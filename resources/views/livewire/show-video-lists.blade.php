<div class="mb-4">
    <div class="container">
        <p>Total video: {{ $count }}</p>
        <div class="input-group mb-3">
            <input wire:model.debounce.800ms="search_key" wire:input="searchVideo" type="text" class="form-control"
                   placeholder="Search Video">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">Search</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card-columns">
            @foreach($video as $item)
                <div class="card">
                    <div class="bg-secondary relative" style="height: 250px">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="32" height="32" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17 10.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-3.5l4 4v-11l-4 4z" fill="currentColor"></path></svg>
                        <div class="absolute">
                            <video width="100%" controls>
                                <source src="{{ url("api/stream/{$item->uid}") }}" type="video/mp4">
                                <source src="{{ url("api/stream/{$item->uid}") }}" type="video/webm">
                                <p>Your browser doesn't support HTML5 video. Here is
                                    a <a href="myVideo.mp4">link to the video</a> instead.</p>
                            </video>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">Uploaded Date: {{ $item->created_at->timezone('Asia/Jakarta')->format("d-m-Y H:i:s") }}</p>
                        <a href="#" class="btn btn-primary">Stream Video</a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
