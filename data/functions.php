<?php
// Sorting of strings with umlauts
function replace_uml($s) {
	$pattern = array('/Ä/','/ä/','/Ü/','/ü/','/Ö/','/ö/','/ß/',
		'/Á/','/á/','/À/','/à/','/Â/','/â/',
		'/É/','/é/','/È/','/è/','/Ê/','/ê/',
		'/Í/','/í/','/Ì/','/ì/','/Î/','/î/',
		'/Ó/','/ó/','/Ò/','/ò/','/Ô/','/ô/',
		'/Ú/','/ú/','/Ù/','/ù/','/Û/','/û/');
	$replacement = array('A','a','U','u','O','o','s',
		'A','a','A','a','A','a',
		'E','e','E','e','E','e',
		'I','i','I','i','I','i',
		'O','o','O','o','O','o',
		'U','u','U','u','U','u');
	return preg_replace($pattern, $replacement, $s);
}

function strcmp_uml($a,$b) {
	$l_a = replace_uml($a);
	$l_b = replace_uml($b);

	return strcasecmp($l_a,$l_b);
}

function sort_uml(&$a) {
	usort($a,'strcmp_uml');
}
// --

// makeList(Array $field)
function makeList($field) {

	sort_uml($field);
	$html = '<ul data-role="listview" data-inset="true" data-theme="a">';
	foreach ($field as $val) {
		$html .= '<li>'.$val.'</li>';
	}
	$html .= '</ul>';
	return $html;
}

// makeCollapsibleList(String $label, String $namelist, Bool $collapsed)
function makeCollapsibleList($label,$namelist,$collapsed) {

	// convert list to array
	$name_arr = explode(',',$namelist);
	foreach ($name_arr as &$val1) {
		// trim
		$val1 = trim($val1);
	}
	sort_uml($name_arr);

	$html = '<ul data-role="listview" data-autodividers="true" data-theme="a" data-divider-theme="f">';
	foreach ($name_arr as $val2) {
		$html .= '<li>'.$val2.'</li>';
	}
	$html .= '</ul>';

	// put everything in collapsible
	return makeCollapsible($label,$html,$collapsed,'true');
}

// makeRadio(String $i_name, Array $val, Array $label)
function makeRadio($i_name,$val,$label) {
	$checked = ' checked="checked"';

	$html = '<fieldset data-role="controlgroup" data-theme="a">';
	for ($n = 0; $n < count($val); $n++) {
		$html .= '<input type="radio" name="'.$i_name.'" id="'.$i_name."-$n".
			'" value="'.$val[$n].'" '.$checked.'/>';
		$html .= '<label for="'.$i_name."-$n".'">'.$label[$n].'</label>';
		if ($checked) $checked = '';
	}
	$html .= '</fieldset>';

	return $html;
}

// makeCollapsible(String $header, String $text, String $theme, Bool $collapsed)
function makeCollapsible($header,$text,$collapsed,$inset) {
	$html = '<div data-role="collapsible" data-content-theme="a" data-collapsed="'.$collapsed.'" data-inset="'.$inset.'">';
	$html .= '<h3>'.$header.'</h3>'.$text.'</div>';
	return $html;
}

// makeSlider(Integer $min, Integer $max, String $i_name, String $i_id, String $i_val, String $text)
function makeSlider($min,$max,$i_name,$i_id,$i_val,$text) {
	$html = '<label for="'.$i_id.'"><strong>'.$text.'</strong></label>';
	$html .= '<input type="range" name="'.$i_name.'" id="'.$i_id.'" value="'.$i_val.'" min="'.$min.'" max="'.$max.'" />';
	return $html;
}

// makeButton(String $i_id, String $text)
function makeButton($i_id,$text) {
	$html = '<input type="submit"  data-icon="star" id="'.$i_id.'" value="'.$text.'" />';
	return $html;
}

