// Generated by CoffeeScript 1.9.3
(function() {
  (function($) {
    var active_turn, current_turn, file, filePrefix, loadEverything, setupMenus, zaxis;
    file = 1;
    current_turn = -1;
    active_turn = -1;
    zaxis = 0;
    $(function() {
      return window.wuasCallback(function() {
        current_turn = window.wuas().current_turn;
        if (window.thisTurnData() != null) {
          return loadEverything();
        } else {
          return $("#interactive-content").html("<h1>Oops!</h1>\n<blockquote>\n    Turn " + (window.getActiveTurn()) + " is not available. Please go back and\n    select another turn.\n</blockquote>");
        }
      });
    });
    filePrefix = function() {
      switch (file) {
        case 0:
          return "n";
        case 1:
          return "";
      }
    };
    setupMenus = function() {
      var _contents, doFileElem, doTurnElem, doZElem, ff, files, tt, turn, turns, zaxes, zz;
      turn = window.getActiveTurn();
      doFileElem = function(ff) {
        if (("" + file) === ("" + ff)) {
          return "" + ff;
        } else {
          return "<a href='interactive.php?file=" + ff + "'>" + ff + "</a>";
        }
      };
      doTurnElem = function(tt) {
        if (("" + turn) === ("" + tt)) {
          return "" + turn;
        } else {
          return "<a href='interactive.php?file=" + file + "&turn=" + tt + "&z=0'>" + tt + "</a>";
        }
      };
      doZElem = function(zz) {
        if (("" + zaxis) === ("" + zz)) {
          return "" + zz;
        } else {
          return "<a href='interactive.php?file=" + file + "&turn=" + turn + "&z=" + zz + "'>" + zz + "</a>";
        }
      };
      files = (function() {
        var i, len, ref, results;
        ref = [0, 1];
        results = [];
        for (i = 0, len = ref.length; i < len; i++) {
          ff = ref[i];
          results.push(doFileElem(ff));
        }
        return results;
      })();
      $("#file-menu").html("File = " + (files.join(' | ')));
      turns = (function() {
        var ref, results;
        ref = window.wuas().turns;
        results = [];
        for (tt in ref) {
          _contents = ref[tt];
          if (tt <= current_turn) {
            results.push(doTurnElem(tt));
          }
        }
        return results;
      })();
      $("#turn-menu").html("Turn = " + (turns.join(' | ')));
      zaxes = (function() {
        var ref, results;
        ref = window.thisTurnSansZ();
        results = [];
        for (zz in ref) {
          _contents = ref[zz];
          results.push(doZElem(zz));
        }
        return results;
      })();
      return $("#axis-menu").html("Z = " + (zaxes.join(' | ')));
    };
    loadEverything = function() {
      var div, itemDescriptor, suffix, tokenDescriptor, turn;
      tokenDescriptor = function(token) {
        var thumbnail, xpos, ypos;
        thumbnail = "";
        if (token.thumbnail != null) {
          xpos = -token.thumbnail[0];
          ypos = -token.thumbnail[1];
          thumbnail = "<div style='width: 16px; height: 16px; background-image: url(\"" + (window.fileStruct().tokens) + "\");";
          thumbnail = thumbnail + " background-position: " + xpos + "px " + ypos + "px; display: inline-block' /> ";
        }
        return "<dt>" + thumbnail + "<b>" + token.name + "</b> <i>(" + token.stats + ")</i></dt><dd>" + token.desc + "</dd>";
      };
      itemDescriptor = function(item) {
        return "<dt><b>" + item.name + "</b></dt><dd>" + item.desc + "</dd>";
      };
      setupMenus();
      turn = window.getActiveTurn();
      div = $("#interactive-content");
      suffix = "_" + zaxis;
      if (zaxis === 0) {
        suffix = "";
      }
      div.html("<img src=\"" + (filePrefix()) + "turn" + turn + suffix + ".png\" id=\"game-map\" />\n<div id=\"int-space\" style=\"min-height:4em\"></div>\n<div id=\"int-token\" style=\"min-height:10em\"></div>");
      return $("#game-map").mousemove(function(e) {
        var dist_x, dist_y, i, len, now, obj, offset, ref, rel_x, rel_y, spaces, the_space, token_data, x0, y0;
        offset = $(this).offset();
        rel_x = e.pageX - offset.left;
        rel_y = e.pageY - offset.top;
        spaces = window.thisTurnData().spaces;
        x0 = Math.floor(rel_x / 32);
        y0 = Math.floor(rel_y / 32);
        now = spaces;
        now && (now = now[y0]);
        now && (now = now[x0]);
        if (now != null) {
          the_space = window.wuas().spaces[now];
          $("#int-space").html("<dl>\n    <dt><b>" + the_space.name + "</b> <i>(" + the_space.visual + ")</i></dt>\n    <dd>" + the_space.desc + "</dd>\n</dl>");
        } else {
          $("#int-space").html("");
        }
        token_data = "";
        ref = window.thisTurnData().tokens;
        for (i = 0, len = ref.length; i < len; i++) {
          obj = ref[i];
          dist_x = rel_x - obj.position[0];
          dist_y = rel_y - obj.position[1];
          if ((0 <= dist_x && dist_x < 16) && (0 <= dist_y && dist_y < 16)) {
            if (window.wuas().tokens[obj.object] != null) {
              token_data += tokenDescriptor(window.wuas().tokens[obj.object]);
            } else if (window.wuas().items[obj.object] != null) {
              token_data += itemDescriptor(window.wuas().items[obj.object]);
            }
          }
        }
        return $("#int-token").html("<dl>" + token_data + "</dl>");
      });
    };
    window.getActiveTurn = function() {
      if (active_turn === -1) {
        return current_turn;
      } else {
        return active_turn;
      }
    };
    window.setActiveTurn = function(f, x, y) {
      file = f;
      active_turn = x;
      return zaxis = y;
    };
    window.thisTurnSansZ = function() {
      var turn;
      turn = window.getActiveTurn();
      return window.wuas().turns["" + turn];
    };
    return window.thisTurnData = function() {
      var turn;
      turn = window.getActiveTurn();
      return window.wuas().turns["" + turn]["" + zaxis];
    };
  })(jQuery);

}).call(this);