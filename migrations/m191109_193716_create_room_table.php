<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room}}`.
 */
class m191109_193716_create_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'capacity' => $this->integer(11)->notNull(),
            'isProjector' => $this->boolean()->notNull(),
            'isMarkerBoard' => $this->boolean()->notNull(),
            'isConferenceCall' => $this->boolean()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room}}');
    }
}
