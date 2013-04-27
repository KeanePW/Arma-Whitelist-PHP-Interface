<?php
@session_start();
//Überprüfen ob Eingeloggt
if (empty($_SESSION['login'])){
   header('Location: logout.php');
}
//Auslesen der Daten aus der Session
$user_ingame = $_SESSION['user_ingame'];
$user_forum = $_SESSION['user_forum'];
$user_id = $_SESSION['user_id'];
//Weiterleitung wenn Ingamename in Forum eingetragen ist
if (!empty($_SESSION['user_ingame'])){
    header('Location: user1.php');
}
include ("db.php");
include ("config.php");
//Prüfen ob Username auf der Whitelist ist
$wl_check = mysql_query('SELECT name FROM whitelist WHERE name="'.$user_ingame.'"');
		$result = mysql_num_rows($wl_check);
if ($result !== 0){
    header('Location: user2.php');
}

include ("functions.php");
include ("lang/de_DE.php");

initHTML();
initMenu();

//Überprüft ob angemeldeter User als Admin eigentragen ist oder nicht. Wenn ja, dann wird der Link zum Admin Interface angezeigt
$permission_check_qry = mysql_query("SELECT permission FROM whitelist WHERE name = '".$user_ingame."'"); 
 
if(mysql_numrows($permission_check_qry)) 
{
    $permission_check_result = mysql_fetch_assoc($permission_check_qry);
    if ($permission_check_result['permission'] == "2")
    {
        echo "  <a href='admin/login.php'>Admin Interface</a>  ";
    }
}
echo $lang_user_login_as . " <strong>".$user_forum."</strong>. ";
echo "<br><br>";
	
//NEIN Kein Eintrag in Profilfeld vorhanden
echo "
    <table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
        <tr>
            <td style='text-align: right;'><img src='img/errorM.png' alt='STOP'></td>
            <td style='text-align: left;'><strong>".$lang_user_error_not_whitelist."</strong></td>
        </tr>
        <tr>
            <td style='text-align: right;'><img src='img/errorM.png' alt='STOP'></td>
            <td style='text-align: left;'><strong>".$lang_user_error_not_field_forum."</strong></td>
        </tr>
        <tr>
					
        <tr>
            <td><img src='img/tut_1.png' alt='Arma II Profilfeld'></td>
            <td style='text-align: left;'>".$lang_user_edit_field_forum_text_1."
            <br><a href='$config_forum_url/index.php?form=UserProfileEdit&category=profile' target_='blank'>".$lang_user_edit_field_forum_link."</a></td>
        </tr>
        <tr>
            <td><img src='img/tut_2.png' alt='Arma II Profilfeld Ingame'></td>
            <td style='text-align: left;'>".$lang_user_edit_field_forum_text_2."</td>
        </tr>
    </table>";
			
closeHtml();
?>