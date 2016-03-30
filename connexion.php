<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init


if(!empty($_GET['action']) && $_GET['action'] == 'deconnexion') {
    unset($_SESSION['utilisateur']); // si j'ai un get deconnexion avec la valeur "ok" alors je supprimme la session utilisateur
}
// si je suis déja connecté, je n'ai rien à faire ici, je go vers la page profil
if(!empty($_SESSION['utilisateur'])) {
    header('location:profil.php');
    exit();
}

//-------- traitement ------------- //
if(isset($_POST['connexion'])) {
    $pseudo = (!empty($_POST['pseudo'])) ? $_POST['pseudo'] : '';
    $mdp = (!empty($_POST['mdp'])) ? $_POST['mdp'] : '';
    // Je rappatrie le mot de passe qui correspond à l'email donné
    $recup_mdp = $lokisalle->prepare('SELECT id_membre, mdp, prenom, nom, pseudo, adresse, ville, cp, sexe, statut FROM membre WHERE pseudo = :pseudo');
    $recup_mdp->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $recup_mdp->execute();
    if($recup_mdp->rowCount() == 1) { // si je trouve quelqu'un
    $membre = $recup_mdp->fetchAll(PDO::FETCH_ASSOC);
 // debug($membre);
    // je verifie si le mot de passe rappatrié, correspond au mot de passe donné dans le $_POST['mdp']
        if(password_verify($mdp, $membre[0]['mdp'])) {
            $msg = '<div class="good">C gagné !</div>';
            $_SESSION['utilisateur']['id_membre'] = $membre[0]['id_membre'];
            $_SESSION['utilisateur']['prenom'] = $membre[0]['prenom'];
            $_SESSION['utilisateur']['nom'] = $membre[0]['nom'];
            $_SESSION['utilisateur']['pseudo'] = $membre[0]['pseudo'];
            $_SESSION['utilisateur']['adresse'] = $membre[0]['adresse'];
            $_SESSION['utilisateur']['ville'] = $membre[0]['ville'];
            $_SESSION['utilisateur']['cp'] = $membre[0]['cp'];
            $_SESSION['utilisateur']['sexe'] = $membre[0]['sexe'];
            $_SESSION['utilisateur']['statut'] = $membre[0]['statut'];
         var_dump($_SESSION['utilisateur']);
             // debug($membre);
            // version dynamique foreach
            /* foreach($membre[0] as $key => $value) {
                if($key !== 'mot_de_passe')
                    $_SESSION['utilisateur'][$key] = $value;
            } */
            // si la connexion est OK, je redirige vers la page de profil
            header('location:profil.php');
            die(); // j'arrete le script exit() & die() font la même chose

        } else {
            $msg = '<div class="erreur">C perdu ! C\'est pas les bons identifiants !</div>';
        }
    } else {
        $msg = '<div class="erreur">C perdu ! C\'est pas les bons identifiants !</div>';
    }
}



//------- affichage ----------- //
include_once 'inc/header.inc.php';
?>
<h1>Connexion</h1>
<div class="reaction">
    <p class="etiquette">Connexion</p>
        <p style="text-decoration: underline;">Deja membre ?</p>
    <form method="post">
        <div class="saisie">

            <div class="user clearfix">

                <div class="prenom">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" value="" name="pseudo" >
                </div>
                <div class="prenom">
                    <label for="mdp">Mot de passe</label>
                    <input type="text" value="" name="mdp" >
                </div>
            </div>
        </div>
        <p class="etiquette">
            <button type="submit" name="connexion">CONNEXION</button>
        </p>
        <div class="saisie">
         <p style="text-decoration: underline;">Pas encore membre ?</p>
            <div class="user clearfix">
                <br>
                <br>
                <a href="inscription.php">Inscrivez vous ici</a>
            </div>
        </div>
    </form>
</div>
<?php
include_once 'inc/footer.inc.php';