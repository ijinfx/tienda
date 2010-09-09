<?php defined('_JEXEC') or die('Restricted access'); ?>

<style type="text/css">
    #moneris_form { width: 100%; }
    #moneris_form td { padding: 5px; }
    #moneris_form .field_name { font-weight: bold; }
</style>

<form action="<?php echo JRoute::_( "index.php?option=com_tienda&view=checkout" ); ?>" method="post" name="adminForm" enctype="multipart/form-data">

    <div class="note">
        <?php echo JText::_( "TIENDA MONERIS PAYMENT PREPARATION MESSAGE" ); ?>
        
        <table id="moneris_form">            
            <tr>
                <td class="field_name"><?php echo JText::_( 'Credit Card Type' ) ?></td>
                <td><?php echo $vars->cardtype; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'Card Number' ) ?></td>
                <td>************<?php echo $vars->cardnum_last4; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'Expiration Date' ) ?></td>
                <td><?php echo $vars->cardexp; ?></td>
            </tr>
            <tr>
                <td class="field_name"><?php echo JText::_( 'Card CVV Number' ) ?></td>
                <td>****</td>
            </tr>
        </table>
    </div>

    <input type='hidden' name='cardtype' value='<?php echo @$vars->cardtype; ?>'>
    <input type='hidden' name='cardnum' value='<?php echo @$vars->cardnum; ?>'>
    <input type='hidden' name='cardexp' value='<?php echo @$vars->cardexp; ?>'>
    <input type='hidden' name='cardcvv' value='<?php echo @$vars->cardcvv; ?>'>

    <input type="submit" class="button" value="<?php echo JText::_('Click Here to Complete Order'); ?>" />

    <input type='hidden' name='order_id' value='<?php echo @$vars->order_id; ?>'>
    <input type='hidden' name='orderpayment_id' value='<?php echo @$vars->orderpayment_id; ?>'>
    <input type='hidden' name='orderpayment_type' value='<?php echo @$vars->orderpayment_type; ?>'>
    <input type='hidden' name='task' value='confirmPayment'>
    <input type='hidden' name='paction' value='process'>
    
     <input type='hidden' name='first_name' value='<?php echo @$vars->data['first_name']; ?>'>
     <input type='hidden' name='last_name' value='<?php echo @$vars->data['last_name']?>'>
     <input type='hidden' name='address_line_1' value='<?php echo @$vars->data['address_line_1']; ?>'>
     <input type='hidden' name='address_line_2' value='<?php echo @$vars->data['address_line_2']; ?>'>
     <input type='hidden' name='city' value='<?php echo @$vars->data['city']; ?>'>
     <input type='hidden' name='state' value='<?php echo @$vars->data['state']; ?>'>
     <input type='hidden' name='postal_code' value='<?php echo @$vars->data['postal_code']; ?>'>
     <input type='hidden' name='country' value='<?php echo @$vars->data['country']; ?>'>
     <input type='hidden' name='orderpayment_amount' value='<?php echo @$vars->data['orderpayment_amount']; ?>'>
     <input type='hidden' name='expiration_month' value='<?php echo @$vars->data['expiration_month']; ?>'>
     <input type='hidden' name='expiration_year' value='<?php echo @$vars->data['expiration_year']; ?>'>
    
    <?php echo JHTML::_( 'form.token' ); ?>
</form>