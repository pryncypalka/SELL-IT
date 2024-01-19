<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';

class SecurityController extends AppController {

    public function login()
    {   
        $user = new User('jsnow@pk.edu.pl', 'admin', 'Johnny', 'Snow');

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email  || $user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['bad data']]);
        }



        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }
}