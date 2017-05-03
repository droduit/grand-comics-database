<?php
session_start();
require_once('class/db.class.php');

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();


$nav = array(
	'home' => array('Accueil', 'home.php'),
	'page-1' => array('Page 1', 'page-1.php', array(
		'page-1~suite1' => array("sous page 1", 'sous-page-1.php'),
		'page-2~suite2' => array("sous page 2", 'sous-page-2.php')
	)),
	'page-2' => array('Page 2', 'page-2.php')
);

$page = (isset($_GET['p'])) ? $_GET['p'] : "home";
$page = str_replace('~', "/", $page);
$page = (@file_exists('inc/'.$page.'.php')) ? $page : "home";
$page = str_replace('/', "~", $page);
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- meta -->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		
		<?php if($_SESSION['MOBILE']) { ?>
			<meta name="viewport" content="width=device-width,user-scalable=0">
			<meta name="apple-mobile-web-app-capable" content="yes">
			<meta name="apple-mobile-web-app-status-bar-style" content="black">
			<?php if(!$_SESSION['IPAD']) { ?>
				<meta content="width=device-width,   user-scalable=0;" name="viewport" />
			<?php } ?>
		<?php } ?>
		
		<meta http-equiv="description" content="<?php echo $_SESSION['PARAM_DESCRIPTION']; ?>" />
		<meta http-equiv="keywords" content="<?php echo $_SESSION['META_KEYWORDS']; ?>" />

		<!-- title -->
		<title></title>
		
		<link href="img/favicon.png" type="image/png" rel="icon">
		<link rel="stylesheet" id="contact-form-7-css" href="css/styles.css" type="text/css" media="all">
		<link rel="stylesheet" id="googlewebfonts-css" href="css/css.css" type="text/css" media="all">
		<link rel="stylesheet" id="prettyphoto-css" href="css/prettyPhoto.css" type="text/css" media="all">
		<link rel="stylesheet" id="style-css" href="css/style.css" type="text/css" media="all">
		<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all">
		<link rel="stylesheet" href="css/tipsy.css" type="text/css" media="all">

	   
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="js/jquery.tipsy.js"></script>
		<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.common.js"></script>
		<?php if(!isset($_GET['p']) || !$_SESSION['MOBILE']) { ?>
		<script type="text/javascript" src="js/jquery-animate-css-rotate-scale.js"></script>
		<?php } ?>
		
		 <!--[if lte IE 8]>
		<link rel="stylesheet" href="css/ie8lte.css" type="text/css" media="all">
		<script type="text/javascript" src="js/reset.ie8lte.js"></script>
		<script src="js/html5.js"></script>
		<![endif]-->
	</head>

<body>
<div id="wrapper">
    <div id="background">
    	
       
        <div id="background-overlay" style="background-color:transparent; opacity:0"></div>
        
        <div style="display: block; opacity: 0; bottom: 462.05px; transform: matrix3d(0.9, 0, 0, 0, 0, -0.9, 0, 0, 0, 0, -0.9, 0, 0, 0, 0, 1); display:none" id="background-loader">
        	<div style="width: 100%;"></div>
        </div>
    </div>


<div id="container">
	
    <header>
        <a id="header-logo" href="?p=home">
            <img alt="Visa-Centre" src="img/logo.png">
        </a>
    
        <div id="header-select">
            <div id="header-select-content">
                <span class="header-select-selected">
                    <strong><?php echo ($nav[$page][0]==NULL) ? $nav[substr($page, 0, strpos($page,"~"))][2][$page][0] : $nav[$page][0]; ?></strong>
                    <div class="selectNav"><img src="img/slctNavDown.png" /></div>
                </span>
                
                <div class="pages" style="display:none">
                	<?php
					foreach($nav as $nItem => $n) {?>
                        <a href="?p=<?php echo $nItem; ?>"> <span class="header-select-level-0"><?php echo $n[0]; ?></span></a>
                        <?php
                        if(count($n)>2) {
                            foreach($n[2] as $sItem => $s) {?>
                                <a href="?p=<?php echo $sItem; ?>"><span class="header-select-level-1"><?php echo $s[0]; ?></span></a>
                            <?php
                            }
                        }
					}
					?>
                </div>
            </div>
        </div>
    </header>

    <aside>
        <a data-climb-history-set="true" href="#" id="aside-logo">
            <!-- <img src="img/logodb.png" alt=""> -->
        </a>
    
        <div id="aside-nav">
            <nav class="menu-demo-menu-container">
                <ul id="menu-demo-menu" class="menu">
                <?php
				/*
                foreach($nav as $nItem => $n) {
                    ?>
                    <li id="menu-item-49" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-49 <?php if($page==$nItem) { echo 'nav-sel'; } ?>">
                        <a href="?p=<?php echo $nItem; ?>"><?php echo $n[0]; ?></a>
                        <?php
                        if(count($n)>2) { ?>
                        <ul class="sub-menu">
                            <?php
                            foreach($n[2] as $sItem => $s) { ?>
                            <li id="menu-item-74" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-74 <?php if($page==$sItem) { echo 'nav-sel'; } ?>">
                                <a href="?p=<?php echo $sItem; ?>"><?php echo $s[0]; ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                }
				*/
				$files = array_diff(scandir("./comics"), array('.', '..'));
				foreach($files as $f) {
					if(strstr($f, ".csv") > -1) {?>
					<li id="menu-item-49" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-49 <?php if($page==$nItem) { echo 'nav-sel'; } ?>">
                        <a href="chunker.php?p=<?php echo $f; ?>"><?php echo $f; ?></a>
					</li>
				<?php 
					}
				}
                ?>
                </ul>
            </nav>
        </div>
    </aside>



    <div id="content">
    <?php
	/*
	$page = str_replace('~', "/", $page);
	include_once('inc/'.$page.".php");
	*/
	?>
    
    <!--[if lte IE 8]>
    <?php if($page=="home") { ?>
    <div id="ie-obsolete">
        <div style="width:74%">
        <strong>IMPORTANT</strong><br><span style="color:#a00">Votre navigateur web se fait très vieux !</span> Ce site internet utilise les dernières technologies du web et votre navigateur, êtant obsolète, n'est pas en mesure de l'afficher correctement.<br><span style="color:#000">Pour profiter pleinement de la puissance des nouvelles technologies et du contenu de ce site, veuillez télécharger un navigateur plus récent, tel que <a href="http://www.mozilla.org/fr/firefox/features/" style="color:#a00">Mozilla Firefox</a>.</span>
        </div>
    </div>
    <?php } ?>
    <![endif]-->
    </div> 
   
        
       
    </div> <!-- /container -->
</div> <!-- /wrapper -->

<section style="opacity: 1; display: none;" id="loader">
	<div id="loader-container">
		<div style="opacity: 0; transform: matrix(1.25, 0, 0, 1.25, 0, 0); bottom: -70.05px;" id="loader-content"><span style="opacity: 0.253524;">Chargement</span></div>
	</div>
</section>

</body>
</html>