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
     *  get the last game row 
     *  return app\modules\game\models\Hits object 
     **/
    public function createHit($isFirstHit = false)
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
}