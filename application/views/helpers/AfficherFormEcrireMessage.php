<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Vérifie les droits de l'utilisateur sur l'évènement à écrire un message
 * Retourne le formulaire passé en paramètre
 * TODO : réfléchir à la possibilité de généraliser cette méthode pour un peu tout
 * @author alexsolex
 */
class Zend_View_Helper_AfficherFormEcrireMessage extends Zend_View_Helper_Abstract {
    const PRIVILEGE_ACTION = 'envoyer';
    const RESOURCE_CONTROLLER = 'message';
    
    public function afficherFormEcrireMessage($formulaire) {    
        
        //récupération de l'idOrga de l'évènement en session
        $bulleNamespace = new Zend_Session_Namespace('bulle');
        //session active ?
        if (isset($bulleNamespace->checkedInEvent)) {
            $event = $bulleNamespace->checkedInEvent;
            $IDorga = $event->idOrga;
        }
        else
        {
            //TODO rediriger car ne devrait jamais arriver (pas de liste de messages sans évènement)
            return 'Pas d\'évènement !';
        }
        
        // récupération de l'utilisateur
        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            $idUser = $auth->getIdentity ()->idUser;
            $tableUtilisateur = new Application_Model_DbTable_Utilisateur();
            $user = $tableUtilisateur->find($idUser)->current();
        }else{
            return 'Vous n\'êtes pas connecté. Vous ne pouvez pas envoyer de messages';
        }
        
        //Détermination du rôle de l'utilisateur dans l'organisme
        if (!is_null($user)) {
            $role = $user->getRole($IDorga);
        }else{
            $role = 'visiteur';
        }
        
        //définition 
        $resourceController  = self::RESOURCE_CONTROLLER;// 'message';
        $privilegeAction     = self::PRIVILEGE_ACTION;//'envoyer';
        $ACL = Zend_Registry::get('Zend_Acl');
        if(!$ACL->isAllowed($role, $resourceController, $privilegeAction))
        {
            return 'Vous n\'avez pas le droit d\écrire de messages';
        }
        
        return $formulaire;
    }
}

