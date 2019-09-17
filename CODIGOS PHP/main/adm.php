<?php 
session_start();
if(isset($_SESSION["usuario_logado_adm"])){
    if($_SESSION["usuario_logado_adm"] == TRUE){
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

if(isset($_POST['CAD'])) {
    header('location: ../cadastro/cadastro_rotina.php');
}

if(isset($_POST['ATU'])) {
    header('location: ../altera/altera_rotina.php');
}

if(isset($_POST['ALT'])) {
    header('location: ../altera/altera_informacao_adm.php');
}
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>AREA DO ADMINISTRADOR</title>
   
</head>

<body>
    <section>
                   <h3> AREA DO ADMINISTRADOR</h3>
                  
                    <div class="box">
                        <form action="" method="POST">        
                        
                        	<button type="submit" name="CAD">CADASTRAR ROTINA</button>    <br>      <br>            
                            
                            <button type="submit" name="ATU">ALTERA ROTINA</button> <br>      <br> 
                            
							<button type="submit" name="ALT">ALTERA INFOMACOES PESSOAIS</button> <br>      <br> 
                            
                            
                            <button type="submit" name="SAIR">SAIR</button>
                        </form>
                    </div>
    </section>
</body>

</html>