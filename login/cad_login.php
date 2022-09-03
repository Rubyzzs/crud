<?php
//inclui o codigo do conexão no arquivo cadastar
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login : : Cadastro</title>
  
    <link rel="stylesheet" href="../../crud/css/grids.css">
    <link rel="stylesheet" href="../../crud/css/formulario.css">   
    <link rel="stylesheet" href="../../crud/css/estilo.css">   

</head>
<body>
    <div class="container">
        <div class="row centralizar-h">
            <ul class="centralizar-v">
                <a href="index.php"><li>HOME</li></a>
                <a href="cad_login.php"><li>CADASTRO</li></a>
                <a href="index.php"><li>VISUALIZAR</li></a>
                <a href="index.php"><li>LOGOUT</li></a>
            </ul>
        </div>        
    </div> 
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


                //echo $dados['nome'];
                //echo $dados['email'];
                //echo $dados['endereco'];
                //echo $dados['telefone'];
                //echo $dados['senha'];

                //query para inserir no banco  passando o nome e email como parametro pelo PDO
                $query_usuario = "INSERT INTO funcionario (`nomeFUN`, emailFUN, cnpjFUN, telFUN) VALUES (:nome, :email, :cnpj, :tel) ";
                //prepara a query com a conexão
                $cad_usuario = $conn->prepare($query_usuario);

                //todos os atributos do 'name' do formul
                $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
                $cad_usuario->bindParam(':tel', $dados['tel'], PDO::PARAM_STR);
               // $cad_usuario->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);

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
  
    <div class="espaco-v"></div> <!--abre um espaço entre os containers-->

    <form action="" method="POST" enctype="multipart/form-data">
       
        <div class="container">
            <div class="container">
                <div class="row-flex">  
                    <div class="col-2">
                        <img src="./imagens/_fotoFeliz.jpg" alt="Foto do usuário"  
                        style="border-radius:8px; max-width:100%;">
                    </div>              
                    <div class="col-2 centralizar-v" >
                        <input type="file" name="foto" id="foto" class="inputfile">
                        <label for="foto">Foto</label>
                    </div>
                    <div class="col-6 centralizar-h centralizar-v">
                        <h1 style="font-size: 70px;">Cadastro de Usuários</h1>
                    </div>        
                </div>

                <div class="centralizar-h">
                    <hr style="margin-top: 50px; width:100%; border: 1px dotted #ccc;">
                </div>

                <div class="row">
                    <div class="col-10">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" 
                            placeholder="Nome completo do usuário">
                    </div>
                </div>

                <div class="row">                
                    <div class="col-10">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" 
                                placeholder="Email comercial">
                    </div>
                </div>     
                <div class="row">                
                    <div class="col-10">
                        <label for="cnpj">Cnpj</label>
                        <input type="text" name="cnpj" id="cnpj" 
                                placeholder="Email comercial">
                    </div>
                </div>             
                <!--<div class="row-flex">
                    <div class="col">
                        <label for="endereco">Endereço</label>
                        <input type="text" name="endereco" id="endereco" 
                                placeholder="Endereço de contato"> 
                    </div> -->

                    <div class="col">
                        <label for="telefone">Telefone</label>
                        <input type="tel" name="tel" id="fone" 
                                placeholder="telefone comercial">
                    </div>
                </div>

              <!-- <div class="row">                
                    <div class="col-10">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" 
                                placeholder="Email comercial">
                    </div>
                </div> -->

               <!-- <div class="row-flex">                
                    <div class="col">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha1"  placeholder="Senha com 8 digitos">
                    </div>

                    <div class="col">
                        <label for="senha2">Confirmação de senha</label>
                        <input type="password" name="senha2" id="senha2" placeholder="Confirmação de senha">
                    </div>
                </div> -->

                <div class="row-flex">                
                    <div class="col">
                        <label for="nivel">Nível</label>
                        <select name="nivel" id="nivel">
                            <option value="1">Usuário</option>                    
                            <option value="2">Administrador</option>                    
                        </select>
                    </div>
                    <div class="col">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="1">Desativado</option>                    
                            <option value="2">Ativado</option>                    
                        </select>
                    </div>
                </div>
                <div class="centralizar-h">
                    <hr style="margin: 30px; width:80%;">
                </div>

                <div class="row">
                    <div class="col-10 centralizar-h">
                        <input type="reset" value="Limpar">
                        <input type="submit" value="Cadastrar" name="CadUsuario">
                    </div>
                </div>                    
            </div>
        </div>
    </form>

    <div class="container">
        <div class="row centralizar-h" style="background-color: #ddd; padding:30px; border-radius:5px;">
           <!-- <h2>Desenvolvedor | ronnie : : 1sem2022</h2>
    -->
        </div>        
    </div> 
</body>
</html>