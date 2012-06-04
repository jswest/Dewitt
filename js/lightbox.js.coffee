$ ->
  
  window.lightbox = () ->  
    c = $('#content-wrapper')
    imgs = c.find('img')
    lg = $('#lightbox-gloss')
    liw = $('#lightbox-image-wrapper')
    t = $('h2#lightbox-title')
    y = $('h2#lightbox-year')
    m = $('#lightbox-materials')
    
    
    
    size_imgs = () ->
      bimg = liw.find('img')
      bimgw = bimg.width()
      bimgh = bimg.height()
      wr = bimgw / bimgh
      hr = bimgh / bimgw
      
      resize = () ->
        ww = $(window).width()
        wh = $(window).height() - 60
        if bimgw / bimgh > ww / wh
          bimg.width( ww )
          bimg.height( ww * ( bimgh / bimgw ) )
        else
          bimg.height( wh )
          bimg.width( wh * ( bimgw / bimgh ) )
        bimg.parent().css(
          'margin-top': -(bimg.height() / 2) - 30
          'margin-left': -(bimg.width() / 2)
        )
      
      resize()
      
      $(window).resize ->
        resize()
    
    
    
    
    lg.click ->
      liw.hide(
        0
        ->
          liw.find('img').remove()
          lg.hide( 0 )
      )
    
    imgs.click ->
      img = $(this)

      img_src = img.attr('src')
      img_real_index = img_src.search( '_' ) + 1
      img_real = img_src.substring( img_real_index, img_src.length )
      img_real = "images/" + img_real
      
      lg.show(
        0
        ->
          liw.show(
            0
            ->
              liw.append("<img src='#{img_real}' id='big'>")
              $('img#big').load ->
                size_imgs()
                t.html( img.data('title') )
                y.html('')
                y.html( img.data('year') )
                m.find('p').html('')
                m.find('p').html( img.data('materials') )
                $(this).fadeIn(
                  500
                )
                
          )
      )
      
      