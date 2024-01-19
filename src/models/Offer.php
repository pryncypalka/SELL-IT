<?php

class Offer
{
    private $template;
    private $createdAt;
    private $price;

    public function __construct($template, $createdAt, $price)
    {
        $this->template = $template;
        $this->createdAt = $createdAt;
        $this->price = $price;
    }

    public function getTemplate()
    {
        return $this->template;
    }


    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function setTemplate($template)
    {
        $this->template = $template;
    }


    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }


    public function setPrice($price)
    {
        $this->price = $price;
    }
}