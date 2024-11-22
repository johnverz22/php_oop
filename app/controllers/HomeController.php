<?php
namespace App\Controllers;

class HomeController extends Controller{
    public function __construct(){
        $this->layout = "main"; //set default layout for all actions
    }
    public function index(){
        
        $this->pageTitle = "Home";

        $data = "some data";
       
        $this->view("home/index", [
            "data" => $data,
        ]);
    }

    // Sample web page to use api request
    public function sampleApiRequest(){
        //$this->layout = 'simple';
        $this->pageTitle = "Sample Api Request From Web";
        $this->view('home/apiRequestSample');
    }
}