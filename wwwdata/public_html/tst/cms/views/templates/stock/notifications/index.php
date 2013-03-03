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
                <li class="current"><a href="/stock/notifications"><span>Overzicht</span></a></li>
                <li><a href="/stock/notifications/archive"><span>Archief</span></a></li>
                <li><a href="/stock/notifications/add"><span>Toevoegen</span></a></li>
            </ul>
            <form class="form_layout" method="post" action="">
            <table width="100%" id="table_sort" class="table_data">
                <colgroup>
                    <col style="width: 15%;" />
                    <col style="" />
                    <col style="" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                    <col style="width: 1%;" />
                </colgroup>
                <thead>
                    <tr>
                        <th class="align_l">Klant</th>
                        <th class="align_l">Product</th>
                        <th>Aantal</th>
                        <th>Verwacht</th>
                        <th>Verwerk</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($Notifications as $Notification): ?>
                    <tr>
                        <td><a href="/client/<?php echo $Notification->getClient()->getId(); ?>"><?php echo $Notification->getClient()->name; ?></a></td>
                        <td><a href="/product/<?php echo $Notification->getProduct()->getId(); ?>"><?php echo $Notification->getProduct()->code . ": " . $Notification->getProduct()->name; ?></a></td>
                        <td class="align_c"><?php echo $Notification->amount; ?></td>
                        <td class="align_c" style="white-space:pre"><?php echo $Notification->expected; ?></td>
                        <td class="align_c" style="line-height:0" rowspan="2"><input type="checkbox" name="notification[<?php echo $Notification->getId(); ?>][checked]" /></td>
                    </tr>
                    <tr>
                        <td class="align_r">Notitie:</td>
                        <td><input type="text" class="text" name="notification[<?php echo $Notification->getId(); ?>][remark]" /></td>
                        <td class="align_r">Ontvangen:</td>
                        <td style="white-space:pre"><input type="text" class="text date" id="calendar_<?php echo $Notification->getId(); ?>" name="notification[<?php echo $Notification->getId(); ?>][received]" /></td>
                    </tr>
                    <script type="text/javascript">
                        window.addEvent('domready', function() {
                            new Calendar({calendar_<?php echo $Notification->getId(); ?>: 'Y-m-d'}, {classes: ['dashboard'], direction: 0});
                        });
                    </script>
<?php endforeach; ?>
                </tbody>
            </table>
            <ul style="margin-top:2px">
                <li class="button">
                    <input type="submit" value="Verwerk" class="fancy_button" />
                </li>
            </ul>
            </form>
        </div>
    </div>
    <?php echo $this->render("navigation.php"); ?>
</div>

<?php

echo $this->render("footer.php");