// makeCatPage(String $cat)
function makeCatPage($cat) {
	global $names;
	$arr = $names[$cat];

	// general part
	$g_html = '';
	if (isset($arr['info'])) {
		$g_html = '<p>'.$arr['info'].'</p>';
		$g_html = makeCollapsible('Allgemein',$g_html,'true','false');
	}

	// random generator part
	$c_html = '<form><input type="hidden" name="cat" value="'.$cat.'"/>';
	$c_html .= makeSlider(1,25,'num','num-'+$cat,1,'Anzahl:');

	if (count($arr['options'][0]) > 2) {
		for ($x = 0; $x < count($arr['options']); $x++) {
			$labels = array();
			$vals = array();
			for ($y = 0; $y < count($arr['options'][$x]) - 1; $y++) {
				$labels[] = $arr['options'][$x][$y]['label'];
				$vals[] = $arr['options'][$x][$y]['val'];
			}
			$c_html .= makeRadio($arr['options'][$x]['id'],$vals,$labels);
		}
	} else {
		$c_html .= '<input type="hidden" name="'.$arr['options'][0]['id'].'" value="'.$arr['options'][0][0]['val'].'" />';
	}

	$c_html .= makeButton('btn-'.$cat,'Generieren');
	$c_html .= '<div id="namelist-'.$cat.'"></div></form>';

	$c_html = makeCollapsible('Zufällig',$c_html,'false','false');

	// list part
	$l_html = '';
	if (isset($arr['names'])) {
		for ($x = 0; $x < count($arr['names']['label']); $x++) {
			$l_html .= makeCollapsibleList($arr['names']['label'][$x],$arr['names'][$x],true);
		}
		$l_html = makeCollapsible('Liste',$l_html,'true','false');
	}
	return $g_html.$c_html.$l_html;
}

function explodeNameList($cat,$idx) {
	global $names;

	$namelist = explode(',',$names[$cat]['names'][$idx]);
	foreach ($namelist as &$val) {
		$val = trim($val);
	}
	return $namelist;
}

function explodePlaceList($cat,$idx) {
	global $places;

	$namelist = explode(',',$places[$cat][$idx]);
	foreach ($namelist as &$val) {
		$val = trim($val);
	}
	return $namelist;
}

// single names
function makeSimpleNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);

	shuffle($namelist);

	$html = '';
	if ($num > count($namelist)) {
		$html = makeList($namelist);
	} else {
		$html = makeList(array_slice($namelist,0,$num));
	}
	return $html;
}

// single names with last name
function makeSurnameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);

	$surnamelist = explodeNameList($cat,2);

	shuffle($namelist);shuffle($surnamelist);

	for ($x = 0; $x < count($namelist); $x++) {
		$namelist[$x] = $namelist[$x].' '.
			$surnamelist[mt_rand(0,count($surnamelist)-1)];
	}

	$html = '';
	if ($num > count($namelist)) {
		$html = makeList($namelist);
	} else {
		$html = makeList(array_slice($namelist,0,$num));
	}
	return $html;
}

// isdira
function makeIsdiraNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist1 = explodeNameList($cat,$gdr);

	$namelist2 = explodeNameList($cat,2);

	$namelist3 = explodeNameList($cat,3);

	shuffle($namelist1);shuffle($namelist2);

	$mergelist = array();
	for ($x = 0; $x < $num; $x++) {
		$mergelist[$x] = $namelist1[$x].' '.$namelist2[$x];
	}

	for ($x = 0; $x < $num; $x++) {
		if (mt_rand(0,2)) {
			shuffle($namelist3);
			$suffix = $namelist3[0];
			switch (substr($mergelist[$x],-1)) {
				case 'e':$mergelist[$x] .= 'n';break;
				case 'l':$mergelist[$x] .= 's';break;
				case 'u':$mergelist[$x] .= 'en';break;
			}
			$mergelist[$x] = $mergelist[$x].$suffix;
		}
	}

	return makeList($mergelist);
}

