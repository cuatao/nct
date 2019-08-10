@extends('app')

@section('content')
    <h1 class="mt-5">Add media to playlist</h1>

    <p class="lead">Please select your <code>playlist</code> and enter a URL of the page that contains video or media item to get <code>media</code>.</p>
    <div class="card p-4 mb-3 bg-white rounded">

        <form class="needs-validation" novalidate="">
            <div class="mb-3">
                <label for="email">Select Playlist </label>
                <input type="hidden" class="form-control">
                <div>
                    <div id="selectPlaylist">
                        <div></div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="address">URL from <code>nhaccuatui.com</code></label>
                        <input type="text" class="form-control" id="url" placeholder="Ex: https://www.nhaccuatui.com/bai-hat/anh-quen-em-roi-charles-huynh.ImZprWIxr400.html" required="">
                        <div class="invalid-feedback">
                            Please enter url.
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" id="btnGetMedia" type="button"  data-loading-text="Loading...">
                    Get media
                </button>
            </div>
        </form>
    </div>

    <div id="success-alert" style="display: none">
        <div class="alert alert-success alert-dismissible " role="alert">
            <strong>Success!</strong> Media has been crawler.
        </div>

        <div class="d-flex align-items-center p-3 my-3 bg-light rounded shadow-sm">
            <img id="media-image" class="mr-3" src="" alt="" width="140" height="140">
            <div class="lh-100">
                <h4 class="mb-0" id="media-name"></h4>
                <br>Thể loại: <code id="media-type"></code>
                <br>Link download: <code id="media-download-url"></code>
                <br>Link gốc: <code id="media-source-url"></code>
            </div>
        </div>
    </div>

    <div id="error-alert" style="display: none">
        <div class="alert alert-danger alert-dismissible " role="alert">
            <strong>Error!</strong> <span id="error-message"></span>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="js/jquery.ddslick.min.js"></script>

    <script>
        var ddData = {!! json_encode($playlists)  !!}

        $('#selectPlaylist').ddslick({
            data: ddData ,
            width: "100%",
            height: '400px',
            imagePosition: "left",
            selectText: "Select your playlist",
            defaultSelectedIndex: 0
        });

        $("#btnGetMedia").click(function() {
            let form = $('.needs-validation');
            if (form[0].checkValidity() === false) {
                form.addClass('was-validated');
                return false;
            }

            let ddData = $('#selectPlaylist').data('ddslick');

            if (ddData.selectedIndex == -1) {
                $('#error-message').html('Please select your playlist.');
                $('#error-alert').show();
                return false;
            }

            $('#error-alert').hide();
            $('#success-alert').hide();

            $('#btnGetMedia').button('loading');

            $.getJSON("/get-media", {
                "playlist_id" : ddData.selectedData.value,
                "url": $('#url').val()
            }, function(data) {
                if (data.status == 0) {
                    $('#error-message').html(data.error);
                    $('#error-alert').show();
                } else {
                    $('#media-image').attr('src', data.data.image_path);
                    $('#media-name').html(data.data.title);
                    $('#media-type').html(data.data.type);
                    $('#media-download-url').html(data.data.download_url);
                    $('#media-source-url').html(data.data.source_url);
                    $('#success-alert').show();
                }
            })
                .fail(function() {
                    $('#error-message').html('Please try again.');
                    $('#error-alert').show();
                })
                .always(function() {
                    $('#result').show();

                    $('#btnGetMedia').button('reset');
                });
        });
    </script>
@endpush
