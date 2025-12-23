@if (session('success') || session('error') || $errors->any())
    <div id="tosit" class="fixed p-3 top-7 right-7 z-[9999] flex flex-col gap-4 max-w-sm">

        @if (session('success'))
            <div
                class="group relative overflow-hidden rounded-xl shadow-xl border border-green-100 bg-gradient-to-r from-green-50 to-green-100 p-4 text-green-900 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">

                <button onclick="this.parentElement.parentElement.style.display='none'"
                    class="absolute left-2 top-2 text-green-400 hover:text-green-600 transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-green-200 ring-2 ring-green-300">
                        <svg class="h-5 w-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                    </div>


                    <div class="flex-1">
                        <h4 class="font-bold text-lg tracking-tight">{{ __('components.toast.success') }}</h4>
                        <p class="mt-1 text-green-700 leading-relaxed">{{ session('success') }}</p>
                    </div>
                </div>


                <div class="absolute bottom-0 left-0 h-1 w-full bg-green-200">
                    <div class="h-full bg-green-500 animate-progress"></div>
                </div>
            </div>
        @endif


        @if (session('error'))
            <div
                class="group relative overflow-hidden rounded-xl shadow-xl border border-red-100 bg-gradient-to-r from-red-50 to-red-100 p-4 text-red-900 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">

                <button onclick="this.parentElement.parentElement.style.display='none'"
                    class="absolute left-2 top-2 text-red-400 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-red-200 ring-2 ring-red-300">
                        <svg class="h-5 w-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                        </svg>
                    </div>


                    <div class="flex-1">
                        <h4 class="font-bold text-lg tracking-tight">{{ __('components.toast.error') }}</h4>
                        <p class="mt-1 text-red-700 leading-relaxed">{{ session('error') }}</p>
                    </div>
                </div>


                <div class="absolute bottom-0 left-0 h-1 w-full bg-red-200">
                    <div class="h-full bg-red-500 animate-progress"></div>
                </div>
            </div>
        @endif


        @if ($errors->any())
            <div
                class="group relative overflow-hidden rounded-xl shadow-xl border border-red-100 bg-gradient-to-r from-red-50 to-red-100 p-4 text-red-900 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">

                <button onclick="this.parentElement.parentElement.style.display='none'"
                    class="absolute left-2 top-2 text-red-400 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex items-start gap-3">
                    
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-red-200 ring-2 ring-red-300">
                        <svg class="h-5 w-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <h4 class="font-bold text-lg tracking-tight">{{ __('components.toast.input_errors') }}</h4>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start gap-2 text-red-700">
                                    <svg class="h-4 w-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="leading-relaxed">{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-full bg-red-200">
                    <div class="h-full bg-red-500 animate-progress"></div>
                </div>
            </div>
        @endif

    </div>

    <style>
        @keyframes progress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .animate-progress {
            animation: progress 5s linear forwards;
        }
    </style>
@endif
