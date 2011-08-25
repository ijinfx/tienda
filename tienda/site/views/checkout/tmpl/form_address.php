<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'tienda.js', 'media/com_tienda/js/'); ?>
<?php JHTML::_('stylesheet', 'tienda.css', 'media/com_tienda/css/'); ?>
<?php $config = TiendaConfig::getInstance(); ?>
<?php $three_col = $config->get('one_page_checkout_layout'); ?>
<?php $one_page = TiendaConfig::getInstance()->get('one_page_checkout', 0); ?>
<?php 
	switch($this->form_prefix)
	{
		case 'shipping_':
			$address_type = '2';
			break;
		default:
		case 'billing_':
			$address_type = '1';
			break;
	}
?>

<div id="<?php echo $this->form_prefix; ?>addressForm" class="address_form <?php if ($three_col == 'onepage-3col') {echo 'col3';} ?>">
    <?php if( !$this->guest && ($config->get('show_field_title', '3') == '3' || $config->get('show_field_title', '3') == $address_type ) ) { ?>
		
        <label class="key" for="<?php echo $this->form_prefix; ?>address_name"> <?php echo JText::_( 'Address Title' ); ?>
            <span class="block"><?php echo JText::_( 'Address Title For Your Reference' ); ?></span>
        </label>
        <input name="<?php echo $this->form_prefix; ?>address_name" id="<?php echo $this->form_prefix; ?>address_name"
		class="inputbox" type="text" maxlength="250" />&nbsp;
		<?php if(!$this->guest && ($config->get('validate_field_title', '3') == '3' || $config->get('validate_field_title', '3') == $address_type ) ): ?>
			*
		<?php endif;?>
			
	<?php } 
			else
				echo '<input value="'.JText::_( 'Temporary' ).'" name="'.$this->form_prefix.'address_name" id="'.$this->form_prefix.'address_name" type="hidden" />';
	?>
	<div class="floatbox">
	<?php if( $config->get('show_field_name', '3') == '3' || $config->get('show_field_name', '3') == $address_type ) :?>
    <div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
    	<label class="key" for="<?php echo $this->form_prefix; ?>first_name">
	    	<?php echo JText::_( 'First name' ); ?>
	    </label>
	    <input name="<?php echo $this->form_prefix; ?>first_name" id="<?php echo $this->form_prefix; ?>first_name" 
	    class="inputbox" type="text" maxlength="250" />
		<?php if($config->get('validate_field_name', '3') == '3' || $config->get('validate_field_name', '3') == $address_type ): ?>
			*
		<?php endif;?>
    </div>
    <?php endif; ?>
    
    <?php if( $config->get('show_field_middle', '3') == '3' || $config->get('show_field_middle', '3') == $address_type ) :?>
    <div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
    	<label class="key" for="<?php echo $this->form_prefix; ?>middle_name">
    		<?php echo JText::_( 'Middle name' ); ?>
        </label>
        <input type="text" name="<?php echo $this->form_prefix; ?>middle_name"
        id="<?php echo $this->form_prefix; ?>middle_name" class="inputbox" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_middle', '3') == '3' || $config->get('validate_field_middle', '3') == $address_type ): ?>
			*
		<?php endif;?>
    </div>
    <?php endif; ?>
    </div>
    
    <?php if( $config->get('show_field_last', '3') == '3' || $config->get('show_field_last', '3') == $address_type ) :?>
    	
    	<label class="key" for="<?php echo $this->form_prefix; ?>last_name">
    		<?php echo JText::_( 'Last name' ); ?>
    	</label>
        <input type="text" name="<?php echo $this->form_prefix; ?>last_name"
        id="<?php echo $this->form_prefix; ?>last_name" class="inputbox" size="45" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_last', '3') == '3' || $config->get('validate_field_last', '3') == $address_type ): ?>
			*
		<?php endif;?>
      
    <?php endif; ?>
    
    <?php if( $config->get('show_field_address1', '3') == '3' || $config->get('show_field_address1', '3') == $address_type ) :?>
    	
    	<label class="key" for="<?php echo $this->form_prefix; ?>address_1">
    		<?php echo JText::_( 'Address Line 1' ); ?>
    	</label>
        <input type="text" name="<?php echo $this->form_prefix; ?>address_1"
        id="<?php echo $this->form_prefix; ?>address_1" class="inputbox" size="48" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_address1', '3') == '3' || $config->get('validate_field_address1', '3') == $address_type ): ?>
			*
		<?php endif;?>
        
    <?php endif; ?>
    <?php if( $config->get('show_field_address2', '3') == '3' || $config->get('show_field_address2', '3') == $address_type ) :?>
    
    	<label class="key" for="<?php echo $this->form_prefix; ?>address_2">
    		<?php echo JText::_( 'Address Line 2' ); ?>
    	</label>
        <input type="text" name="<?php echo $this->form_prefix; ?>address_2"
        id="<?php echo $this->form_prefix; ?>address_2" class="inputbox" size="48" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_address2', '3') == '3' || $config->get('validate_field_address2', '3') == $address_type ): ?>
			*
		<?php endif;?>
       
    <?php endif; ?>
    
    <?php if( $config->get('show_field_country', '3') == '3' || $config->get('show_field_country', '3') == $address_type ) :?>
	
		<label class="key">
			<?php echo JText::_( 'Country' ); ?>
		</label>
		<?php
		$url = "index.php?option=com_tienda&format=raw&controller=checkout&task=getzones&prefix={$this->form_prefix}&country_id=";
		
		$onchange = 'tiendaPutAjaxLoader( \''.$this->form_prefix.'zones_wrapper\' );tiendaDoTask( \''.$url.'\'+document.getElementById(\''.$this->form_prefix.'country_id\').value, \''.$this->form_prefix.'zones_wrapper\', \'\', \'\', false, function() {tiendaCheckoutAutomaticShippingRatesUpdate( \''.$this->form_prefix.'country_id\', \''.JText::_( 'Updating Shipping Rates' ).'\', \''.JText::_( 'Updating Cart' ).'\', \''.JText::_( 'Updating Address' ).'\' );}  );';
		if( $one_page )
		{
			$onchange = 'tiendaPutAjaxLoader( \''.$this->form_prefix.'zones_wrapper\' );'.
									'tiendaDoTask( \''.$url.'\'+document.getElementById(\''.$this->form_prefix.'country_id\').value, \''.$this->form_prefix.'zones_wrapper\', \'\', \'\', false, '.
									'function() {tiendaCheckoutAutomaticShippingRatesUpdate( \''.$this->form_prefix.'country_id\', \''.JText::_( 'Updating Shipping Rates' ).'\', \''.JText::_( 'Updating Cart' ).'\', \''.JText::_( 'Updating Address' ).'\' ); '.
									'	});';
		}
		
		$attribs = array('class' => 'inputbox','size' => '1','onchange' => $onchange );
		echo TiendaSelect::country( $this->default_country_id, $this->form_prefix.'country_id', $attribs, $this->form_prefix.'country_id', false, true );
		?>&nbsp;
		<?php if($config->get('validate_field_country', '3') == '3' || $config->get('validate_field_country', '3') == $address_type ): ?>
			*
		<?php endif;?>
        
	<?php endif; ?>
    
    <?php if( $config->get('show_field_city', '3') == '3' || $config->get('show_field_city', '3') == $address_type ) :?>
	
    	<label class="key" for="<?php echo $this->form_prefix; ?>city">
    		<?php echo JText::_( 'City' ); ?>
    	</label>        
		<input type="text" name="<?php echo $this->form_prefix; ?>city" 
		id="<?php echo $this->form_prefix; ?>city" class="inputbox" size="48" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_city', '3') == '3' || $config->get('validate_field_city', '3') == $address_type ): ?>
			*
		<?php endif;?>
		
	<?php endif; ?>
	
	<div class="floatbox">
		
		<?php if( $config->get('show_field_zip', '3') == '3' || $config->get('show_field_zip', '3') == $address_type ) :?>
		<div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
			<label class="key" for="<?php echo $this->form_prefix; ?>postal_code">
				<?php echo JText::_( 'Postal code' ); ?>
			</label>
			<?php 
					$onchange = '';
					if( $one_page )
						$onchange = 'tiendaCheckoutAutomaticShippingRatesUpdate( \''.$this->form_prefix.'postal_code\', \''.JText::_( 'Updating Shipping Rates' ).'\', \''.JText::_( 'Updating Cart' ).'\', \''.JText::_( 'Updating Address' ).'\' )';
					else
						if( !empty($this->showShipping)&& $this->forShipping )
							$onchange = 'tiendaGrayOutAddressDiv( \''.JText::_( 'Updating Address' ).'\' ); tiendaGetShippingRates( \'onCheckoutShipping_wrapper\', this.form,  \''.JText::_( 'Updating Shipping Rates' ).'\', tiendaDeleteAddressGrayDiv);';
			?>
			<input type="text" name="<?php echo $this->form_prefix; ?>postal_code"
			id="<?php echo $this->form_prefix; ?>postal_code" class="inputbox" size="25" maxlength="250" 
			<?php if ( strlen( $onchange ) ) { ?>onchange="<?php echo $onchange; ?>" <?php } ?> 
			/>&nbsp;
			<?php if($config->get('validate_field_zip', '3') == '3' || $config->get('validate_field_zip', '3') == $address_type ): ?>
				*
			<?php endif;?>
		</div>
		<?php endif; ?>
		
		<?php if( $config->get('show_field_zone', '3') == '3' || $config->get('show_field_zone', '3') == $address_type ) :?>
		<div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
			<label class="key">
				<?php echo JText::_( 'Zone' ); ?>
			</label>
        	<div id="<?php echo $this->form_prefix; ?>zones_wrapper">
            	<?php
                	if (!empty($this->zones)) {
                    	echo $this->zones;
                	} else {
                    	echo JText::_( "Select Country First" );
                	}
            	?>
            <?php if($config->get('validate_field_zone', '3') == '3' || $config->get('validate_field_zone', '3') == $address_type ): ?>
				*
			<?php endif;?>
        	</div>
		</div>
	<?php endif; ?>
		
	</div>
    
    <?php if( $config->get('show_field_phone', '3') == '3' || $config->get('show_field_phone', '3') == $address_type ) :?>
	
		<label class="key" name="<?php echo $this->form_prefix; ?>phone_1">
			<?php echo JText::_( 'Phone' ); ?>
		</label>
		<input name="<?php echo $this->form_prefix; ?>phone_1" id="<?php echo $this->form_prefix; ?>phone_1"
		class="inputbox" type="text" size="25" maxlength="250" />&nbsp;
		<?php if($config->get('validate_field_phone', '3') == '3' || $config->get('validate_field_phone', '3') == $address_type ): ?>
			*
		<?php endif;?>
		
	<?php endif; ?>
	
	<div class="floatbox">
    <?php if( $config->get('show_field_company', '3') == '3' || $config->get('show_field_company', '3') == $address_type ) :?>
     	<div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
     		<label class="key" for="<?php echo $this->form_prefix; ?>company">
    			<?php echo JText::_( 'Company' ); ?>
        	</label>
        	<input type="text" name="<?php echo $this->form_prefix; ?>company" id="<?php echo $this->form_prefix; ?>company"
        	class="inputbox" size="48" maxlength="250" />&nbsp;
			<?php if($config->get('validate_field_company', '3') == '3' || $config->get('validate_field_company', '3') == $address_type ): ?>
				*
			<?php endif;?>
     	</div>
    <?php endif; ?>
    <?php if( $config->get('show_field_tax_number', '3') == '3' || $config->get('show_field_tax_number', '3') == $address_type ) :?>
    	<div class="<?php if ($three_col == 'onepage-3col') { echo 'left50'; } ?>">
    		<label class="key" for="<?php echo $this->form_prefix; ?>tax_number"> 
        		<?php echo JText::_( 'Co. Tax Number' ); ?>
        	</label>
        	<input type="text" name="<?php echo $this->form_prefix; ?>tax_number" id="<?php echo $this->form_prefix; ?>tax_number"
        	class="inputbox" size="48" maxlength="250" />&nbsp;
			<?php if($config->get('validate_field_tax_number', '3') == '3' || $config->get('validate_field_tax_number', '3') == $address_type ): ?>
				*
			<?php endif;?>
    	</div>
    <?php endif; ?>
    </div>
    
	<?php 
		$data = new JObject();
		$dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger('onAfterDisplayAddressDetails', array($data, $this->form_prefix) );
	?>
	
</div>
