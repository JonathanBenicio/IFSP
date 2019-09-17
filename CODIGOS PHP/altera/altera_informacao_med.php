<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    
    $email = $_POST['Email'];
    $nome = $_POST['Nome'];
    $rg = $_POST['RG'];
    $cpf = $_POST['CPF'];
    $genero = $_POST['Genero'];
    $idade = $_POST['Idade'];
    $telefone = $_POST['Telefone'];
    $senha = $_POST['Senha'];
    
    $email_logado=$_SESSION["usuario_adm"];
    
    $resulta=altera_adm($email, $nome, $rg, $cpf, $genero, $idade, $telefone, $senha, $email_logado);
    
    if($resulta == 1){
        echo "Atualizado com sucesso";
        
    }
    
    
    
}

if(isset($_POST['SAI'])) {
    
    header('location: ../main/adm.php');
}

?>



<html>
<head>
 		<meta charset="utf-8">
 		<title>Sistema de Login</title>
</head>

<body>
    <section>
    
                   <h3>Sistema de Alteracao de Informacao do Medico</h3>
                  
                  <table borde="2" bordercolor="#EEE" >
                   <tr>
               			<td><strong>Rotinas cadastradas no sistema</strong></td>
                   </tr>
                   		<td><strong>E_mail</strong></td>
                   		<td><strong>Nome</strong></td>
                   		<td><strong>RG</strong></td>
                   		<td><strong>CPF</strong></td>
                   		<td><strong>Genero</strong></td>
                   		<td><strong>Idade</strong></td>
                   		<td><strong>Telefone</strong></td>
                   		<td><strong>Endereco</strong></td>
                   		<td><strong>CRM</strong></td>
                   		<td><strong>FK_Rotinas_ID</strong></td>
                   		<td><strong>Senha</strong></td>
                   <tr>
                   
                   </tr>
                   
                   <?php 
                    $a="";
                    $consulta = consulta_med($_SESSION["usuario_med"],$a);
                    while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                        $Email=$lista->E_mail;
                        $Nome=$lista->Nome;
                        $RG=$lista->RG;
                        $CPF=$lista->CPF;
                        $Genero=$lista->Genero;
                        $Idade=$lista->Idade;
                        $Telefone=$lista->Telefone;
                        $Endereco=$lista->Endereco;
                        $CRM=$lista->CRM;
                        $FK_Rotinas_ID=$lista->FK_Rotinas_ID;
                        $Senha=$lista->Senha;
                        ?>
                     
                        <tr>
                        	<td><?=$Email?></td>
                            <td><?=$Nome?></td>
                            <td><?=$RG?></td>
                            <td><?=$CPF?></td>
                            <td><?=$Genero?></td>
                            <td><?=$Idade?></td>
                            <td><?=$Telefone?></td>
                            <td><?=$Endereco?></td>
                            <td><?=$CRM?></td>
                            <td><?=$FK_Rotinas_ID?></td>
                            <td><?=$Senha?></td>
                            
                            
                        </tr>
                          
                    <?php }?>
    				</table>
                  
                    <div class="box">
                        <form action="#" method="POST">
                           
                                   <p>
                           			Digite seu E-mail: <input name="Email" type="text" placeholder="Seu E-mail" required>
                                    </p>
                                    <p>
                                    Digite seu Nome: <input name="Nome" type="text" placeholder="Seu Nome" required >
                                    </p>
                                    <p>
                                    Digite seu RG: <input name="RG" type="tel" placeholder="Seu RG" required>
                                    </p>
                                    <p>
                                    Digite seu CPF: <input name="CPF" type="tel" placeholder="Seu CPF" required>
                                    </p>
                                    <p>
                                    Digite seu Genero: <input name="Genero" type="text" placeholder="Seu Genero" required>
                                    </p>
                                    <p>
                                    Digite sua Idade: <input name="Idade" type="tel" placeholder="Sua Idade" required>
                                    </p>
                                    <p>
                                    Digite seu Telefone: <input name="Telefone" type="tel" placeholder="Seu Telefone" required>                                    
                         			</p>
                                    
                         			<p>
                                    Digite seu Endereco: <input name="Endereco" type="text" placeholder="Seu Endereco" required>                                    
                         			</p>
                         			<p>
                                    Digite seu CRM: <input name="CRM" type="tel" placeholder="Seu CRM" required>                                    
                         			</p>
                                    
                                   

                            
                         
                         			<table borde="2" bordercolor="#EEE" >
                                       <tr>
                                       		<td><h3>Rotinas cadastradas no sistema</h3></td>
                                       </tr>
                                       
                                       <tr>
                                       		<td><strong>ID</strong></td>
                                       		<td><strong>Nome</strong></td>
                                       </tr>
                                       <?php 
                                        $consulta = consulta_todas_rotina();
                                        while ($lista = $consulta->fetch(PDO::FETCH_OBJ)){
                                            $ID=$lista->ID        . "<br>";
                                            $Nome=$lista->Nome    . "<br>";?>
                                         
                                            <tr>
												<td><?=$ID?></td>
                                                <td><?=$Nome?></td>
                                            </tr>
                                              
                                        <?php }?>
                						</table>
                					<p>
                                    Digite o ID das rotinas acima que representa sua especialidade: <input name="Especialidade" type="text" placeholder="Selecione" required>
                                    </p>
                                    									 
                         			<p>
                                    Digite sua Senha: <input name="Senha" type="password" placeholder="Sua senha" required> 
                                    </p>
                             
                            <button type="submit" name="OK">Cadastrar</button>
                            
                            <p>Se sua especialidade de rotina nao estive cadastra, por favor enviar um email para projetoextexao@gmail.com<p>
                            
                        </form>
                        
                        <form action="#" method="POST"> 
                        	<button type="submit" name="SAI">Volta ao Menu</button>
                       </form>
                       
                    </div>
    </section>


</body>

</html>