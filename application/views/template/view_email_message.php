<!DOCTYPE html>
<html>
<head>
  <title>Jobfair-Online</title>
  <!-- Meta tags for Search Engine -->
  <meta property="og:title" content="Jobfair-Online Activation" />
  <meta property="og:image" content="<?php echo base_url('assets/images/logo/jobfair-online.png'); ?>" />
  <meta property="og:url" content="http://jobfair-online.net">
  <meta property="og:site_name" content="Jobfair Online" />

  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/css/customize.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css');?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css')?>">  
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/logo/people-link.ico')?>" />
</head>
<body style="background-color: rgba(225, 242, 254, 0.06);/*#ECEFF1*/">

<section class="content-header" style="margin-top: 2.5rem;">

</section>
<section class="content">
 <div class="container">
  <div class="row ">
    <div class="jumbotron" style="background-color:  #dff0d8;">
      <h1 class="display-3" style="color:#494545;"> <?php echo $header; ?> <i class="fa fa-exclamation-circle"></i> </h1>
      <hr>
      <center>
        <strong><p class="lead" style="color:#494545;"><?php echo $message;?></p></strong>
        <p><a class="btn btn-lg btn-success" href="<?php echo base_url('Authenticate/')?>" role="button">Got it!</a></p>
      </center>  
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
</section>
</body>
</html>

