<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li class="current"><a href="/stock"><span>Voorraad</span></a></li>
            <li><a href="/stock/notifications"><span>Voormeldingen</span></a></li>
        </ul>
        <div class="box">
            <h1>Voorraad</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
                <li class="current"><a href="/stock/add"><span>Toevoegen</span></a></li>
            </ul>
            <form method="post" id="form_users" action="#">
                <div class="filter_bar clearfix">
                    <div class="float_l">
                    </div>
                    <div class="float_r">
                        Snel zoeken: <input type="text" name="word"  id="autocompleter_word" value="" class="text" />
                    </div>
                </div>
                <table width="100%" id="table_sort" class="table_data">
                    <colgroup>
                        <col style="" />
                        <col style="width: 10%;" />
                        <col style="width: 1%;" />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="align_l">Product</th>
                            <th class="align_l">Aantal</th>
                            <th>Details</th>
                            <th>Wijzig</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($Stocks as $Stock): ?>
                        <tr>
                            <td><?php #echo $Stock->product; ?></td>
                            <td><?php echo $Stock->amount; ?></td>
                            <td class="align_c" style="line-height: 0;"><a href="/product/<?php echo $Stock->product_id; ?>" title=""><img src="assets/img/icons/magnifier.png" alt="" class="icon" /></a></td>
                            <td class="align_c" style="line-height: 0;"><a href="/stock/<?php echo $Stock->client_id; ?>/<?php echo $Stock->product_id; ?>/<?php echo $Stock->location_id; ?>/<?php echo $Stock->multiplier; ?>" title=""><img src="assets/img/icons/pencil.png" alt="" class="icon" /></a></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">
    
    window.addEvent('domready', function() {
        
        new HtmlTable($('table_sort'), {sortIndex: null, sortable: true, zebra: true, classZebra: 'odd'});
        
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
        
        new Autocompleter.Request.JSON($('product_search_string'), '/json/search/product', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                new URI('/product/' + li.getFirst('span').get('rel')).go();
            }
        });
    });
    
</script>

<?php

echo $this->render("footer.php");