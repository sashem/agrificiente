<? 
$pageURL = 'http';
if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}
$index_page2 = str_replace("/admin/","",$pageURL);//"http://".$_SERVER["SERVER_NAME"];
$index_page = str_replace("ckupload.php?CKEditor=editor1&CKEditorFuncNum=1&langCode=es","",$index_page2);
$index_page = str_replace("ckupload.php?CKEditor=editor2&CKEditorFuncNum=203&langCode=es","",$index_page);

//http://localhost/segurihost2/ckupload.php?CKEditor=editor1&CKEditorFuncNum=1&langCode=es/blogimg/20151023144942_385488297.png

$image = $_FILES['upload']['name'];
$partes = explode('.',$_FILES['upload']['name']) ;
$num = count($partes) - 1 ;
$extension = $partes[$num] ;
$carpeta_index = "../images/";
$carpeta_index2 = "/images/";
$seedx = str_replace("-","",rand(000000000000,999999999999));
$url = $carpeta_index.date('YmdHis')."_".$seedx.".".$extension;
$url2 = $index_page."/images/".date('YmdHis')."_".$seedx.".".$extension;

//$url = '../images/uploads/'.time()."_".$_FILES['upload']['name'];
 //extensive suitability check before doing anything with the file…
    if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
    {
       $message = "No file uploaded.";
    }
    else if ($_FILES['upload']["size"] == 0)
    {
       $message = "The file is of zero length.";
    }
    else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png"))
    {
       $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
    }
    else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
    {
       $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
    }
    else {
      $message = "";
      $move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $url);
      if(!$move)
      {
         $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
      }
      $url = "../" . $url;
    }
$funcNum = $_GET['CKEditorFuncNum'] ;
echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url2', '$message');</script>";
?>