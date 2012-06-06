$ ->
  ul = $('ul#admin-primary-menu')
  nav = $('nav#admin-primary-nav')
  lis = ul.children('li')
  c = $('#admin-content')
  
  nav_out = () ->
    nav.animate(
      'width': '250px'
      500
      ->
        ul_out()
        nav.removeClass('in')
        nav.addClass('out')
    )
  
  nav_in = () ->
    nav.animate(
      'width': '50px'
      500
      ->
        nav.removeClass('out')
        nav.addClass('in')
        
    )
  
  ul_out = () ->
    ul.slideToggle(
      500
      ->
        ul.removeClass('in')
        ul.addClass('out')
    )
  
  ul_in = () ->
    ul.slideToggle(
      500
      ->
        nav_in()
        ul.removeClass('out')
        ul.addClass('in')
    )
    

  nav.click ->
    if nav.hasClass('out')
      ul_in()
    else if nav.hasClass('in')
      nav_out()
    else
      console.log "something has gone very, very wrong"
      
  lis.click ->
    li = $(this)
    $.ajax(
      dataType: 'html'
      data: {
        table: $(this).data( 'table' )
      }
      url: $(this).data('ajax_url')
      success: ( data ) ->
        $('#admin-content').html('')
        c.html( data )
        if c.hasClass('in')
          c.show()
          c.removeClass('in')
          c.addClass('out')
        ul_in()
        if li.data( 'ajax_url' ) is '_general.php'
          $('ul#general-options').children('li').click ->
            if $(this).data( 'option' ) is 'create-database'
              $.ajax(
                dataType: 'html'
                url: '../db/schema.php'
                success: ( data ) ->
                  $('#admin-content').append( data )
              )
    ) 