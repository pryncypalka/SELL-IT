<?php

class Template {
    protected $title;
    protected $description;
    protected $item_id;
    protected $user_id;

    private $createdAt;

    private $isPublic;



    public function __construct($title, $description, $item_id, $user_id, $createdAt, $isPublic = false)
    {
        $this->title = $title;
        $this->description = $description;
        $this->item_id = $item_id;
        $this->user_id = $user_id;
        $this->createdAt = $createdAt;
        $this->isPublic = $isPublic;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getItemId()
    {
        return $this->item_id;
    }

    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getCreatedAt()
    {
        if ($this->createdAt === null) {
            return null;
        }
        $dateTime = new DateTime($this->createdAt);
        return $dateTime->format('Y-m-d');
    }

    public function getCreatedAtWithTime()
    {
        return new $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }
}