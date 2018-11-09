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
        $this->validatePlayer($player);
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
        $this->validatePlayer($player);
        $value = 0;
        $getHitsRepository = Yii::$container->get('app\modules\game\repositories\GetHitsRepositoryInterface', [$player, $id]);
        $lastGameHit = $getHitsRepository->getLastGameHit();
        if (!$lastGameHit){
            return $this->redirect(['error', 'msg' => 'something wrong happen with the game']);
        }
        $value = $lastGameHit->value;
        
        if (Yii::$app->request->isPost) {
            if ($lastGameHit->canCreateNewHit() && !$lastGameHit->isTheSamePayer($player)) {
                $createHitsRepository = Yii::$container->get('app\modules\game\repositories\CreateHitsRepositoryInterface', [$player, $id]);
                $createHitsRepository->createHit($lastGameHit->value);
                return $this->redirect(['hit', 'player' => $player, 'id' => $id]);
            }
        }

        return $this->render('hit', ['msg' => $this->getTheHitMsg($lastGameHit, $player), 'value' => $value, 'allowNewGame' => !$lastGameHit->canCreateNewHit()]);
    }

    public function actionError(String $msg)
    {
        return $this->render('error', ['msg' => $msg]);
    }

    private function getTheHitMsg($lastGameHit, int $player)
    {
        $msg = '';
            if ($lastGameHit->isTheSamePayer($player)) {
                if ($lastGameHit->canCreateNewHit()) {
                    $msg = "waitting for the other player hit";
                } else {
                    $msg = 'you win!';
                }
            } else {
                if ($lastGameHit->canCreateNewHit($player))
                    $msg = "waitting for your hit";
                else
                    $msg = "can't add more hits values became 1 - you lose";
            }

        return $msg;
    }

    private function validatePlayer(int $player)
    {
        if ($player !== 1 && $player !== 2)
            return $this->redirect(['error', 'msg' => 'wrong player number']);
    }
}
