<?php

use yii\db\Migration;

/**
 * Class m250312_075547_create_tabel_wilayah_kabupaten_kota
 */
class m250312_075547_create_tabel_wilayah_kabupaten_kota extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb(); // Ambil koneksi database
        $transaction = $db->beginTransaction(); // Mulai transaksi

        try {

            $this->createTable('wilayah_kabupaten_kota', [
                'id' => $this->PrimaryKey(),
                'provinsi_id' => $this->integer()->notNull(),
                'kd_kabupaten_kota' => $this->tinyInteger(4)->notNull(),
                'kabupaten_kota' => $this->string(255)->null(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
                'created_by' => $this->integer()->null(),
                'updated_by' => $this->integer()->null(),
            ]);

            $this->addForeignKey(
                'wilayah_kabupaten_kota_ibfk_1',
                '{{%wilayah_kabupaten_kota}}',
                ['provinsi_id'],
                '{{%wilayah_provinsi}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_created_by_wilayah_kabupaten_kota',
                '{{%wilayah_kabupaten_kota}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_wilayah_kabupaten_kota',
                '{{%wilayah_kabupaten_kota}}',
                ['updated_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack(); // Batalkan perubahan jika ada error
            throw $e; // Lempar error agar Yii2 menampilkan pesan kesalahan
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250312_075547_create_tabel_wilayah_kabupaten_kota cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_075547_create_tabel_wilayah_kabupaten_kota cannot be reverted.\n";

        return false;
    }
    */
}
