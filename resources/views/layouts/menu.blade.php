<!-- Sidebar Logo -->
<div class="logo-box">
     <a href="/" class="logo-dark">
          <img src="{{ asset('upload/admin/'.Auth::guard('admin')->user()->image ) }}" class="logo-sm" alt="logo sm">
          <img src="{{ asset('upload/admin/'.Auth::guard('admin')->user()->image ) }}" class="logo-lg" alt="logo dark">
     </a>

     <a href="/" class="logo-light">
          <img src="{{ asset('upload/admin/'.Auth::guard('admin')->user()->image ) }}" class="logo-sm" alt="logo sm">
          <img src="{{ asset('upload/admin/'.Auth::guard('admin')->user()->image ) }}" class="logo-lg" alt="logo light">
     </a>
</div>

<!-- Menu Toggle Button (sm-hover) -->
<button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
     <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
</button>

<div class="scrollbar" data-simplebar>
     <ul class="navbar-nav" id="navbar-nav">

          <li class="nav-item">
               <a class="nav-link" href="{{ route('admin.home') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
               </a>
          </li>
          <li class="menu-title mt-2">Users</li>

          <li class="nav-item">
               <a class="nav-link" href="{{ route('admin.settings.index') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Profile </span>
               </a>
          </li>

          <li class="nav-item">
               <a  class="nav-link " href="{{ route('admin.customer.index') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Customers Lists</span>
               </a>
          </li>

          <li class="menu-title">General</li>

          <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarCategory" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarCategory">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Category </span>
               </a>
               <div class="collapse" id="sidebarCategory">
                    <ul class="nav sub-navbar-nav">
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.category.index') }}">List</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.category.create') }}">Create</a>
                         </li>
                    </ul>
               </div>
          </li>

          <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarProducts" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarProducts">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Products </span>
               </a>
               <div class="collapse" id="sidebarProducts">
                    <ul class="nav sub-navbar-nav">
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.product.index') }}">List</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.product.create') }}">Create</a>
                         </li>
                    </ul>
               </div>
          </li>
          <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarDelivery" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDelivery">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:box-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Delivery Area </span>
               </a>
               <div class="collapse" id="sidebarDelivery">
                    <ul class="nav sub-navbar-nav">

                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.delivery.area.index') }}">List</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.delivery.area.create') }}">Create</a>
                         </li>
                    </ul>
               </div>
          </li>
          <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarBlog" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBlog">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:box-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Blog </span>
               </a>
               <div class="collapse" id="sidebarBlog">
                    <ul class="nav sub-navbar-nav">

                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.post.category.index') }}">Categories</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.post.index') }}">BLogs</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="#">Comments</a>
                         </li>
                    </ul>
               </div>
          </li>
          <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarOrders" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOrders">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Orders </span>
               </a>
               <div class="collapse" id="sidebarOrders">
                    <ul class="nav sub-navbar-nav">

                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.order.list') }}">List</a>
                         </li>
                    </ul>
               </div>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="{{ route('admin.review.index') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Reviews </span>
               </a>
          </li>
          {{-- <li class="nav-item">
               <a class="nav-link menu-arrow" href="#sidebarPurchases" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarPurchases">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:card-send-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Manage site </span>
               </a>
               <div class="collapse" id="sidebarPurchases">
                    <ul class="nav sub-navbar-nav">
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.home.page') }}">Home Page</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.slider.index') }}">Slider</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.shipping.index') }}">Shipping</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.faq.index') }}">FAQ</a>
                         </li>
                         <li class="sub-nav-item">
                              <a class="sub-nav-link" href="{{ route('admin.post.index') }}">Post</a>
                         </li>
                    </ul>
               </div>
          </li> --}}
          {{-- <li class="nav-item">
               <a class="nav-link" href="{{ route('admin.settings.index') }}">
                    <span class="nav-icon">
                         <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Settings </span>
               </a>
          </li> --}}
     </ul>
</div>