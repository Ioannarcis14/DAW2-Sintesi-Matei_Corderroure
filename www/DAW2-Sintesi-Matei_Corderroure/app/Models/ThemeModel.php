<?php

namespace App\Models;

use CodeIgniter\Model;

class ThemeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'theme';
    protected $primaryKey       = 'name';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name'];

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



     /**
     * getByTitleOrText
     * $search
     */
    public function themeSearch($search, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->orLike('name', $search, 'both', true);
        else if ($act == "") {
            return $this->select(['*'])->
                orLike('name', $search, 'both', true)
                ->orderBy($order, "DESC");
        } else if ($act == "a") {
            return $this->select(['*'])->
            orLike('name', $search, 'both', true)
                ->orLike('auth_groups.description', $search, 'both', true)->orderBy($order, "ASC");
        }
    }

    /**
     * getAllPaged
     * $nElements
     */
    public function themeListPager($nElements, $order, $act)
    {
        if ($order == "")
            return $this->select(['*'])->paginate($nElements);
        else if ($act == "") {
            return $this->select(['*'])->orderBy($order, "DESC")->paginate($nElements);
        } else if ($act == "a") {
            return $this->select(['*'])->orderBy($order, "ASC")->paginate($nElements);
        }
    }
}
