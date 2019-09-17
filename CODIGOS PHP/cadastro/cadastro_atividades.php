<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if (!empty($_POST['nome']) && !empty($_POST['descricao']) && !empty($_POST['beneficio'])){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $beneficio = $_POST['beneficio'];
        $rotina =  $_SESSION['rotina'];
        $resultado = cadastra_atividade($nome, $descricao, $beneficio, $rotina, $_SESSION["usuario_med"]);
        
        
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
                   <h3>Sistema de Cadastro de Atividades</h3>
                  
                   <table borde="2" bordercolor="#EEE" >
                   <tr>
               			<td><h3>Atividades cadastradas no sistema</h3></td>
                   </tr>
                   
                   <tr>
						<td><strong>Nome</strong></td>
                        <td><strong>Descricao</strong></td> 
                        <td></td>   
                        <td><strong>Beneficios</strong></td>                                            
                   </tr>
                   <?php 
                   $consulta = consulta_atividades($_SESSION["rotina"], $_SESSION["usuario_med"]);
                    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                        $Nome=$lista->Nome;
                        $Descricao=$lista->Descricao;
                        $Beneficios=$lista->Beneficios;?>
                     
                     	
                     
                        <tr>
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
                                    Digite o nome da Atividade: <input name="nome" type="text" placeholder="Nome da Atividade" required>
                                    </p>
                                    <p>
                                    Digite a descricao da Atividade<input name="descricao" type="text" placeholder="Descricao da Atividade" required>
                                    </p>
                                    <p>
                                    Digite o beneficio da Atividade<input name="beneficio" type="text" placeholder="Beneficio da Atividade" required>
                                    </p>
                                    
    
   
                             
                            <button type="submit" name="OK">Cadastrar</button>
                        </form>
                       
                    </div>
    </section>


</body>

</html>