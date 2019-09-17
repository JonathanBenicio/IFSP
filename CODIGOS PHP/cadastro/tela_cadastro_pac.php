<?php

include '../dao/agendaDAO.php';
if (isset($_POST)) {
    $json_str = file_get_contents('php://input');
    
    //Decode JSON
    $json_data = json_decode($json_str, true); //o TRUE retorna o json como um associative array
    
    if($json_data['acao'] == "consulta_quant") {
        
        
        
        $objeto_para_resposta['acao'] = $json_data['acao'];
        $objeto_para_resposta['quant_rotina'] = quant_rotina();
        $objeto_para_resposta['resultado'] = 1;
        
        
        $jsonResposta = json_encode($objeto_para_resposta);
        
        echo $jsonResposta;
        
    }
    
    if($json_data['acao'] == "efetuar_cadastro") {
        
        $nome = $json_data['parametros']['nome'];
        $email = $json_data['parametros']['email'];
        $CPF = $json_data['parametros']['cpf'];
        $RG = $json_data['parametros']['rg'];
        $idade = $json_data['parametros']['idade'];
        $genero = $json_data['parametros']['genero'];
        $telefone = $json_data['parametros']['telefone'];
        $face = $json_data['parametros']['facebook'];
        $inst = $json_data['parametros']['instagram'];
        $senha = $json_data['parametros']['senha'];
        $id_rotina = $json_data['parametros']['id_rotina'];
        
        $objeto_para_resposta['acao'] = $json_data['acao'];
       
        $objeto_para_resposta['resultado'] = cadastro($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $face, $inst, $senha, $id_rotina);
        
        
        $jsonResposta = json_encode($objeto_para_resposta);
        
        echo $jsonResposta;
        
    }
    
    if($json_data['acao'] == "consulta_rotina") {
        
        $rotina = $json_data['parametros']['rotina'];
        
        $objeto_para_resposta['acao'] = $json_data['acao'];
        $objeto_para_resposta['nome'] = consulta_nome($rotina);
        $objeto_para_resposta['resultado'] = 1;
        
        
        $jsonResposta = json_encode($objeto_para_resposta);
        
        echo $jsonResposta;
        
    }
    
     
}

function quant_rotina(){
    $quant= rotina_quant();
    if($quant->RowCount()==1){
        $lista=$quant->fetch(PDO::FETCH_OBJ);
        $id=$lista->total;
        return $id;
    }
}

function cadastro($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $face, $inst, $senha, $id_rotina){
    $resultado = cadastro_pac($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $face, $inst, $senha, $id_rotina);
    if($resultado == 1){
        return 1;
    }
    return 0;
}

function consulta_nome($rotina){
    $consulta=consulta_rotina($rotina);
    if($consulta->RowCount()==1){
        $lista=$consulta->fetch(PDO::FETCH_OBJ);
        $nome=$lista->Nome;
        return $nome;
    }
}