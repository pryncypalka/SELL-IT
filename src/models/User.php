<?php

class User {
    private $email;
    private $password;
    private $role;
    private $created_at;
    private $avatar_link;

    public function __construct($email, $password, $role, $created_at, $avatar_link)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->created_at = $created_at;
        $this->avatar_link = $avatar_link;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getAvatarLink()
    {
        return $this->avatar_link;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setAvatarLink($avatar_link)
    {
        $this->avatar_link = $avatar_link;
    }


}