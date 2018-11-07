<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hits`.
 */
class m181106_202223_create_hits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('hits', [
            'id' => 'INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'value' => 'INT(3) NOT NULL',
            'player' => 'ENUM ("1","2") NOT NULL',
            'game_id' => 'INT(5)'
        ]);
        $this->addForeignKey('game_hit_relation','hits','game_id','games','id');
    }

    /**
     * {@inheritdoc}    
     */
    public function safeDown()
    {
        $this->dropTable('hits');
    }
}
