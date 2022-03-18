<?php
    session_start();
    if ($_SESSION['usuario'] != 'admn') {
        header("Location: ../index.php");
    }
?>
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
            <a class="navbar-brand" href="../index.php">Breaking News</a>
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
    
    

    <div class="container">
        <div class="row">
            <?php
                if (isset($_POST['submit'])) {
                    include 'conexio.php';

                    $titulo=$_POST['titulo'];
                    $cuerpo=$_POST['cuerpo'];
                    $autor=$_POST['autor'];
                    $codiSeccion=$_POST['codiSeccion'];
                    $typeImg=$_FILES['image']['type'];
                    $tmp_name=$_FILES['image']['tmp_name'];
                    $datosImg=file_get_contents($tmp_name);
                    $datosImg=mysqli_real_escape_string($con, $datosImg);
                    $sql="insert into noticia (titol, cos, autor, codiSeccio, data, imatge, tipus) values ('".$titulo."','".$cuerpo."','".$autor."','".$codiSeccion."', CURDATE(),'".$datosImg."','".$typeImg."')";

                    mysqli_query($con, $sql);
                    if(mysqli_error($con)){
                        echo "
                        <div class='col-xs-12 error'>
                            <div class='text-center'>
                                Error en la subida: ".$mysqli_error($con)."
                            </div>
                        </div>
                        ";
                    }
                    else {
                        echo "
                        <div class='col-xs-12 correcto'>
                            <div class='text-center'>
                                Noticia subida correctamente.
                            </div>
                        </div>
                        ";
                    }

                    mysqli_close($con);
                }
                else if(isset($_POST['modificado'])){
                    include 'conexio.php';
                    $codiNoticia=$_POST['codiNoticia'];
                    $titulo=$_POST['tituloModificado'];
                    $cuerpo=$_POST['cuerpoModificado'];
                    $typeImg=$_FILES['imageModificada']['type'];
                    $tmp_name=$_FILES['imageModificada']['tmp_name'];
                    $datosImg=file_get_contents($tmp_name);
                    $datosImg=mysqli_real_escape_string($con, $datosImg);
                    $sql="update noticia set titol='$titulo', cos='$cuerpo', imatge='$datosImg', tipus='$typeImg'  where codiNoticia='$codiNoticia'";
                    
                    mysqli_query($con, $sql);
                    if(mysqli_error($con)){
                        echo "
                        <div class='col-xs-12 error'>
                            <div class='text-center'>
                                Error en la modificacio: ".$mysqli_error($con)."
                            </div>
                        </div>
                        ";
                    }
                    else {
                        echo "
                        <div class='col-xs-12 correcto'>
                            <div class='text-center'>
                                Noticia modificada correctamente.
                            </div>
                        </div>
                        ";
                    }

                    mysqli_close($con);
                }
                else if(isset($_POST['eliminar'])){
                    include 'conexio.php';

                    $codiNoticia=$_POST['codiEliminar'];
                    $sql="delete from noticia where codiNoticia='$codiNoticia'";
                    mysqli_query($con,$sql);
                    if(mysqli_error($con)){
                        echo "
                        <div class='col-xs-12 error'>
                            <div class='text-center'>
                                SQL ERROR: ".$mysqli_error($con)."
                            </div>
                        </div>
                        ";
                    }
                    else {
                        echo "
                        <div class='col-xs-12 correcto'>
                            <div class='text-center'>
                                Noticia eliminada.
                            </div>
                        </div>
                        ";
                    }

                    mysqli_close($con);
                }
            ?>
            <div class="col-xs-12">
                <h1>Agrega noticia</h1>
                <div class="jumbotron">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="inputTitulo">Titulo</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Titulo..." name="titulo" required>
                        </div>
                        <div class="form-group">
                            <label for="inputCuerpo">Cuerpo</label>
                            <textarea class="form-control" rows="5" name="cuerpo" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputAutor">Autor</label>
                            <input type="text" class="form-control" id="inputAutor" placeholder="Autor..." name="autor" required>
                        </div>
                        <div class="form-group">
                            <label for="inputSeccion">Sección</label>
                            <select name="codiSeccion" id="inputSeccion" required>
                                <?php
                                    include 'conexio.php';
                                    $sql="select codiSeccio, seccio from seccio";
                                    $res=mysqli_query($con, $sql);

                                    while ($fila = mysqli_fetch_assoc($res)) {
                                        echo "<option value='".$fila['codiSeccio']."'>".$fila['codiSeccio']." - ".$fila['seccio']."</option>";
                                    }

                                    mysqli_close($con);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputImagen">Imagen</label>
                            <input type="file" id="inputImagen" name="image" required>
                            <p class="help-block">Imagen de la noticia</p>
                        </div>
                        <button type="submit" class="btn btn-default" name="submit">Subir Noticia</button>
                    </form>
                </div>
            </div>

            <div class="col-xs-12">
                <h1>Elimina noticia</h1>
                <div class="jumbotron">
                    <form method="post">
                        <div class="form-group">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th>Titulo</th>
                                        <th>Fecha</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'conexio.php';
                                    $sql="select * from noticia";
                                    $res=mysqli_query($con, $sql);

                                    while($fila = mysqli_fetch_assoc($res)){
                                        echo "<tr>";
                                            echo "<td>".$fila['titol']."</td>";
                                            echo "<td>".$fila['data']."</td>";
                                            echo "<td> " . '<input type="radio" name="codiEliminar" value="' . $fila["codiNoticia"].'"></td>';
                                        echo "</tr>";
                                    }                
                                    ?>                                   
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-default" name="eliminar">Eliminar Noticia</button>
                    </form>
                </div>
            </div>

            <div class="col-xs-12">
                <h1>Modifica noticia</h1>
                <div class="jumbotron">
                    <form action="modifica.php" method="post">
                        <div class="form-group">
                            <label for="inputModificar">Titulo a Modificar</label>
                            <select name="codiModifica" id="inputModificar">
                            <?php
                                include 'conexio.php';
                                $sql="select * from noticia";
                                $res=mysqli_query($con, $sql);

                                while ($fila = mysqli_fetch_assoc($res)) {
                                    echo "<option value='".$fila['codiNoticia']."'>".$fila['titol']." - ".$fila['data']."</option>";
                                }

                                mysqli_close($con);
                            ?>        
                            </select> 
                        </div>
                        <button type="submit" name="modificar" class="btn btn-default">Modificar</button>
                    </form>       
                </div>
            </div>
        </div>
    </div>

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