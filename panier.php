<?php
// inclure les fichiers de configuration
require_once 'inc/init.inc.php';
creationPanier(); // je créé un panier
// si je clic sur le bouton vider le panier, je le vide...
if(!empty($_GET['action']) && $_GET['action'] == 'vider_panier') {
  unset($_SESSION['panier']);
}

// debug($_POST);

$recup_id = (!empty($_POST['id_produit'])) ? trim(strip_tags($_POST['id_produit'])) : '';
$infoProduit = $lokisalle->prepare("SELECT id_produit, capacite, prix, titre, DATE_FORMAT(date_depart, '%d/%m/%y %H:%i'), DATE_FORMAT(date_arrivee, '%d/%m/%y %H:%i'), ville, photo FROM produit p INNER JOIN salle s ON p.id_salle = s.id_salle WHERE id_produit = :id_produit");
  $infoProduit->bindValue(':id_produit', $recup_id, PDO::PARAM_INT);
  $infoProduit->execute();
  if($infoProduit->rowCount() == 1) { // si je trouve un produit je le return
    $resultat = $infoProduit->fetchAll(PDO::FETCH_ASSOC);
    $produit = $resultat[0]; 
   
  } else { // sinon, j'envoi false
    $produit = false;
  }
  

// si je desire supprimer un article du panier
if(!empty($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_article_panier']) && is_numeric($_GET['id_article_panier'])) {
  retirerArticleDuPanier($_GET['id_article_panier']);
}

 
  if(isset($_POST['ajout_panier'])) {
  $produitAjoute = recupInfoProduit($_POST['id_produit']);

  if(!$produitAjoute) { // si le produit n'existe pas c'est qu'il y a eu triche
    header('location:reservation.php');
    exit();
  } else {
    ajouterArticleDansPanier($produitAjoute['titre'], $produitAjoute['id_produit'], $produitAjoute['capacite'], $produitAjoute['prix'], $produitAjoute['photo'], $produitAjoute['date_arrivee'], $produitAjoute['date_depart'], $produitAjoute['ville']); // je rafraichi la page pour supprimer le renvoi des posts, dans le cas ou l'internaute appuie sur F5 (actualisation de page)
  }
}

  // debug($insert_detail_commande);
  // message de confirmation avec suppression du bouton payer et vider le contenu du panier
  // unset($_SESSION['panier']);
  // $msg = '<p class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Votre commande a bien été prise en compte, elle sera traitée sous peu</p>';


//     ajouterArticleDansPanier($produitAjoute['id_produit'],$produitAjoute['capacite'],$_POST['prix'],$produitAjoute['titre'], $produitAjoute['date_arrivee'], $produitAjoute['date_depart'], $produitAjoute['ville'], $produitAjoute['photo']);
//     header('location:panier.php'); // je rafraichi la page pour supprimer le renvoi des posts, dans le cas ou l'internaute appuie sur F5 (actualisation de page)
//   }
// }
// inclure les fichiers d'affichage
include_once 'inc/header.inc.php';
?>
<h1>Panier</h1>
<table class="table table-hover">
    <thead>
      <tr>
        <th>capacite</th>
        <th>Produit</th>
        <th>Salle</th>
        <th>photo</th>
        <th>ville</th>
        <th>Date Arrivée</th>
        <th>Date Depart</th>
        <th>supprimer</th>
        <th>Prix HT</th>
        <th>TVA</th>
        <th>Prix TTC</th>
      </tr>
    </thead>
    <tbody>
    
    <?php if(!empty($_SESSION['panier']['id_produit'])) : ?>
    <?php $nbre_produits = count($_SESSION['panier']['id_produit']); ?>
      <?php for($i=0;$i<$nbre_produits;$i++) : ?>
      <tr>
      	<td><?= $_SESSION['panier']['capacite'][$i] ?></td>
        <td><?= $_SESSION['panier']['id_produit'][$i] ?></td>
        <td><?= $_SESSION['panier']['titre'][$i] ?></td>
        <td><a href="fiche_article.php?id_article=<?= $_SESSION['panier']['id_produit'][$i] ?>"><img src="<?= URL ?>/assets/images/<?= $_SESSION['panier']['photo'][$i] ?>"></a></td>
        <td><?= $_SESSION['panier']['ville'][$i] ?></td>
      	<td><?= $_SESSION['panier']['date_arrivee'][$i] ?></td>
      	<td><?= $_SESSION['panier']['date_depart'][$i] ?></td>
        <td><a href="?action=suppression&id_article_panier=<?= $_SESSION['panier']['id_produit'][$i] ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
        <td><?= $_SESSION['panier']['prix'][$i] ?>€</td>
        <td><?= '20%' ?></td>
        <td><?= $_SESSION['panier']['prix'][$i]*1.2 ?>€</td>
      </tr>
      <?php endfor; ?>

      <tr colspan="4">
      	<td>Total HT: <?= calculMontantTotal() ?>€</td>
      </tr><tr colspan="4">
      	<td>Total TTC : <?= (calculMontantTotal() * 1.2) ?>€</td>
      </tr>
  <?php else : ?>
  	<tr col="4">
  		<td>Votre panier est vide</td>
  	</tr>
  <?php endif; ?>
    </tbody>
  </table>
  <form>
  <?php if(isset($_SESSION['panier']['id_produit']))  : ?>
  <button name="action" value="vider_panier">Vider le panier</button>
  <button name="action" value="payer">Payer</button>
  <?php endif; ?>
  </form>
  <p>Tous nos articles sont calculés avec le taux de TVA à 19,6%
Règlement: Par Chèque uniquement
Nous attendons votre règlement par chèque à l'adresse suivante:
Ma boutique ‐ 1 Rue Boswellia, 75000 Paris, France</p>

<?php
include_once 'inc/footer.inc.php';


/* SELECT c.id_commande, c.date, m.prenom, m.nom, p.titre, p.categorie, p.photo, dc.quantite, dc.prix
FROM membre AS m
		INNER JOIN commande AS c
			ON m.id_membre = c.id_membre
		INNER JOIN detail_commande AS dc
			ON c.id_commande = dc.id_commande
		INNER JOIN produit AS p
			ON p.id_produit = dc.id_produit;

SELECT c.id_commande, c.date, m.prenom, m.nom, p.titre, p.categorie, p.photo, dc.quantite, dc.prix
FROM membre m, commande c, detail_commande dc, produit p
WHERE m.id_membre = c.id_membre
AND c.id_commande = dc.id_commande
AND p.id_produit = dc.id_produit */
