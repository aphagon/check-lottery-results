/*
 * @Author: MooToons <support@mootoons.com>
 * @Date: 2023-02-26 00:44:50
 * @LastEditTime: 2023-03-03 04:51:17
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

    $("html, body").animate(
      {
        scrollTop: $("#checkLotteryResultsContent").offset().top,
      },
      500
    );

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

  /**
   * Thai Lotto
   */

  var lottery_month = [
    "",
    "มกราคม",
    "กุมภาพันธ์",
    "มีนาคม",
    "เมษายน",
    "พฤษภาคม",
    "มิถุนายน",
    "กรกฏาคม",
    "สิงหาคม",
    "กันยายน",
    "ตุลาคม",
    "พฤศจิกายน",
    "ธันวาคม",
  ];
  $("#CheckLotteryResultsThaiLotto").submit(function (e) {
    e.preventDefault();
    var lotteryThai = $(this).data("lottery-thai");

    var $checkLotteryResultsMessage = $("#CheckLotteryResultsMessage");
    var msg = "ไม่ถูกรางวัลใด ๆ";

    var $checkLotteryResultsNumber = $("#CheckLotteryResultsNumber");
    var filter = $checkLotteryResultsNumber.val();

    if ("" === filter) {
      return false;
    }

    var intRegex = /^\d+$/;
    if (intRegex.test(filter) && filter.length !== 6) {
      $checkLotteryResultsMessage.html(
        '<p class="check-lottery-results-single-thai-lotto__message-in-text">กรุณาระบุหมายเลขสลากให้ถูกต้อง</p>'
      );
      return false;
    }

    var numberWithCommas = function (x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    };

    var d2 = filter.substring(4, 6);
    var d3f = filter.substring(0, 3);
    var d3l = filter.substring(3, 6);

    var map = new Map(Object.entries(lotteryThai));
    map.forEach(function (lotto, index) {
      for (var i = 0; i < lotto.data.length; i++) {
        var val = lotto.data[i];

        if (filter == val) {
          if (index == 11) {
            msg = filter + " ถูกรางวัลข้างเคียงรางวัลที่ 1 จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          } else {
            msg = filter + " ถูกรางวัล รางวัลที่ " + index + " จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          }
        } else if (d2 == val) {
          msg = filter + " ถูกรางวัล เลขท้าย 2 ตัว จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          break;
        } else if (d2 == val) {
          msg = filter + " ถูกรางวัล เลขท้าย 2 ตัว จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          break;
        } else if (d3l == val && index == 6) {
          msg = filter + " ถูกรางวัล เลขท้าย 3 ตัว จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          break;
        } else if (d3f == val && index == 10) {
          msg = filter + " ถูกรางวัล เลขหน้า 3 ตัว จำนวนเงิน " + numberWithCommas(lotto.info[1]) + " บาท";
          break;
        }
      }
    });

    $checkLotteryResultsMessage.html(
      '<p class="check-lottery-results-single-thai-lotto__message-in-text">' + msg + "</p>"
    );

    return false;
  });

  var $checkLotteryResultsSearchSelectDay = $("#CheckLotteryResultsSearchSelectDay");
  $("#CheckLotteryResultsSearchSelectYear").change(function () {
    var lotteryThaiYears = $("#CheckLotteryResultsSearch").data("lottery-thai-years");

    $checkLotteryResultsSearchSelectDay.empty();
    $checkLotteryResultsSearchSelectDay.append(
      $("<option/>", {
        value: "",
        text: "งวดประจำวันที่",
      })
    );

    if ("" === this.value || lotteryThaiYears[this.value] === undefined) {
      return;
    }

    $.each(lotteryThaiYears[this.value], function (_, value) {
      var d = value.split(" ");

      var month, date;
      for (let i = 1; i < lottery_month.length; i++) {
        if (lottery_month[i] === d[1]) {
          month = ("0" + i).slice(-2);
          break;
        }
      }
      date = parseInt(d[2]) - 543 + "-" + month + "-" + ("0" + d[0]).slice(-2);

      $checkLotteryResultsSearchSelectDay.append(
        $("<option/>", {
          value: date,
          text: value,
        })
      );
    });
  });

  $("#CheckLotteryResultsSearchSubmit").click(function () {
    var select_date = $checkLotteryResultsSearchSelectDay.val();
    if ("" !== select_date) {
      window.location = $(this).data("href") + "?lottery-date=" + select_date;
    } else {
      alert("จำเป็นต้องเลือกงวด");
    }

    return false;
  });
});
