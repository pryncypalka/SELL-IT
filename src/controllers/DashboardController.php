<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Offer.php';
require_once __DIR__ . '/../repository/OfferRepository.php';
require_once __DIR__ . '/../repository/TemplateRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class DashboardController extends AppController
{
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $offerRepository;
    private $TemplateRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->offerRepository = new OfferRepository();
        $this->TemplateRepository = new TemplateRepository();
    }

    public function dashboard()
    {
        $userId = 22;
        $userEmail = "email2@example.com";
        $user = $this->userRepository->getUser($userEmail);
        $offers = $this->offerRepository->getOffers($userId);
        $templates = $this->TemplateRepository->getTemplatesByUserId($userId);

        $this->render('dashboard', ['offers' => $offers, 'templates' => $templates, "user" => $user]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->offerRepository->getOfferByTitle($decoded['search']));
        }
    }
}



