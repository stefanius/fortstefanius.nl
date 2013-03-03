<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li class="current"><a href="/client"><span>Overzicht</span></a></li>
            <li><a href="/client/add"><span>Toevoegen</span></a></li>
        </ul>
        <div class="box">
            <h1>Klanten overzicht</h1>
            <form method="post" id="form_users" action="">
                <h4>Snel zoeken</h4>
                <div class="filter_bar clearfix">
                    <div class="float_l">
                    </div>
                    <div class="float_r">
                        Zoek op: <input type="text" name="word"  id="client_search_string" value="" class="text" />
                    </div>
                </div>
            </form>
            <h4>Overzicht</h4>
            <table width="100%" id="table_sort" class="table_data">
                <colgroup>
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                    <col style="" />
                    <col style="width: 30%;" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                </colgroup>
                <thead>
                    <tr>
                        <th>Actief</th>
                        <th>ID</th>
                        <th class="align_l">Naam</th>
                        <th class="align_l">E-mail</th>
                        <th>Details</th>
                        <th>Wijzig</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($Clients as $Client): ?>
                    <tr>
                        <td class="align_c" style="line-height: 0;"><img src="/assets/img/icons/<?php if ($Client->is_enabled): ?>accept<?php else: ?>delete<?php endif; ?>.png" alt="" class="icon" /></td>
                        <td><a href="/client/<?php echo $Client->getId(); ?>"><?php echo $Client->getId(); ?></a></td>
                        <td><a href="/client/<?php echo $Client->getId(); ?>"><?php echo $Client->name; ?></a></td>
                        <td><?php echo $Client->email; ?></td>
                        <td class="align_c" style="line-height: 0;"><a href="/client/<?php echo $Client->getId(); ?>"><img src="/assets/img/icons/magnifier.png" alt="" class="icon" /></a></td>
                        <td class="align_c" style="line-height: 0;"><a href="/client/<?php echo $Client->getId(); ?>/edit" title=""><img src="/assets/img/icons/pencil.png" alt="" class="icon" /></a></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
            
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
        
        new Autocompleter.Request.JSON($('client_search_string'), '/json/search/client', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                new URI('/client/' + li.getFirst('span').get('rel')).go();
            }
        });
        
    });
    
</script>

<?php

echo $this->render("footer.php");