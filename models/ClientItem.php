<?php

namespace mata\client\models;

use Yii;
use mata\client\models\Client;
use mata\behaviors\IncrementalBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%clientitem}}".
 *
 * @property integer $ClientId
 * @property string $DocumentId
 * @property integer $Order
 */
class ClientItem extends \matacms\db\ActiveRecord {

    const REQ_PARAM_CLIENT_GROUPING = "client-item-client-grouping";
    const REQ_PARAM_CLIENT_ID = "client-item-client-id";

    public function behaviors() {
        return [
            [
                'class' => IncrementalBehavior::className(),
                'findBy' => "DocumentId",
                'incrementField' => "Order"
            ]
        ];
    }

    public static function find() {
        return new ClientItemQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mata_clientitem}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ClientId', 'DocumentId', 'Order'], 'required'],
            [['ClientId', 'Order'], 'integer'],
            [['DocumentId'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ClientId' => 'Client ID',
            'DocumentId' => 'Document ID',
            'Order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['Id' => 'ClientId']);
    }
}

class ClientItemQuery extends ActiveQuery {

    public function forItem($item) {

        if (is_object($item))
            $item = $item->getDocumentId();

        $this->andWhere(['DocumentId' => $item]);
        return $this;
    }

}