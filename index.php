<?php
    session_start();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Breaking News</title>
</head>
<body>
    <div class="page">

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Breaking News</a>
              </div>
            </div><!-- /.container-fluid -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-push-2">
                    <div class="jumbotron">
                    <?php
                        if (isset($_POST['submit'])) {
                            if ($_POST['password'] == "JVjv2022") {
                                if ($_POST['usuario'] == 'client') {
                                    $_SESSION['log_user'] = 'client';
                                    $_SESSION["usuario"] = "client";
                                    $_SESSION["password"] = "Jvjv2022";
                                    $_SESSION['password']= md5($_SESSION['password']);
                                    header('Location: html/client.php');                                    
                                }
                                else if ($_POST['usuario'] == 'admn') {
                                    $_SESSION['log_user'] = 'admn';
                                    $_SESSION["usuario"] = "admn";
                                    header('Location: html/admin.php');
                                }
                            }
                            else {
                                echo "<h3>Datos incorrectos.<h3>";
                            }
                        }
                        else {
                            session_destroy();
                        }
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputUser">Usuario</label>
                            <input type="text" class="form-control" id="exampleUser" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" class="form-control" name="password" id="inputPassword" required>
                        </div>
                        <button type="submit" class="btn btn-default" name="submit">Login</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center footer">
            <p class="h5">All rights reserved. &copy; | Jherson Pabon 2022</p>
        </div>


    </div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>