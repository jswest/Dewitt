$ ->
    
  $(window).ready ->
    ww = $(window).width()
    wh = $(window).height()
    
    bg = $('#bg')
    bgw = bg.width()
    bgh = bg.height()
    
    
    
    if (wh / ww) < (bgh / bgw)
      bg.width( ww )
      bg.height( ww * (bgh / bgw) )
    else
      bg.height( wh )
      bg.width( wh * (bgw / bgh ) )
      
      
      
    resize_bg = () ->
      ww = $(window).width()
      wh = $(window).height()
      if (wh / ww) < (bgh / bgw)
        bg.width( ww )
        bg.height( ww * (bgh / bgw) )
      else
        bg.height( wh )
        bg.width( wh * (bgw / bgh ) )
    
    
    bg.fadeIn(
      2000
      ->
        $(window).resize ->
          resize_bg()        
      )