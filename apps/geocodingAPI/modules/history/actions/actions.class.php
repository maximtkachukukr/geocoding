<?php

/**
 * history actions.
 * 
 * this is controller for REST API of a requests history
 */
class historyActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      
      $this->result =  Doctrine::getTable('History')
              ->createQuery()
              ->where('user_id = "'.$this->getUser()->getUserColumn('id').'"')
              ->orderBy('created_at DESC')
              ->fetchArray();
      
      $this->setTemplate('json','history');
      
  }
  
  public function executeGetOne(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $this->result =  Doctrine::getTable('History')->findOneById(intval($id));
      if($this->result){
          $this->result = $this->result->toArray();
      }else{
          $this->result = array('error'=>'Record not found');
      }
      $this->setTemplate('json','history');
      
  }
  
  public function executeDeleteOne(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    if (Doctrine::getTable('History')->findOneById(intval($id))){
        
        Doctrine::getTable('History')
                ->findOneById(intval($id))
                ->delete();
        
        $this->result = array('result'=>'OK');

    }else{
        $this->result = array('error'=>'Record not found');
    }

      $this->setTemplate('json','history');
      
  }
}
