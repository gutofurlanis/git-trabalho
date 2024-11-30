<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header(header: 'Location: index.php');
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'login');

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se existe uma mensagem de sucesso na sessão
if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green; font-weight: bold;'>{$_SESSION['success_message']}</p>";
    unset($_SESSION['success_message']); // Remove a mensagem após exibi-la
}

// Verifica a ação de excluir
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Escapa o valor do ID para segurança
    $id = $conn->real_escape_string($id);
    
    // Realiza a exclusão
    $result = $conn->query("DELETE FROM pessoas WHERE id = $id");
    
    if ($result) {
        $_SESSION['success_message'];
    } else {
        $_SESSION['error_message'] = "Erro ao excluir paciente!";
    }
    
    // Redireciona para a página de pacientes
    header('Location: site.php');
    exit;
}

// Selecionar todos os pacientes do banco de dados ordenados por data
$sql = "SELECT * FROM pessoas ORDER BY data_consulta ASC, hora_consulta ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<h1>Pacientes</h1>

<!-- Campo de pesquisa -->
<input type="text" id="pesquisa" placeholder="Pesquisar por nome">
<button id="adicionar">+</button>

<table id="tabela-pacientes">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Data da Consulta</th>
            <th>Horário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Simplesmente não inclui a lógica de destaque
                echo "<tr>
                        <td>{$row['nome']}</td>
                        <td>" . date('d/m/Y', strtotime($row['data_consulta'])) . "</td>
                        <td>" . date('H:i', strtotime($row['hora_consulta'])) . "</td>
                        <td>
                            <a class='editar' href='editar.php?id={$row['id']}'>Editar</a>
                            <a class='excluir' href='site.php?action=delete&id={$row['id']}' onclick='return confirm(\"Tem certeza que deseja excluir este paciente?\")'>Excluir</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum paciente encontrado.</td></tr>";
        }
        ?>
    </tbody>
</table>

<script src="scripts.js"></script>
</body>
</html>
