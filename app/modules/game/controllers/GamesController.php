<?php

namespace app\modules\game\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GamesController implements the CRUD actions for Games model.
 */
class GamesController extends Controller
{
    // protected $createNewGameRepository;

    // public function __construct($id, $module)
    // {
    //     parent::__construct($id, $module);
    // }

    /**
     * Creates a new Games model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionStart(int $player)
    {
        if (Yii::$app->request->isPost) {
            $createNewGameRepository = Yii::$container->get('app\modules\game\repositories\CreateNewGameRepositoryInterface', [$player]);
            $game = $createNewGameRepository->create($player);
            return $this->redirect(['hit', 'id' => $game->id]);
        }

        return $this->render('start');
    }

    /**
     * Creates a new Hits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionHit($id)
    {
        if (Yii::$app->request->isPost) {
            return $this->redirect(['hit']);
        }

        return $this->render('hit', [
        ]);
    }

}
