<?php

class Admin extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
        $this->model("Sermons_model");
        $this->model("Events_model");
        $this->model("Stats_model");
    }

    /**
     * @throws SmartyException
     */
    function index(){
        $this->model->Accounts_model->is_logged_in();
        $this->smarty->assign("stats", $this->model->Stats_model->get_stats());
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

    function sermons() {
        $this->model->Accounts_model->is_logged_in();
        $video = $this->inputs->post("watch");
        if ($video)
            $this->smarty->assign("sermon", $this->model->Sermons_model->get_sermons($video));
        $this->smarty->assign("sermons", $this->model->Sermons_model->get_sermons());
        $this->smarty->display("admin/sermons.tpl");
    }

    function forgot_password() {

    }

    function logout() {
        $this->session->destroy();
        $this->redirect("/wp-admin");
    }

    /**
     * @throws SmartyException
     */
    function blog() {
        $this->model->Accounts_model->is_logged_in();
        $this->smarty->assign("events", $this->model->Events_model->get_all_events(2));
        $this->smarty->display("admin/blog.tpl");
    }

    /**
     * @throws SmartyException
     */
    function events() {
        $this->model->Accounts_model->is_logged_in();
        $this->smarty->assign("events", $this->model->Events_model->get_all_events());
        $this->smarty->display("admin/events.tpl");
    }

    function add_event() {
        $this->model->Accounts_model->is_logged_in();
        $results = $this->model->Events_model->add_event();
        $this->redirect("/wp-admin/events?m=" . str_replace(" ", "%20", $results['message']));
    }

    function add_blog() {
        $this->model->Accounts_model->is_logged_in();
        $results = $this->model->Events_model->add_event(true);
        $this->redirect("/wp-admin/blog?m=" . str_replace(" ", "%20", $results['message']));

    }

    function add_sermon() {
        $this->model->Accounts_model->is_logged_in();
        $result = $this->model->Sermons_model->add_sermon();
        $this->redirect("/wp-admin/sermons?m=" . str_replace(" ", "%20", $result['message']));
    }

    function sermon_del($sermon) {
        $this->model->Accounts_model->is_logged_in();
        $result = $this->model->Sermons_model->delete_sermon($sermon);
        $this->redirect("/wp-admin/sermons?m=" . str_replace(" ", "%20", $result['message']));
    }

    function del_event($event) {
        $this->model->Accounts_model->is_logged_in();
        $result = $this->model->Events_model->delete_event($event);
        $page = $this->inputs->get("b") ? "blog" : "events";
        $this->redirect("/wp-admin/" . $page . "?m=" . str_replace(" ", "%20", $result['message']));

    }

}