<?php 
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model {

    protected $table = 'user';
    protected $primary_key = 'id';

    public function __construct() {
        parent::__construct();
    }
    
    /* ============================
       🔍 GET USER RECORDS
    ============================= */

    public function get_user_by_id($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function get_user_by_username($username) {
        return $this->db->table($this->table)
                        ->where('username', $username)
                        ->get();
    }

    public function get_user_by_email($email) {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get();
    }

    public function get_all_users() {
        return $this->db->table($this->table)->get_all();
    }

    public function has_admin() {
        $admin = $this->db->table('user')->where('role', 'admin')->get();
        return !empty($admin);
    }

    public function get_logged_in_user() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['user']['id'])) {
            return $this->get_user_by_id($_SESSION['user']['id']);
        }

        return null;
    }

    /* ============================
       📄 PAGINATION + SEARCH
    ============================= */

    public function page($q = '', $records_per_page = 10, $page = 1) 
    {
        $query = $this->db->table($this->table);

        if (!empty($q)) {
            $query->like('username', "%$q%")
                  ->or_like('email', "%$q%")
                  ->or_like('role', "%$q%");
        }

        // Clone for counting
        $countQuery = clone $query;

        $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];

        $data['records'] = $query->pagination($records_per_page, $page)->get_all();

        return $data;
    }

    /* ============================
       ➕ INSERT USER
    ============================= */

    public function insert_user($data) {
        return $this->db->table($this->table)->insert($data);
    }

    /* ============================
       ✏ UPDATE USER
    ============================= */

    public function update_user($id, $data) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    /* ============================
       ❌ DELETE USER
    ============================= */

    public function delete_user($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }

    /* ============================
       🔁 CHECK EMAIL / USERNAME (FIXED)
    ============================= */

    public function email_exists($email, $exclude_id = null) 
    {
        $query = $this->db->table($this->table)->where('email', $email);
        
        if ($exclude_id !== null) {
            $query->where('id !=', $exclude_id);
        }
        
        $result = $query->get();
        return !empty($result);
    }

    public function username_exists($username, $exclude_id = null) 
    {
        $query = $this->db->table($this->table)->where('username', $username);
        
        if ($exclude_id !== null) {
            $query->where('id !=', $exclude_id);
        }
        
        $result = $query->get();
        return !empty($result);
    }

    /* ============================
       📊 EXTRA UTILITIES
    ============================= */

    public function get_users_by_role($role) {
        return $this->db->table($this->table)
                        ->where('role', $role)
                        ->get_all();
    }

    public function count_users($role = null) {
        $query = $this->db->table($this->table);

        if ($role) {
            $query->where('role', $role);
        }

        return $query->select_count('*', 'count')
                     ->get()['count'];
    }

    public function get_recent_users($limit = 5) {
        return $this->db->table($this->table)
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get_all();
    }

    /* ============================
       🔐 CHECK PASSWORD EXISTS
       (FIXED FOR LAVALUST)
    ============================= */

    public function password_exists($password) {
        // LavaLust doesn't support from(), so use query()
        $allUsers = $this->db->query("SELECT password FROM user")->fetchAll();

        foreach ($allUsers as $user) {
            if (password_verify($password, $user['password'])) {
                return true;
            }
        }

        return false;
    }
}
