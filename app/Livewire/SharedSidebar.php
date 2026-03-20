<?php

namespace App\Livewire;

use Livewire\Component;

class SharedSidebar extends Component
{
    public $category;
    public $currentPostId;
    public function render()
    {
    return view('livewire.shared-sidebar', [
        'relatedPosts' => Post::where('category', $this->category)
            ->where('id', '!=', $this->currentPostId)
            ->limit(5)
            ->get(),
        'activePoll' => Poll::where('is_active', true)->first(),
        'ads' => Ad::where('position', 'sidebar')->inRandomOrder()->limit(2)->get(),
    ]);
    }
}
