@extends('app')

@section('content')
    <h1 class="mt-5">Your playlists</h1>

    <p class="lead"></p>
    <div class="row">
        @foreach ($playlists as $playlist)
            <div class="col-md-3">
                <a href="/playlists/{{ $playlist->slug }}">
                    <img src="{{ $playlist->image_path }}" alt="{{$playlist->name}}" class="img-thumbnail">
                </a>

                <a href="/playlists/{{ $playlist->slug }}">
                    <h5 class="">{{ $playlist->name }}</h5>
                    <p class="text-muted">{{ $playlist->artists }}</p>
                </a>
            </div>
        @endforeach
    </div>
@endsection
