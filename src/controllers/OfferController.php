<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Offer.php';
require_once __DIR__ . '/../repository/OfferRepository.php';

class OfferController extends AppController
{
    const MAX_FILE_SIZE =  5 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $offerRepository;

    public function __construct()
    {
        parent::__construct();
        $this->offerRepository = new OfferRepository();
    }

    public function offers()
    {
        $offers = $this->offerRepository->getOffers();
        $this->render('dashboard', ['offers' => $offers]);
    }

    public function addOffer()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            // TODO create new offer object and save it in database
            $offer = new Offer($_POST['title'], $_POST['description'], $_POST['user_id'], date('Y-m-d'), $_POST['price'], $_FILES['file']['name']);
            $this->offerRepository->addOffer($offer);

            return $this->render('offers', [
                'messages' => $this->message,
                'offers' => $this->offerRepository->getOffers()
            ]);
        }

        return $this->render('add-offer', ['messages' => $this->message]);
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

//    public function search()
//    {
//        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//
//        if ($contentType === "application/json") {
//            $content = trim(file_get_contents("php://input"));
//            $decoded = json_decode($content, true);
//
//            header('Content-type: application/json');
//            http_response_code(200);
//
//            echo json_encode($this->OfferRepository->getProjectByTitle($decoded['search']));
//        }
//    }


