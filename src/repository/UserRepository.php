<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users u 
            LEFT JOIN public.user_details ud ON u.id_user_details = ud.id_user_details 
            WHERE ud.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            return null;
        }

        return new User(
            $userData['email'],
            $userData['password_hashed'],
            $userData['id_role'],
            $userData['create_time'],
            $userData['id_user_details']

        );
    }

    public function addUser(User $user)
    {


        // Dodawanie szczegółów użytkownika
        $stmtDetails = $this->database->connect()->prepare('
            INSERT INTO public.user_details (photo_path, email)
            VALUES (?, ?)
        ');

        $stmtDetails->execute([
            null,
            $user->getEmail()
        ]);


        $userDetailsId = $this->getUserDetailsIdByEmail($user->getEmail());


        $stmtUser = $this->database->connect()->prepare('
            INSERT INTO public.users (password_hashed, create_time, id_user_details, id_role)
            VALUES (?, ?, ?, ?)
        ');

        $stmtUser->execute([
            $user->getPassword(),
            $user->getCreatedAt(),
            $userDetailsId,
            $user->getRoleId()
        ]);
    }

    public function getUserDetailsIdByEmail(string $email): ?int
    {

        $stmt = $this->database->connect()->prepare('
        SELECT id_user_details
FROM public.user_details
WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) {
            return null;
        }

        return $data['id_user_details'];
    }
}
