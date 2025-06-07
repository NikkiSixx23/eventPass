<?php
//importações
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';

session_start();

$editar = false;

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit;
} else if ($_SESSION['user']->getPerfil() == 'ADMINISTRADOR') {
    if (isset($_GET['id'])) {
        $editar = true;
        $idEvento = intval($_GET['id']);
        $consulta = mysqli_query($conexao, "SELECT * FROM Eventos WHERE id = $idEvento");
        $dados = mysqli_fetch_assoc($consulta);
        if (!empty($dados)) {
            $dataEvento = new DateTime($dados['data_evento']);
        } else {
            echo "<p>OS DADOS NÃO FORAM PASSADOS CORRETAMENTE";
            exit;
        }
    }
} else {
    echo "<p>Você não pode mexer aqui, danadinho</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Evento</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #d6f0ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .logo {
            margin-bottom: 5px;
        }

        .logo img {
            width: 200px;
            cursor: pointer;
        }

        .container {
            background-color: navy;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            width: 380px;
        }

        h2 {
            color: white;
            margin-bottom: 15px;
        }

        label {
            color: white;
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 10px;
            border: none;
        }

        .inputs {
            display: flex;
            gap: 10px;
            width: 100%;
        }

        .btn {
            width: 50%;
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }

        .capa {
            margin-top: 15px;
        }

        .capa input {
            background-color: white;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatarMoeda(campo) {
                campo.addEventListener('input', function(e) {
                    let valor = e.target.value.replace(/\D/g, '');
                    valor = (valor / 100).toFixed(2) + '';
                    valor = valor.replace(".", ",");
                    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    e.target.value = 'R$ ' + valor;
                });
            }

            const campoInteira = document.getElementById('precoInteira');
            const campoMeia = document.getElementById('precoMeia');

            formatarMoeda(campoInteira);
            formatarMoeda(campoMeia);
        });
    </script>
</head>

<body>
    <div class="logo">
        <img src="EventPassLogo.png" onclick="window.location.href='HomeView.php'" alt="EventPass Logo">
    </div>

    <form method="POST" action="SalvarEvento.php?id=<?php echo $idEvento;?>" enctype="multipart/form-data">
        <div class="container">
            <?php if ($editar): ?>
                <h2>EDITAR EVENTO</h2>
                <label for="nomeEvento">Nome do Evento</label>
                <input type="text" name="nomeEvento" id="nomeEvento" placeholder="Digite o nome do evento" value="<?php echo htmlspecialchars($dados['nome']); ?>">

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="data">Data</label>
                        <input type="date" name="data" id="data" value="<?php echo htmlspecialchars($dataEvento->format("Y-m-d")); ?>">
                    </div>
                    <div style="flex: 1;">
                        <label for="local">Local</label>
                        <input type="text" name="local" id="local" placeholder="Ex: Allianz Parque, São Paulo" value="<?php echo htmlspecialchars($dados['local_evento']); ?>">
                    </div>
                </div>

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="horario">Horário do Evento</label>
                        <input type="time" name="horario" id="horario" value="<?php echo htmlspecialchars($dataEvento->format("H:i")); ?>">
                    </div>
                    <div style="flex: 1;">
                        <label for="abertura">Abertura dos Portões</label>
                        <input type="time" name="abertura" id="abertura" value="<?php echo htmlspecialchars($dados['abertura']); ?>">
                    </div>
                </div>

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="precoInteira">Preço (inteira)</label>
                        <input type="text" step="0.01" name="precoInteira" id="precoInteira" placeholder="Ex: R$ 400" value="<?php echo htmlspecialchars($dados['preco_ingresso']); ?>">
                    </div>
                    <div style="flex: 1;">
                        <label for="precoMeia">Preço (meia)</label>
                        <input type="text" step="0.01" name="precoMeia" id="precoMeia" placeholder="Ex: R$ 200" value="<?php echo htmlspecialchars($dados['preco_ingresso'] / 2); ?>">
                    </div>
                </div>

                <label for="classificacao">Classificação Etária</label>
                <input type="text" name="classificacao" id="classificacao" placeholder="Ex: Livre, 12 anos, 18 anos..." value="<?php echo htmlspecialchars($dados['classificacao']); ?>">

                <div class="capa">
                    <label for="capa">Inserir Capa</label>
                    <input type="file" name="capa" id="capa">
                    <input type="hidden" name="logoAntiga" id="logoAntiga" value="<?php echo htmlspecialchars($dados['logo']); ?>">
                </div>

                <input type="hidden" name="editar" value="editar">
                <button type="submit" class="btn">SALVAR</button>
            <?php else: ?>
                <h2>INSERIR EVENTO</h2>
                <label for="nomeEvento">Nome do Evento</label>
                <input type="text" name="nomeEvento" id="nomeEvento" placeholder="Digite o nome do evento">

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="data">Data</label>
                        <input type="date" name="data" id="data">
                    </div>
                    <div style="flex: 1;">
                        <label for="local">Local</label>
                        <input type="text" name="local" id="local" placeholder="Ex: Allianz Parque, São Paulo">
                    </div>
                </div>

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="horario">Horário do Evento</label>
                        <input type="time" name="horario" id="horario">
                    </div>
                    <div style="flex: 1;">
                        <label for="abertura">Abertura dos Portões</label>
                        <input type="time" name="abertura" id="abertura">
                    </div>
                </div>

                <div class="inputs">
                    <div style="flex: 1;">
                        <label for="precoInteira">Preço (inteira)</label>
                        <input type="text" step="0.01" name="precoInteira" id="precoInteira" placeholder="Ex: R$ 400">
                    </div>
                    <div style="flex: 1;">
                        <label for="precoMeia">Preço (meia)</label>
                        <input type="text" step="0.01" name="precoMeia" id="precoMeia" placeholder="Ex: R$ 200">
                    </div>
                </div>

                <label for="classificacao">Classificação Etária</label>
                <input type="text" name="classificacao" id="classificacao" placeholder="Ex: Livre, 12 anos, 18 anos...">

                <div class="capa">
                    <label for="capa">Inserir Capa</label>
                    <input type="file" name="capa" id="capa">
                </div>

                <input type="hidden" name="criar" value="criar">
                <button type="submit" class="btn">ENVIAR</button>
        </div>
    <?php endif; ?>
    </form>
</body>

</html>