<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 12/14/21
 * Time: 11:25 PM
 */

class Dashboard extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
        $this->model("Mail_model");
    }

    function index() {
        $this->model->Accounts_model->is_logged_in();
        $this->smarty->display("dashboard/dashboard.tpl");
    }

    function profile() {
        $this->model->Accounts_model->is_logged_in();

        $user = $this->session->data->user;
        $this->smarty->assign("profile", $this->model->Accounts_model->get_user_profile($user));
        $this->smarty->display("dashboard/profile.tpl");
    }

    function watchlist() {
        $this->model->Accounts_model->is_logged_in();

        $this->smarty->display("dashboard/watchlist.tpl");
    }

    function applications() {
        $this->model->Accounts_model->is_logged_in();

        $this->smarty->display("dashboard/applications.tpl");
    }

}