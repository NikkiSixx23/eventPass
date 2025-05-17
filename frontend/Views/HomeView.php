<?php
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';

session_start();

//testa se no login o usuario colocou email
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //faz um consulta no banco que retorna os dados do usuário específico
    $consulta = mysqli_query($conexao, "select id, cpf, nome, email, dataNascimento, senha, perfil from Usuarios where email = '$email'");
    $dados = mysqli_fetch_assoc($consulta);
    
    //instancia uma entidade usuário para conseguir realizar validação de senha e email
    $user = null;
    if ($dados != null) {
        $user = new Usuario($dados['cpf'], $dados['nome'], $dados['dataNascimento'], $dados['email'], $dados['senha']);
    }

    //realiza validação de email e senha para o usuário conseguir navegar no site
    if ($user != null && $user->validaUsuario($email, $senha)) {
        $_SESSION['user'] = $dados['id'];
    } else {
        $_SESSION['msg'] = "Usuário ou senha incorretos!!";
        header("Location: login.php");
        exit;
    }
} else if (!isset($_SESSION['user'])) {
    $_SESSION['msg'] = "Necessário email e senha para fazer login";
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPass</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #d8f0ff;
            padding: 15px 20px;
        }

        .logo img {
            height: 150px;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
            display: flex;
        }

        .search-bar input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px 0 0 20px;
            outline: none;
        }

        .search-bar button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-left: none;
            background: white;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
        }

        .login button {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: #007BFF;
        }

        .eventos-principais {
            background: navy;
            padding: 50px;
            border-radius: 0 0 30px 30px;
            text-align: center;
        }

        .eventos-capas img {
            width: 280px;
            height: 280px;
            margin: 2px;
            border-radius: 2px;
        }

        .eventos-proximos {
            padding: 20px;
            background: white;
        }
    </style>

</head>

<body>
    <header>
        <div class="logo">
            <a href="HomeView.php">
                <img src="EventPassLogo.png" alt="EventPass Logo">
            </a>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Encontre seu evento">
            <button>🔍</button>
        </div>
        <div class="login">
            <a href="LoginView.php">
                <button>Login</button>
            </a>
        </div>
    </header>

    <section class="eventos-principais">
        <div class="eventos-capas">
            <button style="all: unset; cursor: pointer;" onclick="window.location.href='EventView.php'">
                <img src="https://cdn.nsite.com.br/imgcache/494/1400x/uploads/494/journey%20e%20toto.jpg.webp"
                    alt="Journey Tour 2022">
            </button>
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTRebUv9-cbgZaylYdXWoMlwXzKpeyqvP5lA&s"
                alt="Foreigner Tour">
            <img src="https://upload.wikimedia.org/wikipedia/pt/2/21/Bruno_Mars_-_Live_in_Brazil_-_Turnê.jpg"
                alt="Bruno Mars Brasil">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyPKQ06CiGAY2MQGzwNy5KkBVjF-gkvJTx0w&s"
                alt="Nickelback Tour">
        </div>
    </section>

    <section class="eventos-proximos">
        <h2>Eventos Próximos</h2>
    </section>
</body>

</html>