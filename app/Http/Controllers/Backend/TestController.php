<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function GetContactData(){
        $query = ContactSubmission::latest()->get();
        return response()->json($query);
    }
}
