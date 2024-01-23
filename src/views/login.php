<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log in</title>
    <link rel="stylesheet" href="../../public/css/login.css">
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
            <img class="logo" src="../../public/assets/logo.png" alt="Logo">
            <div class="textLogo">SELL-IT</div>
        </nav>
        <div class="content">
            <form class=" form_login" action="login" method="POST">
                <div class="text1">Log in</div>
                <div class="text2">Enter your details below</div>
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <div class = field_name>Your Email</div>
                <div class="input_field">
                    <input type="text" name="email" >
                </div>
                <div class = field_name>Password</div>
                <div class="input_field">
                    <input type="password" name="password" >
                </div>
                <div class = field_name>Forget password?</div>
                <button class="log_in_button" type="submit">Log in</button>
                <div class = field_name>Don't have an account?</div>
                <a class="signup_link" href="/signup">Sign up</a>
                
            </form>

            

            <div class="picture_box">
                    <img class="picture" src="../../public/assets/Login_image.svg" alt="image">
            </div>
        </div>
    </div>

</body>
</html>