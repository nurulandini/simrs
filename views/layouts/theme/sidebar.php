<?php

use yii\helpers\Html;
use mdm\admin\components\MenuHelper;

if (!empty(Yii::$app->user->identity->id)) {
    $items = MenuHelper::getAssignedMenu(Yii::$app->user->identity->id, 1);
    foreach ($items as $key => $item) {
        $label = $item['label'];
        $temp = [
            "url" => $item['url'],
            "label" => $item['label']
        ];


        switch ($label) {
            case "Dashboard":
                $temp['iconClass'] = "nav-icon fas fa-tachometer-alt";
                break;
            case "Berita Acara":
                $temp['iconClass'] = "nav-icon fas fa-folder";
                break;
            case "Data":
                $temp['iconClass'] = "nav-icon fas fa-database";
                break;
            case "Paket Pekerjaan":
                $temp['iconClass'] = "nav-icon fas fa-cubes";
                break;
            case "Forum Diskusi":
                $temp['iconClass'] = "nav-icon fas fa-comments";
                break;
            case "Riwayat Pengajuan":
                $temp['iconClass'] = "nav-icon fas fa-history";
                break;
            case "Galeri Kegiatan":
                $temp['iconClass'] = "nav-icon fas fa-newspaper";
                break;
            case "Realisasi Paket":
                $temp['iconClass'] = "nav-icon fas fa-archive";
                break;
            case "Verifikasi Akun":
                $temp['iconClass'] = "nav-icon fas fa-check-circle";
                break;
            case "RBAC":
                $temp['iconClass'] = "nav-icon fas fa-cogs";
                break;
            case "Carousel":
                $temp['iconClass'] = "nav-icon fas fa-window-restore";
                break;
            default:

                break;
        }


        if (isset($item['items']) && !empty($item['items'])) {
            $subItems = [];
            foreach ($item['items'] as $subItem) {
                $subTemp = [
                    "url" => $subItem['url'],
                    "label" => $subItem['label']
                ];


                switch ($subItem['label']) {
                    case "Pengesahan Paket":
                        $subTemp['iconClass'] = "nav-icon fas fa-file";
                        break;
                    case "Pengambilan Paket":
                        $subTemp['iconClass'] = "nav-icon fas fa-file";
                        break;
                    case "Tahun":
                        $subTemp['iconClass'] = "nav-icon fas fa-calendar";
                        break;
                    case "UMKM":
                        $subTemp['iconClass'] = "nav-icon fas fa-users";
                        break;
                    case "Sub Unit":
                        $subTemp['iconClass'] = "nav-icon fas fa-university";
                        break;
                    case "Bidang CSR":
                        $subTemp['iconClass'] = "nav-icon fas fa-th";
                        break;
                    case "LSM":
                        $subTemp['iconClass'] = "nav-icon fas fa-users";
                        break;
                    case "Perusahaan":
                        $subTemp['iconClass'] = "nav-icon fas fa-building";
                        break;
                    case "Satuan":
                        $subTemp['iconClass'] = "nav-icon fas fa-tags";
                        break;
                    case "Jenis CSR":
                        $subTemp['iconClass'] = "nav-icon fas fa-th-large";
                        break;

                    default:

                        break;
                }

                $subItems[] = $subTemp;
            }
            $temp['items'] = $subItems;
        }

        $items[$key] = $temp;
    }
} else {
    $items = [];
}
?>
<aside class="main-sidebar sidebar-warning elevation-4" style="background-color: white;">

    <span class="brand-text text-center">
        <h3 style="font-size: 50px; color:#00A8D9;"><b>SIMRS</b></h3>
    </span>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?= Html::img('@web/img/23.png', ['alt' => 'User Image']) ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= \Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= \hail812\adminlte\widgets\Menu::widget([
                'options' => ['class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent', 'data-widget' => 'treeview'],
                'items' => $items
            ]);
            ?>
            <br>
            <br>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>