// garethi, weiden
function makeWeidenNameList($cat,$gdr,$num,$get) {
	global $names;

	$nbl = 'l';
	if (isset($get)) {
		if ( ($get['nbl'] == 'l') || ($get['nbl'] == 'f') ||
			($get['nbl'] == 's') || ($get['nbl'] == 'a') ) $nbl = $get['nbl'];
	}

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);

	shuffle($namelist);

	if ($nbl == 'a') {
		$nlist = array();
		for ($x = 0; $x < $num; $x++) {
			$n = array_rand($namelist,mt_rand(2,5));
			$nlist[$x] = '';
			foreach ($n as $val) {
				$nlist[$x] .= ' '.$namelist[$val];
			}
		}
		$namelist = $nlist;
	}

	$namelist = array_slice($namelist,0,$num);

	$prelist = explodeNameList($cat,2);
	$sufflist = explodeNameList($cat,4);

	if ($nbl == 's') {
		$sufflist_g = explodeNameList($cat,5 + $gdr);
		$sufflist = array_merge($sufflist,$sufflist_g);
	}

	$p = count($prelist)-1;$s = count($sufflist)-1;

	$placelist = array();
	for ($x = 0; $x < $num; $x++) {
		$placelist[$x] = $prelist[mt_rand(0,$p)].$sufflist[mt_rand(0,$s)];
	}

	$rnd_list = array();
	if ($nbl == 'l') {
		for ($x = 0; $x < $num; $x++) {
			$namelist[$x] = $namelist[$x].' aus '.$placelist[$x];
		}
	}
	if ($nbl == 'f') {
		for ($x = 0; $x < $num; $x++) {
			$namelist[$x] = $namelist[$x].' von '.$placelist[$x];
		}
	}
	if ($nbl == 's') {
		for ($x = 0; $x < $num; $x++) {
			$namelist[$x] = $namelist[$x].' '.$placelist[$x];
		}
	}
	if ($nbl == 'a') {
		for ($x = 0; $x < $num; $x++) {
			$namelist[$x] = $namelist[$x].' von '.$placelist[$x];
		}
	}

	return makeList($namelist);
}

// garethi, svelltal
function makeSvelltalNameList($cat,$gdr,$num) {
	global $name;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$names_garethien = explodeNameList('garethien',$gdr);
	$names_nivesisch = explodeNameList('nivesisch',$gdr);
	$names_norbardisch = explodeNameList('norbardisch',$gdr);

	$namelist = array_merge($names_garethien,$names_nivesisch,$names_norbardisch);

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	return makeList($namelist);	
}

// garethi, andergast
function makeAndergastNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);

	$surnamelist = explodeNameList($cat,2);

	if ($gdr == 0) {
		foreach ($surnamelist as &$value) {
			$value .= "in";
		}
	}

	shuffle($namelist);shuffle($surnamelist);

	for ($x = 0; $x < count($namelist); $x++) {
		$namelist[$x] = $namelist[$x].' '.
			$surnamelist[mt_rand(0,count($surnamelist)-1)];
	}

	$html = '';
	if ($num > count($namelist)) {
		$html = makeList($namelist);
	} else {
		$html = makeList(array_slice($namelist,0,$num));
	}
	return $html;
}

// thorwalsch
function makeThorwalschNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);

	$fem_namelist = explodeNameList($cat,0);
	$mal_namelist = explodeNameList($cat,1);

	if ($gdr) {
		foreach ($fem_namelist as &$value) {
			if (substr($value,-1) == 's') $s = '';
				else $s = 's';
			$value .= $s."son";
		}
		foreach ($mal_namelist as &$value) {
			if (substr($value,-1) == 's') $s = '';
				else $s = 's';
			$value .= $s."son";
		}
	} else {
		foreach ($fem_namelist as &$value) {
			if (substr($value,-1) == 's') $s = '';
				else $s = 's';
			$value .= $s."dottir";
		}
		foreach ($mal_namelist as &$value) {
			if (substr($value,-1) == 's') $s = '';
				else $s = 's';
			$value .= $s."dottir";
		}
	}

	shuffle($namelist);
	shuffle($fem_namelist);
	shuffle($mal_namelist);

	for ($x = 0; $x < count($namelist); $x++) {
		if (mt_rand(0,1)) {
			$surname = $mal_namelist[mt_rand(0,count($mal_namelist)-1)];
		} else {
			$surname = $fem_namelist[mt_rand(0,count($fem_namelist)-1)];
		}
		$namelist[$x] = $namelist[$x].' '.$surname;
	}

	$html = '';
	if ($num > count($namelist)) {
		$html = makeList($namelist);
	} else {
		$html = makeList(array_slice($namelist,0,$num));
	}
	return $html;
}

