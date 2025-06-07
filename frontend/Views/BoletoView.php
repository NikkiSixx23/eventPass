<?php
//importações
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';

session_start();

if (!isset($_SESSION['user'])) {
  header("Location: LoginView.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pagamento com Boleto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
  <!--<link rel="stylesheet" href="Style.css">-->
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
      text-align: center;
    }

    .boleto-container {
      background-color: white;
      color: black;
      border-radius: 40px;
      padding: 40px 20px;
      max-width: 500px;
      width: 90%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
      margin-bottom: 60px;
      margin-top: 15px;
    }

    .boleto-logo {
      max-width: 180px;
      height: 100%;
    }

    .boleto-img {
      max-width: 100%;
      height: auto;
      border: 1px solid #ccc;
    }

    .baixar-btn {
      background-color: #4a90e2;
      color: white;
      font-size: 14px;
      font-weight: normal;
      padding: 12px 30px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      margin-top: 10px;
    }

    .baixar-btn:hover {
      background-color: #4a90e2;
    }

    .botao-voltar {
      position: absolute;
      top: 210px;
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

  <h2 style="color: white;">FORMA DE PAGAMENTO</h2>

  <div class="boleto-container">
    <img class="boleto-logo"
      src="https://seeklogo.com/images/B/boleto-codigo-barra-preto-black-bar-code-ticket-logo-AB7B0F1776-seeklogo.com.png"
      alt="Boleto Logo" />
    <img class="boleto-img" src="https://www.rtek.com.br/wp-content/uploads/2017/08/boletobancario.jpg"
      alt="Imagem do Boleto" />
    <a href="boletos/boleto_exemplo.pdf" class="baixar-btn" download>BAIXAR</a>
  </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>