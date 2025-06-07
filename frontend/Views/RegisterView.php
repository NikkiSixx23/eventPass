<?php
include_once '../../backend/Database/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';
session_start();

function validarCPF($cpf) {
    //pega apenas os caracteres numéricos do cpf
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    //testa se o cpf tem 11 caracteres e se os caracteres não são repetidos. Ex: 11111111111
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validarNome() {
    // Quebra apenas por espaço em branco
    $palavras = preg_split('/\s+/', trim($_POST['nome']));

    // Remove entradas vazias
    $palavras = array_filter($palavras);

    return count($palavras);
}

$erros = [];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['cpf'])) {
        $erros['cpf'] = "CPF é obrigatório.";
    } else if (!validarCPF($_POST['cpf'])) {
        $erros['cpf'] = "CPF inválido.";
    };
    if (empty($_POST['nome'])) {
        $erros['nome'] = "Nome é obrigatório";
    } else if (validarNome() < 2) {
        $erros['nome'] = "Necessário nome completo";
    }
    if (empty($_POST['dataNasc'])) {
        $erros['dataNasc'] = "Data de nascimento é obrigatória.";
    }
    if (empty($_POST['email'])) {
        $erros['email'] = "Email é obrigatório.";
    }
    if (empty($_POST['senha'])) {
        $erros['senha'] = "Senha é obrigatória.";
    }
    if (empty($_POST['confirmarSenha'])) {
        $erros['confirmarSenha'] = "Confirmação de senha é obrigatória.";
    }

    if (!isset($erros['senha']) && !isset($erros['confirmarSenha']) && $_POST['senha'] !== $_POST['confirmarSenha']) {
        $erros['confirmarSenha'] = "As senhas não coincidem.";
    }

    if (empty($erros)) {
        $_POST['cpf'] = preg_replace('/[^0-9]/', '', $_POST['cpf']);
        $dataNasc = new DateTime($_POST['dataNasc']);
        $user = new Usuario($_POST['cpf'], $_POST['nome'], $dataNasc, $_POST['email'], $_POST['senha']);
        $consulta = mysqli_query($conexao, "INSERT INTO usuarios (cpf, nome, dataNascimento, email, senha, perfil, telefone, endereco) VALUES
        ('" . $user->getCpf() . "', '" . $user->getNome() . "', '" . $user->getDataNascimento()->format('Y-m-d') . "', '" . $user->getEmail() . "', '" . $user->getSenha() . "', '" . $user->getPerfil() . "', '" . $user->getTelefone() . "', '" . $user->getEndereco() . "')");

        if ($consulta) {
            $_SESSION['msg'] = "Usuário cadastrado com sucesso!!";
            header('Location: LoginView.php');
            exit();
        } else {
            $msg = "Erro ao cadastrar. Tente novamente.";
        }
    } else {
        $msg = "Preencha todos os campos corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPass Cadastro</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #d6f0ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            padding-top: 30px;
        }

        .logo img {
            width: 200px;
        }

        .form-container {
            background-color: navy;
            padding: 30px;
            border-radius: 15px;
            color: white;
            max-width: 100%;
        }

        h2 {
            color: white;
            margin-bottom: 15px;
            text-align: center;
        }

        label {
            margin-top: 10px;
            font-size: 14px;
        }

        input {
            margin-top: 5px;
            border-radius: 10px !important;
        }

        .btn {
            width: 100%;
            margin-top: 20px;
            background-color: #4a90e2;
            border: none;
        }

        .btn:hover {
            background-color: #357ab8;
        }

        .cadastro {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #4a90e2;
            text-decoration: none;
        }

        .field-error {
            color: #ffb3b3;
            font-size: 13px;
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <div class="logo mb-3">
        <img src="EventPassLogo.png" alt="EventPass Logo">
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <form method='POST' action='RegisterView.php' class="form-container">
                    <h2>CADASTRO</h2>

                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>" placeholder="Digite seu nome completo">
                    <?php if (isset($erros['nome'])) echo "<div class='field-error'>{$erros['nome']}</div>"; ?>

                    <label for="cpf">CPF</label>
                    <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo htmlspecialchars($_POST['cpf'] ?? ''); ?>" placeholder="Digite seu CPF">
                    <?php if (isset($erros['cpf'])) echo "<div class='field-error'>{$erros['cpf']}</div>"; ?>

                    <label for="dataNasc">Data de nascimento</label>
                    <input type="date" name="dataNasc" id="dataNasc" class="form-control" value="<?php echo htmlspecialchars($_POST['dataNasc'] ?? ''); ?>">
                    <?php if (isset($erros['dataNasc'])) echo "<div class='field-error'>{$erros['dataNasc']}</div>"; ?>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="Digite seu email">
                    <?php if (isset($erros['email'])) echo "<div class='field-error'>{$erros['email']}</div>"; ?>

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha">
                    <?php if (isset($erros['senha'])) echo "<div class='field-error'>{$erros['senha']}</div>"; ?>

                    <label for="confirmarSenha">Confirmar Senha</label>
                    <input type="password" name="confirmarSenha" id="confirmarSenha" class="form-control" placeholder="Confirme sua senha">
                    <?php if (isset($erros['confirmarSenha'])) echo "<div class='field-error'>{$erros['confirmarSenha']}</div>"; ?>

                    <button type="submit" class="btn btn-primary">CADASTRAR</button>
                    <a href="LoginView.php" class="cadastro">Já tenho cadastro</a>
                </form>
            </div>
        </div>
    </div>

    <!--Máscara do CPF-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            cpfInput.addEventListener('input', function() {
                let value = cpfInput.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                cpfInput.value = value;
            });
        });
    </script>
</body>