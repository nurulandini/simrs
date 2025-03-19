<?php

use yii\db\Migration;

/**
 * Class m250312_165158_create_tabel_data_jadwal_pegawai
 */
class m250312_165158_create_tabel_data_jadwal_pegawai extends Migration
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
                'data_jadwal_pegawai',
                [
                    'id' => $this->PrimaryKey(),
                    'pegawai_id' => $this->integer()->notNull(),
                    'hari_kerja' => $this->tinyInteger(1)->notNull(), // jadwal hari
                    'shift' => $this->tinyInteger(1)->notNull(), // pagi atau sore
                    'mulai' => $this->time()->notNull(),
                    'akhir' => $this->time()->notNull(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_data_jadwal_pegawai',
                '{{%data_jadwal_pegawai}}',
                ['pegawai_id'],
                '{{%data_pegawai}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_creted_by_data_jadwal_pegawai',
                '{{%data_jadwal_pegawai}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_jadwal_pegawai',
                '{{%data_jadwal_pegawai}}',
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
        echo "m250312_165158_create_tabel_data_jadwal_pegawai cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_165158_create_tabel_data_jadwal_pegawai cannot be reverted.\n";

        return false;
    }
    */
}
