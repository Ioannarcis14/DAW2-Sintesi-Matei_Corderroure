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

    

    public function getMessagesFromUser($email) {
        $this->select(['id_user', 'receiver', 'theme', 'message']);
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

    public function createMessageAdmin($id_user, $receiver, $theme, $message) {
        $data = [
            'id_user' => $id_user,
            'receiver' => $receiver,
            'theme' => $theme,
            'message' => $message,
        ];
        $this->insert($data);
    }

    public function createMessage($id_user, $theme, $message) {

        $data = [
            'id_user' => $id_user,
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

    /**
     * getByTitleOrText
     * $search
     */
    public function messageSearch($search, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->where('receiver', null)->orLike('id_user', $search, 'both', true)
            ->orLike('theme', $search, 'both', true)
            ->orLike('message', $search, 'both', true);
        else if ($act == "") {
            return $this->select('*')->where('receiver', null)->orLike('id_user', $search, 'both', true)
            ->orLike('theme', $search, 'both', true)
            ->orLike('message', $search, 'both', true)
            ->orderBy($order, "DESC");
        } else if ($act == "a") {
            return $this->select('*')->where('receiver', null)->orLike('id_user', $search, 'both', true)
            ->orLike('theme', $search, 'both', true)
            ->orLike('message', $search, 'both', true)->orderBy($order, "ASC");
        }
    }

    /**
     * getAllPaged
     * $nElements
     */
    public function messageListPager($nElements, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->where('receiver', null)->paginate($nElements);
        else if ($act == "") {
            return $this->select('*')->where('receiver', null)->orderBy($order, "DESC")->paginate($nElements);
        } else if ($act == "a") {
            return $this->select('*')->where('receiver', null)->orderBy($order, "ASC")->paginate($nElements);
        }
    }



}


