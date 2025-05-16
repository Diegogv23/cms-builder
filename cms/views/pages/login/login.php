<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/custom/custom.css">
    <style>
        body {
            background: linear-gradient(135deg, #2f2f2f, #d3d3d3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        button[type="submit"] {
            background-color: #333;
            border: none;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #111;
        }

        
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/views/assets/css/custom/custom.css">
    <link rel="stylesheet" href="/views/template.php">
    
</head>

<body>

    <div class="container=fluid backgroundImage" <?php if (!empty($admin->back_admin)): ?>
        style="background-image: url(<?php echo $admin->back_admin ?>)"
        <?php endif; ?>>

        <div class="d-flex flex-wrap justify-content-center align-content-center vh-100">

            <div class="card border-0 rounded shadow p-5" style="min-width:320px !important">

                <form method="POST" class="needs-validation" novalidate>

                    <h3 class="pt-3 text-center">
                        <?php echo $admin->symbol_admin ?> <?php echo $admin->title_admin ?>
                    </h3>
                    <hr>

                    <div class="form-group mb-3">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control rounded" id="email" name="email" placeholder="Escribe el correo" required>
                        <div class="valid-feedback">Válido</div>
                        <div class="invalid-feedback">Campo inválido</div>
                    </div>

                    <div class="form-group mb-3 position-relative">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control rounded-end" id="password" name="password" placeholder="Escribe la contraseña" required>
                            <button type="button" class="btn btn-outline-secondary rounded-start" id="togglePassword">
                                👀
                            </button>
                        </div>
                        <div class="valid-feedback">Válido</div>
                        <div class="invalid-feedback">Campo inválido</div>
                        <div class="mt-2">
                            <a href="#" class="text-muted" style="font-size: 0.9rem;">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label" for="rememberMe">Recuerdame</label>
                    </div>

                    <button type="submit" class="btn btn-dark btn-block w-100 rounded mt-3 backColor">Entrar</button>

                    <?php 
                    
                    require_once "controllers/admins.controller.php";
                    $login = new AdminsController();
                    $login -> login();

                    ?>


                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="w-100 text-center mt-3">
        <small class="text-muted">
            &copy; 2025 Juan Diego Gutiérrez Venegas. Todos los derechos reservados.
            <a href="mailto:juandiguti@gmail.com" class="text-decoration-none">juandiguti@gmail.com</a>
        </small>
    </div>

    <script>
        // Bootstrap validación visual
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>

    <script>
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            toggleBtn.textContent = type === 'password' ? '👀' : '🙈';
        });
    </script>

</body>

</html>