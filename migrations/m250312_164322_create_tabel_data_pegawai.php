<?php

use yii\db\Migration;

/**
 * Class m250312_164322_create_tabel_data_pegawai
 */
class m250312_164322_create_tabel_data_pegawai extends Migration
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
                'data_pegawai',
                [
                    'id' => $this->PrimaryKey(),
                    'nip' => $this->integer(20)->notNull(),
                    'nama' => $this->string(100)->notNull(),
                    'jenis_kelamin' => $this->tinyInteger(1)->notNull(),
                    'tempat_lahir' => $this->string(100)->notNull(),
                    'tanggal_lahir' => $this->date()->notNull(),
                    'nomor_hp' => $this->string(20)->notNull(),
                    'alamat' => $this->text()->notNull(),
                    'kelurahan_id' => $this->integer()->notNull(),
                    'poli_id' => $this->integer()->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_kelurahan_pegawai',
                '{{%data_pegawai}}',
                ['kelurahan_id'],
                '{{%wilayah_kelurahan}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'relasi_poli_pegawai',
                '{{%data_pegawai}}',
                ['poli_id'],
                '{{%data_poli}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_creted_by_data_pegawai',
                '{{%data_pegawai}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_pegawai',
                '{{%data_pegawai}}',
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
        echo "m250312_164322_create_tabel_data_pegawai cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_164322_create_tabel_data_pegawai cannot be reverted.\n";

        return false;
    }
    */
}
