<?
session_start();
require("../config.php");
include("funciones.php");
$logadmin = limpiar($_POST['loginadmin']);
$logpass = limpiar($_POST['hash']);


	if(isset($logadmin) and isset($logpass)){
		if(!empty($logadmin)){
			if(!empty($logpass)){
				$admin = $logadmin;
				$adminsql = "SELECT * FROM admin WHERE user_name='".$admin."' AND user_password='".$logpass."' AND id=1";
				$resp_admin = mysql_query($adminsql);
				if($resp_admin){
					if(mysql_num_rows($resp_admin)==1){
						$ra = mysql_fetch_array($resp_admin);
						$_SESSION['adminid'] = $ra['id'];
						$_SESSION['adminuser'] = $ra['user_name'];
						unset($_SESSION['logon']);
						
						ir($_POST['referer']);
						
					} else {
						ir("index.php?error=false");
					}
				} else {
					echo $mysql_error;
				}
			} else {
				ir("index.php?error=false");
			}
		} else {
			ir("index.php?error=false");
		}
	} else {
		//echo "login_inicio";
		ir("index.php?error=false");
	}

mysql_close($dbh);
?>