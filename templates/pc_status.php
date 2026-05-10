<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCの使用状況</title>
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/edit_button.js"></script>

<header class="header">
    <div class="logo">
        <img src="pictures/logo.png" alt="サイトロゴ">
    </div>
    教室の利用状況
</header>
<div class="edit">
    <button id="editModeButton">編集</button>
    <button id="saveChangesButton" style="display: none;">確定</button>
</div>
<div>
    <table class="status-table">
        <thead>
            <tr>
                <th>教室</th>
                <th>PC番号</th>
                <th>ステータス</th>
                <th>コメント</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // デバッグ用のため一時コメントアウト
            // $totalCount = 0;
            // foreach ($statuses as $entry) {
            //     $totalCount += $entry['count'];
            // }
            // echo "Total count: " . $totalCount; 
        ?>
        <?php foreach ($pcInfo as $index => $pc): ?>
            <?php
                $status = htmlspecialchars($statuses[$index]['status'], ENT_QUOTES, 'UTF-8');
                $mac_address = htmlspecialchars($pc['mac_address'], ENT_QUOTES, 'UTF-8');
                $comment = htmlspecialchars($pc['comment'], ENT_QUOTES, 'UTF-8');
                $rowClass = ($status === '使用中') ? 'using' : 'notuse';
                if (strpos($pc['comment'], '使用不可') !== false) {
                    $rowClass = 'disable';
                }
            ?>
            <tr class="<?php echo $rowClass; ?>">
                <td><?php echo htmlspecialchars($pc['classroom'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pc['number'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo $status; ?></td>
                <td class="editable" data-id="<?php echo $pc['number']; ?>" contenteditable="false">
                    <?php echo $comment; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<p class="back-button"><a href="index/index.php">戻る</a></p>


<footer>
    <p><small>&copy; oca2024 制作展</small></p>
</footer>

</body>
</html>
