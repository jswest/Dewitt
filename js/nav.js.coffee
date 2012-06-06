$ ->
  
  # DEFINE YO' VARIABLES
  n = $('nav#primary-nav')
  h = $('header#primary-header')
  ul = $('ul#primary-menu')
  lis = ul.children('li')
  c = $('#content-wrapper')
  l = $('#line')
  proj = $('li#projects')
  sm = $('#secondary-menu-wrapper')
  slis = sm.find('li')

  
  # DEFINE YO' FUNCTIONS!
  sm_in = () ->
    sm.slideToggle(
      500
      ->
        sm.removeClass( 'out' )
        sm.addClass( 'in' )
    )
  
  sm_out = () ->
    sm.slideToggle(
      500
      ->
        sm.removeClass( 'in' )
        sm.addClass( 'out' )
        window.slider() unless sm.hasClass( 'bindings-set' )
    )

  n_in = () ->
    sm_in() if sm.hasClass( 'out' )
    ul.slideToggle(
      500
      ->
        n.animate(
          'width': '50px'
          500
          ->
            n.removeClass('out')
            n.addClass('in')
          )
    )
    
  n_out = () ->
    n.animate(
      'width': '250px'
      500
      ->
        ul.slideToggle(
          500
          ->
            n.removeClass('in')
            n.addClass('out')
          )
    )
    
  c_in = () ->
    c.slideToggle(
      500
      ->
        l.animate(
          'width': 0
          500
          ->
            c.removeClass('out')
            c.addClass('in')
        )
    )
    
  c_out = () ->
    l.animate(
      'width': ( ( $(window).width() - 800 ) / 2 ) + 800
      500
      ->
        c.slideToggle(
          500
          ->
            c.removeClass('in')
            c.addClass('out')
        )
    )

  
  # SET THE BINDINGS FOR THE NAV CLICK      
  n.click ->
    h.fadeOut( 500 )
    if n.hasClass('in') and c.hasClass('out')
      n_out()
      c_in()
    else if n.hasClass('in') and c.hasClass('in')
      n_out()
    else if n.hasClass('out') and c.hasClass('in')
      n_in()
    else
      console.log "Something has gone very, very wrong. Really."

    
  # SET THE AJAX BINDINGS ON THE LIS
  ajax_in = () ->
    lis.click ->
      c.html('')
      li = $(this)
      if li.data('ajaxable')
        $.ajax(
          dataType: 'html'
          data: {
            'table': li.data( 'table' )
            'id': li.data( 'id' )
          }
          url: "_#{li.data('table')}.php"
          success: ( data ) ->
            c.html( data )
            c_out()
            n_in()
            window.lightbox()
        )
      else if not li.data('ajaxable')
        if sm.hasClass('in')
          sm_out()
        else if sm.hasClass('out')
          sm_in()
        else
          console.log "something has gone very, very wrong."
      else
        console.log "something has gone very, very wrong."
    slis.click ->
      li = $(this)
      $.ajax(
        dataType: 'html'
        data: {
          'table': li.data( 'table' )
          'id': li.data( 'id' )
        }
        url: "_#{li.data('table')}.php"
        success: ( data ) ->
          c.html( data )
          n_in()
          c_out()
      )

  ajax_in()
