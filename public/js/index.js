let csrfToken;

// HTMLが読み込まれてから実行させる
$(document).ready(function () {
    csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    // ボタンを押下した時の通常の処理を妨げる
    $('input[type="submit"]').click(function (event) {
        event.preventDefault();
        let search = getSearch();
        console.log("検索結果：", search);
    });
});

function getSearch() {
    let keyword = $('textarea[name="keyword"]').val();
    let company_id = $('select[name="company_id"]').val();
    $.ajax({
        url: "/step7/public/search",
        type: "POST",
        data: { keyword, company_id },
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        // 成功
        .done(function (response) {
            console.log("成功", response);
            $("tbody").empty(); //結果を一度クリア
            response.products.data.forEach(function (product) {
                csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");
                //paginationを使用するときは.dataがいる
                let company_name = response.CompanyName.company_name || "不明";
                let html = `
                    <tr>
                        <td class="align-middle">${product.id}</td>
                        <td class="align-middle">
                            <img class="img" src="storage/${product.img_path}" alt="画像">
                        </td>
                        <td class="align-middle">${product.product_name}</td>
                        <td class="align-middle">¥${product.price}</td>
                        <td class="align-middle">${product.stock}</td>
                        <td class="align-middle">${company_name}</td>
                        <td class="align-middle d-flex align-items-center gap-2 form-btn">
                            
                        <form method='POST' action="/step7/public/detail/${product.id}">
                        <input type='hidden' name='_token' value="${csrfToken}">
                        <input type='hidden' name='id' value="${product.id}">
                        <button type="submit" class="btn btn-info">詳細</button>
                        </form>
                            <form method='POST' action="/step7/public/delete/${product.id}">
                                <input type='hidden' name='_token' value="${csrfToken}">
                                <input type='hidden' name='id' value="${product.id}">
                                <button type="submit" class="btn btn-danger" onclick='return confirm("削除します。よろしいですか？")'>削除</button>
                            </form>
                        </td>
                    </tr>`;
                $("tbody").append(html);
            });
        })
        // 失敗
        .fail(function (response) {
            console.log("失敗");
        })
        // 完了
        .always(function (response) {
            console.log("完了");
        });
}
