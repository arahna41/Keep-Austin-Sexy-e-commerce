"use strict";
/* init carousels */
//Carousel.Plugins.Autoplay = Autoplay;
const sliders = document.querySelectorAll(".carousel");
if (sliders) {
  sliders.forEach((item) => {
    if (item.classList.contains("main_page_banner__carousel")) {
      const myCarousel = new Carousel(item, {
        fill: true,
        slidesPerPage: 1,
        friction: 0.92,
        initialPage: 1,
        timeout: 6000,
        on: {
          ready: (carousel) => {
            carousel.$container
              .querySelectorAll(".carousel__slide")
              .forEach((i) => {
                i.style.display = "grid";
              });
          },
        },
      });
      myCarousel.updatePage();
    } else if (item.classList.contains("main_page_banner__carousel") == false) {
      const myCarousel = new Carousel(item, {
        infinite: false,
        fill: true,
        friction: 0.92,
        center: false,
        on: {
          ready: (carousel) => {
            carousel.$container
              .querySelectorAll(".carousel__slide")
              .forEach((i) => {
                i.style.opacity = "1";
              });
          },
        },
      });
      myCarousel.plugins.Autoplay.stop();
    }
    if (item.classList.contains("cart_reviewed_products_carousel")) {
      const myCarousel = new Carousel(item, {
        infinite: false,
        fill: true,
        slidesPerPage: 1,
        friction: 0.92,
        center: false,
      });
      myCarousel.plugins.Autoplay.stop();
    }
  });
}

/* loader */
window.onload = function () {
  document.body.classList.add("loaded_hiding");
  window.setTimeout(function () {
    document.body.classList.add("loaded");
    document.body.classList.remove("loaded_hiding");
  }, 500);
};

/* dropdown */
const dropdownBtn = document.getElementsByClassName("btn_dropdown");
if (dropdownBtn) {
  for (let i = 0; i < dropdownBtn.length; i++) {
    dropdownBtn[i].addEventListener("click", function () {
      this.classList.toggle("active");
      const allPanel = document.querySelectorAll(".panel_dropdown");
      const panel = this.nextElementSibling;
      if (panel.style.height) {
        panel.style.height = null;
      } else {
        allPanel.forEach((item) => {
          item.style.height = null;
        });
        panel.style.height = panel.scrollHeight + "px";
      }
    });
  }
}

/* style for mobile menu */
const btnMenu = document.querySelector(".header__mobile_btn");
const btnCross = document.querySelector(".header__mobile_btn_cross");
const mobileMenuPanel = document.querySelector(".header__mobile_panel");
if (btnMenu) {
  btnMenu.addEventListener("click", function () {
    mobileMenuPanel.style.right = "0";
  });
}

if (btnCross) {
  btnCross.addEventListener("click", function () {
    mobileMenuPanel.style.right = "100%";
  });
}

// Style for open/close filters on catalog page

const btnFilter = document.querySelector(".btn_catalog_filters");
const catalogOverlay = document.querySelector(".catalog_overlay");
const panelFilter = document.querySelector(".catalog_filters_panel");
const btnFilterCross = document.querySelector(".btn_catalog_filters_cross");

if (btnFilter) {
  btnFilter.addEventListener("click", function () {
    catalogOverlay.classList.add("catalog_overlay_active");

    panelFilter.classList.add("catalog_filters_panel_active");
  });

  btnFilterCross.addEventListener("click", function () {
    catalogOverlay.classList.remove("catalog_overlay_active");

    panelFilter.classList.remove("catalog_filters_panel_active");
  });

  document.addEventListener("mousedown", function (e) {
    if (
      e.target.closest(".catalog_filters_panel") === null ||
      e.target.closest(".catalog_overlay") === null
    ) {
      panelFilter.classList.remove("catalog_filters_panel_active");
      catalogOverlay.classList.remove("catalog_overlay_active");
    }
  });
}

// Cart List

const product = document.querySelectorAll(".cart_product");
const productList = document.querySelector(".product_list");
const checkoutList = document.querySelector(".checkout_list.shop_table");
const checkoutProducts = document.querySelectorAll(".checkout_product");

if (productList && product.length > 4) {
  productList.classList.add("overflow");
} else if (checkoutList && product.length > 4) {
  checkoutList.classList.add("overflow");
}

// Style description on product_page
const descriptionProduct = document.querySelector(
  ".woocommerce_description_title"
);
if (descriptionProduct) {
  descriptionProduct.nextElementSibling.style.maxHeight = "72px";
  descriptionProduct.nextElementSibling.style.overflow = "hidden";
}

const accordionReviews = document.querySelector(".product_page__review_title");

if (accordionReviews) {
  accordionReviews.addEventListener("click", function () {
    this.classList.toggle("active_reviews");
    const panel = this.nextElementSibling;
    if (panel.style.height) {
      panel.style.height = null;
    } else {
      panel.style.height = panel.scrollHeight + "px";
    }
  });
}

// Checkout tab

const checkoutTab = document.querySelector(".checkout_result_header"),
  checkoutOrder = document.querySelector(".order_wrapper"),
  arrow = document.querySelector(".tab_arrow");

if (checkoutTab) {
  checkoutTab.addEventListener("click", () => {
    arrow.classList.toggle("order_open");
    if (checkoutOrder.style.maxHeight) {
      checkoutOrder.style.maxHeight = null;
    } else {
      checkoutOrder.style.maxHeight = null;
      checkoutOrder.style.maxHeight = checkoutOrder.scrollHeight + "px";
    }
  });
}

