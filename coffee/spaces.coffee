# -*- coffee-tab-width: 4 -*-

(($) ->

    wuas = null
    file_number = -1
    codex_struct = {}
    file_struct = {}
    cb = []

    window.loadData = (file) ->
        file_number = file
        $.ajax
            url: "../wuas_codex.json"
            dataType: "json"
            success: (data) ->
                codex_struct = data
                fillInFooter()
                initFileStruct()

    initFileStruct = () ->
        file_struct = codex_struct.dicts[file_number]
        $.ajax
            url: file_struct.json
            dataType: "json"
            success: (data, _0, _1) ->
                wuas = data
                # Backward compatibility
                wuas.attributes = {} unless wuas.attributes
                $("#wuas-space-map").html """
                    <img src="#{file_struct.spaces}" usemap="#spaces-map" />
                    <map name="spaces-map" id="spaces-map">
                    </map>
                """
                setupSpaceMap()
                listOutValsWithNames wuas.items, $("#wuas-items")
                listOutValsWithNames wuas.attributes, $("#wuas-attributes")
                if wuas.captures
                    $("#wuas-captures-project-div").removeClass "hidden-project"
                    listOutValsWithNames wuas.captures, $("#wuas-captures")
                listOutWithNames wuas.effects, $("#wuas-effects")
                listOutWithEntry wuas.tokens, $("#wuas-tokens")
                listOut wuas.rulings, $("#wuas-rulings")
                $("#search-field").bind "change input keyup paste", ->
                    window.updateSearch 'wuas-search-results', 'search-field'
                f() for f in cb

    spaceMapLine = (key, data) ->
        area = $("<area/>")
        area.attr "coords", data.coords
        area.attr "href", "javascript:void(0)"
        area.on "click", (e) ->
            e.preventDefault()
            window.putEffectText $("#space-effect-text"), key
        $("#spaces-map").append area

    setupSpaceMap = ->
        spaceMapLine(key, value) for key, value of wuas.spaces

    listOut = (list, jqObj) ->
        ul = $("<ul></ul>")
        ul.append $("<li>#{obj.desc}</li>") for obj in list
        jqObj.html ''
        jqObj.append ul

    listOutWithNames = (list, jqObj) ->
        dl = $("<dl></dl>")
        dl.append $("<dt><b>#{obj.name}</b></dt><dd>#{obj.desc}</dd>") for obj in list
        jqObj.html ''
        jqObj.append dl

    listOutValsWithNames = (list, jqObj) ->
        dl = $("<dl></dl>")
        dl.append $("<dt><b>#{obj.name}</b></dt><dd>#{obj.desc}</dd>") for key, obj of list
        jqObj.html ''
        jqObj.append dl

    listOutWithEntry = (list, jqObj) ->
        dl = $("<dl></dl>")
        for key, obj of list
            name = ""
            if obj.thumbnail?
                xpos = - obj.thumbnail[0]
                ypos = - obj.thumbnail[1]
                spanx = 1
                spany = 1
                if 'span' of obj
                    spanx = obj.span[0]
                    spany = obj.span[1]
                spanx *= 16
                spany *= 16
                name = """
                    <div style='width: #{spanx}px; height: #{spany}px;
                        background-image: url("#{file_struct.tokens}");
                        background-position: #{xpos}px #{ypos}px; display: inline-block' />
                    <b>#{obj.name}</b>
                """
            dl.append $("<dt>#{name} <i>(#{obj.stats})</i></dt><dd>#{obj.desc}</dd>")
        jqObj.html ''
        jqObj.append dl

    window.putEffectText = (jqObj, id) ->
        if wuas?
            spaces = wuas.spaces
            name = spaces[id].name
            visual = spaces[id].visual
            desc = spaces[id].desc
            str = """
                <b>#{name}</b> <i>(#{visual})</i><br/>
                <blockquote>#{desc}</blockquote>
            """
            jqObj.html str

    window.updateSearch = (divId, textId) ->
        tokenDescriptor = (token) ->
            thumbnail = ""
            if token.thumbnail?
                xpos = - token.thumbnail[0]
                ypos = - token.thumbnail[1]
                thumbnail = """
                    <div style='width: 16px; height: 16px;
                        background-image: url("#{file_struct.tokens}");
                        background-position: #{xpos}px #{ypos}px; display: inline-block' />
                    """
            "<dt>#{thumbnail}<b>#{token.name}</b> <i>(#{token.stats})</i></dt><dd>#{token.desc}</dd>"
        divField = $("##{divId}")
        textField = $("##{textId}")
        text = textField.val().toLowerCase()
        if wuas?
            results = []
            results.push "<dt><b>#{space.name}</b> <i>(#{space.visual})</i></dt><dd>#{space.desc}</dd>" \
                for key, space of wuas.spaces when space.name.toLowerCase().includes text
            results.push "<dt><b>#{item.name}</b></dt><dd>#{item.desc}</dd>" \
                for key, item of wuas.items when item.name.toLowerCase().includes text
            results.push "<dt><b>#{effect.name}</b></dt><dd>#{effect.desc}</dd>" \
                for effect in wuas.effects when effect.name.toLowerCase().includes text
            results.push tokenDescriptor(token) \
                for key, token of wuas.tokens when token.name.toLowerCase().includes text
            results.push "<dt><b>#{attribute.name}</b></dt><dd>#{attribute.desc}</dd>" \
                for key, attribute of wuas.attributes when attribute.name.toLowerCase().includes text
            if results.length > 10
                divField.html "Please narrow your search."
            else if results.length == 0
                divField.html "No results found."
            else
                dl = $("<dl></dl>")
                for result in results
                    dl.append $(result)
                divField.html ''
                divField.append dl
        else
            divField.html "Please wait..."

    window.wuas = ->
        wuas

    window.wuasCallback = (f) ->
        cb.push f

    window.fileStruct = ->
        file_struct

    window.fillInFooter = ->
        tag_current = "an unknown dictionary"
        tag_old = "an unknown dictionary"
        tag_link = "here"
        files = for data, i in codex_struct.dicts
            if file_number == i
                data.name
            else
                "<a href='index.php?file=#{i}'>#{data.name}</a>"
        list_data = ("<li>#{curr}</li>" for curr in files)
        $("#wuas-footer-tagline").html """
            Available Game Dictionaries
            <ul>
                #{list_data.join "\n"}
            </ul>
        """

    window.fillInHeader = ->
        text = "Wish Upon A Star - #{codex_struct.dicts[file_number].name}"
        $("#file-header").html """
            <em>
                Currently viewing: #{text}
            </em>
        """

    window.getCodexDict = (n = file_number) ->
        codex_struct.dicts[n]

    window.fileCount = ->
        codex_struct.dicts.length

) jQuery
