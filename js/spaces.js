// Generated by CoffeeScript 2.5.1
(function() {
  // -*- coffee-tab-width: 4 -*-
  (function($) {
    var cb, codex_struct, file_number, file_struct, initFileStruct, listOut, listOutValsWithNames, listOutWithEntry, listOutWithNames, setupSpaceMap, spaceMapLine, wuas;
    wuas = null;
    file_number = -1;
    codex_struct = {};
    file_struct = {};
    cb = [];
    window.loadData = function(file) {
      file_number = file;
      return $.ajax({
        url: "../wuas_codex.json",
        dataType: "json",
        success: function(data) {
          codex_struct = data;
          fillInFooter();
          return initFileStruct();
        }
      });
    };
    initFileStruct = function() {
      file_struct = codex_struct.dicts[file_number];
      return $.ajax({
        url: file_struct.json,
        dataType: "json",
        success: function(data, _0, _1) {
          var f, j, len, results1;
          wuas = data;
          if (!wuas.attributes) {
            // Backward compatibility
            wuas.attributes = {};
          }
          $("#wuas-space-map").html(`<img src="${file_struct.spaces}" usemap="#spaces-map" />
<map name="spaces-map" id="spaces-map">
</map>`);
          setupSpaceMap();
          listOutValsWithNames(wuas.items, $("#wuas-items"));
          listOutValsWithNames(wuas.attributes, $("#wuas-attributes"));
          if (wuas.captures) {
            $("#wuas-captures-project-div").removeClass("hidden-project");
            listOutValsWithNames(wuas.captures, $("#wuas-captures"));
          }
          listOutWithNames(wuas.effects, $("#wuas-effects"));
          listOutWithEntry(wuas.tokens, $("#wuas-tokens"));
          listOut(wuas.rulings, $("#wuas-rulings"));
          $("#search-field").bind("change input keyup paste", function() {
            return window.updateSearch('wuas-search-results', 'search-field');
          });
          results1 = [];
          for (j = 0, len = cb.length; j < len; j++) {
            f = cb[j];
            results1.push(f());
          }
          return results1;
        }
      });
    };
    spaceMapLine = function(key, data) {
      var area;
      area = $("<area/>");
      area.attr("coords", data.coords);
      area.attr("href", "javascript:void(0)");
      area.on("click", function(e) {
        e.preventDefault();
        return window.putEffectText($("#space-effect-text"), key);
      });
      return $("#spaces-map").append(area);
    };
    setupSpaceMap = function() {
      var key, ref, results1, value;
      ref = wuas.spaces;
      results1 = [];
      for (key in ref) {
        value = ref[key];
        results1.push(spaceMapLine(key, value));
      }
      return results1;
    };
    listOut = function(list, jqObj) {
      var j, len, obj, ul;
      ul = $("<ul></ul>");
      for (j = 0, len = list.length; j < len; j++) {
        obj = list[j];
        ul.append($(`<li>${obj.desc}</li>`));
      }
      jqObj.html('');
      return jqObj.append(ul);
    };
    listOutWithNames = function(list, jqObj) {
      var dl, j, len, obj;
      dl = $("<dl></dl>");
      for (j = 0, len = list.length; j < len; j++) {
        obj = list[j];
        dl.append($(`<dt><b>${obj.name}</b></dt><dd>${obj.desc}</dd>`));
      }
      jqObj.html('');
      return jqObj.append(dl);
    };
    listOutValsWithNames = function(list, jqObj) {
      var dl, key, obj;
      dl = $("<dl></dl>");
      for (key in list) {
        obj = list[key];
        dl.append($(`<dt><b>${obj.name}</b></dt><dd>${obj.desc}</dd>`));
      }
      jqObj.html('');
      return jqObj.append(dl);
    };
    listOutWithEntry = function(list, jqObj) {
      var dl, key, name, obj, spanx, spany, xpos, ypos;
      dl = $("<dl></dl>");
      for (key in list) {
        obj = list[key];
        name = "";
        if (obj.thumbnail != null) {
          xpos = -obj.thumbnail[0];
          ypos = -obj.thumbnail[1];
          spanx = 1;
          spany = 1;
          if ('span' in obj) {
            spanx = obj.span[0];
            spany = obj.span[1];
          }
          spanx *= 16;
          spany *= 16;
          name = `<div style='width: ${spanx}px; height: ${spany}px;
    background-image: url("${file_struct.tokens}");
    background-position: ${xpos}px ${ypos}px; display: inline-block' />
<b>${obj.name}</b>`;
        }
        dl.append($(`<dt>${name} <i>(${obj.stats})</i></dt><dd>${obj.desc}</dd>`));
      }
      jqObj.html('');
      return jqObj.append(dl);
    };
    window.putEffectText = function(jqObj, id) {
      var desc, name, spaces, str, visual;
      if (wuas != null) {
        spaces = wuas.spaces;
        name = spaces[id].name;
        visual = spaces[id].visual;
        desc = spaces[id].desc;
        str = `<b>${name}</b> <i>(${visual})</i><br/>
<blockquote>${desc}</blockquote>`;
        return jqObj.html(str);
      }
    };
    window.updateSearch = function(divId, textId) {
      var attribute, divField, dl, effect, item, j, k, key, len, len1, ref, ref1, ref2, ref3, ref4, ref5, result, results, space, text, textField, token, tokenDescriptor;
      tokenDescriptor = function(token) {
        var thumbnail, xpos, ypos;
        thumbnail = "";
        if (token.thumbnail != null) {
          xpos = -token.thumbnail[0];
          ypos = -token.thumbnail[1];
          thumbnail = `<div style='width: 16px; height: 16px;
    background-image: url("${file_struct.tokens}");
    background-position: ${xpos}px ${ypos}px; display: inline-block' />`;
        }
        return `<dt>${thumbnail}<b>${token.name}</b> <i>(${token.stats})</i></dt><dd>${token.desc}</dd>`;
      };
      divField = $(`#${divId}`);
      textField = $(`#${textId}`);
      text = textField.val().toLowerCase();
      if (wuas != null) {
        results = [];
        ref = wuas.spaces;
        for (key in ref) {
          space = ref[key];
          if (space.name.toLowerCase().includes(text)) {
            results.push(`<dt><b>${space.name}</b> <i>(${space.visual})</i></dt><dd>${space.desc}</dd>`);
          }
        }
        ref1 = wuas.items;
        for (key in ref1) {
          item = ref1[key];
          if (item.name.toLowerCase().includes(text)) {
            results.push(`<dt><b>${item.name}</b></dt><dd>${item.desc}</dd>`);
          }
        }
        ref2 = wuas.effects;
        for (j = 0, len = ref2.length; j < len; j++) {
          effect = ref2[j];
          if (effect.name.toLowerCase().includes(text)) {
            results.push(`<dt><b>${effect.name}</b></dt><dd>${effect.desc}</dd>`);
          }
        }
        ref3 = wuas.tokens;
        for (key in ref3) {
          token = ref3[key];
          if (token.name.toLowerCase().includes(text)) {
            results.push(tokenDescriptor(token));
          }
        }
        ref4 = wuas.attributes;
        for (key in ref4) {
          attribute = ref4[key];
          if (attribute.name.toLowerCase().includes(text)) {
            results.push(`<dt><b>${attribute.name}</b></dt><dd>${attribute.desc}</dd>`);
          }
        }
        ref5 = wuas.captures || {};
        for (key in ref5) {
          attribute = ref5[key];
          if (attribute.name.toLowerCase().includes(text)) {
            results.push(`<dt><b>${attribute.name}</b></dt><dd>${attribute.desc}</dd>`);
          }
        }
        if (results.length > 10) {
          return divField.html("Please narrow your search.");
        } else if (results.length === 0) {
          return divField.html("No results found.");
        } else {
          dl = $("<dl></dl>");
          for (k = 0, len1 = results.length; k < len1; k++) {
            result = results[k];
            dl.append($(result));
          }
          divField.html('');
          return divField.append(dl);
        }
      } else {
        return divField.html("Please wait...");
      }
    };
    window.wuas = function() {
      return wuas;
    };
    window.wuasCallback = function(f) {
      return cb.push(f);
    };
    window.fileStruct = function() {
      return file_struct;
    };
    window.fillInFooter = function() {
      var curr, data, files, i, list_data, tag_current, tag_link, tag_old;
      tag_current = "an unknown dictionary";
      tag_old = "an unknown dictionary";
      tag_link = "here";
      files = (function() {
        var j, len, ref, results1;
        ref = codex_struct.dicts;
        results1 = [];
        for (i = j = 0, len = ref.length; j < len; i = ++j) {
          data = ref[i];
          if (file_number === i) {
            results1.push(data.name);
          } else {
            results1.push(`<a href='index.php?file=${i}'>${data.name}</a>`);
          }
        }
        return results1;
      })();
      list_data = (function() {
        var j, len, results1;
        results1 = [];
        for (j = 0, len = files.length; j < len; j++) {
          curr = files[j];
          results1.push(`<li>${curr}</li>`);
        }
        return results1;
      })();
      return $("#wuas-footer-tagline").html(`Available Game Dictionaries
<ul>
    ${list_data.join("\n")}
</ul>`);
    };
    window.fillInHeader = function() {
      var text;
      text = `Wish Upon A Star - ${codex_struct.dicts[file_number].name}`;
      return $("#file-header").html(`<em>
    Currently viewing: ${text}
</em>`);
    };
    window.getCodexDict = function(n = file_number) {
      return codex_struct.dicts[n];
    };
    return window.fileCount = function() {
      return codex_struct.dicts.length;
    };
  })(jQuery);

}).call(this);
