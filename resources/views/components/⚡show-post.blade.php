<?php

use Livewire\Component;
use App\Models\Post;

new class extends Component
{
    public Post $post;

    public function mount(Post $post){
        $this->post = $post;
    }


};
?>

<div class="max-w-3xl mx-auto p-6">
    <div class="mb-6">
        <flux:button href="{{ route('posts.index') }}" wire:navigate variant="subtle">
            一覧に戻る
        </flux:button>
        <div class="mb-8 border-b border-zinc-200 pb-6 dark:border-zinc-700">
            <flux:heading size="lg" level="1">{{ $post->title }}</flux:heading>
            <div class="flex items-center text-sm text-gray-500 gap-4 mb-2">
                <div class="flex items-center gap-1">
                    <flux:icon.user class="w-4 h-4"/>
                    <span>{{ $post->user->name }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <flux:icon.calendar class="w-4 h-4" />
                    <span>{{ $post->created_at->format('Y/m/d') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div>{!! nl2br(e($post->body)) !!}</div>
</div>
