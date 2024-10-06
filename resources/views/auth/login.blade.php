{{-- 
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}



@extends('Backend.backend/auth.app')
@section('main-content') 


    <section id="header" class="header">
        <div class="top-bar">
            <div class="container">
                <div class="navigation" id="navigation-scroll">
                        <div class="row">
                            <div class="col-md-11 col-xs-10">
                                <a href="/">
                                    <img src="../assets/img/logo_1.png" alt="MediKeep Logo" style="width: 80px; height: auto; margin-right: 10px;">
                                    <span id="logo"><strong class="strong">M</strong>edi<strong class="strong">K</strong>eep</span>
                                </a>
                            </div>
                            
                        </div><!-- /.row -->
                    </div><!-- /.navigation -->
                </div><!--/.container-->
            </div><!--/.top-bar-->

        <div class="container">
            <div class="starting">
                <div class="row">
                    <div class="col-md-6">
                        <img src="welcome/invM.png" alt="LUCY" class="wow flipInY animated animated" style="width:70%; margin-top:50px; margin-left:50px; ">
                    </div>
                    <div class="col-md-4">
                        <div class="banner-text">
                            <!-- Session Status -->
                            <div class="card p-5 " style="border-radius: 15px;">
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                        
                                <form method="POST" action="{{ route('login') }}" class="login-form">
                                    @csrf
                        
                                    <!-- Email Address -->
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <input id="email" type="email" class="form-control" name="email" :value="old('email')" required autofocus autocomplete="username">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                        
                                    <!-- Password -->
                                    <div class="form-group mt-4">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                        
                                    <!-- Remember Me -->
                                    <div class="form-check mt-4">
                                        <input id="remember_me" type="checkbox" class="form-input" name="remember">
                                        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                                    </div>
                        
                                    <!-- Forgot Password & Login Button -->
                                    <div class="d-flex justify-content-between mt-4">
                                        @if (Route::has('password.request'))
                                            <a class="text-sm text-decoration-underline" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                        
                                        <button type="submit" class="btn btn-log wow animated fadeInRight">
                                            {{ __('Log in') }}
                                        </button>
                                    </div>
                                </form>
                            </div> 
                        </div> <!-- /.banner-text -->
                    </div>
                    
                </div>
            </div>
            <!-- /.starting -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /#header -->

    @endsection
    @push('custom-scripts')
    @endpush
    