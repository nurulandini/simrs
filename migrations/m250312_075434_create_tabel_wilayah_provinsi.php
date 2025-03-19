<?php

use yii\db\Migration;

/**
 * Class m250312_075434_create_tabel_wilayah_provinsi
 */
class m250312_075434_create_tabel_wilayah_provinsi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = $this->getDb(); // Ambil koneksi database
        $transaction = $db->beginTransaction(); // Mulai transaksi

        try {
            $this->createTable('wilayah_provinsi', [
                'id' => $this->PrimaryKey(),
                'kd_provinsi' => $this->tinyInteger(4)->notNull(),
                'provinsi' => $this->string(200),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
                'created_by' => $this->integer()->null(),
                'updated_by' => $this->integer()->null(),
            ]);
    
            $this->addForeignKey(
                'FK_created_by_wilayah_provinsi',
                '{{%wilayah_provinsi}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );
    
            $this->addForeignKey(
                'FK_updated_by_wilayah_provinsi',
                '{{%wilayah_provinsi}}',
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
        echo "m250312_075434_create_tabel_wilayah_provinsi cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_075434_create_tabel_wilayah_provinsi cannot be reverted.\n";

        return false;
    }
    */
}
