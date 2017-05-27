<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Detinatori</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "detinatori.css" />
  </head>
  <body>
    <a href="Homepage.html"><header class="banner">
    </header></a>
	<header id=menubar>
    <a href="Artefacte.html" class=Button><span> Artefacts </span></a>
	<a href="arheologi.php" class=Button><span> Archaeologists </span></a>
	<a href="locatii.php" class=Button><span> Sites </span></a>
	<a href="Detinatori.php" class=Button><span> Museums </span></a>
	<a href="administrare.php" class=Button><span> Admin Area </span></a>
	</header>
    <section>
      <article id=atricol1>
        <h2 class=AtricleTitle>New Owners</h2>
        <?php
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
                $nr=4;
                $max=getQuery($conn,"Select max(id) from detinator");
                while($nr){
                    $nr=$nr-1;
                    echo "<p class=filler><a href=detinator?id=\"".$max."\">".getQuery($conn,"Select nume from detinator where id like ".$max)."</a></p>";
                    $max=getQuery($conn,"Select max(id) from detinator where id<".$max);
                }
        ?>
      </article>
      <article id=articol2>
        <h2 class=AtricleTitle>Muzeums and collectioners</h2>
		<?php
            
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                } 
                if (isset($_GET['LowerID'])) {
                    $LowerID = $_GET['LowerID'];
                    $UpperID = $_GET['UpperID'];
                    $UpperID = $_GET['UpperID'];
                }
                else{        
                    $LowerID = 0;
                    $UpperID = 5;
                }
                $auxLower = $LowerID;
                $auxUpper = $UpperID;
                if(isset($_GET['search'])){
                    $filter[0]=' where nume like \'%'.$_GET['search'].'%\'';
                    $filter[1]=' join artefact on artefact.id_detinator=detinator.id and artefact.nume like \'%'.$_GET['search'].'%\'';
                    $filter[2]=' where tip like \'%'.$_GET['search'].'%\'';
                    $s="<input type=\"hidden\" name=\"search\" value=\"".$_GET['search']."\"/>";
                }
                else{
                    $filter[0]=' where 1=1';
                    $s="";
                }
                
                $all=0;
                for($i=0;$i<count($filter);$i++){
                   $count=getQuery($conn,'Select count(*) from detinator'.$filter[$i]); 
                   
                   if($count!=0)
                    $id=getQuery($conn,'Select min(detinator.id) from detinator'.$filter[$i]);
                   else 
                       continue;
                   $all+=$count;
                   while($count--){
                        $type=getQuery($conn,'Select tip from detinator where id like '.$id);
                        if($LowerID<=0){
                           if(file_exists("img/detinator".$id))
                                $source="img/detinator".$id;
                            else
                                if($type[0]=='M')
                                    $source="img/standard.png";
                                else
                                    $source="img/standardc.png";
                            echo "<div class=\"post-container\">                
                                    <div class=\"post-thumb\"><img src=\"".$source."\" /></div>
                                    <div class=\"post-content\">
                                        <h3 class=\"post-title\">".getQuery($conn,'Select nume from detinator where id like '.$id)."</h3>
                                        <p>Type : ".$type."</p>
                                        <p>Collection Size : ".getQuery($conn,'Select count(*) from artefact where id_detinator like '.$id)." </p>
                                        <a href=\"detinator.php?id=".$id."\" class=RMButton><span> Read More </span></a>
                                    </div>
                                </div>";
                        }
                        $UpperID--;
                        $LowerID--;
                        if($UpperID==0)
                            break;
                        $id=getQuery($conn,'Select min(detinator.id) from detinator'.$filter[$i].' and detinator.id>'.$id);
                    }
                    if($UpperID==0)
                        break;
                }
         
         if ($auxLower > 0)
           echo "    <form action=\"\">
                        <input type=\"submit\" value=\"Previous\" />
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($auxLower-5)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($auxUpper-5)."\"/>
                        ".$s."
                     </form>";
         if ($auxUpper < $all)
           echo "    <form action=\"\">
                        <input type=\"submit\" value=\"Next\" />
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($auxLower+5)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($auxUpper+5)."\"/>
                        ".$s."
                     </form>";
        
        ?>
      </article id=articol3>
      <article >
        
		<?php
        echo "    <form action=\"\">
                        <input type=\"submit\" value=\"Search\" />
                        <input type=\"text\" name=\"search\" id=\"search\" ><br/>
                        
                     </form>";
        
        ?>
        <h3>Recently Searched</h3>
        <p class=filler><a href="notfound.php">BattleAxe of Olaf The Mighty</a></p>
		<p class=filler><a href="notfound.php">Spear of Thetzuo</a></p>
		<p class=filler><a href="notfound.php">Pterodactyl tibia</a></p>
		<p class=filler><a href="notfound.php">Golden Trojan calice</a></p>
        <h2 class=AtricleTitle>Tags</h2>
            <p>Muzeu</p>
            <p>Colectionar</p>
            <p>"Nume Muzeu/Colectionar"</p>
            <p>"Nume Artefact detinut/expus</p>
        </article>
        </section>

  </body>
</html>
