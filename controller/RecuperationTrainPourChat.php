<?php
require_once '../dao/trainDao.php';

if(isset($_GET['numtrain'])){
	
	$name_train = $_GET['numtrain'];
	
	$dao = new trainDao();
	$train = $dao->getTrainByName($name_train);
	header('Location:http://gentoo.vm/hackaton/webdev/comulien/view/train.php?idtrain='.$train->getIdtrain());
} 
else 
{
	header('Location:index.php');
}