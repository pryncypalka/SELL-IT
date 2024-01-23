<?php

class Item
{
    private $id;
    private $name;
    private $category_name;
    private $subcategory_name;

    public function __construct($id, $name, $category_name, $subcategory_name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_name = $category_name;
        $this->subcategory_name = $subcategory_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getSubcategoryName()
    {
        return $this->subcategory_name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;
    }

    public function setSubcategoryName($subcategory_name)
    {
        $this->subcategory_name = $subcategory_name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    
}
