<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'id_restaurant', 'theme', 'message'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

<<<<<<< HEAD
    public function getMessagesFromUser($email) {
        $this->select(['id_user', 'id_restaurant', 'theme', 'message']);
        $this->join('users','users.id = id_user');
        $this->orWhere('email',$email)->orWhere('username',$email);
        return $this->findAll();
    }

    public function getMessages($email) {
        $this->select(['count(message) as total']);
        $this->join('users','users.id = id_user');
        $this->orWhere('users.email',$email)->orWhere('users.username',$email);
        return $this->findAll();
    }


=======

    public function create($id_user, $theme, $message) {

    }
>>>>>>> 658f9b042c6d1de6115dfa198c7c033023bc9401
}


