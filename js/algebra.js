// Generated by CoffeeScript 1.12.7
(function() {
  (function($) {
    var desymbolify, redirecting, structs;
    structs = null;
    redirecting = false;
    desymbolify = [[/&Omega;/g, 'Omega'], [/&omega;/g, 'omega']];
    $(function() {
      $(window).bind('popstate', function(event) {
        redirecting = true;
        return window.doRender(event.originalEvent.state.key);
      });
      return $.ajax({
        url: "../algebra.json",
        dataType: "json",
        success: function(data, _0, _1) {
          structs = data;
          return window.doRender(window.structureCommand);
        }
      });
    });
    window.doList = function() {
      var alt, i, j, l0, len, len1, line, lines, ref, ref1, text, value;
      lines = (function() {
        var results;
        results = [];
        for (value in structs) {
          results.push(value);
        }
        return results;
      })();
      l0 = [];
      for (i = 0, len = lines.length; i < len; i++) {
        line = lines[i];
        l0.push([structs[line].name, "<li>\n    <a href='javascript:void(0)' onclick='window.doRender(\"" + line + "\")'>\n        " + structs[line].name + "\n    </a>\n</li>"]);
        ref1 = (ref = structs[line].alt) != null ? ref : [];
        for (j = 0, len1 = ref1.length; j < len1; j++) {
          alt = ref1[j];
          l0.push([alt, "<li>\n    <a href='javascript:void(0)' onclick='window.doRender(\"" + line + "\")'>\n        " + alt + "\n    </a>\n</li>"]);
        }
      }
      l0.sort(function(x, y) {
        return x[0].localeCompare(y[0]);
      });
      l0 = l0.map(function(x) {
        return x[1];
      });
      text = "<ul>" + (l0.join('')) + "</ul>\n<div>\n    <a href=\"index.php\">\n        Back to Algebra\n    </a>\n</div>";
      return $("#map-contents").html(text);
    };
    return window.doRender = function(str) {
      var alt_names, alternatives, edge, edges, example, examples, form, i, j, k, l, len, len1, len2, len3, len4, len5, link, links, m, n, new_title, prop, props, ref, ref1, ref2, ref3, ref4, reg, struct, text;
      if (str === "list") {
        window.doList();
      } else {
        struct = structs[str];
        links = "";
        ref = struct.links;
        for (i = 0, len = ref.length; i < len; i++) {
          link = ref[i];
          links += "<li>\n    <a href='" + link + "'>" + link + "</a>\n</li>";
        }
        links = "<ul>" + links + "</ul>";
        edges = "";
        ref1 = struct.edges;
        for (j = 0, len1 = ref1.length; j < len1; j++) {
          edge = ref1[j];
          edges += "<li>\n    " + edge.algebra + " =\n        <a href='javascript:void(0)' onclick='window.doRender(\"" + edge.result + "\")'>\n            " + structs[edge.result].name + "\n        </a>\n</li>";
        }
        edges = "<ul>" + edges + "</ul>";
        props = "";
        ref2 = struct.props;
        for (k = 0, len2 = ref2.length; k < len2; k++) {
          prop = ref2[k];
          props += "<li>\n    " + prop + "\n</li>";
        }
        if (props === "") {
          props = "<li>(No additional properties)</li>";
        }
        props = "<ul>" + props + "</ul>";
        examples = "";
        if (struct.examples != null) {
          ref3 = struct.examples;
          for (l = 0, len3 = ref3.length; l < len3; l++) {
            example = ref3[l];
            examples += "<li>\n    " + example + "\n</li>";
          }
          examples = "<b>Examples</b><ul>" + examples + "</ul>";
        }
        alt_names = "";
        if (struct.alt != null) {
          alt_names = "<div><small><i>(Also called " + (struct.alt.join(', ')) + ")</i></small></div>";
        }
        alternatives = "";
        if (struct.form != null) {
          ref4 = struct.form;
          for (m = 0, len4 = ref4.length; m < len4; m++) {
            form = ref4[m];
            alternatives += "<p>\n    " + form + "\n</p>";
          }
        }
        text = "<h1>" + struct.name + "</h1>\n" + alt_names + "\n<p>\n    " + struct.tagline + "\n    " + props + "\n</p>\n" + alternatives + "\n" + examples + "\n<br/>\n<b>Related Structures</b>\n" + edges + "\n<b>Further Links</b>\n" + links + "\n<br/>\n<a href='javascript:void(0)' onclick='window.doRender(\"list\")'>Back to List</a>";
        $("#map-contents").html(text);
      }
      if (struct != null) {
        new_title = "Mercerenies - " + struct.name;
      } else {
        new_title = "Mercerenies - Algebra";
      }
      for (n = 0, len5 = desymbolify.length; n < len5; n++) {
        reg = desymbolify[n];
        new_title = new_title.replace(reg[0], reg[1]);
      }
      document.title = new_title;
      if (redirecting) {
        redirecting = false;
      } else {
        window.history.pushState({
          key: str
        }, new_title, "map.php?struct=" + str);
      }
      return MathJax.Hub.Queue(["Typeset", MathJax.Hub, "map-contents"]);
    };
  })(jQuery);

}).call(this);
