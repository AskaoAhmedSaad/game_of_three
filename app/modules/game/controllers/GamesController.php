<?php

namespace app\modules\game\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Exception;

/**
 * GamesController implements the CRUD actions for Games model.
 */
class GamesController extends Controller
{
    /**
     * Creates a new Games model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionStart(int $player)
    {
        $msg = '';
        $getGameRepository = Yii::$container->get('app\modules\game\repositories\GetGameRepositoryInterface');
        $lastGame = $getGameRepository->getLastGame();
        if ($lastGame && $lastGame->IsActive)
            return $this->redirect(['hit', 'player' => $player, 'id' => $lastGame->id]);
        if (Yii::$app->request->isPost) {
            $createNewGameRepository = Yii::$container->get('app\modules\game\repositories\CreateNewGameRepositoryInterface', [$player]);
            $game = $createNewGameRepository->create($player);
            return $this->redirect(['hit', 'player' => $player, 'id' => $game->id]);
        }

        return $this->render('start', ['msg' => $msg]);
    }

    /**
     * Creates a new Hits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionHit(int $player, int $id)
    {
        $value = 0;
        $msg = 'watting for your hit';
        $allowNewGame = false;
        $getHitsRepository = Yii::$container->get('app\modules\game\repositories\GetHitsRepositoryInterface', [$player, $id]);
        $lastGameHit = $getHitsRepository->getLastGameHit();
        if (!$lastGameHit){
            $msg = 'something wrong happen';
            return $this->render('hit', ['msg' => $msg, 'value' => $value, 'allowNewGame' => $allowNewGame]);
        }
        $value = $lastGameHit->value;
        
        if (Yii::$app->request->isPost) {
            if (!$lastGameHit->canCreateNewHit()) {
                $msg =  "can't add more hits play a new game";
                $value = $lastGameHit->value;
            } else {
                if ($lastGameHit->isTheSamePayer($player)) {
                    $value = $lastGameHit->value;
                    $msg =  "can't make new it wait for the other player hit";
                } else {
                    $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $id]);
                    $newGameHit = $this->createHitsRepository->createHit($lastGameHit->value);
                    $value = $newGameHit->value;
                    $msg = 'wait until the other player hit';
                }
            }
        }

        return $this->render('hit', ['player' => $player, 'id' =>  $id, 'msg' => $msg, 'value' => $value, 'allowNewGame' => $allowNewGame]);
    }

}
