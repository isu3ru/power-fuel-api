@extends('layouts.auth')

@section('title') Register @endsection

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
                            <form class="needs-validation" novalidate action="{{ route('register') }}" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" required>
                                    <div class="invalid-feedback">
                                        Please enter your name.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter email address"
                                        required>
                                    <div class="invalid-feedback">
                                        Please enter your email address
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter password" required>
                                    <div class="invalid-feedback">
                                        Please enter a password
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                        placeholder="Enter password" required>
                                    <div class="invalid-feedback">
                                        Please enter a password
                                    </div>
                                </div>

                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <h5 class="font-size-14 mb-3">Sign up using</h5>

                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="javascript::void()"
                                                class="social-list-item bg-primary text-white border-primary">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript::void()"
                                                class="social-list-item bg-info text-white border-info">
                                                <i class="mdi mdi-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript::void()"
                                                class="social-list-item bg-danger text-white border-danger">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-4 text-center">
                                    <p class="mb-0">By registering you agree to the Skote <a href="#"
                                            class="text-primary">Terms of Use</a></p>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <div>
                        <p>Already have an account ? <a href="auth-login.html" class="fw-medium text-primary"> Login</a>
                        </p>
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
