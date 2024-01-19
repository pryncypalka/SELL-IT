<?php

class Template {
    private $title;
    private $description;
    private $itemName;
    private $userName;



    public function __construct($title, $description, $itemName, $userName)
    {
        $this->title = $title;
        $this->description = $description;
        $this->itemName = $itemName;
        $this->userName = $userName;
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

    public function getItemName()
    {
        return $this->itemName;
    }

    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
}