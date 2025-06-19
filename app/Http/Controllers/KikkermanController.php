<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KikkermanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Haal alle items op die de gebruiker heeft, en groepeer ze op categorie.
        $cosmetics = $user->items()->get()->groupBy('category');


        return view('kikkerman', [
            'cosmetics' => $cosmetics
        ]);
    }
}