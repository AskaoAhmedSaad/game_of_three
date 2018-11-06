<?php

namespace app\modules\game;

use Yii;

/**
 * game module definition class
 */
class Module extends yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\game\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // initialize the module with the configuration loaded from config.php

    }
}
