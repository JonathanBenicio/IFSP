<?php

include '../dao/agendaDAO.php';
if (isset($_POST)) {
    $json_str = file_get_contents('php://input');
    
    //Decode JSON
    $json_data = json_decode($json_str, true); //o TRUE retorna o json como um associative array
    
    if($json_data['acao'] == "efetuar_login") {
        
        $email = $json_data['parametros']['usuario'];
        $senha = $json_data['parametros']['senha'];
        
        $objeto_para_resposta['acao'] = $json_data['acao'];
        $objeto_para_resposta['rotina'] = rotina($email);
        $objeto_para_resposta['resultado'] = verifica_login($email, $senha);
        
        
        $jsonResposta = json_encode($objeto_para_resposta);
        
        echo $jsonResposta;
        
    }
}



function verifica_login($email, $senha) {
    
    $resultado = consulta_pac($email, $senha);
    
    if($resultado->rowCount() == 1){
        
    
        return 1;
    }
    
    return 0;
    
}

function rotina($email){
    $consulta = consulta_repeticoes($email);
    $lista = $consulta->fetch(PDO::FETCH_OBJ);
    $rotina=$lista->FK_Rotinas_ID;
    return $rotina;
}
?>