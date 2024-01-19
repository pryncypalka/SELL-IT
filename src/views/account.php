<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/account.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="avatar-form">
    <h1>UPLOAD</h1>
    <form action="addImage" method="POST" ENCTYPE="multipart/form-data">
        <div class="messages">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
        <input name="title" type="text" placeholder="title">
        <textarea name="description" rows=5 placeholder="description"></textarea>

        <input type="file" name="file"/><br/>
        <button type="submit">send</button>
    </form>
    <section class="avatars">
        <div id="avatar-1">
            <img src="public/uploads/<?= $avatar->getImage() ?>">
            <div>
                <h2><?= $avatar->getTitle() ?></h2>
                <p><?= $avatar->getDescription() ?></p>
                <div class="social-section">
                    <i class="fas fa-heart"> 600</i>
                    <i class="fas fa-minus-square"> 121</i>
                </div>
            </div>
        </div>
    </section>
</body>
</html>