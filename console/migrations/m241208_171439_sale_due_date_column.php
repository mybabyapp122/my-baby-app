<?php

use yii\db\Migration;

/**
 * Class m241208_171439_sale_due_date_column
 */
class m241208_171439_sale_due_date_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sale', 'due_date', $this->dateTime()->defaultValue(null)->after('order_date'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241208_171439_sale_due_date_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241208_171439_sale_due_date_column cannot be reverted.\n";

        return false;
    }
    */
}
