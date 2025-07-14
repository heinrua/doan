(function () {
  "use strict";

  function init(el) {
    const targetEl = $(el).clone().html("");
    const isShown = $($("<div></div>").append(targetEl)).find(
      $(targetEl).data("selector")
    ).length;

    if ($(el).data("state") === undefined) {
      $(el).data("state", !isShown ? "enter" : "leave");
      !isShown ? $(el).hide() : $(el).show();
    }

    if (isShown && $(el).data("state") === "leave") {
      $(el).data("state", "enter");
      $(el).show();

      // Enter
      $(el).addClass($(el).data("enter-from"));
      setTimeout(() => {
        $(el).addClass($(el).data("enter"));
        $(el).addClass($(el).data("enter-to"));
        $(el).removeClass($(el).data("enter-from"));

        setTimeout(() => {
          $(el).removeClass($(el).data("enter"));
        }, parseFloat($(el).css("transition-duration")) * 1000);
      });
    } else if (!isShown && $(el).data("state") === "enter") {
      $(el).data("state", "leave");

      // Leave
      $(el).addClass($(el).data("leave-from"));
      setTimeout(() => {
        $(el).addClass($(el).data("leave"));
        $(el).addClass($(el).data("leave-to"));
        $(el).removeClass($(el).data("leave-from"));

        setTimeout(() => {
          $(el).removeClass($(el).data("leave"));
          $(el).attr(
            "class",
            ($(el).attr("class") !== undefined ? $(el).attr("class") : "")
              .split(" ")
              .filter((value) => {
                return value.search("mt-") === -1;
              })
              .join(" ")
          );
          setTimeout(() => {
            $(el).hide();
          }, 100);
        }, parseFloat($(el).css("transition-duration")) * 1000);
      });
    }
  }

  const observer = new MutationObserver((mutationList) => {
    mutationList.forEach(async function (mutation) {
      if (mutation.type === "attributes") {
        init(mutation.target);
      }
    });
  });

  $("[data-transition]").each(function () {
    observer.observe(this, {
      attributes: true,
    });

    init(this);
  });
})();
