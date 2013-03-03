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
        <div class="box">
            <h1>Klant details</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:2px">
                <li><a href="/client/<?php echo $Client->getId(); ?>/details"><span>Gegevens</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/products"><span>Producten</span></a></li>
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/orders"><span>Orders</span></a></li>
            </ul>
            <table width="100%" id="table_sort" class="table_data">
                <colgroup>
                    <col style="width: 1%;" />
                    <col style="" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="align_l">ID</th>
                        <th class="align_l">Ontvanger</th>
                        <th>Prod.</th>
                        <th>Status</th>
                        <th style="white-space:pre">Toegevoegd</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($Orders as $Order): $Receiver = $Order->getReceiver(); $status = $Order->getStatus(); ?>
                    <tr>
                        <td><a href="/order/<?php echo $Order->getId(); ?>"><?php echo sprintf("%010u", $Order->getId()); ?></a></td>
                        <td class="align_l"><?php echo $Receiver->firstname . " " . $Receiver->surname; ?></td>
                        <td class="align_c"><?php echo $Order->getProductsAmount(); ?></td>
                        <td class="align_c" style="white-space:pre"><?php echo ($status->is_fulfilled ? "voltooid" : ($status->is_processed ? "in verwerking" : "open")); ?></td>
                        <td class="align_c" style="white-space:pre"><?php echo $status->is_open; ?></td>
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
    });
</script>

<?php

echo $this->render("footer.php");