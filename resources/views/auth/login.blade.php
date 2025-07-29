<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>

    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">

                    <div class="auth-logo mb-4">
                        <a href="#"><img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo"></a>
                    </div>

                    <h1 class="auth-title">Log in</h1>
                    <p class="auth-subtitle mb-5">Log in with your email and password.</p>

                    <!-- Laravel session status -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Login form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                placeholder="Email"
                                required
                                autofocus
                            >
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input
                                type="password"
                                name="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                placeholder="Password"
                                required
                            >
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember me -->
                        <div class="form-check form-check-lg d-flex align-items-center mb-4">
                            <input class="form-check-input me-2" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-gray-600" for="remember">
                                Keep me logged in
                            </label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <!-- You can add a background image or some branding here -->
                </div>
            </div>
        </div>

    </div>
</body>

</html>
