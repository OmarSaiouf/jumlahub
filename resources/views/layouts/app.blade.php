<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'JumlaHub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body>
    @include('layouts.components.header')

    <main class="page container">
        @if (session('status'))
            <div class="alert">
                <i class="fas fa-circle-check"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert"
                style="border-color: rgba(239,68,68,0.35); background: rgba(239,68,68,0.08); color: #991b1b;">
                <div>
                    <strong>{{ __('layout.errors.heading') }}</strong>
                    <ul style="margin: 8px 16px 0 0; padding: 0; list-style: disc;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.components.footer')
</body>

</html>
