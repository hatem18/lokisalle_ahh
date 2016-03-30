<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init
$id_produit = (!empty($_GET['id_produit']) && is_numeric($_GET['id_produit'])) ? trim(strip_tags($_GET['id_produit'])) : '';

$recup_produits = $lokisalle->query("SELECT p.id_produit, p.date_arrivee, p.date_depart, s.photo, p.prix, s.ville, s.capacite FROM produit p INNER JOIN salle s ON p.id_salle = s.id_salle");
$produits = $recup_produits->fetchAll(PDO::FETCH_ASSOC);
$nbre_produits = count($produits);



include_once 'inc/header.inc.php';

?>
		
		<div class="content container">
		<h1>Bienvenue sur lokisalle site de location de salles</h1>
		<h2 style="text-align: center; text-decoration:underline;">Nos offres de locations</h2>
	
	<div class="row">
	<?php for($i=0;$i<$nbre_produits;$i++) : ?>

		<div class="col-xs-2">
			<h3 class="text-center"></h3>
			<p class="text-center">
				<a href="reservation_details.php?id_produit=<?= $produits[$i]['id_produit'] ?>"><img src="<?= URL ?>/assets/images/<?= $produits[$i]['photo'] ?>"></a>
				<p class="lead text-center">Du <?= $produits[$i]['date_arrivee'] ?> au <?= $produits[$i]['date_depart'] ?> ‐ <?= $produits[$i]['ville'] ?> 
			<?= $produits[$i]['prix'] ?> euros * pour <?= $produits[$i]['capacite'] ?> personnes </p>
			<a href="reservation_details.php?id_produit=<?= $produits[$i]['id_produit'] ?>"> Voir la fiche détaillée</a>
			<?php if(!(userConnected())) : ?>   
			<a href="connexion.php"> Connectez vous pour l'ajouter au panier</a>
			<?php endif; ?>
			<?php if(userConnected()) : ?>   
			 <form method="POST" action="panier.php">
				<input type="hidden" name="id_produit" value="<?= $produits[$i]['id_produit'] ?>">
				<button type="submit" name="ajout_panier">Ajouter au panier</button>
			</form> 
			<?php endif; ?>  
			</p>
		</div>
	
	<?php endfor; ?>	
</div>
		
	<?php
include_once 'inc/footer.inc.php';