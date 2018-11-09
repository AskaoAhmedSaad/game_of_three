<?php
/**
* repository for getting games
*/
namespace app\modules\game\repositories;

use Yii;
use app\modules\game\models\Games;
use Exception;

class DbGetGameRepository implements GetGameRepositoryInterface
{
    /**
     *  get the last game row 
     *  @return app\modules\game\models\Games object 
     **/
    public function getLastGame()
    {
        $query = Games::find()->orderBy('id DESC');
        
        return $query->one();
    }
}