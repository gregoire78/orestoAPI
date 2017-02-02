<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('restaurant_model', 'restaurants');
    }

    private function arrayMaker($restaurant){
        return [
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
        ];
    }

    public function index()
    {
        $data["restaurants"] = [];
        foreach ($this->restaurants->getAll() as $restaurant) {
            array_push($data["restaurants"], $this->arrayMaker($restaurant));
        }
        $this->getJson($data);
    }

    public function insert_restaurant()
    {
        $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($this->restaurants->create()))->get_output();
    }

    public function get_restaurant($id)
    {
        $data["restaurant"] = [];
        $restaurants = $this->restaurants->get($id);
        if (empty($restaurants)) {
            return $this->output->set_status_header(404)->set_content_type('text/plain', 'utf-8')->set_output("Not Found")->get_output();
        } else {
            $restaurant = $restaurants[0];
            array_push($data["restaurant"], $this->arrayMaker($restaurant));
            $this->getJson($data);
        }
        return 1;
    }

    public function get_restaurant_page($page)
    {
        $data["restaurants"] = [];
        $restaurants = $this->restaurants->getPage($page);
        if (empty($restaurants)) {
            return $this->output->set_status_header(404)->set_content_type('text/plain', 'utf-8')->set_output("Not Found")->get_output();
        } else {
            foreach ($restaurants as $restaurant) {
                array_push($data["restaurants"], $this->arrayMaker($restaurant));
            }
            // page calculation
            $pre = ($page-1) > 0 ? $page-1 : null;
            $next = ($page+1) <= ($this->restaurants->getTotalPage()) ? $page+1 : null;
            $data['page'] = ["pre" => $pre, "next" => $next , "total" =>  $this->restaurants->getTotalPage(), "now"=>intval($page)];
            $this->getJson($data);
        }
        return 1;
    }
}
