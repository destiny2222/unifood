@extends('layouts.main')
@section('title', 'Reset Password')
@section('content')

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
                        @if (Session::has('message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="wsus__login_area">
                            <h2>Create new password</h2>
                            <form method="POST" action="{{ route('password.update') }}" class="mt-4 login-form">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <label>Your Email <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="email"  name="email" value="{{ request()->email ?? old('email') }}" placeholder="name@example.com" required>
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12 mb-4">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <div class="position-relative" id="Password-toggle">
                                            <input type="password"   name="password" id="password" placeholder="Enter Password" required>
                                            <a href="javascript:void(0);" class="" id="Password-toggle-btn" style="top: 20%;">
                                              <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                        @if ($errors->has('password'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12 mb-4">
                                        <label>Password Confirmation<span class="text-danger">*</span></label>
                                        <div class="position-relative" id="Password-toggle1">
                                            <input type="password" name="password_confirmation" id="password"  placeholder="Enter Password" required>
                                            <a href="javascript:void(0);" class="" id="Password-toggle-btn" style="top: 20%;">
                                              <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!--end col-->
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
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

@endsection