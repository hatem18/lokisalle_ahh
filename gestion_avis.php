<?php
require_once 'inc/init.inc.php';
?>


<?php
$avis = $lokisalle->query("SELECT * FROM avis");
  $infos_avis = $avis->fetchAll(PDO::FETCH_ASSOC);

 debug($avis);
 ?>
 <!-- <?php
 if(!empty($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_membre']) && is_numeric($_GET['id_membre'])) {
 $suppr_membre = $lokisalle -> prepare("DELETE FROM membre WHERE id_membre = :id_membre");
 $suppr_membre->bindValue(':id_membre', $_GET["id_membre"], PDO::PARAM_INT);
 $suppr_membre->execute();
}
?> -->

<?php
include_once 'inc/header.inc.php';
?>

<h1>Gestion Avis</h1>
<table class="table table-hover">
    <thead>
      <tr>
        <th>id_avis</th>
        <th>id_membre</th>
        <th>id_salle</th>
        <th>commentaire</th>
        <th>note</th>
        <th>date</th>
        <th>supprimer</th>
      </tr>
    </thead>
    <tbody>

    <!-- <?php for($i=0; $i<count($membre);$i++) : ?>

      <tr>
      	<td><?php echo $membre[$i]['id_membre'] ?></td>
        <td><?php echo $membre[$i]['pseudo'] ?></td>
        <td><?php echo $membre[$i]['mdp'] ?></td>
        <td><?php echo $membre[$i]['nom'] ?></td>       
        <td><?php echo $membre[$i]['prenom'] ?></td>
      	<td><?php echo $membre[$i]['email'] ?></td>
      	<td><?php echo $membre[$i]['sexe'] ?></td>
        <td><?php echo $membre[$i]['ville'] ?></td>
        <td><?php echo $membre[$i]['cp'] ?></td>
        <td><?php echo $membre[$i]['adresse'] ?></td>
        <td><?php echo $membre[$i]['statut'] ?></td>
        <td><a href="?action=suppression&id_membre=<?= $membre[$i]['id_membre'] ?>">X</a></td>
      	
      </tr> 
      <?php endfor ?>  -->
    </tbody>
  </table>


<?php
include_once 'inc/footer.inc.php';