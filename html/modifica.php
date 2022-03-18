<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
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
                <a class="navbar-brand" href="../index.html">Breaking News</a>
            </div>
        
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                <li><a href="client.php">Noticias</a></li>
                <li><a href="admin.php">Admin</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        
        <?php
            include 'conexio.php';

            $codiNoticia=$_POST['codiModifica'];
            $sql="select * from noticia where codiNoticia=$codiNoticia";
            $res=mysqli_query($con, $sql);

            while ($fila = mysqli_fetch_assoc($res)) {
        ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="jumbotron">
                        <form action="admin.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputTitulo">Titulo</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $fila['titol'];?>" name="tituloModificado" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCuerpo">Cuerpo</label>
                                <textarea class="form-control" rows="5" name="cuerpoModificado" required><?php echo $fila['cos'];?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputImagen">Imagen</label>
                                <input type="file" id="inputImagen" name="imageModificada" required>
                                <input type="hidden" name="codiNoticia" value="<?php echo $codiNoticia;?>">
                            </div>
                            <div class="row">
                                <div class="col-xs-6"><button type="submit" name="modificado" class="btn btn-default">Modificar</button></div>
                                <div class="col-xs-6"><a href="admin.php" class="btn btn-default">Volver</a></div>
                            </div>
                        </form>       
                    </div>
                </div>
            </div>
        </div>
        <?php
            }

            mysqli_close($con);
        ?>

    </div>

    <div class="text-center footer">
        <p class="h5">All rights reserved. &copy; | Jherson Pabon 2022</p>
    </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>