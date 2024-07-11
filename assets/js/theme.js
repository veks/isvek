(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, global.isvek = factory());
})(this, (function () { 'use strict';

  /**
   * --------------------------------------------------------------------------
   * Bootstrap util/index.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  const MILLISECONDS_MULTIPLIER = 1000;
  const TRANSITION_END = 'transitionend';

  /**
   * Properly escape IDs selectors to handle weird IDs
   * @param {string} selector
   * @returns {string}
   */
  const parseSelector = selector => {
    if (selector && window.CSS && window.CSS.escape) {
      // document.querySelector needs escaping to handle IDs (html5+) containing for instance /
      selector = selector.replace(/#([^\s"#']+)/g, (match, id) => `#${CSS.escape(id)}`);
    }

    return selector
  };

  // Shout-out Angus Croll (https://goo.gl/pxwQGp)
  const toType = object => {
    if (object === null || object === undefined) {
      return `${object}`
    }

    return Object.prototype.toString.call(object).match(/\s([a-z]+)/i)[1].toLowerCase()
  };

  const getTransitionDurationFromElement = element => {
    if (!element) {
      return 0
    }

    // Get transition-duration of the element
    let { transitionDuration, transitionDelay } = window.getComputedStyle(element);

    const floatTransitionDuration = Number.parseFloat(transitionDuration);
    const floatTransitionDelay = Number.parseFloat(transitionDelay);

    // Return 0 if element or transition duration is not found
    if (!floatTransitionDuration && !floatTransitionDelay) {
      return 0
    }

    // If multiple durations are defined, take the first
    transitionDuration = transitionDuration.split(',')[0];
    transitionDelay = transitionDelay.split(',')[0];

    return (Number.parseFloat(transitionDuration) + Number.parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER
  };

  const triggerTransitionEnd = element => {
    element.dispatchEvent(new Event(TRANSITION_END));
  };

  const isElement = object => {
    if (!object || typeof object !== 'object') {
      return false
    }

    if (typeof object.jquery !== 'undefined') {
      object = object[0];
    }

    return typeof object.nodeType !== 'undefined'
  };

  const getElement = object => {
    // it's a jQuery object or a node element
    if (isElement(object)) {
      return object.jquery ? object[0] : object
    }

    if (typeof object === 'string' && object.length > 0) {
      return document.querySelector(parseSelector(object))
    }

    return null
  };

  const isVisible = element => {
    if (!isElement(element) || element.getClientRects().length === 0) {
      return false
    }

    const elementIsVisible = getComputedStyle(element).getPropertyValue('visibility') === 'visible';
    // Handle `details` element as its content may falsie appear visible when it is closed
    const closedDetails = element.closest('details:not([open])');

    if (!closedDetails) {
      return elementIsVisible
    }

    if (closedDetails !== element) {
      const summary = element.closest('summary');
      if (summary && summary.parentNode !== closedDetails) {
        return false
      }

      if (summary === null) {
        return false
      }
    }

    return elementIsVisible
  };

  const isDisabled = element => {
    if (!element || element.nodeType !== Node.ELEMENT_NODE) {
      return true
    }

    if (element.classList.contains('disabled')) {
      return true
    }

    if (typeof element.disabled !== 'undefined') {
      return element.disabled
    }

    return element.hasAttribute('disabled') && element.getAttribute('disabled') !== 'false'
  };

  const getjQuery = () => {
    if (window.jQuery && !document.body.hasAttribute('data-bs-no-jquery')) {
      return window.jQuery
    }

    return null
  };

  const execute = (possibleCallback, args = [], defaultValue = possibleCallback) => {
    return typeof possibleCallback === 'function' ? possibleCallback(...args) : defaultValue
  };

  const executeAfterTransition = (callback, transitionElement, waitForTransition = true) => {
    if (!waitForTransition) {
      execute(callback);
      return
    }

    const durationPadding = 5;
    const emulatedDuration = getTransitionDurationFromElement(transitionElement) + durationPadding;

    let called = false;

    const handler = ({ target }) => {
      if (target !== transitionElement) {
        return
      }

      called = true;
      transitionElement.removeEventListener(TRANSITION_END, handler);
      execute(callback);
    };

    transitionElement.addEventListener(TRANSITION_END, handler);
    setTimeout(() => {
      if (!called) {
        triggerTransitionEnd(transitionElement);
      }
    }, emulatedDuration);
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap dom/selector-engine.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */


  const getSelector = element => {
    let selector = element.getAttribute('data-bs-target');

    if (!selector || selector === '#') {
      let hrefAttribute = element.getAttribute('href');

      // The only valid content that could double as a selector are IDs or classes,
      // so everything starting with `#` or `.`. If a "real" URL is used as the selector,
      // `document.querySelector` will rightfully complain it is invalid.
      // See https://github.com/twbs/bootstrap/issues/32273
      if (!hrefAttribute || (!hrefAttribute.includes('#') && !hrefAttribute.startsWith('.'))) {
        return null
      }

      // Just in case some CMS puts out a full URL with the anchor appended
      if (hrefAttribute.includes('#') && !hrefAttribute.startsWith('#')) {
        hrefAttribute = `#${hrefAttribute.split('#')[1]}`;
      }

      selector = hrefAttribute && hrefAttribute !== '#' ? hrefAttribute.trim() : null;
    }

    return selector ? selector.split(',').map(sel => parseSelector(sel)).join(',') : null
  };

  const SelectorEngine = {
    find(selector, element = document.documentElement) {
      return [].concat(...Element.prototype.querySelectorAll.call(element, selector))
    },

    findOne(selector, element = document.documentElement) {
      return Element.prototype.querySelector.call(element, selector)
    },

    children(element, selector) {
      return [].concat(...element.children).filter(child => child.matches(selector))
    },

    parents(element, selector) {
      const parents = [];
      let ancestor = element.parentNode.closest(selector);

      while (ancestor) {
        parents.push(ancestor);
        ancestor = ancestor.parentNode.closest(selector);
      }

      return parents
    },

    prev(element, selector) {
      let previous = element.previousElementSibling;

      while (previous) {
        if (previous.matches(selector)) {
          return [previous]
        }

        previous = previous.previousElementSibling;
      }

      return []
    },
    // TODO: this is now unused; remove later along with prev()
    next(element, selector) {
      let next = element.nextElementSibling;

      while (next) {
        if (next.matches(selector)) {
          return [next]
        }

        next = next.nextElementSibling;
      }

      return []
    },

    focusableChildren(element) {
      const focusables = [
        'a',
        'button',
        'input',
        'textarea',
        'select',
        'details',
        '[tabindex]',
        '[contenteditable="true"]'
      ].map(selector => `${selector}:not([tabindex^="-"])`).join(',');

      return this.find(focusables, element).filter(el => !isDisabled(el) && isVisible(el))
    },

    getSelectorFromElement(element) {
      const selector = getSelector(element);

      if (selector) {
        return SelectorEngine.findOne(selector) ? selector : null
      }

      return null
    },

    getElementFromSelector(element) {
      const selector = getSelector(element);

      return selector ? SelectorEngine.findOne(selector) : null
    },

    getMultipleElementsFromSelector(element) {
      const selector = getSelector(element);

      return selector ? SelectorEngine.find(selector) : []
    }
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap dom/event-handler.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */


  /**
   * Constants
   */

  const namespaceRegex = /[^.]*(?=\..*)\.|.*/;
  const stripNameRegex = /\..*/;
  const stripUidRegex = /::\d+$/;
  const eventRegistry = {}; // Events storage
  let uidEvent = 1;
  const customEvents = {
    mouseenter: 'mouseover',
    mouseleave: 'mouseout'
  };

  const nativeEvents = new Set([
    'click',
    'dblclick',
    'mouseup',
    'mousedown',
    'contextmenu',
    'mousewheel',
    'DOMMouseScroll',
    'mouseover',
    'mouseout',
    'mousemove',
    'selectstart',
    'selectend',
    'keydown',
    'keypress',
    'keyup',
    'orientationchange',
    'touchstart',
    'touchmove',
    'touchend',
    'touchcancel',
    'pointerdown',
    'pointermove',
    'pointerup',
    'pointerleave',
    'pointercancel',
    'gesturestart',
    'gesturechange',
    'gestureend',
    'focus',
    'blur',
    'change',
    'reset',
    'select',
    'submit',
    'focusin',
    'focusout',
    'load',
    'unload',
    'beforeunload',
    'resize',
    'move',
    'DOMContentLoaded',
    'readystatechange',
    'error',
    'abort',
    'scroll'
  ]);

  /**
   * Private methods
   */

  function makeEventUid(element, uid) {
    return (uid && `${uid}::${uidEvent++}`) || element.uidEvent || uidEvent++
  }

  function getElementEvents(element) {
    const uid = makeEventUid(element);

    element.uidEvent = uid;
    eventRegistry[uid] = eventRegistry[uid] || {};

    return eventRegistry[uid]
  }

  function bootstrapHandler(element, fn) {
    return function handler(event) {
      hydrateObj(event, { delegateTarget: element });

      if (handler.oneOff) {
        EventHandler.off(element, event.type, fn);
      }

      return fn.apply(element, [event])
    }
  }

  function bootstrapDelegationHandler(element, selector, fn) {
    return function handler(event) {
      const domElements = element.querySelectorAll(selector);

      for (let { target } = event; target && target !== this; target = target.parentNode) {
        for (const domElement of domElements) {
          if (domElement !== target) {
            continue
          }

          hydrateObj(event, { delegateTarget: target });

          if (handler.oneOff) {
            EventHandler.off(element, event.type, selector, fn);
          }

          return fn.apply(target, [event])
        }
      }
    }
  }

  function findHandler(events, callable, delegationSelector = null) {
    return Object.values(events)
      .find(event => event.callable === callable && event.delegationSelector === delegationSelector)
  }

  function normalizeParameters(originalTypeEvent, handler, delegationFunction) {
    const isDelegated = typeof handler === 'string';
    // TODO: tooltip passes `false` instead of selector, so we need to check
    const callable = isDelegated ? delegationFunction : (handler || delegationFunction);
    let typeEvent = getTypeEvent(originalTypeEvent);

    if (!nativeEvents.has(typeEvent)) {
      typeEvent = originalTypeEvent;
    }

    return [isDelegated, callable, typeEvent]
  }

  function addHandler(element, originalTypeEvent, handler, delegationFunction, oneOff) {
    if (typeof originalTypeEvent !== 'string' || !element) {
      return
    }

    let [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);

    // in case of mouseenter or mouseleave wrap the handler within a function that checks for its DOM position
    // this prevents the handler from being dispatched the same way as mouseover or mouseout does
    if (originalTypeEvent in customEvents) {
      const wrapFunction = fn => {
        return function (event) {
          if (!event.relatedTarget || (event.relatedTarget !== event.delegateTarget && !event.delegateTarget.contains(event.relatedTarget))) {
            return fn.call(this, event)
          }
        }
      };

      callable = wrapFunction(callable);
    }

    const events = getElementEvents(element);
    const handlers = events[typeEvent] || (events[typeEvent] = {});
    const previousFunction = findHandler(handlers, callable, isDelegated ? handler : null);

    if (previousFunction) {
      previousFunction.oneOff = previousFunction.oneOff && oneOff;

      return
    }

    const uid = makeEventUid(callable, originalTypeEvent.replace(namespaceRegex, ''));
    const fn = isDelegated ?
      bootstrapDelegationHandler(element, handler, callable) :
      bootstrapHandler(element, callable);

    fn.delegationSelector = isDelegated ? handler : null;
    fn.callable = callable;
    fn.oneOff = oneOff;
    fn.uidEvent = uid;
    handlers[uid] = fn;

    element.addEventListener(typeEvent, fn, isDelegated);
  }

  function removeHandler(element, events, typeEvent, handler, delegationSelector) {
    const fn = findHandler(events[typeEvent], handler, delegationSelector);

    if (!fn) {
      return
    }

    element.removeEventListener(typeEvent, fn, Boolean(delegationSelector));
    delete events[typeEvent][fn.uidEvent];
  }

  function removeNamespacedHandlers(element, events, typeEvent, namespace) {
    const storeElementEvent = events[typeEvent] || {};

    for (const [handlerKey, event] of Object.entries(storeElementEvent)) {
      if (handlerKey.includes(namespace)) {
        removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
      }
    }
  }

  function getTypeEvent(event) {
    // allow to get the native events from namespaced events ('click.bs.button' --> 'click')
    event = event.replace(stripNameRegex, '');
    return customEvents[event] || event
  }

  const EventHandler = {
    on(element, event, handler, delegationFunction) {
      addHandler(element, event, handler, delegationFunction, false);
    },

    one(element, event, handler, delegationFunction) {
      addHandler(element, event, handler, delegationFunction, true);
    },

    off(element, originalTypeEvent, handler, delegationFunction) {
      if (typeof originalTypeEvent !== 'string' || !element) {
        return
      }

      const [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);
      const inNamespace = typeEvent !== originalTypeEvent;
      const events = getElementEvents(element);
      const storeElementEvent = events[typeEvent] || {};
      const isNamespace = originalTypeEvent.startsWith('.');

      if (typeof callable !== 'undefined') {
        // Simplest case: handler is passed, remove that listener ONLY.
        if (!Object.keys(storeElementEvent).length) {
          return
        }

        removeHandler(element, events, typeEvent, callable, isDelegated ? handler : null);
        return
      }

      if (isNamespace) {
        for (const elementEvent of Object.keys(events)) {
          removeNamespacedHandlers(element, events, elementEvent, originalTypeEvent.slice(1));
        }
      }

      for (const [keyHandlers, event] of Object.entries(storeElementEvent)) {
        const handlerKey = keyHandlers.replace(stripUidRegex, '');

        if (!inNamespace || originalTypeEvent.includes(handlerKey)) {
          removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
        }
      }
    },

    trigger(element, event, args) {
      if (typeof event !== 'string' || !element) {
        return null
      }

      const $ = getjQuery();
      const typeEvent = getTypeEvent(event);
      const inNamespace = event !== typeEvent;

      let jQueryEvent = null;
      let bubbles = true;
      let nativeDispatch = true;
      let defaultPrevented = false;

      if (inNamespace && $) {
        jQueryEvent = $.Event(event, args);

        $(element).trigger(jQueryEvent);
        bubbles = !jQueryEvent.isPropagationStopped();
        nativeDispatch = !jQueryEvent.isImmediatePropagationStopped();
        defaultPrevented = jQueryEvent.isDefaultPrevented();
      }

      const evt = hydrateObj(new Event(event, { bubbles, cancelable: true }), args);

      if (defaultPrevented) {
        evt.preventDefault();
      }

      if (nativeDispatch) {
        element.dispatchEvent(evt);
      }

      if (evt.defaultPrevented && jQueryEvent) {
        jQueryEvent.preventDefault();
      }

      return evt
    }
  };

  function hydrateObj(obj, meta = {}) {
    for (const [key, value] of Object.entries(meta)) {
      try {
        obj[key] = value;
      } catch {
        Object.defineProperty(obj, key, {
          configurable: true,
          get() {
            return value
          }
        });
      }
    }

    return obj
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
      var i = e.call(t, r );
      if ("object" != _typeof$1(i)) return i;
      throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return (String )(t);
  }

  function toPropertyKey(t) {
    var i = toPrimitive(t, "string");
    return "symbol" == _typeof$1(i) ? i : i + "";
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

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): cookie.js
   * Licensed under MIT (https://isvek.ru/main/LICENSE.md)
   * --------------------------------------------------------------------------
   */

  EventHandler.on(window, 'load', function () {
    var toastCookie = SelectorEngine.findOne('#toast-cookie');
    var toast = bootstrap.Toast.getOrCreateInstance(toastCookie, {
      autohide: false,
      animation: true
    });
    var cookieAgree = SelectorEngine.findOne('.cookie-agree');
    if (toastCookie) {
      if (stringToBoolean(getCookie('cookie-agree'))) {
        toastCookie.classList.add('d-none');
        toast.hide();
      } else {
        toastCookie.classList.remove('d-none');
        toast.show();
      }
      if (cookieAgree) {
        EventHandler.on(cookieAgree, 'click', function (event) {
          event.preventDefault();
          setCookie('cookie-agree', 'true');
          toast.hide();
        });
      }
    }
  });

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): scroll-top.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  EventHandler.on(window, 'load', function () {
    var backTopSelector = SelectorEngine.findOne('.scroll-top');
    if (backTopSelector) {
      EventHandler.on(backTopSelector, 'click', function (event) {
        event.preventDefault();
        window.scroll({
          top: 0,
          left: 0,
          behavior: 'smooth'
        });
      }, false);
      EventHandler.on(window, 'scroll', function () {
        var scrolled = document.scrollingElement.scrollTop || 0;
        if (scrolled > 300) {
          backTopSelector.classList.add('show');
        } else {
          backTopSelector.classList.remove('show');
        }
      });
    }
  });

  function _createForOfIteratorHelper$1(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray$1(r)) || e  ) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
  function _unsupportedIterableToArray$1(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray$1(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray$1(r, a) : void 0; } }
  function _arrayLikeToArray$1(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
  EventHandler.on(window, 'load', function () {
    var elements = SelectorEngine.find('[data-bs-toggle="tooltip"]');
    if (elements) {
      var _iterator = _createForOfIteratorHelper$1(elements),
        _step;
      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var element = _step.value;
          new bootstrap.Tooltip(element);
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    }
  });

  function _classCallCheck(a, n) {
    if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function");
  }

  function _defineProperties(e, r) {
    for (var t = 0; t < r.length; t++) {
      var o = r[t];
      o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, toPropertyKey(o.key), o);
    }
  }
  function _createClass(e, r, t) {
    return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", {
      writable: !1
    }), e;
  }

  function _assertThisInitialized(e) {
    if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return e;
  }

  function _possibleConstructorReturn(t, e) {
    if (e && ("object" == _typeof$1(e) || "function" == typeof e)) return e;
    if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined");
    return _assertThisInitialized(t);
  }

  function _getPrototypeOf(t) {
    return _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) {
      return t.__proto__ || Object.getPrototypeOf(t);
    }, _getPrototypeOf(t);
  }

  function _setPrototypeOf(t, e) {
    return _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) {
      return t.__proto__ = e, t;
    }, _setPrototypeOf(t, e);
  }

  function _inherits(t, e) {
    if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
    t.prototype = Object.create(e && e.prototype, {
      constructor: {
        value: t,
        writable: !0,
        configurable: !0
      }
    }), Object.defineProperty(t, "prototype", {
      writable: !1
    }), e && _setPrototypeOf(t, e);
  }

  /**
   * --------------------------------------------------------------------------
   * Bootstrap dom/data.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  /**
   * Constants
   */

  const elementMap = new Map();

  var Data = {
    set(element, key, instance) {
      if (!elementMap.has(element)) {
        elementMap.set(element, new Map());
      }

      const instanceMap = elementMap.get(element);

      // make it clear we only want one instance per element
      // can be removed later when multiple key/instances are fine to be used
      if (!instanceMap.has(key) && instanceMap.size !== 0) {
        // eslint-disable-next-line no-console
        console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(instanceMap.keys())[0]}.`);
        return
      }

      instanceMap.set(key, instance);
    },

    get(element, key) {
      if (elementMap.has(element)) {
        return elementMap.get(element).get(key) || null
      }

      return null
    },

    remove(element, key) {
      if (!elementMap.has(element)) {
        return
      }

      const instanceMap = elementMap.get(element);

      instanceMap.delete(key);

      // free up element references if there are no instances left for an element
      if (instanceMap.size === 0) {
        elementMap.delete(element);
      }
    }
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap dom/manipulator.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  function normalizeData(value) {
    if (value === 'true') {
      return true
    }

    if (value === 'false') {
      return false
    }

    if (value === Number(value).toString()) {
      return Number(value)
    }

    if (value === '' || value === 'null') {
      return null
    }

    if (typeof value !== 'string') {
      return value
    }

    try {
      return JSON.parse(decodeURIComponent(value))
    } catch {
      return value
    }
  }

  function normalizeDataKey(key) {
    return key.replace(/[A-Z]/g, chr => `-${chr.toLowerCase()}`)
  }

  const Manipulator = {
    setDataAttribute(element, key, value) {
      element.setAttribute(`data-bs-${normalizeDataKey(key)}`, value);
    },

    removeDataAttribute(element, key) {
      element.removeAttribute(`data-bs-${normalizeDataKey(key)}`);
    },

    getDataAttributes(element) {
      if (!element) {
        return {}
      }

      const attributes = {};
      const bsKeys = Object.keys(element.dataset).filter(key => key.startsWith('bs') && !key.startsWith('bsConfig'));

      for (const key of bsKeys) {
        let pureKey = key.replace(/^bs/, '');
        pureKey = pureKey.charAt(0).toLowerCase() + pureKey.slice(1, pureKey.length);
        attributes[pureKey] = normalizeData(element.dataset[key]);
      }

      return attributes
    },

    getDataAttribute(element, key) {
      return normalizeData(element.getAttribute(`data-bs-${normalizeDataKey(key)}`))
    }
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap util/config.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */


  /**
   * Class definition
   */

  class Config {
    // Getters
    static get Default() {
      return {}
    }

    static get DefaultType() {
      return {}
    }

    static get NAME() {
      throw new Error('You have to implement the static method "NAME", for each component!')
    }

    _getConfig(config) {
      config = this._mergeConfigObj(config);
      config = this._configAfterMerge(config);
      this._typeCheckConfig(config);
      return config
    }

    _configAfterMerge(config) {
      return config
    }

    _mergeConfigObj(config, element) {
      const jsonConfig = isElement(element) ? Manipulator.getDataAttribute(element, 'config') : {}; // try to parse

      return {
        ...this.constructor.Default,
        ...(typeof jsonConfig === 'object' ? jsonConfig : {}),
        ...(isElement(element) ? Manipulator.getDataAttributes(element) : {}),
        ...(typeof config === 'object' ? config : {})
      }
    }

    _typeCheckConfig(config, configTypes = this.constructor.DefaultType) {
      for (const [property, expectedTypes] of Object.entries(configTypes)) {
        const value = config[property];
        const valueType = isElement(value) ? 'element' : toType(value);

        if (!new RegExp(expectedTypes).test(valueType)) {
          throw new TypeError(
            `${this.constructor.NAME.toUpperCase()}: Option "${property}" provided type "${valueType}" but expected type "${expectedTypes}".`
          )
        }
      }
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Bootstrap base-component.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */


  /**
   * Constants
   */

  const VERSION = '5.3.3';

  /**
   * Class definition
   */

  class BaseComponent extends Config {
    constructor(element, config) {
      super();

      element = getElement(element);
      if (!element) {
        return
      }

      this._element = element;
      this._config = this._getConfig(config);

      Data.set(this._element, this.constructor.DATA_KEY, this);
    }

    // Public
    dispose() {
      Data.remove(this._element, this.constructor.DATA_KEY);
      EventHandler.off(this._element, this.constructor.EVENT_KEY);

      for (const propertyName of Object.getOwnPropertyNames(this)) {
        this[propertyName] = null;
      }
    }

    _queueCallback(callback, element, isAnimated = true) {
      executeAfterTransition(callback, element, isAnimated);
    }

    _getConfig(config) {
      config = this._mergeConfigObj(config, this._element);
      config = this._configAfterMerge(config);
      this._typeCheckConfig(config);
      return config
    }

    // Static
    static getInstance(element) {
      return Data.get(getElement(element), this.DATA_KEY)
    }

    static getOrCreateInstance(element, config = {}) {
      return this.getInstance(element) || new this(element, typeof config === 'object' ? config : null)
    }

    static get VERSION() {
      return VERSION
    }

    static get DATA_KEY() {
      return `bs.${this.NAME}`
    }

    static get EVENT_KEY() {
      return `.${this.DATA_KEY}`
    }

    static eventName(name) {
      return `${name}${this.EVENT_KEY}`
    }
  }

  function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e  ) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
  function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
  function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
  function _callSuper(t, o, e) { return o = _getPrototypeOf(o), _possibleConstructorReturn(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], _getPrototypeOf(t).constructor) : o.apply(t, e)); }
  function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }

  /**
   * Constants
   */
  var NAME = 'dropdown';
  var DATA_KEY = 'bs.dropdown';
  var EVENT_KEY = ".".concat(DATA_KEY);
  var DATA_API_KEY = '.data-api';
  var EVENT_CLICK = 'click';
  var EVENT_MOUSEOVER = "mouseover";
  var EVENT_MOUSELEAVE = "mouseleave";
  var EVENT_LOAD_DATA_API = "load".concat(EVENT_KEY).concat(DATA_API_KEY);
  var SELECTOR_OFFCANVAS = '.offcanvas';
  var SELECTOR_DATA_API = '[data-bs-toggle="dropdown"][data-bs-trigger="hover"]';
  var CLASS_NAME_DROPEND = 'dropend';
  var CLASS_NAME_DROPSTART = 'dropstart';
  var DropdownHover = /*#__PURE__*/function (_BaseComponent) {
    function DropdownHover(element) {
      var _this;
      _classCallCheck(this, DropdownHover);
      _this = _callSuper(this, DropdownHover, [element]);
      _this.offcanvas = SelectorEngine.parents(_this._element, SELECTOR_OFFCANVAS)[0];
      _this.bsDropdown = new bootstrap.Dropdown(_this._element);
      _this._handler();
      return _this;
    }

    // Getters
    _inherits(DropdownHover, _BaseComponent);
    return _createClass(DropdownHover, [{
      key: "_handler",
      value: function _handler() {
        var _this2 = this;
        EventHandler.on(this._element, EVENT_CLICK, function (event) {
          if (event.currentTarget.getAttribute('href') === '#') {
            event.preventDefault();
          }
        });
        EventHandler.on(this._element, EVENT_MOUSEOVER, function () {
          return _this2._show();
        });
        EventHandler.on(this._element.parentNode, EVENT_MOUSELEAVE, function () {
          return _this2._hide();
        });
      }
    }, {
      key: "_show",
      value: function _show() {
        if (!(this.offcanvas && this.offcanvas.classList.contains('show'))) {
          this._element.dataset.bsToggle = 'dropdown-hover';
          this.bsDropdown.show();
          this._element.blur();
          this._dropdownSubmenuHandler();
        }
      }
    }, {
      key: "_hide",
      value: function _hide() {
        if (!(this.offcanvas && this.offcanvas.classList.contains('show'))) {
          this._element.dataset.bsToggle = 'dropdown';
          this.bsDropdown.hide();
          this._dropdownSubmenuHandler();
        }
      }
    }, {
      key: "_dropdownSubmenuHandler",
      value: function _dropdownSubmenuHandler() {
        if (this.bsDropdown._menu.classList.contains('dropdown-menu-submenu')) {
          this.bsDropdown._parent.classList.add(CLASS_NAME_DROPEND);
          this.bsDropdown._parent.classList.remove(CLASS_NAME_DROPSTART);
          if (!this._elementVisible(this.bsDropdown._menu)) {
            this.bsDropdown._parent.classList.remove(CLASS_NAME_DROPEND);
            this.bsDropdown._parent.classList.add(CLASS_NAME_DROPSTART);
          }
        } else {
          this.bsDropdown._menu.classList.remove('dropdown-menu-end');
          if (!this._elementVisible(this.bsDropdown._menu)) {
            this.bsDropdown._menu.classList.add('dropdown-menu-end');
          }
        }
      }
    }, {
      key: "_elementVisible",
      value: function _elementVisible(el) {
        var rect = el.getBoundingClientRect();
        return rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth);
      }
    }], [{
      key: "NAME",
      get: function get() {
        return NAME;
      }
    }]);
  }(BaseComponent);
  /**
   * Data API implementation
   */
  EventHandler.on(window, EVENT_LOAD_DATA_API, function () {
    var _iterator = _createForOfIteratorHelper(SelectorEngine.find(SELECTOR_DATA_API)),
      _step;
    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var selector = _step.value;
        DropdownHover.getOrCreateInstance(selector);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  });

  /**
   * --------------------------------------------------------------------------
   * Isvek (v1.0.0): index.js
   * Licensed under MIT
   * --------------------------------------------------------------------------
   */

  var index = {
    DropdownHover: DropdownHover
  };

  return index;

}));
//# sourceMappingURL=theme.js.map
