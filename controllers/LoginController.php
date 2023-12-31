<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth =  new Admin($_POST);

            $errores = $auth->validar();
            if (empty($errores)) {
                //verificar usuario
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    $errores = Admin::getErrores();
                } else {
                    //verificar password
                    $autenticado = true; //$auth->comprobarPass($resultado);
                    if ($autenticado) {
                        //autenticar al usuario
                        $auth->autenticar();
                    } else {
                        //mensaje de error en password
                        $errores = Admin::getErrores();
                    }
                }
            }
        }
        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('location: /');
    }
}