function filterFirstLetter($letter,$array) {
	$field = array();

	for ($x = 0; $x < count($array); $x++) {
		if (substr($array[$x],0,1) == $letter) {
			$field[] = $array[$x];
		}
		
	}

	if ($field) return $field;
		else return false;
}

// rogolan
function makeRogolanNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$namelist2 = $namelist;

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	if ($gdr) {
		$conj = ' Sohn des ';
	} else {
		$conj = ' Tochter der ';
	}

	foreach ($namelist as &$value) {
		$anc_list = filterFirstLetter(substr($value,0,1),$namelist2);
		$value = $value.$conj.$anc_list[mt_rand(0,count($anc_list)-1)];
	}

	return makeList($namelist);
}

// garethi, almada
function makeAlmadaNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$secnamelist = explodeNameList($cat,$gdr+4);
	$surnamelist = explodeNameList($cat,3);

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$value = $value.' '.$secnamelist[mt_rand(0,count($secnamelist)-1)].' '.
			$surnamelist[mt_rand(0,count($surnamelist)-1)];
	}

	return makeList($namelist);
}

// tulamidya
function makeTulamidischNameList($cat,$gdr,$num,$get) {
	global $names;

	$plc = 't';
	if (isset($get)) {
		if ( ($get['plc'] == 't') || ($get['plc'] == 'n') ||
			($get['plc'] == 's') ) $plc = $get['plc'];
	}

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$anc_namelist = explodeNameList($cat,1);
	$hnr_namelist = explodeNameList($cat,$gdr+4);


	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$conj = '';$suff = '';$hnr = '';
		if ($gdr) {
			if ($plc == 's') {$conj = ' y ben';}
			elseif ($plc == 'n') {$conj = ' ben';}
			else {$conj = ' ibn';}
		} else {
			if (mt_rand(0,1)) {
				$conj = ' saba';
			} else {
				if (mt_rand(0,1)) {
					$suff = 'sunya';
				} else {
					$suff = 'suni';
				}
			}
		}
		if (mt_rand(0,1)) {
			$hname = explode('|',$hnr_namelist[mt_rand(0,count($hnr_namelist)-1)]);
			$hnr = ' <span title="'.$hname[1].'">'.$hname[0].'</span>';
		}
		$value = $value.$hnr.$conj.' '.$anc_namelist[mt_rand(0,count($anc_namelist)-1)].$suff;
	}

	return makeList($namelist);
}

// garethi, ferkina
function makeFerkinaNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$anc_namelist = explodeNameList($cat,1);

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$conj = '';
		if ($gdr) {
			$conj = ' iban ';
		} else {
			if (mt_rand(0,1)) {
				$conj = ' sabu ';
			} else {
				$conj = ' zawsh-i-';
			}
		}
		$value = $value.$conj.$anc_namelist[mt_rand(0,count($anc_namelist)-1)];
	}

	return makeList($namelist);
}

// zulchammaqra
function makeZulchammaqraNameList($cat,$gdr,$num) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$anc_namelist = explodeNameList($cat,1);

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$conj = '';
		if ($gdr) {
			$conj = ' iban ';
		} else {
			$conj = ' sabu ';
		}
		$value = $value.$conj.$anc_namelist[mt_rand(0,count($anc_namelist)-1)];
	}

	return makeList($namelist);
}

// tulamidya, aranien
function makeAranienNameList($cat,$gdr,$num) {
	global $names;
	$cat = 'tulamidisch';

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$namelist = explodeNameList($cat,$gdr);
	$anc_namelist = explodeNameList($cat,$gdr);
	$hnr_namelist = explodeNameList($cat,$gdr+4);


	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$conj = '';$suff = '';$hnr = '';
		if ($gdr) {
			$conj = ' ibn';
		} else {
			if (mt_rand(0,1)) {
				$suff = 'suni';
			} else {
				if (mt_rand(0,1)) {
					$suff = 'sunya';
				} else {
					$suff = 'sunyara';
				}
			}
		}
		if (mt_rand(0,1)) {
			$hname = explode('|',$hnr_namelist[mt_rand(0,count($hnr_namelist)-1)]);
			$hnr = ' <span title="'.$hname[1].'">'.$hname[0].'</span>';
		}
		$value = $value.$hnr.$conj.' '.$anc_namelist[mt_rand(0,count($anc_namelist)-1)].$suff;
	}

	return makeList($namelist);
}

