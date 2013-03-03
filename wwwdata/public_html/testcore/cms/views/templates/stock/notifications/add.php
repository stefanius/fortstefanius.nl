<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/stock"><span>Voorraad</span></a></li>
            <li class="current"><a href="/stock/notifications"><span>Voormeldingen</span></a></li>
        </ul>
<?php if (isset($message)): ?>
        <div class="box" style="margin-bottom:20px;border:1px solid #9D9;background:#EFE;">
            <h1>Succes</h1>
            <p><?php echo $message; ?></p>
        </div>
<?php endif; ?>
        <div class="box">
            <h1>Voormeldingen</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li><a href="/stock/notifications"><span>Overzicht</span></a></li>
                <li><a href="/stock/notifications/archive"><span>Archief</span></a></li>
                <li class="current"><a href="/stock/notifications/add"><span>Toevoegen</span></a></li>
            </ul>
            <form method="post" id="form_add_notification" class="form_layout" action="">
                <h4>Details</h4>
                <ul>
                    <li class="label"><label>Klant:</label></li>
                    <li>
                        <input type="text" id="client_search_string" value="" class="text validate['required']" />
                        <input type="hidden" name="client_id" id="client_id" value="" />
                    </li>
                    <li class="label"><label>Product:</label></li>
                    <li>
                        <input type="text" id="product_search_string" value="" class="text validate['required']" />
                        <input type="hidden" name="product_id" id="product_id" value="" />
                    </li>
                    <li class="label"><label>Aantal:</label></li>
                    <li>
                        <input type="text" name="amount" value="" class="text validate['required','digit']" />
                    </li>
                    <li class="label"><label>Verwacht:</label></li>
                    <li>
                        <input type="text" name="expected" id="expected" value="" class="text date validate['required']" />
                    </li>
                    <li class="button">
                        <input type="submit" value="Toevoegen" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">
    
    window.addEvent('domready', function() {
        
        //new FormCheck($('form_add_notification'));
        
        new Calendar({expected: 'Y-m-d'}, {classes: ['dashboard'], direction: 1});
        
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
        
        var clientCompleter, productCompleter;
        
        clientCompleter = new Autocompleter.Request.JSON($('client_search_string'), '/json/search/client', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                $('client_id').set('value', li.getFirst('span').get('rel'));
            }
        });
        
        productCompleter = new Autocompleter.Request.JSON($('product_search_string'), '/json/search/product', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                $('product_id').set('value', li.getFirst('span').get('rel'));
            }
        });
        
    });
    
</script>

<?php

echo $this->render("footer.php");