<?php
// Archivo de conexion con la base de datos
require_once 'conexion.php';
// Condicional para validar el borrado de la imagen
if(isset($_GET['delete_id']))
{
	
	try{
        // Selecciona imagen a borrar
		$stmt_select = $dbh->prepare('SELECT * FROM coches WHERE id =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$coche=$stmt_select->fetch(PDO::FETCH_ASSOC);
		//Elimina el fichero en la ruta imagenes
		unlink("./imagenes/".$coche['imagen']);
		
		// Consulta para eliminar el registro de la base de datos
		$stmt_delete = $dbh->prepare('DELETE FROM coches WHERE id =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();
		// Redireccioa al inicio
		header("Location: index.php");

	}catch(PDOException $e) {
		$errores[]= $e->getMessage();
	}
	
	
}

?>