<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/client"><span>Overzicht</span></a></li>
            <li><a href="/client/add"><span>Toevoegen</span></a></li>
            <li><a href="/client/<?php echo $Client->getId(); ?>/edit"><span>Wijzigen</span></a></li>
            <li class="current"><a href="/client/<?php echo $Client->getId(); ?>"><span>Details</span></a></li>
        </ul>
        </ul>
        <div class="box">
            <h1>Klant details</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:2px">
                <li><a href="/client/<?php echo $Client->getId(); ?>/details"><span>Gegevens</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/products"><span>Producten</span></a></li>
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/rma"><span>Stuk</span></a></li>
            </ul>
<?php if (isset($message)): ?>
            <div class="box" style="margin-bottom:2px;border:1px solid #9D9;background:#EFE;">
                <h1>Succes</h1>
                <p><?php echo $message; ?></p>
            </div>
<?php endif; ?>
<?php if (count($RMAs)): ?>
            <form method="post" id="form_customers" class="form_layout" action="">
                <table width="100%" id="table_sort" class="table_data">
                    <colgroup>
                        <col style="width: 120px" />
                        <col />
                        <col style="width: 1%;" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="align_l">EAN</th>
                            <th class="align_l">Naam</th>
                            <th>Aantal</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($RMAs as $RMA): ?>
                        <tr>
                            <td><a href="/product/<?php echo $RMA->id; ?>"><?php echo $RMA->code; ?></a></td>
                            <td><a href="/product/<?php echo $RMA->id; ?>"><?php echo $RMA->name; ?></a></td>
                            <td class="align_c" style="line-height:0"><input class="align_c" name="products[<?php echo $RMA->id; ?>]" type="text" style="width:40px" value="<?php echo $RMA->amount; ?>" /></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
                <ul style="margin-top:5px; text-align:right">
                    <li class="button">
                        <input type="submit" value="Opslaan" class="fancy_button" />
                    </li>
                </ul>
            </form>
<?php else: ?>
            <div class="box" style="margin-bottom:2px;border:1px solid #D99;background:#FEE;">
                <h1>Geen data</h1>
                <p>Er zijn geen stuk producten bekend voor deze klant.</p>
            </div>
<?php endif; ?>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<script type="text/javascript">
    window.addEvent('domready', function(){
        new HtmlTable($('table_sort'), {sortIndex: null, sortable: true, zebra: true, classZebra: 'odd'});
    });
</script>

<?php

echo $this->render("footer.php");