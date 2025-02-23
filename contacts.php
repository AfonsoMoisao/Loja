<?php
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

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados do formulário
    $name = $_POST['contact']['name'];
    $email = $_POST['contact']['email'];
    $phone = $_POST['contact']['phone'];
    $message = $_POST['contact']['message'];
    
    // Validação dos dados (você pode adicionar regras de validação adicionais aqui)

    // Construa a consulta SQL para inserção
    $sql = "INSERT INTO contacts (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    // Execute a consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }
}


    // Feche a conexão com o banco de dados
    $conn->close();

?>