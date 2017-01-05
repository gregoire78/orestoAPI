<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){
        $query = $this->db->get('restaurants');
        return $query->result();
    }

}