<?php

use yii\db\Migration;

/**
 * Class m241224_132346_update_translation_add_ar
 */
class m241224_132346_update_translation_add_ar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('translation', 'ar', 'TEXT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241224_132346_update_translation_add_ar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241224_132346_update_translation_add_ar cannot be reverted.\n";

        return false;
    }
    */
}
