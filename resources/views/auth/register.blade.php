<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to left, white 50%, rgb(58, 124, 165) 50%);
            background-size: cover;
            background-position: center;
        }
        .h-custom {
            margin-top: 80px;
        }
        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('monairsu/public/img/logo-kpspams.png') }}"
                        class="img-fluid" alt="Sample image" style="margin-left: -60px">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="form-container">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="form-outline mb-4">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="form-control form-control-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
                            </div>

                            <!-- Email Address -->
                            <div class="form-outline mb-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="form-control form-control-lg" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            </div>

                            <!-- Password -->
                            <div class="form-outline mb-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="form-control form-control-lg" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-outline mb-4">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" class="form-control form-control-lg" type="password" name="password_confirmation" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a class="text-body" href="{{ route('login') }}">{{ __('Already registered?') }}</a>

                                <x-primary-button class="btn btn-primary btn-lg ms-3">
                                    {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
