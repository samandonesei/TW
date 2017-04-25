<html>
	<head>
		<meta charset="utf-8">
		<title> <?php echo $_GET['id'] ?></title>
		<link rel = "stylesheet" type = "text/css" href = "continent.css" </link>
	</head>
            
        <body>
            
            <?php
                function isDotGood($x,$y){
                    $image = imagecreatefrompng("img/" . $_GET['id'] .".png\"");
                    $rgb = imagecolorat($image, $x, $y);   
                    $r = ($rgb >> 16) & 0xFF;
                    if ($r == 254)
                        return true;
                    return false;
                }
                function getNumberOfSites(){
                    $conn = oci_connect('TW', 'TW', 'localhost/XE');
                    if (!$conn){
                        $e = oci_error();
                        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                        exit();
                    }
                    $instruction = oci_parse($conn, 'Select count(id) from locatie where continent like :continent');
                    oci_bind_by_name($instruction,':continent',$_GET['id']);
                    oci_execute($instruction);
                    
                    return oci_fetch_array($instruction)[0];
                }
                function getNumberOfArheolog(){
                    $conn = oci_connect('TW', 'TW', 'localhost/XE');
                    if (!$conn){
                        $e = oci_error();
                        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                        exit();
                    }
                    $instruction = oci_parse($conn, 'Select count(a.id) from Arheolog a join locatie l on a.id_locatie=l.id and l.continent like :continent');
                    oci_bind_by_name($instruction,':continent',$_GET['id']);
                    oci_execute($instruction);
                    
                    return oci_fetch_array($instruction)[0];
                }
                
                function generateDots(){
                    $size = getimagesize("img/".$_GET['id'].".png");
                    $width = $size[0]-1;
                    $height = $size[1]-1;
                
                        
                    $number=getNumberOfSites();
                    if ($number>150)
                        $number=150;
                    
                    while($number){
                        do{
                            $x=rand(0,$width);
                            $y=rand(0,$height);
                        }
                        while(!isDotGood($x,$y));
                        echo "\n<style>";
                        echo "#Dot" . $number."{";
                        echo "
                                   position: absolute;
                                   width: 10;
                                   height: auto;
                                   left: " .intval($x/2) . "px;
                                   top: " .intval($y/2) ."px;
                                   z-index: 2;
                                   color :red;
                                   font: italic bold 30px/30px Georgia, serif;
                        }</style>";
                            echo "<a href=Locatie.php?id=".$number.">";
                                echo "<text id='Dot". $number. "'/> .";
                            echo "</a>";
                        
                        $number=$number-1;
                    }
                }
                echo "<div class=\"SecondContainer\">";
                    echo "<strong id=\"Titlu\">". $_GET['id'] . "</strong>";
                    echo "<br>Apasati pe unul din punctele situate pe harta <br>pentru a vedea mai multe informatii despre situl respectiv";
                    echo "<div class=\"SitesContainer\">";
                        echo "<text id=\"Sites\">" . getNumberOfSites() . " situri arheologice active la momentul actual</text>";
                    echo "</div>";
                    echo "<div class=\"ArheologContainer\">";
                        echo "<text id=\"Arheolog\">" . getNumberOfArheolog() . " arheologi prezenti pe continent la momentul actual</text>";
                    echo "</div>";
                echo "</div>";
                
                echo "<a class=\"Container\">";
                    echo "<div id=\"Continent\">";
                        echo "<a>";
                            echo "<img id=\"Continent\" src=\"img/" . $_GET['id'] .".png\">";
                        echo "</a>";
                    echo "</div>";  
                    generateDots();
                echo "</a>";
                
            ?>
        </body>
    </head>
</html>