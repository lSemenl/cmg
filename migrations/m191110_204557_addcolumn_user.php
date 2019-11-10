<?php

use yii\db\Migration;

/**
 * Class m191110_204557_addcolumn_user
 */
class m191110_204557_addcolumn_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'is_admin', 'boolean');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'is_admin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191110_204557_addcolumn_user cannot be reverted.\n";

        return false;
    }
    */
}
