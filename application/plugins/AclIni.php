<?php

/**
 * Classe de création des ACL via un fichier de configuration INI
**/

class Application_Plugin_AclIni extends Zend_Acl	{
	public function __construct($file)	{
		$roles = new Zend_Config_Ini($file, 'roles') ;
		$this->_setRoles($roles) ;
		
		$ressources = new Zend_Config_Ini($file, 'ressources') ;
		$this->_setRessources($ressources) ;
		
		foreach ($roles->toArray() as $role => $parents)	{
			$privileges = new Zend_Config_Ini($file, $role) ;
			$this->_setPrivileges($role, $privileges) ;
		}
	}
	
        public function test(){
            //WIP : refaire les rôles sans le ini
            $this->addRole('visiteur');
            $this->addRole('utilisateur','visiteur');
            $this->addRole('identifie','utilisateur');  //regroupe pour le moment les corp et orga
            $this->addRole('corporate','identifie');
            $this->addRole('organisateur','identifie');
            $this->addRole('dev');
            
            $this->addResource('resource');
            $this->addResource('evenement');
            $this->addResource('index');
            $this->addResource('login');
            $this->addResource('message');
            $this->addResource('organisme');
            $this->addResource('profil');
            $this->addResource('qrcode');
            $this->addResource('typemessage');
            $this->addResource('utilisateur');
            

//allow.login = index,login,logout
//allow.message = lister-tous,lister-organisateur
//deny.message = approuver
//allow.utilisateur = inscrire,profilpublic,authentifier,deconnecter
//allow.error = null ; ATTENTION : pour les tests seulement !!
            $this->allow('visiteur','evenement','checkin');
            $this->allow('visiteur','evenement','accueil');
            $this->allow('visiteur','evenement','checkout');
            $this->allow('visiteur','evenement','defaut');
            $this->allow('visiteur','evenement','liste');
            
            $this->allow('visiteur','message','lister-tous');
            $this->allow('visiteur','message','lister-organisateur');
            
            $this->allow('visiteur','login','lister-organisateur');
            
            
            
            
        }
	protected function _setRoles($roles)	{
		foreach ($roles as $role => $parents)	{
			if (empty($parents))	{
				$parents = null ;
			} else {
				$parents = explode(',', $parents) ;
			}

			$this->addRole(new Zend_Acl_Role($role), $parents);
		}
		
		return $this ;
	}

	protected function _setRessources($ressources)	{
		foreach ($ressources as $ressource => $parents)	{
			if (empty($parents))	{
				$parents = null ;
			} else {
				$parents = explode(',', $parents) ;
			}

			$this->add(new Zend_Acl_Resource($ressource), $parents);
		}
		
		return $this ;
	}

	protected function _setPrivileges($role, $privileges)	{
		foreach ($privileges as $do => $ressources)	{
			foreach ($ressources as $ressource => $actions)	{
				if (empty($actions))	{
					$actions = null ;
				} else {
					$actions = explode(',', $actions) ;
				}
				
				$this->{$do}($role, $ressource, $actions);
			}
		}
		
		return $this ;
	}
}

?>
