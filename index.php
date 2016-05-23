<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
      
        <link rel="stylesheet" type="text/css" href="css/artisan.css" media="all"/>
        
    </head>
    <body>
	    
	    <?php 
		    include_once 'class/employee.class.php';
			$Employee = Employee::BDDtoEmployee();
			
						
		    ?>
	<center>
            <img src="img/logo.png" title="Chimeres">
            <h1>Artisans :</h1>
            <p>
                <?php 
	            foreach($Employee as $value){				
					if($value->nommetier != "Bijoutier" && $value->nommetier != "Contrôleur")
						$value->AfficherEmployee();	
				}
	           ?>
            </p>
            <h2>Contrôleurs :</h2>
            <p>
                <?php 
	            foreach($Employee as $value){				
					if($value->nommetier == "Contrôleur")
						$value->AfficherEmployee();	
				}
	           ?>
            </p>
             <h2>Bijoutier :</h2>
            <p>
                <?php 
	            foreach($Employee as $value){				
					if($value->nommetier == "Bijoutier")
						$value->AfficherEmployee();	
				}
	           ?>
            </p>
            <br>
            <p> Légende : 
	            <span class="Sertisseur">Sertisseur</span>
	            <span class="Contrôleur">Contrôleur</span>
	            <span class="Bijoutier">Bijoutier</span>
	            <span class="Fondeur">Fondeur</span>
	            <span class="Tailleur">Tailleur</span>
	            <span class="Polisseur">Polisseur</span>
	            
            </p>    
        </center>
    </body>
</html>
