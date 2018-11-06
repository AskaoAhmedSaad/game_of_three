<?php

use yii\db\Migration;

/**
 * Handles the creation of table `games`.
 */
class m181106_201837_create_games_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('games', [
            'id' => 'INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'status' => 'ENUM("0","1") DEFAULT "1"',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('games');
    }
}
