! function(n) {
    var a = {};

    function r(e) {
        if (a[e]) return a[e].exports;
        var t = a[e] = {
            i: e,
            l: !1,
            exports: {}
        };
        return n[e].call(t.exports, t, t.exports, r), t.l = !0, t.exports
    }
    r.m = n, r.c = a, r.d = function(e, t, n) {
        r.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: n
        })
    }, r.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, r.t = function(t, e) {
        if (1 & e && (t = r(t)), 8 & e) return t;
        if (4 & e && "object" == typeof t && t && t.__esModule) return t;
        var n = Object.create(null);
        if (r.r(n), Object.defineProperty(n, "default", {
            enumerable: !0,
            value: t
        }), 2 & e && "string" != typeof t)
            for (var a in t) r.d(n, a, function(e) {
                return t[e]
            }.bind(null, a));
        return n
    }, r.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return r.d(t, "a", t), t
    }, r.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, r.p = "", r(r.s = "./assets/admin/src/template-kit.js")
}({
    "./assets/admin/src/template-kit.js": function(e, t, n) {
        "use strict";
        n.r(t);
        var a = n("jquery"),
            l = n.n(a);

        function r(e, t) {
            for (var n = 0; n < t.length; n++) {
                var a = t[n];
                a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a)
            }
        }
        new(function() {
            function e() {
                ! function(e, t) {
                    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
                }(this, e), this.currentID = 0, this.templateModal = l()("#template-modal-content"), this.filters(), this.modal(), this.import()
            }
            return function(e, t, n) {
                t && r(e.prototype, t), n && r(e, n)
            }(e, [{
                key: "filters",
                value: function() {
                    var i = this;
                    l()(".filter-nav").select2({
                        width: "100%",
                        placeholder: "Select category"
                    }).on("select2:select", function(e) {
                        var t = l()(e.currentTarget),
                            n = t.val(),
                            a = t.find("option"),
                            r = "tk-all",
                            o = "All";
                        a.each(function() {
                            var e = l()(this);
                            e.val() === n && (r = e.data("filter"), o = e.attr("data-title"))
                        }), i.updateGallery(r, o)
                    })
                }
            }, {
                key: "updateGallery",
                value: function(n, e) {
                    var a = l()(".filter-content");
                    "tk-all" === n ? a.fadeOut(300, function() {
                        l()(".post").show(), a.fadeIn()
                    }) : a.find(".post").each(function(e, t) {
                        a.fadeOut(300, function() {
                            l()(t).hasClass(n) ? l()(t).show() : l()(t).hide(), a.fadeIn()
                        })
                    }),     this.templateModal.parent().find('.filter-content, h3, .custom-btn').removeClass("hide-d"), this.templateModal.removeClass("show"), l()(".filter-title").text(e)
                }
            }, {
                key: "modal",
                value: function() {
                    var a = this;
                    l()(".post").on("click", function(e) {
                        var t = l()(e.currentTarget),
                            n = aheto.templates[t.data("index")];
                        a.currentID = t.data("index"),
                            a.slug = t.data("slug"),
                            a.templateModal.find(".template-preview").attr("href", n.preview_url),
                            a.templateModal.find(".template-title").html(n.title),
                            a.templateModal.find(".template-screenshot").attr("src", n.screenshot),
                            a.templateModal.find(".template-id").val(a.currentID),
                            a.templateModal.find(".template-slug").val(a.slug),
                            a.templateModal.parent().find('.filter-content, h3, .custom-btn').addClass("hide-d"),
                            a.templateModal.addClass("show")
                    }), l()(".template-kit-import h3 small").on("click", function() {
                        l()(".post").removeClass("act"), a.templateModal.parent().find('.filter-content, h3, .custom-btn').removeClass("hide-d"), a.templateModal.removeClass("show"), a.currentID = 0
                    })
                }
            }, {
                key: "import",
                value: function() {
                    var n = this,
                        t = l()(".action-template-import "),
                        s = l()(".action-skin-import "),
                        h = l()(".action-header-import "),
                        f = l()(".action-footer-import "),
                        a = l()("form", ".template-kit-create-page");
                    l()(document).on("click", ".action-template-import", function(e) {
                        document.getElementById("loader_importing_page").style.display = "block";
                        e.preventDefault(), n.fetch("template").done(function(e) {
                        	document.getElementById("loader_importing_page").style.display = "none";
							if ( e.success === false ) {
								e.error && n.addNotice(e.error, "error", t, 3e3)
							}
							else{
								e.message && n.addNotice(e.message, "success", t, 3e3)
							}
                        }).catch((error) => {
                            document.getElementById("loader_importing_page").style.display = "none";
                            e.error && n.addNotice( e.error, "error", t);
                        })
                    }),
					l()(document).on("click", ".action-skin-import", function(e) {
						document.getElementById("loader_importing_page").style.display = "block";
						e.preventDefault(), n.fetch("skin").done(function(e) {
							document.getElementById("loader_importing_page").style.display = "none";
							if ( e.success === false ) {
								e.error && n.addNotice(e.error, "error", s, 3e3)
							}
							else{
								e.message && n.addNotice(e.message, "success", s, 3e3)
							}
						}).error(function(e) {
							document.getElementById("loader_importing_page").style.display = "none";
							e.error && n.addNotice('Something wrong.', "error", s);
						})
					}),
					l()(document).on("click", ".action-header-import", function(e) {
						document.getElementById("loader_importing_page").style.display = "block";
						e.preventDefault(), n.fetch("header").done(function(e) {
							document.getElementById("loader_importing_page").style.display = "none";
							if ( e.success === false ) {
								e.error && n.addNotice(e.error, "error", h, 3e3)
							}
							else{
								e.message && n.addNotice(e.message, "success", h, 3e3)
							}
						}).error(function(e) {
							document.getElementById("loader_importing_page").style.display = "none";
							e.error && n.addNotice('Something wrong.', "error", s);
						})
					}),
					l()(document).on("click", ".action-template-create-page", function(e) {
                        document.getElementById("loader_creating_page").style.display = "block";
                        e.preventDefault();
                        var t = l()(".aheto-page-name").val();
                        "" !== t ? n.fetch("page", {
                            pageTitle: t
                        }).done(function(e) {
                            document.getElementById("loader_creating_page").style.display = "none";
                            e.message && n.addNotice(e.message, "success", a, 3e3)
                        }) : n.addNotice("Please enter title for page.", "error", a, 3e3);

                        function hide() {
                            document.getElementById("loader_creating_page").style.display = "none";
                        }
                        setTimeout(hide, 2000);
                    })
                }
            }, {
                key: "fetch",
                value: function(e, t) {
                    return l.a.ajax({
                        url: window.ajaxurl,
                        method: "post",
                        data: l.a.extend({}, {
                            action: "aheto_import_" + e,
                            security: aheto.security,
                            templateID: this.currentID,
                            slugId: this.slug
                        }, t)
                    })
                }
            }, {
                key: "addNotice",
                value: function(e, t, n, a) {
                    var r = l()('<div class="notice notice-' + t + ' is-dismissible"><p>' + e + "</p></div>").hide();
                    t = t || "error", a = a || !1, n.next(".notice").remove(), n.after(r), r.slideDown(), l()(document).trigger("wp-updates-notice-added"), a && setTimeout(function() {
                        r.fadeOut(function() {
                            return r.remove()
                        })
                    }, a)
                }
            }]), e
        }())
    },
    jquery: function(e, t) {
        e.exports = jQuery
    }

});

(function() {

    jQuery('.filter-content .post').on('click', function() {
        jQuery("html, body").animate({
            scrollTop: 0
        }, "slow");
    });

    window.addEventListener('load', function () {
        if (jQuery("img[data-lazy-src]").length) {
            jQuery("img[data-lazy-src]").ahetolazy();
        }
    });

}(jQuery))
