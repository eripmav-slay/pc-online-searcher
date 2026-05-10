<!-- PcInfoクラスからDB内容を取得して、
MacStatusクラスでMACアドレスのステータスを取得
templates/pc_status.phpで出力してます
ほぼデバッグ用だから表示は参考程度に -->
<?php
require_once 'config/database.php';
require_once 'PcInfo.php';
require_once 'MacStatus.php';

// PCの情報を取得
$pcInfoManager = new PcInfo($pdo);
$pcInfo = $pcInfoManager->getAllPcInfo($_GET['classroom']);

// pcInfoのmac_addressから$macAddresssを生成
$macAddresses = array_column($pcInfo, 'mac_address');
// MACアドレスをもとに情報を取得
$statuses = MacStatus::getStatuses($macAddresses,'python scripts/network_scan.py ' . implode(' ', $macAddresses));

// 表示を行う
include 'templates/pc_status.php';
?>