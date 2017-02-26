<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model
{

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

    public function getTotalPage(): int
    {
        return $this->numberPage;
    }

    public function getAll(): array
    {
        $query = $this->db->get('restaurants');
        return $query->result();
    }

    public function get(int $id): array
    {
        $query = $this->db->get_where('restaurants', array('id' => $id));
        return $query->result();
    }

    public function get_limit(int $min, int $max): array
    {
        $query = $this->db->select('*')->from('restaurants')->order_by('name')->limit($min, $max)->get();
        return $query->result();
    }

    public function getPage(int $page): array
    {
        $pageActuelle = $page;
        $premiereEntree = ($pageActuelle - 1) * $this->messagesParPage; // On calcul la première entrée à lire
        return $this->get_limit($this->messagesParPage, $premiereEntree);
    }

    public function create(): array
    {
        if (empty($_POST['name']) || empty($_POST['city']) || empty($_POST['postal_code']) || empty($_POST['address']) || empty($_POST['description'])) {
            return ["error" => "il manque quelque chose"];
        } else {
            $data = [
                'name' => $_POST['name'],
                'city' => $_POST['city'],
                'postal_code' => $_POST['postal_code'],
                'latitude' => $_POST['latitude'] ?? null,
                'longitude' => $_POST['longitude'] ?? null,
                'address' => $_POST['address'],
                'description' => $_POST['description'],
                'image' => $_POST['image'] ?? null
            ];
            $this->db->insert('restaurants', $data);
            return ["success" => "ajout OK"];
        }
    }

    public function update(int $id): array
    {
        $errors = [];
        $warnings = [];
        $result=[];
        $data = array_filter([
            'name' => $_POST['name'] ?? null,
            'city' => $_POST['city'] ?? null,
            'postal_code' => $_POST['postal_code'] ?? null,
            'latitude' => $_POST['latitude'] ?? null,
            'longitude' => $_POST['longitude'] ?? null,
            'address' => $_POST['address'] ?? null,
            'description' => $_POST['description'] ?? null,
            'image' => $_POST['image'] ?? null
        ]);
        if (empty($data)) array_push($errors, "Il n'y a rien à mettre à jour !"); //pas de parametres valides
        elseif (isset($data["postal_code"]) && !preg_match('/^\d{5}$/', $data["postal_code"])) {
            $errors["postal_code"] = "le code postal doit être composé de 5 chiffres";
        }
        if (!empty(array_diff_key($_POST, $data))) {
            $warnings["unknown_parameters"] = array_diff_key($_POST, $data);
            $warnings["message"] = "Paramètres inconnus détectés !";
        }

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