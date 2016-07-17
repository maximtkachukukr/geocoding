<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: tokenSecurityUser.class.php 30260 2010-07-16 13:55:09Z fabien $
 */
class tokenSecurityUser extends sfBasicSecurityUser
{
    /**
     *
     * login key of the GET param 
     */
    private $auth_param  = 'key';
    
    /**
     *
     * login GET param value taken from $auth_param  key
     */
    private $auth_token_value  = null;
    protected $user = null;

  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    $this->auth_token_value = sfContext::getInstance()->getRequest()->getParameter($this->auth_param);
    if (!$this->isAuthenticated())
    {
        $this->user = null;
      
    }
  }
  
  public function isAuthenticated()
  {
      $user = Doctrine_Core::getTable('User')->findOneByAccessToken($this->auth_token_value);
      
      if(!$user){
          return false;
      }else{
          $this->user = $user;
          return true;
      }
  }
  
  public function getAuthKey(){
      return $this->auth_param;
  }
  
  public function getAuthKeyValue(){
      return $this->auth_token_value;
  }
  
  public function getUserColumn($column){
      if ($this->user){
          $data = $this->user->getData();
        return $data[$column];
      }else{
          return NULL;
      }
  }
}
