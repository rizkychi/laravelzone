@section('page', 'register')

<x-guest-layout>
    
    <x-login-title />

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Create New Account</h5>
                        <p class="text-muted">Get your free velzon account now</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form class="needs-validation" novalidate method="POST"
                            action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" id="useremail"
                                    placeholder="Enter email address" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="invalid-feedback">
                                    Please enter email
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" id="username"
                                    placeholder="Enter username" required>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="invalid-feedback">
                                    Please enter username
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fname" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fname') is-invalid @enderror"
                                    name="fname" value="{{ old('fname') }}" id="fname"
                                    placeholder="Enter full name" required>
                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="invalid-feedback">
                                    Please enter full name
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="userpassword" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    id="userpassword" placeholder="Enter password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="invalid-feedback">
                                    Please enter password
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="input-password">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" id="input-password"
                                    placeholder="Enter Confirm Password" required>
                                <div class="invalid-feedback">
                                    Passwords do not match
                                </div>
                                <div class="form-floating-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="input-avatar">Avatar <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                    name="avatar" id="input-avatar" required>
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="">
                                    <i data-feather="file"></i>
                                </div>
                            </div> --}}

                            {{-- <div class="mb-3">
                                <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                    Velzon <a href="#"
                                        class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                        of Use</a></p>
                            </div> --}}

                            <div class="mt-3">
                                <button class="btn btn-success w-100" type="submit">Sign Up</button>
                            </div>

                            {{-- <div class="mt-3 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                </div>

                                <div>
                                    <button type="button"
                                        class="btn btn-primary btn-icon waves-effect waves-light"><i
                                            class="ri-facebook-fill fs-16"></i></button>
                                    <button type="button"
                                        class="btn btn-danger btn-icon waves-effect waves-light"><i
                                            class="ri-google-fill fs-16"></i></button>
                                    <button type="button"
                                        class="btn btn-dark btn-icon waves-effect waves-light"><i
                                            class="ri-github-fill fs-16"></i></button>
                                    <button type="button"
                                        class="btn btn-info btn-icon waves-effect waves-light"><i
                                            class="ri-twitter-fill fs-16"></i></button>
                                </div>
                            </div> --}}
                        </form>

                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Already have an account ? <a href="{{ route('login') }}"
                        class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->

</x-guest-layout>
