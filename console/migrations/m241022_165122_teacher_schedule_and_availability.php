<?php

use yii\db\Migration;

/**
 * Class m241022_165122_teacher_schedule_and_availability
 */
class m241022_165122_teacher_schedule_and_availability extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('grade_teacher_schedule', [
            'id' => $this->primaryKey(),
            'grade_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer()->notNull(),
            'day_of_week' => "ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL",
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'start_date' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'end_date' => $this->dateTime()->notNull(),
        ]);

        // Create foreign key constraint for grade_id
        $this->addForeignKey(
            'fk-grade_teacher_schedule-grade_id',
            'grade_teacher_schedule',
            'grade_id',
            'grade',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Create foreign key constraint for teacher_id
        $this->addForeignKey(
            'fk-grade_teacher_schedule-teacher_id',
            'grade_teacher_schedule',
            'teacher_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // Create the student_schedule table
        $this->createTable('student_schedule', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'grade_id' => $this->integer()->notNull(),
            'day_of_week' => "ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL",
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'start_date' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'end_date' => $this->dateTime()->notNull(),
        ]);

        // Foreign key constraints for student_schedule
        $this->addForeignKey(
            'fk-student_schedule-student_id',
            'student_schedule',
            'student_id',
            'student',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-student_schedule-grade_id',
            'student_schedule',
            'grade_id',
            'grade',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241022_165122_teacher_schedule_and_availability cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241022_165122_teacher_schedule_and_availability cannot be reverted.\n";

        return false;
    }
    */
}
