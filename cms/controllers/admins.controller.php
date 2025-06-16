<?php

class AdminsController{

    /*==========================
    Login Admin
    ==========================*/

    public function login(){
        if(isset($_POST["email_admin"])){
            
                echo '<script>
                
                fncMatPreloader("on");
                fncSweetAlert("loading", "Ingresando...", "");

                </script>';
                
                $url = "admins?login=true&suffix=admin";
                $method = "POST";
                $fields = array(
                    "email_admin" => $_POST["email_admin"],
                    "password_admin" => $_POST["password_admin"]
                );

                $login = CurlController::request($url, $method, $fields);
                
                if($login->status == 200){

                    /*==========================
                    Validar estado admin
                    ==========================*/

                    

                }else{
                        
                    echo '<div class="alert alert-danger mt-3 rounded">Error al ingresar: Correo o contraseña incorrectos</div>';

                    echo '<script>
                
                    fncMatPreloader("off");
                    fncFormatInputs();
                    fncToastr("error", "Error al ingresar: Correo o contraseña incorrectos");

                    </script>';

                }
                    
        }
    }
}