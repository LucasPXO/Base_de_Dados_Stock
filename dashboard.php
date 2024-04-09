<?php
    require('inc/essentials.php');
    adminLogin();
?>
<!doctype html>
<html lang="en">
    <head>
        <title>PÁGINA INICIAL</title>
        <?php require('inc/links.php');?>
    </head>
    <style>
        #dashboard-menu{
            position: fixed;
            height: 100%;
            z-index: 11;
        }

        @media screen and (max-width: 991px){
            #dashboard-menu{
                height: auto;
                width: 100%;
            }
            #main-content{
                margin-top: 60px;
            }
        }
        .size-card{
            height: 200px;
        } 
    </style>
    <body>
        
    <?php require('inc/header.php');?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h1 class="p-2 mb-4">PÁGINA INICIAL</h1>
                <a href="bd_stock.php">
                    <div class="card bg-white text-white my-4">
                        <img class="card-img size-card" src="images/stock.png" alt="Card image">
                    </div>
                </a>
                <a href="bd_entradas.php">
                    <div class="card bg-white text-white my-4">
                        <img class="card-img size-card" src="images/basededados.png" alt="Card image">
                    </div>
                </a>
                <a href="bd_saidas.php">
                    <div class="card bg-white text-white my-4">
                        <img class="card-img size-card" src="images/basededados1.png" alt="Card image">
                    </div>
                </a>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php');?>

    </body>
</html>
