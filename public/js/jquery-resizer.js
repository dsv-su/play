/**
 * @preserve FastClick: polyfill to remove click delays on browsers with touch UIs.
 *
 * @version 1.0.2
 * @codingstandard ftlabs-jsv2
 * @copyright The Financial Times Limited [All Rights Reserved]
 * @license MIT License (see LICENSE.txt)
 */
function FastClick(a, b) {
    "use strict";
    function c(a, b) {
        return function() {
            return a.apply(b, arguments)
        }
    }
    var d;
    if (b = b || {},
        this.trackingClick = !1,
        this.trackingClickStart = 0,
        this.targetElement = null,
        this.touchStartX = 0,
        this.touchStartY = 0,
        this.lastTouchIdentifier = 0,
        this.touchBoundary = b.touchBoundary || 10,
        this.layer = a,
        this.tapDelay = b.tapDelay || 200,
        !FastClick.notNeeded(a)) {
        for (var e = ["onMouse", "onClick", "onTouchStart", "onTouchMove", "onTouchEnd", "onTouchCancel"], f = this, g = 0, h = e.length; h > g; g++)
            f[e[g]] = c(f[e[g]], f);
        deviceIsAndroid && (a.addEventListener("mouseover", this.onMouse, !0),
            a.addEventListener("mousedown", this.onMouse, !0),
            a.addEventListener("mouseup", this.onMouse, !0)),
            a.addEventListener("click", this.onClick, !0),
            a.addEventListener("touchstart", this.onTouchStart, !1),
            a.addEventListener("touchmove", this.onTouchMove, !1),
            a.addEventListener("touchend", this.onTouchEnd, !1),
            a.addEventListener("touchcancel", this.onTouchCancel, !1),
        Event.prototype.stopImmediatePropagation || (a.removeEventListener = function(b, c, d) {
                var e = Node.prototype.removeEventListener;
                "click" === b ? e.call(a, b, c.hijacked || c, d) : e.call(a, b, c, d)
            }
                ,
                a.addEventListener = function(b, c, d) {
                    var e = Node.prototype.addEventListener;
                    "click" === b ? e.call(a, b, c.hijacked || (c.hijacked = function(a) {
                            a.propagationStopped || c(a)
                        }
                    ), d) : e.call(a, b, c, d)
                }
        ),
        "function" == typeof a.onclick && (d = a.onclick,
            a.addEventListener("click", function(a) {
                d(a)
            }, !1),
            a.onclick = null)
    }
}
function validateEmail(a) {
    var b = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return b.test(a)
}
!function(a, b) {
    "use strict";
    "function" == typeof define && define.amd ? define(["exports"], b) : b("object" == typeof exports ? exports : a.PubSub = {})
}("object" == typeof window && window || this, function(a) {
    "use strict";
    function b(a) {
        var b;
        for (b in a)
            if (a.hasOwnProperty(b))
                return !0;
        return !1
    }
    function c(a) {
        return function() {
            throw a
        }
    }
    function d(a, b, d) {
        try {
            a(b, d)
        } catch (e) {
            setTimeout(c(e), 0)
        }
    }
    function e(a, b, c) {
        a(b, c)
    }
    function f(a, b, c, f) {
        var g, h = j[b], i = f ? e : d;
        if (j.hasOwnProperty(b))
            for (g in h)
                h.hasOwnProperty(g) && i(h[g], a, c)
    }
    function g(a, b, c) {
        return function() {
            var d = String(a)
                , e = d.lastIndexOf(".");
            for (f(a, a, b, c); -1 !== e; )
                d = d.substr(0, e),
                    e = d.lastIndexOf("."),
                    f(a, d, b)
        }
    }
    function h(a) {
        for (var c = String(a), d = Boolean(j.hasOwnProperty(c) && b(j[c])), e = c.lastIndexOf("."); !d && -1 !== e; )
            c = c.substr(0, e),
                e = c.lastIndexOf("."),
                d = Boolean(j.hasOwnProperty(c) && b(j[c]));
        return d
    }
    function i(a, b, c, d) {
        var e = g(a, b, d)
            , f = h(a);
        return f ? (c === !0 ? e() : setTimeout(e, 0),
            !0) : !1
    }
    var j = {}
        , k = -1;
    a.publish = function(b, c) {
        return i(b, c, !1, a.immediateExceptions)
    }
        ,
        a.publishSync = function(b, c) {
            return i(b, c, !0, a.immediateExceptions)
        }
        ,
        a.subscribe = function(a, b) {
            if ("function" != typeof b)
                return !1;
            j.hasOwnProperty(a) || (j[a] = {});
            var c = "uid_" + String(++k);
            return j[a][c] = b,
                c
        }
        ,
        a.clearAllSubscriptions = function() {
            j = {}
        }
        ,
        a.unsubscribe = function(a) {
            var b, c, d, e = "string" == typeof a && j.hasOwnProperty(a), f = !e && "string" == typeof a, g = "function" == typeof a, h = !1;
            if (e)
                return void delete j[a];
            for (b in j)
                if (j.hasOwnProperty(b)) {
                    if (c = j[b],
                    f && c[a]) {
                        delete c[a],
                            h = a;
                        break
                    }
                    if (g)
                        for (d in c)
                            c.hasOwnProperty(d) && c[d] === a && (delete c[d],
                                h = !0)
                }
            return h
        }
}),
    function() {
        var a = this
            , b = a._
            , c = Array.prototype
            , d = Object.prototype
            , e = Function.prototype
            , f = c.push
            , g = c.slice
            , h = c.concat
            , i = d.toString
            , j = d.hasOwnProperty
            , k = Array.isArray
            , l = Object.keys
            , m = e.bind
            , n = function(a) {
            return a instanceof n ? a : this instanceof n ? void (this._wrapped = a) : new n(a)
        };
        "undefined" != typeof exports ? ("undefined" != typeof module && module.exports && (exports = module.exports = n),
            exports._ = n) : a._ = n,
            n.VERSION = "1.7.0";
        var o = function(a, b, c) {
            if (void 0 === b)
                return a;
            switch (null == c ? 3 : c) {
                case 1:
                    return function(c) {
                        return a.call(b, c)
                    }
                        ;
                case 2:
                    return function(c, d) {
                        return a.call(b, c, d)
                    }
                        ;
                case 3:
                    return function(c, d, e) {
                        return a.call(b, c, d, e)
                    }
                        ;
                case 4:
                    return function(c, d, e, f) {
                        return a.call(b, c, d, e, f)
                    }
            }
            return function() {
                return a.apply(b, arguments)
            }
        };
        n.iteratee = function(a, b, c) {
            return null == a ? n.identity : n.isFunction(a) ? o(a, b, c) : n.isObject(a) ? n.matches(a) : n.property(a)
        }
            ,
            n.each = n.forEach = function(a, b, c) {
                if (null == a)
                    return a;
                b = o(b, c);
                var d, e = a.length;
                if (e === +e)
                    for (d = 0; e > d; d++)
                        b(a[d], d, a);
                else {
                    var f = n.keys(a);
                    for (d = 0,
                             e = f.length; e > d; d++)
                        b(a[f[d]], f[d], a)
                }
                return a
            }
            ,
            n.map = n.collect = function(a, b, c) {
                if (null == a)
                    return [];
                b = n.iteratee(b, c);
                for (var d, e = a.length !== +a.length && n.keys(a), f = (e || a).length, g = Array(f), h = 0; f > h; h++)
                    d = e ? e[h] : h,
                        g[h] = b(a[d], d, a);
                return g
            }
        ;
        var p = "Reduce of empty array with no initial value";
        n.reduce = n.foldl = n.inject = function(a, b, c, d) {
            null == a && (a = []),
                b = o(b, d, 4);
            var e, f = a.length !== +a.length && n.keys(a), g = (f || a).length, h = 0;
            if (arguments.length < 3) {
                if (!g)
                    throw new TypeError(p);
                c = a[f ? f[h++] : h++]
            }
            for (; g > h; h++)
                e = f ? f[h] : h,
                    c = b(c, a[e], e, a);
            return c
        }
            ,
            n.reduceRight = n.foldr = function(a, b, c, d) {
                null == a && (a = []),
                    b = o(b, d, 4);
                var e, f = a.length !== +a.length && n.keys(a), g = (f || a).length;
                if (arguments.length < 3) {
                    if (!g)
                        throw new TypeError(p);
                    c = a[f ? f[--g] : --g]
                }
                for (; g--; )
                    e = f ? f[g] : g,
                        c = b(c, a[e], e, a);
                return c
            }
            ,
            n.find = n.detect = function(a, b, c) {
                var d;
                return b = n.iteratee(b, c),
                    n.some(a, function(a, c, e) {
                        return b(a, c, e) ? (d = a,
                            !0) : void 0
                    }),
                    d
            }
            ,
            n.filter = n.select = function(a, b, c) {
                var d = [];
                return null == a ? d : (b = n.iteratee(b, c),
                    n.each(a, function(a, c, e) {
                        b(a, c, e) && d.push(a)
                    }),
                    d)
            }
            ,
            n.reject = function(a, b, c) {
                return n.filter(a, n.negate(n.iteratee(b)), c)
            }
            ,
            n.every = n.all = function(a, b, c) {
                if (null == a)
                    return !0;
                b = n.iteratee(b, c);
                var d, e, f = a.length !== +a.length && n.keys(a), g = (f || a).length;
                for (d = 0; g > d; d++)
                    if (e = f ? f[d] : d,
                        !b(a[e], e, a))
                        return !1;
                return !0
            }
            ,
            n.some = n.any = function(a, b, c) {
                if (null == a)
                    return !1;
                b = n.iteratee(b, c);
                var d, e, f = a.length !== +a.length && n.keys(a), g = (f || a).length;
                for (d = 0; g > d; d++)
                    if (e = f ? f[d] : d,
                        b(a[e], e, a))
                        return !0;
                return !1
            }
            ,
            n.contains = n.include = function(a, b) {
                return null == a ? !1 : (a.length !== +a.length && (a = n.values(a)),
                n.indexOf(a, b) >= 0)
            }
            ,
            n.invoke = function(a, b) {
                var c = g.call(arguments, 2)
                    , d = n.isFunction(b);
                return n.map(a, function(a) {
                    return (d ? b : a[b]).apply(a, c)
                })
            }
            ,
            n.pluck = function(a, b) {
                return n.map(a, n.property(b))
            }
            ,
            n.where = function(a, b) {
                return n.filter(a, n.matches(b))
            }
            ,
            n.findWhere = function(a, b) {
                return n.find(a, n.matches(b))
            }
            ,
            n.max = function(a, b, c) {
                var d, e, f = -1 / 0, g = -1 / 0;
                if (null == b && null != a) {
                    a = a.length === +a.length ? a : n.values(a);
                    for (var h = 0, i = a.length; i > h; h++)
                        d = a[h],
                        d > f && (f = d)
                } else
                    b = n.iteratee(b, c),
                        n.each(a, function(a, c, d) {
                            e = b(a, c, d),
                            (e > g || e === -1 / 0 && f === -1 / 0) && (f = a,
                                g = e)
                        });
                return f
            }
            ,
            n.min = function(a, b, c) {
                var d, e, f = 1 / 0, g = 1 / 0;
                if (null == b && null != a) {
                    a = a.length === +a.length ? a : n.values(a);
                    for (var h = 0, i = a.length; i > h; h++)
                        d = a[h],
                        f > d && (f = d)
                } else
                    b = n.iteratee(b, c),
                        n.each(a, function(a, c, d) {
                            e = b(a, c, d),
                            (g > e || 1 / 0 === e && 1 / 0 === f) && (f = a,
                                g = e)
                        });
                return f
            }
            ,
            n.shuffle = function(a) {
                for (var b, c = a && a.length === +a.length ? a : n.values(a), d = c.length, e = Array(d), f = 0; d > f; f++)
                    b = n.random(0, f),
                    b !== f && (e[f] = e[b]),
                        e[b] = c[f];
                return e
            }
            ,
            n.sample = function(a, b, c) {
                return null == b || c ? (a.length !== +a.length && (a = n.values(a)),
                    a[n.random(a.length - 1)]) : n.shuffle(a).slice(0, Math.max(0, b))
            }
            ,
            n.sortBy = function(a, b, c) {
                return b = n.iteratee(b, c),
                    n.pluck(n.map(a, function(a, c, d) {
                        return {
                            value: a,
                            index: c,
                            criteria: b(a, c, d)
                        }
                    }).sort(function(a, b) {
                        var c = a.criteria
                            , d = b.criteria;
                        if (c !== d) {
                            if (c > d || void 0 === c)
                                return 1;
                            if (d > c || void 0 === d)
                                return -1
                        }
                        return a.index - b.index
                    }), "value")
            }
        ;
        var q = function(a) {
            return function(b, c, d) {
                var e = {};
                return c = n.iteratee(c, d),
                    n.each(b, function(d, f) {
                        var g = c(d, f, b);
                        a(e, d, g)
                    }),
                    e
            }
        };
        n.groupBy = q(function(a, b, c) {
            n.has(a, c) ? a[c].push(b) : a[c] = [b]
        }),
            n.indexBy = q(function(a, b, c) {
                a[c] = b
            }),
            n.countBy = q(function(a, b, c) {
                n.has(a, c) ? a[c]++ : a[c] = 1
            }),
            n.sortedIndex = function(a, b, c, d) {
                c = n.iteratee(c, d, 1);
                for (var e = c(b), f = 0, g = a.length; g > f; ) {
                    var h = f + g >>> 1;
                    c(a[h]) < e ? f = h + 1 : g = h
                }
                return f
            }
            ,
            n.toArray = function(a) {
                return a ? n.isArray(a) ? g.call(a) : a.length === +a.length ? n.map(a, n.identity) : n.values(a) : []
            }
            ,
            n.size = function(a) {
                return null == a ? 0 : a.length === +a.length ? a.length : n.keys(a).length
            }
            ,
            n.partition = function(a, b, c) {
                b = n.iteratee(b, c);
                var d = []
                    , e = [];
                return n.each(a, function(a, c, f) {
                    (b(a, c, f) ? d : e).push(a)
                }),
                    [d, e]
            }
            ,
            n.first = n.head = n.take = function(a, b, c) {
                return null == a ? void 0 : null == b || c ? a[0] : 0 > b ? [] : g.call(a, 0, b)
            }
            ,
            n.initial = function(a, b, c) {
                return g.call(a, 0, Math.max(0, a.length - (null == b || c ? 1 : b)))
            }
            ,
            n.last = function(a, b, c) {
                return null == a ? void 0 : null == b || c ? a[a.length - 1] : g.call(a, Math.max(a.length - b, 0))
            }
            ,
            n.rest = n.tail = n.drop = function(a, b, c) {
                return g.call(a, null == b || c ? 1 : b)
            }
            ,
            n.compact = function(a) {
                return n.filter(a, n.identity)
            }
        ;
        var r = function(a, b, c, d) {
            if (b && n.every(a, n.isArray))
                return h.apply(d, a);
            for (var e = 0, g = a.length; g > e; e++) {
                var i = a[e];
                n.isArray(i) || n.isArguments(i) ? b ? f.apply(d, i) : r(i, b, c, d) : c || d.push(i)
            }
            return d
        };
        n.flatten = function(a, b) {
            return r(a, b, !1, [])
        }
            ,
            n.without = function(a) {
                return n.difference(a, g.call(arguments, 1))
            }
            ,
            n.uniq = n.unique = function(a, b, c, d) {
                if (null == a)
                    return [];
                n.isBoolean(b) || (d = c,
                    c = b,
                    b = !1),
                null != c && (c = n.iteratee(c, d));
                for (var e = [], f = [], g = 0, h = a.length; h > g; g++) {
                    var i = a[g];
                    if (b)
                        g && f === i || e.push(i),
                            f = i;
                    else if (c) {
                        var j = c(i, g, a);
                        n.indexOf(f, j) < 0 && (f.push(j),
                            e.push(i))
                    } else
                        n.indexOf(e, i) < 0 && e.push(i)
                }
                return e
            }
            ,
            n.union = function() {
                return n.uniq(r(arguments, !0, !0, []))
            }
            ,
            n.intersection = function(a) {
                if (null == a)
                    return [];
                for (var b = [], c = arguments.length, d = 0, e = a.length; e > d; d++) {
                    var f = a[d];
                    if (!n.contains(b, f)) {
                        for (var g = 1; c > g && n.contains(arguments[g], f); g++)
                            ;
                        g === c && b.push(f)
                    }
                }
                return b
            }
            ,
            n.difference = function(a) {
                var b = r(g.call(arguments, 1), !0, !0, []);
                return n.filter(a, function(a) {
                    return !n.contains(b, a)
                })
            }
            ,
            n.zip = function(a) {
                if (null == a)
                    return [];
                for (var b = n.max(arguments, "length").length, c = Array(b), d = 0; b > d; d++)
                    c[d] = n.pluck(arguments, d);
                return c
            }
            ,
            n.object = function(a, b) {
                if (null == a)
                    return {};
                for (var c = {}, d = 0, e = a.length; e > d; d++)
                    b ? c[a[d]] = b[d] : c[a[d][0]] = a[d][1];
                return c
            }
            ,
            n.indexOf = function(a, b, c) {
                if (null == a)
                    return -1;
                var d = 0
                    , e = a.length;
                if (c) {
                    if ("number" != typeof c)
                        return d = n.sortedIndex(a, b),
                            a[d] === b ? d : -1;
                    d = 0 > c ? Math.max(0, e + c) : c
                }
                for (; e > d; d++)
                    if (a[d] === b)
                        return d;
                return -1
            }
            ,
            n.lastIndexOf = function(a, b, c) {
                if (null == a)
                    return -1;
                var d = a.length;
                for ("number" == typeof c && (d = 0 > c ? d + c + 1 : Math.min(d, c + 1)); --d >= 0; )
                    if (a[d] === b)
                        return d;
                return -1
            }
            ,
            n.range = function(a, b, c) {
                arguments.length <= 1 && (b = a || 0,
                    a = 0),
                    c = c || 1;
                for (var d = Math.max(Math.ceil((b - a) / c), 0), e = Array(d), f = 0; d > f; f++,
                    a += c)
                    e[f] = a;
                return e
            }
        ;
        var s = function() {};
        n.bind = function(a, b) {
            var c, d;
            if (m && a.bind === m)
                return m.apply(a, g.call(arguments, 1));
            if (!n.isFunction(a))
                throw new TypeError("Bind must be called on a function");
            return c = g.call(arguments, 2),
                d = function() {
                    if (!(this instanceof d))
                        return a.apply(b, c.concat(g.call(arguments)));
                    s.prototype = a.prototype;
                    var e = new s;
                    s.prototype = null;
                    var f = a.apply(e, c.concat(g.call(arguments)));
                    return n.isObject(f) ? f : e
                }
        }
            ,
            n.partial = function(a) {
                var b = g.call(arguments, 1);
                return function() {
                    for (var c = 0, d = b.slice(), e = 0, f = d.length; f > e; e++)
                        d[e] === n && (d[e] = arguments[c++]);
                    for (; c < arguments.length; )
                        d.push(arguments[c++]);
                    return a.apply(this, d)
                }
            }
            ,
            n.bindAll = function(a) {
                var b, c, d = arguments.length;
                if (1 >= d)
                    throw new Error("bindAll must be passed function names");
                for (b = 1; d > b; b++)
                    c = arguments[b],
                        a[c] = n.bind(a[c], a);
                return a
            }
            ,
            n.memoize = function(a, b) {
                var c = function(d) {
                    var e = c.cache
                        , f = b ? b.apply(this, arguments) : d;
                    return n.has(e, f) || (e[f] = a.apply(this, arguments)),
                        e[f]
                };
                return c.cache = {},
                    c
            }
            ,
            n.delay = function(a, b) {
                var c = g.call(arguments, 2);
                return setTimeout(function() {
                    return a.apply(null, c)
                }, b)
            }
            ,
            n.defer = function(a) {
                return n.delay.apply(n, [a, 1].concat(g.call(arguments, 1)))
            }
            ,
            n.throttle = function(a, b, c) {
                var d, e, f, g = null, h = 0;
                c || (c = {});
                var i = function() {
                    h = c.leading === !1 ? 0 : n.now(),
                        g = null,
                        f = a.apply(d, e),
                    g || (d = e = null)
                };
                return function() {
                    var j = n.now();
                    h || c.leading !== !1 || (h = j);
                    var k = b - (j - h);
                    return d = this,
                        e = arguments,
                        0 >= k || k > b ? (clearTimeout(g),
                            g = null,
                            h = j,
                            f = a.apply(d, e),
                        g || (d = e = null)) : g || c.trailing === !1 || (g = setTimeout(i, k)),
                        f
                }
            }
            ,
            n.debounce = function(a, b, c) {
                var d, e, f, g, h, i = function() {
                    var j = n.now() - g;
                    b > j && j > 0 ? d = setTimeout(i, b - j) : (d = null,
                    c || (h = a.apply(f, e),
                    d || (f = e = null)))
                };
                return function() {
                    f = this,
                        e = arguments,
                        g = n.now();
                    var j = c && !d;
                    return d || (d = setTimeout(i, b)),
                    j && (h = a.apply(f, e),
                        f = e = null),
                        h
                }
            }
            ,
            n.wrap = function(a, b) {
                return n.partial(b, a)
            }
            ,
            n.negate = function(a) {
                return function() {
                    return !a.apply(this, arguments)
                }
            }
            ,
            n.compose = function() {
                var a = arguments
                    , b = a.length - 1;
                return function() {
                    for (var c = b, d = a[b].apply(this, arguments); c--; )
                        d = a[c].call(this, d);
                    return d
                }
            }
            ,
            n.after = function(a, b) {
                return function() {
                    return --a < 1 ? b.apply(this, arguments) : void 0
                }
            }
            ,
            n.before = function(a, b) {
                var c;
                return function() {
                    return --a > 0 ? c = b.apply(this, arguments) : b = null,
                        c
                }
            }
            ,
            n.once = n.partial(n.before, 2),
            n.keys = function(a) {
                if (!n.isObject(a))
                    return [];
                if (l)
                    return l(a);
                var b = [];
                for (var c in a)
                    n.has(a, c) && b.push(c);
                return b
            }
            ,
            n.values = function(a) {
                for (var b = n.keys(a), c = b.length, d = Array(c), e = 0; c > e; e++)
                    d[e] = a[b[e]];
                return d
            }
            ,
            n.pairs = function(a) {
                for (var b = n.keys(a), c = b.length, d = Array(c), e = 0; c > e; e++)
                    d[e] = [b[e], a[b[e]]];
                return d
            }
            ,
            n.invert = function(a) {
                for (var b = {}, c = n.keys(a), d = 0, e = c.length; e > d; d++)
                    b[a[c[d]]] = c[d];
                return b
            }
            ,
            n.functions = n.methods = function(a) {
                var b = [];
                for (var c in a)
                    n.isFunction(a[c]) && b.push(c);
                return b.sort()
            }
            ,
            n.extend = function(a) {
                if (!n.isObject(a))
                    return a;
                for (var b, c, d = 1, e = arguments.length; e > d; d++) {
                    b = arguments[d];
                    for (c in b)
                        j.call(b, c) && (a[c] = b[c])
                }
                return a
            }
            ,
            n.pick = function(a, b, c) {
                var d, e = {};
                if (null == a)
                    return e;
                if (n.isFunction(b)) {
                    b = o(b, c);
                    for (d in a) {
                        var f = a[d];
                        b(f, d, a) && (e[d] = f)
                    }
                } else {
                    var i = h.apply([], g.call(arguments, 1));
                    a = new Object(a);
                    for (var j = 0, k = i.length; k > j; j++)
                        d = i[j],
                        d in a && (e[d] = a[d])
                }
                return e
            }
            ,
            n.omit = function(a, b, c) {
                if (n.isFunction(b))
                    b = n.negate(b);
                else {
                    var d = n.map(h.apply([], g.call(arguments, 1)), String);
                    b = function(a, b) {
                        return !n.contains(d, b)
                    }
                }
                return n.pick(a, b, c)
            }
            ,
            n.defaults = function(a) {
                if (!n.isObject(a))
                    return a;
                for (var b = 1, c = arguments.length; c > b; b++) {
                    var d = arguments[b];
                    for (var e in d)
                        void 0 === a[e] && (a[e] = d[e])
                }
                return a
            }
            ,
            n.clone = function(a) {
                return n.isObject(a) ? n.isArray(a) ? a.slice() : n.extend({}, a) : a
            }
            ,
            n.tap = function(a, b) {
                return b(a),
                    a
            }
        ;
        var t = function(a, b, c, d) {
            if (a === b)
                return 0 !== a || 1 / a === 1 / b;
            if (null == a || null == b)
                return a === b;
            a instanceof n && (a = a._wrapped),
            b instanceof n && (b = b._wrapped);
            var e = i.call(a);
            if (e !== i.call(b))
                return !1;
            switch (e) {
                case "[object RegExp]":
                case "[object String]":
                    return "" + a == "" + b;
                case "[object Number]":
                    return +a !== +a ? +b !== +b : 0 === +a ? 1 / +a === 1 / b : +a === +b;
                case "[object Date]":
                case "[object Boolean]":
                    return +a === +b
            }
            if ("object" != typeof a || "object" != typeof b)
                return !1;
            for (var f = c.length; f--; )
                if (c[f] === a)
                    return d[f] === b;
            var g = a.constructor
                , h = b.constructor;
            if (g !== h && "constructor"in a && "constructor"in b && !(n.isFunction(g) && g instanceof g && n.isFunction(h) && h instanceof h))
                return !1;
            c.push(a),
                d.push(b);
            var j, k;
            if ("[object Array]" === e) {
                if (j = a.length,
                    k = j === b.length)
                    for (; j-- && (k = t(a[j], b[j], c, d)); )
                        ;
            } else {
                var l, m = n.keys(a);
                if (j = m.length,
                    k = n.keys(b).length === j)
                    for (; j-- && (l = m[j],
                        k = n.has(b, l) && t(a[l], b[l], c, d)); )
                        ;
            }
            return c.pop(),
                d.pop(),
                k
        };
        n.isEqual = function(a, b) {
            return t(a, b, [], [])
        }
            ,
            n.isEmpty = function(a) {
                if (null == a)
                    return !0;
                if (n.isArray(a) || n.isString(a) || n.isArguments(a))
                    return 0 === a.length;
                for (var b in a)
                    if (n.has(a, b))
                        return !1;
                return !0
            }
            ,
            n.isElement = function(a) {
                return !(!a || 1 !== a.nodeType)
            }
            ,
            n.isArray = k || function(a) {
                return "[object Array]" === i.call(a)
            }
            ,
            n.isObject = function(a) {
                var b = typeof a;
                return "function" === b || "object" === b && !!a
            }
            ,
            n.each(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function(a) {
                n["is" + a] = function(b) {
                    return i.call(b) === "[object " + a + "]"
                }
            }),
        n.isArguments(arguments) || (n.isArguments = function(a) {
                return n.has(a, "callee")
            }
        ),
        "function" != typeof /./ && (n.isFunction = function(a) {
                return "function" == typeof a || !1
            }
        ),
            n.isFinite = function(a) {
                return isFinite(a) && !isNaN(parseFloat(a))
            }
            ,
            n.isNaN = function(a) {
                return n.isNumber(a) && a !== +a
            }
            ,
            n.isBoolean = function(a) {
                return a === !0 || a === !1 || "[object Boolean]" === i.call(a)
            }
            ,
            n.isNull = function(a) {
                return null === a
            }
            ,
            n.isUndefined = function(a) {
                return void 0 === a
            }
            ,
            n.has = function(a, b) {
                return null != a && j.call(a, b)
            }
            ,
            n.noConflict = function() {
                return a._ = b,
                    this
            }
            ,
            n.identity = function(a) {
                return a
            }
            ,
            n.constant = function(a) {
                return function() {
                    return a
                }
            }
            ,
            n.noop = function() {}
            ,
            n.property = function(a) {
                return function(b) {
                    return b[a]
                }
            }
            ,
            n.matches = function(a) {
                var b = n.pairs(a)
                    , c = b.length;
                return function(a) {
                    if (null == a)
                        return !c;
                    a = new Object(a);
                    for (var d = 0; c > d; d++) {
                        var e = b[d]
                            , f = e[0];
                        if (e[1] !== a[f] || !(f in a))
                            return !1
                    }
                    return !0
                }
            }
            ,
            n.times = function(a, b, c) {
                var d = Array(Math.max(0, a));
                b = o(b, c, 1);
                for (var e = 0; a > e; e++)
                    d[e] = b(e);
                return d
            }
            ,
            n.random = function(a, b) {
                return null == b && (b = a,
                    a = 0),
                a + Math.floor(Math.random() * (b - a + 1))
            }
            ,
            n.now = Date.now || function() {
                return (new Date).getTime()
            }
        ;
        var u = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#x27;",
            "`": "&#x60;"
        }
            , v = n.invert(u)
            , w = function(a) {
            var b = function(b) {
                return a[b]
            }
                , c = "(?:" + n.keys(a).join("|") + ")"
                , d = RegExp(c)
                , e = RegExp(c, "g");
            return function(a) {
                return a = null == a ? "" : "" + a,
                    d.test(a) ? a.replace(e, b) : a
            }
        };
        n.escape = w(u),
            n.unescape = w(v),
            n.result = function(a, b) {
                if (null == a)
                    return void 0;
                var c = a[b];
                return n.isFunction(c) ? a[b]() : c
            }
        ;
        var x = 0;
        n.uniqueId = function(a) {
            var b = ++x + "";
            return a ? a + b : b
        }
            ,
            n.templateSettings = {
                evaluate: /<%([\s\S]+?)%>/g,
                interpolate: /<%=([\s\S]+?)%>/g,
                escape: /<%-([\s\S]+?)%>/g
            };
        var y = /(.)^/
            , z = {
            "'": "'",
            "\\": "\\",
            "\r": "r",
            "\n": "n",
            "\u2028": "u2028",
            "\u2029": "u2029"
        }
            , A = /\\|'|\r|\n|\u2028|\u2029/g
            , B = function(a) {
            return "\\" + z[a]
        };
        n.template = function(a, b, c) {
            !b && c && (b = c),
                b = n.defaults({}, b, n.templateSettings);
            var d = RegExp([(b.escape || y).source, (b.interpolate || y).source, (b.evaluate || y).source].join("|") + "|$", "g")
                , e = 0
                , f = "__p+='";
            a.replace(d, function(b, c, d, g, h) {
                return f += a.slice(e, h).replace(A, B),
                    e = h + b.length,
                    c ? f += "'+\n((__t=(" + c + "))==null?'':_.escape(__t))+\n'" : d ? f += "'+\n((__t=(" + d + "))==null?'':__t)+\n'" : g && (f += "';\n" + g + "\n__p+='"),
                    b
            }),
                f += "';\n",
            b.variable || (f = "with(obj||{}){\n" + f + "}\n"),
                f = "var __t,__p='',__j=Array.prototype.join,print=function(){__p+=__j.call(arguments,'');};\n" + f + "return __p;\n";
            try {
                var g = new Function(b.variable || "obj","_",f)
            } catch (h) {
                throw h.source = f,
                    h
            }
            var i = function(a) {
                return g.call(this, a, n)
            }
                , j = b.variable || "obj";
            return i.source = "function(" + j + "){\n" + f + "}",
                i
        }
            ,
            n.chain = function(a) {
                var b = n(a);
                return b._chain = !0,
                    b
            }
        ;
        var C = function(a) {
            return this._chain ? n(a).chain() : a
        };
        n.mixin = function(a) {
            n.each(n.functions(a), function(b) {
                var c = n[b] = a[b];
                n.prototype[b] = function() {
                    var a = [this._wrapped];
                    return f.apply(a, arguments),
                        C.call(this, c.apply(n, a))
                }
            })
        }
            ,
            n.mixin(n),
            n.each(["pop", "push", "reverse", "shift", "sort", "splice", "unshift"], function(a) {
                var b = c[a];
                n.prototype[a] = function() {
                    var c = this._wrapped;
                    return b.apply(c, arguments),
                    "shift" !== a && "splice" !== a || 0 !== c.length || delete c[0],
                        C.call(this, c)
                }
            }),
            n.each(["concat", "join", "slice"], function(a) {
                var b = c[a];
                n.prototype[a] = function() {
                    return C.call(this, b.apply(this._wrapped, arguments))
                }
            }),
            n.prototype.value = function() {
                return this._wrapped
            }
            ,
        "function" == typeof define && define.amd && define("underscore", [], function() {
            return n
        })
    }
        .call(this),
    /*!
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

    function(a, b) {
        "$:nomunge";
        var c, d = a.jQuery || a.Cowboy || (a.Cowboy = {});
        d.throttle = c = function(a, c, e, f) {
            function g() {
                function d() {
                    i = +new Date,
                        e.apply(j, l)
                }
                function g() {
                    h = b
                }
                var j = this
                    , k = +new Date - i
                    , l = arguments;
                f && !h && d(),
                h && clearTimeout(h),
                    f === b && k > a ? d() : c !== !0 && (h = setTimeout(f ? g : d, f === b ? a - k : a))
            }
            var h, i = 0;
            return "boolean" != typeof c && (f = e,
                e = c,
                c = b),
            d.guid && (g.guid = e.guid = e.guid || d.guid++),
                g
        }
            ,
            d.debounce = function(a, d, e) {
                return e === b ? c(a, d, !1) : c(a, e, d !== !1)
            }
    }(this),
    function(a) {
        var b = "waitForImages";
        a.waitForImages = {
            hasImageProperties: ["backgroundImage", "listStyleImage", "borderImage", "borderCornerImage"]
        },
            a.expr[":"].uncached = function(b) {
                if (!a(b).is('img[src!=""]'))
                    return !1;
                var c = document.createElement("img");
                return c.src = b.src,
                    !c.complete
            }
            ,
            a.fn.waitForImages = function(c, d, e) {
                if (a.isPlainObject(arguments[0]) && (d = c.each,
                    e = c.waitForAll,
                    c = c.finished),
                    c = c || a.noop,
                    d = d || a.noop,
                    e = !!e,
                !a.isFunction(c) || !a.isFunction(d))
                    throw new TypeError("An invalid callback was supplied.");
                return this.each(function() {
                    var f = a(this)
                        , g = [];
                    if (e) {
                        var h = a.waitForImages.hasImageProperties || []
                            , i = /url\((['"]?)(.*?)\1\)/g;
                        f.find("*").each(function() {
                            var b = a(this);
                            b.is("img:uncached") && g.push({
                                src: b.attr("src"),
                                element: b[0]
                            }),
                                a.each(h, function(a, c) {
                                    var d = b.css(c);
                                    if (!d)
                                        return !0;
                                    for (var e; e = i.exec(d); )
                                        g.push({
                                            src: e[2],
                                            element: b[0]
                                        })
                                })
                        })
                    } else
                        f.find("img:uncached").each(function() {
                            g.push({
                                src: this.src,
                                element: this
                            })
                        });
                    var j = g.length
                        , k = 0;
                    0 == j && c.call(f[0]),
                        a.each(g, function(e, g) {
                            var h = new Image;
                            a(h).bind("load." + b + " error." + b, function(a) {
                                return k++,
                                    d.call(g.element, k, j, "load" == a.type),
                                    k == j ? (c.call(f[0]),
                                        !1) : void 0
                            }),
                                h.src = g.src
                        })
                })
            }
    }(jQuery),
    /*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */

    function(a) {
        "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
    }(function(a) {
        function b(a) {
            return h.raw ? a : encodeURIComponent(a)
        }
        function c(a) {
            return h.raw ? a : decodeURIComponent(a)
        }
        function d(a) {
            return b(h.json ? JSON.stringify(a) : String(a))
        }
        function e(a) {
            0 === a.indexOf('"') && (a = a.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
            try {
                return a = decodeURIComponent(a.replace(g, " ")),
                    h.json ? JSON.parse(a) : a
            } catch (b) {}
        }
        function f(b, c) {
            var d = h.raw ? b : e(b);
            return a.isFunction(c) ? c(d) : d
        }
        var g = /\+/g
            , h = a.cookie = function(e, g, i) {
                if (arguments.length > 1 && !a.isFunction(g)) {
                    if (i = a.extend({}, h.defaults, i),
                    "number" == typeof i.expires) {
                        var j = i.expires
                            , k = i.expires = new Date;
                        k.setTime(+k + 864e5 * j)
                    }
                    return document.cookie = [b(e), "=", d(g), i.expires ? "; expires=" + i.expires.toUTCString() : "", i.path ? "; path=" + i.path : "", i.domain ? "; domain=" + i.domain : "", i.secure ? "; secure" : ""].join("")
                }
                for (var l = e ? void 0 : {}, m = document.cookie ? document.cookie.split("; ") : [], n = 0, o = m.length; o > n; n++) {
                    var p = m[n].split("=")
                        , q = c(p.shift())
                        , r = p.join("=");
                    if (e && e === q) {
                        l = f(r, g);
                        break
                    }
                    e || void 0 === (r = f(r)) || (l[q] = r)
                }
                return l
            }
        ;
        h.defaults = {},
            a.removeCookie = function(b, c) {
                return void 0 === a.cookie(b) ? !1 : (a.cookie(b, "", a.extend({}, c, {
                    expires: -1
                })),
                    !a.cookie(b))
            }
    });
var deviceIsAndroid = navigator.userAgent.indexOf("Android") > 0
    , deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent)
    , deviceIsIOS4 = deviceIsIOS && /OS 4_\d(_\d)?/.test(navigator.userAgent)
    , deviceIsIOSWithBadTarget = deviceIsIOS && /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent)
    , deviceIsBlackBerry10 = navigator.userAgent.indexOf("BB10") > 0;
