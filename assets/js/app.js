(function (factory) {
  typeof define === 'function' && define.amd ? define(factory) :
  factory();
})((function () { 'use strict';

  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
    return arr2;
  }

  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }

  function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
  }

  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
  }

  function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }

  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
  }

  function _typeof$1(o) {
    "@babel/helpers - typeof";

    return _typeof$1 = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
      return typeof o;
    } : function (o) {
      return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
    }, _typeof$1(o);
  }

  function toPrimitive(t, r) {
    if ("object" != _typeof$1(t) || !t) return t;
    var e = t[Symbol.toPrimitive];
    if (void 0 !== e) {
      var i = e.call(t, r || "default");
      if ("object" != _typeof$1(i)) return i;
      throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return ("string" === r ? String : Number)(t);
  }

  function toPropertyKey(t) {
    var i = toPrimitive(t, "string");
    return "symbol" == _typeof$1(i) ? i : i + "";
  }

  function _defineProperty(obj, key, value) {
    key = toPropertyKey(key);
    if (key in obj) {
      Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
      });
    } else {
      obj[key] = value;
    }
    return obj;
  }

  function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
    try {
      var info = gen[key](arg);
      var value = info.value;
    } catch (error) {
      reject(error);
      return;
    }
    if (info.done) {
      resolve(value);
    } else {
      Promise.resolve(value).then(_next, _throw);
    }
  }
  function _asyncToGenerator(fn) {
    return function () {
      var self = this,
        args = arguments;
      return new Promise(function (resolve, reject) {
        var gen = fn.apply(self, args);
        function _next(value) {
          asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
        }
        function _throw(err) {
          asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
        }
        _next(undefined);
      });
    };
  }

  function getDefaultExportFromCjs (x) {
  	return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, 'default') ? x['default'] : x;
  }

  var regeneratorRuntime$1 = {exports: {}};

  var _typeof = {exports: {}};

  (function (module) {
  	function _typeof(o) {
  	  "@babel/helpers - typeof";

  	  return (module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
  	    return typeof o;
  	  } : function (o) {
  	    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  	  }, module.exports.__esModule = true, module.exports["default"] = module.exports), _typeof(o);
  	}
  	module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports; 
  } (_typeof));

  var _typeofExports = _typeof.exports;

  (function (module) {
  	var _typeof = _typeofExports["default"];
  	function _regeneratorRuntime() {
  	  module.exports = _regeneratorRuntime = function _regeneratorRuntime() {
  	    return e;
  	  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  	  var t,
  	    e = {},
  	    r = Object.prototype,
  	    n = r.hasOwnProperty,
  	    o = Object.defineProperty || function (t, e, r) {
  	      t[e] = r.value;
  	    },
  	    i = "function" == typeof Symbol ? Symbol : {},
  	    a = i.iterator || "@@iterator",
  	    c = i.asyncIterator || "@@asyncIterator",
  	    u = i.toStringTag || "@@toStringTag";
  	  function define(t, e, r) {
  	    return Object.defineProperty(t, e, {
  	      value: r,
  	      enumerable: !0,
  	      configurable: !0,
  	      writable: !0
  	    }), t[e];
  	  }
  	  try {
  	    define({}, "");
  	  } catch (t) {
  	    define = function define(t, e, r) {
  	      return t[e] = r;
  	    };
  	  }
  	  function wrap(t, e, r, n) {
  	    var i = e && e.prototype instanceof Generator ? e : Generator,
  	      a = Object.create(i.prototype),
  	      c = new Context(n || []);
  	    return o(a, "_invoke", {
  	      value: makeInvokeMethod(t, r, c)
  	    }), a;
  	  }
  	  function tryCatch(t, e, r) {
  	    try {
  	      return {
  	        type: "normal",
  	        arg: t.call(e, r)
  	      };
  	    } catch (t) {
  	      return {
  	        type: "throw",
  	        arg: t
  	      };
  	    }
  	  }
  	  e.wrap = wrap;
  	  var h = "suspendedStart",
  	    l = "suspendedYield",
  	    f = "executing",
  	    s = "completed",
  	    y = {};
  	  function Generator() {}
  	  function GeneratorFunction() {}
  	  function GeneratorFunctionPrototype() {}
  	  var p = {};
  	  define(p, a, function () {
  	    return this;
  	  });
  	  var d = Object.getPrototypeOf,
  	    v = d && d(d(values([])));
  	  v && v !== r && n.call(v, a) && (p = v);
  	  var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p);
  	  function defineIteratorMethods(t) {
  	    ["next", "throw", "return"].forEach(function (e) {
  	      define(t, e, function (t) {
  	        return this._invoke(e, t);
  	      });
  	    });
  	  }
  	  function AsyncIterator(t, e) {
  	    function invoke(r, o, i, a) {
  	      var c = tryCatch(t[r], t, o);
  	      if ("throw" !== c.type) {
  	        var u = c.arg,
  	          h = u.value;
  	        return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) {
  	          invoke("next", t, i, a);
  	        }, function (t) {
  	          invoke("throw", t, i, a);
  	        }) : e.resolve(h).then(function (t) {
  	          u.value = t, i(u);
  	        }, function (t) {
  	          return invoke("throw", t, i, a);
  	        });
  	      }
  	      a(c.arg);
  	    }
  	    var r;
  	    o(this, "_invoke", {
  	      value: function value(t, n) {
  	        function callInvokeWithMethodAndArg() {
  	          return new e(function (e, r) {
  	            invoke(t, n, e, r);
  	          });
  	        }
  	        return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
  	      }
  	    });
  	  }
  	  function makeInvokeMethod(e, r, n) {
  	    var o = h;
  	    return function (i, a) {
  	      if (o === f) throw Error("Generator is already running");
  	      if (o === s) {
  	        if ("throw" === i) throw a;
  	        return {
  	          value: t,
  	          done: !0
  	        };
  	      }
  	      for (n.method = i, n.arg = a;;) {
  	        var c = n.delegate;
  	        if (c) {
  	          var u = maybeInvokeDelegate(c, n);
  	          if (u) {
  	            if (u === y) continue;
  	            return u;
  	          }
  	        }
  	        if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) {
  	          if (o === h) throw o = s, n.arg;
  	          n.dispatchException(n.arg);
  	        } else "return" === n.method && n.abrupt("return", n.arg);
  	        o = f;
  	        var p = tryCatch(e, r, n);
  	        if ("normal" === p.type) {
  	          if (o = n.done ? s : l, p.arg === y) continue;
  	          return {
  	            value: p.arg,
  	            done: n.done
  	          };
  	        }
  	        "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg);
  	      }
  	    };
  	  }
  	  function maybeInvokeDelegate(e, r) {
  	    var n = r.method,
  	      o = e.iterator[n];
  	    if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y;
  	    var i = tryCatch(o, e.iterator, r.arg);
  	    if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y;
  	    var a = i.arg;
  	    return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y);
  	  }
  	  function pushTryEntry(t) {
  	    var e = {
  	      tryLoc: t[0]
  	    };
  	    1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e);
  	  }
  	  function resetTryEntry(t) {
  	    var e = t.completion || {};
  	    e.type = "normal", delete e.arg, t.completion = e;
  	  }
  	  function Context(t) {
  	    this.tryEntries = [{
  	      tryLoc: "root"
  	    }], t.forEach(pushTryEntry, this), this.reset(!0);
  	  }
  	  function values(e) {
  	    if (e || "" === e) {
  	      var r = e[a];
  	      if (r) return r.call(e);
  	      if ("function" == typeof e.next) return e;
  	      if (!isNaN(e.length)) {
  	        var o = -1,
  	          i = function next() {
  	            for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next;
  	            return next.value = t, next.done = !0, next;
  	          };
  	        return i.next = i;
  	      }
  	    }
  	    throw new TypeError(_typeof(e) + " is not iterable");
  	  }
  	  return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", {
  	    value: GeneratorFunctionPrototype,
  	    configurable: !0
  	  }), o(GeneratorFunctionPrototype, "constructor", {
  	    value: GeneratorFunction,
  	    configurable: !0
  	  }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) {
  	    var e = "function" == typeof t && t.constructor;
  	    return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name));
  	  }, e.mark = function (t) {
  	    return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t;
  	  }, e.awrap = function (t) {
  	    return {
  	      __await: t
  	    };
  	  }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () {
  	    return this;
  	  }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) {
  	    void 0 === i && (i = Promise);
  	    var a = new AsyncIterator(wrap(t, r, n, o), i);
  	    return e.isGeneratorFunction(r) ? a : a.next().then(function (t) {
  	      return t.done ? t.value : a.next();
  	    });
  	  }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () {
  	    return this;
  	  }), define(g, "toString", function () {
  	    return "[object Generator]";
  	  }), e.keys = function (t) {
  	    var e = Object(t),
  	      r = [];
  	    for (var n in e) r.push(n);
  	    return r.reverse(), function next() {
  	      for (; r.length;) {
  	        var t = r.pop();
  	        if (t in e) return next.value = t, next.done = !1, next;
  	      }
  	      return next.done = !0, next;
  	    };
  	  }, e.values = values, Context.prototype = {
  	    constructor: Context,
  	    reset: function reset(e) {
  	      if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t);
  	    },
  	    stop: function stop() {
  	      this.done = !0;
  	      var t = this.tryEntries[0].completion;
  	      if ("throw" === t.type) throw t.arg;
  	      return this.rval;
  	    },
  	    dispatchException: function dispatchException(e) {
  	      if (this.done) throw e;
  	      var r = this;
  	      function handle(n, o) {
  	        return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o;
  	      }
  	      for (var o = this.tryEntries.length - 1; o >= 0; --o) {
  	        var i = this.tryEntries[o],
  	          a = i.completion;
  	        if ("root" === i.tryLoc) return handle("end");
  	        if (i.tryLoc <= this.prev) {
  	          var c = n.call(i, "catchLoc"),
  	            u = n.call(i, "finallyLoc");
  	          if (c && u) {
  	            if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
  	            if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
  	          } else if (c) {
  	            if (this.prev < i.catchLoc) return handle(i.catchLoc, !0);
  	          } else {
  	            if (!u) throw Error("try statement without catch or finally");
  	            if (this.prev < i.finallyLoc) return handle(i.finallyLoc);
  	          }
  	        }
  	      }
  	    },
  	    abrupt: function abrupt(t, e) {
  	      for (var r = this.tryEntries.length - 1; r >= 0; --r) {
  	        var o = this.tryEntries[r];
  	        if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) {
  	          var i = o;
  	          break;
  	        }
  	      }
  	      i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null);
  	      var a = i ? i.completion : {};
  	      return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a);
  	    },
  	    complete: function complete(t, e) {
  	      if ("throw" === t.type) throw t.arg;
  	      return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y;
  	    },
  	    finish: function finish(t) {
  	      for (var e = this.tryEntries.length - 1; e >= 0; --e) {
  	        var r = this.tryEntries[e];
  	        if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y;
  	      }
  	    },
  	    "catch": function _catch(t) {
  	      for (var e = this.tryEntries.length - 1; e >= 0; --e) {
  	        var r = this.tryEntries[e];
  	        if (r.tryLoc === t) {
  	          var n = r.completion;
  	          if ("throw" === n.type) {
  	            var o = n.arg;
  	            resetTryEntry(r);
  	          }
  	          return o;
  	        }
  	      }
  	      throw Error("illegal catch attempt");
  	    },
  	    delegateYield: function delegateYield(e, r, n) {
  	      return this.delegate = {
  	        iterator: values(e),
  	        resultName: r,
  	        nextLoc: n
  	      }, "next" === this.method && (this.arg = t), y;
  	    }
  	  }, e;
  	}
  	module.exports = _regeneratorRuntime, module.exports.__esModule = true, module.exports["default"] = module.exports; 
  } (regeneratorRuntime$1));

  var regeneratorRuntimeExports = regeneratorRuntime$1.exports;

  // TODO(Babel 8): Remove this file.

  var runtime = regeneratorRuntimeExports();
  var regenerator = runtime;

  // Copied from https://github.com/facebook/regenerator/blob/main/packages/runtime/runtime.js#L736=
  try {
    regeneratorRuntime = runtime;
  } catch (accidentalStrictMode) {
    if (typeof globalThis === "object") {
      globalThis.regeneratorRuntime = runtime;
    } else {
      Function("r", "regeneratorRuntime = r")(runtime);
    }
  }

  var _regeneratorRuntime = /*@__PURE__*/getDefaultExportFromCjs(regenerator);

  typeof arguments === "undefined" ? void 0 : arguments;

  /**
   * String to boolean
   *
   * @param string
   * @returns {boolean}
   */
  var stringToBoolean = function stringToBoolean(string) {
    switch (string) {
      case 'on':
      case 'true':
      case '1':
        return true;
      default:
        return false;
    }
  };
  var setCookie = function setCookie() {
    var name = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
    var now = new Date();
    var time = now.getTime();
    time += 24 * 60 * 60 * 1000;
    now.setTime(time);
    document.cookie = "isvek-theme-".concat(name, "=").concat(value, ";path=/;expires=").concat(now.toUTCString(), ";domain=").concat(location.host);
  };
  var getCookie = function getCookie() {
    var name = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    name = "isvek-theme-".concat(name, "=");
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookies = decodedCookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.indexOf(name) !== -1) {
        return cookie.substring(name.length, cookie.length);
      }
    }
  };

  document.addEventListener('DOMContentLoaded', function () {
    var navbarElementList = document.querySelectorAll('[data-bs-navbar]');
    if (navbarElementList) {
      navbarElementList.forEach(function (navbarEl) {
        var offcanvasNavbar = document.getElementById('offcanvas-navbar');
        var dropdownElementList = navbarEl.querySelectorAll('.dropdown-toggle');
        var dropdownList = _toConsumableArray(dropdownElementList).map(function (dropdownToggleEl) {
          return new bootstrap.Dropdown(dropdownToggleEl, {
            'data-bs-display': 'none'
          });
        });
        var dataNavbarVisible = stringToBoolean(navbarEl.getAttribute('data-bs-visible'));
        var elementVisible = function elementVisible(el) {
          var rect = el.getBoundingClientRect();
          return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
        };
        var dropdown = function dropdown(event) {
          var instance = bootstrap.Dropdown.getInstance(event.target);
          if (instance) {
            if (instance._menu.classList.contains('dropdown-submenu')) {
              instance._parent.classList.add('dropend');
              instance._parent.classList.remove('dropstart');
              if (dataNavbarVisible && !elementVisible(instance._menu)) {
                instance._parent.classList.remove('dropend');
                instance._parent.classList.add('dropstart');
              }
            } else {
              instance._menu.classList.remove('dropdown-menu-end');
              if (dataNavbarVisible && !elementVisible(instance._menu)) {
                instance._menu.classList.add('dropdown-menu-end');
              }
            }
          }
        };
        var navbar = function navbar(el) {
          if (el._menu) {
            el._element.addEventListener('mouseover', function (event) {
              dropdown(event);
            });
            el._element.addEventListener('keydown', function (event) {
              dropdown(event);
            });
          }
        };
        if (dropdownList) {
          dropdownList.map(function (dropdown) {
            window.addEventListener('resize', function () {
              navbar(dropdown);
            });
            navbar(dropdown);
            if (offcanvasNavbar) {
              offcanvasNavbar.addEventListener('hide.bs.offcanvas', function (event) {
                dropdown.hide();
                dropdown._menu.setAttribute('data-bs-popper', 'none');
              });
              offcanvasNavbar.addEventListener('hidden.bs.offcanvas', function (event) {
                dropdown.hide();
                dropdown._menu.setAttribute('data-bs-popper', 'none');
              });
            }
          });
        }
      });
    }
  });

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): scroll-top.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  var backTopSelector = document.querySelector('.scroll-top');
  if (backTopSelector) {
    backTopSelector.addEventListener('click', function (event) {
      event.preventDefault();
      window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth'
      });
    }, false);
    window.addEventListener('scroll', function () {
      var scrolled = document.scrollingElement.scrollTop || 0;
      if (scrolled > 300) {
        backTopSelector.classList.add('show');
      } else {
        backTopSelector.classList.remove('show');
      }
    });
  }

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): toasts.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  document.addEventListener('DOMContentLoaded', function () {
    var toastCookie = document.getElementById('toast-cookie');
    var toast = bootstrap.Toast.getOrCreateInstance(toastCookie, {
      autohide: false,
      animation: false
    });
    var cookieAgree = document.querySelector('.cookie-agree');
    if (toastCookie) {
      if (stringToBoolean(getCookie('cookie-agree'))) {
        toastCookie.classList.add('d-none');
        toast.hide();
      } else {
        toastCookie.classList.remove('d-none');
        toast.show();
      }
      cookieAgree.addEventListener('click', function (event) {
        event.preventDefault();
        setCookie('cookie-agree', 'true');
        toast.hide();
      });
    }
  });

  function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
  function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.1): search.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  document.addEventListener('DOMContentLoaded', function () {
    var searchForm = document.querySelector('.isvek-theme-search-form');
    var ajax = /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime.mark(function _callee(event) {
        return _regeneratorRuntime.wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (!(event.target.value.length > 3)) {
                _context.next = 6;
                break;
              }
              _context.next = 3;
              return fetch(isvek_theme_search.url_ajax, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                  'Cache-Control': 'no-cache',
                  'charset': 'UTF-8'
                },
                body: new URLSearchParams({
                  action: isvek_theme_search.action,
                  s: event.target.value,
                  security: isvek_theme_search.security
                })
              }).then(function (response) {
                return response.json().then(function (data) {
                  return _objectSpread({
                    ok: response.ok,
                    status: response.status,
                    statusText: response.statusText
                  }, data);
                });
              }).then(function (object) {
                if (object.ok === true && object.status === 200) {
                  if (object.success === true) {
                    return object.data;
                  }
                  return false;
                }
                return false;
              })["catch"](function (error) {
                return error;
              });
            case 3:
              return _context.abrupt("return", _context.sent);
            case 6:
              return _context.abrupt("return", false);
            case 7:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }));
      return function ajax(_x) {
        return _ref.apply(this, arguments);
      };
    }();
    if (searchForm) {
      var searchInput = searchForm.querySelector('.search-input');
      searchForm.addEventListener('mouseover', function (event) {
        return event.stopImmediatePropagation();
      });
      searchInput.addEventListener('keyup', function (event) {
        var searchDataList = searchForm.querySelector('#isvek-theme-search-data-list');
        ajax(event).then(function (data) {
          Array.from(searchDataList.children).forEach(function (option) {
            return option.remove();
          });
          if (Object.keys(data).length !== 0) {
            data.query.forEach(function (q) {
              var option = document.createElement('option');
              option.value = q.title;
              searchDataList.appendChild(option);
            });
          }
        });
      });
    }
  });

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): tooltip.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });

}));
//# sourceMappingURL=app.js.map
