<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
  		<link rel="stylesheet" href="css/indexartisan.css">
  		<link rel="stylesheet" href="css/menu.css">
		<title></title>
	</head>
	<body>
            <div id="menu">
                <img src="img/logo.png" alt="" width="100%"/>		
            </div>
            
           		
<?php
include_once 'class/bijou.class.php';
session_start ();
if (isset($_SESSION['idemp'])) {

	
?>


		<div id="menu">
			<a href="indexartisan.php"><img src="img/logo.png" alt="" width="100%"/></a>
			<br/>			
						
			
		</div>
            <div id="bidonjour"><b>Bonjour,</b> <?php  echo $_SESSION['prenom']; echo " "; echo $_SESSION['nom'];?></div>
		<a href="deco.php"><div id="deco">Déconnexion			
			</div></a>
			
		<?php
		if($_SESSION['nommetier'] == "Bijoutier"){
	
		echo "
		 <div id='gestion'>
	            
                <ul id='menus'>
					<li>
							<a href='#'>  Administrer le site </a>
						<ul>
                        	<li><a href='#'>Employées</a></li>
                        	<li><a href='#'>Bijoux</a></li>
							<li><a href='#'>Boutique</a></li>
							<li><a href='#'>Archives</a></li>
                		</ul>
					</li>   
				</ul>
				
            </div>";
            }
            
			?>
		
		
		<div id="affichagebijou">
		
		<img src="img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
                <h1 >Bijoux</h1>		
                <hr style="margin-top: 5px;"> 


			<a href="add/addbijou.php">
			<div id="carre" class="white"><b>Ajouter un bijou</b>
            	<center>
            		<img src="img/add3.png" alt="" class="bijou" title="Pendentif de Mme Bordat">
            	</center>          	
				   <p class="envoye"> CLiquez ici pour ajouter un bijou </p>      
			</div>
			</a>
			
			<div id="carre" class="red">Pendentif de Mme Bordat
            	<center>
            		<img src="img/bijou.jpg" alt="" class="bijou" title="Pendentif de Mme Bordat">
            	</center>          	
				<p class="envoye">Envoyé par : Michel</p>      
			</div>
			
			
			<br>
			<img src="img/pierre.png" alt="" width="25px" style="margin-top: 10px;"/>
                <h1 >Bijoux</h1>		
                <hr style="margin-top: 5px;"> 

			
			
			
		</div>
	</body>
</html>