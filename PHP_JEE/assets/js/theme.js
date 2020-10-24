  jQuery(function ($) {
    $(window).on('load',function() {
      $(".se-pre-con").fadeOut("slow")
    });

    $(document).ready(function() {
      $(".se-pre-con").fadeOut("slow")
    });
  // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function() {
      if ($(window).width() < 600) {
          $('.sidebar .collapse').collapse('hide');
      };
    });

    $(window).resize(function() {
      if ($(this).width() < 800) {
        if($(".sidebar-toggled").html()==undefined)
        $("#sidebarToggle").trigger('click');
        //do something
      }else{
        if($(".sidebar-toggled").html()!=undefined)
          $("#sidebarToggle").trigger('click');
      }
    });

    if ($(window).width() < 800) {
      if($(".sidebar-toggled").html()==undefined)
        $("#sidebarToggle").trigger('click');
      //do something
    }else{
      if($(".sidebar-toggled").html()!=undefined)
        $("#sidebarToggle").trigger('click');
    }
  /*
  */
    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
      if ($(window).width() > 768) {
        var e0 = e.originalEvent,
          delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
      }
    });

    // Scroll to top button appear
    $(document).on('scroll', function() {
      var scrollDistance = $(this).scrollTop();
      if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
      } else {
        $('.scroll-to-top').fadeOut();
      }
    });

    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function(e) {
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
      }, 1000, 'easeInOutExpo');
      e.preventDefault();
    });

      $(document).on('click', '.dropdown-menu', function (e) {
          e.stopPropagation();
      });

// make it as accordion for smaller screens
      if ($(window).width() < 992) {
          $('.dropdown-menu a').click(function(e){
              /*e.preventDefault();
              if($(this).next('.submenu').length){
                  $(this).next('.submenu').toggle();
              }
              $('.dropdown').on('hide.bs.dropdown', function () {
                  $(this).find('.submenu').hide();
              })*/
          });
      }

  }); // End of use strict
