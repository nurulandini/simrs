<?php

use yii\db\Migration;

/**
 * Class m250317_172047_update_tabel_data_skrinning
 */
class m250317_172047_update_tabel_data_skrinning extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('data_skrinning', 'tinggi', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250317_172047_update_tabel_data_skrinning cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250317_172047_update_tabel_data_skrinning cannot be reverted.\n";

        return false;
    }
    */
}
