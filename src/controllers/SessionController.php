<?php

require_once 'AppController.php';

session_start();

class SessionController extends AppController
{
    public function startSession(int $id_user)
    {
        if (!isset($_SESSION['id_user'])) {
            $_SESSION['id_user'] = $id_user;
        }
    }

    public function checkSession(): bool
    {
        return isset($_SESSION['id_user']);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /login"); // Użyj pełnej ścieżki URL
        exit(); // Zakończ działanie skryptu po przekierowaniu
    }

    public function getIdUser(): ?int
    {
        return $_SESSION['id_user'] ?? null;
    }
}
?>
