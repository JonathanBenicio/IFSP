<?php
session_start();
include '../dao/agendaDAO.php';
if(isset($_POST['OK'])) {
    if(!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $resultado = consulta_med($email, $senha);
        
        if($resultado->rowCount() == 1){
            
            $consulta = consulta_med($email, $senha);
            $lista = $consulta->fetch(PDO::FETCH_OBJ);
            $ID_rotina = $lista->FK_Rotinas_ID        . "<br>";
                       
            $_SESSION["usuario_logado"] = TRUE;
            $_SESSION["usuario_med"] = $_POST['email'];
            $_SESSION["rotina"] = $ID_rotina;
             header('location: ../main/medico.php');
           
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
                           
                                    <input name="email" type="email" placeholder="Seu E-mail">
                         
                                    <input name="senha" type="password" placeholder="Sua senha">
                              
                            <button type="submit" name="OK">Entrar</button>
                        </form>
                        
                        
                        
                    </div>
    </section>
</body>

</html>