<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    //

    public function create(): Response
    {
        return Inertia::render('Lead/Create');
    }


}
