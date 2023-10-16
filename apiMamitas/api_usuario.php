<?php
    require_once 'headers.php';
    
    require_once 'conexao.php';
   
    date_default_timezone_set('America/Sao_Paulo');
    @session_start();

    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['id'])){
            $id = $con->real_escape_string($_GET['id']);
            $sql = $con->query("select * from usuario where id = '$id'");
            $data = $sql->fetch_assoc();
        } // ------ isset para verificar e pegar o email 
        else if(isset($_GET['email'])) {
            $email= $con->real_escape_string($_GET['email']);
            $sql = $con->query("select * from usuario where email = '$email'");
            $data = $sql->fetch_assoc();
        } // ------- isset para verificar e pegar o cpf
        else if(isset($_GET['cpf'])) {
            $cpf= $con->real_escape_string($_GET['cpf']);
            $sql = $con->query("select * from usuario where cpf = '$cpf'");
            $data = $sql->fetch_assoc();
        }//-----------
        else{
            $data = array();
            $sql = $con->query("select * from usuario");
              while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
       
        }
        exit(json_encode($data));//json_encode( $arr, JSON_NUMERIC_CHECK );
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data  = json_decode(file_get_contents("php://input"));
        //-----Criptografando da senha
            $senha = password_hash($data->senha, PASSWORD_DEFAULT);
        //-----
        $sql = $con->query("insert into usuario (nome, sobrenome, cpf, telefone, email, senha, cep, rua, numero, bairro) values ('".$data->nome."','".$data->sobrenome."','".$data->cpf."','".$data->telefone."','".$data->email."','".$senha."', '".$data->cep."','".$data->rua."','".$data->numero."','".$data->bairro."')");   
        if($sql){
            $data->id = $con->insert_id;
            exit(json_encode($data));

        }else{
            exit(json_decode(array('status' => 'Deu ruim')));
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        if(isset($_GET['id'])){
            // a função real_escape_string remove quaisquer caracteres especiais que possam interferir nas operações de consulta
            $id = $con->real_escape_string($_GET['id']);
            $data = json_decode(file_get_contents("php://input"));
            //-----Criptografando da senha
            $senha = password_hash($data->senha, PASSWORD_DEFAULT);
        //-----
            $sql = $con->query("update usuario set nome = '".$data->nome."', sobrenome = '".$data->sobrenome."', cpf = '".$data->cpf."', telefone = '".$data->telefone."', email = '".$data->email."',  senha = '".$senha."', cep = '".$data->cep."', rua = '".$data->rua."', numero = '".$data->numero."', bairro = '".$data->bairro."' where id = '$id'");
            if($sql){
                exit(json_encode(array('status'=> 'successo')));
            }else{
                // vamos testar um erro no código acima
                exit(json_encode(array('status'=> 'Deu ruim')));
            }
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        if(isset($_GET['id'])){
            $id = $con->real_escape_string($_GET['id']);
            $sql = $con->query("delete from usuario where id = '$id'");
        
            if($sql){
                exit(json_encode(array('status' => 'successo')));
            }else{
                exit(json_encode(array('status' => 'Deu ruim')));
            }
        }
    }
?>