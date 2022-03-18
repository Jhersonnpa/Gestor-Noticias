<?php
    session_start();
    if (!(($_SESSION['usuario'] == 'admn') || ($_SESSION['usuario'] == 'client'))) {
      header("Location: ../index.php");
    }

    if (isset($_REQUEST['paginacio'])) {
      $inici=$_REQUEST['paginacio'];
    }
    else {
      $inici=0;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
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
              <li class="active"><a href="client.php">Noticias</a></li>
              <?php
                if ($_SESSION['usuario'] == "admn") {
                    echo "<li><a href='admin.php'>Admin</a></li>";
                }
              ?>
            </ul>
            <form class="navbar-form navbar-right" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="inputBuscador" placeholder="Buscar">
              </div>
              <button type="submit" name="buscador" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Secciones <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <form method="post">
                    <?php
                    include 'conexio.php';

                    $sql="select seccio from seccio";
                    $res=mysqli_query($con, $sql);

                    while ($fila = mysqli_fetch_assoc($res)) {
                      echo "<li class='li'><input class='btn-seccio' type='submit' name='listSeccio' value='".$fila['seccio']."' ></li>";
                    }
                    mysqli_close($con);
                  ?>
                  </form>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>

      <div class="container">
        <div class="row">
          <h1 class="text-center">Noticias</h1>
          <div class="col-xs-12">
            <?php
              if (isset($_POST['listSeccio'])) {
                $linies=10;
                include 'conexio.php';
                $count=0;
                $sql="select n.titol, n.autor, n.cos, n.data, n.imatge, n.tipus, s.seccio from noticia n join seccio s on n.codiSeccio = s.codiSeccio where s.seccio = '".$_POST['listSeccio']."' order by codiNoticia DESC limit $inici,$linies";
                $res=mysqli_query($con, $sql);
                $res2=mysqli_query($con, $sql);
                $impresos=0;
                while ($filla = mysqli_fetch_assoc($res2)) {
                  $count++;
                }
                if ($count > 0) {
                  while ($fila = mysqli_fetch_assoc($res)) {
                    $impresos++;
                    echo "
                    <div class='jumbotron'>
                    <h1>".$fila['titol']."<h5>".$fila['seccio']."</h1><br><br><br>
                    <div class='row'>
                    <div class='col-sm-6'>";
                    echo '<img class="img-responsive " src="data:'.$fila['tipus'].';base64,'.base64_encode($fila['imatge']).'">'."
                    <br><br><br><p>Autor: ".$fila['autor']."</p>
                    <p>".$fila['data']."</p>
                    </div>
  
                    <div class='col-sm-6'>
                    <p class='lead'>".$fila['cos']."</p>
                    </div>
                    </div>
                    </div>
                    ";
                  }
                }
                else {
                  echo "
                    <div class='jumbotron'>
                    <h1>No se encontraron noticias de esta sección.</h1><br><br><br>
                    </div>
                    <br><br><br><br><br><br>
                  ";
                }
                
                mysqli_close($con);
                if ($inici!=0) {
                  $anterior = $inici - $linies;
                  echo "<a href='client.php?paginacio=$anterior' class='btn btn-default'>Anterior</a>";
                }
                if ($impresos == $linies) {
                  $proper = $inici + $linies;
                  echo "<a href='client.php?paginacio=$proper' class='btn btn-default'>Siguiente</a>";
                }
              }
              else if(isset($_POST['buscador'])) {
                $linies=10;
                include 'conexio.php';

                $string = $_POST['inputBuscador'];
                
                $sql="select * from noticia n join seccio s on n.codiSeccio = s.codiSeccio where cos LIKE '%$string%' OR titol LIKE '%$string%' OR autor LIKE '%$string%' OR data LIKE '%$string%' OR seccio LIKE '%$string%' limit $inici,$linies";
                $res=mysqli_query($con, $sql);
                $impresos=0;

                while ($fila = mysqli_fetch_assoc($res)) {
                  $impresos++;
                  echo "
                  <div class='jumbotron'>
                  <h1>".$fila['titol']."<h5>".$fila['seccio']."</h1><br><br><br>
                  <div class='row'>
                  <div class='col-sm-6'>";
                  echo '<img class="img-responsive " src="data:'.$fila['tipus'].';base64,'.base64_encode($fila['imatge']).'">'."
                  <br><br><br><p>Autor: ".$fila['autor']."</p>
                  <p>".$fila['data']."</p>
                  </div>

                  <div class='col-sm-6'>
                  <p class='lead'>".$fila['cos']."</p>
                  </div>
                  </div>
                  </div>
                  ";
                }
                mysqli_close($con);
                if ($inici!=0) {
                  $anterior = $inici - $linies;
                  echo "<a href='client.php?paginacio=$anterior' class='btn btn-default'>Anterior</a>";
                }
                if ($impresos == $linies) {
                  $proper = $inici + $linies;
                  echo "<a href='client.php?paginacio=$proper' class='btn btn-default'>Siguiente</a>";
                }
              }
              else {
                $linies=10;
                include 'conexio.php';
                $sql="select n.titol, n.autor, n.cos, n.data, n.imatge, n.tipus, s.seccio from noticia n  join seccio s on n.codiSeccio = s.codiSeccio order by codiNoticia DESC limit $inici,$linies ";
                $res=mysqli_query($con, $sql);
                $impresos=0;

                while ($fila = mysqli_fetch_assoc($res)) {
                  $impresos++;
                  echo "
                  <div class='jumbotron'>
                  <h1>".$fila['titol']."<h5>".$fila['seccio']."</h1><br><br><br>
                  <div class='row'>
                  <div class='col-sm-6'>";
                  echo '<img class="img-responsive " src="data:'.$fila['tipus'].';base64,'.base64_encode($fila['imatge']).'">'."
                  <br><br><br><p>Autor: ".$fila['autor']."</p>
                  <p>".$fila['data']."</p>
                  </div>

                  <div class='col-sm-6'>
                  <p class='lead'>".$fila['cos']."</p>
                  </div>
                  </div>
                  </div>
                  ";
                }
                mysqli_close($con);
                if ($inici!=0) {
                  $anterior = $inici - $linies;
                  echo "<a href='client.php?paginacio=$anterior' class='btn btn-default'>Anterior</a>";
                }
                if ($impresos == $linies) {
                  $proper = $inici + $linies;
                  echo "<a href='client.php?paginacio=$proper' class='btn btn-default'>Siguiente</a>";
                }
              }
            ?>
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