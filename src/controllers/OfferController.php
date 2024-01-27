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

        if (isset($_GET['item_id'])) {
            $Id = $_GET['item_id'];
            $offer = $this->TemplateRepository->getPublicTemplatesByItemId($Id);
            $title = $offer->getTitle();
            $description = $offer->getDescription();
            return $this->render('offer', ['user' => $user, 'title' => $title, 'description' => $description]);
        } elseif (isset($_GET['offer_id'])) {
            $Id = $_GET['offer_id'];
            $offer = $this->offerRepository->getOffer($Id);
            $title = $offer->getTitle();
            $description = $offer->getDescription();
            $price = $offer->getPrice();
            $photos = $offer->getPhotos();
            return $this->render('offer', ['user' => $user, 'title' => $title, 'description' => $description, 'price' => $price, 'photos'=> $photos]);
        } elseif (isset($_GET['template_id'])) {
            $Id = $_GET['template_id'];
            $offer = $this->TemplateRepository->getTemplateById($Id);
            $title = $offer->getTitle();
            $description = $offer->getDescription();
            return $this->render('offer', ['user' => $user, 'title' => $title, 'description' => $description]);
        }
        return $this->render('offer', ['user' => $user]);
    }

    public function addOffer()
    {
        if (!$this->userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($this->userId);
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $currentTimestamp = time();
        $formattedDateTime = date('Y-m-d H:i:s', $currentTimestamp);

        if ($action == 'saveOffer') {

            $photos = $this->handleMultipleUploadedImage($_FILES['photo'], $this->userId);
            $Offer = new Offer($title, $description, $this->userId, $formattedDateTime, $price, $photos);

            $this->offerRepository->addOffer($Offer);
            $this->render('offer', ['user' => $user, 'messages' => ['Offer saved']]);

        } elseif ($action == 'saveAsTemplate') {
            $template = new Template($title, $description, null, $this->userId, $formattedDateTime, false);
            $this->TemplateRepository->addTemplatePrivate($template);
            $this->render('offer', ['user' => $user, 'messages' => ['Template saved']]);
        } else {
            $this->render('offer', ['user' => $user]);
        }
    }

    private function handleMultipleUploadedImage($files, $userId)
    {
        $uploadedPhotos = [];

        foreach ($files['tmp_name'] as $key => $tmpName) {
            if (is_uploaded_file($tmpName) && $this->validate($files, $key)) {
                $extension = pathinfo($files['name'][$key], PATHINFO_EXTENSION);
                $imageFileName = 'user' . $userId . '_' . time() . '_' . $key . '.' . $extension;

                // Adjust the path based on your project structure
                $uploadDir = __DIR__ . '/../../public/uploads/offer_photos/';
                $uploadPath = $uploadDir . $imageFileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $uploadedPhotos[] = $imageFileName;
                }
            }
        }

        return $uploadedPhotos;
    }


    private function validate(array $files, $key): bool
    {
        if (!isset($files['size'][$key]) || $files['size'][$key] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($files['type'][$key]) || !in_array($files['type'][$key], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }

        return true;
    }



}


