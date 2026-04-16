<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,cupcake,cyberpunk,forest,luxury'
        ]);
        session(['theme' => $request->theme]);
        return back();
    }
}
