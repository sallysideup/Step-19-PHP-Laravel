<?php

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

new class extends Component
{
    public Post $post;

    #[Validate("required|min:3")]
    public $title = '';

    #[Validate("required")]
    public $body = '';

    public function mount(Post $post){
        if ($post->user_id !== Auth::id()){
            abort(403);
        }

        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
    }

    public function update(){
        $this->validate();

        if ($this->post->user_id !== Auth::id()){
            abort(403);
        }

        $this->post->update([
            'title' => $this->title,
            'body' => $this->body,
        ]);

        session()->flash('status', '記事を更新しました');

        return $this->redirect('/my-posts', navigate: true);
    }

};
?>

<div>
      <flux:heading size="lg" level="1">記事編集ページ</flux:heading>



    <form wire:submit="update" class="space-y-6">
        <flux:input wire:model='title' label="タイトル" placeholder="記事のタイトルを入力" />
        <flux:textarea wire:model='body' label="本文" placeholder="本文を入力" />
        <div class="flex justify-end">
            <flux:button href="{{ route('my-posts') }}" wire:navigate>
                キャンセル
            </flux:button>
            <flux:button type="submit" variant="primary">
                更新する
            </flux:button>
        </div>
    </form>
</div>
