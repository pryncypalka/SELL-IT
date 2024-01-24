<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account</title>
    <link rel="stylesheet" href="../../public/css/account.css">
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
        <form action="change_avatar" method="post" enctype="multipart/form-data">
            <p class="Change_avatar">Change avatar</p>
            <img class="avatar_preview" src="../../public/assets/profile_empty.png" alt="avatar_preview">
            <input type="file" name="file"/><br/>
            <button type="submit">Send</button>
        </form>

        <form action="change_password" method="post">
            <p class="Change_password">Change password</p>
            <input class="input_field" type="password" name="old_password" placeholder="Old password">
            <input class="input_field" type="password" name="new_password" placeholder="New password">
            <input class="input_field" type="password" name="new_password_repeat" placeholder="Repeat new password">
            <button type="submit">Send</button>
        </form>
    </div>

    </div>
</body>
</html>