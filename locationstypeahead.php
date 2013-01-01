<?php
/**
 * RSEvPro_Locations_Typeahead
 *
 * @version  1.0
 * @package Stilero
 * @subpackage RSEvPro_Locations_Typeahead
 * @author Daniel Eliasson (joomla@stilero.com)
 * @copyright  (C) 2013-jan-01 Stilero Webdesign (www.stilero.com)
 * @license	GNU General Public License version 2 or later.
 * @link http://www.stilero.com
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 
define('LOC_TYPEAHEAD_CLASSES', JPATH_PLUGINS.'/system/locationstypeahead/locationstypeahead/');
JLoader::register('LocationsTypeAhead', LOC_TYPEAHEAD_CLASSES.'locationstypeahead.php');

// import library dependencies
//jimport('joomla.plugin.plugin');

//class plgSystemLocationstypeahead extends JPlugin {
//
//   
//    function plgSystemLocationstypeahead(&$subject, $config) {
//        parent::__construct($subject, $config);
//        LocationsTypeAhead::loadBootstrap();
//        LocationsTypeAhead::insertTypeaheadScript();
//        LocationsTypeAhead::loadBootstrapCSS();
//    }
//    
//    public function onContentAfterDisplay($context, &$article, &$params, $limitstart=0) {
//        print LocationsTypeAhead::getTypeaheadInput();
//    }
//}