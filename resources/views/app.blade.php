<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'NCT - Crawler')</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="/css/styles.css" rel="stylesheet">
</head>

<body class="bg-light">
<header>
    @include('partials.menu')
</header>

<!-- Begin page content -->
<main role="main" class="container">
    @yield('content')
</main>

@include('partials.footer')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

<script>
    // Loading button plugin (removed from BS4)
    (function($) {
        $.fn.button = function(action) {
            if (action === 'loading' && this.data('loading-text')) {
                this.data('original-text', this.html()).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ` + this.data('loading-text')).prop('disabled', true);
            }
            if (action === 'reset' && this.data('original-text')) {
                this.html(this.data('original-text')).prop('disabled', false);
            }
        };
    }(jQuery));
</script>

@stack('scripts')

</body>
</html>
