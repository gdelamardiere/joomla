<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2012 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class alphauserpointsModelUpgrade extends Jmodel {

	function __construct(){
		parent::__construct();
	}
	
	 function _getUpdate()
	 {
	 	$url = 'http://update.alphaplug.com/alphauserpoints_1.6_update.xml';
		$data = '';
		$check = array();
		$check['connect'] = 0;
		$check['current_version'] = _ALPHAUSERPOINTS_NUM_VERSION;

		//try to connect via cURL
		if(function_exists('curl_init') && function_exists('curl_exec')) {
			$ch = @curl_init();
			
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_HEADER, 0);
			//http code is greater than or equal to 300 ->fail
			@curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//timeout of 5s just in case
			@curl_setopt($ch, CURLOPT_TIMEOUT, 5);
						
			$data = @curl_exec($ch);
						
			@curl_close($ch);
		}

		//try to connect via fsockopen
		if(function_exists('fsockopen') && $data == '') {

			$errno = 0;
			$errstr = '';

			//timeout handling: 5s for the socket and 5s for the stream = 10s
			$fsock = @fsockopen("update.alphaplug.com", 80, $errno, $errstr, 5);
		
			if ($fsock) {
				@fputs($fsock, "GET /alphauserpoints_1.6_update.xml HTTP/1.1\r\n");
				@fputs($fsock, "HOST: update.alphaplug.com\r\n");
				@fputs($fsock, "Connection: close\r\n\r\n");
        
				//force stream timeout...
				@stream_set_blocking($fsock, 1);
				@stream_set_timeout($fsock, 5);
				 
				$get_info = false;
				while (!@feof($fsock))
				{
					if ($get_info)
					{
						$data .= @fread($fsock, 1024);
					}
					else
					{
						if (@fgets($fsock, 1024) == "\r\n")
						{
							$get_info = true;
						}
					}
				}        	
				@fclose($fsock);
				
				//need to check data cause http error codes aren't supported here
				if(!strstr($data, '<?xml version="1.0" encoding="utf-8"?><update>')) {
					$data = '';
				}
			}
		}

	 	//try to connect via fopen
		if (function_exists('fopen') && ini_get('allow_url_fopen') && $data == '') {
		
			//set socket timeout
			ini_set('default_socket_timeout', 5);
			
			$handle = @fopen ($url, 'r');
			
			//set stream timeout
			@stream_set_blocking($handle, 1);
			@stream_set_timeout($handle, 5);
			
			$data	= @fread($handle, 1000);
			
			@fclose($handle);
		}
						
		if( $data && strstr($data, '<?xml version="1.0" encoding="utf-8"?><update>') ) {
			$xml =  JFactory::getXMLparser('Simple');
			$xml->loadString($data);
			
			$version 				= & $xml->document->version[0];
			$check['version'] 		= & $version->data();
			$released 				= & $xml->document->released[0];
			$check['released'] 		= & $released->data();
			$check['connect'] 		= 1;
			$check['enabled'] 		= 1;
			
			$check['current'] 		= version_compare( $check['current_version'], $check['version'] );
		}
		
		return $check;
	 }

	 
	 function _checkConfig() 
	 {
	 	$db			    = JFactory::getDBO();		
		
		$query = "SELECT params FROM #__extensions WHERE name='alphauserpoints' AND `type`='component'";
		$db->setQuery($query);
		$result = $db->loadResult();
		if ( !$result || $result=='{}' ) {
			JError::raiseNotice(0, JText::_( 'AUP_ALERT_CONFIGURATION' ) );
		}	 
	 }
	 
	 
	 function _checkNewRule()
	 {
	 
	 	// check new rules installed by plugin (autodetect)
		// Note: if new rule installed with a component no need to check here -> rule is stored in database on install of the component		
		
	 	$app 			= JFactory::getApplication();
		
	 	$db			    = JFactory::getDBO();
		
		$insertinto = "INSERT INTO #__alpha_userpoints_rules (`id`, `rule_name`, `rule_description`, `rule_plugin`, `plugin_function`, `access`, `component`, `calltask`, `taskid`, `points`, `points2`, `percentage`, `rule_expire`, `sections`, `categories`, `content_items`, `exclude_items`, `published`, `system`, `duplicate`, `blockcopy`, `autoapproved`, `fixedpoints`, `category`, `displaymsg`, `msg`, `method`, `notification`, `emailsubject`, `emailbody`, `emailformat`, `bcc2admin`, `type_expire_date`) VALUES";
		
		$nrule			= 0;
				
		/*  rule read article 
		======================= */		
		$rule_readarticle = JPATH_SITE.DS.'plugins'.DS.'content'.DS.'plgaup_readarticle'.DS.'plgaup_readarticle.php';
		if ( file_exists( $rule_readarticle ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='plgaup_readarticle'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_READ_ARTICLE', 'AUP_READ_ARTICLE_DESCRIPTION', 'Joomla content', 'plgaup_readarticle', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'ar', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1000' WHERE element='plgaup_readarticle' AND `type`='plugin' AND folder='content'";
				$db->setQuery( $query );
				$db->query();			

			}
		}
		
		/*  rule to login 
		======================= */
		$rule_dailylogin = JPATH_SITE.DS.'plugins'.DS.'user'.DS.'sysplgaup_login'.DS.'sysplgaup_login.php';
		if ( file_exists( $rule_dailylogin ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_login'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'Login', 'Attrib or remove points when a user log in into the frontend website', 'Joomla user', 'sysplgaup_login', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'us', '1', '', '2', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1000' WHERE element='sysplgaup_login' AND `type`='plugin' AND folder='user'";
				$db->setQuery( $query );
				$db->query();			
			}
		}
		
		
		/*  rule Happy Birthday 
		======================= */
		$rule_happybirthday = JPATH_SITE.DS.'plugins'.DS.'user'.DS.'sysplgaup_happybirthday'.DS.'sysplgaup_happybirthday.php';
		if ( file_exists( $rule_happybirthday ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_happybirthday'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto . 
				"('', 'AUP_HAPPYBIRTHDAY', 'AUP_HAPPYBIRTHDAY_DESCRIPTION', 'Joomla user', 'sysplgaup_happybirthday', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'us', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1001' WHERE element='sysplgaup_happybirthday' AND `type`='plugin' AND folder='user'";
				$db->setQuery( $query );
				$db->query();			

			}
		}
		
		
		/*  rule Inactive User 
		======================= */
		$rule_inactiveuser = JPATH_SITE.DS.'plugins'.DS.'user'.DS.'sysplgaup_inactiveuser'.DS.'sysplgaup_inactiveuser.php';
		if ( file_exists( $rule_inactiveuser ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_inactiveuser'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_INACTIVE_USER', 'AUP_INACTIVE_USER_DESCRIPTION', 'Joomla user', 'sysplgaup_inactiveuser', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'us', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_inactiveuser' AND `type`='plugin' AND folder='user'";
				$db->setQuery( $query );
				$db->query();
				
			}
		}
		
		
		/*  rule Click on weblink
		========================= */
		$rule_clickOnWeblink = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'plgaup_clickonweblink'.DS.'plgaup_clickonweblink.php';
		if ( file_exists( $rule_clickOnWeblink ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='plgaup_clickonweblink'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'Click on a weblink', 'Assign or remove points when a user click on a weblink', 'Weblinks', 'plgaup_clickonweblink', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'li', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='plgaup_clickonweblink' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();
			}
		}
		

		/*  rule Click on Contact
		========================= */
		$rule_clickOnContact = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'plgaup_clickoncontact'.DS.'plgaup_clickoncontact.php';
		if ( file_exists( $rule_clickOnContact ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='plgaup_clickoncontact'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'Click on a contact', 'Assign or remove points when a user click on a contact', 'Contacts', 'plgaup_clickoncontact', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'co', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='plgaup_clickoncontact' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		
		/*  rule Submit email from  contact form
		======================================== */
		$rule_submitemailfromcontactform = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'plgaup_submitemailfromcontactform'.DS.'plgaup_submitemailfromcontactform.php';
		if ( file_exists( $rule_submitemailfromcontactform ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='plgaup_submitemailfromcontact'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'Submit e-mail from contact form', 'Assign or remove points when a user send an e-mail from contact form', 'Contacts', 'plgaup_submitemailfromcontact', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 're', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='plgaup_submitemailfromcontactform' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		/*  rule Submit new article
		======================================== */
		$rule_submitnewarticle = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_submitarticle'.DS.'sysplgaup_submitarticle.php';
		if ( file_exists( $rule_submitnewarticle ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_submitarticle'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_SUBMITANARTICLE', 'AUP_SUBMITANARTICLEDESCRIPTION', 'Joomla content', 'sysplgaup_submitarticle', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'ar', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_submitarticle' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		/*  rule Submit new weblink
		======================================== */
		$rule_submitnewweblink = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_submitweblink'.DS.'sysplgaup_submitweblink.php';
		if ( file_exists( $rule_submitnewweblink ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_submitweblink'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_SUBMITAWEBLINK', 'AUP_SUBMITAWEBLINKDESCRIPTION', 'Joomla weblinks', 'sysplgaup_submitweblink', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'li', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_submitweblink' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}

		/*  rule Answering a poll
		======================================== */
		$rule_answeringpoll = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_answeringpoll'.DS.'sysplgaup_answeringpoll.php';
		if ( file_exists( $rule_answeringpoll ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_answeringpoll'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_ANSWERINGAPOLL', 'AUP_ANSWERINGAPOLLDESCRIPTION', 'Joomla poll', 'sysplgaup_answeringpoll', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'po', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_answeringpoll' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		/*  rule vote article
		======================================== */
		$rule_votearticle = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_votearticle'.DS.'sysplgaup_votearticle.php';
		if ( file_exists( $rule_votearticle ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_votearticle'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_VOTE_ARTICLE', 'AUP_VOTE_ARTICLE_DESCRIPTION', 'Joomla content', 'sysplgaup_votearticle', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'ot', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_votearticle' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		
		/*  rule recommend article
		======================================== */
		$rule_recommendarticle = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_recommend'.DS.'sysplgaup_recommend.php';
		if ( file_exists( $rule_recommendarticle ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_recommend'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_INVITETOREADARTICLE', 'AUP_INVITETOREADARTICLEDESCRIPTION', 'Joomla content', 'sysplgaup_recommend', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 're', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_recommend' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		

		/*  rule click banner
		======================================== */
		$rule_clickbanner = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'sysplgaup_clickbanner'.DS.'sysplgaup_clickbanner.php';
		if ( file_exists( $rule_clickbanner ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_clickbanner'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_CLICK_BANNER', 'AUP_CLICK_BANNER_DESCRIPTION', 'Joomla banner', 'sysplgaup_clickbanner', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 1, 'ot', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_clickbanner' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}
		
		/*  rule custom read article
		======================================== */
		$rule_customreadarticle = JPATH_SITE.DS.'plugins'.DS.'content'.DS.'sysplgaup_customreadarticle'.DS.'sysplgaup_customreadarticle.php';
		if ( file_exists( $rule_customreadarticle ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_customreadarticle'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_CONTENT', 'AUP_CONTENT_DESCRIPTION', 'Joomla content', 'sysplgaup_customreadarticle', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 0, 'ar', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_customreadarticle' AND `type`='plugin' AND folder='content'";
				$db->setQuery( $query );
				$db->query();

			}
		}

		/*  rule custom reader to author
		======================================== */
		$rule_customreadertoauthor = JPATH_SITE.DS.'plugins'.DS.'content'.DS.'sysplgaup_customreadertoauthor'.DS.'sysplgaup_customreadertoauthor.php';
		if ( file_exists( $rule_customreadertoauthor ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_customreadertoauthor'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_CONTENTAUTHOR', 'AUP_CONTENTAUTHOR_DESCRIPTION', 'Joomla content', 'sysplgaup_customreadertoauthor', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 0, 'ar', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='sysplgaup_customreadertoauthor' AND `type`='plugin' AND folder='content'";
				$db->setQuery( $query );
				$db->query();

			}
		}		
		
		
		/* rule unlock menu(s)
		======================================== */
		$rule_unlockmenu = JPATH_SITE.DS.'plugins'.DS.'system'.DS.'plgaup_unlockmenu'.DS.'plgaup_unlockmenu.php';
		if ( file_exists( $rule_unlockmenu ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='sysplgaup_unlockmenus'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_UNLOCKMENUS', 'AUP_UNLOCKMENUS_DESCRIPTION', 'System', 'sysplgaup_unlockmenus', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 0, 'sy', '0', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {
					$nrule++;
				}

				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1002' WHERE element='plgaup_unlockmenu' AND `type`='plugin' AND folder='system'";
				$db->setQuery( $query );
				$db->query();

			}
		}		
		
		
		/*  rule read article by categories
		==================================== */		
		$rule_readarticle_by_cat = JPATH_SITE.DS.'plugins'.DS.'content'.DS.'plgaup_readarticle_by_cat'.DS.'plgaup_readarticle_by_cat.php';
		if ( file_exists( $rule_readarticle_by_cat ) ) 
		{
			$query = "SELECT id FROM #__alpha_userpoints_rules WHERE plugin_function='plgaup_readarticle_by_cat'";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ( ! $result ) 
			{
				$query = $insertinto .
				"('', 'AUP_READ_ARTICLE_BY_CAT', 'AUP_READ_ARTICLE_BY_CAT_DESCRIPTION', 'Joomla content', 'plgaup_readarticle_by_cat', '1', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', '', '', '', '', 0, 0, 0, 0, 1, 0, 'ar', '1', '', '4', '0', '', '', '0', '0', '0');";
				$db->setQuery( $query );
				if ( $db->query() ) {		
					$nrule++;
				}
				
				// publish and move the plugin user in last position
				$query = "UPDATE #__extensions SET enabled='1', ordering='1000' WHERE element='plgaup_readarticle_by_cat' AND `type`='plugin' AND folder='content'";
				$db->setQuery( $query );
				$db->query();			

			}
		}


		// show message in backend after install (autodetect)
		if ( $nrule ) $app->enqueueMessage( JText::_( 'AUP_NEW_RULE_INSTALLED_SUCCESSFULLY' ) . ' (' . $nrule . ')' );	 
	 
	 }
	
}
?>