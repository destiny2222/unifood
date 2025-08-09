@extends('layouts.main')
@section('content')
@section('title', 'Login')
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
                            <h2>Welcome back!</h2>
                            <p>sign in to continue</p>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Email</label>
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput input-group" id="Password-toggle2">
                                            <label>Password</label>
                                            <input type="password" name="password" placeholder="Password">
                                            <a href="javascript:void(0);" class="" id="Password-toggle-btn">
                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput wsus__login_check_area">
                                            <div class="form-check">
                                                <input class="form-check-input" name="remember" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Remeber Me
                                                </label>
                                            </div>
                                            <a href="{{ route('password.request') }}">Forgot Password ?</a>
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="create_account">Do not have an account ? <a href="/register">Create Account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
            SIGNIN END
        ==========================-->

@endsection
