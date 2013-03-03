<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/client"><span>Overzicht</span></a></li>
            <li><a href="/client/add"><span>Toevoegen</span></a></li>
            <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/details"><span>Wijzigen</span></a></li>
            <li><a href="/client/<?php echo $Client->getId(); ?>"><span>Details</span></a></li>
        </ul>
<?php if (isset($message)): ?>
        <div class="box" style="margin-bottom:20px;border:1px solid #9D9;background:#EFE;">
            <h1>Succes</h1>
            <p><?php echo $message; ?></p>
        </div>
<?php endif; ?>
        <div class="box">
            <h1>Klant wijzigen</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/details"><span>Details</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/users"><span>Gebruikers</span></a></li>
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/images"><span>Afbeeldingen</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/marketing"><span>Marketing</span></a></li>
            </ul>
            <form method="post" id="form_client_images_logo" class="form_layout" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $Client->getId(); ?>" />
                <h4>Pakbon</h4>
                <ul>
                    <li class="label"><label>Logo:</label></li>
                    <li><input type="file" name="logo" /></li>
<?php if (isset($logo_url)): ?>
                    <li class="label"><label>Huidig:</label></li>
                    <li><img src="<?php echo $logo_url; ?>" /></li>
<?php endif; ?>
                </ul>
                <ul style="margin:5px 0;">
                    <li class="button">
                        <input type="submit" value="Opslaan" class="fancy_button" />
<?php /* if (isset($logo_url)): ?>
                        <input type="button" value="Verwijder" onclick="" class="fancy_button grey" />
<?php endif; */ ?>
                    </li>
                </ul>
            </form>
            <form method="post" id="form_client_images_achterkant" class="form_layout" action="" enctype="multipart/form-data">
                <ul>
                    <li class="label"><label>Achterkant:</label></li>
                    <li><input type="file" name="achterkant" /></li>
<?php if (isset($achterkant_url)): ?>
                    <li class="label"><label>Huidig:</label></li>
                    <li><a href="<?php echo $achterkant_url; ?>">Downloaden</a></li>
<?php endif; ?>
                </ul>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" value="Opslaan" class="fancy_button" />
<?php /* if (isset($achterkant_url)): ?>
                        <input type="button" value="Verwijder" onclick="" class="fancy_button grey" />
<?php endif; */ ?>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<?php

echo $this->render("footer.php");
