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
    protected $allowedFields    = ['id_user', 'receiver', 'theme', 'message'];

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


    public function createMessage($id_user, $theme, $message) {

        $data = [
            'id_user' => $id_user,
            'receiver' => 0,
            'theme' => $theme,
            'message' => $message,
        ];
        $this->insert($data);
    }

    public function checkMessage($id_user, $id_receiver, $theme) {

        $message = $this->where('id_user',$id_user)->where('receiver', $id_receiver)->where('theme', $theme)->first();

        if(!empty($message)) {
            return true;
        } else {
            return false;
        }
    }
}
