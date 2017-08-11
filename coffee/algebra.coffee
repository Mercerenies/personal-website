
(($) ->

    structs = null
    redirecting = false

    desymbolify = [
        [/&Omega;/g, 'Omega']
        [/&omega;/g, 'omega']
    ]

    $ ->
        $(window).bind 'popstate', (event) ->
            redirecting = true
            window.doRender event.originalEvent.state.key
        $.ajax
            url: "../algebra.json"
            dataType: "json"
            success: (data, _0, _1) ->
                structs = data
                window.doRender window.structureCommand

    window.doList = ->
        lines = (value for value of structs)
        l0 = []
        for line in lines
            l0.push [structs[line].name, """
                <li>
                    <a href='javascript:void(0)' onclick='window.doRender(\"#{line}\")'>
                        #{structs[line].name}
                    </a>
                </li>
            """]
            for alt in structs[line].alt ? []
                l0.push [alt, """
                    <li>
                        <a href='javascript:void(0)' onclick='window.doRender(\"#{line}\")'>
                            #{alt}
                        </a>
                    </li>
                """]
        l0.sort (x, y) ->
            x[0].localeCompare y[0]
        l0 = l0.map (x) -> x[1]
        text = """
            <ul>#{l0.join ''}</ul>
            <div>
                <a href="index.php">
                    Back to Algebra
                </a>
            </div>
        """
        $("#map-contents").html text

    window.doRender = (str) ->
        if str == "list"
            window.doList()
        else
            struct = structs[str]
            links = ""
            for link in struct.links
                links += """
                    <li>
                        <a href='#{link}'>#{link}</a>
                    </li>
                """
            links = "<ul>#{links}</ul>"
            edges = ""
            for edge in struct.edges
                edges += """
                    <li>
                        #{edge.algebra} =
                            <a href='javascript:void(0)' onclick='window.doRender(\"#{edge.result}\")'>
                                #{structs[edge.result].name}
                            </a>
                    </li>
                """
            edges = "<ul>#{edges}</ul>"
            props = ""
            for prop in struct.props
                props += """
                    <li>
                        #{prop}
                    </li>
                """
            if props == ""
                props = "<li>(No additional properties)</li>"
            props = "<ul>#{props}</ul>"
            examples = ""
            if struct.examples?
                for example in struct.examples
                    examples += """
                        <li>
                            #{example}
                        </li>
                    """
                examples = "<b>Examples</b><ul>#{examples}</ul>"
            alt_names = ""
            if struct.alt?
                alt_names = "<div><small><i>(Also called #{struct.alt.join ', '})</i></small></div>"
            alternatives = ""
            if struct.form?
                for form in struct.form
                    alternatives += """
                        <p>
                            #{form}
                        </p>
                    """
            text = """
                <h1>#{struct.name}</h1>
                #{alt_names}
                <p>
                    #{struct.tagline}
                    #{props}
                </p>
                #{alternatives}
                #{examples}
                <br/>
                <b>Related Structures</b>
                #{edges}
                <b>Further Links</b>
                #{links}
                <br/>
                <a href='javascript:void(0)' onclick='window.doRender(\"list\")'>Back to List</a>
            """
            $("#map-contents").html text
        if struct?
            new_title = "Mercerenies - #{struct.name}"
        else
            new_title = "Mercerenies - Algebra"
        for reg in desymbolify
            new_title = new_title.replace reg[0], reg[1]
        document.title = new_title
        if redirecting
            redirecting = false
        else
            window.history.pushState { key: str }, new_title, "map.php?struct=#{str}";
        MathJax.Hub.Queue ["Typeset", MathJax.Hub, "map-contents"]

) jQuery
