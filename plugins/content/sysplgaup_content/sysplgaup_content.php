<?php
/*
 * @component AlphaUserPoints
 * @copyright Copyright (C) 2008-2011 Bernard Gilly
 * @license : GNU/GPL
 * @Website : http://www.alphaplug.com
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * AlphaUserPoints Content Plugin
 *
 * @package		Joomla
 * @subpackage	AlphaUserPoints
 * @since 		1.6
 */

class plgContentsysplgaup_content extends JPlugin
{

	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$app = JFactory::getApplication();
		
		$user 	=  JFactory::getUser();
		
		if(isset($article->id))
		{
			$articleid  = $article->id;
		} 
		else 
		{
			$articleid = null;
		}		
		
		$option = JRequest::getCmd('option', '');
		$view   = JRequest::getVar('view',   '');
		$print	= JRequest::getVar('print');
		//$format	= JRequest::getVar('format');
		
		if ($app->isAdmin()) return;
		
		//if ( !$user->id || $print || $format=='pdf' || !$articleid ) {
		if ( !$user->id || !$articleid ) {
			$article->text = preg_replace( " |{AUP::SHOWPOINTS}| ", "", $article->text );
			return;
		}
		
		JPlugin::loadLanguage( 'com_alphauserpoints', JPATH_SITE );
		
		require_once (JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php');		
		
		// *******************************************
		// * show current points of the current user *
		// *******************************************
		if ( preg_match('#{AUP::SHOWPOINTS}#Uis', $article->text, $m) )
		{
			$show = $m[0];
			if ( $show && @$_SESSION['referrerid'] ) {
				$currentpoints = AlphaUserPointsHelper::getCurrentTotalPoints( @$_SESSION['referrerid'] );
				$currentpoints = AlphaUserPointsHelper::getFPoints($currentpoints);
				if ( !$article->title || $article->title==NULL ) $article->title = $option;					
				$article->text = preg_replace( " |{AUP::SHOWPOINTS}| ", $currentpoints, $article->text );
			} else $article->text = preg_replace( " |{AUP::SHOWPOINTS}| ", "", $article->text );
		} 
		
	}
}
?>