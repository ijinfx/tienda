<?php
/**
 * @version	0.1
 * @package	Tienda
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

// Check the registry to see if our Tienda class has been overridden
if ( !class_exists('Tienda') ) 
    JLoader::register( "Tienda", JPATH_ADMINISTRATOR."/components/com_tienda/defines.php" );

// load the config class
Tienda::load( 'Tienda', 'defines' );

// set the options array
$options = array( 'site'=>'site', 'type'=>'components', 'ext'=>'com_tienda' );

// Require the base controller
Tienda::load( 'TiendaController', 'controller', $options );

// Load Custom Language File if needed (com_tienda_custom)
if(Tienda::getInstance()->get('custom_language_file', '0'))
{
	$lang = JFactory::getLanguage();
	$extension = 'com_tienda_custom';
	$base_dir = JPATH_SITE;
	$lang->load($extension, $base_dir, null, true);
}

$app = JFactory::getApplication();

// Check if protocol is specified
$protocol = $app->input->getWord('protocol', ;;);

// Require specific controller if requested
$controller = $app->input->getWord('controller', $app->input->get( 'view' ) );

// if protocol is specified, try to load the specific controller
if(strlen($protocol))
{
	// file syntax: controller_json.php
	if (Tienda::load( 'TiendaController'.$controller.$protocol, "controllers.".$controller."_".$protocol, $options ))
    	$controller .=  $protocol;
}
else
{
	if (!Tienda::load( 'TiendaController'.$controller, "controllers.$controller", $options ))
    	$controller = '';
}

if (empty($controller))
{
    // redirect to default
    $redirect = "index.php?option=com_tienda&view=products";
    $redirect = JRoute::_( $redirect, false );
    $app->redirect( $redirect );
}

$doc = JFactory::getDocument();
$js = "var com_tienda = {};\n";
$js.= "com_tienda.jbase = '".Tienda::getUriRoot()."';\n";
$doc->addScriptDeclaration($js);

$parentPath = JPATH_ADMINISTRATOR . '/components/com_tienda/helpers';
DSCLoader::discover('TiendaHelper', $parentPath, true);

$parentPath = JPATH_ADMINISTRATOR . '/components/com_tienda/library';
DSCLoader::discover('Tienda', $parentPath, true);

$parentPath = JPATH_ADMINISTRATOR . '/components/com_tienda/tables';
DSCLoader::discover('TiendaTable', $parentPath, true);

// load the plugins
JPluginHelper::importPlugin( 'tienda' );

// Check Json Class Existance
if ( !function_exists('json_decode') ) 
{
	// This should load not only the class, but also json_encode / json_decode
	Tienda::load('Services_JSON', 'library.json');
}

// Create the controller
$classname = 'TiendaController'.$controller;
$controller = Tienda::getClass( $classname );

// ensure a valid task exists
$task = $app->input->get('task');
if (empty($task))
{
    $task = 'display';	
}
$app->input->set( 'task', $task );

// Perform the requested task
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();
