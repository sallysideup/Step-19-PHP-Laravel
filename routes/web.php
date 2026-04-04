<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'dashboard')->name('dashboard');

    Route::livewire('/posts/create', 'create-post')->name('posts.create');
    Route::livewire('/posts/{post}', 'show-post')->name('post.show');
    Route::livewire('/posts/{post}/edit', 'edit-post')->name('posts.edit');
    Route::livewire('/my-posts', 'my-posts')->name('my-posts');

});

Route::livewire('/posts', 'show-posts')->name('posts.index');


require __DIR__.'/settings.php';
