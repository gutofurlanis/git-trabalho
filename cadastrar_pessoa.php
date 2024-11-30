<?php

// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Altere conforme necessário
$password = "";     // Altere conforme necessário
$database = "login"; // Nome do banco de dados



$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processar o envio do formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $carteirinha = $_POST['carteirinha_convenio'];
    $data_consulta = $_POST['data_consulta']; // Novo campo
    $hora_consulta = $_POST['hora_consulta']; // Novo campo

    // Validar campos obrigatórios
    if (empty($nome) || empty($email) || empty($cpf) || empty($data_consulta) || empty($hora_consulta)) {
        $_SESSION['error_message'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: cadastrar_pessoa.php"); // Redireciona de volta para o formulário com erro
        exit;
    }

    // Inserir no banco de dados
    $sql = "INSERT INTO pessoas (nome, email, telefone, cpf, carteirinha_convenio, data_consulta, hora_consulta) 
            VALUES ('$nome', '$email', '$telefone', '$cpf', '$carteirinha', '$data_consulta', '$hora_consulta')";

    if ($conn->query($sql) === TRUE) {
        // Mensagem de sucesso
        $_SESSION['success_message'];
        // Redireciona para a página inicial após o cadastro
        header("Location: site.php");
        exit();
    } else {
        // Caso de erro no banco de dados
        $_SESSION['error_message'] = "Erro ao cadastrar paciente: " . $conn->error;
        header("Location: cadastrar_pessoa.php"); // Redireciona para o formulário com erro
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="cadastrar.css">
</head>
<body>

<!-- Barra lateral -->
<div class="sidebar">
    <h2>Cadastro de Paciente</h2>
    <p>Adicione os dados do paciente</p>    
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

        <!-- Formulário de cadastro -->
        <form action="cadastrar_pessoa.php" method="post">
            <div class="column">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required><br>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone"><br>

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required><br>
            </div>

            <div class="column">
                <label for="carteirinha_convenio">Carteirinha do Convênio:</label>
                <input type="text" id="carteirinha_convenio" name="carteirinha_convenio"><br>

                <label for="data_consulta">Data da Consulta:</label>
                <input type="date" id="data_consulta" name="data_consulta" required><br>

                <label for="hora_consulta">Horário da Consulta:</label>
                <input type="time" id="hora_consulta" name="hora_consulta" required><br>
            </div>

            <button type="submit">Cadastrar</button>
        </form>

        <!-- Botão Voltar -->
        <a href="site.php" class="voltar">Voltar</a>

    </div>
</div>

</body>
</html>
