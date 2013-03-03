<h1>Blog: <?php echo $Blog->displayvalue; ?></h1>
<h2><a href="<?php echo URL_BASE.'blog/edit/'.$Blog->id ?>">Edit</a></h2>
<dl> 
                <?php        
                
                    foreach($Blog->getFieldnames() as $fieldname){
                        echo '<dt>'.$fieldname.'</dt><dd>'.$Blog->$fieldname.'</dd>';
                    }
                ?>

</dl>