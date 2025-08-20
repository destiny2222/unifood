@extends('layouts.main')
@section('content')
    <!--=============================
        404 PAGE START
    ==============================-->
    <section class="wsus__404">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-7 m-auto">
                    <div class="wsus__404_text wow fadeInUp" data-wow-duration="1s">
                        {{-- <img src="{{asset('images/errorpage.png')}}" alt="404" class="img-fluid w-100"> --}}
                        <h2>500!</h2>
                        <p>Sorry, an error has occurred, Requested page not found!</p>
                        <a class="common_btn" href="/">home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        404 PAGE END
    ==============================-->

@endsection