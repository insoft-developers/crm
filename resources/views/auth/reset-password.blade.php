{{-- <x-guest-layout> --}}
{{--    <x-auth-card> --}}
{{--        <x-slot name="logo"> --}}
{{--            <a href="/"> --}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
{{--            </a> --}}
{{--        </x-slot> --}}

{{--        <!-- Validation Errors --> --}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

{{--        <form method="POST" action="{{ route('password.update') }}"> --}}
{{--            @csrf --}}

{{--            <!-- Password Reset Token --> --}}
{{--            <input type="hidden" name="token" value="{{ $request->route('token') }}"> --}}

{{--            <!-- Email Address --> --}}
{{--            <div> --}}
{{--                <x-label for="email" :value="__('Email')" /> --}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus /> --}}
{{--            </div> --}}

{{--            <!-- Password --> --}}
{{--            <div class="mt-4"> --}}
{{--                <x-label for="password" :value="__('Password')" /> --}}

{{--                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required /> --}}
{{--            </div> --}}

{{--            <!-- Confirm Password --> --}}
{{--            <div class="mt-4"> --}}
{{--                <x-label for="password_confirmation" :value="__('Confirm Password')" /> --}}

{{--                <x-input id="password_confirmation" class="block mt-1 w-full" --}}
{{--                                    type="password" --}}
{{--                                    name="password_confirmation" required /> --}}
{{--            </div> --}}

{{--            <div class="flex items-center justify-end mt-4"> --}}
{{--                <x-button> --}}
{{--                    {{ __('Reset Password') }} --}}
{{--                </x-button> --}}
{{--            </div> --}}
{{--        </form> --}}
{{--    </x-auth-card> --}}
{{-- </x-guest-layout> --}}
<x-guest-layout>
    <section class="login-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="auth-logo">
                                <img src="{{ asset('images/logo.png') }}" class="img-fluid rounded-normal" alt="logo">
                            </div>
                            <h2 class="mb-2 text-center">Reset Password</h2>
                            <p>Enter your email address and we'll send you an email with instructions to reset your
                                password.</p>
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <!-- Hidden Token -->
                                <input type="hidden" name="token" value="{{ $token }}">

                                <!-- Email Address -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', $email) }}" required autofocus>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input class="form-control" type="password" name="password" required>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input class="form-control" type="password" name="password_confirmation" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Reset Password') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
