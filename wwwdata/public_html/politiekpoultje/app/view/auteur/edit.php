<form method="post" id="edit_auteur" action="">
    <dl>
        <dt>Naam:</dt> <dd><input type="text" name="naam" value="<?php echo $Auteur->naam; ?>"></dd><br/>
        <dt>Omschrijving:</dt>  <dd><input type="text" name="omschrijving" value="<?php echo $Auteur->omschrijving; ?>"></dd><br/>
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>