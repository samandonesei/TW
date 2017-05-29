<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1">
        <title>Artifacty</title>
    <link rel="stylesheet" 
           type="text/css" 
           href="detinator.css" />
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
		<div id=main>
            <?php 
                $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                    }
                $instr=oci_parse($conn,'Select nume from detinator where id='.$_GET['id']);
                oci_execute($instr);
                $row=oci_fetch_array($instr);
                if(file_exists("sami/muzeu".$_GET['id'].".jpg"))
                    $imagine="sami/muzeu".$_GET['id'].".jpg";
                else
                    $imagine="sami/muzeu.jpg";
            echo "
			<div class=\"separator basic1\"><p>Welcome to ".$row[0]." museum!</p></div>
			<div class=\"descriere layout\">
				<img src=\"".$imagine."\"".">
				<h1>".$row[0]."</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ut justo ultrices, tempus sem sodales, consequat est. Duis facilisis eu odio lobortis auctor. Curabitur faucibus at libero id cursus. Nunc elementum justo tincidunt lectus viverra lobortis. Quisque ac nisl in elit euismod gravida. Fusce nec ipsum elit. Vestibulum dictum efficitur finibus. Nulla varius sem in orci ornare convallis. Aliquam dignissim id augue a cursus. Nam quis elementum est, at placerat dolor.

Sed in finibus ipsum, nec elementum risus. Nullam sodales imperdiet euismod. Pellentesque sed cursus nibh. Duis sit amet mi sit amet urna gravida sagittis. Aliquam erat volutpat. Donec ut luctus ante. Etiam in elit ut sem malesuada scelerisque sed vehicula augue. Phasellus quis mattis turpis. Curabitur elementum, enim nec elementum elementum, turpis magna lacinia ligula, commodo mattis tellus metus at lectus. Mauris feugiat metus metus, nec semper eros pulvinar sit amet. Fusce congue erat libero, eu vestibulum purus fermentum sed. Vivamus ac malesuada tellus. Mauris egestas libero viverra diam rhoncus luctus.

Nunc mauris enim, semper quis tempor vel, suscipit id massa. In ullamcorper ipsum mi, quis placerat dui feugiat ut. Integer molestie mi vel magna ullamcorper, sit amet bibendum massa dapibus. Sed rhoncus varius ligula, vel sollicitudin enim. Phasellus pharetra id lectus vitae feugiat. Praesent tempus mi viverra pellentesque feugiat. Donec iaculis scelerisque enim vel condimentum. Vivamus malesuada dictum dui, sed tempor nibh suscipit ut. Aenean scelerisque velit in justo porta, et convallis elit convallis. Proin vel euismod sem, eu vestibulum lectus.

Suspendisse vulputate dolor in metus commodo pretium. Curabitur et tincidunt nisi, eu faucibus metus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas blandit imperdiet erat, a placerat augue luctus id. Quisque vel orci dapibus, viverra felis vel, ullamcorper mauris. Nunc maximus tempus maximus. Aliquam ac suscipit lorem. Aliquam et finibus ex, a ultrices enim. Vivamus volutpat urna id efficitur laoreet. Quisque purus mauris, imperdiet a egestas a, varius ac nulla. Suspendisse arcu lorem, volutpat nec purus a, finibus sodales erat. Vivamus congue dapibus felis, sed finibus quam placerat nec.

Mauris aliquam dictum metus, quis ultrices nibh tristique ut. Interdum et malesuada fames ac ante ipsum primis in faucibus. Quisque vitae risus lacinia, dignissim arcu sit amet, vestibulum felis. Nullam non ornare metus. Vestibulum porttitor, magna eu pellentesque accumsan, turpis nisl dapibus ligula, vel mattis nisi purus eu eros. In non tellus justo. Vivamus aliquet tempor est nec porttitor. Aenean non enim dolor. Phasellus sed egestas nibh. Morbi blandit tincidunt tellus id cursus. Ut ultrices nisi nec ante rhoncus rutrum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean at tempus tellus. Nam sodales vestibulum purus, a iaculis massa vehicula vel. Aenean dignissim ligula sed erat iaculis, ut varius libero pellentesque.</p>
			</div>
            ";
            $instr=oci_parse($conn,"select t.id,t.nume from tipologie t join incadrare i on t.id=i.id_tipologie join artefact a on i.id_artefact=a.id where a.id_detinator=".$_GET['id']." group  by t.id,t.nume"   );
            oci_execute($instr);
			echo "<div class=\"separator basic2\"><p>Founded in ".rand(1950,2010).".</p> </div>
			<div class=\"tipologii layout\">
				<h2>Some of the tipologies from our museum</h2>";
            while($row=oci_fetch_array($instr)){
                if(file_exists("sami/tipologie".$row[0].".jpg"))
                    $imagine="sami/tipologie".$row[0].".jpg";
                else
                    $imagine="sami/tipologie.jpg";
            echo "
				<a href=\"a\"><img src=\"".$imagine."\"alt=\"".$row[1]."\" title=\"".$row[1]."\"></a>
				<a href=\"a\" class=\"text\">".$row[1]."</a>";}
             echo "</div>";
            ?>
			<div class="separator notbasic"><p>Some recent acquisitions</p> </div>
			<div id=news>
				<h3>X artefacts found...rejoice!</h3>
				<div id=container>
                
                <?php
                 $conn = oci_connect('TW', 'TW', 'localhost/XE');
                if (!$conn){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                    exit();
                    }
                $instr=oci_parse($conn,'Select id,nume from artefact where id_detinator='.$_GET['id'].' and rownum<4');
                oci_execute($instr);
                while($row=oci_fetch_array($instr)){
                if(file_exists("sami/artefact".$row[0].".jpg"))
                    $imagine="sami/artefact".$row[0].".jpg";
                else
                    $imagine="sami/artefact.png";
                echo "
					<div class=\"obiect\">
						<a href=\"Artefact.html?id=".$row[0]."\"><img class=\"artefacte\" src=\"".$imagine."\" title=\"".$row[1]."\"></a>
						<a href=\"Artefact.html?id=?".$row[0]."\" class=\"artefactnume\"><h4>".$row[1]."</h4></a>
						<p class=\"descriereart\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget scelerisque dui, vitae tincidunt eros.</p>
					</div>";}
                 ?>
				</div>
			</div>
			<div class="separator end"><p>Glad you visited,please come again!</p> </div>
		</div>
		<footer id=foot>
			<div id=down>
				<a href="Artefacte.html">Artefacts</a> | <a href="#">Archaeologists</a> | <a href="#">Sites</a> | <a href="#">Museums</a>
			</div>
		</footer>
	</body>
</html>
