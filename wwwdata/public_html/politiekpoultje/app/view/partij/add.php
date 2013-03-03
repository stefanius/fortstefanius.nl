<form method="post" id="add_partij" action="">
    <dl>
        <dt>Partijnaam:</dt> <dd><input type="text" name="naam"></dd><br/>
        <dt>Afkorting:</dt>  <dd><input type="text" name="naam_kort"></dd><br/>
        <dt>Oprichtingsdatum:</dt> <dd><input type="text" name="opgericht"></dd><br/>
        <dt>Infopagina</dt> 
        <dd>
            <select name="contentpage_urlpart">
                <?php
                    echo '<option value="" SELECTED>Geen Infopagina</option>';
                    foreach($Pages as $Page){
                        echo '<option value="'.$Page->urlpart.'">'.$Page->title.'</option>';
                    }
                ?>
            </select>            
        </dd>
        
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>