const checkboxShipToDifferentAddress = document.querySelector(
  "#ship-to-different-address-checkbox"
);
const shippingFields = document.querySelector(".shipping_address");
if (checkboxShipToDifferentAddress && shippingFields) {
  checkboxShipToDifferentAddress.addEventListener("change", function () {
    if (this.checked) {
      shippingFields.classList.add("shipping_address_opened");
    } else {
      shippingFields.classList.remove("shipping_address_opened");
    }
  });
}

// Payment
const paymentMethods = document.querySelectorAll(".radio_spoller");
const method = document.querySelector(".radio_spoller");

// accordion functionality
paymentMethods.forEach((paymentMethod) => {
  paymentMethod.addEventListener("click", () => {
    const currentlyOpenMethod = document.querySelector(".radio_spoller._open");

    if (currentlyOpenMethod && currentlyOpenMethod !== paymentMethod) {
      currentlyOpenMethod.classList.remove("_open");
      currentlyOpenMethod.nextElementSibling.style.maxHeight = 0;
    }

    paymentMethod.classList.add("_open");

    const paymentButton = paymentMethod.nextElementSibling;

    if (paymentMethod.classList.contains("_open")) {
      paymentButton.style.maxHeight = paymentButton.scrollHeight + "px";
    } else {
      paymentButton.style.maxHeight = 0;
    }
  });
});

/* search */
const btnSearch = document.querySelector(".header_search");
const crossSearch = document.querySelector(".header_panel_cross");
const searchPanelOverlay = document.querySelector(
  ".header_search_panel_overlay"
);
const searchPanel = document.querySelector(".header_search_panel");
const inputSearchValue = document.querySelector("#input_search");
const toggleMenu = function () {
  if (searchPanel.classList.contains("header_search_panel_active")) {
    searchPanelOverlay.style.display = "none";
    inputSearchValue.value = "";
    searchPanel.classList.remove("header_search_panel_active");
  } else {
    searchPanelOverlay.style.display = "block";
    searchPanel.classList.add("header_search_panel_active");
  }
};
if (btnSearch && searchPanel && crossSearch) {
  btnSearch.addEventListener("click", function (e) {
    e.stopPropagation();
    toggleMenu();
  });

  crossSearch.addEventListener("click", function (e) {
    e.stopPropagation();
    toggleMenu();
    searchPanel.querySelector("input").value = null;
  });

  document.addEventListener("click", function (e) {
    const target = e.target;
    const itsSearch = target == searchPanel || searchPanel.contains(target);
    const itsBtnSearch = target == btnMenu;
    const searchIsActive = searchPanelOverlay.style.display == "block";

    if (!itsSearch && !itsBtnSearch && searchIsActive) {
      toggleMenu();
    }
  });
}

/* gift card */
const btnGiftCard = document.querySelector(".sertificates__gift");
const giftCardPanel = document.querySelector(".gift_card_panel");
const contentGiftCard = document.querySelector(".gift_card_content");

if (btnGiftCard && giftCardPanel) {
  btnGiftCard.addEventListener("click", function () {
    giftCardPanel.style.display = "grid";
  });
}

const crossGiftCard = document.querySelector(".gift_cadr_cross");
if (crossGiftCard && giftCardPanel) {
  crossGiftCard.addEventListener("click", function () {
    giftCardPanel.style.display = "none";
    imageBlocksGiftCard.forEach(function (imageBlock) {
      imageBlock.nextElementSibling.classList.remove(
        "gift_card__description_active"
      );
    });
  });
  document.addEventListener("mousedown", function (e) {
    if (
      e.target.closest(".gift_card_content") === null ||
      e.target.closest(".gift_card_panel") === null
    ) {
      giftCardPanel.style.display = "none";
      imageBlocksGiftCard.forEach(function (imageBlock) {
        imageBlock.nextElementSibling.classList.remove(
          "gift_card__description_active"
        );
      });
    }
  });
}

const imageBlocksGiftCard = document.querySelectorAll(".gift_card__images");
const descGiftCards = document.querySelectorAll(".gift_card__description");
if (imageBlocksGiftCard && descGiftCards) {
  imageBlocksGiftCard.forEach(function (imageBlock) {
    imageBlock.addEventListener("click", function () {
      descGiftCards.forEach((item) => {
        item.classList.remove("gift_card__description_active");
      });
      this.nextElementSibling.classList.add("gift_card__description_active");
    });
  });
}

const crossGiftCadrDesc = document.querySelectorAll(".gift_card_desc__cross");
if (crossGiftCadrDesc) {
  crossGiftCadrDesc.forEach((cross) => {
    cross.addEventListener("click", function () {
      cross.parentElement.classList.remove("gift_card__description_active");
    });
  });
}

/* style for checkbox */
const inputMailPoet = document.querySelector(
  "#mailpoet_woocommerce_checkout_optin"
);
if (inputMailPoet) {
  if (inputMailPoet.checked) {
    inputMailPoet.parentElement.classList.add("woocommerce-form__label_active");
    console.log("CHecked");
  } else {
    inputMailPoet.parentElement.classList.remove(
      "woocommerce-form__label_active"
    );
    console.log("Unchecked");
  }
}

/* not edit email in checkout */
const inputEmail = document.querySelector("#billing_email");
if (inputEmail) {
  inputEmail.setAttribute("readonly", "true");
}

/* faq */
const titleFAQs = document.querySelectorAll(".faq_header");
if (titleFAQs) {
  titleFAQs.forEach((titleFAQ) => {
    titleFAQ.addEventListener("click", () => {
      const panelFAQ = titleFAQ.nextElementSibling;
      panelFAQ.classList.toggle("faq_content_active");
      if (panelFAQ.classList.contains("faq_content_active")) {
        titleFAQ.nextElementSibling.style.height =
          titleFAQ.nextElementSibling.scrollHeight + "px";
      } else {
        titleFAQ.nextElementSibling.style.height = null;
      }
    });
  });
}
