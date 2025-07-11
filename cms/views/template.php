<?php

/*=============================================
Inicializacion de sesión
=============================================*/
ob_start();
session_start();

/*=============================================
Capturar parámetros de la url
=============================================*/

$routesArray = explode("/", $_SERVER["REQUEST_URI"]);
array_shift($routesArray);

foreach ($routesArray as $key => $value) {
	$routesArray[$key] = explode("?", $value)[0];
}

$url = "admins";
$method = "GET";
$fields = array();

$adminTable = CurlController::request($url, $method, $fields);

$admin = null;

if ($adminTable !== null && isset($adminTable->status) && $adminTable->status != 404) {
	if (isset($adminTable->results) && is_array($adminTable->results) && count($adminTable->results) > 0) {
		$admin = $adminTable->results[0];
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="https://cdn-icons-png.flaticon.com/512/18234/18234191.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<?php if (!empty($admin)): ?>
		<title><?php echo $admin->title_admin ?></title>

		<?php if ($admin->font_admin != "null"): ?>
			<?php echo $admin->font_admin ?>
		<?php endif ?>

		<style>
			<?php
			// Extraer nombre de la fuente de manera segura
			$fontName = "sans-serif";
			if (!empty($admin->font_admin) && $admin->font_admin != "null") {
				$fontUrlParts = explode("?", $admin->font_admin);
				if (isset($fontUrlParts[1])) {
					$queryParts = explode(":", $fontUrlParts[1]);
					if (isset($queryParts[0])) {
						$keyValue = explode("=", $queryParts[0]);
						if (isset($keyValue[1])) {
							$fontName = str_replace("+", " ", $keyValue[1]);
						}
					}
				}
			}
			?>
			body {
				font-family:
					<?php echo $fontName ?>
					, sans-serif !important;
			}

			/*=============================================
				Color del dashboard
				=============================================*/

			.backColor {
				background:
					<?php echo $admin->color_admin ?>
					!important;
				color: #FFF !important;
				border: 0 !important;
			}

			.form-check-input:checked {
				background-color:
					<?php echo $admin->color_admin ?>
					!important;
				border-color:
					<?php echo $admin->color_admin ?>
					!important;
			}

			.textColor {
				color:
					<?php echo $admin->color_admin ?>
					!important;
			}
		</style>

	<?php else: ?>
		<title>CMS BUILDER</title>
	<?php endif ?>



	<!--=============================================
	Alertas personalizadas
	===============================================-->

	<script src="/views/assets/js/alerts/alerts.js"></script>

	<!--=============================================
	PLUGINS CSS
	===============================================-->

	<!-- https://www.w3schools.com/bootstrap5/ -->
	<link rel="stylesheet" href="/views/assets/plugins/bootstrap5/bootstrap.min.css">
	<!-- https://fontawesome.com/v5/search -->
	<link rel="stylesheet" href="/views/assets/plugins/fontawesome-free/css/all.min.css">
	<!-- https://icons.getbootstrap.com/ -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
	<!-- https://www.jqueryscript.net/demo/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3/#google_vignette -->
	<link rel="stylesheet" href="/views/assets/plugins/material-preloader/material-preloader.css">
	<!-- https://codeseven.github.io/toastr/demo.html -->
	<link rel="stylesheet" href="/views/assets/plugins/toastr/toastr.min.css">
	<!--  https://www.daterangepicker.com/ -->
	<link rel="stylesheet" href="/views/assets/plugins/daterangepicker/daterangepicker.css">
	<!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
	<link rel="stylesheet" href="/views/assets/plugins/tags-input/tags-input.css">
	<!-- https://select2.org/ -->
	<link rel="stylesheet" href="/views/assets/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="/views/assets/plugins/select2/select2-bootstrap4.min.css">
	<!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
	<link rel="stylesheet" href="/views/assets/plugins/datetimepicker/datetimepicker.min.css">
	<!-- https://summernote.org -->
	<link rel="stylesheet" href="/views/assets/plugins/summernote/summernote-bs4.min.css">
	<link rel="stylesheet" href="/views/assets/plugins/summernote/summernote.min.css">
	<link rel="stylesheet" href="/views/assets/plugins/summernote/emoji.css">
	<!-- https://codemirror.net/ -->
	<link rel="stylesheet" href="/views/assets/plugins/codemirror/codemirror.css">
	<link rel="stylesheet" href="/views/assets/plugins/codemirror/monokai.css">

	<!--=============================================
	PLUGINS JS
	===============================================-->

	<!-- https://jquery.com/ -->
	<script src="/views/assets/plugins/jquery/jquery.min.js"></script>
	<!-- https://jqueryui.com/ -->
	<script src="/views/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<!-- https://www.w3schools.com/bootstrap5/ -->
	<script src="/views/assets/plugins/bootstrap5/bootstrap.bundle.min.js"></script>
	<!-- https://sweetalert2.github.io/ -->
	<script src="/views/assets/plugins/sweetalert/sweetalert.min.js"></script>
	<!-- https://www.jqueryscript.net/demo/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3/ -->
	<script src="/views/assets/plugins/material-preloader/material-preloader.js"></script>
	<!-- https://codeseven.github.io/toastr/demo.html -->
	<script src="/views/assets/plugins/toastr/toastr.min.js"></script>
	<!-- http://josecebe.github.io/twbs-pagination/ -->
	<script src="/views/assets/plugins/twbs-pagination/twbs-pagination.min.js"></script>
	<!-- https://momentjs.com/ -->
	<script src="/views/assets/plugins/moment/moment.min.js"></script>
	<script src="/views/assets/plugins/moment/moment-with-locales.min.js"></script>
	<!--  https://www.daterangepicker.com/ -->
	<script src="/views/assets/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
	<script src="/views/assets/plugins/tags-input/tags-input.js"></script>
	<!-- https://select2.org/ -->
	<script src="/views/assets/plugins/select2/select2.full.min.js"></script>
	<!-- https://xdsoft.net/jqplugins/datetimepicker/ -->
	<script src="/views/assets/plugins/datetimepicker/datetimepicker.full.min.js"></script>
	<!-- https://summernote.org -->
	<script src="/views/assets/plugins/summernote/summernote.min.js"></script>
	<script src="/views/assets/plugins/summernote/summernote-bs4.js"></script>
	<script src="/views/assets/plugins/summernote/summernote-code-beautify-plugin.js"></script>
	<script src="/views/assets/plugins/summernote/emoji.config.js"></script>
	<script src="/views/assets/plugins/summernote/tam-emoji.min.js"></script>
	<!-- https://codemirror.net/ -->
	<script src="/views/assets/plugins/codemirror/codemirror.js"></script>
	<script src="/views/assets/plugins/codemirror/xml.js"></script>
	<script src="/views/assets/plugins/codemirror/formatting.js"></script>
	<!-- https://www.chartjs.org/ -->
	<script src="/views/assets/plugins/chartjs/chartjs.min.js"></script>

	<!--=============================================
	CUSTOM CSS
	===============================================-->
	<link rel="stylesheet" href="/views/assets/css/custom/custom.css">
	<link rel="stylesheet" href="/views/assets/css/dashboard/dashboard.css">


</head>

<body>

	<?php

	if (!isset($_SESSION["admin"])) {

		if ($admin == null) {

			include "pages/install/install.php";
		} else {

			include "pages/login/login.php";
		}
	}

	?>

	<?php if (isset($_SESSION["admin"])): ?>

		<!--=============================================
		Plantilla de CMS
		===============================================-->
		<div class="d-flex backDashboard" id="wrapper">

			<!--=============================================
			SIDEBAR
			===============================================-->

			<?php include "modules/sidebar.php"; ?>

			<div id="page-content-wrapper">

				<!--=============================================
				NAV
				===============================================-->

				<?php include "modules/nav.php"; ?>

				<!--=============================================
				MAIN PAGE
				===============================================-->

				<?php if (!empty($routesArray[0])): ?>

					<?php if ($routesArray[0] == "logout"): ?>

						<?php include "pages/" . $routesArray[0] . "/" . $routesArray[0] . ".php"; ?>

					<?php endif ?>

					<?php include "pages/dynamic/dynamic.php"; ?>

				<?php endif ?>

			</div>

		</div>

		<?php
		include "modules/modals/profile.php";
		require_once "controllers/admins.controller.php";
		$update = new AdminsController();
		$update->updateAdmin();

		if ($_SESSION["admin"]->rol_admin == "superadmin") {

			include "views/modules/modals/pages.php";

			require_once "controllers/pages.controller.php";
			$page = new PagesController();
			$page->managePage();

		}

		?>

	<?php endif ?>

	<!--=============================================
	CUSTOM JS
	===============================================-->

	<script src="/views/assets/js/dashboard/dashboard.js"></script>
	<script src="/views/assets/js/forms/forms.js"></script>
	<script src="/views/assets/js/pages/pages.js"></script>


</body>

</html>