<?php
@session_start();
if (empty($_SESSION['login'])){
   header('Location: logout.php');
}
//Check ob Profilfeld im Forum vorhanden ist
if (empty($_SESSION['user_ingame'])){
    header('Location: login.php');
    } 
include ("db.php");
$user_ingame = $_SESSION['user_ingame'];
//Check ob Name aus Profilfeld im Forum auf der Whitelist steht
$wl_check = mysql_query('SELECT name FROM whitelist WHERE name="'.$user_ingame.'"');
$result = mysql_num_rows($wl_check);
if ($result !== 1) {
    header('Location: login.php');
    } 
include ("functions.php");
include ("lang/de_DE.php");
initHTML();
initMenu();


//Anzeige wenn Spieler auf Whitelist
echo"
<table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
    <tr>
        <td style='text-align: right;'><img src='img/successM.png' alt='Ja'></td>
        <td style='text-align: left;'><strong>".$lang_user_success_whitelist_1."</strong></td>
    </tr>
    <tr>
        <td style='text-align: right;'><img src='img/successM.png' alt='STOP'></td>
        <td style='text-align: left;'><strong>".$lang_user_success_field_forum_1."</strong><br>".$lang_user_success_field_forum_2.": $user_ingame</td>
    </tr>
</table> <br>";
				
echo "
<table border='1' cellspacing='0' cellpadding='5' style='text-align: center;'>
    <tr>
        <td>".$lang_user2_table_head_1."</td>
        <td>".$lang_user2_table_head_2."</td>
        <td>".$lang_user2_table_head_3."</td>
        <td>".$lang_user2_table_head_4."</td>
    </tr>";
//Auslesen Whitelist Ja Daten
    $ergebnis = mysql_query('SELECT * FROM whitelist WHERE name="'.$user_ingame.'"');
    while($row = mysql_fetch_object($ergebnis)){
        echo "<tr>";
        echo 	"<td>$row->id</td>";
        echo 	"<td>$row->name</td>";
        //Aus Sicherheitsgründen nur gekürzte Whitelist
        $guid_short=substr($row->guid,0,-22);
        echo 	"<td>$guid_short**********************</td>";
        if ($row->is_whitelisted === "1")
            {echo "<td>".$lang_user2_table_yes."</td>";}
            else
            {echo "<td>".$lang_user2_table_no."</td>";}
    echo "</tr>";
    }
echo "</table><br>";
closeHtml();
?>
