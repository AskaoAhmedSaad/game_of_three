<?php

return [
    'definitions' => [
      'app\modules\game\repositories\CreateNewGameRepositoryInterface' => [
          'class' =>  'app\modules\game\repositories\DbCreateNewGameRepository'
       ],
       'app\modules\game\repositories\GetGameRepositoryInterface' => [
          'class' =>  'app\modules\game\repositories\DbGetGameRepository'
       ],
       'app\modules\game\repositories\CreateHitsRepositoryInterface' => [
          'class' =>  'app\modules\game\repositories\DbCreateHitsRepository'
       ],
       'app\modules\game\repositories\GetHitsRepositoryInterface' => [
          'class' =>  'app\modules\game\repositories\DbGetHitsRepository'
       ],
    ]
];