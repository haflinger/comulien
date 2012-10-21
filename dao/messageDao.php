<?php
require_once(MODELEPATH . 'message.php');
require_once(MODELEPATH . 'dbConnect.php');

function getMessageById($id){
        $connexion = dbConnect::getInstance();
        $messageSQL = $connexion->ExecuteSelectOne('SELECT * FROM message WHERE IDMESSAGE = ' . $id);
        $message = new message($messageSQL['IDMESSAGE'], $messageSQL['LBLMESSAGE'], $messageSQL['DATEMESSAGE'], $messageSQL['IDMESSAGE_REPONDRE'], $messageSQL['IDUSER'], $messageSQL['IDTRAIN']);
        return $message;
    }
    
function getAllMessage(){
         $connexion = dbConnect::getInstance();
        $messageSQL = $connexion->ExecuteSelectOne('SELECT * FROM message');
        $message = new message($messageSQL['IDMESSAGE'], $messageSQL['LBLMESSAGE'], $messageSQL['DATEMESSAGE'], $messageSQL['IDMESSAGE_REPONDRE'], $messageSQL['IDUSER'], $messageSQL['IDTRAIN']);
        return $message;
    }
    
function createMessage($idparent, $label, $date, $idProprietaire, $idTrain){
        $connexion = dbConnect::getInstance();
        $tabData = array();
        $tabData['IDMESSAGE_REPONDRE'] = $idparent;
        $tabData['IDUSER'] = $idProprietaire;
        $tabData['IDTRAIN'] = $idTrain;
        $tabData['LBLMESSAGE'] = $label;
        $tabData['DATEMESSAGE'] = $date;
        var_dump($tabData);
        $connexion->ExecuteInsert('INSERT INTO message(IDMESSAGE_REPONDRE, IDUSER, IDTRAIN, LBLMESSAGE, DATEMESSAGE) VALUES (:IDMESSAGE_REPONDRE, :IDUSER, :IDTRAIN, :LBLMESSAGE, :DATEMESSAGE)', $tabData);
        //$tabMod = array();
        //$tabMod['IDUSER'] = $idProprietaire;
        //$connexion->ExecuteUpdate('UPDATE user SET NBMESSAGE = NBMESSAGE + 1 WHERE IDUSER = :IDUSER', $tabMod);
    }

    function listeMessageParent($idTrain){
        $connexion = dbConnect::getInstance();
        $listeMessP = $connexion->ExecuteSelect('SELECT * FROM message WHERE idtrain = ' . $idTrain . ' AND IDMESSAGE_REPONDRE is null');
        $test = listeMessageEnfant($listeMessP, $idTrain);
        return $test;
    }
    function listeMessageEnfant($listeMessP, $idTrain){
        $connexion = dbConnect::getInstance();
        $listeMessE = $connexion->ExecuteSelect('SELECT * FROM message WHERE idtrain = ' . $idTrain . ' AND IDMESSAGE_REPONDRE is not null');
        $test = prepareListeMessage($listeMessP, $listeMessE);
        return $test;
    }    
    function prepareListeMessage($listeP, $listeE){
        $tabfinal = array();
        foreach ($listeP as $messP){

            foreach ($listeE as $messE) {
                $messP[] = $messE;
            }
            $tabfinal[] = $messP;
        }
         var_dump($tabfinal);  
    }
?>
