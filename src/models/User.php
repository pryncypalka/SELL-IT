<?php

class User {
    private $email;
    private $password;
    private $role_id;
    private $created_at;
    private $avatar_link;


    public function __construct($email, $password, $role, $created_at, $avatar_link)
    {
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role;
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

    public function getRoleId()
    {
        return $this->role_id;
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

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
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