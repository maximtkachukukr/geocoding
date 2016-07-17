<?php

/**
 * default actions.
 *
 * @package    reverse_geocoding
 * @subpackage default
 */
class TokenAuthRegisterActions extends sfActions
{
    /**
     * Executes register action
     *
     * @param sfRequest $request A request object
     * 
     * if $request->getParameter('sf_format')=='json' then json response
     * if $request->getParameter('sf_format')=='html' - show register form
     */
    public function executeForm(sfWebRequest $request)
    {
        if($request->getParameter('sf_format')=='json'){
            $this->result =  array(
                'error'=>'Access token not exists'
            );
            $this->setTemplate('json');
        }else{
            
            $this->form = new UserForm();
            if($request->getMethod()==='POST'){
                
                $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

                if ($this->form->isValid()) {
                    $user = $this->form->save();
                    $this->user_data = $user->getData();
                    $this->setTemplate('show_token');  
                }else{
                    $this->setTemplate('new'); 
                }
            }else{
                $this->setTemplate('new'); 
            }
            
        }
        

    }
}
