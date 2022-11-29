@extends('layouts.auth')

@section('title') Request Password Reset Email @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="card-body pt-0">
                    <div class="p-2 mt-3">
                        <h3 class="text-primary">Request Password Reset</h3>
                        <p>Enter your email address to receive an email with a link to reset the password.</p>
                    </div>
                    <div class="p-2 pt-0">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" action="{{ route('password.email') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" name="email" placeholder="Enter email address" value="{{ old('email') }}" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Send me the email</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <p>Remember It ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Log In here</a> </p>
                <p>&copy; Copyrights Reserved {{ date('Y') }} - {{ config('system.title') }}</p>
            </div>

        </div>
    </div>
</div>
@endsection