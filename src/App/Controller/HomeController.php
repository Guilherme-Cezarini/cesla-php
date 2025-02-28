<?php
namespace App\Controller;

class HomeController extends Controller
{

    public function __construct() {  
       
    }

    public function index($request) {
        header('Location: /produtos');
        return;
    }


}