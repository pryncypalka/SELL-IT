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

        $validationMessages = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validationMessages[] = 'Please provide a valid email address<br>';
        }

        if ($password !== $confirmedPassword) {
            $validationMessages[] = 'Please provide proper password<br>';
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $validationMessages[] = 'Password must be at least 8 characters long, and include lowercase, uppercase, and a number<br>';
        }

        if ($this->userRepository->getUserDetailsIdByEmail($email) !== null) {
            $validationMessages[] = 'User with this email already exists<br>';
        }

        if (!empty($validationMessages)) {
            return $this->render('signup', ['messages' => $validationMessages]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User($email, $hashedPassword, 2, $date->format('Y-m-d H:i:s'), null, null);
        $this->userRepository->addUser($user);

        return $this->render('signup', ['messages' => ['You\'ve been succesfully registrated!']]);
    }

    public function changePassword()
    {

        $userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($userId);

        $messages = [];

        if ($this->isPost()) {
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $newPasswordRepeat = $_POST['new_password_repeat'];


            if (!password_verify($oldPassword, $user->getPassword())) {
                $messages[] = 'Incorrect old password';
            }


            if ($newPassword !== $newPasswordRepeat) {
                $messages[] = 'New passwords do not match';
            }


            if (empty($messages)) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userRepository->changePassword($userId, $hashedNewPassword);


                $messages[] = 'Password has been changed successfully';


                $user = $this->userRepository->getUserById($userId);
            }
        }


        $this->render('account', ['user' => $user, 'messages' => $messages]);
    }


}
