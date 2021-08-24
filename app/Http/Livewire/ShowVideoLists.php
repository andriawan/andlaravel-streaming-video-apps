<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class ShowVideoLists extends Component
{
    public $video;
    public $search_key;
    public $count;
    protected $listeners = ['uploadSuccess'];

    public function mount()
    {
        $this->video = Video::orderBy("created_at", "ASC")->get();
        $this->count = Video::count();
        $this->search_key = "";

    }

    public function searchVideo()
    {
        $this->video = Video::where('name', 'LIKE', "%{$this->search_key}%")->get();
    }

    public function uploadSuccess()
    {
        $this->video = Video::orderBy("created_at", "ASC")->get();
        $this->count = Video::count();
    }

    public function render()
    {
        return view('livewire.show-video-lists', [
            'video' => $this->video,
            'search_key' => $this->search_key
        ]);
    }
}
