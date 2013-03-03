<?php

$this->show_view("header.php", TRUE);

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <div class="box">
		<?php
			$S = $System->read();
			foreach($S as $key => $val){
				echo $key." - ".$val."<br/>";
			}			
		?>
        </div>
    </div>
    <?php $this->show_view("navigation.php", TRUE); ?>
</div>

<?php

$this->show_view("footer.php", TRUE);
