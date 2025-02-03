<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m241107_020424_add_plan_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'plan_id', $this->integer()->notNull()->defaultValue(1));
        $this->addColumn('{{%user}}', 'plan_renewal_date', $this->dateTime()->defaultValue(null));
        $this->addColumn('{{%user}}', 'plan_expiry_date', $this->dateTime()->defaultValue(null));
        $this->addColumn('{{%user}}', 'plan_amount', $this->decimal(19, 2)->defaultValue(0.00));

        // Adding a foreign key for plan_id, referencing the id column of the plan table
        $this->createIndex(
            'idx-user-plan_id',
            '{{%user}}',
            'plan_id'
        );

        $this->addForeignKey(
            'fk-user-plan_id',
            '{{%user}}',
            'plan_id',
            '{{%plan}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
