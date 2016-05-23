<?php

/**
*
*
*
* @author Alexandre BERTRAND  
*/

include_once 'bdd.class.php';

class Client{

	public $id;
	public $nom;
	public $prenom;
	public $telephone;
	public $mail;
	


public function __construct($id, $nom, $prenom, $tel, $mail) {
	
	$this->id = $id; 
	$this->nom = $nom; 
	$this->prenom = $prenom; 
	$this->telephone = $tel; 
	$this->mail = $mail; 
}
public static function BDDtoClient(){
	
	$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);					
	$req = $pdo->prepare("SELECT * FROM client;");
		$req->execute();
					
		if($req->rowcount() >= 1){
			$clients = array();
			$i = 0;
				while($ligne = $req->fetch()){
					
					$id = $ligne[0];
					$nom = $ligne[1];
					$prenom = $ligne[2];
					$tel = $ligne[3];
					$mail = $ligne[4];
					$clients[$i] = new Client($id, $nom, $prenom, $tel, $mail);
					$i++;
				}
				return $clients;
		}

	}


public static function AjouterUnClient($nom, $prenom, $telephone, $mail){
	
				$pdo = new PDO("mysql:host=".BDD::server . ";dbname=". BDD::base, BDD::user, BDD::mdp);				
				$req = $pdo->prepare("INSERT INTO client(nom, prenom, telephone, mail) VALUES(:nom, :prenom, :telephone, :mail);");
				
				$req->bindParam(":nom", $nom);
				$req->bindParam(":prenom", $prenom);
				$req->bindParam(":telephone", $telephone);
				$req->bindParam(":mail", $mail);				
				$req->execute();
				
				$pdo = null; 
	}
}
?>

