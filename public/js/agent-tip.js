function setPrice(value) {
    $("#tip_price").val(value);
    removeClass();
    $("#price_" + value).attr("class", "btn btn-outline-info active");
}

function removeClass() {
    $("#price_5").attr("class", "btn btn-outline-info");
    $("#price_10").attr("class", "btn btn-outline-info");
    $("#price_15").attr("class", "btn btn-outline-info");
    $("#price_custom").attr("class", "btn btn-outline-info dropdown-toggle");
    $("#custom_tip_span").html('Custom Tip');
}

function setCustomPrice() {
    $("#tip_price").val($("#custom_price").val());
    removeClass();
    $("#custom_tip_span").html('Custom Tip-' + $("#custom_price").val() + ' €');
    $("#price_custom").attr("class", "btn btn-outline-info dropdown-toggle active");
}