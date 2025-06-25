<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Sign In | {{ config('app.name') }} - Admin Dashboard </title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="" />
     <meta name="author" content="Dexnovate" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->
     <link rel="shortcut icon" href="/backend/images/favicon.ico">

     <!-- Vendor css (Require in all Page) -->
     <link href="/backend/css/vendor.min.css" rel="stylesheet" type="text/css" />

     <!-- Icons css (Require in all Page) -->
     <link href="/backend/css/icons.min.css" rel="stylesheet" type="text/css" />

     <!-- App css (Require in all Page) -->
     <link href="/backend/css/app.min.css" rel="stylesheet" type="text/css" />

     <!-- Theme Config js (Require in all Page) -->
     <script src="/backend/js/config.js"></script>
</head>

<body class="h-100">
     <div class="d-flex flex-column h-100 p-3">
          <div class="d-flex flex-column flex-grow-1">
               <div class="row h-100">
                    <div class="col-xxl-7">
                         <div class="row justify-content-center h-100">
                              <div class="col-lg-6 py-lg-5">
                                   <div class="d-flex flex-column h-100 justify-content-center">
                                        <div class="auth-logo mb-4">
                                             <a href="/" class="logo-dark">
                                                  <img src="/assets/img/logo/logo.png" height="24" alt="logo dark">
                                             </a>

                                             <a href="/" class="logo-light">
                                                  <img src="/assets/img/logo/logo.png" height="24" alt="logo light">
                                             </a>
                                        </div>

                                        <h2 class="fw-bold fs-24">Sign In</h2>

                                        <p class="text-muted mt-1 mb-4">Enter your email address and password to access admin panel.</p>

                                        <div class="mb-5">
                                             <form action="{{ route('admin.login') }}" class="authentication-form" method="POST">
                                                @csrf
                                                  <div class="mb-3">
                                                       <label class="form-label" for="example-email">Email/Username</label>
                                                       <input type="email" id="example-email" name="field" class="form-control @error('field') is-invalid @enderror  bg-" placeholder="Enter your email / username">
                                                  </div>
                                                  <div class="mb-3">
                                                       {{-- <a href="auth-password.html" class="float-end text-muted text-unline-dashed ms-1">Reset password</a> --}}
                                                       <label class="form-label" for="example-password">Password</label>
                                                       <input type="password" id="example-password" name="password" class="form-control @error('password') is-invalid  @enderror" placeholder="Enter your password">
                                                  </div>
                                                  <div class="mb-3">
                                                       <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                                       </div>
                                                  </div>

                                                  <div class="mb-1 text-center d-grid">
                                                       <button class="btn btn-soft-primary" type="submit">Sign In</button>
                                                  </div>
                                             </form>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <div class="col-xxl-5 d-none d-xxl-flex">
                         <div class="card h-100 mb-0 overflow-hidden">
                              <div class="d-flex flex-column h-100">
                                   <img src="/backend/images/small/img-10.jpg" alt="" class="w-100 h-100">
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <!-- Vendor Javascript (Require in all Page) -->
     <script src="/backend/js/vendor.js"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="/backend/js/app.js"></script>

</body>

</html>