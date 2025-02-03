<?php

use yii\db\Migration;

/**
 * Class m241022_154839_grade_ratio_table
 */
class m241022_154839_grade_ratio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%grade_ratio}}', [
            'id' => $this->primaryKey(),
            'grade_id' => $this->integer()->notNull(),
            'teacher_ratio' => $this->integer()->notNull()->defaultValue(1),
            'student_ratio' => $this->integer()->notNull()->defaultValue(4),
            'create_time' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_time' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Create index and add foreign key for `grade_id`
        $this->createIndex(
            'idx-grade_ratio-grade_id',
            '{{%grade_ratio}}',
            'grade_id'
        );

        $this->addForeignKey(
            'fk-grade_ratio-grade_id',
            '{{%grade_ratio}}',
            'grade_id',
            '{{%grade}}',
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
        echo "m241022_154839_grade_ratio_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241022_154839_grade_ratio_table cannot be reverted.\n";

        return false;
    }
    */
}
