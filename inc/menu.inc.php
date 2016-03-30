<div class="row">
			<div id="logo">
				<img src="assets/images/logo.png" width="100" height="100" alt="">
			</div>
			<nav class="collapse navbar-collapse col-md-10" >
				<ul class="nav navbar-nav navbar-inverse">
					<li><a href="http://localhost/PHP/11_lokisalle/accueil.php">Accueil</a></li>
					<li><a href="http://localhost/PHP/11_lokisalle/reservation.php">Réservation</a></li>
					<li><a href="http://localhost/PHP/11_lokisalle/recherche.php">Recherche</a></li>
					<?php if(!(userConnected())) : ?>
					<li><a href="http://localhost/PHP/11_lokisalle/connexion.php">Connexion</a></li>
					<?php endif; ?>
					<?php if(userConnected()) : ?>
					<li><a href="http://localhost/PHP/11_lokisalle/connexion.php?action=deconnexion">deconnexion</a></li>
					<?php endif; ?>
					<?php if(!(userConnected())) : ?>
					<li><a href="http://localhost/PHP/11_lokisalle/inscription.php">inscription</a></li>
					<?php endif; ?>
					<?php if(userAdmin()) : ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="http://localhost/PHP/11_lokisalle/admin/gestion_membres.php">Gestion des membres</a></li>
							<li><a href="http://localhost/PHP/11_lokisalle/admin/gestion_commandes.php">Gestion des commandes</a></li>
							<li><a href="http://localhost/PHP/11_lokisalle/admin/gestion_salle.php">Gestion des Salles</a></li>
							<li><a href="http://localhost/PHP/11_lokisalle/admin/gestion_produit.php">Gestion des produits</a></li>
							<li><a href="http://localhost/PHP/11_lokisalle/admin/gestion_avis.php">Gestion des avis</a></li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>