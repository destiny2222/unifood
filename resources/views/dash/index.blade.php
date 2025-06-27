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
                                                <div class="col-md-6">
                                                    <div class="wsus__checkout_single_address ">
                                                        <div class="form-check address-list-1">
                                                            <label class="form-check-label">
                                                                <span class="icon"><i class="fas fa-home" aria-hidden="true"></i>Home</span>
                                                                <span class="address">Name : John Doe</span>

                                                                <span class="address">Phone : 125-985-4587</span>

                                                                <span class="address">Delivery area : Metrocenter Mall</span>

                                                                <span class="address">Address : Los Angeles, CA, USA</span>
                                                            </label>
                                                        </div>
                                                        <ul>
                                                            <li><a data-existing-address="{&quot;id&quot;:1,&quot;user_id&quot;:1,&quot;delivery_area_id&quot;:3,&quot;first_name&quot;:&quot;John&quot;,&quot;last_name&quot;:&quot;Doe&quot;,&quot;email&quot;:&quot;user@gmail.com&quot;,&quot;phone&quot;:&quot;125-985-4587&quot;,&quot;address&quot;:&quot;Los Angeles, CA, USA&quot;,&quot;type&quot;:&quot;home&quot;,&quot;default_address&quot;:&quot;Yes&quot;,&quot;latitude&quot;:null,&quot;longitude&quot;:null,&quot;created_at&quot;:&quot;2023-03-05T16:47:09.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-05T16:47:09.000000Z&quot;,&quot;delivery_area&quot;:{&quot;id&quot;:3,&quot;area_name&quot;:&quot;Metrocenter Mall&quot;,&quot;delivery_fee&quot;:&quot;25&quot;,&quot;min_time&quot;:&quot;20&quot;,&quot;max_time&quot;:&quot;30&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-03-04T22:55:58.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-04T22:55:58.000000Z&quot;}}" class="dash_edit_btn edit_data_attribute-1"><i class="far fa-edit" aria-hidden="true"></i></a></li>
                                                            <li><a onclick="delete_address(1)" class="dash_del_icon"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                                                            </li>

                                                            <form id="delete_address_1" action="https://unifood.websolutionus.com/address/1" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="wsus__checkout_single_address ">
                                                        <div class="form-check address-list-2">
                                                            <label class="form-check-label">
                                                                <span class="icon"><i class="far fa-car-building" aria-hidden="true"></i>Office</span>
                                                                <span class="address">Name : John Doe</span>
                                                                <span class="address">Phone : 123-343-4444</span>
                                                                <span class="address">Delivery area : Thunderbird Paseo Park</span>
                                                                <span class="address">Address : Los Angeles, CA, USA</span>
                                                            </label>
                                                        </div>
                                                        <ul>
                                                            <li><a data-existing-address="{&quot;id&quot;:2,&quot;user_id&quot;:1,&quot;delivery_area_id&quot;:2,&quot;first_name&quot;:&quot;John&quot;,&quot;last_name&quot;:&quot;Doe&quot;,&quot;email&quot;:&quot;user@gmail.com&quot;,&quot;phone&quot;:&quot;123-343-4444&quot;,&quot;address&quot;:&quot;Los Angeles, CA, USA&quot;,&quot;type&quot;:&quot;office&quot;,&quot;default_address&quot;:&quot;No&quot;,&quot;latitude&quot;:null,&quot;longitude&quot;:null,&quot;created_at&quot;:&quot;2023-03-05T16:47:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-05T16:47:48.000000Z&quot;,&quot;delivery_area&quot;:{&quot;id&quot;:2,&quot;area_name&quot;:&quot;Thunderbird Paseo Park&quot;,&quot;delivery_fee&quot;:&quot;15&quot;,&quot;min_time&quot;:&quot;10&quot;,&quot;max_time&quot;:&quot;20&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-03-04T22:55:45.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-04T22:55:45.000000Z&quot;}}" class="dash_edit_btn edit_data_attribute-2"><i class="far fa-edit" aria-hidden="true"></i></a></li>
                                                            <li><a onclick="delete_address(2)" class="dash_del_icon"><i class="fas fa-trash-alt" aria-hidden="true"></i></a> </li>

                                                            <form id="delete_address_2" action="https://unifood.websolutionus.com/address/2" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="wsus__checkout_single_address ">
                                                        <div class="form-check address-list-3">
                                                            <label class="form-check-label">
                                                                <span class="icon"><i class="fas fa-home" aria-hidden="true"></i>Home</span>
                                                                <span class="address">Name : David Rechard</span>
                                                                <span class="address">Phone : 123-874-6548</span>
                                                                <span class="address">Delivery area : Deer Valley Rock Art Center</span>
                                                                <span class="address">Address : Los Angeles, CA, USA</span>
                                                            </label>
                                                        </div>
                                                        <ul>
                                                            <li><a data-existing-address="{&quot;id&quot;:3,&quot;user_id&quot;:1,&quot;delivery_area_id&quot;:6,&quot;first_name&quot;:&quot;David&quot;,&quot;last_name&quot;:&quot;Rechard&quot;,&quot;email&quot;:&quot;user@gmail.com&quot;,&quot;phone&quot;:&quot;123-874-6548&quot;,&quot;address&quot;:&quot;Los Angeles, CA, USA&quot;,&quot;type&quot;:&quot;home&quot;,&quot;default_address&quot;:&quot;No&quot;,&quot;latitude&quot;:null,&quot;longitude&quot;:null,&quot;created_at&quot;:&quot;2023-03-05T16:48:18.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-05T16:48:18.000000Z&quot;,&quot;delivery_area&quot;:{&quot;id&quot;:6,&quot;area_name&quot;:&quot;Deer Valley Rock Art Center&quot;,&quot;delivery_fee&quot;:&quot;15&quot;,&quot;min_time&quot;:&quot;15&quot;,&quot;max_time&quot;:&quot;20&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-03-04T22:57:28.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-04T22:57:28.000000Z&quot;}}" class="dash_edit_btn edit_data_attribute-3"><i class="far fa-edit" aria-hidden="true"></i></a></li>
                                                            <li><a onclick="delete_address(3)" class="dash_del_icon"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                                                            </li>

                                                            <form id="delete_address_3" action="https://unifood.websolutionus.com/address/3" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="wsus__checkout_single_address ">
                                                        <div class="form-check address-list-4">
                                                            <label class="form-check-label">
                                                                <span class="icon"><i class="far fa-car-building" aria-hidden="true"></i>Office</span>
                                                                <span class="address">Name : John Abraham</span>
                                                                <span class="address">Phone : 123-874-6548</span>
                                                                <span class="address">Delivery area : Thunderbird Paseo Park</span>
                                                                <span class="address">Address : Los Angeles, CA, USA</span>
                                                            </label>
                                                        </div>
                                                        <ul>
                                                            <li><a data-existing-address="{&quot;id&quot;:4,&quot;user_id&quot;:1,&quot;delivery_area_id&quot;:2,&quot;first_name&quot;:&quot;John&quot;,&quot;last_name&quot;:&quot;Abraham&quot;,&quot;email&quot;:&quot;user@gmail.com&quot;,&quot;phone&quot;:&quot;123-874-6548&quot;,&quot;address&quot;:&quot;Los Angeles, CA, USA&quot;,&quot;type&quot;:&quot;office&quot;,&quot;default_address&quot;:&quot;No&quot;,&quot;latitude&quot;:null,&quot;longitude&quot;:null,&quot;created_at&quot;:&quot;2023-03-05T16:49:24.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-05T16:49:24.000000Z&quot;,&quot;delivery_area&quot;:{&quot;id&quot;:2,&quot;area_name&quot;:&quot;Thunderbird Paseo Park&quot;,&quot;delivery_fee&quot;:&quot;15&quot;,&quot;min_time&quot;:&quot;10&quot;,&quot;max_time&quot;:&quot;20&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-03-04T22:55:45.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-03-04T22:55:45.000000Z&quot;}}" class="dash_edit_btn edit_data_attribute-4"><i class="far fa-edit" aria-hidden="true"></i></a></li>
                                                            <li><a onclick="delete_address(4)" class="dash_del_icon"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                                                            </li>

                                                            <form id="delete_address_4" action="https://unifood.websolutionus.com/address/4" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wsus_dashboard_new_address ">
                                            <form id="add_new_address_form" method="POST">
                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>add new address</h4>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="select2 select2-hidden-accessible" data-select2-id="select2-data-1-nuar" tabindex="-1" aria-hidden="true">
                                                                <option value="" data-select2-id="select2-data-3-7yi9">Select Delivery Area</option>
                                                                <option value="1">Arizona State University West Campus</option>
                                                                <option value="2">Thunderbird Paseo Park</option>
                                                                <option value="3">Metrocenter Mall</option>
                                                                <option value="4">Reach 11 Recreation Area</option>
                                                                <option value="5">Pioneer Community Park</option>
                                                                <option value="6">Deer Valley Rock Art Center</option>
                                                                <option value="7">Cave Creek Regional Park</option>
                                                                <option value="8">Turf Soaring School</option>
                                                            </select>
                                                            <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-2-w7ft" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-delivery_area_id-4v-container" aria-controls="select2-delivery_area_id-4v-container"><span class="select2-selection__rendered" id="select2-delivery_area_id-4v-container" role="textbox" aria-readonly="true" title="Select Delivery Area">Select Delivery Area</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
                                                            <input type="text" placeholder="Phone" name="phone">
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
                                        <div class="wsus_dashboard_edit_address ">
                                            <form id="edit_address_form" method="POST">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>Edit address</h4>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="wsus__check_single_form">
                                                            <select name="delivery_area_id" class="select2 edit_delivery_area_id select2-hidden-accessible" data-select2-id="select2-data-4-0tia" tabindex="-1" aria-hidden="true">
                                                                <option value="1" data-select2-id="select2-data-6-y300">Arizona State University West Campus</option>
                                                                <option value="2">Thunderbird Paseo Park</option>
                                                                <option value="3">Metrocenter Mall</option>
                                                                <option value="4">Reach 11 Recreation Area</option>
                                                                <option value="5">Pioneer Community Park</option>
                                                                <option value="6">Deer Valley Rock Art Center</option>
                                                                <option value="7">Cave Creek Regional Park</option>
                                                                <option value="8">Turf Soaring School</option>
                                                            </select>
                                                            <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-0s2e" style="width: auto;">
                                                                <span class="selection">
                                                                    <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-delivery_area_id-m6-container" aria-controls="select2-delivery_area_id-m6-container">
                                                                        <span class="select2-selection__rendered" id="select2-delivery_area_id-m6-container" role="textbox" aria-readonly="true" title="Arizona State University West Campus">Arizona State University West Campus</span>
                                                                        <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                                                                    </span>
                                                                </span>
                                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                                            </span>
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
                                                            <input class="edit_phone" type="text" placeholder="Phone" name="phone">
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
                                                                <label class="form-check-label" for="flexRadioDefault3">
                                                                    home
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input value="office" class="form-check-input edit_address_type office_type" type="radio" name="address_type" id="flexRadioDefault4">
                                                                <label class="form-check-label" for="flexRadioDefault4">
                                                                    office
                                                                </label>
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
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/hyderabadi-biryani-2023-03-05-01-14-59-9689.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=burger">Burger</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>

                                                            <span>1</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/hyderabadi-biryani">Hyderabadi Biryani</a>
                                                        <h5 class="price">$130 <del>$150</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(1)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_1" action="https://unifood.websolutionus.com/remove-to-wishlist/1" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(1)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/hyderabadi-biryani"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/indian-cuisine-pakora-2023-03-05-01-32-04-5856.jpg" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=muffin">Muffin</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>

                                                            <span>0</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/indian-cuisine-pakora">Indian cuisine Pakora</a>
                                                        <h5 class="price">$100 <del>$120</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(3)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_3" action="https://unifood.websolutionus.com/remove-to-wishlist/3" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(3)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/indian-cuisine-pakora"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/daria-shevtsova-2023-03-05-02-47-26-3957.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=burger">Burger</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>

                                                            <span>0</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/daria-shevtsova">Daria Shevtsova</a>
                                                        <h5 class="price">$120 <del>$200</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(6)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_6" action="https://unifood.websolutionus.com/remove-to-wishlist/6" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(6)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/daria-shevtsova"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/spicy-burger-2023-03-05-02-57-08-4535.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=burger">Burger</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>

                                                            <span>1</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/spicy-burger">Spicy Burger</a>
                                                        <h5 class="price">$40 <del>$80</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(7)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_7" action="https://unifood.websolutionus.com/remove-to-wishlist/7" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(7)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/spicy-burger"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/firecracker-shrimp-2023-03-06-12-25-11-9828.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=chicken">Chicken</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>

                                                            <span>0</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/firecracker-shrimp">Firecracker Shrimp</a>
                                                        <h5 class="price">$25 <del>$30</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(15)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_15" action="https://unifood.websolutionus.com/remove-to-wishlist/15" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(15)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/firecracker-shrimp"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/grilled-octopus-salad-2023-03-06-12-28-49-3466.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=chicken">Chicken</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>

                                                            <span>0</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/grilled-octopus-salad">Grilled Octopus Salad</a>
                                                        <h5 class="price">$70 <del>$75</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(16)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_16" action="https://unifood.websolutionus.com/remove-to-wishlist/16" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(16)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/grilled-octopus-salad"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/quinoa-stuffed-peppers-2023-03-06-12-52-48-9661.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=dresserts">Dresserts</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>
                                                            <i class="far fa-star" aria-hidden="true"></i>

                                                            <span>0</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/quinoa-stuffed-peppers">Quinoa Stuffed Peppers</a>
                                                        <h5 class="price">$110</h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(20)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_20" action="https://unifood.websolutionus.com/remove-to-wishlist/20" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(20)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/quinoa-stuffed-peppers"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-lg-6">
                                                <div class="wsus__menu_item">
                                                    <div class="wsus__menu_item_img">
                                                        <img src="https://unifood.websolutionus.com/public/uploads/custom-images/truffle-fries-2023-03-06-01-06-09-8443.png" alt="menu" class="img-fluid w-100">
                                                        <a class="category" href="https://unifood.websolutionus.com/products?category=sandwich">Sandwich</a>
                                                    </div>
                                                    <div class="wsus__menu_item_text">
                                                        <p class="rating">


                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                            <i class="fas fa-star" aria-hidden="true"></i>

                                                            <span>1</span>
                                                        </p>
                                                        <a class="title" href="https://unifood.websolutionus.com/product/truffle-fries">Truffle Fries</a>
                                                        <h5 class="price">$150 <del>$200</del> </h5>

                                                        <ul class="d-flex flex-wrap justify-content-center">
                                                            <li><a href="javascript:;" onclick="load_product_model(22)"><i class="fas fa-shopping-basket" aria-hidden="true"></i></a></li>

                                                            <form id="remove_wishlist_22" action="https://unifood.websolutionus.com/remove-to-wishlist/22" method="POST">
                                                                <input type="hidden" name="_token" value="9DoTNtSQlXDGrW2LXuvr79771ZJbicckzkn9F9fo" autocomplete="off"> <input type="hidden" name="_method" value="DELETE"> </form>

                                                            <li><a href="javascript:;" onclick="remove_wishlist(22)"><i class="fal fa-heart" aria-hidden="true"></i></a></li>

                                                            <li><a href="https://unifood.websolutionus.com/product/truffle-fries"><i class="far fa-eye" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
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
                                                            <a href="javascript:void(0);" class="" id="Password-toggle">
                                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="wsus__comment_imput_single input_group" id="Password-toggle3">
                                                            <label>New Password</label>
                                                            <input type="password" placeholder="New Password" name="new_password">
                                                            <a href="javascript:void(0);" class="" id="Password-toggle">
                                                                <i class="fal fa-eye-slash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="wsus__comment_imput_single input_group" id="Password-toggle1">
                                                            <label>Confirm Password</label>
                                                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                                                            <a href="javascript:void(0);" class="" id="Password-toggle">
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
@endpush
