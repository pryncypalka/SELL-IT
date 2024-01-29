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
        $templateData['created_at'],
        $templateData['is_public'],
        $templateData['template_id']
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
        $templateData['is_public'],
        $templateData['template_id']
        );
        }

        return $result;
    }


    public function getTemplateById($templateId): Template
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * FROM templates WHERE template_id = :template_id;
        ');

        $stmt->bindParam(':template_id', $templateId, PDO::PARAM_INT);
        $stmt->execute();
        $templateData = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Template(
        $templateData['title'],
        $templateData['description'],
        $templateData['item_id'],
        $templateData['user_id'],
        $templateData['created_at'],
        $templateData['is_public'],
        $templateData['template_id']
        );
    }



    public function addTemplate(Template $template): void
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        INSERT INTO templates (item_id, user_id, title, description, created_at, is_public)
        VALUES (?, ?, ?, ?, ?, ?)
    ');



        $stmt->execute([
            $template->getItemId(),
            $template->getUserId(),
            $template->getTitle(),
            $template->getDescription(),
            $template->getCreatedAtWithTime(),
            $template->getIsPublic()
        ]);
    }
    public function getPublicTemplatesByItemId($itemId): Template
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * 
        FROM templates 
        WHERE item_id = :item_id 
            AND is_public = true
        LIMIT 1
    ');

        $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
        $stmt->execute();
        $templateData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($templateData)) {
            // Handle the case when no template is found
            // For example, throw an exception or return a default Template
        }

        $templateData = $templateData[0]; // Take the first (and only) row

        return new Template(
            $templateData['title'],
            $templateData['description'],
            $templateData['item_id'],
            $templateData['user_id'],
            $templateData['created_at']
        );
    }

    public function deleteTemplate($templateId): void
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        DELETE FROM templates WHERE template_id = :template_id;
        ');

        $stmt->bindParam(':template_id', $templateId, PDO::PARAM_INT);
        $stmt->execute();
    }

}
