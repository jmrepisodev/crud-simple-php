<?php
// Archivo de conexion con la base de datos
require_once 'conexion.php';

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=yes" />
		<title>CRUD PHP con imágenes</title>
		 <!-- Bootstrap 3 -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
		 <!-- jquery -->
		<script src="bootstrap/js/jquery.min.js"></script>
	</head>

	<body>
		<div class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header"> <a class="navbar-brand" href="index.php" title='Inicio' target="_blank">Inicio</a> </div>
			</div>
		</div>
		<div class="container">
			<div class="page-header">
				<h1 class="h2"> INICIO <a class="btn btn-default" href="./agregar.php"> <span class="glyphicon glyphicon-plus"></span> &nbsp; Agregar nuevo</a></h1>
			</div>
			<br />
			<div class="row">
				<?php
				
				$stmt = $dbh->prepare('SELECT * FROM coches ORDER BY id DESC');
				$stmt->execute();
				$coches = $stmt->fetchAll();
				
				if(count($coches) > 0)
				{
					for ($i = 0; $i < count($coches); $i++)
					{
						//Convierte cada elemento de un array en variables. Toma los índices asociativos de dicho array para nombrar las variables 
						//extract($row);
						$columns=4;
						if($i % $columns === 0 && $i > 0) { //si hay más de 3 columnas, pasamos a la siguiente fila
							echo '</div> 
							<div class="row p-3">';
						}

				?>
						<div class="col-xs-3">
							<h1 class="page-header"><?php echo $coches[$i]['marca']."&nbsp;/&nbsp;". $coches[$i]['modelo']; ?></h1>
							<img src="./imagenes/<?php echo  $coches[$i]['imagen']; ?>" class="img-fluid img-thumbnail" width="240px" height="240px"/>
							<p class="page-header"> 
								<span> 
									<a class="btn btn-info" href="./editar.php?edit_id=<?php echo  $coches[$i]['id']; ?>" title="click for edit" onclick="return confirm('¿Esta seguro de editar el archivo ?')"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
									<a class="btn btn-danger" href="./eliminar.php?delete_id=<?php echo  $coches[$i]['id']; ?>" title="click for delete" onclick="return confirm('¿Esta seguro de eliminar el archivo?')"><span class="glyphicon glyphicon-remove-circle"></span> Borrar</a> 
								</span> 
							</p>
						</div>
				<?php
					}
				}
				else
				{
				?>
					<div class="col-xs-12">
						<div class="alert alert-warning"> 
							<span class="glyphicon glyphicon-info-sign"></span> &nbsp; No existen productos en la base de datos 
						</div>
					</div>
				<?php
				}
				
			?>
			</div>
		
		</div>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>