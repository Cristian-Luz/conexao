<?php
// Configurações de conexão com o banco de dados Oracle
$host = 'localhost';
$port = '1521';
$sid  = 'XEPDB1';
$user = 'hr';
$pass = 'hr';

// Construir a string de conexão usando TNS (Transparent Network Substrate)
$tns = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST={$host})(PORT={$port}))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME={$sid})))";

// Estabelecer a conexão com o banco de dados Oracle
$conn = oci_connect($user, $pass, $tns);

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    $e = oci_error();
    echo "Erro na conexão com o banco de dados: " . htmlentities($e['message'], ENT_QUOTES) . "\n";
} else {
    // Obter os valores de email e senha do formulário enviado via método POST
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Preparar a consulta SQL para inserir um novo usuário na tabela USUARIOS
    $sql = "INSERT INTO USUARIOS (EMAIL, SENHA) VALUES (:email, :senha)";
    $stmt = oci_parse($conn, $sql);

    // Associar os parâmetros da consulta SQL com as variáveis PHP
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':senha', $senha);

    // Executar a consulta SQL e confirmar a transação em caso de sucesso
    $result = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

    // Verificar o resultado da execução da consulta e fornecer feedback ao usuário
    if ($result) {
        echo "Usuário inserido com sucesso na tabela!";
    } else {
        $e = oci_error($stmt);
        echo "Erro ao inserir o usuário: " . htmlentities($e['message'], ENT_QUOTES);
    }

    // Fechar a conexão com o banco de dados Oracle
    oci_close($conn);
}
?>
