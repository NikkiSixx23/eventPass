<?php
//importações
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';

session_start();

//testa se no login o usuario colocou email
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //faz um consulta no banco que retorna os dados do usuário específico
        $consulta = mysqli_query($conexao, "SELECT * FROM Usuarios WHERE email = '$email'");
        $dados = mysqli_fetch_assoc($consulta);

        //instancia uma entidade usuário para conseguir realizar validação de senha e email
        $user = null;
        if ($dados != null) {
            $dataDeNascimento = new DateTime($dados['dataNascimento']);
            $user = new Usuario($dados['cpf'], $dados['nome'], $dataDeNascimento, $dados['email'], $dados['senha']);
            $user->setPerfil($dados['perfil']);
        }

        //realiza validação de email e senha para o usuário conseguir navegar no site
        if ($user != null && $user->validaUsuario($email, $senha)) {
            $_SESSION['user'] = $user;

            if (isset($_SESSION['pagina']) && isset($_SESSION['evento'])) {
                header("Location: " . $_SESSION['pagina'] . "?id=" . $_SESSION['evento']);
            }
        } else {
            $_SESSION['msg'] = "Usuário ou senha incorretos!!";
            header("Location: LoginView.php");
            exit;
        }
    } else if (!isset($_SESSION['user'])) {
        $_SESSION['msg'] = "Necessário email e senha para fazer login";
        header("Location: LoginView.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPass</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            max-width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #d8f0ff;
            padding: 10px 20px;
        }

        .logo img {
            height: 75px;
        }

        .engrenagem-opcoes {
            height: 25px;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 300px;
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
            <img style="cursor: pointer;" src="EventPassLogo.png" onclick="window.location.href='HomeView.php'" alt="EventPass Logo">
        </div>
        <div class="search-bar">
            <form action="HomeView.php" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="busca" placeholder="Encontre seu evento" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                <button type="submit">🔍</button>
            </form>
        </div>
        <div class="login">
            <?php
            if (isset($_SESSION['user'])) {
                $primeiroNome = $_SESSION['user']->pegarPrimeiroNome($_SESSION['user']->getNome());

                if ($_SESSION['user']->getPerfil() != 'ADMINISTRADOR') {
                    echo "<div class=\"d-flex align-items-center\">
                        <span class=\"navbar-text me-3\">Bem vindo, " . $primeiroNome . "!</span>
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\"><img class=\"engrenagem-opcoes\" src=\"engrenagem.png\" alt=\"felladaputa\"/></a>
                            <ul class=\"dropdown-menu dropdown-menu-end\">
                                <li><a class=\"dropdown-item\" href=\"#\">Action</a></li>
                                <li><a class=\"dropdown-item\" href=\"EditarUsuario.php\">Editar Perfil</a></li>
                                <li><hr class=\"dropdown-divider\"></li>
                                <li><a class=\"dropdown-item\" href=\"Logout.php\">Logout</a></li>
                            </ul>
                    </div>";
                } else {
                    echo "<div class=\"d-flex align-items-center\">
                        <span class=\"navbar-text me-3\">Bem vindo, " . $primeiroNome . "!</span>
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\"><img class=\"engrenagem-opcoes\" src=\"engrenagem.png\" alt=\"felladaputa\"/></a>
                            <ul class=\"dropdown-menu dropdown-menu-end\">
                                <li><a class=\"dropdown-item\" href=\"GerenciarEventos.php\">Gerenciar eventos</a></li>
                                <li><a class=\"dropdown-item\" href=\"EditarUsuario.php\">Editar Perfil</a></li>
                                <li><hr class=\"dropdown-divider\"></li>
                                <li><a class=\"dropdown-item\" href=\"Logout.php\" style=\"color: darkred;\">Logout</a></li>
                            </ul>
                    </div>";
                }
            } else {
                echo "<button onclick=\"window.location.href='LoginView.php'\">Login</button>";
            } ?>
        </div>
    </header>

    <section class="eventos-principais">
        <div class="eventos-capas">
            <?php
            $busca = isset($_GET['busca']) ? mysqli_real_escape_string($conexao, $_GET['busca']) : '';
            if ($busca != '') {
                $sql = "SELECT id, nome, logo FROM Eventos WHERE nome LIKE '%$busca%'";
            } else {
                $sql = "SELECT id, nome, logo FROM Eventos";
            }
            $result = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $nome = htmlspecialchars($row['nome']);
                    $logo = $row['logo'];

                    echo "
                    <button style=\"all: unset; cursor: pointer;\" onclick=\"window.location.href='EventView.php?id=$id'\">
                        <img src=\"$logo\" alt=\"$nome\">
                    </button>
                    ";
                }
            } else {
                echo "<p style='color: white;'>Nenhum evento encontrado para \"$busca\".</p>";
            }
            ?>
        </div>
    </section>

    <section class="eventos-proximos">
        <h2>Eventos Próximos</h2>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>