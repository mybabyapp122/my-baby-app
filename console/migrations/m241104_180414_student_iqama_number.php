<?php

use yii\db\Migration;

/**
 * Class m241104_180414_student_iqama_number
 */
class m241104_180414_student_iqama_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student',  'id_number', $this->integer(11)->defaultValue(NULL)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241104_180414_student_iqama_number cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241104_180414_student_iqama_number cannot be reverted.\n";

        return false;
    }
    */
}
