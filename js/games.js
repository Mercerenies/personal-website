// Generated by CoffeeScript 1.9.3
(function() {
  (function($) {
    var cmpFunction, compareNames, compareStrings, games, predFunction, setDefaults, showAll, showGenre, showOccasion, showTable, sortByDate, sortByName;
    games = null;
    predFunction = null;
    cmpFunction = null;
    $(function() {
      return $.ajax({
        url: "games.json",
        dataType: "json",
        success: function(data, _0, _1) {
          games = data;
          return setDefaults();
        }
      });
    });
    compareStrings = function(x, y) {
      switch (false) {
        case !(x > y):
          return 1;
        case !(x < y):
          return -1;
        default:
          return 0;
      }
    };
    compareNames = function(x, y) {
      return compareStrings(x.name, y.name);
    };
    showTable = function() {
      var arr, cmp, finish, game, i, len, parity, pred, str;
      pred = predFunction;
      cmp = cmpFunction;
      arr = games.games.slice(0).filter(pred);
      arr.sort(cmp);
      str = "<tr class='rowhead'>\n    <th>Name</th>\n    <th>Author(s)</th>\n    <th>Genre</th>\n    <th>Summary</th>\n    <th>Finish Date</th>\n    <th>Link</th>\n</tr>";
      parity = 'even';
      for (i = 0, len = arr.length; i < len; i++) {
        game = arr[i];
        finish = game.finished[0] + "/" + game.finished[1];
        parity = (function() {
          switch (parity) {
            case 'even':
              return 'odd';
            case 'odd':
              return 'even';
            default:
              return 'odd';
          }
        })();
        str += "<tr class='row" + parity + "'>\n    <td class='column cname'>" + game.name + "</td>\n    <td class='column cauthor'>" + game.author + "</td>\n    <td class='column cgenre'>" + game.genre + "</td>\n    <td class='column csummary'>" + game.summary + "</td>\n    <td class='column cfinish'>" + finish + "</td>\n    <td class='column cpage'>\n        <a href='" + game.page + "' target='new'>Link</a>\n    </td>\n</tr>";
      }
      return $("table#games-table").html(str);
    };
    setDefaults = function() {
      cmpFunction = compareNames;
      return showAll();
    };
    showAll = function() {
      predFunction = function(_0) {
        return true;
      };
      return showTable();
    };
    showGenre = function(regexp) {
      predFunction = function(obj) {
        return obj.genre.match(regexp);
      };
      return showTable();
    };
    showOccasion = function(occasion) {
      predFunction = function(obj) {
        return obj.occasion === occasion;
      };
      return showTable();
    };
    sortByName = function() {
      cmpFunction = compareNames;
      return showTable();
    };
    sortByDate = function() {
      cmpFunction = function(x, y) {
        var ref, x0, y0;
        ref = [x.finished, y.finished], x0 = ref[0], y0 = ref[1];
        switch (false) {
          case !(x0[1] > y0[1]):
            return -1;
          case !(x0[1] < y0[1]):
            return 1;
          case !(x0[0] > y0[0]):
            return -1;
          case !(x0[0] < y0[0]):
            return 1;
          default:
            return 0;
        }
      };
      return showTable();
    };
    window.showAll = showAll;
    window.showGenre = showGenre;
    window.showOccasion = showOccasion;
    window.sortByName = sortByName;
    return window.sortByDate = sortByDate;
  })(jQuery);

}).call(this);
