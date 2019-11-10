<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reserve}}`.
 */
class m191109_194234_create_reserve_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reserve}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer(11)->notNull(),
            'meeting_date' => $this->date()->notNull(),
            'start_date' => $this->time()->notNull(),
            'end_date' => $this->time()->notNull(),
            'owner_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('{{%reserve_room}}', '{{%reserve}}', 'room_id', '{{%room}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('{{%reserve_owner}}', '{{%reserve}}', 'owner_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reserve}}');
    }
}
