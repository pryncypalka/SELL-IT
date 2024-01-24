<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/SessionController.php';

class SecurityController extends AppController {

    private $userRepository;




    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);



        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password or email']]);
        }
        $session = new SessionController();
        $session->startSession($user->getId());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function signup()
    {
        if (!$this->isPost()) {
            return $this->render('signup');
        }
        $date = new DateTime();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['password2'];


        if ($password !== $confirmedPassword) {
            return $this->render('signup', ['messages' => ['Please provide proper password']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $user = new User($email, $hashedPassword, 2, $date->format('Y-m-d H:i:s'), null);
        if ($this->userRepository->getUserDetailsIdByEmail($user->getEmail()) != null) {
            return $this->render('signup', ['messages' => ['User with this email already exists']]);
        }
        $this->userRepository->addUser($user);


        return $this->render('signup', ['messages' => ['You\'ve been succesfully registrated!']]);
    }




}
