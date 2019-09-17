<?php
include '../dao/agendaDAO.php';
if (isset($_POST)) {
    $json_str = file_get_contents('php://input');
    
    //Decode JSON
    $json_data = json_decode($json_str, true); //o TRUE retorna o json como um associative array
    
    if($json_data['acao'] == "consulta_atividade") {
        
        $roina_pac = $json_data['parametros']['rotina_pac'];
        
        
        
        
        $objeto_para_resposta['acao'] = $json_data['acao'];
        
        $objeto_para_resposta['nome']= consultanome($roina_pac);
        $objeto_para_resposta['descricao']= consultadescricao($roina_pac);
        
        
        
        $jsonResposta = json_encode($objeto_para_resposta);
        
        
        echo $jsonResposta;
    }
}

function verifica_login($email, $senha) {
    $resultado = consulta_pac($email, $senha);
    if($resultado->rowCount() == 1) {
        return 1;
    }
    
    return 0;
}

function consultanome($roina_pac){
    $consulta = consulta_atividades($roina_pac,"");
    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
        $Nome=$lista->Nome;
        
    }
    return $Nome;
    
}


function consultadescricao($roina_pac){
    $consulta = consulta_atividades($roina_pac,"");
    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
        $Descricao=$lista->Descricao;
        
    }
    return $Descricao;
    
    
    
}