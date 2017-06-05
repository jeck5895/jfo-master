	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/bootstrap4/js/bootstrap.min.js');?>"></script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-validate.bootstrap-tooltip.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/localstoragedb.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/bootstrap-notify.min.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/auth.js');?>"></script>
		<script type="text/javascript">
			var current_url = window.location.href; 
			$('ul.navbar-nav li a[href="'+ current_url +'"]').addClass('active');

			$('.dropdown').on('show.bs.dropdown', function() {
				$(this).find('.dropdown-menu').first().stop(true, true).fadeIn();
			});

			$('.dropdown').on('hide.bs.dropdown', function() {
				$(this).find('.dropdown-menu').first().stop(true, true).fadeOut();
			});
		</script>
	</body>
</html>