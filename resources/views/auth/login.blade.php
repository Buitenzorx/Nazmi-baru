<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body>
    <section class="vh-200">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-2 col-xl-4">
                    <img src="{{ asset('monairsu/public/img/logo-kpspams.png') }}"
                        class="img-fluid" alt="Sample image" style="margin-left: -60px">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-outline mb-4">
                            <input id="email" type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Enter a valid email address">
                            
                            @error('email')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-outline mb-3">
                            <input id="password" type="password" name="password" class="form-control form-control-lg" required autocomplete="current-password" placeholder="Enter password">
                    
                            @error('password')
                                <div class="mt-2 text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">Remember me</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-body" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Log in</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? 
                                <a href="{{ route('register') }}" class="link-danger">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
