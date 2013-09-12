<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


if(!defined("_ALPHAUSERPOINTS_WIDTH_POPUP_CONFIG")) {
   DEFINE( "_ALPHAUSERPOINTS_WIDTH_POPUP_CONFIG", "580" );
}

if(!defined("_ALPHAUSERPOINTS_HEIGHT_POPUP_CONFIG")) {
   DEFINE( "_ALPHAUSERPOINTS_HEIGHT_POPUP_CONFIG", "480" );
}

$document = JFactory::getDocument();
$style = '.icon-32-export { background-image: url(../administrator/components/com_alphauserpoints/assets/images/icon-32-export.png); }';
$document->addStyleDeclaration( $style );


function curlDetect() {

	if (function_exists('curl_init')) {
		return true;
	} else return false;

}

 function getFormattedPoints( $points ){
 
	// get params definitions
	$params = JComponentHelper::getParams( 'com_alphauserpoints' );		
	$formatPoints = $params->get( 'formatPoints', 0 );
	
	switch( $formatPoints ){
		case "1":
			$fpoints = number_format($points, 2, '.', ',');
			break;
		case "2":
			$fpoints = number_format($points, 2, ',', '');
			break;
		case "3":
			$fpoints = number_format($points, 2, ',', ' ');
			break;
		case "4":
			$fpoints = number_format($points, 0);
			break;
		case "5":
			$fpoints = number_format($points, 0, '', ' ');
			break;
		case "6":
			$fpoints = number_format($points, 0, '', ',');
			break;
		case "7":				
			$fpoints = number_format(floor($points), 0);
			break;				
		case "0":
		default:
			$fpoints = $points; 
	}		

	return $fpoints;
	
 }


function isIE () {
	$document = JFactory::getDocument();
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/MSIE/i', $user_agent)) {
		$juribase = str_replace('/administrator', '', JURI::base());
		$document->addScript($juribase.'components/com_alphauserpoints/assets/js/html5.js');
	}
}

function createURLQRcodePNG( $url='', $width='200', $path='' ) {
	
	if (!$url) return;
	
	require_once (JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'assets'.DS.'barcode'.DS.'BarcodeQR.php');
	
	$qrcode = new BarcodeQR();	
	$qrcode->url( $url );
	$qrcode->draw( $width, $path );
	
}

function aup_CopySite ($align='center') {
	// Get Copyright for Backend
	$copyStart = 2008; 
	$copyNow = date('Y');  
	if ($copyStart == $copyNow) { 
		$copySite = $copyStart;
	} else {
		$copySite = $copyStart." - ".$copyNow ;
	}
	$_copyright =  "<br /><div align=\"$align\"><span class=\"small\"><b>AlphaUserPoints</b> &copy; $copySite"
					. " - Bernard Gilly - <a href=\"http://www.alphaplug.com\" target=\"_blank\">www.alphaplug.com</a><br />"
					. "AlphaUserPoints is Free Software released under the <a href=\"http://www.gnu.org/licenses/gpl-2.0.html\" target=\"_blank\">GNU/GPL License</a></span></div>";
	echo $_copyright;
}


function aup_createIconPanel( $link, $image, $text, $javascript='', $class='' ) {
	
	$image = JURI::base(true)."/components/com_alphauserpoints/assets/images/" . $image;
	?>
	<div style="float:left;">
		<div class="icon">
			<a <?php echo $class; ?> href="<?php echo $link; ?>" <?php echo $javascript; ?>>
				<img src="<?php echo $image; ?>" alt="<?php echo $text; ?>" align="top" border="0" />
				<span><?php echo $text; ?></span>
			</a>
		</div>
	</div>
	<?php
}

