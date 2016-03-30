<?php
require_once '../inc/init.inc.php';
?>


<?php
$avis = $lokisalle->query("SELECT * FROM avis");
  $infos_avis = $avis->fetchAll(PDO::FETCH_ASSOC);


 ?>
  <?php
 if(!empty($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_avis']) && is_numeric($_GET['id_avis'])) {
 $suppr_avis = $lokisalle -> prepare("DELETE FROM avis WHERE id_avis = :id_avis");
 $suppr_avis->bindValue(':id_avis', $_GET["id_avis"], PDO::PARAM_INT);
 $suppr_avis->execute();
}
?> 

<?php
include_once '../inc/header.inc.php';
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

    <?php for($i=0; $i<count($infos_avis);$i++) : ?>

      <tr>
      	<td><?php echo $infos_avis[$i]['id_avis'] ?></td>
        <td><?php echo $infos_avis[$i]['id_membre'] ?></td>
        <td><?php echo $infos_avis[$i]['id_salle'] ?></td>
        <td><?php echo $infos_avis[$i]['commentaire'] ?></td>       
        <td><?php echo $infos_avis[$i]['note'] ?></td>
      	<td><?php echo $infos_avis[$i]['date'] ?></td>
        <td><a href="?action=suppression&id_avis=<?= $infos_avis[$i]['id_avis'] ?>">X</a></td>
      	
      </tr> 
      <?php endfor ?> 
    </tbody>
  </table>


<?php
include_once '../inc/footer.inc.php';