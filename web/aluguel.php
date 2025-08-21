<?php
session_start();
include("config.php");

// Se for requisição AJAX de busca
if (isset($_GET['q'])) {
    $q = "%" . $_GET['q'] . "%";
    
    $stmt = $conn->prepare("SELECT id, titulo FROM tb_livros WHERE titulo LIKE ?");
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $livros = [];
    while ($row = $result->fetch_assoc()) {
        $livros[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($livros);
    exit;
}

// Verifica se o cliente está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email_sessao = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livro_id'])) {
    $livro_id = intval($_POST['livro_id']);
    $dias_aluguel = intval($_POST['dias_aluguel']);
    $data_pedido = date('Y-m-d');

    // Buscar cliente
    $stmt_cliente = $conn->prepare("SELECT id FROM tb_cadastro WHERE email = ?");
    $stmt_cliente->bind_param("s", $email_sessao);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();

    if ($result_cliente->num_rows > 0) {
        $cliente = $result_cliente->fetch_assoc();
        $cliente_id = $cliente['id'];

        // Verifica se livro existe
        $stmt_livro = $conn->prepare("SELECT id FROM tb_livros WHERE id = ?");
        $stmt_livro->bind_param("i", $livro_id);
        $stmt_livro->execute();
        $result_livro = $stmt_livro->get_result();

        if ($result_livro->num_rows > 0) {
            $stmt = $conn->prepare("INSERT INTO tb_pedidos (cliente_id, livro_id, dias_aluguel, data_pedido) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $cliente_id, $livro_id, $dias_aluguel, $data_pedido);

            $mensagem = $stmt->execute() ? "Pedido realizado com sucesso!" : "Erro ao realizar o pedido.";
            $stmt->close();
        } else {
            $mensagem = "Livro não encontrado.";
        }
        $stmt_livro->close();
    } else {
        $mensagem = "Cliente não encontrado.";
    }
    $stmt_cliente->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Fazer Pedido</title>
    <link rel="stylesheet" href="Style.css/aluguel.css">
</head>
 
<body>
   

<div class="container">
    <h1>Fazer Pedido de Livro</h1>

    <?php if (isset($mensagem)): ?>
        <p><strong><?= $mensagem ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label for="livro_pesquisa">Pesquisar livro:</label><br>
        <input type="text" id="livro_pesquisa" name="livro_titulo" list="lista_livros" autocomplete="off" required>
        <datalist id="lista_livros"></datalist>
        <input type="hidden" name="livro_id" id="livro_id">
        <br><br>

        <label for="dias_aluguel">Quantidade de dias:</label><br>
        <input type="number" name="dias_aluguel" min="1" max="15" required><br><br>

        <button type="submit">Fazer Pedido</button>
    </form>

    <form method="post" action="home.php">
        <button type="submit" name="inicio">Início</button>
    </form>
</div>
   

<script>
document.getElementById("livro_pesquisa").addEventListener("input", function () {
    const input = this.value;
    const datalist = document.getElementById("lista_livros");

    if (input.length < 2) return;

    fetch(`aluguel.php?q=${encodeURIComponent(input)}`)
        .then(res => res.json())
        .then(data => {
            datalist.innerHTML = "";
            data.forEach(livro => {
                const option = document.createElement("option");
                option.value = livro.titulo;
                option.setAttribute("data-id", livro.id);
                datalist.appendChild(option);
            });
        });
});

document.getElementById("livro_pesquisa").addEventListener("change", function () {
    const input = this.value;
    const datalist = document.getElementById("lista_livros").options;
    let livroId = "";

    for (let i = 0; i < datalist.length; i++) {
        if (datalist[i].value === input) {
            livroId = datalist[i].getAttribute("data-id");
            break;
        }
    }

    document.getElementById("livro_id").value = livroId;
});
</script>
</body>
</html>