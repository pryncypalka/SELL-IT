<?php

require_once 'AppController.php';



class DefaultController extends AppController {

    public function login() {
       $this->render("login");
    }

    public function boarding() {
        $this->render("boarding");
    }

    public function account() {
        $this->render("account");
    }

    public function dashboard() {
        $this->render("dashboard");
    }

    public function offer() {
        $this->render("offer");
    }

    public function signup() {
        $this->render("signup");
    }

    public function create() {
        $this->render("create");
    }


}   
