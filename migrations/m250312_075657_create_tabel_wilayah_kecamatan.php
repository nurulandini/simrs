<?php

use yii\db\Migration;

/**
 * Class m250312_075657_create_tabel_wilayah_kecamatan
 */
class m250312_075657_create_tabel_wilayah_kecamatan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('wilayah_kecamatan', [
            'id' => $this->PrimaryKey(),
            'kabupaten_kota_id' => $this->integer()->notNull(),
            'kd_kecamatan' => $this->tinyInteger(4)->notNull(),
            'kecamatan' => $this->string(255)->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'wilayah_kecamatan_ibfk_1',
            '{{%wilayah_kecamatan}}',
            ['kabupaten_kota_id'],
            '{{%wilayah_kabupaten_kota}}',
            ['id'],
            'CASCADE',
            'CASCADE'

        );

        $this->addForeignKey(
            'FK_created_by_wilayah_kecamatan',
            '{{%wilayah_kecamatan}}',
            ['created_by'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_updated_by_wilayah_kecamatan',
            '{{%wilayah_kecamatan}}',
            ['updated_by'],
            '{{%user}}',
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
        echo "m250312_075657_create_tabel_wilayah_kecamatan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_075657_create_tabel_wilayah_kecamatan cannot be reverted.\n";

        return false;
    }
    */
}
