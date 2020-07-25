<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessCard extends Controller
{
    //
    public function card_v1(){
        return view('backend.cards.card_v1');
    }

    public function card_v2(){
        return view('backend.cards.card_v2');
    }
}
