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
            "id" => (int)$restaurant->id,
            "name" => $restaurant->name,
            "location" => [
                "city" => $restaurant->city,
                "address" => $restaurant->address,
                "postal_code" => is_null($restaurant->postal_code) ? $restaurant->postal_code : (int)$restaurant->postal_code,
                "longitude" => is_null($restaurant->longitude) ? $restaurant->longitude : (int)$restaurant->longitude,
                "latitude" => is_null($restaurant->latitude) ? $restaurant->latitude : (int)$restaurant->latitude
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

    public function indexClone()
    {
        $data = [];
        foreach ($this->restaurants->getAll() as $restaurant) {
            array_push($data, $this->arrayMaker($restaurant));
        }
        return $this->getJson($data);
    }


    public function formatNomFichier($name_file)
    {
        $name_file = mb_strtolower($name_file, 'UTF-8');
        $name_file = str_replace(
            array('à', 'â', 'ä', 'á', 'ã', 'å', 'î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 'ù', 'û', 'ü', 'ú', 'é', 'è', 'ê', 'ë', 'ç', 'ÿ', 'ñ'),
            array('a', 'a', 'a', 'a', 'a', 'a', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'e', 'e', 'e', 'e', 'c', 'y', 'n'),
            $name_file
        );
        $name_file = preg_replace("/[^a-z0-9]/", "", $name_file);
        return $name_file;
    }
    public function insert_restaurant()
    {
        if ($this->isAuth()) {
            $config['upload_path'] = 'images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1000;
            $config['max_width'] = 10240;
            $config['max_height'] = 7680;
            $config['overwrite'] = true;
            $config['file_ext_tolower'] = true;
            $config['file_name'] = $this->formatNomFichier($_POST['name'])."-original";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('recfile')) {
                $error = array('error' => $this->upload->display_errors('', ''));
                $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($error))->get_output();
            } else {
                $config['file_name'] =  $this->formatNomFichier($_POST['name'])."-cropped";
                $this->upload->initialize($config, false);
                if (!$this->upload->do_upload('file')) {
                    $error = array('error' => $this->upload->display_errors('', ''));
                    $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($error))->get_output();
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($this->restaurants->create($this->upload->data('file_name'))))->get_output();
                }
            }
            //$this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($this->restaurants->create()))->get_output();
        } else $this->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Not Auth")->get_output();
    }

    public function update_restaurant($id)
    {
        if ($this->isAuth()) {
            $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($this->restaurants->update($id)))->get_output();
        } else $this->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Not Auth")->get_output();
    }

    public function get_restaurant($id)
    {
        if ($this->isAuth()) {
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
        return $this->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Not Auth")->get_output();
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
