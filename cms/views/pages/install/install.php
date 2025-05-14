<style>
    body {
        background: linear-gradient(135deg, #2f2f2f, #d3d3d3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .form-control:focus {
        border-color: #666;
        box-shadow: 0 0 0 0.2rem rgba(100, 100, 100, 0.25);
    }

    button[type="submit"] {
        background-color: #333;
        border: none;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #111;
    }

    .text-muted a {
        color: #cccccc;
    }

    .text-muted a:hover {
        color: #ffffff;
        text-decoration: underline;
    }

    .footer-reservados {
        color: #ffffff;
    }

    .form-wrapper {
        margin-top: 60px;
    }
</style>


<div class="container=fluid">

    <div class="d-flex flex-wrap justify-content-center align-content-center vh-100">

        <div class="card border-0 rounded shadow p-5">

            <form method="POST" class="needs-validation" novalidate>

                <h3 class="pt-3 text-center">Instalación</h3>

                <hr>

                <div class="form-group mb-3">

                    <label for="email_admin">Correo Administrador<sup>*</sup></label>

                    <input
                        type="email"
                        class="form-control rounded"
                        id="email_admin"
                        name="email_admin"
                        required>

                    <div class="valid-feedback">Válido</div>
                    <div class="invalid-feedback">Campo inválido</div>

                </div>

                <div class="form-group mb-3">

                    <label for="password_admin">Contraseña Administrador<sup>*</sup></label>

                    <input
                        type="password"
                        class="form-control rounded"
                        id="password_admin"
                        name="password_admin"
                        required>

                    <div class="valid-feedback">Válido</div>
                    <div class="invalid-feedback">Campo inválido</div>

                </div>

                <div class="form-group mb-3">

                    <label for="title_admin">Nombre del Dashboard<sup>*</sup></label>

                    <input
                        type="text"
                        class="form-control rounded"
                        id="title_admin"
                        name="title_admin"
                        required>

                    <div class="valid-feedback">Válido</div>
                    <div class="invalid-feedback">Campo inválido</div>

                </div>

                <div class="form-group mb-3">

                    <label for="symbol_admin">Simbolo del Dashboard<sup>*</sup></label>

                    <input
                        type="text"
                        class="form-control rounded"
                        id="symbol_admin"
                        name="symbol_admin"
                        required>

                    <div class="valid-feedback">Válido</div>
                    <div class="invalid-feedback">Campo inválido</div>    

                </div>

                <div class="form-group mb-3">

                    <label for="font_admin">Tipografia del Dashboard</label>

                    <textarea
                        class="form-control rounded"
                        id="font_admin"
                        name="font_admin"></textarea>

                </div>

                <div class="form-group mb-3">

                    <label for="color_admin">Color del Dashboard</label>

                    <input
                        type="color"
                        class="form-control form-control-color rounded"
                        id="color_admin"
                        name="color_admin"
                        value="#000000"
                        title="Elige un color">

                </div>

                <div class="form-group mb-3">

                    <label for="back_admin">Imagen para el Login</label>

                    <input
                        type="text"
                        class="form-control rounded"
                        id="back_admin"
                        name="back_admin">

                </div>

                <small><sup>*</sup>Campos Obligatorios</small>

                <button type="submit" class="btn btn-dark btn-block w-100 rounded mt-5">Instalar</button>

                <?php
                
                require_once "controllers/install.controller.php";
                $install = new InstallController();
                $install->install();

                ?>

            </form>

        </div>

    </div>

</div>

<!-- Texto de derechos reservados fuera del formulario -->
<div class="w-100 text-center mt-3">
    <small class="text-muted">
        &copy; 2025 Juan Diego Gutiérrez Venegas. Todos los derechos reservados.
        <a href="mailto:juandiguti@gmail.com" class="text-decoration-none">juandiguti@gmail.com</a>
    </small>
</div>