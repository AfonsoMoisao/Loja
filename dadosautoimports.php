<?php
$host = '127.0.0.1'; // Endereço do host do banco de dados
$user = 'root'; // Nome de usuário do banco de dados
$pass = ''; // Senha do banco de dados (vazio no seu caso)
$db = 'autoimports'; // Nome da base de dados

    // Conexão com o banco de dados
    $conn = new mysqli($host, $user, $pass, $db);

    // Verificação de erros na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }


    // Código adicional aqui para executar consultas e interagir com o banco de dados
    // Consulta de teste
    $query = "SELECT * FROM produtos";
    $result = $conn->query($query);


    if ($result) {
        // Verificar se há resultados
        if ($result->num_rows > 0) {
            // Iterar sobre os resultados e exibir os dados
            while ($row = $result->fetch_assoc()) {
                echo "Nome: " . $row["nome"] . "<br>";
                echo "Descrição: " . $row["descricao"] . "<br>";
                echo "Preço: " . $row["preco"] . "<br>";
                echo "Quantidade-Disponivel: " . $row["quantidade"] . "<br><br>";
            }
        } else {
            echo "Nenhum produto encontrado na tabela.";
        }
    } else {
        echo "Erro ao executar a consulta: " . $conn->error;
    }



    // Código adicional aqui para executar consultas e interagir com o banco de dados
    // Consulta de teste
    $query = "SELECT * FROM produtos WHERE id = 15";
    $result = $conn->query($query);

     // Verifique se foi encontrado um produto com o ID fornecido
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Construa um array com os dados do produto
    $produto = [ 
      'nome' => $row['nome'],
      'descricao' => $row['descricao'],
      'preco' => $row['preco'],
      'quantidadeDisponivel' => $row['quantidade']

    ];
}
    $quantidadeDisponivel_id15 = $row['quantidade'];

    // Converta o valor em JSON e envie para o navegador
    echo json_encode($quantidadeDisponivel_id15);




    // Código adicional aqui para executar consultas e interagir com o banco de dados
    // Consulta de teste
    $query = "SELECT * FROM produtos WHERE id = 16";
    $result = $conn->query($query);

     // Verifique se foi encontrado um produto com o ID fornecido
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Construa um array com os dados do produto
    $produto = [ 
      'nome' => $row['nome'],
      'descricao' => $row['descricao'],
      'preco' => $row['preco'],
      'quantidadeDisponivel' => $row['quantidade']

    ];
}
    $quantidadeDisponivel_id16 = $row['quantidade'];


    // Converta o valor em JSON e envie para o navegador
    //echo json_encode($quantidadeDisponivel_id16);
    echo '<script>var quantidadeDisponivel_id16 = ' . $quantidadeDisponivel_id16 . ';</script>';



    // Feche a conexão com o banco de dados
    $conn->close();

?>