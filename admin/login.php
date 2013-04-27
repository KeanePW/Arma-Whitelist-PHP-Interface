

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include ("../db.php");
include ("../functions.php");

// define relative dir to wbb installation
if (!defined('RELATIVE_WBB_DIR')) define('RELATIVE_WBB_DIR', '../../../');

// wbb imports
require_once(RELATIVE_WBB_DIR.'global.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/UserSession.class.php');
require_once(WCF_DIR.'lib/system/auth/UserAuth.class.php');

class Login {
  // Hier definieren wir Variablen mit Standard-Inhalten
  // user object
  public $user = null;
  
  // given username
  public $username = '';
  
  // given password
  public $password = '';
  
  // error field
  public $errorField = '';
  
  // error text
  public $errorText = '';
  
	/**
	 * Neue Instanz der Klasse, die den Ablauf steuert.
	 */
	public function __construct() {
    // Benutzer ist bereits angemeldet, "userID" also ungleich "0" -> Wir geben den Benutzernamen aus und stoppen den Ablauf hier
    if (WCF::getUser()->userID != 0) {
    //if ($admincheck == WCF::getUser()->username)
	  include ('admin.php');
		
	  
      exit;
    }
    
    // Benutzer ist noch nicht angemeldet, "userID" also gleich "0" -> Wir prüfen, ob Daten übergeben wurden und handeln entsprechend
    // Keine Daten übergeben -> Wir geben unser Loginformular aus
    if (!count($_POST)) {
      $this->showForm();
    }
    // Daten übergeben -> Wir lesen diese mit readParameters() ein
    else {
      $this->readParameters();
    }
	}
  
	/**
	 * Lesen der eingegebenen Daten.
	 */
	public function readParameters() {
    // Wir lesen den Benutzernamen aus den übergebenen Daten aus und entfernen unnötige Leerzeichen
		if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']);
		
    // Wir lesen das Kennwort aus, welches der Benutzer eingegeben hat
		if (isset($_POST['password'])) $this->password = $_POST['password'];
		
		// Nun prüfen wir die Daten, geben einen Fehler aus oder melden den Benutzer an
		$this->checkLoginData();
	}
  
	/**
	 * Daten des Benutzers prüfen.
	 */
	public function checkLoginData() {
    // Wir prüfen die Daten in einem try/catch-Block, um den Ablauf durch Exceptions unterbrechen zu können
    try {
      // Prüfen, ob kein Benutzername eingegeben wurde
		  if (empty($this->username)) {
        throw new UserInputException('username');
      }
      
      // Prüfen, ob kein Kennwort eingegeben wurde
      if (empty($this->password)) {
        throw new UserInputException('password');
      }
      
      // Prüfen des Kennwortes und ggf. Rückgabe eines neuen Objektes
      $this->user = UserAuth::getInstance()->loginManually($this->username, $this->password);
      
      // Es ist kein Fehler aufgetreten; Wir melden den Benutzer "richtig" an und leiten ihn weiter
      $this->doLogin();
    }
    catch (UserInputException $e) {
      // Setze das betroffene Eingabefeld, welches den Fehler verursacht hat
      $this->errorField = $e->getField();
      
      // Setze einen Fehlertext (alternativ könnte man noch abfragen, welcher Fehler aufgetreten ist und den Text entsprechend anpassen)
      $this->errorText = 'Es ist ein Fehler aufgetreten. Bitte &uuml;berpr&uuml;fe das markierte Eingabefeld.';
      
      // Abschließend geben wir das Formular erneut aus
      $this->showForm();
    }
	}
  
	/**
	 * Den Benutzer "richtig" anmelden und zur Loginseite weiterleiten.
	 */
	public function doLogin() {
    // Setze Daten des Benutzern
    UserAuth::getInstance()->storeAccessData($this->user, $this->username, $this->password);
    
    // Session ändern
    WCF::getSession()->changeUser($this->user);
    
    // Benutzer weiterleiten
    HeaderUtil::redirect('admin.php');
    exit;
	}
  
	/**
	 * Gibt ein einfaches Formular aus, mit dem sich ein Benutzer anmelden kann.
	 */
	public function showForm() {
    // Wir prüfen zunächst, ob ein Fehler bekannt ist und geben den Fehlertext hier aus
    if (!empty($this->errorText)) {
      echo '<p style="color:red;font-weight:bold">' . $this->errorText . '</p>';
    }
    
    // Nun geben wir das eigentliche Formular aus
    // Wir senden die Daten an die Datei "login.php" mit der Methode "post"
    // Die Felder werden befüllt, sobald man Daten eingegeben hat, diese aber nicht anerkannt wurden
    // Mit einer Abfrage markieren wir das Eingabefeld, welches den Fehler verursacht hat
initHTML();
initMenu();
	?>

<p>Logge dich mit deinen Foren Login Daten ein</p>
<form action="login.php" method="post">
  <p>Benutzername:<br /><input name="username" type="text" value="<?php echo $this->username ?>" size="30"<?php if ($this->errorField == 'username') {echo ' style="border:2px solid red"'; } ?> /></p>
  <p>Kennwort:<br /><input name="password" type="password" value="<?php echo $this->password ?>" size="30"<?php if ($this->errorField == 'password') {echo ' style="border:2px solid red"'; } ?> /></p>
  <p><input type="submit" value="Absenden"> <input type="reset" value="Abbrechen"></p>
</form>

<?php
closeHTML();
	}
}

// Wir "starten" unsere Klasse, die dann automatisch die weiteren Schritte abarbeitet
new Login;
?>