<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init

include_once 'inc/header.inc.php';
?>
<h1>Contacts</h1>
   <form>
	   	<p><label>Sujet :</label><input type="text" name="sujet"/></p>
		<p><label>Message :</label></p>
		<p><textarea name="message" cols="25" rows="3" width="200"></textarea></p>
		<p><input id="envoi" type="submit" name="envoi" value="Envoyer" /></p>
	</form>
<?php
include_once 'inc/footer.inc.php';