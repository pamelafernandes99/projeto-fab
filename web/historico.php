<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['email'])) {
    header("Location: inicial.php");
    exit;
}

include("config.php"); // Conexão com o banco

$email_sessao = $_SESSION['email'];

// Buscar ID do usuário logado
$stmt_cliente = $conn->prepare("SELECT id FROM tb_cadastro WHERE email = ?");
$stmt_cliente->bind_param("s", $email_sessao);
$stmt_cliente->execute();
$result_cliente = $stmt_cliente->get_result();
$usuario_logado = $result_cliente->fetch_assoc();

if (!$usuario_logado) {
    die("Usuário não encontrado!");
}

$cliente_id = $usuario_logado['id']; // Definindo a variável cliente_id corretamente
$_SESSION['id'] = $cliente_id; // Atualiza a sessão

// Consulta ao banco para buscar o histórico de aluguéis
$sql = "
    SELECT a.*, l.titulo 
    FROM tb_pedidos a
    JOIN tb_livros l ON a.livro_id = l.id
    WHERE a.cliente_id = ?
    ORDER BY a.data_pedido DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id); // Agora usando a variável definida
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados
if ($result->num_rows === 0) {
    $sem_resultados = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Histórico de Aluguéis</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="Style.css/historico.css" rel="stylesheet">
</head>
 <header>
<body>

    <h2 style="text-align:center;">Histórico de Aluguéis</h2>

        <nav>
    <ul>
        <a href="home.php"><i class='bx bx-home'></i> Início</a>
    </ul> 
</nav>


    </header>
    
    <?php if (isset($sem_resultados)): ?>
        <div class="sem-resultados">Nenhum aluguel encontrado em seu histórico.</div>
    <?php else: ?>
        <table>
            <tr>
                <th>Livro</th>
                <th>Dias</th>
                <th>Data do Aluguel</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['titulo']) ?></td>
                <td><?= $row['dias_aluguel'] ?> dias</td>
                <td><?= date("d/m/Y H:i", strtotime($row['data_pedido'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

     <!-- Rodapé da página -->
  <footer>
    <p>&copy; 2025 Biblioteca Luar Dourado — Todos os direitos reservados</p>
    <div class="footer-links">
      <a href="#inicio">Início</a>
      <a href="login.php">Acervo</a>
      <a href="#contato">Contato</a>
    </div>

</footer>
</body>
</html>