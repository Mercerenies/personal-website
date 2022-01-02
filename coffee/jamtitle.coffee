# -*- coffee-tab-width: 4 -*-

(($) ->

    _jamData = null

    WORD2VEC_THRESHOLD = 0.5
    LEVENSHTEIN_CAP = 5

    class Data

        constructor: (@jamWords, @wordDB) ->

        findBestMatch: (word) ->

            # First, an exact match is always 100% confidence
            for candidate of @jamWords
                if word == candidate
                    return new Match(candidate, 1.00)

            # Next, use the word2vec database to find a
            # high-confidence match
            bestMatch = null
            bestConfidence = 0.0
            wordVec = @getWordVec(word)
            for candidate of @jamWords
                candidateVec = @getWordVec(candidate)
                sim = cosSim(wordVec, candidateVec)
                if sim > bestConfidence
                    bestConfidence = sim
                    bestMatch = candidate
            if bestConfidence > WORD2VEC_THRESHOLD
                return new Match(bestMatch, bestConfidence)

            # If that fails, try Levenshtein distance
            bestMatch = null
            bestDist = LEVENSHTEIN_CAP + 1
            for candidate of @jamWords
                dist = levenshtein(candidate, word)
                if dist < bestDist
                    bestMatch = candidate
                    bestDist = dist
            if bestDist <= LEVENSHTEIN_CAP
                levenshteinConfidence = (1.0 - bestDist / LEVENSHTEIN_CAP) / 2 # Max of 0.5 even with perfect
                return new Match(bestMatch, levenshteinConfidence)

            null

        getWordVec: (w) ->
            @wordDB[w] ? Array(300).fill(0.0)

    class Match
        constructor: (@word, @confidence) ->

    class Word

        constructor: (@word, @denom, @score) ->

        @fromLine: (line) ->
            new Word(line.split("\t")...)

    getData = ->
        if _jamData == null

            # Load CSV
            fileContents = await $.ajax
                url: "../jam_data.csv"
                dataType: "text"
            jamWords = Object.fromEntries fileContents.split("\n").map(Word.fromLine).map((x) -> [x.word, x])

            # Load JSON
            wordDB = await $.ajax
                url: "../lib/wordvecs25000.json"
                dataType: "json"
            delete wordDB['__notice__']

            _jamData = new Data(jamWords, wordDB)

        _jamData

    zip = (a, b) ->
        a.map((e, i) -> [e, b[i]])

    dotProd = (a, b) ->
        zip(a, b).map((x) -> x[0] * x[1]).reduce((x, y) -> x + y)

    vecLen = (a) ->
        Math.sqrt dotProd(a, a)

    cosSim = (a, b) ->
        alen = vecLen(a)
        blen = vecLen(b)
        if alen == 0 or blen == 0
            0
        else
            dotProd(a, b) / (alen * blen)

    setProgress = (value) ->
        $("#progress").html value

    normalizeWord = (w) ->
        w.toLowerCase().replaceAll(/[^\w]/g, '')

    # https://en.wikipedia.org/wiki/Levenshtein_distance
    levenshtein = (a, b) ->
        m = a.length
        n = b.length

        d = Array((m+1) * (n+1)).fill(0)

        for i in [1..m]
            d[i * (n+1) + 0] = i

        for j in [1..n]
            d[0 * (n+1) + j] = j

        for j in [1..n]
            for i in [1..m]
                if a[i - 1] == b[j - 1]
                    sCost = 0
                else
                    sCost = 1
                d[i * (n+1) + j] = Math.min(
                    d[(i - 1) * (n+1) + j] + 1, # Deletion
                    d[i * (n+1) + (j - 1)] + 1, # Insertion
                    d[(i - 1) * (n+1) + (j - 1)] + sCost, # Substitution
                )
        d[m * (n+1) + n]

    runAlgorithm = (text) ->
        setProgress "Getting Jam data ..."
        fullData = await getData()

        setProgress "Processing ..."
        tokenized = text.split(/\s+/).map(normalizeWord)

        bestMatches = tokenized.map((w) -> fullData.findBestMatch(w))
        console.log(tokenized)
        console.log(bestMatches)

        setProgress "Done."

    $ ->

        $("#rank-my-title").click ->
            text = $("#title-box").val()
            runAlgorithm(text)

        $('#title-box').keypress (e) ->
            key = e.which
            if key == 13
                $('#rank-my-title').click()
                false
            true

) jQuery
