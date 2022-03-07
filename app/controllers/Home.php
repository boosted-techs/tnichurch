<?php
/**
 * Created by PhpStorm.
 * User: welcome
 * Date: 10/4/21
 * Time: 1:32 PM
 */

class Home extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model("Accounts_model");
    }

    function index() {
        $this->smarty->display("website/home.tpl");
    }

    function about() {
        $this->smarty->display("website/about-us.tpl");
    }

    function blog() {
        $this->smarty->display("website/blog.tpl");
    }

    function contact() {
        $this->smarty->display("website/contact-us.tpl");
    }

   function events() {
       $this->smarty->display("website/events.tpl");
   }

   function sermons() {
       $this->smarty->display("website/sermons.tpl");
   }

   function shop() {
       $this->smarty->display("website/shop.tpl");
   }



    function contact_us() {
        $message = "Hello <b>" . $this->inputs->post['names'] .", your message has been received. We shall get in touch as soon as possible.</b>";

        $this->model->Mail_model->send_mail($this->inputs->post['email'], $message, "Contact us");
    }

}