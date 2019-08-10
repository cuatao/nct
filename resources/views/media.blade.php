@extends('app')

@section('content')
    <div class="d-flex align-items-center p-3 my-3 bg-white rounded shadow-sm">
        <img class="mr-3" src="{{ $playlist->image_path }}" alt="" width="100" height="100">
        <div class="lh-100">
            <h3 class="mb-0">{{ $playlist->name }}</h6>
                <p>{{ $playlist->artists }}</p>
            </h3>
        </div>

    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h6 class="border-bottom border-gray pb-2 mb-0">List media</h6>

        @foreach ($playlist->media as $media)
        <div class="media text-muted pt-3">
            <img class="mr-2" src="{{ $media->image_path }}" width="32">
            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <strong class="text-gray-dark">{{ $media->title }}</strong>
                    <a href="javascript:;" onclick="getDownloadUrl({{ $media->id }})">Download</a>
                </div>
                <span class="d-block">{{ implode(', ', $media->artists->pluck('name')->toArray()) }}</span>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        function getDownloadUrl(mediaId) {
            $.getJSON("/medias/"+mediaId+"/fetch-new-download-url", function(data) {
                if (data.status == 0) {
                    alert(data.error)
                } else {
                    window.location.href = data.url;
                }
            });
        }
    </script>
@endpush
