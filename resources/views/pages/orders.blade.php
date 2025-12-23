@extends('layouts.site')


@section('title', __('pages.orders.title'))

@section('content')

    <!-- Main Content -->
    <main class="container orders-page">
        <div class="section-head">
            <h1 class="section-title"><i class="fas fa-receipt"></i> {{ __('pages.orders.title') }}</h1>
            <span class="muted">{{ __('pages.orders.muted') }}</span>
        </div>

        @foreach ($orders->get() as $item)
            @if ($item->id)
                <x-order :order="$item"></x-order>
            @else
                <p>{{ __('pages.orders.no_orders') }}</p>
            @endif
        @endforeach

    </main>



@endsection
