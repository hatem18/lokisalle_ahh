<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init
if(!empty($_POST['reponse_mot'])){
	$requete = trim(strip_tags($_POST['reponse_mot']));

	$affichage = $lokisalle ->prepare("SELECT salle.photo, produit.id_salle, produit.prix, produit.date_depart, produit.date_arrivee, salle.ville, salle.capacite
FROM produit
INNER JOIN salle ON salle.id_salle = produit.id_salle 
WHERE salle.ville LIKE :mot_cle 
|| salle.titre LIKE :mot_cle 
|| salle.adresse LIKE :mot_cle 
|| salle.pays LIKE :mot_cle 
|| salle.description LIKE :mot_cle 
|| salle.photo LIKE :mot_cle 
|| salle.categorie LIKE :mot_cle  ORDER BY id_salle DESC");
	$affichage->bindValue(':mot_cle', '%' . $requete . '%', PDO::PARAM_STR);
	$affichage->execute();
	$infos_affichage = $affichage->fetchAll(PDO::FETCH_ASSOC);
	
}
include_once 'inc/header.inc.php'; // com
?>
    <h1>Recherche d'une location de salle pour réservation</h1>
    <div id="bando_recherche">
            <form action="" method="post">
            	<div id="rech_date">
                    <label> <span class="texte_orange"></span> A la date de :</label>
                    <select id ="mois" name="mois">
						<?php 
					$mois=['Janvier', 'Fevrier','Mars', 'Avril','Mai', 'Juin','Juillet', 'Aout','Septembre', 'Octobre','Novembre', 'Décembre',];
				foreach($mois as $key => $value)
				   { 
                 		echo '<option value="'.$value.'">'.$value.'</option>';
						  }							
				?>	
					</select>
                    <select id ="annee" name="annee">
						<?php 
							for($annee=date('Y'); $annee>=2012; $annee--){
						?>
						<option value='<?php echo $annee;?>'><?php echo $annee?></option>
						<?php 
							} 
						?>
					</select>                
                   
        		</div>
                <div id="rech_mots">
                    <label for="reponse_mot"> <span class="texte_orange"> > </span> Par Mots-clés :</label> <input type="text" id="reponse_mot" name="reponse_mot" value="" /><span id="ville"> (Ex : Ville, Nom, adresse)</span>
                </div>
        		<div id="bouton">
                	<input type="submit" id="bt_rechercher" name="bt_rechercher" value="Rechercher" />
                </div>   
                </form>
	</div>
	<h2>Resultat de votre recherche</h2>
	<?php if(!empty($_POST['bt_rechercher'])) : ?>
	<p>Nombre de resultat: <?php echo count($infos_affichage)?></p>
	<?php endif ?>
	<article>
		<h2>Nos offres de locations</h2>
		<?php if(!empty($_POST['bt_rechercher'])) : ?>
				<?php for($i=0;$i<count($infos_affichage);$i++) : ?>
		<div id="div">
			
					<img src="<?= URL ?>/assets/images/<?= $infos_affichage[$i]['photo'] ?>">
					<p>Du <?= $infos_affichage[$i]['date_arrivee'] ?> au <?= $infos_affichage[$i]['date_depart'] ?> ‐ <?= $infos_affichage[$i]['ville'] ?> 
					<?= $infos_affichage[$i]['prix'] ?> euros * pour <?= $infos_affichage[$i]['capacite'] ?> personnes </p> 
					<a href="#"> Voir la fiche détaillée</a>
						<?php if(userConnected()) : ?>   
						<a href="#"> Connectez vous pour l'ajouter au panier</a>
						<?php endif ?>
				 
		</div>	
		<?php endfor ?>
				<?php endif ?> 	
	</article>

	<?php
include_once 'inc/footer.inc.php';