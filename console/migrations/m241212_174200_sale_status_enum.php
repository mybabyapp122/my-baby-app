<?php

use yii\db\Migration;

/**
 * Class m241212_174200_sale_status_enum
 */
class m241212_174200_sale_status_enum extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('sale', 'status', "ENUM('paid', 'unpaid', 'cancelled', 'failed') DEFAULT 'unpaid'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241212_174200_sale_status_enum cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241212_174200_sale_status_enum cannot be reverted.\n";

        return false;
    }
    */
}
