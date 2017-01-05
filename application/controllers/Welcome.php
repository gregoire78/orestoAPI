<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct(){
        parent::__construct();
    }

    public function index(){
        return $this->output->set_status_header(404)->set_content_type('text/plain', 'utf-8')->set_output("Not Found")->get_output();
    }
}
