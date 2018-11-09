<?php

namespace app\modules\game\models;

use Yii;

/**
 * This is the model class for table "games".
 *
 * @property int $id
 * @property string $status
 *
 * @property Hits[] $hits
 */
class Games extends \yii\db\ActiveRecord
{
    const ACTIVE_STATUS = 1;
    const INACTIVE_STATUS = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'games';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
        ];
    }

    public function getIsActive()
    {
        return $this->status == self::ACTIVE_STATUS;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHits()
    {
        return $this->hasMany(Hits::className(), ['game_id' => 'id']);
    }
}
