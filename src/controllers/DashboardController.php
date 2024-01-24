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
    const MAX_FILE_SIZE =  5 * 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    private $message = [];
    private $offerRepository;
    private $TemplateRepository;
    private $userRepository;
    private $ItemRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->offerRepository = new OfferRepository();
        $this->TemplateRepository = new TemplateRepository();
        $this->ItemRepository = new ItemRepository();
    }

    public function dashboard()
    {

        $userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }


        $user = $this->userRepository->getUserById($userId);
        $offers = $this->offerRepository->getOffers($userId);
        $templates = $this->TemplateRepository->getTemplatesByUserId($userId);

        $this->render('dashboard', ['offers' => $offers, 'templates' => $templates, "user" => $user]);
    }

    public function create()
    {
        $userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($userId);
        $items = $this->ItemRepository->getItems();
        $templates = $this->TemplateRepository->getTemplates();
        $categories = $this->ItemRepository->getCategories();
        $this->render('create', ['items' => $items, 'templates' => $templates, 'categories' => $categories, 'user' => $user]);
    }

    public function account()
    {
        $userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($userId);
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
        $userId = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }

        $user = $this->userRepository->getUserById($userId);

        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            $newAvatarLink = $this->handleUploadedAvatar($_FILES['file']);

            $UserDetailsId = $this->userRepository->getUserDetailsIdByEmail($user->getEmail());
            $this->userRepository->changeAvatar($UserDetailsId, $newAvatarLink);


            header("Location: /account");
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

    private function handleUploadedAvatar($file)
    {
        $uploadDir = dirname(__DIR__) . '/public/uploads/avatars/';
        $uploadPath = $uploadDir . basename($file['name']);


        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return '/uploads/avatars/' . basename($file['name']);
        } else {
            // Zwróć null lub odpowiednią wartość w przypadku niepowodzenia
            return null;
        }
    }

}



