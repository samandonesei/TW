<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Artefact Types</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "Type.css" />
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
    <section>

      <article id=articol2>
<?php
    $conn = oci_connect('TW', 'TW', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
        
    $command = 'select * from tipologie where rownum<=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);

    $command = 'Select * from tipologie';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);

         while ($row = oci_fetch_array($instruction)) {
			
			if(file_exists('img/type'.$row[0].'.jpg'))
				$source='img/type'.$row[0].'.jpg';
			else
				$source='img/standard.png';

			echo '<div class="post-container">';
			echo '<div class="post-thumb"><img src="'.$source.'" /></div>';
			echo '<div class="post-content">';
			echo '<h3 class="post-title">'.$row[1].'</h3>';
			echo '<p>'.$row[2].$row[3].'</p>';
			echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';
            }
?>


	</article>
      <article  id=articol3>
        <h2 class=AtricleTitle>Search</h2>
		<div><input type="search" id="search" placeholder="Search..." />
			</div>
		<h3>Recently Searched</h3>
        <p class=filler><a href="notfound.php">BattleAxe of Olaf The Mighty</a></p>
		<p class=filler><a href="notfound.php">Spear of Thetzuo</a></p>
		<p class=filler><a href="notfound.php">Pterodactyl tibia</a></p>
		<p class=filler><a href="notfound.php">Golden Trojan calice</a></p>
        <h2 class=AtricleTitle>Tags</h2>
		<p>war-weapons bones tools armors swords china egypt north-america mayan helmet Sirius-the-great peru-site dinosaur coffin sarcophagus relic shrine  Assyrian statue wine-cup ritual-vessels papyrus Persepolis  terracotta-soldier  stone-head</p>
      </article>
    </section>

  </body>
</html>


