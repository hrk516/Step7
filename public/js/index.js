function getSearch() {
    let keyword = $('textarea[name="keyword"]').val();
    let company_id = $('select[name="company_id"]').val();
    $.ajax({
        url: "/step7/public/search",
        type: "GET",
        data: { keyword, company_id },
        success: function (response) {
            console.log(response);
            console.log("成功したよお疲れ");
        },
    });
    return { keyword, company_id };
}

// HTMLが読み込まれてから実行させる
$(document).ready(function () {
    // ボタンを押下した時の通常の処理を妨げる
    $('input[type="submit"]').click(function (event) {
        event.preventDefault();
        let search = getSearch();
        console.log("検索結果：", search);
    });
});
