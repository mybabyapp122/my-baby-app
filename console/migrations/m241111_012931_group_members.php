<?php

use yii\db\Migration;

/**
 * Class m241111_012931_group_members
 */
class m241111_012931_group_members extends Migration
{
    public function safeUp()
    {
        // Create the `group_members` table
        $this->createTable('{{%group_members}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'create_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key for `group_id` to `groups`
        $this->addForeignKey(
            'fk-group_members-group_id',
            '{{%group_members}}',
            'group_id',
            '{{%groups}}',
            'id',
            'CASCADE'
        );

        // Add foreign key for `user_id` to `user`
        $this->addForeignKey(
            'fk-group_members-user_id',
            '{{%group_members}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Drop foreign keys
        $this->dropForeignKey('fk-group_members-group_id', '{{%group_members}}');
        $this->dropForeignKey('fk-group_members-user_id', '{{%group_members}}');

        // Drop `group_members` table
        $this->dropTable('{{%group_members}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241111_012931_group_members cannot be reverted.\n";

        return false;
    }
    */
}
