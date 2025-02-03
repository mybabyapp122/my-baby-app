<?php

use yii\db\Migration;

/**
 * Class m241016_153445_init
 */
class m241016_153445_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/mybaby_16-10-2024.sql');
        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241016_153445_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241016_153445_init cannot be reverted.\n";

        return false;
    }
    */
}
