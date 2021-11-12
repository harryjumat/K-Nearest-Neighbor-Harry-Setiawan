  $(document).ready(function() {
    $('.carousel .carousel-caption').css('zoom', $('.carousel').width()/1000);
  });

  $(window).resize(function() {
    $('.carousel .carousel-caption').css('zoom', $('.carousel').width()/1000);
  });