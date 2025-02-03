<?php

use yii\db\Migration;

/**
 * Class m241119_145404_sale_status_enum_added
 */
class m241119_145404_sale_status_enum_added extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('sale', 'status', "ENUM('paid', 'unpaid', 'cancelled') DEFAULT 'unpaid'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241119_145404_sale_status_enum_added cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241119_145404_sale_status_enum_added cannot be reverted.\n";

        return false;
    }
    */
}
