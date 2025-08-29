<x-guest-layout>

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">
                <div>
                    <a href="index" class="d-inline-block auth-logo">
                        <img src="{{ Vite::asset('resources/images/logo-light.png') }}" alt="" height="20">
                    </a>
                </div>
                <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="mb-4">
                        <div class="avatar-lg mx-auto">
                            <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                <i class="ri-mail-line"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-2 mt-4">
                        <div class="text-muted text-center mb-4 mx-lg-3">
                            <h4 class="">Verify Your Email</h4>
                            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                        </div>

                        <div class="mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-success text-center">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="mt-4 text-center">
                    <p class="mb-0">Didn't receive an email ?
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="fw-semibold text-primary text-decoration-underline">Resend</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
    <!-- end row -->
</x-guest-layout>
