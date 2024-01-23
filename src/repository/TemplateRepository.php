<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Template.php';
class TemplateRepository extends Repository
{

    public function getTemplatesByUserId($userId): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * FROM templates WHERE user_id = :user_id;
        ');

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($templates as $templateData) {
        $result[] = new Template(
        $templateData['title'],
        $templateData['description'],
        $templateData['item_id'],
        $templateData['user_id'],
        $templateData['created_at']
        );
        }

        return $result;
    }

    public function getTemplates(): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * FROM public.templates
WHERE is_public = true');
        $stmt->execute();
        $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($templates as $templateData) {
        $result[] = new Template(
        $templateData['title'],
        $templateData['description'],
        $templateData['item_id'],
        $templateData['user_id'],
        $templateData['created_at'],
        $templateData['is_public']
        );
        }

        return $result;
    }

}
