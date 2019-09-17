<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if(!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $resultado = consulta_adm($email, $senha);
        
        if($resultado->rowCount() == 1){
            
            $_SESSION["usuario_logado_adm"] = TRUE;
            $_SESSION["usuario_adm"] = $_POST['email'];
            header('location: ../main/adm.php');
            
        }
    }
}
?>
<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>Sistema de Login</title>
</head>

<body>
    <section class="hero is-success is-fullheight">
                   <h3 class="title has-text-grey">Sistema de Login</h3>
                  
                    <div class="box">
                        <form action="" method="POST">
                           
                                    <input name="email" type="email" placeholder="Seu E-mail" required>
                         
                                    <input name="senha" type="password" placeholder="Sua senha" required>
                              
                            <button type="submit" name="OK">Entrar</button>
                        </form>
                        
                        
                        
                    </div>
    </section>
</body>

</html>