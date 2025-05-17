<?php
include_once '../../backend/Database/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';
session_start();

function validarCPF($cpf){
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
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

$erros = [];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['cpf'])) {
        $erros['cpf'] = "CPF é obrigatório.";
    } elseif (!validarCPF($_POST['cpf'])) {
        $erros['cpf'] = "CPF inválido.";
    };
    if (empty($_POST['nome'])) $erros['nome'] = "Nome é obrigatório.";
    if (empty($_POST['dataNasc'])) $erros['dataNasc'] = "Data de nascimento é obrigatória.";
    if (empty($_POST['email'])) $erros['email'] = "Email é obrigatório.";
    if (empty($_POST['senha'])) $erros['senha'] = "Senha é obrigatória.";
    if (empty($_POST['confirmarSenha'])) $erros['confirmarSenha'] = "Confirmação de senha é obrigatória.";

    if (!isset($erros['senha']) && !isset($erros['confirmarSenha']) && $_POST['senha'] !== $_POST['confirmarSenha']) {
        $erros['confirmarSenha'] = "As senhas não coincidem.";
    }

    if (empty($erros)) {
        $user = new Usuario($_POST['cpf'], $_POST['nome'], $_POST['dataNasc'], $_POST['email'], $_POST['senha']);
        $consulta = mysqli_query($conexao, "INSERT INTO usuarios (cpf, nome, dataNascimento, email, senha, perfil, telefone, endereco) VALUES
        ('" . $user->getCpf() . "', '" . $user->getNome() . "', '" . $user->getDataNascimento() . "', '" . $user->getEmail() . "', '" . $user->getSenha() . "', '" . $user->getPerfil() . "', '" . $user->getTelefone() . "', '" . $user->getEndereco() . "')");

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
            height: 100vh;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 200px;
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

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 10px;
            border: none;
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
    </style>

    <!--ESTILO PARA MENSAGEM DE ALERTA-->
    <style>
        .alert {
            margin-top: 10px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .field-error {
            color: #ffb3b3;
            font-size: 13px;
            margin-top: 3px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="EventPassLogo.png" alt="EventPass Logo">
    </div>
    <form method='POST' action='RegisterView.php'>
        <div class="container">
            <h2>CADASTRO</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome completo" value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>">
            <?php if (isset($erros['nome'])) echo "<div class='field-error'>{$erros['nome']}</div>"; ?>

            <label for="cpf">CPF</label>
            <input type="text" name="cpf" id="cpf" placeholder="Digite seu CPF" value="<?php echo htmlspecialchars($_POST['cpf'] ?? ''); ?>">
            <?php if (isset($erros['cpf'])) echo "<div class='field-error'>{$erros['cpf']}</div>"; ?>

            <label for="dataNasc">Data de nascimento</label>
            <input type="text" name="dataNasc" id="dataNasc" placeholder="Digite sua data de nascimento" value="<?php echo htmlspecialchars($_POST['dataNasc'] ?? ''); ?>">
            <?php if (isset($erros['dataNasc'])) echo "<div class='field-error'>{$erros['dataNasc']}</div>"; ?>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            <?php if (isset($erros['email'])) echo "<div class='field-error'>{$erros['email']}</div>"; ?>

            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
            <?php if (isset($erros['senha'])) echo "<div class='field-error'>{$erros['senha']}</div>"; ?>

            <label for="confirmarSenha">Confirmar Senha</label>
            <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirme sua senha">
            <?php if (isset($erros['confirmarSenha'])) echo "<div class='field-error'>{$erros['confirmarSenha']}</div>"; ?>

            <button class="btn">CADASTRAR</button>
        </div>
    </form>
</body>

</html>