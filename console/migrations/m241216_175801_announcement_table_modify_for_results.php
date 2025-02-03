<?php

use yii\db\Migration;

/**
 * Class m241216_175801_announcement_table_modify_for_results
 */
class m241216_175801_announcement_table_modify_for_results extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('announcement', 'type', "ENUM('announcement', 'event', 'result') DEFAULT 'announcement'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241216_175801_announcement_table_modify_for_results cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241216_175801_announcement_table_modify_for_results cannot be reverted.\n";

        return false;
    }
    */
}
