<form method="post" id="add_partij" action="" onsubmit="return form_validate()" >
    <dl>
        <dt>Partijnaam:</dt> <dd><input type="text" name="naam" value="<?php echo $Partij->naam ?>"></dd><br/>
        <dt>Afkorting:</dt>  <dd><input type="text" name="naam_kort" value="<?php echo $Partij->naam_kort ?>"></dd><br/>
        <dt>Oprichtingsdatum:</dt> <dd><input type="text" class="datepicker" name="opgericht" value="<?php echo $Partij->opgericht ?>"></dd><br/>
        <dt>Ontbonden:</dt> <dd><input type="text" class="datepicker" name="ontbonden" value="<?php echo $Partij->ontbonden ?>"></dd><br/>
        <?php if($Partij->partij_id > 0): ?>
            <dt>Opgegaan in:</dt> <dd><span id="span_partij_samengevoegd"><?php echo $Partij->naam_partij_samengevoegd ?></span></dd><br/>
            <input type="hidden" name="partij_id" id="partij_id" value="<?php echo $Partij->partij_id ?>">
        <?php else: ?>
            <dt>Opgegaan in:</dt> <dd><span id="span_partij_samengevoegd">Geen fusie partij geselecteerd</span></dd><br/>
            <input type="hidden" name="partij_id" id="partij_id" value="0">
        <?php endif; ?>
        <input type="hidden" name="id" value="<?php echo $Partij->id ?>">
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>


<!--JavaScript-->

<script>
        
    $(function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });

    $(function () {

        $('#span_partij_samengevoegd').live('click', function () {
            var input = $('<input />', {'type': 'text', 'id': 'my_input', 'name': 'my_input', 'value': $(this).html()});
            
            input.autocomplete({
                source: function(req, resp) {
                    $.getJSON("http://localhost/grootjeframework/testproject/json/find/partij/naam/" + encodeURIComponent(req.term), resp);
                },

                select: function(event,ui){
                    $("#partij_id").attr("value", ui.item.id );
                    $('#span_partij_samengevoegd').remove();
                    input.parent().append($('<span />' , {'id': 'span_partij_samengevoegd'}).html(ui.item.value));
                    input.remove();
                }
            });    

            $(this).parent().append(input);
            $(this).remove();
            input.focus();
        });
        
    });
    
    function form_validate()
    {
        //validate ID of the partij with the text in the span.
        var validated_partij;
        var response = $.ajax({
            type: "GET",   
            url: "/grootjeframework/testproject/json/validate_autocomplete/partij/"+
                    $("#partij_id").attr("value")+'/'+
                    $('#span_partij_samengevoegd').html(),   
            async: false,
            success : function(res) {
                validated_partij = (res==1);
            }

        });
        if(!validated_partij){
            alert('Partij is onbekend. Wellicht heeft u een spelfout gemaakt. Indien de partij niet is opgegaan in een nieuwe partij, kunt u dit vak leeglaten.');
        }
        return validated_partij;
 
    }
</script>
