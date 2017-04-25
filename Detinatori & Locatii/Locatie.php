<html>
	<head>
		<meta charset="utf-8">
		<title> <?php echo $_GET['id'] ?></title>
		<link rel = "stylesheet" type = "text/css" href = "socatie.css" </link>
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
                echo 'Search <input type="text" name="text" value=""><br>';
                echo "<div class=\"Main\">";
                    echo "<strong> ".getQuery($conn,"Select nume_sit from locatie where id like ".$_GET['id']) ."</strong>";
                    echo "<div class=\"Arheologi\">";
                        $nrArheologi=getQuery($conn,"Select count(id) from arheolog where id_locatie like ".$_GET['id']);
                        echo "<text>".$nrArheologi." arheologi prezenti la sit</text>";
                        while($nrArheologi){
                            $id=getQuery($conn,"Select id from (Select id,rownum as rn from Arheolog where id_locatie like ".$_GET['id']. ")where rn=".$nrArheologi);
                            echo "<div class=\"Arheolog\">";
                                echo "<a href=\"Arheolog.php?id=".$id."\">";
                                    echo "<strong>". getQuery($conn,"Select nume from Arheolog where id like ".$id). "</strong>"."<br>";
                                echo "</a>";
                                echo "<text> Specializare : ". getQuery($conn,"Select specializare from Arheolog where id like ".$id)."</text>"."<br>";
                                echo "<text>".getQuery($conn,"Select count(*) from Artefact where id_arheolog=".$id)." artefacte descoperite in total</text>";
                            echo "</div>";
                            $nrArheologi=$nrArheologi-1;
                        }
                    echo "</div>";
                    echo "<div class=\"Artefacte\">";
                        $nrArtefacte=getQuery($conn,"Select count(id) from artefact where id_locatie like ".$_GET['id']);
                        echo "<text>".$nrArtefacte." artefacte au fost descoperite aici</text>";
                        while($nrArtefacte){
                            $id=getQuery($conn,"Select id from (Select id,rownum as rn from Artefact where id_locatie like ".$_GET['id']. ")where rn=".$nrArtefacte);
                            echo "<div class=\"Artefact\">";
                                echo "<a href=\"Artefact.php?id=".$id."\">";
                                    echo "<strong>". getQuery($conn,"Select nume from Artefact where id like ".$id). "</strong>"."<br>";
                                echo "</a>";
                                echo "</div>";
                            $nrArtefacte=$nrArtefacte-1;
                        }
                    echo "</div>";
                echo "</div>";
            ?>
        </body>
    </head>
</html>