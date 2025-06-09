<?php
include_once '../../backend/DataBase/conexaoDB.php';
include_once '../../backend/Entities/Usuario.php';
include_once '../../backend/Entities/Eventos.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: LoginView.php');
    exit;
} else if ($_SESSION['user']->getPerfil() == 'ADMINISTRADOR') {
    $result = mysqli_query($conexao, "SELECT id, nome, logo FROM Eventos");
} else {
    echo "<p>Você não pode mexer aqui, danadinho</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerenciar Eventos</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonte Inter (opcional) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            max-width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #d8f0ff;
            padding: 15px 20px;
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

        .eventos-principais {
            background: navy;
            padding: 20px 50px;
            border-radius: 0 0 30px 30px;
            text-align: center;
            color: white;
        }

        .eventos-capas img {
            width: 280px;
            height: 280px;
            margin: 2px;
            border-radius: 2px;
        }

        .eventos-proximos {
            padding: 20px;
            background: white;
        }

        .table-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .btn-edit {
            background-color: #0d6efd;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0b5ed7;
        }

        .btn-delete:hover {
            background-color: #bb2d3b;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img style="cursor: pointer;" src="EventPassLogo.png" alt="Logo" onclick="window.location.href='HomeView.php'">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Buscar eventos...">
            <button>🔍</button>
        </div>
        <div class="login">
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
                } ?>
            </div>
        </div>
    </header>

    <div class="eventos-principais">
        <h1>LISTAGEM DE EVENTOS</h1>
    </div>

    <div class="eventos-proximos">
        <div class="container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered align-middle text-center">';
                echo '<thead class="table-primary"><tr><th>Logo</th><th>Nome</th><th>Ações</th></tr></thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $idEvento = intval($row['id']);
                    $nome = htmlspecialchars($row['nome']);
                    $logo = $row['logo'];
                    $extensao = Eventos::pegarExtensaoDaImagem($row['logo']);
                    $logo = base64_encode($logo);

                    echo '<tr>';
                    echo "<td><img src=\"data:$extensao;base64,$logo\" alt=\"$nome\" class=\"table-img\"></td>";
                    echo "<td>$nome</td>";
                    echo '<td>
                            <button class="btn btn-sm btn-edit me-2" onclick="window.location.href=\'InserirEvento.php?id=' . $idEvento . '\'">EDITAR</button>
                            <button type="button" class="btn btn-sm btn-delete" data-id="' . $idEvento . '" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">EXCLUIR</button>
                        </td>';
                    echo '</tr>';
                }

                echo '</tbody></table></div>';
            } else {
                echo "<p class='text-center text-muted mt-3'>Nenhum evento encontrado.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirmar exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" id="formExcluir">
                        <button id="btnConfirmDelete" type="submit" class="btn btn-danger">Confirmar</button>
                        <input type="hidden" name="excluir" value="excluir">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".btn-delete");
        const confirmBtn = document.getElementById("btnConfirmDelete");

        // Atualiza o destino do botão de confirmação com o ID correto
        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const idEvento = this.getAttribute("data-id");
                confirmBtn.onclick = function() {
                    // Fecha a modal
                    const modalEl = document.getElementById('confirmDeleteModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    // Redireciona para a exclusão
                    const formExcluir = document.getElementById("formExcluir");
                    formExcluir.action = `UpdateEventos.php?id=${idEvento}`;

                };
            });
        });
    });
</script>


</html>