<h1>Verkiezingen</h1>
        
    <?php        
        //  var_dump();
        foreach($Verkiezingen as $Verkiezing){
            echo '<dd><a href="' . URL_BASE.'verkiezing/view/'.$Verkiezing->id.'">'. $Verkiezing->Verkiezingtype->omschrijving.' - '. $Verkiezing->verkiezingsdatum.'</a></dd>';
        }
    ?>

