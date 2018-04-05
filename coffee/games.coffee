# -*- coffee-tab-width: 4 -*-

(($) ->

    games = null
    predFunction = null
    cmpFunction = null

    $ ->
        $.ajax
            url: "games.json"
            dataType: "json"
            success: (data, _0, _1) ->
                games = data
                setDefaults()

    compareStrings = (x, y) ->
        switch
            when x > y then 1
            when x < y then -1
            else 0

    compareNames = (x, y) ->
        compareStrings x.name, y.name

    showTable = ->
        pred = predFunction
        cmp = cmpFunction
        arr = games.games[..].filter pred
        arr.sort cmp
        str = """
            <tr class='rowhead'>
                <th>Name</th>
                <th>Author(s)</th>
                <th>Genre</th>
                <th>Summary</th>
                <th>Finish Date</th>
                <th>Link</th>
            </tr>
        """
        parity = 'even'
        for game in arr
            finish = "#{game.finished[0]}/#{game.finished[1]}"
            parity = switch parity
                     when 'even' then 'odd'
                     when 'odd' then 'even'
                     else 'odd'
            str += """
                <tr class='row#{parity}'>
                    <td class='column cname'>#{game.name}</td>
                    <td class='column cauthor'>#{game.author}</td>
                    <td class='column cgenre'>#{game.genre}</td>
                    <td class='column csummary'>#{game.summary}</td>
                    <td class='column cfinish'>#{finish}</td>
                    <td class='column cpage'>
                        <a href='#{game.page}' target='new'>Link</a>
                    </td>
                </tr>
            """
        $("table#games-table").html str

    setDefaults = ->
        cmpFunction = compareNames
        showAll()

    showAll = ->
        predFunction = (_0) -> true
        showTable()

    showGenre = (regexp) ->
        predFunction = (obj) -> obj.genre.match regexp
        showTable()

    showOccasion = (occasion) ->
        predFunction = (obj) -> obj.occasion == occasion
        showTable()

    sortByName = ->
        cmpFunction = compareNames
        showTable()

    sortByDate = ->
        cmpFunction = (x, y) ->
            [x0, y0] = [x.finished, y.finished]
            switch
                when x0[1] > y0[1] then -1
                when x0[1] < y0[1] then 1
                when x0[0] > y0[0] then -1
                when x0[0] < y0[0] then 1
                else 0
        showTable()

    window.showAll = showAll
    window.showGenre = showGenre
    window.showOccasion = showOccasion
    window.sortByName = sortByName
    window.sortByDate = sortByDate

) jQuery
