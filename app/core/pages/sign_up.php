<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    if(count($_POST)>0) {
        if(!empty($_POST)) {
            $error = [];


            if(empty($_POST['surname'])) {
                $error['surname'] = "Input a Surname";
            }

            if(empty($_POST['firstname'])) {
                $error['firstname'] = "Input a Firstname";
            }
            
            $query = "select * from users where email = :email limit 1";
            $email = query_one($query,['email'=>strtolower($_POST['email'])]);

            if(empty($_POST['email'])) {
                $error['email'] = "Input an Email";
            }elseif($email) {
                $error['email'] = "Email Exists";
            }elseif(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Enter a Valid Email";
            }

            if(empty($_POST['password'])) {
                $error['password'] = "Input a Password";
            }elseif(strlen($_POST['password']<10)) {
                $error['password'] = "Password must be Greater than 10 characters";
            }elseif($_POST['password']!==$_POST['confirm_password']) {
                $error['password'] = "Passwords dont match";
            }

            if(empty($error)) {
                $arr = [];
                $arr['surname'] = strtolower($_POST['surname']);
                $arr['firstname'] = strtolower($_POST['firstname']);
                $arr['email'] = strtolower($_POST['email']);
                $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $arr['userid'] = rand(0000000000,9999999999);
                $arr['date'] = date("Y-m-d H:i:s");
                
                
                $query ="insert into users(surname,firstname,email,password,date,userid) values(:surname,:firstname,:email,:password,:date,:userid)";
                $result[0] = query_one($query,$arr);

                $mail = new PHPMailer(true);

                if($result) {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'abodunrinoluwatomiwo@gmail.com';
                    $mail->Password = 'gsnx oklb lfwh rvtr';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
            
                    $mail->setFrom('abodunrinoluwatomiwo@gmail.com');
                    
                    $mail->addAddress($arr['email']);
            
                    $mail->isHTML(true);
            
                    $mail->Subject = 'Welcome to this platform';
                    $mail->Body = "Dear " . $arr['firstname'] . " " . $arr['surname'] . ",<br><br>Welcome to this platform! We are excited to have you on board.";
            
                    $mail->send();
                }


                redirect("sign_in");
            }

        }
    }
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title><?=WEBTITLE?> - Signup page</title>    

    

<link href="<?=ASSETS?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?=ASSETS?>css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin w-100 m-auto">
  <form method="post">
    <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

    <?php if(!empty($error['surname'])):?>
        <div class="alert alert-danger"><?=$error['surname']?></div>
    <?php endif;?>

    <div class="form-floating">
      <input type="text" name="surname" value="<?=former_value('surname')?>" class="form-control" id="floatingInput" placeholder="Surname">
      <label>Surname</label>
    </div>
    <br>

    <?php if(!empty($error['firstname'])):?>
        <div class="alert alert-danger"><?=$error['firstname']?></div>
    <?php endif;?>

    <div class="form-floating">
      <input type="text" name="firstname" value="<?=former_value('firstname')?>" class="form-control" placeholder="Firstname">
      <label>firstname</label>
    </div>
    <br>

    <?php if(!empty($error['email'])):?>
    <div class="alert alert-danger"><?=$error['email']?></div>
    <?php endif;?>

    <div class="form-floating">
      <input type="email" name="email" value="<?=former_value('email')?>" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <br>

    <?php if(!empty($error['password'])):?>
    <div class="alert alert-danger"><?=$error['password']?></div>
    <?php endif;?>

    <div class="form-floating">
      <input type="password" name="password" value="<?=former_value('password')?>" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <br>

    <div class="form-floating">
      <input type="password" name="confirm_password" value="<?=former_value('confirm_password')?>" class="form-control" id="floatingPassword" placeholder="Confirm Password">
      <label for="floatingPassword">Confirm Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" name="send" type="submit">Sign Up</button>
    <p class="mt-3">Already have an account? <a href="<?=ROOT?>sign_in">Sign in</a></p>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
  </form>
</main>


    
  </body>
</html>
