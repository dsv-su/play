var suobj = suobj || {};
suobj.utils = {
    ANIMATION_SPEED: "fast", TRUNCATE_DEFAULT_LENGTH: 1200, TRUNCATE_FORGIVENESS: 400, getParams: function (b) {
        var c = null;
        var a = document.createElement("a");
        a.href = b;
        var j = a.search.substring(1);
        var h = j.split("&");
        for (var f = 0; f < h.length; f++) {
            var d = h[f].split("=");
            if (d.length < 2 || d[1] == null || d[1] == "") {
                continue
            }
            c = c || {};
            var l = d[0];
            var k = decodeURIComponent(d[1]);
            var g = c[l] || [];
            g.push(k);
            c[l] = g
        }
        return c
    }, getParam: function (a) {
        var b = this.getParams(window.location.href);
        if (b) {
            return b[a]
        }
    }, pushToParams: function (a, d) {
        var f = this.getParams(window.location.href) || {};
        var c = [];
        f[a] = d;
        for (var b in f) {
            if (!f.hasOwnProperty(b)) {
                continue
            }
            c.push(b + "=" + f[b])
        }
        history.replaceState(history.state, $(document).find("title").text(), window.location.pathname + "?" + c.join("&"))
    }, truncate: function (b) {
        var h = b.find(".js-truncate-txt");
        var j = b.find(".su-js-toggle-btn");
        var c = b.find(".collapse");
        var f = j.attr("data-target");
        var g = false;
        var l = parseInt(b.attr("data-truncate-len"));
        var d = parseInt(b.attr("data-truncate-forgiveness"));
        var k;
        var a = h.html();
        if (isNaN(l)) {
            l = suobj.utils.TRUNCATE_DEFAULT_LENGTH
        }
        if (isNaN(d)) {
            d = suobj.utils.TRUNCATE_FORGIVENESS
        }
        if (a.length > l + d) {
            while (a.length > l) {
                k = h.children();
                if (k.length === 1 && a.length <= l + d) {
                    break
                }
                g = true;
                k.detach(":last").last().prependTo(f);
                a = h.html()
            }
        }
        if (g) {
            var m = h.children().last();
            if (m.is("p")) {
                m.append('<span class="js-truncate-dot-dot-dot"> ...</span>')
            } else {
                h.append('<span class="js-truncate-dot-dot-dot"> ...</span>')
            }
            b.addClass("truncated");
            $(f).removeClass("d-none");
            j.removeClass("d-none");
            c.on("shown.bs.collapse", function () {
                b.find(".js-truncate-dot-dot-dot").addClass("d-none")
            });
            c.on("hidden.bs.collapse", function () {
                b.find(".js-truncate-dot-dot-dot").removeClass("d-none")
            })
        }
    }
};
var suobj = suobj || {};
suobj.educationinfoarticle = {
    selectedEducationEvent: {}, init: function () {
        $(".js-event-toggler").on("click", function (a) {
            a.preventDefault();
            suobj.educationinfoarticle.toggleEvent($(this), false)
        });
        suobj.educationinfoarticle.initSelectedEducationEvent();
        suobj.educationinfoarticle.showSelectedEducationEvent();
        suobj.educationinfoarticle.setToggleLinks()
    }, initSelectedEducationEvent: function () {
        var b;
        var a;
        if (typeof educationInfoArticleDefaults != "undefined") {
            suobj.educationinfoarticle.selectedEducationEvent = educationInfoArticleDefaults
        } else {
            b = $(".js-education-semester-toggle").find(".js-semester-option:first").attr("data-event-semester") || "";
            a = $(".js-education-event-toggle").find(".js-event-option:first").attr("data-event-code") || "";
            suobj.educationinfoarticle.selectedEducationEvent = {semester: b, eventcode: a}
        }
    }, showSelectedEducationEvent: function () {
        var b = $(".js-education-event-toggle");
        var c = $(".js-education-semester-toggle");
        var a = c.find(".show");
        var f = suobj.educationinfoarticle.selectedEducationEvent.semester;
        var d = suobj.educationinfoarticle.selectedEducationEvent.eventcode;
        if (a.length && f !== a.attr("data-event-semester")) {
            a.fadeTo(suobj.utils.ANIMATION_SPEED, 0, function () {
                c.find(".show").removeClass("show").attr("aria-expanded", "false");
                c.find('[data-event-semester="' + f + '"]').addClass("show").attr("aria-expanded", "true").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
            })
        } else {
            c.find('[data-event-semester="' + f + '"]').attr("aria-expanded", "true").addClass("show").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
        }
        if (b.find(".show").length) {
            b.find(".show").fadeTo(suobj.utils.ANIMATION_SPEED, 0, function () {
                b.find(".show").removeClass("show").attr("aria-expanded", "false");
                b.find('[data-event-code="' + d + '"]').addClass("show").attr("aria-expanded", "true").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
            })
        } else {
            b.find('[data-event-code="' + d + '"]').addClass("show").attr("aria-expanded", "true").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
        }
    }, setToggleLinks: function () {
        var d = $("#education-event-togglers").find(".js-education-toggle-this");
        var a = d.filter('[data-event-code="' + suobj.educationinfoarticle.selectedEducationEvent.eventcode + '"]');
        var c = $(".js-education-semester-toggle").find(".js-semester-option");
        var b = c.filter('[data-event-semester="' + suobj.educationinfoarticle.selectedEducationEvent.semester + '"]');
        suobj.educationinfoarticle.setNextEventLink(a);
        suobj.educationinfoarticle.setNextSemesterLink(b, a);
        suobj.educationinfoarticle.setPrevEventLink(a);
        suobj.educationinfoarticle.setPrevSemesterLink(b, a)
    }, doPushState: function () {
        var c = location.href.split("?")[0];
        var b = {
            eventcode: suobj.educationinfoarticle.selectedEducationEvent.eventcode,
            semester: suobj.educationinfoarticle.selectedEducationEvent.semester
        };
        var a = c + "?semester=" + b.semester + "&eventcode=" + b.eventcode;
        history.replaceState(b, "", a)
    }, toggleEvent: function (a) {
        var c;
        var b;
        if (!a.hasClass("disabled")) {
            c = a.attr("data-event-semester");
            b = a.attr("data-event-code");
            suobj.educationinfoarticle.selectedEducationEvent.semester = c;
            suobj.educationinfoarticle.selectedEducationEvent.eventcode = b;
            suobj.educationinfoarticle.showSelectedEducationEvent();
            suobj.educationinfoarticle.setToggleLinks();
            suobj.educationinfoarticle.doPushState()
        }
    }, getEvent: function (a) {
        if (suobj.educationinfoarticle.selectedEducationEvent) {
            $event = a.filter('[data-event-code="' + suobj.educationinfoarticle.selectedEducationEvent.eventcode + '"]');
            if ($event.length) {
                return $event
            }
        }
        return a.first()
    }, getNextEventSameSemester: function (a) {
        return a.next('.js-event-option[data-event-semester="' + suobj.educationinfoarticle.selectedEducationEvent.semester + '"]')
    }, getPrevEventSameSemester: function (a) {
        return a.prev('.js-event-option[data-event-semester="' + suobj.educationinfoarticle.selectedEducationEvent.semester + '"]')
    }, getNextEventNextSemester: function (c, a) {
        var b = c.next(".js-semester-option");
        if (!b.length) {
            return null
        }
        return a.nextAll('[data-event-semester="' + b.attr("data-event-semester") + '"]').first()
    }, getPrevEventPrevSemester: function (c, a) {
        var b = c.prev(".js-semester-option");
        if (!b.length) {
            return null
        }
        return a.prevAll('[data-event-semester="' + b.attr("data-event-semester") + '"]').first()
    }, setEventLink: function (c, b) {
        var a = $(c);
        if (b && b.length) {
            a.removeClass("disabled").attr("data-event-semester", b.attr("data-event-semester")).attr("data-event-code", b.attr("data-event-code")).attr("aria-disabled", "false").prop("disabled", false)
        } else {
            a.addClass("disabled").attr("data-event-semester", "").attr("data-event-code", "").attr("aria-disabled", "true").prop("disabled", true)
        }
    }, setNextEventLink: function (b) {
        var a = suobj.educationinfoarticle.getNextEventSameSemester(b);
        suobj.educationinfoarticle.setEventLink("#js-next-event", a)
    }, setNextSemesterLink: function (c, a) {
        var b = suobj.educationinfoarticle.getNextEventNextSemester(c, a);
        suobj.educationinfoarticle.setEventLink("#js-next-semester", b)
    }, setPrevEventLink: function (b) {
        var a = suobj.educationinfoarticle.getPrevEventSameSemester(b);
        suobj.educationinfoarticle.setEventLink("#js-prev-event", a)
    }, setPrevSemesterLink: function (c, a) {
        var b = suobj.educationinfoarticle.getPrevEventPrevSemester(c, a);
        suobj.educationinfoarticle.setEventLink("#js-prev-semester", b)
    }
};
$(function () {
    if ($("#education-info-article").length) {
        suobj.educationinfoarticle.init()
    }
});
var suobj = suobj || {};
suobj.anchorlinks = {
    init: function () {
        const f = $(".js-anchor-links-headers-container h2");
        const n = $(".anchor-links-card-wrapper");
        const d = $(".anchor-links-card");
        const g = $(".js-anchor-links-ul");
        const j = $(".anchor-sidebar");
        const c = $(".anchor-openbtn");
        const m = $(".anchor-links-ul, .closebtn");
        const k = $(".js-designated-image-wrapper");
        const h = $(".su-theme-links-box");
        const a = "h2-link-";
        let generatedIdNumber = 1;
        if (f.length > 0) {
            f.each(function () {
                $(this).before('<span id="' + a + generatedIdNumber + '" class="su-anchor">&nbsp;</span>');
                g.append('<li><a href="#' + a + generatedIdNumber + '">' + $(this).text() + "</a></li>");
                generatedIdNumber++
            });
            let anchorLinksCardWrapperHeight = (f.length * 40) + 72;
            let designatedImageWrapperHeight = 270;
            let suThemeLinksBoxHeight = h.outerHeight(true) + 18;
            let combinedHeight = suThemeLinksBoxHeight + anchorLinksCardWrapperHeight + designatedImageWrapperHeight;
            let availableViewPortHeight = $(window).height() - 48;
            let viewPortWidth = $(window).width();
            const l = 990;
            const b = 350;
            let rightColumnIsVisible = viewPortWidth > l;
            let anchorLinksAreObscured = combinedHeight > availableViewPortHeight;
            if (rightColumnIsVisible && anchorLinksAreObscured) {
                $(window).scroll(function () {
                    if ($(document).scrollTop() > b) {
                        k.removeClass("mb-4");
                        k.hide("normal")
                    } else {
                        k.show("normal");
                        k.addClass("mb-4")
                    }
                })
            }
            c.click(function (o) {
                o.stopPropagation();
                j.show();
                $("body").one("click", function (p) {
                    j.hide()
                })
            });
            m.click(function (o) {
                j.hide()
            });
            n.removeClass("d-none")
        } else {
            n.remove();
            d.remove();
            c.remove();
            j.remove()
        }
    }
};
$(function () {
    if ($(".js-anchor-links-headers-container").length) {
        suobj.anchorlinks.init()
    }
});
var suobj = suobj || {};
suobj.linktotop = {
    init: function () {
        const b = $(".su-js-link-to-top-button");
        let viewPortHeight = $(window).height();
        let pageHeight = $(document).height();
        let showLinkToTop = pageHeight > (viewPortHeight * 2.5);
        if (showLinkToTop) {
            let scrolled;
            let lastScrollPosition = 0;
            $(window).scroll(function () {
                scrolled = true
            });
            setInterval(function () {
                if (scrolled) {
                    a();
                    scrolled = false
                }
            }, 500);

            function a() {
                let currentScrollPosition = $(this).scrollTop();
                let positionChanged = currentScrollPosition !== lastScrollPosition;
                if (positionChanged && currentScrollPosition > viewPortHeight) {
                    b.show()
                } else {
                    if (currentScrollPosition < viewPortHeight) {
                        b.hide()
                    }
                }
                lastScrollPosition = currentScrollPosition
            }
        }
        b.click(function () {
            $("html,body").animate({scrollTop: 0}, 400);
            return false
        })
    }
};
$(window).on("load", (function () {
    suobj.linktotop.init()
}));
$(function () {
    const a = $("#navbar-search_desktop");
    const g = $("#navbar-search-close_desktop");
    const f = $("#togglerHamburger_desktop");
    const d = $("#navbar-hamburger-close_desktop");
    const b = $("#dropdownMenuWrapper");
    const h = $("#primaryHamburgerCollapse");
    const c = $("#departmentHamburgerCollapse");
    const j = $("#dropdownMenuWrapper, #navbar-hamburger_desktop, #navbar-search_desktop");
    var k;
    h.on("hidden.bs.collapse", function () {
        j.removeClass("d-none");
        d.addClass("d-none")
    });
    h.on("shown.bs.collapse", function () {
        j.addClass("d-none");
        d.removeClass("d-none")
    });
    c.on("hidden.bs.collapse", function () {
        j.removeClass("d-none");
        d.addClass("d-none")
    });
    c.on("shown.bs.collapse", function () {
        j.addClass("d-none");
        d.removeClass("d-none")
    });
    $("#togglerSearch_desktop.navbar-toggler.collapsed").click(function () {
        if ($("#primarySearchFormCollapse").hasClass("collapsing")) {
            return false
        }
        a.toggleClass("d-none");
        f.toggleClass("d-none");
        b.toggleClass("d-none");
        g.toggleClass("d-none");
        $("#main-search").trigger("reset");
        if (a.hasClass("d-none")) {
            setTimeout(function () {
                $("#header-main-search-text").focus()
            }, 500)
        }
    });
    setTopSpacer();
    $(window).resize(function () {
        setTopSpacer()
    });
    $(window).scroll(function () {
        if (k) {
            clearTimeout(k);
            k = null
        }
        k = setTimeout(setTopSpacer, 250)
    })
});
$(document).ready(function () {
    let currentScrollPos = $(window).scrollTop();
    let isAtTop = true;
    $(window).scroll(function () {
        let headerOuterHeight = $("header").outerHeight();
        let newScrollPos = $(this).scrollTop();
        if (newScrollPos > currentScrollPos) {
            if (isAtTop) {
                $("#suDepartmentTopNav").addClass("d-none");
                $("#suDepartmentHeaderLogo").removeClass("d-none");
                $("#suDepartmentHeader").removeClass("dept-header_ontop").addClass("dept-header_onpage");
                isAtTop = false
            }
        } else {
            if (!isAtTop && currentScrollPos < 100) {
                $("#suDepartmentTopNav").removeClass("d-none");
                $("#suDepartmentHeaderLogo").addClass("d-none");
                $("#suDepartmentHeader").removeClass("dept-header_onpage").addClass("dept-header_ontop");
                isAtTop = true
            }
        }
        currentScrollPos = newScrollPos;
        if ($("#togglerHamburger_desktop").attr("aria-expanded")) {
            $("#departmentHamburgerCollapse").collapse("hide")
        }
        $(".header-mega-menu-collapse__department").css({top: headerOuterHeight})
    })
});

function browserHasSvgSupport() {
    return !isIE() && document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1")
}

function isIE() {
    return window.navigator.userAgent.match(/(MSIE|Trident)/)
}

if (!browserHasSvgSupport()) {
    var e = document.querySelectorAll("[data-fallback]");
    for (var i = 0; i < e.length; i++) {
        var img = e[i], src = img.getAttribute("src");
        if (src.match(/svgz?$/)) {
            img.setAttribute("src", img.getAttribute("data-fallback"))
        }
    }
}
if (!"objectFit" in document.documentElement.style) {
    var container = document.getElementsByClassName("js-object-fit-box");
    for (var i = 0; i < container.length; i++) {
        var imageSource = container[i].querySelector("img").src;
        container[i].querySelector("img").style.display = "none";
        container[i].style.backgroundSize = "cover";
        container[i].style.backgroundImage = "url(" + imageSource + ")";
        container[i].style.backgroundPosition = "center center";
        container[i].style.height = "450px"
    }
}

function setTopSpacer() {
    let headerOuterHeight = $("header").outerHeight();
    $("#top-spacer").css("height", headerOuterHeight);
    $(".header-mega-menu-collapse__department").css({top: headerOuterHeight})
}

var suobj = suobj || {};
suobj.chosenfilters = {
    init: function () {
        var c = $("#clear-filter-button");
        var b = $("#education-search-filter-checkbox-area :checkbox");
        var a = $("button[id*='chosen-filter']");
        b.change(function () {
            var d = suobj.chosenfilters.getNameAndNumberFromElementId($(this));
            $("#chosen-filter-" + d).toggle(this.checked);
            suobj.chosenfilters.handleVisibilityOfButton(c)
        });
        a.click(function () {
            var d = suobj.chosenfilters.getNameAndNumberFromElementId($(this));
            $("#chosen-filter-" + d).toggle();
            $("#custom-checkbox-" + d).prop("checked", false);
            suobj.educationsearch.doSearch(true);
            suobj.chosenfilters.handleVisibilityOfButton(c)
        });
        c.click(function (d) {
            d.preventDefault();
            b.prop("checked", false);
            suobj.chosenfilters.hideAllCheckedFilterButtons(a);
            suobj.educationsearch.doSearch(true);
            suobj.chosenfilters.handleVisibilityOfButton(c)
        })
    }, getNameAndNumberFromElementId: function (d) {
        var a = d.attr("id");
        var f = a.split("-");
        var b = f[f.length - 2];
        var c = f[f.length - 1];
        return b + "-" + c
    }, hideAllCheckedFilterButtons: function (a) {
        a.toggle($(this).is(":checked"))
    }, checkBoxesAreChecked: function () {
        return $("#education-search-filter-checkbox-area :checkbox:checked").length
    }, handleVisibilityOfButton: function (a) {
        if (suobj.chosenfilters.checkBoxesAreChecked()) {
            a.show()
        } else {
            a.hide()
        }
    }
};
suobj.educationsearch = {
    page: -1,
    perpage: 20,
    PERPAGE_DEFAULT: 20,
    TIMEOUT_DELAY: 200,
    TIMEOUT: undefined,
    autocompleteIndex: -1,
    url: "",
    langsearchresults: "sv",
    initSearchForm: function (c) {
        var a = $("#education-search-form");
        var b = $("#clear-search-input");
        suobj.educationsearch.url = URLToAjax;
        suobj.educationsearch.langsearchresults = langSearchResults;
        $("#education-search-more-filters").on("show.bs.collapse", function (d) {
            if ($(this).is(d.target)) {
                $(this).closest(".education-search-toggle-box").addClass("su-expanded")
            }
        }).on("hidden.bs.collapse", function (d) {
            if ($(this).is(d.target)) {
                $(this).closest(".education-search-toggle-box").removeClass("su-expanded")
            }
        });
        if ($("#education-search-element").length) {
            suobj.chosenfilters.init()
        }
        $(".pager-show-more").on("click", function () {
            suobj.educationsearch.page++;
            suobj.educationsearch.showNumberOfHits();
            suobj.educationsearch.doSearch(false)
        });
        a.on("submit", function (d) {
            d.preventDefault();
            suobj.educationsearch.page = 1;
            suobj.educationsearch.doSearch(true)
        });
        $("#education-search-submit").on("click", function (d) {
            d.preventDefault();
            a.trigger("submit")
        });
        c.on("input", function () {
            var d = c.val();
            if (d === "") {
                b.addClass("d-none")
            } else {
                b.removeClass("d-none")
            }
        });
        b.on("click", function (d) {
            d.preventDefault();
            c.val("");
            b.addClass("d-none")
        });
        a.find("input[type=checkbox]").change(function (d) {
            d.preventDefault();
            suobj.educationsearch.doSearch(true)
        });
        suobj.educationsearch.initFiltersFromParams(c);
        suobj.educationsearch.initAutoComplete(c);
        suobj.educationsearch.doSearch(true);
        $(".education-search-list").on("click", "a", function (h) {
            var g = $(this);
            var f = g.attr("data-index");
            var j = g.attr("data-title");
            var d = g.attr("href");
            h.preventDefault();
            var k = function () {
                window.location.href = d
            };
            suobj.educationsearch.searchClickTracking(d, j, f, null, k);
            return false
        });
        window.onunload = function () {
        }
    },
    initFiltersFromParams: function (d) {
        var c = suobj.utils.getParams(window.location.href);
        var a = $("#education-search-form");
        if (!c && "en" == suobj.educationsearch.langsearchresults) {
            c = {};
            c.eventopenforinternationalstudents = ["true"]
        }
        if (!c) {
            return
        }
        $.each(c, function (f, g) {
            a.find("[name=" + f + "]").val(g);
            $.each(g, function (j, h) {
                $("#chosen-filter-" + f + "-" + h).show()
            })
        });
        try {
            suobj.educationsearch.page = parseInt(c.page)
        } catch (b) {
        }
        if (suobj.educationsearch.page < 1) {
            suobj.educationsearch.page = 1
        }
        suobj.educationsearch.perpage = suobj.educationsearch.page * suobj.educationsearch.PERPAGE_DEFAULT;
        if (d.val().length) {
            d.trigger("input")
        }
        suobj.chosenfilters.handleVisibilityOfButton($("#clear-filter-button"));
        a.trigger("change")
    },
    initAutoComplete: function (a) {
        a.on("keydown", function (c) {
            var b;
            var d;
            if (c.keyCode === 40) {
                suobj.educationsearch.autocompleteIndex++;
                suobj.educationsearch.autoCompleteAddActive();
                c.preventDefault()
            } else {
                if (c.keyCode === 38) {
                    suobj.educationsearch.autocompleteIndex--;
                    suobj.educationsearch.autoCompleteAddActive();
                    c.preventDefault()
                } else {
                    if (c.keyCode === 13) {
                        b = $(".education-search-auto-complete").find(".autocomplete-active > a");
                        d = b.length && b.data("comparestring");
                        if (d) {
                            a.val(d)
                        }
                        $("#education-search-form").trigger("submit");
                        suobj.educationsearch.autoComplete("");
                        c.preventDefault()
                    }
                }
            }
        });
        $(".education-search-auto-complete").on("click", "a", function (c) {
            var b = $(this);
            c.preventDefault();
            a.val(b.data("comparestring"));
            $("#education-search-form").trigger("submit");
            suobj.educationsearch.autoComplete("")
        });
        $(document).on("click", function () {
            suobj.educationsearch.autoComplete("")
        });
        a.on("input", function () {
            suobj.educationsearch.timedSearchTyping(a.val())
        })
    },
    autoComplete: function (b) {
        var a = $(".education-search-auto-complete");
        if (b.length) {
            $.ajax({
                data: {q: b, autocomplete: true, langsearchresults: suobj.educationsearch.langsearchresults},
                url: suobj.educationsearch.url,
                dataType: "html",
                success: function (f) {
                    a.html(f);
                    if (b.length > 3) {
                        b = b.toLowerCase();
                        var d = a.find("a");
                        var c = b.split(" ").filter(function (j) {
                            return j.length > 3
                        });
                        var g = {};
                        if (c.length) {
                            c.forEach(function (j) {
                                g[j] = '<span class="text-sans-serif-bold">' + j + "</span>"
                            });
                            var h = new RegExp(Object.keys(g).join("|"), "gi");
                            d.each(function () {
                                var k = $(this);
                                var j = k.data("comparestring");
                                j = j.replace(h, function (l) {
                                    return g[l.toLowerCase()]
                                });
                                k.html(j)
                            })
                        }
                    }
                    a.removeClass("d-none")
                },
                error: function (c) {
                    console && console.log && console.log("ERROR", c);
                    suobj.educationsearch.autoComplete("")
                }
            })
        } else {
            suobj.educationsearch.autocompleteIndex = -1;
            a.addClass("d-none");
            a.html("")
        }
    },
    autoCompleteAddActive: function () {
        var a = $(".education-search-auto-complete > li");
        if (suobj.educationsearch.autocompleteIndex < -1) {
            suobj.educationsearch.autocompleteIndex = a.length - 1
        }
        if (suobj.educationsearch.autocompleteIndex >= a.length) {
            suobj.educationsearch.autocompleteIndex = -1
        }
        a.removeClass("autocomplete-active");
        if (suobj.educationsearch.autocompleteIndex > -1) {
            a.filter("li:eq(" + suobj.educationsearch.autocompleteIndex + ")").addClass("autocomplete-active")
        }
    },
    timedSearchTyping: function (c, b) {
        var a = b || suobj.educationsearch.TIMEOUT_DELAY;
        window.clearTimeout(suobj.educationsearch.TIMEOUT);
        suobj.educationsearch.TIMEOUT = window.setTimeout(function () {
            suobj.educationsearch.autoComplete(c)
        }, a)
    },
    fadeToClose: function () {
        $("#edu-search").fadeTo(suobj.utils.ANIMATION_SPEED, 0, function () {
            $("#edu-search").addClass("d-none");
            $("#edu-search-close").removeClass("d-none").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
        })
    },
    getNumberOfRowsShown: function () {
        return $(".education-search-list").children("li").length
    },
    doSearch: function (g) {
        var d = suobj.educationsearch.perpage;
        var j = suobj.educationsearch.page;
        if (d > suobj.educationsearch.PERPAGE_DEFAULT) {
            suobj.educationsearch.perpage = suobj.educationsearch.PERPAGE_DEFAULT;
            j = 1
        } else {
            if (g) {
                suobj.educationsearch.page = 1;
                j = 1
            }
        }
        var b = $("#education-search-form");
        var c = b.serialize() + "&ajax=true&page=" + j + "&langsearchresults=" + suobj.educationsearch.langsearchresults + "&count=" + d + "&_" + Date.now();
        var f = window.location.pathname + "?";
        var a = b.serialize() + "&page=" + suobj.educationsearch.page;
        var h = $(".education-search-list");
        suobj.educationsearch.searchStart(g);
        $.ajax({
            data: c, dataType: "html", url: suobj.educationsearch.url, success: function (k) {
                var n = -1;
                var m = suobj.educationsearch.getNumberOfRowsShown();
                if (g) {
                    h.html(k);
                    suobj.educationsearch.showNumberOfHits();
                    suobj.educationsearch.showFixedQuery();
                    if ($("#education-search-query").val() !== "") {
                        suobj.educationsearch.fadeToClose()
                    }
                } else {
                    h.append(k);
                    h.find("li:nth-of-type(" + (m + 1) + ")").find("a").focus()
                }
                history.replaceState(history.state, $(document).find("title").text(), f + a);
                try {
                    n = parseInt(h.find(".education-search-result:last").attr("data-totalrow"))
                } catch (l) {
                }
                if (n < 0 || n > suobj.educationsearch.getNumberOfRowsShown()) {
                    $(".pager-show-more").removeClass("d-none")
                } else {
                    $(".pager-show-more").addClass("d-none")
                }
            }, complete: function () {
                suobj.educationsearch.searchEnd(g);
                suobj.educationsearch.searchQueryTracking()
            }
        })
    },
    searchQueryTracking: function () {
        var a = {
            responsetime: educationSearchResponseTime,
            resultcount: educationSearchResultCount,
            fixedquery: educationSearchFixedQuery,
            bannerscount: "0"
        };
        suobj.educationsearch.searchTracking(a, "query")
    },
    searchClickTracking: function (b, g, d, j, h) {
        var f = "searchresult";
        var c = "";
        if (j) {
            f = "banner";
            c = j
        }
        var a = {clickurl: b, title: g, clicksearchresultindex: d, logsource: f, clickedbannerid: c};
        suobj.educationsearch.searchTracking(a, "click", h)
    },
    searchTracking: function (a, b, f) {
        var d = {
            screensize: window.screen.availWidth + "x" + window.screen.availHeight,
            useragent: navigator.userAgent,
            referalurl: window.location.origin + window.location.pathname,
            referalpagetitle: document.title,
            pagenumber: educationSearchQueryPage,
            hostname: window.location.hostname,
            queryid: educationSearchQueryId,
            query: educationSearchQuery,
            browserlanguage: window.navigator.language
        };
        var c = $.extend({}, d, a);
        $.ajax({
            url: "/edusearchtrack?operation=" + b + "&isenglishsearch=" + educationSearchQueryIsEnglishSearch,
            type: "POST",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(c),
            timeout: 1000,
            complete: function () {
                if (f) {
                    f()
                }
            }
        })
    },
    searchStart: function (a) {
        $("#education-search-spinner").removeClass("d-none");
        if (a) {
            $(".edu-search-fade").fadeTo(suobj.utils.ANIMATION_SPEED, 0.5)
        }
    },
    searchEnd: function (a) {
        $("#education-search-spinner").addClass("d-none");
        if (a) {
            $(".edu-search-fade").fadeTo(suobj.utils.ANIMATION_SPEED, 1)
        }
    },
    showNumberOfHits: function () {
        var c = $(".education-search-list");
        var b = c.find(".education-search-result").attr("data-totalrow");
        var a = suobj.educationsearch.page * 20;
        $(".education-search-no-hits").html(b);
        if (a > b) {
            a = b
        }
        if (b > 20) {
            $(".education-search-no-hits-showing").html("1-" + a)
        } else {
            $(".education-search-no-hits-showing").html(a)
        }
    },
    showFixedQuery: function () {
        var b = $(".education-search-list");
        var a = b.find(".education-search-result").attr("data-fixedquery");
        if (a !== "") {
            $(".js-fixedquery-div").addClass("d-inline-block");
            $(".js-fixedquery").html(a)
        } else {
            $(".js-fixedquery-div").removeClass("d-inline-block")
        }
    },
    initAutoScroll: function () {
        var c = 700;
        var a = $("#search-result-information");
        var b = $("#education-search-query");
        b.focus(function () {
            var d = (a.offset().top - 5);
            suobj.educationsearch.scrollToSearch(d, c)
        })
    },
    scrollToSearch: function (b, a) {
        $("html, body").animate({scrollTop: b}, a)
    }
};
$(function () {
    var a = $("#education-search-query");
    if (a.length) {
        suobj.educationsearch.initAutoScroll();
        suobj.educationsearch.initSearchForm(a);
        window.onpageshow = function (b) {
            if (b.persisted) {
                suobj.educationsearch.initFiltersFromParams()
            }
        }
    }
});
var suobj = suobj || {};
suobj.megaMenu = {
    delay: 300, init: function () {
        $(".mega-menu-item").each(function () {
            var a = $(this);
            suobj.megaMenu.megaMenuItemElement(a)
        })
    }, open: function (a) {
        a.addClass("open");
        setTimeout(function () {
            a.addClass("is-open")
        }, 20)
    }, close: function (a) {
        a.removeClass("is-open");
        a.removeClass("open")
    }, megaMenuItemElement: function (a) {
        var c;
        var b = a.find(".mega-menu-collapse");
        a.on("mouseover", function () {
            clearTimeout(c);
            suobj.megaMenu.open(b)
        }).on("mouseleave", function () {
            c = setTimeout(function () {
                a.attr("style", "");
                suobj.megaMenu.close(b)
            }, suobj.megaMenu.delay)
        });
        b.on("click", 'a[href*="#"]', function () {
            suobj.megaMenu.close(b)
        })
    }
};
suobj.carousel = {
    getMode: function (g, f) {
        var a = f.find(".arrow-container");
        var c = f.find(".prev-arrow");
        var b = f.find(".next-arrow");
        var d = {
            mode1: {
                slidesToShow: 3,
                responsive: [{breakpoint: 768, settings: {slidesToShow: 1}}, {
                    breakpoint: 960,
                    settings: {slidesToShow: 2}
                }],
                appendArrows: a,
                prevArrow: c,
                nextArrow: b
            },
            mode2: {slidesToShow: 1, dots: true, dotsClass: "d-none", appendArrows: a, prevArrow: c, nextArrow: b},
            mode3: {
                slidesToShow: 1,
                dots: true,
                dotsClass: "slick-dots not-list-styled p-0",
                prevArrow: c,
                nextArrow: b
            },
            mode4: {
                slidesToShow: 3,
                responsive: [{breakpoint: 768, settings: {slidesToShow: 1}}, {
                    breakpoint: 1200,
                    settings: {slidesToShow: 2}
                }],
                dots: true,
                dotsClass: "slick-dots not-list-styled p-0",
                appendArrows: a,
                prevArrow: c,
                nextArrow: b
            }
        };
        return d[g]
    }, init: function () {
        $(".slick-carousel-slider-container").each(function () {
            var c = $(this);
            var d = c.attr("data-mode") || "mode1";
            var a = suobj.carousel.getMode(d, c);
            var b = c.find(".slick-paginator");
            c.on("init reInit afterChange", function (h, f, j) {
                if (!f.$dots) {
                    return
                }
                var g = (j ? j : 0) + 1;
                b.text(g + "/" + (f.$dots[0].children.length))
            });
            c.find(".slick-carousel-slider").slick(a)
        })
    }
};
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    suobj.collapseHandler.clickableArea($(".collapsible-item > div:first-child, .clickableArea"));
    suobj.collapseHandler.initCollapseHandling($(".su-js-has-toggle-btn"));
    suobj.collapseHandler.initCollapseHandling($(".ck-collapsible-section").find(".collapse"));
    if ("querySelector" in document && "addEventListener" in window) {
        $(".js-truncate").each(function () {
            suobj.utils.truncate($(this))
        })
    }
    $('#primaryHamburgerCollapse a[href*="#"]').click(function (k) {
        $("#primaryHamburgerCollapse").collapse("hide")
    });
    var j = function (k) {
        k.find(".js-show-more").removeClass("d-none");
        if (!k.find(".article-list-item.d-none").length) {
            k.find(".js-show-more").addClass("d-none")
        }
    };
    var h = function () {
        var k = $(".js-article-list");
        k.on("click", ".js-show-more", function (n) {
            n.preventDefault();
            var m = $(this).closest(".js-article-list");
            var l = parseInt(m.attr("data-count"), 10);
            var o = m.find(".article-list-item.d-none");
            if (isNaN(l, 10)) {
                return
            }
            o.slice(0, l).removeClass("d-none").first().find("a").focus();
            j(m)
        });
        k.each(function () {
            j($(this))
        })
    };
    h();
    var f = function () {
        var k = suobj.utils.getParams(window.location.href);
        if (k) {
            suobj.collapseHandler.initFromParameters(k)
        }
    };
    f();
    $(".js-simple-article-container").each(function (k, n) {
        var m = $(this);
        var l = m.attr("data-contentid");
        $.ajax({
            url: "/cmlink/" + l + "?d=" + new Date().getTime(), success: function (p) {
                m.html(p);
                var o = "#" + m.find(".collapse").attr("id");
                suobj.collapseHandler.initCollapseHandling($(o));
                suobj.collapseHandler.clickableArea(m.find(".clickableArea"))
            }, error: function (o) {
                m.remove()
            }
        })
    });
    $(".js-find-link-and-create-click-area").on("click", function (k) {
        k.preventDefault();
        location.href = $(this).find("a").first().attr("href")
    });
    var d = function (n) {
        var m = $("#main-header.fixed-top");
        var l = $(".education-info-shortcut-bar");
        var k;
        var o;
        if (!m.length || !l.length) {
            return
        }
        k = m.height();
        o = $(window).scrollTop();
        o -= $("body").offset().top;
        if (o > k || n) {
            l.addClass("locked-to-header").css({top: k + "px"})
        } else {
            l.removeClass("locked-to-header").css({top: "0"})
        }
    };
    var g = function () {
        var l = $(".education-info-shortcut-bar");
        var m = false;
        var k = false;
        if (!l.length) {
            return
        }
        $(window).scroll(function () {
            m = true
        });
        $(window).resize(function () {
            k = true
        });
        setInterval(function () {
            if (m || k) {
                if (m) {
                    m = false
                }
                if (k) {
                    k = false
                }
                d()
            }
        }, 100);
        d();
        l.on("click", ".js-anchor-link", function () {
            d(true)
        })
    };
    g();
    var b = function (n) {
        var k = n.concat();
        for (var m = 0; m < k.length; ++m) {
            for (var l = m + 1; l < k.length; ++l) {
                if (k[m] === k[l]) {
                    k.splice(l--, 1)
                }
            }
        }
        return k
    };
    var c = function (l, o, p) {
        var k = l.find(".article-list-item");
        var m = l.find(".js-article-list-filters");
        var n = l.find(".js-article-list-sub-filters");
        n.addClass("d-none");
        n.find('button[aria-pressed="true"]').attr("aria-pressed", false);
        m.find('button[aria-pressed="true"]').attr("aria-pressed", false);
        if (!o.length) {
            k.removeClass("d-none")
        } else {
            k.addClass("d-none");
            n.removeClass("d-none");
            n.find("button").addClass("d-none");
            n.find('button[data-category="' + o + '"]').removeClass("d-none");
            if (!p || !p.length) {
                k.filter('[data-categories*="' + o + '"]').removeClass("d-none");
                m.find('button[data-category="' + o + '"]').attr("aria-pressed", true)
            } else {
                k.filter('[data-subcategories*="' + p + '"]').removeClass("d-none");
                n.find('button[data-subcategory="' + p + '"]').attr("aria-pressed", true);
                m.find('button[data-category="' + o + '"]').attr("aria-pressed", true)
            }
        }
    };
    var a = function (l) {
        var k = l.find(".article-list-item");
        var m = [];
        var n = l.find(".js-article-list-filters");
        var o = l.find(".js-article-list-sub-filters");
        k.filter(".d-none").removeClass("d-none");
        k.each(function () {
            var s = $(this);
            var r = s.attr("data-categories");
            var q = s.attr("data-subcategories");
            var p = [];
            if (r && r.length) {
                p = r.split("|");
                m = b(m.concat(p))
            }
            if (q && q.length) {
                p = q.split("|");
                m = b(m.concat(p))
            }
        });
        $.each(m, function (r, q) {
            var p = [];
            if (q.indexOf("/") > 0) {
                p = q.split("/");
                o.append('<button aria-pressed="false" data-category="' + p[0] + '" data-subcategory="' + q + '" class="my-1 button-rounded-border button-rounded-smaller button-ghost d-none mr-3 text-decoration-none">' + p[1] + "</button>")
            } else {
                n.append('<button aria-pressed="false" data-category="' + q + '" class="my-1 button-rounded-border button-rounded-smaller button-ghost d-inline-block mr-3 text-decoration-none">' + q + "</button>")
            }
        });
        n.on("click", "button", function () {
            var p = $(this);
            if (p.attr("aria-pressed") === "true") {
                c(l, "", "")
            } else {
                c(l, p.attr("data-category"), "")
            }
        });
        o.on("click", "button", function () {
            var p = $(this);
            if (p.attr("aria-pressed") === "true") {
                c(l, p.attr("data-category"), "")
            } else {
                c(l, p.attr("data-category"), p.attr("data-subcategory"))
            }
        })
    };
    $(".js-article-list-use-filters").each(function () {
        a($(this))
    });
    $(".js-select-tabs-list a:first").tab("show");
    suobj.megaMenu.init();
    suobj.carousel.init()
});
$(function () {
    window.initScreen9Video = function c(k) {
        var j, f, h, d, g, l;
        j = k.val();
        if (!j || !j.length) {
            return
        } else {
            screen9_ajax_auth = $(".screen9_ajax_auth_token").val();
            f = "thumb_wrapper_" + j;
            h = "play_overlay_" + j;
            d = document.getElementById("screen9_selected_mediaid_" + j);
            if (!d) {
                return
            }
            g = d.value;
            if (!g) {
                return
            }
            l = document.getElementById("screen9_video_player_" + j);
            if (!l) {
                return
            }
            $("#" + h).hide();
            l.innerHTML += '<div style="width: 100%;" id="id_' + g + '"></div>';
            if (typeof screen9.api === "undefined") {
                return
            }
            if ($(l).parents(".promotion").length === 1) {
                $("#screen9_video_player_" + j).closest(".smart-video-element").css("height", "280px");
                screen9.api.embed({mediaid: g, containerid: "id_" + g, width: " ", height: 280}, function (m) {
                    a(m.player, j);
                    b(m.player, l)
                })
            } else {
                screen9.api.embed({mediaid: g, containerid: "id_" + g}, function (m) {
                    a(m.player, j);
                    b(m.player, l)
                })
            }
        }
    };

    function b(d) {
        let $prevButton = $(".visual-story-container button.prev-arrow.slick-arrow");
        let $nextButton = $(".visual-story-container button.next-arrow.slick-arrow");
        $nextButton.on("click", function () {
            d.stop()
        });
        $prevButton.on("click", function () {
            d.stop()
        })
    }

    function a(h, g) {
        var d, f, k, j;
        d = "thumb_wrapper_" + g;
        f = "play_overlay_" + g;
        k = $("#" + d);
        if (!k.length) {
            return
        }
        k.on("click", function () {
            h.stop();
            h.toggle()
        });
        k.on("keypress", function (l) {
            if (l.which === 13 || l.which === 32) {
                h.stop();
                h.toggle()
            }
        });
        j = $("#" + f);
        j.on("click", function () {
            h.stop();
            h.toggle()
        });
        $("#" + d).on("click", function () {
            $("#" + d).hide();
            $("#" + f).hide()
        });
        $("#" + f).on("click", function () {
            $("#" + d).hide();
            $("#" + f).hide()
        });
        k.on("keypress", function (l) {
            if (l.which === 13 || l.which === 32) {
                $("#" + d).hide();
                $("#" + f).hide()
            }
        });
        $("#" + f).show()
    }

    $("input.screen9_video_initializer").each(function () {
        window.initScreen9Video($(this))
    })
});
$(document).ready(function () {
    $(".smart-video-placeholder").each(function (d) {
        var b = $(this);
        var c = b.attr("data-content-id");
        var a = "/cmlink/" + c;
        $.ajax({
            dataType: "html", data: {isAjaxCall: "true"}, url: a, success: function (f) {
                b.replaceWith(f)
            }
        })
    })
});
$(function () {
    var o = $.Deferred();
    var a = false;
    var b = false;
    var k = [];
    var g = 280;
    window.initYoutubeVideo = function l(u) {
        var t = u.val();
        if (!t || !t.length) {
            return
        }
        var s = n(t);
        if (!s) {
            return
        }
        var v = document.getElementById("youtube_video_player_" + t);
        if (!v) {
            return
        }
        var r = p(t);
        j(!r, t);
        var w = -1;
        if ($(v).parents(".promotion").length) {
            $("#youtube_video_player_" + t).closest(".smart-video-element").css("height", g + "px");
            w = g
        } else {
            $("#youtube_video_player_wrapper_" + t).addClass("youtube-aspect-ratio")
        }
        m(t, s, r, w);
        if (!a && !b) {
            a = true;
            d()
        } else {
            if (!a && b) {
                h()
            }
        }
    };
    $("input.youtube_video_initializer").each(function () {
        window.initYoutubeVideo($(this))
    });

    function m(t, s, r, u) {
        var v = {
            contentId: t, mediaId: s, playerHeight: u, onReady: function (w) {
                c(w.target, t, r)
            }
        };
        k.push(v)
    }

    function n(s) {
        var r = document.getElementById("youtube_selected_mediaid_" + s);
        if (!r) {
            return null
        }
        return r.value
    }

    function d() {
        var r = document.createElement("script");
        r.src = "https://www.youtube.com/iframe_api";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(r, s)
    }

    window.onYouTubeIframeAPIReady = function () {
        o.resolve()
    };

    function h() {
        var s = null;
        for (var r = 0; r < k.length; r++) {
            s = k[r];
            if (s.playerHeight && s.playerHeight > 0) {
                new window.YT.Player("youtube_video_player_" + s.contentId, {
                    width: "100%",
                    height: s.playerHeight + "px",
                    playerVars: {rel: 0},
                    enablejsapi: 1,
                    videoId: s.mediaId,
                    events: {onReady: s.onReady}
                })
            } else {
                new window.YT.Player("youtube_video_player_" + s.contentId, {
                    videoId: s.mediaId,
                    width: "100%",
                    height: "100%",
                    playerVars: {rel: 0},
                    enablejsapi: 1,
                    events: {onReady: s.onReady}
                })
            }
        }
        k.length = 0
    }

    $(".thumb-wrapper").on("keypress", function (r) {
        if (r.which === 13) {
            $(this).trigger("click")
        }
    });

    function c(u, t, r) {
        q(u);
        if (r) {
            const s = $("#thumb_wrapper_" + t);
            s.click(function () {
                f(u, t)
            });
            s.on("keypress", function (v) {
                if (v.which === 13 || v.which === 32) {
                    f(u, t)
                }
            });
            $("#play_overlay_" + t).click(function () {
                f(u, t)
            })
        } else {
            j(true, t)
        }
    }

    function f(s, r) {
        j(true, r);
        s.playVideo()
    }

    function q(r) {
        let $prevButton = $(".visual-story-container button.prev-arrow.slick-arrow");
        let $nextButton = $(".visual-story-container button.next-arrow.slick-arrow");
        $nextButton.on("click", function () {
            r.stopVideo()
        });
        $prevButton.on("click", function () {
            r.stopVideo()
        })
    }

    function j(r, s) {
        if (r) {
            $("youtube_video_player_wrapper_" + s).css({visibility: "visible"});
            $("#youtube_video_player_" + s).css({visibility: "visible"});
            $("#thumb_wrapper_" + s).hide();
            $("#play_overlay_wrapper_" + s).hide()
        } else {
            $("youtube_video_player_wrapper_" + s).css({visibility: "hidden"});
            $("#youtube_video_player_" + s).css({visibility: "hidden"});
            $("#thumb_wrapper_" + s).show();
            $("#play_overlay_wrapper_" + s).show()
        }
    }

    function p(r) {
        var s = document.getElementById("play_thm_" + r);
        if (s) {
            return true
        }
        return false
    }

    o.done(function () {
        b = true;
        h();
        a = false
    })
});
var suobj = suobj || {};
suobj.collapseHandler = {
    openCollapseBoxes: [], firefoxFixed: false, initCollapseHandling: function (a) {
        a.on("hidden.bs.collapse", function (c) {
            var b = $(this);
            c.stopPropagation();
            b.parent().find(".su-js-toggle-btn").filter(":first").attr("aria-pressed", "false");
            if (b.hasClass("track-collapse-state") || b.hasClass("collapsible-item-collapse")) {
                suobj.collapseHandler.closeBox(b.attr("id"))
            }
        }).on("shown.bs.collapse", function (c) {
            var b = $(this);
            c.stopPropagation();
            b.parent().find(".su-js-toggle-btn").filter(":first").attr("aria-pressed", "true");
            if (b.hasClass("track-collapse-state") || b.hasClass("collapsible-item-collapse")) {
                suobj.collapseHandler.openBox(b.attr("id"))
            }
        })
    }, clickableArea: function (a) {
        a.on("click", function () {
            var b = $(this).parent().find(".collapse").first();
            if (b.hasClass("show", "collapsing")) {
                b.collapse("hide")
            } else {
                b.collapse("show")
            }
        })
    }, replaceState: function () {
        if (!this.firefoxFixed) {
            window.onunload = function () {
            };
            this.firefoxFixed = true
        }
        suobj.utils.pushToParams("open-collapse-boxes", this.openCollapseBoxes.join(","))
    }, openBox: function (a) {
        this.pushToArray(a);
        this.replaceState()
    }, closeBox: function (a) {
        this.popFromArray(a);
        this.replaceState()
    }, pushToArray: function (a) {
        this.popFromArray(a);
        this.openCollapseBoxes.push(a)
    }, popFromArray: function (b) {
        var a = this.openCollapseBoxes.indexOf(b);
        this.openCollapseBoxes.indexOf(b);
        if (a > -1) {
            this.openCollapseBoxes.splice(a, 1)
        }
    }, initFromParameters: function (c) {
        var b;
        if (c["open-collapse-boxes"] && c["open-collapse-boxes"].length) {
            this.openCollapseBoxes = c["open-collapse-boxes"][0].split(",")
        } else {
            return
        }
        b = this.openCollapseBoxes[this.openCollapseBoxes.length - 1];
        for (var a = 0; a < this.openCollapseBoxes.length; a++) {
            $('[id="' + this.openCollapseBoxes[a] + '"]').addClass("override-transition").collapse("show")
        }
        setTimeout(function () {
            $(".override-transition").removeClass("override-transition")
        }, 100)
    }
};
var suobj = suobj || {};
suobj.imagelightbox = {
    init: function () {
        const f = "rgba(0, 38, 76, 0.8)";
        const b = 0.08;
        const d = "999999";
        let vopa_img_box, idpopup_img_box;
        const c = document.createElement("div");
        c.id = "image_lightbox";
        document.getElementsByTagName("body")[0].appendChild(c);
        idpopup_img_box = document.getElementById("image_lightbox");
        idpopup_img_box.style.top = 0;
        idpopup_img_box.style.left = 0;
        idpopup_img_box.style.opacity = 0;
        idpopup_img_box.style.width = "100%";
        idpopup_img_box.style.height = "100%";
        idpopup_img_box.style.display = "none";
        idpopup_img_box.style.position = "fixed";
        idpopup_img_box.style.cursor = "pointer";
        idpopup_img_box.style.textAlign = "center";
        idpopup_img_box.style.zIndex = d;
        idpopup_img_box.style.backgroundColor = f;
        $(".js-lightbox-image").on("click", function () {
            a(this)
        });

        function a(g) {
            const h = typeof g === "string" ? g : g.src;
            vopa_img_box = 0;
            let hwin_img_box = window.innerHeight;
            let wwin_img_box = window.innerWidth;
            let himg_img_box, padtop_img_box, idfadein_img_box;
            let img_img_box = new Image();
            img_img_box.src = h;
            img_img_box.onload = function () {
                himg_img_box = img_img_box.height;
                wimg_img_box = img_img_box.width;
                idpopup_img_box.innerHTML = "<img src=" + h + ">";
                if (wimg_img_box > wwin_img_box) {
                    idpopup_img_box.getElementsByTagName("img")[0].style.width = "90%"
                } else {
                    if (himg_img_box > hwin_img_box) {
                        idpopup_img_box.getElementsByTagName("img")[0].style.height = "90%";
                        himg_img_box = hwin_img_box * 90 / 100
                    }
                }
                if (himg_img_box < hwin_img_box) {
                    padtop_img_box = (hwin_img_box / 2) - (himg_img_box / 2);
                    idpopup_img_box.style.paddingTop = padtop_img_box + "px"
                } else {
                    idpopup_img_box.style.paddingTop = "0px"
                }
                idpopup_img_box.style.display = "block"
            };
            idfadein_img_box = setInterval(function () {
                if (vopa_img_box <= 1.1) {
                    idpopup_img_box.style.opacity = vopa_img_box;
                    vopa_img_box += b
                } else {
                    idpopup_img_box.style.opacity = 1;
                    clearInterval(idfadein_img_box)
                }
            }, 10);
            idpopup_img_box.onclick = function () {
                const j = setInterval(function () {
                    if (vopa_img_box >= 0) {
                        idpopup_img_box.style.opacity = vopa_img_box;
                        vopa_img_box -= b
                    } else {
                        idpopup_img_box.style.opacity = 0;
                        clearInterval(j);
                        idpopup_img_box.style.display = "none";
                        idpopup_img_box.innerHTML = "";
                        vopa_img_box = 0
                    }
                }, 10)
            }
        }
    }
};
$(function () {
    if ($(".js-lightbox-image").length) {
        suobj.imagelightbox.init()
    }
});
!function (d, c) {
    "object" == typeof exports && "object" == typeof module ? module.exports = c() : "function" == typeof define && define.amd ? define([], c) : "object" == typeof exports ? exports.jwplayer = c() : d.jwplayer = c()
}(this, function () {
    return function (g) {
        function f(b) {
            if (j[b]) {
                return j[b].exports
            }
            var a = j[b] = {exports: {}, id: b, loaded: !1};
            return g[b].call(a.exports, a, a.exports, f), a.loaded = !0, a.exports
        }

        var k = window.webpackJsonpjwplayer;
        window.webpackJsonpjwplayer = function (n, m) {
            for (var l, c, b = 0, a = []; b < n.length; b++) {
                c = n[b], h[c] && a.push.apply(a, h[c]), h[c] = 0
            }
            for (l in m) {
                g[l] = m[l]
            }
            for (k && k(n, m); a.length;) {
                a.shift().call(null, f)
            }
        };
        var j = {}, h = {0: 0};
        return f.e = function (b, n) {
            if (0 === h[b]) {
                return n.call(null, f)
            }
            if (void 0 !== h[b]) {
                h[b].push(n)
            } else {
                h[b] = [n];
                var m = document.getElementsByTagName("head")[0], l = document.createElement("script");
                l.type = "text/javascript", l.charset = "utf-8", l.async = !0, l.src = f.p + "" + ({
                    1: "polyfills.promise",
                    2: "polyfills.base64",
                    3: "provider.youtube",
                    4: "provider.dashjs",
                    5: "provider.shaka",
                    6: "provider.cast"
                }[b] || b) + ".js", m.appendChild(l)
            }
        }, f.m = g, f.c = j, f.p = "", f(0)
    }([function (f, d, g) {
        f.exports = g(40)
    }, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , function (g, f, k) {
        var j, h;
        j = [k(41), k(174), k(45)], h = function (l, d, m) {
            return window.jwplayer ? window.jwplayer : m.extend(l, d)
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(42), k(48), k(168)], h = function (d, c) {
            return k.p = c.loadFrom(), d.selectPlayer
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(43), k(98), k(45)], h = function (m, l, p) {
            var o = m.selectPlayer, n = function () {
                var b = o.apply(this, arguments);
                return b ? b : {
                    registerPlugin: function (q, s, r) {
                        "jwpsrv" !== q && l.registerPlugin(q, s, r)
                    }
                }
            };
            return p.extend(m, {selectPlayer: n})
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(44), k(45), k(86), k(84), k(80), k(98)], h = function (B, A, z, y, x, w) {
            function v(b) {
                var d = b.getName().name;
                if (!A.find(x, A.matches({name: d}))) {
                    if (!A.isFunction(b.supports)) {
                        throw {message: "Tried to register a provider with an invalid object"}
                    }
                    x.unshift({name: d, supports: b.supports})
                }
                var c = function () {
                };
                c.prototype = z, b.prototype = new c, y[d] = b
            }

            var u = [], t = 0, s = function (a) {
                var m, l;
                return a ? "string" == typeof a ? (m = r(a), m || (l = document.getElementById(a))) : "number" == typeof a ? m = u[a] : a.nodeType && (l = a, m = r(l.id)) : m = u[0], m ? m : l ? q(new B(l, p)) : {registerPlugin: w.registerPlugin}
            }, r = function (d) {
                for (var c = 0; c < u.length; c++) {
                    if (u[c].id === d) {
                        return u[c]
                    }
                }
                return null
            }, q = function (b) {
                return t++, b.uniqueId = t, u.push(b), b
            }, p = function (d) {
                for (var c = u.length; c--;) {
                    if (u[c].uniqueId === d.uniqueId) {
                        u.splice(c, 1);
                        break
                    }
                }
            }, o = {selectPlayer: s, registerProvider: v, availableProviders: x, registerPlugin: w.registerPlugin};
            return s.api = o, o
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(46), k(62), k(47), k(48), k(61), k(60), k(45), k(63), k(165), k(166), k(167), k(59)], h = function (z, y, x, w, v, u, t, s, r, q, p, o) {
            var n = function (B, A) {
                var l, d = this, c = !1, b = {};
                t.extend(this, x), this.utils = w, this._ = t, this.Events = x, this.version = o, this.trigger = function (E, m) {
                    return m = t.isObject(m) ? t.extend({}, m) : {}, m.type = E, window.jwplayer && window.jwplayer.debug ? x.trigger.call(d, E, m) : x.triggerSafe.call(d, E, m)
                }, this.dispatchEvent = this.trigger, this.removeEventListener = this.off.bind(this);
                var a = function () {
                    l = new s(B), r(d, l), q(d, l), l.on(z.JWPLAYER_PLAYLIST_ITEM, function () {
                        b = {}
                    }), l.on(z.JWPLAYER_MEDIA_META, function (m) {
                        t.extend(b, m.metadata)
                    }), l.on(z.JWPLAYER_READY, function (m) {
                        c = !0, D.tick("ready"), m.setupTime = D.between("setup", "ready")
                    }), l.on("all", d.trigger)
                };
                a(), p(this), this.id = B.id;
                var D = this._qoe = new v;
                D.tick("init");
                var C = function () {
                    c = !1, b = {}, d.off(), l && l.off(), l && l.playerDestroy && l.playerDestroy()
                };
                return this.getPlugin = function (m) {
                    return d.plugins && d.plugins[m]
                }, this.addPlugin = function (E, m) {
                    this.plugins = this.plugins || {}, this.plugins[E] = m, this.onReady(m.addToPlayer), m.resize && this.onResize(m.resizeHandler)
                }, this.setup = function (m) {
                    return D.tick("setup"), C(), a(), w.foreach(m.events, function (F, E) {
                        var G = d[F];
                        "function" == typeof G && G.call(d, E)
                    }), m.id = d.id, l.setup(m, this), d
                }, this.qoe = function () {
                    var m = l.getItemQoe(), F = D.between("setup", "ready"),
                        E = m.between(z.JWPLAYER_MEDIA_PLAY_ATTEMPT, z.JWPLAYER_MEDIA_FIRST_FRAME);
                    return {setupTime: F, firstFrame: E, player: D.dump(), item: m.dump()}
                }, this.getContainer = function () {
                    return l.getContainer ? l.getContainer() : B
                }, this.getMeta = this.getItemMeta = function () {
                    return b
                }, this.getPlaylistItem = function (E) {
                    if (!w.exists(E)) {
                        return l._model.get("playlistItem")
                    }
                    var m = d.getPlaylist();
                    return m ? m[E] : null
                }, this.getRenderingMode = function () {
                    return "html5"
                }, this.load = function (E) {
                    var m = this.getPlugin("vast") || this.getPlugin("googima");
                    return m && m.destroy(), l.load(E), d
                }, this.play = function (m, E) {
                    if (t.isBoolean(m) || (E = m), E || (E = {reason: "external"}), m === !0) {
                        return l.play(E), d
                    }
                    if (m === !1) {
                        return l.pause(), d
                    }
                    switch (m = d.getState()) {
                        case y.PLAYING:
                        case y.BUFFERING:
                            l.pause();
                            break;
                        default:
                            l.play(E)
                    }
                    return d
                }, this.pause = function (m) {
                    return t.isBoolean(m) ? this.play(!m) : this.play()
                }, this.createInstream = function () {
                    return l.createInstream()
                }, this.castToggle = function () {
                    l && l.castToggle && l.castToggle()
                }, this.playAd = this.pauseAd = w.noop, this.remove = function () {
                    return A(d), d.trigger("remove"), C(), d
                }, this
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            var X = {}, W = Array.prototype, V = Object.prototype, U = Function.prototype, T = W.slice, S = W.concat,
                R = V.toString, Q = V.hasOwnProperty, P = W.map, O = W.reduce, N = W.forEach, M = W.filter, L = W.every,
                K = W.some, J = W.indexOf, I = Array.isArray, H = Object.keys, G = U.bind, F = function (b) {
                    return b instanceof F ? b : this instanceof F ? void 0 : new F(b)
                }, E = F.each = F.forEach = function (a, p, o) {
                    if (null == a) {
                        return a
                    }
                    if (N && a.forEach === N) {
                        a.forEach(p, o)
                    } else {
                        if (a.length === +a.length) {
                            for (var n = 0, m = a.length; m > n; n++) {
                                if (p.call(o, a[n], n, a) === X) {
                                    return
                                }
                            }
                        } else {
                            for (var l = F.keys(a), n = 0, m = l.length; m > n; n++) {
                                if (p.call(o, a[l[n]], l[n], a) === X) {
                                    return
                                }
                            }
                        }
                    }
                    return a
                };
            F.map = F.collect = function (m, l, o) {
                var n = [];
                return null == m ? n : P && m.map === P ? m.map(l, o) : (E(m, function (b, d, c) {
                    n.push(l.call(o, b, d, c))
                }), n)
            };
            var D = "Reduce of empty array with no initial value";
            F.reduce = F.foldl = F.inject = function (m, l, p, o) {
                var n = arguments.length > 2;
                if (null == m && (m = []), O && m.reduce === O) {
                    return o && (l = F.bind(l, o)), n ? m.reduce(l, p) : m.reduce(l)
                }
                if (E(m, function (b, d, c) {
                    n ? p = l.call(o, p, b, d, c) : (p = b, n = !0)
                }), !n) {
                    throw new TypeError(D)
                }
                return p
            }, F.find = F.detect = function (m, l, o) {
                var n;
                return C(m, function (b, d, c) {
                    return l.call(o, b, d, c) ? (n = b, !0) : void 0
                }), n
            }, F.filter = F.select = function (m, l, o) {
                var n = [];
                return null == m ? n : M && m.filter === M ? m.filter(l, o) : (E(m, function (b, d, c) {
                    l.call(o, b, d, c) && n.push(b)
                }), n)
            }, F.reject = function (l, d, m) {
                return F.filter(l, function (b, n, c) {
                    return !d.call(m, b, n, c)
                }, m)
            }, F.compact = function (b) {
                return F.filter(b, F.identity)
            }, F.every = F.all = function (a, n, m) {
                n || (n = F.identity);
                var l = !0;
                return null == a ? l : L && a.every === L ? a.every(n, m) : (E(a, function (c, o, d) {
                    return (l = l && n.call(m, c, o, d)) ? void 0 : X
                }), !!l)
            };
            var C = F.some = F.any = function (a, n, m) {
                n || (n = F.identity);
                var l = !1;
                return null == a ? l : K && a.some === K ? a.some(n, m) : (E(a, function (c, o, d) {
                    return l || (l = n.call(m, c, o, d)) ? X : void 0
                }), !!l)
            };
            F.size = function (b) {
                return null == b ? 0 : b.length === +b.length ? b.length : F.keys(b).length
            }, F.after = function (d, c) {
                return function () {
                    return --d < 1 ? c.apply(this, arguments) : void 0
                }
            }, F.before = function (l, d) {
                var m;
                return function () {
                    return --l > 0 && (m = d.apply(this, arguments)), 1 >= l && (d = null), m
                }
            };
            var B = function (b) {
                return null == b ? F.identity : F.isFunction(b) ? b : F.property(b)
            };
            F.sortedIndex = function (m, l, s, r) {
                s = B(s);
                for (var q = s.call(r, l), p = 0, o = m.length; o > p;) {
                    var n = p + o >>> 1;
                    s.call(r, m[n]) < q ? p = n + 1 : o = n
                }
                return p
            };
            var C = F.some = F.any = function (a, n, m) {
                n || (n = F.identity);
                var l = !1;
                return null == a ? l : K && a.some === K ? a.some(n, m) : (E(a, function (c, o, d) {
                    return l || (l = n.call(m, c, o, d)) ? X : void 0
                }), !!l)
            };
            F.contains = F.include = function (d, c) {
                return null == d ? !1 : (d.length !== +d.length && (d = F.values(d)), F.indexOf(d, c) >= 0)
            }, F.where = function (d, c) {
                return F.filter(d, F.matches(c))
            }, F.findWhere = function (d, c) {
                return F.find(d, F.matches(c))
            }, F.max = function (m, l, p) {
                if (!l && F.isArray(m) && m[0] === +m[0] && m.length < 65535) {
                    return Math.max.apply(Math, m)
                }
                var o = -(1 / 0), n = -(1 / 0);
                return E(m, function (b, q, d) {
                    var c = l ? l.call(p, b, q, d) : b;
                    c > n && (o = b, n = c)
                }), o
            }, F.difference = function (b) {
                var d = S.apply(W, T.call(arguments, 1));
                return F.filter(b, function (c) {
                    return !F.contains(d, c)
                })
            }, F.without = function (b) {
                return F.difference(b, T.call(arguments, 1))
            }, F.indexOf = function (m, l, p) {
                if (null == m) {
                    return -1
                }
                var o = 0, n = m.length;
                if (p) {
                    if ("number" != typeof p) {
                        return o = F.sortedIndex(m, l), m[o] === l ? o : -1
                    }
                    o = 0 > p ? Math.max(0, n + p) : p
                }
                if (J && m.indexOf === J) {
                    return m.indexOf(l, p)
                }
                for (; n > o; o++) {
                    if (m[o] === l) {
                        return o
                    }
                }
                return -1
            };
            var A = function () {
            };
            F.bind = function (m, l) {
                var o, n;
                if (G && m.bind === G) {
                    return G.apply(m, T.call(arguments, 1))
                }
                if (!F.isFunction(m)) {
                    throw new TypeError
                }
                return o = T.call(arguments, 2), n = function () {
                    if (!(this instanceof n)) {
                        return m.apply(l, o.concat(T.call(arguments)))
                    }
                    A.prototype = m.prototype;
                    var b = new A;
                    A.prototype = null;
                    var a = m.apply(b, o.concat(T.call(arguments)));
                    return Object(a) === a ? a : b
                }
            }, F.partial = function (d) {
                var c = T.call(arguments, 1);
                return function () {
                    for (var m = 0, l = c.slice(), b = 0, a = l.length; a > b; b++) {
                        l[b] === F && (l[b] = arguments[m++])
                    }
                    for (; m < arguments.length;) {
                        l.push(arguments[m++])
                    }
                    return d.apply(this, l)
                }
            }, F.once = F.partial(F.before, 2), F.memoize = function (l, d) {
                var m = {};
                return d || (d = F.identity), function () {
                    var a = d.apply(this, arguments);
                    return F.has(m, a) ? m[a] : m[a] = l.apply(this, arguments)
                }
            }, F.delay = function (l, d) {
                var m = T.call(arguments, 2);
                return setTimeout(function () {
                    return l.apply(null, m)
                }, d)
            }, F.defer = function (b) {
                return F.delay.apply(F, [b, 1].concat(T.call(arguments, 1)))
            }, F.throttle = function (t, s, r) {
                var q, p, o, n = null, m = 0;
                r || (r = {});
                var l = function () {
                    m = r.leading === !1 ? 0 : F.now(), n = null, o = t.apply(q, p), q = p = null
                };
                return function () {
                    var b = F.now();
                    m || r.leading !== !1 || (m = b);
                    var a = s - (b - m);
                    return q = this, p = arguments, 0 >= a ? (clearTimeout(n), n = null, m = b, o = t.apply(q, p), q = p = null) : n || r.trailing === !1 || (n = setTimeout(l, a)), o
                }
            }, F.keys = function (l) {
                if (!F.isObject(l)) {
                    return []
                }
                if (H) {
                    return H(l)
                }
                var d = [];
                for (var m in l) {
                    F.has(l, m) && d.push(m)
                }
                return d
            }, F.invert = function (m) {
                for (var l = {}, p = F.keys(m), o = 0, n = p.length; n > o; o++) {
                    l[m[p[o]]] = p[o]
                }
                return l
            }, F.defaults = function (b) {
                return E(T.call(arguments, 1), function (a) {
                    if (a) {
                        for (var d in a) {
                            void 0 === b[d] && (b[d] = a[d])
                        }
                    }
                }), b
            }, F.extend = function (b) {
                return E(T.call(arguments, 1), function (a) {
                    if (a) {
                        for (var d in a) {
                            b[d] = a[d]
                        }
                    }
                }), b
            }, F.pick = function (b) {
                var m = {}, l = S.apply(W, T.call(arguments, 1));
                return E(l, function (a) {
                    a in b && (m[a] = b[a])
                }), m
            }, F.omit = function (b) {
                var n = {}, m = S.apply(W, T.call(arguments, 1));
                for (var l in b) {
                    F.contains(m, l) || (n[l] = b[l])
                }
                return n
            }, F.clone = function (b) {
                return F.isObject(b) ? F.isArray(b) ? b.slice() : F.extend({}, b) : b
            }, F.isArray = I || function (b) {
                return "[object Array]" == R.call(b)
            }, F.isObject = function (b) {
                return b === Object(b)
            }, E(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function (b) {
                F["is" + b] = function (a) {
                    return R.call(a) == "[object " + b + "]"
                }
            }), F.isArguments(arguments) || (F.isArguments = function (b) {
                return !(!b || !F.has(b, "callee"))
            }), F.isFunction = function (b) {
                return "function" == typeof b
            }, F.isFinite = function (b) {
                return isFinite(b) && !isNaN(parseFloat(b))
            }, F.isNaN = function (b) {
                return F.isNumber(b) && b != +b
            }, F.isBoolean = function (b) {
                return b === !0 || b === !1 || "[object Boolean]" == R.call(b)
            }, F.isNull = function (b) {
                return null === b
            }, F.isUndefined = function (b) {
                return void 0 === b
            }, F.has = function (d, c) {
                return Q.call(d, c)
            }, F.identity = function (b) {
                return b
            }, F.constant = function (b) {
                return function () {
                    return b
                }
            }, F.property = function (b) {
                return function (a) {
                    return a[b]
                }
            }, F.propertyOf = function (b) {
                return null == b ? function () {
                } : function (a) {
                    return b[a]
                }
            }, F.matches = function (b) {
                return function (a) {
                    if (a === b) {
                        return !0
                    }
                    for (var d in b) {
                        if (b[d] !== a[d]) {
                            return !1
                        }
                    }
                    return !0
                }
            }, F.now = Date.now || function () {
                return (new Date).getTime()
            }, F.result = function (l, d) {
                if (null != l) {
                    var m = l[d];
                    return F.isFunction(m) ? m.call(l) : m
                }
            };
            var z = 0;
            return F.uniqueId = function (d) {
                var c = ++z + "";
                return d ? d + c : c
            }, F
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            var d = {
                DRAG: "drag",
                DRAG_START: "dragStart",
                DRAG_END: "dragEnd",
                CLICK: "click",
                DOUBLE_CLICK: "doubleClick",
                TAP: "tap",
                DOUBLE_TAP: "doubleTap",
                OVER: "over",
                MOVE: "move",
                OUT: "out"
            }, c = {
                COMPLETE: "complete",
                ERROR: "error",
                JWPLAYER_AD_CLICK: "adClick",
                JWPLAYER_AD_COMPANIONS: "adCompanions",
                JWPLAYER_AD_COMPLETE: "adComplete",
                JWPLAYER_AD_ERROR: "adError",
                JWPLAYER_AD_IMPRESSION: "adImpression",
                JWPLAYER_AD_META: "adMeta",
                JWPLAYER_AD_PAUSE: "adPause",
                JWPLAYER_AD_PLAY: "adPlay",
                JWPLAYER_AD_SKIPPED: "adSkipped",
                JWPLAYER_AD_TIME: "adTime",
                JWPLAYER_CAST_AD_CHANGED: "castAdChanged",
                JWPLAYER_MEDIA_COMPLETE: "complete",
                JWPLAYER_READY: "ready",
                JWPLAYER_MEDIA_SEEK: "seek",
                JWPLAYER_MEDIA_BEFOREPLAY: "beforePlay",
                JWPLAYER_MEDIA_BEFORECOMPLETE: "beforeComplete",
                JWPLAYER_MEDIA_BUFFER_FULL: "bufferFull",
                JWPLAYER_DISPLAY_CLICK: "displayClick",
                JWPLAYER_PLAYLIST_COMPLETE: "playlistComplete",
                JWPLAYER_CAST_SESSION: "cast",
                JWPLAYER_MEDIA_ERROR: "mediaError",
                JWPLAYER_MEDIA_FIRST_FRAME: "firstFrame",
                JWPLAYER_MEDIA_PLAY_ATTEMPT: "playAttempt",
                JWPLAYER_MEDIA_LOADED: "loaded",
                JWPLAYER_MEDIA_SEEKED: "seeked",
                JWPLAYER_SETUP_ERROR: "setupError",
                JWPLAYER_ERROR: "error",
                JWPLAYER_PLAYER_STATE: "state",
                JWPLAYER_CAST_AVAILABLE: "castAvailable",
                JWPLAYER_MEDIA_BUFFER: "bufferChange",
                JWPLAYER_MEDIA_TIME: "time",
                JWPLAYER_MEDIA_TYPE: "mediaType",
                JWPLAYER_MEDIA_VOLUME: "volume",
                JWPLAYER_MEDIA_MUTE: "mute",
                JWPLAYER_MEDIA_META: "meta",
                JWPLAYER_MEDIA_LEVELS: "levels",
                JWPLAYER_MEDIA_LEVEL_CHANGED: "levelsChanged",
                JWPLAYER_CONTROLS: "controls",
                JWPLAYER_FULLSCREEN: "fullscreen",
                JWPLAYER_RESIZE: "resize",
                JWPLAYER_PLAYLIST_ITEM: "playlistItem",
                JWPLAYER_PLAYLIST_LOADED: "playlist",
                JWPLAYER_AUDIO_TRACKS: "audioTracks",
                JWPLAYER_AUDIO_TRACK_CHANGED: "audioTrackChanged",
                JWPLAYER_LOGO_CLICK: "logoClick",
                JWPLAYER_CAPTIONS_LIST: "captionsList",
                JWPLAYER_CAPTIONS_CHANGED: "captionsChanged",
                JWPLAYER_PROVIDER_CHANGED: "providerChanged",
                JWPLAYER_PROVIDER_FIRST_FRAME: "providerFirstFrame",
                JWPLAYER_USER_ACTION: "userAction",
                JWPLAYER_PROVIDER_CLICK: "providerClick",
                JWPLAYER_VIEW_TAB_FOCUS: "tabFocus",
                JWPLAYER_CONTROLBAR_DRAGGING: "scrubbing",
                JWPLAYER_INSTREAM_CLICK: "instreamClick"
            };
            return c.touchEvents = d, c
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (m) {
            var l = [], s = l.slice, r = {
                on: function (u, t, w) {
                    if (!p(this, "on", u, [t, w]) || !t) {
                        return this
                    }
                    this._events || (this._events = {});
                    var v = this._events[u] || (this._events[u] = []);
                    return v.push({callback: t, context: w}), this
                }, once: function (a, w, v) {
                    if (!p(this, "once", a, [w, v]) || !w) {
                        return this
                    }
                    var u = this, t = m.once(function () {
                        u.off(a, t), w.apply(this, arguments)
                    });
                    return t._callback = w, this.on(a, t, v)
                }, off: function (C, B, A) {
                    var z, y, x, w, v, u, t, a;
                    if (!this._events || !p(this, "off", C, [B, A])) {
                        return this
                    }
                    if (!C && !B && !A) {
                        return this._events = void 0, this
                    }
                    for (w = C ? [C] : m.keys(this._events), v = 0, u = w.length; u > v; v++) {
                        if (C = w[v], x = this._events[C]) {
                            if (this._events[C] = z = [], B || A) {
                                for (t = 0, a = x.length; a > t; t++) {
                                    y = x[t], (B && B !== y.callback && B !== y.callback._callback || A && A !== y.context) && z.push(y)
                                }
                            }
                            z.length || delete this._events[C]
                        }
                    }
                    return this
                }, trigger: function (t) {
                    if (!this._events) {
                        return this
                    }
                    var c = s.call(arguments, 1);
                    if (!p(this, "trigger", t, c)) {
                        return this
                    }
                    var v = this._events[t], u = this._events.all;
                    return v && o(v, c, this), u && o(u, arguments, this), this
                }, triggerSafe: function (t) {
                    if (!this._events) {
                        return this
                    }
                    var c = s.call(arguments, 1);
                    if (!p(this, "trigger", t, c)) {
                        return this
                    }
                    var v = this._events[t], u = this._events.all;
                    return v && n(v, c, this), u && n(u, arguments, this), this
                }
            }, q = /\s+/, p = function (u, t, A, z) {
                if (!A) {
                    return !0
                }
                if ("object" == typeof A) {
                    for (var y in A) {
                        u[t].apply(u, [y, A[y]].concat(z))
                    }
                    return !1
                }
                if (q.test(A)) {
                    for (var x = A.split(q), w = 0, v = x.length; v > w; w++) {
                        u[t].apply(u, [x[w]].concat(z))
                    }
                    return !1
                }
                return !0
            }, o = function (B, A, z) {
                var y, x = -1, w = B.length, v = A[0], u = A[1], t = A[2];
                switch (A.length) {
                    case 0:
                        for (; ++x < w;) {
                            (y = B[x]).callback.call(y.context || z)
                        }
                        return;
                    case 1:
                        for (; ++x < w;) {
                            (y = B[x]).callback.call(y.context || z, v)
                        }
                        return;
                    case 2:
                        for (; ++x < w;) {
                            (y = B[x]).callback.call(y.context || z, v, u)
                        }
                        return;
                    case 3:
                        for (; ++x < w;) {
                            (y = B[x]).callback.call(y.context || z, v, u, t)
                        }
                        return;
                    default:
                        for (; ++x < w;) {
                            (y = B[x]).callback.apply(y.context || z, A)
                        }
                        return
                }
            }, n = function (u, t, z) {
                for (var y, x = -1, w = u.length; ++x < w;) {
                    try {
                        (y = u[x]).callback.apply(y.context || z, t)
                    } catch (v) {
                    }
                }
            };
            return r
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51), k(45), k(52), k(53), k(55), k(49), k(56), k(50), k(57), k(60)], h = function (v, u, t, s, r, q, p, o, n, m) {
            var l = {};
            return l.log = function () {
                window.console && ("object" == typeof console.log ? console.log(Array.prototype.slice.call(arguments, 0)) : console.log.apply(console, arguments))
            }, l.between = function (w, d, x) {
                return Math.max(Math.min(w, x), d)
            }, l.foreach = function (x, w) {
                var z, y;
                for (z in x) {
                    "function" === l.typeOf(x.hasOwnProperty) ? x.hasOwnProperty(z) && (y = x[z], w(z, y)) : (y = x[z], w(z, y))
                }
            }, l.indexOf = u.indexOf, l.noop = function () {
            }, l.seconds = v.seconds, l.prefix = v.prefix, l.suffix = v.suffix, u.extend(l, q, o, t, p, s, r, n, m), l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(50)], h = function (m, l) {
            function p(b) {
                return /^(?:(?:https?|file)\:)?\/\//.test(b)
            }

            function o(a) {
                return m.some(a, function (b) {
                    return "parsererror" === b.nodeName
                })
            }

            var n = {};
            return n.getAbsolutePath = function (b, v) {
                if (l.exists(v) || (v = document.location.href), l.exists(b)) {
                    if (p(b)) {
                        return b
                    }
                    var u, t = v.substring(0, v.indexOf("://") + 3),
                        s = v.substring(t.length, v.indexOf("/", t.length + 1));
                    if (0 === b.indexOf("/")) {
                        u = b.split("/")
                    } else {
                        var r = v.split("?")[0];
                        r = r.substring(t.length + s.length + 1, r.lastIndexOf("/")), u = r.split("/").concat(b.split("/"))
                    }
                    for (var q = [], c = 0; c < u.length; c++) {
                        u[c] && l.exists(u[c]) && "." !== u[c] && (".." === u[c] ? q.pop() : q.push(u[c]))
                    }
                    return t + s + "/" + q.join("/")
                }
            }, n.getScriptPath = m.memoize(function (r) {
                for (var q = document.getElementsByTagName("script"), t = 0; t < q.length; t++) {
                    var s = q[t].src;
                    if (s && s.indexOf(r) >= 0) {
                        return s.substr(0, s.indexOf(r))
                    }
                }
                return ""
            }), n.parseXML = function (q) {
                var d = null;
                try {
                    "DOMParser" in window ? (d = (new window.DOMParser).parseFromString(q, "text/xml"), (o(d.childNodes) || d.childNodes && o(d.childNodes[0].childNodes)) && (d = null)) : (d = new window.ActiveXObject("Microsoft.XMLDOM"), d.async = "false", d.loadXML(q))
                } catch (r) {
                }
                return d
            }, n.serialize = function (d) {
                if (void 0 === d) {
                    return null
                }
                if ("string" == typeof d && d.length < 6) {
                    var c = d.toLowerCase();
                    if ("true" === c) {
                        return !0
                    }
                    if ("false" === c) {
                        return !1
                    }
                    if (!isNaN(Number(d)) && !isNaN(parseFloat(d))) {
                        return Number(d)
                    }
                }
                return d
            }, n.parseDimension = function (b) {
                return "string" == typeof b ? "" === b ? 0 : b.lastIndexOf("%") > -1 ? b : parseInt(b.replace("px", ""), 10) : b
            }, n.timeFormat = function (r, q) {
                if (0 >= r && !q) {
                    return "00:00"
                }
                var v = 0 > r ? "-" : "";
                r = Math.abs(r);
                var u = Math.floor(r / 3600), t = Math.floor((r - 3600 * u) / 60), s = Math.floor(r % 60);
                return v + (u ? u + ":" : "") + (10 > t ? "0" : "") + t + ":" + (10 > s ? "0" : "") + s
            }, n.adaptiveType = function (d) {
                if (0 !== d) {
                    var c = -120;
                    if (c >= d) {
                        return "DVR"
                    }
                    if (0 > d || d === 1 / 0) {
                        return "LIVE"
                    }
                }
                return "VOD"
            }, n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (d) {
            var c = {};
            return c.exists = function (b) {
                switch (typeof b) {
                    case"string":
                        return b.length > 0;
                    case"object":
                        return null !== b;
                    case"undefined":
                        return !1
                }
                return !0
            }, c.isHTTPS = function () {
                return 0 === window.location.href.indexOf("https")
            }, c.isRtmp = function (m, l) {
                return 0 === m.indexOf("rtmp") || "rtmp" === l
            }, c.isYouTube = function (m, l) {
                return "youtube" === l || /^(http|\/\/).*(youtube\.com|youtu\.be)\/.+/.test(m)
            }, c.youTubeID = function (m) {
                var l = /v[=\/]([^?&]*)|youtu\.be\/([^?]*)|^([\w-]*)$/i.exec(m);
                return l ? l.slice(1).join("").replace("?", "") : ""
            }, c.typeOf = function (a) {
                if (null === a) {
                    return "null"
                }
                var l = typeof a;
                return "object" === l && d.isArray(a) ? "array" : l
            }, c
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (u) {
            function t(b) {
                return b.indexOf("(format=m3u8-") > -1 ? "m3u8" : !1
            }

            var s = function (b) {
                return b.replace(/^\s+|\s+$/g, "")
            }, r = function (v, d, w) {
                for (v = "" + v, w = w || "0"; v.length < d;) {
                    v = w + v
                }
                return v
            }, q = function (v, d) {
                for (var w = 0; w < v.attributes.length; w++) {
                    if (v.attributes[w].name && v.attributes[w].name.toLowerCase() === d.toLowerCase()) {
                        return v.attributes[w].value.toString()
                    }
                }
                return ""
            }, p = function (b) {
                if (!b || "rtmp" === b.substr(0, 4)) {
                    return ""
                }
                var d = t(b);
                return d ? d : (b = b.substring(b.lastIndexOf("/") + 1, b.length).split("?")[0].split("#")[0], b.lastIndexOf(".") > -1 ? b.substr(b.lastIndexOf(".") + 1, b.length).toLowerCase() : void 0)
            }, o = function (v) {
                var d = parseInt(v / 3600), x = parseInt(v / 60) % 60, w = v % 60;
                return r(d, 2) + ":" + r(x, 2) + ":" + r(w.toFixed(3), 6)
            }, n = function (a) {
                if (u.isNumber(a)) {
                    return a
                }
                a = a.replace(",", ".");
                var w = a.split(":"), v = 0;
                return "s" === a.slice(-1) ? v = parseFloat(a) : "m" === a.slice(-1) ? v = 60 * parseFloat(a) : "h" === a.slice(-1) ? v = 3600 * parseFloat(a) : w.length > 1 ? (v = parseFloat(w[w.length - 1]), v += 60 * parseFloat(w[w.length - 2]), 3 === w.length && (v += 3600 * parseFloat(w[w.length - 3]))) : v = parseFloat(a), v
            }, m = function (a, d) {
                return u.map(a, function (b) {
                    return d + b
                })
            }, l = function (a, d) {
                return u.map(a, function (b) {
                    return b + d
                })
            };
            return {trim: s, pad: r, xmlAttribute: q, extension: p, hms: o, seconds: n, suffix: l, prefix: m}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (u) {
            function t(b) {
                return function () {
                    return r(b)
                }
            }

            var s = {}, r = u.memoize(function (d) {
                var c = navigator.userAgent.toLowerCase();
                return null !== c.match(d)
            }), q = s.isInt = function (b) {
                return parseFloat(b) % 1 === 0
            };
            s.isFlashSupported = function () {
                var b = s.flashVersion();
                return b && b >= 11.2
            }, s.isFF = t(/firefox/i), s.isIPod = t(/iP(hone|od)/i), s.isIPad = t(/iPad/i), s.isSafari602 = t(/Macintosh.*Mac OS X 10_8.*6\.0\.\d* Safari/i), s.isOSX = t(/Mac OS X/i), s.isEdge = t(/\sedge\/\d+/i);
            var p = s.isIETrident = function (b) {
                return s.isEdge() ? !0 : b ? (b = parseFloat(b).toFixed(1), r(new RegExp("trident/.+rv:\\s*" + b, "i"))) : r(/trident/i)
            }, o = s.isMSIE = function (b) {
                return b ? (b = parseFloat(b).toFixed(1), r(new RegExp("msie\\s*" + b, "i"))) : r(/msie/i)
            }, n = t(/chrome/i);
            s.isChrome = function () {
                return n() && !s.isEdge()
            }, s.isIE = function (b) {
                return b ? (b = parseFloat(b).toFixed(1), b >= 11 ? p(b) : o(b)) : o() || p()
            }, s.isSafari = function () {
                return r(/safari/i) && !r(/chrome/i) && !r(/chromium/i) && !r(/android/i)
            };
            var m = s.isIOS = function (b) {
                return r(b ? new RegExp("iP(hone|ad|od).+\\s(OS\\s" + b + "|.*\\sVersion/" + b + ")", "i") : /iP(hone|ad|od)/i)
            };
            s.isAndroidNative = function (b) {
                return l(b, !0)
            };
            var l = s.isAndroid = function (d, c) {
                return c && r(/chrome\/[123456789]/i) && !r(/chrome\/18/) ? !1 : d ? (q(d) && !/\./.test(d) && (d = "" + d + "."), r(new RegExp("Android\\s*" + d, "i"))) : r(/Android/i)
            };
            return s.isMobile = function () {
                return m() || l()
            }, s.isIframe = function () {
                return window.frameElement && "IFRAME" === window.frameElement.nodeName
            }, s.flashVersion = function () {
                if (s.isAndroid()) {
                    return 0
                }
                var v, c = navigator.plugins;
                if (c && (v = c["Shockwave Flash"], v && v.description)) {
                    return parseFloat(v.description.replace(/\D+(\d+\.?\d*).*/, "$1"))
                }
                if ("undefined" != typeof window.ActiveXObject) {
                    try {
                        if (v = new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash")) {
                            return parseFloat(v.GetVariable("$version").split(" ")[1].replace(/\s*,\s*/, "."))
                        }
                    } catch (w) {
                        return 0
                    }
                    return v
                }
                return 0
            }, s
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51), k(45), k(54)], h = function (m, l, q) {
            var p = {};
            p.createElement = function (d) {
                var c = document.createElement("div");
                return c.innerHTML = d, c.firstChild
            }, p.styleDimension = function (b) {
                return b + (b.toString().indexOf("%") > 0 ? "" : "px")
            };
            var o = function (b) {
                return l.isString(b.className) ? b.className.split(" ") : []
            }, n = function (a, d) {
                d = m.trim(d), a.className !== d && (a.className = d)
            };
            return p.classList = function (b) {
                return b.classList ? b.classList : o(b)
            }, p.hasClass = q.hasClass, p.addClass = function (b, t) {
                var s = o(b), r = l.isArray(t) ? t : t.split(" ");
                l.each(r, function (c) {
                    l.contains(s, c) || s.push(c)
                }), n(b, s.join(" "))
            }, p.removeClass = function (b, t) {
                var s = o(b), r = l.isArray(t) ? t : t.split(" ");
                n(b, l.difference(s, r).join(" "))
            }, p.replaceClass = function (s, r, u) {
                var t = s.className || "";
                r.test(t) ? t = t.replace(r, u) : u && (t += " " + u), n(s, t)
            }, p.toggleClass = function (b, s, r) {
                var d = p.hasClass(b, s);
                r = l.isBoolean(r) ? r : !d, r !== d && (r ? p.addClass(b, s) : p.removeClass(b, s))
            }, p.emptyElement = function (b) {
                for (; b.firstChild;) {
                    b.removeChild(b.firstChild)
                }
            }, p.addStyleSheet = function (d) {
                var c = document.createElement("link");
                c.rel = "stylesheet", c.href = d, document.getElementsByTagName("head")[0].appendChild(c)
            }, p.empty = function (b) {
                if (b) {
                    for (; b.childElementCount > 0;) {
                        b.removeChild(b.children[0])
                    }
                }
            }, p.bounds = function (s) {
                var r = {left: 0, right: 0, width: 0, height: 0, top: 0, bottom: 0};
                if (!s || !document.body.contains(s)) {
                    return r
                }
                var v = s.getBoundingClientRect(s), u = window.pageYOffset, t = window.pageXOffset;
                return v.width || v.height || v.left || v.top ? (r.left = v.left + t, r.right = v.right + t, r.top = v.top + u, r.bottom = v.bottom + u, r.width = v.right - v.left, r.height = v.bottom - v.top, r) : r
            }, p
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return {
                hasClass: function (l, d) {
                    var m = " " + d + " ";
                    return 1 === l.nodeType && (" " + l.className + " ").replace(/[\t\r\n\f]/g, " ").indexOf(m) >= 0
                }
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51)], h = function (u) {
            function t(d) {
                d = d.split("-");
                for (var c = 1; c < d.length; c++) {
                    d[c] = d[c].charAt(0).toUpperCase() + d[c].slice(1)
                }
                return d.join("")
            }

            function s(a, x, w) {
                if ("" === x || void 0 === x || null === x) {
                    return ""
                }
                var v = w ? " !important" : "";
                return "string" == typeof x && isNaN(x) ? /png|gif|jpe?g/i.test(x) && x.indexOf("url") < 0 ? "url(" + x + ")" : x + v : 0 === x || "z-index" === a || "opacity" === a ? "" + x + v : /color/i.test(a) ? "#" + u.pad(x.toString(16).replace(/^0x/i, ""), 6) + v : Math.ceil(x) + "px" + v
            }

            var r, q = {}, p = function (v, d) {
                r || (r = document.createElement("style"), r.type = "text/css", document.getElementsByTagName("head")[0].appendChild(r));
                var x = v + JSON.stringify(d).replace(/"/g, ""), w = document.createTextNode(x);
                q[v] && r.removeChild(q[v]), q[v] = w, r.appendChild(w)
            }, o = function (b, z) {
                if (void 0 !== b && null !== b) {
                    void 0 === b.length && (b = [b]);
                    var y, x = {};
                    for (y in z) {
                        x[y] = s(y, z[y])
                    }
                    for (var w = 0; w < b.length; w++) {
                        var v, c = b[w];
                        if (void 0 !== c && null !== c) {
                            for (y in x) {
                                v = t(y), c.style[v] !== x[y] && (c.style[v] = x[y])
                            }
                        }
                    }
                }
            }, n = function (d) {
                for (var c in q) {
                    c.indexOf(d) >= 0 && (r.removeChild(q[c]), delete q[c])
                }
            }, m = function (d, c) {
                o(d, {transform: c, webkitTransform: c, msTransform: c, mozTransform: c, oTransform: c})
            }, l = function (w, v) {
                var y = "rgb";
                w ? (w = String(w).replace("#", ""), 3 === w.length && (w = w[0] + w[0] + w[1] + w[1] + w[2] + w[2])) : w = "000000";
                var x = [parseInt(w.substr(0, 2), 16), parseInt(w.substr(2, 2), 16), parseInt(w.substr(4, 2), 16)];
                return void 0 !== v && 100 !== v && (y += "a", x.push(v / 100)), y + "(" + x.join(",") + ")"
            };
            return {css: p, style: o, clearCss: n, transform: m, hexToRgba: l}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(49)], h = function (x, w) {
            function v(b) {
                b.onload = null, b.onprogress = null, b.onreadystatechange = null, b.onerror = null, "abort" in b && b.abort()
            }

            function u(a, c) {
                return function (l) {
                    var d = l.currentTarget || c.xhr;
                    if (clearTimeout(c.timeoutId), c.retryWithoutCredentials && c.xhr.withCredentials) {
                        v(d);
                        var b = x.extend({}, c, {xhr: null, withCredentials: !1, retryWithoutCredentials: !1});
                        return void m(b)
                    }
                    c.onerror(a, c.url, d)
                }
            }

            function t(b) {
                return function (a) {
                    var y = a.currentTarget || b.xhr;
                    if (4 === y.readyState) {
                        if (clearTimeout(b.timeoutId), y.status >= 400) {
                            var l;
                            return l = 404 === y.status ? "File not found" : "" + y.status + "(" + y.statusText + ")", b.onerror(l, b.url, y)
                        }
                        if (200 === y.status) {
                            return s(b)(a)
                        }
                    }
                }
            }

            function s(b) {
                return function (A) {
                    var z = A.currentTarget || b.xhr;
                    if (clearTimeout(b.timeoutId), b.responseType) {
                        if ("json" === b.responseType) {
                            return r(z, b)
                        }
                    } else {
                        var y, l = z.responseXML;
                        if (l) {
                            try {
                                y = l.firstChild
                            } catch (a) {
                            }
                        }
                        if (l && y) {
                            return q(z, l, b)
                        }
                        if (o && z.responseText && !l && (l = w.parseXML(z.responseText), l && l.firstChild)) {
                            return q(z, l, b)
                        }
                        if (b.requireValidXML) {
                            return void b.onerror("Invalid XML", b.url, z)
                        }
                    }
                    b.oncomplete(z)
                }
            }

            function r(a, y) {
                if (!a.response || x.isString(a.response) && '"' !== a.responseText.substr(1)) {
                    try {
                        a = x.extend({}, a, {response: JSON.parse(a.responseText)})
                    } catch (l) {
                        return void y.onerror("Invalid JSON", y.url, a)
                    }
                }
                return y.oncomplete(a)
            }

            function q(a, z, y) {
                var l = z.documentElement;
                return y.requireValidXML && ("parsererror" === l.nodeName || l.getElementsByTagName("parsererror").length) ? void y.onerror("Invalid XML", y.url, a) : (a.responseXML || (a = x.extend({}, a, {responseXML: z})), y.oncomplete(a))
            }

            var p = function () {
            }, o = !1, n = function (y) {
                var l = document.createElement("a"), A = document.createElement("a");
                l.href = location.href;
                try {
                    return A.href = y, A.href = A.href, l.protocol + "//" + l.host != A.protocol + "//" + A.host
                } catch (z) {
                }
                return !0
            }, m = function (c, z, y, d) {
                x.isObject(c) && (d = c, c = d.url);
                var a, C = x.extend({
                    xhr: null,
                    url: c,
                    withCredentials: !1,
                    retryWithoutCredentials: !1,
                    timeout: 60000,
                    timeoutId: -1,
                    oncomplete: z || p,
                    onerror: y || p,
                    mimeType: d && !d.responseType ? "text/xml" : "",
                    requireValidXML: !1,
                    responseType: d && d.plainText ? "text" : ""
                }, d);
                if ("XDomainRequest" in window && n(c)) {
                    a = C.xhr = new window.XDomainRequest, a.onload = s(C), a.ontimeout = a.onprogress = p, o = !0
                } else {
                    if (!("XMLHttpRequest" in window)) {
                        return void C.onerror("", c)
                    }
                    a = C.xhr = new window.XMLHttpRequest, a.onreadystatechange = t(C)
                }
                var B = u("Error loading file", C);
                a.onerror = B, "overrideMimeType" in a ? C.mimeType && a.overrideMimeType(C.mimeType) : o = !0;
                try {
                    c = c.replace(/#.*$/, ""), a.open("GET", c, !0)
                } catch (A) {
                    return B(A), a
                }
                if (C.responseType) {
                    try {
                        a.responseType = C.responseType
                    } catch (A) {
                    }
                }
                C.timeout && (C.timeoutId = setTimeout(function () {
                    v(a), C.onerror("Timeout", c, a)
                }, C.timeout));
                try {
                    C.withCredentials && "withCredentials" in a && (a.withCredentials = !0), a.send()
                } catch (A) {
                    B(A)
                }
                return a
            };
            return {ajax: m, crossdomain: n}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(58), k(45), k(50), k(49), k(59)], h = function (m, l, q, p, o) {
            var n = {};
            return n.repo = l.memoize(function () {
                var a = o.split("+")[0], c = m.repo + a + "/";
                return q.isHTTPS() ? c.replace(/^http:/, "https:") : c
            }), n.versionCheck = function (s) {
                var r = ("0" + s).split(/\W/), v = o.split(/\W/), u = parseFloat(r[0]), t = parseFloat(v[0]);
                return u > t ? !1 : !(u === t && parseFloat("0" + r[1]) > parseFloat(v[1]))
            }, n.isSDK = function (b) {
                return !(!b.analytics || !b.analytics.sdkplatform)
            }, n.loadFrom = function () {
                return n.repo()
            }, n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return {
                repo: "http://ssl.p.jwpcdn.com/player/v/",
                SkinsIncluded: ["seven"],
                SkinsLoadable: ["beelden", "bekle", "five", "glow", "roundster", "six", "stormtrooper", "vapor"],
                dvrSeekLimit: -25
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return "7.3.6+commercial_v7-3-6.81.commercial.f002db.jwplayer.ad873d.analytics.c31916.vast.0300bb.googima.e8ba93.plugin-sharing.08a279.plugin-related.909f55.plugin-gapro.0374cd"
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            var d = function (b, n, m) {
                if (n = n || this, m = m || [], window.jwplayer && window.jwplayer.debug) {
                    return b.apply(n, m)
                }
                try {
                    return b.apply(n, m)
                } catch (l) {
                    return new c(b.name, l)
                }
            }, c = function (m, l) {
                this.name = m, this.message = l.message || l.toString(), this.error = l
            };
            return {tryCatch: d, Error: c}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (d) {
            var c = function () {
                var a = {}, n = {}, m = {}, l = {};
                return {
                    start: function (b) {
                        a[b] = d.now(), m[b] = m[b] + 1 || 1
                    }, end: function (o) {
                        if (a[o]) {
                            var b = d.now() - a[o];
                            n[o] = n[o] + b || b
                        }
                    }, dump: function () {
                        return {counts: m, sums: n, events: l}
                    }, tick: function (o, p) {
                        l[o] = p || d.now()
                    }, between: function (p, o) {
                        return l[o] && l[p] ? l[o] - l[p] : -1
                    }
                }
            };
            return c
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return {
                BUFFERING: "buffering",
                IDLE: "idle",
                COMPLETE: "complete",
                PAUSED: "paused",
                PLAYING: "playing",
                ERROR: "error",
                LOADING: "loading",
                STALLED: "stalled"
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(64), k(81), k(158)], h = function (l, c, n) {
            var m = l.prototype.setup;
            return l.prototype.setup = function (b, s) {
                m.apply(this, arguments);
                var r = this._model.get("edition"), q = c(r), p = this._model.get("cast"), o = this;
                q("casting") && p && p.appid && k.e(6, function (u) {
                    var t = k(159);
                    o._castController = new t(o, o._model), o.castToggle = o._castController.castToggle.bind(o._castController)
                });
                var d = n.setup();
                this.once("ready", d.onReady, this), s.getAdBlock = d.checkAdBlock
            }, l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(73), k(115), k(74), k(45), k(93), k(111), k(77), k(114), k(65), k(48), k(116), k(47), k(76), k(62), k(46), k(156)], h = function (L, K, J, I, H, G, F, E, D, C, B, A, z, y, x, w) {
            function v(b) {
                return function () {
                    var a = Array.prototype.slice.call(arguments, 0);
                    this.eventsQueue.push([b, a])
                }
            }

            function u(b) {
                return b === y.LOADING || b === y.STALLED ? y.BUFFERING : b
            }

            var t = function (b) {
                this.originalContainer = this.currentContainer = b, this.eventsQueue = [], I.extend(this, A), this._model = new F
            };
            return t.prototype = {
                play: v("play"),
                pause: v("pause"),
                setVolume: v("setVolume"),
                setMute: v("setMute"),
                seek: v("seek"),
                stop: v("stop"),
                load: v("load"),
                playlistNext: v("playlistNext"),
                playlistPrev: v("playlistPrev"),
                playlistItem: v("playlistItem"),
                setFullscreen: v("setFullscreen"),
                setCurrentCaptions: v("setCurrentCaptions"),
                setCurrentQuality: v("setCurrentQuality"),
                setup: function (aI, aH) {
                    function aG() {
                        n.mediaModel.on("change:state", function (p, l) {
                            var q = u(l);
                            n.set("state", q)
                        })
                    }

                    function aF() {
                        c = null, ap(n.get("item")), n.on("change:state", z, this), n.on("change:castState", function (p, l) {
                            au.trigger(x.JWPLAYER_CAST_SESSION, l)
                        }), n.on("change:fullscreen", function (p, l) {
                            au.trigger(x.JWPLAYER_FULLSCREEN, {fullscreen: l})
                        }), n.on("itemReady", function () {
                            au.trigger(x.JWPLAYER_PLAYLIST_ITEM, {index: n.get("item"), item: n.get("playlistItem")})
                        }), n.on("change:playlist", function (p, l) {
                            l.length && au.trigger(x.JWPLAYER_PLAYLIST_LOADED, {playlist: l})
                        }), n.on("change:volume", function (p, l) {
                            au.trigger(x.JWPLAYER_MEDIA_VOLUME, {volume: l})
                        }), n.on("change:mute", function (p, l) {
                            au.trigger(x.JWPLAYER_MEDIA_MUTE, {mute: l})
                        }), n.on("change:controls", function (p, l) {
                            au.trigger(x.JWPLAYER_CONTROLS, {controls: l})
                        }), n.on("change:scrubbing", function (p, l) {
                            l ? ay() : aA()
                        }), n.on("change:captionsList", function (p, l) {
                            au.trigger(x.JWPLAYER_CAPTIONS_LIST, {tracks: l, track: ac()})
                        }), n.mediaController.on("all", au.trigger.bind(au)), m.on("all", au.trigger.bind(au)), this.showView(m.element()), window.addEventListener("beforeunload", function () {
                            c && c.destroy(), n && n.destroy()
                        }), I.defer(aE)
                    }

                    function aE() {
                        for (au.trigger(x.JWPLAYER_READY, {setupTime: 0}), au.trigger(x.JWPLAYER_PLAYLIST_LOADED, {playlist: n.get("playlist")}), au.trigger(x.JWPLAYER_PLAYLIST_ITEM, {
                            index: n.get("item"),
                            item: n.get("playlistItem")
                        }), au.trigger(x.JWPLAYER_CAPTIONS_LIST, {
                            tracks: n.get("captionsList"),
                            track: n.get("captionsIndex")
                        }), n.get("autostart") && aA({reason: "autostart"}); au.eventsQueue.length > 0;) {
                            var p = au.eventsQueue.shift(), l = p[0], q = p[1] || [];
                            au[l].apply(au, q)
                        }
                    }

                    function aD(p) {
                        switch (n.get("state") === y.ERROR && n.set("state", y.IDLE), az(!0), n.get("autostart") && n.once("itemReady", aA), typeof p) {
                            case"string":
                                aC(p);
                                break;
                            case"object":
                                var l = aq(p);
                                l && ap(0);
                                break;
                            case"number":
                                ap(p)
                        }
                    }

                    function aC(p) {
                        var l = new D;
                        l.on(x.JWPLAYER_PLAYLIST_LOADED, function (q) {
                            aD(q.playlist)
                        }), l.on(x.JWPLAYER_ERROR, function (q) {
                            q.message = "Error loading playlist: " + q.message, this.triggerError(q)
                        }, this), l.load(p)
                    }

                    function aB() {
                        var l = au._instreamAdapter && au._instreamAdapter.getState();
                        return I.isString(l) ? l : n.get("state")
                    }

                    function aA(p) {
                        var l;
                        if (p && n.set("playReason", p.reason), n.get("state") !== y.ERROR) {
                            var q = au._instreamAdapter && au._instreamAdapter.getState();
                            if (I.isString(q)) {
                                return aH.pauseAd(!1)
                            }
                            if (n.get("state") === y.COMPLETE && (az(!0), ap(0)), !av && (av = !0, au.trigger(x.JWPLAYER_MEDIA_BEFOREPLAY, {playReason: n.get("playReason")}), av = !1, a)) {
                                return a = !1, void (b = null)
                            }
                            if (ax()) {
                                if (0 === n.get("playlist").length) {
                                    return !1
                                }
                                l = C.tryCatch(function () {
                                    n.loadVideo()
                                })
                            } else {
                                n.get("state") === y.PAUSED && (l = C.tryCatch(function () {
                                    n.playVideo()
                                }))
                            }
                            return l instanceof C.Error ? (au.triggerError(l), b = null, !1) : !0
                        }
                    }

                    function az(p) {
                        n.off("itemReady", aA);
                        var l = !p;
                        b = null;
                        var q = C.tryCatch(function () {
                            n.stopVideo()
                        }, au);
                        return q instanceof C.Error ? (au.triggerError(q), !1) : (l && (aK = !0), av && (a = !0), !0)
                    }

                    function ay() {
                        b = null;
                        var p = au._instreamAdapter && au._instreamAdapter.getState();
                        if (I.isString(p)) {
                            return aH.pauseAd(!0)
                        }
                        switch (n.get("state")) {
                            case y.ERROR:
                                return !1;
                            case y.PLAYING:
                            case y.BUFFERING:
                                var l = C.tryCatch(function () {
                                    aJ().pause()
                                }, this);
                                if (l instanceof C.Error) {
                                    return au.triggerError(l), !1
                                }
                                break;
                            default:
                                av && (a = !0)
                        }
                        return !0
                    }

                    function ax() {
                        var l = n.get("state");
                        return l === y.IDLE || l === y.COMPLETE || l === y.ERROR
                    }

                    function at(l) {
                        n.get("state") !== y.ERROR && (n.get("scrubbing") || n.get("state") === y.PLAYING || aA(!0), aJ().seek(l))
                    }

                    function ar(p, l) {
                        az(!0), ap(p), aA(l)
                    }

                    function aq(p) {
                        var l = E(p);
                        return l = E.filterPlaylist(l, n.getProviders(), n.get("androidhls"), n.get("drm"), n.get("preload")), n.set("playlist", l), I.isArray(l) && 0 !== l.length ? !0 : (au.triggerError({message: "Error loading playlist: No playable sources found"}), !1)
                    }

                    function ap(p) {
                        var l = n.get("playlist");
                        p = (p + l.length) % l.length, n.set("item", p), n.set("playlistItem", l[p]), n.setActiveItem(l[p])
                    }

                    function ao(l) {
                        ar(n.get("item") - 1, l || {reason: "external"})
                    }

                    function an(l) {
                        ar(n.get("item") + 1, l || {reason: "external"})
                    }

                    function am() {
                        if (ax()) {
                            if (aK) {
                                return void (aK = !1)
                            }
                            b = am;
                            var l = n.get("item");
                            return l === n.get("playlist").length - 1 ? void (n.get("repeat") ? an({reason: "repeat"}) : (n.set("state", y.COMPLETE), au.trigger(x.JWPLAYER_PLAYLIST_COMPLETE, {}))) : void an({reason: "playlist"})
                        }
                    }

                    function al(l) {
                        aJ().setCurrentQuality(l)
                    }

                    function ak() {
                        return aJ() ? aJ().getCurrentQuality() : -1
                    }

                    function aj() {
                        return this._model ? this._model.getConfiguration() : void 0
                    }

                    function ai() {
                        if (this._model.mediaModel) {
                            return this._model.mediaModel.get("visualQuality")
                        }
                        var p = ah();
                        if (p) {
                            var l = ak(), q = p[l];
                            if (q) {
                                return {level: I.extend({index: l}, q), mode: "", reason: ""}
                            }
                        }
                        return null
                    }

                    function ah() {
                        return aJ() ? aJ().getQualityLevels() : null
                    }

                    function ag(l) {
                        aJ() && aJ().setCurrentAudioTrack(l)
                    }

                    function af() {
                        return aJ() ? aJ().getCurrentAudioTrack() : -1
                    }

                    function ae() {
                        return aJ() ? aJ().getAudioTracks() : null
                    }

                    function ad(l) {
                        n.persistVideoSubtitleTrack(l), au.trigger(x.JWPLAYER_CAPTIONS_CHANGED, {
                            tracks: ab(),
                            track: l
                        })
                    }

                    function ac() {
                        return d.getCurrentIndex()
                    }

                    function ab() {
                        return d.getCaptionsList()
                    }

                    function r() {
                        var p = n.getVideo();
                        if (p) {
                            var l = p.detachMedia();
                            if (l instanceof HTMLVideoElement) {
                                return l
                            }
                        }
                        return null
                    }

                    function o() {
                        var l = C.tryCatch(function () {
                            n.getVideo().attachMedia()
                        });
                        return l instanceof C.Error ? void C.log("Error calling _attachMedia", l) : void ("function" == typeof b && b())
                    }

                    var n, m, d, c, b, a, av = !1, aK = !1, au = this, aJ = function () {
                        return n.getVideo()
                    }, aw = new L(aI);
                    n = this._model.setup(aw), m = this._view = new B(aH, n), d = new G(aH, n), c = new H(aH, n, m, aq), c.on(x.JWPLAYER_READY, aF, this), c.on(x.JWPLAYER_SETUP_ERROR, this.setupError, this), n.mediaController.on(x.JWPLAYER_MEDIA_COMPLETE, function () {
                        I.defer(am)
                    }), n.mediaController.on(x.JWPLAYER_MEDIA_ERROR, this.triggerError, this), n.on("change:flashBlocked", function (p, l) {
                        if (!l) {
                            return void this._model.set("errorEvent", void 0)
                        }
                        var s = !!p.get("flashThrottle"),
                            q = {message: s ? "Click to run Flash" : "Flash plugin failed to load"};
                        s || this.trigger(x.JWPLAYER_ERROR, q), this._model.set("errorEvent", q)
                    }, this), aG(), n.on("change:mediaModel", aG), this.play = aA, this.pause = ay, this.seek = at, this.stop = az, this.load = aD, this.playlistNext = an, this.playlistPrev = ao, this.playlistItem = ar, this.setCurrentCaptions = ad, this.setCurrentQuality = al, this.detachMedia = r, this.attachMedia = o, this.getCurrentQuality = ak, this.getQualityLevels = ah, this.setCurrentAudioTrack = ag, this.getCurrentAudioTrack = af, this.getAudioTracks = ae, this.getCurrentCaptions = ac, this.getCaptionsList = ab, this.getVisualQuality = ai, this.getConfig = aj, this.getState = aB, this.setVolume = n.setVolume, this.setMute = n.setMute, this.getProvider = function () {
                        return n.get("provider")
                    }, this.getWidth = function () {
                        return n.get("containerWidth")
                    }, this.getHeight = function () {
                        return n.get("containerHeight")
                    }, this.getContainer = function () {
                        return this.currentContainer
                    }, this.resize = m.resize, this.getSafeRegion = m.getSafeRegion, this.setCues = m.addCues, this.setFullscreen = function (l) {
                        I.isBoolean(l) || (l = !n.get("fullscreen")), n.set("fullscreen", l), this._instreamAdapter && this._instreamAdapter._adModel && this._instreamAdapter._adModel.set("fullscreen", l)
                    }, this.addButton = function (p, l, O, N, M) {
                        var s = {img: p, tooltip: l, callback: O, id: N, btnClass: M}, q = n.get("dock");
                        q = q ? q.slice(0) : [], q = I.reject(q, I.matches({id: s.id})), q.push(s), n.set("dock", q)
                    }, this.removeButton = function (p) {
                        var l = n.get("dock") || [];
                        l = I.reject(l, I.matches({id: p})), n.set("dock", l)
                    }, this.checkBeforePlay = function () {
                        return av
                    }, this.getItemQoe = function () {
                        return n._qoeItem
                    }, this.setControls = function (p) {
                        I.isBoolean(p) || (p = !n.get("controls")), n.set("controls", p);
                        var l = n.getVideo();
                        l && l.setControls(p)
                    }, this.playerDestroy = function () {
                        this.stop(), this.showView(this.originalContainer), m && m.destroy(), n && n.destroy(), c && (c.destroy(), c = null)
                    }, this.isBeforePlay = this.checkBeforePlay, this.isBeforeComplete = function () {
                        return n.getVideo().checkComplete()
                    }, this.createInstream = function () {
                        return this.instreamDestroy(), this._instreamAdapter = new J(this, n, m), this._instreamAdapter
                    }, this.skipAd = function () {
                        this._instreamAdapter && this._instreamAdapter.skipAd()
                    }, this.instreamDestroy = function () {
                        au._instreamAdapter && au._instreamAdapter.destroy()
                    }, K(aH, this), c.start()
                },
                showView: function (b) {
                    (document.documentElement.contains(this.currentContainer) || (this.currentContainer = document.getElementById(this._model.get("id")), this.currentContainer)) && (this.currentContainer.parentElement && this.currentContainer.parentElement.replaceChild(b, this.currentContainer), this.currentContainer = b)
                },
                triggerError: function (b) {
                    this._model.set("errorEvent", b), this._model.set("state", y.ERROR), this._model.once("change:state", function () {
                        this._model.set("errorEvent", void 0)
                    }, this), this.trigger(x.JWPLAYER_ERROR, b)
                },
                setupError: function (l) {
                    var d = l.message, p = C.createElement(w(this._model.get("id"), this._model.get("skin"), d)),
                        o = this._model.get("width"), n = this._model.get("height");
                    C.style(p, {
                        width: o.toString().indexOf("%") > 0 ? o : o + "px",
                        height: n.toString().indexOf("%") > 0 ? n : n + "px"
                    }), this.showView(p);
                    var m = this;
                    I.defer(function () {
                        m.trigger(x.JWPLAYER_SETUP_ERROR, {message: d})
                    })
                }
            }, t
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(66), k(67), k(48), k(46), k(47), k(45)], h = function (m, l, r, q, p, o) {
            var n = function () {
                function d(t) {
                    var s = r.tryCatch(function () {
                        var y, x = t.responseXML ? t.responseXML.childNodes : null, w = "";
                        if (x) {
                            for (var v = 0; v < x.length && (w = x[v], 8 === w.nodeType); v++) {
                            }
                            "xml" === m.localName(w) && (w = w.nextSibling), "rss" === m.localName(w) && (y = l.parse(w))
                        }
                        if (!y) {
                            try {
                                y = JSON.parse(t.responseText), o.isArray(y) || (y = y.playlist)
                            } catch (u) {
                                return void b("Not a valid RSS/JSON feed")
                            }
                        }
                        a.trigger(q.JWPLAYER_PLAYLIST_LOADED, {playlist: y})
                    });
                    s instanceof r.Error && b()
                }

                function c(s) {
                    b("Playlist load error: " + s)
                }

                function b(s) {
                    a.trigger(q.JWPLAYER_ERROR, {message: s ? s : "Error loading file"})
                }

                var a = o.extend(this, p);
                this.load = function (s) {
                    r.ajax(s, d, c)
                }, this.destroy = function () {
                    this.off()
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51)], h = function (b) {
            return {
                localName: function (c) {
                    return c ? c.localName ? c.localName : c.baseName ? c.baseName : "" : ""
                }, textContent: function (a) {
                    return a ? a.textContent ? b.trim(a.textContent) : a.text ? b.trim(a.text) : "" : ""
                }, getChildNode: function (d, c) {
                    return d.childNodes[c]
                }, numChildren: function (c) {
                    return c.childNodes ? c.childNodes.length : 0
                }
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51), k(66), k(68), k(69), k(70)], h = function (v, u, t, s, r) {
            function q(a) {
                for (var x = {}, w = 0; w < a.childNodes.length; w++) {
                    var d = a.childNodes[w], c = m(d);
                    if (c) {
                        switch (c.toLowerCase()) {
                            case"enclosure":
                                x.file = v.xmlAttribute(d, "url");
                                break;
                            case"title":
                                x.title = p(d);
                                break;
                            case"guid":
                                x.mediaid = p(d);
                                break;
                            case"pubdate":
                                x.date = p(d);
                                break;
                            case"description":
                                x.description = p(d);
                                break;
                            case"link":
                                x.link = p(d);
                                break;
                            case"category":
                                x.tags ? x.tags += p(d) : x.tags = p(d)
                        }
                    }
                }
                return x = s(a, x), x = t(a, x), new r(x)
            }

            var p = u.textContent, o = u.getChildNode, n = u.numChildren, m = u.localName, l = {};
            return l.parse = function (x) {
                for (var w = [], C = 0; C < n(x); C++) {
                    var B = o(x, C), A = m(B).toLowerCase();
                    if ("channel" === A) {
                        for (var z = 0; z < n(B); z++) {
                            var y = o(B, z);
                            "item" === m(y).toLowerCase() && w.push(q(y))
                        }
                    }
                }
                return w
            }, l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(66), k(51), k(48)], h = function (m, l, p) {
            var o = "jwplayer", n = function (x, w) {
                for (var v = [], u = [], t = l.xmlAttribute, s = "default", r = "label", q = "file", d = "type", c = 0; c < x.childNodes.length; c++) {
                    var b = x.childNodes[c];
                    if (b.prefix === o) {
                        var a = m.localName(b);
                        "source" === a ? (delete w.sources, v.push({
                            file: t(b, q),
                            "default": t(b, s),
                            label: t(b, r),
                            type: t(b, d)
                        })) : "track" === a ? (delete w.tracks, u.push({
                            file: t(b, q),
                            "default": t(b, s),
                            kind: t(b, "kind"),
                            label: t(b, r)
                        })) : (w[a] = p.serialize(m.textContent(b)), "file" === a && w.sources && delete w.sources)
                    }
                    w[q] || (w[q] = w.link)
                }
                if (v.length) {
                    for (w.sources = [], c = 0; c < v.length; c++) {
                        v[c].file.length > 0 && (v[c][s] = "true" === v[c][s], v[c].label.length || delete v[c].label, w.sources.push(v[c]))
                    }
                }
                if (u.length) {
                    for (w.tracks = [], c = 0; c < u.length; c++) {
                        u[c].file.length > 0 && (u[c][s] = "true" === u[c][s], u[c].kind = u[c].kind.length ? u[c].kind : "captions", u[c].label.length || delete u[c].label, w.tracks.push(u[c]))
                    }
                }
                return w
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(66), k(51), k(48)], h = function (t, s, r) {
            var q = s.xmlAttribute, p = t.localName, o = t.textContent, n = t.numChildren, m = "media",
                l = function (v, d) {
                    function x(B) {
                        var A = {
                            zh: "Chinese",
                            nl: "Dutch",
                            en: "English",
                            fr: "French",
                            de: "German",
                            it: "Italian",
                            ja: "Japanese",
                            pt: "Portuguese",
                            ru: "Russian",
                            es: "Spanish"
                        };
                        return A[B] ? A[B] : B
                    }

                    var w, u, c = "tracks", z = [];
                    for (u = 0; u < n(v); u++) {
                        if (w = v.childNodes[u], w.prefix === m) {
                            if (!p(w)) {
                                continue
                            }
                            switch (p(w).toLowerCase()) {
                                case"content":
                                    q(w, "duration") && (d.duration = r.seconds(q(w, "duration"))), n(w) > 0 && (d = l(w, d)), q(w, "url") && (d.sources || (d.sources = []), d.sources.push({
                                        file: q(w, "url"),
                                        type: q(w, "type"),
                                        width: q(w, "width"),
                                        label: q(w, "label")
                                    }));
                                    break;
                                case"title":
                                    d.title = o(w);
                                    break;
                                case"description":
                                    d.description = o(w);
                                    break;
                                case"guid":
                                    d.mediaid = o(w);
                                    break;
                                case"thumbnail":
                                    d.image || (d.image = q(w, "url"));
                                    break;
                                case"player":
                                    break;
                                case"group":
                                    l(w, d);
                                    break;
                                case"subtitle":
                                    var y = {};
                                    y.file = q(w, "url"), y.kind = "captions", q(w, "lang").length > 0 && (y.label = x(q(w, "lang"))), z.push(y)
                            }
                        }
                    }
                    for (d.hasOwnProperty(c) || (d[c] = []), u = 0; u < z.length; u++) {
                        d[c].push(z[u])
                    }
                    return d
                };
            return l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(71), k(72)], h = function (m, l, p) {
            var o = {sources: [], tracks: []}, n = function (q) {
                q = q || {}, m.isArray(q.tracks) || delete q.tracks;
                var d = m.extend({}, o, q);
                m.isObject(d.sources) && !m.isArray(d.sources) && (d.sources = [l(d.sources)]), m.isArray(d.sources) && 0 !== d.sources.length || (q.levels ? d.sources = q.levels : d.sources = [l(q)]);
                for (var c = 0; c < d.sources.length; c++) {
                    var b = d.sources[c];
                    if (b) {
                        var a = b["default"];
                        a ? b["default"] = "true" === a.toString() : b["default"] = !1, d.sources[c].label || (d.sources[c].label = c.toString()), d.sources[c] = l(d.sources[c])
                    }
                }
                return d.sources = m.compact(d.sources), m.isArray(d.tracks) || (d.tracks = []), m.isArray(d.captions) && (d.tracks = d.tracks.concat(d.captions), delete d.captions), d.tracks = m.compact(m.map(d.tracks, p)), d
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(51), k(45)], h = function (m, l, p) {
            var o = {"default": !1}, n = function (c) {
                if (c && c.file) {
                    var b = p.extend({}, o, c);
                    b.file = l.trim("" + b.file);
                    var a = /^[^\/]+\/(?:x-)?([^\/]+)$/;
                    if (m.isYouTube(b.file) ? b.type = "youtube" : m.isRtmp(b.file) ? b.type = "rtmp" : a.test(b.type) ? b.type = b.type.replace(a, "$1") : b.type || (b.type = l.extension(b.file)), b.type) {
                        switch (b.type) {
                            case"m3u8":
                            case"vnd.apple.mpegurl":
                                b.type = "hls";
                                break;
                            case"dash+xml":
                                b.type = "dash";
                                break;
                            case"smil":
                                b.type = "rtmp";
                                break;
                            case"m4a":
                                b.type = "aac"
                        }
                        return p.each(b, function (q, d) {
                            "" === q && delete b[d]
                        }), b
                    }
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (l) {
            var d = {kind: "captions", "default": !1}, m = function (a) {
                return a && a.file ? l.extend({}, d, a) : void 0
            };
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(45)], h = function (l, c) {
            function q(a) {
                c.each(a, function (r, s) {
                    a[s] = l.serialize(r)
                })
            }

            function p(b) {
                return b.slice && "px" === b.slice(-2) && (b = b.slice(0, -2)), b
            }

            function o(a, u) {
                if (-1 === u.toString().indexOf("%")) {
                    return 0
                }
                if ("string" != typeof a || !l.exists(a)) {
                    return 0
                }
                if (/^\d*\.?\d+%$/.test(a)) {
                    return a
                }
                var t = a.indexOf(":");
                if (-1 === t) {
                    return 0
                }
                var s = parseFloat(a.substr(0, t)), r = parseFloat(a.substr(t + 1));
                return 0 >= s || 0 >= r ? 0 : r / s * 100 + "%"
            }

            var n = {
                autostart: !1,
                controls: !0,
                displaytitle: !0,
                displaydescription: !0,
                mobilecontrols: !1,
                repeat: !1,
                castAvailable: !1,
                skin: "seven",
                stretching: "uniform",
                mute: !1,
                volume: 90,
                width: 480,
                height: 270
            }, m = function (r) {
                var d = c.extend({}, (window.jwplayer || {}).defaults, r);
                q(d);
                var b = c.extend({}, n, d);
                if ("." === b.base && (b.base = l.getScriptPath("jwplayer.js")), b.base = (b.base || l.loadFrom()).replace(/\/?$/, "/"), k.p = b.base, b.width = p(b.width), b.height = p(b.height), b.flashplayer = b.flashplayer || l.getScriptPath("jwplayer.js") + "jwplayer.flash.swf", "http:" === window.location.protocol && (b.flashplayer = b.flashplayer.replace("https", "http")), b.aspectratio = o(b.aspectratio, b.width), c.isObject(b.skin) && (b.skinUrl = b.skin.url, b.skinColorInactive = b.skin.inactive, b.skinColorActive = b.skin.active, b.skinColorBackground = b.skin.background, b.skin = c.isString(b.skin.name) ? b.skin.name : n.skin), c.isString(b.skin) && b.skin.indexOf(".xml") > 0 && (console.log("JW Player does not support XML skins, please update your config"), b.skin = b.skin.replace(".xml", "")), b.aspectratio || delete b.aspectratio, !b.playlist) {
                    var a = c.pick(b, ["title", "description", "type", "mediaid", "image", "file", "sources", "tracks", "preload"]);
                    b.playlist = [a]
                }
                return b
            };
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(75), k(92), k(46), k(62), k(48), k(47), k(45)], h = function (u, t, s, r, q, p, o) {
            function n(b) {
                var a = b.get("provider").name || "";
                return a.indexOf("flash") >= 0 ? t : u
            }

            var m = {skipoffset: null, tag: null}, l = function (G, F, E) {
                function D(w, v) {
                    v = v || {}, J.tag && !v.tag && (v.tag = J.tag), this.trigger(w, v)
                }

                function C(b) {
                    L._adModel.set("duration", b.duration), L._adModel.set("position", b.position)
                }

                function B(b) {
                    if (A && K + 1 < A.length) {
                        L._adModel.set("state", "buffering"), F.set("skipButton", !1), K++;
                        var w, v = A[K];
                        z && (w = z[K]), this.loadItem(v, w)
                    } else {
                        b.type === s.JWPLAYER_MEDIA_COMPLETE && (D.call(this, b.type, b), this.trigger(s.JWPLAYER_PLAYLIST_COMPLETE, {})), this.destroy()
                    }
                }

                var A, z, y, x, d, c = n(F), L = new c(G, F), K = 0, J = {}, I = o.bind(function (b) {
                    b = b || {}, b.hasControls = !!F.get("controls"), this.trigger(s.JWPLAYER_INSTREAM_CLICK, b), L && L._adModel && (L._adModel.get("state") === r.PAUSED ? b.hasControls && L.instreamPlay() : L.instreamPause())
                }, this), H = o.bind(function () {
                    L && L._adModel && L._adModel.get("state") === r.PAUSED && F.get("controls") && (G.setFullscreen(), G.play())
                }, this);
                this.type = "instream", this.init = function () {
                    y = F.getVideo(), x = F.get("position"), d = F.get("playlist")[F.get("item")], L.on("all", D, this), L.on(s.JWPLAYER_MEDIA_TIME, C, this), L.on(s.JWPLAYER_MEDIA_COMPLETE, B, this), L.init(), y.detachMedia(), F.mediaModel.set("state", r.BUFFERING), G.checkBeforePlay() || 0 === x && !y.checkComplete() ? (x = 0, F.set("preInstreamState", "instream-preroll")) : y && y.checkComplete() || F.get("state") === r.COMPLETE ? F.set("preInstreamState", "instream-postroll") : F.set("preInstreamState", "instream-midroll");
                    var a = F.get("state");
                    return a !== r.PLAYING && a !== r.BUFFERING || y.pause(), E.setupInstream(L._adModel), L._adModel.set("state", r.BUFFERING), E.clickHandler().setAlternateClickHandlers(q.noop, null), this.setText("Loading ad"), this
                }, this.loadItem = function (b, w) {
                    if (q.isAndroid(2.3)) {
                        return void this.trigger({
                            type: s.JWPLAYER_ERROR,
                            message: "Error loading instream: Cannot play instream on Android 2.3"
                        })
                    }
                    o.isArray(b) && (A = b, z = w, b = A[K], z && (w = z[K])), this.trigger(s.JWPLAYER_PLAYLIST_ITEM, {
                        index: K,
                        item: b
                    }), J = o.extend({}, m, w), L.load(b), this.addClickHandler();
                    var v = b.skipoffset || J.skipoffset;
                    v && (L._adModel.set("skipMessage", J.skipMessage), L._adModel.set("skipText", J.skipText), L._adModel.set("skipOffset", v), F.set("skipButton", !0))
                }, this.applyProviderListeners = function (b) {
                    L.applyProviderListeners(b), this.addClickHandler()
                }, this.play = function () {
                    L.instreamPlay()
                }, this.pause = function () {
                    L.instreamPause()
                }, this.hide = function () {
                    L.hide()
                }, this.addClickHandler = function () {
                    E.clickHandler().setAlternateClickHandlers(I, H), L.on(s.JWPLAYER_MEDIA_META, this.metaHandler, this)
                }, this.skipAd = function (w) {
                    var v = s.JWPLAYER_AD_SKIPPED;
                    this.trigger(v, w), B.call(this, {type: v})
                }, this.metaHandler = function (b) {
                    b.width && b.height && E.resizeMedia()
                }, this.destroy = function () {
                    if (this.off(), F.set("skipButton", !1), L) {
                        E.clickHandler() && E.clickHandler().revertAlternateClickHandlers(), L.instreamDestroy(), E.destroyInstream(), L = null, G.attachMedia();
                        var b = F.get("preInstreamState");
                        switch (b) {
                            case"instream-preroll":
                            case"instream-midroll":
                                var a = o.extend({}, d);
                                a.starttime = x, F.loadVideo(a), q.isMobile() && F.mediaModel.get("state") === r.BUFFERING && y.setState(r.BUFFERING), y.play();
                                break;
                            case"instream-postroll":
                            case"instream-idle":
                                y.stop()
                        }
                    }
                }, this.getState = function () {
                    return L && L._adModel ? L._adModel.get("state") : !1
                }, this.setText = function (b) {
                    E.setAltText(b ? b : "")
                }, this.hide = function () {
                    E.useExternalControls()
                }
            };
            return o.extend(l.prototype, p), l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(47), k(76), k(46), k(62), k(77)], h = function (m, l, r, q, p, o) {
            var n = function (w, v) {
                function u(x) {
                    var y = x || c.getVideo();
                    if (b !== y) {
                        if (b = y, !y) {
                            return
                        }
                        y.off(), y.on("all", function (z, A) {
                            A = m.extend({}, A, {type: z}), this.trigger(z, A)
                        }, a), y.on(q.JWPLAYER_MEDIA_BUFFER_FULL, d), y.on(q.JWPLAYER_PLAYER_STATE, t), y.attachMedia(), y.volume(v.get("volume")), y.mute(v.get("mute")), c.on("change:state", r, a)
                    }
                }

                function t(x) {
                    switch (x.newstate) {
                        case p.PLAYING:
                            c.set("state", x.newstate);
                            break;
                        case p.PAUSED:
                            c.set("state", x.newstate)
                    }
                }

                function s(x) {
                    v.trigger(x.type, x), a.trigger(q.JWPLAYER_FULLSCREEN, {fullscreen: x.jwstate})
                }

                function d() {
                    c.getVideo().play()
                }

                var c, b, a = m.extend(this, l);
                return w.on(q.JWPLAYER_FULLSCREEN, function (x) {
                    this.trigger(q.JWPLAYER_FULLSCREEN, x)
                }, a), this.init = function () {
                    c = (new o).setup({
                        id: v.get("id"),
                        volume: v.get("volume"),
                        fullscreen: v.get("fullscreen"),
                        mute: v.get("mute")
                    }), c.on("fullscreenchange", s), this._adModel = c
                }, a.load = function (x) {
                    c.set("item", 0), c.set("playlistItem", x), c.setActiveItem(x), u(), c.off(q.JWPLAYER_ERROR), c.on(q.JWPLAYER_ERROR, function (y) {
                        this.trigger(q.JWPLAYER_ERROR, y)
                    }, a), c.loadVideo(x)
                }, a.applyProviderListeners = function (x) {
                    u(x), x.off(q.JWPLAYER_ERROR), x.on(q.JWPLAYER_ERROR, function (y) {
                        this.trigger(q.JWPLAYER_ERROR, y)
                    }, a), v.on("change:volume", function (z, y) {
                        b.volume(y)
                    }, a), v.on("change:mute", function (z, y) {
                        b.mute(y)
                    }, a)
                }, this.instreamDestroy = function () {
                    c && (c.off(), this.off(), b && (b.detachMedia(), b.off(), c.getVideo() && b.destroy()), c = null, w.off(null, null, this), w = null)
                }, a.instreamPlay = function () {
                    c.getVideo() && c.getVideo().play(!0)
                }, a.instreamPause = function () {
                    c.getVideo() && c.getVideo().pause(!0)
                }, a
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(62)], h = function (d) {
            function c(a) {
                return a === d.COMPLETE || a === d.ERROR ? d.IDLE : a
            }

            return function (b, o, n) {
                if (o = c(o), n = c(n), o !== n) {
                    var m = o.replace(/(?:ing|d)$/, ""),
                        l = {type: m, newstate: o, oldstate: n, reason: b.mediaModel.get("state")};
                    "play" === m && (l.playReason = b.get("playReason")), this.trigger(m, l)
                }
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(78), k(89), k(90), k(45), k(47), k(91), k(46), k(62)], h = function (x, w, v, u, t, s, r, q, p) {
            var o = ["volume", "mute", "captionLabel", "qualityLabel"], n = function () {
                function c(z, y) {
                    switch (z) {
                        case"flashThrottle":
                            var D = "resume" !== y.state;
                            this.set("flashThrottle", D), this.set("flashBlocked", D);
                            break;
                        case"flashBlocked":
                            return void this.set("flashBlocked", !0);
                        case"flashUnblocked":
                            return void this.set("flashBlocked", !1);
                        case"volume":
                        case"mute":
                            return void this.set(z, y[z]);
                        case q.JWPLAYER_MEDIA_TYPE:
                            this.mediaModel.set("mediaType", y.mediaType);
                            break;
                        case q.JWPLAYER_PLAYER_STATE:
                            return void this.mediaModel.set("state", y.newstate);
                        case q.JWPLAYER_MEDIA_BUFFER:
                            this.set("buffer", y.bufferPercent);
                        case q.JWPLAYER_MEDIA_META:
                            var C = y.duration;
                            t.isNumber(C) && (this.mediaModel.set("duration", C), this.set("duration", C));
                            break;
                        case q.JWPLAYER_MEDIA_BUFFER_FULL:
                            this.mediaModel.get("playAttempt") ? this.playVideo() : this.mediaModel.on("change:playAttempt", function () {
                                this.playVideo()
                            }, this);
                            break;
                        case q.JWPLAYER_MEDIA_TIME:
                            this.mediaModel.set("position", y.position), this.set("position", y.position), t.isNumber(y.duration) && (this.mediaModel.set("duration", y.duration), this.set("duration", y.duration));
                            break;
                        case q.JWPLAYER_PROVIDER_CHANGED:
                            this.set("provider", a.getName());
                            break;
                        case q.JWPLAYER_MEDIA_LEVELS:
                            this.setQualityLevel(y.currentQuality, y.levels), this.mediaModel.set("levels", y.levels);
                            break;
                        case q.JWPLAYER_MEDIA_LEVEL_CHANGED:
                            this.setQualityLevel(y.currentQuality, y.levels), this.persistQualityLevel(y.currentQuality, y.levels);
                            break;
                        case q.JWPLAYER_AUDIO_TRACKS:
                            this.setCurrentAudioTrack(y.currentTrack, y.tracks), this.mediaModel.set("audioTracks", y.tracks);
                            break;
                        case q.JWPLAYER_AUDIO_TRACK_CHANGED:
                            this.setCurrentAudioTrack(y.currentTrack, y.tracks);
                            break;
                        case"subtitlesTrackChanged":
                            this.setVideoSubtitleTrack(y.currentTrack, y.tracks);
                            break;
                        case"visualQuality":
                            var B = t.extend({}, y);
                            this.mediaModel.set("visualQuality", B)
                    }
                    var A = t.extend({}, y, {type: z});
                    this.mediaController.trigger(z, A)
                }

                var b, a, l = this, d = x.noop;
                this.mediaController = t.extend({}, s), this.mediaModel = new m, u.model(this), this.set("mediaModel", this.mediaModel), this.setup = function (y) {
                    var z = new v;
                    return z.track(o, this), t.extend(this.attributes, z.getAllItems(), y, {
                        item: 0,
                        state: p.IDLE,
                        flashBlocked: !1,
                        fullscreen: !1,
                        compactUI: !1,
                        scrubbing: !1,
                        duration: 0,
                        position: 0,
                        buffer: 0
                    }), x.isMobile() && !y.mobileSdk && this.set("autostart", !1), this.updateProviders(), this
                }, this.getConfiguration = function () {
                    return t.omit(this.clone(), ["mediaModel"])
                }, this.updateProviders = function () {
                    b = new w(this.getConfiguration())
                }, this.setQualityLevel = function (z, y) {
                    z > -1 && y.length > 1 && "youtube" !== a.getName().name && this.mediaModel.set("currentLevel", parseInt(z))
                }, this.persistQualityLevel = function (z, y) {
                    var B = y[z] || {}, A = B.label;
                    this.set("qualityLabel", A)
                }, this.setCurrentAudioTrack = function (z, y) {
                    z > -1 && y.length > 0 && z < y.length && this.mediaModel.set("currentAudioTrack", parseInt(z))
                }, this.onMediaContainer = function () {
                    var y = this.get("mediaContainer");
                    d.setContainer(y)
                }, this.changeVideoProvider = function (z) {
                    this.off("change:mediaContainer", this.onMediaContainer), a && (a.off(null, null, this), a.getContainer() && a.remove()), d = new z(l.get("id"), l.getConfiguration());
                    var y = this.get("mediaContainer");
                    y ? d.setContainer(y) : this.once("change:mediaContainer", this.onMediaContainer), this.set("provider", d.getName()), -1 === d.getName().name.indexOf("flash") && (this.set("flashThrottle", void 0), this.set("flashBlocked", !1)), a = d, a.volume(l.get("volume")), a.mute(l.get("mute")), a.on("all", c, this)
                }, this.destroy = function () {
                    this.off(), a && (a.off(null, null, this), a.destroy())
                }, this.getVideo = function () {
                    return a
                }, this.setFullscreen = function (y) {
                    y = !!y, y !== l.get("fullscreen") && l.set("fullscreen", y)
                }, this.chooseProvider = function (y) {
                    return b.choose(y).provider
                }, this.setActiveItem = function (z) {
                    this.mediaModel.off(), this.mediaModel = new m, this.set("mediaModel", this.mediaModel);
                    var y = z && z.sources && z.sources[0];
                    if (void 0 !== y) {
                        var A = this.chooseProvider(y);
                        if (!A) {
                            throw new Error("No suitable provider found")
                        }
                        d instanceof A || l.changeVideoProvider(A), d.init && d.init(z), this.trigger("itemReady", z)
                    }
                }, this.getProviders = function () {
                    return b
                }, this.resetProvider = function () {
                    d = null
                }, this.setVolume = function (z) {
                    z = Math.round(z), l.set("volume", z), a && a.volume(z);
                    var y = 0 === z;
                    y !== l.get("mute") && l.setMute(y)
                }, this.setMute = function (y) {
                    if (x.exists(y) || (y = !l.get("mute")), l.set("mute", y), a && a.mute(y), !y) {
                        var z = Math.max(10, l.get("volume"));
                        this.setVolume(z)
                    }
                }, this.loadVideo = function (z) {
                    if (this.mediaModel.set("playAttempt", !0), this.mediaController.trigger(q.JWPLAYER_MEDIA_PLAY_ATTEMPT, {playReason: this.get("playReason")}), !z) {
                        var y = this.get("item");
                        z = this.get("playlist")[y]
                    }
                    this.set("position", z.starttime || 0), this.set("duration", z.duration || 0), a.load(z)
                }, this.stopVideo = function () {
                    a && a.stop()
                }, this.playVideo = function () {
                    a.play()
                }, this.persistCaptionsTrack = function () {
                    var y = this.get("captionsTrack");
                    y ? this.set("captionLabel", y.label) : this.set("captionLabel", "Off")
                }, this.setVideoSubtitleTrack = function (z, y) {
                    this.set("captionsIndex", z), z && y && z <= y.length && y[z - 1].data && this.set("captionsTrack", y[z - 1]), a && a.setSubtitlesTrack && a.setSubtitlesTrack(z)
                }, this.persistVideoSubtitleTrack = function (y) {
                    this.setVideoSubtitleTrack(y), this.persistCaptionsTrack()
                }
            }, m = n.MediaModel = function () {
                this.set("state", p.IDLE)
            };
            return t.extend(n.prototype, r), t.extend(m.prototype, r), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(79)], h = function (b) {
            return b.prototype.providerSupports = function (d, c) {
                return d.supports(c, this.config.edition)
            }, b
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(80), k(84), k(45)], h = function (m, l, q) {
            function p(a) {
                this.providers = m.slice(), this.config = a || {}, "flash" === this.config.primary && n(this.providers, "html5", "flash")
            }

            function o(r, d) {
                for (var s = 0; s < r.length; s++) {
                    if (r[s].name === d) {
                        return s
                    }
                }
                return -1
            }

            function n(s, r, w) {
                var v = o(s, r), u = o(s, w), t = s[v];
                s[v] = s[u], s[u] = t
            }

            return q.extend(p.prototype, {
                providerSupports: function (d, c) {
                    return d.supports(c)
                }, choose: function (b) {
                    b = q.isObject(b) ? b : {};
                    for (var t = this.providers.length, s = 0; t > s; s++) {
                        var r = this.providers[s];
                        if (this.providerSupports(r, b)) {
                            var c = t - s - 1;
                            return {priority: c, name: r.name, type: b.type, provider: l[r.name]}
                        }
                    }
                    return null
                }
            }), p
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(81), k(45), k(82)], h = function (m, l, r, q) {
            function p(t, s) {
                var b = l(s);
                if (!b("dash")) {
                    return !1
                }
                if (t.drm && !b("drm")) {
                    return !1
                }
                if (!window.MediaSource) {
                    return !1
                }
                if (!m.isChrome() && !m.isIETrident(11)) {
                    return !1
                }
                var a = t.file || "";
                return "dash" === t.type || "mpd" === t.type || a.indexOf(".mpd") > -1 || a.indexOf("mpd-time-csf") > -1
            }

            var o = r.find(q, r.matches({name: "flash"})), n = o.supports;
            return o.supports = function (t, s) {
                if (!m.isFlashSupported()) {
                    return !1
                }
                var b = t && t.type;
                if ("hls" === b || "m3u8" === b) {
                    var a = l(s);
                    return a("hls")
                }
                return n.apply(this, arguments)
            }, q.push({name: "dashjs", supports: r.constant(!1)}), q.push({name: "shaka", supports: p}), q
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (t) {
            var s = "free", r = "premium", q = "enterprise", p = "ads", o = "unlimited", n = "trial", m = {
                setup: [s, r, q, p, o, n],
                dash: [r, q, p, o, n],
                drm: [q, p, o, n],
                hls: [r, p, q, o, n],
                ads: [p, o, n],
                casting: [r, q, p, o, n],
                jwpsrv: [s, r, q, p, n]
            }, l = function (a) {
                return function (b) {
                    return t.contains(m[b], a)
                }
            };
            return l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(45), k(83)], h = function (m, l, p) {
            function o(a) {
                if ("hls" === a.type) {
                    if (a.androidhls !== !1) {
                        var d = m.isAndroidNative;
                        if (d(2) || d(3) || d("4.0")) {
                            return !1
                        }
                        if (m.isAndroid()) {
                            return !0
                        }
                    } else {
                        if (m.isAndroid()) {
                            return !1
                        }
                    }
                }
                return null
            }

            var n = [{
                name: "youtube", supports: function (a) {
                    return m.isYouTube(a.file, a.type)
                }
            }, {
                name: "html5", supports: function (a) {
                    var s = {
                        aac: "audio/mp4",
                        mp4: "video/mp4",
                        f4v: "video/mp4",
                        m4v: "video/mp4",
                        mov: "video/mp4",
                        mp3: "audio/mpeg",
                        mpeg: "audio/mpeg",
                        ogv: "video/ogg",
                        ogg: "video/ogg",
                        oga: "video/ogg",
                        vorbis: "video/ogg",
                        webm: "video/webm",
                        f4a: "video/aac",
                        m3u8: "application/vnd.apple.mpegurl",
                        m3u: "application/vnd.apple.mpegurl",
                        hls: "application/vnd.apple.mpegurl"
                    }, r = a.file, q = a.type, d = o(a);
                    if (null !== d) {
                        return d
                    }
                    if (m.isRtmp(r, q)) {
                        return !1
                    }
                    if (!s[q]) {
                        return !1
                    }
                    if (p.canPlayType) {
                        var c = p.canPlayType(s[q]);
                        return !!c
                    }
                    return !1
                }
            }, {
                name: "flash", supports: function (s) {
                    var r = {
                        flv: "video",
                        f4v: "video",
                        mov: "video",
                        m4a: "video",
                        m4v: "video",
                        mp4: "video",
                        aac: "video",
                        f4a: "video",
                        mp3: "sound",
                        mpeg: "sound",
                        smil: "rtmp"
                    }, q = l.keys(r);
                    if (!m.isFlashSupported()) {
                        return !1
                    }
                    var b = s.file, a = s.type;
                    return m.isRtmp(b, a) ? !0 : l.contains(q, a)
                }
            }];
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return document.createElement("video")
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(85), k(87)], h = function (l, d) {
            var m = {html5: l, flash: d};
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(55), k(48), k(45), k(46), k(62), k(86), k(47)], h = function (X, W, V, U, T, S, R) {
            function Q(b, d) {
                W.foreach(b, function (l, c) {
                    d.addEventListener(l, c, !1)
                })
            }

            function P(b, d) {
                W.foreach(b, function (l, c) {
                    d.removeEventListener(l, c, !1)
                })
            }

            function O(l, d, m) {
                "addEventListener" in l ? l.addEventListener(d, m) : l["on" + d] = m
            }

            function N(l, d, m) {
                l && ("removeEventListener" in l ? l.removeEventListener(d, m) : l["on" + d] = null)
            }

            function M(b) {
                if ("hls" === b.type) {
                    if (b.androidhls !== !1) {
                        var d = W.isAndroidNative;
                        if (d(2) || d(3) || d("4.0")) {
                            return !1
                        }
                        if (W.isAndroid()) {
                            return !0
                        }
                    } else {
                        if (W.isAndroid()) {
                            return !1
                        }
                    }
                }
                return null
            }

            function L(ae, ac) {
                function ab() {
                    aM(aV.audioTracks), bb(aV.textTracks)
                }

                function aR(m) {
                    aH.trigger("click", m)
                }

                function aQ() {
                    aO && !v && (aG(aI()), aK(r(), aU, a4))
                }

                function aP() {
                    aO && aK(r(), aU, a4)
                }

                function aN() {
                    K(a9), t = !0, aO && (aH.state === T.STALLED ? aH.setState(T.PLAYING) : aH.state === T.PLAYING && (a9 = setTimeout(ad, J)), v && aV.duration === 1 / 0 && 0 === aV.currentTime || (aG(aI()), aJ(aV.currentTime), aK(r(), aU, a4), aH.state === T.PLAYING && (aH.trigger(U.JWPLAYER_MEDIA_TIME, {
                        position: aU,
                        duration: a4
                    }), aL())))
                }

                function aL() {
                    var m = b.level;
                    if (m.width !== aV.videoWidth || m.height !== aV.videoHeight) {
                        if (m.width = aV.videoWidth, m.height = aV.videoHeight, ak(), !m.width || !m.height) {
                            return
                        }
                        b.reason = b.reason || "auto", b.mode = "hls" === aY[ai].type ? "auto" : "manual", b.bitrate = 0, m.index = ai, m.label = aY[ai].label, aH.trigger("visualQuality", b), b.reason = ""
                    }
                }

                function aK(y, m, Y) {
                    y === a0 && Y === a4 || (a0 = y, aH.trigger(U.JWPLAYER_MEDIA_BUFFER, {
                        bufferPercent: 100 * y,
                        position: m,
                        duration: Y
                    }))
                }

                function aJ(m) {
                    0 > a4 && (m = -(aj() - m)), aU = m
                }

                function aI() {
                    var y = aV.duration, m = aj();
                    if (y === 1 / 0 && m) {
                        var Y = m - aV.seekable.start(0);
                        Y !== 1 / 0 && Y > 120 && (y = -Y)
                    }
                    return y
                }

                function aG(m) {
                    a4 = m, l && m && m !== 1 / 0 && aH.seek(l)
                }

                function aE() {
                    var m = aI();
                    v && m === 1 / 0 && (m = 0), aH.trigger(U.JWPLAYER_MEDIA_META, {
                        duration: m,
                        height: aV.videoHeight,
                        width: aV.videoWidth
                    }), aG(m)
                }

                function aD() {
                    aO && (t = !0, aB())
                }

                function aC() {
                    aO && (aV.muted && (aV.muted = !1, aV.muted = !0), ak(), aE())
                }

                function aB() {
                    a7 || (a7 = !0, aH.trigger(U.JWPLAYER_MEDIA_BUFFER_FULL))
                }

                function aA() {
                    aH.setState(T.PLAYING), aV.hasAttribute("hasplayed") || aV.setAttribute("hasplayed", ""), aH.trigger(U.JWPLAYER_PROVIDER_FIRST_FRAME, {})
                }

                function az() {
                    aH.state !== T.COMPLETE && aV.currentTime !== aV.duration && aH.setState(T.PAUSED)
                }

                function ax() {
                    v || aV.paused || aV.ended || aH.state !== T.LOADING && aH.state !== T.ERROR && (aH.seeking || aH.setState(T.STALLED))
                }

                function aw() {
                    aO && (W.log("Error playing media: %o %s", aV.error, aV.src || a.file), aH.trigger(U.JWPLAYER_MEDIA_ERROR, {message: "Error loading media: File could not be played"}))
                }

                function av(m) {
                    var y;
                    return "array" === W.typeOf(m) && m.length > 0 && (y = V.map(m, function (Z, Y) {
                        return {label: Z.label || Y}
                    })), y
                }

                function au(y) {
                    aY = y, ai = at(y);
                    var m = av(y);
                    m && aH.trigger(U.JWPLAYER_MEDIA_LEVELS, {levels: m, currentQuality: ai})
                }

                function at(y) {
                    var m = Math.max(0, ai), Z = ac.qualityLabel;
                    if (y) {
                        for (var Y = 0; Y < y.length; Y++) {
                            if (y[Y]["default"] && (m = Y), Z && y[Y].label === Z) {
                                return Y
                            }
                        }
                    }
                    return b.reason = "initial choice", b.level = {width: 0, height: 0}, m
                }

                function ar() {
                    return G || F
                }

                function aq(m, aa, Z) {
                    a = aY[ai], l = 0, K(a9);
                    var Y = document.createElement("source");
                    Y.src = a.file;
                    var y = aV.src !== Y.src;
                    y || ar() ? (a4 = aa, ap(Z), aV.load()) : (0 === m && 0 !== aV.currentTime && (l = -1, aH.seek(m)), aV.play()), aU = aV.currentTime, G && (aB(), aV.paused || aH.state === T.PLAYING || aH.setState(T.LOADING)), W.isIOS() && aH.getFullScreen() && (aV.controls = !0), m > 0 && aH.seek(m)
                }

                function ap(m) {
                    if (a3 = null, aT = null, x = -1, al = -1, q = -1, b.reason || (b.reason = "initial choice", b.level = {
                        width: 0,
                        height: 0
                    }), t = !1, a7 = !1, v = M(a), aV.src = a.file, a.preload && aV.setAttribute("preload", a.preload), m && m.tracks) {
                        var y = W.isIOS() && !W.isSDK(ac);
                        y && an(m.tracks)
                    }
                }

                function ao() {
                    aV && (aV.removeAttribute("src"), !H && aV.load && aV.load())
                }

                function an(m) {
                    for (; aV.firstChild;) {
                        aV.removeChild(aV.firstChild)
                    }
                    am(m)
                }

                function am(y) {
                    if (y) {
                        aV.setAttribute("crossorigin", "anonymous");
                        for (var m = 0; m < y.length; m++) {
                            if (-1 !== y[m].file.indexOf(".vtt") && /subtitles|captions|descriptions|chapters|metadata/.test(y[m].kind)) {
                                var Y = document.createElement("track");
                                Y.src = y[m].file, Y.kind = y[m].kind, Y.srclang = y[m].language || "", Y.label = y[m].label, Y.mode = "disabled", aV.appendChild(Y)
                            }
                        }
                    }
                }

                function a1() {
                    for (var y = aV.seekable ? aV.seekable.length : 0, m = 1 / 0; y--;) {
                        m = Math.min(m, aV.seekable.start(y))
                    }
                    return m
                }

                function aj() {
                    for (var y = aV.seekable ? aV.seekable.length : 0, m = 0; y--;) {
                        m = Math.max(m, aV.seekable.end(y))
                    }
                    return m
                }

                function aW() {
                    aH.seeking = !1, aH.trigger(U.JWPLAYER_MEDIA_SEEKED)
                }

                function ay() {
                    aH.trigger("volume", {volume: Math.round(100 * aV.volume)}), aH.trigger("mute", {mute: aV.muted})
                }

                function ad() {
                    aV.currentTime === aU && ax()
                }

                function r() {
                    var m = aV.buffered, y = aV.duration;
                    return !m || 0 === m.length || 0 >= y || y === 1 / 0 ? 0 : W.between(m.end(m.length - 1) / y, 0, 1)
                }

                function c() {
                    if (aO && aH.state !== T.IDLE && aH.state !== T.COMPLETE) {
                        if (K(a9), ai = -1, o = !0, aH.trigger(U.JWPLAYER_MEDIA_BEFORECOMPLETE), !aO) {
                            return
                        }
                        a6()
                    }
                }

                function a6() {
                    K(a9), aH.setState(T.COMPLETE), o = !1, aH.trigger(U.JWPLAYER_MEDIA_COMPLETE)
                }

                function aX(m) {
                    bc = !0, aZ(m), W.isIOS() && (aV.controls = !1)
                }

                function aF() {
                    var y = -1, m = 0;
                    if (a3) {
                        for (m; m < a3.length; m++) {
                            if ("showing" === a3[m].mode) {
                                y = m;
                                break
                            }
                        }
                    }
                    a2(y + 1)
                }

                function af() {
                    for (var y = -1, m = 0; m < aV.audioTracks.length; m++) {
                        if (aV.audioTracks[m].enabled) {
                            y = m;
                            break
                        }
                    }
                    ah(y)
                }

                function s(m) {
                    d(m.currentTarget.activeCues)
                }

                function d(y) {
                    if (y && y.length && q !== y[0].startTime) {
                        var m = {
                            TIT2: "title",
                            TT2: "title",
                            WXXX: "url",
                            TPE1: "artist",
                            TP1: "artist",
                            TALB: "album",
                            TAL: "album"
                        }, aa = function (bd, ba) {
                            var bj, bi, bh, bg, bf, be;
                            for (bj = "", bh = bd.length, bi = ba || 0; bh > bi;) {
                                switch (bg = bd[bi++], bg >> 4) {
                                    case 0:
                                    case 1:
                                    case 2:
                                    case 3:
                                    case 4:
                                    case 5:
                                    case 6:
                                    case 7:
                                        bj += String.fromCharCode(bg);
                                        break;
                                    case 12:
                                    case 13:
                                        bf = bd[bi++], bj += String.fromCharCode((31 & bg) << 6 | 63 & bf);
                                        break;
                                    case 14:
                                        bf = bd[bi++], be = bd[bi++], bj += String.fromCharCode((15 & bg) << 12 | (63 & bf) << 6 | (63 & be) << 0)
                                }
                            }
                            return bj
                        }, Z = function (bd, ba) {
                            var bg, bf, be;
                            for (bg = "", be = bd.length, bf = ba || 0; be > bf;) {
                                254 === bd[bf] && 255 === bd[bf + 1] || (bg += String.fromCharCode((bd[bf] << 8) + bd[bf + 1])), bf += 2
                            }
                            return bg
                        }, Y = V.reduce(y, function (ba, bi) {
                            if (!("value" in bi) && "data" in bi && bi.data instanceof ArrayBuffer) {
                                var bh = bi, bg = new Uint8Array(bh.data);
                                bi = {value: {key: "", data: ""}};
                                for (var bf = 10; 14 > bf && bf < bg.length && 0 !== bg[bf];) {
                                    bi.value.key += String.fromCharCode(bg[bf]), bf++
                                }
                                var be = bg[20];
                                1 === be || 2 === be ? bi.value.data = Z(bg, 21) : bi.value.data = aa(bg, 21)
                            }
                            if (m.hasOwnProperty(bi.value.key) && (ba[m[bi.value.key]] = bi.value.data), bi.value.info) {
                                var bd = ba[bi.value.key];
                                V.isObject(bd) || (bd = {}, ba[bi.value.key] = bd), bd[bi.value.info] = bi.value.data
                            } else {
                                ba[bi.value.key] = bi.value.data
                            }
                            return ba
                        }, {});
                        q = y[0].startTime, aH.trigger("meta", {metadataTime: q, metadata: Y})
                    }
                }

                function a8(m) {
                    bc = !1, aZ(m), W.isIOS() && (aV.controls = !1)
                }

                function aZ(m) {
                    aH.trigger("fullscreenchange", {target: m.target, jwstate: bc})
                }

                function aM(y) {
                    if (aT = null, y) {
                        if (y.length) {
                            for (var m = 0; m < y.length; m++) {
                                if (y[m].enabled) {
                                    x = m;
                                    break
                                }
                            }
                            -1 === x && (x = 0, y[x].enabled = !0), aT = V.map(y, function (Z) {
                                var Y = {name: Z.label || Z.language, language: Z.language};
                                return Y
                            })
                        }
                        O(y, "change", af), aT && aH.trigger("audioTracks", {currentTrack: x, tracks: aT})
                    }
                }

                function ah(m) {
                    aV && aV.audioTracks && aT && m > -1 && m < aV.audioTracks.length && m !== x && (aV.audioTracks[x].enabled = !1, x = m, aV.audioTracks[x].enabled = !0, aH.trigger("audioTrackChanged", {
                        currentTrack: x,
                        tracks: aT
                    }))
                }

                function u() {
                    return aT || []
                }

                function n() {
                    return x
                }

                function bb(y) {
                    if (a3 = null, y) {
                        if (y.length) {
                            var m = 0, Y = y.length;
                            for (m; Y > m; m++) {
                                "metadata" === y[m].kind ? (y[m].oncuechange = s, y[m].mode = "showing") : "subtitles" !== y[m].kind && "captions" !== y[m].kind || (y[m].mode = "disabled", a3 || (a3 = []), a3.push(y[m]))
                            }
                        }
                        O(y, "change", aF), a3 && a3.length && aH.trigger("subtitlesTracks", {tracks: a3})
                    }
                }

                function a2(m) {
                    a3 && al !== m - 1 && (al > -1 && al < a3.length ? a3[al].mode = "disabled" : V.each(a3, function (y) {
                        y.mode = "disabled"
                    }), m > 0 && m <= a3.length ? (al = m - 1, a3[al].mode = "showing") : al = -1, aH.trigger("subtitlesTrackChanged", {
                        currentTrack: al + 1,
                        tracks: a3
                    }))
                }

                function aS() {
                    return al
                }

                function ak() {
                    if ("hls" === aY[0].type) {
                        var m = "video";
                        0 === aV.videoWidth && (m = "audio"), aH.trigger("mediaType", {mediaType: m})
                    }
                }

                function w() {
                    a3 && a3[al] && (a3[al].mode = "disabled")
                }

                this.state = T.IDLE, this.seeking = !1, V.extend(this, R), this.trigger = function (y, m) {
                    return aO ? R.trigger.call(this, y, m) : void 0
                }, this.setState = function (m) {
                    return aO ? S.setState.call(this, m) : void 0
                };
                var p, a, a4, aU, a7, aY, aH = this, ag = {
                        click: aR,
                        durationchange: aQ,
                        ended: c,
                        error: aw,
                        loadeddata: ab,
                        loadedmetadata: aC,
                        canplay: aD,
                        playing: aA,
                        progress: aP,
                        pause: az,
                        seeked: aW,
                        timeupdate: aN,
                        volumechange: ay,
                        webkitbeginfullscreen: aX,
                        webkitendfullscreen: a8
                    }, t = !1, l = 0, a9 = -1, a0 = -1, aO = !0, ai = -1, v = null, o = !1, bc = !1, a3 = null, aT = null,
                    al = -1, x = -1, q = -1, b = {level: {}}, a5 = document.getElementById(ae),
                    aV = a5 ? a5.querySelector("video") : void 0;
                aV = aV || document.createElement("video"), aV.className = "jw-video jw-reset", Q(ag, aV), C || (aV.controls = !0, aV.controls = !1), aV.setAttribute("x-webkit-airplay", "allow"), aV.setAttribute("webkit-playsinline", ""), this.stop = function () {
                    K(a9), aO && (ao(), W.isIETrident() && aV.pause(), ai = -1, this.setState(T.IDLE))
                }, this.destroy = function () {
                    P(ag, aV), N(aV.audioTracks, "change", af), N(aV.textTracks, "change", aF), this.remove(), this.off()
                }, this.init = function (m) {
                    aO && (aY = m.sources, ai = at(m.sources), m.sources.length && "hls" !== m.sources[0].type && this.sendMediaType(m.sources), a = aY[ai], aU = m.starttime || 0, a4 = m.duration || 0, b.reason = "", ap(m))
                }, this.load = function (m) {
                    aO && (au(m.sources), m.sources.length && "hls" !== m.sources[0].type && this.sendMediaType(m.sources), G && !aV.hasAttribute("hasplayed") || aH.setState(T.LOADING), aq(m.starttime || 0, m.duration || 0, m))
                }, this.play = function () {
                    return aH.seeking ? (aH.setState(T.LOADING), void aH.once(U.JWPLAYER_MEDIA_SEEKED, aH.play)) : void aV.play()
                }, this.pause = function () {
                    K(a9), aV.pause(), this.setState(T.PAUSED)
                }, this.seek = function (y) {
                    if (aO) {
                        if (0 > y && (y += a1() + aj()), 0 === l && this.trigger(U.JWPLAYER_MEDIA_SEEK, {
                            position: aV.currentTime,
                            offset: y
                        }), t || (t = !!aj()), t) {
                            l = 0;
                            try {
                                aH.seeking = !0, aV.currentTime = y
                            } catch (m) {
                                aH.seeking = !1, l = y
                            }
                        } else {
                            l = y, E && aV.paused && aV.play()
                        }
                    }
                }, this.volume = function (m) {
                    m = W.between(m / 100, 0, 1), aV.volume = m
                }, this.mute = function (m) {
                    aV.muted = !!m
                }, this.checkComplete = function () {
                    return o
                }, this.detachMedia = function () {
                    return K(a9), w(), aO = !1, aV
                }, this.attachMedia = function () {
                    aO = !0, t = !1, this.seeking = !1, aV.loop = !1, o && a6()
                }, this.setContainer = function (m) {
                    p = m, m.appendChild(aV)
                }, this.getContainer = function () {
                    return p
                }, this.remove = function () {
                    ao(), K(a9), ai = -1, p === aV.parentNode && p.removeChild(aV)
                }, this.setVisibility = function (m) {
                    m = !!m, m || D ? X.style(p, {visibility: "visible", opacity: 1}) : X.style(p, {
                        visibility: "",
                        opacity: 0
                    })
                }, this.resize = function (bh, bg, bf) {
                    if (!(bh && bg && aV.videoWidth && aV.videoHeight)) {
                        return !1
                    }
                    var be = {objectFit: ""};
                    if ("uniform" === bf) {
                        var bd = bh / bg, ba = aV.videoWidth / aV.videoHeight;
                        Math.abs(bd - ba) < 0.09 && (be.objectFit = "fill", bf = "exactfit")
                    }
                    var aa = I || D || C || B;
                    if (aa) {
                        var Z = -Math.floor(aV.videoWidth / 2 + 1), Y = -Math.floor(aV.videoHeight / 2 + 1),
                            y = Math.ceil(100 * bh / aV.videoWidth) / 100,
                            m = Math.ceil(100 * bg / aV.videoHeight) / 100;
                        "none" === bf ? y = m = 1 : "fill" === bf ? y = m = Math.max(y, m) : "uniform" === bf && (y = m = Math.min(y, m)), be.width = aV.videoWidth, be.height = aV.videoHeight, be.top = be.left = "50%", be.margin = 0, X.transform(aV, "translate(" + Z + "px, " + Y + "px) scale(" + y.toFixed(2) + ", " + m.toFixed(2) + ")")
                    }
                    return X.style(aV, be), !1
                }, this.setFullscreen = function (m) {
                    if (m = !!m) {
                        var Y = W.tryCatch(function () {
                            var Z = aV.webkitEnterFullscreen || aV.webkitEnterFullScreen;
                            Z && Z.apply(aV)
                        });
                        return Y instanceof W.Error ? !1 : aH.getFullScreen()
                    }
                    var y = aV.webkitExitFullscreen || aV.webkitExitFullScreen;
                    return y && y.apply(aV), m
                }, aH.getFullScreen = function () {
                    return bc || !!aV.webkitDisplayingFullscreen
                }, this.setCurrentQuality = function (y) {
                    if (ai !== y && (y = parseInt(y, 10), y >= 0 && aY && aY.length > y)) {
                        ai = y, b.reason = "api", b.level = {
                            width: 0,
                            height: 0
                        }, this.trigger(U.JWPLAYER_MEDIA_LEVEL_CHANGED, {
                            currentQuality: y,
                            levels: av(aY)
                        }), ac.qualityLabel = aY[y].label;
                        var m = aV.currentTime || 0, Y = aV.duration || 0;
                        0 >= Y && (Y = a4), aH.setState(T.LOADING), aq(m, Y)
                    }
                }, this.getCurrentQuality = function () {
                    return ai
                }, this.getQualityLevels = function () {
                    return av(aY)
                }, this.getName = function () {
                    return {name: A}
                }, this.setCurrentAudioTrack = ah, this.getAudioTracks = u, this.getCurrentAudioTrack = n, this.setSubtitlesTrack = a2, this.getSubtitlesTrack = aS
            }

            var K = window.clearTimeout, J = 256, I = W.isIE(), H = W.isMSIE(), G = W.isMobile(), F = W.isSafari(),
                E = W.isFF(), D = W.isAndroidNative(), C = W.isIOS(7), B = W.isIOS(8), A = "html5", z = function () {
                };
            return z.prototype = S, L.prototype = new z, L
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(46), k(62), k(45)], h = function (m, l, r, q) {
            var p = m.noop, o = q.constant(!1), n = {
                supports: o,
                play: p,
                load: p,
                stop: p,
                volume: p,
                mute: p,
                seek: p,
                resize: p,
                remove: p,
                destroy: p,
                setVisibility: p,
                setFullscreen: o,
                getFullscreen: p,
                getContainer: p,
                setContainer: o,
                getName: p,
                getQualityLevels: p,
                getCurrentQuality: p,
                setCurrentQuality: p,
                getAudioTracks: p,
                getCurrentAudioTrack: p,
                setCurrentAudioTrack: p,
                checkComplete: p,
                setControls: p,
                attachMedia: p,
                detachMedia: p,
                setState: function (b) {
                    var c = this.state || r.IDLE;
                    this.state = b, b !== c && this.trigger(l.JWPLAYER_PLAYER_STATE, {newstate: b})
                },
                sendMediaType: function (b) {
                    var t = b[0].type, s = "oga" === t || "aac" === t || "mp3" === t || "mpeg" === t || "vorbis" === t;
                    this.trigger(l.JWPLAYER_MEDIA_TYPE, {mediaType: s ? "audio" : "video"})
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(45), k(46), k(62), k(88), k(86), k(47)], h = function (x, w, v, u, t, s, r) {
            function q(b) {
                return b + "_swf_" + n++
            }

            function p(a) {
                var y = document.createElement("a");
                y.href = a.flashplayer;
                var l = y.hostname === window.location.host;
                return x.isChrome() && !l
            }

            function o(aa, Z) {
                function Y(y) {
                    if (H) {
                        for (var l = 0; l < y.length; l++) {
                            var A = y[l];
                            if (A.bitrate) {
                                var z = Math.round(A.bitrate / 1000);
                                A.label = X(z)
                            }
                        }
                    }
                }

                function X(y) {
                    var l = H[y];
                    if (!l) {
                        for (var B = 1 / 0, A = H.bitrates.length; A--;) {
                            var z = Math.abs(H.bitrates[A] - y);
                            if (z > B) {
                                break
                            }
                            B = z
                        }
                        l = H.labels[H.bitrates[A + 1]], H[y] = l
                    }
                    return l
                }

                function W() {
                    var y = Z.hlslabels;
                    if (!y) {
                        return null
                    }
                    var l = {}, C = [];
                    for (var B in y) {
                        var A = parseFloat(B);
                        if (!isNaN(A)) {
                            var z = Math.round(A);
                            l[z] = y[B], C.push(z)
                        }
                    }
                    return 0 === C.length ? null : (C.sort(function (E, D) {
                        return E - D
                    }), {labels: l, bitrates: C})
                }

                function V() {
                    I = setTimeout(function () {
                        r.trigger.call(N, "flashBlocked")
                    }, 4000), O.once("embedded", function () {
                        S(), r.trigger.call(N, "flashUnblocked")
                    }, N)
                }

                function U() {
                    S(), V()
                }

                function S() {
                    clearTimeout(I), window.removeEventListener("focus", U)
                }

                var Q, O, M, K = null, I = -1, d = !1, c = -1, b = null, a = -1, T = null, R = !0, P = !1, N = this,
                    L = function () {
                        return O && O.__ready
                    }, J = function () {
                        O && O.triggerFlash.apply(O, arguments)
                    }, H = W();
                w.extend(this, r, {
                    init: function (l) {
                        l.preload && "none" !== l.preload && !Z.autostart && (K = l)
                    }, load: function (l) {
                        K = l, d = !1, this.setState(u.LOADING), J("load", l), l.sources.length && "hls" !== l.sources[0].type && this.sendMediaType(l.sources)
                    }, play: function () {
                        J("play")
                    }, pause: function () {
                        J("pause"), this.setState(u.PAUSED)
                    }, stop: function () {
                        J("stop"), c = -1, K = null, this.setState(u.IDLE)
                    }, seek: function (l) {
                        J("seek", l)
                    }, volume: function (l) {
                        if (w.isNumber(l)) {
                            var y = Math.min(Math.max(0, l), 100);
                            L() && J("volume", y)
                        }
                    }, mute: function (l) {
                        L() && J("mute", l)
                    }, setState: function () {
                        return s.setState.apply(this, arguments)
                    }, checkComplete: function () {
                        return d
                    }, attachMedia: function () {
                        R = !0, d && (this.setState(u.COMPLETE), this.trigger(v.JWPLAYER_MEDIA_COMPLETE), d = !1)
                    }, detachMedia: function () {
                        return R = !1, null
                    }, getSwfObject: function (y) {
                        var l = y.getElementsByTagName("object")[0];
                        return l ? (l.off(null, null, this), l) : t.embed(Z.flashplayer, y, q(aa), Z.wmode)
                    }, getContainer: function () {
                        return Q
                    }, setContainer: function (A) {
                        if (Q !== A) {
                            Q = A, O = this.getSwfObject(A), document.hasFocus() ? V() : window.addEventListener("focus", U), O.once("ready", function () {
                                S(), O.once("pluginsLoaded", function () {
                                    O.queueCommands = !1, J("setupCommandQueue", O.__commandQueue), O.__commandQueue = []
                                });
                                var B = w.extend({}, Z), C = O.triggerFlash("setup", B);
                                C === O ? O.__ready = !0 : this.trigger(v.JWPLAYER_MEDIA_ERROR, C), K && J("init", K)
                            }, this);
                            var z = [v.JWPLAYER_MEDIA_META, v.JWPLAYER_MEDIA_ERROR, v.JWPLAYER_MEDIA_SEEK, v.JWPLAYER_MEDIA_SEEKED, "subtitlesTracks", "subtitlesTrackChanged", "subtitlesTrackData", "mediaType"],
                                y = [v.JWPLAYER_MEDIA_BUFFER, v.JWPLAYER_MEDIA_TIME],
                                l = [v.JWPLAYER_MEDIA_BUFFER_FULL];
                            O.on(v.JWPLAYER_MEDIA_LEVELS, function (B) {
                                Y(B.levels), c = B.currentQuality, b = B.levels, this.trigger(B.type, B)
                            }, this), O.on(v.JWPLAYER_MEDIA_LEVEL_CHANGED, function (B) {
                                Y(B.levels), c = B.currentQuality, b = B.levels, this.trigger(B.type, B)
                            }, this), O.on(v.JWPLAYER_AUDIO_TRACKS, function (B) {
                                a = B.currentTrack, T = B.tracks, this.trigger(B.type, B)
                            }, this), O.on(v.JWPLAYER_AUDIO_TRACK_CHANGED, function (B) {
                                a = B.currentTrack, T = B.tracks, this.trigger(B.type, B)
                            }, this), O.on(v.JWPLAYER_PLAYER_STATE, function (C) {
                                var B = C.newstate;
                                B !== u.IDLE && this.setState(B)
                            }, this), O.on(y.join(" "), function (B) {
                                "Infinity" === B.duration && (B.duration = 1 / 0), this.trigger(B.type, B)
                            }, this), O.on(z.join(" "), function (B) {
                                this.trigger(B.type, B)
                            }, this), O.on(l.join(" "), function (B) {
                                this.trigger(B.type)
                            }, this), O.on(v.JWPLAYER_MEDIA_BEFORECOMPLETE, function (B) {
                                d = !0, this.trigger(B.type), R === !0 && (d = !1)
                            }, this), O.on(v.JWPLAYER_MEDIA_COMPLETE, function (B) {
                                d || (this.setState(u.COMPLETE), this.trigger(B.type))
                            }, this), O.on("visualQuality", function (B) {
                                B.reason = B.reason || "api", this.trigger("visualQuality", B), this.trigger(v.JWPLAYER_PROVIDER_FIRST_FRAME, {})
                            }, this), O.on(v.JWPLAYER_PROVIDER_CHANGED, function (B) {
                                M = B.message, this.trigger(v.JWPLAYER_PROVIDER_CHANGED, B)
                            }, this), O.on(v.JWPLAYER_ERROR, function (B) {
                                x.log("Error playing media: %o %s", B.code, B.message, B), this.trigger(v.JWPLAYER_MEDIA_ERROR, B)
                            }, this), p(Z) && O.on("throttle", function (B) {
                                S(), "resume" === B.state ? r.trigger.call(N, "flashThrottle", B) : I = setTimeout(function () {
                                    r.trigger.call(N, "flashThrottle", B)
                                }, 250)
                            }, this)
                        }
                    }, remove: function () {
                        c = -1, b = null, t.remove(O)
                    }, setVisibility: function (l) {
                        l = !!l, Q.style.opacity = l ? 1 : 0
                    }, resize: function (y, l, z) {
                        z && J("stretch", z)
                    }, setControls: function (l) {
                        J("setControls", l)
                    }, setFullscreen: function (l) {
                        P = l, J("fullscreen", l)
                    }, getFullScreen: function () {
                        return P
                    }, setCurrentQuality: function (l) {
                        J("setCurrentQuality", l)
                    }, getCurrentQuality: function () {
                        return c
                    }, setSubtitlesTrack: function (l) {
                        J("setSubtitlesTrack", l)
                    }, getName: function () {
                        return M ? {name: "flash_" + M} : {name: "flash"}
                    }, getQualityLevels: function () {
                        return b || K.sources
                    }, getAudioTracks: function () {
                        return T
                    }, getCurrentAudioTrack: function () {
                        return a
                    }, setCurrentAudioTrack: function (l) {
                        J("setCurrentAudioTrack", l)
                    }, destroy: function () {
                        S(), this.remove(), O && (O.off(), O = null), Q = null, K = null, this.off()
                    }
                }), this.trigger = function (y, l) {
                    return R ? r.trigger.call(this, y, l) : void 0
                }
            }

            var n = 0, m = function () {
            };
            return m.prototype = s, o.prototype = new m, o
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(47), k(45)], h = function (m, l, s) {
            function r(u, t, w) {
                var v = document.createElement("param");
                v.setAttribute("name", t), v.setAttribute("value", w), u.appendChild(v)
            }

            function q(v, u, t, d) {
                var c;
                if (d = d || "opaque", m.isMSIE()) {
                    var b = document.createElement("div");
                    u.appendChild(b), b.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="' + t + '" name="' + t + '" tabindex="0"><param name="movie" value="' + v + '"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="wmode" value="' + d + '"><param name="bgcolor" value="' + n + '"><param name="menu" value="false"></object>';
                    for (var a = u.getElementsByTagName("object"), w = a.length; w--;) {
                        a[w].id === t && (c = a[w])
                    }
                } else {
                    c = document.createElement("object"), c.setAttribute("type", "application/x-shockwave-flash"), c.setAttribute("data", v), c.setAttribute("width", "100%"), c.setAttribute("height", "100%"), c.setAttribute("bgcolor", n), c.setAttribute("id", t), c.setAttribute("name", t), r(c, "allowfullscreen", "true"), r(c, "allowscriptaccess", "always"), r(c, "wmode", d), r(c, "menu", "false"), u.appendChild(c, u)
                }
                return c.className = "jw-swf jw-reset", c.style.display = "block", c.style.position = "absolute", c.style.left = 0, c.style.right = 0, c.style.top = 0, c.style.bottom = 0, s.extend(c, l), c.queueCommands = !0, c.triggerFlash = function (x) {
                    var C = this;
                    if ("setup" !== x && C.queueCommands || !C.__externalCall) {
                        for (var B = C.__commandQueue, A = B.length; A--;) {
                            B[A][0] === x && B.splice(A, 1)
                        }
                        return B.push(Array.prototype.slice.call(arguments)), C
                    }
                    var z = Array.prototype.slice.call(arguments, 1), y = m.tryCatch(function () {
                        if (z.length) {
                            for (var D = z.length; D--;) {
                                "object" == typeof z[D] && s.each(z[D], o)
                            }
                            var E = JSON.stringify(z);
                            C.__externalCall(x, E)
                        } else {
                            C.__externalCall(x)
                        }
                    });
                    return y instanceof m.Error && (console.error(x, y), "setup" === x) ? (y.name = "Failed to setup flash", y) : C
                }, c.__commandQueue = [], c
            }

            function p(b) {
                b && b.parentNode && (b.style.display = "none", b.parentNode.removeChild(b))
            }

            function o(t, d, u) {
                t instanceof window.HTMLElement && delete u[d]
            }

            var n = "#000000";
            return {embed: q, remove: p}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48)], h = function (v, u) {
            function t(b) {
                return "jwplayer." + b
            }

            function s() {
                return v.reduce(this.persistItems, function (b, w) {
                    var c = m[t(w)];
                    return c && (b[w] = u.serialize(c)), b
                }, {})
            }

            function r(w, c) {
                try {
                    m[t(w)] = c
                } catch (x) {
                    n && n.debug && console.error(x)
                }
            }

            function q() {
                v.each(this.persistItems, function (b) {
                    m.removeItem(t(b))
                })
            }

            function p() {
            }

            function o(a, d) {
                this.persistItems = a, v.each(this.persistItems, function (b) {
                    d.on("change:" + b, function (w, x) {
                        r(b, x)
                    })
                })
            }

            var n = window.jwplayer, m = {removeItem: u.noop};
            try {
                m = window.localStorage
            } catch (l) {
            }
            return v.extend(p.prototype, {getAllItems: s, track: o, clear: q}), p
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(61), k(46), k(45)], h = function (m, l, r) {
            function q(b) {
                b.mediaController.off(l.JWPLAYER_MEDIA_PLAY_ATTEMPT, b._onPlayAttempt), b.mediaController.off(l.JWPLAYER_PROVIDER_FIRST_FRAME, b._triggerFirstFrame), b.mediaController.off(l.JWPLAYER_MEDIA_TIME, b._onTime)
            }

            function p(b) {
                q(b), b._triggerFirstFrame = r.once(function () {
                    var d = b._qoeItem;
                    d.tick(l.JWPLAYER_MEDIA_FIRST_FRAME);
                    var a = d.between(l.JWPLAYER_MEDIA_PLAY_ATTEMPT, l.JWPLAYER_MEDIA_FIRST_FRAME);
                    b.mediaController.trigger(l.JWPLAYER_MEDIA_FIRST_FRAME, {loadTime: a}), q(b)
                }), b._onTime = n(b._triggerFirstFrame), b._onPlayAttempt = function () {
                    b._qoeItem.tick(l.JWPLAYER_MEDIA_PLAY_ATTEMPT)
                }, b.mediaController.on(l.JWPLAYER_MEDIA_PLAY_ATTEMPT, b._onPlayAttempt), b.mediaController.once(l.JWPLAYER_PROVIDER_FIRST_FRAME, b._triggerFirstFrame), b.mediaController.on(l.JWPLAYER_MEDIA_TIME, b._onTime)
            }

            function o(b) {
                function a(u, t, s) {
                    u._qoeItem && s && u._qoeItem.end(s.get("state")), u._qoeItem = new m, u._qoeItem.tick(l.JWPLAYER_PLAYLIST_ITEM), u._qoeItem.start(t.get("state")), p(u), t.on("change:state", function (v, c, w) {
                        u._qoeItem.end(w), u._qoeItem.start(c)
                    })
                }

                b.on("change:mediaModel", a)
            }

            var n = function (d) {
                var c = Number.MIN_VALUE;
                return function (a) {
                    a.position > c && d(), c = a.position
                }
            };
            return {model: o}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(47)], h = function (l, d) {
            var m = l.extend({
                get: function (b) {
                    return this.attributes = this.attributes || {}, this.attributes[b]
                }, set: function (o, n) {
                    if (this.attributes = this.attributes || {}, this.attributes[o] !== n) {
                        var p = this.attributes[o];
                        this.attributes[o] = n, this.trigger("change:" + o, this, n, p)
                    }
                }, clone: function () {
                    return l.clone(this.attributes)
                }
            }, d);
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(47), k(77), k(76), k(46), k(62), k(48), k(45)], h = function (m, l, s, r, q, p, o) {
            var n = function (b, t) {
                this.model = t, this._adModel = (new l).setup({
                    id: t.get("id"),
                    volume: t.get("volume"),
                    fullscreen: t.get("fullscreen"),
                    mute: t.get("mute")
                }), this._adModel.on("change:state", s, this);
                var c = b.getContainer();
                this.swf = c.querySelector("object")
            };
            return n.prototype = o.extend({
                init: function () {
                    if (p.isChrome()) {
                        var d = -1, c = !1;
                        this.swf.on("throttle", function (b) {
                            if (clearTimeout(d), "resume" === b.state) {
                                c && (c = !1, this.instreamPlay())
                            } else {
                                var a = this;
                                d = setTimeout(function () {
                                    a._adModel.get("state") === q.PLAYING && (c = !0, a.instreamPause())
                                }, 250)
                            }
                        }, this)
                    }
                    this.swf.on("instream:state", function (b) {
                        switch (b.newstate) {
                            case q.PLAYING:
                                this._adModel.set("state", b.newstate);
                                break;
                            case q.PAUSED:
                                this._adModel.set("state", b.newstate)
                        }
                    }, this).on("instream:time", function (b) {
                        this._adModel.set("position", b.position), this._adModel.set("duration", b.duration), this.trigger(r.JWPLAYER_MEDIA_TIME, b)
                    }, this).on("instream:complete", function (b) {
                        this.trigger(r.JWPLAYER_MEDIA_COMPLETE, b)
                    }, this).on("instream:error", function (b) {
                        this.trigger(r.JWPLAYER_MEDIA_ERROR, b)
                    }, this), this.swf.triggerFlash("instream:init"), this.applyProviderListeners = function (b) {
                        this.model.on("change:volume", function (a, t) {
                            b.volume(t)
                        }, this), this.model.on("change:mute", function (a, t) {
                            b.mute(t)
                        }, this)
                    }
                }, instreamDestroy: function () {
                    this._adModel && (this.off(), this.swf.off(null, null, this), this.swf.triggerFlash("instream:destroy"), this.swf = null, this._adModel.off(), this._adModel = null, this.model = null)
                }, load: function (b) {
                    this.swf.triggerFlash("instream:load", b)
                }, instreamPlay: function () {
                    this.swf.triggerFlash("instream:play")
                }, instreamPause: function () {
                    this.swf.triggerFlash("instream:pause")
                }
            }, m), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(94), k(47), k(45), k(46)], h = function (m, l, p, o) {
            var n = function (B, A, z, y) {
                function x() {
                    s("Setup Timeout Error", "Setup took longer than " + a + " seconds to complete.")
                }

                function w() {
                    p.each(c, function (b) {
                        b.complete !== !0 && b.running !== !0 && null !== B && u(b.depends) && (b.running = !0, v(b))
                    })
                }

                function v(b) {
                    var q = function (C) {
                        C = C || {}, t(b, C)
                    };
                    b.method(q, A, B, z, y)
                }

                function u(b) {
                    return p.all(b, function (q) {
                        return c[q].complete
                    })
                }

                function t(C, q) {
                    "error" === q.type ? s(q.msg, q.reason) : "complete" === q.type ? (clearTimeout(r), d.trigger(o.JWPLAYER_READY)) : (C.complete = !0, w())
                }

                function s(C, q) {
                    clearTimeout(r), d.trigger(o.JWPLAYER_SETUP_ERROR, {message: C + ": " + q}), d.destroy()
                }

                var r, d = this, c = m.getQueue(), a = 30;
                this.start = function () {
                    r = setTimeout(x, 1000 * a), w()
                }, this.destroy = function () {
                    clearTimeout(r), this.off(), c.length = 0, B = null, A = null, z = null
                }
            };
            return n.prototype = l, n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(95), k(81), k(80), k(45), k(48), k(57), k(97)], h = function (z, y, x, w, v, u, t) {
            function s(m, l, A) {
                if (l) {
                    var n = l.client;
                    delete l.client, /\.(js|swf)$/.test(n || "") || (n = u.repo() + A), m[n] = l
                }
            }

            function r(I, H) {
                var G = w.clone(H.get("plugins")) || {}, F = H.get("edition"), E = y(F), D = /^(vast|googima)$/,
                    C = /\.(js|swf)$/, B = u.repo(), A = H.get("advertising");
                if (E("ads") && A && (C.test(A.client) ? G[A.client] = A : D.test(A.client) && (G[B + A.client + ".js"] = A), delete A.client), E("jwpsrv")) {
                    var b = H.get("analytics");
                    w.isObject(b) || (b = {}), s(G, b, "jwpsrv.js")
                }
                s(G, H.get("ga"), "gapro.js"), s(G, H.get("sharing"), "sharing.js"), s(G, H.get("related"), "related.js"), H.set("plugins", G), I()
            }

            function q(a, B) {
                var A = B.get("key") || window.jwplayer && window.jwplayer.key, n = new z(A), m = n.edition();
                if (B.set("key", A), B.set("edition", m), "unlimited" === m) {
                    var l = v.getScriptPath("jwplayer.js");
                    if (!l) {
                        return void t.error(a, "Error setting up player", "Could not locate jwplayer.js script tag")
                    }
                    k.p = l, v.repo = u.repo = u.loadFrom = function () {
                        return l
                    }
                }
                B.updateProviders(), "invalid" === m ? t.error(a, "Error setting up player", (void 0 === A ? "Missing" : "Invalid") + " license key") : a()
            }

            function p(m, l, n) {
                "dashjs" === m ? k.e(4, function (b) {
                    var d = k(107);
                    d.register(window.jwplayer), n.updateProviders(), l()
                }) : k.e(5, function (b) {
                    var d = k(109);
                    d.register(window.jwplayer), n.updateProviders(), l()
                })
            }

            function o(l, d) {
                var C = d.get("playlist"), B = d.get("edition"), A = d.get("dash");
                w.contains(["shaka", "dashjs"], A) || (A = "shaka");
                var n = w.where(x, {name: A})[0].supports, m = w.some(C, function (b) {
                    return n(b, B)
                });
                m ? p(A, l, d) : l()
            }

            function c() {
                var b = t.getQueue();
                return b.LOAD_DASH = {method: o, depends: ["CHECK_KEY", "FILTER_PLAYLIST"]}, b.CHECK_KEY = {
                    method: q,
                    depends: ["LOADED_POLYFILLS"]
                }, b.FILTER_PLUGINS = {
                    method: r,
                    depends: ["CHECK_KEY"]
                }, b.FILTER_PLAYLIST.depends.push("CHECK_KEY"), b.LOAD_PLUGINS.depends.push("FILTER_PLUGINS"), b.SETUP_VIEW.depends.push("CHECK_KEY"), b.SEND_READY.depends.push("LOAD_DASH"), b
            }

            return {getQueue: c}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(96), k(81)], h = function (m, l, q) {
            var p = "invalid", o = "RnXcsftYjWRDA^Uy", n = function (r) {
                function d(w) {
                    m.exists(w) || (w = "");
                    try {
                        w = l.decrypt(w, o);
                        var v = w.split("/");
                        c = v[0], "pro" === c && (c = "premium");
                        var u = q(c);
                        if (v.length > 2 && u("setup")) {
                            b = v[1];
                            var t = parseInt(v[2]);
                            t > 0 && (a = new Date, a.setTime(t))
                        } else {
                            c = p
                        }
                    } catch (s) {
                        c = p
                    }
                }

                var c, b, a;
                this.edition = function () {
                    return a && a.getTime() < (new Date).getTime() ? p : c
                }, this.token = function () {
                    return b
                }, this.expiration = function () {
                    return a
                }, d(r)
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            var m = function (b) {
                return window.atob(b)
            }, l = function (b) {
                return unescape(encodeURIComponent(b))
            }, p = function (d) {
                try {
                    return decodeURIComponent(escape(d))
                } catch (c) {
                    return d
                }
            }, o = function (q) {
                for (var d = new Array(Math.ceil(q.length / 4)), r = 0; r < d.length; r++) {
                    d[r] = q.charCodeAt(4 * r) + (q.charCodeAt(4 * r + 1) << 8) + (q.charCodeAt(4 * r + 2) << 16) + (q.charCodeAt(4 * r + 3) << 24)
                }
                return d
            }, n = function (q) {
                for (var d = new Array(q.length), r = 0; r < q.length; r++) {
                    d[r] = String.fromCharCode(255 & q[r], q[r] >>> 8 & 255, q[r] >>> 16 & 255, q[r] >>> 24 & 255)
                }
                return d.join("")
            };
            return {
                decrypt: function (B, A) {
                    if (B = String(B), A = String(A), 0 == B.length) {
                        return ""
                    }
                    for (var z, y, x = o(m(B)), w = o(l(A).slice(0, 16)), v = x.length, u = x[v - 1], t = x[0], d = 2654435769, c = Math.floor(6 + 52 / v), b = c * d; 0 != b;) {
                        y = b >>> 2 & 3;
                        for (var a = v - 1; a >= 0; a--) {
                            u = x[a > 0 ? a - 1 : v - 1], z = (u >>> 5 ^ t << 2) + (t >>> 3 ^ u << 4) ^ (b ^ t) + (w[3 & a ^ y] ^ u), t = x[a] -= z
                        }
                        b -= d
                    }
                    var C = n(x);
                    return C = C.replace(/\0+$/, ""), p(C)
                }
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(98), k(65), k(101), k(58), k(45), k(48), k(46)], h = function (Z, Y, X, W, V, U, T) {
            function S() {
                var b = {
                    LOAD_PROMISE_POLYFILL: {method: R, depends: []},
                    LOAD_BASE64_POLYFILL: {method: Q, depends: []},
                    LOADED_POLYFILLS: {method: P, depends: ["LOAD_PROMISE_POLYFILL", "LOAD_BASE64_POLYFILL"]},
                    LOAD_PLUGINS: {method: O, depends: ["LOADED_POLYFILLS"]},
                    INIT_PLUGINS: {method: N, depends: ["LOAD_PLUGINS", "SETUP_VIEW"]},
                    LOAD_YOUTUBE: {method: E, depends: ["FILTER_PLAYLIST"]},
                    LOAD_SKIN: {method: F, depends: ["LOADED_POLYFILLS"]},
                    LOAD_PLAYLIST: {method: L, depends: ["LOADED_POLYFILLS"]},
                    FILTER_PLAYLIST: {method: J, depends: ["LOAD_PLAYLIST"]},
                    SETUP_VIEW: {method: D, depends: ["LOAD_SKIN"]},
                    SEND_READY: {method: C, depends: ["INIT_PLUGINS", "LOAD_YOUTUBE", "SETUP_VIEW"]}
                };
                return b
            }

            function R(b) {
                window.Promise ? b() : k.e(1, function (a) {
                    k(104), b()
                })
            }

            function Q(b) {
                window.btoa && window.atob ? b() : k.e(2, function (a) {
                    k(105), b()
                })
            }

            function P(b) {
                b()
            }

            function O(a, d) {
                c = Z.loadPlugins(d.get("id"), d.get("plugins")), c.on(T.COMPLETE, a), c.on(T.ERROR, V.partial(M, a)), c.load()
            }

            function N(l, d, m) {
                c.setupPlugins(m, d), l()
            }

            function M(l, d) {
                B(l, "Could not load plugin", d.message)
            }

            function L(b, m) {
                var l = m.get("playlist");
                V.isString(l) ? (K = new Y, K.on(T.JWPLAYER_PLAYLIST_LOADED, function (a) {
                    m.set("playlist", a.playlist), b()
                }), K.on(T.JWPLAYER_ERROR, V.partial(I, b)), K.load(l)) : b()
            }

            function J(m, l, r, q, p) {
                var o = l.get("playlist"), n = p(o);
                n ? m() : I(m)
            }

            function I(l, d) {
                d && d.message ? B(l, "Error loading playlist", d.message) : B(l, "Error loading player", "No playable sources found")
            }

            function H(l, d) {
                return V.contains(W.SkinsLoadable, l) ? d + "skins/" + l + ".css" : void 0
            }

            function G(m) {
                for (var l = document.styleSheets, o = 0, n = l.length; n > o; o++) {
                    if (l[o].href === m) {
                        return !0
                    }
                }
                return !1
            }

            function F(l, d) {
                var p = d.get("skin"), o = d.get("skinUrl");
                if (V.contains(W.SkinsIncluded, p)) {
                    return void l()
                }
                if (o || (o = H(p, d.get("base"))), V.isString(o) && !G(o)) {
                    d.set("skin-loading", !0);
                    var n = !0, m = new X(o, n);
                    m.addEventListener(T.COMPLETE, function () {
                        d.set("skin-loading", !1)
                    }), m.addEventListener(T.ERROR, function () {
                        d.set("skin", "seven"), d.set("skin-loading", !1)
                    }), m.load()
                }
                V.defer(function () {
                    l()
                })
            }

            function E(m, l) {
                var o = l.get("playlist"), n = V.some(o, function (q) {
                    var p = U.isYouTube(q.file, q.type);
                    if (p && !q.image) {
                        var s = q.file, r = U.youTubeID(s);
                        q.image = "//i.ytimg.com/vi/" + r + "/0.jpg"
                    }
                    return p
                });
                n ? k.e(3, function (a) {
                    var p = k(106);
                    p.register(window.jwplayer), m()
                }) : m()
            }

            function D(m, l, o, n) {
                n.setup(), m()
            }

            function C(b) {
                b({type: "complete"})
            }

            function B(l, d, m) {
                l({type: "error", msg: d, reason: m})
            }

            var c, K;
            return {getQueue: S, error: B}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(99), k(102), k(103), k(100)], h = function (m, l, s, r) {
            var q = {}, p = {}, o = function (b, a) {
                return p[b] = new m(new l(q), a), p[b]
            }, n = function (d, c, v, u) {
                var t = r.getPluginName(d);
                q[t] || (q[t] = new s(d)), q[t].registerPlugin(d, c, v, u)
            };
            return {loadPlugins: o, registerPlugin: n}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(100), k(48), k(46), k(47), k(45), k(101)], h = function (t, s, r, q, p, o) {
            function n(u, d, v) {
                return function () {
                    var a = u.getContainer().getElementsByClassName("jw-overlays")[0];
                    a && (a.appendChild(v), v.left = a.style.left, v.top = a.style.top, d.displayArea = a)
                }
            }

            function m(d) {
                function c() {
                    var a = d.displayArea;
                    a && d.resize(a.clientWidth, a.clientHeight)
                }

                return function () {
                    c(), setTimeout(c, 400)
                }
            }

            var l = function (z, y) {
                function x() {
                    b || (b = !0, c = o.loaderstatus.COMPLETE, d.trigger(r.COMPLETE))
                }

                function w() {
                    if (!A && (y && 0 !== p.keys(y).length || x(), !b)) {
                        var B = z.getPlugins();
                        u = p.after(a, x), p.each(y, function (I, H) {
                            var G = t.getPluginName(H), F = B[G], E = F.getJS(), D = F.getTarget(), C = F.getStatus();
                            C !== o.loaderstatus.LOADING && C !== o.loaderstatus.NEW && (E && !s.versionCheck(D) && d.trigger(r.ERROR, {message: "Incompatible player version"}), u())
                        })
                    }
                }

                function v(B) {
                    if (!A) {
                        var C = "File not found";
                        B.url && s.log(C, B.url), this.off(), this.trigger(r.ERROR, {message: C}), w()
                    }
                }

                var u, d = p.extend(this, q), c = o.loaderstatus.NEW, b = !1, a = p.size(y), A = !1;
                this.setupPlugins = function (F, E) {
                    var D = [], C = z.getPlugins(), B = E.get("plugins");
                    p.each(B, function (O, N) {
                        var M = t.getPluginName(N), L = C[M], K = L.getFlashPath(), J = L.getJS(), I = L.getURL();
                        if (K) {
                            var H = p.extend({name: M, swf: K, pluginmode: L.getPluginmode()}, O);
                            D.push(H)
                        }
                        var G = s.tryCatch(function () {
                            if (J && B[I]) {
                                var Q = document.createElement("div");
                                Q.id = F.id + "_" + M, Q.className = "jw-plugin jw-reset";
                                var P = p.extend({}, B[I]), R = L.getNewInstance(F, P, Q);
                                R.addToPlayer = n(F, R, Q), R.resizeHandler = m(R), F.addPlugin(M, R, Q)
                            }
                        });
                        G instanceof s.Error && s.log("ERROR: Failed to load " + M + ".")
                    }), E.set("flashPlugins", D)
                }, this.load = function () {
                    if (s.exists(y) && "object" !== s.typeOf(y)) {
                        return void w()
                    }
                    c = o.loaderstatus.LOADING, p.each(y, function (C, E) {
                        if (s.exists(E)) {
                            var D = z.addPlugin(E);
                            D.on(r.COMPLETE, w), D.on(r.ERROR, v)
                        }
                    });
                    var B = z.getPlugins();
                    p.each(B, function (C) {
                        C.load()
                    }), w()
                }, this.destroy = function () {
                    A = !0, this.off()
                }, this.getStatus = function () {
                    return c
                }
            };
            return l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51)], h = function (l) {
            var d = {}, m = d.pluginPathType = {ABSOLUTE: 0, RELATIVE: 1, CDN: 2};
            return d.getPluginPathType = function (a) {
                if ("string" == typeof a) {
                    a = a.split("?")[0];
                    var o = a.indexOf("://");
                    if (o > 0) {
                        return m.ABSOLUTE
                    }
                    var n = a.indexOf("/"), c = l.extension(a);
                    return !(0 > o && 0 > n) || c && isNaN(c) ? m.RELATIVE : m.CDN
                }
            }, d.getPluginName = function (b) {
                return b.replace(/^(.*\/)?([^-]*)-?.*\.(swf|js)$/, "$2")
            }, d.getPluginVersion = function (b) {
                return b.replace(/[^-]*-?([^\.]*).*$/, "$1")
            }, d
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(46), k(47), k(45)], h = function (m, l, q) {
            var p = {}, o = {NEW: 0, LOADING: 1, ERROR: 2, COMPLETE: 3}, n = function (s, r) {
                function d(t) {
                    a = o.ERROR, b.trigger(m.ERROR, t)
                }

                function c(t) {
                    a = o.COMPLETE, b.trigger(m.COMPLETE, t)
                }

                var b = q.extend(this, l), a = o.NEW;
                this.addEventListener = this.on, this.removeEventListener = this.off, this.makeStyleLink = function (u) {
                    var t = document.createElement("link");
                    return t.type = "text/css", t.rel = "stylesheet", t.href = u, t
                }, this.makeScriptTag = function (u) {
                    var t = document.createElement("script");
                    return t.src = u, t
                }, this.makeTag = r ? this.makeStyleLink : this.makeScriptTag, this.load = function () {
                    if (a === o.NEW) {
                        var t = p[s];
                        if (t && (a = t.getStatus(), 2 > a)) {
                            return t.on(m.ERROR, d), void t.on(m.COMPLETE, c)
                        }
                        var w = document.getElementsByTagName("head")[0] || document.documentElement,
                            v = this.makeTag(s), u = !1;
                        v.onload = v.onreadystatechange = function (x) {
                            u || this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (u = !0, c(x), v.onload = v.onreadystatechange = null, w && v.parentNode && !r && w.removeChild(v))
                        }, v.onerror = d, w.insertBefore(v, w.firstChild), a = o.LOADING, p[s] = this
                    }
                }, this.getStatus = function () {
                    return a
                }
            };
            return n.loaderstatus = o, n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(100), k(103)], h = function (l, d) {
            var m = function (a) {
                this.addPlugin = function (c) {
                    var b = l.getPluginName(c);
                    return a[b] || (a[b] = new d(c)), a[b]
                }, this.getPlugins = function () {
                    return a
                }
            };
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(100), k(46), k(47), k(101), k(45)], h = function (m, l, s, r, q, p) {
            var o = {FLASH: 0, JAVASCRIPT: 1, HYBRID: 2}, n = function (y) {
                function x() {
                    switch (l.getPluginPathType(y)) {
                        case l.pluginPathType.ABSOLUTE:
                            return y;
                        case l.pluginPathType.RELATIVE:
                            return m.getAbsolutePath(y, window.location.href)
                    }
                }

                function w() {
                    p.defer(function () {
                        a = q.loaderstatus.COMPLETE, b.trigger(s.COMPLETE)
                    })
                }

                function v() {
                    a = q.loaderstatus.ERROR, b.trigger(s.ERROR, {url: y})
                }

                var u, t, d, c, b = p.extend(this, r), a = q.loaderstatus.NEW;
                this.load = function () {
                    if (a === q.loaderstatus.NEW) {
                        if (y.lastIndexOf(".swf") > 0) {
                            return u = y, a = q.loaderstatus.COMPLETE, void b.trigger(s.COMPLETE)
                        }
                        if (l.getPluginPathType(y) === l.pluginPathType.CDN) {
                            return a = q.loaderstatus.COMPLETE, void b.trigger(s.COMPLETE)
                        }
                        a = q.loaderstatus.LOADING;
                        var z = new q(x());
                        z.on(s.COMPLETE, w), z.on(s.ERROR, v), z.load()
                    }
                }, this.registerPlugin = function (A, z, C, B) {
                    c && (clearTimeout(c), c = void 0), d = z, C && B ? (u = B, t = C) : "string" == typeof C ? u = C : "function" == typeof C ? t = C : C || B || (u = A), a = q.loaderstatus.COMPLETE, b.trigger(s.COMPLETE)
                }, this.getStatus = function () {
                    return a
                }, this.getPluginName = function () {
                    return l.getPluginName(y)
                }, this.getFlashPath = function () {
                    if (u) {
                        switch (l.getPluginPathType(u)) {
                            case l.pluginPathType.ABSOLUTE:
                                return u;
                            case l.pluginPathType.RELATIVE:
                                return y.lastIndexOf(".swf") > 0 ? m.getAbsolutePath(u, window.location.href) : m.getAbsolutePath(u, x())
                        }
                    }
                    return null
                }, this.getJS = function () {
                    return t
                }, this.getTarget = function () {
                    return d
                }, this.getPluginmode = function () {
                    return void 0 !== typeof u && void 0 !== typeof t ? o.HYBRID : void 0 !== typeof u ? o.FLASH : void 0 !== typeof t ? o.JAVASCRIPT : void 0
                }, this.getNewInstance = function (A, z, B) {
                    return new t(A, z, B)
                }, this.getURL = function () {
                    return y
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, , , , , , , , function (g, f, k) {
        var j, h;
        j = [k(66), k(112), k(113), k(48)], h = function (m, l, p, o) {
            var n = function (J, I) {
                function H(r) {
                    if (r.tracks.length) {
                        I.mediaController.off("meta", G), d = [], c = {}, b = {}, a = 0;
                        for (var q = r.tracks || [], u = 0; u < q.length; u++) {
                            var t = q[u];
                            t.id = t.name, t.label = t.name || t.language, C(t)
                        }
                        var s = z();
                        this.setCaptionsList(s), y()
                    }
                }

                function G(r) {
                    var q = r.metadata;
                    if (q && "textdata" === q.type) {
                        if (!q.text) {
                            return
                        }
                        var K = c[q.trackid];
                        if (!K) {
                            K = {kind: "captions", id: q.trackid, data: []}, C(K);
                            var v = z();
                            this.setCaptionsList(v)
                        }
                        var u, t;
                        q.useDTS ? (K.source || (K.source = q.source || "mpegts"), u = q.begin, t = q.begin + "_" + q.text) : (u = r.position || I.get("position"), t = "" + Math.round(10 * u) + "_" + q.text);
                        var s = b[t];
                        s || (s = {begin: u, text: q.text}, q.end && (s.end = q.end), b[t] = s, K.data.push(s))
                    }
                }

                function F(q) {
                    o.log("CAPTIONS(" + q + ")")
                }

                function E(r, q) {
                    w = q, d = [], c = {}, b = {}, a = 0, I.mediaController.off("meta", G), I.mediaController.off("subtitlesTracks", H);
                    var L, v, u, t = q.tracks;
                    for (u = 0; u < t.length; u++) {
                        if (L = t[u], v = L.kind.toLowerCase(), "captions" === v || "subtitles" === v) {
                            if (L.file) {
                                var s = o.isIOS() && !o.isSDK(I.getConfiguration()) && -1 !== L.file.indexOf(".vtt");
                                s || (C(L), B(L))
                            } else {
                                L.data && C(L)
                            }
                        }
                    }
                    0 === d.length && (I.mediaController.on("meta", G, this), I.mediaController.on("subtitlesTracks", H, this));
                    var K = z();
                    this.setCaptionsList(K), y()
                }

                function D(r, q) {
                    var s = null;
                    0 !== q && (s = d[q - 1]), r.set("captionsTrack", s)
                }

                function C(q) {
                    "number" != typeof q.id && (q.id = q.name || q.file || "cc" + d.length), q.data = q.data || [], q.label || (q.label = "Unknown CC", a++, a > 1 && (q.label += " (" + a + ")")), d.push(q), c[q.id] = q
                }

                function B(q) {
                    o.ajax(q.file, function (r) {
                        A(r, q)
                    }, F)
                }

                function A(t, s) {
                    var r, q = t.responseXML ? t.responseXML.firstChild : null;
                    if (q) {
                        for ("xml" === m.localName(q) && (q = q.nextSibling); q.nodeType === q.COMMENT_NODE;) {
                            q = q.nextSibling
                        }
                    }
                    r = q && "tt" === m.localName(q) ? o.tryCatch(function () {
                        s.data = p(t.responseXML)
                    }) : o.tryCatch(function () {
                        s.data = l(t.responseText)
                    }), r instanceof o.Error && F(r.message + ": " + s.file)
                }

                function z() {
                    for (var r = [{id: "off", label: "Off"}], q = 0; q < d.length; q++) {
                        r.push({id: d[q].id, label: d[q].label || "Unknown CC"})
                    }
                    return r
                }

                function y() {
                    var r = 0, q = I.get("captionLabel");
                    if ("Off" === q) {
                        return void I.set("captionsIndex", 0)
                    }
                    for (var t = 0; t < d.length; t++) {
                        var s = d[t];
                        if (q && q === s.label) {
                            r = t + 1;
                            break
                        }
                        s["default"] || s.defaulttrack ? r = t + 1 : s.autoselect
                    }
                    x(r)
                }

                function x(q) {
                    d.length ? I.setVideoSubtitleTrack(q, d) : I.set("captionsIndex", q)
                }

                I.on("change:playlistItem", E, this), I.on("change:captionsIndex", D, this), I.mediaController.on("subtitlesTracks", H, this), I.mediaController.on("subtitlesTrackData", function (r) {
                    var q = c[r.name];
                    if (q) {
                        q.source = r.source;
                        for (var K = r.captions || [], v = !1, u = 0; u < K.length; u++) {
                            var t = K[u], s = r.name + "_" + t.begin + "_" + t.end;
                            b[s] || (b[s] = t, q.data.push(t), v = !0)
                        }
                        v && q.data.sort(function (M, L) {
                            return M.begin - L.begin
                        })
                    }
                }, this), I.mediaController.on("meta", G, this);
                var w = {}, d = [], c = {}, b = {}, a = 0;
                this.getCurrentIndex = function () {
                    return I.get("captionsIndex")
                }, this.getCaptionsList = function () {
                    return I.get("captionsList")
                }, this.setCaptionsList = function (q) {
                    I.set("captionsList", q)
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(51)], h = function (m, l) {
            function o(p) {
                var d = {}, t = p.split("\r\n");
                1 === t.length && (t = p.split("\n"));
                var s = 1;
                if (t[0].indexOf(" --> ") > 0 && (s = 0), t.length > s + 1 && t[s + 1]) {
                    var r = t[s], q = r.indexOf(" --> ");
                    q > 0 && (d.begin = n(r.substr(0, q)), d.end = n(r.substr(q + 5)), d.text = t.slice(s + 1).join("<br/>"))
                }
                return d
            }

            var n = m.seconds;
            return function (b) {
                var r = [];
                b = l.trim(b);
                var q = b.split("\r\n\r\n");
                1 === q.length && (q = b.split("\n\n"));
                for (var p = 0; p < q.length; p++) {
                    if ("WEBVTT" !== q[p]) {
                        var c = o(q[p]);
                        c.text && r.push(c)
                    }
                }
                if (!r.length) {
                    throw new Error("Invalid SRT file")
                }
                return r
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(51)], h = function (m) {
            function l(b) {
                b || o()
            }

            function o() {
                throw new Error("Invalid DFXP file")
            }

            var n = m.seconds;
            return function (v) {
                l(v);
                var u = [], t = v.getElementsByTagName("p");
                l(t), t.length || (t = v.getElementsByTagName("tt:p"), t.length || (t = v.getElementsByTagName("tts:p")));
                for (var s = 0; s < t.length; s++) {
                    var r = t[s], q = r.innerHTML || r.textContent || r.text || "",
                        p = m.trim(q).replace(/>\s+</g, "><").replace(/tts?:/g, "");
                    if (p) {
                        var d = r.getAttribute("begin"), c = r.getAttribute("dur"), b = r.getAttribute("end"),
                            a = {begin: n(d), text: p};
                        b ? a.end = n(b) : c && (a.end = a.begin + n(c)), u.push(a)
                    }
                }
                return u.length || o(), u
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(70), k(71), k(45), k(78)], h = function (m, l, s, r) {
            function q(u, t) {
                for (var x = 0; x < u.length; x++) {
                    var w = u[x], v = t.choose(w);
                    if (v) {
                        return w.type
                    }
                }
                return null
            }

            var p = function (a) {
                return a = s.isArray(a) ? a : [a], s.compact(s.map(a, m))
            };
            p.filterPlaylist = function (t, c, x, w, v) {
                var u = [];
                return s.each(t, function (b) {
                    b = s.extend({}, b), b.allSources = o(b.sources, x, b.drm || w, b.preload || v), b.sources = n(b.allSources, c), b.sources.length && (b.file = b.sources[0].file, (b.preload || v) && (b.preload = b.preload || v), u.push(b))
                }), u
            };
            var o = function (b, u, t, c) {
                return s.compact(s.map(b, function (d) {
                    return s.isObject(d) ? (void 0 !== u && null !== u && (d.androidhls = u), (d.drm || t) && (d.drm = d.drm || t), (d.preload || c) && (d.preload = d.preload || c), l(d)) : void 0
                }))
            }, n = function (d, c) {
                c && c.choose || (c = new r({primary: c ? "flash" : null}));
                var t = q(d, c);
                return s.where(d, {type: t})
            };
            return p
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            return function (l, d) {
                l.getPlaylistIndex = l.getItem;
                var m = {
                    jwPlay: d.play,
                    jwPause: d.pause,
                    jwSetMute: d.setMute,
                    jwLoad: d.load,
                    jwPlaylistItem: d.item,
                    jwGetAudioTracks: d.getAudioTracks,
                    jwDetachMedia: d.detachMedia,
                    jwAttachMedia: d.attachMedia,
                    jwAddEventListener: d.on,
                    jwRemoveEventListener: d.off,
                    jwStop: d.stop,
                    jwSeek: d.seek,
                    jwSetVolume: d.setVolume,
                    jwPlaylistNext: d.next,
                    jwPlaylistPrev: d.prev,
                    jwSetFullscreen: d.setFullscreen,
                    jwGetQualityLevels: d.getQualityLevels,
                    jwGetCurrentQuality: d.getCurrentQuality,
                    jwSetCurrentQuality: d.setCurrentQuality,
                    jwSetCurrentAudioTrack: d.setCurrentAudioTrack,
                    jwGetCurrentAudioTrack: d.getCurrentAudioTrack,
                    jwGetCaptionsList: d.getCaptionsList,
                    jwGetCurrentCaptions: d.getCurrentCaptions,
                    jwSetCurrentCaptions: d.setCurrentCaptions,
                    jwSetCues: d.setCues
                };
                l.callInternal = function (b) {
                    console.log("You are using the deprecated callInternal method for " + b);
                    var c = Array.prototype.slice.call(arguments, 1);
                    m[b].apply(d, c)
                }
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(117), k(46), k(154)], h = function (m, l, o) {
            var n = function (p, c) {
                var b = new m(p, c), a = b.setup;
                return b.setup = function () {
                    if (a.call(this), "trial" === c.get("edition")) {
                        var d = document.createElement("div");
                        d.className = "jw-icon jw-watermark", this.element().appendChild(d)
                    }
                    c.on("change:skipButton", this.onSkipButton, this), c.on("change:castActive change:playlistItem", this.showDisplayIconImage, this)
                }, b.showDisplayIconImage = function (r) {
                    var q = r.get("castActive"), t = r.get("playlistItem"),
                        s = b.controlsContainer().getElementsByClassName("jw-display-icon-container")[0];
                    q && t && t.image ? (s.style.backgroundImage = 'url("' + t.image + '")', s.style.backgroundSize = "contain") : (s.style.backgroundImage = "", s.style.backgroundSize = "")
                }, b.onSkipButton = function (q, d) {
                    d ? this.addSkipButton() : this._skipButton && (this._skipButton.destroy(), this._skipButton = null)
                }, b.addSkipButton = function () {
                    this._skipButton = new o(this.instreamModel), this._skipButton.on(l.JWPLAYER_AD_SKIPPED, function () {
                        this.api.skipAd()
                    }, this), this.controlsContainer().appendChild(this._skipButton.element())
                }, b
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(46), k(47), k(58), k(62), k(128), k(129), k(130), k(118), k(132), k(134), k(148), k(149), k(152), k(45), k(153)], h = function (P, O, N, M, L, K, J, I, H, G, F, E, D, C, B, A) {
            var z = P.style, y = P.bounds, x = P.isMobile(),
                w = ["fullscreenchange", "webkitfullscreenchange", "mozfullscreenchange", "MSFullscreenChange"],
                v = function (ah, ag) {
                    function af(u) {
                        var T = 0, S = ag.get("duration"), R = ag.get("position");
                        "DVR" === P.adaptiveType(S) && (T = S, S = Math.max(R, M.dvrSeekLimit));
                        var Q = P.between(R + u, T, S);
                        ah.seek(Q)
                    }

                    function ae(u) {
                        var Q = P.between(ag.get("volume") + u, 0, 100);
                        ah.setVolume(Q)
                    }

                    function ad(u) {
                        return u.ctrlKey || u.metaKey ? !1 : !!ag.get("controls")
                    }

                    function ac(Q) {
                        if (!ad(Q)) {
                            return !0
                        }
                        switch (bc || aZ(), Q.keyCode) {
                            case 27:
                                ah.setFullscreen(!1);
                                break;
                            case 13:
                            case 32:
                                ah.play({reason: "interaction"});
                                break;
                            case 37:
                                bc || af(-5);
                                break;
                            case 39:
                                bc || af(5);
                                break;
                            case 38:
                                ae(10);
                                break;
                            case 40:
                                ae(-10);
                                break;
                            case 77:
                                ah.setMute();
                                break;
                            case 70:
                                ah.setFullscreen();
                                break;
                            default:
                                if (Q.keyCode >= 48 && Q.keyCode <= 59) {
                                    var u = Q.keyCode - 48, R = u / 10 * ag.get("duration");
                                    ah.seek(R)
                                }
                        }
                        return /13|32|37|38|39|40/.test(Q.keyCode) ? (Q.preventDefault(), !1) : void 0
                    }

                    function aV() {
                        m = !1, P.removeClass(p, "jw-no-focus")
                    }

                    function aU() {
                        m = !0, P.addClass(p, "jw-no-focus")
                    }

                    function aT() {
                        m || aV(), bc || aZ()
                    }

                    function aR() {
                        var u = y(p), R = Math.round(u.width), Q = Math.round(u.height);
                        return document.body.contains(p) ? R && Q && (R === a2 && Q === aQ || (a2 = R, aQ = Q, clearTimeout(aS), aS = setTimeout(at, 50), ag.set("containerWidth", R), ag.set("containerHeight", Q), be.trigger(O.JWPLAYER_RESIZE, {
                            width: R,
                            height: Q
                        }))) : (window.removeEventListener("resize", aR), x && window.removeEventListener("orientationchange", aR)), u
                    }

                    function aP(u, Q) {
                        Q = Q || !1, P.toggleClass(p, "jw-flag-casting", Q)
                    }

                    function aO(u, Q) {
                        P.toggleClass(p, "jw-flag-cast-available", Q), P.toggleClass(c, "jw-flag-cast-available", Q)
                    }

                    function aN(u, Q) {
                        P.replaceClass(p, /jw-stretch-\S+/, "jw-stretch-" + Q)
                    }

                    function aM(u, Q) {
                        P.toggleClass(p, "jw-flag-compact-player", Q)
                    }

                    function aK(u) {
                        u && !x && (u.element().addEventListener("mousemove", aG, !1), u.element().addEventListener("mouseout", aF, !1))
                    }

                    function aI() {
                        ag.get("state") !== L.IDLE && ag.get("state") !== L.COMPLETE && ag.get("state") !== L.PAUSED || !ag.get("controls") || ah.play({reason: "interaction"}), a3 ? an() : aZ()
                    }

                    function aH(u) {
                        u.link ? (ah.pause(!0), ah.setFullscreen(!1), window.open(u.link, u.linktarget)) : ag.get("controls") && ah.play({reason: "interaction"})
                    }

                    function aG() {
                        clearTimeout(ak)
                    }

                    function aF() {
                        aZ()
                    }

                    function aE(u) {
                        be.trigger(u.type, u)
                    }

                    function aD(u, Q) {
                        Q ? (a7 && a7.destroy(), P.addClass(p, "jw-flag-flash-blocked")) : (a7 && a7.setup(ag, p, p), P.removeClass(p, "jw-flag-flash-blocked"))
                    }

                    function aB() {
                        ag.get("controls") && ah.setFullscreen()
                    }

                    function aA() {
                        var S = p.getElementsByClassName("jw-overlays")[0];
                        S.addEventListener("mousemove", aZ), bd = new J(ag, bb, {useHover: !0}), bd.on("click", function () {
                            aE({type: O.JWPLAYER_DISPLAY_CLICK}), ag.get("controls") && ah.play({reason: "interaction"})
                        }), bd.on("tap", function () {
                            aE({type: O.JWPLAYER_DISPLAY_CLICK}), aI()
                        }), bd.on("doubleClick", aB), bd.on("move", aZ), bd.on("over", aZ);
                        var R = new I(ag);
                        R.on("click", function () {
                            aE({type: O.JWPLAYER_DISPLAY_CLICK}), ah.play({reason: "interaction"})
                        }), R.on("tap", function () {
                            aE({type: O.JWPLAYER_DISPLAY_CLICK}), aI()
                        }), P.isChrome() && R.el.addEventListener("mousedown", function () {
                            var U = ag.getVideo(), T = U && 0 === U.getName().name.indexOf("flash");
                            if (T) {
                                var V = function () {
                                    document.removeEventListener("mouseup", V), R.el.style.pointerEvents = "auto"
                                };
                                this.style.pointerEvents = "none", document.addEventListener("mouseup", V)
                            }
                        }), c.appendChild(R.element()), aW = new H(ag), ao = new G(ag), ao.on(O.JWPLAYER_LOGO_CLICK, aH);
                        var Q = document.createElement("div");
                        Q.className = "jw-controls-right jw-reset", ao.setup(Q), Q.appendChild(aW.element()), c.appendChild(Q), n = new K(ag), n.setup(ag.get("captions")), c.parentNode.insertBefore(n.element(), t.element());
                        var u = ag.get("height");
                        x && ("string" == typeof u || u >= 1.5 * d) ? P.addClass(p, "jw-flag-touch") : (a7 = new D, a7.setup(ag, p, p)), r = new F(ah, ag), r.on(O.JWPLAYER_USER_ACTION, aZ), ag.on("change:scrubbing", ay), ag.on("change:compactUI", aM), c.appendChild(r.element()), p.addEventListener("focus", aT), p.addEventListener("blur", aV), p.addEventListener("keydown", ac), p.onmousedown = aU
                    }

                    function az(u) {
                        return u.get("state") === L.PAUSED ? void u.once("change:state", az) : void (u.get("scrubbing") === !1 && P.removeClass(p, "jw-flag-dragging"))
                    }

                    function ay(u, Q) {
                        u.off("change:state", az), Q ? P.addClass(p, "jw-flag-dragging") : az(u)
                    }

                    function ax(u, T, S) {
                        var R, Q = p.className;
                        S = !!S, S && (Q = Q.replace(/\s*aspectMode/, ""), p.className !== Q && (p.className = Q), z(p, {display: "block"}, S)), P.exists(u) && P.exists(T) && (ag.set("width", u), ag.set("height", T)), R = {width: u}, P.hasClass(p, "jw-flag-aspect-mode") || (R.height = T), z(p, R, !0), aw(T), at(u, T)
                    }

                    function aw(u) {
                        if (a = av(u), r && !a) {
                            var Q = bc ? al : ag;
                            aj(Q, Q.get("state"))
                        }
                        P.toggleClass(p, "jw-flag-audio-player", a)
                    }

                    function av(Q) {
                        if (ag.get("aspectratio")) {
                            return !1
                        }
                        if (B.isString(Q) && Q.indexOf("%") > -1) {
                            return !1
                        }
                        var u = B.isNumber(Q) ? Q : ag.get("containerHeight");
                        return au(u)
                    }

                    function au(u) {
                        return u && d * (x ? 1.75 : 1) >= u
                    }

                    function at(u, S) {
                        if (!u || isNaN(Number(u))) {
                            if (!bb) {
                                return
                            }
                            u = bb.clientWidth
                        }
                        if (!S || isNaN(Number(S))) {
                            if (!bb) {
                                return
                            }
                            S = bb.clientHeight
                        }
                        P.isMSIE(9) && document.all && !window.atob && (u = S = "100%");
                        var R = ag.getVideo();
                        if (R) {
                            var Q = R.resize(u, S, ag.get("stretching"));
                            Q && (clearTimeout(aS), aS = setTimeout(at, 250)), n.resize(), r.checkCompactMode(u)
                        }
                    }

                    function ar() {
                        if (s) {
                            var u = document.fullscreenElement || document.webkitCurrentFullScreenElement || document.mozFullScreenElement || document.msFullscreenElement;
                            return !(!u || u.id !== ag.get("id"))
                        }
                        return bc ? al.getVideo().getFullScreen() : ag.getVideo().getFullScreen()
                    }

                    function aq(Q) {
                        var u = ag.get("fullscreen"), R = void 0 !== Q.jwstate ? Q.jwstate : ar();
                        u !== R && ag.set("fullscreen", R), clearTimeout(aS), aS = setTimeout(at, 200)
                    }

                    function a4(u, Q) {
                        Q ? (P.addClass(u, "jw-flag-fullscreen"), z(document.body, {"overflow-y": "hidden"}), aZ()) : (P.removeClass(u, "jw-flag-fullscreen"), z(document.body, {"overflow-y": ""})), at()
                    }

                    function an() {
                        a3 = !1, clearTimeout(ak), r.hideComponents(), P.addClass(p, "jw-flag-user-inactive")
                    }

                    function aZ() {
                        a3 || (P.removeClass(p, "jw-flag-user-inactive"), r.checkCompactMode(bb.clientWidth)), a3 = !0, clearTimeout(ak), ak = setTimeout(an, q)
                    }

                    function aC() {
                        ah.setFullscreen(!1)
                    }

                    function ai() {
                        a5 && a5.setState(ag.get("state")), o(ag, ag.mediaModel.get("mediaType")), ag.mediaModel.on("change:mediaType", o, this)
                    }

                    function o(u, R) {
                        var Q = "audio" === R;
                        P.toggleClass(p, "jw-flag-media-audio", Q)
                    }

                    function b(u, R) {
                        var Q = "LIVE" === P.adaptiveType(R);
                        P.toggleClass(p, "jw-flag-live", Q), be.setAltText(Q ? "Live Broadcast" : "")
                    }

                    function a8(Q, u) {
                        return u ? void (u.name ? t.updateText(u.name, u.message) : t.updateText(u.message, "")) : void t.playlistItem(Q, Q.get("playlistItem"))
                    }

                    function a0() {
                        var u = ag.getVideo();
                        return u ? u.isCaster : !1
                    }

                    function aJ() {
                        P.replaceClass(p, /jw-state-\S+/, "jw-state-" + aY)
                    }

                    function aj(u, Q) {
                        if (aY = Q, clearTimeout(am), Q === L.COMPLETE || Q === L.IDLE ? am = setTimeout(aJ, 100) : aJ(), a0()) {
                            return void P.addClass(bb, "jw-media-show")
                        }
                        switch (Q) {
                            case L.PLAYING:
                                at();
                                break;
                            case L.PAUSED:
                                aZ()
                        }
                    }

                    var p, c, bb, a2, aQ, al, r, l, bd, a5, aW, ao, t, n, a, a7, aY, a9, a1, aL, ak = -1,
                        q = x ? 4000 : 2000, d = 40, bc = !1, a3 = !1, aS = -1, am = -1, s = !1, m = !1,
                        be = B.extend(this, N);
                    this.model = ag, this.api = ah, p = P.createElement(A({id: ag.get("id")})), P.isIE() && P.addClass(p, "jw-ie");
                    var a6 = ag.get("width"), aX = ag.get("height");
                    z(p, {
                        width: a6.toString().indexOf("%") > 0 ? a6 : a6 + "px",
                        height: aX.toString().indexOf("%") > 0 ? aX : aX + "px"
                    }), a1 = p.requestFullscreen || p.webkitRequestFullscreen || p.webkitRequestFullScreen || p.mozRequestFullScreen || p.msRequestFullscreen, aL = document.exitFullscreen || document.webkitExitFullscreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.msExitFullscreen, s = a1 && aL, this.onChangeSkin = function (u, Q) {
                        P.replaceClass(p, /jw-skin-\S+/, Q ? "jw-skin-" + Q : "")
                    }, this.handleColorOverrides = function () {
                        function u(U, X, W) {
                            if (W) {
                                U = P.prefix(U, "#" + T + " ");
                                var V = {};
                                V[X] = W, P.css(U.join(", "), V)
                            }
                        }

                        var T = ag.get("id"), S = ag.get("skinColorActive"), R = ag.get("skinColorInactive"),
                            Q = ag.get("skinColorBackground");
                        u([".jw-toggle", ".jw-button-color:hover"], "color", S), u([".jw-active-option", ".jw-progress", ".jw-playlist-container .jw-option.jw-active-option", ".jw-playlist-container .jw-option:hover"], "background", S), u([".jw-text", ".jw-option", ".jw-button-color", ".jw-toggle.jw-off", ".jw-tooltip-title", ".jw-skip .jw-skip-icon", ".jw-playlist-container .jw-icon"], "color", R), u([".jw-cue", ".jw-knob"], "background", R), u([".jw-playlist-container .jw-option"], "border-bottom-color", R), u([".jw-background-color", ".jw-tooltip-title", ".jw-playlist", ".jw-playlist-container .jw-option"], "background", Q), u([".jw-playlist-container ::-webkit-scrollbar"], "border-color", Q)
                    }, this.setup = function () {
                        this.handleColorOverrides(), ag.get("skin-loading") === !0 && (P.addClass(p, "jw-flag-skin-loading"), ag.once("change:skin-loading", function () {
                            P.removeClass(p, "jw-flag-skin-loading")
                        })), this.onChangeSkin(ag, ag.get("skin"), ""), ag.on("change:skin", this.onChangeSkin, this), bb = p.getElementsByClassName("jw-media")[0], c = p.getElementsByClassName("jw-controls")[0];
                        var T = p.getElementsByClassName("jw-preview")[0];
                        l = new E(ag), l.setup(T);
                        var S = p.getElementsByClassName("jw-title")[0];
                        t = new C(ag), t.setup(S), aA(), aZ(), ag.set("mediaContainer", bb), ag.mediaController.on("fullscreenchange", aq);
                        for (var R = w.length; R--;) {
                            document.addEventListener(w[R], aq, !1)
                        }
                        window.removeEventListener("resize", aR), window.addEventListener("resize", aR, !1), x && (window.removeEventListener("orientationchange", aR), window.addEventListener("orientationchange", aR, !1)), ag.on("change:errorEvent", a8), ag.on("change:controls", ap), ap(ag, ag.get("controls")), ag.on("change:state", aj), ag.on("change:duration", b, this), ag.on("change:flashBlocked", aD), aD(ag, ag.get("flashBlocked")), ah.onPlaylistComplete(aC), ah.onPlaylistItem(ai), ag.on("change:castAvailable", aO), aO(ag, ag.get("castAvailable")), ag.on("change:castActive", aP), aP(ag, ag.get("castActive")), ag.get("stretching") && aN(ag, ag.get("stretching")), ag.on("change:stretching", aN), aj(ag, L.IDLE), ag.on("change:fullscreen", ab), aK(r), aK(ao);
                        var Q = ag.get("aspectratio");
                        if (Q) {
                            P.addClass(p, "jw-flag-aspect-mode");
                            var u = p.getElementsByClassName("jw-aspect")[0];
                            z(u, {paddingTop: Q})
                        }
                        ah.on(O.JWPLAYER_READY, function () {
                            aR(), ax(ag.get("width"), ag.get("height"))
                        })
                    };
                    var ap = function (u, R) {
                        if (R) {
                            var Q = bc ? al.get("state") : ag.get("state");
                            aj(u, Q)
                        }
                        P.toggleClass(p, "jw-flag-controls-disabled", !R)
                    }, ab = function (u, R) {
                        var Q = ag.getVideo();
                        s ? (R ? a1.apply(p) : aL.apply(document), a4(p, R)) : P.isIE() ? a4(p, R) : (al && al.getVideo() && al.getVideo().setFullscreen(R), Q.setFullscreen(R)), Q && 0 === Q.getName().name.indexOf("flash") && Q.setFullscreen(R)
                    };
                    this.resize = function (Q, u) {
                        var R = !0;
                        ax(Q, u, R), aR()
                    }, this.resizeMedia = at, this.reset = function () {
                        document.contains(p) && p.parentNode.replaceChild(a9, p), P.emptyElement(p)
                    }, this.setupInstream = function (u) {
                        this.instreamModel = al = u, al.on("change:controls", ap, this), al.on("change:state", aj, this), bc = !0, P.addClass(p, "jw-flag-ads"), aZ()
                    }, this.setAltText = function (u) {
                        r.setAltText(u)
                    }, this.useExternalControls = function () {
                        P.addClass(p, "jw-flag-ads-hide-controls")
                    }, this.destroyInstream = function () {
                        if (bc = !1, al && (al.off(null, null, this), al = null), this.setAltText(""), P.removeClass(p, "jw-flag-ads"), P.removeClass(p, "jw-flag-ads-hide-controls"), ag.getVideo) {
                            var u = ag.getVideo();
                            u.setContainer(bb)
                        }
                        b(ag, ag.get("duration")), bd.revertAlternateClickHandlers()
                    }, this.addCues = function (u) {
                        r && r.addCues(u)
                    }, this.clickHandler = function () {
                        return bd
                    }, this.controlsContainer = function () {
                        return c
                    }, this.getContainer = this.element = function () {
                        return p
                    }, this.getSafeRegion = function (u) {
                        var R = {
                            x: 0,
                            y: 0,
                            width: ag.get("containerWidth") || 0,
                            height: ag.get("containerHeight") || 0
                        }, Q = ag.get("dock");
                        return Q && Q.length && ag.get("controls") && (R.y = aW.element().clientHeight, R.height -= R.y), u = u || !P.exists(u), u && ag.get("controls") && (R.height -= r.element().clientHeight), R
                    }, this.destroy = function () {
                        window.removeEventListener("resize", aR), window.removeEventListener("orientationchange", aR);
                        for (var u = w.length; u--;) {
                            document.removeEventListener(w[u], aq, !1)
                        }
                        ag.mediaController && ag.mediaController.off("fullscreenchange", aq), p.removeEventListener("keydown", ac, !1), a7 && a7.destroy(), a5 && (ag.off("change:state", a5.statusDelegate), a5.destroy(), a5 = null), bc && this.destroyInstream(), ao && ao.destroy(), P.clearCss("#" + ag.get("id"))
                    }
                };
            return v
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(119), k(48), k(45), k(127)], h = function (m, l, p, o) {
            var n = function (b) {
                this.model = b, this.setup(), this.model.on("change:dock", this.render, this)
            };
            return p.extend(n.prototype, {
                setup: function () {
                    var d = this.model.get("dock"), b = this.click.bind(this), a = m(d);
                    this.el = l.createElement(a), new o(this.el).on("click tap", b)
                }, getDockButton: function (b) {
                    return l.hasClass(b.target, "jw-dock-button") ? b.target : l.hasClass(b.target, "jw-dock-text") ? b.target.parentElement.parentElement : b.target.parentElement
                }, click: function (q) {
                    var c = this.getDockButton(q), t = c.getAttribute("button"), s = this.model.get("dock"),
                        r = p.findWhere(s, {id: t});
                    r && r.callback && r.callback(q)
                }, render: function () {
                    var q = this.model.get("dock"), b = m(q), a = l.createElement(b);
                    this.el.innerHTML = a.innerHTML
                }, element: function () {
                    return this.el
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            1: function (t, s, r, q) {
                var p, o, n = "function", m = s.helperMissing, l = this.escapeExpression,
                    k = '    <div class="jw-dock-button jw-background-color jw-reset';
                return p = s["if"].call(t, null != t ? t.btnClass : t, {
                    name: "if",
                    hash: {},
                    fn: this.program(2, q),
                    inverse: this.noop,
                    data: q
                }), null != p && (k += p), k += '" button="' + l((o = null != (o = s.id || (null != t ? t.id : t)) ? o : m, typeof o === n ? o.call(t, {
                    name: "id",
                    hash: {},
                    data: q
                }) : o)) + '">\n        <div class="jw-icon jw-dock-image jw-reset" ', p = s["if"].call(t, null != t ? t.img : t, {
                    name: "if",
                    hash: {},
                    fn: this.program(4, q),
                    inverse: this.noop,
                    data: q
                }), null != p && (k += p), k += '></div>\n        <div class="jw-arrow jw-reset"></div>\n', p = s["if"].call(t, null != t ? t.tooltip : t, {
                    name: "if",
                    hash: {},
                    fn: this.program(6, q),
                    inverse: this.noop,
                    data: q
                }), null != p && (k += p), k + "    </div>\n"
            }, 2: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return " " + m((p = null != (p = k.btnClass || (null != l ? l.btnClass : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "btnClass",
                    hash: {},
                    data: q
                }) : p))
            }, 4: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return "style='background-image: url(\"" + m((p = null != (p = k.img || (null != l ? l.img : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "img",
                    hash: {},
                    data: q
                }) : p)) + "\")'"
            }, 6: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return '        <div class="jw-overlay jw-background-color jw-reset">\n            <span class="jw-text jw-dock-text jw-reset">' + m((p = null != (p = k.tooltip || (null != l ? l.tooltip : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "tooltip",
                    hash: {},
                    data: q
                }) : p)) + "</span>\n        </div>\n"
            }, compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, p, o) {
                var n, m = '<div class="jw-dock jw-reset">\n';
                return n = k.each.call(l, l, {
                    name: "each",
                    hash: {},
                    fn: this.program(1, o),
                    inverse: this.noop,
                    data: o
                }), null != n && (m += n), m + "</div>"
            }, useData: !0
        })
    }, function (f, d, g) {
        f.exports = g(121)
    }, function (t, s, r) {
        var q = r(122), p = r(124)["default"], o = r(125)["default"], n = r(123), m = r(126), l = function () {
            var b = new q.HandlebarsEnvironment;
            return n.extend(b, q), b.SafeString = p, b.Exception = o, b.Utils = n, b.escapeExpression = n.escapeExpression, b.VM = m, b.template = function (a) {
                return m.template(a, b)
            }, b
        }, k = l();
        k.create = l, k["default"] = k, s["default"] = k
    }, function (H, G, F) {
        function E(d, c) {
            this.helpers = d || {}, this.partials = c || {}, D(this)
        }

        function D(b) {
            b.registerHelper("helperMissing", function () {
                if (1 !== arguments.length) {
                    throw new B("Missing helper: '" + arguments[arguments.length - 1].name + "'")
                }
            }), b.registerHelper("blockHelperMissing", function (a, k) {
                var j = k.inverse, h = k.fn;
                if (a === !0) {
                    return h(this)
                }
                if (a === !1 || null == a) {
                    return j(this)
                }
                if (x(a)) {
                    return a.length > 0 ? (k.ids && (k.ids = [k.name]), b.helpers.each(a, k)) : j(this)
                }
                if (k.data && k.ids) {
                    var f = r(k.data);
                    f.contextPath = C.appendContextPath(k.data.contextPath, k.name), k = {data: f}
                }
                return h(a, k)
            }), b.registerHelper("each", function (K, J) {
                if (!J) {
                    throw new B("Must pass iterator to #each")
                }
                var I, q, p = J.fn, o = J.inverse, l = 0, k = "";
                if (J.data && J.ids && (q = C.appendContextPath(J.data.contextPath, J.ids[0]) + "."), w(K) && (K = K.call(this)), J.data && (I = r(J.data)), K && "object" == typeof K) {
                    if (x(K)) {
                        for (var g = K.length; g > l; l++) {
                            I && (I.index = l, I.first = 0 === l, I.last = l === K.length - 1, q && (I.contextPath = q + l)), k += p(K[l], {data: I})
                        }
                    } else {
                        for (var f in K) {
                            K.hasOwnProperty(f) && (I && (I.key = f, I.index = l, I.first = 0 === l, q && (I.contextPath = q + f)), k += p(K[f], {data: I}), l++)
                        }
                    }
                }
                return 0 === l && (k = o(this)), k
            }), b.registerHelper("if", function (d, c) {
                return w(d) && (d = d.call(this)), !c.hash.includeZero && !d || C.isEmpty(d) ? c.inverse(this) : c.fn(this)
            }), b.registerHelper("unless", function (a, d) {
                return b.helpers["if"].call(this, a, {fn: d.inverse, inverse: d.fn, hash: d.hash})
            }), b.registerHelper("with", function (g, f) {
                w(g) && (g = g.call(this));
                var j = f.fn;
                if (C.isEmpty(g)) {
                    return f.inverse(this)
                }
                if (f.data && f.ids) {
                    var h = r(f.data);
                    h.contextPath = C.appendContextPath(f.data.contextPath, f.ids[0]), f = {data: h}
                }
                return j(g, f)
            }), b.registerHelper("log", function (a, g) {
                var f = g.data && null != g.data.level ? parseInt(g.data.level, 10) : 1;
                b.log(f, a)
            }), b.registerHelper("lookup", function (d, c) {
                return d && d[c]
            })
        }

        var C = F(123), B = F(125)["default"], A = "2.0.0";
        G.VERSION = A;
        var z = 6;
        G.COMPILER_REVISION = z;
        var y = {
            1: "<= 1.0.rc.2",
            2: "== 1.0.0-rc.3",
            3: "== 1.0.0-rc.4",
            4: "== 1.x.x",
            5: "== 2.0.0-alpha.x",
            6: ">= 2.0.0-beta.1"
        };
        G.REVISION_CHANGES = y;
        var x = C.isArray, w = C.isFunction, v = C.toString, u = "[object Object]";
        G.HandlebarsEnvironment = E, E.prototype = {
            constructor: E, logger: t, log: s, registerHelper: function (d, c) {
                if (v.call(d) === u) {
                    if (c) {
                        throw new B("Arg not supported with multiple helpers")
                    }
                    C.extend(this.helpers, d)
                } else {
                    this.helpers[d] = c
                }
            }, unregisterHelper: function (b) {
                delete this.helpers[b]
            }, registerPartial: function (d, c) {
                v.call(d) === u ? C.extend(this.partials, d) : this.partials[d] = c
            }, unregisterPartial: function (b) {
                delete this.partials[b]
            }
        };
        var t = {
            methodMap: {0: "debug", 1: "info", 2: "warn", 3: "error"},
            DEBUG: 0,
            INFO: 1,
            WARN: 2,
            ERROR: 3,
            level: 3,
            log: function (f, d) {
                if (t.level <= f) {
                    var g = t.methodMap[f];
                    "undefined" != typeof console && console[g] && console[g].call(console, d)
                }
            }
        };
        G.logger = t;
        var s = t.log;
        G.log = s;
        var r = function (d) {
            var c = C.extend({}, d);
            return c._parent = d, c
        };
        G.createFrame = r
    }, function (D, C, B) {
        function A(b) {
            return u[b]
        }

        function z(f) {
            for (var d = 1; d < arguments.length; d++) {
                for (var g in arguments[d]) {
                    Object.prototype.hasOwnProperty.call(arguments[d], g) && (f[g] = arguments[d][g])
                }
            }
            return f
        }

        function y(b) {
            return b instanceof v ? b.toString() : null == b ? "" : b ? (b = "" + b, s.test(b) ? b.replace(t, A) : b) : b + ""
        }

        function x(b) {
            return b || 0 === b ? !(!p(b) || 0 !== b.length) : !0
        }

        function w(d, c) {
            return (d ? d + "." : "") + c
        }

        var v = B(124)["default"],
            u = {"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#x27;", "`": "&#x60;"}, t = /[&<>"'`]/g,
            s = /[&<>"'`]/;
        C.extend = z;
        var r = Object.prototype.toString;
        C.toString = r;
        var q = function (b) {
            return "function" == typeof b
        };
        q(/x/) && (q = function (b) {
            return "function" == typeof b && "[object Function]" === r.call(b)
        });
        var q;
        C.isFunction = q;
        var p = Array.isArray || function (b) {
            return b && "object" == typeof b ? "[object Array]" === r.call(b) : !1
        };
        C.isArray = p, C.escapeExpression = y, C.isEmpty = x, C.appendContextPath = w
    }, function (f, d) {
        function g(b) {
            this.string = b
        }

        g.prototype.toString = function () {
            return "" + this.string
        }, d["default"] = g
    }, function (g, f) {
        function j(k, d) {
            var n;
            d && d.firstLine && (n = d.firstLine, k += " - " + n + ":" + d.firstColumn);
            for (var m = Error.prototype.constructor.call(this, k), l = 0; l < h.length; l++) {
                this[h[l]] = m[h[l]]
            }
            n && (this.lineNumber = n, this.column = d.firstColumn)
        }

        var h = ["description", "fileName", "lineNumber", "message", "name", "number", "stack"];
        j.prototype = new Error, f["default"] = j
    }, function (B, A, z) {
        function y(g) {
            var f = g && g[0] || 1, k = q;
            if (f !== k) {
                if (k > f) {
                    var j = p[k], h = p[f];
                    throw new r("Template was precompiled with an older version of Handlebars than the current runtime. Please update your precompiler to a newer version (" + j + ") or downgrade your runtime to an older version (" + h + ").")
                }
                throw new r("Template was precompiled with a newer version of Handlebars than the current runtime. Please update your runtime to a newer version (" + g[1] + ").")
            }
        }

        function x(g, f) {
            if (!f) {
                throw new r("No environment passed to template")
            }
            if (!g || !g.main) {
                throw new r("Unknown template object: " + typeof g)
            }
            f.VM.checkRevision(g.compiler);
            var k = function (N, M, L, K, J, I, H, G, F) {
                J && (K = s.extend({}, K, J));
                var E = f.VM.invokePartial.call(this, N, L, K, I, H, G, F);
                if (null == E && f.compile) {
                    var D = {helpers: I, partials: H, data: G, depths: F};
                    H[L] = f.compile(N, {data: void 0 !== G, compat: g.compat}, f), E = H[L](K, D)
                }
                if (null != E) {
                    if (M) {
                        for (var C = E.split("\n"), b = 0, a = C.length; a > b && (C[b] || b + 1 !== a); b++) {
                            C[b] = M + C[b]
                        }
                        E = C.join("\n")
                    }
                    return E
                }
                throw new r("The partial " + L + " could not be compiled when running in runtime-only mode")
            }, j = {
                lookup: function (m, l) {
                    for (var C = m.length, n = 0; C > n; n++) {
                        if (m[n] && null != m[n][l]) {
                            return m[n][l]
                        }
                    }
                }, lambda: function (d, c) {
                    return "function" == typeof d ? d.call(c) : d
                }, escapeExpression: s.escapeExpression, invokePartial: k, fn: function (a) {
                    return g[a]
                }, programs: [], program: function (m, l, D) {
                    var C = this.programs[m], n = this.fn(m);
                    return l || D ? C = w(this, m, n, l, D) : C || (C = this.programs[m] = w(this, m, n)), C
                }, data: function (d, c) {
                    for (; d && c--;) {
                        d = d._parent
                    }
                    return d
                }, merge: function (l, d) {
                    var m = l || d;
                    return l && d && l !== d && (m = s.extend({}, d, l)), m
                }, noop: f.VM.noop, compilerInfo: g.compiler
            }, h = function (a, m) {
                m = m || {};
                var l = m.data;
                h._setup(m), !m.partial && g.useData && (l = t(a, l));
                var d;
                return g.useDepths && (d = m.depths ? [a].concat(m.depths) : [a]), g.main.call(j, a, j.helpers, j.partials, l, d)
            };
            return h.isTop = !0, h._setup = function (a) {
                a.partial ? (j.helpers = a.helpers, j.partials = a.partials) : (j.helpers = j.merge(a.helpers, f.helpers), g.usePartial && (j.partials = j.merge(a.partials, f.partials)))
            }, h._child = function (a, l, d) {
                if (g.useDepths && !d) {
                    throw new r("must pass parent depths")
                }
                return w(j, a, g[a], l, d)
            }, h
        }

        function w(h, g, m, l, k) {
            var j = function (a, c) {
                return c = c || {}, m.call(h, a, h.helpers, h.partials, c.data || l, k && [a].concat(k))
            };
            return j.program = g, j.depth = k ? k.length : 0, j
        }

        function v(k, j, E, D, C, n, m) {
            var l = {partial: !0, helpers: D, partials: C, data: n, depths: m};
            if (void 0 === k) {
                throw new r("The partial " + j + " could not be found")
            }
            return k instanceof Function ? k(E, l) : void 0
        }

        function u() {
            return ""
        }

        function t(d, c) {
            return c && "root" in c || (c = c ? o(c) : {}, c.root = d), c
        }

        var s = z(123), r = z(125)["default"], q = z(122).COMPILER_REVISION, p = z(122).REVISION_CHANGES,
            o = z(122).createFrame;
        A.checkRevision = y, A.template = x, A.program = w, A.invokePartial = v, A.noop = u
    }, function (g, f, k) {
        var j, h;
        j = [k(47), k(46), k(45), k(48)], h = function (z, y, x, w) {
            function v(d, c) {
                return /touch/.test(d.type) ? (d.originalEvent || d).changedTouches[0]["page" + c] : d["page" + c]
            }

            function u(d) {
                var c = d || window.event;
                return d instanceof MouseEvent ? "which" in c ? 3 === c.which : "button" in c ? 2 === c.button : !1 : !1
            }

            function t(m, l, B) {
                var A;
                return A = l instanceof MouseEvent || !l.touches && !l.changedTouches ? l : l.touches && l.touches.length ? l.touches[0] : l.changedTouches[0], {
                    type: m,
                    target: l.target,
                    currentTarget: B,
                    pageX: A.pageX,
                    pageY: A.pageY
                }
            }

            function s(b) {
                (b instanceof MouseEvent || b instanceof window.TouchEvent) && (b.preventManipulation && b.preventManipulation(), b.cancelable && b.preventDefault && b.preventDefault())
            }

            var r = !x.isUndefined(window.PointerEvent), q = !r && w.isMobile(), p = !r && !q,
                o = w.isFF() && w.isOSX(), n = function (P, O) {
                    function N(d) {
                        (p || r && "touch" !== d.pointerType) && G(y.touchEvents.OVER, d)
                    }

                    function M(d) {
                        (p || r && "touch" !== d.pointerType) && G(y.touchEvents.MOVE, d)
                    }

                    function L(a) {
                        (p || r && "touch" !== a.pointerType && !P.contains(document.elementFromPoint(a.x, a.y))) && G(y.touchEvents.OUT, a)
                    }

                    function K(a) {
                        F = a.target, B = v(a, "X"), l = v(a, "Y"), u(a) || (r ? a.isPrimary && (O.preventScrolling && (E = a.pointerId, P.setPointerCapture(E)), P.addEventListener("pointermove", J), P.addEventListener("pointercancel", H), P.addEventListener("pointerup", H)) : p && (document.addEventListener("mousemove", J), o && "object" === a.target.nodeName.toLowerCase() ? P.addEventListener("click", H) : document.addEventListener("mouseup", H)), F.addEventListener("touchmove", J), F.addEventListener("touchcancel", H), F.addEventListener("touchend", H))
                    }

                    function J(d) {
                        var T = y.touchEvents, S = 6;
                        if (C) {
                            G(T.DRAG, d)
                        } else {
                            var R = v(d, "X"), Q = v(d, "Y"), A = R - B, m = Q - l;
                            A * A + m * m > S * S && (G(T.DRAG_START, d), C = !0, G(T.DRAG, d))
                        }
                        O.preventScrolling && s(d)
                    }

                    function H(d) {
                        var a = y.touchEvents;
                        r ? (O.preventScrolling && P.releasePointerCapture(E), P.removeEventListener("pointermove", J), P.removeEventListener("pointercancel", H), P.removeEventListener("pointerup", H)) : p && (document.removeEventListener("mousemove", J), document.removeEventListener("mouseup", H)), F.removeEventListener("touchmove", J), F.removeEventListener("touchcancel", H), F.removeEventListener("touchend", H), C ? G(a.DRAG_END, d) : O.directSelect && d.target !== P || -1 !== d.type.indexOf("cancel") || (r && d instanceof window.PointerEvent ? "touch" === d.pointerType ? G(a.TAP, d) : G(a.CLICK, d) : p ? G(a.CLICK, d) : (G(a.TAP, d), s(d))), F = null, C = !1
                    }

                    function G(d, Q) {
                        var A;
                        if (O.enableDoubleTap && (d === y.touchEvents.CLICK || d === y.touchEvents.TAP)) {
                            if (x.now() - c < b) {
                                var m = d === y.touchEvents.CLICK ? y.touchEvents.DOUBLE_CLICK : y.touchEvents.DOUBLE_TAP;
                                A = t(m, Q, D), I.trigger(m, A), c = 0
                            } else {
                                c = x.now()
                            }
                        }
                        A = t(d, Q, D), I.trigger(d, A)
                    }

                    var F, E, D = P, C = !1, B = 0, l = 0, c = 0, b = 300;
                    O = O || {}, r ? (P.addEventListener("pointerdown", K), O.useHover && (P.addEventListener("pointerover", N), P.addEventListener("pointerout", L)), O.useMove && P.addEventListener("pointermove", M)) : p && (P.addEventListener("mousedown", K), O.useHover && (P.addEventListener("mouseover", N), P.addEventListener("mouseout", L)), O.useMove && P.addEventListener("mousemove", M)), P.addEventListener("touchstart", K);
                    var I = this;
                    return this.triggerEvent = G, this.destroy = function () {
                        P.removeEventListener("touchstart", K), P.removeEventListener("mousedown", K), F && (F.removeEventListener("touchmove", J), F.removeEventListener("touchcancel", H), F.removeEventListener("touchend", H)), r && (O.preventScrolling && P.releasePointerCapture(E), P.removeEventListener("pointerover", N), P.removeEventListener("pointerdown", K), P.removeEventListener("pointermove", J), P.removeEventListener("pointermove", M), P.removeEventListener("pointercancel", H), P.removeEventListener("pointerout", L), P.removeEventListener("pointerup", H)), P.removeEventListener("click", H), P.removeEventListener("mouseover", N), P.removeEventListener("mousemove", M), P.removeEventListener("mouseout", L), document.removeEventListener("mousemove", J), document.removeEventListener("mouseup", H)
                    }, this
                };
            return x.extend(n.prototype, z), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(55), k(62), k(45)], h = function (m, l, r, q) {
            var p = l.style, o = {
                back: !0,
                fontSize: 15,
                fontFamily: "Arial,sans-serif",
                fontOpacity: 100,
                color: "#FFF",
                backgroundColor: "#000",
                backgroundOpacity: 100,
                edgeStyle: null,
                windowColor: "#FFF",
                windowOpacity: 0,
                preprocessor: q.identity
            }, n = function (B) {
                function A(s) {
                    s = s || "";
                    var t = "jw-captions-window jw-reset";
                    s ? (D.innerHTML = s, a.className = t + " jw-captions-window-active") : (a.className = t, m.empty(D))
                }

                function z(s) {
                    c = s, x(u, c)
                }

                function y(t, s) {
                    var F = t.source, E = s.metadata;
                    return F ? E && q.isNumber(E[F]) ? E[F] : !1 : s.position
                }

                function x(t, s) {
                    if (t && t.data && s) {
                        var H = y(t, s);
                        if (H !== !1) {
                            var G = t.data;
                            if (!(d >= 0 && w(G, d, H))) {
                                for (var F = -1, E = 0; E < G.length; E++) {
                                    if (w(G, E, H)) {
                                        F = E;
                                        break
                                    }
                                }
                                -1 === F ? A("") : F !== d && (d = F, A(C.preprocessor(G[d].text)))
                            }
                        }
                    }
                }

                function w(t, s, E) {
                    return t[s].begin <= E && (!t[s].end || t[s].end >= E) && (s === t.length - 1 || t[s + 1].begin >= E)
                }

                function v(s, F, E) {
                    var t = l.hexToRgba("#000000", E);
                    "dropshadow" === s ? F.textShadow = "0 2px 1px " + t : "raised" === s ? F.textShadow = "0 0 5px " + t + ", 0 1px 5px " + t + ", 0 2px 5px " + t : "depressed" === s ? F.textShadow = "0 -2px 1px " + t : "uniform" === s && (F.textShadow = "-2px 0 1px " + t + ",2px 0 1px " + t + ",0 -2px 1px " + t + ",0 2px 1px " + t + ",-1px 1px 1px " + t + ",1px 1px 1px " + t + ",1px -1px 1px " + t + ",1px 1px 1px " + t)
                }

                var u, d, c, b, a, D, C = {};
                b = document.createElement("div"), b.className = "jw-captions jw-reset", this.show = function () {
                    b.className = "jw-captions jw-captions-enabled jw-reset"
                }, this.hide = function () {
                    b.className = "jw-captions jw-reset"
                }, this.populate = function (s) {
                    return d = -1, u = s, s ? void x(s, c) : void A("")
                }, this.resize = function () {
                    var t = b.clientWidth, s = Math.pow(t / 400, 0.6);
                    if (s) {
                        var E = C.fontSize * s;
                        p(b, {fontSize: Math.round(E) + "px"})
                    }
                }, this.setup = function (t) {
                    if (a = document.createElement("div"), D = document.createElement("span"), a.className = "jw-captions-window jw-reset", D.className = "jw-captions-text jw-reset", C = q.extend({}, o, t), t) {
                        var I = C.fontOpacity, H = C.windowOpacity, G = C.edgeStyle, F = C.backgroundColor, E = {},
                            s = {
                                color: l.hexToRgba(C.color, I),
                                fontFamily: C.fontFamily,
                                fontStyle: C.fontStyle,
                                fontWeight: C.fontWeight,
                                textDecoration: C.textDecoration
                            };
                        H && (E.backgroundColor = l.hexToRgba(C.windowColor, H)), v(G, s, I), C.back ? s.backgroundColor = l.hexToRgba(F, C.backgroundOpacity) : null === G && v("uniform", s), p(a, E), p(D, s)
                    }
                    a.appendChild(D), b.appendChild(a), this.populate(B.get("captionsTrack"))
                }, this.element = function () {
                    return b
                }, B.on("change:playlistItem", function () {
                    c = null, d = -1, A("")
                }, this), B.on("change:captionsTrack", function (t, s) {
                    this.populate(s)
                }, this), B.mediaController.on("seek", function () {
                    d = -1
                }, this), B.mediaController.on("time seek", z, this), B.mediaController.on("subtitlesTrackData", function () {
                    x(u, c)
                }, this), B.on("change:state", function (t, s) {
                    switch (s) {
                        case r.IDLE:
                        case r.ERROR:
                        case r.COMPLETE:
                            this.hide();
                            break;
                        default:
                            this.show()
                    }
                }, this)
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(127), k(46), k(47), k(45)], h = function (m, l, p, o) {
            var n = function (w, v, u) {
                function t(x) {
                    return w.get("flashBlocked") ? void 0 : q ? void q(x) : void a.trigger(x.type === l.touchEvents.CLICK ? "click" : "tap")
                }

                function s() {
                    return d ? void d() : void a.trigger("doubleClick")
                }

                var r, q, d, c = {enableDoubleTap: !0, useMove: !0};
                o.extend(this, p), r = v, this.element = function () {
                    return r
                };
                var b = new m(r, o.extend(c, u));
                b.on("click tap", t), b.on("doubleClick doubleTap", s), b.on("move", function () {
                    a.trigger("move")
                }), b.on("over", function () {
                    a.trigger("over")
                }), b.on("out", function () {
                    a.trigger("out")
                }), this.clickHandler = t;
                var a = this;
                this.setAlternateClickHandlers = function (y, x) {
                    q = y, d = x || null
                }, this.revertAlternateClickHandlers = function () {
                    q = null, d = null
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(47), k(127), k(131), k(45)], h = function (m, l, q, p, o) {
            var n = function (b) {
                o.extend(this, l), this.model = b, this.el = m.createElement(p({}));
                var a = this;
                this.iconUI = new q(this.el).on("click tap", function (c) {
                    a.trigger(c.type)
                })
            };
            return o.extend(n.prototype, {
                element: function () {
                    return this.el
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, n, m) {
                return '<div class="jw-display-icon-container jw-background-color jw-reset">\n    <div class="jw-icon jw-icon-display jw-button-color jw-reset"></div>\n</div>\n'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(127), k(48), k(46), k(45), k(47), k(133)], h = function (t, s, r, q, p, o) {
            var n = s.style, m = {linktarget: "_blank", margin: 8, hide: !1, position: "top-right"}, l = function (u) {
                var d, c, b = new Image, a = q.extend({}, u.get("logo"));
                return q.extend(this, p), this.setup = function (v) {
                    if (c = q.extend({}, m, a), c.hide = "true" === c.hide.toString(), d = s.createElement(o()), c.file) {
                        c.hide && s.addClass(d, "jw-hide"), s.addClass(d, "jw-logo-" + (c.position || m.position)), "top-right" === c.position && (u.on("change:dock", this.topRight, this), u.on("change:controls", this.topRight, this), this.topRight(u)), u.set("logo", c), b.onload = function () {
                            var y = {
                                backgroundImage: 'url("' + this.src + '")',
                                width: this.width,
                                height: this.height
                            };
                            if (c.margin !== m.margin) {
                                var x = /(\w+)-(\w+)/.exec(c.position);
                                3 === x.length && (y["margin-" + x[1]] = c.margin, y["margin-" + x[2]] = c.margin)
                            }
                            n(d, y), u.set("logoWidth", y.width)
                        }, b.src = c.file;
                        var w = new t(d);
                        w.on("click tap", function (x) {
                            s.exists(x) && x.stopPropagation && x.stopPropagation(), this.trigger(r.JWPLAYER_LOGO_CLICK, {
                                link: c.link,
                                linktarget: c.linktarget
                            })
                        }, this), v.appendChild(d)
                    }
                }, this.topRight = function (w) {
                    var v = w.get("controls"), y = w.get("dock"),
                        x = v && (y && y.length || w.get("sharing") || w.get("related"));
                    n(d, {top: x ? "3.5em" : 0})
                }, this.element = function () {
                    return d
                }, this.position = function () {
                    return c.position
                }, this.destroy = function () {
                    b.onload = null
                }, this
            };
            return l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, n, m) {
                return '<div class="jw-logo jw-reset"></div>'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(45), k(47), k(58), k(127), k(136), k(135), k(142), k(144), k(146), k(147)], h = function (F, E, D, C, B, A, z, y, x, w, v) {
            function u(l, d) {
                var m = document.createElement("div");
                return m.className = "jw-icon jw-icon-inline jw-button-color jw-reset " + l, m.style.display = "none", d && new B(m).on("click tap", function () {
                    d()
                }), {
                    element: function () {
                        return m
                    }, toggle: function (b) {
                        b ? this.show() : this.hide()
                    }, show: function () {
                        m.style.display = ""
                    }, hide: function () {
                        m.style.display = "none"
                    }
                }
            }

            function t(d) {
                var c = document.createElement("span");
                return c.className = "jw-text jw-reset " + d, c
            }

            function s(d) {
                var c = new y(d);
                return c
            }

            function r(b, m) {
                var l = document.createElement("div");
                return l.className = "jw-group jw-controlbar-" + b + "-group jw-reset", E.each(m, function (c) {
                    c.element && (c = c.element()), l.appendChild(c)
                }), l
            }

            function q(a, d) {
                this._api = a, this._model = d, this._isMobile = F.isMobile(), this._compactModeMaxSize = 400, this._maxCompactWidth = -1, this.setup()
            }

            return E.extend(q.prototype, D, {
                setup: function () {
                    this.build(), this.initialize()
                }, build: function () {
                    var b, G, o, n, l = new z(this._model, this._api), m = new v("jw-icon-more");
                    this._model.get("visualplaylist") !== !1 && (b = new x("jw-icon-playlist")), this._isMobile || (n = u("jw-icon-volume", this._api.setMute), G = new A("jw-slider-volume", "horizontal"), o = new w(this._model, "jw-icon-volume")), this.elements = {
                        alt: t("jw-text-alt"),
                        play: u("jw-icon-playback", this._api.play.bind(this, {reason: "interaction"})),
                        prev: u("jw-icon-prev", this._api.playlistPrev.bind(this, {reason: "interaction"})),
                        next: u("jw-icon-next", this._api.playlistNext.bind(this, {reason: "interaction"})),
                        playlist: b,
                        elapsed: t("jw-text-elapsed"),
                        time: l,
                        duration: t("jw-text-duration"),
                        drawer: m,
                        hd: s("jw-icon-hd"),
                        cc: s("jw-icon-cc"),
                        audiotracks: s("jw-icon-audio-tracks"),
                        mute: n,
                        volume: G,
                        volumetooltip: o,
                        cast: u("jw-icon-cast jw-off", this._api.castToggle),
                        fullscreen: u("jw-icon-fullscreen", this._api.setFullscreen)
                    }, this.layout = {
                        left: [this.elements.play, this.elements.prev, this.elements.playlist, this.elements.next, this.elements.elapsed],
                        center: [this.elements.time, this.elements.alt],
                        right: [this.elements.duration, this.elements.hd, this.elements.cc, this.elements.audiotracks, this.elements.drawer, this.elements.mute, this.elements.cast, this.elements.volume, this.elements.volumetooltip, this.elements.fullscreen],
                        drawer: [this.elements.hd, this.elements.cc, this.elements.audiotracks]
                    }, this.menus = E.compact([this.elements.playlist, this.elements.hd, this.elements.cc, this.elements.audiotracks, this.elements.volumetooltip]), this.layout.left = E.compact(this.layout.left), this.layout.center = E.compact(this.layout.center), this.layout.right = E.compact(this.layout.right), this.layout.drawer = E.compact(this.layout.drawer), this.el = document.createElement("div"), this.el.className = "jw-controlbar jw-background-color jw-reset", this.elements.left = r("left", this.layout.left), this.elements.center = r("center", this.layout.center), this.elements.right = r("right", this.layout.right), this.el.appendChild(this.elements.left), this.el.appendChild(this.elements.center), this.el.appendChild(this.elements.right)
                }, initialize: function () {
                    this.elements.play.show(), this.elements.fullscreen.show(), this.elements.mute && this.elements.mute.show(), this.onVolume(this._model, this._model.get("volume")), this.onPlaylist(this._model, this._model.get("playlist")), this.onPlaylistItem(this._model, this._model.get("playlistItem")), this.onMediaModel(this._model, this._model.get("mediaModel")), this.onCastAvailable(this._model, this._model.get("castAvailable")), this.onCastActive(this._model, this._model.get("castActive")), this.onCaptionsList(this._model, this._model.get("captionsList")), this._model.on("change:volume", this.onVolume, this), this._model.on("change:mute", this.onMute, this), this._model.on("change:playlist", this.onPlaylist, this), this._model.on("change:playlistItem", this.onPlaylistItem, this), this._model.on("change:mediaModel", this.onMediaModel, this), this._model.on("change:castAvailable", this.onCastAvailable, this), this._model.on("change:castActive", this.onCastActive, this), this._model.on("change:duration", this.onDuration, this), this._model.on("change:position", this.onElapsed, this), this._model.on("change:fullscreen", this.onFullscreen, this), this._model.on("change:captionsList", this.onCaptionsList, this), this._model.on("change:captionsIndex", this.onCaptionsIndex, this), this._model.on("change:compactUI", this.onCompactUI, this), this.elements.volume && this.elements.volume.on("update", function (d) {
                        var c = d.percentage;
                        this._api.setVolume(c)
                    }, this), this.elements.volumetooltip && (this.elements.volumetooltip.on("update", function (d) {
                        var c = d.percentage;
                        this._api.setVolume(c)
                    }, this), this.elements.volumetooltip.on("toggleValue", function () {
                        this._api.setMute()
                    }, this)), this.elements.playlist && this.elements.playlist.on("select", function (b) {
                        this._model.once("itemReady", function () {
                            this._api.play({reason: "interaction"})
                        }, this), this._api.load(b)
                    }, this), this.elements.hd.on("select", function (b) {
                        this._model.getVideo().setCurrentQuality(b)
                    }, this), this.elements.hd.on("toggleValue", function () {
                        this._model.getVideo().setCurrentQuality(0 === this._model.getVideo().getCurrentQuality() ? 1 : 0)
                    }, this), this.elements.cc.on("select", function (b) {
                        this._api.setCurrentCaptions(b)
                    }, this), this.elements.cc.on("toggleValue", function () {
                        var b = this._model.get("captionsIndex");
                        this._api.setCurrentCaptions(b ? 0 : 1)
                    }, this), this.elements.audiotracks.on("select", function (b) {
                        this._model.getVideo().setCurrentAudioTrack(b)
                    }, this), new B(this.elements.duration).on("click tap", function () {
                        if ("DVR" === F.adaptiveType(this._model.get("duration"))) {
                            var a = this._model.get("position");
                            this._api.seek(Math.max(C.dvrSeekLimit, a))
                        }
                    }, this), new B(this.el).on("click tap drag", function () {
                        this.trigger("userAction")
                    }, this), this.elements.drawer.on("open-drawer close-drawer", function (a, d) {
                        F.toggleClass(this.el, "jw-drawer-expanded", d.isOpen), d.isOpen || this.closeMenus()
                    }, this), E.each(this.menus, function (b) {
                        b.on("open-tooltip", this.closeMenus, this)
                    }, this)
                }, onCaptionsList: function (l, d) {
                    var m = l.get("captionsIndex");
                    this.elements.cc.setup(d, m), this.clearCompactMode()
                }, onCaptionsIndex: function (d, c) {
                    this.elements.cc.selectItem(c)
                }, onPlaylist: function (l, d) {
                    var m = d.length > 1;
                    this.elements.next.toggle(m), this.elements.prev.toggle(m), this.elements.playlist && this.elements.playlist.setup(d, l.get("item"))
                }, onPlaylistItem: function (d) {
                    this.elements.time.updateBuffer(0), this.elements.time.render(0), this.elements.duration.innerHTML = "00:00", this.elements.elapsed.innerHTML = "00:00", this.clearCompactMode();
                    var c = d.get("item");
                    this.elements.playlist && this.elements.playlist.selectItem(c), this.elements.audiotracks.setup()
                }, onMediaModel: function (b, a) {
                    a.on("change:levels", function (d, c) {
                        this.elements.hd.setup(c, d.get("currentLevel")), this.clearCompactMode()
                    }, this), a.on("change:currentLevel", function (d, c) {
                        this.elements.hd.selectItem(c)
                    }, this), a.on("change:audioTracks", function (l, n) {
                        var m = E.map(n, function (c) {
                            return {label: c.name}
                        });
                        this.elements.audiotracks.setup(m, l.get("currentAudioTrack"), {toggle: !1}), this.clearCompactMode()
                    }, this), a.on("change:currentAudioTrack", function (d, c) {
                        this.elements.audiotracks.selectItem(c)
                    }, this), a.on("change:state", function (d, l) {
                        "complete" === l && (this.elements.drawer.closeTooltip(), F.removeClass(this.el, "jw-drawer-expanded"))
                    }, this)
                }, onVolume: function (d, c) {
                    this.renderVolume(d.get("mute"), c)
                }, onMute: function (d, c) {
                    this.renderVolume(c, d.get("volume"))
                }, renderVolume: function (a, d) {
                    this.elements.mute && F.toggleClass(this.elements.mute.element(), "jw-off", a), this.elements.volume && this.elements.volume.render(a ? 0 : d), this.elements.volumetooltip && (this.elements.volumetooltip.volumeSlider.render(a ? 0 : d), F.toggleClass(this.elements.volumetooltip.element(), "jw-off", a))
                }, onCastAvailable: function (d, c) {
                    this.elements.cast.toggle(c), this.clearCompactMode()
                }, onCastActive: function (a, d) {
                    F.toggleClass(this.elements.cast.element(), "jw-off", !d)
                }, onElapsed: function (a, n) {
                    var m, l = a.get("duration");
                    m = "DVR" === F.adaptiveType(l) ? "-" + F.timeFormat(-l) : F.timeFormat(n), this.elements.elapsed.innerHTML = m
                }, onDuration: function (a, m) {
                    var l;
                    "DVR" === F.adaptiveType(m) ? (l = "Live", this.clearCompactMode()) : l = F.timeFormat(m), this.elements.duration.innerHTML = l
                }, onFullscreen: function (a, d) {
                    F.toggleClass(this.elements.fullscreen.element(), "jw-off", d)
                }, element: function () {
                    return this.el
                }, getVisibleBounds: function () {
                    var a, m = this.el, l = getComputedStyle ? getComputedStyle(m) : m.currentStyle;
                    return "table" === l.display ? F.bounds(m) : (m.style.visibility = "hidden", m.style.display = "table", a = F.bounds(m), m.style.visibility = m.style.display = "", a)
                }, setAltText: function (b) {
                    this.elements.alt.innerHTML = b
                }, addCues: function (b) {
                    this.elements.time && (E.each(b, function (c) {
                        this.elements.time.addCue(c)
                    }, this), this.elements.time.drawCues())
                }, closeMenus: function (b) {
                    E.each(this.menus, function (a) {
                        b && b.target === a.el || a.closeTooltip(b)
                    })
                }, hideComponents: function () {
                    this.closeMenus(), this.elements.drawer.closeTooltip(), F.removeClass(this.el, "jw-drawer-expanded")
                }, clearCompactMode: function () {
                    this._maxCompactWidth = -1, this._model.set("compactUI", !1), this._containerWidth && this.checkCompactMode(this._containerWidth)
                }, setCompactModeBounds: function () {
                    if (this.element().offsetWidth > 0) {
                        var a = this.elements.left.offsetWidth + this.elements.right.offsetWidth;
                        if ("LIVE" === F.adaptiveType(this._model.get("duration"))) {
                            this._maxCompactWidth = a + this.elements.alt.offsetWidth
                        } else {
                            var m = a + (this.elements.center.offsetWidth - this.elements.time.el.offsetWidth), l = 0.2;
                            this._maxCompactWidth = m / (1 - l)
                        }
                    }
                }, checkCompactMode: function (b) {
                    -1 === this._maxCompactWidth && this.setCompactModeBounds(), this._containerWidth = b, -1 !== this._maxCompactWidth && (b >= this._compactModeMaxSize && b > this._maxCompactWidth ? this._model.set("compactUI", !1) : (b < this._compactModeMaxSize || b <= this._maxCompactWidth) && this._model.set("compactUI", !0))
                }, onCompactUI: function (b, a) {
                    F.removeClass(this.el, "jw-drawer-expanded"), this.elements.drawer.setup(this.layout.drawer, a), (!a || this.elements.drawer.activeContents.length < 2) && E.each(this.layout.drawer, function (c) {
                        this.elements.right.insertBefore(c.el, this.elements.drawer.el)
                    }, this)
                }
            }), q
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48), k(58), k(136), k(139), k(140), k(141)], h = function (t, s, r, q, p, o, n) {
            var m = p.extend({
                setup: function () {
                    this.text = document.createElement("span"), this.text.className = "jw-text jw-reset", this.img = document.createElement("div"), this.img.className = "jw-reset";
                    var b = document.createElement("div");
                    b.className = "jw-time-tip jw-background-color jw-reset", b.appendChild(this.img), b.appendChild(this.text), s.removeClass(this.el, "jw-hidden"), this.addContent(b)
                }, image: function (b) {
                    s.style(this.img, b)
                }, update: function (b) {
                    this.text.innerHTML = b
                }
            }), l = q.extend({
                constructor: function (a, d) {
                    this._model = a, this._api = d, this.timeTip = new m("jw-tooltip-time"), this.timeTip.setup(), this.cues = [], this.seekThrottled = t.throttle(this.performSeek, 400), this._model.on("change:playlistItem", this.onPlaylistItem, this).on("change:position", this.onPosition, this).on("change:duration", this.onDuration, this).on("change:buffer", this.onBuffer, this), q.call(this, "jw-slider-time", "horizontal")
                }, setup: function () {
                    q.prototype.setup.apply(this, arguments), this._model.get("playlistItem") && this.onPlaylistItem(this._model, this._model.get("playlistItem")), this.elementRail.appendChild(this.timeTip.element()), this.el.addEventListener("mousemove", this.showTimeTooltip.bind(this), !1), this.el.addEventListener("mouseout", this.hideTimeTooltip.bind(this), !1)
                }, limit: function (x) {
                    if (this.activeCue && t.isNumber(this.activeCue.pct)) {
                        return this.activeCue.pct
                    }
                    var w = this._model.get("duration"), v = s.adaptiveType(w);
                    if ("DVR" === v) {
                        var u = (1 - x / 100) * w, c = this._model.get("position"),
                            b = Math.min(u, Math.max(r.dvrSeekLimit, c)), a = 100 * b / w;
                        return 100 - a
                    }
                    return x
                }, update: function (b) {
                    this.seekTo = b, this.seekThrottled(), q.prototype.update.apply(this, arguments)
                }, dragStart: function () {
                    this._model.set("scrubbing", !0), q.prototype.dragStart.apply(this, arguments)
                }, dragEnd: function () {
                    q.prototype.dragEnd.apply(this, arguments), this._model.set("scrubbing", !1)
                }, onSeeked: function () {
                    this._model.get("scrubbing") && this.performSeek()
                }, onBuffer: function (d, c) {
                    this.updateBuffer(c)
                }, onPosition: function (d, c) {
                    this.updateTime(c, d.get("duration"))
                }, onDuration: function (d, c) {
                    this.updateTime(d.get("position"), c)
                }, updateTime: function (b, w) {
                    var v = 0;
                    if (w) {
                        var u = s.adaptiveType(w);
                        "DVR" === u ? v = (w - b) / w * 100 : "VOD" === u && (v = b / w * 100)
                    }
                    this.render(v)
                }, onPlaylistItem: function (a, v) {
                    this.reset(), a.mediaModel.on("seeked", this.onSeeked, this);
                    var u = v.tracks;
                    t.each(u, function (b) {
                        b && b.kind && "thumbnails" === b.kind.toLowerCase() ? this.loadThumbnails(b.file) : b && b.kind && "chapters" === b.kind.toLowerCase() && this.loadChapters(b.file)
                    }, this)
                }, performSeek: function () {
                    var b, w = this.seekTo, v = this._model.get("duration"), u = s.adaptiveType(v);
                    0 === v ? this._api.play() : "DVR" === u ? (b = (100 - w) / 100 * v, this._api.seek(b)) : (b = w / 100 * v, this._api.seek(Math.min(b, v - 0.25)))
                }, showTimeTooltip: function (b) {
                    var z = this._model.get("duration");
                    if (0 !== z) {
                        var y = s.bounds(this.elementRail), x = b.pageX ? b.pageX - y.left : b.x;
                        x = s.between(x, 0, y.width);
                        var w = x / y.width, v = z * w;
                        0 > z && (v = z - v);
                        var u;
                        if (this.activeCue) {
                            u = this.activeCue.text
                        } else {
                            var c = !0;
                            u = s.timeFormat(v, c), 0 > z && v > r.dvrSeekLimit && (u = "Live")
                        }
                        this.timeTip.update(u), this.showThumbnail(v), s.addClass(this.timeTip.el, "jw-open"), this.timeTip.el.style.left = 100 * w + "%"
                    }
                }, hideTimeTooltip: function () {
                    s.removeClass(this.timeTip.el, "jw-open")
                }, reset: function () {
                    this.resetChapters(), this.resetThumbnails()
                }
            });
            return t.extend(l.prototype, o, n), l
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(137), k(127), k(138), k(48)], h = function (m, l, p, o) {
            var n = m.extend({
                constructor: function (d, c) {
                    this.className = d + " jw-background-color jw-reset", this.orientation = c, this.dragStartListener = this.dragStart.bind(this), this.dragMoveListener = this.dragMove.bind(this), this.dragEndListener = this.dragEnd.bind(this), this.tapListener = this.tap.bind(this), this.setup()
                }, setup: function () {
                    var b = {
                        "default": this["default"],
                        className: this.className,
                        orientation: "jw-slider-" + this.orientation
                    };
                    this.el = o.createElement(p(b)), this.elementRail = this.el.getElementsByClassName("jw-slider-container")[0], this.elementBuffer = this.el.getElementsByClassName("jw-buffer")[0], this.elementProgress = this.el.getElementsByClassName("jw-progress")[0], this.elementThumb = this.el.getElementsByClassName("jw-knob")[0], this.userInteract = new l(this.element(), {preventScrolling: !0}), this.userInteract.on("dragStart", this.dragStartListener), this.userInteract.on("drag", this.dragMoveListener), this.userInteract.on("dragEnd", this.dragEndListener), this.userInteract.on("tap click", this.tapListener)
                }, dragStart: function () {
                    this.trigger("dragStart"), this.railBounds = o.bounds(this.elementRail)
                }, dragEnd: function (b) {
                    this.dragMove(b), this.trigger("dragEnd")
                }, dragMove: function (q) {
                    var d, t, s = this.railBounds = this.railBounds ? this.railBounds : o.bounds(this.elementRail);
                    "horizontal" === this.orientation ? (d = q.pageX, t = d < s.left ? 0 : d > s.right ? 100 : 100 * o.between((d - s.left) / s.width, 0, 1)) : (d = q.pageY, t = d >= s.bottom ? 0 : d <= s.top ? 100 : 100 * o.between((s.height - (d - s.top)) / s.height, 0, 1));
                    var r = this.limit(t);
                    return this.render(r), this.update(r), !1
                }, tap: function (b) {
                    this.railBounds = o.bounds(this.elementRail), this.dragMove(b)
                }, limit: function (b) {
                    return b
                }, update: function (b) {
                    this.trigger("update", {percentage: b})
                }, render: function (b) {
                    b = Math.max(0, Math.min(b, 100)), "horizontal" === this.orientation ? (this.elementThumb.style.left = b + "%", this.elementProgress.style.width = b + "%") : (this.elementThumb.style.bottom = b + "%", this.elementProgress.style.height = b + "%")
                }, updateBuffer: function (b) {
                    this.elementBuffer.style.width = b + "%"
                }, element: function () {
                    return this.el
                }
            });
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(47), k(45)], h = function (m, l) {
            function o() {
            }

            var n = function (b, s) {
                var r, q = this;
                r = b && l.has(b, "constructor") ? b.constructor : function () {
                    return q.apply(this, arguments)
                }, l.extend(r, q, s);
                var p = function () {
                    this.constructor = r
                };
                return p.prototype = q.prototype, r.prototype = new p, b && l.extend(r.prototype, b), r.__super__ = q.prototype, r
            };
            return o.extend = n, l.extend(o.prototype, m), o
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return '<div class="' + m((p = null != (p = k.className || (null != l ? l.className : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "className",
                    hash: {},
                    data: q
                }) : p)) + " " + m((p = null != (p = k.orientation || (null != l ? l.orientation : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "orientation",
                    hash: {},
                    data: q
                }) : p)) + ' jw-reset">\n    <div class="jw-slider-container jw-reset">\n        <div class="jw-rail jw-reset"></div>\n        <div class="jw-buffer jw-reset"></div>\n        <div class="jw-progress jw-reset"></div>\n        <div class="jw-knob jw-reset"></div>\n    </div>\n</div>'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(137), k(48)], h = function (l, d) {
            var m = l.extend({
                constructor: function (b) {
                    this.el = document.createElement("div"), this.el.className = "jw-icon jw-icon-tooltip " + b + " jw-button-color jw-reset jw-hidden", this.container = document.createElement("div"), this.container.className = "jw-overlay jw-reset", this.openClass = "jw-open", this.componentType = "tooltip", this.el.appendChild(this.container)
                }, addContent: function (b) {
                    this.content && this.removeContent(), this.content = b, this.container.appendChild(b)
                }, removeContent: function () {
                    this.content && (this.container.removeChild(this.content), this.content = null)
                }, hasContent: function () {
                    return !!this.content
                }, element: function () {
                    return this.el
                }, openTooltip: function (b) {
                    this.trigger("open-" + this.componentType, b, {isOpen: !0}), this.isOpen = !0, d.toggleClass(this.el, this.openClass, this.isOpen)
                }, closeTooltip: function (b) {
                    this.trigger("close-" + this.componentType, b, {isOpen: !1}), this.isOpen = !1, d.toggleClass(this.el, this.openClass, this.isOpen)
                }, toggleOpenState: function (b) {
                    this.isOpen ? this.closeTooltip(b) : this.openTooltip(b)
                }
            });
            return m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48), k(112)], h = function (m, l, p) {
            function o(d, c) {
                this.time = d, this.text = c, this.el = document.createElement("div"), this.el.className = "jw-cue jw-reset"
            }

            m.extend(o.prototype, {
                align: function (d) {
                    if ("%" === this.time.toString().slice(-1)) {
                        this.pct = this.time
                    } else {
                        var c = this.time / d * 100;
                        this.pct = c + "%"
                    }
                    this.el.style.left = this.pct
                }
            });
            var n = {
                loadChapters: function (b) {
                    l.ajax(b, this.chaptersLoaded.bind(this), this.chaptersFailed, {plainText: !0})
                }, chaptersLoaded: function (a) {
                    var c = p(a.responseText);
                    m.isArray(c) && (m.each(c, this.addCue, this), this.drawCues())
                }, chaptersFailed: function () {
                }, addCue: function (b) {
                    this.cues.push(new o(b.begin, b.text))
                }, drawCues: function () {
                    var a = this._model.mediaModel.get("duration");
                    if (!a || 0 >= a) {
                        return void this._model.mediaModel.once("change:duration", this.drawCues, this)
                    }
                    var d = this;
                    m.each(this.cues, function (b) {
                        b.align(a), b.el.addEventListener("mouseover", function () {
                            d.activeCue = b
                        }), b.el.addEventListener("mouseout", function () {
                            d.activeCue = null
                        }), d.elementRail.appendChild(b.el)
                    })
                }, resetChapters: function () {
                    m.each(this.cues, function (b) {
                        b.el.parentNode && b.el.parentNode.removeChild(b.el)
                    }, this), this.cues = []
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48), k(112)], h = function (m, l, p) {
            function o(b) {
                this.begin = b.begin, this.end = b.end, this.img = b.text
            }

            var n = {
                loadThumbnails: function (b) {
                    b && (this.vttPath = b.split("?")[0].split("/").slice(0, -1).join("/"), this.individualImage = null, l.ajax(b, this.thumbnailsLoaded.bind(this), this.thumbnailsFailed.bind(this), {plainText: !0}))
                }, thumbnailsLoaded: function (a) {
                    var c = p(a.responseText);
                    m.isArray(c) && (m.each(c, function (b) {
                        this.thumbnails.push(new o(b))
                    }, this), this.drawCues())
                }, thumbnailsFailed: function () {
                }, chooseThumbnail: function (a) {
                    var r = m.sortedIndex(this.thumbnails, {end: a}, m.property("end"));
                    r >= this.thumbnails.length && (r = this.thumbnails.length - 1);
                    var q = this.thumbnails[r].img;
                    return q.indexOf("://") < 0 && (q = this.vttPath ? this.vttPath + "/" + q : q), q
                }, loadThumbnail: function (a) {
                    var u = this.chooseThumbnail(a),
                        t = {display: "block", margin: "0 auto", backgroundPosition: "0 0"}, s = u.indexOf("#xywh");
                    if (s > 0) {
                        try {
                            var r = /(.+)\#xywh=(\d+),(\d+),(\d+),(\d+)/.exec(u);
                            u = r[1], t.backgroundPosition = -1 * r[2] + "px " + -1 * r[3] + "px", t.width = r[4], t.height = r[5]
                        } catch (q) {
                            return
                        }
                    } else {
                        this.individualImage || (this.individualImage = new Image, this.individualImage.onload = m.bind(function () {
                            this.individualImage.onload = null, this.timeTip.image({
                                width: this.individualImage.width,
                                height: this.individualImage.height
                            })
                        }, this), this.individualImage.src = u)
                    }
                    return t.backgroundImage = 'url("' + u + '")', t
                }, showThumbnail: function (b) {
                    this.thumbnails.length < 1 || this.timeTip.image(this.loadThumbnail(b))
                }, resetThumbnails: function () {
                    this.timeTip.image({backgroundImage: "", width: 0, height: 0}), this.thumbnails = []
                }
            };
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(139), k(48), k(45), k(127), k(143)], h = function (m, l, q, p, o) {
            var n = m.extend({
                setup: function (b, u, t) {
                    this.iconUI || (this.iconUI = new p(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }), this.toggleValueListener = this.toggleValue.bind(this), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this), this.selectListener = this.select.bind(this)), this.reset(), b = q.isArray(b) ? b : [], l.toggleClass(this.el, "jw-hidden", b.length < 2);
                    var s = b.length > 2 || 2 === b.length && t && t.toggle === !1, r = !s && 2 === b.length;
                    if (l.toggleClass(this.el, "jw-toggle", r), l.toggleClass(this.el, "jw-button-color", !r), this.isActive = s || r, s) {
                        l.removeClass(this.el, "jw-off"), this.iconUI.on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener);
                        var d = o(b), c = l.createElement(d);
                        this.addContent(c), this.contentUI = new p(this.content).on("click tap", this.selectListener)
                    } else {
                        r && this.iconUI.on("click tap", this.toggleValueListener)
                    }
                    this.selectItem(u)
                }, toggleValue: function () {
                    this.trigger("toggleValue")
                }, select: function (b) {
                    if (b.target.parentElement === this.content) {
                        var r = l.classList(b.target), c = q.find(r, function (d) {
                            return 0 === d.indexOf("jw-item")
                        });
                        c && (this.trigger("select", parseInt(c.split("-")[2])), this.closeTooltipListener())
                    }
                }, selectItem: function (b) {
                    if (this.content) {
                        for (var d = 0; d < this.content.children.length; d++) {
                            l.toggleClass(this.content.children[d], "jw-active-option", b === d)
                        }
                    } else {
                        l.toggleClass(this.el, "jw-off", 0 === b)
                    }
                }, reset: function () {
                    l.addClass(this.el, "jw-off"), this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            1: function (l, k, p, o) {
                var n = this.lambda, m = this.escapeExpression;
                return "        <li class='jw-text jw-option jw-item-" + m(n(o && o.index, l)) + " jw-reset'>" + m(n(null != l ? l.label : l, l)) + "</li>\n"
            }, compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, p, o) {
                var n, m = '<ul class="jw-menu jw-background-color jw-reset">\n';
                return n = k.each.call(l, l, {
                    name: "each",
                    hash: {},
                    fn: this.program(1, o),
                    inverse: this.noop,
                    data: o
                }), null != n && (m += n), m + "</ul>"
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(45), k(139), k(127), k(145)], h = function (m, l, q, p, o) {
            var n = q.extend({
                setup: function (r, d) {
                    if (this.iconUI || (this.iconUI = new p(this.el, {useHover: !0}), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this), this.selectListener = this.onSelect.bind(this)), this.reset(), r = l.isArray(r) ? r : [], m.toggleClass(this.el, "jw-hidden", r.length < 2), r.length >= 2) {
                        this.iconUI = new p(this.el, {useHover: !0}).on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener);
                        var b = this.menuTemplate(r, d), a = m.createElement(b);
                        this.addContent(a), this.contentUI = new p(this.content), this.contentUI.on("click tap", this.selectListener)
                    }
                    this.originalList = r
                }, menuTemplate: function (b, s) {
                    var r = l.map(b, function (d, c) {
                        return {active: c === s, label: c + 1 + ".", title: d.title}
                    });
                    return o(r)
                }, onSelect: function (s) {
                    var r = s.target;
                    if ("UL" !== r.tagName) {
                        "LI" !== r.tagName && (r = r.parentElement);
                        var b = m.classList(r), a = l.find(b, function (c) {
                            return 0 === c.indexOf("jw-item")
                        });
                        a && (this.trigger("select", parseInt(a.split("-")[2])), this.closeTooltip())
                    }
                }, selectItem: function (b) {
                    this.setup(this.originalList, b)
                }, reset: function () {
                    this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            1: function (l, k, p, o) {
                var n, m = "";
                return n = k["if"].call(l, null != l ? l.active : l, {
                    name: "if",
                    hash: {},
                    fn: this.program(2, o),
                    inverse: this.program(4, o),
                    data: o
                }), null != n && (m += n), m
            }, 2: function (l, k, p, o) {
                var n = this.lambda, m = this.escapeExpression;
                return "                <li class='jw-option jw-text jw-active-option jw-item-" + m(n(o && o.index, l)) + ' jw-reset\'>\n                    <span class="jw-label jw-reset"><span class="jw-icon jw-icon-play jw-reset"></span></span>\n                    <span class="jw-name jw-reset">' + m(n(null != l ? l.title : l, l)) + "</span>\n                </li>\n"
            }, 4: function (l, k, p, o) {
                var n = this.lambda, m = this.escapeExpression;
                return "                <li class='jw-option jw-text jw-item-" + m(n(o && o.index, l)) + ' jw-reset\'>\n                    <span class="jw-label jw-reset">' + m(n(null != l ? l.label : l, l)) + '</span>\n                    <span class="jw-name jw-reset">' + m(n(null != l ? l.title : l, l)) + "</span>\n                </li>\n"
            }, compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, p, o) {
                var n,
                    m = '<div class="jw-menu jw-playlist-container jw-background-color jw-reset">\n\n    <div class="jw-tooltip-title jw-reset">\n        <span class="jw-icon jw-icon-inline jw-icon-playlist jw-reset"></span>\n        <span class="jw-text jw-reset">PLAYLIST</span>\n    </div>\n\n    <ul class="jw-playlist jw-reset">\n';
                return n = k.each.call(l, l, {
                    name: "each",
                    hash: {},
                    fn: this.program(1, o),
                    inverse: this.noop,
                    data: o
                }), null != n && (m += n), m + "    </ul>\n</div>"
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(139), k(136), k(127), k(48)], h = function (m, l, p, o) {
            var n = m.extend({
                constructor: function (b, a) {
                    this._model = b, m.call(this, a), this.volumeSlider = new l("jw-slider-volume jw-volume-tip", "vertical"), this.addContent(this.volumeSlider.element()), this.volumeSlider.on("update", function (c) {
                        this.trigger("update", c)
                    }, this), o.removeClass(this.el, "jw-hidden"), new p(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }).on("click", this.toggleValue, this).on("tap", this.toggleOpenState, this).on("over", this.openTooltip, this).on("out", this.closeTooltip, this), this._model.on("change:volume", this.onVolume, this)
                }, toggleValue: function () {
                    this.trigger("toggleValue")
                }
            });
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(139), k(48), k(45), k(127)], h = function (m, l, p, o) {
            var n = m.extend({
                constructor: function (a) {
                    m.call(this, a), this.container.className = "jw-overlay-horizontal jw-reset", this.openClass = "jw-open-drawer", this.componentType = "drawer"
                }, setup: function (b, c) {
                    this.iconUI || (this.iconUI = new o(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this)), this.reset(), b = p.isArray(b) ? b : [], this.activeContents = p.filter(b, function (d) {
                        return d.isActive
                    }), l.toggleClass(this.el, "jw-hidden", !c || this.activeContents.length < 2), c && this.activeContents.length > 1 && (l.removeClass(this.el, "jw-off"), this.iconUI.on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener), p.each(b, function (d) {
                        this.container.appendChild(d.el)
                    }, this))
                }, reset: function () {
                    l.addClass(this.el, "jw-off"), this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48)], h = function (m, l) {
            function p(d, c) {
                c.off("change:mediaType", null, this), c.on("change:mediaType", function (a, q) {
                    "audio" === q && this.setImage(d.get("playlistItem").image)
                }, this)
            }

            function o(b, r) {
                var q = b.get("autostart") && !l.isMobile() || b.get("item") > 0;
                return q ? (this.setImage(null), b.off("change:state", null, this), void b.on("change:state", function (d, c) {
                    "complete" !== c && "idle" !== c && "error" !== c || this.setImage(r.image)
                }, this)) : void this.setImage(r.image)
            }

            var n = function (b) {
                this.model = b, b.on("change:playlistItem", o, this), b.on("change:mediaModel", p, this)
            };
            return m.extend(n.prototype, {
                setup: function (d) {
                    this.el = d;
                    var c = this.model.get("playlistItem");
                    c && this.setImage(c.image)
                }, setImage: function (b) {
                    this.model.off("change:state", null, this);
                    var a = "";
                    m.isString(b) && (a = 'url("' + b + '")'), l.style(this.el, {backgroundImage: a})
                }, element: function () {
                    return this.el
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(150), k(45), k(59)], h = function (m, l, p) {
            var o = {free: "f", premium: "r", enterprise: "e", ads: "a", unlimited: "u", trial: "t"}, n = function () {
            };
            return l.extend(n.prototype, m.prototype, {
                buildArray: function () {
                    var a = m.prototype.buildArray.apply(this, arguments), q = this.model.get("edition"),
                        d = "https://jwplayer.com/learn-more/?m=h&e=" + (o[q] || q) + "&v=" + p;
                    if (a.items[0].link = d, this.model.get("abouttext")) {
                        a.items[0].showLogo = !1, a.items.push(a.items.shift());
                        var c = {title: this.model.get("abouttext"), link: this.model.get("aboutlink") || d};
                        a.items.unshift(c)
                    }
                    return a
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(151), k(45), k(127), k(59)], h = function (m, l, q, p, o) {
            var n = function () {
            };
            return q.extend(n.prototype, {
                buildArray: function () {
                    var a = o.split("+"), x = a[0], w = {
                        items: [{
                            title: "Powered by JW Player " + x,
                            featured: !0,
                            showLogo: !0,
                            link: "https://jwplayer.com/learn-more/?m=h&e=o&v=" + o
                        }]
                    }, v = x.indexOf("-") > 0, u = a[1];
                    if (v && u) {
                        var t = u.split(".");
                        w.items.push({title: "build: (" + t[0] + "." + t[1] + ")", link: "#"})
                    }
                    var s = this.model.get("provider").name;
                    if (s.indexOf("flash") >= 0) {
                        var r = "Flash Version " + m.flashVersion();
                        w.items.push({title: r, link: "http://www.adobe.com/software/flash/about/"})
                    }
                    return w
                }, buildMenu: function () {
                    var a = this.buildArray();
                    return m.createElement(l(a))
                }, updateHtml: function () {
                    this.el.innerHTML = this.buildMenu().innerHTML
                }, rightClick: function (b) {
                    return this.lazySetup(), this.mouseOverContext ? !1 : (this.hideMenu(), this.showMenu(b), !1)
                }, getOffset: function (s) {
                    for (var r = s.target, u = s.offsetX || s.layerX, t = s.offsetY || s.layerY; r !== this.playerElement;) {
                        u += r.offsetLeft, t += r.offsetTop, r = r.parentNode
                    }
                    return {x: u, y: t}
                }, showMenu: function (a) {
                    var d = this.getOffset(a);
                    return this.el.style.left = d.x + "px", this.el.style.top = d.y + "px", m.addClass(this.playerElement, "jw-flag-rightclick-open"), m.addClass(this.el, "jw-open"), !1
                }, hideMenu: function () {
                    this.mouseOverContext || (m.removeClass(this.playerElement, "jw-flag-rightclick-open"), m.removeClass(this.el, "jw-open"))
                }, lazySetup: function () {
                    this.el || (this.el = this.buildMenu(), this.layer.appendChild(this.el), this.hideMenuHandler = this.hideMenu.bind(this), this.addOffListener(this.playerElement), this.addOffListener(document), this.model.on("change:provider", this.updateHtml, this), this.elementUI = new p(this.el, {useHover: !0}).on("over", function () {
                        this.mouseOverContext = !0
                    }, this).on("out", function () {
                        this.mouseOverContext = !1
                    }, this))
                }, setup: function (r, d, s) {
                    this.playerElement = d, this.model = r, this.mouseOverContext = !1, this.layer = s, d.oncontextmenu = this.rightClick.bind(this)
                }, addOffListener: function (b) {
                    b.addEventListener("mousedown", this.hideMenuHandler), b.addEventListener("touchstart", this.hideMenuHandler), b.addEventListener("pointerdown", this.hideMenuHandler)
                }, removeOffListener: function (b) {
                    b.removeEventListener("mousedown", this.hideMenuHandler), b.removeEventListener("touchstart", this.hideMenuHandler), b.removeEventListener("pointerdown", this.hideMenuHandler)
                }, destroy: function () {
                    this.el && (this.hideMenu(), this.elementUI.off(), this.removeOffListener(this.playerElement), this.removeOffListener(document), this.hideMenuHandler = null, this.el = null), this.playerElement && (this.playerElement.oncontextmenu = null, this.playerElement = null), this.model && (this.model.off("change:provider", this.updateHtml), this.model = null)
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            1: function (t, s, r, q) {
                var p, o, n = "function", m = s.helperMissing, l = this.escapeExpression,
                    k = '        <li class="jw-reset';
                return p = s["if"].call(t, null != t ? t.featured : t, {
                    name: "if",
                    hash: {},
                    fn: this.program(2, q),
                    inverse: this.noop,
                    data: q
                }), null != p && (k += p), k += '">\n            <a href="' + l((o = null != (o = s.link || (null != t ? t.link : t)) ? o : m, typeof o === n ? o.call(t, {
                    name: "link",
                    hash: {},
                    data: q
                }) : o)) + '" class="jw-reset" target="_top">\n', p = s["if"].call(t, null != t ? t.showLogo : t, {
                    name: "if",
                    hash: {},
                    fn: this.program(4, q),
                    inverse: this.noop,
                    data: q
                }), null != p && (k += p), k + "                " + l((o = null != (o = s.title || (null != t ? t.title : t)) ? o : m, typeof o === n ? o.call(t, {
                    name: "title",
                    hash: {},
                    data: q
                }) : o)) + "\n            </a>\n        </li>\n"
            }, 2: function (l, k, n, m) {
                return " jw-featured"
            }, 4: function (l, k, n, m) {
                return '                <span class="jw-icon jw-rightclick-logo jw-reset"></span>\n'
            }, compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, p, o) {
                var n, m = '<div class="jw-rightclick jw-reset">\n    <ul class="jw-reset">\n';
                return n = k.each.call(l, null != l ? l.items : l, {
                    name: "each",
                    hash: {},
                    fn: this.program(1, o),
                    inverse: this.noop,
                    data: o
                }), null != n && (m += n), m + "    </ul>\n</div>"
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(48)], h = function (l, d) {
            var m = function (b) {
                this.model = b, this.model.on("change:playlistItem", this.playlistItem, this)
            };
            return l.extend(m.prototype, {
                hide: function () {
                    this.el.style.display = "none"
                }, show: function () {
                    this.el.style.display = ""
                }, setup: function (n) {
                    this.el = n;
                    var c = this.el.getElementsByTagName("div");
                    this.title = c[0], this.description = c[1], this.model.get("playlistItem") && this.playlistItem(this.model, this.model.get("playlistItem")), this.model.on("change:logoWidth", this.update, this), this.model.on("change:dock", this.update, this)
                }, update: function (b) {
                    var t = {paddingLeft: 0, paddingRight: 0}, s = b.get("controls"), r = b.get("dock"),
                        q = b.get("logo");
                    if (q) {
                        var p = 1 * ("" + q.margin).replace("px", ""), o = b.get("logoWidth") + (isNaN(p) ? 0 : p);
                        "top-left" === q.position ? t.paddingLeft = o : "top-right" === q.position && (t.paddingRight = o)
                    }
                    if (s && r && r.length) {
                        var n = 56 * r.length;
                        t.paddingRight = Math.max(t.paddingRight, n)
                    }
                    d.style(this.el, t)
                }, playlistItem: function (o, n) {
                    if (o.get("displaytitle") || o.get("displaydescription")) {
                        var q = "", p = "";
                        n.title && o.get("displaytitle") && (q = n.title), n.description && o.get("displaydescription") && (p = n.description), this.updateText(q, p)
                    } else {
                        this.hide()
                    }
                }, updateText: function (n, c) {
                    this.title.innerHTML = n, this.description.innerHTML = c, this.title.firstChild || this.description.firstChild ? this.show() : this.hide()
                }, element: function () {
                    return this.el
                }
            }), m
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return '<div id="' + m((p = null != (p = k.id || (null != l ? l.id : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "id",
                    hash: {},
                    data: q
                }) : p)) + '" class="jwplayer jw-reset" tabindex="0">\n    <div class="jw-aspect jw-reset"></div>\n    <div class="jw-media jw-reset"></div>\n    <div class="jw-preview jw-reset"></div>\n    <div class="jw-title jw-reset">\n        <div class="jw-title-primary jw-reset"></div>\n        <div class="jw-title-secondary jw-reset"></div>\n    </div>\n    <div class="jw-overlays jw-reset"></div>\n    <div class="jw-controls jw-reset"></div>\n</div>'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(48), k(46), k(127), k(47), k(45), k(155)], h = function (m, l, r, q, p, o) {
            var n = function (b) {
                this.model = b, this.setup()
            };
            return p.extend(n.prototype, q, {
                setup: function () {
                    this.destroy(), this.skipMessage = this.model.get("skipText"), this.skipMessageCountdown = this.model.get("skipMessage"), this.setWaitTime(this.model.get("skipOffset"));
                    var a = o();
                    this.el = m.createElement(a), this.skiptext = this.el.getElementsByClassName("jw-skiptext")[0], this.skipAdOnce = p.once(this.skipAd.bind(this)), new r(this.el).on("click tap", p.bind(function () {
                        this.skippable && this.skipAdOnce()
                    }, this)), this.model.on("change:duration", this.onChangeDuration, this), this.model.on("change:position", this.onChangePosition, this), this.onChangeDuration(this.model, this.model.get("duration")), this.onChangePosition(this.model, this.model.get("position"))
                }, updateMessage: function (b) {
                    this.skiptext.innerHTML = b
                }, updateCountdown: function (b) {
                    this.updateMessage(this.skipMessageCountdown.replace(/xx/gi, Math.ceil(this.waitTime - b)))
                }, onChangeDuration: function (a, d) {
                    if (d) {
                        if (this.waitPercentage) {
                            if (!d) {
                                return
                            }
                            this.itemDuration = d, this.setWaitTime(this.waitPercentage), delete this.waitPercentage
                        }
                        m.removeClass(this.el, "jw-hidden")
                    }
                }, onChangePosition: function (a, d) {
                    this.waitTime - d > 0 ? this.updateCountdown(d) : (this.updateMessage(this.skipMessage), this.skippable = !0, m.addClass(this.el, "jw-skippable"))
                }, element: function () {
                    return this.el
                }, setWaitTime: function (a) {
                    if (p.isString(a) && "%" === a.slice(-1)) {
                        var d = parseFloat(a);
                        return void (this.itemDuration && !isNaN(d) ? this.waitTime = this.itemDuration * d / 100 : this.waitPercentage = a)
                    }
                    p.isNumber(a) ? this.waitTime = a : "string" === m.typeOf(a) ? this.waitTime = m.seconds(a) : isNaN(Number(a)) ? this.waitTime = 0 : this.waitTime = Number(a)
                }, skipAd: function () {
                    this.trigger(l.JWPLAYER_AD_SKIPPED)
                }, destroy: function () {
                    this.el && (this.el.removeEventListener("click", this.skipAdOnce), this.el.parentElement && this.el.parentElement.removeChild(this.el)), delete this.skippable, delete this.itemDuration, delete this.waitPercentage
                }
            }), n
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, n, m) {
                return '<div class="jw-skip jw-background-color jw-hidden jw-reset">\n    <span class="jw-text jw-skiptext jw-reset"></span>\n    <span class="jw-icon-inline jw-skip-icon jw-reset"></span>\n</div>'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [k(157)], h = function (d) {
            function c(a, n, m, l) {
                return d({id: a, skin: n, title: m, body: l})
            }

            return c
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(120);
        g.exports = (h["default"] || h).template({
            compiler: [6, ">= 2.0.0-beta.1"], main: function (l, k, r, q) {
                var p, o = "function", n = k.helperMissing, m = this.escapeExpression;
                return '<div id="' + m((p = null != (p = k.id || (null != l ? l.id : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "id",
                    hash: {},
                    data: q
                }) : p)) + '"class="jw-skin-' + m((p = null != (p = k.skin || (null != l ? l.skin : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "skin",
                    hash: {},
                    data: q
                }) : p)) + ' jw-error jw-reset">\n    <div class="jw-title jw-reset">\n        <div class="jw-title-primary jw-reset">' + m((p = null != (p = k.title || (null != l ? l.title : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "title",
                    hash: {},
                    data: q
                }) : p)) + '</div>\n        <div class="jw-title-secondary jw-reset">' + m((p = null != (p = k.body || (null != l ? l.body : l)) ? p : n, typeof p === o ? p.call(l, {
                    name: "body",
                    hash: {},
                    data: q
                }) : p)) + '</div>\n    </div>\n\n    <div class="jw-icon-container jw-reset">\n        <div class="jw-display-icon-container jw-background-color jw-reset">\n            <div class="jw-icon jw-icon-display jw-reset"></div>\n        </div>\n    </div>\n</div>\n'
            }, useData: !0
        })
    }, function (g, f, k) {
        var j, h;
        j = [], h = function () {
            function l() {
                var b = document.createElement("div");
                return b.className = m, b.innerHTML = "&nbsp;", b.style.width = "1px", b.style.height = "1px", b.style.position = "absolute", b.style.background = "transparent", b
            }

            function d() {
                function a() {
                    var q = this, p = q._view.element();
                    p.appendChild(c), o() && q.trigger("adBlock")
                }

                function o() {
                    return n ? !0 : ("" !== c.innerHTML && c.className === m && null !== c.offsetParent && 0 !== c.clientHeight || (n = !0), n)
                }

                var n = !1, c = l();
                return {onReady: a, checkAdBlock: o}
            }

            var m = "afs_ads";
            return {setup: d}
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, , , , function (g, f, k) {
        var j, h;
        j = [], h = function () {
            var d = window.chrome, c = {};
            return c.NS = "urn:x-cast:com.longtailvideo.jwplayer", c.debug = !1, c.availability = null, c.available = function (b) {
                b = b || c.availability;
                var a = "available";
                return d && d.cast && d.cast.ReceiverAvailability && (a = d.cast.ReceiverAvailability.AVAILABLE), b === a
            }, c.log = function () {
                if (c.debug) {
                    var b = Array.prototype.slice.call(arguments, 0);
                    console.log.apply(console, b)
                }
            }, c.error = function () {
                var b = Array.prototype.slice.call(arguments, 0);
                console.error.apply(console, b)
            }, c
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, , , function (g, f, k) {
        var j, h;
        j = [k(98), k(45)], h = function (d, c) {
            return function (l, b) {
                var a = ["seek", "skipAd", "stop", "playlistNext", "playlistPrev", "playlistItem", "resize", "addButton", "removeButton", "registerPlugin", "attachMedia"];
                c.each(a, function (m) {
                    l[m] = function () {
                        return b[m].apply(b, arguments), l
                    }
                }), l.registerPlugin = d.registerPlugin
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45)], h = function (b) {
            return function (a, o) {
                var n = ["buffer", "controls", "position", "duration", "fullscreen", "volume", "mute", "item", "stretching", "playlist"];
                b.each(n, function (c) {
                    var p = c.slice(0, 1).toUpperCase() + c.slice(1);
                    a["get" + p] = function () {
                        return o._model.get(c)
                    }
                });
                var m = ["getAudioTracks", "getCaptionsList", "getWidth", "getHeight", "getCurrentAudioTrack", "setCurrentAudioTrack", "getCurrentCaptions", "setCurrentCaptions", "getCurrentQuality", "setCurrentQuality", "getQualityLevels", "getVisualQuality", "getConfig", "getState", "getSafeRegion", "isBeforeComplete", "isBeforePlay", "getProvider", "detachMedia"],
                    l = ["setControls", "setFullscreen", "setVolume", "setMute", "setCues"];
                b.each(m, function (c) {
                    a[c] = function () {
                        return o[c] ? o[c].apply(o, arguments) : null
                    }
                }), b.each(l, function (c) {
                    a[c] = function () {
                        return o[c].apply(o, arguments), a
                    }
                })
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, k) {
        var j, h;
        j = [k(45), k(46)], h = function (d, c) {
            return function (l) {
                var b = {
                    onBufferChange: c.JWPLAYER_MEDIA_BUFFER,
                    onBufferFull: c.JWPLAYER_MEDIA_BUFFER_FULL,
                    onError: c.JWPLAYER_ERROR,
                    onSetupError: c.JWPLAYER_SETUP_ERROR,
                    onFullscreen: c.JWPLAYER_FULLSCREEN,
                    onMeta: c.JWPLAYER_MEDIA_META,
                    onMute: c.JWPLAYER_MEDIA_MUTE,
                    onPlaylist: c.JWPLAYER_PLAYLIST_LOADED,
                    onPlaylistItem: c.JWPLAYER_PLAYLIST_ITEM,
                    onPlaylistComplete: c.JWPLAYER_PLAYLIST_COMPLETE,
                    onReady: c.JWPLAYER_READY,
                    onResize: c.JWPLAYER_RESIZE,
                    onComplete: c.JWPLAYER_MEDIA_COMPLETE,
                    onSeek: c.JWPLAYER_MEDIA_SEEK,
                    onTime: c.JWPLAYER_MEDIA_TIME,
                    onVolume: c.JWPLAYER_MEDIA_VOLUME,
                    onBeforePlay: c.JWPLAYER_MEDIA_BEFOREPLAY,
                    onBeforeComplete: c.JWPLAYER_MEDIA_BEFORECOMPLETE,
                    onDisplayClick: c.JWPLAYER_DISPLAY_CLICK,
                    onControls: c.JWPLAYER_CONTROLS,
                    onQualityLevels: c.JWPLAYER_MEDIA_LEVELS,
                    onQualityChange: c.JWPLAYER_MEDIA_LEVEL_CHANGED,
                    onCaptionsList: c.JWPLAYER_CAPTIONS_LIST,
                    onCaptionsChange: c.JWPLAYER_CAPTIONS_CHANGED,
                    onAdError: c.JWPLAYER_AD_ERROR,
                    onAdClick: c.JWPLAYER_AD_CLICK,
                    onAdImpression: c.JWPLAYER_AD_IMPRESSION,
                    onAdTime: c.JWPLAYER_AD_TIME,
                    onAdComplete: c.JWPLAYER_AD_COMPLETE,
                    onAdCompanions: c.JWPLAYER_AD_COMPANIONS,
                    onAdSkipped: c.JWPLAYER_AD_SKIPPED,
                    onAdPlay: c.JWPLAYER_AD_PLAY,
                    onAdPause: c.JWPLAYER_AD_PAUSE,
                    onAdMeta: c.JWPLAYER_AD_META,
                    onCast: c.JWPLAYER_CAST_SESSION,
                    onAudioTrackChange: c.JWPLAYER_AUDIO_TRACK_CHANGED,
                    onAudioTracks: c.JWPLAYER_AUDIO_TRACKS
                }, a = {onBuffer: "buffer", onPause: "pause", onPlay: "play", onIdle: "idle"};
                d.each(a, function (m, n) {
                    l[n] = d.partial(l.on, m, d)
                }), d.each(b, function (m, n) {
                    l[n] = d.partial(l.on, m, d)
                })
            }
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }, function (g, f, j) {
        var h = j(169);
        "string" == typeof h && (h = [[g.id, h, ""]]);
        j(173)(h, {});
        h.locals && (g.exports = h.locals)
    }, function (f, d, g) {
        d = f.exports = g(170)(), d.push([f.id, ".jw-reset{color:inherit;background-color:transparent;padding:0;margin:0;float:none;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:1em;list-style:none;text-align:left;text-transform:none;vertical-align:baseline;border:0;direction:ltr;font-variant:inherit;font-stretch:inherit;-webkit-tap-highlight-color:rgba(255,255,255,0)}@font-face{font-family:'jw-icons';src:url(" + g(171) + ") format('woff'),url(" + g(172) + ') format(\'truetype\');font-weight:normal;font-style:normal}.jw-icon-inline,.jw-icon-tooltip,.jw-icon-display,.jw-controlbar .jw-menu .jw-option:before{font-family:\'jw-icons\';-webkit-font-smoothing:antialiased;font-style:normal;font-weight:normal;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}.jw-icon-audio-tracks:before{content:"\\E600"}.jw-icon-buffer:before{content:"\\E601"}.jw-icon-cast:before{content:"\\E603"}.jw-icon-cast.jw-off:before{content:"\\E602"}.jw-icon-cc:before{content:"\\E605"}.jw-icon-cue:before{content:"\\E606"}.jw-icon-menu-bullet:before{content:"\\E606"}.jw-icon-error:before{content:"\\E607"}.jw-icon-fullscreen:before{content:"\\E608"}.jw-icon-fullscreen.jw-off:before{content:"\\E613"}.jw-icon-hd:before{content:"\\E60A"}.jw-watermark:before,.jw-rightclick-logo:before{content:"\\E60B"}.jw-icon-next:before{content:"\\E60C"}.jw-icon-pause:before{content:"\\E60D"}.jw-icon-play:before{content:"\\E60E"}.jw-icon-prev:before{content:"\\E60F"}.jw-icon-replay:before{content:"\\E610"}.jw-icon-volume:before{content:"\\E612"}.jw-icon-volume.jw-off:before{content:"\\E611"}.jw-icon-more:before{content:"\\E614"}.jw-icon-close:before{content:"\\E615"}.jw-icon-playlist:before{content:"\\E616"}.jwplayer{width:100%;font-size:16px;position:relative;display:block;min-height:0;overflow:hidden;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif;background-color:#000;-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jwplayer *{box-sizing:inherit}.jwplayer.jw-flag-aspect-mode{height:auto !important}.jwplayer.jw-flag-aspect-mode .jw-aspect{display:block}.jwplayer .jw-aspect{display:none}.jwplayer.jw-no-focus:focus,.jwplayer .jw-swf{outline:none}.jwplayer.jw-ie:focus{outline:#585858 dotted 1px}.jwplayer:hover .jw-display-icon-container{background-color:#333;background:#333;background-size:#333}.jw-media,.jw-preview,.jw-overlays,.jw-controls{position:absolute;width:100%;height:100%;top:0;left:0;bottom:0;right:0}.jw-media{overflow:hidden;cursor:pointer}.jw-overlays{cursor:auto}.jw-media.jw-media-show{visibility:visible;opacity:1}.jw-controls.jw-controls-disabled{display:none}.jw-controls .jw-controls-right{position:absolute;top:0;right:0;left:0;bottom:2em}.jw-text{height:1em;font-family:Arial,Helvetica,sans-serif;font-size:.75em;font-style:normal;font-weight:normal;color:white;text-align:center;font-variant:normal;font-stretch:normal}.jw-plugin{position:absolute;bottom:2.5em}.jw-plugin .jw-banner{max-width:100%;opacity:0;cursor:pointer;position:absolute;margin:auto auto 0 auto;left:0;right:0;bottom:0;display:block}.jw-cast-screen{width:100%;height:100%}.jw-instream{position:absolute;top:0;right:0;bottom:0;left:0;display:none}.jw-icon-playback:before{content:"\\E60E"}.jw-preview,.jw-captions,.jw-title,.jw-overlays,.jw-controls{pointer-events:none}.jw-overlays>div,.jw-media,.jw-controlbar,.jw-dock,.jw-logo,.jw-skip,.jw-display-icon-container{pointer-events:all}.jwplayer video{position:absolute;top:0;right:0;bottom:0;left:0;width:100%;height:100%;margin:auto;background:transparent}.jwplayer video::-webkit-media-controls-start-playback-button{display:none}.jwplayer video::-webkit-media-text-track-display{-webkit-transform:translateY(-1.5em);transform:translateY(-1.5em)}.jwplayer.jw-flag-user-inactive.jw-state-playing video::-webkit-media-text-track-display{-webkit-transform:translateY(0);transform:translateY(0)}.jwplayer.jw-stretch-uniform video{-o-object-fit:contain;object-fit:contain}.jwplayer.jw-stretch-none video{-o-object-fit:none;object-fit:none}.jwplayer.jw-stretch-fill video{-o-object-fit:cover;object-fit:cover}.jwplayer.jw-stretch-exactfit video{-o-object-fit:fill;object-fit:fill}.jw-click{position:absolute;width:100%;height:100%}.jw-preview{position:absolute;display:none;opacity:1;visibility:visible;width:100%;height:100%;background:#000 no-repeat 50% 50%}.jwplayer .jw-preview,.jw-error .jw-preview,.jw-stretch-uniform .jw-preview{background-size:contain}.jw-stretch-none .jw-preview{background-size:auto auto}.jw-stretch-fill .jw-preview{background-size:cover}.jw-stretch-exactfit .jw-preview{background-size:100% 100%}.jw-display-icon-container{position:relative;top:50%;display:table;height:3.5em;width:3.5em;margin:-1.75em auto 0;cursor:pointer}.jw-display-icon-container .jw-icon-display{position:relative;display:table-cell;text-align:center;vertical-align:middle !important;background-position:50% 50%;background-repeat:no-repeat;font-size:2em}.jw-flag-audio-player .jw-display-icon-container,.jw-flag-dragging .jw-display-icon-container{display:none}.jw-icon{font-family:\'jw-icons\';-webkit-font-smoothing:antialiased;font-style:normal;font-weight:normal;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}.jw-controlbar{display:table;position:absolute;right:0;left:0;bottom:0;height:2em;padding:0 .25em}.jw-controlbar .jw-hidden{display:none}.jw-controlbar.jw-drawer-expanded .jw-controlbar-left-group,.jw-controlbar.jw-drawer-expanded .jw-controlbar-center-group{opacity:0}.jw-background-color{background-color:#414040}.jw-group{display:table-cell}.jw-controlbar-center-group{width:100%;padding:0 .25em}.jw-controlbar-center-group .jw-slider-time,.jw-controlbar-center-group .jw-text-alt{padding:0}.jw-controlbar-center-group .jw-text-alt{display:none}.jw-controlbar-left-group,.jw-controlbar-right-group{white-space:nowrap}.jw-knob:hover,.jw-icon-inline:hover,.jw-icon-tooltip:hover,.jw-icon-display:hover,.jw-option:before:hover{color:#eee}.jw-icon-inline,.jw-icon-tooltip,.jw-slider-horizontal,.jw-text-elapsed,.jw-text-duration{display:inline-block;height:2em;position:relative;line-height:2em;vertical-align:middle;cursor:pointer}.jw-icon-inline,.jw-icon-tooltip{min-width:1.25em;text-align:center}.jw-icon-playback{min-width:2.25em}.jw-icon-volume{min-width:1.75em;text-align:left}.jw-time-tip{line-height:1em;pointer-events:none}.jw-icon-inline:after,.jw-icon-tooltip:after{width:100%;height:100%;font-size:1em}.jw-icon-cast{display:none}.jw-slider-volume.jw-slider-horizontal,.jw-icon-inline.jw-icon-volume{display:none}.jw-dock{margin:.75em;display:block;opacity:1;clear:right}.jw-dock:after{content:\'\';clear:both;display:block}.jw-dock-button{cursor:pointer;float:right;position:relative;width:2.5em;height:2.5em;margin:.5em}.jw-dock-button .jw-arrow{display:none;position:absolute;bottom:-0.2em;width:.5em;height:.2em;left:50%;margin-left:-0.25em}.jw-dock-button .jw-overlay{display:none;position:absolute;top:2.5em;right:0;margin-top:.25em;padding:.5em;white-space:nowrap}.jw-dock-button:hover .jw-overlay,.jw-dock-button:hover .jw-arrow{display:block}.jw-dock-image{width:100%;height:100%;background-position:50% 50%;background-repeat:no-repeat;opacity:.75}.jw-title{display:none;position:absolute;top:0;width:100%;font-size:.875em;height:8em;background:-webkit-linear-gradient(top, #000 0, #000 18%, rgba(0,0,0,0) 100%);background:linear-gradient(to bottom, #000 0, #000 18%, rgba(0,0,0,0) 100%)}.jw-title-primary,.jw-title-secondary{padding:.75em 1.5em;min-height:2.5em;width:100%;color:white;white-space:nowrap;text-overflow:ellipsis;overflow-x:hidden}.jw-title-primary{font-weight:bold}.jw-title-secondary{margin-top:-0.5em}.jw-slider-container{display:inline-block;height:1em;position:relative;touch-action:none}.jw-rail,.jw-buffer,.jw-progress{position:absolute;cursor:pointer}.jw-progress{background-color:#fff}.jw-rail{background-color:#aaa}.jw-buffer{background-color:#202020}.jw-cue,.jw-knob{position:absolute;cursor:pointer}.jw-cue{background-color:#fff;width:.1em;height:.4em}.jw-knob{background-color:#aaa;width:.4em;height:.4em}.jw-slider-horizontal{width:4em;height:1em}.jw-slider-horizontal.jw-slider-volume{margin-right:5px}.jw-slider-horizontal .jw-rail,.jw-slider-horizontal .jw-buffer,.jw-slider-horizontal .jw-progress{width:100%;height:.4em}.jw-slider-horizontal .jw-progress,.jw-slider-horizontal .jw-buffer{width:0}.jw-slider-horizontal .jw-rail,.jw-slider-horizontal .jw-progress,.jw-slider-horizontal .jw-slider-container{width:100%}.jw-slider-horizontal .jw-knob{left:0;margin-left:-0.325em}.jw-slider-vertical{width:.75em;height:4em;bottom:0;position:absolute;padding:1em}.jw-slider-vertical .jw-rail,.jw-slider-vertical .jw-buffer,.jw-slider-vertical .jw-progress{bottom:0;height:100%}.jw-slider-vertical .jw-progress,.jw-slider-vertical .jw-buffer{height:0}.jw-slider-vertical .jw-slider-container,.jw-slider-vertical .jw-rail,.jw-slider-vertical .jw-progress{bottom:0;width:.75em;height:100%;left:0;right:0;margin:0 auto}.jw-slider-vertical .jw-slider-container{height:4em;position:relative}.jw-slider-vertical .jw-knob{bottom:0;left:0;right:0;margin:0 auto}.jw-slider-time{right:0;left:0;width:100%}.jw-tooltip-time{position:absolute}.jw-slider-volume .jw-buffer{display:none}.jw-captions{position:absolute;display:none;margin:0 auto;width:100%;left:0;bottom:3em;right:0;max-width:90%;text-align:center}.jw-captions.jw-captions-enabled{display:block}.jw-captions-window{display:none;padding:.25em;border-radius:.25em}.jw-captions-window.jw-captions-window-active{display:inline-block}.jw-captions-text{display:inline-block;color:white;background-color:black;word-wrap:break-word;white-space:pre-line;font-style:normal;font-weight:normal;text-align:center;text-decoration:none;line-height:1.3em;padding:.1em .8em}.jw-rightclick{display:none;position:absolute;white-space:nowrap}.jw-rightclick.jw-open{display:block}.jw-rightclick ul{list-style:none;font-weight:bold;border-radius:.15em;margin:0;border:1px solid #444;padding:0}.jw-rightclick .jw-rightclick-logo{font-size:2em;color:#ff0147;vertical-align:middle;padding-right:.3em;margin-right:.3em;border-right:1px solid #444}.jw-rightclick li{background-color:#000;border-bottom:1px solid #444;margin:0}.jw-rightclick a{color:#fff;text-decoration:none;padding:1em;display:block;font-size:.6875em}.jw-rightclick li:last-child{border-bottom:none}.jw-rightclick li:hover{background-color:#1a1a1a;cursor:pointer}.jw-rightclick .jw-featured{background-color:#252525;vertical-align:middle}.jw-rightclick .jw-featured a{color:#777}.jw-logo{position:absolute;margin:.75em;cursor:pointer;pointer-events:all;background-repeat:no-repeat;background-size:contain;top:auto;right:auto;left:auto;bottom:auto}.jw-logo .jw-flag-audio-player{display:none}.jw-logo-top-right{top:0;right:0}.jw-logo-top-left{top:0;left:0}.jw-logo-bottom-left{bottom:0;left:0}.jw-logo-bottom-right{bottom:0;right:0}.jw-watermark{position:absolute;top:50%;left:0;right:0;bottom:0;text-align:center;font-size:14em;color:#eee;opacity:.33;pointer-events:none}.jw-icon-tooltip.jw-open .jw-overlay{opacity:1;visibility:visible}.jw-icon-tooltip.jw-hidden{display:none}.jw-overlay-horizontal{display:none}.jw-icon-tooltip.jw-open-drawer:before{display:none}.jw-icon-tooltip.jw-open-drawer .jw-overlay-horizontal{opacity:1;display:inline-block;vertical-align:top}.jw-overlay:before{position:absolute;top:0;bottom:0;left:-50%;width:100%;background-color:rgba(0,0,0,0);content:" "}.jw-slider-time .jw-overlay:before{height:1em;top:auto}.jw-time-tip,.jw-volume-tip,.jw-menu{position:relative;left:-50%;border:solid 1px #000;margin:0}.jw-volume-tip{width:100%;height:100%;display:block}.jw-time-tip{text-align:center;font-family:inherit;color:#aaa;bottom:1em;border:solid 4px #000}.jw-time-tip .jw-text{line-height:1em}.jw-controlbar .jw-overlay{margin:0;position:absolute;bottom:2em;left:50%;opacity:0;visibility:hidden}.jw-controlbar .jw-overlay .jw-contents{position:relative}.jw-controlbar .jw-option{position:relative;white-space:nowrap;cursor:pointer;list-style:none;height:1.5em;font-family:inherit;line-height:1.5em;color:#aaa;padding:0 .5em;font-size:.8em}.jw-controlbar .jw-option:hover,.jw-controlbar .jw-option:before:hover{color:#eee}.jw-controlbar .jw-option:before{padding-right:.125em}.jw-playlist-container ::-webkit-scrollbar-track{background-color:#333;border-radius:10px}.jw-playlist-container ::-webkit-scrollbar{width:5px;border:10px solid black;border-bottom:0;border-top:0}.jw-playlist-container ::-webkit-scrollbar-thumb{background-color:white;border-radius:5px}.jw-tooltip-title{border-bottom:1px solid #444;text-align:left;padding-left:.7em}.jw-playlist{max-height:11em;min-height:4.5em;overflow-x:hidden;overflow-y:scroll;width:calc(100% - 4px)}.jw-playlist .jw-option{height:3em;margin-right:5px;color:white;padding-left:1em;font-size:.8em}.jw-playlist .jw-label,.jw-playlist .jw-name{display:inline-block;line-height:3em;text-align:left;overflow:hidden;white-space:nowrap}.jw-playlist .jw-label{width:1em}.jw-playlist .jw-name{width:11em}.jw-skip{cursor:default;position:absolute;float:right;display:inline-block;right:.75em;bottom:3em}.jw-skip.jw-skippable{cursor:pointer}.jw-skip.jw-hidden{visibility:hidden}.jw-skip .jw-skip-icon{display:none;margin-left:-0.75em}.jw-skip .jw-skip-icon:before{content:"\\E60C"}.jw-skip .jw-text,.jw-skip .jw-skip-icon{color:#aaa;vertical-align:middle;line-height:1.5em;font-size:.7em}.jw-skip.jw-skippable:hover{cursor:pointer}.jw-skip.jw-skippable:hover .jw-text,.jw-skip.jw-skippable:hover .jw-skip-icon{color:#eee}.jw-skip.jw-skippable .jw-skip-icon{display:inline;margin:0}.jwplayer.jw-state-playing.jw-flag-casting .jw-display-icon-container,.jwplayer.jw-state-paused.jw-flag-casting .jw-display-icon-container{display:table}.jwplayer.jw-flag-casting .jw-display-icon-container{border-radius:0;border:1px solid white;position:absolute;top:auto;left:.5em;right:.5em;bottom:50%;margin-bottom:-12.5%;height:50%;width:50%;padding:0;background-repeat:no-repeat;background-position:center}.jwplayer.jw-flag-casting .jw-display-icon-container .jw-icon{font-size:3em}.jwplayer.jw-flag-casting.jw-state-complete .jw-preview{display:none}.jw-cast{position:absolute;width:100%;height:100%;background-repeat:no-repeat;background-size:auto;background-position:50% 50%}.jw-cast-label{position:absolute;left:.5em;right:.5em;bottom:75%;margin-bottom:1.5em;text-align:center}.jw-cast-name{color:#ccc}.jw-state-idle .jw-preview{display:block}.jw-state-idle .jw-icon-display:before{content:"\\E60E"}.jw-state-idle .jw-controlbar{display:none}.jw-state-idle .jw-captions{display:none}.jw-state-idle .jw-title{display:block}.jwplayer.jw-state-playing .jw-display-icon-container{display:none}.jwplayer.jw-state-playing .jw-display-icon-container .jw-icon-display:before{content:"\\E60D"}.jwplayer.jw-state-playing .jw-icon-playback:before{content:"\\E60D"}.jwplayer.jw-state-paused .jw-display-icon-container{display:none}.jwplayer.jw-state-paused .jw-display-icon-container .jw-icon-display:before{content:"\\E60E"}.jwplayer.jw-state-paused .jw-icon-playback:before{content:"\\E60E"}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-icon-display{-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-icon-display:before{content:"\\E601"}@-webkit-keyframes spin{100%{-webkit-transform:rotate(360deg)}}@keyframes spin{100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-text{display:none}.jwplayer.jw-state-buffering .jw-icon-playback:before{content:"\\E60D"}.jwplayer.jw-state-complete .jw-preview{display:block}.jwplayer.jw-state-complete .jw-display-icon-container .jw-icon-display:before{content:"\\E610"}.jwplayer.jw-state-complete .jw-display-icon-container .jw-text{display:none}.jwplayer.jw-state-complete .jw-icon-playback:before{content:"\\E60E"}.jwplayer.jw-state-complete .jw-captions{display:none}body .jw-error .jw-title,.jwplayer.jw-state-error .jw-title{display:block}body .jw-error .jw-title .jw-title-primary,.jwplayer.jw-state-error .jw-title .jw-title-primary{white-space:normal}body .jw-error .jw-preview,.jwplayer.jw-state-error .jw-preview{display:block}body .jw-error .jw-controlbar,.jwplayer.jw-state-error .jw-controlbar{display:none}body .jw-error .jw-captions,.jwplayer.jw-state-error .jw-captions{display:none}body .jw-error:hover .jw-display-icon-container,.jwplayer.jw-state-error:hover .jw-display-icon-container{cursor:default;color:#fff;background:#000}body .jw-error .jw-icon-display,.jwplayer.jw-state-error .jw-icon-display{cursor:default;font-family:\'jw-icons\';-webkit-font-smoothing:antialiased;font-style:normal;font-weight:normal;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}body .jw-error .jw-icon-display:before,.jwplayer.jw-state-error .jw-icon-display:before{content:"\\E607"}body .jw-error .jw-icon-display:hover,.jwplayer.jw-state-error .jw-icon-display:hover{color:#fff}body .jw-error{font-size:16px;background-color:#000;color:#eee;width:100%;height:100%;display:table;opacity:1;position:relative}body .jw-error .jw-icon-container{position:absolute;width:100%;height:100%;top:0;left:0;bottom:0;right:0}.jwplayer.jw-flag-cast-available .jw-controlbar{display:table}.jwplayer.jw-flag-cast-available .jw-icon-cast{display:inline-block}.jwplayer.jw-flag-skin-loading .jw-captions,.jwplayer.jw-flag-skin-loading .jw-controls,.jwplayer.jw-flag-skin-loading .jw-title{display:none}.jwplayer.jw-flag-fullscreen{width:100% !important;height:100% !important;top:0;right:0;bottom:0;left:0;z-index:1000;margin:0;position:fixed}.jwplayer.jw-flag-fullscreen.jw-flag-user-inactive{cursor:none;-webkit-cursor-visibility:auto-hide}.jwplayer.jw-flag-live .jw-controlbar .jw-text-elapsed,.jwplayer.jw-flag-live .jw-controlbar .jw-text-duration,.jwplayer.jw-flag-live .jw-controlbar .jw-slider-time{display:none}.jwplayer.jw-flag-live .jw-controlbar .jw-text-alt{display:inline}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-controlbar,.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-dock{display:none}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-logo.jw-hide{display:none}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-plugin,.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-captions{bottom:.5em}.jwplayer.jw-flag-user-inactive.jw-state-buffering .jw-controlbar{display:none}.jwplayer.jw-flag-media-audio .jw-controlbar{display:table}.jwplayer.jw-flag-media-audio.jw-flag-user-inactive .jw-controlbar{display:table}.jwplayer.jw-flag-media-audio.jw-flag-user-inactive.jw-state-playing .jw-plugin,.jwplayer.jw-flag-media-audio.jw-flag-user-inactive.jw-state-playing .jw-captions{bottom:3em}.jw-flag-media-audio .jw-preview{display:block}.jwplayer.jw-flag-ads .jw-preview,.jwplayer.jw-flag-ads .jw-dock{display:none}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-inline,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-tooltip,.jwplayer.jw-flag-ads .jw-controlbar .jw-text,.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-horizontal{display:none}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-playback,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-volume,.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-volume,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-fullscreen{display:inline-block}.jwplayer.jw-flag-ads .jw-controlbar .jw-text-alt{display:inline}.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-volume.jw-slider-horizontal,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-inline.jw-icon-volume{display:inline-block}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-tooltip.jw-icon-volume{display:none}.jwplayer.jw-flag-ads .jw-logo,.jwplayer.jw-flag-ads .jw-captions{display:none}.jwplayer.jw-flag-ads-googleima .jw-controlbar{display:table;bottom:0}.jwplayer.jw-flag-ads-googleima.jw-flag-touch .jw-controlbar{font-size:1em}.jwplayer.jw-flag-ads-googleima.jw-flag-touch.jw-state-paused .jw-display-icon-container{display:none}.jwplayer.jw-flag-ads-googleima.jw-skin-seven .jw-controlbar{font-size:.9em}.jwplayer.jw-flag-ads-vpaid .jw-controlbar{display:none}.jwplayer.jw-flag-ads-hide-controls .jw-controls{display:none !important}.jwplayer.jw-flag-ads.jw-flag-touch .jw-controlbar{display:table}.jwplayer.jw-flag-overlay-open .jw-title{display:none}.jwplayer.jw-flag-overlay-open .jw-controls-right .jw-logo{display:none}.jwplayer.jw-flag-overlay-open-sharing .jw-controls,.jwplayer.jw-flag-overlay-open-related .jw-controls,.jwplayer.jw-flag-overlay-open-sharing .jw-title,.jwplayer.jw-flag-overlay-open-related .jw-title{display:none}.jwplayer.jw-flag-rightclick-open{overflow:visible}.jwplayer.jw-flag-rightclick-open .jw-rightclick{z-index:16777215}.jw-flag-controls-disabled .jw-controls{visibility:hidden}.jw-flag-controls-disabled .jw-logo{visibility:visible}.jw-flag-controls-disabled .jw-media{cursor:auto}body .jwplayer.jw-flag-flash-blocked .jw-title{display:block}body .jwplayer.jw-flag-flash-blocked .jw-controls,body .jwplayer.jw-flag-flash-blocked .jw-overlays,body .jwplayer.jw-flag-flash-blocked .jw-preview{display:none}.jw-flag-touch .jw-controlbar,.jw-flag-touch .jw-skip,.jw-flag-touch .jw-plugin{font-size:1.5em}.jw-flag-touch .jw-captions{bottom:4.25em}.jw-flag-touch .jw-icon-tooltip.jw-open-drawer:before{display:inline}.jw-flag-touch .jw-icon-tooltip.jw-open-drawer:before{content:"\\E615"}.jw-flag-touch .jw-display-icon-container{pointer-events:none}.jw-flag-touch.jw-state-paused .jw-display-icon-container{display:table}.jw-flag-touch.jw-state-paused.jw-flag-dragging .jw-display-icon-container{display:none}.jw-flag-compact-player .jw-icon-playlist,.jw-flag-compact-player .jw-text-elapsed,.jw-flag-compact-player .jw-text-duration{display:none}.jwplayer.jw-flag-audio-player{background-color:transparent}.jwplayer.jw-flag-audio-player .jw-media{visibility:hidden}.jwplayer.jw-flag-audio-player .jw-media object{width:1px;height:1px}.jwplayer.jw-flag-audio-player .jw-preview,.jwplayer.jw-flag-audio-player .jw-display-icon-container{display:none}.jwplayer.jw-flag-audio-player .jw-controlbar{display:table;height:auto;left:0;bottom:0;margin:0;width:100%;min-width:100%;opacity:1}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-fullscreen,.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-tooltip{display:none}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-slider-volume.jw-slider-horizontal,.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-inline.jw-icon-volume{display:inline-block}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-tooltip.jw-icon-volume{display:none}.jwplayer.jw-flag-audio-player.jw-flag-user-inactive .jw-controlbar{display:table}.jw-skin-seven .jw-background-color{background:#000}.jw-skin-seven .jw-controlbar{border-top:#333 1px solid;height:2.5em}.jw-skin-seven .jw-group{vertical-align:middle}.jw-skin-seven .jw-playlist{background-color:rgba(0,0,0,0.5)}.jw-skin-seven .jw-playlist-container{left:-43%;background-color:rgba(0,0,0,0.5)}.jw-skin-seven .jw-playlist-container .jw-option{border-bottom:1px solid #444}.jw-skin-seven .jw-playlist-container .jw-option:hover,.jw-skin-seven .jw-playlist-container .jw-option.jw-active-option{background-color:black}.jw-skin-seven .jw-playlist-container .jw-option:hover .jw-label{color:#FF0046}.jw-skin-seven .jw-playlist-container .jw-icon-playlist{margin-left:0}.jw-skin-seven .jw-playlist-container .jw-label .jw-icon-play{color:#FF0046}.jw-skin-seven .jw-playlist-container .jw-label .jw-icon-play:before{padding-left:0}.jw-skin-seven .jw-tooltip-title{background-color:#000;color:#fff}.jw-skin-seven .jw-text{color:#fff}.jw-skin-seven .jw-button-color{color:#fff}.jw-skin-seven .jw-button-color:hover{color:#FF0046}.jw-skin-seven .jw-toggle{color:#FF0046}.jw-skin-seven .jw-toggle.jw-off{color:#fff}.jw-skin-seven .jw-controlbar .jw-icon:before,.jw-skin-seven .jw-text-elapsed,.jw-skin-seven .jw-text-duration{padding:0 .7em}.jw-skin-seven .jw-controlbar .jw-icon-prev:before{padding-right:.25em}.jw-skin-seven .jw-controlbar .jw-icon-playlist:before{padding:0 .45em}.jw-skin-seven .jw-controlbar .jw-icon-next:before{padding-left:.25em}.jw-skin-seven .jw-icon-prev,.jw-skin-seven .jw-icon-next{font-size:.7em}.jw-skin-seven .jw-icon-prev:before{border-left:1px solid #666}.jw-skin-seven .jw-icon-next:before{border-right:1px solid #666}.jw-skin-seven .jw-icon-display{color:#fff}.jw-skin-seven .jw-icon-display:before{padding-left:0}.jw-skin-seven .jw-display-icon-container{border-radius:50%;border:1px solid #333}.jw-skin-seven .jw-rail{background-color:#384154;box-shadow:none}.jw-skin-seven .jw-buffer{background-color:#666F82}.jw-skin-seven .jw-progress{background:#FF0046}.jw-skin-seven .jw-knob{width:.6em;height:.6em;background-color:#fff;box-shadow:0 0 0 1px #000;border-radius:1em}.jw-skin-seven .jw-slider-horizontal .jw-slider-container{height:.95em}.jw-skin-seven .jw-slider-horizontal .jw-rail,.jw-skin-seven .jw-slider-horizontal .jw-buffer,.jw-skin-seven .jw-slider-horizontal .jw-progress{height:.2em;border-radius:0}.jw-skin-seven .jw-slider-horizontal .jw-knob{top:-0.2em}.jw-skin-seven .jw-slider-horizontal .jw-cue{top:-0.05em;width:.3em;height:.3em;background-color:#fff;border-radius:50%}.jw-skin-seven .jw-slider-vertical .jw-rail,.jw-skin-seven .jw-slider-vertical .jw-buffer,.jw-skin-seven .jw-slider-vertical .jw-progress{width:.2em}.jw-skin-seven .jw-slider-vertical .jw-knob{margin-bottom:-0.3em}.jw-skin-seven .jw-volume-tip{width:100%;left:-45%;padding-bottom:.7em}.jw-skin-seven .jw-text-duration{color:#666F82}.jw-skin-seven .jw-controlbar-right-group .jw-icon-tooltip:before,.jw-skin-seven .jw-controlbar-right-group .jw-icon-inline:before{border-left:1px solid #666}.jw-skin-seven .jw-controlbar-right-group .jw-icon-inline:first-child:before{border:none}.jw-skin-seven .jw-dock .jw-dock-button{border-radius:50%;border:1px solid #333}.jw-skin-seven .jw-dock .jw-overlay{border-radius:2.5em}.jw-skin-seven .jw-icon-tooltip .jw-active-option{background-color:#FF0046;color:#fff}.jw-skin-seven .jw-icon-volume{min-width:2.6em}.jw-skin-seven .jw-time-tip,.jw-skin-seven .jw-menu,.jw-skin-seven .jw-volume-tip,.jw-skin-seven .jw-skip{border:1px solid #333}.jw-skin-seven .jw-time-tip{padding:.2em;bottom:1.3em}.jw-skin-seven .jw-menu,.jw-skin-seven .jw-volume-tip{bottom:.24em}.jw-skin-seven .jw-skip{padding:.4em;border-radius:1.75em}.jw-skin-seven .jw-skip .jw-text,.jw-skin-seven .jw-skip .jw-icon-inline{color:#fff;line-height:1.75em}.jw-skin-seven .jw-skip.jw-skippable:hover .jw-text,.jw-skin-seven .jw-skip.jw-skippable:hover .jw-icon-inline{color:#FF0046}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon:before,.jw-skin-seven.jw-flag-touch .jw-text-elapsed,.jw-skin-seven.jw-flag-touch .jw-text-duration{padding:0 .35em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-prev:before{padding:0 .125em 0 .7em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-next:before{padding:0 .7em 0 .125em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-playlist:before{padding:0 .225em}', ""])
    }, function (d, c) {
        d.exports = function () {
            var b = [];
            return b.toString = function () {
                for (var g = [], f = 0; f < this.length; f++) {
                    var h = this[f];
                    h[2] ? g.push("@media " + h[2] + "{" + h[1] + "}") : g.push(h[1])
                }
                return g.join("")
            }, b.i = function (a, m) {
                "string" == typeof a && (a = [[null, a, ""]]);
                for (var l = {}, k = 0; k < this.length; k++) {
                    var j = this[k][0];
                    "number" == typeof j && (l[j] = !0)
                }
                for (k = 0; k < a.length; k++) {
                    var h = a[k];
                    "number" == typeof h[0] && l[h[0]] || (m && !h[2] ? h[2] = m : m && (h[2] = "(" + h[2] + ") and (" + m + ")"), b.push(h))
                }
            }, b
        }
    }, function (d, c) {
        d.exports = "data:application/font-woff;base64,d09GRgABAAAAABQ4AAsAAAAAE+wAAQABAAAAAAAAAAAAAAAAAAAAAAAAAABPUy8yAAABCAAAAGAAAABgDxID2WNtYXAAAAFoAAAAVAAAAFQaVsydZ2FzcAAAAbwAAAAIAAAACAAAABBnbHlmAAABxAAAD3AAAA9wKJaoQ2hlYWQAABE0AAAANgAAADYIhqKNaGhlYQAAEWwAAAAkAAAAJAmCBdxobXR4AAARkAAAAGwAAABscmAHPWxvY2EAABH8AAAAOAAAADg2EDnwbWF4cAAAEjQAAAAgAAAAIAAiANFuYW1lAAASVAAAAcIAAAHCwZOZtHBvc3QAABQYAAAAIAAAACAAAwAAAAMEmQGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAQAAA5hYDwP/AAEADwABAAAAAAQAAAAAAAAAAAAAAIAAAAAAAAwAAAAMAAAAcAAEAAwAAABwAAwABAAAAHAAEADgAAAAKAAgAAgACAAEAIOYW//3//wAAAAAAIOYA//3//wAB/+MaBAADAAEAAAAAAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAABABgAAAFoAOAADoAPwBEAEkAACUVIi4CNTQ2Ny4BNTQ+AjMyHgIVFAYHHgEVFA4CIxEyFhc+ATU0LgIjIg4CFRQWFz4BMxExARUhNSEXFSE1IRcVITUhAUAuUj0jCgoKCkZ6o11do3pGCgoKCiM9Ui4qSh4BAjpmiE1NiGY6AQIeSioCVQIL/fWWAXX+i0oBK/7VHh4jPVIuGS4VH0MiXaN6RkZ6o10iQx8VLhkuUj0jAcAdGQ0bDk2IZjo6ZohNDhsNGR3+XgNilZXglZXglZUAAAABAEAAAAPAA4AAIQAAExQeAjMyPgI1MxQOAiMiLgI1ND4CMxUiDgIVMYs6ZohNTYhmOktGeqNdXaN6RkZ6o11NiGY6AcBNiGY6OmaITV2jekZGeqNdXaN6Rks6ZohNAAAEAEAAAATAA4AADgAcACoAMQAAJS4BJyERIREuAScRIREhByMuAyc1HgMXMSsBLgMnNR4DFzErATUeARcxAn8DBQQCDPxGCysLBDz9v1NaCERrjE9irINTCLVbByc6Sio9a1I1CLaBL0YMQgsoCgLB/ukDCgIBSPzCQk6HaEIIWAhQgKdgKUg5JgdYBzRRZzx9C0QuAAAAAAUAQAAABMADgAAOABkAJwA1ADwAACUuASchESERLgEnESERIQE1IREhLgMnMQEjLgMnNR4DFzErAS4DJzUeAxcxKwE1HgEXMQKAAgYFAg38QAwqCgRA/cD+gANA/iAYRVlsPgEtWghFa4xPYq2DUgmzWgcnO0oqPGpSNgm6gDBEDEAMKAwCwP7tAggDAUb8wAHQ8P3APWdUQRf98E2IaEIHWghQgKhgKUg4JgdaCDVRZzt9DEMuAAAEAEAAAAXAA4AABAAJAGcAxQAANxEhESEBIREhEQU+ATc+ATMyFhceARceARceARcjLgEnLgEnLgEnLgEjIgYHDgEHDgEHDgEVFBYXHgEXHgEXHgEzMjY3PgE3Mw4BBw4BBw4BBw4BIyImJy4BJy4BJy4BNTQ2Nz4BNzEhPgE3PgEzMhYXHgEXHgEXHgEXIy4BJy4BJy4BJy4BIyIGBw4BBw4BBw4BFRQWFx4BFx4BFx4BMzI2Nz4BNzMOAQcOAQcOAQcOASMiJicuAScuAScuATU0Njc+ATcxQAWA+oAFNvsUBOz8Iw4hExQsGBIhEA8cDQwUCAgLAlsBBQUECgYHDggIEAkQGgsLEgcHCgMDAwMDAwoHBxILCxoQFiEMDA8DWgIJBwgTDQwcERAkFBgsFBMhDg0VBwcHBwcHFQ0Bug0hFBMsGREhEBAcDAwVCAgKAloCBQQECwYGDggIEQgQGwsLEgcHCgMDAwMDAwoHBxILCxsQFSIMDA4DWwIJCAcUDAwdEBEkExksExQhDQ4UBwcICAcHFA4AA4D8gAM1/RYC6tcQGAgJCQUFBQ8KChgPDiETCQ4HBwwFBQgDAwIGBgYRCgoYDQ0cDg0aDQ0XCgoRBgYGDQ0OIhYUJBEQHAsLEgYGBgkICRcPDyQUFCwXGC0VFCQPEBgICQkFBQUPCgoYDw4hEwkOBwcMBQUIAwMCBgYGEQoKGA0NHA4NGg0NFwoKEQYGBg0NDiIWFCQREBwLCxIGBgYJCAkXDw8kFBQsFxgtFRQkDwAAAAADAEAAAAXAA4AAEABvAM4AACUhIiY1ETQ2MyEyFhURFAYjAT4BNz4BNz4BMzIWFx4BFx4BFx4BFzMuAScuAScuAScuASMiBgcOAQcOAQcOARUUFhceARceARceATMyNjc+ATc+ATc+ATcjDgEHDgEjIiYnLgEnLgEnLgE1NDY3OQEhPgE3PgE3PgEzMhYXHgEXHgEXHgEXMy4BJy4BJy4BJy4BIyIGBw4BBw4BBw4BFRQWFx4BFx4BFx4BMzI2Nz4BNz4BNz4BNyMOAQcOASMiJicuAScuAScuATU0Njc5AQUs+6g9V1c9BFg9V1c9/JoDCgcGEgsLGxAJEAgIDgYHCgQEBgFaAgoICBQNDBwQDyESGCwUEyEODRUHBwcHBwcVDQ4hExQrGRQkEBAdDAwUCAcJAloDDwwMIhUQGwsLEgYHCgMEAwMEAbkDCgcHEgsLGxAIEQgHDwYGCwQEBQFbAgoICBUMDBwQECERGSwTFCENDhQHBwgIBwcUDg0hFBMsGRMkERAdDAwUBwgJAlsDDgwNIRUQGwsLEgcHCgMDAwMDAFc+AlY+V1c+/ao+VwH0DRgKCxAGBgYCAwMIBQUMBwcOCRMhDg8YCgoOBgUFCQkIGBAPJBQVLRgXLBQUJA8PFwkICQYGBhILCxwQESQUFiIODQ0GBgYRCgoXDQ0aDg4bDQ0YCgsQBgYGAgMDCAUFDAcHDgkTIQ4PGAoKDgYFBQkJCBgQDyQUFS0YFywUFCQPDxcJCAkGBgYSCwscEBEkFBYiDg0NBgYGEQoKFw0NGg4OGw0AAAABAOAAoAMgAuAAFAAAARQOAiMiLgI1ND4CMzIeAhUDIC1OaTw8aU4tLU5pPDxpTi0BwDxpTi0tTmk8PGlOLS1OaTwAAAMAQAAQBEADkAADABAAHwAANwkBISUyNjU0JiMiBhUUFjMTNCYjIgYVERQWMzI2NRFAAgACAPwAAgAOFRUODhUVDiMVDg4VFQ4OFRADgPyAcBYQDxgWERAWAeYPGBYR/tcPGBYRASkAAgBAAAADwAOAAAcADwAANxEXNxcHFyEBIREnByc3J0CAsI2wgP5zAfMBjYCwjbCAAAGNgLCNsIADgP5zgLCNsIAAAAAFAEAAAAXAA4AABAAJABYAMwBPAAA3ESERIQEhESERATM1MxEjNSMVIxEzFSUeARceARceARUUBgcOAQcOAQcOASsBETMeARcxBxEzMjY3PgE3PgE3PgE1NCYnLgEnLgEnLgErAUAFgPqABTb7FATs/FS2YGC2ZGQCXBQeDg8UBwcJBgcHEwwMIRMTLBuwsBYqE6BHCRcJChIIBw0FBQUEAwINBwcTDAwgETcAA4D8gAM2/RcC6f7Arf5AwMABwK2dBxQODyIWFTAbGC4TFiIPDhgKCQcBwAIHB0P+5gQDAg0HBxcMDCETER0PDhgKCQ8EBQUABAA9AAAFwAOAABAAHQA7AFkAACUhIiY1ETQ2MyEyFhURFAYjASMVIzUjETM1MxUzEQUuAScuAScuASsBETMyNjc+ATc+ATc+ATUuASc5AQcOAQcOASsBETMyFhceARceARceARUUBgcOAQc5AQUq+6k+WFg+BFc+WFg+/bNgs2Rks2ABsAcXDA4fExMnFrCwGywTEx4PDBMHBwYCCAl3CBIKCRQMRzcTHgwMEwcHCwQDBAUFBQ0HAFg+AlQ+WFg+/aw+WAKdra3+QMDAAcB9FiIODxQHBwb+QAkHCRgPDiUTFiwYHTAW4ggNAgMEAR8EBQUPCgoYDw4fERMfDwwXBwAAAAABAEMABgOgA3oAjwAAExQiNScwJic0JicuAQcOARUcARUeARceATc+ATc+ATE2MhUwFAcUFhceARceATMyNjc+ATc+ATc+AzE2MhUwDgIVFBYXHgEXFjY3PgE3PgE3PgE3PgM3PAE1NCYnJgYHDgMxBiI1MDwCNTQmJyYGBw4BBw4DMQYiNTAmJy4BJyYGBw4BMRWQBgQIBAgCBQ4KBwkDFgcHIQ8QDwcHNgUEAwMHBQsJChcMBQ0FBwsHDBMICR8cFQUFAwQDCAUHFRERJBEMEwgJEgUOGQwGMjgvBAkHDBYEAz1IPAQFLyQRIhEQFgoGIiUcBQUEAgMYKCcmCgcsAboFBQwYDwUKBwUEAgMNBwcLBxRrDhENBwggDxOTCgqdMBM1EQwTCAcFBAIFCgcPIw4UQ0IxCgpTc3glEyMREBgIBwEKBxUKESUQJ00mE6/JrA8FBgIHDQMECAkGla2PCQk1VGYxNTsHAgUKChwQC2BqVQoKehYfTwUDRx8TkAMAAAAAAgBGAAAENgOAAAQACAAAJREzESMJAhEDxnBw/IADgPyAAAOA/IADgP5A/kADgAAAAgCAAAADgAOAAAQACQAAJREhESEBIREhEQKAAQD/AP4AAQD/AAADgPyAA4D8gAOAAAAAAAEAgAAABAADgAADAAAJAREBBAD8gAOAAcD+QAOA/kAAAgBKAAAEOgOAAAQACAAANxEjETMJAhG6cHADgPyAA4AAA4D8gAOA/kD+QAOAAAAAAQBDACADQwOgACkAAAEeARUUDgIjIi4CNTQ+AjM1DQE1Ig4CFRQeAjMyPgI1NCYnNwMNGhw8aYxPT4xoPT1ojE8BQP7APGlOLS1OaTw8aU4tFhNTAmMrYzVPjGg9PWiMT0+MaD2ArbOALU5pPDxpTi0tTmk8KUsfMAAAAAEAQABmAiADEwAGAAATETMlESUjQM0BE/7tzQEzARPN/VPNAAQAQAAABJADgAAXACsAOgBBAAAlJz4DNTQuAic3HgMVFA4CBzEvAT4BNTQmJzceAxUOAwcxJz4BNTQmJzceARUUBgcnBREzJRElIwPaKiY+KxcXKz4mKipDMBkZMEMqpCk5REQ5KSE0JBQBFCQzIcMiKCgiKiYwMCYq/c3NARP+7c0AIyheaXI8PHFpXikjK2ZyfEFBfHJmK4MjNZFUVJE1Ix5IUFgvL1lRRx2zFkgpK0YVIxxcNDVZHykDARPN/VPNAAACAEAAAAPDA4AABwAPAAABFyERFzcXBwEHJzcnIREnAypw/qlwl3mZ/iaWepZwAVdtAnNwAVdwlnqT/iOWepZw/qpsAAMAQAETBcACYAAMABkAJgAAARQGIyImNTQ2MzIWFSEUBiMiJjU0NjMyFhUhFAYjIiY1NDYzMhYVAY1iRUVhYUVFYgIWYUVFYmJFRWECHWFFRWJiRUVhAbpFYmJFRWFhRUViYkVFYWFFRWJiRUVhYUUAAAAAAQBmACYDmgNaACAAAAEXFhQHBiIvAQcGIicmND8BJyY0NzYyHwE3NjIXFhQPAQKj9yQkJGMd9vYkYx0kJPf3JCQkYx329iRjHSQk9wHA9iRjHSQk9/ckJCRjHfb2JGMdJCT39yQkJGMd9gAABgBEAAQDvAN8AAQACQAOABMAGAAdAAABIRUhNREhFSE1ESEVITUBMxUjNREzFSM1ETMVIzUBpwIV/esCFf3rAhX96/6dsrKysrKyA3xZWf6dWVn+nVlZAsaysv6dsrL+nbKyAAEAAAABGZqh06s/Xw889QALBAAAAAAA0dQiKwAAAADR1CIrAAAAAAXAA6AAAAAIAAIAAAAAAAAAAQAAA8D/wAAABgAAAAAABcAAAQAAAAAAAAAAAAAAAAAAABsEAAAAAAAAAAAAAAACAAAABgAAYAQAAEAFAABABQAAQAYAAEAGAABABAAA4ASAAEAEAABABgAAQAYAAD0D4ABDBIAARgQAAIAEAACABIAASgOAAEMEwABABMAAQAQAAEAGAABABAAAZgQAAEQAAAAAAAoAFAAeAIgAuAEEAWAChgOyA9QECAQqBKQFJgXoBgAGGgYqBkIGgAaSBvQHFgdQB4YHuAABAAAAGwDPAAYAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEADAAAAAEAAAAAAAIABwCNAAEAAAAAAAMADABFAAEAAAAAAAQADACiAAEAAAAAAAUACwAkAAEAAAAAAAYADABpAAEAAAAAAAoAGgDGAAMAAQQJAAEAGAAMAAMAAQQJAAIADgCUAAMAAQQJAAMAGABRAAMAAQQJAAQAGACuAAMAAQQJAAUAFgAvAAMAAQQJAAYAGAB1AAMAAQQJAAoANADganctc2l4LWljb25zAGoAdwAtAHMAaQB4AC0AaQBjAG8AbgBzVmVyc2lvbiAxLjEAVgBlAHIAcwBpAG8AbgAgADEALgAxanctc2l4LWljb25zAGoAdwAtAHMAaQB4AC0AaQBjAG8AbgBzanctc2l4LWljb25zAGoAdwAtAHMAaQB4AC0AaQBjAG8AbgBzUmVndWxhcgBSAGUAZwB1AGwAYQByanctc2l4LWljb25zAGoAdwAtAHMAaQB4AC0AaQBjAG8AbgBzRm9udCBnZW5lcmF0ZWQgYnkgSWNvTW9vbi4ARgBvAG4AdAAgAGcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAuAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=="
    }, function (d, c) {
        d.exports = "data:application/octet-stream;base64,AAEAAAALAIAAAwAwT1MvMg8SA9kAAAC8AAAAYGNtYXAaVsydAAABHAAAAFRnYXNwAAAAEAAAAXAAAAAIZ2x5ZiiWqEMAAAF4AAAPcGhlYWQIhqKNAAAQ6AAAADZoaGVhCYIF3AAAESAAAAAkaG10eHJgBz0AABFEAAAAbGxvY2E2EDnwAAARsAAAADhtYXhwACIA0QAAEegAAAAgbmFtZcGTmbQAABIIAAABwnBvc3QAAwAAAAATzAAAACAAAwSZAZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADmFgPA/8AAQAPAAEAAAAABAAAAAAAAAAAAAAAgAAAAAAADAAAAAwAAABwAAQADAAAAHAADAAEAAAAcAAQAOAAAAAoACAACAAIAAQAg5hb//f//AAAAAAAg5gD//f//AAH/4xoEAAMAAQAAAAAAAAAAAAAAAQAB//8ADwABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAAAQAAAAAAAAAAAAIAADc5AQAAAAAEAGAAAAWgA4AAOgA/AEQASQAAJRUiLgI1NDY3LgE1ND4CMzIeAhUUBgceARUUDgIjETIWFz4BNTQuAiMiDgIVFBYXPgEzETEBFSE1IRcVITUhFxUhNSEBQC5SPSMKCgoKRnqjXV2jekYKCgoKIz1SLipKHgECOmaITU2IZjoBAh5KKgJVAgv99ZYBdf6LSgEr/tUeHiM9Ui4ZLhUfQyJdo3pGRnqjXSJDHxUuGS5SPSMBwB0ZDRsOTYhmOjpmiE0OGw0ZHf5eA2KVleCVleCVlQAAAAEAQAAAA8ADgAAhAAATFB4CMzI+AjUzFA4CIyIuAjU0PgIzFSIOAhUxizpmiE1NiGY6S0Z6o11do3pGRnqjXU2IZjoBwE2IZjo6ZohNXaN6RkZ6o11do3pGSzpmiE0AAAQAQAAABMADgAAOABwAKgAxAAAlLgEnIREhES4BJxEhESEHIy4DJzUeAxcxKwEuAyc1HgMXMSsBNR4BFzECfwMFBAIM/EYLKwsEPP2/U1oIRGuMT2Ksg1MItVsHJzpKKj1rUjUItoEvRgxCCygKAsH+6QMKAgFI/MJCTodoQghYCFCAp2ApSDkmB1gHNFFnPH0LRC4AAAAABQBAAAAEwAOAAA4AGQAnADUAPAAAJS4BJyERIREuAScRIREhATUhESEuAycxASMuAyc1HgMXMSsBLgMnNR4DFzErATUeARcxAoACBgUCDfxADCoKBED9wP6AA0D+IBhFWWw+AS1aCEVrjE9irYNSCbNaByc7Sio8alI2CbqAMEQMQAwoDALA/u0CCAMBRvzAAdDw/cA9Z1RBF/3wTYhoQgdaCFCAqGApSDgmB1oINVFnO30MQy4AAAQAQAAABcADgAAEAAkAZwDFAAA3ESERIQEhESERBT4BNz4BMzIWFx4BFx4BFx4BFyMuAScuAScuAScuASMiBgcOAQcOAQcOARUUFhceARceARceATMyNjc+ATczDgEHDgEHDgEHDgEjIiYnLgEnLgEnLgE1NDY3PgE3MSE+ATc+ATMyFhceARceARceARcjLgEnLgEnLgEnLgEjIgYHDgEHDgEHDgEVFBYXHgEXHgEXHgEzMjY3PgE3Mw4BBw4BBw4BBw4BIyImJy4BJy4BJy4BNTQ2Nz4BNzFABYD6gAU2+xQE7PwjDiETFCwYEiEQDxwNDBQICAsCWwEFBQQKBgcOCAgQCRAaCwsSBwcKAwMDAwMDCgcHEgsLGhAWIQwMDwNaAgkHCBMNDBwRECQUGCwUEyEODRUHBwcHBwcVDQG6DSEUEywZESEQEBwMDBUICAoCWgIFBAQLBgYOCAgRCBAbCwsSBwcKAwMDAwMDCgcHEgsLGxAVIgwMDgNbAgkIBxQMDB0QESQTGSwTFCENDhQHBwgIBwcUDgADgPyAAzX9FgLq1xAYCAkJBQUFDwoKGA8OIRMJDgcHDAUFCAMDAgYGBhEKChgNDRwODRoNDRcKChEGBgYNDQ4iFhQkERAcCwsSBgYGCQgJFw8PJBQULBcYLRUUJA8QGAgJCQUFBQ8KChgPDiETCQ4HBwwFBQgDAwIGBgYRCgoYDQ0cDg0aDQ0XCgoRBgYGDQ0OIhYUJBEQHAsLEgYGBgkICRcPDyQUFCwXGC0VFCQPAAAAAAMAQAAABcADgAAQAG8AzgAAJSEiJjURNDYzITIWFREUBiMBPgE3PgE3PgEzMhYXHgEXHgEXHgEXMy4BJy4BJy4BJy4BIyIGBw4BBw4BBw4BFRQWFx4BFx4BFx4BMzI2Nz4BNz4BNz4BNyMOAQcOASMiJicuAScuAScuATU0Njc5ASE+ATc+ATc+ATMyFhceARceARceARczLgEnLgEnLgEnLgEjIgYHDgEHDgEHDgEVFBYXHgEXHgEXHgEzMjY3PgE3PgE3PgE3Iw4BBw4BIyImJy4BJy4BJy4BNTQ2NzkBBSz7qD1XVz0EWD1XVz38mgMKBwYSCwsbEAkQCAgOBgcKBAQGAVoCCggIFA0MHBAPIRIYLBQTIQ4NFQcHBwcHBxUNDiETFCsZFCQQEB0MDBQIBwkCWgMPDAwiFRAbCwsSBgcKAwQDAwQBuQMKBwcSCwsbEAgRCAcPBgYLBAQFAVsCCggIFQwMHBAQIREZLBMUIQ0OFAcHCAgHBxQODSEUEywZEyQREB0MDBQHCAkCWwMODA0hFRAbCwsSBwcKAwMDAwMAVz4CVj5XVz79qj5XAfQNGAoLEAYGBgIDAwgFBQwHBw4JEyEODxgKCg4GBQUJCQgYEA8kFBUtGBcsFBQkDw8XCQgJBgYGEgsLHBARJBQWIg4NDQYGBhEKChcNDRoODhsNDRgKCxAGBgYCAwMIBQUMBwcOCRMhDg8YCgoOBgUFCQkIGBAPJBQVLRgXLBQUJA8PFwkICQYGBhILCxwQESQUFiIODQ0GBgYRCgoXDQ0aDg4bDQAAAAEA4ACgAyAC4AAUAAABFA4CIyIuAjU0PgIzMh4CFQMgLU5pPDxpTi0tTmk8PGlOLQHAPGlOLS1OaTw8aU4tLU5pPAAAAwBAABAEQAOQAAMAEAAfAAA3CQEhJTI2NTQmIyIGFRQWMxM0JiMiBhURFBYzMjY1EUACAAIA/AACAA4VFQ4OFRUOIxUODhUVDg4VEAOA/IBwFhAPGBYREBYB5g8YFhH+1w8YFhEBKQACAEAAAAPAA4AABwAPAAA3ERc3FwcXIQEhEScHJzcnQICwjbCA/nMB8wGNgLCNsIAAAY2AsI2wgAOA/nOAsI2wgAAAAAUAQAAABcADgAAEAAkAFgAzAE8AADcRIREhASERIREBMzUzESM1IxUjETMVJR4BFx4BFx4BFRQGBw4BBw4BBw4BKwERMx4BFzEHETMyNjc+ATc+ATc+ATU0JicuAScuAScuASsBQAWA+oAFNvsUBOz8VLZgYLZkZAJcFB4ODxQHBwkGBwcTDAwhExMsG7CwFioToEcJFwkKEggHDQUFBQQDAg0HBxMMDCARNwADgPyAAzb9FwLp/sCt/kDAwAHArZ0HFA4PIhYVMBsYLhMWIg8OGAoJBwHAAgcHQ/7mBAMCDQcHFwwMIRMRHQ8OGAoJDwQFBQAEAD0AAAXAA4AAEAAdADsAWQAAJSEiJjURNDYzITIWFREUBiMBIxUjNSMRMzUzFTMRBS4BJy4BJy4BKwERMzI2Nz4BNz4BNz4BNS4BJzkBBw4BBw4BKwERMzIWFx4BFx4BFx4BFRQGBw4BBzkBBSr7qT5YWD4EVz5YWD79s2CzZGSzYAGwBxcMDh8TEycWsLAbLBMTHg8MEwcHBgIICXcIEgoJFAxHNxMeDAwTBwcLBAMEBQUFDQcAWD4CVD5YWD79rD5YAp2trf5AwMABwH0WIg4PFAcHBv5ACQcJGA8OJRMWLBgdMBbiCA0CAwQBHwQFBQ8KChgPDh8REx8PDBcHAAAAAAEAQwAGA6ADegCPAAATFCI1JzAmJzQmJy4BBw4BFRwBFR4BFx4BNz4BNz4BMTYyFTAUBxQWFx4BFx4BMzI2Nz4BNz4BNz4DMTYyFTAOAhUUFhceARcWNjc+ATc+ATc+ATc+Azc8ATU0JicmBgcOAzEGIjUwPAI1NCYnJgYHDgEHDgMxBiI1MCYnLgEnJgYHDgExFZAGBAgECAIFDgoHCQMWBwchDxAPBwc2BQQDAwcFCwkKFwwFDQUHCwcMEwgJHxwVBQUDBAMIBQcVEREkEQwTCAkSBQ4ZDAYyOC8ECQcMFgQDPUg8BAUvJBEiERAWCgYiJRwFBQQCAxgoJyYKBywBugUFDBgPBQoHBQQCAw0HBwsHFGsOEQ0HCCAPE5MKCp0wEzURDBMIBwUEAgUKBw8jDhRDQjEKClNzeCUTIxEQGAgHAQoHFQoRJRAnTSYTr8msDwUGAgcNAwQICQaVrY8JCTVUZjE1OwcCBQoKHBALYGpVCgp6Fh9PBQNHHxOQAwAAAAACAEYAAAQ2A4AABAAIAAAlETMRIwkCEQPGcHD8gAOA/IAAA4D8gAOA/kD+QAOAAAACAIAAAAOAA4AABAAJAAAlESERIQEhESERAoABAP8A/gABAP8AAAOA/IADgPyAA4AAAAAAAQCAAAAEAAOAAAMAAAkBEQEEAPyAA4ABwP5AA4D+QAACAEoAAAQ6A4AABAAIAAA3ESMRMwkCEbpwcAOA/IADgAADgPyAA4D+QP5AA4AAAAABAEMAIANDA6AAKQAAAR4BFRQOAiMiLgI1ND4CMzUNATUiDgIVFB4CMzI+AjU0Jic3Aw0aHDxpjE9PjGg9PWiMTwFA/sA8aU4tLU5pPDxpTi0WE1MCYytjNU+MaD09aIxPT4xoPYCts4AtTmk8PGlOLS1OaTwpSx8wAAAAAQBAAGYCIAMTAAYAABMRMyURJSNAzQET/u3NATMBE839U80ABABAAAAEkAOAABcAKwA6AEEAACUnPgM1NC4CJzceAxUUDgIHMS8BPgE1NCYnNx4DFQ4DBzEnPgE1NCYnNx4BFRQGBycFETMlESUjA9oqJj4rFxcrPiYqKkMwGRkwQyqkKTlERDkpITQkFAEUJDMhwyIoKCIqJjAwJir9zc0BE/7tzQAjKF5pcjw8cWleKSMrZnJ8QUF8cmYrgyM1kVRUkTUjHkhQWC8vWVFHHbMWSCkrRhUjHFw0NVkfKQMBE839U80AAAIAQAAAA8MDgAAHAA8AAAEXIREXNxcHAQcnNychEScDKnD+qXCXeZn+JpZ6lnABV20Cc3ABV3CWepP+I5Z6lnD+qmwAAwBAARMFwAJgAAwAGQAmAAABFAYjIiY1NDYzMhYVIRQGIyImNTQ2MzIWFSEUBiMiJjU0NjMyFhUBjWJFRWFhRUViAhZhRUViYkVFYQIdYUVFYmJFRWEBukViYkVFYWFFRWJiRUVhYUVFYmJFRWFhRQAAAAABAGYAJgOaA1oAIAAAARcWFAcGIi8BBwYiJyY0PwEnJjQ3NjIfATc2MhcWFA8BAqP3JCQkYx329iRjHSQk9/ckJCRjHfb2JGMdJCT3AcD2JGMdJCT39yQkJGMd9vYkYx0kJPf3JCQkYx32AAAGAEQABAO8A3wABAAJAA4AEwAYAB0AAAEhFSE1ESEVITURIRUhNQEzFSM1ETMVIzURMxUjNQGnAhX96wIV/esCFf3r/p2ysrKysrIDfFlZ/p1ZWf6dWVkCxrKy/p2ysv6dsrIAAQAAAAEZmqHTqz9fDzz1AAsEAAAAAADR1CIrAAAAANHUIisAAAAABcADoAAAAAgAAgAAAAAAAAABAAADwP/AAAAGAAAAAAAFwAABAAAAAAAAAAAAAAAAAAAAGwQAAAAAAAAAAAAAAAIAAAAGAABgBAAAQAUAAEAFAABABgAAQAYAAEAEAADgBIAAQAQAAEAGAABABgAAPQPgAEMEgABGBAAAgAQAAIAEgABKA4AAQwTAAEAEwABABAAAQAYAAEAEAABmBAAARAAAAAAACgAUAB4AiAC4AQQBYAKGA7ID1AQIBCoEpAUmBegGAAYaBioGQgaABpIG9AcWB1AHhge4AAEAAAAbAM8ABgAAAAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAOAK4AAQAAAAAAAQAMAAAAAQAAAAAAAgAHAI0AAQAAAAAAAwAMAEUAAQAAAAAABAAMAKIAAQAAAAAABQALACQAAQAAAAAABgAMAGkAAQAAAAAACgAaAMYAAwABBAkAAQAYAAwAAwABBAkAAgAOAJQAAwABBAkAAwAYAFEAAwABBAkABAAYAK4AAwABBAkABQAWAC8AAwABBAkABgAYAHUAAwABBAkACgA0AOBqdy1zaXgtaWNvbnMAagB3AC0AcwBpAHgALQBpAGMAbwBuAHNWZXJzaW9uIDEuMQBWAGUAcgBzAGkAbwBuACAAMQAuADFqdy1zaXgtaWNvbnMAagB3AC0AcwBpAHgALQBpAGMAbwBuAHNqdy1zaXgtaWNvbnMAagB3AC0AcwBpAHgALQBpAGMAbwBuAHNSZWd1bGFyAFIAZQBnAHUAbABhAHJqdy1zaXgtaWNvbnMAagB3AC0AcwBpAHgALQBpAGMAbwBuAHNGb250IGdlbmVyYXRlZCBieSBJY29Nb29uLgBGAG8AbgB0ACAAZwBlAG4AZQByAGEAdABlAGQAIABiAHkAIABJAGMAbwBNAG8AbwBuAC4AAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
    }, function (J, I, H) {
        function G(j, h) {
            for (var o = 0; o < j.length; o++) {
                var n = j[o], m = y[n.id];
                if (m) {
                    m.refs++;
                    for (var l = 0; l < m.parts.length; l++) {
                        m.parts[l](n.parts[l])
                    }
                    for (; l < n.parts.length; l++) {
                        m.parts.push(C(n.parts[l], h))
                    }
                } else {
                    for (var k = [], l = 0; l < n.parts.length; l++) {
                        k.push(C(n.parts[l], h))
                    }
                    y[n.id] = {id: n.id, refs: 1, parts: k}
                }
            }
        }

        function F(L) {
            for (var K = [], r = {}, q = 0; q < L.length; q++) {
                var p = L[q], o = p[0], n = p[1], m = p[2], l = p[3], k = {css: n, media: m, sourceMap: l};
                r[o] ? r[o].parts.push(k) : K.push(r[o] = {id: o, parts: [k]})
            }
            return K
        }

        function E() {
            var d = document.createElement("style"), c = v();
            return d.type = "text/css", c.appendChild(d), d
        }

        function D() {
            var d = document.createElement("link"), c = v();
            return d.rel = "stylesheet", c.appendChild(d), d
        }

        function C(g, f) {
            var m, l, k;
            if (f.singleton) {
                var j = t++;
                m = u || (u = E()), l = B.bind(null, m, j, !1), k = B.bind(null, m, j, !0)
            } else {
                g.sourceMap && "function" == typeof URL && "function" == typeof URL.createObjectURL && "function" == typeof URL.revokeObjectURL && "function" == typeof Blob && "function" == typeof btoa ? (m = D(), l = z.bind(null, m), k = function () {
                    m.parentNode.removeChild(m), m.href && URL.revokeObjectURL(m.href)
                }) : (m = E(), l = A.bind(null, m), k = function () {
                    m.parentNode.removeChild(m)
                })
            }
            return l(g), function (a) {
                if (a) {
                    if (a.css === g.css && a.media === g.media && a.sourceMap === g.sourceMap) {
                        return
                    }
                    l(g = a)
                } else {
                    k()
                }
            }
        }

        function B(j, h, o, n) {
            var m = o ? "" : n.css;
            if (j.styleSheet) {
                j.styleSheet.cssText = s(h, m)
            } else {
                var l = document.createTextNode(m), k = j.childNodes;
                k[h] && j.removeChild(k[h]), k.length ? j.insertBefore(l, k[h]) : j.appendChild(l)
            }
        }

        function A(g, f) {
            var j = f.css, h = f.media;
            f.sourceMap;
            if (h && g.setAttribute("media", h), g.styleSheet) {
                g.styleSheet.cssText = j
            } else {
                for (; g.firstChild;) {
                    g.removeChild(g.firstChild)
                }
                g.appendChild(document.createTextNode(j))
            }
        }

        function z(h, g) {
            var m = g.css, l = (g.media, g.sourceMap);
            l && (m += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(l)))) + " */");
            var k = new Blob([m], {type: "text/css"}), j = h.href;
            h.href = URL.createObjectURL(k), j && URL.revokeObjectURL(j)
        }

        var y = {}, x = function (d) {
            var c;
            return function () {
                return "undefined" == typeof c && (c = d.apply(this, arguments)), c
            }
        }, w = x(function () {
            return /msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase())
        }), v = x(function () {
            return document.head || document.getElementsByTagName("head")[0]
        }), u = null, t = 0;
        J.exports = function (f, d) {
            d = d || {}, "undefined" == typeof d.singleton && (d.singleton = w());
            var g = F(f);
            return G(g, d), function (b) {
                for (var p = [], o = 0; o < g.length; o++) {
                    var n = g[o], m = y[n.id];
                    m.refs--, p.push(m)
                }
                if (b) {
                    var l = F(b);
                    G(l, d)
                }
                for (var o = 0; o < p.length; o++) {
                    var m = p[o];
                    if (0 === m.refs) {
                        for (var c = 0; c < m.parts.length; c++) {
                            m.parts[c]()
                        }
                        delete y[m.id]
                    }
                }
            }
        };
        var s = function () {
            var b = [];
            return function (a, d) {
                return b[a] = d, b.filter(Boolean).join("\n")
            }
        }()
    }, function (g, f, k) {
        var j, h;
        j = [k(42), k(45), k(59), k(48), k(89), k(51), k(127), k(95), k(101), k(96), k(83), k(46), k(62), k(114), k(70), k(162), k(67), k(98)], h = function (L, K, J, I, H, G, F, E, D, C, B, A, z, y, x, w, v, u) {
            var t = {};
            return t.api = L, t._ = K, t.version = J, t.utils = K.extend(I, G, {
                canCast: w.available,
                key: E,
                extend: K.extend,
                scriptloader: D,
                rssparser: v,
                tea: C,
                UI: F
            }), t.utils.css.style = t.utils.style, t.vid = B, t.events = K.extend({}, A, {state: z}), t.playlist = K.extend({}, y, {item: x}), t.plugins = u, t.cast = w, t
        }.apply(f, j), !(void 0 !== h && (g.exports = h))
    }])
});

function setupJwplayer() {
    var a = 0;
    if (typeof $ === "undefined") {
        return
    }
    $(".video-element").not(".smart-video-element").each(function () {
        var k = $(this).data("subtype");
        var d = "video" + (a++);
        $(this).attr("id", d);
        var b = $(this).data("content-id");
        var h = $(this).data("file-path").replace(/\t /g, "").trim();
        var j = $(this).data("preview-image");
        var f = parseInt($(this).data("width"));
        var l = parseInt($(this).data("height"));
        var m = $(this).closest(".promotion");
        if (!f || !l) {
            f = 16;
            l = 9
        }
        var c = {primary: "html5", skin: "bekle", width: "100%", aspectratio: f + ":" + l};
        if (m.length) {
            $.extend(c, {width: "", height: "280px"})
        }
        if (j && j.length > 0) {
            $.extend(c, {image: "/polopoly_fs/" + b + "!/" + j})
        }
        if (k === "flashfile") {
            var g = "/polopoly_fs/" + b + "!/" + h;
            $.extend(c, {file: g})
        } else {
            if (k === "url") {
                $.extend(c, {file: h})
            } else {
                if (k === "stream") {
                    $.extend(c, {file: $(this).data("streamer") + h})
                }
            }
        }
        jwplayer(d).setup(c)
    })
}

function setupSmartJwPlayer(b, f, a) {
    var g = {
        file: f,
        primary: "html5",
        width: "100%",
        aspectratio: "16:9",
        flashplayer: "/js/jwplayer/jwplayer.flash.swf",
        skin: "bekle"
    };
    if (a && a.length > 0) {
        $.extend(g, {image: a})
    }
    var c = $(document.getElementById(b)).closest(".promotion");
    if (c.length) {
        $.extend(g, {width: "", height: "280px"})
    }
    var d = jwplayer(b);
    d.setup(g)
}

$(function () {
    setupJwplayer()
});