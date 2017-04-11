<!DOCTYPE html>
<html>
<body>
    <head>
        <meta charset="utf-8">
        <title> Administrare </title>
        <link rel = "stylesheet" type = "text/css" href = "Administrare.css" </link>
    </head>

   <form id=Administrare action="Administrare.php">
   <?php
        echo '<p>Selecteaza tabel<br>';
        echo '<select name="select">';
        $conn = oci_connect('TW', 'TW', 'localhost/XE');
        if (!$conn){
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            exit();
        }
        
        $selected='ARTEFACT';
        $instruction = oci_parse($conn, 'SELECT table_name from user_tables');
        oci_execute($instruction);
         while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)) {
            foreach ($row as $item) {
                if(isset($_GET['select']) and strcmp($_GET['select'],$item)==0){
                    $selected=$_GET['select'];
                    echo '<option value="'. $item .'" selected>' .$item . '</option>';
                }
                    
                else{
                    echo '<option value="'. $item .'">'.$item.'</option>';
                }
                echo $item;
            }
        }
        echo '</select>';
        echo '</p>';
        echo '<input type="submit" value="Get Table">';
   
        if (isset($_GET['LowerID'])) {
            $LowerID = $_GET['LowerID'];
            $UpperID = $_GET['UpperID'];
            $UpperID = $_GET['UpperID'];
        }
        else{        
            $LowerID = 0;
            $UpperID = 10;
        }
       
       if(isset($_GET['filter'])){
            $command = 'Select count(*) from ' . $selected .' where '. $_GET['filter'] .' like \''. $_GET['text'].'\'';
       }
       else{
           $command = 'Select count(*) from ' . $selected;
       }
       
        $instruction = oci_parse($conn, $command);
        
        oci_execute($instruction);

        $maxRows = oci_fetch_array($instruction);       
       
       if(isset($_GET['action']) and strcmp($_GET['action'],'Next')==0){
           if ($UpperID < $maxRows[0]){
                        
                        $UpperID = $UpperID+10;
                        $LowerID = $LowerID+10;
                        
                    }
       }
       if(isset($_GET['action']) and strcmp($_GET['action'],'Previous')==0){
           if ($LowerID > 0){
               $UpperID = $UpperID-10;
               $LowerID = $LowerID-10;
            }
       }
        echo '<input type="hidden" name="LowerID" value="';echo $LowerID; echo '"><br>';
        echo '<input type="hidden" name="UpperID" value="';echo $UpperID; echo '"><br>';
        
        echo 'Displaying values in interval ';
        echo '<label name="LowerID">' . $LowerID .'</label>';
        echo ' <-----> ';
        echo '<label for="UpperID">' . $UpperID .'</label><br>';
        echo 'Selected Query returned ' . $maxRows[0]. ' results';
        $instruction = oci_parse($conn,'SELECT column_name FROM USER_TAB_COLUMNS WHERE table_name = \''. $selected .'\'');
        $table = "<table border='2' <tr>\n";
        
        echo "</tr>\n </table>\n";
        echo '<p>Selecteaza coloana pe care sa fie rulat filtrul<br>'; 
        echo '<select name="filter">';
        
        $filter = '';
        
        oci_execute($instruction);
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)) {
            foreach ($row as $item) {
                $table .="    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
                if (strcmp($filter,'')==0){
                    $filter = $item;
                }
                if(isset($_GET['filter']) and strcmp($_GET['filter'],$item)==0){
                    $filter=$_GET['filter'];
                    echo '<option value="'. $item .'" selected>' .$item . '</option>';
                }
                    
                else{
                    echo '<option value="'. $item .'">'.$item.'</option>';
                }}
            $table.= "</td>\n";
        }
        echo '</select>';
        echo '</p>';
        
        if (isset($_GET["text"])){
            if(strcmp($_GET['text'],'')==0)
               $text="%";
            else
               $text=$_GET['text'];
            echo 'Text <input type="text" name="text" value="'. $_GET["text"].'"><br>';
        }
        else{
            $text="%";
            echo 'Text <input type="text" name="text" value="%"><br>';
        }
        $instruction = oci_parse($conn, 'Select * from (SELECT myTable.*,rownum as RowNumber from ' .$selected 
        . ' myTable where '. $filter .' like \''. $text.'\') where RowNumber >= ' . $LowerID .' and RowNumber <=' . $UpperID);
        oci_execute($instruction);
        echo $table;
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                
                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    ?>
    <input type="submit" class="button" name="action" value="Previous" />
    <input type="submit" class="button" name="action" value="Next" />
</form>

    <form id=Custom action="Administrare.php">
        <input type="submit" class="button" name="CurrentCursor" value="getArtefactsPer" />
        <input type="submit" class="button" name="CurrentCursor" value="distributie_arheologi.distribuire" />
        <input type="submit" class="button" name="CurrentCursor" value="best_furnizor.tara_per_muzeu" />
        <input type="submit" class="button" name="CurrentCursor" value="origine_tipologie.tara_per_tipologie" />
        
        <?php
            $currentCursor ='getArtefactsPer';
            if( isset($_GET['CurrentCursor'])){
                $currentCursor = $_GET['CurrentCursor'];
            }
            
        $conn = oci_connect('TW', 'TW', 'localhost/XE');
        if (!$conn){
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            exit();
        }
        

        $curs = oci_new_cursor($conn);
        $stid = oci_parse($conn, "begin ". $currentCursor . "(:cursbv); end;");
        oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
        oci_execute($stid);

        oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
        echo "<table border='2'";
        while ($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) {
            echo "<tr>\n";
            foreach ($row as $item) {
                echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";

        oci_free_statement($stid);
        oci_free_statement($curs);
        oci_close($conn);   
        ?>    
         
   </form>
   