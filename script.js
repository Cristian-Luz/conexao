// Função responsável por enviar os dados do formulário para o servidor PHP
function inserirUsuario() {
    // Obter os valores de email e senha do formulário
    var email = document.getElementById('email').value;
    var senha = document.getElementById('senha').value;

    // Criar uma nova instância do objeto XMLHttpRequest para realizar a requisição HTTP
    var xhr = new XMLHttpRequest();

    // Especificar o URL do script PHP que irá processar os dados
    var url = 'inserir_usuario.php';

    // Formatar os parâmetros a serem enviados no formato 'application/x-www-form-urlencoded'
    var params = 'email=' + encodeURIComponent(email) + '&senha=' + encodeURIComponent(senha);

    // Configurar a requisição HTTP para ser assíncrona (true)
    xhr.open('POST', url, true);

    // Definir o cabeçalho 'Content-type' para indicar o tipo de dados sendo enviados
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Definir a função de retorno de chamada para ser executada quando o estado da requisição mudar
    xhr.onreadystatechange = function () {
        // Verificar se a requisição foi concluída (readyState == 4) e se o status HTTP é 200 (OK)
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Atualizar o conteúdo do elemento HTML com a resposta do servidor
            document.getElementById('resultado').innerHTML = xhr.responseText;
        }
    }

    // Enviar a requisição HTTP com os parâmetros
    xhr.send(params);
}

