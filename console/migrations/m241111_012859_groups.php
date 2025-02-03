<?php

use yii\db\Migration;

/**
 * Class m241111_012859_groups
 */
class m241111_012859_groups extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%groups}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%groups}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241111_012859_groups cannot be reverted.\n";

        return false;
    }
    */
}
