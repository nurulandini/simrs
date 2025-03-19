<?php

use yii\helpers\Html;


if (!function_exists('formatJam')) {
    function formatJam($jam)
    {
        return date("H:i", strtotime($jam)); // Format 24 jam
    }
}

$hariList = [
    1 => "Senin",
    2 => "Selasa",
    3 => "Rabu",
    4 => "Kamis",
    5 => "Jumat",
    6 => "Sabtu",
    7 => "Minggu",
];

$shiftList = [
    1 => "Pagi",
    0 => "Sore",
];

?>

<p>Detail Jadwal Pegawai</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Hari</th>
            <th>Shift</th>
            <th>Jam Mulai</th>
            <th>Jam Akhir</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model['jadwal'] as $jadwal): ?>
            <tr>
                <td><?= $hariList[$jadwal['hari']] ?></td>
                <td><?= $shiftList[$jadwal['shift']] ?></td>
                <td><?= Yii::$app->formatter->asTime($jadwal['jam_mulai'], 'HH:mm') ?></td>
                <td><?= Yii::$app->formatter->asTime($jadwal['jam_akhir'], 'HH:mm') ?></td>
                <td>
                    <?= Html::a(
                        '<i class="fa fa-eye"></i>',
                        ['view', 'id' => $jadwal['id']],
                        ['role' => 'modal-remote', 'title' => 'Lihat Detail', 'class' => 'btn btn-sm btn-info']
                    ) ?>

                    <?= Html::a(
                        '<i class="fa fa-pencil-alt"></i>',
                        ['update', 'id' => $jadwal['id']],
                        ['role' => 'modal-remote', 'title' => 'Edit Jadwal', 'class' => 'btn btn-sm btn-warning']
                    ) ?>

                    <?= Html::a(
                        '<i class="fa fa-trash"></i>',
                        ['delete', 'id' => $jadwal['id']],
                        [
                            'role' => 'modal-remote',
                            'title' => 'Hapus Jadwal',
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => false,
                            'data-method' => false,
                            'data-request-method' => 'post',
                            'data-confirm-title' => 'Hapus Data',
                            'data-confirm-message' => 'Apakah Anda yakin ingin menghapus jadwal ini?'
                        ]
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>