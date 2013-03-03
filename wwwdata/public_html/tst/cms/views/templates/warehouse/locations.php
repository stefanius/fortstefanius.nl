<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/warehouse"><span>Magazijnen</span></a></li>
            <!--<li><a href="/location/add"><span>Locatie Toevoegen</span></a></li>-->
            <li class="current"><a href="/warehouse/<?php echo $Warehouse->getId(); ?>/locations"><span>Locaties</span></a></li>
        </ul>
        <div class="box">
            <h1>Locaties in magazijn: <?php echo $Warehouse->name;?></h1>
            <form method="post" id="form_users" action="#">
                <div class="filter_bar clearfix">
                    <div class="float_l">
                    </div>
                    <div class="float_r">
                        Snel zoeken: <input type="text" name="word"  id="location_search_string" value="" class="text" />
                    </div>
                </div>
                <ul id="table_sort_paginate_top" class="pagination"></ul>
                <table width="100%" id="table_sort" class="table_data">
                    <colgroup>
                        <col style="" />
                        <col style="width: 1%;" />
                        <col style="width: 1%;" />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="align_l">Naam</th>
                            <th>Producten</th>
                            <th>Details</th>
                            <th>Wijzig</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($Locations as $Location): ?>
                        <tr>
                            <td><a href="/location/<?php echo $Location->getId(); ?>"><?php echo $Location->name; ?></a></td>
                            <td class="align_c"><?php echo $Location->getProductCount(); ?></td>
                            <td class="align_c" style="line-height: 0;"><a href="/location/<?php echo $Location->getId(); ?>"><img src="/assets/img/icons/magnifier.png" alt="" class="icon" /></a></td>
                            <td class="align_c" style="line-height: 0;"><a href="/location/<?php echo $Location->getId(); ?>/edit" title=""><img src="/assets/img/icons/pencil.png" alt="" class="icon" /></a></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
                <ul id="table_sort_paginate_bottom" class="pagination"></ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">
    
    window.addEvent('domready', function() {
        
        // make table sortable and fancy
        new HtmlTable($('table_sort'), {
            sortIndex: null,
            sortable: true,
            zebra: true,
            classZebra: 'odd',
            pagination: 50,
            paginators: ['table_sort_paginate_top','table_sort_paginate_bottom']
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
        
        new Autocompleter.Request.JSON($('location_search_string'), '/json/search/location', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 1,
            'indicatorClass': 'autocompleter-loading',
            'postData': {
                'warehouse_id': <?php echo $Warehouse->getId(); ?>
            },
            'onSelection': function(input, li) {
                new URI('/location/' + li.getFirst('span').get('rel')).go();
            }
        });
        
    });
</script>

<?php

echo $this->render("footer.php");
