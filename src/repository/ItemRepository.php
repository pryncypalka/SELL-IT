<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Item.php';

class ItemRepository extends Repository
{
    public function getItems(): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT i.item_id, i.item_name, c.category_name, s.subcategory_name
FROM public.item i
JOIN public.item_sub isub ON i.item_id = isub.item_id
JOIN public.subcategories s ON isub.sub_id = s.subcategory_id
JOIN public.categories c ON s.category_id = c.category_id
        ');
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as $itemData) {
            $result[] = new Item(
                $itemData['item_id'],
                $itemData['item_name'],
                $itemData['category_name'],
                $itemData['subcategory_name']
            );
        }

        return $result;
    }

    public function getCategories(): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * FROM public.categories
        ');
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as $categoryData) {
            $result[] = $categoryData['category_name'];
        }

        return $result;
    }
    public function getItemsWithTemplates(): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT item_id, item_name, subcategory_name, category_name
        FROM public.public_templates_items
    ');
        $stmt->execute();
        $itemsWithTemplates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($itemsWithTemplates as $itemData) {
            $result[] = new Item(
                $itemData['item_id'],
                $itemData['item_name'],
                $itemData['category_name'],
                $itemData['subcategory_name']
            );
        }

        return $result;
    }

    public function getItemsByName(string $searchString): array
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
        SELECT item_id, item_name, subcategory_name, category_name
        FROM public.public_templates_items
        WHERE LOWER(item_name) LIKE :searchResult OR LOWER(subcategory_name) LIKE :searchResult OR LOWER(category_name) LIKE :searchResult
    ');
        $stmt->bindParam(':searchResult', $searchString, PDO::PARAM_STR);
        $stmt->execute();

//        $result = [];
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

//        foreach ($items as $itemData) {
//            $result[] = new Item(
//                $itemData['item_id'],
//                $itemData['item_name'],
//                $itemData['category_name'],
//                $itemData['subcategory_name']
//            );
//        }
//
//        return $result;
    }

}


