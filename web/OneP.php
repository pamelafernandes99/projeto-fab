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
    <img src="https://m.media-amazon.com/images/I/51Ghk-Ret0L._SY445_SX342_.jpg" alt="Capa do livro One Piece Vol. 1" class="book-cover">



    <div class="book-details">
      <h1>One Piece Vol. 1</h1>
      <p><span class="label">Autor:</span> Eiichiro Oda </p>
      <p><span class="label">Gênero:</span> HQs e Mangás</p>
      <p><span class="label">Sinopse:</span>A tripulação pirata mais famosa dos quadrinhos finalmente joga sua âncora de novo no Brasil! Com roteiro e arte de Eiichiro Oda, o mangá de maior sucesso de todos os tempos retorna ao país, agora sob a bandeira Planet Mangá, da Panini Comics! Para ser o rei dos piratas, Luffy, o homem-borracha, precisa reunir uma tripulação e encontrar o maior de todos os tesouros. No caminho, enfrentará a Marinha, monstros, e muitos outros piratas que têm o mesmo objetivo. Então prepare-se pra encarar os perigos dos mares. A maior aventura de todas vai recomeçar! </p>

      <a href="aluguel.php" class="alugar-btn">Alugar este livro</a>
    </div>
  </div>

  <footer>
    &copy; 2025 Biblioteca Luar Dourado. Todos os direitos reservados.
  </footer>
</body>
</html>