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
                <li class="current"><a href="/stock/add"><span>Toevoegen</span></a></li>
            </ul>
            <form method="post" id="form_add_stock" class="form_layout" action="">
                <h4>Gegevens</h4>
                <ul>
                    <li class="label"><label for="client_search_string">Klant:</label></li>
                    <li>
                        <input type="text" id="client_search_string" value="" class="text validate['required','~hasValidClient']" />
                        <input type="hidden" name="client_id" id="client_id" value="" />
                    </li>
                    <li class="label"><label for="product_search_string">Product:</label></li>
                    <li>
                        <input type="text" id="product_search_string" value="" class="text validate['required','~hasValidProduct']" />
                        <input type="hidden" name="product_id" id="product_id" value="" />
                    </li>
                    <li class="label"><label for="warehouse_selector">Magazijn:</label></li>
                    <li>
                        <select id="warehouse_selector" name="warehouse_id">
                            <option value="<?php echo WID_BULK; ?>">Bulk</option>
                            <option value="<?php echo WID_GRIJP; ?>">Grijp</option>
                            <!--<option value="<?php echo WID_RETOUR; ?>">Retouren</option>-->
                        </select>
                    </li>
                    <li class="label"><label for="location_search_string">Vak:</label></li>
                    <li>
                        <input type="text" id="location_search_string" value="" class="text validate['required','~hasValidLocation']" />
                        <input type="hidden" name="location_id" id="location_id" value="" />
                    </li>
                </ul>
                <div id="hidechange">
                    <ul>
                        <li class="label"><label for="multiplier">Aantal in doos:</label></li>
                        <li>
                            <input type="text" name="multiplier" id="multiplier" value="" class="text validate['required','digit']" />
                        </li>
                    </ul>
                </div>
                <ul>
                    <li class="label"><label for="amount" id="amounttext">Aantal dozen:</label></li>
                    <li>
                        <input type="text" name="amount" id="amount" value="" class="text validate['required','digit']" />
                    </li>
                    <li class="button">
                        <input type="submit" value="Voorraad toevoegen" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">

    // client validator
    function hasValidClient(el){
        if (el.value.length && !document.id('client_id').value.test(/[0-9]+/)) {
            el.errors.push('Klant niet correct geselecteerd');
            return false;
        } else {
            return true;
        }
    }

    // product validator
    function hasValidProduct(el){
        if (el.value.length && !document.id('product_id').value.test(/[0-9]+/)) {
            el.errors.push('Product niet correct geselecteerd');
            return false;
        } else {
            return true;
        }
    }

    // location validator
    function hasValidLocation(el){
        if (el.value.length && !document.id('location_id').value.test(/[0-9]+/)) {
            el.errors.push('Locatie niet correct geselecteerd');
            return false;
        } else {
            return true;
        }
    }

    window.addEvent('domready', function() {

        new FormCheck(document.id('form_add_stock'), {
            display: {
                showErrors: 1
            }
        });

        document.id('client_search_string').addEvent('change', function(e){
            document.id('client_id').value = null;
        });

        document.id('product_search_string').addEvent('change', function(e){
            document.id('product_id').value = null;
        });

        document.id('location_search_string').addEvent('change', function(e){
            document.id('location_id').value = null;
        });

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

        var clientCompleter, productCompleter, locationCompleter;

        clientCompleter = new Autocompleter.Request.JSON($('client_search_string'), '/json/search/client', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                $('client_id').set('value', li.getFirst('span').get('rel'));
                locationCompleter.options.postData.client_id = li.getFirst('span').get('rel');
            }
        });

        productCompleter = new Autocompleter.Request.JSON($('product_search_string'), '/json/search/product', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                $('product_id').set('value', li.getFirst('span').get('rel'));
                locationCompleter.options.postData.product_id = li.getFirst('span').get('rel');
            }
        });

        locationCompleter = new Autocompleter.Request.JSON($('location_search_string'), '/json/search/location', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 1,
            'indicatorClass': 'autocompleter-loading',
            'postData': {
                'warehouse_id': <?php echo WID_BULK; ?>,
                'client_id': 0,
                'product_id': 0
            },
            'onSelection': function(input, li) {
                $('location_id').set('value', li.getFirst('span').get('rel'));
            }
        });

        $('warehouse_selector').addEvent('change', function(){
            locationCompleter.options.postData.warehouse_id = this.value;
            if (this.value == <?php echo WID_GRIJP; ?>) {
                $("hidechange").setStyle("display", "none");
                $("hidechange").getElement("input").set("value", 1);
                $("amounttext").set("text", "Aantal:");
            } else {
                $("hidechange").setStyle("display", "");
                $("hidechange").getElement("input").set("value", null);
                $("amounttext").set("text", "Aantal dozen:");
            }
        });
    });
</script>

<?php

echo $this->render("footer.php");