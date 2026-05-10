<!-- PcInfo.php -->
<!-- DBから情報を抜くだけのクラス -->
<?php
class PcInfo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function getAllPcInfo($classroom) {
        
        $sql = "SELECT `classroom`, `number`, `mac-address` , `comment` FROM `mac-address` WHERE `classroom` = :classroom";
        // SQLを準備
        $stmt = $this->pdo->prepare($sql);

        // プレースホルダにパラメータをバインド
        $stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR);

        // クエリを実行
        $stmt->execute();
        
        $pcInfo = [];
        while ($row = $stmt->fetch()) {
            $pcInfo[] = [
                'classroom' => $row['classroom'],
                'number' => $row['number'],
                'mac_address' => $row['mac-address'],
                'comment' => $row['comment']
            ];
        }
        
        return $pcInfo;
    }
}
?>
