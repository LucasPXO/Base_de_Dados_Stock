<?php
    require('inc/db_config.php');
    require('inc/essentials.php');

    session_start();
        if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            redirect('dashboard.php');
        }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>DATABASE LOGIN</title>
        <!-- Required meta tags -->
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <!-- Bootstrap CSS v5.2.1 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
        <style>
            .form-login{
                position: absolute;
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%);
                width:350px;
            }

            .custom-bg{
                background-color: #2ec1ac;
                border:1px solid #2ec1ac;
            }

            .custom-bg:hover{
                background-color: #279e8c;
                border-color: #279e8c;
            }

        </style>
    </head>
    <body class="bg-white">
        
        <div class="form-login text-center rounded bg-white shadow overflow-hidden">
            <form method="POST">
                <h4 class="bg-dark text-white py-3">DATABASE LOGIN PANEL</h4>
                <div class="p-4">
                    <div class="mb-4">
                        <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
                    </div>
                    <div class="mb-4">
                        <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                    </div>
                    <button name="login" type="submit" class="btn text-white custom-bg shadow-none">LOGIN</button>
                </div>
            </form>
        </div>
        
        <?php
    
            if(isset($_POST['login']))
            {
                $frm_data = filteration($_POST);
                
                $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
                $values = [$frm_data['admin_name'],$frm_data['admin_pass']];

                $res = select($query,$values,"ss");
                if($res->num_rows==1){
                    $row = mysqli_fetch_assoc($res);
                    $_SESSION['adminLogin'] = true;
                    $_SESSION['adminId'] = $row['sr_no'];
                    redirect('dashboard.php');
                }
                else{
                    alert('error', 'Login failed - Invalid Credentials!');
                }
            }

        ?>
            
        <!-- Bootstrap JavaScript Libraries --> 
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    </body>
</html>
