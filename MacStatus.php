<!-- MacStatus.php -->
<!-- network_scan.pyにMACアドレスを渡して状態を確認するファイル
scripts/network_scan.pyが呼び出されてshellにて実行される -->
<?php
class MacStatus {
    public static function getStatuses($macAddresses,$path) {
        $output = shell_exec($path);
        return json_decode($output, true);
    }
}
?>
