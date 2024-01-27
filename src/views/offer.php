<!DOCTYPE html>
<html lang="en">
<head>
    <title>offer</title>
    <link rel="stylesheet" href="../../public/css/offer.css">
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700;900&display=swap"
          rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="base-container">
    <nav>
        <div class="logo_container">
            <img class="logo" src="../../public/assets/logo.png" alt="Logo">
            <div class="textLogo">SELL-IT</div>
        </div>
        <div class="Options">
            <a class="textHome" href="/dashboard">HOME</a>
            <a class="textCreate" href="/create">CREATE</a>
            <a class="textAccount" href="/account">ACCOUNT</a>
        </div>
        <img class="avatarImage" src="../../public/uploads/avatars/<?= $user->getAvatarLink(); ?>" alt="avatarImage">
    </nav>
    <div class="content">

        <form action="addOffer" method="post" enctype="multipart/form-data">
            <?php if (isset($messages) && is_array($messages)): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="messages"><?= $message; ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Title" required value="<?= isset($title) ? $title : '' ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="15" placeholder="Description" required><?= isset($description) ? $description : '' ?></textarea>

            <label for="price">Price:</label>
            <input class="offer_price" type="number" id="price" name="price" step="0.01" placeholder="Price"  value="<?= isset($price) ? $price : '' ?>">

            <label for="photos">Photos:</label>
            <input type="file" id="photo" name="photo[]" accept="image/*" multiple>

            <?php if (isset($photos) && is_array($photos)): ?>
                <div class="photo_container">
                    <?php foreach ($photos as $photo): ?>
                        <img class="photo_preview" src="../../public/uploads/offer_photos/<?= $photo ?>" alt="photo_preview">
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="photo_container">
                    <img class="photo_preview" src="../../public/uploads/offer_photos/image-not-found-icon.png" alt="photo_preview">
                </div>
            <?php endif; ?>

            <div class="button_container">
                <button type="submit" name="action" value="saveOffer">Save Offer</button>
                <button type="submit" name="action" value="saveAsTemplate" class="secondary">Save as Template (Title and Description only)</button>
            </div>
        </form>
    </div>

</div>
</body>
</html>