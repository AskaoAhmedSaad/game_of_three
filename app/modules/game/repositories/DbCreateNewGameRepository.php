<?php
/**
* repository for creating new game
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Games;
use app\modules\game\models\Hits;
use yii\web\NotAcceptableHttpException;

class DbCreateNewGameRepository implements CreateNewGameRepositoryInterface
{
    protected $player;
    protected $getGameRepository;

    public function __construct(int $player)
    {
        $this->player = $player;

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
            $dbCreateHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$this->player, $game->id]);
            $hit = $dbCreateHitsRepository->createFirstHit(true);
            $transaction->commit();

            return $game;
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            throw new Exception('something error happens!', 1);
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
}