
(($) ->

    file = 1
    current_turn = -1
    active_turn = -1
    zaxis = 0

    $ ->
        window.wuasCallback ->
            current_turn = window.wuas().current_turn
            if window.thisTurnData()?
                loadEverything()
            else
                $("#interactive-content").html """
                    <h1>Oops!</h1>
                    <blockquote>
                        Turn #{window.getActiveTurn()} is not available. Please go back and
                        select another turn.
                    </blockquote>
                """

    filePrefix = ->
        switch file
            when 0 then "n"
            when 1 then ""

    setupMenus = ->
        turn = window.getActiveTurn()

        doFileElem = (ff) ->
            if "#{file}" == "#{ff}"
                "#{ff}"
            else
                "<a href='interactive.php?file=#{ff}'>#{ff}</a>"
        doTurnElem = (tt) ->
            if "#{turn}" == "#{tt}"
                "#{turn}"
            else
                "<a href='interactive.php?file=#{file}&turn=#{tt}&z=0'>#{tt}</a>"
        doZElem = (zz) ->
            if "#{zaxis}" == "#{zz}"
                "#{zz}"
            else
                "<a href='interactive.php?file=#{file}&turn=#{turn}&z=#{zz}'>#{zz}</a>"
        files = (doFileElem(ff) for ff in [0, 1])
        $("#file-menu").html "File = #{files.join ' | '}"
        turns = (doTurnElem(tt) for tt, _contents of window.wuas().turns when tt <= current_turn)
        $("#turn-menu").html "Turn = #{turns.join ' | '}"
        zaxes = (doZElem(zz) for zz, _contents of window.thisTurnSansZ())
        $("#axis-menu").html "Z = #{zaxes.join ' | '}"

    loadEverything = ->
        tokenDescriptor = (token) ->
            thumbnail = ""
            if token.thumbnail?
                xpos = - token.thumbnail[0]
                ypos = - token.thumbnail[1]
                thumbnail = "<div style='width: 16px; height: 16px; background-image: url(\"#{window.fileStruct().tokens}\");"
                thumbnail = "#{thumbnail} background-position: #{xpos}px #{ypos}px; display: inline-block' /> "
            "<dt>#{thumbnail}<b>#{token.name}</b> <i>(#{token.stats})</i></dt><dd>#{token.desc}</dd>"
        itemDescriptor = (item) ->
            "<dt><b>#{item.name}</b></dt><dd>#{item.desc}</dd>"
        setupMenus()
        turn = window.getActiveTurn()
        div = $("#interactive-content")
        suffix = "_#{zaxis}"
        suffix = "" if zaxis == 0
        div.html """
            <img src="#{filePrefix()}turn#{turn}#{suffix}.png" id="game-map" />
            <div id="int-space" style="min-height:4em"></div>
            <div id="int-token" style="min-height:10em"></div>
        """
        $("#game-map").mousemove (e) ->
            offset = $(this).offset()
            rel_x = e.pageX - offset.left
            rel_y = e.pageY - offset.top
            spaces = window.thisTurnData().spaces
            x0 = Math.floor(rel_x / 32)
            y0 = Math.floor(rel_y / 32)
            now = spaces
            now &&= now[y0]
            now &&= now[x0]
            if now?
                the_space = window.wuas().spaces[now]
                $("#int-space").html """
                    <dl>
                        <dt><b>#{the_space.name}</b> <i>(#{the_space.visual})</i></dt>
                        <dd>#{the_space.desc}</dd>
                    </dl>
                """
            else
                $("#int-space").html ""
            token_data = ""
            for obj in window.thisTurnData().tokens
                dist_x = rel_x - obj.position[0]
                dist_y = rel_y - obj.position[1]
                if 0 <= dist_x < 16 and 0 <= dist_y < 16
                    if window.wuas().tokens[obj.object]?
                        token_data += tokenDescriptor window.wuas().tokens[obj.object]
                    else if window.wuas().items[obj.object]?
                        token_data += itemDescriptor window.wuas().items[obj.object]
            $("#int-token").html "<dl>#{token_data}</dl>"

    window.getActiveTurn = ->
        if active_turn == -1 then current_turn else active_turn

    window.setActiveTurn = (f, x, y) ->
        file = f
        active_turn = x
        zaxis = y

    window.thisTurnSansZ = ->
        turn = window.getActiveTurn()
        window.wuas().turns["#{turn}"]

    window.thisTurnData = ->
        turn = window.getActiveTurn()
        window.wuas().turns["#{turn}"]["#{zaxis}"]

) jQuery
