<?php
include_once('../model/message.php');

class messageDao {
	
    public function getMessageById($id){
        $messageSQL = self::$connexion->ExecuteSelectOne('SELECT * FROM message WHERE IDMESSAGE = ' . $id);
        $message = new message($messageSQL['IDMESSAGE'], $messageSQL['LBLMESSAGE'], $messageSQL['DATEMESSAGE'], $messageSQL['IDMESSAGE_REPONDRE'], $messageSQL['IDUSER'], $messageSQL['IDTRAIN']);
    
        return $message;
    }
    
    public function createMessage($label, $date, $idMessageParent, $idProprietaire, $idTrain){
        self::$connexion->ExecuteInsert("INSERT INTO message(LBLMESSAGE, DATEMESSAGE, IDMESSAGE_REPONDRE, IDUSER, IDTRAIN) VALUES ('" . $label . "', '" . $date . "', " . $idMessageParent . ", " . $idProprietaire . ", " . $idTrain . ')', array());
    }
}

?>
