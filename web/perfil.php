<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include("config.php"); // Conexão com o banco

$email_sessao = $_SESSION['email'];

// Buscar dados do usuário logado
$stmt = $conn->prepare("SELECT id, usuario, email, foto_nome FROM tb_cadastro WHERE email = ?");
$stmt->bind_param("s", $email_sessao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$usuario = $result->fetch_assoc();

// Variáveis para exibir no HTML
$id = $usuario['id'];
$nome_usuario = htmlspecialchars($usuario['usuario']);
$email = htmlspecialchars($usuario['email']);
$foto_nome = $usuario['foto_nome'];
$_SESSION['id'] = $id;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Georgia', serif;
            line-height: 1.6;
            color: #fff;
            background-color: #1b2c51;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1b2c51;
            color: #f8f5f0;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            border-bottom: 5px solid #b8860b;
            background-image: url('https://images.unsplash.com/photo-1588580000645-4562a6d2c839?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); /* Link direto de imagem */
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }

        .profile-container {
            max-width: 800px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        h2 {
            color: #fff;
            border-bottom: 2px solid #b8860b;
            padding-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        h3 {
            color: #ffffff;
            margin-top: 25px;
            font-size: 1.1em;
        }

        .profile-info p {
            margin: 10px 0;
            color: #fff;
        }

        .profile-picture {
            margin: 15px 0;
        }

        .profile-picture img {
            border-radius: 50%;
            border: 3px solid #b8860b;
            object-fit: cover;
            width: 150px;
            height: 150px;
        }

        form {
    margin: 0 auto 25px auto; /* Centraliza horizontalmente */
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 8px;
    max-width: 600px;
    
    display: flex;
    flex-direction: column;  /* Empilha os campos verticalmente */
    align-items: center;     /* Centraliza os campos no centro do form */
}

input[type="text"],
input[type="password"],
input[type="file"] {
    width: 90%;             /* Levemente menor que 100% para ficar estético */
    padding: 8px;
    margin: 6px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #f9f9f9;
    color: #000;
}

input[type="file"] {
    padding: 3px;
}

button, .btn {
    background-color: #b8860b;
    color: #1b2c51;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s;
    font-weight: bold;
    width: 90%;             /* Igual aos inputs */
    margin-top: 8px;
}

button:hover, .btn:hover {
    background-color: #d4b15f;
}

form[action="excluir_conta.php"] button {
    background-color: #e74c3c;
    color: white;
}

form[action="excluir_conta.php"] button:hover {
    background-color: #c0392b;
}

form[action="logout.php"] button {
    background-color: #7f8c8d;
    color: white;
}

form[action="logout.php"] button:hover {
    background-color: #34495e;
}

/* CORREÇÃO DA NAVEGAÇÃO (incluindo o botão início) */
nav {
    padding: 1rem;
    text-align: center;
    position: sticky;
    top: 0;
    z-index: 100;
}

nav ul {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
}

nav ul li {
    display: inline-block;
}

nav ul a {
    margin: 0 1rem;
    position: relative;
    color: #f8f5f0;
    text-decoration: none;
    padding: 0.6rem 1.2rem;
    border-radius: 4px;
    transition: all 0.3s;
    font-weight: 500;
    letter-spacing: 0.5px;
    display: inline-block;
    line-height: 1.5;
    text-align: center;
    min-width: 100px; /* Largura mínima para consistência */
}

/* Correção específica para o botão de início */
nav ul a[href="index.php"] {
    background-color: rgba(179, 153, 93, 0.2);
    border: 1px solid #b8860b;
}

nav ul a:hover {
    color: #b8860b;
    background-color: rgba(255, 255, 255, 0.1);
}

nav ul a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #b8860b;
    transition: width 0.3s;
}

nav ul a:hover::after {
    width: 80%;
}
        @media (max-width: 600px) {
            .profile-container {
                padding: 15px;
            }

            h2 {
                font-size: 1.5em;
            }

            form {
                padding: 15px;
            }

            .profile-picture img {
                width: 120px;
                height: 120px;
            }
        }

        p {
            text-align: center;
        }

        h3 {
            text-align: center;
        }

    </style>
</head>
<body>



<header>
    <h2>Meu Perfil</h2>
<nav>
    <ul>
        <a href="home.php"><i class='bx bx-home'></i> Início</a>
    </ul> 
</nav>


<div class="profile-container">
    <div class="profile-info">
        <p><strong>Foto de perfil:</strong></p>
        <?php if ($foto_nome && file_exists("fotos/$foto_nome")): ?>
            <div class="profile-picture">
                <img src="fotos/<?= htmlspecialchars($foto_nome) ?>" alt="Foto de perfil">
            </div>
            <p><strong>Email:</strong> <?= $email ?></p>
        <?php else: ?>
            <p>Nenhuma foto enviada</p>
        <?php endif; ?>
    </div>

    <h3>Alterar Foto</h3>
    <form method="post" action="alterar_foto.php" enctype="multipart/form-data">
        <input type="file" name="foto" accept="image/jpeg,image/png" required>
        <button type="submit">Enviar Foto</button>
    </form>

    <h3>Alterar Nome de Usuário</h3>
    <form method="post" action="alterar_usuario.php">
        <input type="text" name="novo_usuario" value="<?= $nome_usuario ?>" required maxlength="50">
        <button type="submit">Atualizar Nome</button>
    </form>

    <h3>Alterar Senha</h3>
    <form method="post" action="alterar_senha.php">
        <input type="password" name="senha_atual" placeholder="Senha atual" required>
        <input type="password" name="nova_senha" placeholder="Nova senha (mínimo 6 caracteres)" required>
        <button type="submit">Atualizar Senha</button>
    </form>

    <form method="post" action="logout.php">
        <button type="submit" name="sair">Sair</button>
    </form>

    <form method="post" action="excluir_conta.php" onsubmit="return confirm('Tem certeza que deseja excluir sua conta?');">
        <button type="submit" name="excluir">Excluir Conta</button>
    </form>
</div>
</header>

 <footer>
        <p>© 2025 Luar Dourado - Acervo Literário - Todos os direitos reservados</p>
    </footer>
</body>
