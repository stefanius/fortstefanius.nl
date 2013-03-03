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
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/details"><span>Details</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/images"><span>Afbeeldingen</span></a></li>
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/marketing"><span>Marketing</span></a></li>
            </ul>
            <form method="post" id="marketing_product" class="form_layout" action="">
                <h4 class="toggler">Gegevens</h4>
                <ul>
                    <li class="label">
                        <label for="product_search_string">Product:</label>
                    </li>
<?php if (isset($Product)): ?>
                    <li>
                        <input type="text" id="product_search_string" name="product" value="<?= $Product->name; ?>" class="text validate['%hasValidProduct']" />
                        <input type="hidden" name="product_id" id="product_id" value="<?= $Product->getId(); ?>" />
                    </li>
<?php else: ?>
                    <li>
                        <input type="text" id="product_search_string" name="product" value="" class="text validate['~hasValidClient']" />
                        <input type="hidden" name="product_id" id="product_id" value="" />
                    </li>
<?php endif; ?>
                    <!--
                    <li class="label">
                        <label for="dfrom">Vanaf:</label>
                    </li>
                    <li>
                        <input type="text" name="dfrom" id="dfrom" class="text date" />
                    </li>
                    <li class="label">
                        <label for="dtill">Tot en met:</label></li>
                    <li>
                        <input type="text" name="dtill" id="dtill" class="text date" />
                    </li>
                    <li class="label">
                        <label for="amount">Aantal:</label></li>
                    <li>
                        <input type="text" name="amount" id="amount" class="text date" />
                    </li>
                    -->
                </ul>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" name="action" value="Opslaan" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">

    // product validator
    function hasValidProduct(el){
        if (el.value.length && !document.id('product_id').value.test(/[0-9]+/)) {
            el.errors.push('Product niet correct geselecteerd');
            return false;
        } else {
            return true;
        }
    }

    window.addEvent('domready', function() {

        // form checker
        new FormCheck(document.id('marketing_product'), {
            display: {
                showErrors: 1
            }
        });

        // calendars
        new Calendar({dfrom: 'Y-m-d'}, {classes: ['dashboard']});
        new Calendar({dtill: 'Y-m-d'}, {classes: ['dashboard']});

        // patch the autocompleter
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

        document.id('product_search_string').addEvent('change', function(e){
            document.id('product_id').value = null;
        });

        // init product autocompleter
        var productCompleter = new Autocompleter.Request.JSON($('product_search_string'), '/json/search/product', {
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