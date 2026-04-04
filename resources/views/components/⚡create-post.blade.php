<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

new #[Title("記事作成ページ")]class extends Component
{
    #[Validate("required", message: "タイトルは必須です")]
    #[Validate("min:3", message: "タイトルは３文字以上入力して下さい")]
    public $title = '';

    #[Validate("required", message: "本文は必須です")]
    public $body = '';

    public function save() {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => Auth::id(),
        ]);

        $this->reset(['title', 'body']);
        session()->flash('status', '記事を投稿しました');

        return $this->redirect('/posts');
    }
};
?>


<div class="max-w-2xl mx-auto p-6">
    <flux:heading size="lg" level="1">記事作成ページ</flux:heading>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <flux:input wire:model='title' label="タイトル" placeholder="記事のタイトルを入力" />
        <flux:textarea wire:model='body' label="本文" placeholder="本文を入力" />
        <div class="flex justify-end">
            <flux:button type="submit" variant="primary" class="bg-green-600 text-green-800">
                投稿する
            </flux:button>
        </div>
    </form>

</div>
