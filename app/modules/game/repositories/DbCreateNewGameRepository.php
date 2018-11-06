<?php
/**
* repository for creating new game
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Games;
use app\modules\game\models\Hits;
use Exception;

class DbCreateNewGameRepository implements CreateNewGameRepositoryInterface
{
    protected $player;

    public function __construct(int $player)
    {
        $this->player = $player;
        // $this->successResponse = Yii::$container->get('SuccessResponse');
        // $this->errorResponse = Yii::$container->get('ErrorResponse');
    }
    /**
     *  creating new group 
     * @param Array $params creating params
     **/
    public function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $game = $this->createNewGame();
            $hit = $this->createTheFirstHit($game->id);
            $transaction->commit();

            return $game;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            throw new Exception($e->getMessage(), 1);
        } 
    }

    protected function createNewGame()
    {
        $model = new Games;
        if (!$model->save()) {
            throw new Exception('error in creating new ' . get_class($model) . ' : ' . current($model->getFirstErrors()), 1);
        }

        return $model;
    }

    protected function createTheFirstHit(int $gameId)
    {
        if (!$this->player)
            throw new Exception("no player passed!", 1);
        $model = new Hits;
        $model->value = rand(10, 999);
        $model->player = $this->player;
        $model->game_id = $gameId;
        if (!$model->save()) {
            throw new Exception('error in creating new ' . get_class($model) . ' : ' . current($model->getFirstErrors()), 1);
        }

        return $model;
    }
}