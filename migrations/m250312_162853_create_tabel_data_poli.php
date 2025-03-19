<?php

use yii\db\Migration;

/**
 * Class m250312_162853_create_tabel_data_poli
 */
class m250312_162853_create_tabel_data_poli extends Migration
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
                'data_poli',
                [
                    'id' => $this->PrimaryKey(),
                    'poli' => $this->string(100)->notNull(),
                    'deskripsi' => $this->text()->null(),
                    'created_at' => $this->integer()->null(),
                    'updated_at' => $this->integer()->null(),
                    'created_by' => $this->integer()->null(),
                    'updated_by' => $this->integer()->null(),
                ]
            );

            $this->addForeignKey(
                'FK_creted_by_data_poli',
                '{{%data_poli}}',
                ['created_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $this->addForeignKey(
                'FK_updated_by_data_poli',
                '{{%data_poli}}',
                ['updated_by'],
                '{{%user}}',
                ['id'],
                'CASCADE',
                'CASCADE'
            );

            $transaction->commit();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250312_162853_create_tabel_data_poli cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250312_162853_create_tabel_data_poli cannot be reverted.\n";

        return false;
    }
    */
}
