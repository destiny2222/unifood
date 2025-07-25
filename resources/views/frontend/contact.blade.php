@extends('layouts.main')
@section('content')
@section('title', 'Contact Us')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->


<!--=============================
        CONTACT PAGE START
    ==============================-->
<section class="wsus__contact mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info"
                    style="background: url({{ optional($contact)->existing_image ?? '' }});">
                    <span><i class="fa fa-phone-alt"></i></span>
                    <h3>call</h3>
                    <p>{{  optional($contact)->phone ?? '' }}</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info"
                    style="background: url({{ optional($contact)->existing_image ?? '' }});">
                    <span><i class="fa fa-envelope"></i></span>
                    <h3>Email</h3>
                    <p>{{ $contact->email ?? '' }}</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info"
                    style="background: url({{ optional($contact)->existing_image ?? '' }});">
                    <span><i class="fas fa-street-view"></i></span>
                    <h3>Location</h3>
                    <p>{{ $contact->address ?? '' }}</p>
                </div>
            </div>
        </div>
        <div class="wsus__contact_form_area mt_100 xs_mt_70">
            <div class="row">
                <div class="col-xl-7 wow fadeInUp" data-wow-duration="1s">
                    <form class="wsus__contact_form" method="POST"  action="{{ route('frontend.contact.store') }}">
                        @csrf
                        <h3>Feel free to contact us</h3>
                        <div class="row">
                            <div class="col-xl-12 col-lg-6">
                                <div class="wsus__contact_form_input">
                                    <span><i class="fa fa-user-alt"></i></span>
                                    <input type="text" name="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="wsus__contact_form_input">
                                    <span><i class="fa fa-envelope"></i></span>
                                    <input type="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="wsus__contact_form_input">
                                    <span><i class="fa fa-phone-alt"></i></span>
                                    <input type="text" name="phone" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-6">
                                <div class="wsus__contact_form_input">
                                    <span><i class="fa fa-book"></i></span>
                                    <input type="text" placeholder="Subject" name="subject">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="wsus__contact_form_input textarea">
                                    <span><i class="fal fa-book"></i></span>
                                    <textarea rows="5" placeholder="Message" name="message"></textarea>
                                </div>

                            </div>

                            <div class="col-xl-12">
                                <button type="submit">send now</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=============================
        CONTACT PAGE END
    ==============================-->


    <!--=============================
        BRAND START
    ==============================-->
     @include('partials.brand')
    <!--=============================
        BRAND END
    ==============================-->


@endsection
