<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Egyptean Culture</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "IndivType.css" />
  </head>
  <body>
    <header class="banner">
    </header>
	<header id=menubar>
	<a href="notfound.php" class=Button><span> Artefacts </span></a>
	<a href="notfound.php" class=Button><span> Archaeologists </span></a>
	<a href="notfound.php" class=Button><span> Sites </span></a>
	<a href="notfound.php" class=Button><span> Museums </span></a>
	<a href="notfound.php" class=Button><span> Admin Area </span></a>
	</header>
    <div id=articol2>
		<?php
		$conn = oci_connect('TW', 'TW', 'localhost/XE');
		if (!$conn){
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			exit();
		}
			
		$command = 'select * from tipologie where id ='.$_GET['id'];
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row = oci_fetch_array($instruction);
			echo '<h2 class=AtricleTitle>'.$row[1].'</h2>';
		if(file_exists('img/type'.$row[0].'.jpg'))
			$source='img/type'.$row[0].'.jpg';
		else
			$source='img/arh1.jpg';
		echo '<img src="'.$source.'" />';
		echo '<p class=filler>'.$row[2].'</p>';
		echo '<h2> Latest Artefacts in this category</h2>';
		
		$command = 'select * from (select * from artefact a 
		join incadrare i on i.id_artefact=a.id
		join TIPOLOGIE t on t.id = i.id_tipologie
		where id_tipologie ='.$_GET['id'].'order by a.id desc) where rownum <=3';
		$instruction = oci_parse($conn, $command);
		oci_execute($instruction);
		while ($row = oci_fetch_array($instruction))
		{

		$command2 = 'Select * from caracteristici where id_artefact='.$row[0];
		$instruction2 = oci_parse($conn, $command2);
		oci_execute($instruction2);
		$props = oci_fetch_array($instruction2);
	
		if(file_exists('img/artefact'.$row[0].'.jpg'))
			$source='img/artefact'.$row[0].'.jpg';
		else
			$source='img/standard.png';

		echo '<div class="post-container">';
		echo '<div class="post-thumb"><img src="'.$source.'" /></div>';
		echo '<div class="post-content">';
		echo '<h3 class="post-title">'.$row[1].'</h3>';
		echo '<p>'.$props[4].$props[1].$props[3].$props[5].$props[6].'</p>';
		echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';
		}
?>
	</div>
  </body>
</html>


