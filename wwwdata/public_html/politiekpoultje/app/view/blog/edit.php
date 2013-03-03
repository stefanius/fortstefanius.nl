<form method="post" id="edit_page" action="">
    <dl>
        <dt>Titel:</dt> <dd><input type="text" name="title" value="<?php echo $Page->title ?>"></dd><br/>
        <dt>Url:</dt>  <dd><input type="text" name="urlpart" value="<?php echo $Page->urlpart ?>"></dd><br/>
        <dt>Content:</dt> <dd><textarea class="ckeditor" name="content"><?php echo $Page->content ?></textarea></dd><br/>

        <input type="hidden" name="id" value="<?php echo $Page->id ?>">
        <input type="submit" name="save" value="Opslaan" />
    </dl>
</form>

