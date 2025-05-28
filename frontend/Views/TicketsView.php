<?php
include_once '../../backend/DataBase/conexaoDB.php';
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $consulta = mysqli_query($conexao, "SELECT * FROM Eventos WHERE id = $id");
    $dados = mysqli_fetch_assoc($consulta);

    if ($dados) {
        // Dados do evento
        $nome = $dados['nome'];
        $local = $dados['local_evento'];
        $data = new DateTime($dados['data_evento']);
        $preco = $dados['preco_ingresso'];
        $precoMeia = $dados['preco_ingresso'] / 2;
        $logo = $dados['logo'];
    } else {
        echo "<p>Evento não encontrado.</p>";
        exit;
    }
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
    <title><?php echo $nome; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            height: 75px;
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
            position: relative;
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

        #mensagemAlerta {
            display: none;
            background-color: #ffc107;
            color: #000;
            padding: 10px 20px;
            border-radius: 8px;
            margin-left: 20px;
            font-weight: bold;
            position: absolute;
            right: 23%;
            /* -50% */
            top: 65%;
            /* 40% */
            z-index: 10;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            opacity: 1;
            transition: opacity 1s ease-in-out;
        }

        .btn-container button:hover {
            background-color: #00CFFF;
            color: white;
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
            <?php if (isset($_SESSION['user'])) {
                echo "<button onclick=\"window.location.href='Logout.php'\">Logout</button>";
            } else {
                echo "<button onclick=\"window.location.href='LoginView.php'\">Login</button>";
            } ?>
        </div>
    </header>

    <div class="poster">
        <img src="<?php echo $logo; ?>" alt="banner-show" class="banner">

        <div class="botao-voltar">
            <button onclick="history.back()">← Voltar</button>
        </div>

        <div class="ingressos-container">
            <h2>INGRESSOS</h2>
            <div id="mensagemAlerta" class="alert alert-danger text-center">Selecione pelo menos um ingresso!</div>
            <form method="POST" action="PaymentView.php?id=<?php echo $id; ?>" id="formularioIngressos">
                <div class="ingresso-item">
                    <span>Pista (inteira)</span>
                    <span>R$ <?php echo $preco ?></span>
                    <div class="contador">
                        <button type="button" class="decremento">-</button>
                        <span class="qtdIngressos qtdInteira">0</span>
                        <button type="button" class="incremento">+</button>
                    </div>
                    <input type="hidden" name="qtdInteira" id="inputQtdInteira" value="0" />
                </div>
                <div class="ingresso-item">
                    <span>Pista (meia)</span>
                    <span>R$ <?php echo $precoMeia ?></span>
                    <div class="contador">
                        <button type="button" class="decremento">-</button>
                        <span class="qtdIngressos qtdMeia">0</span>
                        <button type="button" class="incremento">+</button>
                    </div>
                    <input type="hidden" name="qtdMeia" id="inputQtdMeia" value="0" />
                </div>
                <div class="btn-container">
                    <button type="button" class="btn" onclick="enviarQtdIngressos()">COMPRAR</button>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    const ticketSelectors = document.querySelectorAll('.ingresso-item');

    ticketSelectors.forEach(selector => {
        const incrementoBtn = selector.querySelector('.incremento');
        const decrementoBtn = selector.querySelector('.decremento');
        const countDisplay = selector.querySelector('.qtdIngressos');

        let count = parseInt(countDisplay.textContent);

        //função de incremento
        incrementoBtn.addEventListener('click', () => {
            if (count < 2) {
                count++;
                countDisplay.textContent = count;
            }
        });

        //função de decremento
        decrementoBtn.addEventListener('click', () => {
            if (count > 0) {
                count--;
                countDisplay.textContent = count;
            }
        });
    });

    function enviarQtdIngressos() {
        let inteira = parseInt(document.querySelector('.qtdInteira').textContent);
        let meia = parseInt(document.querySelector('.qtdMeia').textContent);
        const alerta = document.getElementById('mensagemAlerta');

        //mensagem de alerta caso o usuário não tenha selecionado nenhum ingresso
        if (inteira === 0 && meia === 0) {
            alerta.textContent = "Selecione pelo menos um ingresso!";
            alerta.style.display = "block";
            alerta.style.opacity = "1";

            setTimeout(() => {
                alerta.style.opacity = "0";
            }, 2000);

            setTimeout(() => {
                alerta.style.display = "none";
            }, 3000);

            return; // NÃO envia o formulário
        }

        document.getElementById('inputQtdInteira').value = inteira;
        document.getElementById('inputQtdMeia').value = meia;

        document.getElementById('formularioIngressos').submit();
    }
</script>

</html>