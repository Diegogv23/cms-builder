<?php

class InstallController
{
    /*=================================================
                Informacion de la base de datos 
    ===================================================*/

    static public function infoDatabase()
    {

        $infoDB = array(
            "database" => "cms-builder",
            "user" => "root",
            "password" => "",
            "host" => "localhost",
        );

        return $infoDB;
    }

    /*=================================================
                Conexion a la base de datos 
    ===================================================*/

    static public function connect()
    {

        try {

            $link = new PDO("mysql:host=localhost;dbname=" . InstallController::infoDatabase()["database"], InstallController::infoDatabase()["user"], InstallController::infoDatabase()["password"]);

            $link->exec("set names utf8");
        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }

        return $link;
    }
    /*=================================================
                Instalacion del sistema
    ===================================================*/

    public function install()
    {

        if (isset($_POST["email_admin"])) {

            echo '<script>
                    fncMatPreloader("on");
                 </script>';

            /*=================================================
                Creacion tabal admin
            ===================================================*/

            $sqlAdmins = "CREATE TABLE admins (
                id_admin INT NOT NULL AUTO_INCREMENT,
                rol_admin TEXT NULL DEFAULT NULL,
                permissions_admin TEXT NULL DEFAULT NULL,
                email_admin TEXT NULL DEFAULT NULL,
                password_admin TEXT NULL DEFAULT NULL,
                token_admin TEXT NULL DEFAULT NULL,
                token_exp_admin TEXT NULL DEFAULT NULL,
                status_admin INT NULL DEFAULT '1',
                title_admin TEXT NULL DEFAULT NULL,
                symbol_admin TEXT NULL DEFAULT NULL,
                font_admin TEXT NULL DEFAULT NULL,
                color_admin TEXT NULL DEFAULT NULL,
                back_admin TEXT NULL DEFAULT NULL,
                date_created_admin DATE NULL DEFAULT NULL, 
                date_updated_admin TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id_admin))";

            $stmtAdmins = InstallController::connect()->prepare($sqlAdmins);


            /*=================================================
                Creacion tabal Pages
            ===================================================*/

            $sqlPages = "CREATE TABLE pages (
                id_page INT NOT NULL AUTO_INCREMENT,
                title_page TEXT NULL DEFAULT NULL,
                url_page TEXT NULL DEFAULT NULL,
                icon_page TEXT NULL DEFAULT NULL,
                type_page TEXT NULL DEFAULT NULL,
                order_page INT NULL DEFAULT '1',
                date_created_page DATE NULL DEFAULT NULL, 
                date_updated_page TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id_page))";

            $stmtPages = InstallController::connect()->prepare($sqlPages);


            /*=================================================
                Creacion tabal Modules
            ===================================================*/

            $sqlModules = "CREATE TABLE modules (
                id_module INT NOT NULL AUTO_INCREMENT,
                id_page_module INT NULL DEFAULT '0',
                type_module TEXT NULL DEFAULT NULL,
                title_module TEXT NULL DEFAULT NULL,
                suffix_module TEXT NULL DEFAULT NULL,
                content_module TEXT NULL DEFAULT NULL,
                width_module INT NULL DEFAULT '100',
                editable_module INT NULL DEFAULT '1',
                date_created_module DATE NULL DEFAULT NULL, 
                date_updated_module TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id_module))";

            $stmtModules = InstallController::connect()->prepare($sqlModules);


            /*=================================================
                Creacion tabal Columns
            ===================================================*/

            $sqlColumns = "CREATE TABLE columns (
                id_column INT NOT NULL AUTO_INCREMENT,
                id_module_column INT NULL DEFAULT '0',
                title_column TEXT NULL DEFAULT NULL,
                alias_column TEXT NULL DEFAULT NULL,
                type_column TEXT NULL DEFAULT NULL,
                matrix_column TEXT NULL DEFAULT NULL,
                visible_column INT NULL DEFAULT '1',
                date_created_column DATE NULL DEFAULT NULL, 
                date_updated_column TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id_column))";

            $stmtColumns = InstallController::connect()->prepare($sqlColumns);

            if (
                $stmtAdmins->execute() &&
                $stmtPages->execute() &&
                $stmtModules->execute() &&
                $stmtColumns->execute()
            ) {

            /*=================================================
                Creacion super administrador
            ===================================================*/

                $url = "admins?register=true&suffix=admin";
                $method = "POST";
                $fields = array(
                    "rol_admin" => "superadmin",
                    "permissions_admin" =>  '{"todo":"on"}',
                    "email_admin" => trim($_POST["email_admin"]),
                    "password_admin" => trim($_POST["password_admin"]),
                    "title_admin" => trim($_POST["title_admin"]),
                    "symbol_admin" => trim($_POST["symbol_admin"]),
                    "font_admin" => trim($_POST["font_admin"]),
                    "color_admin" => trim($_POST["color_admin"]),
                    "back_admin" => trim($_POST["back_admin"]),
                    "date_created_admin" => date("Y-m-d")
                );

                $register = CurlController::request($url, $method, $fields);

                if ($register->status == 200) {

                    echo '<script>
                    fncMatPreloader("off");
                    fncFormatInputs();
                    fncToastr("success", "La instalación se ha completado exitosamente");
                    </script>';
                }
            }
        }
    }
}
