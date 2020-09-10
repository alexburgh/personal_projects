<?php 

    require_once('../includes/database_handler.inc.php'); 
    
    if(filter_input(INPUT_GET, 'action') == 'export') {
        $table = filter_input(INPUT_GET, 'table');
    }

    function cleanData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);

        if(strstr($str, '"')) 
            $str = '"' . str_replace('"', '""', $str) . '"';
        }

        // filename for download
        $filename = "Tranzactii_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");

        $flag = false;
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM $table;") or die('Query failed!');
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0) {
            while($row = $stmt->fetch()) {
                if(!$flag) {
                    // display field/column names as first row
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                array_walk($row, __NAMESPACE__ . '\cleanData');
                echo implode("\t", array_values($row)) . "\r\n";
            }
            exit;
        } else {
            echo "Nu s-au gasit inregistrari!";
        }