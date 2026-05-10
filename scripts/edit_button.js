
$(document).ready(function() {
    let editMode = false;

    // 編集モードの切り替え
    $("#editModeButton").click(function() {
        editMode = !editMode;
        $(".editable").attr("contenteditable", editMode);
        $("#saveChangesButton").toggle(editMode);
        $(this).text(editMode ? "キャンセル" : "編集");

        if (!editMode) {
            // キャンセル時に元の値に戻す
            $(".editable").each(function() {
                $(this).text($(this).data("original"));
            });
        } else {
            // 編集前の値を保存（ただし、確定後に更新する）
            $(".editable").each(function() {
                if (!$(this).data("original")) {
                    $(this).data("original", $(this).text());
                }
            });
        }
    });

    // 確定ボタン（変更を保存）
    $("#saveChangesButton").click(function() {
        let updates = [];
        $(".editable").each(function() {
            let id = $(this).data("id");
            let comment = $(this).text().trim();
            let original = $(this).data("original");

            if (comment !== original) { // 変更されたものだけ送信
                updates.push({ id: id, comment: comment });
            }
        });

        if (updates.length === 0) {
            alert("変更はありません");
            return;
        }

        console.log("送信データ:", updates);

        $.ajax({
            url: "/school-pcs/index/update_comment.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ updates: updates }),
            dataType: "json"
        }).done(function(response) {
            console.log("レスポンス:", response);
            if (response.status === "success") {
                alert("変更を保存しました");

                // 変更を確定したら、最新の値を新しい「original」に設定
                $(".editable").each(function() {
                    $(this).data("original", $(this).text());
                });

                // 編集モードを解除
                editMode = false;
                $(".editable").attr("contenteditable", false);
                $("#editModeButton").text("編集");
                $("#saveChangesButton").hide();
            } else {
                alert("エラー: " + response.message);
            }
        }).fail(function(xhr, status, error) {
            console.error("通信エラー:", xhr.responseText);
            alert("通信エラーが発生しました\n" + xhr.responseText);
        });
    });
});