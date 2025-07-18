<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole('Teacher')) {
            return redirect()->route('admin.teacherdashboard');
        } elseif ($user->hasRole('Student')) {
            return redirect()->route('admin.studentDashboard');
        } elseif ($user->hasRole('Admin')) {
            return redirect()->route('admin.admindashboard');
        }
        // Default fallback
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function apilogin(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validateUser->errors()->all()
            ], 404);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Login Successfully',
                'token' => $authUser->createToken('api Token')->plainTextToken,
                'token_type' => 'bearer',
                'user' => $authUser,
                'role' => $authUser->getRoleNames()->first() ?? null,

            ], 200);
        }
        
        else{
            return response()->json([
                'status' => false,
                'message' => 'Email and password not matched.',
                'errors' => $validateUser->errors()->all()
            ],401);
        }

    }

    public function apilogout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' =>true,
            'message' => 'You logged out Successfully.',
        ],200);
    }

}
