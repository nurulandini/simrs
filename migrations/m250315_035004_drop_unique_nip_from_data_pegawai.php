<?php

use yii\db\Migration;

/**
 * Class m250315_035004_drop_unique_nip_from_data_pegawai
 */
class m250315_035004_drop_unique_nip_from_data_pegawai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        $this->dropIndex('nip', 'data_pegawai'); 

        $this->alterColumn('data_pegawai', 'nip', $this->string(25)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250315_035004_drop_unique_nip_from_data_pegawai cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250315_035004_drop_unique_nip_from_data_pegawai cannot be reverted.\n";

        return false;
    }
    */
}
