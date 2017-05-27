<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Artifacty</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "homepage.css" />
  </head>
  <body>
    <a href="Homepage.html"><header class="banner">
    </header></a>
	<header id=menubar>
	<a href="Artefacte.html" class=Button><span> Artefacts </span></a>
	<a href="notfound.php" class=Button><span> Archaeologists </span></a>
	<a href="notfound.php" class=Button><span> Sites </span></a>
	<a href="Detinator.html" class=Button><span> Museums </span></a>
	<a href="notfound.php" class=Button><span> Admin Area </span></a>
	</header>
    <section>
      <article id=atricol1>
        <h2 class=AtricleTitle>News</h2>
		<?php
		$conn = oci_connect('TW', 'TW', 'localhost/XE');
		if (!$conn){
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			exit();
		}
			
		$command = 'select * from (select * from (Select * from artefact order by id desc) where rownum<=dbms_random.value(2,50) order by id ) where rownum <=1';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row1 = oci_fetch_array($instruction);
			$command = 'select * from arheolog where id=(select id_arheolog from artefact where id='.$row1[0].')';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row2 = oci_fetch_array($instruction);
			$command = 'select * from locatie where id=(select id_locatie from artefact where id='.$row1[0].')';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row3 = oci_fetch_array($instruction);
		echo '<p class=filler ><a href="notfound.php">Archaeologist '. $row2[1].' found '.$row1[1].' in the '.$row3[1].' archeological site.</a></p>';
			$command = 'select * from (select * from (Select * from artefact order by id desc) where rownum<=dbms_random.value(2,50) order by id ) where rownum <=1';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row1 = oci_fetch_array($instruction);
			$command = 'select * from locatie where id=(select id_locatie from artefact where id='.$row1[0].')';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row2 = oci_fetch_array($instruction);	
		echo '<p class=filler ><a href="notfound.php">Artefact '. $row1[1].' is now in display at  '.$row2[1].' museum.</a></p>';
			$command = 'select * from (select * from (Select * from locatie order by id desc) where rownum<=dbms_random.value(2,50) order by id ) where rownum <=1';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row1 = oci_fetch_array($instruction);
		echo '<p class=filler ><a href="notfound.php">Archeological site" '. $row1[1].' " has been founded in '.$row1[3].'.</a></p>';
			$command = 'select * from (select * from (Select * from arheolog order by id desc) where rownum<=dbms_random.value(2,50) order by id ) where rownum <=1';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row1 = oci_fetch_array($instruction);
			$command = 'select * from locatie where id=(select id_locatie from arheolog where id='.$row1[0].')';
			$instruction = oci_parse($conn, $command);
			oci_execute($instruction);
			$row2 = oci_fetch_array($instruction);
		echo '<p class=filler ><a href="notfound.php">Archeolog " '. $row1[1].' " has started his research in '.$row2[1].'.</a></p>';
?>

      </article>
      <article id=articol2>
        <h2 class=AtricleTitle>Main window</h2>
		<p class=filler >Hello and welcome to the Artifacty WebSite! One of the most complete and detailed site about artefacts from around the world and from all time periods ranging fromfarming tools to embaling tools to battle weapons or armor and from dinosaur tibia to microwave-ovens.</p>
<?php
    $conn = oci_connect('TW', 'TW', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
        
    $command = 'select * from (Select * from artefact order by id desc) where rownum<=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);

    $command = 'Select * from caracteristici where id_artefact='.$row[0];
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $props = oci_fetch_array($instruction);
	
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

	$command = 'select * from (Select * from arheolog order by id desc) where rownum<=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	if(file_exists('img/arh'.$row[0].'.jpg'))
        $source='img/arh'.$row[0].'.jpg';
    else
        $source='img/arh1.jpg';
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="'.$source.'" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].$row[3].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';

	$command = 'select * from (Select * from locatie order by id desc) where rownum<=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].$row[3].$row[4].'</p>';
	echo'<a href=locatie.php?id='.$row[0].' class=RMButton><span> Read More </span></a>
			</div>
		</div>';
	
	$command = 'select * from (Select * from detinator order by id desc) where rownum<=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';

    $command = 'select * from (select * from (Select * from artefact order by id desc) where rownum<=2 order by id ) where rownum <=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);

    $command = 'Select * from caracteristici where id_artefact='.$row[0];
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $props = oci_fetch_array($instruction);

	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$props[4].$props[1].$props[3].$props[5].$props[6].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';

	$command = 'select * from (select * from (Select * from arheolog order by id desc) where rownum<=2 order by id ) where rownum <=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].$row[3].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';

	$command = 'select * from (select * from (Select * from locatie order by id desc) where rownum<=2 order by id ) where rownum <=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].$row[3].$row[4].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';

	$command = 'select * from (select * from (Select * from detinator order by id desc) where rownum<=2 order by id ) where rownum <=1';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);
    $row = oci_fetch_array($instruction);
	echo '<div class="post-container">';
	echo '<div class="post-thumb"><img src="Resources/147901-004-7CE3E91A.jpg" /></div>';
	echo '<div class="post-content">';
	echo '<h3 class="post-title">'.$row[1].'</h3>';
	echo '<p>'.$row[2].'</p>';
	echo'<a href="notfound.php" class=RMButton><span> Read More </span></a>
			</div>
		</div>';
?>

	</article id=articol3>
      <article >
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


