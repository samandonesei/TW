<html>
<body>
<?php
    $conn = oci_connect('TW', 'TW', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
	$comand = 'begin
	artefact_administration.updateArtefact(' . '\'' .$_GET['NameField']. '\'' . ','
	.'\''.$_GET['ArheologField'].'\''.','
	.'\''.$_GET['LocationField'].'\''.','
	.'\''.$_GET['ColorField'].'\''.','
	.'\''.$_GET['MaterialField'].'\''.','	
	.'\''.$_GET['TimeField'].'\''.','	
	.$_GET['FoundDateField'].','
	.'\''.$_GET['RolField'].'\''.','
	.'\''.$_GET['ValueField'].'\''.','
	.'\''.$_GET['DetainField'].'\''.','
	.'\''.$_GET['TypoField']. '\') ;end; ';
    $instruction = oci_parse($conn, $comand);
    oci_execute($instruction);
	ECHO "ARTEFACT SUCESFULL ALTERED";
?>
</body>
</html> 
