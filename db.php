<?php
session_start();

// Exibir erros para depuração (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização dos inputs
    $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Validar campos vazios
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'Preencha todos os campos.';
        header('Location: login.php'); // Redireciona para a página de login
        exit();
    }

    // Buscar o usuário no banco de dados
    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar se o usuário foi encontrado
    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['error_message'] = 'Usuário ou senha inválidos.';
        header('Location: index.php'); // Redireciona para a página de login
        exit();
    }

    // Autenticar o usuário e redirecionar
    $_SESSION['usuario_id'] = $user['id']; // Armazena o id do usuário logado
    $_SESSION['username'] = $user['username']; // Armazena o nome de usuário
    header('Location: site.php'); // Redireciona para o site
    exit();
}

// Fechar conexão com o banco
$conn->close();
?>
