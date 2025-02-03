<?php

use yii\db\Migration;

/**
 * Class m241111_013004_messages
 */
class m241111_013004_messages extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key for group_id
        $this->addForeignKey(
            'fk-messages-group_id',
            '{{%messages}}',
            'group_id',
            '{{%groups}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-messages-group_id', '{{%messages}}');
        $this->dropTable('{{%messages}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241111_013004_messages cannot be reverted.\n";

        return false;
    }
    */
}
