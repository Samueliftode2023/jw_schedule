<?php
    $root = '../../../'; 
    $type_session = 'important';
    include_once $root.'included/function/php/common.php';
    include_once $root.'included/function/php/adauga-teritorii.php';
    check_session($type_session, $root, $conectareDB);
    if (isset($_POST['range-name'])) {
        execute_teritorii($_POST['range-name'], $_POST['link-name'], $_POST['map-display'], $_POST['link-info'], $conectareDB);
    }
    else if(false){
        $document = 'link.json';
        $json_content = file_get_contents($document);
        $json_content = json_decode($json_content);
        $numar_obiecte = count($json_content);

        for ($i=0; $i < $numar_obiecte; $i++) { 
            $nume = $json_content[$i]->{"Nr. teritoriu"};
            $link = $json_content[$i]->{"Link normal"};
            $map = $json_content[$i]->{"Link pentru site"};
            $info = substr($json_content[$i]->{"Nr. teritoriu"}, 0, 2);

            execute_teritorii($nume, $link, $map, $info, $conectareDB);
        }
    }
    else if(isset($_POST['check-table'])){
        if(check_table($conectareDB)){
            create_table($conectareDB);
        }
        else{
            read_table_teritorii($conectareDB);
        }
    }
    else{
        header('Location:'.$root.'');
        exit;
    }
?>