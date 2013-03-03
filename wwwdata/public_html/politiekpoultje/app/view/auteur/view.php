<h1>Auteur: <?php echo $Partij->displayvalue; ?></h1>
<h2><a href="<?php echo URL_BASE.'auteur/edit/'.$Auteur->id ?>">Edit</a></h2>
<dl> 
                <?php        
                
                    foreach($Auteur->getFieldnames() as $fieldname){
                        echo '<dt>'.$fieldname.'</dt><dd>'.$Auteur->$fieldname.'</dd>';
                    }
                ?>

</dl>