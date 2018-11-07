<?php
/**
* repository for creating hits
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Hits;
use Exception;

class DbCreateHitsRepository implements CreateHitsRepositoryInterface
{
    protected $player;
    protected $gameId;

    public function __construct(int $player, int $gameId){
        $this->player = $player;
        $this->gameId = $gameId;
    }

    /**
     *  create first hit for a game
     *  @return app\modules\game\models\Hits object 
     **/
    public function createFirstHit()
    {
        $model = new Hits;
        $model->value = rand(10, 999);
        $model->player = $this->player;
        $model->game_id = $this->gameId;
        if (!$model->save()) {
            throw new Exception('error in creating new ' . get_class($model) . ' : ' . current($model->getFirstErrors()), 1);
        }

        return $model;
    }

    /**
     *  create new hit for a game
     *  @return app\modules\game\models\Hits object 
     **/
    public function createHit($lastHitValue)
    {
        $model = new Hits;
        $model->value = $this->getTheNextHitValue();
        $model->player = $this->player;
        $model->game_id = $this->gameId;
        if (!$model->save()) {
            throw new Exception('error in creating new ' . get_class($model) . ' : ' . current($model->getFirstErrors()), 1);
        }

        return $model;
    }

    /**
     *  create new hit for a game
     *  @return int $lastHitValue
     **/
    protected function getTheNextHitValue($lastHitValue)
    {
        if ($lastHitValue % 3 == 0) {
            return $lastHitValue;
        } else if (($lastHitValue + 1) % 3 == 0) {
            return $lastHitValue + 1;
        } else if (($lastHitValue - 1) % 3 == 0) {
            return $lastHitValue - 1;
        }
    }
}