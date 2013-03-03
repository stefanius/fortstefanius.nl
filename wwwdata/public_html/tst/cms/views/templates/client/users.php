<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/client"><span>Overzicht</span></a></li>
            <li><a href="/client/add"><span>Toevoegen</span></a></li>
            <li><a href="/client/<?php echo $Client->getId(); ?>/edit/users"><span>Wijzigen</span></a></li>
            <li class="current"><a href="/client/<?php echo $Client->getId(); ?>"><span>Details</span></a></li>
        </ul>
        <div class="box">
            <h1>Klant details</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:2px">
                <li><a href="/client/<?php echo $Client->getId(); ?>/details"><span>Gegevens</span></a></li>
                <li class="current"><a href="/client/<?php echo $Client->getId(); ?>/users"><span>Gebruikers</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/products"><span>Producten</span></a></li>
                <li><a href="/client/<?php echo $Client->getId(); ?>/rma"><span>Stuk</span></a></li>
            </ul>
<?php if (count($Users)): ?>
            <table width="100%" id="table_sort" class="table_data">
                <colgroup>
                    <col style="" />
                    <col style="width: 20%;" />
                    <col style="width: 15%;" />
                    <col style="width: 15%;" />
                    <col style="width: 1%;" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="align_l">Naam</th>
                        <th>Email</th>
                        <th>Telefoon</th>
                        <th>Mobiel</th>
                        <th>Wijzig</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($Users as $User): ?>
	<?php if(!$User->is_deleted): ?>
                    <tr>
                        <td class="cell"><a href="/user/external/<?php echo $User->getId(); ?>/edit"><?php echo $User->firstname . " " . $User->surname; ?></a></td>
                        <td class="align_c"><?php echo $User->email; ?></td>
                        <td class="align_c"><?php echo $User->telephone; ?></td>
                        <td class="align_c"><?php echo $User->mobile; ?></td>
                        <td class="align_c" style="line-height:0"><a href="/user/external/<?php echo $User->getId(); ?>/edit"><img src="/assets/img/icons/pencil.png" class="icon" /></a></td>
                    </tr>
	<?php endif; ?>
<?php endforeach; ?>
                </tbody>
            </table>
<?php else: ?>
            <div class="box" style="margin-bottom:2px;border:1px solid #D99;background:#FEE;">
                <h1>Geen data</h1>
                <p>Er zijn geen gebruikers gekoppeld deze klant.</p>
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