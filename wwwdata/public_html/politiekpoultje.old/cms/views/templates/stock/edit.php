<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li class="current"><a href="/stock/add"><span>Voorraad</span></a></li>
            <li><a href="/stock/notifications"><span>Voormeldingen</span></a></li>
        </ul>
<?php if (isset($message)): ?>
        <div class="box" style="margin-bottom:20px;border:1px solid #9D9;background:#EFE;">
            <h1>Succes</h1>
            <p><?php echo $message; ?></p>
        </div>
<?php endif; ?>
        <div class="box">
            <h1>Voorraad</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li><a href="/stock/add"><span>Toevoegen</span></a></li>
                <li class="current"><a href="/stock/<?php echo $Client->getId(); ?>/<?php echo $Product->getId(); ?>/<?php echo $Location->getId(); ?>/<?php echo $multiplier; ?>" title=""><span>Wijzigen</span></a></li>
            </ul>
            <h4>Product</h4>
            <table class="table_info">
                <colgroup>
                    <col style="width:15%" />
                    <col />
                </colgroup>
                <tr>
                    <td class="cell">Naam:</td>
                    <td><a href="/product/<?php echo $Product->getId(); ?>"><?php echo $Product->name; ?></a></td>
                </tr>
                <tr>
                    <td class="cell">Productcode:</td>
                    <td><a href="/product/<?php echo $Product->getId(); ?>"><?php echo $Product->code; ?></a></td>
                </tr>
                <tr>
                    <td class="cell">Beschrijving:</td>
                    <td><?php echo $Product->description; ?></td>
                </tr>
                <tr>
                    <td class="cell">Gewicht:</td>
                    <td><?php echo $Product->weight; ?> gram</td>
                </tr>
                <tr>
                    <td class="cell">Breed:</td>
                    <td><?php echo $Product->width; ?> millimeter</td>
                </tr>
                <tr>
                    <td class="cell">Hoog:</td>
                    <td><?php echo $Product->height; ?> millimeter</td>
                </tr>
                <tr>
                    <td class="cell">Diep:</td>
                    <td><?php echo $Product->depth; ?> millimeter</td>
                </tr>
            </table>
            <h4>Voorraad</h4>
            <table class="table_info">
                <colgroup>
                    <col style="width:15%" />
                    <col />
                </colgroup>
                <tr>
                    <td class="cell">Magazijn:</td>
                    <td><a href="/warehouse/<?php echo $Location->warehouse_id; ?>/locations"><?php if ($Location->warehouse_id == WID_BULK) { echo "Bulk"; } elseif ($Location->warehouse_id == WID_GRIJP) { echo "Grijp"; } ?></a></td>
                </tr>
                <tr>
                    <td class="cell">Locatie:</td>
                    <td><a href="/location/<?php echo $Location->getId(); ?>"><?php echo $Location->name; ?></a></td>
                </tr>
<?php if ($multiplier > 1): ?>
                <tr>
                    <td class="cell">Aantal per doos:</td>
                    <td><?php echo $multiplier; ?></td>
                </tr>
                <tr>
                    <td class="cell">Aantal dozen:</td>
                    <td><?php echo $stock->current()->amount; ?></td>
                </tr>
<?php else: ?>
                <tr>
                    <td class="cell">Aantal:</td>
                    <td><?php echo $stock->current()->amount; ?></td>
                </tr>
<?php endif; ?>
            </table>
            <h4>Wijzigen</h4>
            <form method="post" action="" class="form_layout">
                <table class="table_info">
                    <colgroup>
                        <col style="width:15%" />
                        <col />
                    </colgroup>
                    <tr>
                        <td class="cell">Bijboeken:</td>
                        <td style="padding:0">
                            <input type="text" class="text" name="add" style="margin:0 6px; width: 80px" />
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">Afboeken:</td>
                        <td style="padding:0">
                            <input type="text" class="text" name="subtract" style="margin:0 6px; width: 80px" />
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">Verplaatsen:</td>
                        <td style="padding:0">
                            <input type="text" class="text" name="location_name" id="location_search_string" style="margin:0 6px; width: 80px" />
                            <input type="hidden" name="location_id" id="location_id" />
                        </td>
                    </tr>
                    <tr>
                        <td class="cell">Verwijderen:</td>
                        <td style="padding:0; vertical-align: middle">
                            <input type="checkbox" name="delete" style="margin:0 6px; vertical-align: middle" />
                        </td>
                    </tr>
                </table>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" value="Toepassen" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript"> 
    
    window.addEvent('domready', function() {
        
        new FormCheck($('form_add_stock'));
        
        Autocompleter.implement({
            'update': function(tokens) {
                this.choices.empty();
                this.cached = tokens;
                var type = tokens && $type(tokens);
                if (!type || (type == 'array' && !tokens.length) || (type == 'hash' && !tokens.getLength())) {
                    (this.options.emptyChoices || this.hideChoices).call(this);
                } else {
                    if (this.options.maxChoices < tokens.length && !this.options.overflow) tokens.length = this.options.maxChoices;
                    tokens.each(this.options.injectChoice || function(token){
                        var match = token.name;
                        var li = new Element('li').adopt(
                            new Element('span', {'html': this.markQueryValue(match), 'rel': token.id})
                        );
                        li.inputValue = match;
                        this.addChoiceEvents(li).inject(this.choices);
                    }, this);
                    this.showChoices();
                }
            }
        });
        
        locationCompleter = new Autocompleter.Request.JSON($('location_search_string'), '/json/search/location', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 1,
            'indicatorClass': 'autocompleter-loading',
            'postData': {
                'warehouse_id': <?php echo $Location->warehouse_id; ?>,
                'client_id': 0,
                'product_id': 0
            },
            'onSelection': function(input, li) {
                $('location_id').set('value', li.getFirst('span').get('rel'));
            }
        });
    });
</script> 

<?php

echo $this->render("footer.php");