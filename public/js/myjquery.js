/**
 * Mé jqry
 * Author & copyright (c) 2018: Jan Dorschner
 */
(function($) {

 /** check resize */
  $(document).ready(function() {
    // run test on initial page load
    checkSize();
    // run test on resize of the window
    $(window).resize(checkSize);
  });

  //Function to the css rule
  function checkSize(){
    if ($(window).width() < 1023) {
      $("aside .toggle-button").appendTo(".left-panel");
      if ($(window).width() < 768) {
        $(".devsmaller li:last-child").prev("li").andSelf().addClass("special");
          if ($(window).width() < 540) {
            $("#chngtxt").html("Koupit");
          } else {
            $("#chngtxt").html("Vložit do košíku");
          }
      } else {
        $(".devsmaller li:last-child").prev("li").andSelf().removeClass("special");
      }
    } else {
      $("aside .toggle-button").appendTo(".left-panel");
    }
  }

  /** kliknes vedle vypnes */
  $("html").click(function() {
    $(".overlay").fadeOut(300);
    $("html").removeClass("overflowhidden");
    $("html, body").removeClass("overflowhiddenfixed");
    $(".modal-handler").fadeOut(300);
    $(".cart-content").removeClass("isIn");
    $(".cart-button").removeClass("open");
    if ($(window).width() < 540) {
      $(".cart-content").animate({"right":"-100%"}, 300);
    }
  });

  /** ESC BIND */
  $(document).keyup(function(event){
    if(event.keyCode === 27)  {
      $(".overlay").fadeOut(300);
      $("html").removeClass("overflowhidden");
      $("html, body").removeClass("overflowhiddenfixed");
      $(".modal-handler").fadeOut(300);
      $(".cart-content").removeClass("isIn");
      $(".cart-button").removeClass("open");
      if ($(window).width() < 540) {
        $(".cart-content").animate({"right":"-100%"}, 300);
      }
    }
  });

  /** trida close */
  $(document).ready(function(event){
    $(".close").on("click", function (event) {
      $(".overlay").fadeOut(300);
      $("html").removeClass("overflowhidden");
      $("html, body").removeClass("overflowhiddenfixed");
      $(".modal-handler").fadeOut(300);
      $(".cart-content").removeClass("isIn");
      $(".cart-button").removeClass("open");
      if ($(window).width() < 540) {
        $(".cart-content").animate({"right":"-100%"}, 300);
      }
    });
  });

  /** scroll top */
  $(document).ready(function(event){
    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
      if ($(window).scrollTop() > 600) {
        $(".scrollToTop").fadeIn();
      } else {
        $(".scrollToTop").fadeOut();
      }
    });
    //Click event to scroll to top
    $(".scrollToTop").click(function(){
      $("html, body").animate({scrollTop : 0},800);
      return false;
    });

  /** Menu smaller  */
    if ($(window).width() > 1024) {
      $(window).scroll(function(event){
          var sticky = $("nav");
              scroll = $(window).scrollTop();
          if (scroll >= 120) sticky.addClass("fixed");
          else sticky.removeClass("fixed");
      });
    }

  /** spinner button */
    $(".spinner-spin").on("click", function (event) {
      $(this).parent().toggleClass("open");
      event.stopPropagation();
        $("nav").click(function(event){
          event.stopPropagation();
        });
      var $nav = $("nav");
      $nav.toggleClass("isIn");
      var isIn = $nav.hasClass("isIn");
      $nav.animate({left: isIn ? "0" : "-300px"}, 300);
    });

  /** Menu-button add class */
    $(".spinner-master input").change(function(){
      if($(this).is(":checked")) {
        $("html").addClass("overflowhidden");
      } else {
        $("html").removeClass("overflowhidden");
      }
    });

  /** CART click responsive */
    if ($(window).width() < 520) {
      $(".cart-button").on("click", function (event) {
        $(this).toggleClass("open");
        event.stopPropagation();
        $(".cart-content").click(function(event){
          event.stopPropagation();
        });
        var $cart = $(".cart-content");
        $cart.toggleClass("isIn");
        var isIn = $cart.hasClass("isIn");
        $cart.animate({right: isIn ? "0" : "-100%"}, 300);
      });
    }

  /** LOGIN */
    $(".login-button").on("click", function (event) {
      $(this).toggleClass("open");
      event.stopPropagation();
      $(".modal-content").click(function(event){
        event.stopPropagation();
      });
      $(".login-handler").css("display", "flex").animate({opacity: 1}, 300);
      $("html").addClass("overflowhiddenfixed");
      $(".overlay").fadeIn(300);
    });

  /** LUPA */
    $(".search-button").on("click", function (event) {
      $(this).toggleClass("open");
      event.stopPropagation();
      $(".search-content").click(function(event){
        event.stopPropagation();
      });
      $(".search-content").slideToggle(300);
      $(".search-content input").focus();
    });

    /** footer click */
    if ($(window).width() < 768) {
      $("footer h5").on("click", function (event) {
        var $this = $(this);
        $("footer h5").not($this).removeClass("active");
        $(this).toggleClass("active");
        var $that = $(this).next("ul");
        $("footer ul").not($that).hide();
        $that.fadeToggle("fast");
      });
    }
  });

}(jQuery));
