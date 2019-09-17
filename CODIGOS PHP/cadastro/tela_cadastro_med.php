<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if(!empty($_POST['Especialidade'])){
        $rotina = $_POST['Especialidade'];
        $consulta=consulta_rotina($rotina);
        if($consulta->rowCount() == 1){
            $ID_rotina = $_POST['Especialidade'];
        }
        else{
            $_POST['Especialidade'] = ''; 
            echo "<center><p>OPS!!! A rotina nao existe</p></center>";
            
        }
    }
    if (!empty($_POST['Email']) && !empty($_POST['Nome']) && !empty($_POST['RG']) && !empty($_POST['CPF']) && !empty($_POST['Genero']) && !empty($_POST['Idade']) && !empty($_POST['Telefone']) && !empty($_POST['Senha']) && !empty($_POST['CRM']) && !empty($_POST['Endereco']) && !empty($_POST['Especialidade'])){
        $email = $_POST['Email'];
        $nome = $_POST['Nome'];
        $RG = $_POST['RG'];
        $CPF = $_POST['CPF'];
        $genero = $_POST['Genero'];
        $idade = $_POST['Idade'];
        $telefone = $_POST['Telefone'];
        $senha = $_POST['Senha'];
        $crm = $_POST['CRM'];
        $endereco = $_POST['Endereco'];
        $face = $_POST['Facebook'];
        $inst = $_POST['Instagram'];
        
        
        
        cadastro_med($email, $nome, $idade, $genero, $CPF, $RG, $telefone, $crm, $endereco, $face, $inst, $senha, $ID_rotina);
        
        $resultado = consulta_med($email, $senha);
        
        
        if($resultado->rowCount() == 1){
            $_SESSION["rotina"] = $ID_rotina;
            $_SESSION["usuario_logado"] = TRUE;
            $_SESSION["usuario_med"] = $_POST['Email'];
            header('location: ../main/medico.php');
            
        }
    }
    
    echo "nao";
}

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Sistema de Login</title>
</head>

<body>
    <section>
                   <h3>Sistema de Cadastro do Medico</h3>
                  
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
                                    Digite seu Facebook: <input name="Facebook" type="tel" placeholder="Seu Facebook" >                                    
                         			</p>
                         			<p>
                                    Digite seu Instagram: <input name="Instagram" type="text" placeholder="Seu Instagram" >                                    
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
                       
                    </div>
    </section>


</body>

</html>