<?php 
session_start();
include '../dao/agendaDAO.php';
if(isset($_SESSION["usuario_logado"])){
    if($_SESSION["usuario_logado"] == TRUE){
        echo "<center><h1>!!! voce esta logado.</h1></center>";
    } else {
        echo "<center><h1>OPS!!! voce não esta logado.</h1></center>";
        exit;  
    }
}else {
    echo "<center><h1>OPS!!! voce não esta logado.</h1></center>";
    exit;
}

if(isset($_POST['SAIR'])) {
    session_unset();
    session_destroy();
    header('location: ../index.php');
}

if(isset($_POST['CON'])) {
    header('location: ../consulta/consulta_pacientes.php');
}

if(isset($_POST['CAD'])) {
    header('location: ../cadastro/cadastro_atividades.php');
}

if(isset($_POST['ALT'])) {
    header('location: ../altera/altera_informacao_med.php');
}
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>AREA DO MEDICO</title>
   
</head>

<body>
    <section>
                   <h3> AREA DO MEDICO</h3>
                  
                    <div class="box">
                        <form action="#" method="POST">        
                        
                        	<button type="submit" name="CAD">CADASTRAR ATIVIDADES</button>    <br>      <br>            
                                                    
                            <button type="submit" name="CON">CONSULTAR PACIENTES</button> <br>      <br> 
                            
                            <button type="submit" name="ALT">ALTERA INFOMACOES PESSOAIS</button> <br>   <br>
                            
                            <button type="submit" name="SAIR">SAIR</button>
                        </form>
                    </div>
    </section>
    
</body>

</html>