<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Offer.php';
require_once __DIR__ . '/../repository/OfferRepository.php';
require_once __DIR__ . '/../repository/TemplateRepository.php';

class OfferController extends AppController
{
    const MAX_FILE_SIZE = 5 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $message = [];
    private $offerRepository;
    private $TemplateRepository;

    public function __construct()
    {
        parent::__construct();
        $this->offerRepository = new OfferRepository();
        $this->TemplateRepository = new TemplateRepository();
    }

    public function dashboard()
    {
        $userId = 22;

        $offers = $this->offerRepository->getOffers($userId);
        $templates = $this->TemplateRepository->getTemplatesByUserId($userId);

        $this->render('dashboard', ['offers' => $offers, 'templates' => $templates]);
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

            return $this->render('dashboard', [
                'messages' => $this->message,
                'offers' => $this->offerRepository->getOffers()
            ]);
        }

        return $this->render('offer', ['messages' => $this->message]);
    }

}


