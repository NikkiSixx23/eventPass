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
        $consulta = mysqli_query($conexao, "select id, cpf, nome, email, dataNascimento, senha, perfil from Usuarios where email = '$email'");
        $dados = mysqli_fetch_assoc($consulta);

        //instancia uma entidade usuário para conseguir realizar validação de senha e email
        $user = null;
        if ($dados != null) {
            $dataDeNascimento = new DateTime($dados['dataNascimento']);
            $user = new Usuario($dados['cpf'], $dados['nome'], $dataDeNascimento, $dados['email'], $dados['senha']);
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
            <img src="EventPassLogo.png" onclick="window.location.href='HomeView.php'" alt="EventPass Logo">
        </div>
        <div class="search-bar">
            <form action="HomeView.php" method="GET" style="display: flex; width: 100%;">
                <input type="text" name="busca" placeholder="Encontre seu evento" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
                <button type="submit">🔍</button>
            </form>
        </div>
        <div class="login">
            <?php if (isset($_SESSION['user'])){
                echo "<button onclick=\"window.location.href='Logout.php'\">Logout</button>";
            } else {
                echo "<button onclick=\"window.location.href='LoginView.php'\">Login</button>";
            }?>
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

</html>