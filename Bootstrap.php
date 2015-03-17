<?php 

namespace mata\client;

use Yii;
use mata\client\behaviors\ClientActiveFormBehavior;
use yii\base\Event;
use matacms\widgets\ActiveField;
use mata\base\MessageEvent;
use mata\client\models\Client;
use mata\client\models\ClientItem;

//TODO Dependency on matacms
use matacms\controllers\module\Controller;

class Bootstrap extends \mata\base\Bootstrap {

	public function bootstrap($app) {

		Event::on(ActiveField::className(), ActiveField::EVENT_INIT_DONE, function(MessageEvent $event) {
			$event->getMessage()->attachBehavior('client', new ClientActiveFormBehavior());
		});


		Event::on(Controller::class, Controller::EVENT_MODEL_UPDATED, function(\matacms\base\MessageEvent $event) {
			$this->processSave($event->getMessage());
		});

		Event::on(Controller::class, Controller::EVENT_MODEL_CREATED, function(\matacms\base\MessageEvent $event) {
			$this->processSave($event->getMessage());
		});

	}

	private function processSave($model) {

		if (empty($clientId = Yii::$app->request->post(ClientItem::REQ_PARAM_CLIENT_ID)))
			return;

		$documentId = $model->getDocumentId();

		ClientItem::deleteAll([
			"DocumentId" => $documentId
			]);

		$clientItem = new ClientItem();
		$clientItem->attributes = [
		"CategoryId" => $clientId,
		"DocumentId" => $documentId
		];

		try {
			if ($clientItem->save() == false)
				throw new \yii\web\ServerErrorHttpException($clientItem->getTopError());

		} catch(yii\db\IntegrityException $e) {

		// Create the missing category

			$clientItem->save();

		// echo $e;
		// exit;
		}

	}
}
