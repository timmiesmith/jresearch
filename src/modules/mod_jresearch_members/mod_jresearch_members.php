<?php
/**
* @version		$Id: mod_feed.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		JResearch
* @subpackage 	Modules
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

if(!JComponentHelper::isEnabled('com_jresearch', true))
{
	JError::raiseError(0, 'J!Research is not enabled or installed');
}

// Include the helper functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$members = modJResearchMembersHelper::getMembers($params);

require(JModuleHelper::getLayoutPath('mod_jresearch_members'));
