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
  <title>Pagamento</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: navy;
      color: white;
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
      height: 150px;
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

    .pix-container {
      background-color: white;
      color: black;
      border-radius: 40px;
      padding: 40px 20px;
      max-width: 400px;
      width: 90%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 30px;
      margin-bottom: 60px;
      margin-top: 15px;
    }

    .pix-logo {
      max-width: 180px;
      width: 100%;
    }

    .qr-code {
      width: 200px;
      height: 200px;
      object-fit: contain;
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
      <button onclick="window.location.href='Logout.php'">Logout</button>
    </div>
  </header>

  <div class="botao-voltar">
        <button onclick="history.back()">← Voltar</button>
  </div>

  <h2>FORMA DE PAGAMENTO</h2>
    
  <div class="pix-container">
    <img class="pix-logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/Logo_-_pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.png/1200px-Logo_-_pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.png" alt="Logo Pix" />
    <img class="qr-code" src="https://pngimg.com/d/qr_code_PNG7.png" alt="QR Code Pix" />
  </div>
  
</body>

</html>