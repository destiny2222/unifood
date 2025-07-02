<!DOCTYPE html>
<html lang="en">

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Admin Dashboard | {{ config('app.name')  }} </title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="An ecommerce platform offering a wide range of products with fast delivery, secure payment options, and 24/7 customer support.">
     <meta name="author" content="Dexnovate" />
     <meta name="keywords" content="ecommerce, online shopping, fast delivery, secure payment, customer support">
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->
     <link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo/favicon.png">
     <meta name="og:image" content="https://text.dexnovate.com/assets/img/logo/logo.png">
     <meta name="robots" content="index, follow">
     <meta name="googlebot" content="index, follow">
     <meta name="bingbot" content="index, follow">
     <!-- Vendor css (Require in all Page) -->
     <link href="/backend/css/vendor.min.css" rel="stylesheet" type="text/css" />

     <!-- Icons css (Require in all Page) -->
     <link href="/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
     <!-- App css (Require in all Page) -->
     <link href="/backend/css/app.min.css" rel="stylesheet" type="text/css" />

     <!-- Theme Config js (Require in all Page) -->
     <script  src="/backend/js/config.js"></script>
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <!-- ========== Topbar Start ========== -->
          @include('layouts.topbar')
          <!-- ========== Topbar End ========== -->

          <!-- ========== App Menu Start ========== -->
          <div class="main-nav">
               @include('layouts.menu')
          </div>
          <!-- ========== App Menu End ========== -->

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               @yield('content')
               <!-- End Container Fluid -->

               <!-- ========== Footer Start ========== -->
               <footer class="footer">
                   <div class="container-fluid">
                       <div class="row">
                           <div class="col-12 text-center">
                               <script>document.write(new Date().getFullYear())</script> &copy; {{ config('app.name') }}. Crafted by <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon> <a
                                   href="https://www.dexnovate.com/" class="fw-bold footer-text" target="_blank">Dexnovate</a>
                           </div>
                       </div>
                   </div>
               </footer>
               <!-- ========== Footer End ========== -->

          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <!-- Vendor Javascript (Require in all Page) -->
     <script src="/backend/js/vendor.js"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="/backend/js/app.js"></script>

     <!-- Vector Map Js -->
     <script src="/backend/vendor/jsvectormap/js/jsvectormap.min.js"></script>
     <script src="/backend/vendor/jsvectormap/maps/world-merc.js"></script>
     <script src="/backend/vendor/jsvectormap/maps/world.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
     <!-- Dashboard Js -->
     <script src="/backend/js/pages/dashboard.js"></script>
     @include('partials.message')
     <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
     <script>
          // Initialize CKEditor
          ClassicEditor
              .create(document.querySelector('textarea'))
              .then(editor => {
                  console.log('Editor was initialized', editor);
              })
              .catch(error => {
                  console.error('Error during initialization of the editor', error);
              });
      </script>
     {{-- <script>
          // Initialize CKEditor
          ClassicEditor
              .create(document.querySelector('#description'))
              .then(editor => {
                  console.log('Editor was initialized', editor);
              })
              .catch(error => {
                  console.error('Error during initialization of the editor', error);
              });
      </script> --}}
      @stack('scripts')
</body>
</html>