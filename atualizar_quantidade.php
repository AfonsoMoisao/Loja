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

  // Consulta SQL para atualizar a quantidade de um produto
  $sql = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $produtoId";

  // Executar a consulta SQL
  if ($conn->query($sql) === TRUE) {
      echo "Quantidade atualizada no banco de dados para o produto com ID $produtoId!";
  } else {
      echo "Erro ao atualizar a quantidade do produto com ID $produtoId: " . $conn->error;
  }

  // Fechar a conexão com o banco de dados
  $conn->close();
}
?>