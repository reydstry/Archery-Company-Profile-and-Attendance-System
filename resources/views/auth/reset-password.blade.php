@extends('layouts.auth')

@section('title', 'Reset Password - FocusOneX Archery')

@section('content')
<section class="relative min-h-screen flex items-center justify-center px-4 overflow-hidden">

    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('asset/img/latarbelakanglogin.jpeg') }}"
             alt="Background"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md">
        <div class="backdrop-blur-sm border border-white/20 rounded-2xl shadow-2xl shadow-black/50 px-10 py-10">

            <h1 class="text-3xl font-bold text-white text-center mb-8">
                Set New Password
            </h1>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-400/30 bg-red-500/10 p-3 text-sm text-red-300">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-8">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <!-- Email -->
                <div>
                    <input type="email"
                           name="email"
                           value="{{ old('email', request()->email) }}"
                           required
                           placeholder="Email address"
                           class="w-full bg-transparent border-0 border-b border-white
                                  text-white placeholder-white text-sm
                                  pb-2 pt-1 focus:outline-none focus:border-white">
                </div>

                <!-- New Password -->
                <div>
                    <input type="password"
                           name="password"
                           required
                           placeholder="New password"
                           class="w-full bg-transparent border-0 border-b border-white
                                  text-white placeholder-white text-sm
                                  pb-2 pt-1 focus:outline-none focus:border-white">
                </div>

                <!-- Confirm Password -->
                <div>
                    <input type="password"
                           name="password_confirmation"
                           required
                           placeholder="Confirm new password"
                           class="w-full bg-transparent border-0 border-b border-white
                                  text-white placeholder-white text-sm
                                  pb-2 pt-1 focus:outline-none focus:border-white">
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-white border border-white/20 hover:bg-white/80
                               rounded-xl py-3 text-sm font-medium text-black
                               transition-all duration-300">
                    Reset Password
                </button>
            </form>

            <!-- Back to Login -->
            <p class="mt-6 text-center text-sm text-white/50">
                Back to
                <a href="{{ route('login') }}"
                   class="text-white font-semibold hover:text-white/80 transition">
                    Login
                </a>
            </p>

        </div>
    </div>

</section>
@endsection
