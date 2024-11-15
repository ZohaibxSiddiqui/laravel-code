<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle user login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Debugging: Log request data
        \Log::info('Login Request Data:', $request->all());
        
        // or use dd() to see the request data immediately
        // dd($request->all());
        
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login successful',
                'user' => $user
            ], 200);
        }
    
        // Return error if authentication fails
        return response()->json(['errors' => ['email' => ['Invalid bkl']]], 401);
    }
    
}
