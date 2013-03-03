<h1>Edit Verkiezing</h1>

<form method="post" id="edit_verkiezing" action="">
    <dl>
        <dt>Verkiezingtype:</dt> 
        <dd>
            <select name="verkiezingtype_id">
                <?php
                    foreach($Verkiezingtypes as $Verkiezingtype){
                        $selected='';
                        if($Verkiezingtype->id ==$Verkiezing->verkiezingtype_id){
                            $selected = ' SELECTED';
                        }
                        echo '<option value="'.$Verkiezingtype->id.'" '.$selected.'>'.$Verkiezingtype->omschrijving.' </option>';
                    }
                ?>
            </select>            
        </dd>
        <dt>Verkiezingsdatum:</dt>  <dd><input type="text" class="datepicker" name="verkiezingsdatum" value="<?php echo $Verkiezing->verkiezingsdatum ?>" /></dd>
        <dt>Deelnemende Partijen:</dt>
        
                <?php                       
                    foreach($Partijen as $Partij){
                        if(in_array($Partij, $Verkiezing->Partijen)){
                             echo '<dd><input type="checkbox" value="'.$Partij->id.'" name="partijlist[]" checked>'.$Partij->naam_kort.'</input></dd>';
                        }else{
                             echo '<dd><input type="checkbox" value="'.$Partij->id.'" name="partijlist[]">'.$Partij->naam_kort.'</input></dd>';
                        }
                       
                    }
                ?>
        <input type="hidden" name="id" value="<?php echo $Verkiezing->id ?>">
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>

<script>
        
    $(function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
    
</script>