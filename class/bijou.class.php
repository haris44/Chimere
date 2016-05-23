<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

/**
*
*
*
* @author Alexandre BERTRAND  
*/
include_once 'bdd.class.php';
include_once 'etape.class.php';

class Bijou {

	public $idbijou;
	public $idclient;
	public $devis;
	public $estimation;
	public $nombreheureprevu;
	public $dateentree;
	public $photo;
	public $description;
	public $typereparation;
	public $etat;
	public $commentaires;


	public function __construct($idclient, $devis, $estimation, $nombreheureprevu, $dateentree, $photo, $description, $typereparation, $etat) {
	

	$this->idclient = $idclient;
	$this->devis = $devis;
	$this->estimation = $estimation;
	$this->nombreheureprevu = $nombreheureprevu;
	$this->dateentree = $dateentree;
	$this->photo = $photo;
	$this->description = $description;
	$this->typereparation = $typereparation;
	$this->etat = $etat;

	}
	
	public static function AfficherInformation($idbijou){

		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT SUM(e.tempspasse), SUM(poidspierre), SUM(poidsmetal), COUNT(idetape), p.devis, p.estimation, p.dateentree, p.description, p.typereparation, p.etat, c.nom, c.prenom, p.nombreheureprevu 
									FROM projet AS p
									LEFT JOIN client as c ON p.idclient = c.idclient
									LEFT JOIN etape as e ON e.idbijou = p.idbijou
									WHERE p.idbijou = :idbijou
									GROUP BY p.idbijou							
									");
							
					$req->bindParam(":idbijou", $idbijou);
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
								
								
								$etat = "unknown";
								if($value[9] == 0){
									$etat = "En cours de traitement par les employées.";
									$action = "Aucune action n'est attendu de votre part !";
								}
								else if($value[9] == 1){
									$etat = "L'objet est terminé, en attente d'action de votre part";
									$action = "
										<br>-> <a href='action/clientok.php?idbijou=$idbijou'>Le client est venu chercher l'objet (mise en archive)</a><br>
										-> <a href='action/miseenvente.php?idbijou=$idbijou'>Mise en vente de l'objet</a>
									";
								}
								else if($value[9] == 2){
									$etat = "L'objet est remis à son propriétaire";
									$action = "Aucune action n'est attendu de votre part !";
								}
								else if($value[9] == 3){
									$etat = "L'objet est en vente sur le site vitrine";
									$action = "<br>
										-> <a href='action/archiver.php?idbijou=$idbijou'>Declarer l'objet vendu (mise en archive)</a>
									";
								}
					
				
								
								
							echo "
							<p>
							<b>Client</b> : $value[10] $value[11] <br><br>
							<b>Description</b> : $value[7]<br>
							<b>Type de réparation</b> : $value[8]<br>
							<b>Date d'entrée du bijou</b> : $value[6]<br>
							<b>Avancement du projet</b> : $etat<br>
							<br>
							<b>Nombre d'heure prévu</b> : $value[12] h<br>
							<b>Temps passé par les exmployées</b> : $value[0] h<br>
							<b>Nombre d'étape effectué</b> : $value[3]<br>
							<br>
							<b>Poids métal utilisé</b> : $value[2] gr<br>
							<b>Poids de pierre utilisé</b> : $value[1] gr<br>
							</p>
							<div id='commentaire'>
							<h2> Action de votre part : </h2>	
							<p> <i>$etat</i> <br> $action 
							<br><br>
							<a href='modify/bijou.php?idbijou=$idbijou'> Modifier le bijou</a></p>			
							</div>
							</div>
							";					
		
							}						
					}
					
			$pdo = null; 		
		
	}
	
		public static function AfficherInterfaceControleur($idbijou){
				
			$Metiers = Metier::BDDtoMetier();	
						
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT e.metiersuivant, p.description, p.typereparation, p.idbijou, e.numeroetape FROM projet as p
									JOIN etape as e ON e.idbijou = p.idbijou
									WHERE p.idbijou = :idbijou
									order by e.idetape desc
									limit 0, 1
							");
							
					$req->bindParam(":idbijou", $idbijou);
					$req->execute();
					
					if($req->rowcount() >= 1){
						
							while($value = $req->fetch()){
							
							$terminer = 0;
							$avancement = "En cours de traitement par les employées";
							if($value[0] == 4)
							{
								$terminer = 1;
								$avancement = "Verification avant le retour au client";
							}	
								echo "<p>
								<b>Description du bijou :</b> $value[1]<br>
								<b>Type de réparation : </b>$value[2]<br/>
								<b> Avancement du projet : </b> $avancement 
								</p>";
								
								echo "<form action='action/controle.php' method='POST'>";
								
								echo '<input type="submit" name="submit" class="greenbutton" value="Déclarer conforme">	';	
								
								echo "<br><br><b> OU ce bijou n'est pas conforme : </b><br><br>";		

								echo "<input type='hidden' name='terminer' value='$terminer' >";
								echo "<input type='hidden' name='metier' value='$value[0]' >";
								echo "<input type='hidden' name='idbijou' value='$value[3]' >";
								echo "<input type='hidden' name='numeroetape' value='$value[4]' >";
								
								echo " Metier suivant :<select name='nextmetier'>";
								foreach($Metiers as $values ){
									if($values->nommetier == $_SESSION['nommetier'] || $values->nommetier == "Bijoutier" | $values->nommetier == "Contrôleur"){}
								else
									echo "<option value='$values->idmetier'> $values->nommetier";
								}
								
								echo "</select> <br>";
								echo "
									Votre commentaire :<br>
									<textarea rows='5' cols='50' name='com'></textarea>
									<br>
									";	
								echo '<input type="submit" name="submit" class="redbutton" value="Déclarer non conforme">	';	
								echo "</form>";
													
						}
															
					}
					
			$pdo = null; 					


				echo "</div>";
			}
	
	
	public static function AfficherBijouIndex($idmetier){
		
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT e.idbijou, p.photo, p.description, ep.prenom FROM etape AS e
							INNER JOIN projet AS p ON e.idbijou = p.idbijou
							INNER JOIN employee AS ep ON ep.idemployee = e.employeeencours
							WHERE metiersuivant = :idmetier AND terminer IS NULL
							");
							
					$req->bindParam(":idmetier", $idmetier);
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
								
							echo"	<a href='Bijoux.php?id=$value[0]'>";
							echo"			<div id='carre' class='green'>$value[2]";
							echo"				<center>";
							echo"					<img src=$value[1] alt='' class='bijou'>";
							echo"				</center>          	";
							echo"					<p class='envoye'>Envoyé par : $value[3] </p>";
							echo"			</div>";
							echo"	</a>";						
		
							}						
					}
					
			$pdo = null; 					
	
	}
	
	public static function AfficherBijouTotal(){
		
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT MAX(e.idbijou), p.photo, p.description, ep.prenom FROM etape AS e
							INNER JOIN projet AS p ON e.idbijou = p.idbijou
							INNER JOIN employee AS ep ON ep.idemployee = e.employeeencours
							WHERE p.etat < 1
                            GROUP BY e.idbijou
							
							");
							
					
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
								
							echo"	<a href='Bijoux.php?id=$value[0]'>";
							echo"			<div id='carre' class='green'>$value[2]";
							echo"				<center>";
							echo"					<img src=$value[1] alt='' class='bijou'>";
							echo"				</center>          	";
							echo"					<p class='envoye'>Envoyé par : $value[3] </p>";
							echo"			</div>";
							echo"	</a>";						
		
							}						
					}
					
			$pdo = null; 					
	
	}
	
	public static function AfficherBijouVente(){
		
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT p.photo, p.description, p.prixfinal FROM projet as p
							WHERE p.etat = 3
							
							");
							
					
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
							
							echo "
							<div id='carre' >
								<center>
									<img src='$value[0]' alt='' class='bijou' >
								</center>      	
								$value[1]<br>
								<span class='prix'> $value[2]€  </span><br>
									<div id='contact'><img src='img/enveloppe.png' class='env'><br><span class='martop'>Contactez-nous</span></div>
										</div>";
				
		
							}						
					}
					
			$pdo = null; 					
	
	}



	public static function SelectBijou($idbijou){
		
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT e.idbijou, p.photo, p.description, p.typereparation, ep.prenom, e.numeroetape, e.idetape FROM etape AS e
								INNER JOIN projet AS p ON e.idbijou = p.idbijou
								INNER JOIN employee AS ep ON ep.idemployee = e.employeeencours
								WHERE e.idbijou = :idbijou AND terminer IS NULL
								");
							
					$req->bindParam(":idbijou", $idbijou);
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
						
								$idbijou = $value[0];
								$photo = $value[1];
								$description = $value[2];
								$typereparation = $value[3];
								$employeeencours = $value[4];
								
								$bijou = new Etape($idbijou, $photo, $description, $typereparation, $employeeencours, $value[5], $value[6]);
							}		
																	
					}
			return $bijou;
					
			$pdo = null; 					
	
	}

	public static function SelectBijouModify($idbijou){
		
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');		
			$req = $pdo->prepare("SELECT c.idclient, c.nom ,c.prenom, p.devis, p.estimation, p.nombreheureprevu, p.description, p.typereparation 									FROM projet as p 
									INNER JOIN client as c ON c.idclient = p.idclient
									WHERE idbijou = :idbijou
									
								");
							
					$req->bindParam(":idbijou", $idbijou);
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
						
								$bijou[0] = $value[0];
								$bijou[1] = $value[1];
								$bijou[2] = $value[2];
								$bijou[3] = $value[3];
								$bijou[4] = $value[4];
								$bijou[5] = $value[5];
								$bijou[6] = $value[6];
								$bijou[7] = $value[7];
							}		
																	
					}
					
			$pdo = null; 				
			return $bijou;					
								
	
	}




	public static function AjouterBijou($idclient, $devis, $estimation, $nombreheureprevu, $dateentree, $photo, $description, $typereparation, $etat, $metiersuivant, $idbijou){


			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
			$pdo->exec('SET NAMES utf8');
				
					$req = $pdo->prepare("INSERT INTO projet(idclient, devis, estimation, nombreheureprevu, dateentree, photo, description, typereparation, etat) 
										VALUES (:idclient, :devis, :estimation, :nombreheureprevu, :dateentree, :photo, :description, :typereparation, :etat);");
								
				$req->bindParam(":idclient", $idclient);
				$req->bindParam(":devis", $devis);
				$req->bindParam(":estimation", $estimation);
				$req->bindParam(":nombreheureprevu", $nombreheureprevu);
				$req->bindParam(":dateentree", $dateentree);
				$req->bindParam(":photo", $photo);
				$req->bindParam(":description", $description);
				$req->bindParam(":typereparation", $typereparation);
				$req->bindParam(":etat", $etat);
					
				$req->execute();					
				$pdo = null; 				
					
				$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
				$pdo->exec('SET NAMES utf8');
								
				$req = $pdo->prepare("SELECT idemployee FROM employee AS e JOIN metier AS m ON e.metier = m.idmetier WHERE m.nommetier = 'Bijoutier';");
							$req->execute();
							
							if($req->rowcount() >= 1){
									while($value = $req->fetch()){
										$employeeencours = $value[0];
							}
								
				}
							
					$pdo = null; 
					
				
				
				$BijouCree = new Bijou($idclient, $devis, $estimation, $nombreheureprevu, $dateentree, $photo, $description, $typereparation, $etat);
				Etape::EtapeToBDD($idbijou, $employeeencours, $photo, $metiersuivant);
				return $BijouCree;					

	}
	
	public static function SelectMaxId(){
	
				
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');
					
		$req = $pdo->prepare("SELECT max(idbijou) FROM projet");
			$req->execute();		
				if($req->rowcount() >= 1){
					while($value = $req->fetch()){
						 $lastid = $value[0];
					}				
			}
					
			$pdo = null; 
			return $lastid;
		}
		
	public static function SetEtat($idbijou, $etat){
	
				
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("UPDATE projet SET etat = :etat WHERE idbijou = :idbijou");
		
				$req->bindParam(":idbijou", $idbijou);
				$req->bindParam(":etat", $etat);

					
				$req->execute();					
				$pdo = null; 

		}
	
	public static function ModiferBijou($idbijoux, $idclient, $devis, $estimation, $hprevu, $description, $motif){
	
				
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
							
		$req = $pdo->prepare("UPDATE projet SET idclient = :idclient, devis = :devis, estimation = :estimation, nombreheureprevu = :hprevu, description = :description, typereparation = :typereparation WHERE idbijou = :idbijou");
		
				$req->bindParam(":idbijou", $idbijoux);
				$req->bindParam(":idclient", $idclient);
				$req->bindParam(":devis", $devis);
				$req->bindParam(":estimation", $estimation);
				$req->bindParam(":hprevu", $hprevu);
				$req->bindParam(":description", $description);
				$req->bindParam(":typereparation", $motif);
			
				$req->execute();		
				
				$pdo = null; 
				

		}
		
	public static function MettreEnVente($idbijou, $prix, $nom){
	
		$etat = 3;
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("UPDATE projet SET etat = :etat, description = :nom, prixfinal = :prixfinal WHERE idbijou = :idbijou");
		
		
				$req->bindParam(":idbijou", $idbijou);
				$req->bindParam(":etat", $etat);
				$req->bindParam(":nom", $nom);
				$req->bindParam(":prixfinal", $prix);
					
				$req->execute();					
				$pdo = null; 

		}
		
	public static function Archiver($idbijou){
	
	
		
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');
					
		$req = $pdo->prepare("SELECT p.idbijou ,p.idclient, p.devis, p.description, p.typereparation, p.estimation, p.prixfinal, COUNT(e.idbijou), SUM(poidspierre), SUM(poidsmetal), p.etat, p.photo 
								FROM Projet as p 
								JOIN etape as e ON p.idbijou = e.idbijou 
								WHERE p.idbijou = :idbijou
								GROUP by p.idbijou
								");
							
					$req->bindParam(":idbijou", $idbijou);
					$req->execute();
					
					if($req->rowcount() >= 1){
							while($value = $req->fetch()){
						
								$idbijou = $value[0];	
								$idclient = $value[1];
								$devis= $value[2];								
								$description = $value[3];
								$typereparation = $value[4];
								$estimation = $value[5];
								$prixfinal = $value[6];
								$nombreetape = $value[7];
								$poidspierre = $value[8];
								$poidsmetal = $value[9];
								$etat = $value[10];
								$photo = $value[11];			
							}		
																	
					}
	;
					
			$pdo = null;
			
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');
				
					$req = $pdo->prepare("INSERT INTO archive(idbijou, idclient, devis, description, typereparation, estimation, prixfinal, nombreetape, pierreutilise, metalutilise, etatfinal, photo) 
										VALUES (:idbijou, :idclient, :devis, :description, :typereparation, :estimation, :prixfinal, :nombreetape, :poidspierre, :poidsmetal, :etat, :photo);");
								
				$req->bindParam(":idbijou", $idbijou);
				$req->bindParam(":idclient", $idclient);
				$req->bindParam(":devis", $devis);
				$req->bindParam(":description", $description); 
				$req->bindParam(":typereparation", $typereparation);
				$req->bindParam(":estimation", $estimation);
				$req->bindParam(":prixfinal", $prixfinal);
				$req->bindParam(":nombreetape", $nombreetape);
				$req->bindParam(":poidspierre", $poidspierre);
				$req->bindParam(":poidsmetal", $poidsmetal);
				$req->bindParam(":etat", $etat);
				$req->bindParam(":photo", $photo);
					
				$req->execute();					
				$pdo = null; 	
		
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');
		
		
		$req = $pdo->prepare("DELETE FROM etape WHERE idbijou = :idbijou");
				
				$req->bindParam(":idbijou", $idbijou);

					
				$req->execute();					
				$pdo = null; 				
	 	
	 	$etat = 5;
	 	
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');		
		
		$req = $pdo->prepare("UPDATE projet SET etat = :etat WHERE idbijou = :idbijou");
				
				$req->bindParam(":idbijou", $idbijou);
				$req->bindParam(":etat", $etat);
					
				$req->execute();					
				$pdo = null; 
				
				
		}

		public static function MettrePrixFinal($idbijou, $prix){
	
		$etat = 2;
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("UPDATE projet SET etat = :etat, prixfinal = :prixfinal WHERE idbijou = :idbijou");
		
		
				$req->bindParam(":idbijou", $idbijou);
				$req->bindParam(":etat", $etat);
				$req->bindParam(":prixfinal", $prix);
					
				$req->execute();					
				$pdo = null; 

		}


		public static function ConsulterArchive(){
	
		$etat = 2;
		echo "
		<table>
		<tr>
			<th>idBijou</th>
			<th>idClient</th>
			<th>Devis</th>
			<th>Description</th>
			<th>Type réparation</th>
			<th>Estimation</th>
			<th>Prix Final</th>
			<th>Nombre d'étape</th>
			<th>Qté pierre</th>
			<th>Qté métal</th>
			<th>Etat final</th>
		</tr>

";
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("SELECT * FROM archive");
				$req->execute();
							
					if($req->rowcount() >= 1){
						while($value = $req->fetch()){
										echo "
										<tr>
											<td>$value[0]</td>
											<td>$value[1]</td>
											<td>$value[2]</td>
											<td>$value[3]</td>
											<td>$value[4]</td>
											<td>$value[5]</td>
											<td>$value[6]</td>
											<td>$value[7]</td>
											<td>$value[8]</td>
											<td>$value[9]</td>
											<td>$value[10]</td>
											
										</tr>";
										
							
							}
								
				}
			
				$pdo = null; 
				echo '</table>';
		}



		
		
	
	
}

?>

