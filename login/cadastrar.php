
<?php
//inclui o codigo do conexão no arquivo cadastar
//include_once './conexao.php';
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Celke - Cadastrar</title>
    </head>
    <body>
        <h1>Cadastrar</h1>
        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão Cadastrar
        if (!empty($dados['CadUsuario'])) {
            //var_dump($dados);

            $empty_input = false;
            $dados = array_map('trim', $dados);

            //Valida os campos Nome e email, se tem informação
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher com e-mail válido!</p>";
            }
            //------------------------------// 

            //Apos validação verifica se $empty_input é true ou false
            // se true faltou alguma informação nos campos
            // false vai inserir no banco e enra no if
            if (!$empty_input) {

                //query para inserir no banco  passando o nome e email como parametro pelo PDO
                $query_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email) ";
                //prepara a query com a conexão
                $cad_usuario = $conn->prepare($query_usuario);

                //pega os dados dos campos nome e email e vincula nos paramentros nome e email
                $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);

                //Executa a query no banco e insere os dados na tabela usuarios
                $cad_usuario->execute();

                //Valida se teve algum problema ao inserir no banco de dados
                //Caso retorne uma linha indica que inseriu no banco  (rowCount)
                //Caso contrario informa o erro de não cadastrado
                if ($cad_usuario->rowCount()) {
                    echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
                    unset($dados);
                } else {
                    echo "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
                }
            }
        }
        ?>
        <form name="cad-usuario" method="POST" action="">
            <label>Nome: </label>
            <input type="text" name="nome" id="nome" placeholder="Nome completo" value="<?php
            if (isset($dados['nome'])) {
                echo $dados['nome'];
            }
            ?>"><br><br>

            <label>E-mail: </label>
            <input type="email" name="email" id="email" placeholder="Seu melhor e-mail" value="<?php
            if (isset($dados['email'])) {
                echo $dados['email'];
            }
            ?>"><br><br>

            <input type="submit" value="Cadastrar" name="CadUsuario">
        </form>
    </body>
</html>
