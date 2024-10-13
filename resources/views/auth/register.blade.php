{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
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
                <div class="col-md-5">
                    <div class="banner-text ">
                        <!-- Registration Form Box -->
                        <div class="card p-5 " style="border-radius: 15px;"> <!-- Card for the form -->
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                
                                <!-- Name -->
                                <div class="form-group">
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="form-control mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                
                                <!-- Email Address -->
                                <div class="form-group mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
            
                
                                <div class="flex items-center justify-end mt-4">
                                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>
                
                                    <button type="submit" class="btn btn-log wow animated fadeInRight">
                                        {{ __('Register') }}
                                    </button>
                                    
                                    @include('components.google-signin', ['buttonText' => 'Register with Google'])
                                  
                                </div>
                            </form>
                        </div> <!-- /.card -->
                    </div> <!-- /.banner-text -->
                </div> <!-- /.col-md-4 -->
                
                
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
    