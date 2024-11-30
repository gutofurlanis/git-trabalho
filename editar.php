<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'login');

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID do paciente foi passado
if (!isset($_GET['id'])) {
    $_SESSION['error_message'] = "Paciente não encontrado!";
    header('Location: site.php');
    exit;
}

// Recupera o ID do paciente
$id = $_GET['id'];
$id = $conn->real_escape_string($id);

// Buscar os dados do paciente
$sql = "SELECT * FROM pessoas WHERE id = $id";
$result = $conn->query($sql);

// Verifica se o paciente existe
if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "Paciente não encontrado!";
    header('Location: site.php');
    exit;
}

$paciente = $result->fetch_assoc();

// Processa a atualização do paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $carteirinha = $_POST['carteirinha_convenio'];
    $data_consulta = $_POST['data_consulta'];
    $hora_consulta = $_POST['hora_consulta'];

    // Atualiza os dados no banco de dados
    $update_sql = "UPDATE pessoas SET nome='$nome', email='$email', telefone='$telefone', cpf='$cpf', carteirinha_convenio='$carteirinha', data_consulta='$data_consulta', hora_consulta='$hora_consulta' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['success_message'] = "Paciente atualizado com sucesso!";
        header('Location: site.php');
        exit;
    } else {
        $_SESSION['error_message'] = "Erro ao atualizar paciente: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>

<!-- Barra lateral -->
<div class="sidebar">
    <h2>Editar Paciente</h2>
    <p>Edite os dados do paciente</p>
</div>

<!-- Conteúdo principal -->
<div class="main-content">
    <div class="container">

        <!-- Exibe mensagem de erro, caso exista -->
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error'>{$_SESSION['error_message']}</p>";
            unset($_SESSION['error_message']);
        }

        if (isset($_SESSION['success_message'])) {
            echo "<p class='success'>{$_SESSION['success_message']}</p>";
            unset($_SESSION['success_message']);
        }
        ?>

        <!-- Formulário de edição -->
        <!-- Formulário de edição -->
<form action="editar.php?id=<?php echo $paciente['id']; ?>" method="post">
    <div class="form-group">
        <div class="input-row">
            <div class="input-column">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $paciente['nome']; ?>" required>
            </div>
            <div class="input-column">
                <label for="carteirinha_convenio">Carteirinha do Convênio:</label>
                <input type="text" id="carteirinha_convenio" name="carteirinha_convenio" value="<?php echo $paciente['carteirinha_convenio']; ?>">
            </div>
        </div>

        <div class="input-row">
            <div class="input-column">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $paciente['email']; ?>" required>
            </div>
            <div class="input-column">
                <label for="data_consulta">Data da Consulta:</label>
                <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $paciente['data_consulta']; ?>" required>
            </div>
        </div>

        <div class="input-row">
            <div class="input-column">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $paciente['telefone']; ?>">
            </div>
            <div class="input-column">
                <label for="hora_consulta">Horário da Consulta:</label>
                <input type="time" id="hora_consulta" name="hora_consulta" value="<?php echo $paciente['hora_consulta']; ?>" required>
            </div>
        </div>

        <div class="input-row">
            <div class="input-column">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $paciente['cpf']; ?>" required>
            </div>
        </div>
    </div>
    <!-- Botão Voltar -->
    <a href="site.php" class="voltar">Voltar</a>

    <button type="submit" class="submit-button">Atualizar</button>
</form>
