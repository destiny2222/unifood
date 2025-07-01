@extends('layouts.main')
@section('content')

<!--=============================
        BREADCRUMB START
    ==============================-->
<section class="wsus__breadcrumb" style="background: url({{ asset('images/breadcrumb_image.jpg') }});">
    <div class="wsus__breadcrumb_overlay">
        <div class="container">
            <div class="wsus__breadcrumb_text">
                <h1>Dashboard</h1>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
        BREADCRUMB END
    ==============================-->

<!--=========================
        DASHBOARD START
    ==========================-->
<section class="wsus__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">
        <div class="wsus__dashboard_area">
            <div class="row">
                <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                    <div class="wsus__dashboard_menu">
                        <div class="dasboard_header">
                            <div class="dasboard_header_img">
                                <img id="preview-user-avatar" src="{{ asset('images/profile/'.$user->profile_picture ) }}" alt="user" class="img-fluid w-100">
                                <label for="upload"><i class="far fa-camera" aria-hidden="true"></i></label>
                                <form id="upload_user_avatar_form" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="file" name="profile_picture" id="upload" hidden="" onchange="previewThumnailImage(event)">
                                </form>
                            </div>
                            <h2>{{  $user->name  }}</h2>
                        </div>
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true"><span><i class="fas fa-user" aria-hidden="true"></i></span> Personal Info</button>

                            <button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill" data-bs-target="#v-pills-address" type="button" role="tab" aria-controls="v-pills-address" aria-selected="false" tabindex="-1"><span><i class="fas fa-user" aria-hidden="true"></i></span>Address</button>

                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false" tabindex="-1"><span><i class="fas fa-bags-shopping" aria-hidden="true"></i></span> Order</button>

                            <button class="nav-link" id="v-pills-messages-tab2" data-bs-toggle="pill" data-bs-target="#v-pills-messages2" type="button" role="tab" aria-controls="v-pills-messages2" aria-selected="false" tabindex="-1"><span><i class="far fa-heart" aria-hidden="true"></i></span> wishlist</button>

                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false" tabindex="-1"><span><i class="fas fa-star" aria-hidden="true"></i></span> Reviews</button>

                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false" tabindex="-1"><span><i class="fas fa-user-lock" aria-hidden="true"></i></span> Change Password </button>

                            <button class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reservation" type="button" role="tab" aria-controls="v-pills-reservation" aria-selected="false" tabindex="-1"><span><i class="fas fa-user-lock" aria-hidden="true"></i></span> Reservations </button>

                            <a onclick="return confirm('Are you sure ?')" href="" class="nav-link">
                                <span> <i class="fas fa-trash" aria-hidden="true"></i></span>
                                Delete Account
                            </a>

                            <button class="nav-link" onclick="event.preventDefault(); document.getElementById('logout_btn').submit();">
                                <span> <i class="fas fa-sign-out-alt" aria-hidden="true"></i> </span> 
                                Logout
                            </button>

                            <form action="{{ route('logout') }}" method="POST" id="logout_btn" style="display: none;">
                                @csrf
                            </form>


                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                    <div class="wsus__dashboard_content">
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="wsus_dashboard_body">
                                    <h3>Welcome to your Profile</h3>

                                    <div class="wsus__dsahboard_overview">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="wsus__dsahboard_overview_item">
                                                    <span class="icon"><i class="far fa-shopping-basket" aria-hidden="true"></i></span>
                                                    <h4>Total order <span>(0)</span></h4>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="wsus__dsahboard_overview_item green">
                                                    <span class="icon"><i class="far fa-shopping-basket" aria-hidden="true"></i></span>
                                                    <h4>Completed <span>(0)</span></h4>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="wsus__dsahboard_overview_item red">
                                                    <span class="icon"><i class="far fa-shopping-basket" aria-hidden="true"></i></span>
                                                    <h4>Cancel <span>(0)</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wsus_dash_personal_info">
                                        <h4>Personal Information
                                            <a class="dash_info_btn">
                                                <span class="edit">edit</span>
                                                <span class="cancel">cancel</span>
                                            </a>
                                        </h4>

                                        <div class="personal_info_text">
                                            <p><span>Name:</span> {{ $user->name }}</p>
                                            <p><span>Email:</span> {{ $user->email }} </p>
                                            <p><span>Phone:</span> {{ $user->phone }} </p>
                                            <p><span>Address:</span>{{ $user->address }} </p>
                                        </div>

                                        <div class="wsus_dash_personal_info_edit comment_input p-0">
                                            <form id="personal_info_form" method="POST" action="{{ route('profile.edit', $user->id) }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="wsus__comment_imput_single">
                                                            <label>Name</label>
                                                            <input type="text" name="name" value="{{ $user->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="wsus__comment_imput_single">
                                                            <label>Email</label>
                                                            <input type="email" name="email" value="{{ $user->email }}" readonly="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="wsus__comment_imput_single">
                                                            <label>Phone</label>
                                                            <input type="text" placeholder="Phone" name="phone" value="{{ $user->phone }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="wsus__comment_imput_single">
                                                            <label>Address</label>
                                                            <input type="text" placeholder="Address" name="address" value="{{ $user->address }}">
                                                        </div>
                                                        <button type="submit" class="common_btn">submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
                                <div class="wsus_dashboard_body address_body">
                                    <h3>address <a class="dash_add_new_address"><i class="far fa-plus" aria-hidden="true"></i> add new
                                        </a>
                                    </h3>
                                    <div class="wsus_dashboard_address">
                                        <div class="wsus_dashboard_existing_address">
                                            <div class="row" id="address_all_list">
                                                @foreach ($shippingAddress as $shipping)
                                                    <div class="col-md-6">
                                                        <div class="wsus__checkout_single_address ">
                                                            <div class="form-check address-list-1">
                                                                <label class="form-check-label">
                                                                    @if ($shipping->address_type == 'Home')
                                                                        <span class="icon"><i class="fas fa-home" aria-hidden="true"></i>{{ $shipping->address_type }}</span>
                                                                    @else
                                                                        <span class="icon"><i class="far fa-car-building" aria-hidden="true"></i>{{ $shipping->address_type }}</span>
                                                                    @endif
                                                                    <span class="address">Name : {{ $shipping->first_name }}  {{ $shipping->last_name }}</span>
                                                                    <span class="address">Phone : {{ $shipping->phone_number }}</span>
                                                                    <span class="address">Delivery area : {{ $shipping->deliveryArea->delivery_area_name }}</span>
                                                                    <span class="address">Address : {{ $shipping->address }}</span>
                                                                </label>
                                                            </div>
                                                            <ul>
                                                                {{-- <li><a href="{{ route('shipping.address.edit', $shipping->id) }}" class="dash_edit_btn edit_data_attribute"><i class="far fa-edit" aria-hidden="true"></i></a></li> --}}
                                                                <li>
                                                                    @php
                                                                        $shippingData = [
                                                                            'id' => $shipping->id,
                                                                            'first_name' => $shipping->first_name,
                                                                            'last_name' => $shipping->last_name,
                                                                            'phone_number' => $shipping->phone_number,
                                                                            'email' => $shipping->email,
                                                                            'delivery_area_id' => $shipping->delivery_area_id,
                                                                            'delivery_area_name' => $shipping->deliveryArea->delivery_area_name,
                                                                            'address' => $shipping->address,
                                                                            'address_type' => $shipping->address_type
                                                                        ];
                                                                    @endphp
                                                                    <a href="javascript:void(0);"
                                                                        class="dash_edit_btn edit_data_attribute"
                                                                        data-address='@json($shippingData)'>
                                                                        <i class="far fa-edit" aria-hidden="true"></i>
                                                                    </a>
                                                                </li>


                                                                <li><a onclick="delete_address(1)" class="dash_del_icon"><i class="fas fa-trash-alt" aria-hidden="true"></i></a> </li>

                                                                <form id="delete_address_1" action="" method="POST">
                                                                    @method('DELETE') 
                                                                    @csrf 
                                                                </form>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                        <div class="wsus_dashboard_new_address ">
                                            <form id="add_new_address_form" method="POST" action='{{ route('shipping.address.store') }}'>
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>add new address</h4>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="select2"  tabindex="-1" aria-hidden="true">
                                                                <option value="">   Select Delivery Area </option>
                                                                @foreach ($deliveryArea as $delivery)
                                                                 <option value="{{ $delivery->id }}"> {{ $delivery->delivery_area_name }}  </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="First Name*" name="first_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Last Name *" name="last_name">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="text" placeholder="Phone" name="phone_number">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input type="email" placeholder="Email" name="email">
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
                                                                <input value="home" class="form-check-input" type="radio" name="address_type" id="flexRadioDefault1">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    home
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input value="office" class="form-check-input" type="radio" name="address_type" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                    office
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="button" class="common_btn cancel_new_address">cancel</button>
                                                        <button type="submit" class="common_btn">Save Address</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="wsus_dashboard_edit_address" >
                                            <form id="edit_address_form"  method="POST"
                                                action="{{ route('shipping.address.update', ['id' => '__id__']) }}"
                                                data-action-template="{{ route('shipping.address.update', ['id' => '__id__']) }}">

                                                <input type="hidden" name="edit_id" class="edit_id">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Edit address</h4>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="select2 edit_delivery_area_id" tabindex="-1" aria-hidden="true">
                                                                <option value="">Select Delivery Area</option>
                                                                @foreach ($deliveryArea as $delivery)
                                                                    <option value="{{ $delivery->id }}">{{ $delivery->delivery_area_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="edit_id" class="edit_id">
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input class="edit_first_name" type="text" placeholder="First Name*" name="first_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input class="edit_last_name" type="text" placeholder="Last Name *" name="last_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input class="edit_phone" type="text" placeholder="Phone" name="phone_number">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                        <div class="wsus__check_single_form">
                                                            <input class="edit_email" type="email" placeholder="Email" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                        <div class="wsus__check_single_form">
                                                            <textarea class="edit_address" name="address" cols="3" rows="4" placeholder="Address *"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form check_area">
                                                            <div class="form-check">
                                                                <input value="home" class="form-check-input edit_address_type home_type" type="radio" name="address_type" id="flexRadioDefault3">
                                                                <label class="form-check-label" for="flexRadioDefault3">home</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input value="office" class="form-check-input edit_address_type office_type" type="radio" name="address_type" id="flexRadioDefault4">
                                                                <label class="form-check-label" for="flexRadioDefault4">office</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="button" class="common_btn cancel_edit_address">cancel</button>
                                                        <button type="submit" class="common_btn">Save Address</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div class="wsus_dashboard_body">
                                    <h3>order list</h3>
                                    <div class="wsus_dashboard_order">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr class="t_header">
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#1214241772</h5>
                                                        </td>
                                                        <td>
                                                            <p>16 Apr 2024</p>
                                                        </td>
                                                        <td>
                                                            <span class="cancel">Pending</span>
                                                        </td>
                                                        <td>
                                                            <h5>$195</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="23">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#107887705</h5>
                                                        </td>
                                                        <td>
                                                            <p>07 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="cancel">Pending</span>

                                                        </td>
                                                        <td>
                                                            <h5>$375</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="12">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#301211793</h5>
                                                        </td>
                                                        <td>
                                                            <p>06 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="cancel">Pending</span>

                                                        </td>
                                                        <td>
                                                            <h5>$890</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="10">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#724479377</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">Completed</span>

                                                        </td>
                                                        <td>
                                                            <h5>$420</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="9">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#560337900</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="cancel">Declined</span>

                                                        </td>
                                                        <td>
                                                            <h5>$270</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="8">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#1583060974</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">Processing</span>

                                                        </td>
                                                        <td>
                                                            <h5>$350</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="7">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#1107267602</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">On the way</span>

                                                        </td>
                                                        <td>
                                                            <h5>$315</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="6">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#917890010</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">Completed</span>

                                                        </td>
                                                        <td>
                                                            <h5>$205</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="5">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#1402351631</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">Completed</span>

                                                        </td>
                                                        <td>
                                                            <h5>$315</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="4">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#958913600</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="cancel">Pending</span>

                                                        </td>
                                                        <td>
                                                            <h5>$225</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="3">View Details</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h5>#479428556</h5>
                                                        </td>
                                                        <td>
                                                            <p>05 Mar 2023</p>
                                                        </td>
                                                        <td>

                                                            <span class="complete">Completed</span>

                                                        </td>
                                                        <td>
                                                            <h5>$310</h5>
                                                        </td>
                                                        <td><a class="view_invoice" data-order-id="2">View Details</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="wsus__invoice">
                                        <a class="go_back"><i class="fas fa-long-arrow-alt-left" aria-hidden="true"></i> go back</a>
                                        <div id="load_order_details">

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade " id="v-pills-messages2" role="tabpanel" aria-labelledby="v-pills-messages-tab2">
                                <div class="wsus_dashboard_body">
                                    <h3>wishlist</h3>
                                    <div class="wsus__dashoard_wishlist">
                                        <div class="row">
                                            @foreach ($wishlists as $wishlist)
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="wsus__menu_item">
                                                        <div class="wsus__menu_item_img">
                                                            <img src="{{ asset('storage/upload/product/single/'.$wishlist->product->images ) }}" alt="menu" class="img-fluid w-100">
                                                            <a class="category" href="">{{ $wishlist->product->category->title  }}</a>
                                                        </div>
                                                        <div class="wsus__menu_item_text">
                                                            <a class="title" href="{{ route('frontend.product.show', $wishlist->product->slug) }}">{{  $wishlist->product->title }}</a>
                                                            <h5 class="price">${{ $wishlist->product->price ?? 0 }} @if($wishlist->product->discount)<del>${{ $wishlist->product->discount }}</del>@endif </h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li>
                                                                    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('add-cart-{{ $wishlist->product->id  }}').submit()" href="{{ route('wishlist.add.cart') }}">
                                                                        <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                                                                    </a>
                                                                    <form action="{{ route('wishlist.add.cart') }}" id="add-cart-{{ $wishlist->product->id }}" method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                                                        <input type="hidden" name="slug" value="{{ $wishlist->product->slug }}">
                                                                        <input type="text" value="1" name="quantity" hidden>
                                                                    </form>
                                                                </li>

                                                                <form id="remove_wishlist_1" action="" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <input type="hidden" name="" value="DELETE"> 
                                                                </form>
                                                                <li><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="wsus_dashboard_body dashboard_review">
                                    <h3>reviews</h3>
                                    <div class="wsus__review_area">
                                        <div class="wsus__comment pt-0 mt_20">
                                            <div class="wsus__single_comment m-0 border-0">
                                                <img src="https://unifood.websolutionus.com/public/uploads/custom-images/pulled-pork-sliders-2023-03-06-01-02-22-7233.png" alt="review" class="img-fluid">
                                                <div class="wsus__single_comm_text">
                                                    <h3><a href="https://unifood.websolutionus.com/product/pulled-pork-sliders">Pulled Pork Sliders</a> <span>06 Mar 2023 </span>
                                                    </h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    </span>
                                                    <p>Pizza is a savory dish of Italian origin consisting of a usually round, flattened base of leavened wheat-based dough topped with tomatoes</p>
                                                    <span class="status active">active</span>

                                                </div>
                                            </div>
                                            <div class="wsus__single_comment m-0 border-0">
                                                <img src="https://unifood.websolutionus.com/public/uploads/custom-images/truffle-fries-2023-03-06-01-06-09-8443.png" alt="review" class="img-fluid">
                                                <div class="wsus__single_comm_text">
                                                    <h3><a href="https://unifood.websolutionus.com/product/truffle-fries">Truffle Fries</a> <span>06 Mar 2023 </span>
                                                    </h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    </span>
                                                    <p>Pizza is a savory dish of Italian origin consisting of a usually round, flattened base of leavened wheat-based dough topped with tomatoes</p>
                                                    <span class="status active">active</span>

                                                </div>
                                            </div>
                                            <div class="wsus__single_comment m-0 border-0">
                                                <img src="https://unifood.websolutionus.com/public/uploads/custom-images/spicy-burger-2023-03-05-02-57-08-4535.png" alt="review" class="img-fluid">
                                                <div class="wsus__single_comm_text">
                                                    <h3><a href="https://unifood.websolutionus.com/product/spicy-burger">Spicy Burger</a> <span>05 Mar 2023 </span>
                                                    </h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    </span>
                                                    <p>Vim et alterum ornatus vivendum, ut mea solum repudiare. His etiam delenit tibique no, ad harum omnes scribentur qui, ne wisi detracto his. Ei movet accusam pri</p>
                                                    <span class="status active">active</span>

                                                </div>
                                            </div>
                                            <div class="wsus__single_comment m-0 border-0">
                                                <img src="https://unifood.websolutionus.com/public/uploads/custom-images/hyderabadi-biryani-2023-03-05-01-14-59-9689.png" alt="review" class="img-fluid">
                                                <div class="wsus__single_comm_text">
                                                    <h3><a href="https://unifood.websolutionus.com/product/hyderabadi-biryani">Hyderabadi Biryani</a> <span>05 Mar 2023 </span>
                                                    </h3>
                                                    <span class="rating">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    </span>
                                                    <p>Vim et alterum ornatus vivendum, ut mea solum repudiare. His etiam delenit tibique no, ad harum omnes scribentur qui, ne wisi detracto his.</p>
                                                    <span class="status active">active</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="wsus_dashboard_body wsus__change_password">
                                    <div class="wsus__review_input">
                                        <h3>change password</h3>
                                        <div class="comment_input pt-0">
                                            <form id="change_password_form" method="POST" action="{{ route('profile.password.update') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="wsus__comment_imput_single input_group" id="Password-toggle2">
                                                            <label>Current Password</label>
                                                            <input type="password" placeholder="Current Password" name="current_password">
                                                            <a href="javascript:void(0);" class="" id="Password_toggle">
                                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="wsus__comment_imput_single input_group" id="Password-toggle3">
                                                            <label>New Password</label>
                                                            <input type="password" placeholder="New Password" name="new_password">
                                                            <a href="javascript:void(0);" class="" id="Password_toggle">
                                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="wsus__comment_imput_single input_group" id="Password-toggle1">
                                                            <label>Confirm Password</label>
                                                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                                                            <a href="javascript:void(0);" class="" id="Password_toggle">
                                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <button type="submit" class="common_btn mt_20">submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="v-pills-reservation" role="tabpanel" aria-labelledby="v-pills-reservation-tab">
                                <div class="wsus_dashboard_body">
                                    <h3>Reservations</h3>
                                    <div class="wsus_dashboard_order reservation_list">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr class="t_header">
                                                        <th class="sn">SN</th>
                                                        <th class="time">Date &amp; Time</th>
                                                        <th class="person">Person</th>
                                                        <th class="status">Status</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="sn">
                                                            <h5>#1</h5>
                                                        </td>
                                                        <td class="time">
                                                            <p>27 Mar, 2023</p>
                                                            <br>
                                                            <p>09:00 AM - 10:00 AM</p>

                                                        </td>
                                                        <td class="person">
                                                            12
                                                        </td>
                                                        <td class="status">
                                                            <span class="cancel">Pending</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="sn">
                                                            <h5>#2</h5>
                                                        </td>
                                                        <td class="time">
                                                            <p>19 Mar, 2023</p>
                                                            <br>
                                                            <p>02:00 AM - 03:00 AM</p>

                                                        </td>
                                                        <td class="person">
                                                            2
                                                        </td>
                                                        <td class="status">
                                                            <span class="cancel">Pending</span>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td class="sn">
                                                            <h5>#3</h5>
                                                        </td>
                                                        <td class="time">
                                                            <p>29 Mar, 2023</p>
                                                            <br>
                                                            <p>12:00 AM - 01:00 AM</p>

                                                        </td>
                                                        <td class="person">
                                                            3
                                                        </td>
                                                        <td class="status">
                                                            <span class="cancel">Pending</span>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {
                $("#upload_user_avatar_form").on("submit", function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST',
                        data:new FormData(this),
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: "{{ route('profile.picture.update') }}",
                        success: function (response) {
                            toastr.success(response.message)
                        },
                        error: function(response) {

                        }
                    });
                })
            });
        })(jQuery);

        function previewThumnailImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-user-avatar');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
            $("#upload_user_avatar_form").submit();
        };
    </script>
    <script>
        $(document).on('click', '.edit_data_attribute', function () {
            let data = $(this).data('address');

            // ✅ Fill in form fields
            $('.edit_id').val(data.id);
            $('.edit_first_name').val(data.first_name);
            $('.edit_last_name').val(data.last_name);
            $('.edit_phone').val(data.phone_number);
            $('.edit_email').val(data.email);
            $('.edit_address').val(data.address);
            $('.edit_delivery_area_id').val(data.delivery_area_id).trigger('change');

            // ✅ Check the appropriate radio button
            if (data.address_type === 'home') {
                $('.home_type').prop('checked', true);
            } else if (data.address_type === 'office') {
                $('.office_type').prop('checked', true);
            }

            // ✅ Update the form action URL dynamically
            let form = $('#edit_address_form');
            let originalAction = form.data('action-template'); // store this in HTML
            let updatedAction = originalAction.replace('__id__', data.id);
            form.attr('action', updatedAction);

            // ✅ Show the edit form
            $('.wsus_dashboard_new_address').hide();
            $('.wsus_dashboard_edit_address').show();
        });
    </script>

    {{-- <script>
        $(document).ready(function () {
            $('#submit_edit_address').on('click', function (e) {
                e.preventDefault();

                let formData = {
                    _token: $('input[name="_token"]').val(),
                    _method: 'PUT',
                    edit_id: $('.edit_id').val(),
                    first_name: $('.edit_first_name').val(),
                    last_name: $('.edit_last_name').val(),
                    phone_number: $('.edit_phone').val(),
                    email: $('.edit_email').val(),
                    address: $('.edit_address').val(),
                    address_type: $('input[name="address_type"]:checked').val(),
                    delivery_area_id: $('.edit_delivery_area_id').val()
                };

                $.ajax({
                    url: '{{ route("shipping.address.update") }}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        toastr.success('Address updated successfully.');
                        $('#address_all_list').load(location.href + " #address_all_list"); 
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            for (let key in errors) {
                                errorMsg += errors[key][0] + '\n';
                            }
                            toastr.error(errorMsg);
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        });
    </script> --}}
@endpush
