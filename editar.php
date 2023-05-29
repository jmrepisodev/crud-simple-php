<?php
error_reporting( ~E_NOTICE );	

require_once 'conexion.php';

if(!empty($_GET['edit_id']) && is_numeric($_GET["edit_id"]))
{
	try {
		$id = $_GET['edit_id'];
		$stmt_edit = $dbh->prepare('SELECT * FROM coches WHERE id =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		//crea pares clave-valor. Los nombres de variables corresponden a los nombres de las columnas de la base de datos
		extract($edit_row);
	}catch(PDOException $e) {
		$errores[]= $e->getMessage();
	}
}
else
{
	header("Location: index.php");
}	



if(isset($_POST['btn_update']))
{
	$marca = $_POST['marca'];
	$tipo = $_POST['tipo'];
		
	$imgFile = $_FILES['imagen']['name'];
	$tmp_dir = $_FILES['imagen']['tmp_name'];
	$imgSize = $_FILES['imagen']['size'];

				
	if($imgFile)
	{
		$upload_dir = './imagenes/'; // upload directory	
		$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		$imagen = rand(1000,1000000).".".$imgExt; //nombre aleatorio

		if(in_array($imgExt, $valid_extensions))
		{			
			if($imgSize < 1000000)
			{
				//eliminamos la imagen previa almacenada
				unlink($upload_dir.$edit_row['imagen']);
				//subimos la nueva imagen
				move_uploaded_file($tmp_dir,$upload_dir.$imagen);
			}
			else
			{
				$errMSG = "Su archivo es mayor a 1MB";
			}
		}
		else
		{
			$errMSG = "Solo archivos JPG, JPEG, PNG & GIF .";		
		}	
	}
	else
	{
		// if no image selected the old image remain as it is.
		$imagen = $edit_row['imagen']; // old image from database
	}	
					
	
	// if no error occured, continue ....
	if(!isset($errMSG))
	{
		$stmt = $dbh->prepare('UPDATE coches
								SET marca=:marca, 
									modelo=:tipo, 
									imagen=:imagen 
								WHERE id=:uid');
		$stmt->bindParam(':marca',$marca);
		$stmt->bindParam(':tipo',$tipo);
		$stmt->bindParam(':imagen',$imagen);
		$stmt->bindParam(':uid',$id);
			
		if($stmt->execute()){
			?>
	<script>
			alert('Archivo editado correctamente');
			window.location.href='index.php';
	</script>
<?php
		}
		else{
			$errMSG = "Error: Ha sido imposiblbe actualizar el producto!";
		}		
	}						
}	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>CRUD PHP con imágenes</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

		<!-- custom stylesheet -->
		<link rel="stylesheet" href="style.css">

		<!-- Latest compiled and minified JavaScript -->

	</head>
<body>
<div class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header"> <a class="navbar-brand" href="index.php" title='Inicio' target="_blank">Inicio</a> </div>
  </div>
</div>
<div class="container">
  <div class="page-header">
    <h1 class="h2">Actualizar producto. <a class="btn btn-default" href="./index.php"> Mostrar todos los modelos </a></h1>
  </div>

  <div class="clearfix"></div>

  <form method="post" enctype="multipart/form-data" class="form-horizontal">
    <?php
	if(isset($errMSG)){
		?>
		<div class="alert alert-danger"> 
			<span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?> 
		</div>
    <?php
	}
	?>
    <table class="table table-bordered table-responsive">
      <tr>
        <td><label class="control-label">Marca.</label></td>
        <td><input class="form-control" type="text" name="marca" value="<?php echo $edit_row['marca']; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Tipo.</label></td>
        <td><input class="form-control" type="text" name="tipo" value="<?php echo $edit_row['modelo']; ?>" required /></td>
      </tr>
      <tr>
        <td><label class="control-label">Imágen.</label></td>
        <td><p><img src="./imagenes/<?php echo $edit_row['imagen']; ?>" height="150" width="150" /></p>
          <input class="input-group" type="file" name="imagen" accept="image/*" /></td>
      </tr>
      <tr>
        <td colspan="2">
			<button type="submit" name="btn_update" class="btn btn-default"> <span class="glyphicon glyphicon-save"></span> Actualizar </button>
          	<a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-backward"></span> cancelar </a>
		</td>
      </tr>
    </table>
  </form>
 
</div>
</body>
</html>