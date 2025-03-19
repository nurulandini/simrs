<?php

use yii\db\Migration;

/**
 * Class m250312_195637_create_tabel_transaksi
 */
class m250312_195637_create_tabel_transaksi extends Migration
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
                'transaksi',
                [
                    'id' => $this->PrimaryKey(),
                    'rekam_medis_id' => $this->integer()->null(),
                    'biaya_layanan' => $this->integer()->null(),
                    'biaya_obat' => $this->integer()->null(),
                    'total_harga' => $this->integer()->null(),
                    'status_pembayaran' => $this->tinyInteger(1)->null(), //pending, paid, canceled
                    'metode_pembayaran' => $this->tinyInteger(1)->null(), // cash transfer asuransi
                    'asuransi' => $this->tinyInteger(1)->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'relasi_transaksi_dan_rekam_medis_id',
                '{{%transaksi}}',
                ['rekam_medis_id'],
                '{{%data_rekam_medis}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );



            $this->addForeignKey(
                'FK_creted_by_transaksi',
                '{{%transaksi}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_transaksi',
                '{{%transaksi}}',
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
        echo "m250312_195637_create_tabel_transaksi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_195637_create_tabel_transaksi cannot be reverted.\n";

        return false;
    }
    */
}
