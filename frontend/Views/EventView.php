<?php
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';
session_start();

//função
function calculoDaIdade(DateTime $dataDeNascimento)
{
    $hoje = new DateTime();
    $idade = $dataDeNascimento->diff($hoje)->y;
    return $idade;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $consulta = mysqli_query($conexao, "SELECT * FROM Eventos WHERE id = $id");
    $dados = mysqli_fetch_assoc($consulta);

    if ($dados) {
        // Dados do evento
        $nome = $dados['nome'];
        $local = $dados['local_evento'];
        $data = new DateTime($dados['data_evento']);
        $logo = $dados['logo'];
        $classificacao = $dados['classificacao'];
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
    <title>Freedom Tour 2025 - Journey & Toto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            overflow-x: hidden;
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

        .banner-container {
            position: relative;
            width: 100%;
            height: 50vh;
            overflow: hidden;
            max-width: 100%;
        }

        .banner-background {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            opacity: 70%;
        }

        .banner-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            max-width: 600px;
            height: 200px;
            display: block;
            border-radius: 20px;
        }

        .info-container {
            background-color: navy;
            width: 100%;
            max-width: 900px;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            align-items: center;
            margin-top: -30px;
            box-sizing: border-box;
        }

        .info {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }

        .info h2 {
            font-size: 22px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .btn-container {
            text-align: center;
            margin-top: 50px;
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
            <?php if (isset($_SESSION['user'])) {
                echo "<button onclick=\"window.location.href='Logout.php'\">Logout</button>";
            } else {
                echo "<button onclick=\"window.location.href='LoginView.php'\">Login</button>";
            } ?>
        </div>
    </header>

    <div class="banner-container">
        <!--<img src="<?php //echo $banner; 
                        ?>" alt="background-show" class="banner-background">-->
        <img src="<?php echo $logo; ?>" alt="banner-show" class="banner-overlay">
    </div>

    <div class="info-container">
        <div class="info">
            <h2><?php //echo htmlspecialchars($cidade); 
                ?></h2>
            <p><strong>Apresentação:</strong> <?php echo $data->format("d/m/Y"); ?> às <?php echo $data->format("H:i:s") ?></p>
            <p><strong>Abertura dos portões:</strong> <?php echo $data->sub(new DateInterval('PT2H'))->format("H:i:s"); ?></p>
            <p><strong>Local:</strong> <?php echo htmlspecialchars($local); ?></p>
            <p><strong>Parcelamento:</strong> Na internet até 10X com juros, sendo as 3 primeiras parcelas sem juros.</p>
            <p><strong>Classificação:</strong> <?php echo $classificacao; ?> anos.</p>
        </div>
        <div class="btn-container">
            <?php if (isset($_SESSION['user'])) {
                if ((int)$classificacao > calculoDaIdade($_SESSION['user']->getDataNascimento())) {
                    echo "<div class=\"alert alert-danger text-center\">
                    Você não tem idade minima para esse evento!!
                </div>";
                } else {
                    echo "<a href=\"TicketsView.php?id=" . $id . "\">
                        <button class=\"btn\">INGRESSOS</button>
                    </a>";
                }
            } else {
                echo "<a href=\"TicketsView.php?id=" . $id . "\">
                        <button class=\"btn\">INGRESSOS</button>
                    </a>";
            } ?>
        </div>
    </div>
</body>

</html>