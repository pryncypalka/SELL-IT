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

            // Sprawdź poprawność starego hasła
            if (!password_verify($oldPassword, $user->getPassword())) {
                $messages[] = 'Incorrect old password';
            }

            // Sprawdź, czy nowe hasła są identyczne
            if ($newPassword !== $newPasswordRepeat) {
                $messages[] = 'New passwords do not match';
            }

            // Jeśli nie ma żadnych błędów, zmień hasło
            if (empty($messages)) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userRepository->changePassword($userId, $hashedNewPassword);

                // Dodaj komunikat o udanej zmianie hasła
                $messages[] = 'Password has been changed successfully';

                // Aktualizuj również dane użytkownika po zmianie hasła
                $user = $this->userRepository->getUserById($userId);
            }
        }

        // Renderuj widok z odpowiednimi danymi i komunikatami
        $this->render('account', ['user' => $user, 'messages' => $messages]);
    }


}
