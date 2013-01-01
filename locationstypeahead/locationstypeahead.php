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
jimport( 'joomla.html.parameter' );
JLoader::register('modRseventsProLocations', JPATH_SITE.'/modules/mod_rseventspro_locations/helper.php');
define('RSEP_MEDIA_FILES_URI', JURI::root().'/media/plg_system_locationstypeahead/');
define('RSEP_MEDIA_IMG', RSEP_MEDIA_FILES_URI.'img/');
define('RSEP_MEDIA_CSS', RSEP_MEDIA_FILES_URI.'css/');
define('RSEP_MEDIA_JS', RSEP_MEDIA_FILES_URI.'js/');

class LocationsTypeAhead{
    
    static function getLocations(){
        $params = new JParameter();
        $locationObject = new modRseventsProLocations();
        $locations = $locationObject->getLocations($params);
        $locationNames = array();
        foreach ($locations as $location) {
            $locationNames[] = $location->name;
        }
        $locationJSOption = '["'.implode('","', $locationNames).'"]';
        return $locationJSOption;
    }
    
    static function loadBootstrap(){
        $document = JFactory::getDocument();
        $document->addScript('http://code.jquery.com/jquery-latest.js');
        $document->addScript(RSEP_MEDIA_JS.'bootstrap.min.js');
    }
    
    static function loadBootstrapCSS(){
        $document = JFactory::getDocument();
        //$document->addStyleSheet(RSEP_MEDIA_CSS.'bootstrap.min.css');
        $document->addStyleSheet(RSEP_MEDIA_CSS.'bootstrap.css');
    }
    
    static function insertTypeaheadScript($class='typeahead', $items=8, $minLength=1){
        $document = JFactory::getDocument();
        $script = 
            'jQuery(function($){ 
                var typeaheadOptions = {
                    source: '.self::getLocations().',
                    items: '.$items.',
                    minLength: '.$minLength.'
                };
                $(\'.'.$class.'\').typeahead(typeaheadOptions); 
            });';
        $document->addScriptDeclaration($script);
    }
    
    static function getLocationsInput(){
        $html = '<input 
            name="rslocations[]" 
            type="text" 
            class="typeahead span3" />';
        return $html;
    }
}
