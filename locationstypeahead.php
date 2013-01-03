<?php
/**
 * RSEvPro_Locations_Typeahead
 * Imports dependent classes and keeps them ready for use
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
