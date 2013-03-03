<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/user"><span>Admin</span></a></li>
            <li class="current"><a href="/user/fulfillment"><span>Fulfillment</span></a></li>
            <li><a href="/user/external"><span>Extern</span></a></li>
        </ul>
        <div class="box">
            <h1>Gebruikers</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:2px">
                <li class="current"><a href="/user/fulfillment"><span>Overzicht</span></a></li>
                <li><a href="/user/fulfillment/add"><span>Toevoegen</span></a></li>
            </ul>
            <form method="post" id="form_users" action="#">
                <div class="filter_bar clearfix">
                    <div class="float_l">
                    </div>
                    <div class="float_r">
                        Snel zoeken: <input type="text" name="word"  id="user_search_string" value="" class="text" />
                    </div>
                </div>
                <table width="100%" id="table_sort" class="table_data">
                    <colgroup>
                        <col style="width: 1%;" />
                        <col />
                        <col />
                        <col />
                        <col style="width: 15%;" />
                        <col style="width: 1%;" />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Actief</th>
                            <th class="align_l">Voornaam</th>
                            <th class="align_l">Achternaam</th>
                            <th class="align_l">Werkgever</th>
                            <th class="align_l">Pincode</th>
                            <th>Wijzig</th>
                            <th>Verwijder</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($Users as $User): ?>
                        <tr>
                            <td class="align_c" style="line-height: 0;"><img src="/assets/img/icons/<?php if ($User->is_enabled): ?>accept<?php else: ?>delete<?php endif; ?>.png" alt="" class="icon" /></td>
                            <td><?php echo $User->firstname; ?></td>
                            <td><?php echo $User->surname; ?></td>
                            <td><?php echo $User->employer; ?></td>
                            <td><?php echo $User->pincode; ?></td>
                            <td class="align_c" style="line-height: 0;"><a href="/user/fulfillment/<?php echo $User->getId(); ?>/edit"><img src="/assets/img/icons/pencil.png" alt="" class="icon" /></a></td>
                            <td class="align_c" style="line-height: 0;"><a href="/user/fulfillment/<?php echo $User->getId(); ?>/delete"><img src="/assets/img/icons/cross.png" alt="" class="icon" /></a></td>
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
                        var match = token.firstname + ' ' + token.surname;
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
        
        new Autocompleter.Request.JSON($('user_search_string'), '/json/search/fulfillmentuser', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                new URI('/user/fulfillment/' + li.getFirst('span').get('rel')).go();
            }
        });
        
    });
    
</script>

<?php

echo $this->render("footer.php");