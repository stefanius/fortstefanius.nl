<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/client"><span>Overzicht</span></a></li>
            <li><a href="/client/add"><span>Toevoegen</span></a></li>
            <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/details"><span>Wijzigen</span></a></li>
            <li><a href="/client/<?php echo $Client->getId(); ?>/users"><span>Details</span></a></li>
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
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/edit/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/images"><span>Afbeeldingen</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/edit/marketing"><span>Marketing</span></a></li>
            </ul>
            <form method="post" id="form_customers" class="form_layout" action="">
                <h4>Zoeken</h4>
                <ul>
                    <li class="label"><label>Gebruiker:</label></li>
                    <li>
                        <input type="text" id="user_search_string" value="" class="text" />
                        <input type="hidden" id="user_id" value="" />
                        <input type="button" id="add_user" value="Toevoegen" class="fancy_button" />
                    </li>
                </ul>
                <h4>Toegevoegd</h4>
                <table width="100%" id="table_sort" class="table_data" style="margin-bottom:0.5em;">
                    <colgroup>
                        <col />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="align_l">Naam</th>
                            <th>Verwijder</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($Users as $User): ?>
                        <tr>
                            <td>
                                <a href="/user/external/<?php echo $User->getId(); ?>/edit"><?php echo $User->firstname . " " . $User->surname; ?></a>
                            </td>
                            <td style="line-height: 0;" class="align_c">
                                <a href="">
                                    <img src="/assets/img/icons/delete.png" class="icon delete_tr">
                                    <input type="hidden" name="user_id[]" value="<?php echo $User->getId(); ?>" />
                                </a>
                            </td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
                <ul style="margin-top:5px;">
                    <li class="button">
                        <input type="submit" value="Opslaan" class="fancy_button" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">

    window.addEvent('domready', function() {

        $$("img.delete_tr").addEvent('click', function(e) {
            if (e) {
                e.stop();
            }
            this.getParent('tr').destroy();
        });

        // html table for users
        var table = new HtmlTable($('table_sort'), {sortIndex: null, sortable: true, zebra: true, classZebra: 'odd'});

        // autocompleter implement
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

        // user handler
        var userHandler = new Autocompleter.Request.JSON($('user_search_string'), '/json/search/externaluser', {
            'selectMode': false,
            'filterSubset': true,
            'minLength': 2,
            'indicatorClass': 'autocompleter-loading',
            'onSelection': function(input, li) {
                $('user_id').set('value', li.getFirst('span').get('rel'));
            }
        });

        $('add_user').addEvent('click', function(e) {
            if (e) {
                e.stop();
            }
            var a = new Element('a').adopt(
                new Element('img', {'src': '/assets/img/icons/delete.png', 'class': 'icon'}),
                new Element('input', {'type': 'hidden', 'name': 'user_id[]', 'value': $('user_id').get('value')})
            ).addEvent('click', function(e) {
                if (e) {
                    e.stop();
                }
                this.getParent('tr').destroy();
            });
            var rows = table.push([
                {'content': new Element('a', {'href': '/user/external/' + $('user_id').get('value') + '/edit', 'text': $('user_search_string').get('value')})},
                {'content': a, 'properties': {'style': 'line-height:0;', 'class': 'align_c'}}
            ]);
            $(rows.tr).addEvents({
                'mouseenter': function(e) {
                    this.addClass('row_hover');
                },
                'mouseleave': function(e) {
                    this.removeClass('row_hover');
                }
            });
            $('user_search_string').erase('value');
            $('user_id').erase('value');
        });

    });

</script>

<?php

echo $this->render("footer.php");