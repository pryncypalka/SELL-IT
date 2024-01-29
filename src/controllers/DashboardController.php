<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Offer.php';
require_once __DIR__ . '/../repository/OfferRepository.php';
require_once __DIR__ . '/../repository/TemplateRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/ItemRepository.php';
require_once __DIR__ . '/SessionController.php';
class DashboardController extends AppController
{
    const MAX_FILE_SIZE =  10 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];

    private $offerRepository;
    private $TemplateRepository;
    private $userRepository;
    private $ItemRepository;

    private $userId;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->offerRepository = new OfferRepository();
        $this->TemplateRepository = new TemplateRepository();
        $this->ItemRepository = new ItemRepository();
        $this->userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
    }

    public function dashboard()
    {

        if (!$this->userId) {
            header("Location: /login");
            exit();
        }


        $user = $this->userRepository->getUserById($this->userId);
        $offers = $this->offerRepository->getOffers($this->userId);
        if ($user->getRoleId() == 1) {
            $templates = $this->TemplateRepository->getTemplates();
            $items = $this->ItemRepository->getItems();
            $this->render('dashboard', ['offers' => $offers, 'templates' => $templates, "user" => $user, 'items' => $items]);
        } else {
            $templates = $this->TemplateRepository->getTemplatesByUserId($this->userId);
            $this->render('dashboard', ['offers' => $offers, 'templates' => $templates, "user" => $user]);
        }

    }

    public function create()
    {


        if (!$this->userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($this->userId);
        $items = $this->ItemRepository->getItemsWithTemplates();
        $categories = $this->ItemRepository->getCategories();
        $this->render('create', ['items' => $items, 'categories' => $categories, 'user' => $user]);
    }

    public function account()
    {
        if (!$this->userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($this->userId);
        $this->render('account', ['user' => $user]);
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

    public function changeAvatar()
    {


        if (!$this->userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($this->userId);

        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            $newAvatarLink = $this->handleUploadedAvatar($_FILES['file'], $this->userId);

            $UserDetailsId = $this->userRepository->getUserDetailsIdByEmail($user->getEmail());
            $this->userRepository->changeAvatar($UserDetailsId, $newAvatarLink);
            $messages_avatar[] = 'File uploaded successfully';
            $user->setAvatarLink($newAvatarLink);
            $this->render('account', ['user' => $user, 'messages_avatar' => $messages_avatar]);
        } else {
            // Handle invalid file or other errors
            return $this->render('account', ['user' => $user, 'message' => 'Invalid file or other error']);
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

    private function handleUploadedAvatar($file, $userId)
    {
        if (!file_exists($file['tmp_name'])) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $avatarFileName = 'user' . $userId . '.' . $extension;

        // Adjust the path based on your project structure
        $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
        $uploadPath = $uploadDir . $avatarFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $avatarFileName;
        } else {
            return null;
        }
    }

    public function deleteTemplate()
    {
        if ($this->isPost()) {
            $templateId = $_POST['template_id'];


            $this->TemplateRepository->deleteTemplate($templateId);


            header("Location: /dashboard");
            exit();
        }
    }

    public function deleteOffer()
    {
        if ($this->isPost()) {
            $offerId = $_POST['offer_id'];


            $this->offerRepository->deleteOffer($offerId);

            header("Location: /dashboard");
            exit();
        }
    }





}



