<div class="h-[calc(100vh-8rem)]">
    <x-theme.agri-page-header
        title="AI Assistant"
        description="Get farming advice powered by AI"
    >
        <x-slot:actions>
            <x-theme.agri-button wire:click="newConversation" variant="outline">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Chat
            </x-theme.agri-button>
        </x-slot:actions>
    </x-theme.agri-page-header>

    <div class="flex gap-6 h-[calc(100%-5rem)]">
        <!-- Conversation History Sidebar -->
        <div class="hidden lg:block w-72 shrink-0">
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 h-full overflow-hidden">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-4">Recent Conversations</h3>
                <div class="space-y-2 overflow-y-auto max-h-[calc(100%-2rem)]">
                    @forelse($conversations as $convo)
                        <div class="flex items-start gap-2 p-2 rounded-xl {{ $conversationId === $convo->id ? 'bg-agri-lime/20 border border-agri-lime' : 'bg-agri-bg dark:bg-zinc-900' }}">
                            <button
                                wire:click="$set('conversationId', {{ $convo->id }})"
                                wire:click.debounce="loadConversation"
                                class="flex-1 text-left p-1 rounded-lg transition-colors hover:bg-agri-bg-alt dark:hover:bg-zinc-800"
                            >
                                <p class="text-sm font-medium text-zinc-800 dark:text-white truncate">
                                    {{ $convo->title }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $convo->last_message_at?->diffForHumans() ?? 'No messages' }}
                                </p>
                            </button>
                            <button
                                type="button"
                                wire:click="deleteConversation({{ $convo->id }})"
                                wire:confirm="Delete this chat permanently?"
                                class="mt-1 p-1.5 rounded-md text-zinc-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-zinc-800"
                                title="Delete chat"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No conversations yet</p>
                    @endforelse
                </div>
            </x-theme.agri-card>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <x-theme.agri-card variant="white" class="border border-zinc-200 dark:border-zinc-700 flex-1 flex flex-col overflow-hidden">
                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                    @if(count($messages) === 0)
                        <div class="flex flex-col items-center justify-center h-full text-center">
                            <div class="w-20 h-20 bg-agri-bg dark:bg-zinc-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-agri-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-zinc-800 dark:text-white mb-2">How can I help you today?</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-md">
                                Ask me anything about farming, crops, pests, weather, or get recommendations for your farm.
                            </p>
                            <div class="mt-6 flex flex-wrap gap-2 justify-center">
                                <button
                                    wire:click="$set('message', 'What crops are best for the current season?')"
                                    class="px-4 py-2 bg-agri-bg dark:bg-zinc-700 rounded-full text-sm text-zinc-700 dark:text-zinc-300 hover:bg-agri-lime/20 transition-colors"
                                >
                                    Best crops for this season?
                                </button>
                                <button
                                    wire:click="$set('message', 'How do I improve my soil quality?')"
                                    class="px-4 py-2 bg-agri-bg dark:bg-zinc-700 rounded-full text-sm text-zinc-700 dark:text-zinc-300 hover:bg-agri-lime/20 transition-colors"
                                >
                                    Improve soil quality
                                </button>
                                <button
                                    wire:click="$set('message', 'Tips for organic farming')"
                                    class="px-4 py-2 bg-agri-bg dark:bg-zinc-700 rounded-full text-sm text-zinc-700 dark:text-zinc-300 hover:bg-agri-lime/20 transition-colors"
                                >
                                    Organic farming tips
                                </button>
                            </div>
                        </div>
                    @else
                        @foreach($messages as $msg)
                            <div wire:key="msg-{{ $msg['id'] }}" class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] {{ $msg['role'] === 'user' ? 'order-2' : 'order-1' }}">
                                    @if($msg['role'] === 'assistant')
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-agri-lime rounded-full flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-zinc-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="bg-agri-bg dark:bg-zinc-700 rounded-2xl rounded-tl-sm px-4 py-3">
                                                @if($msg['status'] === 'processing')
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex gap-1">
                                                            <div class="w-2 h-2 bg-agri-olive rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                                            <div class="w-2 h-2 bg-agri-olive rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                                            <div class="w-2 h-2 bg-agri-olive rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                                                        </div>
                                                        <span class="text-sm text-zinc-500">Thinking...</span>
                                                    </div>
                                                @elseif(!empty($msg['content']))
                                                    <div class="prose prose-sm dark:prose-invert max-w-none markdown-content" data-markdown="{{ base64_encode($msg['content']) }}">
                                                        {{-- Fallback content while JS loads --}}
                                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{!! nl2br(e($msg['content'])) !!}</p>
                                                    </div>
                                                @else
                                                    <p class="text-sm text-zinc-500 italic">No response received</p>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-agri-lime/20 dark:bg-agri-lime/10 rounded-2xl rounded-tr-sm px-4 py-3">
                                            <p class="text-sm text-zinc-800 dark:text-zinc-200">{{ $msg['content'] }}</p>
                                        </div>
                                    @endif
                                    <p class="text-xs text-zinc-400 mt-1 {{ $msg['role'] === 'user' ? 'text-right' : 'text-left ml-11' }}">
                                        {{ $msg['created_at'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Input Area -->
                <div class="border-t border-zinc-200 dark:border-zinc-700 p-4">
                    <form wire:submit="sendMessage" class="flex gap-3">
                        <div class="flex-1 relative">
                            <textarea
                                wire:model="message"
                                placeholder="Ask me anything about farming..."
                                rows="1"
                                class="w-full px-4 py-3 bg-agri-bg dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl text-sm text-zinc-800 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-agri-lime resize-none"
                                @keydown.enter.prevent="if(!event.shiftKey) $wire.sendMessage()"
                                {{ $isProcessing ? 'disabled' : '' }}
                            ></textarea>
                        </div>
                        <button
                            type="submit"
                            class="px-4 py-3 bg-agri-lime text-zinc-800 rounded-xl hover:bg-agri-lime-light transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $isProcessing ? 'disabled' : '' }}
                        >
                            @if($isProcessing)
                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            @endif
                        </button>
                    </form>
                    <p class="text-xs text-zinc-400 mt-2 text-center">AI responses may not always be accurate. Verify important advice with local experts.</p>
                </div>
            </x-theme.agri-card>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.6/dist/purify.min.js"></script>
<script>
    let userIsScrolling = false;
    let lastMessageCount = 0;

    function renderAllMarkdown() {
        document.querySelectorAll('.markdown-content').forEach(el => {
            try {
                const encoded = el.dataset.markdown || '';
                if (encoded && !el.dataset.rendered) {
                    const md = atob(encoded);
                    if (md && md.trim()) {
                        const html = marked.parse(md);
                        el.innerHTML = DOMPurify.sanitize(html);
                        el.dataset.rendered = 'true';
                    }
                }
            } catch (err) {
                console.error('Markdown render error:', err);
            }
        });
    }

    function isNearBottom(container) {
        const threshold = 100;
        return container.scrollHeight - container.scrollTop - container.clientHeight < threshold;
    }

    function scrollToBottomIfNeeded(container, force = false) {
        if (force || (!userIsScrolling && isNearBottom(container))) {
            container.scrollTop = container.scrollHeight;
        }
    }

    // Wait for marked.js to load then render
    function initMarkdown() {
        if (typeof marked !== 'undefined' && typeof DOMPurify !== 'undefined') {
            renderAllMarkdown();
        } else {
            setTimeout(initMarkdown, 100);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMarkdown();

        const chatContainer = document.getElementById('chat-messages');
        if (chatContainer) {
            // Track when user is actively scrolling
            chatContainer.addEventListener('scroll', function() {
                userIsScrolling = !isNearBottom(chatContainer);
            });

            // Initial scroll to bottom
            chatContainer.scrollTop = chatContainer.scrollHeight;
            lastMessageCount = chatContainer.querySelectorAll('[wire\\:key^="msg-"]').length;
        }
    });

    document.addEventListener('livewire:init', () => {
        initMarkdown();

        Livewire.hook('morph.updated', () => {
            const chatContainer = document.getElementById('chat-messages');
            if (chatContainer) {
                const currentMessageCount = chatContainer.querySelectorAll('[wire\\:key^="msg-"]').length;

                // Only scroll to bottom if new messages were added
                if (currentMessageCount > lastMessageCount) {
                    scrollToBottomIfNeeded(chatContainer);
                    lastMessageCount = currentMessageCount;
                }
            }
            // Re-render markdown after Livewire updates
            setTimeout(renderAllMarkdown, 100);
        });
    });
</script>

