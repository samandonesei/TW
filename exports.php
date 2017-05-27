<?php
    function drop_table($conn,$table_name){
        $instruction = oci_parse($conn,'Delete from '. $table_name .' where 1=1');
        oci_execute($instruction);
    }
    function export_table_csv($conn,$table_name){
        $fp = fopen('ExportedTables\\'.$table_name.'.csv', 'w');
        $instruction = oci_parse($conn,'SELECT column_name FROM USER_TAB_COLUMNS WHERE table_name = \''. $table_name .'\'');
      
        oci_execute($instruction);
        $names = array();
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $l)
                $names []=$l;
        }
        
        fputcsv($fp,$names);
            
        $instruction = oci_parse($conn,'SELECT * from '. $table_name .'');
        oci_execute($instruction);
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS))
                fputcsv($fp, $row);
        fclose($fp);
    }
    function export_table_json($conn,$table_name){
        $instruction = oci_parse($conn,'SELECT * from '. $table_name .'');
            $fp = fopen('ExportedTables\\'.$table_name.'.json', 'w');
            oci_execute($instruction);
            $values=array();
            while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)){
                $column= array();
                foreach($row as $item)
                    $column[] = $item;
                $values[]=$column;
            }
            fwrite($fp, json_encode($values));
        fclose($fp);
     }
    function export_table_xml($conn,$table_name){
        $fp = fopen('ExportedTables\\'.$table_name.'.xml', 'w');
        
        $instruction = oci_parse($conn,'SELECT column_name FROM USER_TAB_COLUMNS WHERE table_name = \''. $table_name .'\'');
      
        oci_execute($instruction);
        $names = array();
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)){
            foreach ($row as $l)
                $names []=$l;
        }
        
        $instruction = oci_parse($conn,'SELECT * from '. $table_name .'');
        
        oci_execute($instruction);
        $values='<?xml version="1.0" encoding="utf-8"?>'."\n";
        $values .= "<content>\n";
        $nr='a';
        
        
        while ($row = oci_fetch_array($instruction, OCI_ASSOC+OCI_RETURN_NULLS)){
          
            $column="\t<$nr>\n";
            $rowNR=0;
            foreach($row as $item){
                $column .= "\t\t<$names[$rowNR]>$item</$names[$rowNR]>\n";
                $rowNR++;
            }
            $values.=$column."\t</$nr>\n";
            $nr++;
        }
        $values .= "</content>\n";
        fwrite($fp, $values);
        fclose($fp);
    }
    function import_table_xml($conn,$table_name){
        $string = file_get_contents('ExportedTables\\'.$table_name.'.xml');
        $xml = simplexml_load_string($string, "SimpleXMLElement", LIBXML_PARSEHUGE);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        foreach($array as $entry){
            $values="(";
            foreach($entry as $row){
                $values.='\''.$row.'\',';
            }
            $values[strlen($values)-1]=')';
            $instruction='Insert into '.$table_name.' values '.$values;
            oci_execute(oci_parse($conn,$instruction));
        }    
        }
    function import_table_json($conn,$table_name){
        $string = file_get_contents('ExportedTables\\'.$table_name.'.json');
        $myJson = json_decode($string, true);
        foreach($myJson as $entry){
            $values="(";
            foreach($entry as $row){
                $values.='\''.$row.'\',';
            }
            $values[strlen($values)-1]=')';
            $instruction='Insert into '.$table_name.' values '.$values;
            oci_execute(oci_parse($conn,$instruction));
        }
    }
    function import_table_csv($conn,$table_name){
      
        $File = 'ExportedTables\\'.$table_name.'.csv';

        $arrResult  = array();
        $handle     = fopen($File, "r");
        if(empty($handle) === false) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $arrResult[] = $data;
            }
            fclose($handle);
        }
        $first = true;
        foreach($arrResult as $entry){
            if($first==true){
                $first=false;
                continue;
            }
            $values="(";
            foreach($entry as $row){
                $values.='\''.$row.'\',';
            }
            $values[strlen($values)-1]=')';
            $instruction='Insert into '.$table_name.' values '.$values;
            oci_execute(oci_parse($conn,$instruction));
        }
    }
    $conn = oci_connect('TW', 'TW', 'localhost/XE');
    if (!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        exit();
    }

    /*
    export_table_csv($conn,"CARACTERISTICI");
    drop_table($conn,"Caracteristici");
    import_table_csv($conn,"Caracteristici");
    */
    /*
    export_table_json($conn,"Caracteristici");
    drop_table($conn,"Caracteristici");
    import_table_json($conn,"Caracteristici");
    */
    /*
    drop_table($conn,"Caracteristici");
    import_table_xml($conn,"Caracteristici");
    
    export_table_xml($conn,"CARACTERISTICI");
    */
?>