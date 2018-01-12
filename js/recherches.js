var tbody = undefined;
var data = undefined;
var dataSimi = undefined;
var pageActuelle = 1;
var valueSearch = "";

$(document).ready(function () {
    tbody = $("#bodyTable");

    $("#btnSearch").click(function () {
        valueSearch = $("#schbox").val();
        pageActuelle = 1;

        getProducts();

        $("#divInfo").hide();
        $("#divSimi").hide();
    });

    $('#schbox').keydown(function(e) {
        var key = e.which;
        if (key == 13) {
            $("#btnSearch").click();
        }
    });

    $("#postPage").click(function () {

        if (pageActuelle <= 1)
            return;

        pageActuelle--;

        getProducts();
    });

    $("#nextPage").click(function () {
        pageActuelle++;

        getProducts();
    });
});

function getProductsSimilaire(index) {
    $.ajax({
        method: "GET",
        url: "../php/rechercheProductsSimi.php",
        dataType: 'json',
        data: { index: index }
    })
        .done(function (html) {
            dataSimi = html;
            addProduitsSimilaire(html);
        })
        .fail(function (jqXHR, textStatus) {
            console.log(textStatus);
        });
}

function addProduitsSimilaire(rows) {

    $("#divSimiProducts").empty();

    $.each(rows, function (key, value) {
        addProduitSimilaire(value);
    });

    $("#divSimi").show();
}

function addProduitSimilaire(row) {

    $("#divSimiProducts").append("<div style='display: inline-block; margin: 0 auto; width: 20%;'>" +
        "<img style='display: block; margin: 0 auto' width='150' height='150' src='" + row['image_url'] + "'>" +
        "<br>" +
        "<p style='text-align: center'>" +
        "<a href='#divInfo' style='cursor: pointer' onclick='selectProduct(" + row['index'] + ")'>" + row['product_name'] + "</a></p></div>");

}

function getProducts() {
    $.ajax({
        method: "GET",
        url: "../php/rechercheProducts.php",
        dataType: 'json',
        data: { nom: valueSearch, page: pageActuelle }
    })
        .done(function (html) {
            data = html;
            addRowsResult(html);
        })
        .fail(function (jqXHR, textStatus) {
            console.log(textStatus);
        });
}

function selectProduct(index) {

    var tmp = undefined;

    if (data[index] != undefined)
        tmp = data;
    else
        tmp = dataSimi;

    $('#p_img').attr('src', tmp[index]['image_url']);
    $('#p_nom').text(tmp[index]['product_name']);
    $('#p_origine').text(tmp[index]['countries_tags'].split(':')[1]);
    $('#p_nutr').text(tmp[index]['nutrition-score-fr_100g']);
    $('#p_nrj').text(tmp[index]['energy_100g']);
    $('#p_fat').text(tmp[index]['fat_100g']);
    $('#p_satfat').text(tmp[index]['saturated-fat_100g']);
    $('#p_prot').text(tmp[index]['proteins_100g']);
    $('#p_salt').text(tmp[index]['salt_100g']);
    $('#p_sugar').text(tmp[index]['sugars_100g']);

    getProductsSimilaire(index);

    $("#divInfo").show();
}

function addRowsResult(rows) {

    tbody.empty();

    $.each(rows, function (key, value) {
        addRowTable(value);
    });

    $("#curPage").text(pageActuelle);

    $("#divTableProducts").show();

    $(document).scrollTop( $("#divTableProducts").offset().top );
}

function addRowTable(sqlRow) {

    tbody.append("" +
        "<tr>" +
            "<td><img width='40' height='40' src='"+ sqlRow['image_small_url'] +"'></td>" +
            "<td onclick='selectProduct("+sqlRow['index']+")'>" +
                "<a href='#divInfo' style='cursor: pointer'>" + sqlRow['product_name'] + "</a>" +
            "</td>" +
            "<td>" + sqlRow['countries_tags'].split(':')[1] + "</td>" +
            "<td>" + sqlRow['nutrition-score-fr_100g'] + "</td>" +
            "<td>" + sqlRow['energy_100g'] + "</td>" +
            "<td>" + sqlRow['fat_100g'] + "</td>" +
            "<td>" + sqlRow['saturated-fat_100g'] + "</td>" +
            "<td>" + sqlRow['proteins_100g'] + "</td>" +
            "<td>" + sqlRow['salt_100g'] + "</td>" +
            "<td>" + sqlRow['sugars_100g'] + "</td>" +
        "</tr>");

}