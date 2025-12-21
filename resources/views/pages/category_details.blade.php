@extends('layouts.site')

@section('title', 'JumlaHub | ' . ($category->name ?? 'تفاصيل الفئة'))

@section('content')

    <main class="min-h-screen  from-slate-50 to-white">

        {{-- ================= CATEGORY HERO ================= --}}
        <section class="container orders-page mx-auto px-4 pt-10">
            <div
                class="relative overflow-hidden rounded-3xl bg-white shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-slate-100">

                {{-- background decoration --}}
                <div class="absolute inset-0 bg-gradient-to-l from-teal-50/40 to-transparent"></div>

                <div class="relative flex p-4 flex-col md:flex-row items-center gap-6 p-8 md:p-12" style="padding: 15px">

                    {{-- Icon --}}
                    <div
                        class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-teal-50 ring-1 ring-teal-100">
                        <img src="{{ $category->image ?? asset('images/iconsCategory.png') }}" alt="{{ $category->name }}"
                            class="h-14 w-14 object-contain">
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 text-right">
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                            {{ $category->name }}
                        </h1>

                        @if (!empty($category->description))
                            <p class="mt-3 max-w-3xl text-slate-600 leading-relaxed">
                                {{ $category->description }}
                            </p>
                        @endif

                        {{-- Meta --}}
                        <div class="mt-5 flex flex-wrap items-center gap-3 justify-end">
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-teal-50 px-8 py-2 text-sm font-medium text-teal-700 ring-1 ring-teal-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4" />
                                </svg>
                                {{ $products->count() }} منتج
                            </span>

                            <a href="{{ url('/orders') }}"
                                class="inline-flex items-center gap-2  rounded-full bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                                <i class="fas fa-receipt"></i>
                                إدارة طلباتي
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ================= PRODUCTS SECTION ================= --}}
        <section class="container mx-auto px-4 py-14">

            {{-- section header --}}
            <div class="mb-10 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">

                <div class="text-right">
                    <span class="text-sm font-semibold text-teal-600">
                        عروض مختارة
                    </span>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">
                        منتجات جاهزة للطلب بالجملة
                    </h2>
                    <p class="mt-2 max-w-xl text-slate-600">
                        اختيارات تم فحصها لضمان الجودة وسهولة الشحن إلى متجرك.
                    </p>
                </div>

            </div>
            <br>
            {{-- products grid --}}
            @if ($products->count())
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">

                    @foreach ($products as $product)
                        <div class="group relative  ">

                            {{-- product card --}}
                            <x-product :product="$product" />

                            {{-- order modal --}}
                            <x-create-order :product="$product" :paymentProviders="$paymentProviders" />
                        </div>
                    @endforeach

                </div>
            @else
                {{-- empty state --}}
                <div
                    class="flex flex-col items-center justify-center rounded-3xl border border-dashed border-slate-200 bg-slate-50 py-20 text-center">
                    <img src="{{ asset('images/empty-box.png') }}" class="h-24 w-24 opacity-60" alt="">
                    <h3 class="mt-6 text-lg font-semibold text-slate-800">
                        لا توجد منتجات حالياً
                    </h3>
                    <p class="mt-2 text-slate-500">
                        سيتم إضافة منتجات لهذه الفئة قريباً
                    </p>
                </div>
            @endif

        </section>

    </main>

@endsection
