<?php 

class InstallController{

	/*=============================================
	Conexión a la base de datos
	=============================================*/

	static public function infoDatabase(){

		$infoDB = array(
			"database" => "pos",
			"user" => "root",
			"pass" => ""
		);

		return $infoDB;

	}

	static public function connect(){

		try{

			$link = new PDO("mysql:host=localhost;dbname=".InstallController::infoDatabase()["database"],
		                    InstallController::infoDatabase()["user"],
		                    InstallController::infoDatabase()["pass"]
		                );

			$link->exec("set names utf8");

		}catch(PDOException $e){

			die("Error: ".$e->getMessage());
		}

		return $link;

	}

	/*=============================================
	Instalación del sistema
	=============================================*/

	public function install(){

		if(isset($_POST["email_admin"])){

			echo '<script>
					fncMatPreloader("on");
					fncSweetAlert("loading", "Instalando...", "");
				</script>';
			
			/*=============================================
			Creamos la tabla admins
			=============================================*/
			
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

			/*=============================================
			Creamos la tabla pages
			=============================================*/
			
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

			/*=============================================
			Creamos la tabla modules
			=============================================*/
			
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

			/*=============================================
			Creamos la tabla columns
			=============================================*/
			
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

			if($stmtAdmins->execute() && 
			   $stmtPages->execute() &&
			   $stmtModules->execute() &&
			   $stmtColumns->execute()
			){

				/*=============================================
				Creamos el super administrador
				=============================================*/

				$url = "admins?register=true&suffix=admin";
				$method = "POST";
				$fields = array(
					"rol_admin" => "superadmin",
					"permissions_admin" => '{"todo":"on"}',
					"email_admin" => trim($_POST["email_admin"]),
					"password_admin" => trim($_POST["password_admin"]),
					"title_admin" => trim($_POST["title_admin"]),
					"symbol_admin" => trim($_POST["symbol_admin"]),
					"font_admin" => trim($_POST["font_admin"]),
					"color_admin" => trim($_POST["color_admin"]),
					"back_admin" => trim($_POST["back_admin"]),
					"date_created_admin" => date("Y-m-d")
				);

				$register = CurlController::request($url,$method,$fields);

				/*=============================================
				Creamos la página de inicio
				=============================================*/

				$url = "pages?token=no&except=id_page";
				$method = "POST";
				$fields = array(
					"title_page" => "Inicio",
					"url_page" => "inicio",
					"icon_page" => "bi bi-house-door-fill",
					"type_page" => "modules",
					"order_page" => 1,
					"date_created_page" => date("Y-m-d")
				);

				$homePage = CurlController::request($url,$method,$fields);

				/*=============================================
				Creamos la página de administradores
				=============================================*/

				$url = "pages?token=no&except=id_page";
				$method = "POST";
				$fields = array(
					"title_page" => "Admins",
					"url_page" => "admins",
					"icon_page" => "bi bi-person-fill-gear",
					"type_page" => "modules",
					"order_page" => 2,
					"date_created_page" => date("Y-m-d")
				);

				$adminPage = CurlController::request($url,$method,$fields);

				$url = "modules?token=no&except=id_module";
				$method = "POST";
				$fields = array(
					"id_page_module" => $adminPage->results->lastId,
					"type_module" => "breadcrumbs",
					"title_module" => "Administradores",
					"date_created_module"  => date("Y-m-d")
				);

				$breadcrumbModule = CurlController::request($url,$method,$fields);

				$url = "modules?token=no&except=id_module";
				$method = "POST";
				$fields = array(
					"id_page_module" => $adminPage->results->lastId,
					"type_module" => "tables",
					"title_module" => "admins",
					"suffix_module" => "admin",
					"editable_module" => 0,
					"date_created_module"  => date("Y-m-d")
				);

				$tableModule = CurlController::request($url,$method,$fields);

				if($register->status == 200 && 
				   $homePage->status == 200 &&
				   $adminPage->status == 200 &&
				   $breadcrumbModule->status == 200 &&
				   $tableModule->status == 200){

					/*=============================================
					Creamos cada una de las columnas de la tabla de administradores
					=============================================*/

					$columns = array(
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "rol_admin",
							"alias_column" => "rol",
							"type_column" =>  "select",
							"matrix_column"  => "admin,editor",
							"visible_column" => 1,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "permissions_admin",
							"alias_column" => "permisos",
							"type_column" =>  "object",
							"matrix_column"  => "",
							"visible_column" => 1,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "email_admin",
							"alias_column" => "email",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 1,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "password_admin",
							"alias_column" => "pass",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "token_admin",
							"alias_column" => "token",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "token_exp_admin",
							"alias_column" => "expiración",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "status_admin",
							"alias_column" => "estado",
							"type_column" =>  "boolean",
							"matrix_column"  => "",
							"visible_column" => 1,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "title_admin",
							"alias_column" => "título",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "symbol_admin",
							"alias_column" => "simbolo",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "font_admin",
							"alias_column" => "tipografía",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "color_admin",
							"alias_column" => "color",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						],
						[	
							"id_module_column" => $tableModule->results->lastId,
							"title_column" =>  "back_admin",
							"alias_column" => "fondo",
							"type_column" =>  "text",
							"matrix_column"  => "",
							"visible_column" => 0,
							"date_created_column" => date("Y-m-d")
						]
					);

					$countColumns = 0;

					foreach ($columns as $key => $value) {
						
						$url = "columns?token=no&except=id_column";
						$method = "POST";
						$fields = array(
							"id_module_column" => $value["id_module_column"],
							"title_column" =>  $value["title_column"],
							"alias_column" => $value["alias_column"],
							"type_column" =>  $value["type_column"],
							"matrix_column"  => $value["matrix_column"],
							"visible_column" => $value["visible_column"],
							"date_created_column" => $value["date_created_column"]
						);

						$createColumn = CurlController::request($url,$method,$fields);

						if($createColumn->status == 200){

							$countColumns++;

						}
							
					}

					if($countColumns == count($columns)){

						echo '<script>
						fncMatPreloader("off");
						fncFormatInputs();
						fncToastr("success","La instalación se ha completado",setTimeout(()=>location.reload(),1250));
						</script>';

					}	

				}

			}		

		}

	}

}

?>