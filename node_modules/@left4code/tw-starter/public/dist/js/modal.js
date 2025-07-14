(function () {
  // Get highest z-index
  function getHighestZindex() {
    let zIndex = 9999;
    $(".modal").each(function () {
      if (
        $(this).css("z-index") !== "auto" &&
        $(this).css("z-index") > zIndex
      ) {
        zIndex = parseInt($(this).css("z-index"));
      }
    });

    return zIndex;
  }

  // Get scrollbar width
  function getScrollbarWidth(el) {
    return window.innerWidth - $(el)[0].clientWidth;
  }

  // Show modal with z-index
  function show(el) {
    if (!$("[data-modal-replacer='" + $(el).attr("id") + "']").length) {
      // Move modal element to body
      $(
        '<div data-modal-replacer="' + $(el).attr("id") + '"></div>'
      ).insertAfter(el);
      $(el).css({
        "margin-top": 0,
        "margin-left": 0,
      });
      $(el).attr("aria-hidden", false).appendTo("body");

      // Show modal by highest z-index
      setTimeout(() => {
        $(el)
          .addClass("show")
          .css("z-index", getHighestZindex() + 1);

        // Trigger "shown.tw.modal" callback function
        const event = new Event("shown.tw.modal");
        $(el)[0].dispatchEvent(event);
      }, 200);

      // Setting up modal scroll
      $("body")
        .css(
          "padding-right",
          parseInt($("body").css("padding-right")) +
            getScrollbarWidth("html") +
            "px"
        )
        .addClass("overflow-y-hidden");
      $(".modal").removeClass("overflow-y-auto").css("padding-left", "0px");
      $(el)
        .addClass("overflow-y-auto")
        .css("padding-left", getScrollbarWidth(el) + "px")
        .addClass($(".modal.show").length ? "modal-overlap" : "");

      // Trigger "show.tw.modal" callback function
      const event = new Event("show.tw.modal");
      $(el)[0].dispatchEvent(event);
    }
  }

  // Hide modal & remove modal scroll
  function hide(el) {
    if ($(el).hasClass("modal") && $(el).hasClass("show")) {
      let transitionDuration =
        parseFloat($(el).css("transition-duration").split(",")[1]) * 1000;
      $(el).attr("aria-hidden", true).removeClass("show");

      setTimeout(() => {
        $(el)
          .removeAttr("style")
          .removeClass("modal-overlap")
          .removeClass("overflow-y-auto");

        // Add scroll to highest z-index modal if exist
        $(".modal").each(function () {
          if (parseInt($(this).css("z-index")) === getHighestZindex()) {
            $(this)
              .addClass("overflow-y-auto")
              .css("padding-left", getScrollbarWidth(this) + "px");
          }
        });

        // Return back scroll to body if no more modal showed up
        if (getHighestZindex() == 9999) {
          $("body").removeClass("overflow-y-hidden").css("padding-right", "");
        }

        // Return back modal element to it's first place
        $('[data-modal-replacer="' + $(el).attr("id") + '"]').replaceWith(el);

        // Trigger "hidden.tw.modal" callback function
        const event = new Event("hidden.tw.modal");
        $(el)[0].dispatchEvent(event);
      }, transitionDuration);

      // Trigger "hide.tw.modal" callback function
      const event = new Event("hide.tw.modal");
      $(el)[0].dispatchEvent(event);
    }
  }

  // Toggle modal
  function toggle(el) {
    if ($(el).hasClass("modal") && $(el).hasClass("show")) {
      hide(el);
    } else {
      show(el);
    }
  }

  // Create instance
  function createInstance(el) {
    return {
      show() {
        show(el);
      },
      hide() {
        hide(el);
      },
      toggle() {
        toggle(el);
      },
    };
  }

  // Show modal
  $("body").on("click", '[data-tw-toggle="modal"]', function () {
    show($(this).attr("data-tw-target"));
  });

  // Hide modal
  $("body").on("click", (event) => {
    if ($(event.target).hasClass("modal") && $(event.target).hasClass("show")) {
      // Check if modal backdrop is not static
      if ($(event.target).data("tw-backdrop") !== "static") {
        hide(event.target);
      } else {
        $(event.target).addClass("modal-static");
        setTimeout(() => {
          $(event.target).removeClass("modal-static");
        }, 600);
      }
    }
  });

  // Dismiss modal by link
  $("body").on("click", '[data-tw-dismiss="modal"]', function () {
    let modal = $(this).closest(".modal")[0];
    hide(modal);
  });

  // Keyboard event
  document.addEventListener("keydown", (event) => {
    if (event.code == "Escape") {
      let el = $(".modal.show").last();
      if (
        $(el).hasClass("modal") &&
        $(el).hasClass("show") &&
        ($(el).data("tw-keyboard") === undefined ||
          $(el).data("tw-keyboard") !== "false")
      ) {
        // Check if modal backdrop is not static
        if ($(el).data("tw-backdrop") !== "static") {
          hide(el);
        } else {
          $(el).addClass("modal-static");
          setTimeout(() => {
            $(el).removeClass("modal-static");
          }, 600);
        }
      }
    }
  });

  // Register instance
  (function init() {
    $(".modal").each(function () {
      this["__modal"] = createInstance(this);
    });

    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Modal = {
      getInstance(el) {
        return el.__modal;
      },
      getOrCreateInstance(el) {
        return el.__modal === undefined ? createInstance(el) : el.__modal;
      },
    };
  })();
})();
