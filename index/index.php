<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secret-room</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

<header class="header">
    <div class="logo">
        <img src="../pictures/logo.png" alt="サイトロゴ">
    </div>
    <p>教室の利用状況</p>
</header>

<?php

require_once '../config/database.php';
require_once '../MacStatus.php';
require_once '../PcInfo.php';

?>
<!-- これを使用するかページで自動更新するか -->
<!-- <div class="info">
    <p>利用する前にこちらのボタンを押して情報を更新してください。</p>
    <p>処理には少し時間がかかることがあります。</p> -->

    <!-- ----------ボタン-------------------------------------------------->
    <!-- フォーム作成 -->
    <!-- <form method="POST" class="update-form">
        <button type="submit" name="first_time_button" class="update-button">ページ更新</button>
    </form>
</div> -->
<?php
// ボタンがクリックされたときに getStatuses を実行
// if (isset($_POST['first_time_button'])) {
//     getStatuses();
// }

// ----------arptable更新----------
function getStatuses() {
    $command = 'python ../scripts/arp_table.py';
    $output = shell_exec($command);

    global $pdo;  // グローバルスコープの $pdo を使用

    // 現在のページにリダイレクトする
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
// ----------arptable更新----------


// ----------教室のリスト----------
// SQLクエリを準備
$sql = "SELECT DISTINCT `classroom` FROM `mac-address`";

// クエリを実行
$stmt = $pdo->query($sql);

// 結果を配列に格納
$classrooms = [];  // 空の配列を初期化
while ($row = $stmt->fetch()) {
    // `classroom`の重複しない値を配列に格納
    $classrooms[] = $row['classroom'];
}
// ----------教室のリスト----------
$usageData = [];
foreach ($classrooms as $classroom) {
    $sql = "SELECT MAX(number) AS max_number FROM `mac-address` WHERE classroom = :classroom;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['classroom' => $classroom]);
    $usageData[$classroom] = $stmt->fetchColumn();
}
?>

<main class="main-content">
    <?php
    foreach ($usageData as $classroom => $maxNumber):
    ?>
        <?php 
        $pcInfoManager = new PcInfo($pdo);
        $pcInfo = $pcInfoManager->getAllPcInfo($classroom);

        // pcInfoのmac_addressから$macAddresssを生成
        $macAddresses = array_column($pcInfo, 'mac_address');
        // MACアドレスをもとに情報を取得
        $statuses = MacStatus::getStatuses($macAddresses,'python ../scripts/network_scan.py ' . implode(' ', $macAddresses));

        $count = $statuses;
        $totalCount = 0;
        foreach ($statuses as $entry) {
            $totalCount += $entry['count'];
        };
        ?>
        <a href="../room_status.php?classroom=<?= urlencode((string)$classroom) ?>" class="btn">
            <p class="classroom-name"><?= htmlspecialchars((string)$classroom) ?></p>
            <p class="pc-status"><?= htmlspecialchars((string)$totalCount) ?>/<?= htmlspecialchars((string)$maxNumber) ?>のPCが使用中</p>

        </a>

    <?php endforeach; ?>

</main>

<footer class="footer-fix">
    <p><small>&copy; oca2024 制作展</small></p>
</footer>

</body>
</html>
