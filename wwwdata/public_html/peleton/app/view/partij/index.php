<h1>Partijen</h1>

    <?php        
        foreach($Partijen as $Partij){
            echo '<dd><a href="' . URL_BASE.'partij/view/'.$Partij->id.'">'. $Partij->naam.'</a></dd>';
        }
    ?>

