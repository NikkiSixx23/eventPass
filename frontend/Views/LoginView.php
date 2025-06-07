<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPass Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #d6f0ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .logo {
            margin-bottom: 20px;
            text-align: center;
        }

        .logo img {
            width: 200px;
            max-width: 80%;
            height: auto;
        }

        .container {
            background-color: navy;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: white;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 10px;
            border: none;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }

        .ou {
            color: white;
            margin: 15px 0;
        }

        label {
            color: white;
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
        }

        .cadastro {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .social-login img {
            width: 40px;
            cursor: pointer;
        }

        /* Responsividade extra para telas muito pequenas */
        @media (max-width: 400px) {
            .container {
                padding: 20px;
            }

            .btn {
                font-size: 14px;
            }

            input {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="EventPassLogo.png" alt="EventPass Logo">
    </div>

    <?php
    if (isset($_SESSION['msg'])) {
        echo ($_SESSION['msg'] == "Usuário cadastrado com sucesso!!") ?
            "<div class=\"alert alert-success text-center\">" . $_SESSION['msg'] . "</div>" :
            "<div class=\"alert alert-danger text-center\">" . $_SESSION['msg'] . "</div>";
        session_destroy();
    }
    ?>

    <form action="HomeView.php" method="POST">
        <div class="container">
            <h2>ENTRE AGORA</h2>
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Digite seu email" required>
            <label for="senha">Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required>
            <button class="btn">ENTRAR</button>
            <p class="ou">OU</p>
            <a href="RegisterView.php" class="cadastro">CADASTRE - SE</a>

            <!-- Login social opcional -->
            <!--
            <p class="ou">Acesso rápido com</p>
            <div class="social-login">
                <img src="https://logopng.com.br/logos/google-37.png" alt="Google Login">
                <img src="https://logopng.com.br/logos/facebook-13.png" alt="Facebook Login">
            </div>
            -->
        </div>
    </form>
</body>

</html>