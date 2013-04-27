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
if ($result !== 0) {
    header('Location: login.php');
    } 
include ("functions.php");
include ("config.php");
include ("lang/de_DE.php");
initHTML();
initMenu();

//Nicht auf Whitelist aber mit Profilfeld
//StatusÜbersicht
    echo"
    <table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
        <tr>
            <td style='text-align: right;'><img src='img/errorM.png' alt='STOP'></td>
            <td style='text-align: left;'><strong>".$lang_user_error_not_whitelist."</strong></td>
        </tr>
        <tr>
            <td style='text-align: right;'><img src='img/successM.png' alt='success'></td>
            <td style='text-align: left;'><strong>".$lang_user_success_field_forum_1."</strong><br>".$lang_user_success_field_forum_2.": $user_ingame<br>
            ".$lang_user_success_field_forum_3." <a href='$config_forum_url/index.php?form=UserProfileEdit&category=profile' target='_blank'>Link</a></td>
        </tr>
    </table>
    <br>" ;
			
    //In Whitelist eintragen
    if (!empty($_POST)){
        $guid_formular = $_POST["guid"];
        $name_new = $_POST["name"];
        $is_whitelised_new = "1";
        if(strlen($guid_formular) == 32){
            $eintragen = mysql_query("INSERT INTO whitelist (id, name, guid, is_whitelisted, permission) VALUES (NULL, '".mysql_real_escape_string($name_new)."', '".mysql_real_escape_string($guid_formular)."', '".mysql_real_escape_string($is_whitelised_new)."', 1)");
		if(!$eintragen){
                    echo "fehler: ",mysql_error(),"<br>"; 
                }
                else{
                    echo "
                        <table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
                            <tr>
                                <td> <img src='img/successM.png' alt='GUID Erfolgreich'> </td>
                                    <td> ".$guid_formular."".$lang_user1_whitelist_add_sql_success."</td>
                            </tr>
                        </table>";
                }
	}		
        else{
            echo "
                <table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
                    <tr>
                        <td>".$lang_user1_whitelist_add_sql_error.": $guid_formular <br></td>
                    </tr>
                </table>" ;
	}
    }
//Anzeige Whitelist_Add Forumlar      
    echo "
    <table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
        <tr>
            <td>
                <strong>".$lang_user1_whitelist_add_form_headline.":</strong>
                <form method='post' action='user1.php'>
                    <p><label>".$lang_user1_whitelist_add_form_ingame_name.":<br><input type='text' name='name' value='$user_ingame' readonly></label</p>
                    <p><label>".$lang_user1_whitelist_add_form_guid.":<br><input type='text' name='guid'></label></p><br>
                    <input type='submit' value='".$lang_user1_whitelist_add_form_send."'> <input type='reset' value='".$lang_user1_whitelist_add_form_cancel."'>
                </form>
            </td>
            <td>
            ".$lang_user1_whitelist_add_form_hint."
            </td>
        </tr>
    </table> <br> <br>
    <strong>".$lang_user1_whitelist_add_description_head."</strong>
    <p>".$lang_user1_whitelist_add_description_text_long."</p>
    ".$lang_user1_whitelist_add_description_text_short_head."<br>
    <p>
        1. ".$lang_user1_whitelist_add_description_text_short_1."</br>
        2. ".$lang_user1_whitelist_add_description_text_short_2."</br>
        3. ".$lang_user1_whitelist_add_description_text_short_3."</br>
        4. ".$lang_user1_whitelist_add_description_text_short_4."</br>
    </p>
    ";
    closeHtml();
?>