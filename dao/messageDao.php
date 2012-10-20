<?php
include_once('../model/message.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messageDao
 *
 * @author Fred
 */
class messageDao {
    public function getMessageById($id){
        $messageSQL = self::$connexion->ExecuteSelect('SELECT * FROM message WHERE IDMESSAGE = ' . $id);
        $message = new message($messageSQL['IDMESSAGE'], $messageSQL['LBLMESSAGE'], $messageSQL['DATEMESSAGE'], $messageSQL['IDMESSAGE_REPONDRE'], $messageSQL['IDUSER'], $messageSQL['IDTRAIN']);
        
        return $message;
    }
    
    public function createMessage($label, $date, $idMessageParent, $idProprietaire, $idTrain){
        self::$connexion->ExecuteInsert("INSERT INTO message(LBLMESSAGE, DATEMESSAGE, IDMESSAGE_REPONDRE, IDUSER, IDTRAIN) VALUES ('" . $label . "', '" . $date . "', " . $idMessageParent . ", " . $idProprietaire . ", " . $idTrain . ')', array());
    }
}

?>
