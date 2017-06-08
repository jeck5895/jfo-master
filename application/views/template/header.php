<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<!-- Meta tags for Search Engine -->
		<meta property="og:title" content="<?php echo  $title; ?>" />
		<meta property="og:image" content="<?php echo base_url('assets/images/app/jfo_logo_mini.png'); ?>" />
		<meta property="og:url" content="http://jobfair-online.net">
		<meta property="og:site_name" content="Jobfair Online" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="shortcut icon" href="<?php echo base_url('assets/images/app/jfo_logo_mini.png')?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/layouts.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ripple.min.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap4/css/bootstrap.css');?>" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css')?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>">	
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:200i" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/dropzone/dropzone.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/cropper.css');?>" />

		<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css" rel="stylesheet">
		<!-- <link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet"> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.1/jquery-confirm.min.css">
	</head>
	<body>
		<div class="wrapper">
			<div id="load" class="loader-wrapper">
				<h6>jobfair-online.net</h6>
				<div class="loader"></div>

				<div class="loader-section section-left"></div>
				<div class="loader-section section-right"></div>				
			</div>
			
