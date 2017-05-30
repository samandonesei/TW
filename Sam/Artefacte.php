<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1">
        <title>Artifacty</title>
    <link rel="stylesheet" 
           type="text/css" 
           href="artefacte.css" />
    </head>
    <body>
        <header class="banner">
        </header>
        <header id=menubar>
            <a href="Artefacte.html" class=Button><span> Artefacts </span></a>
            <a href="#" class=Button><span> Archaeologists </span></a>
            <a href="#" class=Button><span> Sites </span></a>
            <a href="#" class=Button><span> Museums </span></a>
            <a href="#" class=Button><span> Admin </span></a>
        </header>
        <div id=mijloc>
          <h1>Artefacts</h1>
          <?php
            $conn = oci_connect('TW', 'TW', 'localhost/XE');
            if (!$conn){
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                exit();
                }
                
            echo "<form id=search>
                    <input type=\"text\" name=\"search\" placeholder=\"Search..\">
                    <input type=\"submit\" value=\"Search\">
                    <div class=\"scroller\">
                        <button id=sortby>Sort by</button>
                        <div class=\"optiuni\">
                            <a href=\"Artefacte.html?Sort=year\">Year Found asc</a>
                            <a href=\"Artefacte.html?Sort=yeard\">Year Found desc</a>
                            <a href=\"Artefacte.html?Sort=AZ\">A-Z</a>
                            <a href=\"Artefacte.html?Sort=ZA\">Z-A</a>
                        </div>
                    </div>
                  </form>"
          ?>
          <ul id=lista>
          <?php
            $conn = oci_connect('TW', 'TW', 'localhost/XE');
            if (!$conn){
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                exit();
            }
            if(isset($_GET['search'])){
                $where='%'.$_GET['search'].'%';
                $input="<input type=\"hidden\" name=\"search\" value=\"".$_GET['search']."\"/>";
            }
            else{
                $where='%';
                $input="";
            }
            if(isset($_GET['Sort'])){
                if($_GET['Sort']=='year'){
                    $order=' order by data_descoperire ';
                    $join=' join caracteristici on artefact.id=caracteristici.id_artefact ';
                    $sort="<input type=\"hidden\" name=\"Sort\" value=\"".$_GET['Sort']."\"/>";
                }
                if($_GET['Sort']=='yeard'){
                    $order=' order by data_descoperire desc ';
                    $join=' join caracteristici on artefact.id=caracteristici.id_artefact ';
                    $sort="<input type=\"hidden\" name=\"Sort\" value=\"".$_GET['Sort']."\"/>";
                }
                if($_GET['Sort']=='AZ'){
                    $order=' order by nume asc ';
                    $join='';
                    $sort="<input type=\"hidden\" name=\"Sort\" value=\"".$_GET['Sort']."\"/>";
                }
                if($_GET['Sort']=='ZA'){
                    $order=' order by nume desc ';
                    $join='';
                    $sort="<input type=\"hidden\" name=\"Sort\" value=\"".$_GET['Sort']."\"/>";
                }
            }
            else{
                $order=' order by id ';
                $join='';
                $sort="";

            }
            function getQuery($conn,$query){
                $instruction = oci_parse($conn, $query);
                oci_execute($instruction);
                return oci_fetch_array($instruction)[0];
                }
            $number=getQuery($conn,'Select count(*) from artefact');
            if (isset($_GET['MIN'])) {
                    $MIN = $_GET['MIN'];
                    $MAX = $_GET['MAX'];
                }
            else{
                $MIN=0;
                $MAX=10;
            }
            $intermediar=$MIN-1;
            $contor=1;
            $sql="select * from ( select /*+ FIRST_ROWS(n) */ a.*, ROWNUM rnum from ( SELECT * FROM ARTEFACT ".$join." 
            where nume like :sam ".$order." ) a where ROWNUM <=".$MAX.") where rnum  > ".$MIN;
            $instruction=oci_parse($conn,$sql);
            $whr=$where;
            oci_bind_by_name($instruction, ":sam", $whr);
            oci_execute($instruction);
            //oci_fetch_all($instruction, $res);
    //oci_execute($instruction);
       
            $numar=oci_parse($conn,"select count(*) from ( select /*+ FIRST_ROWS(n) */ a.*, ROWNUM rnum from ( SELECT * FROM ARTEFACT ".$join."where nume like :sam ".$order." ) a where ROWNUM <=".$MAX.") where rnum  > ".$MIN);
            oci_bind_by_name($numar,":sam",$whr);
            oci_execute($numar);
            
            $linie=oci_fetch_array($numar);
            if($linie[0]==0)
            {
                echo "<p id=mijj>NO DATA FOUND</p>";
            }
            else{
            while ($row = oci_fetch_array($instruction)) {
                if(file_exists("sami/artefact".$row[0].".jpg"))
                    $imagine="sami/artefact".$row[0].".jpg";
                else
                    $imagine="sami/artefact.png";
                $instr=oci_parse($conn,"select data_descoperire,valoare_est from caracteristici where id_artefact=".$row[0]);
                oci_execute($instr);
                $caracteristici=oci_fetch_array($instr);
                 echo "<li class="."artefact".">
                <img src=".$imagine." />
                <h3>".$row[1]."</h3>
                <p>Date discovered:".$caracteristici[0].",Est. value:".$caracteristici[1].".</p>
				<a href=artefact.html?id=".$row[0]." class=More>More Details</a>
            </li>";
                $contor=$contor+1;
            }}
            oci_free_statement($instruction);
            oci_close($conn);
        ?>
          </ul>
          <?php
            echo "<div id=MoveButtons>";
            $conn = oci_connect('TW', 'TW', 'localhost/XE');
                   
            $numar=oci_parse($conn,"select count(*) FROM ARTEFACT ".$join. " where nume like :sam ".$order);
            oci_bind_by_name($numar,":sam",$whr);
            oci_execute($numar);
            $number=oci_fetch_array($numar)[0];
            
            $intermediar=$MIN-1;
            $pagini=intval($number/10);
            $intermediar2=$MAX;
            $last=$pagini;
            $max=$number-10;
            $paginimax=$last-($MIN/10 +1);
            if($pagini>6 )
                $pagini=5;
            if($paginimax<5)
                $pagini=$paginimax;
                           
            $i=1;
            if($number!=0){
            if ($intermediar > 0){
                echo "<form action=\"\">
                        <input type=\"submit\" class=\"MoveBut dir\" value=\"First\" />
                        <input type=\"hidden\" name=\"MIN\" value=\"".(0)."\"/>
                        <input type=\"hidden\" name=\"MAX\" value=\"".(10)."\"/>".$input.$sort."
                     </form>";
                echo "    <form action=\"\">
                        <input type=\"submit\" class=\"MoveBut dir\" value=\"&laquo;Prev\" />
                        <input type=\"hidden\" name=\"MIN\" value=\"".($MIN-10)."\"/>
                        <input type=\"hidden\" name=\"MAX\" value=\"".($MAX-10)."\"/>".$input.$sort."
                     </form>";
                     }
            while($i<=$pagini){
                echo " <form action=\"\">
                    <input type=\"submit\" class=\"MoveBut Indexes\" value=".(($MIN/10)+$i)." />
                    <input type=\"hidden\" name=\"MIN\" value=\"".((($MIN/10)+$i)*10)."\"/>
                    <input type=\"hidden\" name=\"MAX\" value=\"".((($MIN/10)+$i)*10+10)."\"/>".$input.$sort."
                 </form>";
                $i=$i+1;
            }
            if ($intermediar2 <=  $max){
                echo "    <form action=\"\">
                        <input type=\"submit\" class=\"MoveBut dir\" value=\"Next&raquo\" />
                        <input type=\"hidden\" name=\"MIN\" value=\"".($MIN+10)."\"/>
                        <input type=\"hidden\" name=\"MAX\" value=\"".($MAX+10)."\"/>".$input.$sort."
                     </form>";
                echo "<form action=\"\">
                        <input type=\"submit\" class=\"MoveBut dir\" value=\"Last\" />
                        <input type=\"hidden\" name=\"MIN\" value=\"".($last*10-10)."\"/>
                        <input type=\"hidden\" name=\"MAX\" value=\"".($last*10)."\"/>".$input.$sort."
                     </form>";}
            }
            echo "</div>";
            ?>
        </div>
		<div id=dreapta>
			<h2>Most Recent Discoveries</h2>
            <?php
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                $interogare=oci_parse($conn,"select id,nume,data_descoperire from ( SELECT * FROM ARTEFACT join caracteristici on artefact.id=caracteristici.id_artefact ORDER BY caracteristici.data_descoperire desc ) where ROWNUM <8");
                oci_execute($interogare);
                while ($row = oci_fetch_array($interogare)){
                    echo "<a class=discoveries href=\"artefact.html?id=".$row[0]."\">".$row[1]."</a>";
                }
            ?>
			<h2>Some interesting statistics</h2>
            <?php
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                $interogare=oci_parse($conn,"select nr_artefacte('Europa') from dual");
                oci_execute($interogare);
                $row=oci_fetch_array($interogare);
                echo "<a class=functii >".$row[0]."</a>";
                
                $interogare=oci_parse($conn,"select nr_artefacte('Asia') from dual");
                oci_execute($interogare);
                $row=oci_fetch_array($interogare);
                echo "<a class=functii >".$row[0]."</a>";
                
                $interogare=oci_parse($conn,"select nr_artefacte('America de Nord') from dual");
                oci_execute($interogare);
                $row=oci_fetch_array($interogare);
                echo "<a class=functii >".$row[0]."</a>";
                
                $interogare=oci_parse($conn,"select nr_artefacte('America de Sud') from dual");
                oci_execute($interogare);
                $row=oci_fetch_array($interogare);
                echo "<a class=functii >".$row[0]."</a>";
                
                $interogare=oci_parse($conn,"select nr_artefacte('Africa') from dual");
                oci_execute($interogare);
                $row=oci_fetch_array($interogare);
                echo "<a class=functii >".$row[0]."</a>";
            ?>
			<h2>Also check our currently known tipologies</h2>
			<a href="#" id=tipologii>Tipologies</a>
		</div>
		<footer id=foot>
			<div id=down>
				<a href="Artefacte.html">Artefacts</a> | <a href="#">Archaeologists</a> | <a href="#">Sites</a> | <a href="#">Museums</a>
			</div>
		</footer>
	</body>
	</html>
