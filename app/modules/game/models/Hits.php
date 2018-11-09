<?php

namespace app\modules\game\models;

use Yii;

/**
 * This is the model class for table "hits".
 *
 * @property int $id
 * @property int $value
 * @property int $player
 * @property int $game_id
 *
 * @property Games $game
 */
class Hits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'player'], 'required'],
            [['value', 'game_id'], 'integer'],
            [['player'], 'integer'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::className(), 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'player' => 'Player',
            'game_id' => 'Game ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::className(), ['id' => 'game_id']);
    }

    public function canCreateNewHit()
    {
        return $this->value > 1;
    }

    public function isTheSamePayer($player)
    {
        return $this->player == $player;
    }

    public function isWinning($player)
    {
        if (!$this->canCreateNewHit() && $this->isTheSamePayer($player))
            return true;
        return false;
    }

}
