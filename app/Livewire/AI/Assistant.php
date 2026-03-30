<?php

namespace App\Livewire\AI;

use App\Models\AIConversation;
use App\Models\AIQuery;
use App\Services\AI\AgriAIService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('AI Assistant')]
class Assistant extends Component
{
    public string $message = '';

    public ?int $conversationId = null;

    public bool $isProcessing = false;

    public array $messages = [];

    protected AgriAIService $aiService;

    public function boot(AgriAIService $aiService): void
    {
        $this->aiService = $aiService;
    }

    public function mount(?int $conversation = null): void
    {
        if ($conversation) {
            $this->conversationId = $conversation;
            $this->loadConversation();
        }
    }

    public function loadConversation(): void
    {
        if (! $this->conversationId) {
            return;
        }

        $conversation = AIConversation::where('user_id', Auth::id())
            ->with(['queries' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->find($this->conversationId);

        if ($conversation) {
            $this->messages = $conversation->queries->map(function ($query) {
                return [
                    'id' => $query->id,
                    'role' => $query->role,
                    'content' => $query->role === 'user' ? $query->prompt : $query->response,
                    'status' => $query->status,
                    'created_at' => $query->created_at->diffForHumans(),
                ];
            })->toArray();
        }
    }

    public function sendMessage(): void
    {
        $this->validate([
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        $trimmedMessage = trim($this->message);

        // Create or get conversation (pass message for title generation on new conversations)
        $conversation = $this->getOrCreateConversation($trimmedMessage);

        // Add user message to UI immediately
        $this->messages[] = [
            'id' => 'temp-'.time(),
            'role' => 'user',
            'content' => $trimmedMessage,
            'status' => 'completed',
            'created_at' => 'Just now',
        ];

        $chatProvider = config('llm.chat_provider', 'groq');
        $chatModel = (string) config("llm.providers.{$chatProvider}.model", config('llm.providers.groq.model'));

        // Create the query record
        $query = AIQuery::create([
            'user_id' => $user->id,
            'ai_conversation_id' => $conversation->id,
            'type' => 'chat',
            'provider' => $chatProvider,
            'model' => $chatModel,
            'prompt' => $trimmedMessage,
            'role' => 'user',
            'status' => 'pending',
        ]);

        // Clear message input
        $this->message = '';
        $this->isProcessing = true;

        // Add placeholder for AI response
        $this->messages[] = [
            'id' => 'ai-pending-'.$query->id,
            'role' => 'assistant',
            'content' => '',
            'status' => 'processing',
            'created_at' => 'Thinking...',
        ];

        // Process synchronously for immediate feedback
        $this->processMessageSync($conversation, $query, $trimmedMessage);
    }

    protected function processMessageSync(AIConversation $conversation, AIQuery $query, string $message): void
    {
        $result = $this->aiService->chat($message, $conversation, Auth::user());

        if ($result['success']) {
            $query->update([
                'response' => $result['text'],
                'prompt_tokens' => $result['prompt_tokens'],
                'completion_tokens' => $result['completion_tokens'],
                'total_tokens' => $result['total_tokens'],
                'response_time_ms' => $result['response_time_ms'],
                'status' => 'completed',
            ]);

            // Create assistant response
            AIQuery::create([
                'user_id' => Auth::id(),
                'ai_conversation_id' => $conversation->id,
                'type' => 'chat',
                'provider' => $result['provider'],
                'model' => $result['model'],
                'prompt' => $message,
                'response' => $result['text'],
                'role' => 'assistant',
                'status' => 'completed',
            ]);

            // Update messages array
            array_pop($this->messages); // Remove placeholder
            $this->messages[] = [
                'id' => 'ai-'.time(),
                'role' => 'assistant',
                'content' => $result['text'],
                'status' => 'completed',
                'created_at' => 'Just now',
            ];
        } else {
            $query->update([
                'status' => 'failed',
                'error_message' => $result['error'],
            ]);

            // Check for quota exceeded error
            $errorMsg = 'Sorry, I encountered an error. Please try again.';
            if (isset($result['error']) && (str_contains($result['error'], 'quota') || str_contains($result['error'], 'exceeded'))) {
                $errorMsg = 'The AI service is temporarily unavailable due to high demand. Please wait a moment and try again.';
            }

            array_pop($this->messages);
            $this->messages[] = [
                'id' => 'ai-error-'.time(),
                'role' => 'assistant',
                'content' => $errorMsg,
                'status' => 'failed',
                'created_at' => 'Just now',
            ];
        }

        $this->isProcessing = false;
        $conversation->update(['last_message_at' => now()]);
    }

    public function refreshMessages(): void
    {
        $this->loadConversation();
        $this->isProcessing = false;
    }

    protected function getOrCreateConversation(string $firstMessage = ''): AIConversation
    {
        if ($this->conversationId) {
            $conversation = AIConversation::find($this->conversationId);
            if ($conversation && $conversation->user_id === Auth::id()) {
                return $conversation;
            }
        }

        // Generate a meaningful title from the first message
        $title = $this->generateConversationTitle($firstMessage);

        $conversation = AIConversation::create([
            'user_id' => Auth::id(),
            'type' => 'chat',
            'title' => $title,
            'last_message_at' => now(),
        ]);

        $this->conversationId = $conversation->id;

        return $conversation;
    }

    protected function generateConversationTitle(string $message): string
    {
        if (empty($message)) {
            return 'New Conversation';
        }

        // Clean up and truncate the message for use as title
        $title = trim($message);

        // Remove any special characters at the start
        $title = preg_replace('/^[^\w]+/', '', $title);

        // Capitalize first letter
        $title = ucfirst($title);

        // Truncate to reasonable length (40 chars) and add ellipsis if needed
        if (mb_strlen($title) > 40) {
            $title = mb_substr($title, 0, 40).'...';
        }

        return $title ?: 'New Conversation';
    }

    public function newConversation(): void
    {
        $this->conversationId = null;
        $this->messages = [];
        $this->message = '';
        $this->isProcessing = false;
    }

    public function deleteConversation(int $conversationId): void
    {
        $conversation = AIConversation::where('user_id', Auth::id())->find($conversationId);
        if (! $conversation) {
            return;
        }

        AIQuery::where('user_id', Auth::id())
            ->where('ai_conversation_id', $conversation->id)
            ->delete();

        $conversation->delete();

        if ($this->conversationId === $conversation->id) {
            $this->newConversation();
        }
    }

    public function render()
    {
        $conversations = AIConversation::where('user_id', Auth::id())
            ->orderBy('last_message_at', 'desc')
            ->limit(20)
            ->get();

        return view('livewire.ai.assistant', [
            'conversations' => $conversations,
        ]);
    }
}
