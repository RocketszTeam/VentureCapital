!function(s){skel.breakpoints({xlarge:"(max-width: 1680px)",large:"(max-width: 1280px)",medium:"(max-width: 980px)",small:"(max-width: 736px)",xsmall:"(max-width: 480px)"}),s(function(){var a=s(window),e=s("body");e.addClass("is-loading"),a.on("load",function(){window.setTimeout(function(){e.removeClass("is-loading")},100)}),s("form").placeholder(),skel.on("+medium -medium",function(){s.prioritize(".important\\28 medium\\29",skel.breakpoint("medium").active)}),s("#menu").append('<a href="#menu" class="close"></a>').appendTo(e).panel({delay:500,hideOnClick:!0,hideOnSwipe:!0,resetScroll:!0,resetForms:!0,side:"right"});var o=s("#banner");if(0<o.length){skel.vars.IEVersion<12&&(a.on("resize",function(){var e=.6*a.height(),i=o.height();o.css("height","auto"),window.setTimeout(function(){i<e&&o.css("height",e+"px")},0)}),a.on("load",function(){a.triggerHandler("resize")}));var i=o.data("video");i&&a.on("load.banner",function(){a.off("load.banner"),!skel.vars.mobile&&!skel.breakpoint("large").active&&9<skel.vars.IEVersion&&o.append('<video autoplay loop><source src="'+i+'.mp4" type="video/mp4" /><source src="'+i+'.webm" type="video/webm" /></video>')}),o.find(".more").addClass("scrolly")}if(s(".flex-tabs").each(function(){var o=jQuery(this),n=o.find(".tab-list li a"),s=o.find(".tab");n.click(function(e){var i=jQuery(this),a=i.data("tab");n.removeClass("active"),i.addClass("active"),s.removeClass("active"),o.find("."+a).addClass("active"),e.preventDefault()})}),s(".scrolly").length){var n=s("#header").height();s(".scrolly").scrolly({offset:n})}})}(jQuery);