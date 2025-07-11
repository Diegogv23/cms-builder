<?php

class PagesController
{

    public function managePage()
    {

        if (isset($_POST["title_page"])) {

            echo '<pre>';
            print_r($_POST);
            echo '</pre>';

            

            $url = "pages?linkTo=title_page,url_page&equalTo=" . trim($_POST["title_page"]) . "," . trim($_POST["url_page"]);
            $method = "GET";
            $fields = array();

            $getPage = CurlController::request($url, $method, $fields);

            if ($getPage->status == 200) {

                echo '

                <script>
                
                    fncMatPreloader("off");
                    fncFormatInput();
                    fncToastr("error", "ERROR: Esta pagina ya existe, por favor intente con otra");

                </script>';

                return;
            }

            /*==============================================
            Crear pagina
            ==============================================*/

        }
    }
}



?>