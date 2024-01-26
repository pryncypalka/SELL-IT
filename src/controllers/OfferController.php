<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Offer.php';
require_once __DIR__ . '/../repository/OfferRepository.php';
require_once __DIR__ . '/../repository/TemplateRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class OfferController extends AppController
{
    const MAX_FILE_SIZE = 10 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/offer_photos/';


    private $offerRepository;
    private $TemplateRepository;

    private $userRepository;
    private $userId;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->offerRepository = new OfferRepository();
        $this->TemplateRepository = new TemplateRepository();
        $this->userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    }

    public function offer()
    {
        if (!$this->userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($this->userId);

        $currentUrl = $_SERVER['REQUEST_URI'];

        $urlFragments = explode('/', $currentUrl);
        $offerKey = array_search('offer', $urlFragments);
        if ($offerKey !== false && isset($urlFragments[$offerKey + 1])) {

            $itemId = $urlFragments[$offerKey + 1];
            $template = $this->TemplateRepository->getPublicTemplatesByItemId($itemId);
        } else {
            $template = null;
        }
        $this->render('offer', [ 'user' => $user, 'template' => $template]);

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


