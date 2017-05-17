<?php
session_start();
require_once('class/db.class.php');
require_once('class/common.php');

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();

$nav = array(
	'search' => array('Search', 'search.php'),
	'predef-queries' => array('Predefined Queries', 'predef-queries.php'),
	'insert-delete' => array('Insert / Delete', 'insert-delete.php')
);

$page = (isset($_GET['p'])) ? $_GET['p'] : "search";
$page = str_replace('~', "/", $page);
$page = (@file_exists('inc/'.$page.'.php')) ? $page : "search";
$page = str_replace('/', "~", $page);
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- meta -->
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">		
		<meta http-equiv="description" content="<?php echo $_SESSION['PARAM_DESCRIPTION']; ?>" />
		<meta http-equiv="keywords" content="<?php echo $_SESSION['META_KEYWORDS']; ?>" />

		<!-- title -->
		<title></title>
		
		<link href="img/favicon.png" type="image/png" rel="icon">

		<link rel="stylesheet" id="googlewebfonts-css" href="css/css.css" type="text/css" media="all">
		<link rel="stylesheet" id="style-css" href="css/style.css" type="text/css" media="all">
		<link rel="stylesheet" id="contact-form-7-css" href="css/styles.css" type="text/css" media="all">
		<link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.3.custom.min.css" type="text/css"		<link rel="stylesheet" href="css/jquery.contextMenu.min.css" type="text/css" media="all">

	   
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
		<?php if(!isset($_GET['p'])) { ?>
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
    	<?php
    	$MyDirectory = (file_exists('img/bg/'.$page."/")) ? opendir('img/bg/'.$page."/") : false;
		
		$bgList = array();
		
		if($MyDirectory!=false) {
			while($Entry = @readdir($MyDirectory)) {
				if($Entry != '.' && $Entry != '..' && substr($Entry, 0,2)!="x_") {
					$bgList[] = $page."/".$Entry;
				} 
			}
		} else {
			$bgList[] = "default.jpg"; 
        }

		
		$idxEntry = 0;
		foreach($bgList as $bg) { $idxEntry++; ?>
       		<div style="
           	<?php if($idxEntry>1) {?>display: none;<?php } ?>
            opacity: 1;
            background-image: url('img/bg/<?php echo $bg; ?>');
            -ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src='img/bg/<?php echo $bg; ?>', sizingMethod='scale');
  			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src='img/bg/<?php echo $bg; ?>', sizingMethod='scale');
            z-index: -<?php echo (9+$idxEntry); ?>;" class="background-image" <?php if($idxEntry==1) {?>current="1"<?php } ?>></div>
        <?php	
		}
		?>
        
        <?php
		$patternAllowed = array("search", "history", "sejours-linguistiques","cours-appui");
		if(in_array($page, $patternAllowed)) {?>
        <div id="background-pattern"></div>
        <?php } ?>
        
        <?php if(!isset($_GET['p'])) { ?>
        <div style="
        opacity: 1;
        background-image: url('img/bg/loader-bg.jpg');
        -ms-filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src='img/bg/outer_space_Wallpaper.jpg', sizingMethod='scale');
        filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src='img/bg/outer_space_Wallpaper.jpg', sizingMethod='scale');
        z-index: -8;" class="background-image init"></div>
        <?php } ?>
        
        <div id="background-overlay" style="background-color:transparent; opacity:0"></div>
        
        <div style="display: block; opacity: 0; bottom: 462.05px; transform: matrix3d(0.9, 0, 0, 0, 0, -0.9, 0, 0, 0, 0, -0.9, 0, 0, 0, 0, 1); display:none" id="background-loader">
        	<div style="width: 100%;"></div>
        </div>
    </div>


<div id="container">
	
    <header>
        <a id="header-logo" href="?p=home">
            <img alt="ComicsDB" src="img/logo.png">
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
            <img src="img/logo.png" alt="">
        </a>
    
        <div id="aside-nav">
            <nav class="menu-demo-menu-container">
                <ul id="menu-demo-menu" class="menu">
                <?php
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
                ?>
                </ul>
            </nav>
        </div>
    </aside>



    <div id="content">
    <?php
	$page = str_replace('~', "/", $page);
	include_once('inc/'.$page.".php");
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