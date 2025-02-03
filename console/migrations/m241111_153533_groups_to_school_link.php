<?php

use yii\db\Migration;

/**
 * Class m241111_153533_groups_to_school_link
 */
class m241111_153533_groups_to_school_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('groups', 'school_id', $this->integer()->notNull()->after('id'));

        // Add foreign key for `school_id` to `user`
        $this->addForeignKey(
            'fk-user-id-group_school_id',
            '{{%groups}}',
            'school_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%groups}}', 'school_id');
        $this->dropForeignKey('fk-user-id-group_school_id', '{{%groups}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241111_153533_groups_to_school_link cannot be reverted.\n";

        return false;
    }
    */
}
