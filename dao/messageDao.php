<?php
include_once('../model/message.php');

class messageDao {
	
    public function getMessageById($id){
        $messageSQL = self::$connexion->ExecuteSelectOne('SELECT * FROM message WHERE IDMESSAGE = ' . $id);
        $message = new message($messageSQL['IDMESSAGE'], $messageSQL['LBLMESSAGE'], $messageSQL['DATEMESSAGE'], $messageSQL['IDMESSAGE_REPONDRE'], $messageSQL['IDUSER'], $messageSQL['IDTRAIN']);
        return $message;
    }
    
    public function createMessage($label, $date, $idMessageParent, $idProprietaire, $idTrain){
        $tabData = array();
        $tabData['LBLMESSAGE'] = $_POST['nomutil'];
        $tabData['DATEMESSAGE'] = $_POST['prenom'];
        $tabData['IDMESSAGE_REPONSE'] = $_POST['mail'];
        $tabData['IDUSER'] = $_POST['newlogin'];
        $tabData['IDTRAIN'] = md5($_POST['newpass']);
        self::$connexion->ExecuteInsert('INSERT INTO message(LBLMESSAGE, DATEMESSAGE, IDMESSAGE_REPONDRE, IDUSER, IDTRAIN) VALUES (:LBLMESSAGE, :DATEMESSAGE, :IDMESSAGE_REPONDRE, :IDUSER, :IDTRAIN)', $tabData);
    }
}

?>
