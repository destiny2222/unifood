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
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="wsus__login_area">
                            <h2>Confirm password</h2>
                            <p>This is a secure area. Please confirm your password before continuing.</p>
                            <form method="POST" action="{{ route('password.confirm') }}" class="mt-4 login-form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 mb-4">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <div class="position-relative" id="Password-toggle">
                                            <input type="password"  name="password" required autocomplete="current-password" autofocus>
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
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">Confirm</button>
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

