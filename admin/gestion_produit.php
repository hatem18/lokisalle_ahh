<?php
//-------- configuration ----------- //
require_once '../inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init
if(!userAdmin()) {
  header('location:../connexion.php');
  exit();
}

// initialisation des variables pour eviter les undefined

$id_salle=(!empty($_POST['id_salle'])) ? trim(strip_tags($_POST['id_salle'])) : '';
$prix=(!empty($_POST['prix'])) ? trim(strip_tags($_POST['prix'])) : '';
$date_arrivee=(!empty($_POST['date_arrivee'])) ? trim(strip_tags($_POST['date_arrivee'])) : '';
$date_depart=(!empty($_POST['date_depart'])) ? trim(strip_tags($_POST['date_depart'])) : '';
$etat=(!empty($_POST['etat'])) ? trim(strip_tags($_POST['etat'])) : '';


  
if(isset($_POST['envoi'])) {  
    
    $insert_produit = $lokisalle->prepare('INSERT INTO produit(id_salle,prix, date_arrivee, date_depart, etat) VALUES(:id_salle,:prix, :date_arrivee, :date_depart, :etat)');  
    $insert_produit->bindValue(':id_salle', $id_salle, PDO::PARAM_STR);
    $insert_produit->bindValue(':prix', $prix, PDO::PARAM_STR);
    $insert_produit->bindValue(':date_arrivee', $date_arrivee, PDO::PARAM_STR);
    $insert_produit->bindValue(':date_depart', $date_depart, PDO::PARAM_STR);
    $insert_produit->bindValue(':etat', $etat, PDO::PARAM_STR);
    $insert_produit->execute();
    // var_dump($_POST);
  }
  


//------- affichage ----------- //
if(!empty($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) {
  $ajoutActif = 'active';
  $affichageActif = '';
} else {
  $ajoutActif = '';
  $affichageActif = 'active';
}
include_once '../inc/header.inc.php';
?>
<ul style="margin: 10px 0;" class="nav nav-tabs">
  <li role="presentation" class="<?= $affichageActif ?>"><a href="gestion_produit.php?action=affichage">Afficher les produits</a></li>
  <li role="presentation" class="<?= $ajoutActif ?>"><a href="gestion_produit.php?action=ajout">Ajouter un produit</a></li>
</ul>

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Ajouter un produit</h3>
      </div>
      <div class="panel-body">
        <form method="post" enctype="multipart/form-data" role="form">
          
           <div class="row">            
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <select name="id_salle">
                  <option value="1">Salle Hamidou</option>
                  <option value="3">Salle Baron</option>
                  <option value="4">Salle Hatem</option>
                  <option value="5">Salle Helena</option>
                  <option value="6">Salle Alice</option>
                  <option value="7">Salle Ziad</option>                  
                </select>
              </div>
            </div>
          </div>

          <div class="row">            
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="date" name="date_arrivee" id="date_arrivee" class="form-control input-sm" placeholder="date_arrivee" value="">
              </div>
            </div>
          </div>

          <div class="row">            
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="date" name="date_depart" id="date_depart" class="form-control input-sm" placeholder="date_depart" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="prix" id="prix" class="form-control input-sm" placeholder="prix" value="">
              </div>
            </div>            
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="etat" id="etat" class="form-control input-sm" placeholder="etat" value="">
              </div>
            </div>            
          </div>

          <button style="margin-top: 15px;" type="submit" name="envoi" class="btn btn-info btn-block">Envoi</button>

        </form>
      </div>
    </div>
  </div>
</div>

<?php 
include_once '../inc/footer.inc.php';