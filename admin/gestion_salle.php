<?php
//-------- configuration ----------- //
require_once '../inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init

include_once '../inc/header.inc.php';

$titre = (!empty($_POST['titre'])) ? trim(strip_tags($_POST['titre'])) : '';
$pays = (!empty($_POST['pays'])) ? trim(strip_tags($_POST['pays'])) : '';
$ville = (!empty($_POST['ville'])) ? trim(strip_tags($_POST['ville'])) : '';
$cp = (!empty($_POST['cp'])) ? trim(strip_tags($_POST['cp'])) : '';
$adresse = (!empty($_POST['adresse'])) ? trim(strip_tags($_POST['adresse'])) : '';
$description = (!empty($_POST['description'])) ? trim(strip_tags($_POST['description'])) : '';
$photo = (!empty($_POST['photo'])) ? trim(strip_tags($_POST['photo'])) : '';
$capacite = (!empty($_POST['capacite'])) ? trim(strip_tags($_POST['capacite'])) : '';
$categorie = (!empty($_POST['categorie'])) ? trim(strip_tags($_POST['categorie'])) : '';



if(!empty($_FILES['photo']['name'])) { // si y'a une photo (bouton parcourir), je la prend
    $photo = strToLower($_FILES['photo']['name']);
    
    $source_photo = $_FILES['photo']['tmp_name'];
    $destination_photo = dirname(dirname(__FILE__)) . '/photos/' . $photo;
    copy($source_photo, $destination_photo); // je copie la photo temporaire de $_FILES dans mon dossier d'images
  
 }      

if (isset($_POST['envoi'])) {
$enregistraiment=$lokisalle ->prepare("INSERT INTO salle (titre, pays, ville, cp, adresse, description, photo, capacite, categorie) 
                    VALUES (:titre, :pays, :ville, :cp, :adresse, :description, :photo, :capacite, :categorie)");

//var_dump(get_class_methods($enregostrement));
// je lie les arguments de ma requete aux variables issues du $_POST
$enregistraiment->bindValue(':titre', $titre, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':pays', $pays, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':ville', $ville, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':cp', $cp, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':adresse', $adresse, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':description', $description, PDO::PARAM_STR);                     
$enregistraiment->bindValue(':photo', $photo, PDO::PARAM_STR);    
$enregistraiment->bindValue(':capacite', $capacite, PDO::PARAM_STR);    
$enregistraiment->bindValue(':categorie', $categorie, PDO::PARAM_STR);    

//j'execute ma requete
$enregistraiment->execute();  

$msg = '<p class="alert alert-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Produit enregistré avec succès !</p>';

         
           
}




?>

<div class="row centered-form">
  <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Ajouter une salle</h3>
      </div>
      <div class="panel-body">
        <form method="post" enctype="multipart/form-data" role="form">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="titre" id="titre" class="form-control input-sm" placeholder="Titre" value="">
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="pays" id="pays" class="form-control input-sm" placeholder="pays" value="">
              </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="ville" id="ville" class="form-control input-sm" placeholder="ville" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="cp" id="cp" class="form-control input-sm" placeholder="code postal" value="">
              </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="adresse" id="adresse" class="form-control input-sm" placeholder="adresse" value="">
              </div>
            </div>
          </div>

          <div class="form-group">
            <textarea name="description" id="description" class="form-control input-sm" placeholder="Description"></textarea>
          </div>

          <div class="form-group">
            <input style="padding:5px;" type="file" name="photo" id="photo" class="form-control" placeholder="Photo">
          </div>
          
            
           
            <div class="col-xs-4 col-sm-4 col-md-4">
              <div class="form-group">
                <input type="text" name="capacite" id="capacite" class="form-control input-sm" placeholder="capacite" value="">
              </div>
            </div>
            

           <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <input id="business" type="radio" name="categorie" value="business" >
                </span>
                <label for="business" class="form-control">business</label>
              </div><!-- /input-group -->
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <input id="fete" type="radio" name="categorie" value="fete" >
                </span>
                <label class="form-control" for="fete" >Fête</label>
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