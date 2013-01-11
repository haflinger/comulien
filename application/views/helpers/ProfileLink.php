<?php
/**
 * Permet de générer le lien de connexion / déconnexion
 */
class Zend_View_Helper_ProfileLink extends Zend_View_Helper_Abstract {
    public function profileLink() {
        $helperUrl = new Zend_View_Helper_Url ( );
        $auth = Zend_Auth::getInstance ();
        if ($auth->hasIdentity ()) {
            $username = $auth->getIdentity ()->loginUser;// . ' ' . strtoupper ( substr ( $auth->getIdentity ()->loginUser, 0, 1 ) ) . '.';
            $lienDeconnexion = $helperUrl->url ( array ('action' => 'deconnecter', 'controller' => 'utilisateur' ) );
            $lienProfil = $helperUrl->url ( array ('action' => 'modifier', 'controller' => 'utilisateur' ) );
            //$retourHelper ='<a href="'.$lienProfil.'" alt="Voir mon profil">'.$username . '</a> (<a href="' . $lienDeconnexion . '">Logout</a>)';
            $retourHelper = $lienDeconnexion;
            
        }else{
            $lienConnexion = $helperUrl->url ( array ('action' => 'authentifier', 'controller' => 'utilisateur' ) );
            //$retourHelper = '<a href="' . $lienConnexion . '">Login</a>';
            $retourHelper = $lienConnexion;
        }
        return $retourHelper;
    }
}