<?php
// Iniciar a sessão
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fonoaudiologia</title>
    <!-- Link do Font Awesome para os ícones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="fonoaudiologa.png" alt="Imagem Fonoaudiologia">
        </div>
        <div class="form-container">
            <h1>Login - Fonoaudiologia</h1>
            <p>Bem-vinda! Por favor, insira seus dados para acessar o sistema.</p>

            <!-- Exibe mensagens de sucesso ou erro -->
            <?php
            // Exibe a mensagem de sucesso, se houver
            if (isset($_SESSION['success_message'])) {
                echo "<p style='color: green; font-weight: bold;'>{$_SESSION['success_message']}</p>";
                unset($_SESSION['success_message']); // Limpa a mensagem após exibição
            }

            // Exibe a mensagem de erro, se houver
            if (isset($_SESSION['error_message'])) {
                echo "<p style='color: red; font-weight: bold;'>{$_SESSION['error_message']}</p>";
                unset($_SESSION['error_message']); // Limpa a mensagem após exibição
            }
            ?>

            <!-- Formulário de Login -->
            <form method="POST" action="db.php">
                <div class="input-group">
                    <label for="username">Usuário</label>
                    <div class="input-icon">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <input type="text" id="username" name="username" placeholder="Usuário" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <span class="icon"><i class="fa fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Senha" required>
                        <span class="toggle-password">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn-login">Entrar</button>
            </form>
        </div>
    </div>

    <!-- Script para mostrar/ocultar senha -->
    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            togglePassword.innerHTML = type === 'password'
                ? '<i class="fa fa-eye"></i>'
                : '<i class="fa fa-eye-slash"></i>';
        });
    </script>
</body>
</html>
