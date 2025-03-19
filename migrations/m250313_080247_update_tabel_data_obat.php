<?php

use yii\db\Migration;

/**
 * Class m250313_080247_update_tabel_data_obat
 */
class m250313_080247_update_tabel_data_obat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'relasi_satuan_obat',
            '{{%data_obat}}',
            ['satuan_id'],
            '{{%data_satuan}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250313_080247_update_tabel_data_obat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_080247_update_tabel_data_obat cannot be reverted.\n";

        return false;
    }
    */
}
