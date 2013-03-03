<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li class="current"><a href="/warehouse"><span>Magazijnen</span></a></li>
            <!--<li><a href="/location/add"><span>Locatie Toevoegen</span></a></li>-->
        </ul>
        <div class="box">
            <h1>Magazijn overzicht</h1>
            <form method="post" id="form_users" action="" class="form_layout">
                <table width="100%" id="table_sort" class="table_data">
                    <colgroup>
                        <col style="" />
                        <col style="" />
                        <!--<col style="width: 10%;" />-->
                        <col style="width: 10%;" />
                        <col style="width: 1%;" />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="align_l">Naam</th>
                            <th class="align_l">Locatie zoeken</th>
                            <!--<th class="align_l">Volume</th>-->
                            <th class="align_l">Gebruikt</th>
                            <th>Details</th>
                            <th>Wijzig</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($Warehouses as $Warehouse): ?>
                        <tr>
                            <td><?php echo $Warehouse->name; ?></td>
                            <td><input type="text" name="word"  id="location_search_string_warehouse_<?php echo $Warehouse->getId(); ?>" value="" class="text" style="width:80px" /></td>
                            <!--<td><?php echo $Warehouse->volume; ?>m&sup3;</td>-->
                            <td><?php echo sprintf("%0.2F", $Warehouse->getSumCubicStorageUsed() / 1000000000); ?>m&sup3;</td>
                            <td class="align_c" style="line-height: 0;"><a href="/warehouse/<?php echo $Warehouse->getId(); ?>/locations"><img src="/assets/img/icons/magnifier.png" class="icon" /></a></td>
                            <td class="align_c" style="line-height: 0;"><a href="/warehouse/<?php echo $Warehouse->getId(); ?>/edit" title=""><img src="assets/img/icons/pencil.png" alt="" class="icon" /></a></td>
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

<?php foreach ($Warehouses as $Warehouse): ?>
        new Autocompleter.Request.JSON($('location_search_string_warehouse_<?php echo $Warehouse->getId(); ?>'), '/json/search/location', {
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
<?php endforeach; ?>

    });

</script>

<?php

echo $this->render("footer.php");
