! function(e, t) {
    "function" == typeof define && define.amd ? define(["exports"], t) : t("object" == typeof exports && "string" != typeof exports.nodeName ? exports : e.commonJsStrict = {})
}(this, function(exports) {
    function e(e) {
        if (e in O) return e;
        for (var t = e[0].toUpperCase() + e.slice(1), n = N.length; n--;)
            if (e = N[n] + t, e in O) return e
    }

    function t(e, n) {
        e = e || {};
        for (var i in n) n[i] && n[i].constructor && n[i].constructor === Object ? (e[i] = e[i] || {}, t(e[i], n[i])) : e[i] = n[i];
        return e
    }

    function n(e, t, n) {
        var i;
        return function() {
            var o = this,
                r = arguments,
                a = function() {
                    i = null, n || e.apply(o, r)
                },
                l = n && !i;
            clearTimeout(i), i = setTimeout(a, t), l && e.apply(o, r)
        }
    }

    function i(e) {
        if ("createEvent" in document) {
            var t = document.createEvent("HTMLEvents");
            t.initEvent("change", !1, !0), e.dispatchEvent(t)
        } else e.fireEvent("onchange")
    }

    function o(e, t, n) {
        if ("string" == typeof t) {
            var i = t;
            t = {}, t[i] = n
        }
        for (var o in t) e.style[o] = t[o]
    }

    function r(e, t) {
        e.classList ? e.classList.add(t) : e.className += " " + t
    }

    function a(e, t) {
        e.classList ? e.classList.remove(t) : e.className = e.className.replace(t, "")
    }

    function l(e) {
        return parseInt(e, 10)
    }

    function s(e, t) {
        var n = t || new Image;
        return n.style.opacity = 0, new Promise(function(t) {
            n.src === e ? t(n) : (n.removeAttribute("crossOrigin"), e.match(/^https?:\/\/|^\/\//) && n.setAttribute("crossOrigin", "anonymous"), n.onload = function() {
                setTimeout(function() {
                    t(n)
                }, 1)
            }, n.src = e)
        })
    }

    function u(e, t) {
        window.EXIF || t(0), EXIF.getData(e, function() {
            var e = EXIF.getTag(this, "Orientation");
            t(e)
        })
    }

    function c(e, t, n) {
        var i = t.width,
            o = t.height,
            r = e.getContext("2d");
        switch (e.width = t.width, e.height = t.height, r.save(), n) {
            case 2:
                r.translate(i, 0), r.scale(-1, 1);
                break;
            case 3:
                r.translate(i, o), r.rotate(180 * Math.PI / 180);
                break;
            case 4:
                r.translate(0, o), r.scale(1, -1);
                break;
            case 5:
                e.width = o, e.height = i, r.rotate(90 * Math.PI / 180), r.scale(1, -1);
                break;
            case 6:
                e.width = o, e.height = i, r.rotate(90 * Math.PI / 180), r.translate(0, -o);
                break;
            case 7:
                e.width = o, e.height = i, r.rotate(-90 * Math.PI / 180), r.translate(-i, o), r.scale(1, -1);
                break;
            case 8:
                e.width = o, e.height = i, r.translate(0, i), r.rotate(-90 * Math.PI / 180)
        }
        r.drawImage(t, 0, 0, i, o), r.restore()
    }

    function h() {
        var e, t, n, i, a, l, s = this,
            u = "croppie-container",
            c = s.options.viewport.type ? "cr-vp-" + s.options.viewport.type : null;
        s.options.useCanvas = s.options.enableOrientation || p.call(s), s.data = {}, s.elements = {}, e = s.elements.boundary = document.createElement("div"), n = s.elements.viewport = document.createElement("div"), t = s.elements.img = document.createElement("img"), i = s.elements.overlay = document.createElement("div"), s.options.useCanvas ? (s.elements.canvas = document.createElement("canvas"), s.elements.preview = s.elements.canvas) : s.elements.preview = s.elements.img, r(e, "cr-boundary"), a = s.options.boundary.width, l = s.options.boundary.height, o(e, {
            width: a + (isNaN(a) ? "" : "px"),
            height: l + (isNaN(l) ? "" : "px")
        }), r(n, "cr-viewport"), c && r(n, c), o(n, {
            width: s.options.viewport.width + "px",
            height: s.options.viewport.height + "px"
        }), n.setAttribute("tabindex", 0), r(s.elements.preview, "cr-image"), r(i, "cr-overlay"), s.element.appendChild(e), e.appendChild(s.elements.preview), e.appendChild(n), e.appendChild(i), r(s.element, u), s.options.customClass && r(s.element, s.options.customClass), w.call(this), s.options.enableZoom && d.call(s)
    }

    function p() {
        return this.options.enableExif && window.EXIF
    }

    function m(e) {
        if (this.options.enableZoom) {
            var t = this.elements.zoomer,
                n = F(e, 4);
            t.value = Math.max(t.min, Math.min(t.max, n))
        }
    }

    function d() {
        function e() {
            f.call(n, {
                value: parseFloat(o.value),
                origin: new D(n.elements.preview),
                viewportRect: n.elements.viewport.getBoundingClientRect(),
                transform: T.parse(n.elements.preview)
            })
        }

        function t(t) {
            var i, o;
            i = t.wheelDelta ? t.wheelDelta / 1200 : t.deltaY ? t.deltaY / 1060 : t.detail ? t.detail / -60 : 0, o = n._currentZoom + i * n._currentZoom, t.preventDefault(), m.call(n, o), e.call(n)
        }
        var n = this,
            i = n.elements.zoomerWrap = document.createElement("div"),
            o = n.elements.zoomer = document.createElement("input");
        r(i, "cr-slider-wrap"), r(o, "cr-slider"), o.type = "range", o.step = "0.0001", o.value = 1, o.style.display = n.options.showZoomer ? "" : "none", n.element.appendChild(i), i.appendChild(o), n._currentZoom = 1, n.elements.zoomer.addEventListener("input", e), n.elements.zoomer.addEventListener("change", e), n.options.mouseWheelZoom && (n.elements.boundary.addEventListener("mousewheel", t), n.elements.boundary.addEventListener("DOMMouseScroll", t))
    }

    function f(e) {
        function t() {
            var e = {};
            e[z] = i.toString(), e[S] = a.toString(), o(n.elements.preview, e)
        }
        var n = this,
            i = e ? e.transform : T.parse(n.elements.preview),
            r = e ? e.viewportRect : n.elements.viewport.getBoundingClientRect(),
            a = e ? e.origin : new D(n.elements.preview);
        if (n._currentZoom = e ? e.value : n._currentZoom, i.scale = n._currentZoom, t(), n.options.enforceBoundary) {
            var l = v.call(n, r),
                s = l.translate,
                u = l.origin;
            i.x >= s.maxX && (a.x = u.minX, i.x = s.maxX), i.x <= s.minX && (a.x = u.maxX, i.x = s.minX), i.y >= s.maxY && (a.y = u.minY, i.y = s.maxY), i.y <= s.minY && (a.y = u.maxY, i.y = s.minY)
        }
        t(), q.call(n), b.call(n)
    }

    function v(e) {
        var t = this,
            n = t._currentZoom,
            i = e.width,
            o = e.height,
            r = t.elements.boundary.clientWidth / 2,
            a = t.elements.boundary.clientHeight / 2,
            l = t.elements.preview.getBoundingClientRect(),
            s = l.width,
            u = l.height,
            c = i / 2,
            h = o / 2,
            p = -1 * (c / n - r),
            m = p - (s * (1 / n) - i * (1 / n)),
            d = -1 * (h / n - a),
            f = d - (u * (1 / n) - o * (1 / n)),
            v = 1 / n * c,
            g = s * (1 / n) - v,
            w = 1 / n * h,
            y = u * (1 / n) - w;
        return {
            translate: {
                maxX: p,
                minX: m,
                maxY: d,
                minY: f
            },
            origin: {
                maxX: g,
                minX: v,
                maxY: y,
                minY: w
            }
        }
    }

    function g() {
        var e = this,
            t = e._currentZoom,
            n = e.elements.preview.getBoundingClientRect(),
            i = e.elements.viewport.getBoundingClientRect(),
            r = T.parse(e.elements.preview.style[z]),
            a = new D(e.elements.preview),
            l = i.top - n.top + i.height / 2,
            s = i.left - n.left + i.width / 2,
            u = {},
            c = {};
        u.y = l / t, u.x = s / t, c.y = (u.y - a.y) * (1 - t), c.x = (u.x - a.x) * (1 - t), r.x -= c.x, r.y -= c.y;
        var h = {};
        h[S] = u.x + "px " + u.y + "px", h[z] = r.toString(), o(e.elements.preview, h)
    }

    function w() {
        function e(e, t) {
            var n = d.elements.preview.getBoundingClientRect(),
                i = p.y + t,
                o = p.x + e;
            d.options.enforceBoundary ? (h.top > n.top + t && h.bottom < n.bottom + t && (p.y = i), h.left > n.left + e && h.right < n.right + e && (p.x = o)) : (p.y = i, p.x = o)
        }

        function t(e) {
            function t(e) {
                switch (e) {
                    case i:
                        return [1, 0];
                    case o:
                        return [0, 1];
                    case r:
                        return [-1, 0];
                    case a:
                        return [0, -1]
                }
            }
            var i = 37,
                o = 38,
                r = 39,
                a = 40;
            if (!e.shiftKey || e.keyCode != o && e.keyCode != a) {
                if (e.keyCode >= 37 && e.keyCode <= 40) {
                    e.preventDefault();
                    var l = t(e.keyCode);
                    p = T.parse(d.elements.preview), document.body.style[P] = "none", h = d.elements.viewport.getBoundingClientRect(), n(l)
                }
            } else {
                var s = 0;
                s = e.keyCode == o ? parseFloat(d.elements.zoomer.value, 10) + parseFloat(d.elements.zoomer.step, 10) : parseFloat(d.elements.zoomer.value, 10) - parseFloat(d.elements.zoomer.step, 10), d.setZoom(s)
            }
        }

        function n(t) {
            var n = t[0],
                i = t[1],
                r = {};
            e(n, i), r[z] = p.toString(), o(d.elements.preview, r), y.call(d), document.body.style[P] = "", g.call(d), b.call(d), c = 0
        }

        function r(e) {
            if (e.preventDefault(), !f) {
                if (f = !0, s = e.pageX, u = e.pageY, e.touches) {
                    var t = e.touches[0];
                    s = t.pageX, u = t.pageY
                }
                p = T.parse(d.elements.preview), window.addEventListener("mousemove", a), window.addEventListener("touchmove", a), window.addEventListener("mouseup", l), window.addEventListener("touchend", l), document.body.style[P] = "none", h = d.elements.viewport.getBoundingClientRect()
            }
        }

        function a(t) {
            t.preventDefault();
            var n = t.pageX,
                r = t.pageY;
            if (t.touches) {
                var a = t.touches[0];
                n = a.pageX, r = a.pageY
            }
            var l = n - s,
                h = r - u,
                f = {};
            if ("touchmove" == t.type && t.touches.length > 1) {
                var v = t.touches[0],
                    g = t.touches[1],
                    w = Math.sqrt((v.pageX - g.pageX) * (v.pageX - g.pageX) + (v.pageY - g.pageY) * (v.pageY - g.pageY));
                c || (c = w / d._currentZoom);
                var b = w / c;
                return m.call(d, b), void i(d.elements.zoomer)
            }
            e(l, h), f[z] = p.toString(), o(d.elements.preview, f), y.call(d), u = r, s = n
        }

        function l() {
            f = !1, window.removeEventListener("mousemove", a), window.removeEventListener("touchmove", a), window.removeEventListener("mouseup", l), window.removeEventListener("touchend", l), document.body.style[P] = "", g.call(d), b.call(d), c = 0
        }
        var s, u, c, h, p, d = this,
            f = !1;
        d.elements.overlay.addEventListener("mousedown", r), d.elements.viewport.addEventListener("keydown", t), d.elements.overlay.addEventListener("touchstart", r)
    }

    function y() {
        var e = this,
            t = e.elements.boundary.getBoundingClientRect(),
            n = e.elements.preview.getBoundingClientRect();
        o(e.elements.overlay, {
            width: n.width + "px",
            height: n.height + "px",
            top: n.top - t.top + "px",
            left: n.left - t.left + "px"
        })
    }

    function b() {
        var e, t = this,
            n = t.get();
        if (x.call(t))
            if (t.options.update.call(t, n), t.$ && "undefined" == typeof Prototype) t.$(t.element).trigger("update", n);
            else {
                var e;
                window.CustomEvent ? e = new CustomEvent("update", {
                    detail: n
                }) : (e = document.createEvent("CustomEvent"), e.initCustomEvent("update", !0, !0, n)), t.element.dispatchEvent(e)
            }
    }

    function x() {
        return this.elements.preview.offsetHeight > 0 && this.elements.preview.offsetWidth > 0
    }

    function C() {
        var e, t, n, r, a, l = this,
            s = 0,
            u = 1.5,
            c = 1,
            h = {},
            p = l.elements.preview,
            d = l.elements.zoomer,
            f = new T(0, 0, c),
            v = new D,
            w = x.call(l);
        if (w && !l.data.bound) {
            if (l.data.bound = !0, h[z] = f.toString(), h[S] = v.toString(), h.opacity = 1, o(p, h), e = p.getBoundingClientRect(), t = l.elements.viewport.getBoundingClientRect(), n = l.elements.boundary.getBoundingClientRect(), l._originalImageWidth = e.width, l._originalImageHeight = e.height, l.options.enableZoom) {
                l.options.enforceBoundary && (r = t.width / e.width, a = t.height / e.height, s = Math.max(r, a)), s >= u && (u = s + 1), d.min = F(s, 4), d.max = F(u, 4);
                var b = Math.max(n.width / e.width, n.height / e.height);
                c = null !== l.data.boundZoom ? l.data.boundZoom : b, m.call(l, c), i(d)
            } else l._currentZoom = c;
            f.scale = l._currentZoom, h[z] = f.toString(), o(p, h), l.data.points.length ? E.call(l, l.data.points) : _.call(l), g.call(l), y.call(l)
        }
    }

    function E(e) {
        if (4 != e.length) throw "Croppie - Invalid number of points supplied: " + e;
        var t = this,
            n = e[2] - e[0],
            i = t.elements.viewport.getBoundingClientRect(),
            r = t.elements.boundary.getBoundingClientRect(),
            a = {
                left: i.left - r.left,
                top: i.top - r.top
            },
            l = i.width / n,
            s = e[1],
            u = e[0],
            c = -1 * e[1] + a.top,
            h = -1 * e[0] + a.left,
            p = {};
        p[S] = u + "px " + s + "px", p[z] = new T(h, c, l).toString(), o(t.elements.preview, p), m.call(t, l), t._currentZoom = l
    }

    function _() {
        var e = this,
            t = e.elements.preview.getBoundingClientRect(),
            n = e.elements.viewport.getBoundingClientRect(),
            i = e.elements.boundary.getBoundingClientRect(),
            r = n.left - i.left,
            a = n.top - i.top,
            l = r - (t.width - n.width) / 2,
            s = a - (t.height - n.height) / 2,
            u = new T(l, s, e._currentZoom);
        o(e.elements.preview, z, u.toString())
    }

    function B(e) {
        var t = this,
            n = t.elements.canvas,
            i = t.elements.img,
            o = n.getContext("2d"),
            r = p.call(t),
            e = t.options.enableOrientation && e;
        o.clearRect(0, 0, n.width, n.height), n.width = i.width, n.height = i.height, r ? u(i, function(t) {
            c(n, i, l(t, 10)), e && c(n, i, e)
        }) : e && c(n, i, e)
    }

    function R(e) {
        var t = this,
            n = e.points,
            i = l(n[0]),
            o = l(n[1]),
            r = l(n[2]),
            a = l(n[3]),
            s = r - i,
            u = a - o,
            c = e.circle,
            h = document.createElement("canvas"),
            p = h.getContext("2d"),
            m = s,
            d = u,
            f = 0,
            v = 0,
            g = m,
            w = d,
            y = e.outputWidth && e.outputHeight,
            b = 1;
        return y && (g = e.outputWidth, w = e.outputHeight, b = g / m), h.width = g, h.height = w, e.backgroundColor && (p.fillStyle = e.backgroundColor, p.fillRect(0, 0, m, d)), 0 > i && (f = Math.abs(i), i = 0), 0 > o && (v = Math.abs(o), o = 0), r > t._originalImageWidth && (s = t._originalImageWidth - i, m = s), a > t._originalImageHeight && (u = t._originalImageHeight - o, d = u), 1 !== b && (f *= b, v *= b, m *= b, d *= b), p.drawImage(this.elements.preview, i, o, s, u, f, v, m, d), c && (p.fillStyle = "#fff", p.globalCompositeOperation = "destination-in", p.beginPath(), p.arc(m / 2, d / 2, m / 2, 0, 2 * Math.PI, !0), p.closePath(), p.fill()), h
    }

    function I(e) {
        var t = e.points,
            n = document.createElement("div"),
            i = document.createElement("img"),
            a = t[2] - t[0],
            l = t[3] - t[1];
        return r(n, "croppie-result"), n.appendChild(i), o(i, {
            left: -1 * t[0] + "px",
            top: -1 * t[1] + "px"
        }), i.src = e.url, o(n, {
            width: a + "px",
            height: l + "px"
        }), n
    }

    function Z(e) {
        return R.call(this, e).toDataURL(e.format, e.quality)
    }

    function L(e) {
        var t = this;
        return new Promise(function(n) {
            R.call(t, e).toBlob(function(e) {
                n(e)
            }, e.format, e.quality)
        })
    }

    function M(e, t) {
        var n, i = this,
            o = [],
            r = null;
        if ("string" == typeof e) n = e, e = {};
        else if (Array.isArray(e)) o = e.slice();
        else {
            if ("undefined" == typeof e && i.data.url) return C.call(i), b.call(i), null;
            n = e.url, o = e.points || [], r = "undefined" == typeof e.zoom ? null : e.zoom
        }
        return i.data.bound = !1, i.data.url = n || i.data.url, i.data.boundZoom = r, s(n, i.elements.img).then(function(n) {
            if (o.length) i.options.relative && (o = [o[0] * n.naturalWidth / 100, o[1] * n.naturalHeight / 100, o[2] * n.naturalWidth / 100, o[3] * n.naturalHeight / 100]), i.data.points = o.map(function(e) {
                return parseFloat(e)
            });
            else {
                var r, a, l = n.naturalWidth,
                    s = n.naturalHeight,
                    u = i.elements.viewport.getBoundingClientRect(),
                    c = u.width / u.height;
                l / s > c ? (a = s, r = a * c) : (r = l, a = r / c);
                var h = (l - r) / 2,
                    p = (s - a) / 2,
                    m = h + r,
                    d = p + a;
                i.data.points = [h, p, m, d]
            }
            i.options.useCanvas && (i.elements.img.exifdata = null, B.call(i, e.orientation || 1)), C.call(i), b.call(i), t && t()
        })
    }

    function F(e, t) {
        return parseFloat(e).toFixed(t || 0)
    }

    function W() {
        var e = this,
            t = e.elements.preview.getBoundingClientRect(),
            n = e.elements.viewport.getBoundingClientRect(),
            i = n.left - t.left,
            o = n.top - t.top,
            r = (n.width - e.elements.viewport.offsetWidth) / 2,
            a = (n.height - e.elements.viewport.offsetHeight) / 2,
            l = i + e.elements.viewport.offsetWidth + r,
            s = o + e.elements.viewport.offsetHeight + a,
            u = e._currentZoom;
        (u === 1 / 0 || isNaN(u)) && (u = 1);
        var c = e.options.enforceBoundary ? 0 : Number.NEGATIVE_INFINITY;
        return i = Math.max(c, i / u), o = Math.max(c, o / u), l = Math.max(c, l / u), s = Math.max(c, s / u), {
            points: [F(i), F(o), F(l), F(s)],
            zoom: u
        }
    }

    function X(e) {
        var n, i = this,
            o = W.call(i),
            r = t(U, t({}, e)),
            a = "string" == typeof e ? e : r.type || "base64",
            l = r.size,
            s = r.format,
            u = r.quality,
            c = r.backgroundColor,
            h = "boolean" == typeof r.circle ? r.circle : "circle" === i.options.viewport.type,
            p = i.elements.viewport.getBoundingClientRect(),
            m = p.width / p.height;
        return "viewport" === l ? (o.outputWidth = p.width, o.outputHeight = p.height) : "object" == typeof l && (l.width && l.height ? (o.outputWidth = l.width, o.outputHeight = l.height) : l.width ? (o.outputWidth = l.width, o.outputHeight = l.width / m) : l.height && (o.outputWidth = l.height * m, o.outputHeight = l.height)), Q.indexOf(s) > -1 && (o.format = "image/" + s, o.quality = u), o.circle = h, o.url = i.data.url, o.backgroundColor = c, n = new Promise(function(e) {
            switch (a.toLowerCase()) {
                case "rawcanvas":
                    e(R.call(i, o));
                    break;
                case "canvas":
                case "base64":
                    e(Z.call(i, o));
                    break;
                case "blob":
                    L.call(i, o).then(e);
                    break;
                default:
                    e(I.call(i, o))
            }
        })
    }

    function k() {
        C.call(this)
    }

    function H(e) {
        if (!this.options.useCanvas) throw "Croppie: Cannot rotate without enableOrientation";
        var t = this,
            n = t.elements.canvas,
            i = (t.elements.img, document.createElement("canvas")),
            o = 1;
        i.width = n.width, i.height = n.height;
        var r = i.getContext("2d");
        r.drawImage(n, 0, 0), (90 === e || -270 === e) && (o = 6), (-90 === e || 270 === e) && (o = 8), (180 === e || -180 === e) && (o = 3), c(n, i, o), f.call(t)
    }

    function Y() {
        var e = this;
        e.element.removeChild(e.elements.boundary), a(e.element, "croppie-container"), e.options.enableZoom && e.element.removeChild(e.elements.zoomerWrap), delete e.elements
    }

    function j(e, n) {
        if (this.element = e, this.options = t(t({}, j.defaults), n), "img" === this.element.tagName.toLowerCase()) {
            var i = this.element;
            r(i, "cr-original-image");
            var o = document.createElement("div");
            this.element.parentNode.appendChild(o), o.appendChild(i), this.element = o, this.options.url = this.options.url || i.src
        }
        if (h.call(this), this.options.url) {
            var a = {
                url: this.options.url,
                points: this.options.points
            };
            delete this.options.url, delete this.options.points, M.call(this, a)
        }
    }
    "function" != typeof Promise && ! function(e) {
        function t(e, t) {
            return function() {
                e.apply(t, arguments)
            }
        }

        function n(e) {
            if ("object" != typeof this) throw new TypeError("Promises must be constructed via new");
            if ("function" != typeof e) throw new TypeError("not a function");
            this._state = null, this._value = null, this._deferreds = [], s(e, t(o, this), t(r, this))
        }

        function i(e) {
            var t = this;
            return null === this._state ? void this._deferreds.push(e) : void c(function() {
                var n = t._state ? e.onFulfilled : e.onRejected;
                if (null === n) return void(t._state ? e.resolve : e.reject)(t._value);
                var i;
                try {
                    i = n(t._value)
                } catch (o) {
                    return void e.reject(o)
                }
                e.resolve(i)
            })
        }

        function o(e) {
            try {
                if (e === this) throw new TypeError("A promise cannot be resolved with itself.");
                if (e && ("object" == typeof e || "function" == typeof e)) {
                    var n = e.then;
                    if ("function" == typeof n) return void s(t(n, e), t(o, this), t(r, this))
                }
                this._state = !0, this._value = e, a.call(this)
            } catch (i) {
                r.call(this, i)
            }
        }

        function r(e) {
            this._state = !1, this._value = e, a.call(this)
        }

        function a() {
            for (var e = 0, t = this._deferreds.length; t > e; e++) i.call(this, this._deferreds[e]);
            this._deferreds = null
        }

        function l(e, t, n, i) {
            this.onFulfilled = "function" == typeof e ? e : null, this.onRejected = "function" == typeof t ? t : null, this.resolve = n, this.reject = i
        }

        function s(e, t, n) {
            var i = !1;
            try {
                e(function(e) {
                    i || (i = !0, t(e))
                }, function(e) {
                    i || (i = !0, n(e))
                })
            } catch (o) {
                if (i) return;
                i = !0, n(o)
            }
        }
        var u = setTimeout,
            c = "function" == typeof setImmediate && setImmediate || function(e) {
                u(e, 1)
            },
            h = Array.isArray || function(e) {
                return "[object Array]" === Object.prototype.toString.call(e)
            };
        n.prototype["catch"] = function(e) {
            return this.then(null, e)
        }, n.prototype.then = function(e, t) {
            var o = this;
            return new n(function(n, r) {
                i.call(o, new l(e, t, n, r))
            })
        }, n.all = function() {
            var e = Array.prototype.slice.call(1 === arguments.length && h(arguments[0]) ? arguments[0] : arguments);
            return new n(function(t, n) {
                function i(r, a) {
                    try {
                        if (a && ("object" == typeof a || "function" == typeof a)) {
                            var l = a.then;
                            if ("function" == typeof l) return void l.call(a, function(e) {
                                i(r, e)
                            }, n)
                        }
                        e[r] = a, 0 === --o && t(e)
                    } catch (s) {
                        n(s)
                    }
                }
                if (0 === e.length) return t([]);
                for (var o = e.length, r = 0; r < e.length; r++) i(r, e[r])
            })
        }, n.resolve = function(e) {
            return e && "object" == typeof e && e.constructor === n ? e : new n(function(t) {
                t(e)
            })
        }, n.reject = function(e) {
            return new n(function(t, n) {
                n(e)
            })
        }, n.race = function(e) {
            return new n(function(t, n) {
                for (var i = 0, o = e.length; o > i; i++) e[i].then(t, n)
            })
        }, n._setImmediateFn = function(e) {
            c = e
        }, "undefined" != typeof module && module.exports ? module.exports = n : e.Promise || (e.Promise = n)
    }(this), "function" != typeof window.CustomEvent && ! function() {
        function e(e, t) {
            t = t || {
                bubbles: !1,
                cancelable: !1,
                detail: void 0
            };
            var n = document.createEvent("CustomEvent");
            return n.initCustomEvent(e, t.bubbles, t.cancelable, t.detail), n
        }
        e.prototype = window.Event.prototype, window.CustomEvent = e
    }(), HTMLCanvasElement.prototype.toBlob || Object.defineProperty(HTMLCanvasElement.prototype, "toBlob", {
        value: function(e, t, n) {
            for (var i = atob(this.toDataURL(t, n).split(",")[1]), o = i.length, r = new Uint8Array(o), a = 0; o > a; a++) r[a] = i.charCodeAt(a);
            e(new Blob([r], {
                type: t || "image/png"
            }))
        }
    });
    var S, z, P, N = ["Webkit", "Moz", "ms"],
        O = document.createElement("div").style;
    z = e("transform"), S = e("transformOrigin"), P = e("userSelect");
    var A = {
            translate3d: {
                suffix: ", 0px"
            },
            translate: {
                suffix: ""
            }
        },
        T = function(e, t, n) {
            this.x = parseFloat(e), this.y = parseFloat(t), this.scale = parseFloat(n)
        };
    T.parse = function(e) {
        return e.style ? T.parse(e.style[z]) : e.indexOf("matrix") > -1 || e.indexOf("none") > -1 ? T.fromMatrix(e) : T.fromString(e)
    }, T.fromMatrix = function(e) {
        var t = e.substring(7).split(",");
        return t.length && "none" !== e || (t = [1, 0, 0, 1, 0, 0]), new T(l(t[4]), l(t[5]), parseFloat(t[0]))
    }, T.fromString = function(e) {
        var t = e.split(") "),
            n = t[0].substring(j.globals.translate.length + 1).split(","),
            i = t.length > 1 ? t[1].substring(6) : 1,
            o = n.length > 1 ? n[0] : 0,
            r = n.length > 1 ? n[1] : 0;
        return new T(o, r, i)
    }, T.prototype.toString = function() {
        var e = A[j.globals.translate].suffix || "";
        return j.globals.translate + "(" + this.x + "px, " + this.y + "px" + e + ") scale(" + this.scale + ")"
    };
    var D = function(e) {
        if (!e || !e.style[S]) return this.x = 0, void(this.y = 0);
        var t = e.style[S].split(" ");
        this.x = parseFloat(t[0]), this.y = parseFloat(t[1])
    };
    D.prototype.toString = function() {
        return this.x + "px " + this.y + "px"
    };
    var q = n(y, 500),
        U = {
            type: "canvas",
            format: "png",
            quality: 1
        },
        Q = ["jpeg", "webp", "png"];
    if (window.jQuery) {
        var $ = window.jQuery;
        $.fn.croppie = function(e) {
            var t = typeof e;
            if ("string" === t) {
                var n = Array.prototype.slice.call(arguments, 1),
                    i = $(this).data("croppie");
                return "get" === e ? i.get() : "result" === e ? i.result.apply(i, n) : "bind" === e ? i.bind.apply(i, n) : this.each(function() {
                    var t = $(this).data("croppie");
                    if (t) {
                        var i = t[e];
                        if (!$.isFunction(i)) throw "Croppie " + e + " method not found";
                        i.apply(t, n), "destroy" === e && $(this).removeData("croppie")
                    }
                })
            }
            return this.each(function() {
                var t = new j(this, e);
                t.$ = $, $(this).data("croppie", t)
            })
        }
    }
    j.defaults = {
        viewport: {
            width: 100,
            height: 100,
            type: "square"
        },
        boundary: {},
        orientationControls: {
            enabled: !0,
            leftClass: "",
            rightClass: ""
        },
        customClass: "",
        showZoomer: !0,
        enableZoom: !0,
        mouseWheelZoom: !0,
        enableExif: !1,
        enforceBoundary: !0,
        enableOrientation: !1,
        update: function() {}
    }, j.globals = {
        translate: "translate3d"
    }, t(j.prototype, {
        bind: function(e, t) {
            return M.call(this, e, t)
        },
        get: function() {
            var e = W.call(this),
                t = e.points;
            return this.options.relative && (t[0] /= this.elements.img.naturalWidth / 100, t[1] /= this.elements.img.naturalHeight / 100, t[2] /= this.elements.img.naturalWidth / 100, t[3] /= this.elements.img.naturalHeight / 100), e
        },
        result: function(e) {
            return X.call(this, e)
        },
        refresh: function() {
            return k.call(this)
        },
        setZoom: function(e) {
            m.call(this, e), i(this.elements.zoomer)
        },
        rotate: function(e) {
            H.call(this, e)
        },
        destroy: function() {
            return Y.call(this)
        }
    }), exports.Croppie = window.Croppie = j, "object" == typeof module && module.exports && (module.exports = j)
});