// mohisch
function makeMohischNameList($cat,$gdr,$num,$get) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$trb = 'w';
	if (isset($get)) {
		if ( ($get['trb'] == 'w') || ($get['trb'] == 's') ||
			($get['trb'] == 'u') ) $trb = $get['trb'];
	}

	if ($trb == 'u') $trb = 2;
		elseif ($trb == 's') $trb = 1;
		else $trb = 0;

	$namelist = explodeNameList($cat,$trb);
	shuffle($namelist);
	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$suff = '';
		if (mt_rand(0,1)) {
			if ($gdr) {
				$suff = 'ha';
			} else {
				$suff = 'ca';
			}
		}
		$value .= $suff;
	}

	return makeList($namelist);
}

// bosparano
function makeBosparanoNameList($cat,$gdr,$num,$get) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$nbl = 'l';
	if (isset($get)) {
		if ( ($get['nbl'] == 'l') || ($get['nbl'] == 'b') ||
			($get['nbl'] == 's') || ($get['nbl'] == 'a') ) $nbl = $get['nbl'];
	}

	$namelist = explodeNameList($cat,$gdr);
	shuffle($namelist);
	$namelist = array_slice($namelist,0,$num);

	$max = 0;
	if ($nbl == 's') $max = 1;
	if ($nbl == 'a') $max = 3;

	for ($x = 0; $x < $max; $x += 2) {
		$other_namelist = explodeNameList($cat,$gdr+5+$x);
		foreach ($namelist as &$value) {
			$value = $value.' '.$other_namelist[mt_rand(0,count($other_namelist)-1)];
		}
	}

	if ($nbl != 'l') {
		$lastnamelist = explodeNameList($cat,4);
		foreach ($namelist as &$value) {
			$value = $value.' '.$lastnamelist[mt_rand(0,count($lastnamelist)-1)];
		}
	}

	return makeList($namelist);
}

// garethi
function makeGarethienNameList($cat,$gdr,$num,$get) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$nbl = 'l';
	if (isset($get)) {
		if ( ($get['nbl'] == 'l') || ($get['nbl'] == 'f') ||
			($get['nbl'] == 'a') ) $nbl = $get['nbl'];
	}

	if (($nbl == 'l') || ($nbl == 'f')) {
		$namelist = explodeNameList($cat,$gdr);
		shuffle($namelist);
		$namelist = array_slice($namelist,0,$num);
	}

	if ($nbl == 'f') {
		$places_pre = explodePlaceList($cat,12);
		$places_suf = explodePlaceList($cat,13);
		foreach ($places_pre as &$value) {
			$value = trim($value,'-');
		}
		foreach ($places_suf as &$value) {
			$value = trim($value,'-');
		}
		$surnamelist = array_merge(explodeNameList($cat,8),explodeNameList($cat,$gdr+9));
		foreach ($namelist as &$value) {
			$value = $value.' '.$surnamelist[mt_rand(0,count($surnamelist))];
			if (mt_rand(0,2)) {
				if (mt_rand(0,1)) {
					$value .= ' aus ';
				} else {
					$value .= ' von ';
				}
				$place = $places_pre[mt_rand(0,count($places_pre))].
						$places_suf[mt_rand(0,count($places_suf))];
				$value .= $place;
			}
		}
	}

	if ($nbl == 'a') {
		$namelist = array();
		$name_pre = explodeNameList($cat,3);
		$name_suf = explodeNameList($cat,$gdr+4);
		$bsp_name = explodeNameList($cat,$gdr+6);
		$places_pre = explodePlaceList($cat,0);
		$places_suf = explodePlaceList($cat,1);
		foreach ($places_pre as &$val1) {
			$val1 = trim($val1,'-');
		}
		foreach ($places_suf as &$val2) {
			$val2 = trim($val2,'-');
		}

		for ($x = 0; $x < $num; $x++) {
			$name = '';$tname = '';
			for ($y = 0; $y < mt_rand(2,5); $y++) {
				if (mt_rand(0,1)) {
					$tname = $name_pre[mt_rand(0,count($name_pre)-1)].
							$name_suf[mt_rand(0,count($name_suf)-1)];
				} else {
					$tname = $bsp_name[mt_rand(0,count($bsp_name)-1)];
				}
				if ($y) $name .= ' ';
				$name .= $tname;
			}
			$namelist[$x] = $name;
			$surnamelist = explodeNameList($cat,11);
			$namelist[$x] .= ' von '.$surnamelist[mt_rand(0,count($surnamelist))];
			$place = $places_pre[mt_rand(0,count($places_pre))].
					$places_suf[mt_rand(0,count($places_suf))];
			if (mt_rand(0,1)) {
				$place = ' zu '.$place;
			} else {
				$place = ' auf '.$place;
			}
			$namelist[$x] .= $place;
		}
	}

	return makeList($namelist);
}

