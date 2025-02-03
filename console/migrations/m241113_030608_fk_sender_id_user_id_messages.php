<?php

use yii\db\Migration;

/**
 * Class m241113_030608_fk_sender_id_user_id_messages
 */
class m241113_030608_fk_sender_id_user_id_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add the foreign key constraint
        $this->addForeignKey(
            'fk-messages-sender_id',  // Name of the foreign key
            'messages',               // Table that contains the foreign key
            'sender_id',              // Column in `messages` table that is the foreign key
            'user',                   // Related table
            'id',                     // Column in `user` table that `sender_id` references
            'CASCADE',                // On delete
            'CASCADE'                 // On update
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop the foreign key constraint if rolling back
        $this->dropForeignKey(
            'fk-messages-sender_id',
            'messages'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241113_030608_fk_sender_id_user_id_messages cannot be reverted.\n";

        return false;
    }
    */
}
