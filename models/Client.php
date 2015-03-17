<?php

namespace mata\client\models;

use Yii;
use mata\client\models\Clientitem;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $URI
 */
class Client extends \matacms\db\ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mata_client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['Name', 'URI', 'Grouping'], 'required'],
            [['Name'], 'string'],
            [['URI'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'URI' => 'Uri',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Clientitem::className(), ['ClientId' => 'Id']);
    }

    public static function generateGroupingFromObject($obj) {
        return get_class($obj);
    }
}

class ClientQuery extends ActiveQuery {
    /**
     *  Categories for various models / groups will be stored in one table. 
     * The grouping allows to differentiate between categories belonging to one, but not another.
     * For instance, ->grouping("books") or ->grouping($postModel) will return different results. 
     */ 
    public function grouping($grouping) {

        if (is_object($grouping))
            $grouping = Client::generateGroupingFromObject($grouping);

        $this->andWhere(['Grouping' => $grouping]);
        return $this;
    }

}