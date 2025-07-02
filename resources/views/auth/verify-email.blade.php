@extends('layouts.main')
@section('content')
@section('title', 'Email Verification')
    <!--=============================
            BREADCRUMB START
        ==============================-->
        @include('partials.breadcrumb')
    <!--=============================
            BREADCRUMB END
        ==============================-->


<!--=========================
            SIGNIN START
        ==========================-->
    <section class="wsus__signin" style="background: url({{ asset('images/banner.jpg') }});">
        <div class="wsus__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="wsus__login_area">
                            <form method="POST" action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="">
                                            @if (session('status') == 'verification-link-sent')
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                                </div>
                                            @endif
                                            <p>{{ __('To complete your registration, please check your inbox for a verification email and follow the instructions provided.') }}</p>
                                            <p>{{ __('Didn\'t receive the email? You can request another verification link below.') }}</p>
                                            @csrf
                                            <div class="mb-0 col-lg-12">
                                                <button class="common_btn" type="submit">
                                                    {{ __('Resend Verification Email') }}</button>
                                            </div>
                                                <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('logout') }}" class="mt-4 login-form">
                                @csrf
                                <button type="submit" class="common_btn">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
            SIGNIN END
        ==========================-->

<!--end section-->
@endsection