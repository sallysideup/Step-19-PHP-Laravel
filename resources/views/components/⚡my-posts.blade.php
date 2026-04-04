<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

new class extends Component
{
    use WithPagination;
    #[Url]
    public $search = '';

    public function updateSearch(){
        $this->resetPage();
    }

    public function delete($id){
        $post = Post::find($id);

        if ($post->user_id !==Auth::id()){
            abort(403);
        }

        $post->delete();

        session()->flash('status', '記事を削除しました');
    }

    public function with(): array {
        return [
            'posts' => Post::where('user_id', Auth::id())
            ->where('title', 'like', '%'. $this->search .'%')
            ->latest()
            ->paginate(10),
        ];
    }
};
?>

<div class="max-w-4xl mx-auto p-6 space-y-6">
    <flux:heading size="lg" level="1">自分の記事投稿一覧</flux:heading>

    <div class="flex justify-between items-center mb-6 gap-4">
        {{-- <flux:input wire:model.live="search" icon="magnifying-glass" class="w-64" placeholder="タイトルで検索" /> --}}
        <flux:input wire:model.live="search" icon="magnifying-glass" class="w-64" placeholder="タイトルで検索"/>
        @auth
            <flux:button href="{{ route('posts.create') }}" wire:navigate variant="primary">
                新規作成
            </flux:button>
        @endauth
    </div>

    @foreach ($posts as $post)
        <article class="p-4 shadow-lg">

                <flux:text class="mt-4 mb-2">{{ $post->created_at->format('y/m/d') }}</flux:text>
                <flux:heading size="lg" level="2">{{ $post->title }}</flux:heading>
                <div class="flex items-center gap-2 shrink-0 mt-2">
                    <flux:button
                        href="/posts/{{ $post->id }}/edit"
                        wire:navigate
                        icon="pencil-square"
                        size="sm"
                    >編集</flux:button>

                    <flux:button
                        wire:click="delete({{ $post->id }})"
                        wire:confirm="本当に削除しますか？"
                        variant="danger"
                        icon="trash"
                        size="sm"
                        >削除</flux:button>

                </div>

        </article>
    @endforeach
</div>
