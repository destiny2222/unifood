@extends('layouts.main')
@section('content')
@section('title', 'Checkout')
<!--=============================
            BREADCRUMB START
        ==============================-->
@include('partials.breadcrumb')
<!--=============================
        BREADCRUMB END
    ==============================-->
<!--============================
        CHECK OUT PAGE START
    ==============================-->
<section class="wsus__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__checkout_form">
                    <div class="wsus__check_form">
                        <h5>
                            select address
                            <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i class="far fa-plus"></i> New Address</a>
                        </h5>

                        <div class="wsus__address_modal">
                            <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                data-bs-keyboard="false" aria-labelledby="address_modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="address_modalLabel">
                                                add new address
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#"  method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="modal_select2">
                                                                <option value="">
                                                                    Select Delivery Area
                                                                </option>
                                                                <option value="1">
                                                                    Arizona State University West Campus
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="First Name*" name="first_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Last Name *"    name="last_name" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Phone" name="phone" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="email" placeholder="Email" name="email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                        <div class="wsus__check_single_form">
                                                            <textarea name="address" cols="3" rows="4" placeholder="Address *"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form check_area">
                                                            <div class="form-check">
                                                                <input value="home" class="form-check-input"  type="radio" name="address_type" id="flexRadioDefault1" />
                                                                <label class="form-check-label" for="flexRadioDefault1">  home </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input value="office" class="form-check-input" type="radio" name="address_type" id="flexRadioDefault2" />
                                                                <label class="form-check-label" for="flexRadioDefault2"> office </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form m-0">
                                                            <button type="submit" class="common_btn">
                                                                Save Address
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="wsus__checkout_single_address">
                                    <div class="form-check">
                                        <input value="1" data-delivery-charge="25"
                                            class="form-check-input address_id" type="radio" name="address_id"
                                            id="home-1" />

                                        <label class="form-check-label" for="home-1">
                                            <span class="icon"><i class="fas fa-home"></i>Home</span>
                                            <span class="address">Name : John Doe</span>
                                            <span class="address">Phone : 125-985-4587</span>
                                            <span class="address">Delivery area : Metrocenter Mall</span>

                                            <span class="address">Address : Los Angeles, CA, USA</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__checkout_single_address">
                                    <div class="form-check">
                                        <input value="2" data-delivery-charge="15"
                                            class="form-check-input address_id" type="radio" name="address_id"
                                            id="home-2" />

                                        <label class="form-check-label" for="home-2">
                                            <span class="icon"><i class="far fa-car-building"></i>Office</span>
                                            <span class="address">Name : John Doe</span>
                                            <span class="address">Phone : 123-343-4444</span>
                                            <span class="address">Delivery area : Thunderbird Paseo Park</span>

                                            <span class="address">Address : Los Angeles, CA, USA</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__checkout_single_address">
                                    <div class="form-check">
                                        <input value="3" data-delivery-charge="15"
                                            class="form-check-input address_id" type="radio" name="address_id"
                                            id="home-3" />

                                        <label class="form-check-label" for="home-3">
                                            <span class="icon"><i class="fas fa-home"></i>Home</span>
                                            <span class="address">Name : David Rechard</span>
                                            <span class="address">Phone : 123-874-6548</span>
                                            <span class="address">Delivery area : Deer Valley Rock Art Center</span>

                                            <span class="address">Address : Los Angeles, CA, USA</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="wsus__checkout_single_address">
                                    <div class="form-check">
                                        <input value="4" data-delivery-charge="15"
                                            class="form-check-input address_id" type="radio" name="address_id"
                                            id="home-4" />

                                        <label class="form-check-label" for="home-4">
                                            <span class="icon"><i class="far fa-car-building"></i>Office</span>
                                            <span class="address">Name : John Abraham</span>
                                            <span class="address">Phone : 123-874-6548</span>
                                            <span class="address">Delivery area : Thunderbird Paseo Park</span>

                                            <span class="address">Address : Los Angeles, CA, USA</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div id="sticky_sidebar" class="wsus__cart_list_footer_button">
                    <h6>total price</h6>
                    <p>subtotal: <span>$120</span></p>
                    <p>discount (-): <span>$0</span></p>
                    <p>delivery (+): <span class="delivery_charge">$0.00</span></p>
                    <p class="total">
                        <span>Total:</span> <span class="grand_total">$120</span>
                    </p>
                    <input type="hidden" id="grand_total" value="120" />
                    <form action="https://unifood.websolutionus.com/apply-coupon-from-checkout">
                        <input name="coupon" type="text" placeholder="Coupon Code" />
                        <button type="submit">apply</button>
                    </form>
                    <a class="common_btn" href="javascript:;" id="continue_to_pay">Continue to pay</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
        CHECK OUT PAGE END
    ==============================-->

@endsection
