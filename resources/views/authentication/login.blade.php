@include('authentication.header')

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo">
                        <img src="assets/img/logo.png" alt="img">
                    </div>
                    <div class="login-userheading">
                        <h3>Sign In</h3>
                        <h4>Please login to your account</h4>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-login">
                            <div class="form-addons">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>
                        </div>
                        <div class="form-login">
                            <div class="pass-group">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>
                        </div>
                        <div class="">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>
                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Sign In</button>
                        </div>
                    </form>
                    <div class="signinform text-center">
                        @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="login-img">
                <img src=" {{ asset('assets/img/login.jpg')}}" alt="img">
            </div>
        </div>
    </div>
</div>
@include('authentication.footer')