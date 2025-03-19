<?php

use yii\db\Migration;

/**
 * Class m250312_173602_create_tabel_data_skrinning
 */
class m250312_173602_create_tabel_data_skrinning extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb(); // Ambil koneksi database
        $transaction = $db->beginTransaction(); // Mulai transaksi

        try {
            $this->createTable(
                'data_skrinning',
                [
                    'id' => $this->PrimaryKey(),
                    'pendaftaran_id' => $this->integer()->notNull(),
                    'pegawai_id' => $this->integer()->notNull(), //role = perawat
                    'tinggi' => $this->integer()->notNull(),
                    'berat' => $this->integer()->notNull(),
                    'tekanan_darah' => $this->string(100)->notNull(),
                    'suhu' => $this->decimal(4, 2)->notNull(),
                    'denyut_jantung' => $this->integer()->null(),
                    'saturasi_oksigen' => $this->integer()->null(),
                    'catatan' => $this->text()->null(), //untuk status (waiting, called, canceled)
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_data_skrinning_dan_pendaftaran',
                '{{%data_skrinning}}',
                ['pendaftaran_id'],
                '{{%data_pendaftaran_pasien}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            // FK untuk perawat
            $this->addForeignKey(
                'relasi_data_skrinning_perawat',
                '{{%data_skrinning}}',
                ['pegawai_id'],
                '{{%data_pegawai}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_creted_by_data_skrinning',
                '{{%data_skrinning}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_skrinning',
                '{{%data_skrinning}}',
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
        echo "m250312_173602_create_tabel_data_skrinning cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_173602_create_tabel_data_skrinning cannot be reverted.\n";

        return false;
    }
    */
}
