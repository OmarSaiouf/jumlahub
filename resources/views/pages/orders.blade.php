@extends('layouts.site')


@section('title', 'JumlaHub | منصة الجملة الذكية للتجار والموردين')

@section('content')

    <!-- Main Content -->
    <main class="container orders-page">
        <div class="section-head">
            <h1 class="section-title"><i class="fas fa-receipt"></i> الطلبيات</h1>
            <span class="muted">آخر التحركات على طلباتك بالجملة</span>
        </div>

        @foreach ($orders->get() as $item)
            @if ($item->id)
                <x-order :order="$item"></x-order>
            @else
                <p>No order found.</p>
            @endif
        @endforeach

    </main>



@endsection
