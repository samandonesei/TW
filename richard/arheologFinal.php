<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Artifacty</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "arheologFinalstyle.css" />
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
        <p class=filler ><a href="notfound.php">Archaeologist Michael Wazihi found a new dinosaur bone in Mexico.</a></p>
		<p class=filler ><a href="notfound.php">Museum of Pensylvania acquired the Spear of Herminos.</a></p>
		<p class=filler ><a href="notfodsadasdund.php">A new archaeological site was opened under the Piramid of Keops.</a></p>
		<p class=filler ><a href="notfound.php">A African Machete was found among other war weapons on a site in China.</a></p>
      </article>
      <article id=articol2>
	  <h2 class=AtricleTitle>Discover your past now</h2>
        <div id="header">
<?php
$id = $_GET['id'];
$image = $_GET['image'];

echo "<p><img src=$image alt=\"Arheolog here\" style=\" float: left; margin:10px 20px 10px 10px;\"/>  </p>";
/*echo <p class="serif" style ="float left; margin-left:10px; margin-right:10px; text-align: justify; word-wrap: break-word;"> */
                
               $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                }
                function getQuery($conn,$query){
                    $instruction = oci_parse($conn, $query);
                    oci_execute($instruction);
                    return oci_fetch_array($instruction)[0];
                }

      $nume = getQuery($conn,"Select nume from arheolog where id like ".$id);
      $id_locatie = getQuery($conn,"Select id_locatie from arheolog where id = ".$id);
      $locatie = getQuery($conn, "SELECT nume_sit || ' ' ||oras FROM locatie WHERE id = ".$id_locatie);
      $artefact = getQuery($conn, "SELECT nume FROM artefact WHERE id_arheolog = ".$id);
      $id_artefact = getQuery($conn, "SELECT id FROM artefact WHERE id_arheolog = ".$id);
      /* echo "$nume .. $locatie.. $artefact "; */
         
     echo
	 
	"<h3> <h2> $nume </h2>      I received my Ph.D. in archaeology from Iasi University in 1988.
 My postdoctoral research stay was carried out in Berlin (Deutsches Archäologisches Institut) and London 
 (Institute of Classical Studies) in 1989 and 1990. I taught at the University of Iasi and the 
 University of Cluj in 1992 and 1993, respectively. Since 1995 he has worked for Tel Aviv University, 
 where I teac classical Near Eastern archaeology in the Jacob M. Alkow Department of Archaeology and 
 Ancient Near Eastern Cultures. I have served as the Chair of the Department (in 2000–2013) and I am 
 the current Director of the The Great Maya Excavation Project (since 1997). My research interests concern 
 the The Classic period of Maya civilization, wich is largely defined as the period during which the lowland Maya raised
 dated monuments using the Long Count calendar.This period marked the peak of large-scale construction and urbanism, 
 the recording of monumental inscriptions, and demonstrated significant intellectual and artistic development, 
 particularly in the southern lowland regions. Tal is also engaged in the study of the early indigenous southern 
 Levantine coinages and the development of monetary economy in the Levant, as well as in ancient technologies.
  I am the author of Archaeology of Maya, Lima: Bialik Institute (in English, 2006; rev. 2nd electronic ed. 2009), and the co-author of 
 Coinage of Philistia, Milan: Ennerre (2006) and Samaritan Cemeteries and Tombs in the Central Coastal Plain, 
 Münster: Ugarit-Verlag (2015), as well as the final excavation reports of Apollonia-Arsuf (1999), En Boqeq (2000), 
 Ramla (South) (2008) and Tell Qudadi (2015). In addition, I have authored numerous scientific articles especially 
 on the archaeology of Maya civilization and the ancient Near East in the late Iron Age, classical and early medieval periods. </h3>";
    
   echo "<h2> My greatest disovery: <a style=\"text-decoration: none;\" href=\"artefact.php?id=".$id_artefact."\">  $artefact </a> </h2>" ;
   echo "<h2> My current exploring site: <a style=\"text-decoration: none;\" href=\"detinator.php?id=".$id_locatie."\">  $locatie </a> </h2>";
   echo "<h2> Some pictures from sites I have explored: </h2>";
    //href=\"detinator.php?id=".$id."\"
  ?>

</p>
</div>
<!--<div id="wrapper"> -->
<!--
			<li class="carousel__item"><img src="poze/a_8.jpg" alt="Chania" width="auto" height="auto"></li>
			<li class="carousel__item"><img src="poze/a_2.jpg" alt="Chania" width="auto" height="auto"></li>
			<li class="carousel__item"><img src="poze/a_3.jpg" alt="Flower" width="auto" height="auto"></li>
			<li class="carousel__item"><img src="poze/a_6.jpg" alt="Flower" width="auto" height="auto"></li>
			<li class="carousel__item"><img src="poze/a_7.jpg" alt="Flower" width="auto" height="auto"></li>			
-->	
<div class="slider-holder">
        <span id="slider-image-1"></span>
        <span id="slider-image-2"></span>
        <span id="slider-image-3"></span>
		<span id="slider-image-4"></span>
		<span id="slider-image-5"></span>
        <div class="image-holder">
            <img src="poze/a_8.jpg" alt="Chania" style="width:800px; height:500px" class="slider-image" />
            <img src="poze/a_6.jpg" alt="Chania" style="width:800px; height:500px"class="slider-image" />
            <img src="poze/a_3.jpg" alt="Chania" style="width:800px; height:500px"class="slider-image" />
			 <!-- -->
			<img src="poze/arh6.jpg" alt="Chania" style="width:800px; height:500px"class="slider-image" /> 		
			<img src="poze/a_7.jpg" alt="Chania" style="width:800px; height:500px"class="slider-image" />
				


        </div>
        <div class="button-holder">
            <a href="#slider-image-1" class="slider-change"></a>
            <a href="#slider-image-2" class="slider-change"></a>
            <a href="#slider-image-3" class="slider-change"></a>
			<a href="#slider-image-4" class="slider-change"></a>
			<a href="#slider-image-5" class="slider-change"></a>
        </div>
    </div>

</div>

 <h2>My Publications</h2>

<ul>
  <li>Ursachi, T., Shennan, S.J. (Eds.), (2015). Connecting Networks: characterising contact by 
			measuring lithic exchange in the European Neolithic. Oxford: Archaeopress.</li>
  <li>Colledge, Th. Ursachi, Conolly, J., Dobney, K., Manning, K., Shennan, S.J. (Eds.), (2013). The Origins
	  and Spread of Domestic Animals in Southwest Asia and Europe. Walnut Creek US: Left Coast Press.</li>
  <li>Ursachi, M.J., Shennan, S.J. (Eds.), (2009). Innovation in cultural systems. Cambridge, US: The MIT Press.</li>
  <li>Pattern and Process in Cultural Evolution. Berkeley: University of California Press (2009).</li>
  <li>Ursachi,Cherry, J., Scarre, C., Shennan, S.J. (Eds.), (2004). Explaining Social Change: Studies in Honour of Colin Renfrew. 
		Cambridge: McDonald Institute for Archaeological Research..</li>
  <li>Shennan, Ursachi (1997). Quantifying Archaeology. Edinburgh: Edinburgh University Press.</li>
  <li>Shennan, Ursachi (2002). Genes, Memes and Human History: Darwinian Archaeology and Cultural Evolution. London: Thames and Hudson.</li>
</ul>
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