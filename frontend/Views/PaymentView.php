<?php
//importações
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';
include_once '../../backend/Entities/Eventos.php';

session_start();

if (isset($_POST['qtdInteira']) && isset($_POST['qtdMeia'])) {
    $_SESSION['qtdInteira'] = $_POST['qtdInteira'];
    $_SESSION['qtdMeia'] = $_POST['qtdMeia'];
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    //testa se o usuário está logado com alguma conta.
    if (!isset($_SESSION['user'])) {
        //passa para a sessão a página e o evento que o usuário estava acessando.
        $_SESSION['pagina'] = "PaymentView.php";
        $_SESSION['evento'] = $id;
        echo "filho da puta";
        //header("Location: LoginView.php");
        exit;
    } else if (isset($_SESSION['qtdInteira']) && isset($_SESSION['qtdMeia'])) {

        if ($_SESSION['qtdInteira'] == 0 && $_SESSION['qtdMeia'] == 0) {
            $_SESSION['msg'] = "Tem que comprar pelo menos um ingresso.";
            header("Location: TicketsView.php?id=" . $id);
        }

        $consulta = mysqli_query($conexao, "SELECT * FROM Eventos WHERE id = $id");
        $dados = mysqli_fetch_assoc($consulta);

        if ($dados) {
            // Dados do evento
            $nome = $dados['nome'];
            $local = $dados['local_evento'];
            $data = new DateTime($dados['data_evento']);
            $preco = $dados['preco_ingresso'];
            $precoMeia = $dados['preco_ingresso']/2;
            $logo = $dados['logo'];
            $extensao = Eventos::pegarExtensaoDaImagem($dados['logo']);
            $logo = base64_encode($logo);
            $total = ($_SESSION['qtdInteira'] * $preco) + ($_SESSION['qtdMeia'] * $precoMeia);
            $classificacao = $dados['classificacao'];

            if ($classificacao > $_SESSION['user']->calculoDaIdade($_SESSION['user']->getDataNascimento())) {
                header("Location: EventView.php?id=" . $_SESSION['evento']);
            }
        } else {
            echo "<p>Evento não encontrado.</p>";
            exit;
        }
    } else {
        echo "<p>Não foi passado corretamente os ingressos.</p>";
        exit;
    }
} else if (!isset($_SESSION['user'])) {
    header("Location: LoginView.php");
    exit;
} else {
    echo "<p>ID do evento não fornecido.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: navy;
            color: black;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #d8f0ff;
            padding: 15px 20px;
            width: 100%;
            margin-bottom: 30px;
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

        h2 {
            font-size: 20px;
            margin: 20px 0 30px;
        }

        .container {
            background-color: white;
            color: black;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 450px;
            text-align: center;
            margin-top: 15px;
        }

        .evento {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .evento img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
        }

        .resumo {
            text-align: left;
            margin-top: 20px;
            font-size: 16px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .btn-comprar {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .botao-voltar {
            position: absolute;
            top: 130px;
            left: 15px;
            z-index: 1000;
        }

        .botao-voltar button {
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
        }

        .botao-voltar button:hover {
            background-color: #00CFFF;
            color: white;
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
    <div class="botao-voltar">
        <button onclick="history.back()">← Voltar</button>
    </div>
    <h2 style="color: white;">PAGAMENTO</h2>
    <div class="container">
        <div class="evento">
            <img src="<?php echo "data:$extensao;base64,$logo"?>" alt="Capa do evento">
            <div>
                <p><strong><?php echo $nome; ?></strong></p>
                <p>📍 <!--coloque aqui onde será o evento--><?php echo $local . ", " . $data->format("d/m/Y"); ?></p>
            </div>
        </div>
        <div class="resumo">
            <p><strong>Resumo</strong></p>
            <p><?php echo $_SESSION['qtdInteira']; ?>x Pista (inteira)</p>
            <p><?php echo $_SESSION['qtdMeia'] ?>x Pista (meia)</p>
        </div>
        <hr>
        <div class="total">Total: R$ <?php echo $total; ?></div>
        <button class="btn-comprar" onclick="window.location.href='PaymentMethod.php'">COMPRAR</button>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>