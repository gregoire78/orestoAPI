<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model {

    private $name;
    private $city;
    private $postal_code;
    private $latitude;
    private $longitude;
    private $address;
    private $description;
    private $image;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(){
        $query = $this->db->get('restaurants');
        return $query->result();
    }

    public function create(){
        if (empty($_POST['name']) || empty($_POST['city']) || empty($_POST['postal_code']) || empty($_POST['address']) || empty($_POST['description'])){
            return ["error"=>"il manque quelquechose"];
        } else {
            $data = [
                'name' => $_POST['name'],
                'city' => $_POST['city'],
                'postal_code' => $_POST['postal_code'],
                'latitude' => empty($_POST['latitude']) ? null : $_POST['latitude'],
                'longitude' => empty($_POST['longitude']) ? null : $_POST['longitude'],
                'address' => $_POST['address'],
                'description' => $_POST['description'],
                'image' => empty($_POST['image']) ? null : $_POST['image']
            ];
            $this->db->insert('restaurants', $data);
            return ["success"=>"ajout OK"];
        }
    }

}