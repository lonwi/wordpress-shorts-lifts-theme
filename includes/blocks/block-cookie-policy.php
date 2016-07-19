<?php
if(isset($_COOKIE['shortscookieenable'])){
	$cookie_enabled = $_COOKIE['shortscookieenable'];
}else {
	$cookie_enabled = false;
}
?>
<?php if(isset($cookie_enabled) && $cookie_enabled != 1):?>
<div class="block-cookie-policy clearfix">
	<div class="container clearfix">
    <p><?php printf(__('Cookies improve the way our website works, by using this website you are agreeing to our use of cookies.<br>For more information see our <a href="%s">cookie policy</a>.','shorts'), get_permalink('138'));?></p>
    <a href="#accept-cookies" class="cookie-notice-close">Accept</a>    
    </div>
</div>
<?php endif;?>