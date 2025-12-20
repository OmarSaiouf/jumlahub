<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'JumlaHub') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body>

    @include('layouts.components.header')




    <main class="page">
        @yield('content')
    </main>

    @include('layouts.components.footer')
    <script>
        setTimeout(() => {
            document.querySelectorAll('#tosit').forEach(el => el.remove());
        }, 10000);
    </script>
</body>

</html>
