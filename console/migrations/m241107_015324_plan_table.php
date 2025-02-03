<?php

use yii\db\Migration;

/**
 * Class m241107_015324_plan_table
 */
class m241107_015324_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plan}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->defaultValue(null),
            'name_ar' => $this->string()->defaultValue(null),
            'description' => $this->string()->defaultValue(null),
            'description_ar' => $this->string()->defaultValue(null),
            'sub_users' => $this->integer()->defaultValue(null),
            'subscription_period' => $this->integer()->defaultValue(null),
            'price' => $this->decimal(19, 2)->defaultValue(0.00),
            'highlighted' => $this->integer()->defaultValue(0),
            'upgrade_to' => $this->string()->defaultValue(null),
            'status' => $this->smallInteger()->defaultValue(1),
            'status_ex' => $this->string()->defaultValue(null),
            'create_time' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241107_015324_plan_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241107_015324_plan_table cannot be reverted.\n";

        return false;
    }
    */
}
