<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create</title>
    <link rel="stylesheet" href="../../public/css/create.css">
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
        <div class="result_box">
            <div class="find_template_text">Find the appropriate template</div>
            <div class="search_field">
                <input  type="text" name="search_template" placeholder="Item name / category">
            </div>
            <div class="result_tiles_container">
                <?php foreach ($items as $item): ?>
                    <a href="/offer?item_id=<?= $item->getId(); ?>">
                        <div class="result_tile">
                            <div class="result_category"><?= $item->getCategoryName() . '/' . $item->getSubcategoryName() ?></div>
                            <div class="result_item_name"><?= $item->getName() ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="categories_box">
        <div class="categories_text">Categories</div>
            <div class="result_tiles_container">
                <?php foreach ($categories as $category): ?>
                    <div class="category_tile">
                        <div class="category_name"><?=$category?></div>
                    </div>
                <?php endforeach; ?>
            </div>
    </div>
    </div>
</body>
</html>