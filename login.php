<?php
    $conn = oci_connect('TW', 'TW', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }
        
    $command = 'Select administrator.login(\'' . $_GET['Username'] . '\',\'' . $_GET['Password'] . '\') from dual';
    $instruction = oci_parse($conn, $command);
    oci_execute($instruction);

    $row = oci_fetch_array($instruction);
    if($row[0]=='1'){
        echo 'Login successful';
        header("Location: administrare.php");
    }
    else{
        echo 'Login Failed';
    }
    exit();
?>