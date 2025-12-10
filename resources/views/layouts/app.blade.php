<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'JumlaHub') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoE3zM6Q4RO6NK5R8I1F8z0JKTb13kfjr0JpNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <strong>حدثت بعض الأخطاء:</strong>
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
