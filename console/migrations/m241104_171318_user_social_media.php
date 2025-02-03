<?php

use yii\db\Migration;

/**
 * Class m241104_171318_user_social_media
 */
class m241104_171318_user_social_media extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user',  'business_website', $this->string(500)->defaultValue(NULL)->after('status_ex'));
        $this->addColumn('user',  'social_instagram', $this->string(500)->defaultValue(NULL)->after('business_website'));
        $this->addColumn('user',  'social_facebook', $this->string(500)->defaultValue(NULL)->after('social_instagram'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241104_171318_user_social_media cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241104_171318_user_social_media cannot be reverted.\n";

        return false;
    }
    */
}
