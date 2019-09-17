<?php 

function conectar(){
    
    $servername = "localhost";
    $username = "root";
    $password ="";
    $dbname = "projeto";
    
    try{
        
        $conn = new PDO("mysql:host=$servername; port=3306; dbname=$dbname", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function cadastro_ADM($email, $nome, $RG, $CPF, $genero, $idade, $telefone, $senha){
    
    
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "INSERT INTO `administrador`(`E_mail`, `Nome`, `Idade`, `Genero`, `CPF`, `RG`, `Telefone`, `Senha`) VALUES ('{$email}', '{$nome}', '{$RG}', '{$CPF}', '{$genero}', '{$idade}', '{$telefone}', '{$senha}')";
        
        return $bancoDeDados->exec($consulta);
        
        
    } catch (Exception $e){
        echo  "Erro cadastro_ADM: " .$e->getMessage();
    }
    
    
}


function cadastro_med($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $crm, $endereco, $face, $inst, $senha, $ID_rotina){
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "INSERT INTO `medico`(`E_mail`, `Nome`, `CPF`, `RG`, `CRM`, `Telefone`, `Idade`, `Genero`, `Endereco`, `Senha`, `Facebook`, `Instagram`, `FK_Rotinas_ID`) VALUES ('{$email}', '{$nome}', '{$CPF}', '{$RG}', '{$crm}', '{$telefone}', '{$idade}', '{$genero}', '{$endereco}', '{$senha}', '{$face}', '{$inst}', '{$ID_rotina}')";
        
        return $bancoDeDados->exec($consulta);
        
        
    } catch (Exception $e){
        echo  "Erro cadastro_med: " .$e->getMessage();
    }
    
    
}

function cadastro_pac($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $face, $inst, $senha, $id_rotina){
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "INSERT INTO `paciente`(`E_mail`, `Nome`, `CPF`, `RG`, `Telefone`, `Idade`, `Genero`, `Senha`, `Facebook`, `Instagram`) VALUES ('{$email}', '{$nome}', '{$CPF}', '{$RG}', '{$telefone}', '{$idade}', '{$genero}', '{$senha}', '{$face}', '{$inst}')";
        
        $bancoDeDados->exec($consulta);
        
        return 1;
        
    } catch (Exception $e){
        echo  "Erro cadastro_med: " .$e->getMessage();
    }
}

function cadastra_atividade($nome,$descricao, $beneficio, $rotina, $email_med){
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "INSERT INTO `atividades`(`ID`, `Nome`, `Beneficios`, `Descricao`, `FK_Rotinas_ID`, `FK_Medico_Email`) VALUES (DEFAULT,'{$nome}','{$descricao}','{$beneficio}','{$rotina}', '{$email_med}') ";
        
        return $bancoDeDados->query($consulta);
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}

function cadastra_rotina($nome,$descricao,$email){
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "INSERT INTO `rotinas`(`Nome`, `Descricao`, `FK_Administrador_E_mail`) VALUES ('{$nome}','{$descricao}','{$email}') ";
        
        return $bancoDeDados->query($consulta);
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}



function consulta_adm($email,$senha){
    
    $bancoDeDados = conectar();
    
    try {
        if(!empty($email) && !empty($senha)){
            $consulta = "SELECT * FROM `administrador` WHERE E_mail= '{$email}' AND Senha='{$senha}'";
            return $bancoDeDados->query($consulta);
           
        }else if(!empty($email)){
            $consulta = "SELECT * FROM `administrador` WHERE E_mail= '{$email}'";
            return $bancoDeDados->query($consulta);
             
        }
        
        
    } catch (Exception $e){
        echo " Erro consulta_adm: " .$e->getMessage();
    }
}

function consulta_med($email,$senha){
    
    $bancoDeDados = conectar();
    
    try {
        
        if(!empty($email) && !empty($senha)){
            $consulta = "SELECT * FROM `medico` WHERE E_mail= '{$email}' AND Senha='{$senha}'";
            return $bancoDeDados->query($consulta);
            
        }else if(!empty($email)){
            $consulta = "SELECT * FROM `medico` WHERE E_mail= '{$email}'";
            return $bancoDeDados->query($consulta);
            
        }
        
        
    } catch (Exception $e){
        echo " Erro consulta_med: " .$e->getMessage();
    }
}

