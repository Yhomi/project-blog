<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index(){
        $title="Welcome to Laravel !";
        return \view('pages.index',compact('title'));
    }

    public function about(){
        $title="About Us";
        return view('pages.about')->with('title',$title);
    }

    public function services(){
        $data= array('title'=>'Our Services',
             'services'=>['Web design', 'Web development','Database management','Web Integrator','Launch Your website']
    );
        return view('pages.services')->with($data);
    }
}
