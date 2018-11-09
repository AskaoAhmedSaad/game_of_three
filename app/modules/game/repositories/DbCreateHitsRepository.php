<?php
/**
* repository for creating hits
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Hits;
use app\modules\game\models\Games;
use Exception;

class DbCreateHitsRepository implements CreateHitsRepositoryInterface
{
    protected $player;
    protected $gameId;
    protected $model;

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
        $this->model = new Hits;
        $this->model->value = rand(10, 20);
        $this->model->player = $this->player;
        $this->model->game_id = $this->gameId;
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }

        return $this->model;
    }

    /**
     *  create new hit for a game
     *  @return app\modules\game\models\Hits object 
     **/
    public function createHit($lastHitValue)
    {
        $this->model = new Hits;
        $this->model->value = $this->getTheNextHitValue($lastHitValue);
        $this->model->player = $this->player;
        $this->model->game_id = $this->gameId;
        if (!$this->model->save()) {
            throw new Exception('error in creating new ' . get_class($this->model) . ' : ' . current($this->model->getFirstErrors()), 1);
        }
        if ($this->model->isWinning($this->player)){
            $this->inActiveTheGame();
        }

        return $this->model;
    }

    /**
     *  create new hit for a game
     *  @return int $lastHitValue
     **/
    protected function getTheNextHitValue($lastHitValue)
    {
        if ($lastHitValue % 3 == 0) {
            return $lastHitValue / 3;
        } else if (($lastHitValue + 1) % 3 == 0) {
            return ($lastHitValue + 1) / 3;
        } else if (($lastHitValue - 1) % 3 == 0) {
            return ($lastHitValue - 1) / 3;
        }
    }

    protected function inActiveTheGame()
    {
        if (!$this->model)
            throw new Exception('error: $this->model sould be initialized', 1);
        if ($game = $this->model->game){
            $game->status = Games::INACTIVE_STATUS;
            if (!$game->save()) {
                throw new Exception('error in inactivating the game', 1);
            }
        } else {
            throw new Exception('error: $this->model sould be initialized', 1);
        }


        return false;
    }



}