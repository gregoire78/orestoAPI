<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends MY_Controller
{
    protected $key;

    function __construct()
    {
        parent::__construct();
        $this->load->model('restaurant_model', 'restaurants');
        $this->load->model('auth_model', 'auth');
    }

    public function isAuth()
    {
        if (!empty($this->input->get('key', TRUE))) {
            $this->key = $this->input->get('key', TRUE);
            if (($this->auth->getKey($this->key)) == 0) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function arrayMaker($restaurant)
    {
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
        return $this->getJson($data);
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
            return $this->getJson($data);
        }
    }

    public function get_restaurant_page($page)
    {
        if ($this->isAuth()) {
            $data["restaurants"] = [];
            $restaurants = $this->restaurants->getPage($page);
            if (empty($restaurants)) {
                return $this->output->set_status_header(404)->set_content_type('text/plain', 'utf-8')->set_output("Not Found")->get_output();
            } else {
                foreach ($restaurants as $restaurant) {
                    array_push($data["restaurants"], $this->arrayMaker($restaurant));
                }
                // page calculation
                $pre = ($page - 1) > 0 ? $page - 1 : null;
                $next = ($page + 1) <= ($this->restaurants->getTotalPage()) ? $page + 1 : null;
                $data['page'] = ["pre" => $pre, "next" => $next, "total" => $this->restaurants->getTotalPage(), "current" => intval($page)];
                return $this->getJson($data);
            }
        }
        return $this->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Not Auth")->get_output();
    }
}
