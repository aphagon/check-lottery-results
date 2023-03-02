/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-26 00:44:50
 * @LastEditTime: 2023-03-02 13:11:03
 * @LastEditors: MooToons
 * @Link: https://mootoons.com/
 * @FilePath: \check-lottery-results\assets\script.js
 */

jQuery(document).ready(function ($) {
  $(".check-lottery-results-single__sidebar a").on("click", function () {
    var typeTxt = $(this).text();
    var $loader = $(".check-lottery-results-single__loader");
    var $icon = $(".check-lottery-results-single__header-icon");
    var $title = $(".check-lottery-results-single__header-title");
    var $date = $(".check-lottery-results-single__header-date");
    var $tbody = $(".check-lottery-results-single__card-table tbody");

    $(".check-lottery-results-single__sidebar a").removeClass("check-lottery-results-single__sidebar-link-active");
    $(this).addClass("check-lottery-results-single__sidebar-link-active");

    $.ajax({
      method: "GET",
      url: checkLotteryResults.url,
      data: {
        nonce: checkLotteryResults.nonce,
        type: typeTxt,
      },
      beforeSend: function () {
        $loader.show();
      },
    })
      .done(function (res) {
        if (!res.success) {
          alert("เกิดข้อผิดพลาดบางอย่างโปรดลองใหม่อีกครั้ง");
          return;
        }

        if (!res.data) {
          return;
        }

        $icon.attr("src", res.data[0].icon);
        $icon.attr("alt", res.data[0].name);
        $title.text(res.data[0].name);
        $date.text(res.data[0].huayResultModel[0].name);

        $tbody.empty();

        $.each(res.data[0].huayResultModel, function (index, value) {
          var primaryNumber = value.result ? value.result.primaryNumber : "รอผล";
          var threeNumber = value.result ? value.result.primaryNumber.substring(1) : "รอผล";
          var twoNumber = value.result ? value.result.twoNumber : "รอผล";

          $tbody.append(
            "<tr>" +
              "<td>" +
              value.name +
              "</td>" +
              "<td>" +
              primaryNumber +
              "</td>" +
              "<td>" +
              threeNumber +
              "</td>" +
              "<td>" +
              twoNumber +
              "</td>" +
              "<tr>"
          );
        });
      })
      .fail(function () {
        alert("เกิดข้อผิดพลาดบางอย่างโปรดลองใหม่อีกครั้ง");
      })
      .always(function () {
        $loader.hide();
      });
  });
});
