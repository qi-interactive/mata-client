<?php

namespace mata\client\behaviors;

use Yii;
use mata\client\models\Client;
use mata\client\models\ClientItem;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class ClientActiveFormBehavior extends \yii\base\Behavior {

	public function client($options = []) {

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->labelOptions["label"] = "Client"; 

		$items = ArrayHelper::map(Client::find()->grouping($this->owner->model)->all(), 'Id', 'Name');
		$value = ClientItem::find()->forItem($this->owner->model)->one();

		if ($value != null)
			$options["value"] = $value->ClientId;

		$options["name"] = ClientItem::REQ_PARAM_CLIENT_ID;

		$this->owner->autocomplete($items, $options);

		$grouping = isset($options["grouping"]) ?: Client::generateGroupingFromObject($this->owner->model);

		$this->owner->parts['{input}'] .= Html::activeHiddenInput($this->owner->model, $this->owner->attribute, [
			"name" => ClientItem::REQ_PARAM_CLIENT_GROUPING,
			"value" => $grouping
			]);

		return $this->owner;

	}

}