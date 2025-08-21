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
    <img src="https://m.media-amazon.com/images/I/819js3EQwbL._SY466_.jpg" alt="Capa do livro 1984" class="book-cover">



    <div class="book-details">
      <h1>1984</h1>
      <p><span class="label">Autor:</span> George Orwell</p>
      <p><span class="label">Gênero:</span> Literatura e Ficção</p>
      <p><span class="label">Sinopse:</span>Winston, herói de 1984, último romance de George Orwell, vive aprisionado na engrenagem totalitária de uma sociedade completamente dominada pelo Estado, onde tudo é feito coletivamente, mas cada qual vive sozinho. Ninguém escapa à vigilância do Grande Irmão, a mais famosa personificação literária de um poder cínico e cruel ao infinito, além de vazio de sentido histórico. De fato, a ideologia do Partido dominante em Oceânia não visa nada de coisa alguma para ninguém, no presente ou no futuro. O'Brien, hierarca do Partido, é quem explica a Winston que "só nos interessa o poder em si. Nem riqueza, nem luxo, nem vida longa, nem felicidade: só o poder pelo poder, poder puro".
        </p>

      <a href="aluguel.php" class="alugar-btn">Alugar este livro</a>
    </div>
  </div>

  <footer>
    &copy; 2025 Biblioteca Luar Dourado. Todos os direitos reservados.
  </footer>
</body>
</html>