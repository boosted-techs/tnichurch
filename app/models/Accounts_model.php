<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 12/14/21
 * Time: 5:30 PM
 */

class Accounts_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    function auth_user() {
//        print_r($_POST);
        //echo $this->password_hash("!tnionline@2020");
        $this->db->where("email", trim($this->inputs->post("email")));
        $this->db->where("password", $this->password_hash($this->inputs->post("password")));
        return $this->db->getOne("users", "id, names, email");
    }

    function is_logged_in() {
        if (empty($this->session->data("user")))
            $this->redirect("/wp-admin");
        return true;
    }

}