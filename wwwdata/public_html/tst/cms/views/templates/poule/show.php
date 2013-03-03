<?php

$this->show_view("header.php", TRUE);

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <div class="box">
		<?php
			$P = $Poule;
                        echo "Poule ID - ".$P->id."<br/>";
                        echo "Poule Name - ".$P->name."<br/>";
                        echo "author Name - ".$P->Author->nickname."<br/>";			
		?>
        </div>
    </div>
    <?php $this->show_view("navigation.php", TRUE); ?>
</div>

<?php

$this->show_view("footer.php", TRUE);
