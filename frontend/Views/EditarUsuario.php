<?php
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: LoginView.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['editar'] == "editarOutros") {
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];

        //retira qualquer caractere que não seja um número para ser salvo corretamente
        $telefone = preg_replace('/\D/', '', $telefone);

        if (strlen($telefone) === 11) {

            //atualiza no banco de dados
            $consulta = mysqli_query($conexao, "UPDATE Usuarios SET email='$email', telefone='$telefone', endereco='$endereco' WHERE cpf='" . $_SESSION['user']->getCpf() . "'");

            if ($consulta) {
                //atualiza os dados na sessao atual
                $_SESSION['user']->setEmail($email);
                $_SESSION['user']->setTelefone($telefone);
                $_SESSION['user']->setEndereco($endereco);
                $msgSucesso = "Alterações salvas com sucesso!";
            } else {
                $msgErro = "Erro ao salvar as alterações. Tente novamente.";
            }
        } else {
            $erroTelefone = "O telefone deve ser completo corretamente!";
        }
    } else if ($_POST['editar'] == "editarSenha") {
        if ($_SESSION['user']->getSenha() == $_POST['senhaAtual'] && $_POST['senhaAtual'] != $_POST['novaSenha'] && $_POST['novaSenha'] == $_POST['confirmarNovaSenha']) {
            $consulta = mysqli_query($conexao, "UPDATE Usuarios SET senha='" . $_POST['novaSenha'] . "' WHERE cpf='" . $_SESSION['user']->getCpf() . "'");
            header("Location: LoginView.php");
            exit;
        } else {
            $msgErro = "Senha atual incorreta!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #d6f0ff;
            padding: 0;
            margin: 0;
        }


        header {
            max-width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #d8f0ff;
            padding: 10px 20px;
        }

        .logo img {
            height: 75px;
        }

        .engrenagem-opcoes {
            height: 25px;
        }

        .eventos-principais {
            background: navy;
            padding: 10px 50px;
            border-radius: 0 0 30px 30px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            width: 100%;
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 20px;
            }

            .eventos-principais {
                padding: 20px;
            }
        }

        .botao-voltar {
            margin-top: -27px;
            margin-bottom: 10px;
            padding-left: 15px;
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
        <div class="login">
            <?php
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
            } ?>
        </div>
    </header>

    <div class="eventos-principais">
        <h2>Editar Perfil</h2>
        <p>Atualize seus dados pessoais abaixo</p>
    </div>

    <div class="botao-voltar">
        <button onclick="window.location.href='HomeView.php'">← Voltar</button>
    </div>

    <div class="modal-body">
        <div class="form-container mx-auto" style="max-width: 500px;">
            <?php if (!empty($msgErro)): ?>
                <div class="alert alert-danger mt-2">
                    <?php htmlspecialchars($msgErro) ?>
                </div>
            <?php endif; ?>

            <form action="EditarUsuario.php" method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <div class="form-control-plaintext"><?php echo htmlspecialchars($_SESSION['user']->getNome()) ?></div>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">CPF:</label>
                    <div class="form-control-plaintext"><?php echo htmlspecialchars($_SESSION['user']->formatarCpfMascara($_SESSION['user']->getCpf())) ?></div>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Data de nascimento:</label>
                    <div class="form-control-plaintext"><?php echo htmlspecialchars($_SESSION['user']->getDataNascimento()->format("d/m/Y")) ?></div>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Telefone:</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $_SESSION['user']->getTelefone() != 'Não informado' ? htmlspecialchars($_SESSION['user']->formatarTelefoneMascara($_SESSION['user']->getTelefone())) : ''; ?>">
                    <?php if (isset($erroTelefone)) echo "<div class='field-error'>" . $erroTelefone . "</div>"; ?>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $_SESSION['user']->getEndereco() != 'Não informado' ? htmlspecialchars($_SESSION['user']->getEndereco()) : ''; ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']->getEmail()); ?>">
                </div>

                <br>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">Senha:********</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editarSenhaModal">Editar</button>
                </div>

                <input type="hidden" name="editar" value="editarOutros">
                <button id="salvarBtn" type="submit" class="btn btn-primary" disabled>Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal para redefinir a senha -->
    <div class="modal fade" id="editarSenhaModal" tabindex="-1" aria-labelledby="editarSenhaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="EditarUsuario.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarSenhaModalLabel">Redefinir Senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="novaSenha" class="form-label">Senha Antiga</label>
                            <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" required>
                        </div>
                        <div class="mb-3">
                            <label for="novaSenha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmarNovaSenha" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirmarNovaSenha" name="confirmarNovaSenha" required>
                        </div>
                        <center><span id="erroSenha" style="color: red;"></span></center>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Esqueceu a senha antiga?</button>-->
                        <button type="submit" class="btn btn-primary" id="btnSalvar">Salvar Senha</button>
                    </div>
                    <input type="hidden" name="editar" value="editarSenha">
                </form>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!--Máscara do telefone-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const telefoneInput = document.getElementById('telefone');

        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

            if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos

            if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4})$/, '($1) $2-$3');
            }

            e.target.value = value.trim();
        });
    });
</script>

<!--JS para travar o botão de salvar dados caso não haja alteração nos campos editaveis-->
<script>
    const telefoneInput = document.getElementById('telefone');
    const enderecoInput = document.getElementById('endereco');
    const emailInput = document.getElementById('email');
    const salvarBtn = document.getElementById('salvarBtn');

    // Armazena os valores iniciais
    const valoresIniciais = {
        telefone: telefoneInput.value,
        endereco: enderecoInput.value,
        email: emailInput.value
    };

    function verificarAlteracoes() {
        const mudou = telefoneInput.value !== valoresIniciais.telefone || enderecoInput.value !== valoresIniciais.endereco || emailInput.value !== valoresIniciais.email;

        salvarBtn.disabled = !mudou;
    }

    // Monitora mudanças nos campos
    telefoneInput.addEventListener('input', verificarAlteracoes);
    enderecoInput.addEventListener('input', verificarAlteracoes);
    emailInput.addEventListener('input', verificarAlteracoes);
</script>

<!--JS para validação de senhas na modal de edição de senha-->
<script>
    const senhaAtualInput = document.getElementById('senhaAtual');
    const novaSenhaInput = document.getElementById('novaSenha');
    const confirmarSenhaInput = document.getElementById('confirmarNovaSenha');
    const erroSpan = document.getElementById('erroSenha');
    const btnSalvar = document.getElementById('btnSalvar');

    function validarSenhas() {
        const senhaAtual = senhaAtualInput.value;
        const novaSenha = novaSenhaInput.value;
        const confirmarNovaSenha = confirmarSenhaInput.value;

        btnSalvar.disabled = true;

        if (novaSenha.length === 0) {
            erroSpan.textContent = "";
        } else if (novaSenha === senhaAtual) {
            erroSpan.textContent = "A nova senha não pode ser igual à antiga!";
        } else if (novaSenha.length < 8) {
            erroSpan.textContent = "A senha deve conter no mínimo 8 caracteres!";
        } else if (novaSenha !== confirmarNovaSenha) {
            erroSpan.textContent = "As senhas não coincidem!";
        } else {
            erroSpan.textContent = "";
            btnSalvar.disabled = false;
        }
    }

    novaSenhaInput.addEventListener('input', validarSenhas);
    confirmarSenhaInput.addEventListener('input', validarSenhas);
</script>


</html>