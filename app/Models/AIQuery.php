<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIQuery extends Model
{
    use HasFactory;

    protected $table = 'ai_queries';

    protected $fillable = [
        'user_id',
        'ai_conversation_id',
        'type',
        'provider',
        'model',
        'prompt',
        'response',
        'role',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'cost',
        'response_time_ms',
        'status',
        'error_message',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'prompt_tokens' => 'integer',
            'completion_tokens' => 'integer',
            'total_tokens' => 'integer',
            'cost' => 'float',
            'response_time_ms' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AIConversation::class, 'ai_conversation_id');
    }
}
