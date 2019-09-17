<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if (!empty($_POST['ID'])){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $beneficio = $_POST['beneficio'];
        $rotina =  $_SESSION['rotina'];
        $resultado = altera_atividade($nome, $descricao, $beneficio, $rotina);
        
        
        if($resultado->rowCount() == 1){
            
            echo "Atividade ", $nome, " cadastrada com sucesso";
            
        }
    }
}

?>



<html>
<head>
 		<meta charset="utf-8">
 		<title>Sistema de Login</title>
</head>

<body>
    <section>
                   <h3>Sistema de Alteracao de Atividades</h3>
                  
                   <table borde="2" bordercolor="#EEE" >
                   <tr>
               			<td><h3>Atividades cadastradas no sistema</h3></td>
                   </tr>
                   
                   <tr>
                   		<td><strong>ID</strong></td>
						<td><strong>Nome</strong></td>
                        <td><strong>Descricao</strong></td> 
                        <td></td>   
                        <td><strong>Beneficios</strong></td>                                            
                   </tr>
                   <?php 
                    $consulta = consulta_atividades($_SESSION["rotina"]);
                    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                        $ID=$lista->ID;
                        $Nome=$lista->Nome;
                        $Descricao=$lista->Descricao;
                        $Beneficios=$lista->Beneficios;?>
                     
                     	
                     
                        <tr>
                        	<td><?=$ID?></td>
                            <td><?=$Nome?></td>
                            <td><?=$Descricao?></td>
                            <td></td>
                            <td><?=$Beneficios?></td>
                            
                        </tr>
                          
                    <?php }?>
    				</table>
                    <div class="box">
                        <form action="#" method="POST">
                        
                        			<p>
                                    Digite o ID da Atividade que deseja altera: <input name="nome" type="text" placeholder="Nome da Atividade" required>
                                    </p>
                           			<p>
                                    Digite o novo nome da Atividade: <input name="nome" type="text" placeholder="Nome da Atividade" >
                                    </p>
                                    <p>
                                    Digite a novo descricao da Atividade<input name="descricao" type="text" placeholder="Descricao da Atividade" >
                                    </p>
                                    <p>
                                    Digite o novo beneficio da Atividade<input name="beneficio" type="text" placeholder="Beneficio da Atividade" >
                                    </p>
                                    
    
   
                             
                            <button type="submit" name="OK">Cadastrar</button>
                        </form>
                       
                    </div>
    </section>


</body>

</html>