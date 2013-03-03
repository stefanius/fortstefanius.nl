<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/user"><span>Admin</span></a></li>
            <li><a href="/user/fulfillment"><span>Fulfillment</span></a></li>
            <li class="current"><a href="/user/external"><span>Extern</span></a></li>
        </ul>
<?php if (isset($message)): ?>
        <div class="box" style="margin-bottom:20px;border:1px solid #9D9;background:#EFE;">
            <h1>Succes</h1>
            <p><?php echo $message; ?></p>
        </div>
<?php endif; ?>
        <div class="box">
            <h1>Gebruikers</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li><a href="/user/external"><span>Overzicht</span></a></li>
                <li class="current"><a href="/user/external/add"><span>Toevoegen</span></a></li>
            </ul>
            <h4>Gegevens</h4>
            <form method="post" id="form_add_user" class="form_layout" action="">
                <ul>
                    <li class="label"><label>Voornaam:</label></li>
                    <li><input type="text" name="firstname" value="" class="text validate['required']" /></li>
                    <li class="label"><label>Achternaam:</label></li>
                    <li><input type="text" name="surname" value="" class="text validate['required']" /></li>
                    <li class="label"><label>E-mailadres:</label></li>
                    <li><input type="text" name="email" value="" class="text validate['required','email']" /></li>
                    <li class="label"><label>Telefoon:</label></li>
                    <li><input type="text" name="telephone" value="" class="text" /></li>
                    <li class="label"><label>Mobiel:</label></li>
                    <li><input type="text" name="mobile" value="" class="text" /></li>
                    <li class="label"><label>Wachtwoord:</label></li>
                    <li><input type="text" name="password" id="password" value="" class="text validate['required']" /> (<a href="javascript:generatePassword();">genereer</a>)</li>
                    <li class="label"><label>Wachtwoord (controle):</label></li>
                    <li><input type="text" name="passwordc" value="" class="text validate['confirm[password]']" /></li>
                    <li class="label"><label>Is actief:</label></li>
                    <li><input type="radio" name="is_enabled" id="active_y" class="validate['required']" value="1" checked /> <label for="active_y">Ja</label>
                        &nbsp; <input type="radio" name="is_enabled" id="active_n" class="validate['required']" value="0" /> <label for="active_n">Nee</label></li>
                </ul>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" name="add_user" value="Gebruiker toevoegen" class="fancy_button" />
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
        $("password").set("value", randomString(8));
    }
    
    window.addEvent('domready', function() {
        new FormCheck($('form_add_user'));
    });
    
</script>

<?php

echo $this->render("footer.php");