FastClick.prototype.needsClick = function(a) {
    "use strict";
    switch (a.nodeName.toLowerCase()) {
        case "button":
        case "select":
        case "textarea":
            if (a.disabled)
                return !0;
            break;
        case "input":
            if (deviceIsIOS && "file" === a.type || a.disabled)
                return !0;
            break;
        case "label":
        case "video":
            return !0
    }
    return /\bneedsclick\b/.test(a.className)
}
    ,
    FastClick.prototype.needsFocus = function(a) {
        "use strict";
        switch (a.nodeName.toLowerCase()) {
            case "textarea":
                return !0;
            case "select":
                return !deviceIsAndroid;
            case "input":
                switch (a.type) {
                    case "button":
                    case "checkbox":
                    case "file":
                    case "image":
                    case "radio":
                    case "submit":
                        return !1
                }
                return !a.disabled && !a.readOnly;
            default:
                return /\bneedsfocus\b/.test(a.className)
        }
    }
    ,
    FastClick.prototype.sendClick = function(a, b) {
        "use strict";
        var c, d;
        document.activeElement && document.activeElement !== a && document.activeElement.blur(),
            d = b.changedTouches[0],
            c = document.createEvent("MouseEvents"),
            c.initMouseEvent(this.determineEventType(a), !0, !0, window, 1, d.screenX, d.screenY, d.clientX, d.clientY, !1, !1, !1, !1, 0, null),
            c.forwardedTouchEvent = !0,
            a.dispatchEvent(c)
    }
    ,
    FastClick.prototype.determineEventType = function(a) {
        "use strict";
        return deviceIsAndroid && "select" === a.tagName.toLowerCase() ? "mousedown" : "click"
    }
    ,
    FastClick.prototype.focus = function(a) {
        "use strict";
        var b;
        deviceIsIOS && a.setSelectionRange && 0 !== a.type.indexOf("date") && "time" !== a.type ? (b = a.value.length,
            a.setSelectionRange(b, b)) : a.focus()
    }
    ,
    FastClick.prototype.updateScrollParent = function(a) {
        "use strict";
        var b, c;
        if (b = a.fastClickScrollParent,
        !b || !b.contains(a)) {
            c = a;
            do {
                if (c.scrollHeight > c.offsetHeight) {
                    b = c,
                        a.fastClickScrollParent = c;
                    break
                }
                c = c.parentElement
            } while (c)
        }
        b && (b.fastClickLastScrollTop = b.scrollTop)
    }
    ,
    FastClick.prototype.getTargetElementFromEventTarget = function(a) {
        "use strict";
        return a.nodeType === Node.TEXT_NODE ? a.parentNode : a
    }
    ,
    FastClick.prototype.onTouchStart = function(a) {
        "use strict";
        var b, c, d;
        if (a.targetTouches.length > 1)
            return !0;
        if (b = this.getTargetElementFromEventTarget(a.target),
            c = a.targetTouches[0],
            deviceIsIOS) {
            if (d = window.getSelection(),
            d.rangeCount && !d.isCollapsed)
                return !0;
            if (!deviceIsIOS4) {
                if (c.identifier === this.lastTouchIdentifier)
                    return a.preventDefault(),
                        !1;
                this.lastTouchIdentifier = c.identifier,
                    this.updateScrollParent(b)
            }
        }
        return this.trackingClick = !0,
            this.trackingClickStart = a.timeStamp,
            this.targetElement = b,
            this.touchStartX = c.pageX,
            this.touchStartY = c.pageY,
        a.timeStamp - this.lastClickTime < this.tapDelay && a.preventDefault(),
            !0
    }
    ,
    FastClick.prototype.touchHasMoved = function(a) {
        "use strict";
        var b = a.changedTouches[0]
            , c = this.touchBoundary;
        return Math.abs(b.pageX - this.touchStartX) > c || Math.abs(b.pageY - this.touchStartY) > c ? !0 : !1
    }
    ,
    FastClick.prototype.onTouchMove = function(a) {
        "use strict";
        return this.trackingClick ? ((this.targetElement !== this.getTargetElementFromEventTarget(a.target) || this.touchHasMoved(a)) && (this.trackingClick = !1,
            this.targetElement = null),
            !0) : !0
    }
    ,
    FastClick.prototype.findControl = function(a) {
        "use strict";
        return void 0 !== a.control ? a.control : a.htmlFor ? document.getElementById(a.htmlFor) : a.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")
    }
    ,
    FastClick.prototype.onTouchEnd = function(a) {
        "use strict";
        var b, c, d, e, f, g = this.targetElement;
        if (!this.trackingClick)
            return !0;
        if (a.timeStamp - this.lastClickTime < this.tapDelay)
            return this.cancelNextClick = !0,
                !0;
        if (this.cancelNextClick = !1,
            this.lastClickTime = a.timeStamp,
            c = this.trackingClickStart,
            this.trackingClick = !1,
            this.trackingClickStart = 0,
        deviceIsIOSWithBadTarget && (f = a.changedTouches[0],
            g = document.elementFromPoint(f.pageX - window.pageXOffset, f.pageY - window.pageYOffset) || g,
            g.fastClickScrollParent = this.targetElement.fastClickScrollParent),
            d = g.tagName.toLowerCase(),
        "label" === d) {
            if (b = this.findControl(g)) {
                if (this.focus(g),
                    deviceIsAndroid)
                    return !1;
                g = b
            }
        } else if (this.needsFocus(g))
            return a.timeStamp - c > 100 || deviceIsIOS && window.top !== window && "input" === d ? (this.targetElement = null,
                !1) : (this.focus(g),
                this.sendClick(g, a),
            deviceIsIOS && "select" === d || (this.targetElement = null,
                a.preventDefault()),
                !1);
        return deviceIsIOS && !deviceIsIOS4 && (e = g.fastClickScrollParent,
        e && e.fastClickLastScrollTop !== e.scrollTop) ? !0 : (this.needsClick(g) || (a.preventDefault(),
            this.sendClick(g, a)),
            !1)
    }
    ,
    FastClick.prototype.onTouchCancel = function() {
        "use strict";
        this.trackingClick = !1,
            this.targetElement = null
    }
    ,
    FastClick.prototype.onMouse = function(a) {
        "use strict";
        return this.targetElement ? a.forwardedTouchEvent ? !0 : a.cancelable && (!this.needsClick(this.targetElement) || this.cancelNextClick) ? (a.stopImmediatePropagation ? a.stopImmediatePropagation() : a.propagationStopped = !0,
            a.stopPropagation(),
            a.preventDefault(),
            !1) : !0 : !0
    }
    ,
    FastClick.prototype.onClick = function(a) {
        "use strict";
        var b;
        return this.trackingClick ? (this.targetElement = null,
            this.trackingClick = !1,
            !0) : "submit" === a.target.type && 0 === a.detail ? !0 : (b = this.onMouse(a),
        b || (this.targetElement = null),
            b)
    }
    ,
    FastClick.prototype.destroy = function() {
        "use strict";
        var a = this.layer;
        deviceIsAndroid && (a.removeEventListener("mouseover", this.onMouse, !0),
            a.removeEventListener("mousedown", this.onMouse, !0),
            a.removeEventListener("mouseup", this.onMouse, !0)),
            a.removeEventListener("click", this.onClick, !0),
            a.removeEventListener("touchstart", this.onTouchStart, !1),
            a.removeEventListener("touchmove", this.onTouchMove, !1),
            a.removeEventListener("touchend", this.onTouchEnd, !1),
            a.removeEventListener("touchcancel", this.onTouchCancel, !1)
    }
    ,
    FastClick.notNeeded = function(a) {
        "use strict";
        var b, c, d;
        if ("undefined" == typeof window.ontouchstart)
            return !0;
        if (c = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]) {
            if (!deviceIsAndroid)
                return !0;
            if (b = document.querySelector("meta[name=viewport]")) {
                if (-1 !== b.content.indexOf("user-scalable=no"))
                    return !0;
                if (c > 31 && document.documentElement.scrollWidth <= window.outerWidth)
                    return !0
            }
        }
        if (deviceIsBlackBerry10 && (d = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/),
        d[1] >= 10 && d[2] >= 3 && (b = document.querySelector("meta[name=viewport]")))) {
            if (-1 !== b.content.indexOf("user-scalable=no"))
                return !0;
            if (document.documentElement.scrollWidth <= window.outerWidth)
                return !0
        }
        return "none" === a.style.msTouchAction ? !0 : !1
    }
    ,
    FastClick.attach = function(a, b) {
        "use strict";
        return new FastClick(a,b)
    }
    ,
    "function" == typeof define && "object" == typeof define.amd && define.amd ? define(function() {
        "use strict";
        return FastClick
    }) : "undefined" != typeof module && module.exports ? (module.exports = FastClick.attach,
        module.exports.FastClick = FastClick) : window.FastClick = FastClick,
    /*! Picturefill - v2.1.0 - 2014-09-23
* http://scottjehl.github.io/picturefill
* Copyright (c) 2014 https://github.com/scottjehl/picturefill/blob/master/Authors.txt; Licensed MIT */
    /*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. Dual MIT/BSD license */

