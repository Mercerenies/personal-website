
(($) ->

    window.doShow = (x) ->
        if window.shown x
            window.hideOne x
        else
            window.showOne x

    window.hideAll = ->
        $(".project-contents").css 'display', 'none'

    window.hideOne = (x) ->
        $("##{x}").css 'display', 'none'

    window.showOne = (x) ->
        $("##{x}").css 'display', 'block'

    window.shown = (x) ->
        ($("##{x}").css 'display') != 'none'

) jQuery
