<?php

/**
 * PluginUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginUserForm extends BaseUserForm
{
    
  public function configure()
  {
      $this->useFields(array('email','auth_token'));
      
      $this->validatorSchema['email'] = new sfValidatorAnd(array(
            $this->validatorSchema['email'],
            new sfValidatorEmail(),
      ));
      
       $this->widgetSchema['auth_token'] = new sfWidgetFormInputHidden(['is_hidden' => true]);
    }
    
    public function save($con = null) {
        
        // generating new auth token
        $this->taintedValues['auth_token'] = md5($this->taintedValues['email'].rand(-9999,9999).rand(-9999,9999));
        $this->bind($this->taintedValues, $this->taintedFiles);
        return parent::save($con);
    }
}
