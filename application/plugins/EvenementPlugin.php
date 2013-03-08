<?php

/**
 * gère l'évènement
 * TODO : documentation
 * */
class Application_Plugin_EvenementPlugin extends Zend_Controller_Plugin_Abstract {

    private $_evenement = null;
    private $_organisme = null;
     
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        
        $module = $request->getModuleName();
        
        $front = Zend_Controller_Front::getInstance();
        $default = $front->getDefaultModule();
        
        switch ($module) {
            case $default:
                $this->handleDefault($request);
                break;
            case 'admin':
                $this->handleAdmin($request);
                break;
            default:
                break;
        }
        

    }
    
    //
    // MODULE ADMIN
    //
    
    
    //gère le plugin pour le module admin
    public function handleAdmin($request){
        $this->getOrganisme();
        
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        
        //TODO que faire avec la requête pour le module admin ? 
        //par exemple si pas d'organisme : rediriger sur la page de sélection de l'organisme ?
        if (is_null($this->_organisme)) { //nous ne sommes pas rattachés à un organisme
            if (!($controller=='organisme' && $action=='lister')) {
                //ce n'est pas organisme/lister qui est appelé, il faut rediriger dessus 
                $front = Zend_Controller_Front::getInstance();
                $request->setParam('infoDefautOrganisme',"Aucun organisme sélectionné il faut d'abord en sélectionner un !");
                $request->setControllerName('organisme');
                $request->setActionName('lister');
                $front->returnResponse();     
            }
        }
        return;
    }
    
    public function getOrganisme(){
        $adminNameSpace = new Zend_Session_Namespace('admin');
        if (isset($adminNameSpace->organisme)) {
            $this->_organisme = $adminNameSpace->organisme;
            $this->_organisme->setTable(new Application_Model_DbTable_Organisme());
            //inscrit l'organisme dans le registre
            Zend_Registry::set('organismeAdmin',$this->_organisme );
        }
        else
        {
            $this->_organisme = null;
        }
    }
    
    //
    // MODULE DEFAULT
    //
    
    //gère le plugin pour le module default
    public function handleDefault($request){
        $this->getEvenement();
        
        $message = null;
        
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        //tous les cas qui redirigent si pas d'évènement
        if (    
                ($controller=='evenement' && $action=='accueil') || 
                ($controller!='evenement' && $controller!='utilisateur') ||
                ($controller=='index' && $action=='index') 
            ) 
        {
            if (is_null($this->_evenement ) ){
                //pour toutes ces actions, l'utilisateur doit avoir check un évènement
                //pour tous ces cas, sans évènement en session, on redirige sur la page par défaut
                $message = 'Vous devez être dans un évènement pour pouvoir continuer !';
                $this->setRedirection($request, $message);
                return;
                
            } 
            else{
                //l'utilisateur a check dans un évènement, il faut vérifier les dates d'activité
                //vérifions un évènement passé (datefin+duree<datemaintenant)
                $maintenant = Zend_Date::now();
                $dateDebut = new Zend_Date($this->_evenement->dateDebutEvent,'yyyy-MM-dd HH:mm:ss S');
                $dateFin = new Zend_Date($this->_evenement->dateFinEvent,'yyyy-MM-dd HH:mm:ss S');
                if ($maintenant < $dateDebut ){
                    $message = 'Désolé ! Cet évènement commence le '.$dateDebut->toString('dd/MM/yyyy à HH:mm:ss');
                    $this->setRedirection($request,$message);
                    //suppression de l'event en session
                    $this->checkout();
                    return;
                }
                elseif (!is_null($this->_evenement->dateFinEvent) && ($maintenant > $dateFin) )
                {
                    $message = 'Désolé mais cet évènement s\'est terminé le '.$dateDebut->toString('dd/MM/yyyy à HH:mm:ss');    
                    $this->setRedirection($request,$message);
                    //suppression de l'event en session
                    $this->checkout();
                    return;
                }
                else{
                    
                    return;
                } 
            }
        }
    }
    
    public function getEvenement(){
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $this->_evenement = $bulleNamespace->checkedInEvent;
            //La ligne qui suit est indispensable pour que les tables liées à la table évènement 
            //  soient mémorisées dans la session
            //  http://gustavostraube.wordpress.com/2010/05/11/zend-framework-cannot-save-a-row-unless-it-is-connected/
            $this->_evenement->setTable(new Application_Model_DbTable_Evenement());
        
            //inscrit l'évènement dans le registre
            Zend_Registry::set('checkedInEvent',$this->_evenement );
        }
        else
        {
            $this->_evenement = null;
        }
    }
    
    public function setRedirection($request,$message){
        $front = Zend_Controller_Front::getInstance();
        $defaultModule = $front->getDefaultModule();
        $request->setParam('infoDefautEvenement',$message);
        $request->setModuleName($defaultModule);
        $request->setControllerName('evenement');
        $request->setActionName('defaut');
        $front->returnResponse();       
    }
    
    public function checkout(){
        $defaultNamespace = new Zend_Session_Namespace('bulle');
        unset($defaultNamespace->checkedInEvent);
    }
}
?>
