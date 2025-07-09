@extends('layouts.main')
@section('content')
@section('title', 'Faq')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->

<!--=============================
        FAQ PAGE START
    ==============================-->
<section class="wsus__faq pt_100 xs_pt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__faq_area">
                    <div class="accordion" id="accordionExample">
                       @foreach ($faqs as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne-{{ $faq->id }}">
                                    <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne-{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapseOne-{{ $faq->id }}">
                                        {{ $loop->iteration }}. {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapseOne-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="headingOne-{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{!! $faq->answer !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-lg-5 wow fadeInUp" data-wow-duration="1s">
                <div id="sticky_sidebar" class="wsus__faq_form">
                    <form method="POST" action="{{ route('frontend.contact.store') }}">
                        @csrf
                        <h3>Feel free to contact us</h3>
                        <input type="text" name="name" placeholder="Name">
                        <input type="email" name="email" placeholder="Email">
                        <input type="text" name="phone" placeholder="Phone">
                        <input type="text" placeholder="Subject" name="subject">
                        <textarea rows="5" placeholder="Message" name="message"></textarea>

                        <button type="submit" class="common_btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=============================
        FAQ PAGE END
    ==============================-->

    <!--=============================
        BRAND START
    ==============================-->
     @include('partials.brand')
    <!--=============================
        BRAND END
    ==============================-->
@endsection
