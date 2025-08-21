<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Harry Potter - Biblioteca Luar Dourado</title>
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
    <img src="https://m.media-amazon.com/images/I/81YOuOGFCJL.jpg" alt="Capa do livro Harry Potter" class="book-cover">



    <div class="book-details">
      <h1>Harry Potter e a Pedra Filosofal</h1>
      <p><span class="label">Autor:</span> J.K. Rowling</p>
      <p><span class="label">Gênero:</span> Fantasia, Aventura</p>
      <p><span class="label">Sinopse:</span> Harry Potter descobre, aos 11 anos, que é um bruxo e recebe uma carta para estudar na famosa Escola de Magia e Bruxaria de Hogwarts. Lá, ele faz amigos leais, descobre segredos sobre seu passado e enfrenta forças obscuras que ameaçam o mundo mágico. O primeiro livro da série nos leva a um universo encantador, repleto de mistérios e aventuras.</p>

      <a href="aluguel.php" class="alugar-btn">Alugar este livro</a>
    </div>
  </div>

  <footer>
    &copy; 2025 Biblioteca Luar Dourado. Todos os direitos reservados.
  </footer>
</body>
</html>