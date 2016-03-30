<?php
//-------- configuration ----------- //
require_once 'inc/init.inc.php'; //-- j'appelle les require qui se trouvent dans init
// si je ne suis pas connecté, je n'accède pas à cette page
if(!isset($_SESSION['utilisateur'])) {
	header('location:connexion.php');
	exit();
}
include_once 'inc/header.inc.php';
?>
<h1>Profil</h1>
<p>Bonjour <?= ($_SESSION['utilisateur']['sexe'] == 'm') ? 'Mr' : 'Mme' ?> <?= ucfirst($_SESSION['utilisateur']['prenom']) ?> <?= strtoupper($_SESSION['utilisateur']['nom']) ?> voici vos infos :
<ul>
<?php foreach($_SESSION['utilisateur'] as $key => $value) : ?>
	<li><?= $key ?> : <?= $value ?></li>
<?php endforeach; ?>
</ul>
<?php if(!empty($_SESSION['utilisateur']['statut']) && $_SESSION['utilisateur']['statut'] == 1) : ?>
<h3>Vous êtes ADMIN</h3>
<?php endif; ?>
<a href="?action=modifier_infos">Mettre à jour vos informations</a>
</p>
<h2>Vos dernieres commandes</h2>
<table class="table table-hover">
    <thead>
      <tr>       
        <th>Numero suivi</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>     
          <tr>
          	<th>ID</th>
          	<th>ID</th>
          	<th>ID</th>
          </tr>      
    </tbody>
  </table>
<?php
include_once 'inc/footer.inc.php';