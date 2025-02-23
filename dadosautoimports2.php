<?php
$produtoId = $_POST['produtoId'];
$quantidade = $_POST['quantidade'];

// Verificar se os parâmetros estão presentes e são válidos
if (isset($produtoId) && isset($quantidade) && is_numeric($produtoId) && is_numeric($quantidade)) {
    // Conexão com o banco de dados
    $host = '127.0.0.1'; // Endereço do host do banco de dados
    $user = 'root'; // Nome de usuário do banco de dados
    $pass = ''; // Senha do banco de dados (vazio no seu caso)
    $db = 'autoimports'; // Nome da base de dados

    $conn = new mysqli($host, $user, $pass, $db);

    // Verificação de erros na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }   

    // Atualizar a quantidade do produto no banco de dados
    $query = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id = $produtoId";
    $result = $conn->query($query);

    if ($result) {
        // Verificar se algum registro foi atualizado
        if ($conn->affected_rows > 0) {
            // Retornar uma resposta JSON indicando sucesso
            $response = [
                'success' => true,
                'message' => 'Quantidade atualizada com sucesso.'
            ];
            echo json_encode($response);
        } else {
            // Retornar uma resposta JSON indicando que o produto não foi encontrado
            $response = [
                'success' => false,
                'message' => 'Produto não encontrado.'
            ];
            echo json_encode($response);
        }
    } else {
        // Retornar uma resposta JSON indicando erro na consulta
        $response = [
            'success' => false,
            'message' => 'Erro ao atualizar a quantidade: ' . $conn->error
        ];
        echo json_encode($response);
    }

    // Feche a conexão com o banco de dados
    $conn->close();
} else {
    // Retornar uma resposta JSON indicando parâmetros inválidos
    $response = [
        'success' => false,
        'message' => 'Parâmetros inválidos na requisição.'
    ];
    echo json_encode($response);
}
?>
