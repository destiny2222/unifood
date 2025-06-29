@extends('layouts.main')
@section('content')
    <!--=============================
            BREADCRUMB START
        ==============================-->
    <section class="wsus__breadcrumb"
        style="background: url({{ asset('images/breadcrumb_image.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>Register</h1>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="#">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
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
                            <h2>Registration</h2>
                            <p>Do not have an account ? please fill up the form below</p>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Name</label>
                                            <input type="text" name="name" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Email</label>
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <div class="input input-group" >
                                            
                                        </div>
                                        <div class="wsus__login_imput input-group" id="Password-toggle">
                                            <label>Password</label>
                                            <input type="password" name="password" placeholder="Password">
                                            <a href="javascript:void(0);" class="" id="Password-toggle-btn">
                                              <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput input-group" id="Password-toggle1"> 
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirmation"
                                                placeholder="Confirm Password">
                                            <a href="javascript:void(0);" class="" id="Password-toggle-btn">
                                              <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="create_account">Already have an account ? <a href="/login">Login here</a>
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
