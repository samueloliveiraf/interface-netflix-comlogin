<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('https://netflix-firebase-70666-default-rtdb.firebaseio.com/login');

$database = $factory->createDatabase();

$login = $database->getReference('login')->getSnapshot();

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="css/style-login.css">

        <title>Login NETFLIX</title>

    </head>

    <body>

        <div class="container" class="column">
            <div class="login-container" class="column">

                <form action="login.php" method="POST" class="form-per">

                    <input type="text" id="login" name="user" placeholder="usuário">

                    <input type="password" id="password" name="password" placeholder="senha">

                    <input type="submit" name="login_firebase">

                    <?php

                    if (isset($_POST['login_firebase'])) {

                        $loginSucess = $login->getValue()[0];

                        $user = $_POST['user'];
                        $password = $_POST['password'];

                        if ($user === $loginSucess['user']) {

                            if (md5($password) === $loginSucess['password']) {
                                setcookie("loginToken", $user, time() + 7200);
                                header("Location: index.php");
                                exit;
                            } else
                                setcookie("loginToken", $user); unset($_COOKIE['loginToken']);
                                echo "Senha inválida";   
                        } else {

                            echo "Usuário inválido";
                            
                        }
                    }

                    ?>

                </form>

            </div>

        </div>

    </body>

</html>