<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $config;
    protected $output;
    protected $input;

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->database();
        $this->config = new CI_Config();
        $this->output = new CI_Output();
        $this->input = new CI_Input();
    }
    protected function getJson($data){
        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->get_output();
    }
}