window.matchMedia || (window.matchMedia = function() {
    "use strict";
    var a = window.styleMedia || window.media;
    if (!a) {
        var b = document.createElement("style")
            , c = document.getElementsByTagName("script")[0]
            , d = null;
        b.type = "text/css",
            b.id = "matchmediajs-test",
            c.parentNode.insertBefore(b, c),
            d = "getComputedStyle"in window && window.getComputedStyle(b, null) || b.currentStyle,
            a = {
                matchMedium: function(a) {
                    var c = "@media " + a + "{ #matchmediajs-test { width: 1px; } }";
                    return b.styleSheet ? b.styleSheet.cssText = c : b.textContent = c,
                    "1px" === d.width
                }
            }
    }
    return function(b) {
        return {
            matches: a.matchMedium(b || "all"),
            media: b || "all"
        }
    }
}()),
    /*! Picturefill - Responsive Images that work today.
*  Author: Scott Jehl, Filament Group, 2012 ( new proposal implemented by Shawn Jansepar )
*  License: MIT/GPLv2
*  Spec: http://picture.responsiveimages.org/
*/

    function(a, b) {
        "use strict";
        function c(a) {
            var b, c, d, f, g, h = a || {};
            b = h.elements || e.getAllElements();
            for (var i = 0, j = b.length; j > i; i++)
                if (c = b[i],
                    d = c.parentNode,
                    f = void 0,
                    g = void 0,
                c[e.ns] || (c[e.ns] = {}),
                h.reevaluate || !c[e.ns].evaluated) {
                    if ("PICTURE" === d.nodeName.toUpperCase()) {
                        if (e.removeVideoShim(d),
                            f = e.getMatch(c, d),
                        f === !1)
                            continue
                    } else
                        f = void 0;
                    ("PICTURE" === d.nodeName.toUpperCase() || c.srcset && !e.srcsetSupported || !e.sizesSupported && c.srcset && c.srcset.indexOf("w") > -1) && e.dodgeSrcset(c),
                        f ? (g = e.processSourceSet(f),
                            e.applyBestCandidate(g, c)) : (g = e.processSourceSet(c),
                        (void 0 === c.srcset || c[e.ns].srcset) && e.applyBestCandidate(g, c)),
                        c[e.ns].evaluated = !0
                }
        }
        function d() {
            function d() {
                var b;
                a._picturefillWorking || (a._picturefillWorking = !0,
                    a.clearTimeout(b),
                    b = a.setTimeout(function() {
                        c({
                            reevaluate: !0
                        }),
                            a._picturefillWorking = !1
                    }, 60))
            }
            c();
            var e = setInterval(function() {
                return c(),
                    /^loaded|^i|^c/.test(b.readyState) ? void clearInterval(e) : void 0
            }, 250);
            a.addEventListener ? a.addEventListener("resize", d, !1) : a.attachEvent && a.attachEvent("onresize", d)
        }
        if (a.HTMLPictureElement)
            return void (a.picturefill = function() {}
            );
        b.createElement("picture");
        var e = {};
        e.ns = "picturefill",
            function() {
                var a = b.createElement("img");
                e.srcsetSupported = "srcset"in a,
                    e.sizesSupported = "sizes"in a
            }(),
            e.trim = function(a) {
                return a.trim ? a.trim() : a.replace(/^\s+|\s+$/g, "")
            }
            ,
            e.endsWith = function(a, b) {
                return a.endsWith ? a.endsWith(b) : -1 !== a.indexOf(b, a.length - b.length)
            }
            ,
            e.restrictsMixedContent = function() {
                return "https:" === a.location.protocol
            }
            ,
            e.matchesMedia = function(b) {
                return a.matchMedia && a.matchMedia(b).matches
            }
            ,
            e.getDpr = function() {
                return a.devicePixelRatio || 1
            }
            ,
            e.getWidthFromLength = function(a) {
                return a = a && a.indexOf("%") > -1 == !1 && (parseFloat(a) > 0 || a.indexOf("calc(") > -1) ? a : "100vw",
                    a = a.replace("vw", "%"),
                e.lengthEl || (e.lengthEl = b.createElement("div"),
                    b.documentElement.insertBefore(e.lengthEl, b.documentElement.firstChild)),
                    e.lengthEl.style.cssText = "position: absolute; left: 0; width: " + a + ";",
                    e.lengthEl.className = "helper-from-picturefill-js",
                e.lengthEl.offsetWidth <= 0 && (e.lengthEl.style.cssText = "width: 100%;"),
                    e.lengthEl.offsetWidth
            }
            ,
            e.types = {},
            e.types["image/jpeg"] = !0,
            e.types["image/gif"] = !0,
            e.types["image/png"] = !0,
            e.types["image/svg+xml"] = b.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1"),
            e.types["image/webp"] = function() {
                var b = new a.Image
                    , d = "image/webp";
                b.onerror = function() {
                    e.types[d] = !1,
                        c()
                }
                    ,
                    b.onload = function() {
                        e.types[d] = 1 === b.width,
                            c()
                    }
                    ,
                    b.src = "data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA="
            }
            ,
            e.verifyTypeSupport = function(a) {
                var b = a.getAttribute("type");
                return null === b || "" === b ? !0 : "function" == typeof e.types[b] ? (e.types[b](),
                    "pending") : e.types[b]
            }
            ,
            e.parseSize = function(a) {
                var b = /(\([^)]+\))?\s*(.+)/g.exec(a);
                return {
                    media: b && b[1],
                    length: b && b[2]
                }
            }
            ,
            e.findWidthFromSourceSize = function(a) {
                for (var b, c = e.trim(a).split(/\s*,\s*/), d = 0, f = c.length; f > d; d++) {
                    var g = c[d]
                        , h = e.parseSize(g)
                        , i = h.length
                        , j = h.media;
                    if (i && (!j || e.matchesMedia(j))) {
                        b = i;
                        break
                    }
                }
                return e.getWidthFromLength(b)
            }
            ,
            e.parseSrcset = function(a) {
                for (var b = []; "" !== a; ) {
                    a = a.replace(/^\s+/g, "");
                    var c, d = a.search(/\s/g), e = null;
                    if (-1 !== d) {
                        c = a.slice(0, d);
                        var f = c[c.length - 1];
                        if (("," === f || "" === c) && (c = c.replace(/,+$/, ""),
                            e = ""),
                            a = a.slice(d + 1),
                        null === e) {
                            var g = a.indexOf(",");
                            -1 !== g ? (e = a.slice(0, g),
                                a = a.slice(g + 1)) : (e = a,
                                a = "")
                        }
                    } else
                        c = a,
                            a = "";
                    (c || e) && b.push({
                        url: c,
                        descriptor: e
                    })
                }
                return b
            }
            ,
            e.parseDescriptor = function(a, b) {
                var c, d = b || "100vw", f = a && a.replace(/(^\s+|\s+$)/g, ""), g = e.findWidthFromSourceSize(d);
                if (f)
                    for (var h = f.split(" "), i = h.length + 1; i >= 0; i--)
                        if (void 0 !== h[i]) {
                            var j = h[i]
                                , k = j && j.slice(j.length - 1);
                            if ("h" !== k && "w" !== k || e.sizesSupported) {
                                if ("x" === k) {
                                    var l = j && parseFloat(j, 10);
                                    c = l && !isNaN(l) ? l : 1
                                }
                            } else
                                c = parseFloat(parseInt(j, 10) / g)
                        }
                return c || 1
            }
            ,
            e.getCandidatesFromSourceSet = function(a, b) {
                for (var c = e.parseSrcset(a), d = [], f = 0, g = c.length; g > f; f++) {
                    var h = c[f];
                    d.push({
                        url: h.url,
                        resolution: e.parseDescriptor(h.descriptor, b)
                    })
                }
                return d
            }
            ,
            e.dodgeSrcset = function(a) {
                a.srcset && (a[e.ns].srcset = a.srcset,
                    a.removeAttribute("srcset"))
            }
            ,
            e.processSourceSet = function(a) {
                var b = a.getAttribute("srcset")
                    , c = a.getAttribute("sizes")
                    , d = [];
                return "IMG" === a.nodeName.toUpperCase() && a[e.ns] && a[e.ns].srcset && (b = a[e.ns].srcset),
                b && (d = e.getCandidatesFromSourceSet(b, c)),
                    d
            }
            ,
            e.applyBestCandidate = function(a, b) {
                var c, d, f;
                a.sort(e.ascendingSort),
                    d = a.length,
                    f = a[d - 1];
                for (var g = 0; d > g; g++)
                    if (c = a[g],
                    c.resolution >= e.getDpr()) {
                        f = c;
                        break
                    }
                f && !e.endsWith(b.src, f.url) && (e.restrictsMixedContent() && "http:" === f.url.substr(0, "http:".length).toLowerCase() ? void 0 !== typeof console && console.warn("Blocked mixed content image " + f.url) : (b.src = f.url,
                    b.currentSrc = b.src))
            }
            ,
            e.ascendingSort = function(a, b) {
                return a.resolution - b.resolution
            }
            ,
            e.removeVideoShim = function(a) {
                var b = a.getElementsByTagName("video");
                if (b.length) {
                    for (var c = b[0], d = c.getElementsByTagName("source"); d.length; )
                        a.insertBefore(d[0], c);
                    c.parentNode.removeChild(c)
                }
            }
            ,
            e.getAllElements = function() {
                for (var a = [], c = b.getElementsByTagName("img"), d = 0, f = c.length; f > d; d++) {
                    var g = c[d];
                    ("PICTURE" === g.parentNode.nodeName.toUpperCase() || null !== g.getAttribute("srcset") || g[e.ns] && null !== g[e.ns].srcset) && a.push(g)
                }
                return a
            }
            ,
            e.getMatch = function(a, b) {
                for (var c, d = b.childNodes, f = 0, g = d.length; g > f; f++) {
                    var h = d[f];
                    if (1 === h.nodeType) {
                        if (h === a)
                            return c;
                        if ("SOURCE" === h.nodeName.toUpperCase()) {
                            null !== h.getAttribute("src") && void 0 !== typeof console && console.warn("The `src` attribute is invalid on `picture` `source` element; instead, use `srcset`.");
                            var i = h.getAttribute("media");
                            if (h.getAttribute("srcset") && (!i || e.matchesMedia(i))) {
                                var j = e.verifyTypeSupport(h);
                                if (j === !0) {
                                    c = h;
                                    break
                                }
                                if ("pending" === j)
                                    return !1
                            }
                        }
                    }
                }
                return c
            }
            ,
            d(),
            c._ = e,
            "object" == typeof module && "object" == typeof module.exports ? module.exports = c : "function" == typeof define && define.amd ? define(function() {
                return c
            }) : "object" == typeof a && (a.picturefill = c)
    }(this, this.document),
    /*!
 * mustache.js - Logic-less {{mustache}} templates with JavaScript
 * http://github.com/janl/mustache.js
 */

    function(a, b) {
        "object" == typeof exports && exports ? b(exports) : "function" == typeof define && define.amd ? define(["exports"], b) : b(a.Mustache = {})
    }(this, function(a) {
        function b(a) {
            return "function" == typeof a
        }
        function c(a) {
            return a.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
        }
        function d(a, b) {
            return o.call(a, b)
        }
        function e(a) {
            return !d(p, a)
        }
        function f(a) {
            return String(a).replace(/[&<>"'\/]/g, function(a) {
                return q[a]
            })
        }
        function g(b, d) {
            function f() {
                if (w && !x)
                    for (; q.length; )
                        delete p[q.pop()];
                else
                    q = [];
                w = !1,
                    x = !1
            }
            function g(a) {
                if ("string" == typeof a && (a = a.split(s, 2)),
                !n(a) || 2 !== a.length)
                    throw new Error("Invalid tags: " + a);
                k = new RegExp(c(a[0]) + "\\s*"),
                    l = new RegExp("\\s*" + c(a[1])),
                    m = new RegExp("\\s*" + c("}" + a[1]))
            }
            if (!b)
                return [];
            var k, l, m, o = [], p = [], q = [], w = !1, x = !1;
            g(d || a.tags);
            for (var y, z, A, B, C, D, E = new j(b); !E.eos(); ) {
                if (y = E.pos,
                    A = E.scanUntil(k))
                    for (var F = 0, G = A.length; G > F; ++F)
                        B = A.charAt(F),
                            e(B) ? q.push(p.length) : x = !0,
                            p.push(["text", B, y, y + 1]),
                            y += 1,
                        "\n" === B && f();
                if (!E.scan(k))
                    break;
                if (w = !0,
                    z = E.scan(v) || "name",
                    E.scan(r),
                    "=" === z ? (A = E.scanUntil(t),
                        E.scan(t),
                        E.scanUntil(l)) : "{" === z ? (A = E.scanUntil(m),
                        E.scan(u),
                        E.scanUntil(l),
                        z = "&") : A = E.scanUntil(l),
                    !E.scan(l))
                    throw new Error("Unclosed tag at " + E.pos);
                if (C = [z, A, y, E.pos],
                    p.push(C),
                "#" === z || "^" === z)
                    o.push(C);
                else if ("/" === z) {
                    if (D = o.pop(),
                        !D)
                        throw new Error('Unopened section "' + A + '" at ' + y);
                    if (D[1] !== A)
                        throw new Error('Unclosed section "' + D[1] + '" at ' + y)
                } else
                    "name" === z || "{" === z || "&" === z ? x = !0 : "=" === z && g(A)
            }
            if (D = o.pop())
                throw new Error('Unclosed section "' + D[1] + '" at ' + E.pos);
            return i(h(p))
        }
        function h(a) {
            for (var b, c, d = [], e = 0, f = a.length; f > e; ++e)
                b = a[e],
                b && ("text" === b[0] && c && "text" === c[0] ? (c[1] += b[1],
                    c[3] = b[3]) : (d.push(b),
                    c = b));
            return d
        }
        function i(a) {
            for (var b, c, d = [], e = d, f = [], g = 0, h = a.length; h > g; ++g)
                switch (b = a[g],
                    b[0]) {
                    case "#":
                    case "^":
                        e.push(b),
                            f.push(b),
                            e = b[4] = [];
                        break;
                    case "/":
                        c = f.pop(),
                            c[5] = b[2],
                            e = f.length > 0 ? f[f.length - 1][4] : d;
                        break;
                    default:
                        e.push(b)
                }
            return d
        }
        function j(a) {
            this.string = a,
                this.tail = a,
                this.pos = 0
        }
        function k(a, b) {
            this.view = null == a ? {} : a,
                this.cache = {
                    ".": this.view
                },
                this.parent = b
        }
        function l() {
            this.cache = {}
        }
        var m = Object.prototype.toString
            , n = Array.isArray || function(a) {
            return "[object Array]" === m.call(a)
        }
            , o = RegExp.prototype.test
            , p = /\S/
            , q = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;",
            "/": "&#x2F;"
        }
            , r = /\s*/
            , s = /\s+/
            , t = /\s*=/
            , u = /\s*\}/
            , v = /#|\^|\/|>|\{|&|=|!/;
        j.prototype.eos = function() {
            return "" === this.tail
        }
            ,
            j.prototype.scan = function(a) {
                var b = this.tail.match(a);
                if (!b || 0 !== b.index)
                    return "";
                var c = b[0];
                return this.tail = this.tail.substring(c.length),
                    this.pos += c.length,
                    c
            }
            ,
            j.prototype.scanUntil = function(a) {
                var b, c = this.tail.search(a);
                switch (c) {
                    case -1:
                        b = this.tail,
                            this.tail = "";
                        break;
                    case 0:
                        b = "";
                        break;
                    default:
                        b = this.tail.substring(0, c),
                            this.tail = this.tail.substring(c)
                }
                return this.pos += b.length,
                    b
            }
            ,
            k.prototype.push = function(a) {
                return new k(a,this)
            }
            ,
            k.prototype.lookup = function(a) {
                var c, d = this.cache;
                if (a in d)
                    c = d[a];
                else {
                    for (var e, f, g = this; g; ) {
                        if (a.indexOf(".") > 0)
                            for (c = g.view,
                                     e = a.split("."),
                                     f = 0; null != c && f < e.length; )
                                c = c[e[f++]];
                        else
                            "object" == typeof g.view && (c = g.view[a]);
                        if (null != c)
                            break;
                        g = g.parent
                    }
                    d[a] = c
                }
                return b(c) && (c = c.call(this.view)),
                    c
            }
            ,
            l.prototype.clearCache = function() {
                this.cache = {}
            }
            ,
            l.prototype.parse = function(a, b) {
                var c = this.cache
                    , d = c[a];
                return null == d && (d = c[a] = g(a, b)),
                    d
            }
            ,
            l.prototype.render = function(a, b, c) {
                var d = this.parse(a)
                    , e = b instanceof k ? b : new k(b);
                return this.renderTokens(d, e, c, a)
            }
            ,
            l.prototype.renderTokens = function(c, d, e, f) {
                function g(a) {
                    return k.render(a, d, e)
                }
                for (var h, i, j = "", k = this, l = 0, m = c.length; m > l; ++l)
                    switch (h = c[l],
                        h[0]) {
                        case "#":
                            if (i = d.lookup(h[1]),
                                !i)
                                continue;
                            if (n(i))
                                for (var o = 0, p = i.length; p > o; ++o)
                                    j += this.renderTokens(h[4], d.push(i[o]), e, f);
                            else if ("object" == typeof i || "string" == typeof i)
                                j += this.renderTokens(h[4], d.push(i), e, f);
                            else if (b(i)) {
                                if ("string" != typeof f)
                                    throw new Error("Cannot use higher-order sections without the original template");
                                i = i.call(d.view, f.slice(h[3], h[5]), g),
                                null != i && (j += i)
                            } else
                                j += this.renderTokens(h[4], d, e, f);
                            break;
                        case "^":
                            i = d.lookup(h[1]),
                            (!i || n(i) && 0 === i.length) && (j += this.renderTokens(h[4], d, e, f));
                            break;
                        case ">":
                            if (!e)
                                continue;
                            i = b(e) ? e(h[1]) : e[h[1]],
                            null != i && (j += this.renderTokens(this.parse(i), d, e, i));
                            break;
                        case "&":
                            i = d.lookup(h[1]),
                            null != i && (j += i);
                            break;
                        case "name":
                            i = d.lookup(h[1]),
                            null != i && (j += a.escape(i));
                            break;
                        case "text":
                            j += h[1]
                    }
                return j
            }
            ,
            a.name = "mustache.js",
            a.version = "1.0.0",
            a.tags = ["{{", "}}"];
        var w = new l;
        a.clearCache = function() {
            return w.clearCache()
        }
            ,
            a.parse = function(a, b) {
                return w.parse(a, b)
            }
            ,
            a.render = function(a, b, c) {
                return w.render(a, b, c)
            }
            ,
            a.to_html = function(c, d, e, f) {
                var g = a.render(c, d, e);
                return b(f) ? void f(g) : g
            }
            ,
            a.escape = f,
            a.Scanner = j,
            a.Context = k,
            a.Writer = l
    }),
    function(a, b) {
        if ("function" == typeof define && define.amd)
            define(["mustache"], function(a) {
                b(a)
            });
        else if ("undefined" != typeof exports) {
            var c = require("mustache");
            b(c)
        } else
            b(a.Mustache)
    }(this, function(a) {
        a.Formatters = {},
            a.Context.prototype.parseParam = function(a) {
                var b, c, d;
                return b = /^[\'\"](.*)[\'\"]$/g,
                    c = /^[+-]?\d+$/g,
                    d = /^[+-]?\d*\.\d+$/g,
                    b.test(a) ? a.replace(b, "$1") : c.test(a) ? parseInt(a, 10) : d.test(a) ? parseFloat(a) : this._lookup(a)
            }
            ,
            a.Context.prototype.applyFilter = function(b, c) {
                var d, e, f, g, h = [b];
                for (d = /^\s*([^\:]+)/g,
                         e = /\:\s*([\'][^\']*[\']|[\"][^\"]*[\"]|[^\:]+)\s*/g,
                         f = d.exec(c),
                         g = f[1].trim(); f = e.exec(c); )
                    h.push(this.parseParam(f[1].trim()));
                return a.Formatters.hasOwnProperty(g) ? (c = a.Formatters[g],
                    c.apply(c, h)) : b
            }
            ,
            a.Context.prototype._lookup = a.Context.prototype.lookup,
            a.Context.prototype.lookup = function(a) {
                var b, c, d, e;
                for (e = a.split("|"),
                         d = e.shift().trim(),
                         d = this._lookup(d),
                         b = 0,
                         c = e.length; c > b; ++b)
                    d = this.applyFilter(d, e[b]);
                return d
            }
    });

/*!
 * VERSION: 1.14.2
 * DATE: 2014-10-28
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2014, GreenSock. All rights reserved.
 * This work is subject to the terms at http://www.greensock.com/terms_of_use.html or for
 * Club GreenSock members, the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 */

var _gsScope = "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window;
(_gsScope._gsQueue || (_gsScope._gsQueue = [])).push(function() {
    "use strict";
    _gsScope._gsDefine("plugins.CSSPlugin", ["plugins.TweenPlugin", "TweenLite"], function(a, b) {
        var c, d, e, f, g = function() {
            a.call(this, "css"),
                this._overwriteProps.length = 0,
                this.setRatio = g.prototype.setRatio
        }, h = {}, i = g.prototype = new a("css");
        i.constructor = g,
            g.version = "1.14.2",
            g.API = 2,
            g.defaultTransformPerspective = 0,
            g.defaultSkewType = "compensated",
            i = "px",
            g.suffixMap = {
                top: i,
                right: i,
                bottom: i,
                left: i,
                width: i,
                height: i,
                fontSize: i,
                padding: i,
                margin: i,
                perspective: i,
                lineHeight: ""
            };
        var j, k, l, m, n, o, p = /(?:\d|\-\d|\.\d|\-\.\d)+/g, q = /(?:\d|\-\d|\.\d|\-\.\d|\+=\d|\-=\d|\+=.\d|\-=\.\d)+/g, r = /(?:\+=|\-=|\-|\b)[\d\-\.]+[a-zA-Z0-9]*(?:%|\b)/gi, s = /(?![+-]?\d*\.?\d+|e[+-]\d+)[^0-9]/g, t = /(?:\d|\-|\+|=|#|\.)*/g, u = /opacity *= *([^)]*)/i, v = /opacity:([^;]*)/i, w = /alpha\(opacity *=.+?\)/i, x = /^(rgb|hsl)/, y = /([A-Z])/g, z = /-([a-z])/gi, A = /(^(?:url\(\"|url\())|(?:(\"\))$|\)$)/gi, B = function(a, b) {
            return b.toUpperCase()
        }, C = /(?:Left|Right|Width)/i, D = /(M11|M12|M21|M22)=[\d\-\.e]+/gi, E = /progid\:DXImageTransform\.Microsoft\.Matrix\(.+?\)/i, F = /,(?=[^\)]*(?:\(|$))/gi, G = Math.PI / 180, H = 180 / Math.PI, I = {}, J = document, K = J.createElement("div"), L = J.createElement("img"), M = g._internals = {
            _specialProps: h
        }, N = navigator.userAgent, O = function() {
            var a, b = N.indexOf("Android"), c = J.createElement("div");
            return l = -1 !== N.indexOf("Safari") && -1 === N.indexOf("Chrome") && (-1 === b || Number(N.substr(b + 8, 1)) > 3),
                n = l && Number(N.substr(N.indexOf("Version/") + 8, 1)) < 6,
                m = -1 !== N.indexOf("Firefox"),
            (/MSIE ([0-9]{1,}[\.0-9]{0,})/.exec(N) || /Trident\/.*rv:([0-9]{1,}[\.0-9]{0,})/.exec(N)) && (o = parseFloat(RegExp.$1)),
                c.innerHTML = "<a style='top:1px;opacity:.55;'>a</a>",
                a = c.getElementsByTagName("a")[0],
                a ? /^0.55/.test(a.style.opacity) : !1
        }(), P = function(a) {
            return u.test("string" == typeof a ? a : (a.currentStyle ? a.currentStyle.filter : a.style.filter) || "") ? parseFloat(RegExp.$1) / 100 : 1
        }, Q = function(a) {
            window.console && console.log(a)
        }, R = "", S = "", T = function(a, b) {
            b = b || K;
            var c, d, e = b.style;
            if (void 0 !== e[a])
                return a;
            for (a = a.charAt(0).toUpperCase() + a.substr(1),
                     c = ["O", "Moz", "ms", "Ms", "Webkit"],
                     d = 5; --d > -1 && void 0 === e[c[d] + a]; )
                ;
            return d >= 0 ? (S = 3 === d ? "ms" : c[d],
                R = "-" + S.toLowerCase() + "-",
            S + a) : null
        }, U = J.defaultView ? J.defaultView.getComputedStyle : function() {}
            , V = g.getStyle = function(a, b, c, d, e) {
            var f;
            return O || "opacity" !== b ? (!d && a.style[b] ? f = a.style[b] : (c = c || U(a)) ? f = c[b] || c.getPropertyValue(b) || c.getPropertyValue(b.replace(y, "-$1").toLowerCase()) : a.currentStyle && (f = a.currentStyle[b]),
                null == e || f && "none" !== f && "auto" !== f && "auto auto" !== f ? f : e) : P(a)
        }
            , W = M.convertToPixels = function(a, c, d, e, f) {
            if ("px" === e || !e)
                return d;
            if ("auto" === e || !d)
                return 0;
            var h, i, j, k = C.test(c), l = a, m = K.style, n = 0 > d;
            if (n && (d = -d),
            "%" === e && -1 !== c.indexOf("border"))
                h = d / 100 * (k ? a.clientWidth : a.clientHeight);
            else {
                if (m.cssText = "border:0 solid red;position:" + V(a, "position") + ";line-height:0;",
                "%" !== e && l.appendChild)
                    m[k ? "borderLeftWidth" : "borderTopWidth"] = d + e;
                else {
                    if (l = a.parentNode || J.body,
                        i = l._gsCache,
                        j = b.ticker.frame,
                    i && k && i.time === j)
                        return i.width * d / 100;
                    m[k ? "width" : "height"] = d + e
                }
                l.appendChild(K),
                    h = parseFloat(K[k ? "offsetWidth" : "offsetHeight"]),
                    l.removeChild(K),
                k && "%" === e && g.cacheWidths !== !1 && (i = l._gsCache = l._gsCache || {},
                    i.time = j,
                    i.width = h / d * 100),
                0 !== h || f || (h = W(a, c, d, e, !0))
            }
            return n ? -h : h
        }
            , X = M.calculateOffset = function(a, b, c) {
            if ("absolute" !== V(a, "position", c))
                return 0;
            var d = "left" === b ? "Left" : "Top"
                , e = V(a, "margin" + d, c);
            return a["offset" + d] - (W(a, b, parseFloat(e), e.replace(t, "")) || 0)
        }
            , Y = function(a, b) {
            var c, d, e = {};
            if (b = b || U(a, null))
                if (c = b.length)
                    for (; --c > -1; )
                        e[b[c].replace(z, B)] = b.getPropertyValue(b[c]);
                else
                    for (c in b)
                        e[c] = b[c];
            else if (b = a.currentStyle || a.style)
                for (c in b)
                    "string" == typeof c && void 0 === e[c] && (e[c.replace(z, B)] = b[c]);
            return O || (e.opacity = P(a)),
                d = Eb(a, b, !1),
                e.rotation = d.rotation,
                e.skewX = d.skewX,
                e.scaleX = d.scaleX,
                e.scaleY = d.scaleY,
                e.x = d.x,
                e.y = d.y,
            xb && (e.z = d.z,
                e.rotationX = d.rotationX,
                e.rotationY = d.rotationY,
                e.scaleZ = d.scaleZ),
            e.filters && delete e.filters,
                e
        }, Z = function(a, b, c, d, e) {
            var f, g, h, i = {}, j = a.style;
            for (g in c)
                "cssText" !== g && "length" !== g && isNaN(g) && (b[g] !== (f = c[g]) || e && e[g]) && -1 === g.indexOf("Origin") && ("number" == typeof f || "string" == typeof f) && (i[g] = "auto" !== f || "left" !== g && "top" !== g ? "" !== f && "auto" !== f && "none" !== f || "string" != typeof b[g] || "" === b[g].replace(s, "") ? f : 0 : X(a, g),
                void 0 !== j[g] && (h = new lb(j,g,j[g],h)));
            if (d)
                for (g in d)
                    "className" !== g && (i[g] = d[g]);
            return {
                difs: i,
                firstMPT: h
            }
        }, $ = {
            width: ["Left", "Right"],
            height: ["Top", "Bottom"]
        }, _ = ["marginLeft", "marginRight", "marginTop", "marginBottom"], ab = function(a, b, c) {
            var d = parseFloat("width" === b ? a.offsetWidth : a.offsetHeight)
                , e = $[b]
                , f = e.length;
            for (c = c || U(a, null); --f > -1; )
                d -= parseFloat(V(a, "padding" + e[f], c, !0)) || 0,
                    d -= parseFloat(V(a, "border" + e[f] + "Width", c, !0)) || 0;
            return d
        }, bb = function(a, b) {
            (null == a || "" === a || "auto" === a || "auto auto" === a) && (a = "0 0");
            var c = a.split(" ")
                , d = -1 !== a.indexOf("left") ? "0%" : -1 !== a.indexOf("right") ? "100%" : c[0]
                , e = -1 !== a.indexOf("top") ? "0%" : -1 !== a.indexOf("bottom") ? "100%" : c[1];
            return null == e ? e = "0" : "center" === e && (e = "50%"),
            ("center" === d || isNaN(parseFloat(d)) && -1 === (d + "").indexOf("=")) && (d = "50%"),
            b && (b.oxp = -1 !== d.indexOf("%"),
                b.oyp = -1 !== e.indexOf("%"),
                b.oxr = "=" === d.charAt(1),
                b.oyr = "=" === e.charAt(1),
                b.ox = parseFloat(d.replace(s, "")),
                b.oy = parseFloat(e.replace(s, ""))),
            d + " " + e + (c.length > 2 ? " " + c[2] : "")
        }, cb = function(a, b) {
            return "string" == typeof a && "=" === a.charAt(1) ? parseInt(a.charAt(0) + "1", 10) * parseFloat(a.substr(2)) : parseFloat(a) - parseFloat(b)
        }, db = function(a, b) {
            return null == a ? b : "string" == typeof a && "=" === a.charAt(1) ? parseInt(a.charAt(0) + "1", 10) * parseFloat(a.substr(2)) + b : parseFloat(a)
        }, eb = function(a, b, c, d) {
            var e, f, g, h, i = 1e-6;
            return null == a ? h = b : "number" == typeof a ? h = a : (e = 360,
                f = a.split("_"),
                g = Number(f[0].replace(s, "")) * (-1 === a.indexOf("rad") ? 1 : H) - ("=" === a.charAt(1) ? 0 : b),
            f.length && (d && (d[c] = b + g),
            -1 !== a.indexOf("short") && (g %= e,
            g !== g % (e / 2) && (g = 0 > g ? g + e : g - e)),
                -1 !== a.indexOf("_cw") && 0 > g ? g = (g + 9999999999 * e) % e - (g / e | 0) * e : -1 !== a.indexOf("ccw") && g > 0 && (g = (g - 9999999999 * e) % e - (g / e | 0) * e)),
                h = b + g),
            i > h && h > -i && (h = 0),
                h
        }, fb = {
            aqua: [0, 255, 255],
            lime: [0, 255, 0],
            silver: [192, 192, 192],
            black: [0, 0, 0],
            maroon: [128, 0, 0],
            teal: [0, 128, 128],
            blue: [0, 0, 255],
            navy: [0, 0, 128],
            white: [255, 255, 255],
            fuchsia: [255, 0, 255],
            olive: [128, 128, 0],
            yellow: [255, 255, 0],
            orange: [255, 165, 0],
            gray: [128, 128, 128],
            purple: [128, 0, 128],
            green: [0, 128, 0],
            red: [255, 0, 0],
            pink: [255, 192, 203],
            cyan: [0, 255, 255],
            transparent: [255, 255, 255, 0]
        }, gb = function(a, b, c) {
            return a = 0 > a ? a + 1 : a > 1 ? a - 1 : a,
            255 * (1 > 6 * a ? b + (c - b) * a * 6 : .5 > a ? c : 2 > 3 * a ? b + (c - b) * (2 / 3 - a) * 6 : b) + .5 | 0
        }, hb = g.parseColor = function(a) {
            var b, c, d, e, f, g;
            return a && "" !== a ? "number" == typeof a ? [a >> 16, a >> 8 & 255, 255 & a] : ("," === a.charAt(a.length - 1) && (a = a.substr(0, a.length - 1)),
                fb[a] ? fb[a] : "#" === a.charAt(0) ? (4 === a.length && (b = a.charAt(1),
                    c = a.charAt(2),
                    d = a.charAt(3),
                    a = "#" + b + b + c + c + d + d),
                    a = parseInt(a.substr(1), 16),
                    [a >> 16, a >> 8 & 255, 255 & a]) : "hsl" === a.substr(0, 3) ? (a = a.match(p),
                    e = Number(a[0]) % 360 / 360,
                    f = Number(a[1]) / 100,
                    g = Number(a[2]) / 100,
                    c = .5 >= g ? g * (f + 1) : g + f - g * f,
                    b = 2 * g - c,
                a.length > 3 && (a[3] = Number(a[3])),
                    a[0] = gb(e + 1 / 3, b, c),
                    a[1] = gb(e, b, c),
                    a[2] = gb(e - 1 / 3, b, c),
                    a) : (a = a.match(p) || fb.transparent,
                    a[0] = Number(a[0]),
                    a[1] = Number(a[1]),
                    a[2] = Number(a[2]),
                a.length > 3 && (a[3] = Number(a[3])),
                    a)) : fb.black
        }
            , ib = "(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#.+?\\b";
        for (i in fb)
            ib += "|" + i + "\\b";
        ib = new RegExp(ib + ")","gi");
        var jb = function(a, b, c, d) {
            if (null == a)
                return function(a) {
                    return a
                }
                    ;
            var e, f = b ? (a.match(ib) || [""])[0] : "", g = a.split(f).join("").match(r) || [], h = a.substr(0, a.indexOf(g[0])), i = ")" === a.charAt(a.length - 1) ? ")" : "", j = -1 !== a.indexOf(" ") ? " " : ",", k = g.length, l = k > 0 ? g[0].replace(p, "") : "";
            return k ? e = b ? function(a) {
                    var b, m, n, o;
                    if ("number" == typeof a)
                        a += l;
                    else if (d && F.test(a)) {
                        for (o = a.replace(F, "|").split("|"),
                                 n = 0; n < o.length; n++)
                            o[n] = e(o[n]);
                        return o.join(",")
                    }
                    if (b = (a.match(ib) || [f])[0],
                        m = a.split(b).join("").match(r) || [],
                        n = m.length,
                    k > n--)
                        for (; ++n < k; )
                            m[n] = c ? m[(n - 1) / 2 | 0] : g[n];
                    return h + m.join(j) + j + b + i + (-1 !== a.indexOf("inset") ? " inset" : "")
                }
                : function(a) {
                    var b, f, m;
                    if ("number" == typeof a)
                        a += l;
                    else if (d && F.test(a)) {
                        for (f = a.replace(F, "|").split("|"),
                                 m = 0; m < f.length; m++)
                            f[m] = e(f[m]);
                        return f.join(",")
                    }
                    if (b = a.match(r) || [],
                        m = b.length,
                    k > m--)
                        for (; ++m < k; )
                            b[m] = c ? b[(m - 1) / 2 | 0] : g[m];
                    return h + b.join(j) + i
                }
                : function(a) {
                    return a
                }
        }
            , kb = function(a) {
            return a = a.split(","),
                function(b, c, d, e, f, g, h) {
                    var i, j = (c + "").split(" ");
                    for (h = {},
                             i = 0; 4 > i; i++)
                        h[a[i]] = j[i] = j[i] || j[(i - 1) / 2 >> 0];
                    return e.parse(b, h, f, g)
                }
        }
            , lb = (M._setPluginRatio = function(a) {
                this.plugin.setRatio(a);
                for (var b, c, d, e, f = this.data, g = f.proxy, h = f.firstMPT, i = 1e-6; h; )
                    b = g[h.v],
                        h.r ? b = Math.round(b) : i > b && b > -i && (b = 0),
                        h.t[h.p] = b,
                        h = h._next;
                if (f.autoRotate && (f.autoRotate.rotation = g.rotation),
                1 === a)
                    for (h = f.firstMPT; h; ) {
                        if (c = h.t,
                            c.type) {
                            if (1 === c.type) {
                                for (e = c.xs0 + c.s + c.xs1,
                                         d = 1; d < c.l; d++)
                                    e += c["xn" + d] + c["xs" + (d + 1)];
                                c.e = e
                            }
                        } else
                            c.e = c.s + c.xs0;
                        h = h._next
                    }
            }
                ,
                function(a, b, c, d, e) {
                    this.t = a,
                        this.p = b,
                        this.v = c,
                        this.r = e,
                    d && (d._prev = this,
                        this._next = d)
                }
        )
            , mb = (M._parseToProxy = function(a, b, c, d, e, f) {
                var g, h, i, j, k, l = d, m = {}, n = {}, o = c._transform, p = I;
                for (c._transform = null,
                         I = b,
                         d = k = c.parse(a, b, d, e),
                         I = p,
                     f && (c._transform = o,
                     l && (l._prev = null,
                     l._prev && (l._prev._next = null))); d && d !== l; ) {
                    if (d.type <= 1 && (h = d.p,
                        n[h] = d.s + d.c,
                        m[h] = d.s,
                    f || (j = new lb(d,"s",h,j,d.r),
                        d.c = 0),
                    1 === d.type))
                        for (g = d.l; --g > 0; )
                            i = "xn" + g,
                                h = d.p + "_" + i,
                                n[h] = d.data[i],
                                m[h] = d[i],
                            f || (j = new lb(d,i,h,j,d.rxp[i]));
                    d = d._next
                }
                return {
                    proxy: m,
                    end: n,
                    firstMPT: j,
                    pt: k
                }
            }
                ,
                M.CSSPropTween = function(a, b, d, e, g, h, i, j, k, l, m) {
                    this.t = a,
                        this.p = b,
                        this.s = d,
                        this.c = e,
                        this.n = i || b,
                    a instanceof mb || f.push(this.n),
                        this.r = j,
                        this.type = h || 0,
                    k && (this.pr = k,
                        c = !0),
                        this.b = void 0 === l ? d : l,
                        this.e = void 0 === m ? d + e : m,
                    g && (this._next = g,
                        g._prev = this)
                }
        )
            , nb = g.parseComplex = function(a, b, c, d, e, f, g, h, i, k) {
            c = c || f || "",
                g = new mb(a,b,0,0,g,k ? 2 : 1,null,!1,h,c,d),
                d += "";
            var l, m, n, o, r, s, t, u, v, w, y, z, A = c.split(", ").join(",").split(" "), B = d.split(", ").join(",").split(" "), C = A.length, D = j !== !1;
            for ((-1 !== d.indexOf(",") || -1 !== c.indexOf(",")) && (A = A.join(" ").replace(F, ", ").split(" "),
                B = B.join(" ").replace(F, ", ").split(" "),
                C = A.length),
                 C !== B.length && (A = (f || "").split(" "),
                     C = A.length),
                     g.plugin = i,
                     g.setRatio = k,
                     l = 0; C > l; l++)
                if (o = A[l],
                    r = B[l],
                    u = parseFloat(o),
                u || 0 === u)
                    g.appendXtra("", u, cb(r, u), r.replace(q, ""), D && -1 !== r.indexOf("px"), !0);
                else if (e && ("#" === o.charAt(0) || fb[o] || x.test(o)))
                    z = "," === r.charAt(r.length - 1) ? ")," : ")",
                        o = hb(o),
                        r = hb(r),
                        v = o.length + r.length > 6,
                        v && !O && 0 === r[3] ? (g["xs" + g.l] += g.l ? " transparent" : "transparent",
                            g.e = g.e.split(B[l]).join("transparent")) : (O || (v = !1),
                            g.appendXtra(v ? "rgba(" : "rgb(", o[0], r[0] - o[0], ",", !0, !0).appendXtra("", o[1], r[1] - o[1], ",", !0).appendXtra("", o[2], r[2] - o[2], v ? "," : z, !0),
                        v && (o = o.length < 4 ? 1 : o[3],
                            g.appendXtra("", o, (r.length < 4 ? 1 : r[3]) - o, z, !1)));
                else if (s = o.match(p)) {
                    if (t = r.match(q),
                    !t || t.length !== s.length)
                        return g;
                    for (n = 0,
                             m = 0; m < s.length; m++)
                        y = s[m],
                            w = o.indexOf(y, n),
                            g.appendXtra(o.substr(n, w - n), Number(y), cb(t[m], y), "", D && "px" === o.substr(w + y.length, 2), 0 === m),
                            n = w + y.length;
                    g["xs" + g.l] += o.substr(n)
                } else
                    g["xs" + g.l] += g.l ? " " + o : o;
            if (-1 !== d.indexOf("=") && g.data) {
                for (z = g.xs0 + g.data.s,
                         l = 1; l < g.l; l++)
                    z += g["xs" + l] + g.data["xn" + l];
                g.e = z + g["xs" + l]
            }
            return g.l || (g.type = -1,
                g.xs0 = g.e),
            g.xfirst || g
        }
            , ob = 9;
        for (i = mb.prototype,
                 i.l = i.pr = 0; --ob > 0; )
            i["xn" + ob] = 0,
                i["xs" + ob] = "";
        i.xs0 = "",
            i._next = i._prev = i.xfirst = i.data = i.plugin = i.setRatio = i.rxp = null,
            i.appendXtra = function(a, b, c, d, e, f) {
                var g = this
                    , h = g.l;
                return g["xs" + h] += f && h ? " " + a : a || "",
                    c || 0 === h || g.plugin ? (g.l++,
                        g.type = g.setRatio ? 2 : 1,
                        g["xs" + g.l] = d || "",
                        h > 0 ? (g.data["xn" + h] = b + c,
                            g.rxp["xn" + h] = e,
                            g["xn" + h] = b,
                        g.plugin || (g.xfirst = new mb(g,"xn" + h,b,c,g.xfirst || g,0,g.n,e,g.pr),
                            g.xfirst.xs0 = 0),
                            g) : (g.data = {
                            s: b + c
                        },
                            g.rxp = {},
                            g.s = b,
                            g.c = c,
                            g.r = e,
                            g)) : (g["xs" + h] += b + (d || ""),
                        g)
            }
        ;
        var pb = function(a, b) {
            b = b || {},
                this.p = b.prefix ? T(a) || a : a,
                h[a] = h[this.p] = this,
                this.format = b.formatter || jb(b.defaultValue, b.color, b.collapsible, b.multi),
            b.parser && (this.parse = b.parser),
                this.clrs = b.color,
                this.multi = b.multi,
                this.keyword = b.keyword,
                this.dflt = b.defaultValue,
                this.pr = b.priority || 0
        }
            , qb = M._registerComplexSpecialProp = function(a, b, c) {
            "object" != typeof b && (b = {
                parser: c
            });
            var d, e, f = a.split(","), g = b.defaultValue;
            for (c = c || [g],
                     d = 0; d < f.length; d++)
                b.prefix = 0 === d && b.prefix,
                    b.defaultValue = c[d] || g,
                    e = new pb(f[d],b)
        }
            , rb = function(a) {
            if (!h[a]) {
                var b = a.charAt(0).toUpperCase() + a.substr(1) + "Plugin";
                qb(a, {
                    parser: function(a, c, d, e, f, g, i) {
                        var j = (_gsScope.GreenSockGlobals || _gsScope).com.greensock.plugins[b];
                        return j ? (j._cssRegister(),
                            h[d].parse(a, c, d, e, f, g, i)) : (Q("Error: " + b + " js file not loaded."),
                            f)
                    }
                })
            }
        };
        i = pb.prototype,
            i.parseComplex = function(a, b, c, d, e, f) {
                var g, h, i, j, k, l, m = this.keyword;
                if (this.multi && (F.test(c) || F.test(b) ? (h = b.replace(F, "|").split("|"),
                    i = c.replace(F, "|").split("|")) : m && (h = [b],
                    i = [c])),
                    i) {
                    for (j = i.length > h.length ? i.length : h.length,
                             g = 0; j > g; g++)
                        b = h[g] = h[g] || this.dflt,
                            c = i[g] = i[g] || this.dflt,
                        m && (k = b.indexOf(m),
                            l = c.indexOf(m),
                        k !== l && (c = -1 === l ? i : h,
                            c[g] += " " + m));
                    b = h.join(", "),
                        c = i.join(", ")
                }
                return nb(a, this.p, b, c, this.clrs, this.dflt, d, this.pr, e, f)
            }
            ,
            i.parse = function(a, b, c, d, f, g) {
                return this.parseComplex(a.style, this.format(V(a, this.p, e, !1, this.dflt)), this.format(b), f, g)
            }
            ,
            g.registerSpecialProp = function(a, b, c) {
                qb(a, {
                    parser: function(a, d, e, f, g, h) {
                        var i = new mb(a,e,0,0,g,2,e,!1,c);
                        return i.plugin = h,
                            i.setRatio = b(a, d, f._tween, e),
                            i
                    },
                    priority: c
                })
            }
        ;
        var sb, tb = "scaleX,scaleY,scaleZ,x,y,z,skewX,skewY,rotation,rotationX,rotationY,perspective,xPercent,yPercent".split(","), ub = T("transform"), vb = R + "transform", wb = T("transformOrigin"), xb = null !== T("perspective"), yb = M.Transform = function() {
                this.skewY = 0
            }
            , zb = window.SVGElement, Ab = function(a, b, c) {
                var d, e = J.createElementNS("http://www.w3.org/2000/svg", a), f = /([a-z])([A-Z])/g;
                for (d in c)
                    e.setAttributeNS(null, d.replace(f, "$1-$2").toLowerCase(), c[d]);
                return b.appendChild(e),
                    e
            }, Bb = document.documentElement, Cb = function() {
                var a, b, c, d = o || /Android/i.test(N) && !window.chrome;
                return J.createElementNS && !d && (a = Ab("svg", Bb),
                    b = Ab("rect", a, {
                        width: 100,
                        height: 50,
                        x: 100
                    }),
                    c = b.getBoundingClientRect().left,
                    b.style[wb] = "50% 50%",
                    b.style[ub] = "scale(0.5,0.5)",
                    d = c === b.getBoundingClientRect().left,
                    Bb.removeChild(a)),
                    d
            }(), Db = function(a, b, c) {
                var d = a.getBBox();
                b = bb(b).split(" "),
                    c.xOrigin = (-1 !== b[0].indexOf("%") ? parseFloat(b[0]) / 100 * d.width : parseFloat(b[0])) + d.x,
                    c.yOrigin = (-1 !== b[1].indexOf("%") ? parseFloat(b[1]) / 100 * d.height : parseFloat(b[1])) + d.y
            }, Eb = M.getTransform = function(a, b, c, d) {
                if (a._gsTransform && c && !d)
                    return a._gsTransform;
                var f, h, i, j, k, l, m, n, o, p, q, r, s, t = c ? a._gsTransform || new yb : new yb, u = t.scaleX < 0, v = 2e-5, w = 1e5, x = 179.99, y = x * G, z = xb ? parseFloat(V(a, wb, b, !1, "0 0 0").split(" ")[2]) || t.zOrigin || 0 : 0, A = parseFloat(g.defaultTransformPerspective) || 0;
                if (ub ? f = V(a, vb, b, !0) : a.currentStyle && (f = a.currentStyle.filter.match(D),
                    f = f && 4 === f.length ? [f[0].substr(4), Number(f[2].substr(4)), Number(f[1].substr(4)), f[3].substr(4), t.x || 0, t.y || 0].join(",") : ""),
                f && "none" !== f && "matrix(1, 0, 0, 1, 0, 0)" !== f) {
                    for (h = (f || "").match(/(?:\-|\b)[\d\-\.e]+\b/gi) || [],
                             i = h.length; --i > -1; )
                        j = Number(h[i]),
                            h[i] = (k = j - (j |= 0)) ? (k * w + (0 > k ? -.5 : .5) | 0) / w + j : j;
                    if (16 === h.length) {
                        var B = h[8]
                            , C = h[9]
                            , E = h[10]
                            , F = h[12]
                            , I = h[13]
                            , J = h[14];
                        if (t.zOrigin && (J = -t.zOrigin,
                            F = B * J - h[12],
                            I = C * J - h[13],
                            J = E * J + t.zOrigin - h[14]),
                        !c || d || null == t.rotationX) {
                            var K, L, M, N, O, P, Q, R = h[0], S = h[1], T = h[2], U = h[3], W = h[4], X = h[5], Y = h[6], Z = h[7], $ = h[11], _ = Math.atan2(Y, E), ab = -y > _ || _ > y;
                            t.rotationX = _ * H,
                            _ && (N = Math.cos(-_),
                                O = Math.sin(-_),
                                K = W * N + B * O,
                                L = X * N + C * O,
                                M = Y * N + E * O,
                                B = W * -O + B * N,
                                C = X * -O + C * N,
                                E = Y * -O + E * N,
                                $ = Z * -O + $ * N,
                                W = K,
                                X = L,
                                Y = M),
                                _ = Math.atan2(B, R),
                                t.rotationY = _ * H,
                            _ && (P = -y > _ || _ > y,
                                N = Math.cos(-_),
                                O = Math.sin(-_),
                                K = R * N - B * O,
                                L = S * N - C * O,
                                M = T * N - E * O,
                                C = S * O + C * N,
                                E = T * O + E * N,
                                $ = U * O + $ * N,
                                R = K,
                                S = L,
                                T = M),
                                _ = Math.atan2(S, X),
                                t.rotation = _ * H,
                            _ && (Q = -y > _ || _ > y,
                                N = Math.cos(-_),
                                O = Math.sin(-_),
                                R = R * N + W * O,
                                L = S * N + X * O,
                                X = S * -O + X * N,
                                Y = T * -O + Y * N,
                                S = L),
                                Q && ab ? t.rotation = t.rotationX = 0 : Q && P ? t.rotation = t.rotationY = 0 : P && ab && (t.rotationY = t.rotationX = 0),
                                t.scaleX = (Math.sqrt(R * R + S * S) * w + .5 | 0) / w,
                                t.scaleY = (Math.sqrt(X * X + C * C) * w + .5 | 0) / w,
                                t.scaleZ = (Math.sqrt(Y * Y + E * E) * w + .5 | 0) / w,
                                t.skewX = 0,
                                t.perspective = $ ? 1 / (0 > $ ? -$ : $) : 0,
                                t.x = F,
                                t.y = I,
                                t.z = J
                        }
                    } else if (!(xb && !d && h.length && t.x === h[4] && t.y === h[5] && (t.rotationX || t.rotationY) || void 0 !== t.x && "none" === V(a, "display", b))) {
                        var bb = h.length >= 6
                            , cb = bb ? h[0] : 1
                            , db = h[1] || 0
                            , eb = h[2] || 0
                            , fb = bb ? h[3] : 1;
                        t.x = h[4] || 0,
                            t.y = h[5] || 0,
                            l = Math.sqrt(cb * cb + db * db),
                            m = Math.sqrt(fb * fb + eb * eb),
                            n = cb || db ? Math.atan2(db, cb) * H : t.rotation || 0,
                            o = eb || fb ? Math.atan2(eb, fb) * H + n : t.skewX || 0,
                            p = l - Math.abs(t.scaleX || 0),
                            q = m - Math.abs(t.scaleY || 0),
                        Math.abs(o) > 90 && Math.abs(o) < 270 && (u ? (l *= -1,
                            o += 0 >= n ? 180 : -180,
                            n += 0 >= n ? 180 : -180) : (m *= -1,
                            o += 0 >= o ? 180 : -180)),
                            r = (n - t.rotation) % 180,
                            s = (o - t.skewX) % 180,
                        (void 0 === t.skewX || p > v || -v > p || q > v || -v > q || r > -x && x > r && r * w | !1 || s > -x && x > s && s * w | !1) && (t.scaleX = l,
                            t.scaleY = m,
                            t.rotation = n,
                            t.skewX = o),
                        xb && (t.rotationX = t.rotationY = t.z = 0,
                            t.perspective = A,
                            t.scaleZ = 1)
                    }
                    t.zOrigin = z;
                    for (i in t)
                        t[i] < v && t[i] > -v && (t[i] = 0)
                } else
                    t = {
                        x: 0,
                        y: 0,
                        z: 0,
                        scaleX: 1,
                        scaleY: 1,
                        scaleZ: 1,
                        skewX: 0,
                        skewY: 0,
                        perspective: A,
                        rotation: 0,
                        rotationX: 0,
                        rotationY: 0,
                        zOrigin: 0
                    };
                return c && (a._gsTransform = t),
                    t.svg = zb && a instanceof zb && a.parentNode instanceof zb,
                t.svg && (Db(a, V(a, wb, e, !1, "50% 50%") + "", t),
                    sb = g.useSVGTransformAttr || Cb),
                    t.xPercent = t.yPercent = 0,
                    t
            }
            , Fb = function(a) {
                var b, c, d = this.data, e = -d.rotation * G, f = e + d.skewX * G, g = 1e5, h = (Math.cos(e) * d.scaleX * g | 0) / g, i = (Math.sin(e) * d.scaleX * g | 0) / g, j = (Math.sin(f) * -d.scaleY * g | 0) / g, k = (Math.cos(f) * d.scaleY * g | 0) / g, l = this.t.style, m = this.t.currentStyle;
                if (m) {
                    c = i,
                        i = -j,
                        j = -c,
                        b = m.filter,
                        l.filter = "";
                    var n, p, q = this.t.offsetWidth, r = this.t.offsetHeight, s = "absolute" !== m.position, v = "progid:DXImageTransform.Microsoft.Matrix(M11=" + h + ", M12=" + i + ", M21=" + j + ", M22=" + k, w = d.x + q * d.xPercent / 100, x = d.y + r * d.yPercent / 100;
                    if (null != d.ox && (n = (d.oxp ? q * d.ox * .01 : d.ox) - q / 2,
                        p = (d.oyp ? r * d.oy * .01 : d.oy) - r / 2,
                        w += n - (n * h + p * i),
                        x += p - (n * j + p * k)),
                        s ? (n = q / 2,
                            p = r / 2,
                            v += ", Dx=" + (n - (n * h + p * i) + w) + ", Dy=" + (p - (n * j + p * k) + x) + ")") : v += ", sizingMethod='auto expand')",
                        l.filter = -1 !== b.indexOf("DXImageTransform.Microsoft.Matrix(") ? b.replace(E, v) : v + " " + b,
                    (0 === a || 1 === a) && 1 === h && 0 === i && 0 === j && 1 === k && (s && -1 === v.indexOf("Dx=0, Dy=0") || u.test(b) && 100 !== parseFloat(RegExp.$1) || -1 === b.indexOf("gradient(" && b.indexOf("Alpha")) && l.removeAttribute("filter")),
                        !s) {
                        var y, z, A, B = 8 > o ? 1 : -1;
                        for (n = d.ieOffsetX || 0,
                                 p = d.ieOffsetY || 0,
                                 d.ieOffsetX = Math.round((q - ((0 > h ? -h : h) * q + (0 > i ? -i : i) * r)) / 2 + w),
                                 d.ieOffsetY = Math.round((r - ((0 > k ? -k : k) * r + (0 > j ? -j : j) * q)) / 2 + x),
                                 ob = 0; 4 > ob; ob++)
                            z = _[ob],
                                y = m[z],
                                c = -1 !== y.indexOf("px") ? parseFloat(y) : W(this.t, z, parseFloat(y), y.replace(t, "")) || 0,
                                A = c !== d[z] ? 2 > ob ? -d.ieOffsetX : -d.ieOffsetY : 2 > ob ? n - d.ieOffsetX : p - d.ieOffsetY,
                                l[z] = (d[z] = Math.round(c - A * (0 === ob || 2 === ob ? 1 : B))) + "px"
                    }
                }
            }, Gb = M.set3DTransformRatio = function(a) {
                var b, c, d, e, f, g, h, i, j, k, l, n, o, p, q, r, s, t, u, v, w, x, y, z = this.data, A = this.t.style, B = z.rotation * G, C = z.scaleX, D = z.scaleY, E = z.scaleZ, F = z.x, H = z.y, I = z.z, J = z.perspective;
                if ((1 === a || 0 === a) && "auto" === z.force3D && !(z.rotationY || z.rotationX || 1 !== E || J || I))
                    return void Hb.call(this, a);
                if (m) {
                    var K = 1e-4;
                    K > C && C > -K && (C = E = 2e-5),
                    K > D && D > -K && (D = E = 2e-5),
                    !J || z.z || z.rotationX || z.rotationY || (J = 0)
                }
                if (B || z.skewX)
                    t = Math.cos(B),
                        u = Math.sin(B),
                        b = t,
                        f = u,
                    z.skewX && (B -= z.skewX * G,
                        t = Math.cos(B),
                        u = Math.sin(B),
                    "simple" === z.skewType && (v = Math.tan(z.skewX * G),
                        v = Math.sqrt(1 + v * v),
                        t *= v,
                        u *= v)),
                        c = -u,
                        g = t;
                else {
                    if (!(z.rotationY || z.rotationX || 1 !== E || J || z.svg))
                        return void (A[ub] = (z.xPercent || z.yPercent ? "translate(" + z.xPercent + "%," + z.yPercent + "%) translate3d(" : "translate3d(") + F + "px," + H + "px," + I + "px)" + (1 !== C || 1 !== D ? " scale(" + C + "," + D + ")" : ""));
                    b = g = 1,
                        c = f = 0
                }
                l = 1,
                    d = e = h = i = j = k = n = o = p = 0,
                    q = J ? -1 / J : 0,
                    r = z.zOrigin,
                    s = 1e5,
                    B = z.rotationY * G,
                B && (t = Math.cos(B),
                    u = Math.sin(B),
                    j = l * -u,
                    o = q * -u,
                    d = b * u,
                    h = f * u,
                    l *= t,
                    q *= t,
                    b *= t,
                    f *= t),
                    B = z.rotationX * G,
                B && (t = Math.cos(B),
                    u = Math.sin(B),
                    v = c * t + d * u,
                    w = g * t + h * u,
                    x = k * t + l * u,
                    y = p * t + q * u,
                    d = c * -u + d * t,
                    h = g * -u + h * t,
                    l = k * -u + l * t,
                    q = p * -u + q * t,
                    c = v,
                    g = w,
                    k = x,
                    p = y),
                1 !== E && (d *= E,
                    h *= E,
                    l *= E,
                    q *= E),
                1 !== D && (c *= D,
                    g *= D,
                    k *= D,
                    p *= D),
                1 !== C && (b *= C,
                    f *= C,
                    j *= C,
                    o *= C),
                r && (n -= r,
                    e = d * n,
                    i = h * n,
                    n = l * n + r),
                z.svg && (e += z.xOrigin - (z.xOrigin * b + z.yOrigin * c),
                    i += z.yOrigin - (z.xOrigin * f + z.yOrigin * g)),
                    e = (v = (e += F) - (e |= 0)) ? (v * s + (0 > v ? -.5 : .5) | 0) / s + e : e,
                    i = (v = (i += H) - (i |= 0)) ? (v * s + (0 > v ? -.5 : .5) | 0) / s + i : i,
                    n = (v = (n += I) - (n |= 0)) ? (v * s + (0 > v ? -.5 : .5) | 0) / s + n : n,
                    A[ub] = (z.xPercent || z.yPercent ? "translate(" + z.xPercent + "%," + z.yPercent + "%) matrix3d(" : "matrix3d(") + [(b * s | 0) / s, (f * s | 0) / s, (j * s | 0) / s, (o * s | 0) / s, (c * s | 0) / s, (g * s | 0) / s, (k * s | 0) / s, (p * s | 0) / s, (d * s | 0) / s, (h * s | 0) / s, (l * s | 0) / s, (q * s | 0) / s, e, i, n, J ? 1 + -n / J : 1].join(",") + ")"
            }
            , Hb = M.set2DTransformRatio = function(a) {
                var b, c, d, e, f, g, h, i, j, k, l, m = this.data, n = this.t, o = n.style, p = m.x, q = m.y;
                return !(m.rotationX || m.rotationY || m.z || m.force3D === !0 || "auto" === m.force3D && 1 !== a && 0 !== a) || m.svg && sb || !xb ? (e = m.scaleX,
                    f = m.scaleY,
                    void (m.rotation || m.skewX || m.svg ? (b = m.rotation * G,
                        c = b - m.skewX * G,
                        d = 1e5,
                        g = Math.cos(b) * e,
                        h = Math.sin(b) * e,
                        i = Math.sin(c) * -f,
                        j = Math.cos(c) * f,
                    m.svg && (p += m.xOrigin - (m.xOrigin * g + m.yOrigin * i),
                        q += m.yOrigin - (m.xOrigin * h + m.yOrigin * j),
                        l = 1e-6,
                    l > p && p > -l && (p = 0),
                    l > q && q > -l && (q = 0)),
                        k = (g * d | 0) / d + "," + (h * d | 0) / d + "," + (i * d | 0) / d + "," + (j * d | 0) / d + "," + p + "," + q + ")",
                        m.svg && sb ? n.setAttribute("transform", "matrix(" + k) : o[ub] = (m.xPercent || m.yPercent ? "translate(" + m.xPercent + "%," + m.yPercent + "%) matrix(" : "matrix(") + k) : o[ub] = (m.xPercent || m.yPercent ? "translate(" + m.xPercent + "%," + m.yPercent + "%) matrix(" : "matrix(") + e + ",0,0," + f + "," + p + "," + q + ")")) : (this.setRatio = Gb,
                    void Gb.call(this, a))
            }
        ;
        qb("transform,scale,scaleX,scaleY,scaleZ,x,y,z,rotation,rotationX,rotationY,rotationZ,skewX,skewY,shortRotation,shortRotationX,shortRotationY,shortRotationZ,transformOrigin,transformPerspective,directionalRotation,parseTransform,force3D,skewType,xPercent,yPercent", {
            parser: function(a, b, c, d, f, h, i) {
                if (d._transform)
                    return f;
                var j, k, l, m, n, o, p, q = d._transform = Eb(a, e, !0, i.parseTransform), r = a.style, s = 1e-6, t = tb.length, u = i, v = {};
                if ("string" == typeof u.transform && ub)
                    l = K.style,
                        l[ub] = u.transform,
                        l.display = "block",
                        l.position = "absolute",
                        J.body.appendChild(K),
                        j = Eb(K, null, !1),
                        J.body.removeChild(K);
                else if ("object" == typeof u) {
                    if (j = {
                        scaleX: db(null != u.scaleX ? u.scaleX : u.scale, q.scaleX),
                        scaleY: db(null != u.scaleY ? u.scaleY : u.scale, q.scaleY),
                        scaleZ: db(u.scaleZ, q.scaleZ),
                        x: db(u.x, q.x),
                        y: db(u.y, q.y),
                        z: db(u.z, q.z),
                        xPercent: db(u.xPercent, q.xPercent),
                        yPercent: db(u.yPercent, q.yPercent),
                        perspective: db(u.transformPerspective, q.perspective)
                    },
                        p = u.directionalRotation,
                    null != p)
                        if ("object" == typeof p)
                            for (l in p)
                                u[l] = p[l];
                        else
                            u.rotation = p;
                    "string" == typeof u.x && -1 !== u.x.indexOf("%") && (j.x = 0,
                        j.xPercent = db(u.x, q.xPercent)),
                    "string" == typeof u.y && -1 !== u.y.indexOf("%") && (j.y = 0,
                        j.yPercent = db(u.y, q.yPercent)),
                        j.rotation = eb("rotation"in u ? u.rotation : "shortRotation"in u ? u.shortRotation + "_short" : "rotationZ"in u ? u.rotationZ : q.rotation, q.rotation, "rotation", v),
                    xb && (j.rotationX = eb("rotationX"in u ? u.rotationX : "shortRotationX"in u ? u.shortRotationX + "_short" : q.rotationX || 0, q.rotationX, "rotationX", v),
                        j.rotationY = eb("rotationY"in u ? u.rotationY : "shortRotationY"in u ? u.shortRotationY + "_short" : q.rotationY || 0, q.rotationY, "rotationY", v)),
                        j.skewX = null == u.skewX ? q.skewX : eb(u.skewX, q.skewX),
                        j.skewY = null == u.skewY ? q.skewY : eb(u.skewY, q.skewY),
                    (k = j.skewY - q.skewY) && (j.skewX += k,
                        j.rotation += k)
                }
                for (xb && null != u.force3D && (q.force3D = u.force3D,
                    o = !0),
                         q.skewType = u.skewType || q.skewType || g.defaultSkewType,
                         n = q.force3D || q.z || q.rotationX || q.rotationY || j.z || j.rotationX || j.rotationY || j.perspective,
                     n || null == u.scale || (j.scaleZ = 1); --t > -1; )
                    c = tb[t],
                        m = j[c] - q[c],
                    (m > s || -s > m || null != u[c] || null != I[c]) && (o = !0,
                        f = new mb(q,c,q[c],m,f),
                    c in v && (f.e = v[c]),
                        f.xs0 = 0,
                        f.plugin = h,
                        d._overwriteProps.push(f.n));
                return m = u.transformOrigin,
                m && q.svg && (Db(a, m, j),
                    f = new mb(q,"xOrigin",q.xOrigin,j.xOrigin - q.xOrigin,f,-1,"transformOrigin"),
                    f.b = q.xOrigin,
                    f.e = f.xs0 = j.xOrigin,
                    f = new mb(q,"yOrigin",q.yOrigin,j.yOrigin - q.yOrigin,f,-1,"transformOrigin"),
                    f.b = q.yOrigin,
                    f.e = f.xs0 = j.yOrigin,
                    m = "0px 0px"),
                (m || xb && n && q.zOrigin) && (ub ? (o = !0,
                    c = wb,
                    m = (m || V(a, c, e, !1, "50% 50%")) + "",
                    f = new mb(r,c,0,0,f,-1,"transformOrigin"),
                    f.b = r[c],
                    f.plugin = h,
                    xb ? (l = q.zOrigin,
                        m = m.split(" "),
                        q.zOrigin = (m.length > 2 && (0 === l || "0px" !== m[2]) ? parseFloat(m[2]) : l) || 0,
                        f.xs0 = f.e = m[0] + " " + (m[1] || "50%") + " 0px",
                        f = new mb(q,"zOrigin",0,0,f,-1,f.n),
                        f.b = l,
                        f.xs0 = f.e = q.zOrigin) : f.xs0 = f.e = m) : bb(m + "", q)),
                o && (d._transformType = q.svg && sb || !n && 3 !== this._transformType ? 2 : 3),
                    f
            },
            prefix: !0
        }),
            qb("boxShadow", {
                defaultValue: "0px 0px 0px 0px #999",
                prefix: !0,
                color: !0,
                multi: !0,
                keyword: "inset"
            }),
            qb("borderRadius", {
                defaultValue: "0px",
                parser: function(a, b, c, f, g) {
                    b = this.format(b);
                    var h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x = ["borderTopLeftRadius", "borderTopRightRadius", "borderBottomRightRadius", "borderBottomLeftRadius"], y = a.style;
                    for (p = parseFloat(a.offsetWidth),
                             q = parseFloat(a.offsetHeight),
                             h = b.split(" "),
                             i = 0; i < x.length; i++)
                        this.p.indexOf("border") && (x[i] = T(x[i])),
                            l = k = V(a, x[i], e, !1, "0px"),
                        -1 !== l.indexOf(" ") && (k = l.split(" "),
                            l = k[0],
                            k = k[1]),
                            m = j = h[i],
                            n = parseFloat(l),
                            s = l.substr((n + "").length),
                            t = "=" === m.charAt(1),
                            t ? (o = parseInt(m.charAt(0) + "1", 10),
                                m = m.substr(2),
                                o *= parseFloat(m),
                                r = m.substr((o + "").length - (0 > o ? 1 : 0)) || "") : (o = parseFloat(m),
                                r = m.substr((o + "").length)),
                        "" === r && (r = d[c] || s),
                        r !== s && (u = W(a, "borderLeft", n, s),
                            v = W(a, "borderTop", n, s),
                            "%" === r ? (l = u / p * 100 + "%",
                                k = v / q * 100 + "%") : "em" === r ? (w = W(a, "borderLeft", 1, "em"),
                                l = u / w + "em",
                                k = v / w + "em") : (l = u + "px",
                                k = v + "px"),
                        t && (m = parseFloat(l) + o + r,
                            j = parseFloat(k) + o + r)),
                            g = nb(y, x[i], l + " " + k, m + " " + j, !1, "0px", g);
                    return g
                },
                prefix: !0,
                formatter: jb("0px 0px 0px 0px", !1, !0)
            }),
            qb("backgroundPosition", {
                defaultValue: "0 0",
                parser: function(a, b, c, d, f, g) {
                    var h, i, j, k, l, m, n = "background-position", p = e || U(a, null), q = this.format((p ? o ? p.getPropertyValue(n + "-x") + " " + p.getPropertyValue(n + "-y") : p.getPropertyValue(n) : a.currentStyle.backgroundPositionX + " " + a.currentStyle.backgroundPositionY) || "0 0"), r = this.format(b);
                    if (-1 !== q.indexOf("%") != (-1 !== r.indexOf("%")) && (m = V(a, "backgroundImage").replace(A, ""),
                    m && "none" !== m)) {
                        for (h = q.split(" "),
                                 i = r.split(" "),
                                 L.setAttribute("src", m),
                                 j = 2; --j > -1; )
                            q = h[j],
                                k = -1 !== q.indexOf("%"),
                            k !== (-1 !== i[j].indexOf("%")) && (l = 0 === j ? a.offsetWidth - L.width : a.offsetHeight - L.height,
                                h[j] = k ? parseFloat(q) / 100 * l + "px" : parseFloat(q) / l * 100 + "%");
                        q = h.join(" ")
                    }
                    return this.parseComplex(a.style, q, r, f, g)
                },
                formatter: bb
            }),
            qb("backgroundSize", {
                defaultValue: "0 0",
                formatter: bb
            }),
            qb("perspective", {
                defaultValue: "0px",
                prefix: !0
            }),
            qb("perspectiveOrigin", {
                defaultValue: "50% 50%",
                prefix: !0
            }),
            qb("transformStyle", {
                prefix: !0
            }),
            qb("backfaceVisibility", {
                prefix: !0
            }),
            qb("userSelect", {
                prefix: !0
            }),
            qb("margin", {
                parser: kb("marginTop,marginRight,marginBottom,marginLeft")
            }),
            qb("padding", {
                parser: kb("paddingTop,paddingRight,paddingBottom,paddingLeft")
            }),
            qb("clip", {
                defaultValue: "rect(0px,0px,0px,0px)",
                parser: function(a, b, c, d, f, g) {
                    var h, i, j;
                    return 9 > o ? (i = a.currentStyle,
                        j = 8 > o ? " " : ",",
                        h = "rect(" + i.clipTop + j + i.clipRight + j + i.clipBottom + j + i.clipLeft + ")",
                        b = this.format(b).split(",").join(j)) : (h = this.format(V(a, this.p, e, !1, this.dflt)),
                        b = this.format(b)),
                        this.parseComplex(a.style, h, b, f, g)
                }
            }),
            qb("textShadow", {
                defaultValue: "0px 0px 0px #999",
                color: !0,
                multi: !0
            }),
            qb("autoRound,strictUnits", {
                parser: function(a, b, c, d, e) {
                    return e
                }
            }),
            qb("border", {
                defaultValue: "0px solid #000",
                parser: function(a, b, c, d, f, g) {
                    return this.parseComplex(a.style, this.format(V(a, "borderTopWidth", e, !1, "0px") + " " + V(a, "borderTopStyle", e, !1, "solid") + " " + V(a, "borderTopColor", e, !1, "#000")), this.format(b), f, g)
                },
                color: !0,
                formatter: function(a) {
                    var b = a.split(" ");
                    return b[0] + " " + (b[1] || "solid") + " " + (a.match(ib) || ["#000"])[0]
                }
            }),
            qb("borderWidth", {
                parser: kb("borderTopWidth,borderRightWidth,borderBottomWidth,borderLeftWidth")
            }),
            qb("float,cssFloat,styleFloat", {
                parser: function(a, b, c, d, e) {
                    var f = a.style
                        , g = "cssFloat"in f ? "cssFloat" : "styleFloat";
                    return new mb(f,g,0,0,e,-1,c,!1,0,f[g],b)
                }
            });
        var Ib = function(a) {
            var b, c = this.t, d = c.filter || V(this.data, "filter") || "", e = this.s + this.c * a | 0;
            100 === e && (-1 === d.indexOf("atrix(") && -1 === d.indexOf("radient(") && -1 === d.indexOf("oader(") ? (c.removeAttribute("filter"),
                b = !V(this.data, "filter")) : (c.filter = d.replace(w, ""),
                b = !0)),
            b || (this.xn1 && (c.filter = d = d || "alpha(opacity=" + e + ")"),
                -1 === d.indexOf("pacity") ? 0 === e && this.xn1 || (c.filter = d + " alpha(opacity=" + e + ")") : c.filter = d.replace(u, "opacity=" + e))
        };
        qb("opacity,alpha,autoAlpha", {
            defaultValue: "1",
            parser: function(a, b, c, d, f, g) {
                var h = parseFloat(V(a, "opacity", e, !1, "1"))
                    , i = a.style
                    , j = "autoAlpha" === c;
                return "string" == typeof b && "=" === b.charAt(1) && (b = ("-" === b.charAt(0) ? -1 : 1) * parseFloat(b.substr(2)) + h),
                j && 1 === h && "hidden" === V(a, "viscleibility", e) && 0 !== b && (h = 0),
                    O ? f = new mb(i,"opacity",h,b - h,f) : (f = new mb(i,"opacity",100 * h,100 * (b - h),f),
                        f.xn1 = j ? 1 : 0,
                        i.zoom = 1,
                        f.type = 2,
                        f.b = "alpha(opacity=" + f.s + ")",
                        f.e = "alpha(opacity=" + (f.s + f.c) + ")",
                        f.data = a,
                        f.plugin = g,
                        f.setRatio = Ib),
                j && (f = new mb(i,"visibility",0,0,f,-1,null,!1,0,0 !== h ? "inherit" : "hidden",0 === b ? "hidden" : "inherit"),
                    f.xs0 = "inherit",
                    d._overwriteProps.push(f.n),
                    d._overwriteProps.push(c)),
                    f
            }
        });
        var Jb = function(a, b) {
            b && (a.removeProperty ? ("ms" === b.substr(0, 2) && (b = "M" + b.substr(1)),
                a.removeProperty(b.replace(y, "-$1").toLowerCase())) : a.removeAttribute(b))
        }
            , Kb = function(a) {
            if (this.t._gsClassPT = this,
            1 === a || 0 === a) {
                this.t.setAttribute("class", 0 === a ? this.b : this.e);
                for (var b = this.data, c = this.t.style; b; )
                    b.v ? c[b.p] = b.v : Jb(c, b.p),
                        b = b._next;
                1 === a && this.t._gsClassPT === this && (this.t._gsClassPT = null)
            } else
                this.t.getAttribute("class") !== this.e && this.t.setAttribute("class", this.e)
        };
        qb("className", {
            parser: function(a, b, d, f, g, h, i) {
                var j, k, l, m, n, o = a.getAttribute("class") || "", p = a.style.cssText;
                if (g = f._classNamePT = new mb(a,d,0,0,g,2),
                    g.setRatio = Kb,
                    g.pr = -11,
                    c = !0,
                    g.b = o,
                    k = Y(a, e),
                    l = a._gsClassPT) {
                    for (m = {},
                             n = l.data; n; )
                        m[n.p] = 1,
                            n = n._next;
                    l.setRatio(1)
                }
                return a._gsClassPT = g,
                    g.e = "=" !== b.charAt(1) ? b : o.replace(new RegExp("\\s*\\b" + b.substr(2) + "\\b"), "") + ("+" === b.charAt(0) ? " " + b.substr(2) : ""),
                f._tween._duration && (a.setAttribute("class", g.e),
                    j = Z(a, k, Y(a), i, m),
                    a.setAttribute("class", o),
                    g.data = j.firstMPT,
                    a.style.cssText = p,
                    g = g.xfirst = f.parse(a, j.difs, g, h)),
                    g
            }
        });
        var Lb = function(a) {
            if ((1 === a || 0 === a) && this.data._totalTime === this.data._totalDuration && "isFromStart" !== this.data.data) {
                var b, c, d, e, f = this.t.style, g = h.transform.parse;
                if ("all" === this.e)
                    f.cssText = "",
                        e = !0;
                else
                    for (b = this.e.split(" ").join("").split(","),
                             d = b.length; --d > -1; )
                        c = b[d],
                        h[c] && (h[c].parse === g ? e = !0 : c = "transformOrigin" === c ? wb : h[c].p),
                            Jb(f, c);
                e && (Jb(f, ub),
                this.t._gsTransform && delete this.t._gsTransform)
            }
        };
        for (qb("clearProps", {
            parser: function(a, b, d, e, f) {
                return f = new mb(a,d,0,0,f,2),
                    f.setRatio = Lb,
                    f.e = b,
                    f.pr = -10,
                    f.data = e._tween,
                    c = !0,
                    f
            }
        }),
                 i = "bezier,throwProps,physicsProps,physics2D".split(","),
                 ob = i.length; ob--; )
            rb(i[ob]);
        i = g.prototype,
            i._firstPT = null,
            i._onInitTween = function(a, b, h) {
                if (!a.nodeType)
                    return !1;
                this._target = a,
                    this._tween = h,
                    this._vars = b,
                    j = b.autoRound,
                    c = !1,
                    d = b.suffixMap || g.suffixMap,
                    e = U(a, ""),
                    f = this._overwriteProps;
                var i, m, o, p, q, r, s, t, u, w = a.style;
                if (k && "" === w.zIndex && (i = V(a, "zIndex", e),
                ("auto" === i || "" === i) && this._addLazySet(w, "zIndex", 0)),
                "string" == typeof b && (p = w.cssText,
                    i = Y(a, e),
                    w.cssText = p + ";" + b,
                    i = Z(a, i, Y(a)).difs,
                !O && v.test(b) && (i.opacity = parseFloat(RegExp.$1)),
                    b = i,
                    w.cssText = p),
                    this._firstPT = m = this.parse(a, b, null),
                    this._transformType) {
                    for (u = 3 === this._transformType,
                             ub ? l && (k = !0,
                             "" === w.zIndex && (s = V(a, "zIndex", e),
                             ("auto" === s || "" === s) && this._addLazySet(w, "zIndex", 0)),
                             n && this._addLazySet(w, "WebkitBackfaceVisibility", this._vars.WebkitBackfaceVisibility || (u ? "visible" : "hidden"))) : w.zoom = 1,
                             o = m; o && o._next; )
                        o = o._next;
                    t = new mb(a,"transform",0,0,null,2),
                        this._linkCSSP(t, null, o),
                        t.setRatio = u && xb ? Gb : ub ? Hb : Fb,
                        t.data = this._transform || Eb(a, e, !0),
                        f.pop()
                }
                if (c) {
                    for (; m; ) {
                        for (r = m._next,
                                 o = p; o && o.pr > m.pr; )
                            o = o._next;
                        (m._prev = o ? o._prev : q) ? m._prev._next = m : p = m,
                            (m._next = o) ? o._prev = m : q = m,
                            m = r
                    }
                    this._firstPT = p
                }
                return !0
            }
            ,
            i.parse = function(a, b, c, f) {
                var g, i, k, l, m, n, o, p, q, r, s = a.style;
                for (g in b)
                    n = b[g],
                        i = h[g],
                        i ? c = i.parse(a, n, g, this, c, f, b) : (m = V(a, g, e) + "",
                            q = "string" == typeof n,
                            "color" === g || "fill" === g || "stroke" === g || -1 !== g.indexOf("Color") || q && x.test(n) ? (q || (n = hb(n),
                                n = (n.length > 3 ? "rgba(" : "rgb(") + n.join(",") + ")"),
                                c = nb(s, g, m, n, !0, "transparent", c, 0, f)) : !q || -1 === n.indexOf(" ") && -1 === n.indexOf(",") ? (k = parseFloat(m),
                                o = k || 0 === k ? m.substr((k + "").length) : "",
                            ("" === m || "auto" === m) && ("width" === g || "height" === g ? (k = ab(a, g, e),
                                o = "px") : "left" === g || "top" === g ? (k = X(a, g, e),
                                o = "px") : (k = "opacity" !== g ? 0 : 1,
                                o = "")),
                                r = q && "=" === n.charAt(1),
                                r ? (l = parseInt(n.charAt(0) + "1", 10),
                                    n = n.substr(2),
                                    l *= parseFloat(n),
                                    p = n.replace(t, "")) : (l = parseFloat(n),
                                    p = q ? n.substr((l + "").length) || "" : ""),
                            "" === p && (p = g in d ? d[g] : o),
                                n = l || 0 === l ? (r ? l + k : l) + p : b[g],
                            o !== p && "" !== p && (l || 0 === l) && k && (k = W(a, g, k, o),
                                "%" === p ? (k /= W(a, g, 100, "%") / 100,
                                b.strictUnits !== !0 && (m = k + "%")) : "em" === p ? k /= W(a, g, 1, "em") : "px" !== p && (l = W(a, g, l, p),
                                    p = "px"),
                            r && (l || 0 === l) && (n = l + k + p)),
                            r && (l += k),
                                !k && 0 !== k || !l && 0 !== l ? void 0 !== s[g] && (n || n + "" != "NaN" && null != n) ? (c = new mb(s,g,l || k || 0,0,c,-1,g,!1,0,m,n),
                                    c.xs0 = "none" !== n || "display" !== g && -1 === g.indexOf("Style") ? n : m) : Q("invalid " + g + " tween value: " + b[g]) : (c = new mb(s,g,k,l - k,c,0,g,j !== !1 && ("px" === p || "zIndex" === g),0,m,n),
                                    c.xs0 = p)) : c = nb(s, g, m, n, !0, null, c, 0, f)),
                    f && c && !c.plugin && (c.plugin = f);
                return c
            }
            ,
            i.setRatio = function(a) {
                var b, c, d, e = this._firstPT, f = 1e-6;
                if (1 !== a || this._tween._time !== this._tween._duration && 0 !== this._tween._time)
                    if (a || this._tween._time !== this._tween._duration && 0 !== this._tween._time || this._tween._rawPrevTime === -1e-6)
                        for (; e; ) {
                            if (b = e.c * a + e.s,
                                e.r ? b = Math.round(b) : f > b && b > -f && (b = 0),
                                e.type)
                                if (1 === e.type)
                                    if (d = e.l,
                                    2 === d)
                                        e.t[e.p] = e.xs0 + b + e.xs1 + e.xn1 + e.xs2;
                                    else if (3 === d)
                                        e.t[e.p] = e.xs0 + b + e.xs1 + e.xn1 + e.xs2 + e.xn2 + e.xs3;
                                    else if (4 === d)
                                        e.t[e.p] = e.xs0 + b + e.xs1 + e.xn1 + e.xs2 + e.xn2 + e.xs3 + e.xn3 + e.xs4;
                                    else if (5 === d)
                                        e.t[e.p] = e.xs0 + b + e.xs1 + e.xn1 + e.xs2 + e.xn2 + e.xs3 + e.xn3 + e.xs4 + e.xn4 + e.xs5;
                                    else {
                                        for (c = e.xs0 + b + e.xs1,
                                                 d = 1; d < e.l; d++)
                                            c += e["xn" + d] + e["xs" + (d + 1)];
                                        e.t[e.p] = c
                                    }
                                else
                                    -1 === e.type ? e.t[e.p] = e.xs0 : e.setRatio && e.setRatio(a);
                            else
                                e.t[e.p] = b + e.xs0;
                            e = e._next
                        }
                    else
                        for (; e; )
                            2 !== e.type ? e.t[e.p] = e.b : e.setRatio(a),
                                e = e._next;
                else
                    for (; e; )
                        2 !== e.type ? e.t[e.p] = e.e : e.setRatio(a),
                            e = e._next
            }
            ,
            i._enableTransforms = function(a) {
                this._transform = this._transform || Eb(this._target, e, !0),
                    this._transformType = this._transform.svg && sb || !a && 3 !== this._transformType ? 2 : 3
            }
        ;
        var Mb = function() {
            this.t[this.p] = this.e,
                this.data._linkCSSP(this, this._next, null, !0)
        };
        i._addLazySet = function(a, b, c) {
            var d = this._firstPT = new mb(a,b,0,0,this._firstPT,2);
            d.e = c,
                d.setRatio = Mb,
                d.data = this
        }
            ,
            i._linkCSSP = function(a, b, c, d) {
                return a && (b && (b._prev = a),
                a._next && (a._next._prev = a._prev),
                    a._prev ? a._prev._next = a._next : this._firstPT === a && (this._firstPT = a._next,
                        d = !0),
                    c ? c._next = a : d || null !== this._firstPT || (this._firstPT = a),
                    a._next = b,
                    a._prev = c),
                    a
            }
            ,
            i._kill = function(b) {
                var c, d, e, f = b;
                if (b.autoAlpha || b.alpha) {
                    f = {};
                    for (d in b)
                        f[d] = b[d];
                    f.opacity = 1,
                    f.autoAlpha && (f.visibility = 1)
                }
                return b.className && (c = this._classNamePT) && (e = c.xfirst,
                    e && e._prev ? this._linkCSSP(e._prev, c._next, e._prev._prev) : e === this._firstPT && (this._firstPT = c._next),
                c._next && this._linkCSSP(c._next, c._next._next, e._prev),
                    this._classNamePT = null),
                    a.prototype._kill.call(this, f)
            }
        ;
        var Nb = function(a, b, c) {
            var d, e, f, g;
            if (a.slice)
                for (e = a.length; --e > -1; )
                    Nb(a[e], b, c);
            else
                for (d = a.childNodes,
                         e = d.length; --e > -1; )
                    f = d[e],
                        g = f.type,
                    f.style && (b.push(Y(f)),
                    c && c.push(f)),
                    1 !== g && 9 !== g && 11 !== g || !f.childNodes.length || Nb(f, b, c)
        };
        return g.cascadeTo = function(a, c, d) {
            var e, f, g, h = b.to(a, c, d), i = [h], j = [], k = [], l = [], m = b._internals.reservedProps;
            for (a = h._targets || h.target,
                     Nb(a, j, l),
                     h.render(c, !0),
                     Nb(a, k),
                     h.render(0, !0),
                     h._enabled(!0),
                     e = l.length; --e > -1; )
                if (f = Z(l[e], j[e], k[e]),
                    f.firstMPT) {
                    f = f.difs;
                    for (g in d)
                        m[g] && (f[g] = d[g]);
                    i.push(b.to(l[e], c, f))
                }
            return i
        }
            ,
            a.activate([g]),
            g
    }, !0)
}),
_gsScope._gsDefine && _gsScope._gsQueue.pop()(),
    function(a) {
        "use strict";
        var b = function() {
            return (_gsScope.GreenSockGlobals || _gsScope)[a]
        };
        "function" == typeof define && define.amd ? define(["TweenLite"], b) : "undefined" != typeof module && module.exports && (require("../TweenLite.js"),
            module.exports = b())
    }("CSSPlugin");

/*!
 * VERSION: 1.7.4
 * DATE: 2014-07-17
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2014, GreenSock. All rights reserved.
 * This work is subject to the terms at http://www.greensock.com/terms_of_use.html or for
 * Club GreenSock members, the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 **/

var _gsScope = "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window;
(_gsScope._gsQueue || (_gsScope._gsQueue = [])).push(function() {
    "use strict";
    var a = document.documentElement
        , b = window
        , c = function(c, d) {
        var e = "x" === d ? "Width" : "Height"
            , f = "scroll" + e
            , g = "client" + e
            , h = document.body;
        return c === b || c === a || c === h ? Math.max(a[f], h[f]) - (b["inner" + e] || Math.max(a[g], h[g])) : c[f] - c["offset" + e]
    }
        , d = _gsScope._gsDefine.plugin({
        propName: "scrollTo",
        API: 2,
        version: "1.7.4",
        init: function(a, d, e) {
            return this._wdw = a === b,
                this._target = a,
                this._tween = e,
            "object" != typeof d && (d = {
                y: d
            }),
                this.vars = d,
                this._autoKill = d.autoKill !== !1,
                this.x = this.xPrev = this.getX(),
                this.y = this.yPrev = this.getY(),
                null != d.x ? (this._addTween(this, "x", this.x, "max" === d.x ? c(a, "x") : d.x, "scrollTo_x", !0),
                    this._overwriteProps.push("scrollTo_x")) : this.skipX = !0,
                null != d.y ? (this._addTween(this, "y", this.y, "max" === d.y ? c(a, "y") : d.y, "scrollTo_y", !0),
                    this._overwriteProps.push("scrollTo_y")) : this.skipY = !0,
                !0
        },
        set: function(a) {
            this._super.setRatio.call(this, a);
            var d = this._wdw || !this.skipX ? this.getX() : this.xPrev
                , e = this._wdw || !this.skipY ? this.getY() : this.yPrev
                , f = e - this.yPrev
                , g = d - this.xPrev;
            this._autoKill && (!this.skipX && (g > 7 || -7 > g) && d < c(this._target, "x") && (this.skipX = !0),
            !this.skipY && (f > 7 || -7 > f) && e < c(this._target, "y") && (this.skipY = !0),
            this.skipX && this.skipY && (this._tween.kill(),
            this.vars.onAutoKill && this.vars.onAutoKill.apply(this.vars.onAutoKillScope || this._tween, this.vars.onAutoKillParams || []))),
                this._wdw ? b.scrollTo(this.skipX ? d : this.x, this.skipY ? e : this.y) : (this.skipY || (this._target.scrollTop = this.y),
                this.skipX || (this._target.scrollLeft = this.x)),
                this.xPrev = this.x,
                this.yPrev = this.y
        }
    })
        , e = d.prototype;
    d.max = c,
        e.getX = function() {
            return this._wdw ? null != b.pageXOffset ? b.pageXOffset : null != a.scrollLeft ? a.scrollLeft : document.body.scrollLeft : this._target.scrollLeft
        }
        ,
        e.getY = function() {
            return this._wdw ? null != b.pageYOffset ? b.pageYOffset : null != a.scrollTop ? a.scrollTop : document.body.scrollTop : this._target.scrollTop
        }
        ,
        e._kill = function(a) {
            return a.scrollTo_x && (this.skipX = !0),
            a.scrollTo_y && (this.skipY = !0),
                this._super._kill.call(this, a)
        }
}),
_gsScope._gsDefine && _gsScope._gsQueue.pop()();
/*!
 * VERSION: beta 1.9.4
 * DATE: 2014-07-17
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2014, GreenSock. All rights reserved.
 * This work is subject to the terms at http://www.greensock.com/terms_of_use.html or for
 * Club GreenSock members, the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 **/

var _gsScope = "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window;
(_gsScope._gsQueue || (_gsScope._gsQueue = [])).push(function() {
    "use strict";
    _gsScope._gsDefine("easing.Back", ["easing.Ease"], function(a) {
        var b, c, d, e = _gsScope.GreenSockGlobals || _gsScope, f = e.com.greensock, g = 2 * Math.PI, h = Math.PI / 2, i = f._class, j = function(b, c) {
            var d = i("easing." + b, function() {}, !0)
                , e = d.prototype = new a;
            return e.constructor = d,
                e.getRatio = c,
                d
        }, k = a.register || function() {}
            , l = function(a, b, c, d) {
            var e = i("easing." + a, {
                easeOut: new b,
                easeIn: new c,
                easeInOut: new d
            }, !0);
            return k(e, a),
                e
        }, m = function(a, b, c) {
            this.t = a,
                this.v = b,
            c && (this.next = c,
                c.prev = this,
                this.c = c.v - b,
                this.gap = c.t - a)
        }, n = function(b, c) {
            var d = i("easing." + b, function(a) {
                this._p1 = a || 0 === a ? a : 1.70158,
                    this._p2 = 1.525 * this._p1
            }, !0)
                , e = d.prototype = new a;
            return e.constructor = d,
                e.getRatio = c,
                e.config = function(a) {
                    return new d(a)
                }
                ,
                d
        }, o = l("Back", n("BackOut", function(a) {
            return (a -= 1) * a * ((this._p1 + 1) * a + this._p1) + 1
        }), n("BackIn", function(a) {
            return a * a * ((this._p1 + 1) * a - this._p1)
        }), n("BackInOut", function(a) {
            return (a *= 2) < 1 ? .5 * a * a * ((this._p2 + 1) * a - this._p2) : .5 * ((a -= 2) * a * ((this._p2 + 1) * a + this._p2) + 2)
        })), p = i("easing.SlowMo", function(a, b, c) {
            b = b || 0 === b ? b : .7,
                null == a ? a = .7 : a > 1 && (a = 1),
                this._p = 1 !== a ? b : 0,
                this._p1 = (1 - a) / 2,
                this._p2 = a,
                this._p3 = this._p1 + this._p2,
                this._calcEnd = c === !0
        }, !0), q = p.prototype = new a;
        return q.constructor = p,
            q.getRatio = function(a) {
                var b = a + (.5 - a) * this._p;
                return a < this._p1 ? this._calcEnd ? 1 - (a = 1 - a / this._p1) * a : b - (a = 1 - a / this._p1) * a * a * a * b : a > this._p3 ? this._calcEnd ? 1 - (a = (a - this._p3) / this._p1) * a : b + (a - b) * (a = (a - this._p3) / this._p1) * a * a * a : this._calcEnd ? 1 : b
            }
            ,
            p.ease = new p(.7,.7),
            q.config = p.config = function(a, b, c) {
                return new p(a,b,c)
            }
            ,
            b = i("easing.SteppedEase", function(a) {
                a = a || 1,
                    this._p1 = 1 / a,
                    this._p2 = a + 1
            }, !0),
            q = b.prototype = new a,
            q.constructor = b,
            q.getRatio = function(a) {
                return 0 > a ? a = 0 : a >= 1 && (a = .999999999),
                (this._p2 * a >> 0) * this._p1
            }
            ,
            q.config = b.config = function(a) {
                return new b(a)
            }
            ,
            c = i("easing.RoughEase", function(b) {
                b = b || {};
                for (var c, d, e, f, g, h, i = b.taper || "none", j = [], k = 0, l = 0 | (b.points || 20), n = l, o = b.randomize !== !1, p = b.clamp === !0, q = b.template instanceof a ? b.template : null, r = "number" == typeof b.strength ? .4 * b.strength : .4; --n > -1; )
                    c = o ? Math.random() : 1 / l * n,
                        d = q ? q.getRatio(c) : c,
                        "none" === i ? e = r : "out" === i ? (f = 1 - c,
                            e = f * f * r) : "in" === i ? e = c * c * r : .5 > c ? (f = 2 * c,
                            e = f * f * .5 * r) : (f = 2 * (1 - c),
                            e = f * f * .5 * r),
                        o ? d += Math.random() * e - .5 * e : n % 2 ? d += .5 * e : d -= .5 * e,
                    p && (d > 1 ? d = 1 : 0 > d && (d = 0)),
                        j[k++] = {
                            x: c,
                            y: d
                        };
                for (j.sort(function(a, b) {
                    return a.x - b.x
                }),
                         h = new m(1,1,null),
                         n = l; --n > -1; )
                    g = j[n],
                        h = new m(g.x,g.y,h);
                this._prev = new m(0,0,0 !== h.t ? h : h.next)
            }, !0),
            q = c.prototype = new a,
            q.constructor = c,
            q.getRatio = function(a) {
                var b = this._prev;
                if (a > b.t) {
                    for (; b.next && a >= b.t; )
                        b = b.next;
                    b = b.prev
                } else
                    for (; b.prev && a <= b.t; )
                        b = b.prev;
                return this._prev = b,
                b.v + (a - b.t) / b.gap * b.c
            }
            ,
            q.config = function(a) {
                return new c(a)
            }
            ,
            c.ease = new c,
            l("Bounce", j("BounceOut", function(a) {
                return 1 / 2.75 > a ? 7.5625 * a * a : 2 / 2.75 > a ? 7.5625 * (a -= 1.5 / 2.75) * a + .75 : 2.5 / 2.75 > a ? 7.5625 * (a -= 2.25 / 2.75) * a + .9375 : 7.5625 * (a -= 2.625 / 2.75) * a + .984375
            }), j("BounceIn", function(a) {
                return (a = 1 - a) < 1 / 2.75 ? 1 - 7.5625 * a * a : 2 / 2.75 > a ? 1 - (7.5625 * (a -= 1.5 / 2.75) * a + .75) : 2.5 / 2.75 > a ? 1 - (7.5625 * (a -= 2.25 / 2.75) * a + .9375) : 1 - (7.5625 * (a -= 2.625 / 2.75) * a + .984375)
            }), j("BounceInOut", function(a) {
                var b = .5 > a;
                return a = b ? 1 - 2 * a : 2 * a - 1,
                    a = 1 / 2.75 > a ? 7.5625 * a * a : 2 / 2.75 > a ? 7.5625 * (a -= 1.5 / 2.75) * a + .75 : 2.5 / 2.75 > a ? 7.5625 * (a -= 2.25 / 2.75) * a + .9375 : 7.5625 * (a -= 2.625 / 2.75) * a + .984375,
                    b ? .5 * (1 - a) : .5 * a + .5
            })),
            l("Circ", j("CircOut", function(a) {
                return Math.sqrt(1 - (a -= 1) * a)
            }), j("CircIn", function(a) {
                return -(Math.sqrt(1 - a * a) - 1)
            }), j("CircInOut", function(a) {
                return (a *= 2) < 1 ? -.5 * (Math.sqrt(1 - a * a) - 1) : .5 * (Math.sqrt(1 - (a -= 2) * a) + 1)
            })),
            d = function(b, c, d) {
                var e = i("easing." + b, function(a, b) {
                    this._p1 = a || 1,
                        this._p2 = b || d,
                        this._p3 = this._p2 / g * (Math.asin(1 / this._p1) || 0)
                }, !0)
                    , f = e.prototype = new a;
                return f.constructor = e,
                    f.getRatio = c,
                    f.config = function(a, b) {
                        return new e(a,b)
                    }
                    ,
                    e
            }
            ,
            l("Elastic", d("ElasticOut", function(a) {
                return this._p1 * Math.pow(2, -10 * a) * Math.sin((a - this._p3) * g / this._p2) + 1
            }, .3), d("ElasticIn", function(a) {
                return -(this._p1 * Math.pow(2, 10 * (a -= 1)) * Math.sin((a - this._p3) * g / this._p2))
            }, .3), d("ElasticInOut", function(a) {
                return (a *= 2) < 1 ? -.5 * this._p1 * Math.pow(2, 10 * (a -= 1)) * Math.sin((a - this._p3) * g / this._p2) : this._p1 * Math.pow(2, -10 * (a -= 1)) * Math.sin((a - this._p3) * g / this._p2) * .5 + 1
            }, .45)),
            l("Expo", j("ExpoOut", function(a) {
                return 1 - Math.pow(2, -10 * a)
            }), j("ExpoIn", function(a) {
                return Math.pow(2, 10 * (a - 1)) - .001
            }), j("ExpoInOut", function(a) {
                return (a *= 2) < 1 ? .5 * Math.pow(2, 10 * (a - 1)) : .5 * (2 - Math.pow(2, -10 * (a - 1)))
            })),
            l("Sine", j("SineOut", function(a) {
                return Math.sin(a * h)
            }), j("SineIn", function(a) {
                return -Math.cos(a * h) + 1
            }), j("SineInOut", function(a) {
                return -.5 * (Math.cos(Math.PI * a) - 1)
            })),
            i("easing.EaseLookup", {
                find: function(b) {
                    return a.map[b]
                }
            }, !0),
            k(e.SlowMo, "SlowMo", "ease,"),
            k(c, "RoughEase", "ease,"),
            k(b, "SteppedEase", "ease,"),
            o
    }, !0)
}),
_gsScope._gsDefine && _gsScope._gsQueue.pop()(),
    /*!
 * VERSION: 1.14.2
 * DATE: 2014-10-28
 * UPDATES AND DOCS AT: http://www.greensock.com
 *
 * @license Copyright (c) 2008-2014, GreenSock. All rights reserved.
 * This work is subject to the terms at http://www.greensock.com/terms_of_use.html or for
 * Club GreenSock members, the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 */

    function(a, b) {
        "use strict";
        var c = a.GreenSockGlobals = a.GreenSockGlobals || a;
        if (!c.TweenLite) {
            var d, e, f, g, h, i = function(a) {
                    var b, d = a.split("."), e = c;
                    for (b = 0; b < d.length; b++)
                        e[d[b]] = e = e[d[b]] || {};
                    return e
                }, j = i("com.greensock"), k = 1e-10, l = function(a) {
                    var b, c = [], d = a.length;
                    for (b = 0; b !== d; c.push(a[b++]))
                        ;
                    return c
                }, m = function() {}, n = function() {
                    var a = Object.prototype.toString
                        , b = a.call([]);
                    return function(c) {
                        return null != c && (c instanceof Array || "object" == typeof c && !!c.push && a.call(c) === b)
                    }
                }(), o = {}, p = function(d, e, f, g) {
                    this.sc = o[d] ? o[d].sc : [],
                        o[d] = this,
                        this.gsClass = null,
                        this.func = f;
                    var h = [];
                    this.check = function(j) {
                        for (var k, l, m, n, q = e.length, r = q; --q > -1; )
                            (k = o[e[q]] || new p(e[q],[])).gsClass ? (h[q] = k.gsClass,
                                r--) : j && k.sc.push(this);
                        if (0 === r && f)
                            for (l = ("com.greensock." + d).split("."),
                                     m = l.pop(),
                                     n = i(l.join("."))[m] = this.gsClass = f.apply(f, h),
                                 g && (c[m] = n,
                                     "function" == typeof define && define.amd ? define((a.GreenSockAMDPath ? a.GreenSockAMDPath + "/" : "") + d.split(".").pop(), [], function() {
                                         return n
                                     }) : d === b && "undefined" != typeof module && module.exports && (module.exports = n)),
                                     q = 0; q < this.sc.length; q++)
                                this.sc[q].check()
                    }
                        ,
                        this.check(!0)
                }, q = a._gsDefine = function(a, b, c, d) {
                    return new p(a,b,c,d)
                }
                , r = j._class = function(a, b, c) {
                    return b = b || function() {}
                        ,
                        q(a, [], function() {
                            return b
                        }, c),
                        b
                }
            ;
            q.globals = c;
            var s = [0, 0, 1, 1]
                , t = []
                , u = r("easing.Ease", function(a, b, c, d) {
                    this._func = a,
                        this._type = c || 0,
                        this._power = d || 0,
                        this._params = b ? s.concat(b) : s
                }, !0)
                , v = u.map = {}
                , w = u.register = function(a, b, c, d) {
                    for (var e, f, g, h, i = b.split(","), k = i.length, l = (c || "easeIn,easeOut,easeInOut").split(","); --k > -1; )
                        for (f = i[k],
                                 e = d ? r("easing." + f, null, !0) : j.easing[f] || {},
                                 g = l.length; --g > -1; )
                            h = l[g],
                                v[f + "." + h] = v[h + f] = e[h] = a.getRatio ? a : a[h] || new a
                }
            ;
            for (f = u.prototype,
                     f._calcEnd = !1,
                     f.getRatio = function(a) {
                         if (this._func)
                             return this._params[0] = a,
                                 this._func.apply(null, this._params);
                         var b = this._type
                             , c = this._power
                             , d = 1 === b ? 1 - a : 2 === b ? a : .5 > a ? 2 * a : 2 * (1 - a);
                         return 1 === c ? d *= d : 2 === c ? d *= d * d : 3 === c ? d *= d * d * d : 4 === c && (d *= d * d * d * d),
                             1 === b ? 1 - d : 2 === b ? d : .5 > a ? d / 2 : 1 - d / 2
                     }
                     ,
                     d = ["Linear", "Quad", "Cubic", "Quart", "Quint,Strong"],
                     e = d.length; --e > -1; )
                f = d[e] + ",Power" + e,
                    w(new u(null,null,1,e), f, "easeOut", !0),
                    w(new u(null,null,2,e), f, "easeIn" + (0 === e ? ",easeNone" : "")),
                    w(new u(null,null,3,e), f, "easeInOut");
            v.linear = j.easing.Linear.easeIn,
                v.swing = j.easing.Quad.easeInOut;
            var x = r("events.EventDispatcher", function(a) {
                this._listeners = {},
                    this._eventTarget = a || this
            });
            f = x.prototype,
                f.addEventListener = function(a, b, c, d, e) {
                    e = e || 0;
                    var f, i, j = this._listeners[a], k = 0;
                    for (null == j && (this._listeners[a] = j = []),
                             i = j.length; --i > -1; )
                        f = j[i],
                            f.c === b && f.s === c ? j.splice(i, 1) : 0 === k && f.pr < e && (k = i + 1);
                    j.splice(k, 0, {
                        c: b,
                        s: c,
                        up: d,
                        pr: e
                    }),
                    this !== g || h || g.wake()
                }
                ,
                f.removeEventListener = function(a, b) {
                    var c, d = this._listeners[a];
                    if (d)
                        for (c = d.length; --c > -1; )
                            if (d[c].c === b)
                                return void d.splice(c, 1)
                }
                ,
                f.dispatchEvent = function(a) {
                    var b, c, d, e = this._listeners[a];
                    if (e)
                        for (b = e.length,
                                 c = this._eventTarget; --b > -1; )
                            d = e[b],
                            d && (d.up ? d.c.call(d.s || c, {
                                type: a,
                                target: c
                            }) : d.c.call(d.s || c))
                }
            ;
            var y = a.requestAnimationFrame
                , z = a.cancelAnimationFrame
                , A = Date.now || function() {
                return (new Date).getTime()
            }
                , B = A();
            for (d = ["ms", "moz", "webkit", "o"],
                     e = d.length; --e > -1 && !y; )
                y = a[d[e] + "RequestAnimationFrame"],
                    z = a[d[e] + "CancelAnimationFrame"] || a[d[e] + "CancelRequestAnimationFrame"];
            r("Ticker", function(a, b) {
                var c, d, e, f, i, j = this, l = A(), n = b !== !1 && y, o = 500, p = 33, q = function(a) {
                    var b, g, h = A() - B;
                    h > o && (l += h - p),
                        B += h,
                        j.time = (B - l) / 1e3,
                        b = j.time - i,
                    (!c || b > 0 || a === !0) && (j.frame++,
                        i += b + (b >= f ? .004 : f - b),
                        g = !0),
                    a !== !0 && (e = d(q)),
                    g && j.dispatchEvent("tick")
                };
                x.call(j),
                    j.time = j.frame = 0,
                    j.tick = function() {
                        q(!0)
                    }
                    ,
                    j.lagSmoothing = function(a, b) {
                        o = a || 1 / k,
                            p = Math.min(b, o, 0)
                    }
                    ,
                    j.sleep = function() {
                        null != e && (n && z ? z(e) : clearTimeout(e),
                            d = m,
                            e = null,
                        j === g && (h = !1))
                    }
                    ,
                    j.wake = function() {
                        null !== e ? j.sleep() : j.frame > 10 && (B = A() - o + 5),
                            d = 0 === c ? m : n && y ? y : function(a) {
                                return setTimeout(a, 1e3 * (i - j.time) + 1 | 0)
                            }
                            ,
                        j === g && (h = !0),
                            q(2)
                    }
                    ,
                    j.fps = function(a) {
                        return arguments.length ? (c = a,
                            f = 1 / (c || 60),
                            i = this.time + f,
                            void j.wake()) : c
                    }
                    ,
                    j.useRAF = function(a) {
                        return arguments.length ? (j.sleep(),
                            n = a,
                            void j.fps(c)) : n
                    }
                    ,
                    j.fps(a),
                    setTimeout(function() {
                        n && (!e || j.frame < 5) && j.useRAF(!1)
                    }, 1500)
            }),
                f = j.Ticker.prototype = new j.events.EventDispatcher,
                f.constructor = j.Ticker;
            var C = r("core.Animation", function(a, b) {
                if (this.vars = b = b || {},
                    this._duration = this._totalDuration = a || 0,
                    this._delay = Number(b.delay) || 0,
                    this._timeScale = 1,
                    this._active = b.immediateRender === !0,
                    this.data = b.data,
                    this._reversed = b.reversed === !0,
                    R) {
                    h || g.wake();
                    var c = this.vars.useFrames ? Q : R;
                    c.add(this, c._time),
                    this.vars.paused && this.paused(!0)
                }
            });
            g = C.ticker = new j.Ticker,
                f = C.prototype,
                f._dirty = f._gc = f._initted = f._paused = !1,
                f._totalTime = f._time = 0,
                f._rawPrevTime = -1,
                f._next = f._last = f._onUpdate = f._timeline = f.timeline = null,
                f._paused = !1;
            var D = function() {
                h && A() - B > 2e3 && g.wake(),
                    setTimeout(D, 2e3)
            };
            D(),
                f.play = function(a, b) {
                    return null != a && this.seek(a, b),
                        this.reversed(!1).paused(!1)
                }
                ,
                f.pause = function(a, b) {
                    return null != a && this.seek(a, b),
                        this.paused(!0)
                }
                ,
                f.resume = function(a, b) {
                    return null != a && this.seek(a, b),
                        this.paused(!1)
                }
                ,
                f.seek = function(a, b) {
                    return this.totalTime(Number(a), b !== !1)
                }
                ,
                f.restart = function(a, b) {
                    return this.reversed(!1).paused(!1).totalTime(a ? -this._delay : 0, b !== !1, !0)
                }
                ,
                f.reverse = function(a, b) {
                    return null != a && this.seek(a || this.totalDuration(), b),
                        this.reversed(!0).paused(!1)
                }
                ,
                f.render = function() {}
                ,
                f.invalidate = function() {
                    return this._time = this._totalTime = 0,
                        this._initted = this._gc = !1,
                        this._rawPrevTime = -1,
                    (this._gc || !this.timeline) && this._enabled(!0),
                        this
                }
                ,
                f.isActive = function() {
                    var a, b = this._timeline, c = this._startTime;
                    return !b || !this._gc && !this._paused && b.isActive() && (a = b.rawTime()) >= c && a < c + this.totalDuration() / this._timeScale
                }
                ,
                f._enabled = function(a, b) {
                    return h || g.wake(),
                        this._gc = !a,
                        this._active = this.isActive(),
                    b !== !0 && (a && !this.timeline ? this._timeline.add(this, this._startTime - this._delay) : !a && this.timeline && this._timeline._remove(this, !0)),
                        !1
                }
                ,
                f._kill = function() {
                    return this._enabled(!1, !1)
                }
                ,
                f.kill = function(a, b) {
                    return this._kill(a, b),
                        this
                }
                ,
                f._uncache = function(a) {
                    for (var b = a ? this : this.timeline; b; )
                        b._dirty = !0,
                            b = b.timeline;
                    return this
                }
                ,
                f._swapSelfInParams = function(a) {
                    for (var b = a.length, c = a.concat(); --b > -1; )
                        "{self}" === a[b] && (c[b] = this);
                    return c
                }
                ,
                f.eventCallback = function(a, b, c, d) {
                    if ("on" === (a || "").substr(0, 2)) {
                        var e = this.vars;
                        if (1 === arguments.length)
                            return e[a];
                        null == b ? delete e[a] : (e[a] = b,
                            e[a + "Params"] = n(c) && -1 !== c.join("").indexOf("{self}") ? this._swapSelfInParams(c) : c,
                            e[a + "Scope"] = d),
                        "onUpdate" === a && (this._onUpdate = b)
                    }
                    return this
                }
                ,
                f.delay = function(a) {
                    return arguments.length ? (this._timeline.smoothChildTiming && this.startTime(this._startTime + a - this._delay),
                        this._delay = a,
                        this) : this._delay
                }
                ,
                f.duration = function(a) {
                    return arguments.length ? (this._duration = this._totalDuration = a,
                        this._uncache(!0),
                    this._timeline.smoothChildTiming && this._time > 0 && this._time < this._duration && 0 !== a && this.totalTime(this._totalTime * (a / this._duration), !0),
                        this) : (this._dirty = !1,
                        this._duration)
                }
                ,
                f.totalDuration = function(a) {
                    return this._dirty = !1,
                        arguments.length ? this.duration(a) : this._totalDuration
                }
                ,
                f.time = function(a, b) {
                    return arguments.length ? (this._dirty && this.totalDuration(),
                        this.totalTime(a > this._duration ? this._duration : a, b)) : this._time
                }
                ,
                f.totalTime = function(a, b, c) {
                    if (h || g.wake(),
                        !arguments.length)
                        return this._totalTime;
                    if (this._timeline) {
                        if (0 > a && !c && (a += this.totalDuration()),
                            this._timeline.smoothChildTiming) {
                            this._dirty && this.totalDuration();
                            var d = this._totalDuration
                                , e = this._timeline;
                            if (a > d && !c && (a = d),
                                this._startTime = (this._paused ? this._pauseTime : e._time) - (this._reversed ? d - a : a) / this._timeScale,
                            e._dirty || this._uncache(!1),
                                e._timeline)
                                for (; e._timeline; )
                                    e._timeline._time !== (e._startTime + e._totalTime) / e._timeScale && e.totalTime(e._totalTime, !0),
                                        e = e._timeline
                        }
                        this._gc && this._enabled(!0, !1),
                        (this._totalTime !== a || 0 === this._duration) && (this.render(a, b, !1),
                        I.length && S())
                    }
                    return this
                }
                ,
                f.progress = f.totalProgress = function(a, b) {
                    return arguments.length ? this.totalTime(this.duration() * a, b) : this._time / this.duration()
                }
                ,
                f.startTime = function(a) {
                    return arguments.length ? (a !== this._startTime && (this._startTime = a,
                    this.timeline && this.timeline._sortChildren && this.timeline.add(this, a - this._delay)),
                        this) : this._startTime
                }
                ,
                f.endTime = function(a) {
                    return this._startTime + (0 != a ? this.totalDuration() : this.duration()) / this._timeScale
                }
                ,
                f.timeScale = function(a) {
                    if (!arguments.length)
                        return this._timeScale;
                    if (a = a || k,
                    this._timeline && this._timeline.smoothChildTiming) {
                        var b = this._pauseTime
                            , c = b || 0 === b ? b : this._timeline.totalTime();
                        this._startTime = c - (c - this._startTime) * this._timeScale / a
                    }
                    return this._timeScale = a,
                        this._uncache(!1)
                }
                ,
                f.reversed = function(a) {
                    return arguments.length ? (a != this._reversed && (this._reversed = a,
                        this.totalTime(this._timeline && !this._timeline.smoothChildTiming ? this.totalDuration() - this._totalTime : this._totalTime, !0)),
                        this) : this._reversed
                }
                ,
                f.paused = function(a) {
                    if (!arguments.length)
                        return this._paused;
                    if (a != this._paused && this._timeline) {
                        h || a || g.wake();
                        var b = this._timeline
                            , c = b.rawTime()
                            , d = c - this._pauseTime;
                        !a && b.smoothChildTiming && (this._startTime += d,
                            this._uncache(!1)),
                            this._pauseTime = a ? c : null,
                            this._paused = a,
                            this._active = this.isActive(),
                        !a && 0 !== d && this._initted && this.duration() && this.render(b.smoothChildTiming ? this._totalTime : (c - this._startTime) / this._timeScale, !0, !0)
                    }
                    return this._gc && !a && this._enabled(!0, !1),
                        this
                }
            ;
            var E = r("core.SimpleTimeline", function(a) {
                C.call(this, 0, a),
                    this.autoRemoveChildren = this.smoothChildTiming = !0
            });
            f = E.prototype = new C,
                f.constructor = E,
                f.kill()._gc = !1,
                f._first = f._last = f._recent = null,
                f._sortChildren = !1,
                f.add = f.insert = function(a, b) {
                    var c, d;
                    if (a._startTime = Number(b || 0) + a._delay,
                    a._paused && this !== a._timeline && (a._pauseTime = a._startTime + (this.rawTime() - a._startTime) / a._timeScale),
                    a.timeline && a.timeline._remove(a, !0),
                        a.timeline = a._timeline = this,
                    a._gc && a._enabled(!0, !0),
                        c = this._last,
                        this._sortChildren)
                        for (d = a._startTime; c && c._startTime > d; )
                            c = c._prev;
                    return c ? (a._next = c._next,
                        c._next = a) : (a._next = this._first,
                        this._first = a),
                        a._next ? a._next._prev = a : this._last = a,
                        a._prev = c,
                        this._recent = a,
                    this._timeline && this._uncache(!0),
                        this
                }
                ,
                f._remove = function(a, b) {
                    return a.timeline === this && (b || a._enabled(!1, !0),
                        a._prev ? a._prev._next = a._next : this._first === a && (this._first = a._next),
                        a._next ? a._next._prev = a._prev : this._last === a && (this._last = a._prev),
                        a._next = a._prev = a.timeline = null,
                    a === this._recent && (this._recent = this._last),
                    this._timeline && this._uncache(!0)),
                        this
                }
                ,
                f.render = function(a, b, c) {
                    var d, e = this._first;
                    for (this._totalTime = this._time = this._rawPrevTime = a; e; )
                        d = e._next,
                        (e._active || a >= e._startTime && !e._paused) && (e._reversed ? e.render((e._dirty ? e.totalDuration() : e._totalDuration) - (a - e._startTime) * e._timeScale, b, c) : e.render((a - e._startTime) * e._timeScale, b, c)),
                            e = d
                }
                ,
                f.rawTime = function() {
                    return h || g.wake(),
                        this._totalTime
                }
            ;
            var F = r("TweenLite", function(b, c, d) {
                if (C.call(this, c, d),
                    this.render = F.prototype.render,
                null == b)
                    throw "Cannot tween a null target.";
                this.target = b = "string" != typeof b ? b : F.selector(b) || b;
                var e, f, g, h = b.jquery || b.length && b !== a && b[0] && (b[0] === a || b[0].nodeType && b[0].style && !b.nodeType), i = this.vars.overwrite;
                if (this._overwrite = i = null == i ? P[F.defaultOverwrite] : "number" == typeof i ? i >> 0 : P[i],
                (h || b instanceof Array || b.push && n(b)) && "number" != typeof b[0])
                    for (this._targets = g = l(b),
                             this._propLookup = [],
                             this._siblings = [],
                             e = 0; e < g.length; e++)
                        f = g[e],
                            f ? "string" != typeof f ? f.length && f !== a && f[0] && (f[0] === a || f[0].nodeType && f[0].style && !f.nodeType) ? (g.splice(e--, 1),
                                this._targets = g = g.concat(l(f))) : (this._siblings[e] = T(f, this, !1),
                            1 === i && this._siblings[e].length > 1 && V(f, this, null, 1, this._siblings[e])) : (f = g[e--] = F.selector(f),
                            "string" == typeof f && g.splice(e + 1, 1)) : g.splice(e--, 1);
                else
                    this._propLookup = {},
                        this._siblings = T(b, this, !1),
                    1 === i && this._siblings.length > 1 && V(b, this, null, 1, this._siblings);
                (this.vars.immediateRender || 0 === c && 0 === this._delay && this.vars.immediateRender !== !1) && (this._time = -k,
                    this.render(-this._delay))
            }, !0)
                , G = function(b) {
                return b && b.length && b !== a && b[0] && (b[0] === a || b[0].nodeType && b[0].style && !b.nodeType)
            }
                , H = function(a, b) {
                var c, d = {};
                for (c in a)
                    O[c] || c in b && "transform" !== c && "x" !== c && "y" !== c && "width" !== c && "height" !== c && "className" !== c && "border" !== c || !(!L[c] || L[c] && L[c]._autoCSS) || (d[c] = a[c],
                        delete a[c]);
                a.css = d
            };
            f = F.prototype = new C,
                f.constructor = F,
                f.kill()._gc = !1,
                f.ratio = 0,
                f._firstPT = f._targets = f._overwrittenProps = f._startAt = null,
                f._notifyPluginsOfEnabled = f._lazy = !1,
                F.version = "1.14.2",
                F.defaultEase = f._ease = new u(null,null,1,1),
                F.defaultOverwrite = "auto",
                F.ticker = g,
                F.autoSleep = !0,
                F.lagSmoothing = function(a, b) {
                    g.lagSmoothing(a, b)
                }
                ,
                F.selector = a.$ || a.jQuery || function(b) {
                    var c = a.$ || a.jQuery;
                    return c ? (F.selector = c,
                        c(b)) : "undefined" == typeof document ? b : document.querySelectorAll ? document.querySelectorAll(b) : document.getElementById("#" === b.charAt(0) ? b.substr(1) : b)
                }
            ;
            var I = []
                , J = {}
                , K = F._internals = {
                    isArray: n,
                    isSelector: G,
                    lazyTweens: I
                }
                , L = F._plugins = {}
                , M = K.tweenLookup = {}
                , N = 0
                , O = K.reservedProps = {
                    ease: 1,
                    delay: 1,
                    overwrite: 1,
                    onComplete: 1,
                    onCompleteParams: 1,
                    onCompleteScope: 1,
                    useFrames: 1,
                    runBackwards: 1,
                    startAt: 1,
                    onUpdate: 1,
                    onUpdateParams: 1,
                    onUpdateScope: 1,
                    onStart: 1,
                    onStartParams: 1,
                    onStartScope: 1,
                    onReverseComplete: 1,
                    onReverseCompleteParams: 1,
                    onReverseCompleteScope: 1,
                    onRepeat: 1,
                    onRepeatParams: 1,
                    onRepeatScope: 1,
                    easeParams: 1,
                    yoyo: 1,
                    immediateRender: 1,
                    repeat: 1,
                    repeatDelay: 1,
                    data: 1,
                    paused: 1,
                    reversed: 1,
                    autoCSS: 1,
                    lazy: 1,
                    onOverwrite: 1
                }
                , P = {
                    none: 0,
                    all: 1,
                    auto: 2,
                    concurrent: 3,
                    allOnStart: 4,
                    preexisting: 5,
                    "true": 1,
                    "false": 0
                }
                , Q = C._rootFramesTimeline = new E
                , R = C._rootTimeline = new E
                , S = K.lazyRender = function() {
                    var a, b = I.length;
                    for (J = {}; --b > -1; )
                        a = I[b],
                        a && a._lazy !== !1 && (a.render(a._lazy[0], a._lazy[1], !0),
                            a._lazy = !1);
                    I.length = 0
                }
            ;
            R._startTime = g.time,
                Q._startTime = g.frame,
                R._active = Q._active = !0,
                setTimeout(S, 1),
                C._updateRoot = F.render = function() {
                    var a, b, c;
                    if (I.length && S(),
                        R.render((g.time - R._startTime) * R._timeScale, !1, !1),
                        Q.render((g.frame - Q._startTime) * Q._timeScale, !1, !1),
                    I.length && S(),
                        !(g.frame % 120)) {
                        for (c in M) {
                            for (b = M[c].tweens,
                                     a = b.length; --a > -1; )
                                b[a]._gc && b.splice(a, 1);
                            0 === b.length && delete M[c]
                        }
                        if (c = R._first,
                        (!c || c._paused) && F.autoSleep && !Q._first && 1 === g._listeners.tick.length) {
                            for (; c && c._paused; )
                                c = c._next;
                            c || g.sleep()
                        }
                    }
                }
                ,
                g.addEventListener("tick", C._updateRoot);
            var T = function(a, b, c) {
                var d, e, f = a._gsTweenID;
                if (M[f || (a._gsTweenID = f = "t" + N++)] || (M[f] = {
                    target: a,
                    tweens: []
                }),
                b && (d = M[f].tweens,
                    d[e = d.length] = b,
                    c))
                    for (; --e > -1; )
                        d[e] === b && d.splice(e, 1);
                return M[f].tweens
            }
                , U = function(a, b, c, d) {
                var e, f, g = a.vars.onOverwrite;
                return g && (e = g(a, b, c, d)),
                    g = F.onOverwrite,
                g && (f = g(a, b, c, d)),
                e !== !1 && f !== !1
            }
                , V = function(a, b, c, d, e) {
                var f, g, h, i;
                if (1 === d || d >= 4) {
                    for (i = e.length,
                             f = 0; i > f; f++)
                        if ((h = e[f]) !== b)
                            h._gc || U(h, b) && h._enabled(!1, !1) && (g = !0);
                        else if (5 === d)
                            break;
                    return g
                }
                var j, l = b._startTime + k, m = [], n = 0, o = 0 === b._duration;
                for (f = e.length; --f > -1; )
                    (h = e[f]) === b || h._gc || h._paused || (h._timeline !== b._timeline ? (j = j || W(b, 0, o),
                    0 === W(h, j, o) && (m[n++] = h)) : h._startTime <= l && h._startTime + h.totalDuration() / h._timeScale > l && ((o || !h._initted) && l - h._startTime <= 2e-10 || (m[n++] = h)));
                for (f = n; --f > -1; )
                    if (h = m[f],
                    2 === d && h._kill(c, a, b) && (g = !0),
                    2 !== d || !h._firstPT && h._initted) {
                        if (2 !== d && !U(h, b))
                            continue;
                        h._enabled(!1, !1) && (g = !0)
                    }
                return g
            }
                , W = function(a, b, c) {
                for (var d = a._timeline, e = d._timeScale, f = a._startTime; d._timeline; ) {
                    if (f += d._startTime,
                        e *= d._timeScale,
                        d._paused)
                        return -100;
                    d = d._timeline
                }
                return f /= e,
                    f > b ? f - b : c && f === b || !a._initted && 2 * k > f - b ? k : (f += a.totalDuration() / a._timeScale / e) > b + k ? 0 : f - b - k
            };
            f._init = function() {
                var a, b, c, d, e, f = this.vars, g = this._overwrittenProps, h = this._duration, i = !!f.immediateRender, j = f.ease;
                if (f.startAt) {
                    this._startAt && (this._startAt.render(-1, !0),
                        this._startAt.kill()),
                        e = {};
                    for (d in f.startAt)
                        e[d] = f.startAt[d];
                    if (e.overwrite = !1,
                        e.immediateRender = !0,
                        e.lazy = i && f.lazy !== !1,
                        e.startAt = e.delay = null,
                        this._startAt = F.to(this.target, 0, e),
                        i)
                        if (this._time > 0)
                            this._startAt = null;
                        else if (0 !== h)
                            return
                } else if (f.runBackwards && 0 !== h)
                    if (this._startAt)
                        this._startAt.render(-1, !0),
                            this._startAt.kill(),
                            this._startAt = null;
                    else {
                        0 !== this._time && (i = !1),
                            c = {};
                        for (d in f)
                            O[d] && "autoCSS" !== d || (c[d] = f[d]);
                        if (c.overwrite = 0,
                            c.data = "isFromStart",
                            c.lazy = i && f.lazy !== !1,
                            c.immediateRender = i,
                            this._startAt = F.to(this.target, 0, c),
                            i) {
                            if (0 === this._time)
                                return
                        } else
                            this._startAt._init(),
                                this._startAt._enabled(!1),
                            this.vars.immediateRender && (this._startAt = null)
                    }
                if (this._ease = j = j ? j instanceof u ? j : "function" == typeof j ? new u(j,f.easeParams) : v[j] || F.defaultEase : F.defaultEase,
                f.easeParams instanceof Array && j.config && (this._ease = j.config.apply(j, f.easeParams)),
                    this._easeType = this._ease._type,
                    this._easePower = this._ease._power,
                    this._firstPT = null,
                    this._targets)
                    for (a = this._targets.length; --a > -1; )
                        this._initProps(this._targets[a], this._propLookup[a] = {}, this._siblings[a], g ? g[a] : null) && (b = !0);
                else
                    b = this._initProps(this.target, this._propLookup, this._siblings, g);
                if (b && F._onPluginEvent("_onInitAllProps", this),
                g && (this._firstPT || "function" != typeof this.target && this._enabled(!1, !1)),
                    f.runBackwards)
                    for (c = this._firstPT; c; )
                        c.s += c.c,
                            c.c = -c.c,
                            c = c._next;
                this._onUpdate = f.onUpdate,
                    this._initted = !0
            }
                ,
                f._initProps = function(b, c, d, e) {
                    var f, g, h, i, j, k;
                    if (null == b)
                        return !1;
                    J[b._gsTweenID] && S(),
                    this.vars.css || b.style && b !== a && b.nodeType && L.css && this.vars.autoCSS !== !1 && H(this.vars, b);
                    for (f in this.vars) {
                        if (k = this.vars[f],
                            O[f])
                            k && (k instanceof Array || k.push && n(k)) && -1 !== k.join("").indexOf("{self}") && (this.vars[f] = k = this._swapSelfInParams(k, this));
                        else if (L[f] && (i = new L[f])._onInitTween(b, this.vars[f], this)) {
                            for (this._firstPT = j = {
                                _next: this._firstPT,
                                t: i,
                                p: "setRatio",
                                s: 0,
                                c: 1,
                                f: !0,
                                n: f,
                                pg: !0,
                                pr: i._priority
                            },
                                     g = i._overwriteProps.length; --g > -1; )
                                c[i._overwriteProps[g]] = this._firstPT;
                            (i._priority || i._onInitAllProps) && (h = !0),
                            (i._onDisable || i._onEnable) && (this._notifyPluginsOfEnabled = !0)
                        } else
                            this._firstPT = c[f] = j = {
                                _next: this._firstPT,
                                t: b,
                                p: f,
                                f: "function" == typeof b[f],
                                n: f,
                                pg: !1,
                                pr: 0
                            },
                                j.s = j.f ? b[f.indexOf("set") || "function" != typeof b["get" + f.substr(3)] ? f : "get" + f.substr(3)]() : parseFloat(b[f]),
                                j.c = "string" == typeof k && "=" === k.charAt(1) ? parseInt(k.charAt(0) + "1", 10) * Number(k.substr(2)) : Number(k) - j.s || 0;
                        j && j._next && (j._next._prev = j)
                    }
                    return e && this._kill(e, b) ? this._initProps(b, c, d, e) : this._overwrite > 1 && this._firstPT && d.length > 1 && V(b, this, c, this._overwrite, d) ? (this._kill(c, b),
                        this._initProps(b, c, d, e)) : (this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration) && (J[b._gsTweenID] = !0),
                        h)
                }
                ,
                f.render = function(a, b, c) {
                    var d, e, f, g, h = this._time, i = this._duration, j = this._rawPrevTime;
                    if (a >= i)
                        this._totalTime = this._time = i,
                            this.ratio = this._ease._calcEnd ? this._ease.getRatio(1) : 1,
                        this._reversed || (d = !0,
                            e = "onComplete"),
                        0 === i && (this._initted || !this.vars.lazy || c) && (this._startTime === this._timeline._duration && (a = 0),
                        (0 === a || 0 > j || j === k) && j !== a && (c = !0,
                        j > k && (e = "onReverseComplete")),
                            this._rawPrevTime = g = !b || a || j === a ? a : k);
                    else if (1e-7 > a)
                        this._totalTime = this._time = 0,
                            this.ratio = this._ease._calcEnd ? this._ease.getRatio(0) : 0,
                        (0 !== h || 0 === i && j > 0 && j !== k) && (e = "onReverseComplete",
                            d = this._reversed),
                        0 > a && (this._active = !1,
                        0 === i && (this._initted || !this.vars.lazy || c) && (j >= 0 && (c = !0),
                            this._rawPrevTime = g = !b || a || j === a ? a : k)),
                        this._initted || (c = !0);
                    else if (this._totalTime = this._time = a,
                        this._easeType) {
                        var l = a / i
                            , m = this._easeType
                            , n = this._easePower;
                        (1 === m || 3 === m && l >= .5) && (l = 1 - l),
                        3 === m && (l *= 2),
                            1 === n ? l *= l : 2 === n ? l *= l * l : 3 === n ? l *= l * l * l : 4 === n && (l *= l * l * l * l),
                            this.ratio = 1 === m ? 1 - l : 2 === m ? l : .5 > a / i ? l / 2 : 1 - l / 2
                    } else
                        this.ratio = this._ease.getRatio(a / i);
                    if (this._time !== h || c) {
                        if (!this._initted) {
                            if (this._init(),
                            !this._initted || this._gc)
                                return;
                            if (!c && this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration))
                                return this._time = this._totalTime = h,
                                    this._rawPrevTime = j,
                                    I.push(this),
                                    void (this._lazy = [a, b]);
                            this._time && !d ? this.ratio = this._ease.getRatio(this._time / i) : d && this._ease._calcEnd && (this.ratio = this._ease.getRatio(0 === this._time ? 0 : 1))
                        }
                        for (this._lazy !== !1 && (this._lazy = !1),
                             this._active || !this._paused && this._time !== h && a >= 0 && (this._active = !0),
                             0 === h && (this._startAt && (a >= 0 ? this._startAt.render(a, b, c) : e || (e = "_dummyGS")),
                             this.vars.onStart && (0 !== this._time || 0 === i) && (b || this.vars.onStart.apply(this.vars.onStartScope || this, this.vars.onStartParams || t))),
                                 f = this._firstPT; f; )
                            f.f ? f.t[f.p](f.c * this.ratio + f.s) : f.t[f.p] = f.c * this.ratio + f.s,
                                f = f._next;
                        this._onUpdate && (0 > a && this._startAt && a !== -1e-4 && this._startAt.render(a, b, c),
                        b || (this._time !== h || d) && this._onUpdate.apply(this.vars.onUpdateScope || this, this.vars.onUpdateParams || t)),
                        e && (!this._gc || c) && (0 > a && this._startAt && !this._onUpdate && a !== -1e-4 && this._startAt.render(a, b, c),
                        d && (this._timeline.autoRemoveChildren && this._enabled(!1, !1),
                            this._active = !1),
                        !b && this.vars[e] && this.vars[e].apply(this.vars[e + "Scope"] || this, this.vars[e + "Params"] || t),
                        0 === i && this._rawPrevTime === k && g !== k && (this._rawPrevTime = 0))
                    }
                }
                ,
                f._kill = function(a, b, c) {
                    if ("all" === a && (a = null),
                    null == a && (null == b || b === this.target))
                        return this._lazy = !1,
                            this._enabled(!1, !1);
                    b = "string" != typeof b ? b || this._targets || this.target : F.selector(b) || b;
                    var d, e, f, g, h, i, j, k, l;
                    if ((n(b) || G(b)) && "number" != typeof b[0])
                        for (d = b.length; --d > -1; )
                            this._kill(a, b[d]) && (i = !0);
                    else {
                        if (this._targets) {
                            for (d = this._targets.length; --d > -1; )
                                if (b === this._targets[d]) {
                                    h = this._propLookup[d] || {},
                                        this._overwrittenProps = this._overwrittenProps || [],
                                        e = this._overwrittenProps[d] = a ? this._overwrittenProps[d] || {} : "all";
                                    break
                                }
                        } else {
                            if (b !== this.target)
                                return !1;
                            h = this._propLookup,
                                e = this._overwrittenProps = a ? this._overwrittenProps || {} : "all"
                        }
                        if (h) {
                            if (j = a || h,
                                k = a !== e && "all" !== e && a !== h && ("object" != typeof a || !a._tempKill),
                            c && (F.onOverwrite || this.vars.onOverwrite)) {
                                for (f in j)
                                    h[f] && (l || (l = []),
                                        l.push(f));
                                if (!U(this, c, b, l))
                                    return !1
                            }
                            for (f in j)
                                (g = h[f]) && (g.pg && g.t._kill(j) && (i = !0),
                                g.pg && 0 !== g.t._overwriteProps.length || (g._prev ? g._prev._next = g._next : g === this._firstPT && (this._firstPT = g._next),
                                g._next && (g._next._prev = g._prev),
                                    g._next = g._prev = null),
                                    delete h[f]),
                                k && (e[f] = 1);
                            !this._firstPT && this._initted && this._enabled(!1, !1)
                        }
                    }
                    return i
                }
                ,
                f.invalidate = function() {
                    return this._notifyPluginsOfEnabled && F._onPluginEvent("_onDisable", this),
                        this._firstPT = this._overwrittenProps = this._startAt = this._onUpdate = null,
                        this._notifyPluginsOfEnabled = this._active = this._lazy = !1,
                        this._propLookup = this._targets ? {} : [],
                        C.prototype.invalidate.call(this),
                    this.vars.immediateRender && (this._time = -k,
                        this.render(-this._delay)),
                        this
                }
                ,
                f._enabled = function(a, b) {
                    if (h || g.wake(),
                    a && this._gc) {
                        var c, d = this._targets;
                        if (d)
                            for (c = d.length; --c > -1; )
                                this._siblings[c] = T(d[c], this, !0);
                        else
                            this._siblings = T(this.target, this, !0)
                    }
                    return C.prototype._enabled.call(this, a, b),
                        this._notifyPluginsOfEnabled && this._firstPT ? F._onPluginEvent(a ? "_onEnable" : "_onDisable", this) : !1
                }
                ,
                F.to = function(a, b, c) {
                    return new F(a,b,c)
                }
                ,
                F.from = function(a, b, c) {
                    return c.runBackwards = !0,
                        c.immediateRender = 0 != c.immediateRender,
                        new F(a,b,c)
                }
                ,
                F.fromTo = function(a, b, c, d) {
                    return d.startAt = c,
                        d.immediateRender = 0 != d.immediateRender && 0 != c.immediateRender,
                        new F(a,b,d)
                }
                ,
                F.delayedCall = function(a, b, c, d, e) {
                    return new F(b,0,{
                        delay: a,
                        onComplete: b,
                        onCompleteParams: c,
                        onCompleteScope: d,
                        onReverseComplete: b,
                        onReverseCompleteParams: c,
                        onReverseCompleteScope: d,
                        immediateRender: !1,
                        useFrames: e,
                        overwrite: 0
                    })
                }
                ,
                F.set = function(a, b) {
                    return new F(a,0,b)
                }
                ,
                F.getTweensOf = function(a, b) {
                    if (null == a)
                        return [];
                    a = "string" != typeof a ? a : F.selector(a) || a;
                    var c, d, e, f;
                    if ((n(a) || G(a)) && "number" != typeof a[0]) {
                        for (c = a.length,
                                 d = []; --c > -1; )
                            d = d.concat(F.getTweensOf(a[c], b));
                        for (c = d.length; --c > -1; )
                            for (f = d[c],
                                     e = c; --e > -1; )
                                f === d[e] && d.splice(c, 1)
                    } else
                        for (d = T(a).concat(),
                                 c = d.length; --c > -1; )
                            (d[c]._gc || b && !d[c].isActive()) && d.splice(c, 1);
                    return d
                }
                ,
                F.killTweensOf = F.killDelayedCallsTo = function(a, b, c) {
                    "object" == typeof b && (c = b,
                        b = !1);
                    for (var d = F.getTweensOf(a, b), e = d.length; --e > -1; )
                        d[e]._kill(c, a)
                }
            ;
            var X = r("plugins.TweenPlugin", function(a, b) {
                this._overwriteProps = (a || "").split(","),
                    this._propName = this._overwriteProps[0],
                    this._priority = b || 0,
                    this._super = X.prototype
            }, !0);
            if (f = X.prototype,
                X.version = "1.10.1",
                X.API = 2,
                f._firstPT = null,
                f._addTween = function(a, b, c, d, e, f) {
                    var g, h;
                    return null != d && (g = "number" == typeof d || "=" !== d.charAt(1) ? Number(d) - c : parseInt(d.charAt(0) + "1", 10) * Number(d.substr(2))) ? (this._firstPT = h = {
                        _next: this._firstPT,
                        t: a,
                        p: b,
                        s: c,
                        c: g,
                        f: "function" == typeof a[b],
                        n: e || b,
                        r: f
                    },
                    h._next && (h._next._prev = h),
                        h) : void 0
                }
                ,
                f.setRatio = function(a) {
                    for (var b, c = this._firstPT, d = 1e-6; c; )
                        b = c.c * a + c.s,
                            c.r ? b = Math.round(b) : d > b && b > -d && (b = 0),
                            c.f ? c.t[c.p](b) : c.t[c.p] = b,
                            c = c._next
                }
                ,
                f._kill = function(a) {
                    var b, c = this._overwriteProps, d = this._firstPT;
                    if (null != a[this._propName])
                        this._overwriteProps = [];
                    else
                        for (b = c.length; --b > -1; )
                            null != a[c[b]] && c.splice(b, 1);
                    for (; d; )
                        null != a[d.n] && (d._next && (d._next._prev = d._prev),
                            d._prev ? (d._prev._next = d._next,
                                d._prev = null) : this._firstPT === d && (this._firstPT = d._next)),
                            d = d._next;
                    return !1
                }
                ,
                f._roundProps = function(a, b) {
                    for (var c = this._firstPT; c; )
                        (a[this._propName] || null != c.n && a[c.n.split(this._propName + "_").join("")]) && (c.r = b),
                            c = c._next
                }
                ,
                F._onPluginEvent = function(a, b) {
                    var c, d, e, f, g, h = b._firstPT;
                    if ("_onInitAllProps" === a) {
                        for (; h; ) {
                            for (g = h._next,
                                     d = e; d && d.pr > h.pr; )
                                d = d._next;
                            (h._prev = d ? d._prev : f) ? h._prev._next = h : e = h,
                                (h._next = d) ? d._prev = h : f = h,
                                h = g
                        }
                        h = b._firstPT = e
                    }
                    for (; h; )
                        h.pg && "function" == typeof h.t[a] && h.t[a]() && (c = !0),
                            h = h._next;
                    return c
                }
                ,
                X.activate = function(a) {
                    for (var b = a.length; --b > -1; )
                        a[b].API === X.API && (L[(new a[b])._propName] = a[b]);
                    return !0
                }
                ,
                q.plugin = function(a) {
                    if (!(a && a.propName && a.init && a.API))
                        throw "illegal plugin definition.";
                    var b, c = a.propName, d = a.priority || 0, e = a.overwriteProps, f = {
                        init: "_onInitTween",
                        set: "setRatio",
                        kill: "_kill",
                        round: "_roundProps",
                        initAll: "_onInitAllProps"
                    }, g = r("plugins." + c.charAt(0).toUpperCase() + c.substr(1) + "Plugin", function() {
                        X.call(this, c, d),
                            this._overwriteProps = e || []
                    }, a.global === !0), h = g.prototype = new X(c);
                    h.constructor = g,
                        g.API = a.API;
                    for (b in f)
                        "function" == typeof a[b] && (h[f[b]] = a[b]);
                    return g.version = a.version,
                        X.activate([g]),
                        g
                }
                ,
                d = a._gsQueue) {
                for (e = 0; e < d.length; e++)
                    d[e]();
                for (f in o)
                    o[f].func || a.console.log("GSAP encountered missing dependency: com.greensock." + f)
            }
            h = !1
        }
    }("undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window, "TweenLite");

var Breakpointer = function() {
    this.$measurer = null,
        this.currentBreakpoint = -1,
        this.initialize()
};
Breakpointer.prototype.initialize = function() {
    var a = this;
    this.$measurer = $("#breakpointer"),
    0 === this.$measurer.length && (this.$measurer = $('<div id="breakpointer" />'),
        this.$measurer.css("position", "relative"),
        $("body").append(this.$measurer)),
        Play.$window.resize($.debounce(100, function() {
            a.resize()
        })),
        this.resize()
}
    ,
    Breakpointer.prototype.resize = function() {
        var a = parseInt(this.$measurer.css("z-index"));
        if (a !== this.currentBreakpoint) {
            var b = {
                oldBreakpoint: this.currentBreakpoint,
                breakpoint: a
            };
            this.currentBreakpoint = a,
                PubSub.publish(Play.Event.BreakpointChanged, b)
        }
    }
    ,
    Breakpointer.prototype.getCurrent = function() {
        return this.currentBreakpoint
    }
;
var PageHeader = function() {
    this.$header = null,
        this.$menuBg = null,
        this.$buttons = null,
        this.currentMenuId = "",
        this.isFullMenu = !1,
        this.isLocked = !1,
        this.initialize()
};
PageHeader.prototype.initialize = function() {
    var a = this;
    this.isFullMenu = Play.breakpointer.getCurrent() >= Play.Config.BreakpointFullMenu,
        this.$header = $(".page-header"),
        this.$buttons = this.$header.find(".buttons"),
        this.$menuBg = this.$header.find(".menu-bg"),
        this.$menuBg.css("height", 0),
        this.$header.on("click", ".menu-button", function(b) {
            if (b.preventDefault(),
                !a.isLocked) {
                var c = $(this).attr("href");
                a.currentMenuId === c ? a.hideMenu(c) : a.showMenu(c)
            }
        }),
        this.$header.on("click", ".continue-shopping-link", function(b) {
            b.preventDefault(),
            "" !== a.currentMenuId && a.hideMenu(a.currentMenuId)
        }),
        PubSub.subscribe(Play.Event.WindowResize, Play.delegate(a, a.resize)),
        PubSub.subscribe(Play.Event.BreakpointChanged, Play.delegate(a, a.breakpointChanged)),
        PubSub.subscribe(Play.Event.CloseMenu, Play.delegate(a, a.closeMenu))
}
    ,
    PageHeader.prototype.resize = function() {
        var a, b = this;
        this.isFullMenu ? "" !== this.currentMenuId && (a = this.$header.find(b.currentMenuId),
            a.css({
                height: $(window).height() - 80
            }),
            this.$menuBg.css("height", $(window).height())) : "" !== this.currentMenuId && (a = this.$header.find(b.currentMenuId),
            a.css({
                height: $(document).height() - 130
            }),
            this.$menuBg.css("height", a.height()))
    }
    ,
    PageHeader.prototype.windowScroll = function() {
        var a = this;
        "" !== this.currentMenuId && a.hideMenu(this.currentMenuId)
    }
    ,
    PageHeader.prototype.breakpointChanged = function(a, b) {
        b.oldBreakpoint < Play.Config.BreakpointFullMenu && b.breakpoint >= Play.Config.BreakpointFullMenu && (this.isFullMenu = !0,
            this.resize()),
        b.oldBreakpoint >= Play.Config.BreakpointFullMenu && b.breakpoint < Play.Config.BreakpointFullMenu && (this.isFullMenu = !1,
            this.resize())
    }
    ,
    PageHeader.prototype.closeMenu = function() {
        var a = this;
        "" !== a.currentMenuId && a.hideMenu(a.currentMenuId)
    }
    ,
    PageHeader.prototype.showMenu = function(a) {
        var b = this
            , c = this.$header.find(a);
        if (this.$menuBg.find(".bg-inner").css({
            background: c.css("background")
        }),
        "" !== b.currentMenuId) {
            var d = this.$header.find(b.currentMenuId);
            TweenLite.to(d, .1, {
                opacity: 0,
                onComplete: function() {
                    d.css({
                        height: 0
                    })
                }
            }),
                this.isFullMenu ? (c.css({
                    opacity: 0,
                    marginTop: -30,
                    height: $(window).height() - 80
                }),
                    TweenLite.to(c, .6, {
                        delay: .4,
                        marginTop: 0,
                        ease: Expo.easeOut
                    }),
                    TweenLite.to(c, .6, {
                        delay: .4,
                        opacity: 1,
                        ease: Sine.easeOut
                    })) : (c.css({
                    opacity: 0,
                    height: $(document).height() - 130
                }),
                    TweenLite.to(c, .6, {
                        delay: .3,
                        opacity: 1,
                        ease: Sine.easeOut
                    }),
                    TweenLite.to(this.$menuBg, .3, {
                        height: c.outerHeight(),
                        ease: Quint.easeOut
                    })),
                this.showButtonState(b.currentMenuId, "closed"),
                this.showButtonState(a, "open"),
                this.setLock(1e3)
        } else
            this.isFullMenu ? (c.css({
                opacity: 0,
                marginTop: -30,
                height: $(window).height() - 80
            }),
                TweenLite.to(this.$menuBg, .6, {
                    height: c.outerHeight(),
                    ease: Quint.easeOut
                })) : (c.css({
                opacity: 0,
                height: $(document).height() - 130
            }),
                TweenLite.to(this.$menuBg, .6, {
                    height: c.outerHeight(),
                    ease: Quint.easeOut
                })),
                TweenLite.killTweensOf(c),
                TweenLite.to(c, .8, {
                    delay: .2,
                    marginTop: 0,
                    ease: Expo.easeOut
                }),
                TweenLite.to(c, .8, {
                    delay: .2,
                    opacity: 1,
                    ease: Sine.easeOut
                }),
                this.showButtonState(a, "open"),
                this.setLock(1e3);
        b.currentMenuId = a
    }
    ,
    PageHeader.prototype.hideMenu = function(a) {
        var b = this
            , c = this.$header.find(a);
        TweenLite.to(c, .1, {
            opacity: 0,
            ease: Sine.easeOut,
            onComplete: function() {
                c.css({
                    height: 0
                })
            }
        }),
            TweenLite.to(this.$menuBg, .5, {
                height: 0,
                ease: Quint.easeOut
            }),
            this.showButtonState(a, "closed"),
            b.currentMenuId = "",
            this.setLock(500)
    }
    ,
    PageHeader.prototype.showButtonState = function(a, b) {
        var c = this.$buttons.find('a[href="' + a + '"]')
            , d = c.find(".open-state")
            , e = c.find(".closed-state");
        "open" === b ? (TweenLite.to(d, .6, {
            delay: .3,
            opacity: 1,
            top: 0,
            ease: Expo.easeOut
        }),
            TweenLite.to(e, .2, {
                opacity: 0,
                top: 20,
                ease: Sine.easeIn
            })) : (TweenLite.to(d, .2, {
            opacity: 0,
            top: -20,
            ease: Sine.easeIn
        }),
            TweenLite.to(e, .6, {
                delay: .2,
                opacity: 1,
                top: 0,
                ease: Expo.easeOut
            }))
    }
    ,
    PageHeader.prototype.setLock = function(a) {
        var b = this;
        b.isLocked = !0,
            setTimeout(function() {
                b.isLocked = !1
            }, a)
    }
;
var CollectionsMenu = function(a) {
    this.$element = a,
        this.$inner = null,
        this.$buttons = null,
        this.canScrollAndFixed = $("html").hasClass("can-fixed") && $("html").hasClass("can-scroll"),
        this.pageHeaderSize = 80,
        this.elemOffsetTop = 0,
        this.isSticky = !1,
        this.currentMenuId = "",
        this.initialize()
};
CollectionsMenu.prototype.initialize = function() {
    var a = this;
    this.$inner = this.$element.find(".collections-nav-inner"),
        this.$buttons = this.$element.find(".buttons"),
        this.elemOffsetTop = this.$element.offset().top,
        this.$element.find(".menu-panel").css({
            height: 0
        }),
        this.$element.on("click", ".menu-button", function(b) {
            b.preventDefault();
            var c = $(this).attr("href");
            a.currentMenuId === c ? a.hideMenu(c) : a.showMenu(c)
        }),
        this.displaySelectedCollection(),
        PubSub.subscribe(Play.Event.WindowResize, Play.delegate(a, a.resize)),
        PubSub.subscribe(Play.Event.WindowScroll, Play.delegate(a, a.windowScroll)),
        PubSub.subscribe(Play.Event.WindowLoaded, Play.delegate(a, a.windowLoaded)),
        PubSub.subscribe(Play.Event.BreakpointChanged, Play.delegate(a, a.breakpointChanged))
}
    ,
    CollectionsMenu.prototype.resize = function() {
        this.elemOffsetTop = this.$element.offset().top
    }
    ,
    CollectionsMenu.prototype.windowScroll = function(a, b) {
        Play.breakpointer.getCurrent() >= Play.Config.BreakpointFixedCollectionsMenu && this.canScrollAndFixed && (!this.isSticky && b.scrollTop >= this.elemOffsetTop - this.pageHeaderSize ? (this.$inner.css({
            position: "fixed",
            top: this.pageHeaderSize
        }),
            this.isSticky = !0) : this.isSticky && b.scrollTop < this.elemOffsetTop - this.pageHeaderSize && (this.$inner.css({
            position: "",
            top: ""
        }),
            this.isSticky = !1))
    }
    ,
    CollectionsMenu.prototype.windowLoaded = function() {
        var a = this;
        this.elemOffsetTop = this.$element.offset().top,
            setTimeout(function() {
                a.elemOffsetTop = a.$element.offset().top
            }, 1e3)
    }
    ,
    CollectionsMenu.prototype.breakpointChanged = function(a, b) {
        var c = this;
        this.canScrollAndFixed && (b.oldBreakpoint < Play.Config.BreakpointFixedCollectionsMenu && b.breakpoint >= Play.Config.BreakpointFixedCollectionsMenu && (this.isFullMenu = !0,
        "" !== c.currentMenuId && c.hideMenu(c.currentMenuId),
            this.resize(),
            $(window).trigger("scroll")),
        b.oldBreakpoint >= Play.Config.BreakpointFixedCollectionsMenu && b.breakpoint < Play.Config.BreakpointFixedCollectionsMenu && (this.isFullMenu = !1,
            this.$inner.css({
                position: "",
                top: ""
            }),
            this.isSticky = !1,
        "" !== c.currentMenuId && c.hideMenu(c.currentMenuId),
            this.resize()))
    }
    ,
    CollectionsMenu.prototype.showMenu = function(a) {
        var b = this
            , c = $(window).scrollTop()
            , d = 0;
        Play.breakpointer.getCurrent() >= Play.Config.BreakpointFixedCollectionsMenu ? c < this.elemOffsetTop - this.pageHeaderSize && (TweenLite.to(window, .6, {
            scrollTo: {
                y: this.elemOffsetTop - this.pageHeaderSize
            },
            ease: Quint.easeOut
        }),
            d = .2) : c < this.elemOffsetTop && (TweenLite.to(window, .6, {
            scrollTo: {
                y: this.elemOffsetTop
            },
            ease: Quint.easeOut
        }),
            d = .2);
        var e = this.$element.find(a)
            , f = e.find(".inner")
            , g = 0;
        Play.breakpointer.getCurrent() >= Play.Config.BreakpointFixedCollectionsMenu ? g = $(window).height() - (this.pageHeaderSize + this.$element.outerHeight()) : (e.css({
            height: "auto"
        }),
            g = e.outerHeight(),
            e.css({
                height: 0
            })),
            "" !== b.currentMenuId ? (this.hideMenu(b.currentMenuId),
                d += .2,
                this.showButtonState(b.currentMenuId, "closed"),
                this.showButtonState(a, "open")) : this.showButtonState(a, "open"),
            f.css({
                opacity: 0,
                marginTop: -25
            }),
            TweenLite.to(e, .6, {
                delay: d,
                height: g,
                ease: Quint.easeOut
            }),
            TweenLite.to(f, .8, {
                delay: d + .2,
                marginTop: 0,
                ease: Expo.easeOut
            }),
            TweenLite.to(f, .8, {
                delay: d + .2,
                opacity: 1,
                ease: Sine.easeOut
            }),
            b.currentMenuId = a
    }
    ,
    CollectionsMenu.prototype.hideMenu = function(a) {
        var b = this
            , c = this.$element.find(a)
            , d = c.find(".inner");
        TweenLite.to(d, .1, {
            opacity: 0,
            ease: Sine.easeOut
        }),
            TweenLite.to(c, .5, {
                height: 0,
                ease: Quint.easeOut
            }),
            this.showButtonState(a, "closed"),
            b.currentMenuId = ""
    }
    ,
    CollectionsMenu.prototype.showButtonState = function(a, b) {
        var c = this.$buttons.find('a[href="' + a + '"]')
            , d = c.find(".open-state")
            , e = c.find(".closed-state");
        "open" === b ? (TweenLite.to(d, .6, {
            delay: .3,
            opacity: 1,
            top: 0,
            ease: Expo.easeOut
        }),
            TweenLite.to(e, .2, {
                opacity: 0,
                top: 20,
                ease: Sine.easeIn
            })) : (TweenLite.to(d, .2, {
            opacity: 0,
            top: -20,
            ease: Sine.easeIn
        }),
            TweenLite.to(e, .6, {
                delay: .2,
                opacity: 1,
                top: 0,
                ease: Expo.easeOut
            }))
    }
    ,
    CollectionsMenu.prototype.displaySelectedCollection = function() {
        var a = this;
        this.$buttons.find(".menu-button").each(function() {
            var b = $(this)
                , c = a.$element.find(b.attr("href"));
            c.length > 0 && c.find(".menu-item.current").length > 0 && (b.find(".unselected-text").hide(),
                b.find(".selected-text").text(c.find(".menu-item.current").text()).show())
        })
    }
;

var QuantitySelector = function(a) {
    this.$selector = a,
        this.$input = null,
        this.$decreaseButton = null,
        this.minValue = 0,
        this.initialize()
};
QuantitySelector.prototype.initialize = function() {
    var a = this;
    this.$input = this.$selector.find("input.cart-quantity-input"),
        this.$decreaseButton = this.$selector.find(".cart-adjust-btn.minus"),
        this.minValue = parseInt(this.$input.attr("min")),
        this.$selector.on("click", ".cart-adjust-btn", function(b) {
            b.preventDefault();
            var c = $(this);
            c.hasClass("plus") ? a.increase() : c.hasClass("minus") && a.decrease()
        })
}
    ,
    QuantitySelector.prototype.increase = function() {
        var a = parseInt(this.$input.val());
        this.$input.val(a += 1),
            this.$decreaseButton.removeClass("deactivated"),
            this.$input.trigger("change")
    }
    ,
    QuantitySelector.prototype.decrease = function() {
        var a = parseInt(this.$input.val());
        a > this.minValue && (this.$input.val(a -= 1),
            this.checkButtonAvailability()),
            this.$input.trigger("change")
    }
    ,
    QuantitySelector.prototype.checkButtonAvailability = function() {
        parseInt(this.$input.val()) <= this.minValue && this.$decreaseButton.addClass("deactivated")
    }
;

var PlayApp = function() {
    this.$document = $("body"),
        this.$window = $(window),
        this.breakpointer = null,
        this.pageHeader = null
};
if (PlayApp.prototype.initialize = function() {
    var a = this
        , b = $("body");
    this.check_scroll_capability(),
        picturefill(),
        a.initFocusHack(),
        this.breakpointer = new Breakpointer,
        this.pageHeader = new PageHeader,
    $(".collections-nav").length > 0 && $(".collections-nav").each(function() {
        new CollectionsMenu($(this))
    });

    var c;

        this.$window.on("load", function() {
            PubSub.publish(Play.Event.WindowLoaded, {})
        }),

        this.$window.on("resize orientationchange", $.throttle(20, function() {
            PubSub.publish(Play.Event.WindowResize, {
                width: $(window).width(),
                height: $(window).height()
            })
        })),

        this.$window.on("scroll", $.throttle(20, function() {
            PubSub.publish(Play.Event.WindowScroll, {
                scrollTop: $(window).scrollTop()
            })
        }))
}
    ,

    PlayApp.prototype.delegate = function(a, b) {
        return function() {
            return b.apply(a, arguments)
        }
    }
    ,
    PlayApp.prototype.init_page = function() {}
    ,
    PlayApp.prototype.ready_init = function() {}
    ,
    PlayApp.prototype.load_init = function() {}
    ,
    PlayApp.prototype.checkInlineTopImage = function() {
        var a = $(".default-article .text-wrapper .wysiwyg")
            , b = $(".default-article .full-width-image");
        if (a.length > 0 && b.length > 0) {
            var c = a.find("img").first();
            c.length > 0 && (b.append(c),
                b.show(),
                a.hide().show(0))
        }
    }
    ,
    PlayApp.prototype.scrollToTop = function() {
        TweenLite.to(window, 1, {
            scrollTo: {
                y: 0
            },
            ease: Quart.easeOut
        })
    }
    ,
    PlayApp.prototype.openShareWindow = function(a) {
        var b = screen.width / 2 - 300
            , c = screen.height / 2 - 300;
        window.open(a, "shareWindow", "height=600,width=600, top=" + c + ",left=" + b + ",toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no")
    }
    ,
    PlayApp.prototype.initFocusHack = function() {
        var a = $("html")
            , b = $("body");
        a.addClass("using-mouse"),
            b.on("keydown", function() {
                a.removeClass("using-mouse")
            }),
            b.on("mousedown", function() {
                a.addClass("using-mouse")
            })
    }
    ,
    PlayApp.prototype.check_scroll_capability = function() {
        var a = navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? !0 : !1;
        a ? this.can_scroll = this.can_fixed = !1 : $("html").addClass("can-scroll").addClass("can-fixed")
    }
    ,
    window.onerror = function() {
        var a = document.documentElement;
        a.className += " js-error"
    }
    ,
"undefined" == typeof console) {
    var console = {};
    console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {}
}
String.prototype.trim || !function() {
    var a = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    String.prototype.trim = function() {
        return this.replace(a, "")
    }
}(),
    jQuery.getMaxWindowTopPos = function(a) {
        var b = jQuery(window).height();
        a || (a = jQuery("body"));
        var c = a.outerHeight();
        return c - b
    }
;
var Play = new PlayApp;
Play.Event = {},
    Play.Event.BreakpointChanged = "BreakpointChanged",
    Play.Event.DomReady = "domReady",
    Play.Event.WindowLoaded = "windowLoaded",
    Play.Event.WindowResize = "windowResize",
    Play.Event.WindowScroll = "windowScroll",
    Play.Event.ContentUpdated = "contentUpdated",
    Play.Event.CloseMenu = "closeMenu",
    Play.Config = {},
    Play.Config.BreakpointFullMenu = "47",
    Play.Config.BreakpointFixedCollectionsMenu = "47";
