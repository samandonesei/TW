<html>
<body>
<?php
    $conn = oci_connect('twproject', 'twproject', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
	$comand = 'begin
	artefact_administration.deleteArtefact(\'' .$_GET['NameField']. '\') ;end; ';
    $instruction = oci_parse($conn, $comand);
    oci_execute($instruction);
	ECHO "ARTEFACT SUCESFULL DELETED";
?>
</body>
</html> 
