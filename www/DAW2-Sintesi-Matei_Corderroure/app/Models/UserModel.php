<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;
use Myth\Auth\Password;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = User::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'email', 'username', 'name', 'img_profile', 'surname', 'city', 'street', 'postal_code', 'phone', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterInsert = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     *
     * @var int|null
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     *
     * @param string      $email
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     *
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Sets the group to assign any users created.
     *
     * @param string $groupName
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup)) {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }

    /**
     * It returns all the users from the database
     * 
     * @return $this
     */
    public function getAllUsers()
    {
        return $this->findAll();
    }

    /**
     * It returns the user that has that email or username
     * 
     * @return $this
     */
    public function getUserByMailOrUsername($email)
    {
        return $this->orWhere('email', $email)->orWhere('username', $email)->first();
    }

    /**
     * It returns the user that has that id
     * 
     * @return $this
     */
    public function getUserByID($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Deletes the user
     * 
     * @return $this
     */
    public function deleteUser($id)
    {
        $file = $this->select(['img_profile'])->where('id', $id)->first();

        if (!empty($file->img_profile)) {
            unlink(WRITEPATH . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "img_profile" . DIRECTORY_SEPARATOR . $file->img_profile);
        }

        return $this->delete($id);
    }

    public function updateUser($id, $data, $file)
    {

        if ($file != null) {
            $oldfile = $this->select(['img_profile'])->where('id', $id)->first();
            if (empty($oldfile->img_profile)) {
                $data['img_profile'] = $file;
            } else {
                unlink(WRITEPATH . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . "img_profile" . DIRECTORY_SEPARATOR . $oldfile->img_profile);
                $data['img_profile'] = $file;
            }
        }

        $this->update($id, $data);

        return $data;
    }

    public function changePassword($newPassword, $id)
    {

        $data = [
            'password_hash' => Password::hash($newPassword),
        ];

        $this->update($id, $data);
    }

    /**
     * getByTitleOrText
     * $search
     */
    public function userSearch($search, $order, $act)
    {
        if ($order == "")
            return $this->select(['id', 'username', 'name', 'surname'])
                ->orLike('username', $search, 'both', true)->orLike('name', $search, 'both', true)->orLike('surname', $search, 'both', true);
        else if ($act == "") {
            return $this->select(['id', 'username', 'name', 'surname'])
                ->orLike('username', $search, 'both', true)
                ->orLike('name', $search, 'both', true)
                ->orLike('surname', $search, 'both', true)
                ->orderBy($order, "DESC");
        } else if ($act == "a") {
            return $this->select(['id', 'username', 'name', 'surname'])
                ->orLike('username', $search, 'both', true)
                ->orLike('name', $search, 'both', true)
                ->orLike('surname', $search, 'both', true)->orderBy($order, "ASC");
        }
    }

    /**
     * getAllPaged
     * $nElements
     */
    public function userListPager($nElements, $order, $act)
    {
        if ($order == "")
            return $this->select(['id', 'username', 'name', 'surname'])->paginate($nElements);
        else if ($act == "") {
            return $this->select(['id', 'username', 'name', 'surname'])->orderBy($order, "DESC")->paginate($nElements);
        } else if ($act == "a") {
            return $this->select(['id', 'username', 'name', 'surname'])->orderBy($order, "ASC")->paginate($nElements);
        }
    }

    /**
     * getByTitleOrText
     * $search
     */
    public function roleSearch($search, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->orLike('auth_groups.name', $search, 'both', true)->orLike('auth_groups.description', $search, 'both', true);
        else if ($act == "") {
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')
                ->orLike('auth_groups.name', $search, 'both', true)
                ->orLike('auth_groups.description', $search, 'both', true)->orderBy("auth_groups." . $order, "DESC");
        } else if ($act == "a") {
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')
                ->orLike('auth_groups.name', $search, 'both', true)
                ->orLike('auth_groups.description', $search, 'both', true)->orderBy("auth_groups." . $order, "ASC");
        }
    }

    /**
     * getAllPaged
     * $nElements
     */
    public function roleListPager($nElements, $order, $act)
    {
        if ($order == "")
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->paginate($nElements);
        else if ($act == "") {
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->orderBy("auth_groups." . $order, "DESC")->paginate($nElements);
        } else if ($act == "a") {
            return $this->select('*')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
                ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->paginate($nElements);
        }
    }

    public function getMissingRoles($id)
    {
        return $this->select('auth_groups.id, auth_groups.name')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
            ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->where('users.id !=' . $id)->findAll();
    }

    public function getRoles($id)
    {
        return $this->select('auth_groups.id, auth_groups.name')->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'right')
            ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id', 'right')->where('users.id',  $id)->findAll();
    }
}
