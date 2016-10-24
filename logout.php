<?
session_start();

if(isset($_COOKIE['idkey']) && isset($_COOKIE['userkey'])){
	include("config.php");
	mysql_query("DELETE FROM cookies WHERE id_user=".$_SESSION['iduser']." AND email='".$_SESSION['email']."'");	
	setcookie("userkey", $key, 0, "/");
	setcookie("idkey", $keyuser, 0, "/");
}

unset($_SESSION["iduser"]);
unset($_SESSION["email"]);
unset($_SESSION["tipo"]);
//session_destroy();
?>
<SCRIPT LANGUAGE="javascript">
location.href = "index.php";
</SCRIPT>