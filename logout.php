<?php
include ("db.php");
include ("config.php");
// define relative dir to wbb installation
if (!defined('RELATIVE_WBB_DIR')) define('RELATIVE_WBB_DIR', $config_forum_path);

// wbb imports
require_once(RELATIVE_WBB_DIR.'global.php');

class Logout {
	/**
	 * Neue Instanz der Klasse, die den Ablauf steuert.
	 */
	public function __construct() {
		// Wir prüfen, ob der Benutzer überhaupt angemeldet ist -> Wenn nicht, geben wir eine meldung aus und stoppen den Ablauf hier
		if (WCF::getUser()->userID == 0) {
                    header('Location: login.php');
			exit;
		}
		
		// Benutzer abmelden
		$this->doLogout();
	}
	
	/**
	 * Hier findet der eigentliche Logout statt. Nachdem der Benutzer abgemeledet wurde, wird er an die "index.php" weitergeleitet.
	 */
	public function doLogout() {
		// Wir löschen die aktuelle Sitzung des Benutzers
		WCF::getSession()->delete();
		
		// Wir löschen die gesetzten Cookies
		if (isset($_COOKIE[COOKIE_PREFIX.'userID'])) HeaderUtil::setCookie('userID', 0);
		if (isset($_COOKIE[COOKIE_PREFIX.'password'])) HeaderUtil::setCookie('password', '');
		
		// Benutzer weiterleiten
		HeaderUtil::redirect('login.php');
		exit;
	}
}

// Wir "starten" unsere Klasse, die dann automatisch die weiteren Schritte abarbeitet
new Logout;
?>