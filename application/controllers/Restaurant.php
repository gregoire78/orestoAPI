<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends MY_Controller {

    protected $config;

    function __construct(){
        parent::__construct();
        $this->load->model('restaurant_model', 'restaurants');
    }

	public function index(){
        $data["restaurants"] = [];

        foreach ($this->restaurants->getAll() as $restaurant){
            array_push($data["restaurants"],[
                "id" => $restaurant->id,
                "name" => $restaurant->name,
                "location" => [
                    "city" => $restaurant->city,
                    "address" => $restaurant->address,
                    "postal_code" => $restaurant->postal_code,
                    "longitude" => $restaurant->longitude,
                    "latitude" => $restaurant->latitude
                ],
                "description" => $restaurant->description,
                "image" => $restaurant->image,
                "dates" => $restaurant->date_register
            ]);
        }
        $this->getJson($data);
	}
}
