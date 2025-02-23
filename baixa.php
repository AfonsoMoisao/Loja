<?php
// Função para atualizar a quantidade de um produto no banco de dados
function atualizarQuantidadeNoBanco($produtoId, $quantidade) {
  // Configurações do banco de dados
  $host = '127.0.0.1';
  $user = 'root';
  $pass = '';
  $db = 'autoimports';

  // Conexão com o banco de dados
  $conn = new mysqli($host, $user, $pass, $db);

  // Verificação de erros na conexão
  if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
  }

  // Consulta SQL para verificar a quantidade disponível no estoque
  $verificarEstoque = "SELECT quantidade FROM produtos WHERE id = $produtoId";
  $resultadoEstoque = $conn->query($verificarEstoque);

  if ($resultadoEstoque->num_rows > 0) {
    $row = $resultadoEstoque->fetch_assoc();
    $estoqueAtual = $row["quantidade"];

    if ($estoqueAtual >= $quantidade) {
      // Consulta SQL para atualizar a quantidade de um produto
      $sql = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $produtoId";

      // Executar a consulta SQL
      if ($conn->query($sql) === TRUE) {
          echo "Quantidade atualizada no banco de dados para o produto com ID $produtoId!";
      } else {
          echo "Erro ao atualizar a quantidade do produto com ID $produtoId: " . $conn->error;
      }
    } else {
      echo "Não há unidades suficientes do produto com ID $produtoId disponíveis no estoque.";
    }
  }

  // Fechar a conexão com o banco de dados
  $conn->close();
}


function realizarCompra() {
  // Converter os dados JSON de volta para um array PHP
  $itensSelecionados = json_decode($_POST['itensSelecionados'], true);

  // Atualizar a quantidade de produtos no banco de dados para cada item no carrinho
  foreach ($itensSelecionados as $item) {
    $produtoId = $item['id'];
    $quantidade = $item['quantidade'];
    atualizarQuantidadeNoBanco($produtoId, $quantidade);
  }

  // Exibir mensagem de compra realizada
  echo "Compra realizada com sucesso!";

  // Exibir o ID e a quantidade de cada item
  foreach ($itensSelecionados as $item) {
    $produtoId = $item['id'];
    $quantidade = $item['quantidade'];

    echo "ID do produto: " . $produtoId . "<br>";
    echo "Quantidade: " . $quantidade . "<br>";
  }

  // Limpar o carrinho
  $itensSelecionados = [];

  // Remover os itensSelecionados do armazenamento local
  echo '<script>localStorage.removeItem("itensSelecionados");</script>';

  // Chamar a função exibirCarrinho() para atualizar a exibição do carrinho
  echo '<script>exibirCarrinho();</script>';
}
?>
