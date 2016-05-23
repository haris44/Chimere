<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="css/vente.css">
		<title></title>
	</head>
	<body>
		
		<div id="menu">
			<a href="indexartisan.php"><img class="logo" src="img/logo.png" alt="" /></a>
			<br/>			
			
			
			
		</div>
		
		<div id="infos">
			<h2>Contactez-nous</h2>
			<hr class="contactligne">
			12, rue des Camélites <br>
			44000 Nantes<br>
			02 28 01 17 18 <br>
			contact@chimere-jewelry.com<br>
			<img src="img/artisan.png" style="padding: 10px;">
		</div>
		
		
        <div id="contenu">
	        

         <div id="pierre">
			<img src="img/pierre.png" alt="" style="margin-top: 10px;"/>
			</div>
			
			<div id="titre">
			<h1 >Nos bijoux en vente</h1>		
			<hr class="ligne"> 
		</div>

        
         
		
		<div id="affichagebijou">
			<br>
			<?php 
				 include_once 'class/bijou.class.php';
				 Bijou::AfficherBijouVente();
				?>
			
		
						
			
			
					
		</div>
        </div>
	</body>
</html>
