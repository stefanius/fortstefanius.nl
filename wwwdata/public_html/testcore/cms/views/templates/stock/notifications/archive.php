<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <ul class="master_tabs" id="loadlive" style="margin-bottom:0">
            <li><a href="/stock"><span>Voorraad</span></a></li>
            <li class="current"><a href="/stock/notifications"><span>Voormeldingen</span></a></li>
        </ul>
        <div class="box">
            <h1>Voormeldingen</h1>
            <ul class="master_tabs" id="loadlive" style="margin-bottom:2px">
                <li><a href="/stock/notifications"><span>Overzicht</span></a></li>
                <li class="current"><a href="/stock/notifications/archive"><span>Archief</span></a></li>
                <li><a href="/stock/notifications/add"><span>Toevoegen</span></a></li>
            </ul>
            <table width="100%" id="table_sort" class="table_data">
                <colgroup>
                    <col style="width: 15%;" />
                    <col style="" />
                    <col style="" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="align_l">Klant</th>
                        <th class="align_l">Code</th>
                        <th class="align_l">Product</th>
                        <th>Aantal</th>
                        <th>Verwacht</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($Notifications as $Notification): ?>
                    <tr>
                        <td><a href="/client/<?php echo $Notification->getClient()->getId(); ?>"><?php echo $Notification->getClient()->name; ?></a></td>
                        <td><a href="/product/<?php echo $Notification->getProduct()->getId(); ?>"><?php echo $Notification->getProduct()->code; ?></a></td>
                        <td><a href="/product/<?php echo $Notification->getProduct()->getId(); ?>"><?php echo $Notification->getProduct()->name; ?></a></td>
                        <td class="align_c"><?php echo $Notification->amount; ?></td>
                        <td class="align_c" style="white-space:pre"><?php echo $Notification->expected; ?></td>
                    </tr>
                    <tr>
                        <td class="align_r">Notitie:</td>
                        <td colspan="2"><?php echo $Notification->remark; ?></td>
                        <td class="align_r">Ontvangen:</td>
                        <td style="white-space:pre"><?php echo $Notification->received; ?></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<?php

echo $this->render("footer.php");