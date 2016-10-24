<?
if(isset($_POST['registrar'])){
	//echo "ok1"
	ini_set('display_errors',0);
	error_reporting(E_ALL);
	include_once("acciones.php");
	//echo "ok2"; die();
	registro($_POST['nombre_empresa'],$_POST['nombre'],$_POST['email'],$_POST['telefono'],$_POST['cargo'],$_POST['tipo']);
}
?>