<?php
// load data file
require_once('data/menu.php');
require_once('data/names.php');
require_once('data/places.php');
require_once('data/functions.php');

// processing parameters
if (isset($_GET)) {
	if (isset($_GET['menu'])) {
		if ($_GET['menu'] == 'menschen') {
			$page = 'menu-menschen';
			$title = 'Menschen';
		}
		if ($_GET['menu'] == 'garethi') {
			$page = 'menu-garethi';
			$title = 'Garethi';
		}
	}
	if (isset($_GET['cat'])) {
		if (isset($names[$_GET['cat']])) {
			$cat = $_GET['cat'];
			$page = 'cat-'.$cat;
			$title = $names[$cat]['label'];
		}
	}
}

if (!isset($page)) {
	$page = 'menu-main';
	$title = 'Buch der Namen';
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Buch der Namen<?php
			if ($page != 'menu-main') print(" - $title");
		?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
	<style type="text/css">
	h4.list {
		margin:0.1em 0;
	}
	p.list {
		margin: -0.2em 0 0.2em;
	}
	</style>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div data-role="page" data-add-back-btn="true" data-back-btn-text="Zurück" id="<?php print($page); ?>" data-theme="a">
		<div data-role="header" data-position="fixed" id="header" data-theme="a">
			<h1><?php
				print $title;
			?></h1>
		</div><!-- header -->
		<div data-role="content" id="content">
<?php
// main menu
if (preg_match('/^menu/',$page)) {
	$e = explode('-',$page);
	$e = $e[1];
	print('<ul data-role="listview" data-filter="true" data-filter-theme="a" data-filter-placeholder="Filter ..." data-inset="false" data-theme="a">');
	for ($i = 0; $i < count($menu[$e]);$i++) {
		if (preg_match('/menu/',$menu[$e][$i]['link'])) $arrow = ' data-icon="forward"';
			else $arrow = '';
		if (isset($menu[$e][$i]['info'])) $info = '<p class="list">'.$menu[$e][$i]['info'].'</p>';
			else $info = '';
		if (isset($menu[$e][$i]['filter'])) $filter = ' data-filtertext="'.$menu[$e][$i]['filter'].'"';
			else $filter = '';
		print('<li'.$arrow.$filter.'><a data-transition="slide" href="?'.$menu[$e][$i]['link'].'"><h4 class="list">'.$menu[$e][$i]['label'].'</h4>'.$info.'</a></li>');
	}
	print('</ul>');
} // main

// cat page
if (preg_match('/^cat/',$page)) {
	print makeCatPage($cat);
} // cat
?>
		</div><!-- /content -->
	<div data-role="footer" position="fixed" id="footer">
		<div data-role="navbar">
			<ul>
				<li><a href="?cat=home" data-icon="home">Start</a></li>
				<li><a href="#info" data-icon="info">Info</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	</div><!-- /page -->

        <div data-role="page" data-add-back-btn="true" data-back-btn-text="Zurück" id="info" data-theme="a">
		<div data-role="header" data-position="fixed" id="header" data-theme="a">
			<h1>Info</h1>
		</div><!-- header -->
		<div data-role="content" id="content">
			<p>Diese App beruht auf dem <a href="http://www.chizuranjida.de/dsa/dokumente/namen.pdf">Buch der Namen (PDF)</a>, das von Stephanie von Ribbeck zusammengestellt wurde. Es werden die Regeln und Richtlinien aus dieser Liste verwendet. Diese sind in keinem Fall verbindlich oder einzig gültig.</p>
			<p>Der Namensgenerator ist in erster Linie als Hilfsmittel für Meister gedacht, damit sie eine einfache und schnelle Möglichkeit haben, NSCs mit passenden Namen auszustatten. Für Spieler kann er natürlich auch als Ausgangspunkt für das Findes des Charakternamens dienen.</p>
			<p class="copy">DAS SCHWARZE AUGE, AVENTURIEN und DERE sind eingetragene Marken in Schrift und Bild der Ulisses Medien und Spiel Distribution GmbH oder deren Partner.</p>
		</div><!-- /content -->
	<div data-role="footer" position="fixed" id="footer">
		<div data-role="navbar">
			<ul>
				<li><a href="?cat=home" data-icon="home">Start</a></li>
				<li><a href="#info" data-icon="info">Info</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /footer -->
	</div><!-- /page -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
</body>
</html>
