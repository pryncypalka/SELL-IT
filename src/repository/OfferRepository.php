<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Offer.php';

class OfferRepository extends Repository
{
    public function getOffer(int $offerId): ?Offer
    {
        $conn = $this->database->connect();

        $stmt = $conn->prepare('
            SELECT * FROM public.offers WHERE offer_id = :offer_id
        ');
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();

        $offerData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($offerData === false) {
            return null;
        }

        $photos = $this->getOfferPhotos($conn, $offerId);

        return new Offer(
            $offerData['title'],
            $offerData['description'],
            $offerData['user_id'],
            $offerData['created_at'],
            $offerData['price'],
            $photos,
            $offerData['offer_id']
        );
    }

    private function getOfferPhotos(PDO $conn, int $offerId): array
    {
        $stmt = $conn->prepare('
            SELECT * FROM public.photos WHERE offer_id = :offer_id
        ');
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();

        $photosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $photos = [];
        foreach ($photosData as $photoData) {
            $photos[] = $photoData['photo_path'];
        }

        return $photos;
    }

    public function addOffer(Offer $offer): void
    {

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
            INSERT INTO public.offers (title, description, user_id, created_at, price)
            VALUES (?, ?, ?, ?, ?)
        ');

        $price = $offer->getPrice() !== "" ? $offer->getPrice() : null;

        $stmt->execute([
            $offer->getTitle(),
            $offer->getDescription(),
            $offer->getUserId(),
            $offer->getOfferCreatedAt(),
            $price
        ]);

        $offerId = $conn->lastInsertId(); // Pobierz ostatnio wstawiony ID oferty


        $this->addOfferPhotos($conn, $offerId, $offer->getPhotos());
    }

    private function addOfferPhotos(PDO $conn, int $offerId, array $photos): void
    {
        $stmt = $conn->prepare('
            INSERT INTO public.photos (photo_path, offer_id)
            VALUES (?, ?)
        ');

        foreach ($photos as $photoPath) {
            $stmt->execute([$photoPath, $offerId]);
        }
    }


    public function getOffers(int $userId): array
    {
        $result = [];

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT * FROM public.offers
        WHERE user_id = :userId;
    ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($offers as $offerData) {
            $offerId = $offerData['offer_id'];
            $photos = $this->getOfferPhotos($conn, $offerId);

            $result[] = new Offer(
                $offerData['title'],
                $offerData['description'],
                $offerData['user_id'],
                $offerData['created_at'],
                $offerData['price'],
                $photos,
                $offerData['offer_id']
            );
        }

        return $result;
    }

    public function getOffersByTitle(string $searchString): array
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $conn = $this->database->connect();
        $stmt = $conn->prepare('
        SELECT o.*, op.photo_path AS first_photo
        FROM public.offers o
        LEFT JOIN (
            SELECT offer_id, MIN(photo_path) AS photo_path
            FROM public.photos
            GROUP BY offer_id
        ) op ON o.offer_id = op.offer_id
        WHERE LOWER(o.title) LIKE :searchResult OR LOWER(o.description) LIKE :searchResult
    ');
        $stmt->bindParam(':searchResult', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteOffer(int $offerId): void
    {
        $conn = $this->database->connect();
        $stmt = $conn->prepare('
            DELETE FROM public.offers WHERE offer_id = :offer_id
        ');
        $stmt->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $stmt->execute();
    }
}