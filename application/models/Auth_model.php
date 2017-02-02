<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getKey($key, $host){
        return $this->db->where('key', $key)->where('host', $host)->count_all_results('auth');
    }
}