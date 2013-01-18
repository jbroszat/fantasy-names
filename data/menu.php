<?php
$menu = array();
$menu['main'] = array();
$menu['main'][] = array('label' => 'Menschen', 'link' => 'menu=menschen');
$menu['main'][] = array('label' => 'Zwerge', 'link' => 'cat=zwerg',
	'filter' => 'rogolan');
$menu['main'][] = array('label' => 'Elfen', 'link' => 'cat=elf',
	'filter' => 'isdira');
$menu['main'][] = array('label' => 'Orks', 'link' => 'cat=ork');
$menu['main'][] = array('label' => 'Goblins', 'link' => 'cat=goblin');
$menu['main'][] = array('label' => 'Trolle', 'link' => 'cat=troll');
$menu['main'][] = array('label' => 'Zyklopen', 'link' => 'cat=altguldenlandisch');
$menu['main'][] = array('label' => 'Grolme', 'link' => 'cat=grolm');
$menu['main'][] = array('label' => 'Yetis', 'link' => 'cat=yeti');
$menu['main'][] = array('label' => 'Echsenmenschen', 'link' => 'cat=echse',
	'filter' => 'achaz');
$menu['main'][] = array('label' => 'Drachen', 'link' => 'cat=drache');

$menu['menschen'] = array();
$menu['menschen'][] = array('label' => 'Garethi','link' => 'menu=garethi',
	'filter' => 'garethi svelltal bornland schwarztobrien weiden andergast nostria albernia garethien almada maraskan horathi liebliches feld brabak al\'anfa aranien brabak brabaci horathi horasreich');
$menu['menschen'][] = array('label' => 'Tulamidisch/Novadisch','link' => 'cat=tulamidisch',
	'info' => 'Für Khomwüste und Umgebung und von Selem bis Nordaranien.');
$menu['menschen'][] = array('label' => 'Thorwalsch','link' => 'cat=thorwalsch');
$menu['menschen'][] = array('label' => 'Aranien','link' => 'cat=aranien');
$menu['menschen'][] = array('label' => 'Norbardisch (Alaanii)','link' => 'cat=norbardisch');
$menu['menschen'][] = array('label' => 'Nivesisch (Nujuka)','link' => 'cat=nivesisch');
$menu['menschen'][] = array('label' => 'Mohisch','link' => 'cat=mohisch',
	'filter' => 'mohisch moha utulu tocamuyac');
$menu['menschen'][] = array('label' => 'Ferkina','link' => 'cat=ferkina',
	'info' => 'Für die wilden tulamidischen Bergvölker in Raschtulswall und Khoramgebirge.');
$menu['menschen'][] = array('label' => 'Zahori','link' => 'cat=zahori',
	'info' => 'Tulamidischstämmiges Nomaden- und Gauklervolk in Almada.');
$menu['menschen'][] = array('label' => 'Kemi (trahelisch)','link' => 'cat=kemi',
	'filter' => 'kemi trahelisch trahelien');
$menu['menschen'][] = array('label' => 'Fjarningisch','link' => 'cat=fjarningisch',
	'info' => 'Sprache der Eisbarbaren; sie selbst nennen sich "Frundengar."');
$menu['menschen'][] = array('label' => 'Gjalskerländisch','link' => 'cat=gjalskerlandisch',
	'info' => 'Für die gjalsker Barbaren nördlich des Orklandes.');
$menu['menschen'][] = array('label' => 'Zulchammaqra','link' => 'cat=zulchammaqra',
	'info' => 'Sprache der Trollzacker Barbaren oder "Kurga."');
$menu['menschen'][] = array('label' => 'Bosparano','link' => 'cat=bosparano');
$menu['menschen'][] = array('label' => 'Urtulamidya','link' => 'cat=urtulamidya');
$menu['menschen'][] = array('label' => 'Altgüldenländisch','link' => 'cat=altguldenlandisch',
	'info' => 'Zyklopeninseln; für Menschen und Zyklopen gleichermaßen.');

$menu['garethi'] = array();
$menu['garethi'][] = array('label' => 'Svelltaler Dialekt', 'link' => 'cat=svelltal');
$menu['garethi'][] = array('label' => 'Bornländer Dialekt', 'link' => 'cat=bornland');
$menu['garethi'][] = array('label' => 'Weidener Dialekt', 'link' => 'cat=weiden',
	'info' => 'Auch für Weiß-Tobrien, Greifenfurt und Teile Andergasts.');
$menu['garethi'][] = array('label' => 'Schwarztobrien', 'link' => 'cat=schwarztobrien');
$menu['garethi'][] = array('label' => 'Andergassischer Dialekt', 'link' => 'cat=andergast');
$menu['garethi'][] = array('label' => 'Nostrianischer Dialekt', 'link' => 'cat=nostria');
$menu['garethi'][] = array('label' => 'Albernischer Dialekt', 'link' => 'cat=albernia');
$menu['garethi'][] = array('label' => 'Zentrales Mittelreich', 'link' => 'cat=garethien',
	'info' => 'Garethien, Darpatien, Nordmarken, Kosch');
$menu['garethi'][] = array('label' => 'Almadaner Dialekt', 'link' => 'cat=almada');
$menu['garethi'][] = array('label' => 'Maraskanisch', 'link' => 'cat=maraskan');
$menu['garethi'][] = array('label' => 'Horathi', 'link' => 'cat=horathi',
	'info' => 'Liebliches Feld von Grangor bis Drôl.');
$menu['garethi'][] = array('label' => 'Brabaci', 'link' => 'cat=brabak',
	'info' => 'Für Al\'Anfa und die anderen Stadtstaaten südlich von Drôl und Selem.');
?>
