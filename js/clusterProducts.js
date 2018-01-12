var tbody = undefined;

$(document).ready(function () {

    tbody = $("#bodyTable");

    $.ajax({
        method: "GET",
        url: "../php/rechercheClusterProducts.php",
        dataType: 'json'
    })
        .done(function (html) {
            addRowsResult(html);
        })
        .fail(function (jqXHR, textStatus) {
            console.log(textStatus);
        });
});

function addRowsResult(rows) {

    tbody.empty();

    $.each(rows, function (key, value) {
        addRowTable(key, value);
    });
}

function addRowTable(key, sqlRow) {

    var tr = "<tr><td>"+(key+1)+"</td>";

    $.each(sqlRow, function (key, value) {
        tr += "<td>" +
                "<a style='cursor: pointer'>" + value['product_name'] + "</a>" +
            "</td>";
    });

    tr += "</tr>";

    tbody.append(tr);
}
