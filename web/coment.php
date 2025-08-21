<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true || !isset($_SESSION['email'])) {
    header("Location: login.php");
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

if ($usuario_logado) {
    $_SESSION['id'] = $usuario_logado['id']; // garante que $_SESSION['id'] está definido corretamente
}

$livroSelecionado = $_GET['livro'] ?? null;
$livros = $conn->query("SELECT * FROM tb_livros");

// Inserir novo comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    $id_usuario = $_SESSION['id'];
    $id_livro = $_POST['id_livro'];
    $comentario = $_POST['comentario'];

    $stmt = $conn->prepare("INSERT INTO tb_comentarios (id_usuario, id_livro, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $id_usuario, $id_livro, $comentario);
    $stmt->execute();
}

// Listar comentários
$query = "SELECT c.*, u.usuario, l.titulo FROM tb_comentarios c 
          JOIN tb_cadastro u ON c.id_usuario = u.id 
          JOIN tb_livros l ON c.id_livro = l.id";
if ($livroSelecionado) {
    $query .= " WHERE l.id = " . intval($livroSelecionado);
}
$query .= " ORDER BY c.data_comentario DESC";
$comentarios = $conn->query($query);
?>

<link rel="stylesheet" href="comentstyle.css">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<header>
  <h1>Comentários</h1>
<nav>
    <ul>
        <a href="home.php"><i class='bx bx-home'></i> Início</a>
    </ul> 
</nav>

</header>

<style>
 

/* comentstyle.css - Estilo para páginas de comentários */

/* Variáveis de cores (consistente com página inicial) */
:root {
    --cor-primaria: #1b2c51;
    --cor-secundaria: #b8860b;
    --cor-texto-claro: #f8f5f0;
    --cor-texto-escuro: #333;
    --cor-fundo: #f8f5f0;
    --cor-destaque: #e6e6e6;
    --cor-borda: #d4d4d4;
}

header {
  background-color: #1b2c51;
  color: #f8f5f0;
  padding: 2rem 0;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  border-bottom: 5px solid #b8860b;
  background-image: url('https://images.unsplash.com/photo-1532012197267-da84d127e765?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
  background-size: cover;
  background-position: center;
  background-blend-mode: overlay;
}

header h1 {
  margin-bottom: 0rem;
  font-size: 2.5rem;
  font-family: 'Georgia', serif;
  letter-spacing: 1px;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

header p {
  font-style: italic;
  color: #b8860b;
  font-weight: bold;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

/* Estrutura base */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: var(--cor-fundo);
    color: var(--cor-texto-escuro);
    line-height: 1.6;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header/Nav - Estilo consistente */


nav ul {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    margin: 0;
}

nav ul a {
    margin: 0 1.5rem;
    position: relative;
    color: var(--cor-texto-claro);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.3s;
    font-weight: 500;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

nav ul a:hover {
    color: var(--cor-secundaria);
    background-color: rgba(255, 255, 255, 0.1);
}

nav ul a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background-color: var(--cor-secundaria);
    transition: width 0.3s;
}

nav ul a:hover::after {
    width: 100%;
}

/* Conteúdo principal */
main {
    flex: 1;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    width: 90%;
}

/* Formulários - Versão unificada e centralizada */
form {
    background-color: white;
    max-width: 700px;
    width: 90%; /* Adicionado para responsividade */
    margin: 0 auto 2rem; /* Centraliza horizontalmente e adiciona margem inferior */
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

select, textarea, button {
    width: 100%;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid var(--cor-borda);
    border-radius: 4px;
    font-family: inherit;
    font-size: 1rem;
}

select {
    cursor: pointer;
}

textarea {
    min-height: 120px;
    resize: vertical;
}

button {
    background-color: var(--cor-primaria);
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s;
}

button:hover {
    background-color: var(--cor-secundaria);
}

/* Filtro de livros */
form[method="get"] {
    background: none;
    box-shadow: none;
    padding: 1rem 0;
    text-align: center;
}

form[method="get"] select {
    max-width: 300px;
}

/* Comentários */
.comentario-box {
    background-color: white;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border-left: 4px solid var(--cor-secundaria);
}

.comentario-box strong {
    color: var(--cor-primaria);
}

.comentario-box em {
    color: var(--cor-secundaria);
    font-style: normal;
    font-weight: 500;
}

.comentario-box small {
    color: #666;
    font-size: 0.9rem;
}

.comentario-box p {
    margin: 1rem 0;
    padding: 0.5rem 0;
    border-top: 1px dashed var(--cor-borda);
    border-bottom: 1px dashed var(--cor-borda);
}

.comentario-box a {
    color: var(--cor-primaria);
    text-decoration: none;
    font-size: 0.9rem;
    margin-right: 1rem;
}

.comentario-box a:hover {
    color: var(--cor-secundaria);
    text-decoration: underline;
}

/* Página de edição */
h2 {
    color: var(--cor-primaria);
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

h2::after {
    content: '';
    position: absolute;
    width: 80px;
    height: 3px;
    background-color: var(--cor-secundaria);
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

/* Rodapé */
footer {
    background-color: var(--cor-primaria);
    color: var(--cor-texto-claro);
    text-align: center;
    padding: 1.5rem;
    margin-top: auto;
    border-top: 3px solid var(--cor-secundaria);
}

/* Responsividade */
@media (max-width: 768px) {
    main {
        padding: 1rem;
        width: 95%;
    }
    
    nav ul {
        flex-direction: column;
        align-items: center;
    }
    
    nav ul a {
        margin: 0.5rem 0;
    }
    
    form[method="get"] select {
        max-width: 100%;
    }
}

/* Estilos específicos para página de edição */
.form-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-cancelar {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background-color: #f1f1f1;
    color: #333;
    border-radius: 4px;
    text-align: center;
    transition: all 0.3s;
}

.btn-cancelar:hover {
    background-color: #e0e0e0;
    text-decoration: none;
}

/* Ajuste do textarea na edição */
form[method="post"] textarea {
    min-height: 200px;
    font-size: 1rem;
    line-height: 1.5;
}

/* Ícones nos botões */
button i, .btn-cancelar i {
    margin-right: 8px;
    vertical-align: middle;
}

/* Estilos para mensagens de alerta */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-weight: 500;
}

.erro {
    background-color: #ffebee;
    color: #c62828;
    border-left: 4px solid #c62828;
}

/* Melhoria no textarea */
textarea {
    min-height: 150px;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: inherit;
    font-size: 1rem;
    line-height: 1.5;
    width: 100%;
    resize: vertical;
}

/* Rodapé */
.footer-links,
.social-media {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
  margin-top: 10px;
}

.footer-links a,
.social-media a {
  color: #fdd835;
  text-decoration: none;
}

footer {
    background-color: #1b2c51;
    color: #fdd835;
    padding: 30px 20px;
    text-align: center;
    margin-top: auto; /* Isso empurra o footer para baixo */
    border-top: 3px solid var(--cor-secundaria);
}
    
</style>

<form method="get">
  <select name="livro" onchange="this.form.submit()">
    <option value="">Selecione para filtrar comentarios</option>
    <?php while ($livro = $livros->fetch_assoc()): ?>
      <option value="<?= $livro['id'] ?>" <?= ($livroSelecionado == $livro['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($livro['titulo']) ?>
      </option>
    <?php endwhile; ?>
  </select>
</form>

<?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
  <form method="post">
    <select name="id_livro" required>
      <option value="">Selecione o livro</option>
      <?php
      $livros->data_seek(0);
      while ($livro = $livros->fetch_assoc()): ?>
        <option value="<?= $livro['id'] ?>"><?= htmlspecialchars($livro['titulo']) ?></option>
      <?php endwhile; ?>
    </select><br>
    <textarea name="comentario" placeholder="Escreva seu comentário..." required></textarea><br>
    <button type="submit">Comentar</button>
  </form>
<?php else: ?>
  <p><em>Faça login para comentar.</em></p>
<?php endif; ?>


<?php while ($com = $comentarios->fetch_assoc()): ?>
  <div class="comentario-box">
    <strong><?= htmlspecialchars($com['usuario']) ?></strong> comentou sobre <em><?= htmlspecialchars($com['titulo']) ?></em><br>
    <small><?= date('d/m/Y H:i', strtotime($com['data_comentario'])) ?></small>
    <p><?= nl2br(htmlspecialchars($com['comentario'])) ?></p>
    <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $com['id_usuario']): ?>
      <a href="commentedit.php?id=<?= $com['id'] ?>">Editar</a> |
      <a href="comentdelet.php?id=<?= $com['id'] ?>" onclick="return confirm('Excluir comentário?')">Excluir</a>
    <?php endif; ?>
  </div>
<?php endwhile; ?>

 <footer>
    <p>&copy; 2025 Biblioteca Luar Dourado — Todos os direitos reservados</p>
    <div class="footer-links">
      <a href="home.php">Início</a>
      <a href="acervo.php">Acervo</a>
      <a href="home.php">Contato</a>
    </div>

</footer>