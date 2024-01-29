<!DOCTYPE html>
<html lang="en">
<head>
    <title>HomePage</title>
    <link rel="stylesheet" href="../../public/css/dashboard.css">
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script type="text/javascript" src="../../public/js/search.js" defer></script>
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
            <div id="add_new"></div>
                <a href="/offer" id="button_add_new">Add new Offer/Template</a>
            </div>
            <div class="info">
                <div class="templates_box">
                    <div class="your_templates">Your templates</div>
                    <div class="template_tiles_container">
                        <?php foreach ($templates as $template): ?>
                            <a href="/offer?template_id=<?= $template->getId(); ?>">
                                <div class="template_tile">
                                    <?php if (isset($items)): ?>
                                        <?php
                                        $itemId = $template->getItemId();
                                        $matchingItem = null;


                                        foreach ($items as $item) {
                                            if ($item->getId() == $itemId) {
                                                $matchingItem = $item;
                                                break;
                                            }
                                        }

                                        if ($matchingItem): ?>
                                            <div class="template_date"><?= $matchingItem->getName(); ?></div>
                                            <div class="template_date"><?= $matchingItem->getSubcategoryName(); ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="template_name"><?= $template->getTitle(); ?></div>
                                    <div class="template_date"><?= $template->getCreatedAt(); ?></div>
                                    <div class="template_first_line"><?= $template->getDescription(); ?></div>
                                    <form action="deleteTemplate" method="post">
                                        <input type="hidden" name="template_id" value="<?= $template->getId(); ?>">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this template?')">Delete</button>
                                    </form>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="offers_box">
                    <div class="your_offers">Your Offers</div>
                    <div class="search_field">
                        <input  type="text" name="search" placeholder="Find your offer">
                    </div>
                    <div class="offer_tiles_container">
                        <?php foreach ($offers as $offer): ?>
                        <a href="/offer?offer_id=<?= $offer->getId(); ?>">
                            <div class="offer_tile">
                                <img class="offer_image" src="../../public/uploads/offer_photos/<?= $offer->getFirstPhoto(); ?>" alt="offer_image">
                                <div class="offer_info">
                                    <div class="offer_name"><?= $offer->getTitle(); ?></div>
                                    <div class="offer_first_line"><?= $offer->getDescription(); ?></div>
                                    <div class="offer_price"><?= $offer->getPrice(); ?></div>
                                    <div class="offer_date"><?= $offer->getOfferCreatedAt(); ?></div>
                                    <form action="deleteOffer" method="post">
                                        <input type="hidden" name="offer_id" value="<?= $offer->getId(); ?>">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this offer?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>