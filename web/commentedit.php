<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['id'])) {
    die("Acesso negado.");
}

$id_comentario = $_GET['id'] ?? null;
if (!$id_comentario) {
    die("ID inválido.");
}

// Buscar o comentário
$stmt = $conn->prepare("SELECT * FROM tb_comentarios WHERE id = ?");
$stmt->bind_param("i", $id_comentario);
$stmt->execute();
$result = $stmt->get_result();
$comentario = $result->fetch_assoc();

if (!$comentario || $comentario['id_usuario'] != $_SESSION['id']) {
    die("Você não tem permissão para editar este comentário.");
}

// Atualizar comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoTexto = $_POST['comentario'];
    $update = $conn->prepare("UPDATE tb_comentarios SET comentario = ? WHERE id = ?");
    $update->bind_param("si", $novoTexto, $id_comentario);
    $update->execute();
    header("Location: coment.php");
    exit;
}
?>

<style>
        :root {
            --cor-primaria: #1b2c51;
            --cor-secundaria: #b8860b;
            --cor-texto-claro: #f8f5f0;
            --cor-texto-escuro: #333;
            --cor-fundo: #f8f5f0;
            --cor-destaque: #e6e6e6;
            --cor-borda: #d4d4d4;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--cor-fundo);
            color: var(--cor-texto-escuro);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .edit-container {
            width: 100%;
            max-width: 700px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .edit-header {
            background-color: var(--cor-primaria);
            color: var(--cor-texto-claro);
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .edit-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .edit-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--cor-secundaria);
        }

        .edit-form {
            padding: 2rem;
        }

        .comment-content {
            margin-bottom: 1.5rem;
        }

        .comment-textarea {
            width: 100%;
            min-height: 200px;
            padding: 1rem;
            border: 1px solid var(--cor-borda);
            border-radius: 4px;
            font-family: inherit;
            font-size: 1rem;
            line-height: 1.5;
            resize: vertical;
            transition: border-color 0.3s;
        }

        .comment-textarea:focus {
            outline: none;
            border-color: var(--cor-primaria);
            box-shadow: 0 0 0 2px rgba(27, 44, 81, 0.2);
        }

        .form-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--cor-primaria);
            color: white;
        }

        .btn-primary:hover {
            background-color: #143265;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--cor-destaque);
            color: var(--cor-texto-escuro);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background-color: #d6d6d6;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }
            
            .edit-container {
                border-radius: 0;
            }
            
            .edit-form {
                padding: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="edit-container">
            <div class="edit-header">
                <h2>Editar Comentário</h2>
            </div>
            
            <form method="post" class="edit-form">
                <div class="comment-content">
                    <textarea 
                        name="comentario" 
                        class="comment-textarea"
                        required
                    ><?= htmlspecialchars($comentario['comentario']) ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="coment.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>