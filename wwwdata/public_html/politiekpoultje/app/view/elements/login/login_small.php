 
<?php
    $action = URL_BASE.'deelnemers/login';
    $logout = URL_BASE.'deelnemers/logout';
   if(!$Session->get('User.id')):
 ?>

            <form class="navbar-form pull-right" method="post" id="login" action="<?php echo $action ?>">
              <input class="span2" type="text" name="mail" placeholder="E-Mail">
              <input class="span2" type="password" name='password' placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form>
<?php
   else:
?>

   <span align="right">Welkom, <?php echo  $Session->get('User.nickname'); ?> <a href="<?php echo $logout ?>"> afmelden</a></span>
    
<?php endif; ?>
