<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model
{

    private $name;
    private $city;
    private $postal_code;
    private $latitude;
    private $longitude;
    private $address;
    private $description;
    private $image;
    private $total;
    private $numberPage;
    private $messagesParPage;

    public function __construct()
    {
        parent::__construct();
        $this->total = $this->db->count_all('restaurants');
        $this->messagesParPage = 5;
        $this->numberPage = ceil($this->total / $this->messagesParPage);
    }

    public function getTotalPage()
    {
        return $this->numberPage;
    }

    public function getAll()
    {
        $query = $this->db->get('restaurants');
        return $query->result();
    }

    public function get($id)
    {
        $query = $this->db->get_where('restaurants', array('id' => $id));
        return $query->result();
    }

    public function get_limit($min, $max)
    {
        $query = $this->db->select('*')->from('restaurants')->order_by('name')->limit($min, $max)->get();
        return $query->result();
    }

    public function getPage($page)
    {
        $pageActuelle = $page;
        $premiereEntree = ($pageActuelle - 1) * $this->messagesParPage; // On calcul la première entrée à lire
        return $this->get_limit($this->messagesParPage, $premiereEntree);
    }

    public function create()
    {
        if (empty($_POST['name']) || empty($_POST['city']) || empty($_POST['postal_code']) || empty($_POST['address']) || empty($_POST['description'])) {
            return ["error" => "il manque quelque chose"];
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
            return ["success" => "ajout OK"];
        }
    }

    public function update($id)
    {
        $errors = [];
        $warnings = [];
        $result=[];
        $data = array_filter([
            'name' => empty($_POST['name']) ? null : $_POST['name'],
            'city' => empty($_POST['city']) ? null : $_POST['city'],
            'postal_code' => empty($_POST['postal_code']) ? null : $_POST['postal_code'],
            'latitude' => empty($_POST['latitude']) ? null : $_POST['latitude'],
            'longitude' => empty($_POST['longitude']) ? null : $_POST['longitude'],
            'address' => empty($_POST['address']) ? null : $_POST['address'],
            'description' => empty($_POST['description']) ? null : $_POST['description'],
            'image' => empty($_POST['image']) ? null : $_POST['image']
        ]);
        if (empty($data)) array_push($errors, "Il n'y a rien à mettre à jour !"); //pas de parametres valides
        elseif ($data["postal_code"] && !preg_match('/^\d{5}$/', $data["postal_code"])) array_push($errors, ["postal_code"=>"le code postal doit être composé de 5 chiffres"]);
        if (!empty(array_diff_key($_POST, $data))) array_push($warnings,"Paramètres inconnus détectés !", ["unknown_parameters" => array_diff_key($_POST, $data)]); //paramètres inconnues

        if (!empty($errors)) {
            $result["errors"]=$errors;
        } else {
            $this->db->where('id', $id);
            $this->db->update('restaurants', $data);
            $result["success"] = "modifications OK";
        }
        if (!empty($warnings)) $result["warnings"]=$warnings;
        return ["results"=>$result];
    }
}