function consulta_pac($email,$senha){
    
    $bancoDeDados = conectar();
    
    try {
        
        if(!empty($email) && !empty($senha)){
            $consulta = "SELECT * FROM `paciente` WHERE E_mail= '{$email}' AND Senha='{$senha}'";
            return $bancoDeDados->query($consulta);
            
        }
        
    } catch (Exception $e){
        echo " Erro consulta_med: " .$e->getMessage();
    }
}

function consulta_repeticoes($email){
    $bancoDeDados = conectar();
    
    try {
        
        
        $consulta = "SELECT* FROM repeticoes INNER JOIN paciente on '{$email}' = repeticoes.FK_Paciente_E_mail";
        return $bancoDeDados->query($consulta);
                
        
    } catch (Exception $e){
        echo " Erro consulta_med: " .$e->getMessage();
    }
}

function consulta_rotina($rotina){
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "SELECT * FROM `rotinas` WHERE ID = '{$rotina}'";
        
        return $bancoDeDados->query($consulta);
        
        
    } catch (Exception $e){
        echo " Erro rotina: " .$e->getMessage();
    }
}

function consulta_todas_rotina(){
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "SELECT * FROM `rotinas`";
        
        return $bancoDeDados->query($consulta);
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}

function consulta_paciente($rotina){
    
    $bancoDeDados = conectar();
    
    try {
        
        $consulta = "SELECT* FROM repeticoes INNER JOIN medico on '{$rotina}' = repeticoes.FK_Rotinas_ID";
        
        return $bancoDeDados->query($consulta);
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}

function consulta_atividades($rotina, $email_med){
    
    $bancoDeDados = conectar();
    
    try {
        if(!empty($rotina && !empty($email_med))){
        $consulta = "SELECT* FROM atividades INNER JOIN medico on '{$rotina}' = atividades.FK_Rotinas_ID and '{$email_med}' = atividades.FK_Medico_Email";
        
        return $bancoDeDados->query($consulta);
        }else if(!empty($rotina)){
            $consulta = "SELECT* FROM atividades INNER JOIN repeticoes on '{$rotina}' = atividades.FK_Rotinas_ID";
            return $bancoDeDados->query($consulta);
        }
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}


function rotina_quant(){
    
    $bancoDeDados = conectar();
    
    try {
       
        $consulta = "SELECT COUNT(ID) AS total FROM rotinas";
            
        return $bancoDeDados->query($consulta);
     
        
        
    } catch (Exception $e){
        echo " Erro consulta: " .$e->getMessage();
    }
}






function altera_rotina($nome, $descricao, $ID_rotina){
    $bancoDeDados = conectar();
    
    try {
            
            if(!empty($nome)){
                $consulta = "UPDATE rotinas SET Nome = '$nome' WHERE ID = $ID_rotina";
                $bancoDeDados->query($consulta);
                $nome="";
            }
            
            if(!empty($descricao)){
                $consulta = "UPDATE rotinas SET Descricao ='$descricao' WHERE ID = $ID_rotina";
                $bancoDeDados->query($consulta);
                $descricao="";
            }
        
        
        
        return 1;
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
}



function altera_adm($email, $nome, $rg, $cpf, $genero, $idade, $telefone, $senha, $email_logado) {
    $bancoDeDados = conectar();
    
    try {
        
        if(!empty($email)){
            $consulta = "UPDATE administrador SET `E_mail`='$email' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $email_logado=$email;
            $_SESSION["usuario_adm"]=$email;
            $email="";
        }
        
        if(!empty($nome)){
            $consulta = "UPDATE administrador SET Nome ='$nome' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $nome="";
        }
        

        if(!empty($rg)){
            $consulta = "UPDATE administrador SET RG ='$rg' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $rg="";
        }
        
        if(!empty($cpf)){
            $consulta = "UPDATE administrador SET CPF ='$cpf' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $cpf="";
        }
        
        if(!empty($genero)){
            $consulta = "UPDATE administrador SET Genero ='$genero' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $genero="";
        }
        
        if(!empty($idade)){
            $consulta = "UPDATE administrador SET Idade ='$idade' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $idade="";
        }
        
        if(!empty($telefone)){
            $consulta = "UPDATE administrador SET Telefone ='$telefone' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $telefone="";
        }
        
        if(!empty($senha)){
            $consulta = "UPDATE administrador SET Senha ='$senha' WHERE E_mail = '$email_logado'";
            $bancoDeDados->query($consulta);
            $senha="";
        }
                
        return 1;
        
        
    } catch (Exception $e){
        echo " Erro consulta_rotina: " .$e->getMessage();
    }
    
}