<?php
function debug($arg, $mode=1) {
	echo '<div style="display: inline-block; padding:10px; position: relative; z-index: 1000; background:#16a085">';
		echo '<pre>';
	if($mode==1) {
		print_r($arg);
	} else {
		var_dump($arg);
	}
		echo '</pre>';
	echo '</div>';
}

function userConnected() {
	if(!empty($_SESSION['utilisateur'])) {
		return true;
	} else {
		return false;
	}
}

function userAdmin() {
	if(userConnected() && (!empty($_SESSION['utilisateur']['statut']) && $_SESSION['utilisateur']['statut'] == 1)) {
		return true;
	} else {
		return false;
	}
}

function recupInfoProduit($id) {
	global $lokisalle; // pour recuperer la variable de l'espace global qui contient la connexion à la BDD
	$infoProduit = $lokisalle->prepare("SELECT id_produit, capacite, prix, titre, date_arrivee, date_depart, ville, photo FROM produit p LEFT JOIN salle s ON p.id_salle = s.id_salle WHERE id_produit = :id_produit");
	$infoProduit->bindValue(':id_produit', $id, PDO::PARAM_INT);
	$infoProduit->execute();
	if($infoProduit->rowCount() == 1) { // si je trouve un produit je le return
		$resultat = $infoProduit->fetchAll(PDO::FETCH_ASSOC);
		$produit = $resultat[0]; // je recupere le produit
	} else { // sinon, j'envoi false
		$produit = false;
	}
	return $produit;
}

function creationPanier() {
	if(!isset($_SESSION['panier'])) { // si le panier n'existe pas
		$_SESSION['panier'] = array(); // je cré le tableau panier
		$_SESSION['panier']['titre'] = array(); // je créé le tableau titre dans panier
		$_SESSION['panier']['id_produit'] = array();
		$_SESSION['panier']['capacite'] = array();
		$_SESSION['panier']['prix'] = array();
		$_SESSION['panier']['photo'] = array();

	}
}

function ajouterArticleDansPanier($titre, $id_produit, $capacite, $prix, $photo, $date_arrivee, $date_depart, $ville) {
	// $position_article = array_search($id_salle, $_SESSION['panier']['id_produit']); // array_search me renvoi la clé de la valeur que je recherche dans un tableau. ici je recherche la clé du $id_article dans le tableau $_SESSION['panier']['id_article']
	
		$_SESSION['panier']['titre'][] = $titre; // avec les crochets vides c'est comme si j'écrivais $_SESSION['panier']['titre'][0] = $titre, [1] = $titre etc.. Chaque produit qui va s'ajouter dans le Panier, aura automatiquement une clé numérique incrémentée
		$_SESSION['panier']['id_produit'][] = $id_produit;
		$_SESSION['panier']['capacite'][] = $capacite;
		$_SESSION['panier']['prix'][] = $prix;
		$_SESSION['panier']['titre'][] = $titre;
		$_SESSION['panier']['date_arrivee'][] = $date_arrivee;
		$_SESSION['panier']['date_depart'][] = $date_depart;
		$_SESSION['panier']['ville'][] = $ville;
		$_SESSION['panier']['photo'][] = $photo;


}


function calculMontantTotal() {
	$nbre_de_produits = count($_SESSION['panier']['id_produit']);
	$resultat = 0;
	for($i=0; $i<$nbre_de_produits; $i++) {
	$resultat += $_SESSION['panier']['prix'][$i];
	}
	return round($resultat,2);
}

function retirerArticleDuPanier($id_a_suppr) {
	$position_article = array_search($id_a_suppr, $_SESSION['panier']['id_produit']);
	if($position_article !== false) { // si array_search me renvoi un nombre, c'est qu'il a trouvé quelque chose
	array_splice($_SESSION['panier']['titre'], $position_article, 1); // arry_splice permet de supprimer un élément du tableau et de reorganiser le tableau en recommançant à partir de zéro
	array_splice($_SESSION['panier']['id_produit'], $position_article, 1);
	array_splice($_SESSION['panier']['capacite'], $position_article, 1);
	array_splice($_SESSION['panier']['prix'], $position_article, 1);
	array_splice($_SESSION['panier']['photo'], $position_article, 1);
	}
}