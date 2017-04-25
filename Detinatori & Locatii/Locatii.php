<html>
	
	<head>
		<meta charset="utf-8">
		<title> Localizarea sit-urilor pe glob </title>
		<link rel = "stylesheet" type = "text/css" href = "locatii.css" </link>
	</head>
    
	<body>
        <a class="Continente">
            <form action="FrontPage.html">
                <input id="myButton" type=text value="<-Back" />
            </form>
            <div id="Europa">
                <a href="Continent.php?id=Europa">
                    <img id="Europa" src="img/Europa.png" />
                </a>  
            </div>
            
            <div id="Asia">
                <a href="Continent.php?id=Asia">
                    <img id="Asia" src="img/Asia.png" />
                </a>
            </div>
            
            <div id="AmericaN">
                <a href="Continent.php?id=AmericaN">
                    <img id="AmericaN" src="img/AmericaN.png" />
                </a>
            </div>
            
            <div id="Africa">
                <a href="Continent.php?id=Africa">
                    <img id="Africa" src="img/Africa.png" />
                </a>
            </div>
            
            <div id="Australia">
                <a href="Continent.php?id=Australia">
                    <img id="Australia" src="img/Australia.png" />
                </a>
            </div>
            
            <div id="AmericaS">
                <a href="Continent.php?id=AmericaS">
                    <img id="AmericaS" src="img/AmericaS.png" />
                </a>
            <div id="Compass">
                <a>
                    <img id="Compass" src="img/compass.png" />
                </a>
            </div>
            
            </div>
            <text id=myText>
            
                Statistica rapida asupra distribuirii siturilor arheologice pe glob
            
            </text>
            
            <?php
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                }
                $instruction = oci_parse($conn, 'Select continent,count(id) from locatie group by continent');
                oci_execute($instruction);
                echo "<table id=myTable>";
                echo "<tr id=myTr>
                        <td id=myTd>Continent</td>
                        <td id=myTd>Numar Situri</td>
                     </tr>";
                while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    echo "<tr id=myTr>\n";
                    foreach ($row as $item) {
                        
                        echo "    <td id=myTd>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            ?>
        </a>
        
        
    </body>

</html>