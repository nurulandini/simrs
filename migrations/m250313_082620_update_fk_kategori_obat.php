<?php

use yii\db\Migration;

/**
 * Class m250313_082620_update_fk_kategori_obat
 */
class m250313_082620_update_fk_kategori_obat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'relasi_kategori_obat',
            '{{%data_obat}}',
            ['kategori_id'],
            '{{%kategori_obat}}',
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
        echo "m250313_082620_update_fk_kategori_obat cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250313_082620_update_fk_kategori_obat cannot be reverted.\n";

        return false;
    }
    */
}
