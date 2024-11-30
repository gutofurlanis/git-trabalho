<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'login');

// Verifica se a conexão com o banco de dados foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID do paciente foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Previne SQL Injection, utilizando prepared statements
    $stmt = $conn->prepare("DELETE FROM pessoas WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" para tipo inteiro
    if ($stmt->execute()) {
        // Mensagem de sucesso se o paciente for excluído
        $_SESSION['success_message'];
    } else {
        // Mensagem de erro caso a exclusão falhe
        $_SESSION['error_message'] = "Erro ao excluir paciente: " . $conn->error;
    }
    $stmt->close();
}

// Redireciona de volta para a página principal (site.php)
header('Location: site.php');
exit;

// Fecha a conexão com o banco de dados
$conn->close();
?>
