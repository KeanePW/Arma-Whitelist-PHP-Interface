<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//Überprüfen ob Eingeloggt
if (empty($_SESSION['login'])){
   header('Location: ../logout.php');
}
if (empty($_SESSION['user_ingame'])){
    header('Location: ../login.php');
    } 
include ("../db.php");
include ("../functions.php");
include ("../config.php");
include ("../lang/de_DE.php");
$user_forum = $_SESSION['user_forum'];
$user_id = $_SESSION['user_id'];
$user_ingame = $_SESSION['user_ingame'];
//ADMIN CHECK
$permission_check_qry = mysql_query("SELECT permission FROM whitelist WHERE name = '".$user_ingame."'"); 
 
if(mysql_numrows($permission_check_qry)) 
{
    $permission_check_result = mysql_fetch_assoc($permission_check_qry);
    if ($permission_check_result['permission'] === "2")
    {
      
initHtml();
initMenu();
//Ausgabe Suchergebnisse
if (!empty($_POST['search'])){
    $search_text = $_POST['search'];
    echo $lang_admin_search_result." " . $search_text ;
    echo "<table border='1' cellspacing='0' cellpadding='5' style='text-align: center;'>";
    echo 	"<tr>";
    echo 		"<td>".$lang_admin_table_1."</td>";
    echo 		"<td>".$lang_admin_table_2."</td>";
    echo 		"<td>".$lang_admin_table_3."</td>";
    echo 		"<td>".$lang_admin_table_4."</td>";
    echo 		"<td>".$lang_admin_table_5."</td>";
    echo 		"<td></td>";
    echo 	"</tr>";
			
    $search_ergebnis = mysql_query("SELECT * FROM `whitelist` WHERE `ID` = '" . mysql_real_escape_string($search_text) . "' OR `Name` = '" . mysql_real_escape_string($search_text) . "' OR `GUID` = '" . mysql_real_escape_string($search_text) . "' OR `is_whitelisted` = '" . mysql_real_escape_string($search_text) . "' OR `permission` = '" . mysql_real_escape_string($search_text) . "'");
    while($row = mysql_fetch_object($search_ergebnis)){
        echo "<tr>";
        echo 	"<td>$row->id</td>";
        echo 	"<td>$row->name</td>";
        echo 	"<td>$row->guid</td>";
        if ($row->is_whitelisted === "1")
            {echo "<td>".$lang_admin_table_yes."</td>";}
        else
            {echo "<td>".$lang_admin_table_no."</td>";}
        if ($row->permission === "2")
            {echo "<td>Admin</td>";}
        else
            if ($row->permission === "1")
                {echo "<td>".$lang_admin_table_admin."</td>";}
            else
                {echo "<td>".$lang_admin_table_error."</td>";}
        echo	"<td><a href='login.php?action=1&nr=".$row->id."'><img src='./b_edit.png' title='".$lang_admin_table_edit."'></a> <a href='login.php?action=2&nr=".$row->id."'><img src='./b_drop.png' title='".$lang_admin_table_delete."'></a></td>";
        echo 	"</tr>";
    }
    echo 	"</table><br>";
}
//Ausgabe Actions
if (isset($_GET['action'])){
    if ($_GET['action']== "1"){
     	
    //Bearbeiten
		$edit = mysql_query('SELECT * FROM whitelist WHERE id="'. $_GET['nr'].'"');
		$form_edit = mysql_fetch_object($edit);
		echo "
		<form method='post' action='login.php?action=11'>
		<table>
			<tr>
				<td></td>
				<td>".$lang_admin_table_1."</td>
				<td>".$lang_admin_table_2."</td>
				<td>".$lang_admin_table_3."</td>
				<td>".$lang_admin_table_4."</td>
				<td>".$lang_admin_table_5."</td>
			</tr>
			<tr>
				<td>Alt</td>
				<td>$form_edit->id</td>
				<td>$form_edit->name</td>
				<td>$form_edit->guid</td>";
                                if ($form_edit->is_whitelisted === "1")
                                    {echo "<td>".$lang_admin_table_yes."</td>";}
                                else{
                                    if ($form_edit->is_whitelisted === "0")
                                    {echo "<td>".$lang_admin_table_no."</td>";}
                                    else
                                        {echo $lang_admin_table_error;}
                                }
                		if ($form_edit->permission === "1")
                                    {echo "<td>".$lang_admin_table_permission_user."</td>";}
                                else{
                                    if ($form_edit->permission === "2")
                                        {echo "<td>".$lang_admin_table_permission_admin."</td>";}
                                    else{
                                        echo $lang_admin_table_error;}
                                }			
			echo "
			</tr>
			<tr>
				<td>".$lang_admin_table_new."</td>
				<td><label><input type='text' name='id' value='$form_edit->id' readonly></label></td>
				<td><label><input type='text' name='name' value='$form_edit->name'></label></td>
				<td><label><input type='text' name='guid' value='$form_edit->guid' size='32' maxlength='32'></label></td>";
				
		if ($form_edit->is_whitelisted === "1")
			{echo "
				<td><select name='is_whitelisted' size='1'><option selected='selected'>".$lang_admin_table_yes."</option><option>".$lang_admin_table_no."</option></select></td>";
			}
		else{
                    if ($form_edit->is_whitelisted === "0")
                        { echo "
                                <td><select name='is_whitelisted' size='1'><option>".$lang_admin_table_yes."</option><option selected='selected'>".$lang_admin_table_no."</option></select></td>";
			}
                    else{
                        echo $lang_admin_table_error;
                    }
                }
		
		if ($form_edit->permission === "1")
			{echo "
				<td><select name='permission' size='1'><option selected='selected'>".$lang_admin_table_permission_user."</option><option>".$lang_admin_table_permission_admin."</option></select></td>";
			}
		else{
                    if ($form_edit->permission === "2")
			{ echo "
				<td><select name='permission' size='1'><option>".$lang_admin_table_permission_user."</option><option selected='selected'>".$lang_admin_table_permission_admin."</option></select></td>";
			}
                    else{
                        echo $lang_admin_table_error;
                    }
                }
		echo"
			</tr>
		</table>
		
	
		<input type='submit' value='".$lang_admin_table_edit_send."' name='edit_button'> <input type='reset' value='".$lang_admin_table_cancel."'>
		</form>";
    }

if ($_GET['action']== "11"){
	  //Bearbeiten absenden
		if ($_POST['is_whitelisted'] === "Nein")
			{$is_whitelisted = "0";}
		else
			{$is_whitelisted = "1";}
			
		if ($_POST['permission'] === "Admin")
			{$permission = "2";}
		else
			{$permission = "1";}
				
		$update = mysql_query("UPDATE `whitelist` SET `name` = '".$_POST['name']."',`guid` = '".$_POST['guid']."',`is_whitelisted` = '".$is_whitelisted."',`permission` = '".$permission."' WHERE `id` = ".$_POST['id']."");
		
		if(!$update) 
			{
				echo "fehler: ",mysql_error(),"<br>"; 
			}
			else 
			{
				echo "<table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
					<tr>
						<td> <img src='../img/successM.png' alt='GUID Erfolgreich'> </td>
						<td> ".$lang_admin_table_success_to_sql."!</td>
					</tr>
					<tr>
						<td colspan='2'><a href='login.php'>".$lang_admin_table_back."</a></td>
					</tr>
				</table>";
			}
}
	  
if ($_GET['action']== "2"){
        
		$del_nr = $_GET['nr'];		
		$del = mysql_query('SELECT * FROM whitelist WHERE id="'. $del_nr.'"');
		$form_del = mysql_fetch_object($del);
		$del_name = $form_del->name;
		
				
		
		echo $lang_admin_table_delete_confirm_1." \"". $del_name."\" ".$lang_admin_table_delete_confirm_2."\n";
		echo "	<form action='login.php?action=22&nr=".$del_nr."' method='POST'>\n";
		echo "  <input type='submit' name='del' value='".$lang_admin_table_yes."'>\n";
		echo "  <input type='submit' name='del' value='".$lang_admin_table_no."'>\n";
		echo "</form>\n";
		echo $del_nr;
}		
		
if ($_GET['action']== "22"){
		$del_22_nr = $_GET['nr'];
						
		if($_POST['del'] === "Ja"){
			$del_22 = mysql_query("DELETE FROM whitelist WHERE id=".$del_22_nr."");}
		if(!$del_22) 
			{
				echo "fehler: ",mysql_error(),"<br>"; 
			}
			else 
			{
				echo "<table border='0' cellspacing='0' cellpadding='5' style='text-align: center;'>
					<tr>
						<td> <img src='../img/successM.png' alt='GUID Erfolgreich'> </td>
						<td> ".$lang_admin_table_delete_success."</td>
					</tr>
					<tr>
						<td colspan='2'><a href='login.php'>".$lang_admin_table_back."</a></td>
					</tr>
				</table>";
			}
}
}
//Suche	
echo " 
    <form method='post' action='login.php'>
        <label>Suche: <input type='text' name='search'></label> <input type='submit' value='Search' name='search_button'>
    </form>";
		
//Darstellung Hauptliste
echo "<table border='1' cellspacing='0' cellpadding='5' style='text-align: center;'>";
echo 	"<tr>";
echo        "<td>".$lang_admin_table_1."</td>";
echo        "<td>".$lang_admin_table_2."</td>";
echo        "<td>".$lang_admin_table_3."</td>";
echo        "<td>".$lang_admin_table_4."</td>";
echo        "<td>".$lang_admin_table_5."</td>";
echo        "<td></td>";
echo 	"</tr>";
$admin_ergebnis = mysql_query('SELECT * FROM whitelist');
while($row = mysql_fetch_object($admin_ergebnis))
    {
    echo "<tr>";
    echo    "<td>$row->id</td>";
    echo    "<td>$row->name</td>";
    echo    "<td>$row->guid</td>";
    if ($row->is_whitelisted === "1")
        {echo "<td>".$lang_admin_table_yes."</td>";}
    else
        {echo "<td>".$lang_admin_table_no."</td>";}
    if ($row->permission === "2")
        {echo "<td>".$lang_admin_table_admin."</td>";}
    else{
        if ($row->permission === "1")
            {echo "<td>".$lang_admin_table_user."</td>";}
        else
            {echo "<td>".$lang_admin_table_error."</td>";}
    }
    echo    "<td><a href='login.php?action=1&nr=".$row->id."'><img src='./b_edit.png' title='".$lang_admin_table_edit."'></a> <a href='login.php?action=2&nr=".$row->id."'><img src='./b_drop.png' title='".$lang_admin_table_delete."'></a></td>";
    echo "</tr>";
    }
    echo "</table><br>";
				

closeHtml();
}
}
else
{echo "Error 500";}
?>