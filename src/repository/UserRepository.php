<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
        SELECT u.user_id, u.email, u.password_hashed, u.id_role, u.create_time, ud.photo_path
        FROM public.users u
        LEFT JOIN public.user_details ud ON u.id_user_details = ud.id_user_details
        WHERE u.email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            return null;
        }

        return new User(
            $userData['user_id'],
            $userData['email'],
            $userData['password_hashed'],
            $userData['id_role'],
            $userData['create_time'],
            $userData['photo_path']
        );
    }

    public function addUser(User $user)
    {
        // Dodaj szczegóły użytkownika
        $stmt = $this->database->connect()->prepare('
        INSERT INTO public.user_details (photo_path)
        VALUES (?)
    ');

        $avatarLink = $user->getAvatarLink();
        $stmt->execute([
            ($avatarLink !== null) ? $avatarLink : null
        ]);

        // Pobierz ID dodanych szczegółów użytkownika
        $userDetailsId = $this->database->connect()->lastInsertId('user_details_id_user_details_seq');

        // Dodaj użytkownika
        $stmt = $this->database->connect()->prepare('
        INSERT INTO public.users (email, password_hashed, id_role, create_time, id_user_details)
        VALUES (?, ?, ?, ?, ?)
    ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getRoleId(),
            $user->getCreatedAt(),
            $userDetailsId
        ]);
    }
}