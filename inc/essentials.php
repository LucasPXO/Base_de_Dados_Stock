<?php

    //frontend purpose data

    define('SITE_URL', 'http://127.0.0.1/projetos/Noite%2026-12%20-%2031-12/');
    define('ABOUT_IMG_PATH', SITE_URL.'images/about/');
    

    //backend upload process needs this data

    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/Projetos/Noite 26-12 - 31-12/images/');
    define('ABOUT_FOLDER', 'about/');

    function adminLogin()
    {
        session_start();
        if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            echo"<script>
            window.location.href='index.php';
            </script>";
            exit;
        }
    }

    function redirect($url){
        echo"<script>
            window.location.href='$url';
            </script>";
        exit;
        
    }

    function alert($type, $msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

    

?>