<?php 

namespace mata\client\controllers;

use Yii;
use mata\client\models\Client;
use mata\client\models\ClientSearch;
use matacms\controllers\module\Controller;

class ClientController extends Controller {

	public function getModel() {
		return new Client();
	}

	public function getSearchModel() {
		return new ClientSearch();
	}
	
}