@extends('layouts.main')
@section('title', 'Forget Password')
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
                @if(Session::has('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    </div>
                @endif
    
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif 
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        @if(Session::has('message'))
                            <div class="alert alert-danger alert-dismissible fade" role="alert">
                                {{ Session::get('message') }}
                            </div>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade " role="alert">
                                {{ session('status') }}
                            </div>
                        @endif 
                        <div class="wsus__login_area">
                            <h2>Forget Password</h2>
                            <p>Did you forget your password ? please submit the form below and get the reset password link</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Email</label>
                                            <input type="email"  name ="email" value="{{ old('email') }}" id="email" placeholder="name@example.com" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">Send Reset Link</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="create_account">Back to login page <a href="/login">Login page</a>
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