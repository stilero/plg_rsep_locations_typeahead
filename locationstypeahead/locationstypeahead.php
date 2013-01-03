<?php
/**
 * RSEvPro_Locations_Typeahead
 * 
 * Usage:
 *      Change the file mod_rseventsprosearch > default.php
 *      Enter the following code to replace the $locationsList variable:
 *          LocationsTypeAhead::loadBootstrap();
 *          LocationsTypeAhead::insertTypeaheadScript();
 *          LocationsTypeAhead::insertLocSearchFix();
 *          LocationsTypeAhead::loadBootstrapCSS();
 *          $locationslist = LocationsTypeAhead::getLocationsInput('rslocations[]');
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
    
    /**
     * Returns the Locations of RSEventsPro
     * @param bool $asObject True to return locations as an object, otherwise as an array of names
     * @return Object An object of Locations
     */
    static function getLocations($asObject=FALSE){
        $params = new JParameter();
        $locationObject = new modRseventsProLocations();
        $locations = $locationObject->getLocations($params);
        $locationNames = array();
        foreach ($locations as $location) {
            $locationNames[] = $location->name;
        }
        $locationJSOption = '["'.implode('","', $locationNames).'"]';
        if($asObject){
            return $locations;
        }else{
            return $locationJSOption;
        }
    }
    
    /**
     * Returns the Locations as a JavaScript Array
     * @return string JS Array
     */
    static function getLocationsInJSArray(){
        $locations = self::getLocations(TRUE);
        $script = 'var locations = new Array();';
        foreach ($locations as $location) {
            $script .= 'locations['.$location->id.'] = "'.$location->name.'";';
        }
        return $script;
    }
    
    /**
     * Loads Bootstrap and jQuery scripts to Joomla.
     */
    static function loadBootstrap(){
        $document = JFactory::getDocument();
        $document->addScript('http://code.jquery.com/jquery-latest.js');
        $script =  'jQuery.noConflict();';
        $document->addScriptDeclaration($script);
        $document->addScript(RSEP_MEDIA_JS.'bootstrap.js');
    }
    
    /**
     * Loads Bootstrap CSS to Joomla
     */
    static function loadBootstrapCSS(){
        $document = JFactory::getDocument();
        //$document->addStyleSheet(RSEP_MEDIA_CSS.'bootstrap.min.css');
        $document->addStyleSheet(RSEP_MEDIA_CSS.'bootstrap.css');
    }
    
    /**
     * Inserts a typeahead scripts to manipulate the Location search
     * @param type $class The CSS class to be used
     * @param type $items Number of items to display in the dropdown
     * @param type $minLength Number of letters to start the typeahead
     */
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
    
    /**
     * Returns a Location search input box.
     * @param type $inputName The form name to be used
     * @return string HTML with the location search field
     */
    static function getLocationsInput($inputName = 'rslocations[]'){
        $html = '<input 
            name="locations_typeahead" 
            id="locations_typeahead" 
            type="text" 
            class="typeahead span3" />'.
                '<input 
                    type="hidden" 
                    id="rslocations" 
                    name="'.$inputName.'" 
                        />';
        return $html;
    }
    
    /**
     * This method inserts jQuery Script that translates the Location name to 
     * The corresponding Location ID, to make it possible to use Typeahead without
     * changing native files.
     * Use this method after loading Bootstrap.
     * @param type $formId The JS ID of the form to be manipulated
     */
    static function insertLocSearchFix($formId = '#rs_search_form'){
        $document = JFactory::getDocument();
        $script = 
            "jQuery(function($){ 
                ".self::getLocationsInJSArray()." 
                $('".$formId."').submit(function(e){
                    //e.preventDefault();
                    //$('#rslocations').css('color', '#fff');
                    var location = $('#locations_typeahead').val();
                    if(location != ''){
                        var key = $.inArray(location, locations);
                        if( key == -1){
                            $('#rslocations').val(99999);
                        }else{
                            $('#rslocations').val(key);
                        }
                    }
                    return true;
                });
            });";
        $document->addScriptDeclaration($script);
    }
}
