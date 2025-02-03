<?php

use yii\db\Migration;

/**
 * Class m241119_122308_grade_add_columns
 */
class m241119_122308_grade_add_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('grade', 'per_hour_rate', $this->integer()->defaultValue(1)->comment('The default value for per hour rate will be taken from here'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241119_122308_grade_add_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241119_122308_grade_add_columns cannot be reverted.\n";

        return false;
    }
    */
}
