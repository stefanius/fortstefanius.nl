<h1>Pagina's</h1>

    <?php        
        foreach($Pages as $Page){
            echo '<dd><a href="' . URL_BASE.'page/view/'.$Page->id.'">'. $Page->title.'</a></dd>';
        }
    ?>

