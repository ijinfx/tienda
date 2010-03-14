<?php

JLoader::import( 'com_tienda.library.plugins.shippingcontroller', JPATH_ADMINISTRATOR.DS.'components' );

class TiendaControllerShippingExample extends TiendaControllerShippingPlugin {
		
	/**
	 * constructor
	 */
	function __construct() 
	{
		parent::__construct();
		$this->_element = 'shipping_example';
	}
	
	function save(){
		
		$id = JRequest::getInt('id', '0');
		$values = JRequest::get('post');
		
    	$this->includeCustomTables(); 
    	$table = JTable::getInstance('ShippingMethods', 'TiendaTable');
    	
    	$table->bind($values);
    	
    	$success =  $table->store($values);
		if($success){
        	$this->messagetype 	= 'message';
			$this->message  	= JText::_( 'Saved' );
        }
        else{
        	$this->messagetype 	= 'notice';
			$this->message 		= JText::_( 'Save Failed' )." - ".$row->getError();
        }
        
        $redirect = "index.php?option=com_tienda&view=shipping&task=view&id=".$id;    	

    	$redirect = JRoute::_( $redirect, false );
		$this->setRedirect( $redirect, $this->message, $this->messagetype );
    }
    
    function setRates(){
    	
    	JLoader::import( 'com_tienda.library.grid', JPATH_ADMINISTRATOR.DS.'components' );
    	JLoader::import( 'com_tienda.library.select', JPATH_ADMINISTRATOR.DS.'components' );
    	$this->includeCustomModel('ShippingRates');
        $sid = JRequest::getVar('sid');
        
        $this->includeCustomTables();  
        $row = JTable::getInstance('ShippingMethods', 'TiendaTable');
        $row->load($sid);
        
        $model = JModel::getInstance('ShippingRates', 'TiendaModel');
        $model->setState('filter_shippingmethod', $sid);
        $items = $model->getList();
        
        //form
        $form = array();
        $form['action'] = $this->baseLink();
        
        // view
        $view = $this->getView( 'Shipping_Example', 'html' );
		$view->hidemenu = true;
		$view->hidestats = true;
		$view->setModel( $model, true );
		$view->assign('row', $row);
		$view->assign('items', $items);
		$view->assign('form2', $form);
		$view->assign('baseLink', $this->baseLink());
		$view->setLayout('setrates');
		$view->display();
    }
    
    function view(){
		
    	$id = JRequest::getInt('id', '0');
    	$sid = TiendaShippingPlugin::getShippingId();
    	$this->includeCustomModel('ShippingMethods');  

        $model = JModel::getInstance('ShippingMethods', 'TiendaModel');
        $model->setId((int)$sid);
        
        $item = $model->getItem();
        
        // Form
        $form = array();
        $form['action'] = $this->baseLink()."&shippingTask=save";
		$view = $this->getView( 'Shipping_Example', 'html' ); 
		$view->hidemenu = true;
		$view->hidestats = true;
		$view->setModel( $model, true );
		$view->assign('item', $item);
		$view->assign('form2', $form);
		$view->setLayout('view');
		$view->display();
        
    }
    
/**
     * Creates a rate and redirects
     * 
     * @return unknown_type
     */
    function createrate()
    {
    	$this->includeCustomModel('shippingrates');
    	$this->includeCustomTables();
    	
        $this->set('suffix', 'shippingrates');
        $model  = $this->getModel( $this->get('suffix') );
        
        $row = $model->getTable();
        $row->bind(JRequest::get('post'));
        if ( $row->save() ) 
        {
            $dispatcher = JDispatcher::getInstance();
            $dispatcher->trigger( 'onAfterSave'.$this->get('suffix'), array( $row ) );
        } 
            else 
        {
            $this->messagetype  = 'notice';         
            $this->message      = JText::_( 'Save Failed' )." - ".$row->getError();
        }
        
        $redirect = $this->baseLink()."&shippingTask=setrates&sid={$row->shipping_method_id}&tmpl=component";
        $redirect = JRoute::_( $redirect, false );
        
        $this->setRedirect( $redirect, $this->message, $this->messagetype );
    }
    
	/**
     * Saves the properties for all prices in list
     * 
     * @return unknown_type
     */
    function saverates()
    {
        $error = false;
        $this->messagetype  = '';
        $this->message      = '';

        $this->includeCustomModel('ShippingRates');
        $this->includeCustomTables();
        $model = $this->getModel('shippingrates');
        $row = $model->getTable();
        
        $cids = JRequest::getVar('cid', array(0), 'request', 'array');
        $geozones = JRequest::getVar('geozone', array(0), 'request', 'array');
        $prices = JRequest::getVar('price', array(0), 'request', 'array');
        $weight_starts = JRequest::getVar('weight_start', array(0), 'request', 'array');
        $weight_ends = JRequest::getVar('weight_end', array(0), 'request', 'array');
        $handlings = JRequest::getVar('handling', array(0), 'request', 'array');
        
        foreach (@$cids as $cid)
        {
            $row->load( $cid );
            $row->geozone_id = $geozones[$cid];
            $row->shipping_rate_price = $prices[$cid];
            $row->shipping_rate_weight_start = $weight_starts[$cid];
            $row->shipping_rate_weight_end = $weight_ends[$cid];
            $row->shipping_rate_handling = $handlings[$cid];

            if (!$row->save())
            {
                $this->message .= $row->getError();
                $this->messagetype = 'notice';
                $error = true;
            }
        }
        
        if ($error)
        {
            $this->message = JText::_('Error') . " - " . $this->message;
        }
            else
        {
            $this->message = "";
        }

        $redirect = $this->baseLink()."&shippingTask=setrates&sid={$row->shipping_method_id}&tmpl=component";
        $redirect = JRoute::_( $redirect, false );
        
        $this->setRedirect( $redirect, $this->message, $this->messagetype );
    }
    
	function delete(){
    	$this->set('suffix', 'shippingrates');
    	parent::delete();
    }
    
} 