// drachisch
function makeDracheNameList($cat,$gdr,$num) {
	global $names;

	$namelist = explodeNameList($cat,0);
	$suf_namelist = explodeNameList($cat,1);

	shuffle($namelist);

	$namelist = array_slice($namelist,0,$num);

	foreach ($namelist as &$value) {
		$value = $value.$suf_namelist[mt_rand(0,count($suf_namelist)-1)];
	}

	return makeList($namelist);
}

// garethi, nostria
function makeNostriaNameList($cat,$gdr,$num,$get) {
	global $names;

	if ( ($gdr != 'w') && ($gdr != 'm') ) $gdr = 'w';

	if ($gdr == 'w') $gdr = 0;
		else $gdr = 1;

	$nbl = 'l';
	if (isset($get)) {
		if ( ($get['nbl'] == 'l') || ($get['nbl'] == 's') ||
			($get['nbl'] == 'a') ) $nbl = $get['nbl'];
	}

	if ($nbl == 'l') {
		$namelist = explodeNameList($cat,$gdr+4);
		shuffle($namelist);
		$namelist = array_slice($namelist,0,$num);
	} else {
		$namelist = explodeNameList($cat,$gdr+6);
		shuffle($namelist);
		$namelist = array_slice($namelist,0,$num);
	}

	if ($nbl == 'l') {
		$cj_list = explodeNameList($cat,10);
		$cj_m = count($cj_list) - 1;
		$ln_list = explodeNameList($cat,9);
		$ln_m = count($ln_list) - 1;

		foreach ($namelist as &$value) {
			$value = $value.' '.$cj_list[mt_rand(0,$cj_m)].' '.$ln_list[mt_rand(0,$ln_m)];
		}
	}

	if ($nbl == 's') {
		$ln_list = explodeNameList($cat,8);
		$ln_m = count($ln_list) - 1;

		foreach ($namelist as &$value) {
			$value = $value.' '.$ln_list[mt_rand(0,$ln_m)];
		}
	}

	if ($nbl == 'a') {
		$ln_list = explodeNameList($cat,8);
		$ln_m = count($ln_list) - 1;
		$pp_list = explodePlaceList($cat,0);
		$pp_m = count($pp_list) - 1;
		$ps_list = explodePlaceList($cat,1);
		$ps_m = count($ps_list) - 1;
		$sn_list = explodeNameList($cat,$gdr+6);
		$rnd_curve = array(1,1,2,2,2,2,3,3,3,4);

		foreach ($namelist as &$value) {
			$n = $rnd_curve[mt_rand(0,9)];
			$rand_arr = (array) array_rand($sn_list,$n);
			foreach ($rand_arr as $nm_i) {
				$value = $value.' '.$sn_list[$nm_i];
			}
			$plc = $pp_list[mt_rand(0,$pp_m)].$ps_list[mt_rand(0,$ps_m)];
			$value = $value.' von '.$ln_list[mt_rand(0,$ln_m)].'-'.$plc;
		}
	}

	return makeList($namelist);
}

?>
