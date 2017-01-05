<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

    protected $config;

    function __construct(){
        parent::__construct();
        $this->load->model('home_model', 'home');
    }

	public function index(){
        $f = ["restaurants" => $this->home->getTest()];
        $this->getJson($f);
	}
}
