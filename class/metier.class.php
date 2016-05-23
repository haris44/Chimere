<?php

/**
*
*
*
* @author Alexandre BERTRAND  
*/
include_once 'bdd.class.php';

class Metier {

	public $idmetier;
	public $nommetier;
	
	public function __construct($id, $nom) {
	
	$this->idmetier = $id; 
	$this->nommetier = $nom; 

	}


	public static function AjouterMetier($nommetier){

		$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);			
		$pdo->exec('SET NAMES utf8');				
					$req = $pdo->prepare("INSERT INTO metier(nommetier) VALUES (:nommetier);");
					
					$req->bindParam(":nommetier", $nommetier);
					$req->execute();					
					
					$pdo = null; 

	}

		
	public static function BDDtoMetier(){

		
	$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);	
	$pdo->exec('SET NAMES utf8');	
					
	$req = $pdo->prepare("SELECT * FROM metier;");
		$req->execute();
					
		if($req->rowcount() >= 1){
			$clients = array();
			$i = 0;
			
				while($ligne = $req->fetch()){
					
					$id = $ligne[0];
					$nom = $ligne[1];
					$metier[$i] = new Metier($id, $nom);
					$i++;
				}
				
				return $metier;
		}

	}


}

?>

