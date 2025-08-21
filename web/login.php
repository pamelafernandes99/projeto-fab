<?php
$erro = $_GET['erro'] ?? ''; //Pega mensagem de erro (se existir ) passada por GET
?>
<link rel="stylesheet" href="Style.css/login.css">
    <div class="login-container">

     <style>

/* Container para os links */
.links-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    width: 100%;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Estilo dos links azuis */
.link-azul {
    color: #1b2c51; /* Azul escuro */
    text-decoration: none;
    font-weight: 500;
    padding: 8px 12px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.link-azul:hover {
    text-decoration: underline;
    background-color: rgba(27, 44, 81, 0.1); /* Azul claro de fundo ao passar mouse */
}

/* Responsividade para mobile */
@media (max-width: 480px) {
    .links-container {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .link-azul {
        text-align: center;
        width: 100%;
    }
}

    </style>

        <h2>Login</h2>
        <!--Exibe mensagem de erro , se houver-->
        <?php if ($erro): ?>
            <p class="erro"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>
        <form method="post" action="processa_login.php">
            <label>Email:</label>
            <input type="text" name="email" required>
            <label>Senha:</label>
            <input type="password" name="senha" required>
            <input type="submit" value="Entrar">
        </form>


        <div class="links-container">
            <a href="inicial.php" class="cadastro">Voltar ao inicio</a>
        <a href="inscrever.php">Não tem conta? | Cadastre-se</a>
    </div>