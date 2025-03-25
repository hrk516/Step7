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
    // 削除処理
    $(document).on("click", ".btn-danger", function (event) {
        event.preventDefault();
        let deleteData = $(this).data("product_id");
        console.log("削除対象のID:", deleteData);
        productDelete(deleteData);
    });
    // $(".btn-danger").click(function (event) {
    //     event.preventDefault();
    //     let deleteData = $(this).data("product_id");
    //     // console.log(deleteData);
    //     productDelete(deleteData);
    // });
});

function getSearch() {
    // let keyword = $('textarea[name="keyword"]').val();
    // let company_id = $('select[name="company_id"]').val();
    let minPrice = $('input[name="minPrice"]').val();
    let maxPrice = $('input[name="maxPrice"]').val();
    let minStock = $('input[name="minStock"]').val();
    let maxStock = $('input[name="maxStock"]').val();

    $.ajax({
        url: "/step7/public/search",
        type: "POST",
        data: { minPrice, maxPrice, minStock, maxStock },
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
                // 該当する会社情報をresponse.companiesから取得
                let company = response.companies.find(function (company) {
                    return company.id === product.company_id; // product.company_idと一致する会社情報を探す
                });

                // 該当する会社が見つからない場合、"不明" を表示
                let company_name = company ? company.company_name : "不明";
                let html = `
                    <tr id="product-${product.id}">
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
                        <button type="button" class="btn btn-danger" data-product_id="${product.id}">削除</button>
                        </td>
                    </tr>`;
                $("tbody").append(html);
            });
        })
        // 失敗
        .fail(function (response) {
            console.log("失敗");
            console.log(response);
        })
        // 完了
        .always(function (response) {
            console.log("完了");
        });
}

function productDelete(deleteData) {
    // この書き方だと1行目のidしか取ってこれない
    // let deleteData = $('input[name="deleteData"]').val();
    // data-product_id="{{$product->id}}"を使う$(this)=クリックしたid
    // let deleteData = $(this).data("product_id");
    // console.log(deleteData);
    // let deleteData = $(this).data("product_id");
    // clickEle = $(this);
    // let deleteData = clickEle.attr("data-product_id");
    // let deleteData = $(this).$('input[name="deleteData"]').val();
    console.log(deleteData);
    let deleteConfirm = confirm("削除してよろしいでしょうか？");
    if (deleteConfirm == true) {
        $.ajax({
            url: "/step7/public/delete/" + deleteData,
            type: "POST",
            data: { deleteData },
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        }).done(function (response) {
            console.log(response);
            if (response.id) {
                $(`#product-${response.id}`).fadeOut();
            } else {
                console.log(response.message);
            }
        });
    } else {
        (function (e) {
            e.preventDefault();
        });
    }
}
