<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if (!empty($_POST['ID_rotina'])){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $ID_rotina = $_POST['ID_rotina'];
        
        $resultado=altera_rotina($nome, $descricao, $ID_rotina);
        
        if($resultado == 1){
            echo "<h3>Rotina alterada com sucesso!</h3>";
        }
        
        
        
    }
}

if(isset($_POST['SAIR'])) {
    
    header('location: ../main/adm.php');
}
?>



<html>
<head>
 		<meta charset="utf-8">
 		<title>Altera Rotinas</title>
</head>

<body>
    <section>
                   <h1>Altera Rotinas</h1>
                  
                  <table borde="2" bordercolor="#EEE" >
                   <tr>
               			<td><h3>Rotinas cadastradas no sistema</h3></td>
                   </tr>
                   
                   <tr>
                   		<td><strong>ID</strong></td>
                   		<td>
						<td><strong>Nome</strong></td>
                        <td><strong>Descricao</strong></td>                        
                   </tr>
                   <?php 
                    $consulta = consulta_todas_rotina();
                    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                        $ID=$lista->ID;
                        $Nome=$lista->Nome;
                        $Descricao=$lista->Descricao;?>
                     
                        <tr>
                        	<td><?=$ID?><td>
                            <td><?=$Nome?></td>
                            <td><?=$Descricao?></td>
                            
                        </tr>
                          
                    <?php }?>
    				</table>
                  
                    <div class="box">
                        <form action="" method="POST">
                        			<p>
                           			Digite o ID rotina que voce ira altera: <input name="ID_rotina" type="number" placeholder="ID rotina" required>
                           			</p>
                           			
                           			<p>
                           			Digite o Nome da Rotina: <input name="nome" type="text" placeholder="Nome">
                                    </p>
                           			
                           			<p>
                                    Digite a Descricao da Rotina: <input name="descricao" type="text" placeholder="Descricao" >
                                    </p>                                    
                                    
    
   
                             
                            <button type="submit" name="OK">Atualizar</button>
                        </form>
                       
                       <form action="#" method="POST"> 
                        	<button type="submit" name="SAIR">Volta ao Menu</button>
                       </form>
                    </div>
    </section>


</body>

</html>