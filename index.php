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
				
				if($stmt->rowCount() > 0)
				{
					while($row=$stmt->fetch(PDO::FETCH_ASSOC))
					{
						//Importa variables desde un array a la tabla de símbolos actual (extrae los pares clave-valor)
						//extract($row);
				?>
						<div class="col-xs-3">
							<p class="page-header"><?php echo $row['marca']."&nbsp;/&nbsp;".$row['modelo']; ?></p>
							<img src="./imagenes/<?php echo $row['imagen']; ?>" class="img-rounded" width="240px" height="240px" />
							<p class="page-header"> 
								<span> 
									<a class="btn btn-info" href="./editar.php?edit_id=<?php echo $row['id']; ?>" title="click for edit" onclick="return confirm('¿Esta seguro de editar el archivo ?')"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
									<a class="btn btn-danger" href="./eliminar.php?delete_id=<?php echo $row['id']; ?>" title="click for delete" onclick="return confirm('¿Esta seguro de eliminar el archivo?')"><span class="glyphicon glyphicon-remove-circle"></span> Borrar</a> 
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