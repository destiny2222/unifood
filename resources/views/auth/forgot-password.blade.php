@extends('layouts.main')
@section('content')

<!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url(public/uploads/website-images/breadcrumb_image-2022-12-31-01-18-17-5423.jpg);">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>Forget Password</h1>
                    <ul>
                        <li><a href="index.htm">Home</a></li>
                        <li><a href="forget-password.html">Forget Password</a></li>
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
    <section class="wsus__signin" style="background: url(public/uploads/website-images/banner-2023-02-23-03-56-18-6177.jpg);">
        <div class="wsus__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="wsus__login_area">
                            <h2>Forget Password</h2>
                            <p>Did you forget your password ? please submit the form below and get the reset password link</p>
                            <form method="POST" action="https://unifood.websolutionus.com/send-forget-password">
                                <input type="hidden" name="_token" value="bEl0FV3NGFotgbZzLm70xYzARsANzVbxSb6MiMoq" autocomplete="off">                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>Email</label>
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                    </div>

                                    
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">Send Reset Link</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="create_account">Back to login page <a href="login.html">Login page</a>
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