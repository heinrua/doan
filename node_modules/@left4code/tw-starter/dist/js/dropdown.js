(function () {
  "use strict";

  // Hide dropdown
  function hide() {
    $(".dropdown-menu").each(async function () {
      if (
        $(this).attr("id") !== undefined &&
        $('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length &&
        $(this).data("dropdown-programmatically") === undefined
      ) {
        let randId = $(this).attr("id");
        let dropdownToggle = $('[data-dropdown-replacer="' + randId + '"]')
          .parent()
          .find("[data-tw-toggle='dropdown']");

        // Animate dropdown
        $(this).removeClass("show");

        // Trigger "hide.tw.dropdown" callback function
        const event = new Event("hide.tw.dropdown");
        $(dropdownToggle).parent()[0].dispatchEvent(event);

        await setTimeout(() => {
          // Move dropdown element to body
          $('[data-dropdown-replacer="' + randId + '"]').replaceWith(this);

          // Reset attribute
          $(this).removeAttr("style");
          $(this).removeAttr("data-popper-placement");

          // Set aria-expanded to false
          $(dropdownToggle).attr("aria-expanded", false);

          // Trigger "hidden.tw.dropdown" callback function
          const event = new Event("hidden.tw.dropdown");
          $(dropdownToggle).parent()[0].dispatchEvent(event);
        }, 200);
      } else if (
        $(this).attr("id") !== undefined &&
        !$('[data-dropdown-replacer="' + $(this).attr("id") + '"]').length &&
        $(this).hasClass("show") &&
        $(this).data("dropdown-programmatically") === undefined
      ) {
        $(this).remove();
      } else if ($(this).data("dropdown-programmatically") == "initiate") {
        // Set programmatically attribute state
        $(this).attr("data-dropdown-programmatically", "showed");
      } else if ($(this).data("dropdown-programmatically") == "showed") {
        // Remove programmatically attribute state
        $(this).removeAttr("data-dropdown-programmatically");

        // Hide dropdown
        hide();
      }
    });
  }

  // Find visible dropdown toggle
  function findVisibleDropdownToggle(dropdownToggle) {
    return dropdownToggle.filter((key, dropdownToggle) => {
      return dropdownToggle.offsetParent !== null;
    });
  }

  // Show dropdown
  async function show(dropdown) {
    let dropdownBox = $(dropdown).find(".dropdown-menu").first();
    let dropdownToggle = findVisibleDropdownToggle(
      $(dropdown).find("[data-tw-toggle='dropdown']")
    );
    let placement = $(dropdown).data("tw-placement")
      ? $(dropdown).data("tw-placement")
      : "bottom-end";
    let randId = "_" + Math.random().toString(36).substr(2, 9);

    // Hide dropdown
    hide();

    if ($(dropdownBox).length) {
      // Set aria-expanded to true
      $(dropdownToggle).attr("aria-expanded", true);

      // Set dropdown width
      $(dropdown).css("position") == "static"
        ? $(dropdown).css("position", "relative")
        : "";
      $(dropdownBox).show();
      $(dropdownBox).css("width", $(dropdownBox).css("width"));

      // Move dropdown element to body
      $('<div data-dropdown-replacer="' + randId + '"></div>').insertAfter(
        dropdownBox
      );
      $(dropdownBox).attr("id", randId).appendTo("body");

      // Check if dropdown is used inside modal
      $(".modal.show").each(function () {
        if ($(this).find('[data-dropdown-replacer="' + randId + '"]')) {
          $(dropdownBox).css("z-index", $(this).css("z-index"));
        }
      });

      // Init popper
      Popper.createPopper(dropdownToggle[0], dropdownBox[0], {
        placement: placement,
      });

      // Show dropdown
      $(dropdownBox).addClass("show");

      // Trigger "show.tw.dropdown" callback function
      const event = new Event("show.tw.dropdown");
      $(dropdown)[0].dispatchEvent(event);

      await setTimeout(() => {
        // Trigger "shown.tw.dropdown" callback function
        const event = new Event("shown.tw.dropdown");
        $(dropdown)[0].dispatchEvent(event);
      }, 200);
    }
  }

  // Toggle dropdown programmatically
  function toggleProgrammatically(dropdown) {
    let dropdownBox = $(dropdown).find(".dropdown-menu").first();
    if ($(dropdownBox).length) {
      showProgrammatically(dropdown);
    } else {
      hide();
    }
  }

  // Show dropdown programmatically
  function showProgrammatically(dropdown) {
    if ($(dropdown).find(".dropdown-menu").length) {
      $(dropdown)
        .find(".dropdown-menu")
        .attr("data-dropdown-programmatically", "initiate");
    } else {
      let randId = $("[data-dropdown-replacer]").data("dropdown-replacer");
      $("#" + randId).attr("data-dropdown-programmatically", "initiate");
    }

    show(dropdown);
  }

  // Create instance
  function createInstance(dropdownToggle) {
    const dropdown = $(dropdownToggle).closest(".dropdown");
    return {
      show() {
        showProgrammatically(dropdown);
      },
      hide() {
        hide();
      },
      toggle() {
        toggleProgrammatically(dropdown);
      },
    };
  }

  // Dropdown event listener
  $("body").on("click", function (event) {
    let dropdown = $(event.target).closest(".dropdown");
    let dropdownToggle = $(dropdown).find("[data-tw-toggle='dropdown']");
    let dropdownBox = $(dropdown).find(".dropdown-menu").first();
    let activeDropdownBox = $(event.target).closest(".dropdown-menu").first();
    let dismissButton = $(event.target).data("tw-dismiss");

    if (
      (!$(dropdown).length && !$(activeDropdownBox).length) ||
      ($(dropdownToggle).length && !$(dropdownBox).length) ||
      dismissButton == "dropdown"
    ) {
      // Hide dropdown
      hide();
    } else if (!$(activeDropdownBox).length) {
      // Show dropdown
      show(dropdown);
    }
  });

  // Keyboard event
  document.addEventListener("keydown", function (event) {
    if (event.code == "Escape") {
      hide();
    }
  });

  // Register instance
  (function init() {
    $("[data-tw-toggle='dropdown']").each(function () {
      this["__dropdown"] = createInstance(this);
    });

    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Dropdown = {
      getInstance(el) {
        return el.__dropdown;
      },
      getOrCreateInstance(el) {
        return el.__dropdown === undefined ? createInstance(el) : el.__dropdown;
      },
    };
  })();
})();
