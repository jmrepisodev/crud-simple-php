<?php

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once 'conexion.php';

	
	/*
	* función de filtrado
	*/
	function filtrado($datos){
		$datos = trim($datos); // Elimina espacios antes y después de los datos
		$datos = stripslashes($datos); // Elimina backslashes \
		$datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
		return $datos;
	}

	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['btnsave'])){

		$marca = filtrado($_POST['marca']);
		$tipo = filtrado($_POST['tipo']);
		
		$imgFile = $_FILES['imagen']['name'];
		$tmp_dir = $_FILES['imagen']['tmp_name'];
		$imgSize = $_FILES['imagen']['size'];
		
		
		if(empty($marca)){
			$errMSG = "Ingrese la marca";
		}
		else if(empty($tipo)){
			$errMSG = "Ingrese el tipo.";
		}
		else if(empty($imgFile)){
			$errMSG = "Seleccione el archivo de imagen.";
		}
		else
		{
			$upload_dir = './imagenes/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$imagen = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '1MB'
				if($imgSize < 1000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$imagen);
				}
				else{
					$errMSG = "Su archivo es muy grande.";
				}
			}
			else{
				$errMSG = "Solo archivos JPG, JPEG, PNG & GIF son permitidos.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $dbh->prepare('INSERT INTO coches (marca, modelo, imagen) VALUES(:marca, :tipo, :imagen)');
			$stmt->bindParam(':marca',$marca);
			$stmt->bindParam(':tipo',$tipo);
			$stmt->bindParam(':imagen',$imagen);
			
			if($stmt->execute())
			{
				$successMSG = "Nuevo registro insertado correctamente";
				header("refresh:3;index.php"); // redirects image view page after 3 seconds.
			}
			else
			{
				$errMSG = "Error al insertar ...";
			}
		}


	}
	
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Subir, Insertar, Actualizar, Borrar una imágen usando PHP y MySQL</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
		<!-- Latest compiled and minified JavaScript -->
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
			<h1 class="h3">Agregar nueva imágen. <a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; Mostrar todo </a></h1>
		</div>
		<?php
			if(isset($errMSG)){
		?>
			<div class="alert alert-danger"> 
				<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong> 
			</div>
		<?php
			}
			else if(isset($successMSG)){
		?>
			<div class="alert alert-success"> 
				<strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong> 
			</div>
		<?php
			}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
			<table class="table table-bordered table-responsive">
				<tr>
					<td><label class="control-label">Marca</label></td>
					<td><input class="form-control" type="text" name="marca" placeholder="Ingrese la Marca"  /></td>
				</tr>
				<tr>
					<td><label class="control-label">Modelo</label></td>
					<td><input class="form-control" type="text" name="tipo" placeholder="Ingrese el Modelo"  /></td>
				</tr>
				<tr>
					<td><label class="control-label">Imagen.</label></td>
					<td><input class="input-group" type="file" name="imagen" accept="image/*" /></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" name="btnsave" class="btn btn-default"> <span class="glyphicon glyphicon-save"></span> &nbsp; Guardar Imagen </button></td>
				</tr>
			</table>
		</form>
		</div>

	<!-- Latest compiled and minified JavaScript --> 
	<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>