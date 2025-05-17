<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="EventPassLogo.png" onclick="window.location.href='HomeView.html'" alt="EventPass Logo">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Encontre seu evento">
            <button>🔍</button>
        </div>
        <div class="login">
            <a href="LoginView.html">
            <button>Login</button>
        </a>
    </header>
    <h2>PAGAMENTO</h2>
    <div class="container">
        <div class="evento">
            <img src="https://cdn.nsite.com.br/imgcache/494/1400x/uploads/494/journey%20e%20toto.jpg.webp"
                alt="Capa do evento">
            <div>
                <p><strong>Journey & Toto - Freedom Tour 2025</strong></p>
                <p>📍 Allianz Parque<br>São Paulo, 02/08/2025</p>
            </div>
        </div>
        <div class="resumo">
            <p><strong>Resumo</strong></p>
            <p>2x Pista (inteira)</p>
            <p>1x Pista (meia)</p>
        </div>
        <hr>
        <div class="total">Total: R$ 1000</div>
        <a href="PaymentMethod.html">
            <button class="btn-comprar">COMPRAR</button>
        </a>
    </div>
</body>

</html>