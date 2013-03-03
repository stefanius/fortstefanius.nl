<form method="post" id="add_verkiezing" action="">
    <dl>
        <dt>Verkiezingtype:</dt> 
        <dd>
            <select name="verkiezingtype_id">
                <?php
                    foreach($Verkiezingtypes as $Verkiezingtype){
                        echo '<option value="'.$Verkiezingtype->id.'">'.$Verkiezingtype->omschrijving.'</option>';
                    }
                ?>
            </select>            
        </dd>
        <dt>Verkiezingsdatum:</dt>  <dd><input type="text" class="datepicker" name="verkiezingsdatum"></dd>
        <dt>Deelnemende Partijen:</dt>
        
                <?php        
                
                    foreach($Partijen as $Partij){
                        echo '<dd><input type="checkbox" value="'.$Partij->id.'" name="partijlist[]">'.$Partij->displayvalue.'</input></dd>';
                    }
                ?>
        
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>

<script>
        
    $(function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
    
</script>