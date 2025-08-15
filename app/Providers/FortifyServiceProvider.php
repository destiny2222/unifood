<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect('/login');
            }
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $this->mergeCarts();

                // Retrieve the intended URL from the session
                $intendedUrl = Session::get('url.intended');

                // Clear the intended URL from the session
                Session::forget('url.intended');

                // If an intended URL exists, redirect there
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }
                return redirect(RouteServiceProvider::HOME);
            }

            protected function mergeCarts()
            {
                if (!Auth::check()) {
                    return;
                }

                $user = Auth::user();
                $sessionCart = session()->get('cart', []);
                $dbCartItems = Cart::where('user_id', $user->id)->with('product')->get();

                foreach ($dbCartItems as $dbItem) {
                    if (!$dbItem->product) {
                        continue;
                    }

                    $productId = $dbItem->product_id;
                    $price = $dbItem->price ?? ($dbItem->product ? $dbItem->product->price : 0);

                    if (isset($sessionCart[$productId])) {
                        $sessionCart[$productId]['quantity'] += $dbItem->quantity;
                    } else {
                        $sessionCart[$productId] = [
                            'product_id' => $productId,
                            "title" => $dbItem->product->title,
                            "price" => $price,
                            "quantity" => $dbItem->quantity,
                            "size" => $dbItem->size ?? null,
                        ];
                    }
                }

                session()->put('cart', $sessionCart);
                Cart::where('user_id', $user->id)->delete();
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                // Retrieve the intended URL from the session
                $intendedUrl = Session::get('url.intended');

                // Clear the intended URL from the session
                Session::forget('url.intended');

                // If an intended URL exists, redirect there
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }

                // Default to dashboard if no intended URL
                return redirect(RouteServiceProvider::HOME);
            }
        });
        
    }

    public function login(): void {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse{
            public function toResponse($request)
            {
                // Retrieve the intended URL from the session
                $intendedUrl = Session::get('url.intended');

                // Clear the intended URL from the session
                Session::forget('url.intended');

                // If an intended URL exists, redirect there
                if ($intendedUrl) {
                    return redirect($intendedUrl);
                }
                return redirect(RouteServiceProvider::HOME);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });


        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });


        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.reset-password', ['request' => $request]);
        });


        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
    }
}
