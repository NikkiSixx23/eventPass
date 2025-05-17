<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freedom Tour 2025 - Journey & Toto</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            background-color: navy;
            color: white;
            font-family: 'Inter', sans-serif;
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
            max-width: 100%;
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

        .poster {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            width: 100%;
            max-width: 100%;
        }

        .banner {
            width: 80%;
            max-width: 800px;
            height: auto;
        }

        .ingressos-container {
            background-color: navy;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-sizing: border-box;
        }

        .ingresso-item {
            background-color: white;
            color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-radius: 20px;
            margin: 10px 0;
            flex-wrap: wrap;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            width: 50%;
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
        }

        .contador {
            display: flex;
            align-items: center;
        }

        .contador button {
            background-color: white;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .contador span {
            margin: 0 10px;
            font-size: 18px;
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

    <div class="poster">
        <img src="https://cdn.nsite.com.br/imgcache/494/1400x/uploads/494/journey%20e%20toto.jpg.webp" alt="banner-show"
            class="banner">

        <div class="ingressos-container">
            <h2>INGRESSOS</h2>
            <div class="ingresso-item">
                <span>Pista (inteira)</span>
                <span>R$ 400</span>
                <div class="contador">
                    <button>-</button>
                    <span>0</span>
                    <button>+</button>
                </div>
            </div>
            <div class="ingresso-item">
                <span>Pista (meia)</span>
                <span>R$ 200</span>
                <div class="contador">
                    <button>-</button>
                    <span>0</span>
                    <button>+</button>
                </div>
            </div>
            <div class="btn-container">
                <a href="PaymentView.html">
                    <button class="btn">COMPRAR</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>