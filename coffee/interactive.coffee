# -*- coffee-tab-width: 4 -*-

(($) ->

    file = 2
    current_turn = -1
    active_turn = -1
    zaxis = 0
    leaflet = true

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
            when 0 then ""
            when 1 then "n"
            when 2 then "z"

    setupMenus = ->
        turn = window.getActiveTurn()

        doZoomElem = (zz) ->
            norm = (zz == "On")
            if leaflet == norm
                "#{zz}"
            else
                "<a href='interactive.php?zoom=#{norm}&file=#{file}&turn=#{turn}&z=#{zaxis}'>#{zz}</a>"
        doFileElem = (ff) ->
            if "#{file}" == "#{ff}"
                "#{ff}"
            else
                "<a href='interactive.php?zoom=#{leaflet}&file=#{ff}'>#{ff}</a>"
        doTurnElem = (tt) ->
            if "#{turn}" == "#{tt}"
                "#{turn}"
            else
                "<a href='interactive.php?zoom=#{leaflet}&file=#{file}&turn=#{tt}&z=0'>#{tt}</a>"
        doZElem = (zz) ->
            if "#{zaxis}" == "#{zz}"
                "#{zz}"
            else
                "<a href='interactive.php?zoom=#{leaflet}&file=#{file}&turn=#{turn}&z=#{zz}'>#{zz}</a>"
        zooms = (doZoomElem(zz) for zz in ["On", "Off"])
        $("#zoom-menu").html "Zoom = #{zooms.join ' | '}"
        files = (doFileElem(ff) for ff in [0, 1, 2])
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
        window.fillInHeader()
        turn = window.getActiveTurn()
        div = $("#interactive-content")
        suffix = "_#{zaxis}"
        suffix = "" if zaxis == 0
        id = null
        div.html """
            <div id="image-map">
            </div>
            <div id="int-space" style="min-height:4em"></div>
            <div id="int-token" style="min-height:10em"></div>
        """
        map = null
        url = "#{filePrefix()}turn#{turn}#{suffix}.png"
        img = $("<img id='game-map' />")
        bounds = null
        loaded = false
        if leaflet
            map = L.map 'image-map',
                minZoom: 1,
                maxZoom: 4,
                center: [0, 0],
                zoom: 3,
                crs: L.CRS.Simple
            img.attr('src', url)
            $('#image-map').css('width', '640px')
            $('#image-map').css('height', '480px')
            $('#image-map').css('border', '1px solid')
            img.on 'load', ->
                bounds = new L.LatLngBounds(
                    map.unproject([0, img[0].height], map.getMaxZoom() - 1),
                    map.unproject([img[0].width,  0], map.getMaxZoom() - 1))
                loaded = true
                L.imageOverlay(url, bounds).addTo(map)
                map.setMaxBounds(bounds)
            id = "#image-map"
        else
            $("#image-map").html """
                <img id='game-map' src=#{url} />
            """
            id = "#image-map"
        $(id).mousemove (e) ->
            rel_x1 = null
            rel_y1 = null
            spaces = window.thisTurnData().spaces
            if leaflet
                return unless loaded
                offset = $('.leaflet-image-layer').offset()
                rel_x = e.pageX - offset.left
                rel_y = e.pageY - offset.top
                rel_x1 = rel_x * img[0].width / $('.leaflet-image-layer')[0].width
                rel_y1 = rel_y * img[0].height / $('.leaflet-image-layer')[0].height
            else
                offset = $(this).offset()
                rel_x1 = e.pageX - offset.left
                rel_y1 = e.pageY - offset.top
            x0 = Math.floor(rel_x1 / 32)
            y0 = Math.floor(rel_y1 / 32)
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
                dist_x = rel_x1 - obj.position[0]
                dist_y = rel_y1 - obj.position[1]
                if 0 <= dist_x < 16 and 0 <= dist_y < 16
                    if window.wuas().tokens[obj.object]?
                        token_data += tokenDescriptor window.wuas().tokens[obj.object]
                    else if window.wuas().items[obj.object]?
                        token_data += itemDescriptor window.wuas().items[obj.object]
            $("#int-token").html "<dl>#{token_data}</dl>"

    window.getActiveTurn = ->
        if active_turn == -1 then current_turn else active_turn

    window.setActiveTurn = (f, x, y, z) ->
        file = f
        active_turn = x
        zaxis = y
        leaflet = !!z

    window.thisTurnSansZ = ->
        turn = window.getActiveTurn()
        window.wuas().turns["#{turn}"]

    window.thisTurnData = ->
        turn = window.getActiveTurn()
        window.wuas().turns["#{turn}"]["#{zaxis}"]

) jQuery
