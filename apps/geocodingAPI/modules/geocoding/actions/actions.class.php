<?php

/**
 * geocoding actions.
 *
 
  * API GET params list:
  * lat - first coordinate
  * lng - second coordinate
  * address - addres 
 * 
 */
class geocodingActions extends sfActions
{
 
    public function executeGeocoding(sfWebRequest $request)
    {

        if($request->getParameter('lat')===null || $request->getParameter('lng')===null){
            return $this->renderErrorResponse('Need coordinates');
        }

        $this->result = $this->findInGoogleAPIByCoordinates($request->getParameter('lat'),$request->getParameter('lng'));
        
        $this->saveHistory('Request to Google API (coordinates->address)');
      
        $this->setTemplate('json');

    }
  
    public function executeEndpoint(sfWebRequest $request) {
        if($request->getParameter('address')===null){
            return $this->renderErrorResponse('Need address');
        }

        $this->result = $this->findInGoogleAPIByAddress($request->getParameter('address'));
       
        $this->saveHistory('Request to Google API (address->coordinates)');
        
        $this->setTemplate('json');
    }

    /**
     * get address by coordinates
     * 
     * for testing used this google API 
     * https://developers.google.com/maps/documentation/javascript/examples/geocoding-reverse
     */
    private function findInGoogleAPIByCoordinates($lat,$lng){
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng;
        $res  = json_decode(file_get_contents($url));
        
        return (array)$res->results;
    }
    
    /**
     * 
     * get coordinates by address
     * 
     * for testing used this google API 
     * https://maps.googleapis.com/maps/api/geocode/json?address=<addres>
     */
    private function findInGoogleAPIByAddress($address){
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.$address;
        
        $res  = json_decode(file_get_contents($url));
        
        if(isset($res->results[0]) && isset($res->results[0]->geometry) && isset($res->results[0]->geometry->location)){
            return ((array)$res->results[0]->geometry->location);
        }else{
            return array('error'=>'Not found');
        }
    }
    
    public function saveHistory($msg){
        $history = new History();
        $history->user_id = $this->getUser()->getUserColumn('id');
        $history->message = $msg;
        $history->save();
    }

    private function renderErrorResponse($msg){
        $this->result =  array(
            'error'=>$msg
        );
        
        $this->setTemplate('json');
  }
}
