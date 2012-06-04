$ ->
  window.slider = () ->
    $('div#secondary-menu-wrapper').addClass('bindings-set')
    current_location = 0
    $('.control').mouseover ->
      mouse_over = true
      $('.control').mouseout ->
        mouse_over = false
      scroll_up = () ->
        if current_location <= 0 and current_location >= -$('ul#secondary-menu').height() + 403
          current_location -= 5
          $('ul#secondary-menu').animate(
            'margin-top': current_location
            1
          )
          if mouse_over
            setTimeout =>
              scroll_up()
            , 1
        else
          clearTimeout()
        
      scroll_down = () ->
        if current_location < 0
          current_location +=5
          console.log "#{current_location}"
          $('ul#secondary-menu').animate(
            'margin-top': current_location
            1
          )
          if mouse_over
            setTimeout =>
              scroll_down()
            , 1
          else
            clearTimeout()
               
      
      if $(this).attr( 'id' ) is 'up-control'  
        scroll_up()
      else if $(this).attr( 'id' ) is 'down-control'
        scroll_down()
      else
        console.log "something has gone very, very wrong."
          