<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


new #[Title("記事一覧ページ")] #[Layout("layouts.guest")]class extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    public function updateSearch(){
        $this->resetPage();
    }

    public function with(): array {
        return [
            'posts' => Post::with('user')
            ->where('title', 'like', '%'. $this->search .'%')
            ->latest()
            ->paginate(10),
    ];
    }
};
?>

<div class="space-y-4">
    <flux:heading size="lg" level="1">記事一覧ページ</flux:heading>
    <div class="flex justify-between items-center mb-6 gap-4 mt-6">
        <flux:input wire:model.live="search" icon="magnifying-glass" class="w-64" placeholder="タイトルで検索"/>


        @auth
            <flux:button href="{{ route('posts.create') }}" wire:navigate variant="primary">
                新規作成
            </flux:button>
        @endauth
    </div>

    @foreach ($posts as $post)
        <article class="p-4 shadow-lg">
            <a href="{{ route('post.show', $post) }}">
                <flux:text class="mt-4">{{ $post->created_at->format('y/m/d') }}</flux:text>
                <flux:heading size="lg" level="2">{{ $post->title }}</flux:heading>
                <flux:text class="mt-2">{{ Str::limit($post->body, 100) }}</flux:text>
                <flux:text class="mt-4">{{ $post->user->name }}</flux:text>
            </a>
        </article>
    @endforeach

    {{ $posts->links() }}

</div>
