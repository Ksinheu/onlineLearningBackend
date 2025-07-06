{{-- <x-guest-layout>
    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    
        <h1 class="text-center text-2xl font-bold text-gray-800 dark:text-white mb-6">ចូល</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            
            <div class="mb-4">
                <x-input-label class="text-gray-700 dark:text-gray-200" for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="mt-1 block w-full p-3 bg-gray-1000 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            
            <div class="mb-4">
                <x-input-label class="text-gray-700 dark:text-gray-200" for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="mt-1 block w-full p-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

           
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 dark:bg-gray-800 dark:border-gray-700" name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
                </label>

               
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline dark:text-indigo-400">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

           
            <div>
                <x-primary-button class="w-full justify-center py-2 px-4 text-sm font-semibold rounded-md">
                    {{ __('ចូល') }}
                </x-primary-button>
            </div>
        </form>
   
</x-guest-layout> --}}
@extends('layouts.guest')
@section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content ">
                <div class="login-logo">
                    <a>
                        <img class="align-content" src="{{ asset('images/pcc-logo.png') }}" class="w-50" alt="">
                    </a>
                </div>
                <div class="login-form shadow">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>អ៊ីមែល</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                autofocus>
                        </div>
                        <div class="form-group">
                            <label>លេខសម្ងាត់</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                            <label class="pull-right">
                                <a href="#">Forgotten Password?</a>
                            </label>

                        </div> --}}
                        <button type="submit" class="btn btn-bule btn-flat m-b-30 m-t-30 text-white">ចូល</button>
                        {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        
                        <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="{{route('register')}}"> Sign Up Here</a></p>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