function nicetime($date, $offset=1)
{
	$config = JFactory::getConfig();
	$tzoffset = $config->getValue('config.offset');
	
	if(empty($date)) {
		return "No date provided";
	}
	
	$datetimestamp = strtotime($date);
	if ( $offset ) {
		$date = date('Y-m-d H:i:s', $datetimestamp + ($tzoffset * 60 * 60));
	} else {
		$date = date('Y-m-d H:i:s', $datetimestamp);
	}
   
	$period          = array(JText::_( 'AUP_SECOND' ), JText::_( 'AUP_MINUTE' ), JText::_( 'AUP_HOUR' ), JText::_( 'AUP_DAY' ), JText::_( 'AUP_WEEK' ), JText::_( 'AUP_MONTH' ), JText::_( 'AUP_YEAR' ), JText::_( 'AUP_DECADE' ));
	$periods         = array(JText::_( 'AUP_SECONDS' ), JText::_( 'AUP_MINUTES' ), JText::_( 'AUP_HOURS' ), JText::_( 'AUP_DAYS' ), JText::_( 'AUP_WEEKS' ), JText::_( 'AUP_MONTHS' ), JText::_( 'AUP_YEARS' ), JText::_( 'AUP_DECADES' ));
	
	$lengths         = array("60","60","24","7","4.35","12","10");
   
	//$now             = time();
	$now = strtotime(gmdate('Y-m-d H:i:s')) + ($tzoffset * 60 * 60);
	$unix_date       = strtotime($date);
   
	   // check validity of date
	if(empty($unix_date)) {   
		return "Bad date";
	}

	// is it future date or past date
	if($now > $unix_date) {  
		$difference     = $now - $unix_date;
		$tense         = JText::_( 'AUP_AGO' );
	   
	} else {
		$difference     = $unix_date - $now;
		$tense         = JText::_( 'AUP_FROM_NOW' );
	}
   
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
		$difference /= $lengths[$j];
	}
   
	$difference = round($difference);
   
	if($difference != 1) {
		//return "$difference $periods[$j] {$tense}";
		$nicetime = $difference . " " . $periods[$j];
		return sprintf($tense, $nicetime);			
	} else {
		//return "$difference $period[$j] {$tense}";
		$nicetime = $difference . " " . $period[$j];
		return sprintf($tense, $nicetime);		
	}

}

	function _get_average_age_community() {

		$db = JFactory::getDBO();	
		
		$avarage_age	= 0;
		
		$query = "SELECT AVG((FLOOR(( TO_DAYS(NOW()) - TO_DAYS(birthdate))/365))) FROM #__alpha_userpoints WHERE birthdate!='0000-00-00' AND blocked='0'";
		$db->setQuery( $query );
		$avarage_age = round($db->loadResult());
		
		return $avarage_age;
	}

	function getIdPluginFunction( $plugin_function )
	{
		$db	   = JFactory::getDBO();
		$query = "SELECT `id` FROM #__alpha_userpoints_rules WHERE `plugin_function`='$plugin_function'";
		$db->setQuery( $query );
		$plugin_id = $db->loadResult();
		return	$plugin_id;	
	}
	
	function getCpanelToolbar()
	{
		JToolBarHelper::custom( 'cpanel', 'default.png', 'default.png', JText::_('AUP_CPANEL'), false );
		JToolBarHelper::divider();
	}
	
	function getPrefHelpToolbar()
	{
		$language 	= JFactory::getLanguage();
		$tag 		= $language->getTag();
		
		JToolBarHelper::divider();
		JToolBarHelper::custom( 'rules', 'move.png', 'move.png', JText::_('AUP_RULES'), false );
		JToolBarHelper::preferences('com_alphauserpoints');
		JToolBarHelper::divider();
		JToolBarHelper::help( 'screen.alphauserpoints', true );
		/*
		if (file_exists( JPATH_COMPONENT . "/help/" . $tag . "/screen.alphauserpoints.html")){
			JToolBarHelper::help( $tag . '/screen.alphauserpoints', true );
		} else JToolBarHelper::help( 'en-GB/screen.alphauserpoints', true );
		*/
	}
	
	function getListGender($gender=0)
	{	
		$options = array();
		$options[] = JHTML::_('select.option', '1', JText::_('AUP_MALE') );
		$options[] = JHTML::_('select.option', '2', JText::_('AUP_FEMALE') );
		return JHTML::_('select.radiolist', $options, 'gender', 'class="inputbox"' ,'value', 'text', $gender );			
	}
	
	function getCountryList($selected='')
	{
	$countrylist='';
	$country_list = array(
			"Afghanistan",
			"Albania",
			"Algeria",
			"Andorra",
			"Angola",
			"Antigua and Barbuda",
			"Argentina",
			"Armenia",
			"Australia",
			"Austria",
			"Azerbaijan",
			"Bahamas",
			"Bahrain",
			"Bangladesh",
			"Barbados",
			"Belarus",
			"Belgium",
			"Belize",
			"Benin",
			"Bhutan",
			"Bolivia",
			"Bosnia and Herzegovina",
			"Botswana",
			"Brazil",
			"Brunei",
			"Bulgaria",
			"Burkina Faso",
			"Burundi",
			"Cambodia",
			"Cameroon",
			"Canada",
			"Cape Verde",
			"Central African Republic",
			"Chad",
			"Chile",
			"China",
			"Colombi",
			"Comoros",
			"Congo (Brazzaville)",
			"Congo",
			"Costa Rica",
			"Cote d'Ivoire",
			"Croatia",
			"Cuba",
			"Cyprus",
			"Czech Republic",
			"Denmark",
			"Djibouti",
			"Dominica",
			"Dominican Republic",
			"East Timor (Timor Timur)",
			"Ecuador",
			"Egypt",
			"El Salvador",
			"Equatorial Guinea",
			"Eritrea",
			"Estonia",
			"Ethiopia",
			"Fiji",
			"Finland",
			"France",
			"Gabon",
			"Gambia, The",
			"Georgia",
			"Germany",
			"Ghana",
			"Greece",
			"Grenada",
			"Guatemala",
			"Guinea",
			"Guinea-Bissau",
			"Guyana",
			"Haiti",
			"Honduras",
			"Hungary",
			"Iceland",
			"India",
			"Indonesia",
			"Iran",
			"Iraq",
			"Ireland",
			"Israel",
			"Italy",
			"Jamaica",
			"Japan",
			"Jordan",
			"Kazakhstan",
			"Kenya",
			"Kiribati",
			"Korea, North",
			"Korea, South",
			"Kuwait",
			"Kyrgyzstan",
			"Laos",
			"Latvia",
			"Lebanon",
			"Lesotho",
			"Liberia",
			"Libya",
			"Liechtenstein",
			"Lithuania",
			"Luxembourg",
			"Macedonia",
			"Madagascar",
			"Malawi",
			"Malaysia",
			"Maldives",
			"Mali",
			"Malta",
			"Marshall Islands",
			"Mauritania",
			"Mauritius",
			"Mexico",
			"Micronesia",
			"Moldova",
			"Monaco",
			"Mongolia",
			"Morocco",
			"Mozambique",
			"Myanmar",
			"Namibia",
			"Nauru",
			"Nepa",
			"Netherlands",
			"New Zealand",
			"Nicaragua",
			"Niger",
			"Nigeria",
			"Norway",
			"Oman",
			"Pakistan",
			"Palau",
			"Panama",
			"Papua New Guinea",
			"Paraguay",
			"Peru",
			"Philippines",
			"Poland",
			"Portugal",
			"Qatar",
			"Romania",
			"Russia",
			"Rwanda",
			"Saint Kitts and Nevis",
			"Saint Lucia",
			"Saint Vincent",
			"Samoa",
			"San Marino",
			"Sao Tome and Principe",
			"Saudi Arabia",
			"Senegal",
			"Serbia and Montenegro",
			"Seychelles",
			"Sierra Leone",
			"Singapore",
			"Slovakia",
			"Slovenia",
			"Solomon Islands",
			"Somalia",
			"South Africa",
			"Spain",
			"Sri Lanka",
			"Sudan",
			"Suriname",
			"Swaziland",
			"Sweden",
			"Switzerland",
			"Syria",
			"Taiwan",
			"Tajikistan",
			"Tanzania",
			"Thailand",
			"Togo",
			"Tonga",
			"Trinidad and Tobago",
			"Tunisia",
			"Turkey",
			"Turkmenistan",
			"Tuvalu",
			"Uganda",
			"Ukraine",
			"United Arab Emirates",
			"United Kingdom",
			"United States Of America",
			"Uruguay",
			"Uzbekistan",
			"Vanuatu",
			"Vatican City",
			"Venezuela",
			"Vietnam",
			"Virgin Islands (British)",
			"Virgin Islands (US)",
			"Wallis and Futuna Islands",
			"Western Sahara",
			"Yemen",
			"Zaire",
			"Zambia",
			"Zimbabwe"
		);
		
		$n = count($country_list)-1;
		
		$options[] = JHTML::_( 'select.option', '', JText::_( 'AUP_SELECTCOUNTRY' ) );
		
		for ($i=0, $n=(count( $country_list )-1); $i < $n; $i++) {
			$options[] = JHTML::_( 'select.option', $country_list[$i], $country_list[$i] );		
		}
		$countrylist = JHTML::_('select.genericlist', $options, 'country', 'class="inputbox" size="1"', 'value', 'text', $selected );
			
		return $countrylist;
	}
	
	function getReferreidByID( $id )
	{	
		if ( !$id ) return;	
		// get referre id
		$db	   = JFactory::getDBO();
		$query = "SELECT referreid FROM #__alpha_userpoints WHERE `id`='$id'";
		$db->setQuery( $query );
		$referreid = $db->loadResult();
		return $referreid;
	}
	
	
?>