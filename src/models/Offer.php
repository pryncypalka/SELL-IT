<?php

class Offer
{
    private $title;
    private $description;
    private $user_id;
    private $offerCreatedAt;
    private $price;
    private $photos = [];
    private $id;

    public function __construct($title, $description, $user_id, $offerCreatedAt, $price, $photos, $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->user_id = $user_id;
        $this->offerCreatedAt = $offerCreatedAt;
        $this->price = $price;
        $this->photos = $photos;
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getOfferCreatedAt()
    {
        if (empty($this->offerCreatedAt)) {
            return '';
        }
        $dateTime = new DateTime($this->offerCreatedAt);
        return $dateTime->format('Y-m-d');
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setOfferCreatedAt($offerCreatedAt)
    {
        $this->offerCreatedAt = $offerCreatedAt;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    public function getFirstPhoto()
    {
        if (!empty($this->photos)) {
            return $this->photos[0];
        } else {
            // Jeżeli tablica $photos jest pusta, zwróć ścieżkę do obrazu "image-not-found-icon.png"
            return 'image-not-found-icon.png';
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
}