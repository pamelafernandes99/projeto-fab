<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
    <link rel="stylesheet" href="Style.css/inscrever.css">
</head>
<body>
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
        <h2>Cadastro</h2>
        <!-- Formulario de cadastro-->
        <form method="post" action="processa_inscricao.php" enctype="multipart/form-data">
        <!-- Sem o enctype, o arquivo não vai-->
            <label>Foto de Perfil:</label>
            <input type="file" name="foto" accept="image/*">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>
            <label>Email:</label>
            <input type="text" name="email" required>
            <label>Senha:</label>
            <input type="password" name="senha" required>
            <input type="submit" value="Cadastrar">
        </form>

       
        <!-- Link login--> 

        <div class="links-container">
       
     <a href="home.php" class="link-azul">Voltar ao início</a>
            <a href="login.php" class="link-azul">Já tem conta? Faça login</a>
    </div>
</body>
</html>
