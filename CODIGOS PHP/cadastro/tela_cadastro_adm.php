<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if (!empty($_POST['email']) && !empty($_POST['nome']) && !empty($_POST['RG']) && !empty($_POST['CPF']) && !empty($_POST['Genero']) && !empty($_POST['Idade']) && !empty($_POST['Telefone']) && !empty($_POST['senha'])){
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $RG = $_POST['RG'];
        $CPF = $_POST['CPF'];
        $genero = $_POST['Genero'];
        $idade = $_POST['Idade'];
        $telefone = $_POST['Telefone'];
        $senha = $_POST['senha'];
        cadastro_ADM($email, $nome, $RG, $CPF, $genero, $idade, $telefone, $senha);
        
        $resultado = consulta_adm($email, $senha);
    
        if($resultado == 1){
            
            $_SESSION["usuario_logado_adm"] = TRUE;
            $_SESSION["usuario_adm"] = $_POST['email'];
            header('location: ../main/adm.php');
            
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
                   <h3>Sistema de Cadastro do Administrador</h3>
                  
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
                                    Digite sua Senha: <input name="Senha" type="password" placeholder="Sua senha" required>                                   
                                    </p>
    
   
                             
                            <button type="submit" name="OK">Cadastrar</button>
                        </form>
                       
                    </div>
    </section>


</body>

</html>