<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init

// if(!empty($_SESSION['utilisateur'])) {
   


$id_produit = (!empty($_GET['id_produit']) && is_numeric($_GET['id_produit'])) ? trim(strip_tags($_GET['id_produit'])) : '';
$prenom = (!empty($_POST['prenom'])) ? $_POST['prenom'] : '';
$commentaire = (!empty($_POST['commentaire'])) ? $_POST['commentaire'] : '';
$note = (!empty($_POST['note'])) ? $_POST['note']: '';

if(isset($_POST['commenter'])) : 
// SELECT id_salle FROM PRODUIT WHERE id_produit = :id_produit 
// recuperer l'id_salle et le mettre dans le bindValue pour insertion 
 	$recup_id_salle = $lokisalle->prepare('SELECT id_salle FROM produit WHERE id_produit = :id_produit');
 	$recup_id_salle->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
 	$recup_id_salle->execute();

 	$id_salle = $recup_id_salle->fetchAll(PDO::FETCH_ASSOC); 

 	//debug($id_salle);
 	$insertion_avis = $lokisalle->prepare('INSERT INTO  avis(id_membre, id_salle, date, commentaire, note) VALUES(:id_membre, :id_salle, NOW(), :commentaire, :note)');
 		
	$insertion_avis->bindValue(':id_membre', $_SESSION['utilisateur']['id_membre'], PDO::PARAM_STR);
	$insertion_avis->bindValue(':id_salle', $id_salle[0]['id_salle'], PDO::PARAM_INT);
	$insertion_avis->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
	$insertion_avis->bindValue(':note', $note, PDO::PARAM_INT);
	$insertion_avis->execute();
endif; 



$comment=$lokisalle->prepare("SELECT m.prenom,  DATE_FORMAT(a.date, '%d/%m/%Y à %h:%i:%s') AS date_fr, a.commentaire, a.note 
FROM membre m 
	INNER JOIN avis a ON a.id_membre = m.id_membre 
WHERE id_salle = (SELECT id_salle FROM PRODUIT WHERE id_produit = :id_produit)
ORDER BY date DESC 
LIMIT 0,3");
$comment->bindValue(':id_produit',$id_produit, PDO::PARAM_INT);
$comment->execute();

$avis = $comment->fetchAll(PDO::FETCH_ASSOC);
$nbre_commentaires=count($avis); 

 //var_dump($avis);


// affichage du produit
$infoProduit = $lokisalle->prepare("SELECT * FROM produit p INNER JOIN salle s ON p.id_salle = s.id_salle WHERE id_produit = :id_produit");
$infoProduit->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
$infoProduit->execute();
$resultat = $infoProduit->fetchAll(PDO::FETCH_ASSOC);
$nbre_resultat=count($resultat);


// $id_produit = !empty($_GET['id_produit']) && is_numeric($_GET['id_produit']) ?  trim(strip_tags($_GET['id_produit'])) : ''; // je recupere l'id qui se trouve dans l'url dans ?id_article=
// $article = recupInfoProduit($id_produit);
// if(!$article) { // si je ne trouve pas de resultat alors je redirige vers la boutique
// 	header('location:reservation.php');
// 	exit;
// }
// debug($article);


// if(!$produits) { // si je ne trouve pas de resultat alors je redirige vers la boutique
// 	header('location:reservation.php');
// 	exit;
// }
include_once 'inc/header.inc.php';
?>
<h1>Reservations en details</h1>
<aside>
	
	
 
	<h2><?= $resultat[0]['titre']?> (7/10) sur 2 avis</h2>
	<img src="<?= URL ?>/assets/images/<?= $resultat[0]['photo']?>">
	<p>Description: <?= $resultat[0]['description']?></p>
	<p>Capacite: <?= $resultat[0]['capacite']?></p>
	<p>Categorie:<?= $resultat[0]['categorie']?></p>

	<h2>Informations complementaires</h2>
	<ul>
		<li>Pays :<?= $resultat[0]['pays']?></li>
		<li>Ville :<?= $resultat[0]['ville']?></li>
		<li>Adresse :<?= $resultat[0]['adresse']?></li>
		<li>Cp :<?= $resultat[0]['cp']?></li>
		<li>Date d'arrivee :<?= $resultat[0]['date_arrivee']?></li>
		<li>Date de depart :<?= $resultat[0]['date_depart']?></li>
		<li>Prix HT :<?= $resultat[0]['prix']?></li>
		<li>Acces :<br>
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2623.738076389784!2d2.701960315154115!3d48.88226950697988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e61b0c422151f1%3A0x7cfaa9ba550911df!2sLagny+-+Thorigny!5e0!3m2!1sfr!2sfr!4v1457034234332" width="400" height="400" frameborder="1" style="border:1" allowfullscreen></iframe>
		</li>
	</ul>
	
	
</aside>
<aside>
	<h2>Avis</h2>

<?php
	for($i=0; $i<$nbre_commentaires; $i++) : ?>
	<div>	
        <h3><?php echo $avis[$i]['prenom'];?>
           <?php echo 'Publié le ' . $avis[$i]['date_fr'];?></h3>
        <p><?php echo $avis[$i]['commentaire']; ?></p><br>
        <p><?php echo $avis[$i]['note']; ?></p>

    </div>
 
  <?php  endfor;

?>
	<div>
	<?php if(userConnected()) : ?>

		<form method="POST" action="">
			<label for="commentaire">Ajouter un commentaire</label>
			<textarea id="commentaire" name="commentaire" width="100" height="200"></textarea>
			<br>
			<label>Note</label>
			<select name="note">
			<?php for($i=0;$i<=10;$i++) : ?>
				<option value="<?= $i ?>"><?= $i ?>/10</option>
				<?php endfor; ?>
			</select>
			<input type="hidden" name="id_produit" value="<?php echo $id_produit ?>">
			<br>
			<br>
			<input type="submit" name="commenter">
		</form>
	<?php endif; ?>
	</div>
</aside>

<form method="POST" action="panier.php">
<?php if(userConnected() AND !userConnected()) : ?>
<input type="text" name="id_produit" value="<?= $_GET['id_produit'] ?>">
<?php endif; ?>
<button type="submit" name="ajout_panier">Ajouter au panier</button>
</form>




<!-- } -->

<?php



include_once 'inc/footer.inc.php';