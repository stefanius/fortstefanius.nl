<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
<?php if (isset($message)): ?>
        <div class="box" style="margin-bottom:20px;border:1px solid #9D9;background:#EFE;">
            <h1>Succes</h1>
            <p><?php echo $message; ?></p>
        </div>
<?php endif; ?>
        <div class="box">
            <h1>Magazijn wijzigen</h1>
            <form method="post" id="form_add_user" class="form_layout" action="">
                <input type="hidden" name="id" value="<?php echo $Warehouse->getId(); ?>" />
                <h4>Gegevens van <?php echo $Warehouse->name; ?></h4>
                <ul>
                    <li class="label"><label>Volume:</label></li>
                    <li><input type="text" name="volume" value="<?php echo $Warehouse->volume; ?>" class="text validate['required']" /></li>
                    <li class="button">
                        <input type="submit" name="add_user" value="Magazijn opslaan" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">
    window.addEvent('domready', function() {
        new FormCheck($('form_add_user'));
    });
</script>

<?php

echo $this->render("footer.php");