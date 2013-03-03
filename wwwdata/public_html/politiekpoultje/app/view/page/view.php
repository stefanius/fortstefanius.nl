<h1>Partij: <?php echo $Partij->displayvalue; ?></h1>
<h2><a href="<?php echo URL_BASE.'page/edit/'.$Page->id ?>">Edit</a></h2>
<dl> 
                <?php        
                
                    foreach($Partij->getFieldnames() as $fieldname){
                        echo '<dt>'.$fieldname.'</dt><dd>'.$Partij->$fieldname.'</dd>';
                    }
                ?>

</dl>