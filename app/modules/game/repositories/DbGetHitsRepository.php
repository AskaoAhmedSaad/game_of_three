<?php
/**
* repository for getting hits
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Hits;
use Exception;

class DbGetHitsRepository implements GetHitsRepositoryInterface
{
    protected $gameId;

    public function __construct(int $player, int $gameId){
        $this->gameId = $gameId;
    }

    /**
     *  get the last game's hit 
     *  return app\modules\game\models\Hits object 
     **/
    public function getLastGameHit()
    {
        $query = Hits::find()->where(['game_id' => $this->gameId])->orderBy('id DESC');
        
        return $query->one();
    }
}