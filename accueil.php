<?php
// inclure les fichiers de configuration
require_once 'inc/init.inc.php';

// $recup_categories = $lokisalle->query("SELECT DISTINCT categorie FROM salle");
// // je transforme mon resultat SQL en tableau PHP
// $categories = $recup_categories->fetchAll(PDO::FETCH_ASSOC);
// // je check mon tableau PHP
// /*debug($categories);
// echo '<hr>';*/
// // echo $categories[0]['categorie'] . '<br>'; // t shirt
// // echo $categories[1]['categorie'] . '<br>'; // t shirt

// $nbre_categories = count($categories);
// // /*
// SELECT p.date_arrivee, p.date_depart, s.photo, p.prix, s.ville FROM produit p INNER JOIN salle s ON p.id_salle = s.id_salle

// SELECT p.date_arrivee, p.date_depart, s.photo, p.prix, s.ville FROM produit p, salle s WHERE p.id_salle = s.id_salle


$recup_produits = $lokisalle->query("SELECT p.id_produit, p.date_arrivee, p.date_depart, s.photo, p.prix, s.ville, s.capacite FROM produit p INNER JOIN salle s ON p.id_salle = s.id_salle");
// $nom_categorie = (!empty($_GET['categorie'])) ? trim(strip_tags($_GET['categorie'])) : '';



// 4. je recupere les résultats grace à fetchAll
$produits = $recup_produits->fetchAll(PDO::FETCH_ASSOC);
// debug($produits);
// debug($produits);
// 5. je dispatch les "titres", "description", "prix" etc... dans la div
$nbre_produits = count($produits);
// debug($nbre_produits);

// $recup_produits2 = $lokisalle->prepare("SELECT * FROM produit");

// $id_produit = (!empty($_GET['id_article'])) ? trim(strip_tags($_GET['id_article'])) : '';

// $recup_produits2->bindValue(':id_produit',$id_produit, PDO::PARAM_STR);

// // 3. j'éxécute la requete
// $recup_produits2->execute();


// // 4. je recupere les résultats grace à fetchAll
// $produits2 = $recup_produits2->fetchAll(PDO::FETCH_ASSOC);
// debug($produits2);
// $nbre_produits2 = count($produits2);
?>

<?php
include_once 'inc/header.inc.php';
?>
	
	
<div class="content container">
		<h1>Bienvenue sur lokisalle site de location de salles</h1>
		<h2 style="text-align: center;">Nos 3 dernieres offres</h2>
		<article id="presentation">
			<p>Créé en 2012, LokiSalle vous propose un large choix de salles de uniondeifférentesensionspouvantlirde 10 à 100 personnes sur Paris, Bordeaux, Marseille et Lyon.Nous disponsons de petites salles pourravailler avec vos collaborateurs et vos fournisseurs ou pour recevoir vos clients, mais aussi de très grandes salle pour les grandes occasions.Toutes les salles proposées disposent de toutes les commodités pour la réussite de vos meetings.Que ce soit pour une réunion d'une heure comme pour un séminaire d'une journée voire plus, les salles de réunion LokiSalle, vous propose gratuitement la présence d'une hôtesse qui accueillera tous les participants pour les aiguiller vers la salle que vous avez réservé. Elle sera à votre service pour préparer des petits déjeuners, sandwichs ou plateaux repas, ou encore réserver un restaurant ou un taxi.LokiSalle mets tout en œuvre pour vous simplifier la vie et concourir à la réussite de vos réunions.</p>
		</article>
	<div class="row">
	<?php for($i=0;$i<3;$i++) : ?>

		<div class="col-xs-2">
			<h3 class="text-center"></h3>
			<div class="text-center">
				<a href="reservation_details.php?id_produit=<?= $produits[$i]['id_produit'] ?>"><img src="<?= URL ?>/assets/images/<?= $produits[$i]['photo'] ?>"></a>
				<p class="lead text-center">Du <?= $produits[$i]['date_arrivee'] ?> au <?= $produits[$i]['date_depart'] ?> ‐ <?= $produits[$i]['ville'] ?> 
			<?= $produits[$i]['prix'] ?> euros * pour <?= $produits[$i]['capacite'] ?> personnes </p>
			<a href="reservation_details.php?id_produit=<?= $produits[$i]['id_produit'] ?>"> Voir la fiche détaillée</a><br>
			<?php if(!(userConnected())) : ?>   
			<a href="#"> Connectez vous pour l'ajouter au panier</a>
		<?php endif ?> 
			</div>
		</div>
	
	<?php endfor; ?>	
</div>


	<?php
include_once 'inc/footer.inc.php';


	


