<?php

class Admin extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
    }

    function index(){
        $this->model->Accounts_model->is_logged_in();
        print_r($_SESSION);
        $this->smarty->display("admin/dashboard.tpl");
    }

    function login() {
        $this->smarty->display("admin/login.tpl");
    }

    function sign_in() {
        $data = $this->model->Accounts_model->auth_user();
        if (empty($data))
            $this->redirect("/wp-admin/?error=1&email=" . trim($this->inputs->post("email")));
        else {
            $this->session->set_user_data("user", $data['id']);
            $this->session->set_user_data("names", $data['names']);
            $this->session->set_user_data("mail", $data['email']);
            $this->redirect("/wp-admin/dashboard");
        }
    }

    function forgot_password() {

    }

    function logout() {
        $this->session->destroy();
        $this->redirect("/wp-admin");
    }

}