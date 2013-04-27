<?php

//Header für jede Seite
function initHtml(){
    include ("config.php");
    echo "<html>\n";
    echo "  <head>\n";
    echo "  <title>$config_page_title</title>";
    echo "  <link rel='stylesheet' type='text/css' href='$config_whitelist_path/format.css'>\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "  <div class='all'>\n";
	echo "	<div align='center'><br><br>"; 
	echo " 	<a href='".$config_forum_url."' target='_blank'><img src='".$config_whitelist_path."/img/logo.png'></a><br>\n";
	};

//Bottom und close Tags für jede Seite
function closeHtml(){
    include ("config.php");
    echo "<div id='bottom'>\n";
	if ($config_construction == "1"){
        echo " <br><img src='".$config_whitelist_path."/img/page_constuction2.png'></img><br>";
        }
        echo " <a href='$config_impressum_url' target='_blank' alt='Impressum'>Impressum</a><br><br>";
        echo " <br> &copy; 2012 - ".date('Y')." Pictureclass - <a href='http://www.revoplay.de' target='_blank'>Revoplay.de</a><br> ";
        echo "    </div>\n";
	echo "    </div>\n";
	echo "  </body>\n";
    echo "</html>\n";
    };

//Menü    
function initMenu(){
	include ("config.php");
        include ("db.php");
	echo "<div id='cssmenu'>";
	echo " 	<ul> ";
	echo "		<li><a href='$config_menu_1_url' alt='$config_menu_1_titel'><span>$config_menu_1_titel</span></a></li>";
	echo "		<li><a href='$config_menu_2_url' alt='$config_menu_2_titel'><span>$config_menu_2_titel</span></a></li>";
	echo "		<li><a href='$config_menu_3_url' alt='$config_menu_3_titel'><span>$config_menu_3_titel</span></a></li>";
	echo "		<li><a href='".$config_whitelist_path."/login.php' alt='Whitelist Interface'><span>Whitelist</span></a></li>";
        echo "		<li><a href='".$config_whitelist_path."/logout.php' alt='Logout'><span>Logout</span></a></li>";
	if (isset ($_SESSION['user_ingame']))
	{
        $user_ingame = $_SESSION['user_ingame'];
		$permission_check_qry = mysql_query("SELECT permission FROM whitelist WHERE name = '".$user_ingame."'"); 
			if(mysql_numrows($permission_check_qry)) 
				{
				$permission_check_result = mysql_fetch_assoc($permission_check_qry);
				if ($permission_check_result['permission'] === "2")
					{ 
					echo "<li><a href='".$config_whitelist_path."/admin/login.php' alt='Admin Interface'><span>Admin Interface</span></a></li>";
					}
				}
	}			
	echo "	</ul>";
	echo "</div>";
	echo " <br>";
	};
	
	 
	
?>