<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

/**
* Deux employéees discutent
* Moi ,fait l'un, je traite toujours mes clients comme ma cigarette
* Comment ça ? 
* Je les roules toujours moi même !!! 
*
* @author Alexandre BERTRAND  
*/
include_once 'bdd.class.php';

class Employee {

	public $id;
	public $idmetier;
	public $nom;
	public $prenom;
	public $nommetier;
	public $estpresent;
	
	public function __construct($id, $idmetier, $prenom, $nom, $nommetier, $estpresent) {
		$this->id = $id;
		$this->idmetier = $idmetier;
		$this->prenom = $prenom;
		$this->nom = $nom;
		$this->nommetier = $nommetier;
		$this->estpresent = $estpresent;
	}
	
	
	public function AfficherEmployee(){
			
			if($this->estpresent == false){
			echo "<a href='connect.php?emp=$this->id' class='$this->nommetier'>  $this->prenom $this->nom</a><br/>"; 
			}
		
		}
	
	
		public static function EnVacances($idemployee){
	
		$etat = 1;
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("UPDATE employee SET estpresent = :estpresent WHERE idemployee = :idemployee");
		
				$req->bindParam(":estpresent", $etat);
				$req->bindParam(":idemployee", $idemployee);

					
				$req->execute();					
				$pdo = null; 

		}
		
		public static function RevenuVacances($idemployee){
	
		$etat = 0;
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("UPDATE employee SET estpresent = :estpresent WHERE idemployee = :idemployee");
		
				$req->bindParam(":estpresent", $etat);
				$req->bindParam(":idemployee", $idemployee);

					
				$req->execute();					
				$pdo = null; 

		}

		
		
	public static function AjouterEmployee($nom, $prenom, $metier){
		
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');	
					
					$req = $pdo->prepare("INSERT INTO employee(nom, prenom, metier) VALUES (:nom, :prenom, :metier);");
					
					$req->bindParam(":nom", $nom);
					$req->bindParam(":prenom", $prenom);
					$req->bindParam(":metier", $metier);

					
					$req->execute();
					$pdo = null; 
	}
	
	public static function BDDtoEmployee(){
	
	$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);					
	$req = $pdo->prepare("SELECT * FROM employee as e JOIN metier AS m ON e.metier = m.idmetier ORDER BY m.idmetier ASC;");
	$pdo->exec('SET NAMES utf8');	
		$req->execute();
					
		if($req->rowcount() >= 1){
			$employee= array();
			$i = 0;
				while($ligne = $req->fetch()){
					
					$id = $ligne[0];
					$nom = $ligne[1];
					$prenom = $ligne[2];
					$idmetier = $ligne[5];
					$nommetier = $ligne[6];
					$estpresent = $ligne[4];
					$employee[$i] = new Employee($id, $idmetier, $prenom, $nom, $nommetier, $estpresent);
					$i++;
				}
				
				return $employee;
		}

	}
	
	public static function BDDtoEmploye($idemployee){
	
	$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);					
	$req = $pdo->prepare("SELECT * FROM employee as e JOIN metier AS m ON e.metier = m.idmetier WHERE idemployee = :idemployee ORDER BY m.idmetier ASC;");
	$pdo->exec('SET NAMES utf8');	
	
		$req->bindParam(":idemployee", $idemployee);
		
		$req->execute();
					
		if($req->rowcount() >= 1){
			$employee= array();
			$i = 0;
				while($ligne = $req->fetch()){
					
					$id = $ligne[0];
					$nom = $ligne[1];
					$prenom = $ligne[2];
					$idmetier = $ligne[5];
					$nommetier = $ligne[6];
					$employee[$i] = new Employee($id, $idmetier, $prenom, $nom, $nommetier);
					$i++;
				}
				
				return $employee;
		}

	}
	
	public static function ConsulterEmployee(){
	
		$etat = 2;
		echo "
		<table>
		<tr>
			<th>iD</th>
			<th>Nom</th>
			<th>Prenom</th>
			<th>iDMetier</th>
			<th>Presence</th>

		</tr>

";
		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);		
		$pdo->exec('SET NAMES utf8');
						
		$req = $pdo->prepare("SELECT * FROM employee");
				$req->execute();
							
					if($req->rowcount() >= 1){
						while($value = $req->fetch()){
							
							if($value[3] != 4){
								
							if($value[4] == false){
							$lien = "<a href='mettreenvacances.php?id=$value[0]'> Mettre en vacances</a>";
							}
							else{
							$lien =  "<a href='revenirvacances.php?id=$value[0]'> Revenu de vacances</a>";
							}
							
										echo "
										<tr>
											<td>$value[0]</td>
											<td>$value[1]</td>
											<td>$value[2]</td>
											<td>$value[3]</td>
											<td>$lien</td>
																						
										</tr>";
							}
																	
							}
							
								
				}
			
				$pdo = null; 
				echo '</table>';
		}


}

?>

