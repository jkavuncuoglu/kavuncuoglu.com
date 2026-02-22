<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PublicChatController;
use Illuminate\Support\Facades\Route;

// Public chat routes — locale-prefixed
Route::prefix('{locale}')->where(['locale' => 'en|de|tr|es'])->group(function () {
    Route::get('chat', [PublicChatController::class, 'index'])->name('chat');
    Route::post('chat/message', [PublicChatController::class, 'message'])->name('chat.message');
});

// Authenticated chat routes (for conversation history - kept for future use)
Route::middleware(['auth', 'verified'])->prefix('app')->group(function () {
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('chat/conversations', [ChatController::class, 'store'])->name('chat.store');
    Route::get('chat/conversations/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/conversations/{conversation}/message', [ChatController::class, 'message'])->name('chat.conversations.message');
    Route::delete('chat/conversations/{conversation}', [ChatController::class, 'destroy'])->name('chat.destroy');
});
