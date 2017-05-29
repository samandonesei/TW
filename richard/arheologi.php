<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Artifacty</title>
 <link rel = "stylesheet"
   type = "text/css"
   href = "listaarhstyle2.css" />
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
		<p class=filler ><a href="notfound.php">A new archaeological site was opened under the Piramid of Keops.</a></p>
		<p class=filler ><a href="notfound.php">A African Machete was found among other war weapons on a site in China.</a></p>
      </article>
      <article id=articol2>
        <h6 class=AtricleTitle>Discover your history</h6>
        <h2 src="poze/arh7.jpg" alt="Arheolog here"/>
		
		<marquee behavior="alternate" onmousedown="this.stop();" onmouseup="this.start();">
		<div id="header">
		<img src="poze/arh1.jpg" alt="Arheolog here"/>
		<img src="poze/arh7.jpg" alt="Arheolog here"/>
		<img src="poze/arh10.jpg" alt="Arheolog here"/>
		<img src="poze/arh9.jpg" alt="Arheolog here"/>
		<img src="poze/arh11.jpg" alt="Arheolog here"/>
		<img src="poze/arh12.jpg" alt="Arheolog here"/>
		<img src="poze/arh13.jpg" alt="Arheolog here"/>
		<img src="poze/arh14.jpg" alt="Arheolog here"/>
		<img src="poze/arh15.jpg" alt="Arheolog here"/>
		</div>
		</marquee>
		<p><h6>ARCHEOLOGY IS NOT WHAT YOU FIND, IT'S WHAT YOU FIND OUT.</h6><p>
        
        <h6 class=AtricleTitle>MEET OUR ARCHAEOLOGISTS</h6>
        <?php
               $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                }
                function getQuery($conn,$query){
                    set_time_limit(50);
                    $instruction = oci_parse($conn, $query);
                    oci_execute($instruction);
                    return oci_fetch_array($instruction)[0];
                }
                
                function getPicture($gender){
                    if($gender == 1)
                        $nr = mt_rand(6,10);
                    else
                        $nr = mt_rand(1,5);
                    $picture_name = "arch_".(string)$nr;
                    
                    if ($nr == 1)
                        $picture_file = $picture_name.".gif";
                    elseif ($nr == 8)
                        $picture_file = $picture_name.".jpeg";
                    elseif ($nr == 3)
                        $picture_file = $picture_name.".png";
                    else
                        $picture_file = $picture_name.".jpg";   
                    
                    return $picture_file;
                }
        ?>

		<?php
            
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                } 
                if (isset($_GET['LowerID']) and isset($_GET['UpperID'])) {
                    $LowerID = $_GET['LowerID'];
                    $UpperID = $_GET['UpperID'];
                }
                else{        
                    $LowerID = 0;
                    $UpperID = 10;
                }
                $inf_idr = $LowerID;
                $sup_id = $UpperID;
                if(isset($_GET['search'])){
                    $condition[0] = ' WHERE nume like \'%'.$_GET['search'].'%\'';
                    $condition[1] = ' WHERE specializare LIKE \'%'.$_GET['search'].'%\'';
                    $s = "<input type=\"hidden\" name=\"search\" value=\"".$_GET['search']."\"/>";
                }
                else{
                    $condition[0] = ' WHERE 1=1';
                    $s = "";
                }
                
                $total_nr_records=0;
                for($i=0; $i < count($condition); $i++){
                   $nr_records = getQuery($conn,'SELECT count(*) FROM arheolog'.$condition[$i]); 
                   
                   if($nr_records != 0)
                    $id = getQuery($conn,'SELECT min(id) FROM arheolog'.$condition[$i]);
                   else 
                       continue;
 
                   $total_nr_records += $nr_records;
                   while($nr_records--){
                        $type = getQuery($conn,"SELECT CASE WHEN substr(nume,1,instr(nume,' ')-1) like '%a' THEN 1 ELSE 0 END FROM arheolog WHERE id = ".$id);
                        $string_type = (string)$type;
                        $string_id = (string)$id;

                        if($LowerID <= 0){

                            $image_path = "poze/".getPicture($type);
                           
                            echo "<div class=\"post-container\">                
                                    <div class=\"post-thumb\"><img src=\"".$image_path."\" /></div>
                                        <h4>".getQuery($conn,'SELECT nume FROM arheolog WHERE id ='.$id)."</h4> 
                                        <h5>Specialization : ".getQuery($conn,'SELECT specializare FROM arheolog WHERE rownum < 2 AND id ='.$id)."</h5>
                                        <h5>Number of discoveries : ".getQuery($conn,'SELECT count(*) FROM artefact WHERE id_arheolog = '.$id)." </h5>
                                        <a href=\"arheologFinal.php?id=".$id."&image=".$image_path."\" class=RMButton><span> Personal Page </span></a>
                                </div>";
                        }
                        $UpperID--;
                        $LowerID--;
                        if($UpperID == 0)
                            break;
                        $id=getQuery($conn,'Select min(arheolog.id) from arheolog'.$condition[$i].' and arheolog.id>'.$id);
                    }
                    if($UpperID == 0)
                        break;
                }
         
        if ($inf_idr > 0)
            echo    " <form action=\"\">
                        <button class = \"button2\" name=\"subject\" type=\"submit\" value=\"Previous\" >Previous Page</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($inf_idr - 10)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($sup_id - 10)."\"/>
                        ".$s."
                     </form>";
            
            //pag 1
            echo    " <form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">1</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".(0)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".(10)."\"/>
                        ".$s."
                     </form>";
                     
            if( 20 < $total_nr_records) //pag 2
            echo    " <form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">2</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".(10)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".(20)."\"/>
                        ".$s."
                     </form>";
            
            //pagini intermediare
            
            if( $sup_id > 30) // nu af pt pag 1,2,3
            if ($total_nr_records > 30){ 
                $page1 = intval($sup_id/10) - 1;
            echo    "<form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">$page1</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($inf_idr - 10)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($sup_id - 10)."\"/>
                        ".$s."
                     </form>";
            }
            
            if( $sup_id > 20) 
            if ( $sup_id!= $total_nr_records and $total_nr_records > 20 and $sup_id < $total_nr_records){
            $page1 = intval($sup_id/10);
            echo    " <form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">$page1</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($inf_idr)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($sup_id)."\"/>
                        ".$s."
                     </form>";
            }
            
            if( $sup_id < $total_nr_records - 10 and $sup_id > 10)
            if ( $sup_id != $total_nr_records and $total_nr_records > 20 ) {
            $page1 = intval($sup_id/10) + 1;
            echo    " <form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">$page1</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($inf_idr + 10)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($sup_id + 10)."\"/>
                        ".$s."
                     </form>";
            }       
                     
            //pag finala
            if ( $total_nr_records > 10 ){         
                $final_page = intval($total_nr_records/10);
                $max_final_page = $total_nr_records;
                $min_final_page = $final_page * 10;
                
                if($min_final_page == $max_final_page){
                    $min_final_page -= 9;
                }
                echo    " <form action=\"\">
                        <button class = \"button3\" name=\"subject\" type=\"submit\" value=\"\">$final_page</button>
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($min_final_page)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($max_final_page)."\"/>
                        ".$s."
                        </form>";
            }
                     
            
            
            
         if ($sup_id < $total_nr_records)
           echo "    <form action=\"\">
                        <button class = \"button1\" name=\"subject\" type=\"submit\" value=\"Next\" >Next Page</button>         
                        <input type=\"hidden\" name=\"LowerID\" value=\"".($inf_idr + 10)."\"/>
                        <input type=\"hidden\" name=\"UpperID\" value=\"".($sup_id + 10)."\"/>
                        ".$s."
                     </form>";
                      /* <h2 class=AtricleTitle>Search</h2>  */
                          
        ?>
      </article id=articol3>
      <article >
        
		<?php
        echo "    <form action=\"\">
                        <h2><button class = AtricleTitle input type=\"submit\" value=\"Search\" />SEARCH</button></h2>
                        <input type=\"text\" name=\"search\" id=\"search\" ><br/>
                        
                     </form>";
                    /* <h2 button class = AtricleTitle input type=\"submit\" value=\"Search\" />Search</h2> */
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