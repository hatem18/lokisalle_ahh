<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init

$DSN = 'mysql:host=localhost;dbname=lokisalle';
$user = 'root';
$mdp = '';
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
];
$lokisalle = new PDO($DSN,$user,$mdp,$options);

$pseudo = (!empty($_POST['pseudo'])) ? trim(strip_tags($_POST['pseudo'])) : '';
$mot_de_passe = (!empty($_POST['mdp'])) ? $_POST['mdp'] : '';
$nom = (!empty($_POST['nom'])) ? trim(strip_tags($_POST['nom'])) : '';
$prenom = (!empty($_POST['prenom'])) ? trim(strip_tags($_POST['prenom'])) : '';
$email = (!empty($_POST['email'])) ? strip_tags($_POST['email']) : '';
$sexe = (!empty($_POST['sexe'])) ? strip_tags($_POST['sexe']) : '';
$ville = (!empty($_POST['ville'])) ? strip_tags($_POST['ville']) : '';
$code_postal = (!empty($_POST['code_postal'])) ? strip_tags($_POST['code_postal']) : '';
$adresse = (!empty($_POST['adresse'])) ? strip_tags($_POST['adresse']) : '';

// 4 je procède à l'insertion au moment où je clic sur le bouton d'envoi
if(isset($_POST['envoi'])) {
	// je vérifie si mes variables ne sont pas vides
	if(!empty($pseudo) && !empty($prenom) && !empty($nom) && !empty($email) && !empty($mot_de_passe) && !empty($sexe)&& !empty($ville) && !empty($code_postal) && !empty($adresse) ) {

		if( preg_match('/@/', $email) &&
            ( preg_match('/[A-Z]/', $mot_de_passe) && preg_match('/[0-9]/', $mot_de_passe)) ) {
			// je verifie la presence de l'email en BDD
			$check_membre = $lokisalle->prepare('SELECT email FROM membre WHERE email = :email');
			$check_membre->bindValue(':email', $email, PDO::PARAM_STR);
			$check_membre->execute();
			if($check_membre->rowCount() > 0) { // si je trouve au moins 1 personne dans la BDD avec l'email saisi, alors je ne l'inscris pas
				$msg = '<div class="erreur">Cet email existe deja</div>';
			} else { // pas d'email dans la BDD, donc on enregistre
				$insertion_membre = $lokisalle->prepare('INSERT INTO membre(pseudo,prenom, nom, email, mdp, sexe,ville, cp, adresse) VALUES(:pseudo, :prenom, :nom, :email, :mdp, :sexe,:ville, :cp, :adresse)');
			// debug($insertion_membre); // je verifie si je recupère bien l'objet PDOstatement
			// je joins les paramètres de prepare aux name ($_POST) du formulaire tout en m'assurant que ceux-ci sont bien pleins
				// on hash le mot de passe avant de l'enregistrer en BDD
				$mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

				$insertion_membre->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
				$insertion_membre->bindValue(':prenom', $prenom, PDO::PARAM_STR);
				$insertion_membre->bindValue(':nom', $nom, PDO::PARAM_STR);
				$insertion_membre->bindValue(':email', $email, PDO::PARAM_STR);
				$insertion_membre->bindValue(':mdp', $mot_de_passe, PDO::PARAM_STR);
				$insertion_membre->bindValue(':sexe', $sexe, PDO::PARAM_STR);
				$insertion_membre->bindValue(':ville', $ville, PDO::PARAM_STR);
				$insertion_membre->bindValue(':cp', $code_postal, PDO::PARAM_STR);
				$insertion_membre->bindValue(':adresse', $adresse, PDO::PARAM_STR);

				$insertion_membre->execute();
			}
		} else {
			$msg = '<div class="erreur">Votre email n\'est pas bon et / ou votre mdp doit posseder au moins 1 chiffre avec une lettre majuscule</div>';
		}
	} else {
		$msg = '<div class="erreur">Au moins 1 champ est vide !</div>';
	}
}

include_once 'inc/header.inc.php';
?>
<h1>Inscription</h1>
<div class="reaction">
    <p class="etiquette">Inscription</p>
    <form method="post">
        <div class="saisie">
            <div class="user clearfix">
            	<div class="prenom">
                    <label for="prenom">Pseudo</label>
                    <input id="pseudo" value="<?= $pseudo ?>" name="pseudo" type="text" />
                </div>
                <div class="prenom">
                    <label for="prenom">Prénom</label>
                    <input id="prenom" value="<?= $prenom ?>" name="prenom" type="text" />
                </div>
                <div class="nom">
                    <label for="nom">Nom</label>
                    <input id="nom" value="<?= $nom ?>" name="nom" type="text" />
                </div>
            </div>
            <div class="user clearfix">
                <div class="prenom">
                    <label for="email">Email</label>
                    <input type="text" required value="<?= $email ?>" name="email" >
                </div>
                <div class="prenom">
                    <label for="mdp">Mot de passe</label>
                    <input type="text" value="" required name="mdp" >
                </div>
            </div>
            <div class="user clearfix">
            	<div class="prenom">
                <label for="sexe">sexe</label>
	                <div class="sexe">
                	<input type="radio" <?=($sexe == 'm') ? 'checked' : '' ?> value="m" name="sexe" >M
	                </div>
	                <div class="sexe">
	                <input type="radio" <?=($sexe == 'f') ? 'checked' : '' ?> value="f" name="sexe" >F
	                </div>
                </div>                
            </div>
            <div class="user clearfix">
            	<div class="prenom">
            	 	<label for="ville">Ville</label>
                    <input type="text" value="<?= $ville ?>" required name="ville" >
                    <label for="code_postal">Code postal</label>
                    <input type="text" value="<?= $code_postal ?>" required name="code_postal" >
                </div>
                <div class="prenom">
                    <label for="adresse">Adresse</label>
                    <textarea name="adresse"><?= $adresse ?></textarea>
                </div>
            </div>
        </div>
        <p class="etiquette">
            <button type="reset">EFFACER</button>
            <button type="submit" name="envoi">INSCRIPTION</button>
        </p>
    </form>
</div>

<?php
include_once 'inc/footer.inc.php';