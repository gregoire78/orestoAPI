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
        $this->load->helper('filename');
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

    public function insert_restaurant()
    {
        if ($this->isAuth()) {
            $error_pre = "Veuillez remplir le champs: ";

            $config['upload_path'] = 'images/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100000000;
            $config['file_ext_tolower'] = true;
            $this->load->library('upload', $config);

            $errors = [];
            $warnings = [];
            $result = [];
            $data = array_filter([
                'name' => $_POST['name'] ?? null,
                'city' => $_POST['city'] ?? null,
                'postal_code' => $_POST['postal_code'] ?? null,
                'latitude' => $_POST['latitude'] ?? null,
                'longitude' => $_POST['longitude'] ?? null,
                'address' => $_POST['address'] ?? null,
                'description' => $_POST['description'] ?? null
            ]);
            $files = array_filter([
                'recfile' => $_FILES['recfile'] ?? null,
                'file' => $_FILES['file'] ?? null
            ]);
            // verifications
            /*if (empty($data)) $errors = "Les champs doivent être remplis"; //pas de parametres valides
            else {*/
            // name
            if (!isset($data['name'])) {
                $errors["name"] = $error_pre . "name";
            }
            // postal_code
            if (!isset($data["postal_code"])) {
                $errors["postal_code"] = $error_pre . "postal_code";
            } elseif (isset($data["postal_code"]) && !preg_match('/^\d{5}$/', $data["postal_code"])) {
                $errors["postal_code"] = "le code postal doit être composé de 5 chiffres";
            }
            // city
            if (!isset($data['city'])) {
                $errors["city"] = $error_pre . "city";
            }
            //address
            if (!isset($data['address'])) {
                $errors["address"] = $error_pre . "address";
            }
            // description
            if (!isset($data['description'])) {
                $errors['description'] = $error_pre . "description";
            }
            // champs inconnus
            if (!empty(array_diff_key($_POST, $data))) {
                $warnings["message"]["fields"] = "Champs inconnus détectés !";
                $warnings["unknown_fields"] = array_diff_key($_POST, $data);
            }
            //fichiers inconnus
            if (!empty(array_diff_key($_FILES, $files))) {
                $warnings["message"]["files"] = "Fichiers inconnus détectés !";
                $res_file_name = [];
                foreach (array_diff_key($_FILES, $files) as $k => $f) {
                    array_key_exists('name', $f) ? $res_file_name[$k] = $f['name'] : $res_file_name[$k] = $k;
                }
                $warnings["unknown_files"] = $res_file_name;
            }

            // upload
            if (!isset($files['recfile'])) {
                $errors['image'] = "Une image doit être envoyé";
            }
            if (empty($errors)) {
                $time = round(microtime(true) * 1000);
                $config['file_name'] = slug($data['name']) . '-' . $time . "-original";
                $this->upload->initialize($config);
                if ($this->upload->do_upload('recfile')) {
                    $data['image'] = $this->upload->data('file_name');
                    $config['file_name'] = slug($data['name']) . '-' . $time . "-cropped";
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('file')) $this->upload->display_errors('', '');
                    else $data['image'] = $this->upload->data('file_name');
                } else {
                    $errors['recfile'] = $this->upload->display_errors('', '');
                }
            }

            // retour
            if (!empty($errors)) {
                $result["errors"] = $errors;
            } else {
                // insert here
                if ($this->restaurants->create($data)) $result["success"] = "ajout OK";
            }
            if (!empty($warnings)) $result["warnings"] = $warnings;
            $r = ["results" => $result];
            $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($r))->get_output();
        } else $this->output->set_status_header(401)->set_content_type('text/plain', 'utf-8')->set_output("Not Auth")->get_output();
    }

    public function update_restaurant($id)
    {
        if ($this->isAuth()) {
            if ($this->restaurants->get($id))
                $this->output->set_status_header(200)->set_content_type('text/plain', 'utf-8')->set_output($this->getJson($this->restaurants->update($id)))->get_output();
            else $this->output->set_status_header(404)->set_content_type('text/plain', 'utf-8')->set_output("Not Found")->get_output();
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
