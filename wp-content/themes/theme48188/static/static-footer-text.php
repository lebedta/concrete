<?php /* Static Name: Footer text */ ?>
<div id="footer-text" class="footer-text">
	<?php $myfooter_text = of_get_option('footer_text'); ?>
	
	<?php if($myfooter_text){?>
		<?php echo of_get_option('footer_text'); ?>
    <?php } ?>
    Copyright &copy; <?php echo date ('Y'); ?>  Все права защищены
    <!--    else { ?>-->
<!--		&copy; --><?php //echo date ('Y'); ?><!-- | <a href="--><?php //echo home_url(); ?><!--/privacy-policy/" title="--><?php //echo theme_locals('privacy_policy'); ?><!--">--><?php //echo theme_locals("privacy_policy"); ?><!--</a>-->
<!--	--><?php //} ?>
<!--	--><?php //if( is_front_page() ) { ?>
<!--		More Construction Company WordPress Themes at <a rel="nofollow" href="http://www.templatemonster.com/category/construction-company-wordpress-themes/" target="_blank">TemplateMonster.com</a>-->
<!--	--><?php //} ?>
</div>