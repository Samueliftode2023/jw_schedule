<?php

    function check_table($conectareDB){
        $tableName = $_SESSION['username'] . '_teritorii';
        $query = "SHOW TABLES LIKE '" . $tableName . "'";
        $result = mysqli_query($conectareDB, $query);

        if (mysqli_num_rows($result) > 0) {
            return false;
        } 
        else{
            return true;
        }
    }

    function execute_teritorii($name, $link, $embed, $details, $conectareDB){
        $name = InlocuireCharactere(mysqli_real_escape_string($conectareDB, $name));
        $link = InlocuireCharactere(mysqli_real_escape_string($conectareDB, $link));
        $embed = InlocuireCharactere(mysqli_real_escape_string($conectareDB, $embed));
        $details = InlocuireCharactere(mysqli_real_escape_string($conectareDB, $details));

        $name_table = $_SESSION['username'] . '_teritorii';
        $verifica_dublurile = [$name, $link, $embed];
        $cap_tabel = ['nume', 'link', 'embed'];

        for ($i=0; $i < count($verifica_dublurile); $i++) { 
            $sql = 'SELECT * FROM '.$name_table.' 
                    WHERE ' . $cap_tabel[$i] . ' = "' . $verifica_dublurile[$i] . '"';
            $result = mysqli_query($conectareDB, $sql);
            if(mysqli_num_rows($result) > 0){
                echo 'Acest teritori apare deja in baza de date! 
                Problema la - ' . $cap_tabel[$i] . '.';
                return false;
            }
            if(strlen($verifica_dublurile[$i]) < 1){
                echo 'Camp necompletat! 
                Problema la - ' . $cap_tabel[$i] . '.';
                return false;  
            }
        }

        $columns = "nume, link, embed, detalii, status";
        $value = "'" . $name . "','" . $link . "','"
                . $embed . "','" . $details . "'," . "'inactiv'";
        insert_data($conectareDB, $name_table, $columns, $value);

        read_table_teritorii($conectareDB);
    }

    function read_table_teritorii($conectareDB){
        $name_table = $_SESSION['username'] . '_teritorii';
        $array_tabel = [];
        $sql = 'SELECT * FROM ' . $name_table . ';';
        $result = mysqli_query($conectareDB, $sql);
    
        if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $array_tabel[] = [
                    'id' => $row['id'],
                    'nume' => $row['nume'],
                    'link' => $row['link'],
                    'embed' => $row['embed'],
                    'detalii' => $row['detalii'],
                    'status' => $row['status']
                ];
            }
            $criptare = json_encode($array_tabel);
            echo $criptare;
        }
        else{
            echo '<div class="centrare-mesaj">Tabel gol</div>';
        }
    }

    function create_table($conectareDB){
        $name_tabel = $_SESSION['username'] . '_teritorii';

        $sql = "
        CREATE TABLE ".$name_tabel." (
            id int(60) AUTO_INCREMENT PRIMARY KEY,
            nume VARCHAR(255) NOT NULL,
            link VARCHAR(255) NOT NULL,
            embed VARCHAR(255) NOT NULL,
            detalii VARCHAR(255) NOT NULL,
            status VARCHAR(255) NOT NULL
        )";

        if(!mysqli_query($conectareDB, $sql)){
            echo 'Am intampinat o eroare! Te rugam sa reincarci pagina!';
        }
    }


?>