<?php

use yii\db\Migration;

/**
 * Class m241107_173229_sale_gateway_invoice_url
 */
class m241107_173229_sale_gateway_invoice_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale}}', 'gateway_invoice_id', $this->string(500)->defaultValue(NULL)->after('order_date'));
        $this->addColumn('{{%sale}}', 'gateway_invoice_url', $this->string(500)->defaultValue(NULL)->after('gateway_invoice_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241107_173229_sale_gateway_invoice_url cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241107_173229_sale_gateway_invoice_url cannot be reverted.\n";

        return false;
    }
    */
}
