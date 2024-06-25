<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/highlightjs/styles/atom-one-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xmodern.min.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/fonts/fontawesome/fa-brands-400.ttf') }}">
    @yield('extra-css')
</head>
