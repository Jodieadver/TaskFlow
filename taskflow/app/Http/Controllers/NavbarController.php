<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class NavbarController extends Controller
{

    //logout 

    public function userLogout(Request $request)
{     
     
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();

    // return Inertia::location(route('home'));
    // return Inertia::render('Welcome');
    return Inertia::location(route('home'));

    
    // return redirect()->route('home')->with('success', 'Logout successfully.');
}

}
