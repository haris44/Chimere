<?php

/**
*
*
*
* @author Alexandre BERTRAND  
*/
include_once 'bdd.class.php';

class Etape {

	public $idetape;
	public $idbijou;
	public $photo;
	public $description;
	public $typereparation;
	public $employeeencours;
	public $numeroetape;
	
	
	public function __construct($idbijou, $photo, $description, $typereparation, $employeeencours, $numeroetape, $idetape) {
	
	
	$this->idbijou = $idbijou;
	$this->numeroetape = $idbijou;
	$this->photo = $photo;
	$this->description = $description;
	$this->typereparation = $typereparation;
	$this->employeeencours = $employeeencours;
	$this->numeroetape = $numeroetape;
	$this->idetape = $idetape;
	
	}

	public function AfficherCommentaires(){
			
			
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
			$pdo->exec('SET NAMES utf8');				
			$req = $pdo->prepare("SELECT e.commentaires, m.nommetier, e.photo FROM etape AS e
								JOIN metier AS m on e.metiersuivant = m.idmetier
								WHERE e.idbijou = :idbijou AND e.commentaires IS NOT NULL AND e.commentaires != '' ORDER BY e.date DESC");
								
			$req->bindParam(":idbijou", $this->idbijou);
				
						$req->execute();
						
						if($req->rowcount() >= 1){
							
								while($value = $req->fetch()){
										
									echo "<h2>Commentaire du $value[1]</h2>";
									echo "<img src='$value[2]' width='150px' style='height:80px; display:inline; float:right; margin-top:-40px;'>";
									echo "<p> $value[0] </p><br>";		
									echo "<hr>";											
							}					
						}
						
				$pdo = null; 
						
		}
		
	public function Ajoutercommentaire($commentaires, $photo){
		
		echo $photo;
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');	
					
					$req = $pdo->prepare("UPDATE etape SET commentaires = :commentaire, photo = :photo WHERE idetape = :idetape;");
					
					$req->bindParam(":idetape", $this->idetape);
					$req->bindParam(":commentaire", $commentaires);
					$req->bindParam(":photo", $photo);
					
					$req->execute();
										
					$pdo = null; 						
		}
	
	public static function AjouterEtape($idbijou, $poidsmetal, $poidpierre, $tempspasse, $nextmetier, $employeesencours,  $numeroetape, $date){
			
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
			$pdo->exec('SET NAMES utf8');	
						
						$req = $pdo->prepare("INSERT INTO etape(idbijou, employeeencours, numeroetape, tempspasse, date,  poidspierre, poidsmetal, metiersuivant)
											 VALUES (:idbijou, :employeeencours, :numeroetape, :tempspasse, :date,  :poidspierre, :poidsmetal, :metiersuivant);");
						
											 
						$req->bindParam(":idbijou", $idbijou);
						$req->bindParam(":employeeencours", $employeesencours);
						$req->bindParam(":numeroetape", $numeroetape);
						$req->bindParam(":tempspasse", $tempspasse);
						$req->bindParam(":date", $date);
						$req->bindParam(":poidspierre", $poidpierre);
						$req->bindParam(":poidsmetal", $poidsmetal);
						$req->bindParam(":metiersuivant", $nextmetier);
												
						$req->execute();
					
						
						$pdo = null; 
			
		}
		
		public static function AjouterEtapeControleur($idbijou, $poidsmetal, $poidpierre, $tempspasse, $nextmetier, $employeesencours, $photo, $numeroetape, $date, $com, $emp){
			
			$cobt = 4;
			
			$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
			$pdo->exec('SET NAMES utf8');	
						
						
						$req = $pdo->prepare("SELECT MAX(idetape) FROM etape WHERE idbijou = :idbijou");
						$req->bindParam(":idbijou", $idbijou);
						$req->execute();		
								if($req->rowcount() >= 1){
									while($value = $req->fetch()){
										$lastid = $value[0];
										}				
								}
								
				$pdo = null; 
				$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
				$pdo->exec('SET NAMES utf8');	
																	 
						$req = $pdo->prepare("UPDATE etape SET terminer = 1, commentaires = :com, employeeencours = :emp, photo = :photo, metiersuivant = :metiersuivant WHERE idetape = :idetape;");
						$req->bindParam(":idetape", $lastid);
						$req->bindParam(":com", $com);
						$req->bindParam(":emp", $emp);
						$req->bindParam(":photo", $photo);
						$req->bindParam(":metiersuivant", $cobt);
						
						$req->execute();
										
				$pdo = null; 																	 
				$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
				$pdo->exec('SET NAMES utf8');	
											 
						$req = $pdo->prepare("INSERT INTO etape(idbijou, employeeencours, numeroetape, tempspasse, date,  poidspierre, poidsmetal, metiersuivant)
											 VALUES (:idbijou, :employeeencours, :numeroetape, :tempspasse, :date,  :poidspierre, :poidsmetal, :metiersuivant);");
						
											 
						$req->bindParam(":idbijou", $idbijou);
						$req->bindParam(":employeeencours", $employeesencours);
						$req->bindParam(":numeroetape", $numeroetape);
						$req->bindParam(":tempspasse", $tempspasse);
						$req->bindParam(":date", $date);
						$req->bindParam(":poidspierre", $poidpierre);
						$req->bindParam(":poidsmetal", $poidsmetal);
						$req->bindParam(":metiersuivant", $nextmetier);
												
						$req->execute();
					
						
						$pdo = null; 
			
		}

	public function Termineretape(){
			
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');	
					
					$req = $pdo->prepare("UPDATE etape SET terminer = 1 WHERE idetape = :idetape;");
					
					$req->bindParam(":idetape", $this->idetape);

					$req->execute();
										
					$pdo = null; 						
		}		
	public static function EtapeToBDD($idbijou, $employeeencours, $photo, $metiersuivant) {
		
					$numeroetape = 0;
					$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
					$pdo->exec('SET NAMES utf8');							
					$req = $pdo->prepare("INSERT INTO etape(idbijou, employeeencours, numeroetape, photo, metiersuivant) VALUES (:idbijou, :employeeencours, :numeroetape, :photo, :metiersuivant);");
					
					$req->bindParam(":idbijou", $idbijou);
					$req->bindParam(":employeeencours", $employeeencours);
					$req->bindParam(":numeroetape", $numeroetape);
					$req->bindParam(":photo", $photo);
					$req->bindParam(":metiersuivant", $metiersuivant);
					
					$req->execute();
					
					
					$pdo = null; 
	}
	
	
}


?>

