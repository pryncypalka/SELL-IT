<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Template.php';

require_once __DIR__ . '/../repository/TemplateRepository.php';
require_once __DIR__ . '/../repository/ItemRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
class CreateController extends AppController
{

    private $TemplateRepository;
    private $ItemRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ItemRepository = new ItemRepository();
        $this->TemplateRepository = new TemplateRepository();

    }

    public function create()
    {
        $items = $this->ItemRepository->getItems();
        $templates = $this->TemplateRepository->getTemplates();
        $categories = $this->ItemRepository->getCategories();
        $this->render('create', ['items' => $items, 'templates' => $templates, 'categories' => $categories]);
    }
    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->offerRepository->getOffersByTitle($decoded['search']));
        }
    }
}



