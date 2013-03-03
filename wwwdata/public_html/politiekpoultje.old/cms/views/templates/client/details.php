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
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/details"><span>Gegevens</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/products"><span>Producten</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/rma"><span>Stuk</span></a></li>
            </ul>
            <table class="table_info">
                <colgroup>
                    <col style="width:15%" />
                    <col />
                </colgroup>
                <tr>
                    <td class="cell">ID:</td>
                    <td><?php echo $Client->getId(); ?></td>
                </tr>
                <tr>
                    <td class="cell">Key:</td>
                    <td><?php echo $Client->hash; ?></td>
                </tr>
                <tr>
                    <td class="cell">Naam:</td>
                    <td><?php echo $Client->name; ?></td>
                </tr>
                <tr>
                    <td class="cell">Email:</td>
                    <td><?php echo $Client->email; ?></td>
                </tr>
                <tr>
                    <td class="cell">Bezoekadres:</td>
                    <td style="white-space:pre"><?php echo $Client->address; ?></td>
                </tr>
                <tr>
                    <td class="cell">Factuuradres:</td>
                    <td style="white-space:pre"><?php echo $Client->address_invoice; ?></td>
                </tr>
                <tr>
                    <td class="cell">Retouradres:</td>
                    <td style="white-space:pre"><?php echo $Client->address_retour; ?></td>
                </tr>
                <tr>
                    <td class="cell">Stuklocatie:</td>
                    <td style="white-space:pre"><?php echo $Client->stuklocatie; ?></td>
                </tr>
                <tr>
                    <td class="cell">Rekeningnummer:</td>
                    <td style="white-space:pre"><?php echo $Client->ban; ?></td>
                </tr>
            </table>
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