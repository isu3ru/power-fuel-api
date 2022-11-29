@extends('layouts.auth')

@section('title') Login @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="card-body"> 
                    <div class="p-2">
                        <h3 class="text-primary">{{ config('system.title') }}</h3>
                        <p>Welcome Back! Please log in to continue.</p>
                    </div>
                    <div class="p-2">
                        <form class="form-horizontal" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                placeholder="Enter email address" autofocus value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Enter password" required>
                                    <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-check" name="remember" value="1">
                                <label class="form-check-label" for="remember-check">
                                    Remember me
                                </label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('password.request') }}" class="text-muted">
                                    <i class="mdi mdi-lock me-1"></i> Forgot your password?
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <div>
                    <p>&copy; Copyrights Reserved {{ date('Y') }} - {{ config('system.developer.company') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection