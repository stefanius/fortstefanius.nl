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
        <div class="box" style="margin-bottom:20px;">
            <h1>Klant wijzigen</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/details"><span>Details</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/images"><span>Afbeeldingen</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/marketing"><span>Marketing</span></a></li>
            </ul>
            <form method="post" id="form_customers" class="form_layout" action="">
                <h4 class="toggler">Gegevens</h4>
                <ul>
                    <li class="label"><label>Klantnaam:</label></li>
                    <li><input type="text" name="name" value="<?php echo htmlentities($Client->name); ?>" class="text validate['required']" /></li>
                    <li class="label"><label>E-mail:</label></li>
                    <li><input type="text" name="email" value="<?php echo htmlentities($Client->email); ?>" class="text validate['required','email']" /></li>
                    <li class="label"><label>Key:</label></li>
                    <li><input type="text" name="hash" value="<?php echo $Client->hash; ?>" id="hash" class="text validate['required']" /> (<a href="javascript:generateKey()">genereer</a>)</li>
                    <li class="label"><label>FTP wachtwoord:</label></li>
                    <li><input type="text" name="ftpasswd" id="ftpasswd" value="" class="text validate['alphanum']" /> (<a href="javascript:generatePassword();">genereer</a>)</li>
                    <li class="label"><label>FTP wachtwoord (controle):</label></li>
                    <li><input type="text" name="ftpasswd_c" value="" class="text validate['confirm[ftpasswd]']" /></li>
                    <li class="label"><label>Bezoekadres</label></li>
                    <li><textarea name="address" style="width: 300px; height: 120px;" class="validate['required']"><?php echo $Client->address; ?></textarea></li>
                    <li class="label"><label>Factuuradres</label></li>
                    <li><textarea name="address_invoice" style="width: 300px; height: 120px;" class="validate['required']"><?php echo $Client->address_invoice; ?></textarea></li>
                    <li class="label"><label>Retouradres</label></li>
                    <li><textarea name="address_retour" style="width: 300px; height: 120px;"><?php echo $Client->address_retour; ?></textarea></li>
                    <li class="label"><label>Stuklocatie:</label></li>
                    <li><input type="text" name="stuklocatie" value="<?php echo $Client->stuklocatie; ?>" class="text" /></li>
                    <li class="label"><label>Rekening nr. rembours:</label></li>
                    <li><input type="text" name="ban" value="<?php echo $Client->ban; ?>" class="text validate['digit']" /></li>
                    <li class="label"><label>Is actief:</label></li>
                    <li><input type="radio" name="is_enabled" id="active_y" value="1" class="validate['required']"<?php if ($Client->is_enabled): ?> checked<?php endif; ?> /> <label for="active_y">Ja</label>
                        &nbsp; <input type="radio" name="is_enabled" id="active_n" value="0" class="validate['required']"<?php if (!$Client->is_enabled): ?> checked<?php endif; ?> /> <label for="active_n">Nee</label></li>
                </ul>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" value="Opslaan" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">

    function randomString(length) {
        var chr = '23456789ABCDEFGHKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');
        var str = '';
        for (var i = 0; i < length; i++) {
            str += chr[Math.floor(Math.random() * chr.length)];
        }
        return str;
    }

    function generatePassword() {
        $("ftpasswd").set("value", randomString(8));
    }

    function generateKey() {
        $("hash").set("value", randomString(32));
    }

    window.addEvent('domready', function() {

        new FormCheck($('form_customers'));

    });

</script>

<?php

echo $this->render("footer.php");