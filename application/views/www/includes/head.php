<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="keywords" content="<?php echo @$com_keywords ?>"/>
<meta name="Description" Content="<?php echo @$com_description ?>"/>
<meta name="COPYRIGHT" content="Copyright (c) by <?php echo @$com_name ?>">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="yes">
<meta name="apple-mobile-web-app-title" content="加入主畫面">


<title><?php echo @$com_title ?></title>

<!--seo-->
    <meta property="og:title" content="<?php echo $com_title?>">
    <meta property="og:url" content="http://www.em66.net/">
    <meta property="og:image" content="<?php echo ASSETS_URL?>/www/images/logo.png">
    <meta property="og:site_name" content="<?php echo $com_title?>">
    <meta property="og:description" content="<?php echo @$com_description?>">
    <meta property="og:locale" content="zh_TW" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="<?php echo @$com_description?>" />
    <meta name="twitter:title" content="<?php echo $com_title?>" />
    <meta name="google-site-verification" content="KJssyA3r9cKFmL9XoZulGEeoigagzuq3lLQ66ZhTwXQ" />

<!--ico-->
<link rel="shortcut icon" href="<?php echo ASSETS_URL ?>/www/images/favico.ico"/>
<link rel="bookmark" href="<?php echo ASSETS_URL ?>/www/images/favico.ico"/>

<!-- Jquery -->
<script type="text/javascript" src="<?php echo ASSETS_URL ?>/www/plugins/jquery.min.js"></script>


<!-- Bootstrap core CSS -->
<link href="<?php echo ASSETS_URL ?>/www/bootstrap/css/bootstrap.css" rel="stylesheet">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>
<!-- Font Awesome CSS -->
<link href="<?php echo ASSETS_URL ?>/www/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
<!-- myfonts CSS -->
<link href="<?php echo ASSETS_URL ?>/www/fonts/webfonts/style.css" rel="stylesheet">
<!-- Plugins -->
<link rel="stylesheet" href="<?php echo ASSETS_URL ?>/www/plugins/fancyBox/jquery.fancybox.css">
<!-- service CSS -->
<link href="<?php echo ASSETS_URL ?>/www/css/service.css" rel="stylesheet" type="text/css">
<!-- mystyles CSS -->
<link href="<?php echo ASSETS_URL ?>/www/css/style.css" rel="stylesheet" type="text/css">

<!-- Vendor -->
<script src="<?php echo ASSETS_URL ?>/www/js/jquery.cookie.js"></script>

<?php $this->load->view("www/includes/base_script.php")?>


 <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127733004-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-127733004-7');
</script>
