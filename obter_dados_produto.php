<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itensSelecionados'])) {
  $itensSelecionados = json_decode($_POST['itensSelecionados'], true);
  
  // Exemplo de código para inserir os dados em uma base de dados MySQL usando PDO:
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "autoimports";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->beginTransaction(); // Inicia uma transação

    foreach ($itensSelecionados as $item) {
      $produtoId = $item['id'];
      $quantidadeComprada = $item['quantidade'];

      // Verificar a quantidade disponível do produto na tabela "produtos"
      $sql = "SELECT quantidade FROM produtos WHERE id = :produtoId";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':produtoId', $produtoId);
      $stmt->execute();

      $quantidadeAtual = $stmt->fetchColumn();

      if ($quantidadeAtual >= $quantidadeComprada) {
        // Calcular a nova quantidade após a compra
        $novaQuantidade = $quantidadeAtual - $quantidadeComprada;

        // Atualizar a quantidade na tabela "produtos"
        $sql = "UPDATE produtos SET quantidade = :novaQuantidade WHERE id = :produtoId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':novaQuantidade', $novaQuantidade);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->execute();

        // Inserir os dados da compra na tabela "compras"
        $nome = $item['nome'];
        $preco = $item['preco'];
        $precoTotal = $quantidadeComprada * $preco;
        $sql = "INSERT INTO compras (ids, nome, quantidade, preco, preco_total) VALUES (:produtoId, :nome, :quantidadeComprada, :preco, :precoTotal)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':produtoId', $produtoId);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':quantidadeComprada', $quantidadeComprada);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':precoTotal', $precoTotal);
        $stmt->execute();
      } else {
        // A quantidade solicitada é maior do que a quantidade disponível
        throw new Exception("Quantidade insuficiente do produto com ID: $produtoId");
      }
    }

    $conn->commit(); // Confirmar a transação se todas as operações forem bem-sucedidas

    // Se chegou até aqui, a operação foi concluída com sucesso
    echo "Dados inseridos com sucesso na base de dados e quantidade atualizada.";
  } catch (PDOException $e) {
    $conn->rollBack(); // Reverter a transação em caso de erro
    echo "Erro ao inserir os dados na base de dados: " . $e->getMessage();
  } catch (Exception $e) {
    $conn->rollBack(); // Reverter a transação em caso de erro
    echo $e->getMessage();
  }

  // Finalizar o script
  exit();
}
?>
