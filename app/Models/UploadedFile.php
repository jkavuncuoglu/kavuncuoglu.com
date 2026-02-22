<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class UploadedFile extends Model
{
    protected $fillable = [
        'user_id',
        'original_filename',
        'stored_filename',
        'disk',
        'path',
        'mime_type',
        'file_size',
        'status',
        'error_message',
        'document_count',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'document_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function getFullPath(): string
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    public function getUrl(): ?string
    {
        if ($this->disk === 'public') {
            return Storage::disk($this->disk)->url($this->path);
        }

        return null;
    }

    public function deleteFile(): bool
    {
        if ($this->path) {
            return Storage::disk($this->disk)->delete($this->path);
        }

        return false;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted(int $documentCount): void
    {
        $this->update([
            'status' => 'completed',
            'document_count' => $documentCount,
            'error_message' => null,
        ]);
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }
}
