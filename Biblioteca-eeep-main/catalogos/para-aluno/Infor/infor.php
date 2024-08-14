<?php
require_once '../dependencies/config.php';

// Recuperar o título do livro da URL
$titulo = isset($_GET['titulo_livro']) ? $_GET['titulo_livro'] : '';

// Função para buscar a URL da capa do livro usando a Google Books API com cURL
function getBookCover($titulo)
{
    // Codificar o título para a URL
    $titulo = urlencode($titulo);
    $url = "https://www.googleapis.com/books/v1/volumes?q=intitle:" . $titulo;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return '../img/sem-foto.png'; // Retorna uma imagem padrão em caso de erro
    }

    curl_close($ch);
    
    $data = json_decode($response, true);

    if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
        $imageUrl = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
        return $imageUrl;
    }

    return '../img/sem-foto.png'; // Retorna uma imagem padrão se não encontrar a capa
}

// Buscar a capa do livro
$imagem = getBookCover($titulo);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Livro</title>
    <link rel="stylesheet" href="../Css/style-bibli.css">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../Css/infor.css">
    <style>
        .img-container img {
            width: auto;
            height: auto;
            max-width: 90%;
            max-height: 90vh;
            display: block;
            margin: 0 auto;
        }
        .main-infor {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <aside id="menu-Oculto" class="menu-Oculto">
            <div class="imagemMenu">
                <img src="../img/logoMenu.png" alt="Logo Menu" class="logoMenu">
                <button class="fechar" onclick="fecharMenu()">&times;</button>
            </div>
            <div class="linha"></div>
            <div class="opcoes">
                <a href="#">Cadastrar Livro</a>
                <a href="#">Cadastrar Empréstimo</a>
                <a href="#">Banco de Livros</a>
                <a href="#">Empréstimos</a>
                <a href="#">Adicionar Turma</a>
                <a href="#">Pedidos</a>
                <a href="#">Relatório</a>
                <a href="#" class="sair">Sair</a>
            </div>
        </aside>
        <section id="principal">
            <span style="font-size:43px;cursor:pointer" onclick="abrirMenu()">&#9776;</span>
            <div class="nav-logo">
                <img src="../img/logoEEEP.png" alt="Logo EEEP" class="logo_eeep" />
                <div class="ret"></div>
                <img src="../img/logoNav.png" alt="Logo Biblioteca" class="library" />
            </div>
        </section>
    </nav>
</header>

<div class="main-infor">
    <div class="main-container">
        <div class="img-container">
            <img src="<?php echo $imagem; ?>" alt="Capa do Livro">
        </div>
        <div class="form-container">
            <form action="">
                <div class="inputs">
                    <label for="#">TÍTULO DO LIVRO</label>
                    <input type="text" readonly value="oi">
                </div>
                <div class="inputs">
                    <label for="#">AUTOR</label>
                    <input type="text" readonly value="oi">
                </div>
                <div class="inputs">
                    <label for="#">STATUS</label>
                    <input type="text" readonly value="oi">
                </div>
                <div class="inputs">
                    <label for="#">GÊNERO</label>
                    <input type="text" readonly value="oi">
                </div>
            </form>
            <!-- Aqui você pode adicionar mais informações sobre o livro ou um formulário -->
        </div>
    </div>
</div>

</body>
</html>
