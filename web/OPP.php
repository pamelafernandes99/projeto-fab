<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>1984 - Biblioteca Luar Dourado</title>
  <link rel="stylesheet" href="Style.css/slivro.css">
</head>
<body>
  <!--Menu de navegação side-->
  <?php include("sidebaron.php"); ?>
  <header>
    
    <h1>Biblioteca Luar Dourado</h1>
    <p>Alugue seu livro favorito com um toque de magia</p>
    <nav> <!-- Menu de navegação -->
        <!-- Cada link leva a uma seção da mesma página -->
        <ul>
        <a href="home.php">Início</a>
      </ul>
      </nav>
  </header>

  <div class="container">
    <img src="https://m.media-amazon.com/images/I/81TmOZIXvzL._SY466_.jpg" alt="Capa do livro O Pequeno Príncipe" class="book-cover">



    <div class="book-details">
      <h1>1984</h1>
      <p><span class="label">Autor:</span> Antoine de Saint-Exupéry</p>
      <p><span class="label">Gênero:</span> Fantasia e Ficção</p>
      <p><span class="label">Sinopse:</span>Nesta história que marcou gerações de leitores em todo o mundo, um piloto cai com seu avião no deserto do Saara e encontra um pequeno príncipe, que o leva a uma aventura filosófica e poética através de planetas que encerram a solidão humana.
      Um livro para todos os públicos, O pequeno príncipe é uma obra atemporal, com metáforas pertinentes e aprendizados sobre afeto, sonhos, esperança e tudo aquilo que é invisível aos olhos. 
        </p>

      <a href="aluguel.php" class="alugar-btn">Alugar este livro</a>
    </div>
  </div>

  <footer>
    &copy; 2025 Biblioteca Luar Dourado. Todos os direitos reservados.
  </footer>
</body>
</html>