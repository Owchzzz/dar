<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Department of Agrararion Reform - DAR</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"> -->
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/owl.carousel.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/owl.theme.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/normalize.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/meanmenu.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/main.css">
    <!-- educate icon CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/educate-custon-icon.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/calendar/fullcalendar.print.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets')?>/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/css/responsive.css">
    <!-- modernizr JS
		============================================ -->
    <script src="<?=base_url('assets');?>/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- Expose global routing to js-->
    <script>
      window.route = function(x) {
        return "<?=base_url()?>"+x;
      }
    </script>
     <!-- Custom CSS
    =========================================== -->
    <script src="<?=base_url('assets')?>/js/dar/customapp.js"></script>
</head>

<body>

    <!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
    <!-- Start Left menu area -->
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header" style="margin-top:10px; padding-bottom:11px;border-bottom:1px solid #fafafa;">
                <a href="index.html" style="font-weight:bold;letter-spacing:2;color:white;background-color:#0060ED;font-size:28px;padding:4px 45px; ">DAR</a>
                <!-- <strong><a href="index.html"><img src="<?=base_url('assets');?>/img/logo/logosn.png" alt="" /></a></strong> -->
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">
                        
                        <li class="">
                            <a class="has-arrow" href="">
                                <span class="fa fa-2x fa-columns icon-wrap"></span>
                                <span class="mini-click-non">Dashboard</span>
                            </a>
                        </li>
                        <li class="">
                          <a class="has-arrow" href="<?=base_url('location');?>">
                              <span class="fa fa-2x fa-map icon-wrap"></span>
                              <span class="mini-click-non">Fields</span>
                            </a>
                          </li>
                        <li class="">
                            <a class="has-arrow" href="<?=base_url('surveys');?>">
                                <span class="fa fa-2x fa-files-o icon-wrap"></span>
                                <span class="mini-click-non">Surveys</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
    <!-- Start of all content wrapper -->
    <div class="all-content-wrapper">

      <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html">DAR</a>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('menu-bar');?>