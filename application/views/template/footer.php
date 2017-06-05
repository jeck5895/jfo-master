	</div>
	
		<?php if((isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ap") || !isset($_COOKIE['_typ'])):?>
			<footer class="footer-main">
				<div class="container">
					<img src="<?=base_url('assets/images/logo/jfo_logo_footer.png')?>">
				</div>
			</footer>
		<?php elseif(isset($_COOKIE['_typ']) && $_COOKIE['_typ'] == "ep"):?>
			<footer class="footer-purple">
				<div class="container">
					<img src="<?=base_url('assets/images/logo/jfo_logo_footer.png')?>">
				</div>
			</footer>
		<?php endif;?>    
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/plugins/jquery.mustache.js')?>"></script>

	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap4/js/bootstrap.min.js');?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/cropper-master/dist/cropper.js');?>"></script>
	
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php //echo base_url('assets/js/jquery-validate.bootstrap-tooltip.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/localstoragedb.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/bootstrap-notify.min.js');?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-filestyle/src/bootstrap-filestyle.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/select2/select2.full.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/app.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.inputmask.bundle.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/parallax/parallax.min.js');?>"></script>
	
	<!-- DataTable for bootstrap 4 -->
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script><!-- 
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script> -->
	
	<!-- jquery confirm -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.1/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/plugins/moment-with-locales.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/plugins/jquery.bootpag.js')?>"></script>
	<script src="//js.pusher.com/3.1/pusher.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript">
		$('body').scrollspy({ target: '.navbar' });
		$('.parallax-window').parallax();
	</script>
</body>
</html>