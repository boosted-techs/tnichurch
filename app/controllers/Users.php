<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 12/14/21
 * Time: 5:28 PM
 */

class Users extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
        $this->model("Mail_model");
    }

    function register_personal_account() {
        $response = $this->model->Accounts_model->register_personal_account();
        if ($response['status'] == "success") {
            $message = "Hello <b>" . $response['names'] ."</b>";
            $message .= "<br/>You have account has been created with password: <b>" . $response['password']. "</b>";
            $message .= "<br/>Login your account to continue.";
            $message .= "<br/><a href='" . $this->server->server_name ."/login'>CLick here to login</a>";
            $message .= "<br/>-----------<br/>KCCA JOB MATCH @" . date("Y");
            $this->model->Mail_model->send_mail($response['email'], $message, "Account creation successful");
            $this->redirect("http://" . $this->server->server_name . "/login?email=" . $response['email'] . "&account_creation=success");
        }else
            $this->redirect("http://" . $this->server->server_name . "/create-account?account_type=seeker&error=" . $response['message']);
    }

    function register_org_account() {
        $response = $this->model->Accounts_model->register_org_account();
        if ($response['status'] == "success") {
            $message = "Hello <b>" . $response['names'] ."</b>";
            $message .= "<br/>You have account has been created with password: <b>" . $response['password']. "</b>";
            $message .= "<br/>Login your account to continue.";
            $message .= "<br/><a href='" . $this->server->server_name ."/login'>CLick here to login</a>";
            $message .= "<br/>-----------<br/>KCCA JOB MATCH @" . date("Y");
            $this->model->Mail_model->send_mail($response['email'], $message, "Account creation successful");
            $this->redirect("http://" . $this->server->server_name . "/login?email=" . $response['email'] . "&account_creation=success");
        }
        else
            $this->redirect("http://" . $this->server->server_name . "/create-account?account_type=org&error=" . $response['message']);
    }

    function auth() {
        $response = $this->model->Accounts_model->auth();
        if (isset($response['status'])) {
            $message = "Hello <b>" . $response['names'] ."</b>, you have logged in KCCA JOB MATCH system today on" . date("Y-m-d H:I:S");
            $this->model->Mail_model->send_mail($response['email'], $message, "Login successful");
            //print_r($response);dele
            $this->session->set_user_data("user", $response['id']);
            $this->session->set_user_data("role", $response['role']);
            $this->session->set_user_data("username", $response['username']);
            $this->session->set_user_data("names", $response['names']);
            $this->session->set_user_data("photo", $response['photo']);
            $this->redirect("http://" . $this->server->server_name . "/dashboard");
        }else
            $this->redirect("http://" . $this->server->server_name . "/login?email=" . $response['email'] . "&login=Access%20denied.");
    }

    function logout() {
        $this->session->destroy();
        $this->redirect("//" . $this->server->server_name);
    }

    function update_bio() {
        $this->model->Accounts_model->is_logged_in();
        $response = $this->model->Accounts_model->update_account_bio();
        $this->redirect("//" . $this->server->server_name . "/d/profile?update=" . $response['status'] . "&message=" . $response['message']);
    }

}