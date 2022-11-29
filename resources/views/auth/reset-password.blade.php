@extends('layouts.auth')

@section('title') Request Password Reset Email @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="card-body"> 
                    <div class="p-2">
                        <h3 class="text-primary">Update Your Password</h3>
                        <p>Enter a new and strong password to update.</p>
                    </div>
                    <div class="p-2">
                        <form class="form-horizontal" action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->token }}">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                                value="{{ $request->email }}" readonly required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Enter new password" autofocus required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password Again</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter password again" 
                                class="form-control @error('password') is-invalid @enderror" autofocus required>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Update Password</button>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-muted">
                                    <i class="mdi mdi-lock me-1"></i> Not you? Log In
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <div>
                    <p>&copy; Copyrights Reserved {{ date('Y') }} - {{ config('system.title') }}</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection