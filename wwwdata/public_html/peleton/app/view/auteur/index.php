<h1>Auteurs</h1>
    <?php        
        foreach($Auteurs as $Auteur){
            echo '<dd><a href="' . URL_BASE.'auteur/view/'.$Auteur->id.'">'. $Auteur->naam.'</a></dd>';
        }
    ?>

