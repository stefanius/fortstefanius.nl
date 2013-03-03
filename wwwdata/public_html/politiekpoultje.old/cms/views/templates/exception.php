<?php

echo $this->render("header.php");

?>

<div id="container" class="clearfix">
    <div id="main_content">
        <div class="box">
            <h1>Exception</h1>
            <p>Er heeft zich een fout voorgedaan. Hieronder volgt de melding (en bijbehorende backtrace).</p>
            <div style="margin:3em 1em 1em;border:1px solid #f99;background:#fee">
                <div id="exception" style="white-space:pre;padding:1em;font-size:14px;font-weight:bold;"><?php echo $exception->getMessage() . "\n"; ?></div>
                <div id="backtrace" style="display:none;white-space:pre;padding:1em;font-family:monospace;">In "<?php echo $exception->getFile(); ?>" op regel #<?php echo $exception->getLine() . "\n"; ?>

<?php echo $exception->getTraceAsString(); ?></div>
            </div>
            <p style="text-align:center"> <a href="javascript:toggleBacktrace()">Toon backtrace</a> | <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Keer terug naar de vorige pagina.</a></p>
        </div>
    </div>
    <?php if (Session::getInstance()->has("admin_id")): echo $this->render("navigation.php"); endif; ?>
</div>

<script type="text/javascript">
function toggleBacktrace()
{
    var target = $('backtrace');
    target.style.display = (target.style.display == 'none' ? '' : 'none');
}
</script>

<?php

echo $this->render("footer.php");