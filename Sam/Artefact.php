<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1">
        <title>Artifacty</title>
    <link rel="stylesheet" 
           type="text/css" 
           href="artefact.css" />
    </head>
	<body>
	    <header class="banner"></header>
        <header id=menubar>
            <a href="Artefacte.html" class=Button><span> Artefacts </span></a>
            <a href="#" class=Button><span> Archaeologists </span></a>
            <a href="#" class=Button><span> Sites </span></a>
            <a href="#" class=Button><span> Museums </span></a>
            <a href="#" class=Button><span> Admin </span></a>
        </header>
		<div id=mainbody>
			<div id=top>
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
                $instr=oci_parse($conn,'Select nume,id_detinator,id_arheolog,id_locatie from artefact where id='.$_GET['id']);
                oci_execute($instr);
                $row=oci_fetch_array($instr);
                $instr=oci_parse($conn,'SELECT material,perioada,data_descoperire,rol,valoare_est from caracteristici where id_artefact='.$_GET['id']);
                oci_execute($instr);
                $caracteristici=oci_fetch_array($instr);
                $instr=oci_parse($conn,'SELECT t.nume from tipologie t join incadrare i on i.id_tipologie=t.id join artefact a on a.id=i.id_artefact
                where a.id='.$_GET['id']);
                oci_execute($instr);
                $tipologie=oci_fetch_array($instr);
                $instr=oci_parse($conn,'SELECT count(*) from tipologie t join incadrare i on i.id_tipologie=t.id join artefact a on a.id=i.id_artefact
                where a.id='.$_GET['id']);
                oci_execute($instr);
                $numarrr=oci_fetch_array($instr);
                $instr=oci_parse($conn,'Select nume from detinator where id='.$row[1]);
                oci_execute($instr);
                $nume=oci_fetch_array($instr);
                $instr=oci_parse($conn,'Select nume from arheolog where id='.$row[2]);
                oci_execute($instr);
                $arheolog=oci_fetch_array($instr);
                $instr=oci_parse($conn,'SELECT tara,oras,nume_sit from locatie where id='.$row[3]);
                oci_execute($instr);
                $locatie=oci_fetch_array($instr);
                if($numarrr[0]==0)
                    $tip='. Nu se incadreaza niciunei tipologii la momentul actual.';
                else
                    $tip='. Se incadreaza urmatoarei tipologii: '.$tipologie[0].".";
                if(file_exists("sami/artefact".$_GET['id'].".jpg"))
                    $imagine="sami/artefact".$_GET['id'].".jpg";
                else
                    $imagine="sami/artefact.png";
                echo  "<img src=\"".$imagine."\">
				<h1>".$row[0]."</h1>
                <p class=\"change\">Artefactul a fost descoperit la data de ".$caracteristici[2]." de catre ".$arheolog[0].".Situl arheologic in care a fost gasit 
                se numeste ".$locatie[2].",localizat in ".$locatie[0].".</p>
                <p class=\"change\">".$row[0]." este datat in perioada  ".$caracteristici[1].",intrebuintarea lui fiind de ".$caracteristici[3].".Materialul din care este confectionat
                este ".$caracteristici[0].",fiind estimat la o valoare de \"".$caracteristici[4]."\"".$tip."</p>
				<p class=\"change\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut justo ultrices, tempus sem sodales, consequat est. Duis facilisis eu odio lobortis auctor. Curabitur faucibus at libero id cursus. Nunc elementum justo tincidunt lectus viverra lobortis. Quisque ac nisl in elit euismod gravida. Fusce nec ipsum elit. Vestibulum dictum efficitur finibus. Nulla varius sem in orci ornare convallis. Aliquam dignissim id augue a cursus. Nam quis elementum est, at placerat dolor.</p>

					<p class=\"change\">Sed in finibus ipsum, nec elementum risus. Nullam sodales imperdiet euismod. Pellentesque sed cursus nibh. Duis sit amet mi sit amet urna gravida sagittis. Aliquam erat volutpat. Donec ut luctus ante. Etiam in elit ut sem malesuada scelerisque sed vehicula augue. Phasellus quis mattis turpis. Curabitur elementum, enim nec elementum elementum, turpis magna lacinia ligula, commodo mattis tellus metus at lectus. Mauris feugiat metus metus, nec semper eros pulvinar sit amet. Fusce congue erat libero, eu vestibulum purus fermentum sed. Vivamus ac malesuada tellus. Mauris egestas libero viverra diam rhoncus luctus.</p>

					<p class=\"change\">Nunc mauris enim, semper quis tempor vel, suscipit id massa. In ullamcorper ipsum mi, quis placerat dui feugiat ut. Integer molestie mi vel magna ullamcorper, sit amet bibendum massa dapibus. Sed rhoncus varius ligula, vel sollicitudin enim. Phasellus pharetra id lectus vitae feugiat. Praesent tempus mi viverra pellentesque feugiat. Donec iaculis scelerisque enim vel condimentum. Vivamus malesuada dictum dui, sed tempor nibh suscipit ut. Aenean scelerisque velit in justo porta, et convallis elit convallis. Proin vel euismod sem, eu vestibulum lectus.</p>

					<p class=\"change\">Suspendisse vulputate dolor in metus commodo pretium. Curabitur et tincidunt nisi, eu faucibus metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas blandit imperdiet erat, a placerat augue luctus id. Quisque vel orci dapibus, viverra felis vel, ullamcorper mauris. Nunc maximus tempus maximus. Aliquam ac suscipit lorem. Aliquam et finibus ex, a ultrices enim. Vivamus volutpat urna id efficitur laoreet. Quisque purus mauris, imperdiet a egestas a, varius ac nulla. Suspendisse arcu lorem, volutpat nec purus a, finibus sodales erat. Vivamus congue dapibus felis, sed finibus quam placerat nec.</p>

					<p class=\"change\">Mauris aliquam dictum metus, quis ultrices nibh tristique ut. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque vitae risus lacinia, dignissim arcu sit amet, vestibulum felis. Nullam non ornare metus. Vestibulum porttitor, magna eu pellentesque accumsan, turpis nisl dapibus ligula, vel mattis nisi purus eu eros. In non tellus justo. Vivamus aliquet tempor est nec porttitor. Aenean non enim dolor. Phasellus sed egestas nibh. Morbi blandit tincidunt tellus id cursus. Ut ultrices nisi nec ante rhoncus rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean at tempus tellus. Nam sodales vestibulum purus, a iaculis massa vehicula vel. Aenean dignissim ligula sed erat iaculis, ut varius libero pellentesque.</p>
				<p class=\"clear\">Now in display at <a href=\"Detinator.html?id=".$row[1]."\">".$nume[0]."</a> museum.</p>
			</div>
			<hr>
			<div id=bottom>
				<div id=stanga>
					<h1>".$arheolog[0]."</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut justo ultrices, tempus sem sodales, consequat est. Duis facilisis eu odio lobortis auctor. Curabitur faucibus at libero id cursus. Nunc elementum justo tincidunt lectus viverra lobortis. Quisque ac nisl in elit euismod gravida. Fusce nec ipsum elit. Vestibulum dictum efficitur finibus. Nulla varius sem in orci ornare convallis. Aliquam dignissim id augue a cursus. Nam quis elementum est, at placerat dolor.</p>

					<p>Sed in finibus ipsum, nec elementum risus. Nullam sodales imperdiet euismod. Pellentesque sed cursus nibh. Duis sit amet mi sit amet urna gravida sagittis. Aliquam erat volutpat. Donec ut luctus ante. Etiam in elit ut sem malesuada scelerisque sed vehicula augue. Phasellus quis mattis turpis. Curabitur elementum, enim nec elementum elementum, turpis magna lacinia ligula, commodo mattis tellus metus at lectus. Mauris feugiat metus metus, nec semper eros pulvinar sit amet. Fusce congue erat libero, eu vestibulum purus fermentum sed. Vivamus ac malesuada tellus. Mauris egestas libero viverra diam rhoncus luctus.</p>

					<p>Nunc mauris enim, semper quis tempor vel, suscipit id massa. In ullamcorper ipsum mi, quis placerat dui feugiat ut. Integer molestie mi vel magna ullamcorper, sit amet bibendum massa dapibus. Sed rhoncus varius ligula, vel sollicitudin enim. Phasellus pharetra id lectus vitae feugiat. Praesent tempus mi viverra pellentesque feugiat. Donec iaculis scelerisque enim vel condimentum. Vivamus malesuada dictum dui, sed tempor nibh suscipit ut. Aenean scelerisque velit in justo porta, et convallis elit convallis. Proin vel euismod sem, eu vestibulum lectus.</p>

					<p>Suspendisse vulputate dolor in metus commodo pretium. Curabitur et tincidunt nisi, eu faucibus metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas blandit imperdiet erat, a placerat augue luctus id. Quisque vel orci dapibus, viverra felis vel, ullamcorper mauris. Nunc maximus tempus maximus. Aliquam ac suscipit lorem. Aliquam et finibus ex, a ultrices enim. Vivamus volutpat urna id efficitur laoreet. Quisque purus mauris, imperdiet a egestas a, varius ac nulla. Suspendisse arcu lorem, volutpat nec purus a, finibus sodales erat. Vivamus congue dapibus felis, sed finibus quam placerat nec.</p>

					<p>Mauris aliquam dictum metus, quis ultrices nibh tristique ut. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque vitae risus lacinia, dignissim arcu sit amet, vestibulum felis. Nullam non ornare metus. Vestibulum porttitor, magna eu pellentesque accumsan, turpis nisl dapibus ligula, vel mattis nisi purus eu eros. In non tellus justo. Vivamus aliquet tempor est nec porttitor. Aenean non enim dolor. Phasellus sed egestas nibh. Morbi blandit tincidunt tellus id cursus. Ut ultrices nisi nec ante rhoncus rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean at tempus tellus. Nam sodales vestibulum purus, a iaculis massa vehicula vel. Aenean dignissim ligula sed erat iaculis, ut varius libero pellentesque.</p>
				
				</div>";
                
                if(file_exists("sami/arheolog".$row[2].".jpg"))
                    $imagine="sami/arheolog".$row[2].".jpg";
                else
                    $imagine="sami/arheolog.jpg";
                echo "
				<div id=dreapta>
					<img src=\"".$imagine."\">
					<h3>Details about the discovery</h3>
					<p>Discovered in <a href=locatie.php?id=".$row[3].">".$locatie[0].','.$locatie[1]."</a> la \"".$locatie[2]."\".</p>
					<h3>Other discoveries</h3>
					<div id=descoperiri>";
                $total=getQuery($conn,'select count(*) from artefact where id_arheolog='.$row[2]);
                if ($total>1){
                    $instr=oci_parse($conn,'Select id,nume from artefact where id!='.$_GET['id']."and id_arheolog=".$row[2]);
                    oci_execute($instr);
                    while ($row = oci_fetch_array($instr)) {
                        echo "<a href=Artefact.html?id=".$row[0].">".$row[1]."</a>";
                    }
                 }
                 else
                    echo "<a>No other artefacts discovered!</a>";
                
                echo "</div>
				</div>
				<p class=\"clear\">Check <a href=arheolog.html?id=".$row[2].">".$arheolog[0]."</a>'s page too!</p>";
                ?>
			</div> 
		</div>
		<footer id=foot>
			<div id=down>
				<a href="Artefacte.html">Artefacts</a> | <a href="#">Archaeologists</a> | <a href="#">Sites</a> | <a href="#">Museums</a>
			</div>
		</footer>
	</body>
</html>
