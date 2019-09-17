<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if (!empty($_POST['nome']) && !empty($_POST['descricao'])){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        
        $resultado = cadastra_rotina($nome, $descricao, $_SESSION["usuario_adm"]);
        
        if($resultado->rowCount() == 1){
            echo "Cadastrado com sucesso";
        }
        
        
        
    }
}

if(isset($_POST['SAI'])) {
    
    header('location: ../main/adm.php');
}

?>



<html>
<head>
 		<meta charset="utf-8">
 		<title>Sistema de Cadastro de Rotinas</title>
</head>

<body>
    <section>
                   <h3>Sistema de Cadastro de Rotinas</h3>
                  
                   <table borde="2" bordercolor="#EEE" >
                   <tr>
               			<td><h3>Rotinas cadastradas no sistema</h3></td>
                   </tr>
                   
                   <tr>
						<td><strong>Nome</strong></td>
                        <td><strong>Descricao</strong></td>                        
                   </tr>
                   <?php 
                    $consulta = consulta_todas_rotina();
                    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                        $ID=$lista->ID  . "<br>";
                        $Nome=$lista->Nome    . "<br>";
                        $Descricao=$lista->Descricao   . "<br>";?>
                     
                     	
                     
                        <tr>
                            <td><?=$Nome?></td>
                            <td><?=$Descricao?></td>
                            
                        </tr>
                          
                    <?php }?>
    				</table>
                  
                    <div class="box">
                        <form action="#" method="POST">
                           			<p>
                           			Digite o Nome da Rotina: <input name="nome" type="text" placeholder="Nome">
                                    </p>
                           			
                           			<p>
                                    Digite a Descricao da Rotina: <input name="descricao" type="text" placeholder="Descricao" >
                                    </p>
                                    
    
   
                             
                            <button type="submit" name="OK">Cadastrar</button>
                        </form>
                        
                        
                       <form action="#" method="POST"> 
                        	<button type="submit" name="SAI">Volta ao Menu</button>
                       </form>
                    </div>
                    
                    
    </section>
</body>

</html>