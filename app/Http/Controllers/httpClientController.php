<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class httpClientController extends Controller
{
    //
    function list(){
        $response = Http::get("https://jsonplaceholder.typicode.com/posts");
        return $response->json();
    }
    function detail($id){
        $response = Http::get("https://jsonplaceholder.typicode.com/posts/{$id}");
        return $response->json();
    }
    // post , put, delete
}
