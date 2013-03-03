<h1>Verkiezing</h1>
<h2><a href="<?php echo URL_BASE.'verkiezing/edit/'.$Verkiezing->id ?>">Edit</a></h2>
<dl> 
                <?php        

                    foreach($Verkiezing->getFieldnames() as $fieldname){
                        echo '<dt>'.$fieldname.'</dt><dd>'.$Verkiezing->$fieldname.'</dd>';
                    }
                    echo '<dt>Niveau / verkiezingtype</dt><dd>'.$Verkiezing->Verkiezingtype->omschrijving.'</dd>';
                    
                    echo '<dt>Partijen:</dt>';
                    
                    if(count($Verkiezing->Partijen) > 0){
                        foreach($Verkiezing->Partijen as $Partij){
                            echo '<dd>'.$Partij->displayvalue.'</dd>';
                        }                       
                    }else{
                        echo '<dd><i>Er zijn geen partijen die deelnemen aan deze verkiezing.</i></dd>';
                    }
                    
                ?>

</dl>