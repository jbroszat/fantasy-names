<?php
require_once('data/names.php');
require_once('data/functions.php');

// processing parameters
if (isset($_GET)) {
	if (isset($_GET['cat'])) {
		if (isset($names[$_GET['cat']])) $cat = $_GET['cat'];
	}
	if (isset($_GET['num'])) {
		$num = intval($_GET['num']);
		if ($num < 1) $num = 1;
		if ($num > 25) $num = 25;
	}
	if (isset($_GET['gdr'])) $gdr = $_GET['gdr'];
		else $gdr = 'w';
}

$html = '';

switch ($cat) {
	case 'echse':;
	case 'grolm':;
	case 'ork':$html = makeSimpleNameList($cat,'w',$num);break;
	case 'yeti':;
	case 'nivesisch':;
	case 'fjarningisch':;
	case 'gjalskerlandisch':;
	case 'goblin':;
	case 'albernia':;
	case 'troll':;
	case 'altguldenlandisch':;
	case 'kemi':;
	case 'maraskan':;
	case 'urtulamidya':$html = makeSimpleNameList($cat,$gdr,$num);break;
	case 'norbardisch':;
	case 'schwarztorbrien':;
	case 'zahori':;
	case 'horathi':;
	case 'brabak':;
	case 'bornland':$html = makeSurnameList($cat,$gdr,$num);break;
	case 'elf':$html = makeIsdiraNameList($cat,$gdr,$num);break;
	case 'weiden':$html = makeWeidenNameList($cat,$gdr,$num,$_GET);break;
	case 'svelltal':$html = makeSvelltalNameList($cat,$gdr,$num);break;
	case 'andergast':$html = makeAndergastNameList($cat,$gdr,$num);break;
	case 'thorwalsch':$html = makeThorwalschNameList($cat,$gdr,$num);break;
	case 'zwerg':$html = makeRogolanNameList($cat,$gdr,$num);break;
	case 'almada':$html = makeAlmadaNameList($cat,$gdr,$num);break;
	case 'tulamidisch':$html = makeTulamidischNameList($cat,$gdr,$num,$_GET);break;
	case 'ferkina':$html = makeFerkinaNameList($cat,$gdr,$num);break;
	case 'zulchammaqra':$html = makeZulchammaqraNameList($cat,$gdr,$num);break;
	case 'aranien':$html = makeAranienNameList($cat,$gdr,$num);break;
	case 'mohisch':$html = makeMohischNameList($cat,$gdr,$num,$_GET);break;
	case 'bosparano':$html = makeBosparanoNameList($cat,$gdr,$num,$_GET);break;
	case 'garethien':$html = makeGarethienNameList($cat,$gdr,$num,$_GET);break;
	case 'drache':$html = makeDracheNameList($cat,'w',$num);break;
}

print $html;

?>
