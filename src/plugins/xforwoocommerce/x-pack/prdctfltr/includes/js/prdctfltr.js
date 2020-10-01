/*
== malihu jquery custom scrollbar plugin == 
Version: 3.1.5 
Plugin URI: http://manos.malihu.gr/jquery-custom-content-scroller 
Author: malihu
Author URI: http://manos.malihu.gr
License: MIT License (MIT) 
*/
if (typeof mCustomScrollbar != 'function') {!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.11",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b)["offsetParent"in a.fn?"offsetParent":"parent"]();return c.length||(c=a("body")),parseInt(c.css("fontSize"),10)},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});(function(b,a,c){(function(d){d(jQuery)}(function(j){var g="mCustomScrollbar",d="mCS",m=".mCustomScrollbar",h={setWidth:false,setHeight:false,setTop:0,setLeft:0,axis:"y",scrollbarPosition:"inside",scrollInertia:950,autoDraggerLength:true,autoHideScrollbar:false,autoExpandScrollbar:false,alwaysShowScrollbar:0,snapAmount:null,snapOffset:0,mouseWheel:{enable:true,scrollAmount:"auto",axis:"y",preventDefault:false,deltaFactor:"auto",normalizeDelta:false,invert:false,disableOver:["select","option","keygen","datalist","textarea"]},scrollButtons:{enable:false,scrollType:"stepless",scrollAmount:"auto"},keyboard:{enable:true,scrollType:"stepless",scrollAmount:"auto"},contentTouchScroll:25,advanced:{autoExpandHorizontalScroll:false,autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",updateOnContentResize:true,updateOnImageLoad:true,updateOnSelectorChange:false},theme:"light",callbacks:{onScrollStart:false,onScroll:false,onTotalScroll:false,onTotalScrollBack:false,whileScrolling:false,onTotalScrollOffset:0,onTotalScrollBackOffset:0,alwaysTriggerOffsets:true,onOverflowY:false,onOverflowX:false,onOverflowYNone:false,onOverflowXNone:false},live:false,liveSelector:null},l=0,o={},f=function(p){if(o[p]){clearTimeout(o[p]);i._delete.call(null,o[p])}},k=(b.attachEvent&&!b.addEventListener)?1:0,n=false,e={init:function(q){var q=j.extend(true,{},h,q),p=i._selector.call(this);if(q.live){var s=q.liveSelector||this.selector||m,r=j(s);if(q.live==="off"){f(s);return}o[s]=setTimeout(function(){r.mCustomScrollbar(q);if(q.live==="once"&&r.length){f(s)}},500)}else{f(s)}q.setWidth=(q.set_width)?q.set_width:q.setWidth;q.setHeight=(q.set_height)?q.set_height:q.setHeight;q.axis=(q.horizontalScroll)?"x":i._findAxis.call(null,q.axis);q.scrollInertia=q.scrollInertia>0&&q.scrollInertia<17?17:q.scrollInertia;if(typeof q.mouseWheel!=="object"&&q.mouseWheel==true){q.mouseWheel={enable:true,scrollAmount:"auto",axis:"y",preventDefault:false,deltaFactor:"auto",normalizeDelta:false,invert:false}}q.mouseWheel.scrollAmount=!q.mouseWheelPixels?q.mouseWheel.scrollAmount:q.mouseWheelPixels;q.mouseWheel.normalizeDelta=!q.advanced.normalizeMouseWheelDelta?q.mouseWheel.normalizeDelta:q.advanced.normalizeMouseWheelDelta;q.scrollButtons.scrollType=i._findScrollButtonsType.call(null,q.scrollButtons.scrollType);i._theme.call(null,q);return j(p).each(function(){var u=j(this);if(!u.data(d)){u.data(d,{idx:++l,opt:q,scrollRatio:{y:null,x:null},overflowed:null,contentReset:{y:null,x:null},bindEvents:false,tweenRunning:false,sequential:{},langDir:u.css("direction"),cbOffsets:null,trigger:null});var w=u.data(d).opt,v=u.data("mcs-axis"),t=u.data("mcs-scrollbar-position"),x=u.data("mcs-theme");if(v){w.axis=v}if(t){w.scrollbarPosition=t}if(x){w.theme=x;i._theme.call(null,w)}i._pluginMarkup.call(this);e.update.call(null,u)}})},update:function(q){var p=q||i._selector.call(this);return j(p).each(function(){var t=j(this);if(t.data(d)){var v=t.data(d),u=v.opt,r=j("#mCSB_"+v.idx+"_container"),s=[j("#mCSB_"+v.idx+"_dragger_vertical"),j("#mCSB_"+v.idx+"_dragger_horizontal")];if(!r.length){return}if(v.tweenRunning){i._stop.call(null,t)}if(t.hasClass("mCS_disabled")){t.removeClass("mCS_disabled")}if(t.hasClass("mCS_destroyed")){t.removeClass("mCS_destroyed")}i._maxHeight.call(this);i._expandContentHorizontally.call(this);if(u.axis!=="y"&&!u.advanced.autoExpandHorizontalScroll){r.css("width",i._contentWidth(r.children()))}v.overflowed=i._overflowed.call(this);i._scrollbarVisibility.call(this);if(u.autoDraggerLength){i._setDraggerLength.call(this)}i._scrollRatio.call(this);i._bindEvents.call(this);var w=[Math.abs(r[0].offsetTop),Math.abs(r[0].offsetLeft)];if(u.axis!=="x"){if(!v.overflowed[0]){i._resetContentPosition.call(this);if(u.axis==="y"){i._unbindEvents.call(this)}else{if(u.axis==="yx"&&v.overflowed[1]){i._scrollTo.call(this,t,w[1].toString(),{dir:"x",dur:0,overwrite:"none"})}}}else{if(s[0].height()>s[0].parent().height()){i._resetContentPosition.call(this)}else{i._scrollTo.call(this,t,w[0].toString(),{dir:"y",dur:0,overwrite:"none"});v.contentReset.y=null}}}if(u.axis!=="y"){if(!v.overflowed[1]){i._resetContentPosition.call(this);if(u.axis==="x"){i._unbindEvents.call(this)}else{if(u.axis==="yx"&&v.overflowed[0]){i._scrollTo.call(this,t,w[0].toString(),{dir:"y",dur:0,overwrite:"none"})}}}else{if(s[1].width()>s[1].parent().width()){i._resetContentPosition.call(this)}else{i._scrollTo.call(this,t,w[1].toString(),{dir:"x",dur:0,overwrite:"none"});v.contentReset.x=null}}}i._autoUpdate.call(this)}})},scrollTo:function(r,q){if(typeof r=="undefined"||r==null){return}var p=i._selector.call(this);return j(p).each(function(){var u=j(this);if(u.data(d)){var x=u.data(d),w=x.opt,v={trigger:"external",scrollInertia:w.scrollInertia,scrollEasing:"mcsEaseInOut",moveDragger:false,timeout:60,callbacks:true,onStart:true,onUpdate:true,onComplete:true},s=j.extend(true,{},v,q),y=i._arr.call(this,r),t=s.scrollInertia>0&&s.scrollInertia<17?17:s.scrollInertia;y[0]=i._to.call(this,y[0],"y");y[1]=i._to.call(this,y[1],"x");if(s.moveDragger){y[0]*=x.scrollRatio.y;y[1]*=x.scrollRatio.x}s.dur=t;setTimeout(function(){if(y[0]!==null&&typeof y[0]!=="undefined"&&w.axis!=="x"&&x.overflowed[0]){s.dir="y";s.overwrite="all";i._scrollTo.call(this,u,y[0].toString(),s)}if(y[1]!==null&&typeof y[1]!=="undefined"&&w.axis!=="y"&&x.overflowed[1]){s.dir="x";s.overwrite="none";i._scrollTo.call(this,u,y[1].toString(),s)}},s.timeout)}})},stop:function(){var p=i._selector.call(this);return j(p).each(function(){var q=j(this);if(q.data(d)){i._stop.call(null,q)}})},disable:function(q){var p=i._selector.call(this);return j(p).each(function(){var r=j(this);if(r.data(d)){var t=r.data(d),s=t.opt;i._autoUpdate.call(this,"remove");i._unbindEvents.call(this);if(q){i._resetContentPosition.call(this)}i._scrollbarVisibility.call(this,true);r.addClass("mCS_disabled")}})},destroy:function(){var p=i._selector.call(this);return j(p).each(function(){var s=j(this);if(s.data(d)){var u=s.data(d),t=u.opt,q=j("#mCSB_"+u.idx),r=j("#mCSB_"+u.idx+"_container"),v=j(".mCSB_"+u.idx+"_scrollbar");if(t.live){f(p)}i._autoUpdate.call(this,"remove");i._unbindEvents.call(this);i._resetContentPosition.call(this);s.removeData(d);i._delete.call(null,this.mcs);v.remove();q.replaceWith(r.contents());s.removeClass(g+" _"+d+"_"+u.idx+" mCS-autoHide mCS-dir-rtl mCS_no_scrollbar mCS_disabled").addClass("mCS_destroyed")}})}},i={_selector:function(){return(typeof j(this)!=="object"||j(this).length<1)?m:this},_theme:function(s){var r=["rounded","rounded-dark","rounded-dots","rounded-dots-dark"],q=["rounded-dots","rounded-dots-dark","3d","3d-dark","3d-thick","3d-thick-dark","inset","inset-dark","inset-2","inset-2-dark","inset-3","inset-3-dark"],p=["minimal","minimal-dark"],u=["minimal","minimal-dark"],t=["minimal","minimal-dark"];s.autoDraggerLength=j.inArray(s.theme,r)>-1?false:s.autoDraggerLength;s.autoExpandScrollbar=j.inArray(s.theme,q)>-1?false:s.autoExpandScrollbar;s.scrollButtons.enable=j.inArray(s.theme,p)>-1?false:s.scrollButtons.enable;s.autoHideScrollbar=j.inArray(s.theme,u)>-1?true:s.autoHideScrollbar;s.scrollbarPosition=j.inArray(s.theme,t)>-1?"outside":s.scrollbarPosition},_findAxis:function(p){return(p==="yx"||p==="xy"||p==="auto")?"yx":(p==="x"||p==="horizontal")?"x":"y"},_findScrollButtonsType:function(p){return(p==="stepped"||p==="pixels"||p==="step"||p==="click")?"stepped":"stepless"},_pluginMarkup:function(){var y=j(this),x=y.data(d),r=x.opt,t=r.autoExpandScrollbar?" mCSB_scrollTools_onDrag_expand":"",B=["<div id='mCSB_"+x.idx+"_scrollbar_vertical' class='mCSB_scrollTools mCSB_"+x.idx+"_scrollbar mCS-"+r.theme+" mCSB_scrollTools_vertical"+t+"'><div class='mCSB_draggerContainer'><div id='mCSB_"+x.idx+"_dragger_vertical' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>","<div id='mCSB_"+x.idx+"_scrollbar_horizontal' class='mCSB_scrollTools mCSB_"+x.idx+"_scrollbar mCS-"+r.theme+" mCSB_scrollTools_horizontal"+t+"'><div class='mCSB_draggerContainer'><div id='mCSB_"+x.idx+"_dragger_horizontal' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],u=r.axis==="yx"?"mCSB_vertical_horizontal":r.axis==="x"?"mCSB_horizontal":"mCSB_vertical",w=r.axis==="yx"?B[0]+B[1]:r.axis==="x"?B[1]:B[0],v=r.axis==="yx"?"<div id='mCSB_"+x.idx+"_container_wrapper' class='mCSB_container_wrapper' />":"",s=r.autoHideScrollbar?" mCS-autoHide":"",p=(r.axis!=="x"&&x.langDir==="rtl")?" mCS-dir-rtl":"";if(r.setWidth){y.css("width",r.setWidth)}if(r.setHeight){y.css("height",r.setHeight)}r.setLeft=(r.axis!=="y"&&x.langDir==="rtl")?"989999px":r.setLeft;y.addClass(g+" _"+d+"_"+x.idx+s+p).wrapInner("<div id='mCSB_"+x.idx+"' class='mCustomScrollBox mCS-"+r.theme+" "+u+"'><div id='mCSB_"+x.idx+"_container' class='mCSB_container' style='position:relative; top:"+r.setTop+"; left:"+r.setLeft+";' dir="+x.langDir+" /></div>");var q=j("#mCSB_"+x.idx),z=j("#mCSB_"+x.idx+"_container");if(r.axis!=="y"&&!r.advanced.autoExpandHorizontalScroll){z.css("width",i._contentWidth(z.children()))}if(r.scrollbarPosition==="outside"){if(y.css("position")==="static"){y.css("position","relative")}y.css("overflow","visible");q.addClass("mCSB_outside").after(w)}else{q.addClass("mCSB_inside").append(w);z.wrap(v)}i._scrollButtons.call(this);var A=[j("#mCSB_"+x.idx+"_dragger_vertical"),j("#mCSB_"+x.idx+"_dragger_horizontal")];A[0].css("min-height",A[0].height());A[1].css("min-width",A[1].width())},_contentWidth:function(p){return Math.max.apply(Math,p.map(function(){return j(this).outerWidth(true)}).get())},_expandContentHorizontally:function(){var q=j(this),s=q.data(d),r=s.opt,p=j("#mCSB_"+s.idx+"_container");if(r.advanced.autoExpandHorizontalScroll&&r.axis!=="y"){p.css({position:"absolute",width:"auto"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:(Math.ceil(p[0].getBoundingClientRect().right+0.4)-Math.floor(p[0].getBoundingClientRect().left)),position:"relative"}).unwrap()}},_scrollButtons:function(){var s=j(this),u=s.data(d),t=u.opt,q=j(".mCSB_"+u.idx+"_scrollbar:first"),r=["<a href='#' class='mCSB_buttonUp' oncontextmenu='return false;' />","<a href='#' class='mCSB_buttonDown' oncontextmenu='return false;' />","<a href='#' class='mCSB_buttonLeft' oncontextmenu='return false;' />","<a href='#' class='mCSB_buttonRight' oncontextmenu='return false;' />"],p=[(t.axis==="x"?r[2]:r[0]),(t.axis==="x"?r[3]:r[1]),r[2],r[3]];if(t.scrollButtons.enable){q.prepend(p[0]).append(p[1]).next(".mCSB_scrollTools").prepend(p[2]).append(p[3])}},_maxHeight:function(){var t=j(this),w=t.data(d),v=w.opt,r=j("#mCSB_"+w.idx),q=t.css("max-height"),s=q.indexOf("%")!==-1,p=t.css("box-sizing");if(q!=="none"){var u=s?t.parent().height()*parseInt(q)/100:parseInt(q);if(p==="border-box"){u-=((t.innerHeight()-t.height())+(t.outerHeight()-t.innerHeight()))}r.css("max-height",Math.round(u))}},_setDraggerLength:function(){var u=j(this),s=u.data(d),p=j("#mCSB_"+s.idx),v=j("#mCSB_"+s.idx+"_container"),y=[j("#mCSB_"+s.idx+"_dragger_vertical"),j("#mCSB_"+s.idx+"_dragger_horizontal")],t=[p.height()/v.outerHeight(false),p.width()/v.outerWidth(false)],q=[parseInt(y[0].css("min-height")),Math.round(t[0]*y[0].parent().height()),parseInt(y[1].css("min-width")),Math.round(t[1]*y[1].parent().width())],r=k&&(q[1]<q[0])?q[0]:q[1],x=k&&(q[3]<q[2])?q[2]:q[3];y[0].css({height:r,"max-height":(y[0].parent().height()-10)}).find(".mCSB_dragger_bar").css({"line-height":q[0]+"px"});y[1].css({width:x,"max-width":(y[1].parent().width()-10)})},_scrollRatio:function(){var t=j(this),v=t.data(d),q=j("#mCSB_"+v.idx),r=j("#mCSB_"+v.idx+"_container"),s=[j("#mCSB_"+v.idx+"_dragger_vertical"),j("#mCSB_"+v.idx+"_dragger_horizontal")],u=[r.outerHeight(false)-q.height(),r.outerWidth(false)-q.width()],p=[u[0]/(s[0].parent().height()-s[0].height()),u[1]/(s[1].parent().width()-s[1].width())];v.scrollRatio={y:p[0],x:p[1]}},_onDragClasses:function(r,t,q){var s=q?"mCSB_dragger_onDrag_expanded":"",p=["mCSB_dragger_onDrag","mCSB_scrollTools_onDrag"],u=r.closest(".mCSB_scrollTools");if(t==="active"){r.toggleClass(p[0]+" "+s);u.toggleClass(p[1]);r[0]._draggable=r[0]._draggable?0:1}else{if(!r[0]._draggable){if(t==="hide"){r.removeClass(p[0]);u.removeClass(p[1])}else{r.addClass(p[0]);u.addClass(p[1])}}}},_overflowed:function(){var t=j(this),u=t.data(d),q=j("#mCSB_"+u.idx),s=j("#mCSB_"+u.idx+"_container"),r=u.overflowed==null?s.height():s.outerHeight(false),p=u.overflowed==null?s.width():s.outerWidth(false);return[r>q.height(),p>q.width()]},_resetContentPosition:function(){var t=j(this),v=t.data(d),u=v.opt,q=j("#mCSB_"+v.idx),r=j("#mCSB_"+v.idx+"_container"),s=[j("#mCSB_"+v.idx+"_dragger_vertical"),j("#mCSB_"+v.idx+"_dragger_horizontal")];i._stop(t);if((u.axis!=="x"&&!v.overflowed[0])||(u.axis==="y"&&v.overflowed[0])){s[0].add(r).css("top",0);i._scrollTo(t,"_resetY")}if((u.axis!=="y"&&!v.overflowed[1])||(u.axis==="x"&&v.overflowed[1])){var p=dx=0;if(v.langDir==="rtl"){p=q.width()-r.outerWidth(false);dx=Math.abs(p/v.scrollRatio.x)}r.css("left",p);s[1].css("left",dx);i._scrollTo(t,"_resetX")}},_bindEvents:function(){var r=j(this),t=r.data(d),s=t.opt;if(!t.bindEvents){i._draggable.call(this);if(s.contentTouchScroll){i._contentDraggable.call(this)}if(s.mouseWheel.enable){function q(){p=setTimeout(function(){if(!j.event.special.mousewheel){q()}else{clearTimeout(p);i._mousewheel.call(r[0])}},1000)}var p;q()}i._draggerRail.call(this);i._wrapperScroll.call(this);if(s.advanced.autoScrollOnFocus){i._focus.call(this)}if(s.scrollButtons.enable){i._buttons.call(this)}if(s.keyboard.enable){i._keyboard.call(this)}t.bindEvents=true}},_unbindEvents:function(){var s=j(this),t=s.data(d),p=d+"_"+t.idx,u=".mCSB_"+t.idx+"_scrollbar",r=j("#mCSB_"+t.idx+",#mCSB_"+t.idx+"_container,#mCSB_"+t.idx+"_container_wrapper,"+u+" .mCSB_draggerContainer,#mCSB_"+t.idx+"_dragger_vertical,#mCSB_"+t.idx+"_dragger_horizontal,"+u+">a"),q=j("#mCSB_"+t.idx+"_container");if(t.bindEvents){j(a).unbind("."+p);r.each(function(){j(this).unbind("."+p)});clearTimeout(s[0]._focusTimeout);i._delete.call(null,s[0]._focusTimeout);clearTimeout(t.sequential.step);i._delete.call(null,t.sequential.step);clearTimeout(q[0].onCompleteTimeout);i._delete.call(null,q[0].onCompleteTimeout);t.bindEvents=false}},_scrollbarVisibility:function(q){var t=j(this),v=t.data(d),u=v.opt,p=j("#mCSB_"+v.idx+"_container_wrapper"),r=p.length?p:j("#mCSB_"+v.idx+"_container"),w=[j("#mCSB_"+v.idx+"_scrollbar_vertical"),j("#mCSB_"+v.idx+"_scrollbar_horizontal")],s=[w[0].find(".mCSB_dragger"),w[1].find(".mCSB_dragger")];if(u.axis!=="x"){if(v.overflowed[0]&&!q){w[0].add(s[0]).add(w[0].children("a")).css("display","block");r.removeClass("mCS_no_scrollbar_y mCS_y_hidden")}else{if(u.alwaysShowScrollbar){if(u.alwaysShowScrollbar!==2){s[0].add(w[0].children("a")).css("display","none")}r.removeClass("mCS_y_hidden")}else{w[0].css("display","none");r.addClass("mCS_y_hidden")}r.addClass("mCS_no_scrollbar_y")}}if(u.axis!=="y"){if(v.overflowed[1]&&!q){w[1].add(s[1]).add(w[1].children("a")).css("display","block");r.removeClass("mCS_no_scrollbar_x mCS_x_hidden")}else{if(u.alwaysShowScrollbar){if(u.alwaysShowScrollbar!==2){s[1].add(w[1].children("a")).css("display","none")}r.removeClass("mCS_x_hidden")}else{w[1].css("display","none");r.addClass("mCS_x_hidden")}r.addClass("mCS_no_scrollbar_x")}}if(!v.overflowed[0]&&!v.overflowed[1]){t.addClass("mCS_no_scrollbar")}else{t.removeClass("mCS_no_scrollbar")}},_coordinates:function(q){var p=q.type;switch(p){case"pointerdown":case"MSPointerDown":case"pointermove":case"MSPointerMove":case"pointerup":case"MSPointerUp":return[q.originalEvent.pageY,q.originalEvent.pageX];break;case"touchstart":case"touchmove":case"touchend":var r=q.originalEvent.touches[0]||q.originalEvent.changedTouches[0];return[r.pageY,r.pageX];break;default:return[q.pageY,q.pageX]}},_draggable:function(){var u=j(this),s=u.data(d),p=s.opt,r=d+"_"+s.idx,t=["mCSB_"+s.idx+"_dragger_vertical","mCSB_"+s.idx+"_dragger_horizontal"],v=j("#mCSB_"+s.idx+"_container"),w=j("#"+t[0]+",#"+t[1]),A,y,z;w.bind("mousedown."+r+" touchstart."+r+" pointerdown."+r+" MSPointerDown."+r,function(E){E.stopImmediatePropagation();E.preventDefault();if(!i._mouseBtnLeft(E)){return}n=true;if(k){a.onselectstart=function(){return false}}x(false);i._stop(u);A=j(this);var F=A.offset(),G=i._coordinates(E)[0]-F.top,B=i._coordinates(E)[1]-F.left,D=A.height()+F.top,C=A.width()+F.left;if(G<D&&G>0&&B<C&&B>0){y=G;z=B}i._onDragClasses(A,"active",p.autoExpandScrollbar)}).bind("touchmove."+r,function(C){C.stopImmediatePropagation();C.preventDefault();var D=A.offset(),E=i._coordinates(C)[0]-D.top,B=i._coordinates(C)[1]-D.left;q(y,z,E,B)});j(a).bind("mousemove."+r+" pointermove."+r+" MSPointerMove."+r,function(C){if(A){var D=A.offset(),E=i._coordinates(C)[0]-D.top,B=i._coordinates(C)[1]-D.left;if(y===E){return}q(y,z,E,B)}}).add(w).bind("mouseup."+r+" touchend."+r+" pointerup."+r+" MSPointerUp."+r,function(B){if(A){i._onDragClasses(A,"active",p.autoExpandScrollbar);A=null}n=false;if(k){a.onselectstart=null}x(true)});function x(B){var C=v.find("iframe");if(!C.length){return}var D=!B?"none":"auto";C.css("pointer-events",D)}function q(D,E,G,B){v[0].idleTimer=p.scrollInertia<233?250:0;if(A.attr("id")===t[1]){var C="x",F=((A[0].offsetLeft-E)+B)*s.scrollRatio.x}else{var C="y",F=((A[0].offsetTop-D)+G)*s.scrollRatio.y}i._scrollTo(u,F.toString(),{dir:C,drag:true})}},_contentDraggable:function(){var y=j(this),K=y.data(d),I=K.opt,F=d+"_"+K.idx,v=j("#mCSB_"+K.idx),z=j("#mCSB_"+K.idx+"_container"),w=[j("#mCSB_"+K.idx+"_dragger_vertical"),j("#mCSB_"+K.idx+"_dragger_horizontal")],E,G,L,M,C=[],D=[],H,A,u,t,J,x,r=0,q,s=I.axis==="yx"?"none":"all";z.bind("touchstart."+F+" pointerdown."+F+" MSPointerDown."+F,function(N){if(!i._pointerTouch(N)||n){return}var O=z.offset();E=i._coordinates(N)[0]-O.top;G=i._coordinates(N)[1]-O.left}).bind("touchmove."+F+" pointermove."+F+" MSPointerMove."+F,function(Q){if(!i._pointerTouch(Q)||n){return}Q.stopImmediatePropagation();A=i._getTime();var P=v.offset(),S=i._coordinates(Q)[0]-P.top,U=i._coordinates(Q)[1]-P.left,R="mcsLinearOut";C.push(S);D.push(U);if(K.overflowed[0]){var O=w[0].parent().height()-w[0].height(),T=((E-S)>0&&(S-E)>-(O*K.scrollRatio.y))}if(K.overflowed[1]){var N=w[1].parent().width()-w[1].width(),V=((G-U)>0&&(U-G)>-(N*K.scrollRatio.x))}if(T||V){Q.preventDefault()}x=I.axis==="yx"?[(E-S),(G-U)]:I.axis==="x"?[null,(G-U)]:[(E-S),null];z[0].idleTimer=250;if(K.overflowed[0]){B(x[0],r,R,"y","all",true)}if(K.overflowed[1]){B(x[1],r,R,"x",s,true)}});v.bind("touchstart."+F+" pointerdown."+F+" MSPointerDown."+F,function(N){if(!i._pointerTouch(N)||n){return}N.stopImmediatePropagation();i._stop(y);H=i._getTime();var O=v.offset();L=i._coordinates(N)[0]-O.top;M=i._coordinates(N)[1]-O.left;C=[];D=[]}).bind("touchend."+F+" pointerup."+F+" MSPointerUp."+F,function(P){if(!i._pointerTouch(P)||n){return}P.stopImmediatePropagation();u=i._getTime();var N=v.offset(),T=i._coordinates(P)[0]-N.top,V=i._coordinates(P)[1]-N.left;if((u-A)>30){return}J=1000/(u-H);var Q="mcsEaseOut",R=J<2.5,W=R?[C[C.length-2],D[D.length-2]]:[0,0];t=R?[(T-W[0]),(V-W[1])]:[T-L,V-M];var O=[Math.abs(t[0]),Math.abs(t[1])];J=R?[Math.abs(t[0]/4),Math.abs(t[1]/4)]:[J,J];var U=[Math.abs(z[0].offsetTop)-(t[0]*p((O[0]/J[0]),J[0])),Math.abs(z[0].offsetLeft)-(t[1]*p((O[1]/J[1]),J[1]))];x=I.axis==="yx"?[U[0],U[1]]:I.axis==="x"?[null,U[1]]:[U[0],null];q=[(O[0]*4)+I.scrollInertia,(O[1]*4)+I.scrollInertia];var S=parseInt(I.contentTouchScroll)||0;x[0]=O[0]>S?x[0]:0;x[1]=O[1]>S?x[1]:0;if(K.overflowed[0]){B(x[0],q[0],Q,"y",s,false)}if(K.overflowed[1]){B(x[1],q[1],Q,"x",s,false)}});function p(P,N){var O=[N*1.5,N*2,N/1.5,N/2];if(P>90){return N>4?O[0]:O[3]}else{if(P>60){return N>3?O[3]:O[2]}else{if(P>30){return N>8?O[1]:N>6?O[0]:N>4?N:O[2]}else{return N>8?N:O[3]}}}}function B(P,R,S,O,N,Q){if(!P){return}i._scrollTo(y,P.toString(),{dur:R,scrollEasing:S,dir:O,overwrite:N,drag:Q})}},_mousewheel:function(){var w=j(this),v=w.data(d);if(v){var p=v.opt,s=d+"_"+v.idx,q=j("#mCSB_"+v.idx),x=[j("#mCSB_"+v.idx+"_dragger_vertical"),j("#mCSB_"+v.idx+"_dragger_horizontal")],t=j("#mCSB_"+v.idx+"_container").find("iframe"),r=q;if(t.length){t.each(function(){var y=this;if(u(y)){r=r.add(j(y).contents().find("body"))}})}r.bind("mousewheel."+s,function(C,G){i._stop(w);if(i._disableMousewheel(w,C.target)){return}var E=p.mouseWheel.deltaFactor!=="auto"?parseInt(p.mouseWheel.deltaFactor):(k&&C.deltaFactor<100)?100:C.deltaFactor||100;if(p.axis==="x"||p.mouseWheel.axis==="x"){var z="x",F=[Math.round(E*v.scrollRatio.x),parseInt(p.mouseWheel.scrollAmount)],B=p.mouseWheel.scrollAmount!=="auto"?F[1]:F[0]>=q.width()?q.width()*0.9:F[0],H=Math.abs(j("#mCSB_"+v.idx+"_container")[0].offsetLeft),D=x[1][0].offsetLeft,A=x[1].parent().width()-x[1].width(),y=C.deltaX||C.deltaY||G}else{var z="y",F=[Math.round(E*v.scrollRatio.y),parseInt(p.mouseWheel.scrollAmount)],B=p.mouseWheel.scrollAmount!=="auto"?F[1]:F[0]>=q.height()?q.height()*0.9:F[0],H=Math.abs(j("#mCSB_"+v.idx+"_container")[0].offsetTop),D=x[0][0].offsetTop,A=x[0].parent().height()-x[0].height(),y=C.deltaY||G}if((z==="y"&&!v.overflowed[0])||(z==="x"&&!v.overflowed[1])){return}if(p.mouseWheel.invert){y=-y}if(p.mouseWheel.normalizeDelta){y=y<0?-1:1}if((y>0&&D!==0)||(y<0&&D!==A)||p.mouseWheel.preventDefault){C.stopImmediatePropagation();C.preventDefault()}i._scrollTo(w,(H-(y*B)).toString(),{dir:z})})}function u(z){var y=null;try{var B=z.contentDocument||z.contentWindow.document;y=B.body.innerHTML}catch(A){}return(y!==null)}},_disableMousewheel:function(r,t){var p=t.nodeName.toLowerCase(),q=r.data(d).opt.mouseWheel.disableOver,s=["select","textarea"];return j.inArray(p,q)>-1&&!(j.inArray(p,s)>-1&&!j(t).is(":focus"))},_draggerRail:function(){var s=j(this),t=s.data(d),q=d+"_"+t.idx,r=j("#mCSB_"+t.idx+"_container"),u=r.parent(),p=j(".mCSB_"+t.idx+"_scrollbar .mCSB_draggerContainer");p.bind("touchstart."+q+" pointerdown."+q+" MSPointerDown."+q,function(v){n=true}).bind("touchend."+q+" pointerup."+q+" MSPointerUp."+q,function(v){n=false}).bind("click."+q,function(z){if(j(z.target).hasClass("mCSB_draggerContainer")||j(z.target).hasClass("mCSB_draggerRail")){i._stop(s);var w=j(this),y=w.find(".mCSB_dragger");if(w.parent(".mCSB_scrollTools_horizontal").length>0){if(!t.overflowed[1]){return}var v="x",x=z.pageX>y.offset().left?-1:1,A=Math.abs(r[0].offsetLeft)-(x*(u.width()*0.9))}else{if(!t.overflowed[0]){return}var v="y",x=z.pageY>y.offset().top?-1:1,A=Math.abs(r[0].offsetTop)-(x*(u.height()*0.9))}i._scrollTo(s,A.toString(),{dir:v,scrollEasing:"mcsEaseInOut"})}})},_focus:function(){var r=j(this),t=r.data(d),s=t.opt,p=d+"_"+t.idx,q=j("#mCSB_"+t.idx+"_container"),u=q.parent();q.bind("focusin."+p,function(x){var w=j(a.activeElement),y=q.find(".mCustomScrollBox").length,v=0;if(!w.is(s.advanced.autoScrollOnFocus)){return}i._stop(r);clearTimeout(r[0]._focusTimeout);r[0]._focusTimer=y?(v+17)*y:0;r[0]._focusTimeout=setTimeout(function(){var C=[w.offset().top-q.offset().top,w.offset().left-q.offset().left],B=[q[0].offsetTop,q[0].offsetLeft],z=[(B[0]+C[0]>=0&&B[0]+C[0]<u.height()-w.outerHeight(false)),(B[1]+C[1]>=0&&B[0]+C[1]<u.width()-w.outerWidth(false))],A=(s.axis==="yx"&&!z[0]&&!z[1])?"none":"all";if(s.axis!=="x"&&!z[0]){i._scrollTo(r,C[0].toString(),{dir:"y",scrollEasing:"mcsEaseInOut",overwrite:A,dur:v})}if(s.axis!=="y"&&!z[1]){i._scrollTo(r,C[1].toString(),{dir:"x",scrollEasing:"mcsEaseInOut",overwrite:A,dur:v})}},r[0]._focusTimer)})},_wrapperScroll:function(){var q=j(this),r=q.data(d),p=d+"_"+r.idx,s=j("#mCSB_"+r.idx+"_container").parent();s.bind("scroll."+p,function(t){s.scrollTop(0).scrollLeft(0)})},_buttons:function(){var u=j(this),w=u.data(d),v=w.opt,p=w.sequential,r=d+"_"+w.idx,t=j("#mCSB_"+w.idx+"_container"),s=".mCSB_"+w.idx+"_scrollbar",q=j(s+">a");q.bind("mousedown."+r+" touchstart."+r+" pointerdown."+r+" MSPointerDown."+r+" mouseup."+r+" touchend."+r+" pointerup."+r+" MSPointerUp."+r+" mouseout."+r+" pointerout."+r+" MSPointerOut."+r+" click."+r,function(z){z.preventDefault();if(!i._mouseBtnLeft(z)){return}var y=j(this).attr("class");p.type=v.scrollButtons.scrollType;switch(z.type){case"mousedown":case"touchstart":case"pointerdown":case"MSPointerDown":if(p.type==="stepped"){return}n=true;w.tweenRunning=false;x("on",y);break;case"mouseup":case"touchend":case"pointerup":case"MSPointerUp":case"mouseout":case"pointerout":case"MSPointerOut":if(p.type==="stepped"){return}n=false;if(p.dir){x("off",y)}break;case"click":if(p.type!=="stepped"||w.tweenRunning){return}x("on",y);break}function x(A,B){p.scrollAmount=v.snapAmount||v.scrollButtons.scrollAmount;i._sequentialScroll.call(this,u,A,B)}})},_keyboard:function(){var u=j(this),t=u.data(d),q=t.opt,x=t.sequential,s=d+"_"+t.idx,r=j("#mCSB_"+t.idx),w=j("#mCSB_"+t.idx+"_container"),p=w.parent(),v="input,textarea,select,datalist,keygen,[contenteditable='true']";r.attr("tabindex","0").bind("blur."+s+" keydown."+s+" keyup."+s,function(D){switch(D.type){case"blur":if(t.tweenRunning&&x.dir){y("off",null)}break;case"keydown":case"keyup":var A=D.keyCode?D.keyCode:D.which,B="on";if((q.axis!=="x"&&(A===38||A===40))||(q.axis!=="y"&&(A===37||A===39))){if(((A===38||A===40)&&!t.overflowed[0])||((A===37||A===39)&&!t.overflowed[1])){return}if(D.type==="keyup"){B="off"}if(!j(a.activeElement).is(v)){D.preventDefault();D.stopImmediatePropagation();y(B,A)}}else{if(A===33||A===34){if(t.overflowed[0]||t.overflowed[1]){D.preventDefault();D.stopImmediatePropagation()}if(D.type==="keyup"){i._stop(u);var C=A===34?-1:1;if(q.axis==="x"||(q.axis==="yx"&&t.overflowed[1]&&!t.overflowed[0])){var z="x",E=Math.abs(w[0].offsetLeft)-(C*(p.width()*0.9))}else{var z="y",E=Math.abs(w[0].offsetTop)-(C*(p.height()*0.9))}i._scrollTo(u,E.toString(),{dir:z,scrollEasing:"mcsEaseInOut"})}}else{if(A===35||A===36){if(!j(a.activeElement).is(v)){if(t.overflowed[0]||t.overflowed[1]){D.preventDefault();D.stopImmediatePropagation()}if(D.type==="keyup"){if(q.axis==="x"||(q.axis==="yx"&&t.overflowed[1]&&!t.overflowed[0])){var z="x",E=A===35?Math.abs(p.width()-w.outerWidth(false)):0}else{var z="y",E=A===35?Math.abs(p.height()-w.outerHeight(false)):0}i._scrollTo(u,E.toString(),{dir:z,scrollEasing:"mcsEaseInOut"})}}}}}break}function y(F,G){x.type=q.keyboard.scrollType;x.scrollAmount=q.snapAmount||q.keyboard.scrollAmount;if(x.type==="stepped"&&t.tweenRunning){return}i._sequentialScroll.call(this,u,F,G)}})},_sequentialScroll:function(r,u,s){var w=r.data(d),q=w.opt,y=w.sequential,x=j("#mCSB_"+w.idx+"_container"),p=y.type==="stepped"?true:false;switch(u){case"on":y.dir=[(s==="mCSB_buttonRight"||s==="mCSB_buttonLeft"||s===39||s===37?"x":"y"),(s==="mCSB_buttonUp"||s==="mCSB_buttonLeft"||s===38||s===37?-1:1)];i._stop(r);if(i._isNumeric(s)&&y.type==="stepped"){return}t(p);break;case"off":v();if(p||(w.tweenRunning&&y.dir)){t(true)}break}function t(z){var F=y.type!=="stepped",J=!z?1000/60:F?q.scrollInertia/1.5:q.scrollInertia,B=!z?2.5:F?7.5:40,I=[Math.abs(x[0].offsetTop),Math.abs(x[0].offsetLeft)],E=[w.scrollRatio.y>10?10:w.scrollRatio.y,w.scrollRatio.x>10?10:w.scrollRatio.x],C=y.dir[0]==="x"?I[1]+(y.dir[1]*(E[1]*B)):I[0]+(y.dir[1]*(E[0]*B)),H=y.dir[0]==="x"?I[1]+(y.dir[1]*parseInt(y.scrollAmount)):I[0]+(y.dir[1]*parseInt(y.scrollAmount)),G=y.scrollAmount!=="auto"?H:C,D=!z?"mcsLinear":F?"mcsLinearOut":"mcsEaseInOut",A=!z?false:true;if(z&&J<17){G=y.dir[0]==="x"?I[1]:I[0]}i._scrollTo(r,G.toString(),{dir:y.dir[0],scrollEasing:D,dur:J,onComplete:A});if(z){y.dir=false;return}clearTimeout(y.step);y.step=setTimeout(function(){t()},J)}function v(){clearTimeout(y.step);i._stop(r)}},_arr:function(r){var q=j(this).data(d).opt,p=[];if(typeof r==="function"){r=r()}if(!(r instanceof Array)){p[0]=r.y?r.y:r.x||q.axis==="x"?null:r;p[1]=r.x?r.x:r.y||q.axis==="y"?null:r}else{p=r.length>1?[r[0],r[1]]:q.axis==="x"?[null,r[0]]:[r[0],null]}if(typeof p[0]==="function"){p[0]=p[0]()}if(typeof p[1]==="function"){p[1]=p[1]()}return p},_to:function(v,w){if(v==null||typeof v=="undefined"){return}var C=j(this),B=C.data(d),u=B.opt,D=j("#mCSB_"+B.idx+"_container"),r=D.parent(),F=typeof v;if(!w){w=u.axis==="x"?"x":"y"}var q=w==="x"?D.outerWidth(false):D.outerHeight(false),x=w==="x"?D.offset().left:D.offset().top,E=w==="x"?D[0].offsetLeft:D[0].offsetTop,z=w==="x"?"left":"top";switch(F){case"function":return v();break;case"object":if(v.nodeType){var A=w==="x"?j(v).offset().left:j(v).offset().top}else{if(v.jquery){if(!v.length){return}var A=w==="x"?v.offset().left:v.offset().top}}return A-x;break;case"string":case"number":if(i._isNumeric.call(null,v)){return Math.abs(v)}else{if(v.indexOf("%")!==-1){return Math.abs(q*parseInt(v)/100)}else{if(v.indexOf("-=")!==-1){return Math.abs(E-parseInt(v.split("-=")[1]))}else{if(v.indexOf("+=")!==-1){var s=(E+parseInt(v.split("+=")[1]));return s>=0?0:Math.abs(s)}else{if(v.indexOf("px")!==-1&&i._isNumeric.call(null,v.split("px")[0])){return Math.abs(v.split("px")[0])}else{if(v==="top"||v==="left"){return 0}else{if(v==="bottom"){return Math.abs(r.height()-D.outerHeight(false))}else{if(v==="right"){return Math.abs(r.width()-D.outerWidth(false))}else{if(v==="first"||v==="last"){var y=D.find(":"+v),A=w==="x"?j(y).offset().left:j(y).offset().top;return A-x}else{if(j(v).length){var A=w==="x"?j(v).offset().left:j(v).offset().top;return A-x}else{D.css(z,v);e.update.call(null,C[0]);return}}}}}}}}}}break}},_autoUpdate:function(q){var t=j(this),F=t.data(d),z=F.opt,v=j("#mCSB_"+F.idx+"_container");if(q){clearTimeout(v[0].autoUpdate);i._delete.call(null,v[0].autoUpdate);return}var s=v.parent(),p=[j("#mCSB_"+F.idx+"_scrollbar_vertical"),j("#mCSB_"+F.idx+"_scrollbar_horizontal")],D=function(){return[p[0].is(":visible")?p[0].outerHeight(true):0,p[1].is(":visible")?p[1].outerWidth(true):0]},E=y(),x,u=[v.outerHeight(false),v.outerWidth(false),s.height(),s.width(),D()[0],D()[1]],H,B=G(),w;C();function C(){clearTimeout(v[0].autoUpdate);v[0].autoUpdate=setTimeout(function(){if(z.advanced.updateOnSelectorChange){x=y();if(x!==E){r();E=x;return}}if(z.advanced.updateOnContentResize){H=[v.outerHeight(false),v.outerWidth(false),s.height(),s.width(),D()[0],D()[1]];if(H[0]!==u[0]||H[1]!==u[1]||H[2]!==u[2]||H[3]!==u[3]||H[4]!==u[4]||H[5]!==u[5]){r();u=H}}if(z.advanced.updateOnImageLoad){w=G();if(w!==B){v.find("img").each(function(){A(this.src)});B=w}}if(z.advanced.updateOnSelectorChange||z.advanced.updateOnContentResize||z.advanced.updateOnImageLoad){C()}},60)}function G(){var I=0;if(z.advanced.updateOnImageLoad){I=v.find("img").length}return I}function A(L){var I=new Image();function K(M,N){return function(){return N.apply(M,arguments)}}function J(){this.onload=null;r()}I.onload=K(I,J);I.src=L}function y(){if(z.advanced.updateOnSelectorChange===true){z.advanced.updateOnSelectorChange="*"}var I=0,J=v.find(z.advanced.updateOnSelectorChange);if(z.advanced.updateOnSelectorChange&&J.length>0){J.each(function(){I+=j(this).height()+j(this).width()})}return I}function r(){clearTimeout(v[0].autoUpdate);e.update.call(null,t[0])}},_snapAmount:function(r,p,q){return(Math.round(r/p)*p-q)},_stop:function(p){var r=p.data(d),q=j("#mCSB_"+r.idx+"_container,#mCSB_"+r.idx+"_container_wrapper,#mCSB_"+r.idx+"_dragger_vertical,#mCSB_"+r.idx+"_dragger_horizontal");q.each(function(){i._stopTween.call(this)})},_scrollTo:function(q,s,u){var I=q.data(d),E=I.opt,D={trigger:"internal",dir:"y",scrollEasing:"mcsEaseOut",drag:false,dur:E.scrollInertia,overwrite:"all",callbacks:true,onStart:true,onUpdate:true,onComplete:true},u=j.extend(D,u),G=[u.dur,(u.drag?0:u.dur)],v=j("#mCSB_"+I.idx),B=j("#mCSB_"+I.idx+"_container"),K=E.callbacks.onTotalScrollOffset?i._arr.call(q,E.callbacks.onTotalScrollOffset):[0,0],p=E.callbacks.onTotalScrollBackOffset?i._arr.call(q,E.callbacks.onTotalScrollBackOffset):[0,0];I.trigger=u.trigger;if(s==="_resetY"&&!I.contentReset.y){if(t("onOverflowYNone")){E.callbacks.onOverflowYNone.call(q[0])}I.contentReset.y=1}if(s==="_resetX"&&!I.contentReset.x){if(t("onOverflowXNone")){E.callbacks.onOverflowXNone.call(q[0])}I.contentReset.x=1}if(s==="_resetY"||s==="_resetX"){return}if((I.contentReset.y||!q[0].mcs)&&I.overflowed[0]){if(t("onOverflowY")){E.callbacks.onOverflowY.call(q[0])}I.contentReset.x=null}if((I.contentReset.x||!q[0].mcs)&&I.overflowed[1]){if(t("onOverflowX")){E.callbacks.onOverflowX.call(q[0])}I.contentReset.x=null}if(E.snapAmount){s=i._snapAmount(s,E.snapAmount,E.snapOffset)}switch(u.dir){case"x":var x=j("#mCSB_"+I.idx+"_dragger_horizontal"),z="left",C=B[0].offsetLeft,H=[v.width()-B.outerWidth(false),x.parent().width()-x.width()],r=[s,s===0?0:(s/I.scrollRatio.x)],L=K[1],J=p[1],A=L>0?L/I.scrollRatio.x:0,w=J>0?J/I.scrollRatio.x:0;break;case"y":var x=j("#mCSB_"+I.idx+"_dragger_vertical"),z="top",C=B[0].offsetTop,H=[v.height()-B.outerHeight(false),x.parent().height()-x.height()],r=[s,s===0?0:(s/I.scrollRatio.y)],L=K[0],J=p[0],A=L>0?L/I.scrollRatio.y:0,w=J>0?J/I.scrollRatio.y:0;break}if(r[1]<0||(r[0]===0&&r[1]===0)){r=[0,0]}else{if(r[1]>=H[1]){r=[H[0],H[1]]}else{r[0]=-r[0]}}if(!q[0].mcs){F()}clearTimeout(B[0].onCompleteTimeout);if(!I.tweenRunning&&((C===0&&r[0]>=0)||(C===H[0]&&r[0]<=H[0]))){return}i._tweenTo.call(null,x[0],z,Math.round(r[1]),G[1],u.scrollEasing);i._tweenTo.call(null,B[0],z,Math.round(r[0]),G[0],u.scrollEasing,u.overwrite,{onStart:function(){if(u.callbacks&&u.onStart&&!I.tweenRunning){if(t("onScrollStart")){F();E.callbacks.onScrollStart.call(q[0])}I.tweenRunning=true;i._onDragClasses(x);I.cbOffsets=y()}},onUpdate:function(){if(u.callbacks&&u.onUpdate){if(t("whileScrolling")){F();E.callbacks.whileScrolling.call(q[0])}}},onComplete:function(){if(u.callbacks&&u.onComplete){if(E.axis==="yx"){clearTimeout(B[0].onCompleteTimeout)}var M=B[0].idleTimer||0;B[0].onCompleteTimeout=setTimeout(function(){if(t("onScroll")){F();E.callbacks.onScroll.call(q[0])}if(t("onTotalScroll")&&r[1]>=H[1]-A&&I.cbOffsets[0]){F();E.callbacks.onTotalScroll.call(q[0])}if(t("onTotalScrollBack")&&r[1]<=w&&I.cbOffsets[1]){F();E.callbacks.onTotalScrollBack.call(q[0])}I.tweenRunning=false;B[0].idleTimer=0;i._onDragClasses(x,"hide")},M)}}});function t(M){return I&&E.callbacks[M]&&typeof E.callbacks[M]==="function"}function y(){return[E.callbacks.alwaysTriggerOffsets||C>=H[0]+L,E.callbacks.alwaysTriggerOffsets||C<=-J]}function F(){var O=[B[0].offsetTop,B[0].offsetLeft],P=[x[0].offsetTop,x[0].offsetLeft],M=[B.outerHeight(false),B.outerWidth(false)],N=[v.height(),v.width()];q[0].mcs={content:B,top:O[0],left:O[1],draggerTop:P[0],draggerLeft:P[1],topPct:Math.round((100*Math.abs(O[0]))/(Math.abs(M[0])-N[0])),leftPct:Math.round((100*Math.abs(O[1]))/(Math.abs(M[1])-N[1])),direction:u.dir}}},_tweenTo:function(r,u,s,q,B,t,K){var K=K||{},H=K.onStart||function(){},C=K.onUpdate||function(){},I=K.onComplete||function(){},z=i._getTime(),x,v=0,E=r.offsetTop,F=r.style,A;if(u==="left"){E=r.offsetLeft}var y=s-E;r._mcsstop=0;if(t!=="none"){D()}p();function J(){if(r._mcsstop){return}if(!v){H.call()}v=i._getTime()-z;G();if(v>=r._mcstime){r._mcstime=(v>r._mcstime)?v+x-(v-r._mcstime):v+x-1;if(r._mcstime<v+1){r._mcstime=v+1}}if(r._mcstime<q){r._mcsid=A(J)}else{I.call()}}function G(){if(q>0){r._mcscurrVal=w(r._mcstime,E,y,q,B);F[u]=Math.round(r._mcscurrVal)+"px"}else{F[u]=s+"px"}C.call()}function p(){x=1000/60;r._mcstime=v+x;A=(!b.requestAnimationFrame)?function(L){G();return setTimeout(L,0.01)}:b.requestAnimationFrame;r._mcsid=A(J)}function D(){if(r._mcsid==null){return}if(!b.requestAnimationFrame){clearTimeout(r._mcsid)}else{b.cancelAnimationFrame(r._mcsid)}r._mcsid=null}function w(N,M,R,Q,O){switch(O){case"linear":case"mcsLinear":return R*N/Q+M;break;case"mcsLinearOut":N/=Q;N--;return R*Math.sqrt(1-N*N)+M;break;case"easeInOutSmooth":N/=Q/2;if(N<1){return R/2*N*N+M}N--;return -R/2*(N*(N-2)-1)+M;break;case"easeInOutStrong":N/=Q/2;if(N<1){return R/2*Math.pow(2,10*(N-1))+M}N--;return R/2*(-Math.pow(2,-10*N)+2)+M;break;case"easeInOut":case"mcsEaseInOut":N/=Q/2;if(N<1){return R/2*N*N*N+M}N-=2;return R/2*(N*N*N+2)+M;break;case"easeOutSmooth":N/=Q;N--;return -R*(N*N*N*N-1)+M;break;case"easeOutStrong":return R*(-Math.pow(2,-10*N/Q)+1)+M;break;case"easeOut":case"mcsEaseOut":default:var P=(N/=Q)*N,L=P*N;return M+R*(0.499999999999997*L*P+-2.5*P*P+5.5*L+-6.5*P+4*N)}}},_getTime:function(){if(b.performance&&b.performance.now){return b.performance.now()}else{if(b.performance&&b.performance.webkitNow){return b.performance.webkitNow()}else{if(Date.now){return Date.now()}else{return new Date().getTime()}}}},_stopTween:function(){var p=this;if(p._mcsid==null){return}if(!b.requestAnimationFrame){clearTimeout(p._mcsid)}else{b.cancelAnimationFrame(p._mcsid)}p._mcsid=null;p._mcsstop=1},_delete:function(r){try{delete r}catch(q){r=null}},_mouseBtnLeft:function(p){return !(p.which&&p.which!==1)},_pointerTouch:function(q){var p=q.originalEvent.pointerType;return !(p&&p!=="touch"&&p!==2)},_isNumeric:function(p){return !isNaN(parseFloat(p))&&isFinite(p)}};j.fn[g]=function(p){if(e[p]){return e[p].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof p==="object"||!p){return e.init.apply(this,arguments)}else{j.error("Method "+p+" does not exist")}}};j[g]=function(p){if(e[p]){return e[p].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof p==="object"||!p){return e.init.apply(this,arguments)}else{j.error("Method "+p+" does not exist")}}};j[g].defaults=h;b[g]=true;j(b).load(function(){j(m)[g]()})}))}(window,document));}

/*!
 * Isotope PACKAGED v3.0.6
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * https://isotope.metafizzy.co
 * Copyright 2010-2018 Metafizzy
 */
!function(t,e){"function"==typeof define&&define.amd?define("jquery-bridget/jquery-bridget",["jquery"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("jquery")):t.jQueryBridget=e(t,t.jQuery)}(window,function(t,e){"use strict";function i(i,s,a){function u(t,e,o){var n,s="$()."+i+'("'+e+'")';return t.each(function(t,u){var h=a.data(u,i);if(!h)return void r(i+" not initialized. Cannot call methods, i.e. "+s);var d=h[e];if(!d||"_"==e.charAt(0))return void r(s+" is not a valid method");var l=d.apply(h,o);n=void 0===n?l:n}),void 0!==n?n:t}function h(t,e){t.each(function(t,o){var n=a.data(o,i);n?(n.option(e),n._init()):(n=new s(o,e),a.data(o,i,n))})}a=a||e||t.jQuery,a&&(s.prototype.option||(s.prototype.option=function(t){a.isPlainObject(t)&&(this.options=a.extend(!0,this.options,t))}),a.fn[i]=function(t){if("string"==typeof t){var e=n.call(arguments,1);return u(this,t,e)}return h(this,t),this},o(a))}function o(t){!t||t&&t.bridget||(t.bridget=i)}var n=Array.prototype.slice,s=t.console,r="undefined"==typeof s?function(){}:function(t){s.error(t)};return o(e||t.jQuery),i}),function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}("undefined"!=typeof window?window:this,function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},o=i[t]=i[t]||[];return o.indexOf(e)==-1&&o.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{},o=i[t]=i[t]||{};return o[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var o=i.indexOf(e);return o!=-1&&i.splice(o,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){i=i.slice(0),e=e||[];for(var o=this._onceEvents&&this._onceEvents[t],n=0;n<i.length;n++){var s=i[n],r=o&&o[s];r&&(this.off(t,s),delete o[s]),s.apply(this,e)}return this}},e.allOff=function(){delete this._events,delete this._onceEvents},t}),function(t,e){"function"==typeof define&&define.amd?define("get-size/get-size",e):"object"==typeof module&&module.exports?module.exports=e():t.getSize=e()}(window,function(){"use strict";function t(t){var e=parseFloat(t),i=t.indexOf("%")==-1&&!isNaN(e);return i&&e}function e(){}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0;e<h;e++){var i=u[e];t[i]=0}return t}function o(t){var e=getComputedStyle(t);return e||a("Style returned "+e+". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"),e}function n(){if(!d){d=!0;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style.boxSizing="border-box";var i=document.body||document.documentElement;i.appendChild(e);var n=o(e);r=200==Math.round(t(n.width)),s.isBoxSizeOuter=r,i.removeChild(e)}}function s(e){if(n(),"string"==typeof e&&(e=document.querySelector(e)),e&&"object"==typeof e&&e.nodeType){var s=o(e);if("none"==s.display)return i();var a={};a.width=e.offsetWidth,a.height=e.offsetHeight;for(var d=a.isBorderBox="border-box"==s.boxSizing,l=0;l<h;l++){var f=u[l],c=s[f],m=parseFloat(c);a[f]=isNaN(m)?0:m}var p=a.paddingLeft+a.paddingRight,y=a.paddingTop+a.paddingBottom,g=a.marginLeft+a.marginRight,v=a.marginTop+a.marginBottom,_=a.borderLeftWidth+a.borderRightWidth,z=a.borderTopWidth+a.borderBottomWidth,I=d&&r,x=t(s.width);x!==!1&&(a.width=x+(I?0:p+_));var S=t(s.height);return S!==!1&&(a.height=S+(I?0:y+z)),a.innerWidth=a.width-(p+_),a.innerHeight=a.height-(y+z),a.outerWidth=a.width+g,a.outerHeight=a.height+v,a}}var r,a="undefined"==typeof console?e:function(t){console.error(t)},u=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"],h=u.length,d=!1;return s}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("desandro-matches-selector/matches-selector",e):"object"==typeof module&&module.exports?module.exports=e():t.matchesSelector=e()}(window,function(){"use strict";var t=function(){var t=window.Element.prototype;if(t.matches)return"matches";if(t.matchesSelector)return"matchesSelector";for(var e=["webkit","moz","ms","o"],i=0;i<e.length;i++){var o=e[i],n=o+"MatchesSelector";if(t[n])return n}}();return function(e,i){return e[t](i)}}),function(t,e){"function"==typeof define&&define.amd?define("fizzy-ui-utils/utils",["desandro-matches-selector/matches-selector"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("desandro-matches-selector")):t.fizzyUIUtils=e(t,t.matchesSelector)}(window,function(t,e){var i={};i.extend=function(t,e){for(var i in e)t[i]=e[i];return t},i.modulo=function(t,e){return(t%e+e)%e};var o=Array.prototype.slice;i.makeArray=function(t){if(Array.isArray(t))return t;if(null===t||void 0===t)return[];var e="object"==typeof t&&"number"==typeof t.length;return e?o.call(t):[t]},i.removeFrom=function(t,e){var i=t.indexOf(e);i!=-1&&t.splice(i,1)},i.getParent=function(t,i){for(;t.parentNode&&t!=document.body;)if(t=t.parentNode,e(t,i))return t},i.getQueryElement=function(t){return"string"==typeof t?document.querySelector(t):t},i.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},i.filterFindElements=function(t,o){t=i.makeArray(t);var n=[];return t.forEach(function(t){if(t instanceof HTMLElement){if(!o)return void n.push(t);e(t,o)&&n.push(t);for(var i=t.querySelectorAll(o),s=0;s<i.length;s++)n.push(i[s])}}),n},i.debounceMethod=function(t,e,i){i=i||100;var o=t.prototype[e],n=e+"Timeout";t.prototype[e]=function(){var t=this[n];clearTimeout(t);var e=arguments,s=this;this[n]=setTimeout(function(){o.apply(s,e),delete s[n]},i)}},i.docReady=function(t){var e=document.readyState;"complete"==e||"interactive"==e?setTimeout(t):document.addEventListener("DOMContentLoaded",t)},i.toDashed=function(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()};var n=t.console;return i.htmlInit=function(e,o){i.docReady(function(){var s=i.toDashed(o),r="data-"+s,a=document.querySelectorAll("["+r+"]"),u=document.querySelectorAll(".js-"+s),h=i.makeArray(a).concat(i.makeArray(u)),d=r+"-options",l=t.jQuery;h.forEach(function(t){var i,s=t.getAttribute(r)||t.getAttribute(d);try{i=s&&JSON.parse(s)}catch(a){return void(n&&n.error("Error parsing "+r+" on "+t.className+": "+a))}var u=new e(t,i);l&&l.data(t,o,u)})})},i}),function(t,e){"function"==typeof define&&define.amd?define("outlayer/item",["ev-emitter/ev-emitter","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("ev-emitter"),require("get-size")):(t.Outlayer={},t.Outlayer.Item=e(t.EvEmitter,t.getSize))}(window,function(t,e){"use strict";function i(t){for(var e in t)return!1;return e=null,!0}function o(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}function n(t){return t.replace(/([A-Z])/g,function(t){return"-"+t.toLowerCase()})}var s=document.documentElement.style,r="string"==typeof s.transition?"transition":"WebkitTransition",a="string"==typeof s.transform?"transform":"WebkitTransform",u={WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[r],h={transform:a,transition:r,transitionDuration:r+"Duration",transitionProperty:r+"Property",transitionDelay:r+"Delay"},d=o.prototype=Object.create(t.prototype);d.constructor=o,d._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},d.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},d.getSize=function(){this.size=e(this.element)},d.css=function(t){var e=this.element.style;for(var i in t){var o=h[i]||i;e[o]=t[i]}},d.getPosition=function(){var t=getComputedStyle(this.element),e=this.layout._getOption("originLeft"),i=this.layout._getOption("originTop"),o=t[e?"left":"right"],n=t[i?"top":"bottom"],s=parseFloat(o),r=parseFloat(n),a=this.layout.size;o.indexOf("%")!=-1&&(s=s/100*a.width),n.indexOf("%")!=-1&&(r=r/100*a.height),s=isNaN(s)?0:s,r=isNaN(r)?0:r,s-=e?a.paddingLeft:a.paddingRight,r-=i?a.paddingTop:a.paddingBottom,this.position.x=s,this.position.y=r},d.layoutPosition=function(){var t=this.layout.size,e={},i=this.layout._getOption("originLeft"),o=this.layout._getOption("originTop"),n=i?"paddingLeft":"paddingRight",s=i?"left":"right",r=i?"right":"left",a=this.position.x+t[n];e[s]=this.getXValue(a),e[r]="";var u=o?"paddingTop":"paddingBottom",h=o?"top":"bottom",d=o?"bottom":"top",l=this.position.y+t[u];e[h]=this.getYValue(l),e[d]="",this.css(e),this.emitEvent("layout",[this])},d.getXValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&!e?t/this.layout.size.width*100+"%":t+"px"},d.getYValue=function(t){var e=this.layout._getOption("horizontal");return this.layout.options.percentPosition&&e?t/this.layout.size.height*100+"%":t+"px"},d._transitionTo=function(t,e){this.getPosition();var i=this.position.x,o=this.position.y,n=t==this.position.x&&e==this.position.y;if(this.setPosition(t,e),n&&!this.isTransitioning)return void this.layoutPosition();var s=t-i,r=e-o,a={};a.transform=this.getTranslate(s,r),this.transition({to:a,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},d.getTranslate=function(t,e){var i=this.layout._getOption("originLeft"),o=this.layout._getOption("originTop");return t=i?t:-t,e=o?e:-e,"translate3d("+t+"px, "+e+"px, 0)"},d.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},d.moveTo=d._transitionTo,d.setPosition=function(t,e){this.position.x=parseFloat(t),this.position.y=parseFloat(e)},d._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to);for(var e in t.onTransitionEnd)t.onTransitionEnd[e].call(this)},d.transition=function(t){if(!parseFloat(this.layout.options.transitionDuration))return void this._nonTransition(t);var e=this._transn;for(var i in t.onTransitionEnd)e.onEnd[i]=t.onTransitionEnd[i];for(i in t.to)e.ingProperties[i]=!0,t.isCleaning&&(e.clean[i]=!0);if(t.from){this.css(t.from);var o=this.element.offsetHeight;o=null}this.enableTransition(t.to),this.css(t.to),this.isTransitioning=!0};var l="opacity,"+n(a);d.enableTransition=function(){if(!this.isTransitioning){var t=this.layout.options.transitionDuration;t="number"==typeof t?t+"ms":t,this.css({transitionProperty:l,transitionDuration:t,transitionDelay:this.staggerDelay||0}),this.element.addEventListener(u,this,!1)}},d.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},d.onotransitionend=function(t){this.ontransitionend(t)};var f={"-webkit-transform":"transform"};d.ontransitionend=function(t){if(t.target===this.element){var e=this._transn,o=f[t.propertyName]||t.propertyName;if(delete e.ingProperties[o],i(e.ingProperties)&&this.disableTransition(),o in e.clean&&(this.element.style[t.propertyName]="",delete e.clean[o]),o in e.onEnd){var n=e.onEnd[o];n.call(this),delete e.onEnd[o]}this.emitEvent("transitionEnd",[this])}},d.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(u,this,!1),this.isTransitioning=!1},d._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var c={transitionProperty:"",transitionDuration:"",transitionDelay:""};return d.removeTransitionStyles=function(){this.css(c)},d.stagger=function(t){t=isNaN(t)?0:t,this.staggerDelay=t+"ms"},d.removeElem=function(){this.element.parentNode.removeChild(this.element),this.css({display:""}),this.emitEvent("remove",[this])},d.remove=function(){return r&&parseFloat(this.layout.options.transitionDuration)?(this.once("transitionEnd",function(){this.removeElem()}),void this.hide()):void this.removeElem()},d.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("visibleStyle");e[i]=this.onRevealTransitionEnd,this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0,onTransitionEnd:e})},d.onRevealTransitionEnd=function(){this.isHidden||this.emitEvent("reveal")},d.getHideRevealTransitionEndProperty=function(t){var e=this.layout.options[t];if(e.opacity)return"opacity";for(var i in e)return i},d.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options,e={},i=this.getHideRevealTransitionEndProperty("hiddenStyle");e[i]=this.onHideTransitionEnd,this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:e})},d.onHideTransitionEnd=function(){this.isHidden&&(this.css({display:"none"}),this.emitEvent("hide"))},d.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},o}),function(t,e){"use strict";"function"==typeof define&&define.amd?define("outlayer/outlayer",["ev-emitter/ev-emitter","get-size/get-size","fizzy-ui-utils/utils","./item"],function(i,o,n,s){return e(t,i,o,n,s)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter"),require("get-size"),require("fizzy-ui-utils"),require("./item")):t.Outlayer=e(t,t.EvEmitter,t.getSize,t.fizzyUIUtils,t.Outlayer.Item)}(window,function(t,e,i,o,n){"use strict";function s(t,e){var i=o.getQueryElement(t);if(!i)return void(u&&u.error("Bad element for "+this.constructor.namespace+": "+(i||t)));this.element=i,h&&(this.$element=h(this.element)),this.options=o.extend({},this.constructor.defaults),this.option(e);var n=++l;this.element.outlayerGUID=n,f[n]=this,this._create();var s=this._getOption("initLayout");s&&this.layout()}function r(t){function e(){t.apply(this,arguments)}return e.prototype=Object.create(t.prototype),e.prototype.constructor=e,e}function a(t){if("number"==typeof t)return t;var e=t.match(/(^\d*\.?\d*)(\w*)/),i=e&&e[1],o=e&&e[2];if(!i.length)return 0;i=parseFloat(i);var n=m[o]||1;return i*n}var u=t.console,h=t.jQuery,d=function(){},l=0,f={};s.namespace="outlayer",s.Item=n,s.defaults={containerStyle:{position:"relative"},initLayout:!0,originLeft:!0,originTop:!0,resize:!0,resizeContainer:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}};var c=s.prototype;o.extend(c,e.prototype),c.option=function(t){o.extend(this.options,t)},c._getOption=function(t){var e=this.constructor.compatOptions[t];return e&&void 0!==this.options[e]?this.options[e]:this.options[t]},s.compatOptions={initLayout:"isInitLayout",horizontal:"isHorizontal",layoutInstant:"isLayoutInstant",originLeft:"isOriginLeft",originTop:"isOriginTop",resize:"isResizeBound",resizeContainer:"isResizingContainer"},c._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),o.extend(this.element.style,this.options.containerStyle);var t=this._getOption("resize");t&&this.bindResize()},c.reloadItems=function(){this.items=this._itemize(this.element.children)},c._itemize=function(t){for(var e=this._filterFindItemElements(t),i=this.constructor.Item,o=[],n=0;n<e.length;n++){var s=e[n],r=new i(s,this);o.push(r)}return o},c._filterFindItemElements=function(t){return o.filterFindElements(t,this.options.itemSelector)},c.getItemElements=function(){return this.items.map(function(t){return t.element})},c.layout=function(){this._resetLayout(),this._manageStamps();var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},c._init=c.layout,c._resetLayout=function(){this.getSize()},c.getSize=function(){this.size=i(this.element)},c._getMeasurement=function(t,e){var o,n=this.options[t];n?("string"==typeof n?o=this.element.querySelector(n):n instanceof HTMLElement&&(o=n),this[t]=o?i(o)[e]:n):this[t]=0},c.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},c._getItemsForLayout=function(t){return t.filter(function(t){return!t.isIgnored})},c._layoutItems=function(t,e){if(this._emitCompleteOnItems("layout",t),t&&t.length){var i=[];t.forEach(function(t){var o=this._getItemLayoutPosition(t);o.item=t,o.isInstant=e||t.isLayoutInstant,i.push(o)},this),this._processLayoutQueue(i)}},c._getItemLayoutPosition=function(){return{x:0,y:0}},c._processLayoutQueue=function(t){this.updateStagger(),t.forEach(function(t,e){this._positionItem(t.item,t.x,t.y,t.isInstant,e)},this)},c.updateStagger=function(){var t=this.options.stagger;return null===t||void 0===t?void(this.stagger=0):(this.stagger=a(t),this.stagger)},c._positionItem=function(t,e,i,o,n){o?t.goTo(e,i):(t.stagger(n*this.stagger),t.moveTo(e,i))},c._postLayout=function(){this.resizeContainer()},c.resizeContainer=function(){var t=this._getOption("resizeContainer");if(t){var e=this._getContainerSize();e&&(this._setContainerMeasure(e.width,!0),this._setContainerMeasure(e.height,!1))}},c._getContainerSize=d,c._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},c._emitCompleteOnItems=function(t,e){function i(){n.dispatchEvent(t+"Complete",null,[e])}function o(){r++,r==s&&i()}var n=this,s=e.length;if(!e||!s)return void i();var r=0;e.forEach(function(e){e.once(t,o)})},c.dispatchEvent=function(t,e,i){var o=e?[e].concat(i):i;if(this.emitEvent(t,o),h)if(this.$element=this.$element||h(this.element),e){var n=h.Event(e);n.type=t,this.$element.trigger(n,i)}else this.$element.trigger(t,i)},c.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},c.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},c.stamp=function(t){t=this._find(t),t&&(this.stamps=this.stamps.concat(t),t.forEach(this.ignore,this))},c.unstamp=function(t){t=this._find(t),t&&t.forEach(function(t){o.removeFrom(this.stamps,t),this.unignore(t)},this)},c._find=function(t){if(t)return"string"==typeof t&&(t=this.element.querySelectorAll(t)),t=o.makeArray(t)},c._manageStamps=function(){this.stamps&&this.stamps.length&&(this._getBoundingRect(),this.stamps.forEach(this._manageStamp,this))},c._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},c._manageStamp=d,c._getElementOffset=function(t){var e=t.getBoundingClientRect(),o=this._boundingRect,n=i(t),s={left:e.left-o.left-n.marginLeft,top:e.top-o.top-n.marginTop,right:o.right-e.right-n.marginRight,bottom:o.bottom-e.bottom-n.marginBottom};return s},c.handleEvent=o.handleEvent,c.bindResize=function(){t.addEventListener("resize",this),this.isResizeBound=!0},c.unbindResize=function(){t.removeEventListener("resize",this),this.isResizeBound=!1},c.onresize=function(){this.resize()},o.debounceMethod(s,"onresize",100),c.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&this.layout()},c.needsResizeLayout=function(){var t=i(this.element),e=this.size&&t;return e&&t.innerWidth!==this.size.innerWidth},c.addItems=function(t){var e=this._itemize(t);return e.length&&(this.items=this.items.concat(e)),e},c.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},c.prepended=function(t){var e=this._itemize(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this._manageStamps(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},c.reveal=function(t){if(this._emitCompleteOnItems("reveal",t),t&&t.length){var e=this.updateStagger();t.forEach(function(t,i){t.stagger(i*e),t.reveal()})}},c.hide=function(t){if(this._emitCompleteOnItems("hide",t),t&&t.length){var e=this.updateStagger();t.forEach(function(t,i){t.stagger(i*e),t.hide()})}},c.revealItemElements=function(t){var e=this.getItems(t);this.reveal(e)},c.hideItemElements=function(t){var e=this.getItems(t);this.hide(e)},c.getItem=function(t){for(var e=0;e<this.items.length;e++){var i=this.items[e];if(i.element==t)return i}},c.getItems=function(t){t=o.makeArray(t);var e=[];return t.forEach(function(t){var i=this.getItem(t);i&&e.push(i)},this),e},c.remove=function(t){var e=this.getItems(t);this._emitCompleteOnItems("remove",e),e&&e.length&&e.forEach(function(t){t.remove(),o.removeFrom(this.items,t)},this)},c.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="",this.items.forEach(function(t){t.destroy()}),this.unbindResize();var e=this.element.outlayerGUID;delete f[e],delete this.element.outlayerGUID,h&&h.removeData(this.element,this.constructor.namespace)},s.data=function(t){t=o.getQueryElement(t);var e=t&&t.outlayerGUID;return e&&f[e]},s.create=function(t,e){var i=r(s);return i.defaults=o.extend({},s.defaults),o.extend(i.defaults,e),i.compatOptions=o.extend({},s.compatOptions),i.namespace=t,i.data=s.data,i.Item=r(n),o.htmlInit(i,t),h&&h.bridget&&h.bridget(t,i),i};var m={ms:1,s:1e3};return s.Item=n,s}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/item",["outlayer/outlayer"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.Item=e(t.Outlayer))}(window,function(t){"use strict";function e(){t.Item.apply(this,arguments)}var i=e.prototype=Object.create(t.Item.prototype),o=i._create;i._create=function(){this.id=this.layout.itemGUID++,o.call(this),this.sortData={}},i.updateSortData=function(){if(!this.isIgnored){this.sortData.id=this.id,this.sortData["original-order"]=this.id,this.sortData.random=Math.random();var t=this.layout.options.getSortData,e=this.layout._sorters;for(var i in t){var o=e[i];this.sortData[i]=o(this.element,this)}}};var n=i.destroy;return i.destroy=function(){n.apply(this,arguments),this.css({display:""})},e}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-mode",["get-size/get-size","outlayer/outlayer"],e):"object"==typeof module&&module.exports?module.exports=e(require("get-size"),require("outlayer")):(t.Isotope=t.Isotope||{},t.Isotope.LayoutMode=e(t.getSize,t.Outlayer))}(window,function(t,e){"use strict";function i(t){this.isotope=t,t&&(this.options=t.options[this.namespace],this.element=t.element,this.items=t.filteredItems,this.size=t.size)}var o=i.prototype,n=["_resetLayout","_getItemLayoutPosition","_manageStamp","_getContainerSize","_getElementOffset","needsResizeLayout","_getOption"];return n.forEach(function(t){o[t]=function(){return e.prototype[t].apply(this.isotope,arguments)}}),o.needsVerticalResizeLayout=function(){var e=t(this.isotope.element),i=this.isotope.size&&e;return i&&e.innerHeight!=this.isotope.size.innerHeight},o._getMeasurement=function(){this.isotope._getMeasurement.apply(this,arguments)},o.getColumnWidth=function(){this.getSegmentSize("column","Width")},o.getRowHeight=function(){this.getSegmentSize("row","Height")},o.getSegmentSize=function(t,e){var i=t+e,o="outer"+e;if(this._getMeasurement(i,o),!this[i]){var n=this.getFirstItemSize();this[i]=n&&n[o]||this.isotope.size["inner"+e]}},o.getFirstItemSize=function(){var e=this.isotope.filteredItems[0];return e&&e.element&&t(e.element)},o.layout=function(){this.isotope.layout.apply(this.isotope,arguments)},o.getSize=function(){this.isotope.getSize(),this.size=this.isotope.size},i.modes={},i.create=function(t,e){function n(){i.apply(this,arguments)}return n.prototype=Object.create(o),n.prototype.constructor=n,e&&(n.options=e),n.prototype.namespace=t,i.modes[t]=n,n},i}),function(t,e){"function"==typeof define&&define.amd?define("masonry-layout/masonry",["outlayer/outlayer","get-size/get-size"],e):"object"==typeof module&&module.exports?module.exports=e(require("outlayer"),require("get-size")):t.Masonry=e(t.Outlayer,t.getSize)}(window,function(t,e){var i=t.create("masonry");i.compatOptions.fitWidth="isFitWidth";var o=i.prototype;return o._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns(),this.colYs=[];for(var t=0;t<this.cols;t++)this.colYs.push(0);this.maxY=0,this.horizontalColIndex=0},o.measureColumns=function(){if(this.getContainerWidth(),!this.columnWidth){var t=this.items[0],i=t&&t.element;this.columnWidth=i&&e(i).outerWidth||this.containerWidth}var o=this.columnWidth+=this.gutter,n=this.containerWidth+this.gutter,s=n/o,r=o-n%o,a=r&&r<1?"round":"floor";s=Math[a](s),this.cols=Math.max(s,1)},o.getContainerWidth=function(){var t=this._getOption("fitWidth"),i=t?this.element.parentNode:this.element,o=e(i);this.containerWidth=o&&o.innerWidth},o._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth%this.columnWidth,i=e&&e<1?"round":"ceil",o=Math[i](t.size.outerWidth/this.columnWidth);o=Math.min(o,this.cols);for(var n=this.options.horizontalOrder?"_getHorizontalColPosition":"_getTopColPosition",s=this[n](o,t),r={x:this.columnWidth*s.col,y:s.y},a=s.y+t.size.outerHeight,u=o+s.col,h=s.col;h<u;h++)this.colYs[h]=a;return r},o._getTopColPosition=function(t){var e=this._getTopColGroup(t),i=Math.min.apply(Math,e);return{col:e.indexOf(i),y:i}},o._getTopColGroup=function(t){if(t<2)return this.colYs;for(var e=[],i=this.cols+1-t,o=0;o<i;o++)e[o]=this._getColGroupY(o,t);return e},o._getColGroupY=function(t,e){if(e<2)return this.colYs[t];var i=this.colYs.slice(t,t+e);return Math.max.apply(Math,i)},o._getHorizontalColPosition=function(t,e){var i=this.horizontalColIndex%this.cols,o=t>1&&i+t>this.cols;i=o?0:i;var n=e.size.outerWidth&&e.size.outerHeight;return this.horizontalColIndex=n?i+t:this.horizontalColIndex,{col:i,y:this._getColGroupY(i,t)}},o._manageStamp=function(t){var i=e(t),o=this._getElementOffset(t),n=this._getOption("originLeft"),s=n?o.left:o.right,r=s+i.outerWidth,a=Math.floor(s/this.columnWidth);a=Math.max(0,a);var u=Math.floor(r/this.columnWidth);u-=r%this.columnWidth?0:1,u=Math.min(this.cols-1,u);for(var h=this._getOption("originTop"),d=(h?o.top:o.bottom)+i.outerHeight,l=a;l<=u;l++)this.colYs[l]=Math.max(d,this.colYs[l])},o._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this._getOption("fitWidth")&&(t.width=this._getContainerFitWidth()),t},o._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},o.needsResizeLayout=function(){var t=this.containerWidth;return this.getContainerWidth(),t!=this.containerWidth},i}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/masonry",["../layout-mode","masonry-layout/masonry"],e):"object"==typeof module&&module.exports?module.exports=e(require("../layout-mode"),require("masonry-layout")):e(t.Isotope.LayoutMode,t.Masonry)}(window,function(t,e){"use strict";var i=t.create("masonry"),o=i.prototype,n={_getElementOffset:!0,layout:!0,_getMeasurement:!0};for(var s in e.prototype)n[s]||(o[s]=e.prototype[s]);var r=o.measureColumns;o.measureColumns=function(){this.items=this.isotope.filteredItems,r.call(this)};var a=o._getOption;return o._getOption=function(t){return"fitWidth"==t?void 0!==this.options.isFitWidth?this.options.isFitWidth:this.options.fitWidth:a.apply(this.isotope,arguments)},i}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/fit-rows",["../layout-mode"],e):"object"==typeof exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window,function(t){"use strict";var e=t.create("fitRows"),i=e.prototype;return i._resetLayout=function(){this.x=0,this.y=0,this.maxY=0,this._getMeasurement("gutter","outerWidth")},i._getItemLayoutPosition=function(t){t.getSize();var e=t.size.outerWidth+this.gutter,i=this.isotope.size.innerWidth+this.gutter;0!==this.x&&e+this.x>i&&(this.x=0,this.y=this.maxY);var o={x:this.x,y:this.y};return this.maxY=Math.max(this.maxY,this.y+t.size.outerHeight),this.x+=e,o},i._getContainerSize=function(){return{height:this.maxY}},e}),function(t,e){"function"==typeof define&&define.amd?define("isotope-layout/js/layout-modes/vertical",["../layout-mode"],e):"object"==typeof module&&module.exports?module.exports=e(require("../layout-mode")):e(t.Isotope.LayoutMode)}(window,function(t){"use strict";var e=t.create("vertical",{horizontalAlignment:0}),i=e.prototype;return i._resetLayout=function(){this.y=0},i._getItemLayoutPosition=function(t){t.getSize();var e=(this.isotope.size.innerWidth-t.size.outerWidth)*this.options.horizontalAlignment,i=this.y;return this.y+=t.size.outerHeight,{x:e,y:i}},i._getContainerSize=function(){return{height:this.y}},e}),function(t,e){"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size","desandro-matches-selector/matches-selector","fizzy-ui-utils/utils","isotope-layout/js/item","isotope-layout/js/layout-mode","isotope-layout/js/layout-modes/masonry","isotope-layout/js/layout-modes/fit-rows","isotope-layout/js/layout-modes/vertical"],function(i,o,n,s,r,a){return e(t,i,o,n,s,r,a)}):"object"==typeof module&&module.exports?module.exports=e(t,require("outlayer"),require("get-size"),require("desandro-matches-selector"),require("fizzy-ui-utils"),require("isotope-layout/js/item"),require("isotope-layout/js/layout-mode"),require("isotope-layout/js/layout-modes/masonry"),require("isotope-layout/js/layout-modes/fit-rows"),require("isotope-layout/js/layout-modes/vertical")):t.Isotope=e(t,t.Outlayer,t.getSize,t.matchesSelector,t.fizzyUIUtils,t.Isotope.Item,t.Isotope.LayoutMode)}(window,function(t,e,i,o,n,s,r){function a(t,e){return function(i,o){for(var n=0;n<t.length;n++){var s=t[n],r=i.sortData[s],a=o.sortData[s];if(r>a||r<a){var u=void 0!==e[s]?e[s]:e,h=u?1:-1;return(r>a?1:-1)*h}}return 0}}var u=t.jQuery,h=String.prototype.trim?function(t){return t.trim()}:function(t){return t.replace(/^\s+|\s+$/g,"")},d=e.create("isotope",{layoutMode:"masonry",isJQueryFiltering:!0,sortAscending:!0});d.Item=s,d.LayoutMode=r;var l=d.prototype;l._create=function(){this.itemGUID=0,this._sorters={},this._getSorters(),e.prototype._create.call(this),this.modes={},this.filteredItems=this.items,this.sortHistory=["original-order"];for(var t in r.modes)this._initLayoutMode(t)},l.reloadItems=function(){this.itemGUID=0,e.prototype.reloadItems.call(this)},l._itemize=function(){for(var t=e.prototype._itemize.apply(this,arguments),i=0;i<t.length;i++){var o=t[i];o.id=this.itemGUID++}return this._updateItemsSortData(t),t},l._initLayoutMode=function(t){var e=r.modes[t],i=this.options[t]||{};this.options[t]=e.options?n.extend(e.options,i):i,this.modes[t]=new e(this)},l.layout=function(){return!this._isLayoutInited&&this._getOption("initLayout")?void this.arrange():void this._layout()},l._layout=function(){var t=this._getIsInstant();this._resetLayout(),this._manageStamps(),this.layoutItems(this.filteredItems,t),this._isLayoutInited=!0},l.arrange=function(t){this.option(t),this._getIsInstant();var e=this._filter(this.items);this.filteredItems=e.matches,this._bindArrangeComplete(),this._isInstant?this._noTransition(this._hideReveal,[e]):this._hideReveal(e),this._sort(),this._layout()},l._init=l.arrange,l._hideReveal=function(t){this.reveal(t.needReveal),this.hide(t.needHide)},l._getIsInstant=function(){var t=this._getOption("layoutInstant"),e=void 0!==t?t:!this._isLayoutInited;return this._isInstant=e,e},l._bindArrangeComplete=function(){function t(){e&&i&&o&&n.dispatchEvent("arrangeComplete",null,[n.filteredItems])}var e,i,o,n=this;this.once("layoutComplete",function(){e=!0,t()}),this.once("hideComplete",function(){i=!0,t()}),this.once("revealComplete",function(){o=!0,t()})},l._filter=function(t){var e=this.options.filter;e=e||"*";for(var i=[],o=[],n=[],s=this._getFilterTest(e),r=0;r<t.length;r++){var a=t[r];if(!a.isIgnored){var u=s(a);u&&i.push(a),u&&a.isHidden?o.push(a):u||a.isHidden||n.push(a)}}return{matches:i,needReveal:o,needHide:n}},l._getFilterTest=function(t){return u&&this.options.isJQueryFiltering?function(e){return u(e.element).is(t);
}:"function"==typeof t?function(e){return t(e.element)}:function(e){return o(e.element,t)}},l.updateSortData=function(t){var e;t?(t=n.makeArray(t),e=this.getItems(t)):e=this.items,this._getSorters(),this._updateItemsSortData(e)},l._getSorters=function(){var t=this.options.getSortData;for(var e in t){var i=t[e];this._sorters[e]=f(i)}},l._updateItemsSortData=function(t){for(var e=t&&t.length,i=0;e&&i<e;i++){var o=t[i];o.updateSortData()}};var f=function(){function t(t){if("string"!=typeof t)return t;var i=h(t).split(" "),o=i[0],n=o.match(/^\[(.+)\]$/),s=n&&n[1],r=e(s,o),a=d.sortDataParsers[i[1]];return t=a?function(t){return t&&a(r(t))}:function(t){return t&&r(t)}}function e(t,e){return t?function(e){return e.getAttribute(t)}:function(t){var i=t.querySelector(e);return i&&i.textContent}}return t}();d.sortDataParsers={parseInt:function(t){return parseInt(t,10)},parseFloat:function(t){return parseFloat(t)}},l._sort=function(){if(this.options.sortBy){var t=n.makeArray(this.options.sortBy);this._getIsSameSortBy(t)||(this.sortHistory=t.concat(this.sortHistory));var e=a(this.sortHistory,this.options.sortAscending);this.filteredItems.sort(e)}},l._getIsSameSortBy=function(t){for(var e=0;e<t.length;e++)if(t[e]!=this.sortHistory[e])return!1;return!0},l._mode=function(){var t=this.options.layoutMode,e=this.modes[t];if(!e)throw new Error("No layout mode: "+t);return e.options=this.options[t],e},l._resetLayout=function(){e.prototype._resetLayout.call(this),this._mode()._resetLayout()},l._getItemLayoutPosition=function(t){return this._mode()._getItemLayoutPosition(t)},l._manageStamp=function(t){this._mode()._manageStamp(t)},l._getContainerSize=function(){return this._mode()._getContainerSize()},l.needsResizeLayout=function(){return this._mode().needsResizeLayout()},l.appended=function(t){var e=this.addItems(t);if(e.length){var i=this._filterRevealAdded(e);this.filteredItems=this.filteredItems.concat(i)}},l.prepended=function(t){var e=this._itemize(t);if(e.length){this._resetLayout(),this._manageStamps();var i=this._filterRevealAdded(e);this.layoutItems(this.filteredItems),this.filteredItems=i.concat(this.filteredItems),this.items=e.concat(this.items)}},l._filterRevealAdded=function(t){var e=this._filter(t);return this.hide(e.needHide),this.reveal(e.matches),this.layoutItems(e.matches,!0),e.matches},l.insert=function(t){var e=this.addItems(t);if(e.length){var i,o,n=e.length;for(i=0;i<n;i++)o=e[i],this.element.appendChild(o.element);var s=this._filter(e).matches;for(i=0;i<n;i++)e[i].isLayoutInstant=!0;for(this.arrange(),i=0;i<n;i++)delete e[i].isLayoutInstant;this.reveal(s)}};var c=l.remove;return l.remove=function(t){t=n.makeArray(t);var e=this.getItems(t);c.call(this,t);for(var i=e&&e.length,o=0;i&&o<i;o++){var s=e[o];n.removeFrom(this.filteredItems,s)}},l.shuffle=function(){for(var t=0;t<this.items.length;t++){var e=this.items[t];e.sortData.random=Math.random()}this.options.sortBy="random",this._sort(),this._layout()},l._noTransition=function(t,e){var i=this.options.transitionDuration;this.options.transitionDuration=0;var o=t.apply(this,e);return this.options.transitionDuration=i,o},l.getFilteredItemElements=function(){return this.filteredItems.map(function(t){return t.element})},d});
/*!
 * Packery layout mode PACKAGED v2.0.1
 * sub-classes Packery
 */

!function(a,b){"function"==typeof define&&define.amd?define("packery/js/rect",b):"object"==typeof module&&module.exports?module.exports=b():(a.Packery=a.Packery||{},a.Packery.Rect=b())}(window,function(){function a(b){for(var c in a.defaults)this[c]=a.defaults[c];for(c in b)this[c]=b[c]}a.defaults={x:0,y:0,width:0,height:0};var b=a.prototype;return b.contains=function(a){var b=a.width||0,c=a.height||0;return this.x<=a.x&&this.y<=a.y&&this.x+this.width>=a.x+b&&this.y+this.height>=a.y+c},b.overlaps=function(a){var b=this.x+this.width,c=this.y+this.height,d=a.x+a.width,e=a.y+a.height;return this.x<d&&b>a.x&&this.y<e&&c>a.y},b.getMaximalFreeRects=function(b){if(!this.overlaps(b))return!1;var c,d=[],e=this.x+this.width,f=this.y+this.height,g=b.x+b.width,h=b.y+b.height;return this.y<b.y&&(c=new a({x:this.x,y:this.y,width:this.width,height:b.y-this.y}),d.push(c)),e>g&&(c=new a({x:g,y:this.y,width:e-g,height:this.height}),d.push(c)),f>h&&(c=new a({x:this.x,y:h,width:this.width,height:f-h}),d.push(c)),this.x<b.x&&(c=new a({x:this.x,y:this.y,width:b.x-this.x,height:this.height}),d.push(c)),d},b.canFit=function(a){return this.width>=a.width&&this.height>=a.height},a}),function(a,b){if("function"==typeof define&&define.amd)define("packery/js/packer",["./rect"],b);else if("object"==typeof module&&module.exports)module.exports=b(require("./rect"));else{var c=a.Packery=a.Packery||{};c.Packer=b(c.Rect)}}(window,function(a){function b(a,b,c){this.width=a||0,this.height=b||0,this.sortDirection=c||"downwardLeftToRight",this.reset()}var c=b.prototype;c.reset=function(){this.spaces=[];var b=new a({x:0,y:0,width:this.width,height:this.height});this.spaces.push(b),this.sorter=d[this.sortDirection]||d.downwardLeftToRight},c.pack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b];if(c.canFit(a)){this.placeInSpace(a,c);break}}},c.columnPack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b],d=c.x<=a.x&&c.x+c.width>=a.x+a.width&&c.height>=a.height-.01;if(d){a.y=c.y,this.placed(a);break}}},c.rowPack=function(a){for(var b=0;b<this.spaces.length;b++){var c=this.spaces[b],d=c.y<=a.y&&c.y+c.height>=a.y+a.height&&c.width>=a.width-.01;if(d){a.x=c.x,this.placed(a);break}}},c.placeInSpace=function(a,b){a.x=b.x,a.y=b.y,this.placed(a)},c.placed=function(a){for(var b=[],c=0;c<this.spaces.length;c++){var d=this.spaces[c],e=d.getMaximalFreeRects(a);e?b.push.apply(b,e):b.push(d)}this.spaces=b,this.mergeSortSpaces()},c.mergeSortSpaces=function(){b.mergeRects(this.spaces),this.spaces.sort(this.sorter)},c.addSpace=function(a){this.spaces.push(a),this.mergeSortSpaces()},b.mergeRects=function(a){var b=0,c=a[b];a:for(;c;){for(var d=0,e=a[b+d];e;){if(e==c)d++;else{if(e.contains(c)){a.splice(b,1),c=a[b];continue a}c.contains(e)?a.splice(b+d,1):d++}e=a[b+d]}b++,c=a[b]}return a};var d={downwardLeftToRight:function(a,b){return a.y-b.y||a.x-b.x},rightwardTopToBottom:function(a,b){return a.x-b.x||a.y-b.y}};return b}),function(a,b){"function"==typeof define&&define.amd?define("packery/js/item",["outlayer/outlayer","./rect"],b):"object"==typeof module&&module.exports?module.exports=b(require("outlayer"),require("./rect")):a.Packery.Item=b(a.Outlayer,a.Packery.Rect)}(window,function(a,b){var c=document.documentElement.style,d="string"==typeof c.transform?"transform":"WebkitTransform",e=function(){a.Item.apply(this,arguments)},f=e.prototype=Object.create(a.Item.prototype),g=f._create;f._create=function(){g.call(this),this.rect=new b};var h=f.moveTo;return f.moveTo=function(a,b){var c=Math.abs(this.position.x-a),d=Math.abs(this.position.y-b),e=this.layout.dragItemCount&&!this.isPlacing&&!this.isTransitioning&&1>c&&1>d;return e?void this.goTo(a,b):void h.apply(this,arguments)},f.enablePlacing=function(){this.removeTransitionStyles(),this.isTransitioning&&d&&(this.element.style[d]="none"),this.isTransitioning=!1,this.getSize(),this.layout._setRectSize(this.element,this.rect),this.isPlacing=!0},f.disablePlacing=function(){this.isPlacing=!1},f.removeElem=function(){this.element.parentNode.removeChild(this.element),this.layout.packer.addSpace(this.rect),this.emitEvent("remove",[this])},f.showDropPlaceholder=function(){var a=this.dropPlaceholder;a||(a=this.dropPlaceholder=document.createElement("div"),a.className="packery-drop-placeholder",a.style.position="absolute"),a.style.width=this.size.width+"px",a.style.height=this.size.height+"px",this.positionDropPlaceholder(),this.layout.element.appendChild(a)},f.positionDropPlaceholder=function(){this.dropPlaceholder.style[d]="translate("+this.rect.x+"px, "+this.rect.y+"px)"},f.hideDropPlaceholder=function(){this.layout.element.removeChild(this.dropPlaceholder)},e}),function(a,b){"function"==typeof define&&define.amd?define("packery/js/packery",["get-size/get-size","outlayer/outlayer","./rect","./packer","./item"],b):"object"==typeof module&&module.exports?module.exports=b(require("get-size"),require("outlayer"),require("./rect"),require("./packer"),require("./item")):a.Packery=b(a.getSize,a.Outlayer,a.Packery.Rect,a.Packery.Packer,a.Packery.Item)}(window,function(a,b,c,d,e){function f(a,b){return a.position.y-b.position.y||a.position.x-b.position.x}function g(a,b){return a.position.x-b.position.x||a.position.y-b.position.y}function h(a,b){var c=b.x-a.x,d=b.y-a.y;return Math.sqrt(c*c+d*d)}c.prototype.canFit=function(a){return this.width>=a.width-1&&this.height>=a.height-1};var i=b.create("packery");i.Item=e;var j=i.prototype;j._create=function(){b.prototype._create.call(this),this.packer=new d,this.shiftPacker=new d,this.isEnabled=!0,this.dragItemCount=0;var a=this;this.handleDraggabilly={dragStart:function(){a.itemDragStart(this.element)},dragMove:function(){a.itemDragMove(this.element,this.position.x,this.position.y)},dragEnd:function(){a.itemDragEnd(this.element)}},this.handleUIDraggable={start:function(b,c){c&&a.itemDragStart(b.currentTarget)},drag:function(b,c){c&&a.itemDragMove(b.currentTarget,c.position.left,c.position.top)},stop:function(b,c){c&&a.itemDragEnd(b.currentTarget)}}},j._resetLayout=function(){this.getSize(),this._getMeasurements();var a,b,c;this._getOption("horizontal")?(a=1/0,b=this.size.innerHeight+this.gutter,c="rightwardTopToBottom"):(a=this.size.innerWidth+this.gutter,b=1/0,c="downwardLeftToRight"),this.packer.width=this.shiftPacker.width=a,this.packer.height=this.shiftPacker.height=b,this.packer.sortDirection=this.shiftPacker.sortDirection=c,this.packer.reset(),this.maxY=0,this.maxX=0},j._getMeasurements=function(){this._getMeasurement("columnWidth","width"),this._getMeasurement("rowHeight","height"),this._getMeasurement("gutter","width")},j._getItemLayoutPosition=function(a){if(this._setRectSize(a.element,a.rect),this.isShifting||this.dragItemCount>0){var b=this._getPackMethod();this.packer[b](a.rect)}else this.packer.pack(a.rect);return this._setMaxXY(a.rect),a.rect},j.shiftLayout=function(){this.isShifting=!0,this.layout(),delete this.isShifting},j._getPackMethod=function(){return this._getOption("horizontal")?"rowPack":"columnPack"},j._setMaxXY=function(a){this.maxX=Math.max(a.x+a.width,this.maxX),this.maxY=Math.max(a.y+a.height,this.maxY)},j._setRectSize=function(b,c){var d=a(b),e=d.outerWidth,f=d.outerHeight;(e||f)&&(e=this._applyGridGutter(e,this.columnWidth),f=this._applyGridGutter(f,this.rowHeight)),c.width=Math.min(e,this.packer.width),c.height=Math.min(f,this.packer.height)},j._applyGridGutter=function(a,b){if(!b)return a+this.gutter;b+=this.gutter;var c=a%b,d=c&&1>c?"round":"ceil";return a=Math[d](a/b)*b},j._getContainerSize=function(){return this._getOption("horizontal")?{width:this.maxX-this.gutter}:{height:this.maxY-this.gutter}},j._manageStamp=function(a){var b,d=this.getItem(a);if(d&&d.isPlacing)b=d.rect;else{var e=this._getElementOffset(a);b=new c({x:this._getOption("originLeft")?e.left:e.right,y:this._getOption("originTop")?e.top:e.bottom})}this._setRectSize(a,b),this.packer.placed(b),this._setMaxXY(b)},j.sortItemsByPosition=function(){var a=this._getOption("horizontal")?g:f;this.items.sort(a)},j.fit=function(a,b,c){var d=this.getItem(a);d&&(this.stamp(d.element),d.enablePlacing(),this.updateShiftTargets(d),b=void 0===b?d.rect.x:b,c=void 0===c?d.rect.y:c,this.shift(d,b,c),this._bindFitEvents(d),d.moveTo(d.rect.x,d.rect.y),this.shiftLayout(),this.unstamp(d.element),this.sortItemsByPosition(),d.disablePlacing())},j._bindFitEvents=function(a){function b(){d++,2==d&&c.dispatchEvent("fitComplete",null,[a])}var c=this,d=0;a.once("layout",b),this.once("layoutComplete",b)},j.resize=function(){this.isResizeBound&&this.needsResizeLayout()&&(this.options.shiftPercentResize?this.resizeShiftPercentLayout():this.layout())},j.needsResizeLayout=function(){var b=a(this.element),c=this._getOption("horizontal")?"innerHeight":"innerWidth";return b[c]!=this.size[c]},j.resizeShiftPercentLayout=function(){var b=this._getItemsForLayout(this.items),c=this._getOption("horizontal"),d=c?"y":"x",e=c?"height":"width",f=c?"rowHeight":"columnWidth",g=c?"innerHeight":"innerWidth",h=this[f];if(h=h&&h+this.gutter){this._getMeasurements();var i=this[f]+this.gutter;b.forEach(function(a){var b=Math.round(a.rect[d]/h);a.rect[d]=b*i})}else{var j=a(this.element)[g]+this.gutter,k=this.packer[e];b.forEach(function(a){a.rect[d]=a.rect[d]/k*j})}this.shiftLayout()},j.itemDragStart=function(a){if(this.isEnabled){this.stamp(a);var b=this.getItem(a);b&&(b.enablePlacing(),b.showDropPlaceholder(),this.dragItemCount++,this.updateShiftTargets(b))}},j.updateShiftTargets=function(a){this.shiftPacker.reset(),this._getBoundingRect();var b=this._getOption("originLeft"),d=this._getOption("originTop");this.stamps.forEach(function(a){var e=this.getItem(a);if(!e||!e.isPlacing){var f=this._getElementOffset(a),g=new c({x:b?f.left:f.right,y:d?f.top:f.bottom});this._setRectSize(a,g),this.shiftPacker.placed(g)}},this);var e=this._getOption("horizontal"),f=e?"rowHeight":"columnWidth",g=e?"height":"width";this.shiftTargetKeys=[],this.shiftTargets=[];var h,i=this[f];if(i=i&&i+this.gutter){var j=Math.ceil(a.rect[g]/i),k=Math.floor((this.shiftPacker[g]+this.gutter)/i);h=(k-j)*i;for(var l=0;k>l;l++)this._addShiftTarget(l*i,0,h)}else h=this.shiftPacker[g]+this.gutter-a.rect[g],this._addShiftTarget(0,0,h);var m=this._getItemsForLayout(this.items),n=this._getPackMethod();m.forEach(function(a){var b=a.rect;this._setRectSize(a.element,b),this.shiftPacker[n](b),this._addShiftTarget(b.x,b.y,h);var c=e?b.x+b.width:b.x,d=e?b.y:b.y+b.height;if(this._addShiftTarget(c,d,h),i)for(var f=Math.round(b[g]/i),j=1;f>j;j++){var k=e?c:b.x+i*j,l=e?b.y+i*j:d;this._addShiftTarget(k,l,h)}},this)},j._addShiftTarget=function(a,b,c){var d=this._getOption("horizontal")?b:a;if(!(0!==d&&d>c)){var e=a+","+b,f=-1!=this.shiftTargetKeys.indexOf(e);f||(this.shiftTargetKeys.push(e),this.shiftTargets.push({x:a,y:b}))}},j.shift=function(a,b,c){var d,e=1/0,f={x:b,y:c};this.shiftTargets.forEach(function(a){var b=h(a,f);e>b&&(d=a,e=b)}),a.rect.x=d.x,a.rect.y=d.y};var k=120;j.itemDragMove=function(a,b,c){function d(){f.shift(e,b,c),e.positionDropPlaceholder(),f.layout()}var e=this.isEnabled&&this.getItem(a);if(e){b-=this.size.paddingLeft,c-=this.size.paddingTop;var f=this,g=new Date;this._itemDragTime&&g-this._itemDragTime<k?(clearTimeout(this.dragTimeout),this.dragTimeout=setTimeout(d,k)):(d(),this._itemDragTime=g)}},j.itemDragEnd=function(a){function b(){d++,2==d&&(c.element.classList.remove("is-positioning-post-drag"),c.hideDropPlaceholder(),e.dispatchEvent("dragItemPositioned",null,[c]))}var c=this.isEnabled&&this.getItem(a);if(c){clearTimeout(this.dragTimeout),c.element.classList.add("is-positioning-post-drag");var d=0,e=this;c.once("layout",b),this.once("layoutComplete",b),c.moveTo(c.rect.x,c.rect.y),this.layout(),this.dragItemCount=Math.max(0,this.dragItemCount-1),this.sortItemsByPosition(),c.disablePlacing(),this.unstamp(c.element)}},j.bindDraggabillyEvents=function(a){this._bindDraggabillyEvents(a,"on")},j.unbindDraggabillyEvents=function(a){this._bindDraggabillyEvents(a,"off")},j._bindDraggabillyEvents=function(a,b){var c=this.handleDraggabilly;a[b]("dragStart",c.dragStart),a[b]("dragMove",c.dragMove),a[b]("dragEnd",c.dragEnd)},j.bindUIDraggableEvents=function(a){this._bindUIDraggableEvents(a,"on")},j.unbindUIDraggableEvents=function(a){this._bindUIDraggableEvents(a,"off")},j._bindUIDraggableEvents=function(a,b){var c=this.handleUIDraggable;a[b]("dragstart",c.start)[b]("drag",c.drag)[b]("dragstop",c.stop)};var l=j.destroy;return j.destroy=function(){l.apply(this,arguments),this.isEnabled=!1},i.Rect=c,i.Packer=d,i}),function(a,b){"function"==typeof define&&define.amd?define(["isotope-layout/js/layout-mode","packery/js/packery"],b):"object"==typeof module&&module.exports?module.exports=b(require("isotope-layout/js/layout-mode"),require("packery")):b(a.Isotope.LayoutMode,a.Packery)}(window,function(a,b){var c=a.create("packery"),d=c.prototype,e={_getElementOffset:!0,_getMeasurement:!0};for(var f in b.prototype)e[f]||(d[f]=b.prototype[f]);var g=d._resetLayout;d._resetLayout=function(){this.packer=this.packer||new b.Packer,this.shiftPacker=this.shiftPacker||new b.Packer,g.apply(this,arguments)};var h=d._getItemLayoutPosition;d._getItemLayoutPosition=function(a){return a.rect=a.rect||new b.Rect,h.call(this,a)};var i=d.needsResizeLayout;d.needsResizeLayout=function(){return this._getOption("horizontal")?this.needsVerticalResizeLayout():i.call(this)};var j=d._getOption;return d._getOption=function(a){return"horizontal"==a?void 0!==this.options.isHorizontal?this.options.isHorizontal:this.options.horizontal:j.apply(this.isotope,arguments)},c});

// Ion.RangeSlider
// version 2.3.0 Build: 381
// © Denis Ineshin, 2018
// https://github.com/IonDen
//
// Project page:    http://ionden.com/a/plugins/ion.rangeSlider/en.html
// GitHub page:     https://github.com/IonDen/ion.rangeSlider
//
// Released under MIT licence:
// http://ionden.com/a/plugins/licence-en.html
;(function(f){"function"===typeof define&&define.amd?define(["jquery"],function(n){return f(n,document,window,navigator)}):"object"===typeof exports?f(require("jquery"),document,window,navigator):f(jQuery,document,window,navigator)})(function(f,n,k,r,p){var t=0,m=function(){var a=r.userAgent,b=/msie\s\d+/i;return 0<a.search(b)&&(a=b.exec(a).toString(),a=a.split(" ")[1],9>a)?(f("html").addClass("lt-ie9"),!0):!1}();Function.prototype.bind||(Function.prototype.bind=function(a){var b=this,d=[].slice;if("function"!=
typeof b)throw new TypeError;var c=d.call(arguments,1),e=function(){if(this instanceof e){var g=function(){};g.prototype=b.prototype;var g=new g,l=b.apply(g,c.concat(d.call(arguments)));return Object(l)===l?l:g}return b.apply(a,c.concat(d.call(arguments)))};return e});Array.prototype.indexOf||(Array.prototype.indexOf=function(a,b){if(null==this)throw new TypeError('"this" is null or not defined');var d=Object(this),c=d.length>>>0;if(0===c)return-1;var e=+b||0;Infinity===Math.abs(e)&&(e=0);if(e>=c)return-1;
for(e=Math.max(0<=e?e:c-Math.abs(e),0);e<c;){if(e in d&&d[e]===a)return e;e++}return-1});var q=function(a,b,d){this.VERSION="2.2.0";this.input=a;this.plugin_count=d;this.old_to=this.old_from=this.update_tm=this.calc_count=this.current_plugin=0;this.raf_id=this.old_min_interval=null;this.no_diapason=this.force_redraw=this.dragging=!1;this.has_tab_index=!0;this.is_update=this.is_key=!1;this.is_start=!0;this.is_click=this.is_resize=this.is_active=this.is_finish=!1;b=b||{};this.$cache={win:f(k),body:f(n.body),
input:f(a),cont:null,rs:null,min:null,max:null,from:null,to:null,single:null,bar:null,line:null,s_single:null,s_from:null,s_to:null,shad_single:null,shad_from:null,shad_to:null,edge:null,grid:null,grid_labels:[]};this.coords={x_gap:0,x_pointer:0,w_rs:0,w_rs_old:0,w_handle:0,p_gap:0,p_gap_left:0,p_gap_right:0,p_step:0,p_pointer:0,p_handle:0,p_single_fake:0,p_single_real:0,p_from_fake:0,p_from_real:0,p_to_fake:0,p_to_real:0,p_bar_x:0,p_bar_w:0,grid_gap:0,big_num:0,big:[],big_w:[],big_p:[],big_x:[]};
this.labels={w_min:0,w_max:0,w_from:0,w_to:0,w_single:0,p_min:0,p_max:0,p_from_fake:0,p_from_left:0,p_to_fake:0,p_to_left:0,p_single_fake:0,p_single_left:0};var c=this.$cache.input;a=c.prop("value");var e;d={type:"single",min:10,max:100,from:null,to:null,step:1,min_interval:0,max_interval:0,drag_interval:!1,values:[],p_values:[],from_fixed:!1,from_min:null,from_max:null,from_shadow:!1,to_fixed:!1,to_min:null,to_max:null,to_shadow:!1,prettify_enabled:!0,prettify_separator:" ",prettify:null,force_edges:!1,
keyboard:!0,grid:!1,grid_margin:!0,grid_num:4,grid_snap:!1,hide_min_max:!1,hide_from_to:!1,prefix:"",postfix:"",max_postfix:"",decorate_both:!0,values_separator:" \u2014 ",input_values_separator:";",disable:!1,block:!1,extra_classes:"",scope:null,onStart:null,onChange:null,onFinish:null,onUpdate:null};"INPUT"!==c[0].nodeName&&console&&console.warn&&console.warn("Base element should be <input>!",c[0]);c={type:c.data("type"),min:c.data("min"),max:c.data("max"),from:c.data("from"),to:c.data("to"),step:c.data("step"),
min_interval:c.data("minInterval"),max_interval:c.data("maxInterval"),drag_interval:c.data("dragInterval"),values:c.data("values"),from_fixed:c.data("fromFixed"),from_min:c.data("fromMin"),from_max:c.data("fromMax"),from_shadow:c.data("fromShadow"),to_fixed:c.data("toFixed"),to_min:c.data("toMin"),to_max:c.data("toMax"),to_shadow:c.data("toShadow"),prettify_enabled:c.data("prettifyEnabled"),prettify_separator:c.data("prettifySeparator"),force_edges:c.data("forceEdges"),keyboard:c.data("keyboard"),
grid:c.data("grid"),grid_margin:c.data("gridMargin"),grid_num:c.data("gridNum"),grid_snap:c.data("gridSnap"),hide_min_max:c.data("hideMinMax"),hide_from_to:c.data("hideFromTo"),prefix:c.data("prefix"),postfix:c.data("postfix"),max_postfix:c.data("maxPostfix"),decorate_both:c.data("decorateBoth"),values_separator:c.data("valuesSeparator"),input_values_separator:c.data("inputValuesSeparator"),disable:c.data("disable"),block:c.data("block"),extra_classes:c.data("extraClasses")};c.values=c.values&&c.values.split(",");
for(e in c)c.hasOwnProperty(e)&&(c[e]!==p&&""!==c[e]||delete c[e]);a!==p&&""!==a&&(a=a.split(c.input_values_separator||b.input_values_separator||";"),a[0]&&a[0]==+a[0]&&(a[0]=+a[0]),a[1]&&a[1]==+a[1]&&(a[1]=+a[1]),b&&b.values&&b.values.length?(d.from=a[0]&&b.values.indexOf(a[0]),d.to=a[1]&&b.values.indexOf(a[1])):(d.from=a[0]&&+a[0],d.to=a[1]&&+a[1]));f.extend(d,b);f.extend(d,c);this.options=d;this.update_check={};this.validate();this.result={input:this.$cache.input,slider:null,min:this.options.min,
max:this.options.max,from:this.options.from,from_percent:0,from_value:null,to:this.options.to,to_percent:0,to_value:null};this.init()};q.prototype={init:function(a){this.no_diapason=!1;this.coords.p_step=this.convertToPercent(this.options.step,!0);this.target="base";this.toggleInput();this.append();this.setMinMax();a?(this.force_redraw=!0,this.calc(!0),this.callOnUpdate()):(this.force_redraw=!0,this.calc(!0),this.callOnStart());this.updateScene()},append:function(){this.$cache.input.before('<span class="irs js-irs-'+
this.plugin_count+" "+this.options.extra_classes+'"></span>');this.$cache.input.prop("readonly",!0);this.$cache.cont=this.$cache.input.prev();this.result.slider=this.$cache.cont;this.$cache.cont.html('<span class="irs"><span class="irs-line" tabindex="0"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min">0</span><span class="irs-max">1</span><span class="irs-from">0</span><span class="irs-to">0</span><span class="irs-single">0</span></span><span class="irs-grid"></span><span class="irs-bar"></span>');
this.$cache.rs=this.$cache.cont.find(".irs");this.$cache.min=this.$cache.cont.find(".irs-min");this.$cache.max=this.$cache.cont.find(".irs-max");this.$cache.from=this.$cache.cont.find(".irs-from");this.$cache.to=this.$cache.cont.find(".irs-to");this.$cache.single=this.$cache.cont.find(".irs-single");this.$cache.bar=this.$cache.cont.find(".irs-bar");this.$cache.line=this.$cache.cont.find(".irs-line");this.$cache.grid=this.$cache.cont.find(".irs-grid");"single"===this.options.type?(this.$cache.cont.append('<span class="irs-bar-edge"></span><span class="irs-shadow shadow-single"></span><span class="irs-slider single"></span>'),
this.$cache.edge=this.$cache.cont.find(".irs-bar-edge"),this.$cache.s_single=this.$cache.cont.find(".single"),this.$cache.from[0].style.visibility="hidden",this.$cache.to[0].style.visibility="hidden",this.$cache.shad_single=this.$cache.cont.find(".shadow-single")):(this.$cache.cont.append('<span class="irs-shadow shadow-from"></span><span class="irs-shadow shadow-to"></span><span class="irs-slider from"></span><span class="irs-slider to"></span>'),this.$cache.s_from=this.$cache.cont.find(".from"),
this.$cache.s_to=this.$cache.cont.find(".to"),this.$cache.shad_from=this.$cache.cont.find(".shadow-from"),this.$cache.shad_to=this.$cache.cont.find(".shadow-to"),this.setTopHandler());this.options.hide_from_to&&(this.$cache.from[0].style.display="none",this.$cache.to[0].style.display="none",this.$cache.single[0].style.display="none");this.appendGrid();this.options.disable?(this.appendDisableMask(),this.$cache.input[0].disabled=!0):(this.$cache.input[0].disabled=!1,this.removeDisableMask(),this.bindEvents());
this.options.disable||(this.options.block?this.appendDisableMask():this.removeDisableMask());this.options.drag_interval&&(this.$cache.bar[0].style.cursor="ew-resize")},setTopHandler:function(){var a=this.options.max,b=this.options.to;this.options.from>this.options.min&&b===a?this.$cache.s_from.addClass("type_last"):b<a&&this.$cache.s_to.addClass("type_last")},changeLevel:function(a){switch(a){case "single":this.coords.p_gap=this.toFixed(this.coords.p_pointer-this.coords.p_single_fake);this.$cache.s_single.addClass("state_hover");
break;case "from":this.coords.p_gap=this.toFixed(this.coords.p_pointer-this.coords.p_from_fake);this.$cache.s_from.addClass("state_hover");this.$cache.s_from.addClass("type_last");this.$cache.s_to.removeClass("type_last");break;case "to":this.coords.p_gap=this.toFixed(this.coords.p_pointer-this.coords.p_to_fake);this.$cache.s_to.addClass("state_hover");this.$cache.s_to.addClass("type_last");this.$cache.s_from.removeClass("type_last");break;case "both":this.coords.p_gap_left=this.toFixed(this.coords.p_pointer-
this.coords.p_from_fake),this.coords.p_gap_right=this.toFixed(this.coords.p_to_fake-this.coords.p_pointer),this.$cache.s_to.removeClass("type_last"),this.$cache.s_from.removeClass("type_last")}},appendDisableMask:function(){this.$cache.cont.append('<span class="irs-disable-mask"></span>');this.$cache.cont.addClass("irs-disabled")},removeDisableMask:function(){this.$cache.cont.remove(".irs-disable-mask");this.$cache.cont.removeClass("irs-disabled")},remove:function(){this.$cache.cont.remove();this.$cache.cont=
null;this.$cache.line.off("keydown.irs_"+this.plugin_count);this.$cache.body.off("touchmove.irs_"+this.plugin_count);this.$cache.body.off("mousemove.irs_"+this.plugin_count);this.$cache.win.off("touchend.irs_"+this.plugin_count);this.$cache.win.off("mouseup.irs_"+this.plugin_count);m&&(this.$cache.body.off("mouseup.irs_"+this.plugin_count),this.$cache.body.off("mouseleave.irs_"+this.plugin_count));this.$cache.grid_labels=[];this.coords.big=[];this.coords.big_w=[];this.coords.big_p=[];this.coords.big_x=
[];cancelAnimationFrame(this.raf_id)},bindEvents:function(){if(!this.no_diapason){this.$cache.body.on("touchmove.irs_"+this.plugin_count,this.pointerMove.bind(this));this.$cache.body.on("mousemove.irs_"+this.plugin_count,this.pointerMove.bind(this));this.$cache.win.on("touchend.irs_"+this.plugin_count,this.pointerUp.bind(this));this.$cache.win.on("mouseup.irs_"+this.plugin_count,this.pointerUp.bind(this));this.$cache.line.on("touchstart.irs_"+this.plugin_count,this.pointerClick.bind(this,"click"));
this.$cache.line.on("mousedown.irs_"+this.plugin_count,this.pointerClick.bind(this,"click"));this.$cache.line.on("focus.irs_"+this.plugin_count,this.pointerFocus.bind(this));this.options.drag_interval&&"double"===this.options.type?(this.$cache.bar.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"both")),this.$cache.bar.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"both"))):(this.$cache.bar.on("touchstart.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")),
this.$cache.bar.on("mousedown.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")));"single"===this.options.type?(this.$cache.single.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"single")),this.$cache.s_single.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"single")),this.$cache.shad_single.on("touchstart.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")),this.$cache.single.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,
"single")),this.$cache.s_single.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"single")),this.$cache.edge.on("mousedown.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")),this.$cache.shad_single.on("mousedown.irs_"+this.plugin_count,this.pointerClick.bind(this,"click"))):(this.$cache.single.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,null)),this.$cache.single.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,null)),this.$cache.from.on("touchstart.irs_"+
this.plugin_count,this.pointerDown.bind(this,"from")),this.$cache.s_from.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"from")),this.$cache.to.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"to")),this.$cache.s_to.on("touchstart.irs_"+this.plugin_count,this.pointerDown.bind(this,"to")),this.$cache.shad_from.on("touchstart.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")),this.$cache.shad_to.on("touchstart.irs_"+this.plugin_count,this.pointerClick.bind(this,
"click")),this.$cache.from.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"from")),this.$cache.s_from.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"from")),this.$cache.to.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"to")),this.$cache.s_to.on("mousedown.irs_"+this.plugin_count,this.pointerDown.bind(this,"to")),this.$cache.shad_from.on("mousedown.irs_"+this.plugin_count,this.pointerClick.bind(this,"click")),this.$cache.shad_to.on("mousedown.irs_"+
this.plugin_count,this.pointerClick.bind(this,"click")));if(this.options.keyboard)this.$cache.line.on("keydown.irs_"+this.plugin_count,this.key.bind(this,"keyboard"));m&&(this.$cache.body.on("mouseup.irs_"+this.plugin_count,this.pointerUp.bind(this)),this.$cache.body.on("mouseleave.irs_"+this.plugin_count,this.pointerUp.bind(this)))}},pointerFocus:function(a){if(!this.target){var b="single"===this.options.type?this.$cache.single:this.$cache.from;a=b.offset().left;a+=b.width()/2-1;this.pointerClick("single",
{preventDefault:function(){},pageX:a})}},pointerMove:function(a){this.dragging&&(this.coords.x_pointer=(a.pageX||a.originalEvent.touches&&a.originalEvent.touches[0].pageX)-this.coords.x_gap,this.calc())},pointerUp:function(a){this.current_plugin===this.plugin_count&&this.is_active&&(this.is_active=!1,this.$cache.cont.find(".state_hover").removeClass("state_hover"),this.force_redraw=!0,m&&f("*").prop("unselectable",!1),this.updateScene(),this.restoreOriginalMinInterval(),(f.contains(this.$cache.cont[0],
a.target)||this.dragging)&&this.callOnFinish(),this.dragging=!1)},pointerDown:function(a,b){b.preventDefault();var d=b.pageX||b.originalEvent.touches&&b.originalEvent.touches[0].pageX;2!==b.button&&("both"===a&&this.setTempMinInterval(),a||(a=this.target||"from"),this.current_plugin=this.plugin_count,this.target=a,this.dragging=this.is_active=!0,this.coords.x_gap=this.$cache.rs.offset().left,this.coords.x_pointer=d-this.coords.x_gap,this.calcPointerPercent(),this.changeLevel(a),m&&f("*").prop("unselectable",
!0),this.$cache.line.trigger("focus"),this.updateScene())},pointerClick:function(a,b){b.preventDefault();var d=b.pageX||b.originalEvent.touches&&b.originalEvent.touches[0].pageX;2!==b.button&&(this.current_plugin=this.plugin_count,this.target=a,this.is_click=!0,this.coords.x_gap=this.$cache.rs.offset().left,this.coords.x_pointer=+(d-this.coords.x_gap).toFixed(),this.force_redraw=!0,this.calc(),this.$cache.line.trigger("focus"))},key:function(a,b){if(!(this.current_plugin!==this.plugin_count||b.altKey||
b.ctrlKey||b.shiftKey||b.metaKey)){switch(b.which){case 83:case 65:case 40:case 37:b.preventDefault();this.moveByKey(!1);break;case 87:case 68:case 38:case 39:b.preventDefault(),this.moveByKey(!0)}return!0}},moveByKey:function(a){var b=this.coords.p_pointer,d=(this.options.max-this.options.min)/100,d=this.options.step/d;this.coords.x_pointer=this.toFixed(this.coords.w_rs/100*(a?b+d:b-d));this.is_key=!0;this.calc()},setMinMax:function(){if(this.options)if(this.options.hide_min_max)this.$cache.min[0].style.display=
"none",this.$cache.max[0].style.display="none";else{if(this.options.values.length)this.$cache.min.html(this.decorate(this.options.p_values[this.options.min])),this.$cache.max.html(this.decorate(this.options.p_values[this.options.max]));else{var a=this._prettify(this.options.min),b=this._prettify(this.options.max);this.result.min_pretty=a;this.result.max_pretty=b;this.$cache.min.html(this.decorate(a,this.options.min));this.$cache.max.html(this.decorate(b,this.options.max))}this.labels.w_min=this.$cache.min.outerWidth(!1);
this.labels.w_max=this.$cache.max.outerWidth(!1)}},setTempMinInterval:function(){var a=this.result.to-this.result.from;null===this.old_min_interval&&(this.old_min_interval=this.options.min_interval);this.options.min_interval=a},restoreOriginalMinInterval:function(){null!==this.old_min_interval&&(this.options.min_interval=this.old_min_interval,this.old_min_interval=null)},calc:function(a){if(this.options){this.calc_count++;if(10===this.calc_count||a)this.calc_count=0,this.coords.w_rs=this.$cache.rs.outerWidth(!1),
this.calcHandlePercent();if(this.coords.w_rs){this.calcPointerPercent();a=this.getHandleX();"both"===this.target&&(this.coords.p_gap=0,a=this.getHandleX());"click"===this.target&&(this.coords.p_gap=this.coords.p_handle/2,a=this.getHandleX(),this.target=this.options.drag_interval?"both_one":this.chooseHandle(a));switch(this.target){case "base":var b=(this.options.max-this.options.min)/100;a=(this.result.from-this.options.min)/b;b=(this.result.to-this.options.min)/b;this.coords.p_single_real=this.toFixed(a);
this.coords.p_from_real=this.toFixed(a);this.coords.p_to_real=this.toFixed(b);this.coords.p_single_real=this.checkDiapason(this.coords.p_single_real,this.options.from_min,this.options.from_max);this.coords.p_from_real=this.checkDiapason(this.coords.p_from_real,this.options.from_min,this.options.from_max);this.coords.p_to_real=this.checkDiapason(this.coords.p_to_real,this.options.to_min,this.options.to_max);this.coords.p_single_fake=this.convertToFakePercent(this.coords.p_single_real);this.coords.p_from_fake=
this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_fake=this.convertToFakePercent(this.coords.p_to_real);this.target=null;break;case "single":if(this.options.from_fixed)break;this.coords.p_single_real=this.convertToRealPercent(a);this.coords.p_single_real=this.calcWithStep(this.coords.p_single_real);this.coords.p_single_real=this.checkDiapason(this.coords.p_single_real,this.options.from_min,this.options.from_max);this.coords.p_single_fake=this.convertToFakePercent(this.coords.p_single_real);
break;case "from":if(this.options.from_fixed)break;this.coords.p_from_real=this.convertToRealPercent(a);this.coords.p_from_real=this.calcWithStep(this.coords.p_from_real);this.coords.p_from_real>this.coords.p_to_real&&(this.coords.p_from_real=this.coords.p_to_real);this.coords.p_from_real=this.checkDiapason(this.coords.p_from_real,this.options.from_min,this.options.from_max);this.coords.p_from_real=this.checkMinInterval(this.coords.p_from_real,this.coords.p_to_real,"from");this.coords.p_from_real=
this.checkMaxInterval(this.coords.p_from_real,this.coords.p_to_real,"from");this.coords.p_from_fake=this.convertToFakePercent(this.coords.p_from_real);break;case "to":if(this.options.to_fixed)break;this.coords.p_to_real=this.convertToRealPercent(a);this.coords.p_to_real=this.calcWithStep(this.coords.p_to_real);this.coords.p_to_real<this.coords.p_from_real&&(this.coords.p_to_real=this.coords.p_from_real);this.coords.p_to_real=this.checkDiapason(this.coords.p_to_real,this.options.to_min,this.options.to_max);
this.coords.p_to_real=this.checkMinInterval(this.coords.p_to_real,this.coords.p_from_real,"to");this.coords.p_to_real=this.checkMaxInterval(this.coords.p_to_real,this.coords.p_from_real,"to");this.coords.p_to_fake=this.convertToFakePercent(this.coords.p_to_real);break;case "both":if(this.options.from_fixed||this.options.to_fixed)break;a=this.toFixed(a+.001*this.coords.p_handle);this.coords.p_from_real=this.convertToRealPercent(a)-this.coords.p_gap_left;this.coords.p_from_real=this.calcWithStep(this.coords.p_from_real);
this.coords.p_from_real=this.checkDiapason(this.coords.p_from_real,this.options.from_min,this.options.from_max);this.coords.p_from_real=this.checkMinInterval(this.coords.p_from_real,this.coords.p_to_real,"from");this.coords.p_from_fake=this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_real=this.convertToRealPercent(a)+this.coords.p_gap_right;this.coords.p_to_real=this.calcWithStep(this.coords.p_to_real);this.coords.p_to_real=this.checkDiapason(this.coords.p_to_real,this.options.to_min,
this.options.to_max);this.coords.p_to_real=this.checkMinInterval(this.coords.p_to_real,this.coords.p_from_real,"to");this.coords.p_to_fake=this.convertToFakePercent(this.coords.p_to_real);break;case "both_one":if(!this.options.from_fixed&&!this.options.to_fixed){var d=this.convertToRealPercent(a);a=this.result.to_percent-this.result.from_percent;var c=a/2,b=d-c,d=d+c;0>b&&(b=0,d=b+a);100<d&&(d=100,b=d-a);this.coords.p_from_real=this.calcWithStep(b);this.coords.p_from_real=this.checkDiapason(this.coords.p_from_real,
this.options.from_min,this.options.from_max);this.coords.p_from_fake=this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_real=this.calcWithStep(d);this.coords.p_to_real=this.checkDiapason(this.coords.p_to_real,this.options.to_min,this.options.to_max);this.coords.p_to_fake=this.convertToFakePercent(this.coords.p_to_real)}}"single"===this.options.type?(this.coords.p_bar_x=this.coords.p_handle/2,this.coords.p_bar_w=this.coords.p_single_fake,this.result.from_percent=this.coords.p_single_real,
this.result.from=this.convertToValue(this.coords.p_single_real),this.result.from_pretty=this._prettify(this.result.from),this.options.values.length&&(this.result.from_value=this.options.values[this.result.from])):(this.coords.p_bar_x=this.toFixed(this.coords.p_from_fake+this.coords.p_handle/2),this.coords.p_bar_w=this.toFixed(this.coords.p_to_fake-this.coords.p_from_fake),this.result.from_percent=this.coords.p_from_real,this.result.from=this.convertToValue(this.coords.p_from_real),this.result.from_pretty=
this._prettify(this.result.from),this.result.to_percent=this.coords.p_to_real,this.result.to=this.convertToValue(this.coords.p_to_real),this.result.to_pretty=this._prettify(this.result.to),this.options.values.length&&(this.result.from_value=this.options.values[this.result.from],this.result.to_value=this.options.values[this.result.to]));this.calcMinMax();this.calcLabels()}}},calcPointerPercent:function(){this.coords.w_rs?(0>this.coords.x_pointer||isNaN(this.coords.x_pointer)?this.coords.x_pointer=
0:this.coords.x_pointer>this.coords.w_rs&&(this.coords.x_pointer=this.coords.w_rs),this.coords.p_pointer=this.toFixed(this.coords.x_pointer/this.coords.w_rs*100)):this.coords.p_pointer=0},convertToRealPercent:function(a){return a/(100-this.coords.p_handle)*100},convertToFakePercent:function(a){return a/100*(100-this.coords.p_handle)},getHandleX:function(){var a=100-this.coords.p_handle,b=this.toFixed(this.coords.p_pointer-this.coords.p_gap);0>b?b=0:b>a&&(b=a);return b},calcHandlePercent:function(){this.coords.w_handle=
"single"===this.options.type?this.$cache.s_single.outerWidth(!1):this.$cache.s_from.outerWidth(!1);this.coords.p_handle=this.toFixed(this.coords.w_handle/this.coords.w_rs*100)},chooseHandle:function(a){return"single"===this.options.type?"single":a>=this.coords.p_from_real+(this.coords.p_to_real-this.coords.p_from_real)/2?this.options.to_fixed?"from":"to":this.options.from_fixed?"to":"from"},calcMinMax:function(){this.coords.w_rs&&(this.labels.p_min=this.labels.w_min/this.coords.w_rs*100,this.labels.p_max=
this.labels.w_max/this.coords.w_rs*100)},calcLabels:function(){this.coords.w_rs&&!this.options.hide_from_to&&("single"===this.options.type?(this.labels.w_single=this.$cache.single.outerWidth(!1),this.labels.p_single_fake=this.labels.w_single/this.coords.w_rs*100,this.labels.p_single_left=this.coords.p_single_fake+this.coords.p_handle/2-this.labels.p_single_fake/2):(this.labels.w_from=this.$cache.from.outerWidth(!1),this.labels.p_from_fake=this.labels.w_from/this.coords.w_rs*100,this.labels.p_from_left=
this.coords.p_from_fake+this.coords.p_handle/2-this.labels.p_from_fake/2,this.labels.p_from_left=this.toFixed(this.labels.p_from_left),this.labels.p_from_left=this.checkEdges(this.labels.p_from_left,this.labels.p_from_fake),this.labels.w_to=this.$cache.to.outerWidth(!1),this.labels.p_to_fake=this.labels.w_to/this.coords.w_rs*100,this.labels.p_to_left=this.coords.p_to_fake+this.coords.p_handle/2-this.labels.p_to_fake/2,this.labels.p_to_left=this.toFixed(this.labels.p_to_left),this.labels.p_to_left=
this.checkEdges(this.labels.p_to_left,this.labels.p_to_fake),this.labels.w_single=this.$cache.single.outerWidth(!1),this.labels.p_single_fake=this.labels.w_single/this.coords.w_rs*100,this.labels.p_single_left=(this.labels.p_from_left+this.labels.p_to_left+this.labels.p_to_fake)/2-this.labels.p_single_fake/2,this.labels.p_single_left=this.toFixed(this.labels.p_single_left)),this.labels.p_single_left=this.checkEdges(this.labels.p_single_left,this.labels.p_single_fake))},updateScene:function(){this.raf_id&&
(cancelAnimationFrame(this.raf_id),this.raf_id=null);clearTimeout(this.update_tm);this.update_tm=null;this.options&&(this.drawHandles(),this.is_active?this.raf_id=requestAnimationFrame(this.updateScene.bind(this)):this.update_tm=setTimeout(this.updateScene.bind(this),300))},drawHandles:function(){this.coords.w_rs=this.$cache.rs.outerWidth(!1);if(this.coords.w_rs){this.coords.w_rs!==this.coords.w_rs_old&&(this.target="base",this.is_resize=!0);if(this.coords.w_rs!==this.coords.w_rs_old||this.force_redraw)this.setMinMax(),
this.calc(!0),this.drawLabels(),this.options.grid&&(this.calcGridMargin(),this.calcGridLabels()),this.force_redraw=!0,this.coords.w_rs_old=this.coords.w_rs,this.drawShadow();if(this.coords.w_rs&&(this.dragging||this.force_redraw||this.is_key)){if(this.old_from!==this.result.from||this.old_to!==this.result.to||this.force_redraw||this.is_key){this.drawLabels();this.$cache.bar[0].style.left=this.coords.p_bar_x+"%";this.$cache.bar[0].style.width=this.coords.p_bar_w+"%";if("single"===this.options.type)this.$cache.s_single[0].style.left=
this.coords.p_single_fake+"%";else{this.$cache.s_from[0].style.left=this.coords.p_from_fake+"%";this.$cache.s_to[0].style.left=this.coords.p_to_fake+"%";if(this.old_from!==this.result.from||this.force_redraw)this.$cache.from[0].style.left=this.labels.p_from_left+"%";if(this.old_to!==this.result.to||this.force_redraw)this.$cache.to[0].style.left=this.labels.p_to_left+"%"}this.$cache.single[0].style.left=this.labels.p_single_left+"%";this.writeToInput();this.old_from===this.result.from&&this.old_to===
this.result.to||this.is_start||(this.$cache.input.trigger("change"),this.$cache.input.trigger("input"));this.old_from=this.result.from;this.old_to=this.result.to;this.is_resize||this.is_update||this.is_start||this.is_finish||this.callOnChange();if(this.is_key||this.is_click)this.is_click=this.is_key=!1,this.callOnFinish();this.is_finish=this.is_resize=this.is_update=!1}this.force_redraw=this.is_click=this.is_key=this.is_start=!1}}},drawLabels:function(){if(this.options){var a=this.options.values.length,
b=this.options.p_values;if(!this.options.hide_from_to)if("single"===this.options.type){if(a)a=this.decorate(b[this.result.from]);else{var d=this._prettify(this.result.from);a=this.decorate(d,this.result.from)}this.$cache.single.html(a);this.calcLabels();this.$cache.min[0].style.visibility=this.labels.p_single_left<this.labels.p_min+1?"hidden":"visible";this.$cache.max[0].style.visibility=this.labels.p_single_left+this.labels.p_single_fake>100-this.labels.p_max-1?"hidden":"visible"}else{a?(this.options.decorate_both?
(a=this.decorate(b[this.result.from]),a+=this.options.values_separator,a+=this.decorate(b[this.result.to])):a=this.decorate(b[this.result.from]+this.options.values_separator+b[this.result.to]),d=this.decorate(b[this.result.from]),b=this.decorate(b[this.result.to])):(d=this._prettify(this.result.from),b=this._prettify(this.result.to),this.options.decorate_both?(a=this.decorate(d,this.result.from),a+=this.options.values_separator,a+=this.decorate(b,this.result.to)):a=this.decorate(d+this.options.values_separator+
b,this.result.to),d=this.decorate(d,this.result.from),b=this.decorate(b,this.result.to));this.$cache.single.html(a);this.$cache.from.html(d);this.$cache.to.html(b);this.calcLabels();a=Math.min(this.labels.p_single_left,this.labels.p_from_left);d=this.labels.p_single_left+this.labels.p_single_fake;var b=this.labels.p_to_left+this.labels.p_to_fake,c=Math.max(d,b);this.labels.p_from_left+this.labels.p_from_fake>=this.labels.p_to_left?(this.$cache.from[0].style.visibility="hidden",this.$cache.to[0].style.visibility=
"hidden",this.$cache.single[0].style.visibility="visible",this.result.from===this.result.to?("from"===this.target?this.$cache.from[0].style.visibility="visible":"to"===this.target?this.$cache.to[0].style.visibility="visible":this.target||(this.$cache.from[0].style.visibility="visible"),this.$cache.single[0].style.visibility="hidden",c=b):(this.$cache.from[0].style.visibility="hidden",this.$cache.to[0].style.visibility="hidden",this.$cache.single[0].style.visibility="visible",c=Math.max(d,b))):(this.$cache.from[0].style.visibility=
"visible",this.$cache.to[0].style.visibility="visible",this.$cache.single[0].style.visibility="hidden");this.$cache.min[0].style.visibility=a<this.labels.p_min+1?"hidden":"visible";this.$cache.max[0].style.visibility=c>100-this.labels.p_max-1?"hidden":"visible"}}},drawShadow:function(){var a=this.options,b=this.$cache,d="number"===typeof a.from_min&&!isNaN(a.from_min),c="number"===typeof a.from_max&&!isNaN(a.from_max),e="number"===typeof a.to_min&&!isNaN(a.to_min),g="number"===typeof a.to_max&&!isNaN(a.to_max);
"single"===a.type?a.from_shadow&&(d||c)?(d=this.convertToPercent(d?a.from_min:a.min),c=this.convertToPercent(c?a.from_max:a.max)-d,d=this.toFixed(d-this.coords.p_handle/100*d),c=this.toFixed(c-this.coords.p_handle/100*c),d+=this.coords.p_handle/2,b.shad_single[0].style.display="block",b.shad_single[0].style.left=d+"%",b.shad_single[0].style.width=c+"%"):b.shad_single[0].style.display="none":(a.from_shadow&&(d||c)?(d=this.convertToPercent(d?a.from_min:a.min),c=this.convertToPercent(c?a.from_max:a.max)-
d,d=this.toFixed(d-this.coords.p_handle/100*d),c=this.toFixed(c-this.coords.p_handle/100*c),d+=this.coords.p_handle/2,b.shad_from[0].style.display="block",b.shad_from[0].style.left=d+"%",b.shad_from[0].style.width=c+"%"):b.shad_from[0].style.display="none",a.to_shadow&&(e||g)?(e=this.convertToPercent(e?a.to_min:a.min),a=this.convertToPercent(g?a.to_max:a.max)-e,e=this.toFixed(e-this.coords.p_handle/100*e),a=this.toFixed(a-this.coords.p_handle/100*a),e+=this.coords.p_handle/2,b.shad_to[0].style.display=
"block",b.shad_to[0].style.left=e+"%",b.shad_to[0].style.width=a+"%"):b.shad_to[0].style.display="none")},writeToInput:function(){"single"===this.options.type?(this.options.values.length?this.$cache.input.prop("value",this.result.from_value):this.$cache.input.prop("value",this.result.from),this.$cache.input.data("from",this.result.from)):(this.options.values.length?this.$cache.input.prop("value",this.result.from_value+this.options.input_values_separator+this.result.to_value):this.$cache.input.prop("value",
this.result.from+this.options.input_values_separator+this.result.to),this.$cache.input.data("from",this.result.from),this.$cache.input.data("to",this.result.to))},callOnStart:function(){this.writeToInput();if(this.options.onStart&&"function"===typeof this.options.onStart)if(this.options.scope)this.options.onStart.call(this.options.scope,this.result);else this.options.onStart(this.result)},callOnChange:function(){this.writeToInput();if(this.options.onChange&&"function"===typeof this.options.onChange)if(this.options.scope)this.options.onChange.call(this.options.scope,
this.result);else this.options.onChange(this.result)},callOnFinish:function(){this.writeToInput();if(this.options.onFinish&&"function"===typeof this.options.onFinish)if(this.options.scope)this.options.onFinish.call(this.options.scope,this.result);else this.options.onFinish(this.result)},callOnUpdate:function(){this.writeToInput();if(this.options.onUpdate&&"function"===typeof this.options.onUpdate)if(this.options.scope)this.options.onUpdate.call(this.options.scope,this.result);else this.options.onUpdate(this.result)},
toggleInput:function(){this.$cache.input.toggleClass("irs-hidden-input");this.has_tab_index?this.$cache.input.prop("tabindex",-1):this.$cache.input.removeProp("tabindex");this.has_tab_index=!this.has_tab_index},convertToPercent:function(a,b){var d=this.options.max-this.options.min;return d?this.toFixed((b?a:a-this.options.min)/(d/100)):(this.no_diapason=!0,0)},convertToValue:function(a){var b=this.options.min,d=this.options.max,c=b.toString().split(".")[1],e=d.toString().split(".")[1],g,l,f=0,h=0;
if(0===a)return this.options.min;if(100===a)return this.options.max;c&&(f=g=c.length);e&&(f=l=e.length);g&&l&&(f=g>=l?g:l);0>b&&(h=Math.abs(b),b=+(b+h).toFixed(f),d=+(d+h).toFixed(f));a=(d-b)/100*a+b;(b=this.options.step.toString().split(".")[1])?a=+a.toFixed(b.length):(a/=this.options.step,a*=this.options.step,a=+a.toFixed(0));h&&(a-=h);h=b?+a.toFixed(b.length):this.toFixed(a);h<this.options.min?h=this.options.min:h>this.options.max&&(h=this.options.max);return h},calcWithStep:function(a){var b=
Math.round(a/this.coords.p_step)*this.coords.p_step;100<b&&(b=100);100===a&&(b=100);return this.toFixed(b)},checkMinInterval:function(a,b,d){var c=this.options;if(!c.min_interval)return a;a=this.convertToValue(a);b=this.convertToValue(b);"from"===d?b-a<c.min_interval&&(a=b-c.min_interval):a-b<c.min_interval&&(a=b+c.min_interval);return this.convertToPercent(a)},checkMaxInterval:function(a,b,d){var c=this.options;if(!c.max_interval)return a;a=this.convertToValue(a);b=this.convertToValue(b);"from"===
d?b-a>c.max_interval&&(a=b-c.max_interval):a-b>c.max_interval&&(a=b+c.max_interval);return this.convertToPercent(a)},checkDiapason:function(a,b,d){a=this.convertToValue(a);var c=this.options;"number"!==typeof b&&(b=c.min);"number"!==typeof d&&(d=c.max);a<b&&(a=b);a>d&&(a=d);return this.convertToPercent(a)},toFixed:function(a){a=a.toFixed(20);return+a},_prettify:function(a){return this.options.prettify_enabled?this.options.prettify&&"function"===typeof this.options.prettify?this.options.prettify(a):
this.prettify(a):a},prettify:function(a){return a.toString().replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g,"$1"+this.options.prettify_separator)},checkEdges:function(a,b){if(!this.options.force_edges)return this.toFixed(a);0>a?a=0:a>100-b&&(a=100-b);return this.toFixed(a)},validate:function(){var a=this.options,b=this.result,d=a.values,c=d.length,e;"string"===typeof a.min&&(a.min=+a.min);"string"===typeof a.max&&(a.max=+a.max);"string"===typeof a.from&&(a.from=+a.from);"string"===typeof a.to&&(a.to=+a.to);
"string"===typeof a.step&&(a.step=+a.step);"string"===typeof a.from_min&&(a.from_min=+a.from_min);"string"===typeof a.from_max&&(a.from_max=+a.from_max);"string"===typeof a.to_min&&(a.to_min=+a.to_min);"string"===typeof a.to_max&&(a.to_max=+a.to_max);"string"===typeof a.grid_num&&(a.grid_num=+a.grid_num);a.max<a.min&&(a.max=a.min);if(c)for(a.p_values=[],a.min=0,a.max=c-1,a.step=1,a.grid_num=a.max,a.grid_snap=!0,e=0;e<c;e++){var g=+d[e];isNaN(g)?g=d[e]:(d[e]=g,g=this._prettify(g));a.p_values.push(g)}if("number"!==
typeof a.from||isNaN(a.from))a.from=a.min;if("number"!==typeof a.to||isNaN(a.to))a.to=a.max;"single"===a.type?(a.from<a.min&&(a.from=a.min),a.from>a.max&&(a.from=a.max)):(a.from<a.min&&(a.from=a.min),a.from>a.max&&(a.from=a.max),a.to<a.min&&(a.to=a.min),a.to>a.max&&(a.to=a.max),this.update_check.from&&(this.update_check.from!==a.from&&a.from>a.to&&(a.from=a.to),this.update_check.to!==a.to&&a.to<a.from&&(a.to=a.from)),a.from>a.to&&(a.from=a.to),a.to<a.from&&(a.to=a.from));if("number"!==typeof a.step||
isNaN(a.step)||!a.step||0>a.step)a.step=1;"number"===typeof a.from_min&&a.from<a.from_min&&(a.from=a.from_min);"number"===typeof a.from_max&&a.from>a.from_max&&(a.from=a.from_max);"number"===typeof a.to_min&&a.to<a.to_min&&(a.to=a.to_min);"number"===typeof a.to_max&&a.from>a.to_max&&(a.to=a.to_max);if(b){b.min!==a.min&&(b.min=a.min);b.max!==a.max&&(b.max=a.max);if(b.from<b.min||b.from>b.max)b.from=a.from;if(b.to<b.min||b.to>b.max)b.to=a.to}if("number"!==typeof a.min_interval||isNaN(a.min_interval)||
!a.min_interval||0>a.min_interval)a.min_interval=0;if("number"!==typeof a.max_interval||isNaN(a.max_interval)||!a.max_interval||0>a.max_interval)a.max_interval=0;a.min_interval&&a.min_interval>a.max-a.min&&(a.min_interval=a.max-a.min);a.max_interval&&a.max_interval>a.max-a.min&&(a.max_interval=a.max-a.min)},decorate:function(a,b){var d="",c=this.options;c.prefix&&(d+=c.prefix);d+=a;c.max_postfix&&(c.values.length&&a===c.p_values[c.max]?(d+=c.max_postfix,c.postfix&&(d+=" ")):b===c.max&&(d+=c.max_postfix,
c.postfix&&(d+=" ")));c.postfix&&(d+=c.postfix);return d},updateFrom:function(){this.result.from=this.options.from;this.result.from_percent=this.convertToPercent(this.result.from);this.result.from_pretty=this._prettify(this.result.from);this.options.values&&(this.result.from_value=this.options.values[this.result.from])},updateTo:function(){this.result.to=this.options.to;this.result.to_percent=this.convertToPercent(this.result.to);this.result.to_pretty=this._prettify(this.result.to);this.options.values&&
(this.result.to_value=this.options.values[this.result.to])},updateResult:function(){this.result.min=this.options.min;this.result.max=this.options.max;this.updateFrom();this.updateTo()},appendGrid:function(){if(this.options.grid){var a=this.options,b;var d=a.max-a.min;var c=a.grid_num,e=4,g="";this.calcGridMargin();if(a.grid_snap)if(50<d){c=50/a.step;var f=this.toFixed(a.step/.5)}else c=d/a.step,f=this.toFixed(a.step/(d/100));else f=this.toFixed(100/c);4<c&&(e=3);7<c&&(e=2);14<c&&(e=1);28<c&&(e=0);
for(d=0;d<c+1;d++){var k=e;var h=this.toFixed(f*d);100<h&&(h=100);this.coords.big[d]=h;var m=(h-f*(d-1))/(k+1);for(b=1;b<=k&&0!==h;b++){var n=this.toFixed(h-m*b);g+='<span class="irs-grid-pol small" style="left: '+n+'%"></span>'}g+='<span class="irs-grid-pol" style="left: '+h+'%"></span>';b=this.convertToValue(h);b=a.values.length?a.p_values[b]:this._prettify(b);g+='<span class="irs-grid-text js-grid-text-'+d+'" style="left: '+h+'%">'+b+"</span>"}this.coords.big_num=Math.ceil(c+1);this.$cache.cont.addClass("irs-with-grid");
this.$cache.grid.html(g);this.cacheGridLabels()}},cacheGridLabels:function(){var a,b=this.coords.big_num;for(a=0;a<b;a++){var d=this.$cache.grid.find(".js-grid-text-"+a);this.$cache.grid_labels.push(d)}this.calcGridLabels()},calcGridLabels:function(){var a;var b=[];var d=[],c=this.coords.big_num;for(a=0;a<c;a++)this.coords.big_w[a]=this.$cache.grid_labels[a].outerWidth(!1),this.coords.big_p[a]=this.toFixed(this.coords.big_w[a]/this.coords.w_rs*100),this.coords.big_x[a]=this.toFixed(this.coords.big_p[a]/
2),b[a]=this.toFixed(this.coords.big[a]-this.coords.big_x[a]),d[a]=this.toFixed(b[a]+this.coords.big_p[a]);this.options.force_edges&&(b[0]<-this.coords.grid_gap&&(b[0]=-this.coords.grid_gap,d[0]=this.toFixed(b[0]+this.coords.big_p[0]),this.coords.big_x[0]=this.coords.grid_gap),d[c-1]>100+this.coords.grid_gap&&(d[c-1]=100+this.coords.grid_gap,b[c-1]=this.toFixed(d[c-1]-this.coords.big_p[c-1]),this.coords.big_x[c-1]=this.toFixed(this.coords.big_p[c-1]-this.coords.grid_gap)));this.calcGridCollision(2,
b,d);this.calcGridCollision(4,b,d);for(a=0;a<c;a++)b=this.$cache.grid_labels[a][0],this.coords.big_x[a]!==Number.POSITIVE_INFINITY&&(b.style.marginLeft=-this.coords.big_x[a]+"%")},calcGridCollision:function(a,b,d){var c,e=this.coords.big_num;for(c=0;c<e;c+=a){var g=c+a/2;if(g>=e)break;var f=this.$cache.grid_labels[g][0];f.style.visibility=d[c]<=b[g]?"visible":"hidden"}},calcGridMargin:function(){this.options.grid_margin&&(this.coords.w_rs=this.$cache.rs.outerWidth(!1),this.coords.w_rs&&(this.coords.w_handle=
"single"===this.options.type?this.$cache.s_single.outerWidth(!1):this.$cache.s_from.outerWidth(!1),this.coords.p_handle=this.toFixed(this.coords.w_handle/this.coords.w_rs*100),this.coords.grid_gap=this.toFixed(this.coords.p_handle/2-.1),this.$cache.grid[0].style.width=this.toFixed(100-this.coords.p_handle)+"%",this.$cache.grid[0].style.left=this.coords.grid_gap+"%"))},update:function(a){this.input&&(this.is_update=!0,this.options.from=this.result.from,this.options.to=this.result.to,this.update_check.from=
this.result.from,this.update_check.to=this.result.to,this.options=f.extend(this.options,a),this.validate(),this.updateResult(a),this.toggleInput(),this.remove(),this.init(!0))},reset:function(){this.input&&(this.updateResult(),this.update())},destroy:function(){this.input&&(this.toggleInput(),this.$cache.input.prop("readonly",!1),f.data(this.input,"ionRangeSlider",null),this.remove(),this.options=this.input=null)}};f.fn.ionRangeSlider=function(a){return this.each(function(){f.data(this,"ionRangeSlider")||
f.data(this,"ionRangeSlider",new q(this,a,t++))})};(function(){for(var a=0,b=["ms","moz","webkit","o"],d=0;d<b.length&&!k.requestAnimationFrame;++d)k.requestAnimationFrame=k[b[d]+"RequestAnimationFrame"],k.cancelAnimationFrame=k[b[d]+"CancelAnimationFrame"]||k[b[d]+"CancelRequestAnimationFrame"];k.requestAnimationFrame||(k.requestAnimationFrame=function(b,d){var c=(new Date).getTime(),e=Math.max(0,16-(c-a)),f=k.setTimeout(function(){b(c+e)},e);a=c+e;return f});k.cancelAnimationFrame||(k.cancelAnimationFrame=
function(a){clearTimeout(a)})})()});

/**
 * History.js Core
 * @author Benjamin Arthur Lupton <contact@balupton.com>
 * @copyright 2010-2011 Benjamin Arthur Lupton <contact@balupton.com>
 * @license New BSD License <http://creativecommons.org/licenses/BSD/>
 */
//(function(e,t){"use strict";var n=e.History=e.History||{};if(typeof n.Adapter!="undefined")throw new Error("History.js Adapter has already been loaded...");n.Adapter={handlers:{},_uid:1,uid:function(e){return e._uid||(e._uid=n.Adapter._uid++)},bind:function(e,t,r){var i=n.Adapter.uid(e);n.Adapter.handlers[i]=n.Adapter.handlers[i]||{},n.Adapter.handlers[i][t]=n.Adapter.handlers[i][t]||[],n.Adapter.handlers[i][t].push(r),e["on"+t]=function(e,t){return function(r){n.Adapter.trigger(e,t,r)}}(e,t)},trigger:function(e,t,r){r=r||{};var i=n.Adapter.uid(e),s,o;n.Adapter.handlers[i]=n.Adapter.handlers[i]||{},n.Adapter.handlers[i][t]=n.Adapter.handlers[i][t]||[];for(s=0,o=n.Adapter.handlers[i][t].length;s<o;++s)n.Adapter.handlers[i][t][s].apply(this,[r])},extractEventData:function(e,n){var r=n&&n[e]||t;return r},onDomLoad:function(t){var n=e.setTimeout(function(){t()},2e3);e.onload=function(){clearTimeout(n),t()}}},typeof n.init!="undefined"&&n.init()})(window),function(e,t){"use strict";var n=e.console||t,r=e.document,i=e.navigator,s=!1,o=e.setTimeout,u=e.clearTimeout,a=e.setInterval,f=e.clearInterval,l=e.JSON,c=e.alert,h=e.History=e.History||{},p=e.history;try{s=e.sessionStorage,s.setItem("TEST","1"),s.removeItem("TEST")}catch(d){s=!1}l.stringify=l.stringify||l.encode,l.parse=l.parse||l.decode;if(typeof h.init!="undefined")throw new Error("History.js Core has already been loaded...");h.init=function(e){return typeof h.Adapter=="undefined"?!1:(typeof h.initCore!="undefined"&&h.initCore(),typeof h.initHtml4!="undefined"&&h.initHtml4(),!0)},h.initCore=function(d){if(typeof h.initCore.initialized!="undefined")return!1;h.initCore.initialized=!0,h.options=h.options||{},h.options.hashChangeInterval=h.options.hashChangeInterval||100,h.options.safariPollInterval=h.options.safariPollInterval||500,h.options.doubleCheckInterval=h.options.doubleCheckInterval||500,h.options.disableSuid=h.options.disableSuid||!1,h.options.storeInterval=h.options.storeInterval||1e3,h.options.busyDelay=h.options.busyDelay||250,h.options.debug=h.options.debug||!1,h.options.initialTitle=h.options.initialTitle||r.title,h.options.html4Mode=h.options.html4Mode||!1,h.options.delayInit=h.options.delayInit||!1,h.intervalList=[],h.clearAllIntervals=function(){var e,t=h.intervalList;if(typeof t!="undefined"&&t!==null){for(e=0;e<t.length;e++)f(t[e]);h.intervalList=null}},h.debug=function(){(h.options.debug||!1)&&h.log.apply(h,arguments)},h.log=function(){var e=typeof n!="undefined"&&typeof n.log!="undefined"&&typeof n.log.apply!="undefined",t=r.getElementById("log"),i,s,o,u,a;e?(u=Array.prototype.slice.call(arguments),i=u.shift(),typeof n.debug!="undefined"?n.debug.apply(n,[i,u]):n.log.apply(n,[i,u])):i="\n"+arguments[0]+"\n";for(s=1,o=arguments.length;s<o;++s){a=arguments[s];if(typeof a=="object"&&typeof l!="undefined")try{a=l.stringify(a)}catch(f){}i+="\n"+a+"\n"}return t?(t.value+=i+"\n-----\n",t.scrollTop=t.scrollHeight-t.clientHeight):e||c(i),!0},h.getInternetExplorerMajorVersion=function(){var e=h.getInternetExplorerMajorVersion.cached=typeof h.getInternetExplorerMajorVersion.cached!="undefined"?h.getInternetExplorerMajorVersion.cached:function(){var e=3,t=r.createElement("div"),n=t.getElementsByTagName("i");while((t.innerHTML="<!--[if gt IE "+ ++e+"]><i></i><![endif]-->")&&n[0]);return e>4?e:!1}();return e},h.isInternetExplorer=function(){var e=h.isInternetExplorer.cached=typeof h.isInternetExplorer.cached!="undefined"?h.isInternetExplorer.cached:Boolean(h.getInternetExplorerMajorVersion());return e},h.options.html4Mode?h.emulated={pushState:!0,hashChange:!0}:h.emulated={pushState:!Boolean(e.history&&e.history.pushState&&e.history.replaceState&&!/ Mobile\/([1-7][a-z]|(8([abcde]|f(1[0-8]))))/i.test(i.userAgent)&&!/AppleWebKit\/5([0-2]|3[0-2])/i.test(i.userAgent)),hashChange:Boolean(!("onhashchange"in e||"onhashchange"in r)||h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8)},h.enabled=!h.emulated.pushState,h.bugs={setHash:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),safariPoll:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),ieDoubleCheck:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8),hashEscape:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<7)},h.isEmptyObject=function(e){for(var t in e)if(e.hasOwnProperty(t))return!1;return!0},h.cloneObject=function(e){var t,n;return e?(t=l.stringify(e),n=l.parse(t)):n={},n},h.getRootUrl=function(){var e=r.location.protocol+"//"+(r.location.hostname||r.location.host);if(r.location.port||!1)e+=":"+r.location.port;return e+="/",e},h.getBaseHref=function(){var e=r.getElementsByTagName("base"),t=null,n="";return e.length===1&&(t=e[0],n=t.href.replace(/[^\/]+$/,"")),n=n.replace(/\/+$/,""),n&&(n+="/"),n},h.getBaseUrl=function(){var e=h.getBaseHref()||h.getBasePageUrl()||h.getRootUrl();return e},h.getPageUrl=function(){var e=h.getState(!1,!1),t=(e||{}).url||h.getLocationHref(),n;return n=t.replace(/\/+$/,"").replace(/[^\/]+$/,function(e,t,n){return/\./.test(e)?e:e+"/"}),n},h.getBasePageUrl=function(){var e=h.getLocationHref().replace(/[#\?].*/,"").replace(/[^\/]+$/,function(e,t,n){return/[^\/]$/.test(e)?"":e}).replace(/\/+$/,"")+"/";return e},h.getFullUrl=function(e,t){var n=e,r=e.substring(0,1);return t=typeof t=="undefined"?!0:t,/[a-z]+\:\/\//.test(e)||(r==="/"?n=h.getRootUrl()+e.replace(/^\/+/,""):r==="#"?n=h.getPageUrl().replace(/#.*/,"")+e:r==="?"?n=h.getPageUrl().replace(/[\?#].*/,"")+e:t?n=h.getBaseUrl()+e.replace(/^(\.\/)+/,""):n=h.getBasePageUrl()+e.replace(/^(\.\/)+/,"")),n.replace(/\#$/,"")},h.getShortUrl=function(e){var t=e,n=h.getBaseUrl(),r=h.getRootUrl();return h.emulated.pushState&&(t=t.replace(n,"")),t=t.replace(r,"/"),h.isTraditionalAnchor(t)&&(t="./"+t),t=t.replace(/^(\.\/)+/g,"./").replace(/\#$/,""),t},h.getLocationHref=function(e){return e=e||r,e.URL===e.location.href?e.location.href:e.location.href===decodeURIComponent(e.URL)?e.URL:e.location.hash&&decodeURIComponent(e.location.href.replace(/^[^#]+/,""))===e.location.hash?e.location.href:e.URL.indexOf("#")==-1&&e.location.href.indexOf("#")!=-1?e.location.href:e.URL||e.location.href},h.store={},h.idToState=h.idToState||{},h.stateToId=h.stateToId||{},h.urlToId=h.urlToId||{},h.storedStates=h.storedStates||[],h.savedStates=h.savedStates||[],h.normalizeStore=function(){h.store.idToState=h.store.idToState||{},h.store.urlToId=h.store.urlToId||{},h.store.stateToId=h.store.stateToId||{}},h.getState=function(e,t){typeof e=="undefined"&&(e=!0),typeof t=="undefined"&&(t=!0);var n=h.getLastSavedState();return!n&&t&&(n=h.createStateObject()),e&&(n=h.cloneObject(n),n.url=n.cleanUrl||n.url),n},h.getIdByState=function(e){var t=h.extractId(e.url),n;if(!t){n=h.getStateString(e);if(typeof h.stateToId[n]!="undefined")t=h.stateToId[n];else if(typeof h.store.stateToId[n]!="undefined")t=h.store.stateToId[n];else{for(;;){t=(new Date).getTime()+String(Math.random()).replace(/\D/g,"");if(typeof h.idToState[t]=="undefined"&&typeof h.store.idToState[t]=="undefined")break}h.stateToId[n]=t,h.idToState[t]=e}}return t},h.normalizeState=function(e){var t,n;if(!e||typeof e!="object")e={};if(typeof e.normalized!="undefined")return e;if(!e.data||typeof e.data!="object")e.data={};return t={},t.normalized=!0,t.title=e.title||"",t.url=h.getFullUrl(e.url?e.url:h.getLocationHref()),t.hash=h.getShortUrl(t.url),t.data=h.cloneObject(e.data),t.id=h.getIdByState(t),t.cleanUrl=t.url.replace(/\??\&_suid.*/,""),t.url=t.cleanUrl,n=!h.isEmptyObject(t.data),(t.title||n)&&h.options.disableSuid!==!0&&(t.hash=h.getShortUrl(t.url).replace(/\??\&_suid.*/,""),/\?/.test(t.hash)||(t.hash+="?"),t.hash+="&_suid="+t.id),t.hashedUrl=h.getFullUrl(t.hash),(h.emulated.pushState||h.bugs.safariPoll)&&h.hasUrlDuplicate(t)&&(t.url=t.hashedUrl),t},h.createStateObject=function(e,t,n){var r={data:e,title:t,url:n};return r=h.normalizeState(r),r},h.getStateById=function(e){e=String(e);var n=h.idToState[e]||h.store.idToState[e]||t;return n},h.getStateString=function(e){var t,n,r;return t=h.normalizeState(e),n={data:t.data,title:e.title,url:e.url},r=l.stringify(n),r},h.getStateId=function(e){var t,n;return t=h.normalizeState(e),n=t.id,n},h.getHashByState=function(e){var t,n;return t=h.normalizeState(e),n=t.hash,n},h.extractId=function(e){var t,n,r,i;return e.indexOf("#")!=-1?i=e.split("#")[0]:i=e,n=/(.*)\&_suid=([0-9]+)$/.exec(i),r=n?n[1]||e:e,t=n?String(n[2]||""):"",t||!1},h.isTraditionalAnchor=function(e){var t=!/[\/\?\.]/.test(e);return t},h.extractState=function(e,t){var n=null,r,i;return t=t||!1,r=h.extractId(e),r&&(n=h.getStateById(r)),n||(i=h.getFullUrl(e),r=h.getIdByUrl(i)||!1,r&&(n=h.getStateById(r)),!n&&t&&!h.isTraditionalAnchor(e)&&(n=h.createStateObject(null,null,i))),n},h.getIdByUrl=function(e){var n=h.urlToId[e]||h.store.urlToId[e]||t;return n},h.getLastSavedState=function(){return h.savedStates[h.savedStates.length-1]||t},h.getLastStoredState=function(){return h.storedStates[h.storedStates.length-1]||t},h.hasUrlDuplicate=function(e){var t=!1,n;return n=h.extractState(e.url),t=n&&n.id!==e.id,t},h.storeState=function(e){return h.urlToId[e.url]=e.id,h.storedStates.push(h.cloneObject(e)),e},h.isLastSavedState=function(e){var t=!1,n,r,i;return h.savedStates.length&&(n=e.id,r=h.getLastSavedState(),i=r.id,t=n===i),t},h.saveState=function(e){return h.isLastSavedState(e)?!1:(h.savedStates.push(h.cloneObject(e)),!0)},h.getStateByIndex=function(e){var t=null;return typeof e=="undefined"?t=h.savedStates[h.savedStates.length-1]:e<0?t=h.savedStates[h.savedStates.length+e]:t=h.savedStates[e],t},h.getCurrentIndex=function(){var e=null;return h.savedStates.length<1?e=0:e=h.savedStates.length-1,e},h.getHash=function(e){var t=h.getLocationHref(e),n;return n=h.getHashByUrl(t),n},h.unescapeHash=function(e){var t=h.normalizeHash(e);return t=decodeURIComponent(t),t},h.normalizeHash=function(e){var t=e.replace(/[^#]*#/,"").replace(/#.*/,"");return t},h.setHash=function(e,t){var n,i;return t!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.setHash,args:arguments,queue:t}),!1):(h.busy(!0),n=h.extractState(e,!0),n&&!h.emulated.pushState?h.pushState(n.data,n.title,n.url,!1):h.getHash()!==e&&(h.bugs.setHash?(i=h.getPageUrl(),h.pushState(null,null,i+"#"+e,!1)):r.location.hash=e),h)},h.escapeHash=function(t){var n=h.normalizeHash(t);return n=e.encodeURIComponent(n),h.bugs.hashEscape||(n=n.replace(/\%21/g,"!").replace(/\%26/g,"&").replace(/\%3D/g,"=").replace(/\%3F/g,"?")),n},h.getHashByUrl=function(e){var t=String(e).replace(/([^#]*)#?([^#]*)#?(.*)/,"$2");return t=h.unescapeHash(t),t},h.setTitle=function(e){var t=e.title,n;t||(n=h.getStateByIndex(0),n&&n.url===e.url&&(t=n.title||h.options.initialTitle));try{r.getElementsByTagName("title")[0].innerHTML=t.replace("<","&lt;").replace(">","&gt;").replace(" & "," &amp; ")}catch(i){}return r.title=t,h},h.queues=[],h.busy=function(e){typeof e!="undefined"?h.busy.flag=e:typeof h.busy.flag=="undefined"&&(h.busy.flag=!1);if(!h.busy.flag){u(h.busy.timeout);var t=function(){var e,n,r;if(h.busy.flag)return;for(e=h.queues.length-1;e>=0;--e){n=h.queues[e];if(n.length===0)continue;r=n.shift(),h.fireQueueItem(r),h.busy.timeout=o(t,h.options.busyDelay)}};h.busy.timeout=o(t,h.options.busyDelay)}return h.busy.flag},h.busy.flag=!1,h.fireQueueItem=function(e){return e.callback.apply(e.scope||h,e.args||[])},h.pushQueue=function(e){return h.queues[e.queue||0]=h.queues[e.queue||0]||[],h.queues[e.queue||0].push(e),h},h.queue=function(e,t){return typeof e=="function"&&(e={callback:e}),typeof t!="undefined"&&(e.queue=t),h.busy()?h.pushQueue(e):h.fireQueueItem(e),h},h.clearQueue=function(){return h.busy.flag=!1,h.queues=[],h},h.stateChanged=!1,h.doubleChecker=!1,h.doubleCheckComplete=function(){return h.stateChanged=!0,h.doubleCheckClear(),h},h.doubleCheckClear=function(){return h.doubleChecker&&(u(h.doubleChecker),h.doubleChecker=!1),h},h.doubleCheck=function(e){return h.stateChanged=!1,h.doubleCheckClear(),h.bugs.ieDoubleCheck&&(h.doubleChecker=o(function(){return h.doubleCheckClear(),h.stateChanged||e(),!0},h.options.doubleCheckInterval)),h},h.safariStatePoll=function(){var t=h.extractState(h.getLocationHref()),n;if(!h.isLastSavedState(t))return n=t,n||(n=h.createStateObject()),h.Adapter.trigger(e,"popstate"),h;return},h.back=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.back,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.back(!1)}),p.go(-1),!0)},h.forward=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.forward,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.forward(!1)}),p.go(1),!0)},h.go=function(e,t){var n;if(e>0)for(n=1;n<=e;++n)h.forward(t);else{if(!(e<0))throw new Error("History.go: History.go requires a positive or negative integer passed.");for(n=-1;n>=e;--n)h.back(t)}return h};if(h.emulated.pushState){var v=function(){};h.pushState=h.pushState||v,h.replaceState=h.replaceState||v}else h.onPopState=function(t,n){var r=!1,i=!1,s,o;return h.doubleCheckComplete(),s=h.getHash(),s?(o=h.extractState(s||h.getLocationHref(),!0),o?h.replaceState(o.data,o.title,o.url,!1):(h.Adapter.trigger(e,"anchorchange"),h.busy(!1)),h.expectedStateId=!1,!1):(r=h.Adapter.extractEventData("state",t,n)||!1,r?i=h.getStateById(r):h.expectedStateId?i=h.getStateById(h.expectedStateId):i=h.extractState(h.getLocationHref()),i||(i=h.createStateObject(null,null,h.getLocationHref())),h.expectedStateId=!1,h.isLastSavedState(i)?(h.busy(!1),!1):(h.storeState(i),h.saveState(i),h.setTitle(i),h.Adapter.trigger(e,"statechange"),h.busy(!1),!0))},h.Adapter.bind(e,"popstate",h.onPopState),h.pushState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.pushState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.pushState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0},h.replaceState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.replaceState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.replaceState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0};if(s){try{h.store=l.parse(s.getItem("History.store"))||{}}catch(m){h.store={}}h.normalizeStore()}else h.store={},h.normalizeStore();h.Adapter.bind(e,"unload",h.clearAllIntervals),h.saveState(h.storeState(h.extractState(h.getLocationHref(),!0))),s&&(h.onUnload=function(){var e,t,n;try{e=l.parse(s.getItem("History.store"))||{}}catch(r){e={}}e.idToState=e.idToState||{},e.urlToId=e.urlToId||{},e.stateToId=e.stateToId||{};for(t in h.idToState){if(!h.idToState.hasOwnProperty(t))continue;e.idToState[t]=h.idToState[t]}for(t in h.urlToId){if(!h.urlToId.hasOwnProperty(t))continue;e.urlToId[t]=h.urlToId[t]}for(t in h.stateToId){if(!h.stateToId.hasOwnProperty(t))continue;e.stateToId[t]=h.stateToId[t]}h.store=e,h.normalizeStore(),n=l.stringify(e);try{s.setItem("History.store",n)}catch(i){if(i.code!==DOMException.QUOTA_EXCEEDED_ERR)throw i;s.length&&(s.removeItem("History.store"),s.setItem("History.store",n))}},h.intervalList.push(a(h.onUnload,h.options.storeInterval)),h.Adapter.bind(e,"beforeunload",h.onUnload),h.Adapter.bind(e,"unload",h.onUnload));if(!h.emulated.pushState){h.bugs.safariPoll&&h.intervalList.push(a(h.safariStatePoll,h.options.safariPollInterval));if(i.vendor==="Apple Computer, Inc."||(i.appCodeName||"")==="Mozilla")h.Adapter.bind(e,"hashchange",function(){h.Adapter.trigger(e,"popstate")}),h.getHash()&&h.Adapter.onDomLoad(function(){h.Adapter.trigger(e,"hashchange")})}},(!h.options||!h.options.delayInit)&&h.init()}(window)

/*!
 * imagesLoaded PACKAGED v4.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
!function(e,t){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",t):"object"==typeof module&&module.exports?module.exports=t():e.EvEmitter=t()}("undefined"!=typeof window?window:this,function(){function e(){}var t=e.prototype;return t.on=function(e,t){if(e&&t){var i=this._events=this._events||{},n=i[e]=i[e]||[];return n.indexOf(t)==-1&&n.push(t),this}},t.once=function(e,t){if(e&&t){this.on(e,t);var i=this._onceEvents=this._onceEvents||{},n=i[e]=i[e]||{};return n[t]=!0,this}},t.off=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){var n=i.indexOf(t);return n!=-1&&i.splice(n,1),this}},t.emitEvent=function(e,t){var i=this._events&&this._events[e];if(i&&i.length){i=i.slice(0),t=t||[];for(var n=this._onceEvents&&this._onceEvents[e],o=0;o<i.length;o++){var r=i[o],s=n&&n[r];s&&(this.off(e,r),delete n[r]),r.apply(this,t)}return this}},t.allOff=function(){delete this._events,delete this._onceEvents},e}),function(e,t){"use strict";"function"==typeof define&&define.amd?define(["ev-emitter/ev-emitter"],function(i){return t(e,i)}):"object"==typeof module&&module.exports?module.exports=t(e,require("ev-emitter")):e.imagesLoaded=t(e,e.EvEmitter)}("undefined"!=typeof window?window:this,function(e,t){function i(e,t){for(var i in t)e[i]=t[i];return e}function n(e){if(Array.isArray(e))return e;var t="object"==typeof e&&"number"==typeof e.length;return t?d.call(e):[e]}function o(e,t,r){if(!(this instanceof o))return new o(e,t,r);var s=e;return"string"==typeof e&&(s=document.querySelectorAll(e)),s?(this.elements=n(s),this.options=i({},this.options),"function"==typeof t?r=t:i(this.options,t),r&&this.on("always",r),this.getImages(),h&&(this.jqDeferred=new h.Deferred),void setTimeout(this.check.bind(this))):void a.error("Bad element for imagesLoaded "+(s||e))}function r(e){this.img=e}function s(e,t){this.url=e,this.element=t,this.img=new Image}var h=e.jQuery,a=e.console,d=Array.prototype.slice;o.prototype=Object.create(t.prototype),o.prototype.options={},o.prototype.getImages=function(){this.images=[],this.elements.forEach(this.addElementImages,this)},o.prototype.addElementImages=function(e){"IMG"==e.nodeName&&this.addImage(e),this.options.background===!0&&this.addElementBackgroundImages(e);var t=e.nodeType;if(t&&u[t]){for(var i=e.querySelectorAll("img"),n=0;n<i.length;n++){var o=i[n];this.addImage(o)}if("string"==typeof this.options.background){var r=e.querySelectorAll(this.options.background);for(n=0;n<r.length;n++){var s=r[n];this.addElementBackgroundImages(s)}}}};var u={1:!0,9:!0,11:!0};return o.prototype.addElementBackgroundImages=function(e){var t=getComputedStyle(e);if(t)for(var i=/url\((['"])?(.*?)\1\)/gi,n=i.exec(t.backgroundImage);null!==n;){var o=n&&n[2];o&&this.addBackground(o,e),n=i.exec(t.backgroundImage)}},o.prototype.addImage=function(e){var t=new r(e);this.images.push(t)},o.prototype.addBackground=function(e,t){var i=new s(e,t);this.images.push(i)},o.prototype.check=function(){function e(e,i,n){setTimeout(function(){t.progress(e,i,n)})}var t=this;return this.progressedCount=0,this.hasAnyBroken=!1,this.images.length?void this.images.forEach(function(t){t.once("progress",e),t.check()}):void this.complete()},o.prototype.progress=function(e,t,i){this.progressedCount++,this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded,this.emitEvent("progress",[this,e,t]),this.jqDeferred&&this.jqDeferred.notify&&this.jqDeferred.notify(this,e),this.progressedCount==this.images.length&&this.complete(),this.options.debug&&a&&a.log("progress: "+i,e,t)},o.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emitEvent(e,[this]),this.emitEvent("always",[this]),this.jqDeferred){var t=this.hasAnyBroken?"reject":"resolve";this.jqDeferred[t](this)}},r.prototype=Object.create(t.prototype),r.prototype.check=function(){var e=this.getIsImageComplete();return e?void this.confirm(0!==this.img.naturalWidth,"naturalWidth"):(this.proxyImage=new Image,this.proxyImage.addEventListener("load",this),this.proxyImage.addEventListener("error",this),this.img.addEventListener("load",this),this.img.addEventListener("error",this),void(this.proxyImage.src=this.img.src))},r.prototype.getIsImageComplete=function(){return this.img.complete&&this.img.naturalWidth},r.prototype.confirm=function(e,t){this.isLoaded=e,this.emitEvent("progress",[this,this.img,t])},r.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},r.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindEvents()},r.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindEvents()},r.prototype.unbindEvents=function(){this.proxyImage.removeEventListener("load",this),this.proxyImage.removeEventListener("error",this),this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype=Object.create(r.prototype),s.prototype.check=function(){this.img.addEventListener("load",this),this.img.addEventListener("error",this),this.img.src=this.url;var e=this.getIsImageComplete();e&&(this.confirm(0!==this.img.naturalWidth,"naturalWidth"),this.unbindEvents())},s.prototype.unbindEvents=function(){this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype.confirm=function(e,t){this.isLoaded=e,this.emitEvent("progress",[this,this.element,t])},o.makeJQueryPlugin=function(t){t=t||e.jQuery,t&&(h=t,h.fn.imagesLoaded=function(e,t){var i=new o(this,e,t);return i.jqDeferred.promise(h(this))})},o.makeJQueryPlugin(),o});


(function($){
"use strict";


	function prdctfltr_sort_classes() {
		if ( prdctfltr.ajax_class == '' ) {
			prdctfltr.ajax_class = '.products';
		}
		if ( prdctfltr.ajax_category_class == '' ) {
			prdctfltr.ajax_category_class = '.product-category';
		}
		if ( prdctfltr.ajax_product_class == '' ) {
			prdctfltr.ajax_product_class = '.type-product';
		}
		if ( prdctfltr.ajax_pagination_class == '' ) {
			prdctfltr.ajax_pagination_class = '.woocommerce-pagination';
		}
		if ( prdctfltr.ajax_count_class == '' ) {
			prdctfltr.ajax_count_class = '.woocommerce-result-count';
		}
		if ( prdctfltr.ajax_orderby_class == '' ) {
			prdctfltr.ajax_orderby_class = '.woocommerce-ordering';
		}
	}
	prdctfltr_sort_classes();
	
	// $(prdctfltr.ajax_pagination_class).children().off();
	// $('.prdctfltr_woocommerce_ordering').off();
	//$('.prdctfltr_wc').children().off();

	function mobile() {
		var css = '';
		$('.prdctfltr_mobile').each( function() {
			var id = $(this).prev().attr('data-id');
			css += '@media screen and (min-width: '+$(this).prev().attr('data-mobile')+'px) {.prdctfltr_wc[data-id="'+id+'"] {display:block;}.prdctfltr_wc[data-id="'+id+'"] + .prdctfltr_mobile {display:none;}}@media screen and (max-width: '+$(this).prev().attr('data-mobile')+'px) {.prdctfltr_wc[data-id="'+id+'"] {display:none;}.prdctfltr_wc[data-id="'+id+'"] +.prdctfltr_mobile {display:block;}}';
		});

		$('.prdctfltr_mobile_show').each( function() {
			var id = $(this).attr('data-id');
			css += '@media screen and (min-width: '+$(this).attr('data-mobile')+'px) {.prdctfltr_wc[data-id="'+id+'"] {display:block;}}';
		});

		$('.prdctfltr_mobile_hide').each( function() {
			var id = $(this).attr('data-id');
			css += '@media screen and (min-width: '+$(this).attr('data-mobile')+'px) {.prdctfltr_wc[data-id="'+id+'"] {display:none;}}>';
		});

		$('head').append('<style type="text/css">'+css+'</style>');
	}
	mobile();

	var pf_singlesc = false;
	if ( $('.prdctfltr_sc_products.prdctfltr_ajax '+prdctfltr.ajax_class).length == 1 && $('.prdctfltr_wc:not(.prdctfltr_step_filter)').length > 0 ) {
		$('body').addClass('prdctfltr-sc');
		pf_singlesc = 1;
	}
	else {
		prdctfltr.active_sc = '';
	}

	var pf_failsafe = false;
	function ajax_failsafe() {
		if ( prdctfltr.ajax_failsafe.length == 0 ) {
			return false;
		}
		if ( $('.prdctfltr_sc_products').length > 0 ) {
			return false;
		}
		if ( $('body').hasClass('prdctfltr-ajax') ) {
			pf_failsafe = false;
			if( $.inArray('wrapper', prdctfltr.ajax_failsafe) !== -1 ) {
				if ( $(prdctfltr.ajax_class).length < 1 ) {
					pf_failsafe = true;
				}
			}
			if( $.inArray('product', prdctfltr.ajax_failsafe) !== -1 ) {
				if ( $(prdctfltr.ajax_class+' '+prdctfltr.ajax_product_class).length < 1 && $(prdctfltr.ajax_class+' '+prdctfltr.ajax_category_class).length < 1 ) {
					pf_failsafe = true;
				}
			}

			if( $.inArray('pagination', prdctfltr.ajax_failsafe) !== -1 ) {
				if ( $(prdctfltr.ajax_pagination_class).length < 1 ) {
					pf_failsafe = true;
				}
			}

			if ( pf_failsafe === true ) {
				console.log('PF: AJAX Failsafe active.');
			}
		}
	}
	ajax_failsafe();

	prdctfltr.clearall = ( $.isArray(prdctfltr.clearall) === true ? prdctfltr.clearall : false );

	var archiveAjax = false;
	if ( $('body').hasClass('prdctfltr-ajax') && pf_failsafe === false ) {
		archiveAjax = true;
	}

	if ( archiveAjax === true || pf_singlesc ) {
		var pageFilters = {};
		var makeHistory = {};

		$('.prdctfltr_wc').each( function() {
			pageFilters[$(this).attr('data-id')] = $("<div />").append($(this).clone()).html();
		});

		if ( prdctfltr.rangefilters ) {
			pageFilters.ranges = prdctfltr.rangefilters;
		}

		pageFilters.products = $("<div />").append($(prdctfltr.ajax_class).clone()).html();
		pageFilters.pagination = $("<div />").append($(prdctfltr.ajax_pagination_class).clone()).html();
		pageFilters.count = $("<div />").append($(prdctfltr.ajax_count_class).clone()).html();
		pageFilters.orderby = $("<div />").append($(prdctfltr.ajax_orderby_class).clone()).html();
		pageFilters.title = $("<div />").append($('h1.page-title').clone()).html();
		pageFilters.desc = $("<div />").append($('.term-description:first, .page-description:first').clone()).html();
		pageFilters.loop_start = $('<ul class="products">');
		pageFilters.prdctfltr = prdctfltr;

		var historyId = guid();

		makeHistory[historyId] = pageFilters;
		history.replaceState({filters:historyId, archiveAjax:true, shortcodeAjax:false}, document.title, '');
	}

	function guid() {
		function s4() {
			return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
		}
		return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
	}

	var ajaxActive = false;

	$.expr[':'].Contains = function(a,i,m){
		return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
	};

	String.prototype.getValueByKey = function (k) {
		var p = new RegExp('\\b' + k + '\\b', 'gi');
		return this.search(p) != -1 ? decodeURIComponent(this.substr(this.search(p) + k.length + 1).substr(0, this.substr(this.search(p) + k.length + 1).search(/(&|;|$)/))) : "";
	};

	var startInit = false;

	function __call_meta_range(i,obj3) {

		var currTax = $('#'+i).attr('data-filter');

		obj3.prettify_enabled = false;
				
		if ( u(obj3.prettyValues) ) {
			obj3.prettify_enabled = true;
			
			obj3.prettify = function (num) {
				return obj3.prettyValues[num];
			};
		}

		obj3.onChange = function (data) {
			startInit = true;
		};

		obj3.onFinish = function (data) {
			if ( startInit === true ) {

				startInit = false;

				var iValue = '';

				if ( data.min == data.from && data.max == data.to ) {

					var ourObj = prdctfltr_get_obj_580($('#'+i).closest('.prdctfltr_wc'));

					$.each( ourObj, function(i, obj) {

						$(obj).find('input[name="'+currTax+'"]').val('');
						$(obj).find('.prdctfltr_range input[data-filter="'+currTax+'"]:not(#'+i+')').each(function() {
							var range = $(this).data("ionRangeSlider");
							range.update({
								from: data.min,
								to: data.max
							});
						});

					});

					$('#'+i).closest('.prdctfltr_filter').find('input[name="'+currTax+'"]:first').trigger('change');

				}
				else {

					if ( obj3.prettify_enabled === true ) {
						$.each( obj3.prettyValues.slice(data.from,data.to+1), function(i,e) {
							iValue += (i==0?'':',')+$(obj3.prettyValues[data.from+i]).text();
						})

					}
					else {
						iValue = data.from+','+data.to;
					}

					var ourObj = prdctfltr_get_obj_580($('#'+i).closest('.prdctfltr_wc'));

					$.each( ourObj, function(i, obj) {

						$(obj).find('input[name="'+currTax+'"]').val(iValue);

						$(obj).find('.prdctfltr_range input[data-filter="'+currTax+'"]:not(#'+i+')').each(function() {
							var range = $(this).data("ionRangeSlider");

							if ( typeof range !== 'undefined' ) {
								range.update({
									from: data.from,
									to: data.to
								});
							}
							
						});

					});

					$('#'+i).closest('.prdctfltr_filter').find('input[name="'+currTax+'"]:first').trigger('change');

				}

				var curr_filter = $('#'+i).closest('.prdctfltr_wc');

				if ( curr_filter.hasClass('prdctfltr_tabbed_selection') && curr_filter.hasClass('prdctfltr_click') ) {
					curr_filter.find('.prdctfltr_filter').each( function() {
						if ( $(this).find('input[type="hidden"]:first').length > 0 && $(this).find('input[type="hidden"]:first').val() !== '' ) {
							if ( !$(this).hasClass('prdctfltr_has_selection') ) {
								$(this).addClass('prdctfltr_has_selection');
							}
							
						}
						else {
							if ( $(this).hasClass('prdctfltr_has_selection') ) {
								$(this).removeClass('prdctfltr_has_selection');
							}
						}
					});
				}

				var ourObj = prdctfltr_get_obj_580(curr_filter);

				$.each( ourObj, function(i, obj) {
					var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+currTax+'"]');
					pfObj.each( function(){
						check_selection_boxes($(this),'look');
					});
				});

			}
		};

		$('#'+i).ionRangeSlider(obj3);
		ranges[i] = $('#'+i).data('ionRangeSlider');

	}

	function __call_taxonomy_range(i,obj3) {

		var currTax = $('#'+i).attr('data-filter');

		if ( currTax !== 'price' ) {
			obj3.prettify_enabled = true;
			
			obj3.prettify = function (num) {
				return obj3.prettyValues[num];
			};
		}

		obj3.onChange = function (data) {
			startInit = true;
		};

		obj3.onFinish = function (data) {
			if ( startInit === true ) {

				startInit = false;

				if ( data.min == data.from && data.max == data.to ) {

					var ourObj = prdctfltr_get_obj_580($('#'+i).closest('.prdctfltr_wc'));

					$.each( ourObj, function(i, obj) {

						$(obj).find('input[name="rng_min_'+currTax+'"]').val('');
						$(obj).find('input[name="rng_max_'+currTax+'"]').val('');
						$(obj).find('.prdctfltr_range input[data-filter="'+currTax+'"]:not(#'+i+')').each(function() {
							var range = $(this).data("ionRangeSlider");
							range.update({
								from: data.min,
								to: data.max
							});
						});

					});

					$('#'+i).closest('.prdctfltr_filter').find('input[name="rng_max_'+currTax+'"]:first').trigger('change');


				}
				else {

					var minVal = ( currTax == 'price' ?
						data.from :
						$(obj3.prettyValues[data.from]).text() );

					var maxVal = ( currTax == 'price' ?
						data.to :
						$(obj3.prettyValues[data.to]).text() );

					var ourObj = prdctfltr_get_obj_580($('#'+i).closest('.prdctfltr_wc'));

					$.each( ourObj, function(i, obj) {

						$(obj).find('input[name="rng_min_'+currTax+'"]').val(minVal);
						$(obj).find('input[name="rng_max_'+currTax+'"]').val(maxVal);

						$(obj).find('.prdctfltr_range input[data-filter="'+currTax+'"]:not(#'+i+')').each(function() {
							var range = $(this).data("ionRangeSlider");

							if ( typeof range !== 'undefined' ) {
								range.update({
									from: data.from,
									to: data.to
								});
							}
							
						});

					});

					$('#'+i).closest('.prdctfltr_filter').find('input[name="rng_max_'+currTax+'"]:first').trigger('change');

				}

				var curr_filter = $('#'+i).closest('.prdctfltr_wc');
				if ( curr_filter.hasClass('prdctfltr_tabbed_selection') && curr_filter.hasClass('prdctfltr_click') ) {
					curr_filter.find('.prdctfltr_filter').each( function() {
						if ( $(this).find('input[type="hidden"]:first').length > 0 && $(this).find('input[type="hidden"]:first').val() !== '' ) {
							if ( !$(this).hasClass('prdctfltr_has_selection') ) {
								$(this).addClass('prdctfltr_has_selection');
							}
							
						}
						else {
							if ( $(this).hasClass('prdctfltr_has_selection') ) {
								$(this).removeClass('prdctfltr_has_selection');
							}
						}
					});
				}

				var ourObj = prdctfltr_get_obj_580(curr_filter);

				$.each( ourObj, function(i, obj) {
					var pfObj = $(obj).find('.prdctfltr_filter[data-filter="rng_'+currTax+'"]');
					pfObj.each( function(){
						check_selection_boxes($(this),'look');
					});
				});

			}
		};

		$('#'+i).ionRangeSlider(obj3);
		ranges[i] = $('#'+i).data('ionRangeSlider');

	}

	function init_ranges() {

		$.each( prdctfltr.rangefilters, function(i, obj3) {

			if ( $('#'+i).length>0 ) {
				if ( $('#'+i).closest('.prdctfltr_filter').hasClass('prdctfltr_meta_range') ) {
					__call_meta_range(i,obj3);
				}
				else {
					__call_taxonomy_range(i,obj3);
				}
			}
		} );

	}

	var ranges = {};
	init_ranges();

	function reorder_selected(curr) {
		curr = ( curr == null ? $('.prdctfltr_wc') : curr );
		if( curr.find('label.prdctfltr_active').length == 0 ) {
			return;
		}
		curr.each( function() {
			var currEl = $(this);
			if ( $(this).hasClass('prdctfltr_selected_reorder') ) {
				currEl.find('.prdctfltr_filter.prdctfltr_attributes:not(.prdctfltr_hierarchy) .prdctfltr_checkboxes, .prdctfltr_filter.prdctfltr_vendor .prdctfltr_checkboxes, .prdctfltr_filter.prdctfltr_byprice .prdctfltr_checkboxes, .prdctfltr_filter.prdctfltr_orderby .prdctfltr_checkboxes').each( function() {
					var checkboxes = $(this);
					if ( checkboxes.find('label.prdctfltr_active').length > 0 ) {
						$(checkboxes.find('label.prdctfltr_active').get().reverse()).each( function () {
							var addThis = $(this);
							$(this).remove();
							if ( checkboxes.find('label.prdctfltr_ft_none:first').length>0 ) {
								checkboxes.find('label.prdctfltr_ft_none:first').after(addThis);
							}
							else {
								checkboxes.prepend(addThis);
							}
						});
					}
				});
			}
		});
	}
	reorder_selected();

	function reorder_adoptive(curr) {

		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.each( function() {

			var currEl = $(this);

			if ( $(this).hasClass('prdctfltr_adoptive_reorder') ) {
				currEl.find('.prdctfltr_adoptive').each( function() {
					var filter = $(this);
					if ( filter.find('.pf_adoptive_hide').length > 0 ) {
						var checkboxes = filter.find('.prdctfltr_checkboxes');
						filter.find('.pf_adoptive_hide').each( function() {
							var addThis = $(this);
							$(this).remove();
							checkboxes.append(addThis);
						});
					}
				});
			}

		});

	}
	reorder_adoptive();

	$(document).on('click', '.pf_more:not(.pf_activated)', function() {
		var filter = $(this).closest('.prdctfltr_attributes, .prdctfltr_meta');
		var checkboxes = filter.find('.prdctfltr_checkboxes');

		if ( filter.hasClass('pf_adptv_default') ) {
			var searchIn = 'label:not(.pf_adoptive_hide)';
		}
		else {
			var searchIn = 'label';
		}

		var displayType = checkboxes.find(searchIn+':first').css('display');

		checkboxes.find(searchIn).attr('style', 'display:'+displayType+' !important');
		checkboxes.find('.pf_more').addClass('pf_activated').html('<span>'+prdctfltr.localization.show_less+'</span>');

		if ( filter.closest('.prdctfltr_wc').hasClass('pf_mod_masonry') ) {
			filter.closest('.prdctfltr_filter_inner').isotope('layout');
		}
	});

	$(document).on('click', '.pf_more.pf_activated', function() {
		var filter = $(this).closest('.prdctfltr_attributes, .prdctfltr_meta');
		var checkboxes = filter.find('.prdctfltr_checkboxes');

		if ( filter.hasClass('pf_adptv_default') ) {
			var searchIn = 'label:not(.pf_adoptive_hide)';
		}
		else {
			var searchIn = 'label';
		}
		checkboxes.each(function(){
			var max = parseInt(filter.attr('data-limit'), 10)-1;
			if (max !== 0 && $(this).find(searchIn).length > max+1) {

				$(this).find(searchIn+':gt('+max+')').attr('style', 'display:none !important');
				$(this).find('.pf_more').html('<span>'+prdctfltr.localization.show_more+'</span>').removeClass('pf_activated');

				if ( filter.closest('.prdctfltr_wc').hasClass('pf_mod_masonry') ) {
					filter.closest('.prdctfltr_filter_inner').isotope('layout');
				}
			}
		});
	});

	function set_select_index(curr) {

		curr = ( curr == null ? $('.prdctfltr_woocommerce') : curr );

		curr.each( function() {

			var curr_el = $(this);

			var selects = curr_el.find('.pf_select .prdctfltr_filter');
			if ( selects.length > 0 ) {
				var zIndex = selects.length;
				selects.each( function() {
					$(this).css({'z-index':zIndex});
					zIndex--;
				});
			}
		});

	}
	set_select_index();

	function init_search(curr) {

		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.each( function() {

			var curr_el = $(this);

			curr_el.find('input.pf_search').each( function() {

					$(this).keyup( function () {
						if ($(this).next().is(':hidden')) {
							$(this).next().show();
						}
					});

			});
		});
	}
	init_search();

	$(document).on( 'keydown', '.pf_search', function() {
		if(event.which==13) {
			$(this).next().trigger('click');
			return false;
		}
	});

	$(document).on( 'click', '.pf_search_trigger', function() {
		var wc = $(this).closest('.prdctfltr_wc');

		if ( $(this).prev().val() == '' ) {
			$('.prdctfltr_filter input[name="s"], .prdctfltr_add_inputs input[name="s"]').remove();
		}

		if ( !wc.hasClass('prdctfltr_click_filter') ) {
			wc.find('.prdctfltr_woocommerce_filter_submit').trigger('click');
		}
		else {
			var obj = wc.find('.prdctfltr_woocommerce_ordering');
			prdctfltr_respond_550(obj);
		}

		return false;
	});


	function is_touch_device() {
		return 'ontouchstart' in window || navigator.maxTouchPoints;
	}

	function prdctfltr_init_tooltips(c) {

		if ( is_touch_device() !== true ) {

			c = ( c == null ? $('.prdctfltr_woocommerce') : c );

			c.each( function() {

				var $tooltips = $(this).find('.prdctfltr_filter :not(.prdctfltr_terms_customized_select) label');

				$tooltips.each( function() {

					var $l = $(this);
					var $t = $l.find('.prdctfltr_tooltip');

					if ( $t.length>0 ) {

						var f = {

							timeout: 150,

							over: function () {
								if ( $('body > .pf_fixtooltip').length>0 ) {
									$('body > .pf_fixtooltip').remove();
								}

								var p = getCoords($l);

								$('body').append('<div class="pf_fixtooltip" style="z-index:999999;position:fixed;top:'+p.top+'px;left:'+(p.left+$l.width()/2)+'px;">'+$('<div></div>').append($t.clone()).html()+'</div>');

								setTimeout( function() {
									$('body > .pf_fixtooltip').addClass('prdctfltr_hover');
								}, 10 );

							},

							out: function () {

								$('body > .prdctfltr_hover').removeClass('prdctfltr_hover').addClass('prdctfltr_removeme');

								setTimeout( function() {
									$('body > .prdctfltr_removeme').remove();
								}, 150 );

							},

						};

						$l.hoverIntent( f );

					}

				} );

			} );

		}

	}

	function prdctfltr_init_tooltips_old(curr) {
		if (is_touch_device()!==true) {
			curr = ( curr == null ? $('.prdctfltr_woocommerce') : curr );

			curr.each( function() {
				var curr_el = $(this);
				var fixedTooltips = false;
				if (curr_el.hasClass('prdctfltr_maxheight')) {
					fixedTooltips = true;
				}

				var $pf_tooltips = curr_el.find('.prdctfltr_filter :not(.prdctfltr_terms_customized_select) label');

				$pf_tooltips
				.on('mouseenter', function() {
					var $this = $(this);
					var position = getCoords($this);

					if ($this.prop('hoverTimeout')) {
						$this.prop('hoverTimeout', clearTimeout($this.prop('hoverTimeout')));
					}

					$this.prop('hoverIntent', setTimeout(function() {
						if ( fixedTooltips===true ) {
							var toolTip = $this.find('.prdctfltr_tooltip');

							toolTip.css({'top':position.top-$this.innerHeight()/2-15+'px', 'left':position.left-1+$this.innerWidth()/2+'px', 'height':$this.height()});
							$('body').append('<div class="pf_fixtooltip">'+$('<div></div>').append(toolTip.clone()).html()+'</div>');
							setTimeout(function() {
								$('body > .pf_fixtooltip:last').addClass('prdctfltr_hover');
							},10);
							
						}
						else {
							$this.addClass('prdctfltr_hover');
						}

					}, 250));
				})
				.on('mouseleave', function() {
					var $this = $(this);

					if ($this.prop('hoverIntent')) {
						$this.prop('hoverIntent', clearTimeout($this.prop('hoverIntent')));
					}

					$this.prop('hoverTimeout', setTimeout(function() {
						if ( fixedTooltips===true ) {
							$('body > .prdctfltr_hover:first').removeClass('prdctfltr_hover').addClass('prdctfltr_removeme');
							setTimeout(function() {
								$('body > .prdctfltr_removeme:first').remove();
								$this.find('.prdctfltr_tooltip').removeAttr('style');
							},250);
						}
						else {
							$this.removeClass('prdctfltr_hover');
						}
					}, 250));
				});
			});
		}
	}
	prdctfltr_init_tooltips();

	function getCoords( elem ) {
		var box = elem[0].getBoundingClientRect();

		var body = document.body;
		var docEl = document.documentElement;

		var clientTop = docEl.clientTop || body.clientTop || 0;
		var clientLeft = docEl.clientLeft || body.clientLeft || 0;

		var top  = box.top - clientTop;
		var left = box.left - clientLeft;

		return { top: Math.round(top), left: Math.round(left) };
	}

	function reorder_limit(curr) {
		curr = ( typeof curr == 'undefined' ? $('.prdctfltr_wc') : curr );

		curr.each( function() {

			var curr_el = $(this);

			if ( curr_el.hasClass('pf_adptv_default') ) {
				var searchIn = 'label:not(.pf_adoptive_hide)';
			}
			else {
				var searchIn = 'label';
			}

			curr_el.find('.prdctfltr_attributes, .prdctfltr_meta').each( function() {
				var filter = $(this);
				var checkboxes = filter.find('.prdctfltr_checkboxes');
				checkboxes.each(function(){
					var max = parseInt(filter.attr('data-limit'), 10);
					if (max != 0 && $(this).find(searchIn).length > max+1) {
						$(this).find(searchIn+':gt('+max+')').attr('style', 'display:none !important')
						$(this).find(searchIn+':last').after($('<div class="pf_more"><span>'+prdctfltr.localization.show_more+'</span></div>'));
					}
				});
			});
		});
	}
	reorder_limit();

	function prdctfltr_init_scroll(curr) {

		curr = ( curr == null ? $('.prdctfltr_wc') : curr );
		var wrap = curr.find('.prdctfltr_filter_wrapper');

		if ( curr.hasClass('pf_mod_row') && curr.hasClass('prdctfltr_scroll_default') ) {
			if ( curr.find('.prdctfltr_filter').length > parseInt( wrap.attr('data-columns'), 10 ) ) {
				wrap.css('overflow-x', 'scroll');
			}
		}

		if ( curr.hasClass('prdctfltr_scroll_active') && curr.hasClass('prdctfltr_maxheight') ) {

			var wrapper = curr.find('.prdctfltr_filter:not(.prdctfltr_range,.prdctfltr_search) .prdctfltr_add_scroll');

			wrapper.mCustomScrollbar({
				axis:'y',
				scrollInertia:550,
				autoExpandScrollbar:true,
				advanced:{
					updateOnBrowserResize:true,
					updateOnContentResize:true
				}
			});

			if ( !curr.hasClass('prdctfltr_wc_widget') && curr.hasClass('pf_mod_row') && ( curr.find('.prdctfltr_checkboxes').length > $('.prdctfltr_filter_wrapper:first').attr('data-columns') ) ) {

				if ( curr.hasClass('prdctfltr_slide') ) {
					curr.find('.prdctfltr_woocommerce_ordering').show();
				}

				var curr_scroll_column = curr.find('.prdctfltr_filter:first').outerWidth();
				var curr_columns = curr.find('.prdctfltr_filter').length;

				curr.find('.prdctfltr_filter_inner').css('width', curr_columns*curr_scroll_column);
				curr.find('.prdctfltr_filter').css('width', curr_scroll_column);
				
				wrap.mCustomScrollbar({
					axis:'x',
					scrollInertia:550,
					scrollbarPosition:'outside',
					autoExpandScrollbar:true,
					advanced:{
						updateOnBrowserResize:true,
						updateOnContentResize:false
					}
				});

				if ( curr.hasClass('prdctfltr_slide') ) {
					curr.find('.prdctfltr_woocommerce_ordering').hide();
				}

			}

			if ( $('.prdctfltr-widget').length == 0 || $('.prdctfltr-widget .prdctfltr_error').length == 1 ) {
				curr.find('.prdctfltr_slide .prdctfltr_woocommerce_ordering').hide();
			}

		}

	}

	function prdctfltr_cats_mode_700(curr) {

		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.each(function(i,obj) {

			obj = $(obj);
			var checkFilters = obj.find('.prdctfltr_attributes');

			checkFilters.each(function(){

				var mode = false;

				if ( $(this).hasClass('prdctfltr_drill') ) {
					mode = 'drill';
				}
				if ( $(this).hasClass('prdctfltr_drillback') ) {
					mode = 'drillback';
				}
				if ( $(this).hasClass('prdctfltr_subonly') ) {
					mode = 'subonly';
				}
				if ( $(this).hasClass('prdctfltr_subonlyback') ) {
					mode = 'subonlyback';
				}
				if ( mode === false ) {
					return true;
				}

				var doIt = true;
				var checkCheckboxes = $(this).find('.prdctfltr_checkboxes');

				if ( mode == 'subonly' || mode == 'subonlyback' ) {
					if ( checkCheckboxes.find('label.prdctfltr_active').length > 1 ) {
						if ( checkCheckboxes.find('> label.prdctfltr_active').length > 1 ) {
							doIt = false;
						}
						var checkParents = '';
						checkCheckboxes.find('label.prdctfltr_active input[type="checkbox"]').each( function() {
							if ( checkParents == '' ) {
								checkParents = ( $(this).attr('data-parent') ? $(this).attr('data-parent') : '%toplevel' );
							}
							else {
								if ( $(this).attr('data-parent') !== checkParents ) {
									doIt = false;
								}
							}
						});

					}
				}

				if ( doIt === false ) {
					return;
				}

				var ourEl = checkCheckboxes.find('label.prdctfltr_active');

				if ( ourEl.length == 0 ) {
					if ( mode == 'drill' || mode == 'drillback' ) {
						checkCheckboxes.find('> .prdctfltr_sub').remove();
					}
				}
				else {
					ourEl.each( function() {

						if ( $(this).next().is('.prdctfltr_sub' ) ) {
							var subParent = $(this).next();
						}
						else {
							var subParent = $(this).closest('.prdctfltr_sub');
						}

						if ( subParent.length == 0 ) {
							if ( mode == 'drill' || mode == 'drillback' ) {
								checkCheckboxes.find('> .prdctfltr_sub').remove();
							}
						}
						else {

							if ( mode == 'drill' || mode == 'drillback' ) {
								subParent.find('.prdctfltr_sub').remove();
							}

							var subParentCon = $('<div></div>').append(subParent.clone()).html();
							if ( mode.indexOf('back') !== -1 && subParent.prev().is('label') ) {
								subParentCon += $('<div></div>').append(subParent.prev().addClass('prdctfltr_hiddenparent').clone()).html();
							}
						}

						if ( typeof subParentCon != 'undefined' ) {
							checkCheckboxes.empty();
							checkCheckboxes.append(subParentCon);
						}

					});

				}

			});

		});

	}

	function get_category_mode(setView) {
		if ( typeof setView == 'undefined' ) {
			prdctfltr_cats_mode_700();
		}
		else {
			prdctfltr_cats_mode_700(setView);
		}
	}
	get_category_mode();

	function prdctfltr_show_opened_cats(curr) {
		curr = ( curr == null ? $('.prdctfltr_woocommerce') : curr );

		curr.find('.prdctfltr_hierarchy label.prdctfltr_active').each( function() {
			if ( $(this).next().is('.prdctfltr_sub') ) {
				if ( !$(this).hasClass('prdctfltr_show_subs') ) {
					$(this).addClass('prdctfltr_show_subs');
				}
			}

			$(this).parents('.prdctfltr_sub').each( function() {
				if ( !$(this).prev().hasClass('prdctfltr_show_subs') ) {
					$(this).prev().addClass('prdctfltr_show_subs');
				}
			});

		});
	}

	function prdctfltr_all_cats(curr) {
		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.find( '.prdctfltr_expand_parents .prdctfltr_sub' ).each( function() {
			var curr = $(this);
			if ( !curr.is(':visible') ) {
				if ( !curr.prev().hasClass('prdctfltr_show_subs') ) {
					curr.prev().addClass('prdctfltr_show_subs');
				}
			}
		});
	}

	function prdctfltr_make_clears(curr) {
		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		var clearActive = false;
		var currEls = curr.find('.prdctfltr_filter label.prdctfltr_active');
		var currElLength = currEls.length;

		if ( curr.find('input[name^="mtar"]').filter(function() { return this.value !== ''; }).length > 0 ) {
			__get_clear_all_button_loop(curr);
		}
		else if ( curr.find('input[name^="rng_m"]').filter(function() { return this.value !== ''; }).length > 0 ) {
			__get_clear_all_button_loop(curr);
		}
		else if ( currElLength>0 ) {
			currEls.each( function() {

				var currEl = $(this);
				var currElPrnt = currEl.closest('.prdctfltr_filter');
				var currElFilter = currElPrnt.attr('data-filter');

				if ( prdctfltr.clearall[0] != null) {
					if ( $.inArray( currElFilter, prdctfltr.clearall ) > -1 ) {
						
					}
					else {
						clearActive = true;
					}
				}
				else {
					clearActive = true;
				}

				if ( !--currElLength ) {
					if ( clearActive === true ) {
						__get_clear_all_button_loop(curr);
					}
				}

			});
		}
		else if ( curr.find('.prdctfltr_buttons label.prdctfltr_active').length>0 ) {
			__get_clear_all_button_loop(curr);
		}
		else if ( curr.find('.prdctfltr_add_inputs input.pf_added_orderby').length>0 ) {
			__get_clear_all_button_loop(curr);
		}
	}

	function __get_clear_all_button_loop(e) {
		e.each( function() {
			if ( !$(this).hasClass('pf_remove_clearall') ) {
				__get_clear_all_button($(this));
			}
		});
	}
	
	function __get_clear_all_button(e) {
		e.find('.prdctfltr_buttons').append('<span class="prdctfltr_reset"><label><input name="reset_filter" type="checkbox" /><span>'+prdctfltr.localization.clearall+'</span></label></span>');
	}

	function prdctfltr_submit_form(curr_filter) {
		if ( curr_filter.hasClass('prdctfltr_click_filter') || $('.prdctfltr_wc input[name="reset_filter"]:checked').length > 0 ) {
			prdctfltr_respond_550( curr_filter.find('form') );
		}
	}

	$('.prdctfltr_wc').each( function() {

		var curr = $(this);

		prdctfltr_filter_terms_init(curr);

		prdctfltr_init_scroll(curr);

		if ( curr.find('.prdctfltr_expand_parents').length > 0 ) {
			prdctfltr_all_cats(curr);
		}
		prdctfltr_show_opened_cats(curr);

		if ( curr.hasClass('pf_mod_masonry') ) {
			curr.find('.prdctfltr_filter_inner').isotope({
				resizable: false,
				masonry: { }
			});
			if ( !curr.hasClass('prdctfltr_always_visible') ) {
				curr.find('.prdctfltr_woocommerce_ordering').hide();
			}
		}

		if ( curr.attr('class').indexOf('pf_sidebar_css') > 0 ) {
			if ( curr.hasClass('pf_sidebar_css_right') ) {
				$('body').css('right', '0px');
			}
			else {
				$('body').css('left', '0px');
			}
			if ( !$('body').hasClass('wc-prdctfltr-active-overlay') ) {
				$('body').addClass('wc-prdctfltr-active-overlay');
			}
		}

		if ( curr.hasClass('prdctfltr_step_filter') ) {
			var checkStep = curr.find('.prdctfltr_woocommerce_filter_submit');
			if ( curr.find('.prdctfltr_woocommerce_filter_submit').length>0 ) {
				curr.find('.prdctfltr_woocommerce_filter_submit').remove();
			}
			curr.find('.prdctfltr_buttons').prepend('<a class="button prdctfltr_woocommerce_filter_submit pf_stopajax" href="#">'+(prdctfltr.js_filters[curr.attr('data-id')].button_text==''?prdctfltr.localization.getproducts:prdctfltr.js_filters[curr.attr('data-id')].button_text)+'</a>');
			curr.closest('.prdctfltr_sc').addClass('prdctfltr_sc_step_filter');
		}

		if ( $(this).attr('data-loader') !== 'none' &&  $(this).attr('data-loader').substr(0, 4) !== 'css-' ) {
			pf_preload_image(prdctfltr.url+'lib/images/svg-loaders/'+$(this).attr('data-loader')+'.svg');
		}

		check_selection_boxes_wrapper(curr);
		prdctfltr_make_clears(curr);

	});

	function pf_preload_image(url) {
		var img = new Image();
		img.src = url;
	}

	$(document).on( 'change', '.prdctfltr_range input[name^="rng_"], .prdctfltr_meta_range input[name^="mtar"]', function() {
		var curr = $(this).closest('.prdctfltr_woocommerce');

		if ( curr.hasClass('prdctfltr_click_filter') ) {
			prdctfltr_respond_550(curr.find('.prdctfltr_woocommerce_ordering'));
		}
	});

	var stopAjax = false;
	$(document).on('click', '.prdctfltr_woocommerce_filter_submit', function() {

		if ( $(this).hasClass('pf_stopajax') ) {
			stopAjax = true;
		}

		var curr = $(this).closest('.prdctfltr_woocommerce_ordering');

		prdctfltr_respond_550(curr);

		return false;

	});

	$(document).on('click', '.prdctfltr_woocommerce_filter_title, .prdctfltr_showing', function() {
		$(this).parent().find('.prdctfltr_woocommerce_filter').trigger('click');
	} );

	$(document).on('click', '.prdctfltr_woocommerce_filter:not(.pf_ajax_loading)', function() {

		var curr_filter = $(this).closest('.prdctfltr_woocommerce');

		if ( !curr_filter.hasClass('prdctfltr_always_visible') ) {

			if (curr_filter.hasClass('pf_mod_masonry') && curr_filter.find('.prdctfltr_woocommerce_ordering:hidden').length > 0 ) {
				if (curr_filter.hasClass('prdctfltr_active')===false) {
					var curr_check = curr_filter.find('.prdctfltr_woocommerce_ordering');
					curr_check.show().find('.prdctfltr_filter_inner').isotope('layout');
					curr_check.hide();
				}
			}

			var curr = curr_filter.find('.prdctfltr_woocommerce_ordering');

			if( $(this).hasClass('prdctfltr_active') ) {
				if ( curr_filter.attr('class').indexOf( 'pf_sidebar' ) == -1 ) {
					if ( curr_filter.hasClass( 'pf_fullscreen' ) ) {
						curr.stop(true,true).fadeOut(200, function() {
							curr.find('.prdctfltr_close_sidebar').remove();
						});
					}
					else {
						if ( !curr_filter.hasClass('prdctfltr_wc_widget') &&  !curr_filter.hasClass('prdctfltr_always_visible') ) {
							curr.stop(true,true).slideUp(200);
						}
					}
				}
				else {
					curr.stop(true,true).fadeOut(200, function() {
						curr.find('.prdctfltr_close_sidebar').remove();
					});
					if ( curr_filter.attr('class').indexOf( 'pf_sidebar_css' ) > 0 ) {
						if ( curr_filter.hasClass('pf_sidebar_css_right') ) {
							$('body').css({'right':'0px','bottom':'auto','top':'auto','left':'auto'});
						}
						else {
							$('body').css({'right':'auto','bottom':'auto','top':'auto','left':'0px'});
						}
						$('.prdctfltr_overlay').remove();
					}
				}
				$(this).removeClass('prdctfltr_active');
				$('body').removeClass('wc-prdctfltr-active');
			}
			else {
				$(this).addClass('prdctfltr_active');
				if ( curr_filter.attr('class').indexOf( 'pf_sidebar' ) == -1 ) {
					$('body').addClass('wc-prdctfltr-active');
					if ( curr_filter.hasClass( 'pf_fullscreen' ) ) {
						curr.prepend('<div class="prdctfltr_close_sidebar"><i class="prdctfltr-delete"></i> '+prdctfltr.localization.close_filter+'</div>');
						curr.stop(true,true).fadeIn(200);

						var curr_height = $(window).height() - curr.find('.prdctfltr_filter_inner').outerHeight() - curr.find('.prdctfltr_close_sidebar').outerHeight() - curr.find('.prdctfltr_buttons').outerHeight();

						if ( curr_height > 128 ) {
							var curr_diff = curr_height/2;
							curr_height = curr.outerHeight();
							curr.css({'padding-top':curr_diff+'px'});
						}
						else {
							curr_height = $(window).height() - curr.find('.prdctfltr_close_sidebar').outerHeight() - curr.find('.prdctfltr_buttons').outerHeight() -128;
						}
						curr_filter.find('.prdctfltr_filter_wrapper').css({'max-height':curr_height});
					}
					else {
						if ( !curr_filter.hasClass('prdctfltr_wc_widget') &&  !curr_filter.hasClass('prdctfltr_always_visible') ) {
							curr.stop(true,true).slideDown(200);
						}
					}
				}
				else {
					curr.prepend('<div class="prdctfltr_close_sidebar"><i class="prdctfltr-delete"></i> '+prdctfltr.localization.close_filter+'</div>');
					curr.stop(true,true).fadeIn(200);
					if ( curr_filter.attr('class').indexOf( 'pf_sidebar_css' ) > 0 ) {
						$('body').append('<div class="prdctfltr_overlay"></div>');
						if ( prdctfltr.rtl == '' ) {
							if ( curr_filter.hasClass('pf_sidebar_css_right') ) {
								$('body').css({'right':'160px','bottom':'auto','top':'auto','left':'auto'});
								$('.prdctfltr_overlay').css({'right':'310px'}).delay(200).animate({'opacity':0.33},200,'linear');
							}
							else {
								$('body').css({'right':'auto','bottom':'auto','top':'auto','left':'160px'});
								$('.prdctfltr_overlay').css({'left':'310px'}).delay(200).animate({'opacity':0.33},200,'linear');
							}
						}
						else {
							if ( curr_filter.hasClass('pf_sidebar_css_right') ) {
								$('body').css({'left':'160px','bottom':'auto','top':'auto','right':'auto'});
								$('.prdctfltr_overlay').css({'left':'310px'}).delay(200).animate({'opacity':0.33},200,'linear');
							}
							else {
								$('body').css({'left':'auto','bottom':'auto','top':'auto','right':'160px'});
								$('.prdctfltr_overlay').css({'right':'310px'}).delay(200).animate({'opacity':0.33},200,'linear');
							}
						}
					}
					$('body').addClass('wc-prdctfltr-active');
				}
			}
		}

		return false;
	});

	$(document).on('click', '.prdctfltr_overlay, .prdctfltr_close_sidebar', function() {

		if ( $(this).closest('.prdctfltr_woocommerce').length > 0 ) {
			$(this).closest('.prdctfltr_woocommerce').find('.prdctfltr_woocommerce_filter.prdctfltr_active').trigger('click');
		}
		else {
			$('.pf_sidebar_css .prdctfltr_woocommerce_filter.prdctfltr_active, .pf_sidebar_css_right .prdctfltr_woocommerce_filter.prdctfltr_active').trigger('click');
		}

	});

	$(document).on('click', '.pf_default_select .prdctfltr_widget_title, .prdctfltr_terms_customized_select .prdctfltr_widget_title', function() {

		var curr = $(this).closest('.prdctfltr_filter').find('.prdctfltr_add_scroll');

		if ( !curr.hasClass('prdctfltr_down') ) {
			$(this).find('.prdctfltr-down').attr('class', 'prdctfltr-up');
			curr.addClass('prdctfltr_down');
			curr.slideDown(100);
		}
		else {
			curr.slideUp(100);
			curr.removeClass('prdctfltr_down');
			$(this).find('.prdctfltr-up').attr('class', 'prdctfltr-down');
		}

	});

	var pf_select_opened = false;
	$(document).on('click', '.pf_select .prdctfltr_filter .prdctfltr_regular_title, .prdctfltr_terms_customized_select.prdctfltr_filter .prdctfltr_regular_title', function() {
		pf_select_opened = true;
		var curr = $(this).closest('.prdctfltr_filter').find('.prdctfltr_add_scroll');

		if ( !curr.hasClass('prdctfltr_down') ) {
			$(this).find('.prdctfltr-down').attr('class', 'prdctfltr-up');
			curr.addClass('prdctfltr_down');
			curr.slideDown(100, function() {
				pf_select_opened = false;
			});

			if ( !$('body').hasClass('wc-prdctfltr-select') ) {
				$('body').addClass('wc-prdctfltr-select');
			}
		}
		else {
			curr.slideUp(100, function() {
				pf_select_opened = false;

			});
			curr.removeClass('prdctfltr_down');
			$(this).find('.prdctfltr-up').attr('class', 'prdctfltr-down');
			if ( curr.closest('.prdctfltr_woocommerce').find('.prdctfltr_down').length == 0 ) {
				$('body').removeClass('wc-prdctfltr-select');
			}
		}

	});

	$(document).on( 'click', 'body.wc-prdctfltr-select', function(e) {

		var curr_target = $(e.target);

		if ( $('.prdctfltr_wc.pf_select .prdctfltr_down, .prdctfltr_terms_customized_select .prdctfltr_down').length > 0 && pf_select_opened === false && !curr_target.is('span, input, i') ) {
			$('.prdctfltr_wc.pf_select .prdctfltr_down, .prdctfltr_wc:not(.prdctfltr_wc_widget.pf_default_select) .prdctfltr_terms_customized_select .prdctfltr_down').each( function() {
				var curr = $(this);
				if ( curr.is(':visible') ) {
					curr.slideUp(100);
					curr.removeClass('prdctfltr_down');
					curr.closest('.prdctfltr_filter').find('span .prdctfltr-up').attr('class', 'prdctfltr-down');
				}
			});
			$('body').removeClass('wc-prdctfltr-select');
		}
	});

	$(document).on('click', 'span.prdctfltr_sale label, span.prdctfltr_instock label, span.prdctfltr_reset label', function() {

		var field = $(this).children('input:first');

		var curr_name = field.attr('name');
		var curr_filter = $(this).closest('.prdctfltr_wc');

		var ourObj = prdctfltr_get_obj_580(curr_filter);
		var pf_length = prdctfltr_count_obj_580(ourObj);

		if ( $('body').hasClass('prdctfltr-ajax') && field.attr('name') == 'reset_filter' ) {
			$.each( ourObj, function(i, obj) {
				if ( obj.find('.prdctfltr_buttons input[name="reset_filter"]').length==0 ) {
					obj.find('.prdctfltr_buttons').append('<input name="reset_filter" type="checkbox" checked />');
				}
			});
		}

		$.each( ourObj, function(i, obj) {

			obj = $(obj);

			var curr_obj = obj.find('.prdctfltr_buttons input[name="'+curr_name+'"]');
			if ( curr_obj.length>0 ) {
				curr_obj.each(function(i5,obj24){
					var obj25 = $(obj24);
					if ( !obj25.parent().hasClass('prdctfltr_active') ) {
						obj25.prop('checked', true).attr('checked', true).parent().addClass('prdctfltr_active');
						de_check_buttons(obj25,'notactive');
					}
					else {
						obj25.prop('checked', false).attr('checked', false).parent().removeClass('prdctfltr_active');
						de_check_buttons(obj25,'active');
					}
				});
			}

			if ( obj.find('.prdctfltr_filter.prdctfltr_instock').length>0 ) {
				obj.find('.prdctfltr_filter.prdctfltr_instock input[name="instock_products"]').remove();
			}

			if ( !--pf_length ) {
				prdctfltr_submit_form(curr_filter);
			}

		});

	});

	$(document).on('click', '.prdctfltr_byprice label', function() {

		var curr_chckbx = $(this).find('input[type="checkbox"]');
		var curr = curr_chckbx.closest('.prdctfltr_filter');
		var curr_var = curr_chckbx.val().split('-');
		var curr_filter = curr_chckbx.closest('.prdctfltr_wc');

		if ( curr_filter.hasClass('prdctfltr_tabbed_selection') ) {
			var currVal = curr.find('input[name="min_price"]').val()+'-'+curr.find('input[name="max_price"]').val();
			if ( currVal == curr_chckbx.val() ) {
				return false;
			}
		}

		var ourObj = prdctfltr_get_obj_580(curr_filter);
		var pf_length = prdctfltr_count_obj_580(ourObj);

		if ( curr_var[0] == '' && curr_var[1] == '' || curr_chckbx.closest('label').hasClass('prdctfltr_active') ) {

			$.each( ourObj, function(i, obj) {
				var pfObj = $(obj).find('.prdctfltr_filter.prdctfltr_byprice');
				pfObj.find('.prdctfltr_active input[type="checkbox"]').prop('checked',false).attr('checked',false).closest('label').removeClass('prdctfltr_active');
				pfObj.find('input[name="min_price"]').val('');
				pfObj.find('input[name="max_price"]').val('');
				if ( !--pf_length ) {
					prdctfltr_submit_form(curr_filter);
				}
			});

		}
		else {

			$.each( ourObj, function(i, obj) {
				var pfObj = $(obj).find('.prdctfltr_filter.prdctfltr_byprice');
				pfObj.find('.prdctfltr_active input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
				pfObj.find('input[name="min_price"]').val(curr_var[0]);
				pfObj.find('input[name="max_price"]').val(curr_var[1]);
				pfObj.find('input[value="'+curr_var[0]+'-'+curr_var[1]+'"][type="checkbox"]').prop('checked',true).attr('checked',true).change().closest('label').addClass('prdctfltr_active');
				if ( !--pf_length ) {
					prdctfltr_submit_form(curr_filter);
				}
			});

		}

		if ( curr_filter.hasClass('prdctfltr_tabbed_selection') && curr_filter.hasClass('prdctfltr_click') ) {
			curr_filter.find('.prdctfltr_filter').each( function() {
				if ( $(this).find('input[type="hidden"]:first').length > 0 && $(this).find('input[type="hidden"]:first').val() !== '' ) {
					if ( !$(this).hasClass('prdctfltr_has_selection') ) {
						$(this).addClass('prdctfltr_has_selection');
					}
					
				}
				else {
					if ( $(this).hasClass('prdctfltr_has_selection') ) {
						$(this).removeClass('prdctfltr_has_selection');
					}
				}
			});
		}

		if ( !curr_chckbx.closest('.prdctfltr_wc').hasClass('prdctfltr_wc_widget') && ( curr_chckbx.closest('.prdctfltr_wc').hasClass('pf_select') || curr.hasClass('prdctfltr_terms_customized_select') ) ) {

			if ( curr.hasClass('prdctfltr_terms_customized_select') && curr_chckbx.closest('.prdctfltr_wc').hasClass('prdctfltr_wc_widget') && curr_chckbx.closest('.prdctfltr_wc').hasClass('pf_default_select') ) {
				return false;
			}
			curr_chckbx.closest('.prdctfltr_filter').find('.prdctfltr_add_scroll').slideUp(250).removeClass('prdctfltr_down');
			curr_chckbx.closest('.prdctfltr_filter').find('.prdctfltr_regular_title i.prdctfltr-up').removeClass('prdctfltr-up').addClass('prdctfltr-down');

		}


		$.each( ourObj, function(i, obj) {
			var pfObj = $(obj).find('.prdctfltr_filter[data-filter="price"]');
			pfObj.each( function(){
				check_selection_boxes($(this),'look');
			});
		});


		return false;

	});

	$(document).on('click', '.prdctfltr_filter:not(.prdctfltr_byprice) label', function(event) {

		if( $(event.target).is('input') ) {
			return false;
		}

		var curr_chckbx = $(this).find('input[type="checkbox"]');
		var curr = curr_chckbx.closest('.prdctfltr_filter');
		var curr_var = curr_chckbx.val();
		var curr_filter = curr.closest('.prdctfltr_wc');

		if ( curr.hasClass('pf_adptv_unclick') ) {
			if ( curr_chckbx.parent().hasClass( 'pf_adoptive_hide' ) ) {
				return false;
			}
		}

		prdctfltr_check_580(curr, curr_chckbx, curr_var, curr_filter);

		return false;

	});

	var shortcodeAjax = false;
	var prodcutsWrapper = false;
	var hasFilter = false;
	var hasProducts = false;
	var isAjax = false;
	var isStep = false;
	var hasWidget = false;

	function resetVars() {
		shortcodeAjax = false;
		prodcutsWrapper = false;
		hasFilter = false;
		hasProducts = false;
		isAjax = false;
		isStep = false;
		hasWidget = false;
	}

	function prdctfltr_get_obj_580(filter) {
		var ourObj = {};
		resetVars();

		if ( filter.closest('.prdctfltr_sc').length>0 ) {
			var scWrap = filter.closest('.prdctfltr_sc');
			var scMode = scWrap.is('.prdctfltr_sc_filter') ? 'sc_filter' : 'sc_shortcode' ;
			if ( scWrap.find('.prdctfltr_wc').length>0 ) {
				hasFilter = true;
			}
			if ( scWrap.find(prdctfltr.ajax_class).length>0 ) {
				hasProducts = true;
			}
			if ( scWrap.hasClass('prdctfltr_ajax') ) {
				isAjax = true;
				shortcodeAjax = true;
			}
			if ( scWrap.find('.prdctfltr_wc').hasClass('prdctfltr_step_filter') ) {
				isStep = true;
			}
			if ( $('.prdctfltr_wc_widget').length>0 ) {
				hasWidget = true;
			}
		}
		else if ( filter.closest('.prdctfltr_wcsc').length>0 ) {

		}
		else if ( archiveAjax === true ) {

		}
		else if ( filter.closest('.prdctfltr_wc_widget').length>0 ) {
			hasWidget = true;
			if( $('.prdctfltr_sc:not(.prdctfltr_sc_step_filter)').length>0 ) {
				if ( $('.prdctfltr_sc:not(.prdctfltr_sc_step_filter)').find(prdctfltr.ajax_class).length>0 ) {
					var scWrap = $('.prdctfltr_sc:not(.prdctfltr_sc_step_filter)');
					var scMode = scWrap.is('.prdctfltr_sc_filter') ? 'sc_filter' : 'sc_shortcode' ;
					hasFilter = true;
					hasProducts = true;
					prodcutsWrapper = scWrap;
					shortcodeAjax = prodcutsWrapper.hasClass('prdctfltr_ajax');
				}
			}
		}

		if ( isStep ) {
			scWrap.find('.prdctfltr_wc').each( function() {
				ourObj[$(this).attr('data-id')] = $(this);
			});
		}
		else if ( hasProducts && hasFilter ) {
			prodcutsWrapper = scWrap;
			if ( hasWidget ) {
				scWrap.find('.prdctfltr_wc:not(.prdctfltr_step_filter)').each( function() {
					ourObj[$(this).attr('data-id')] = $(this);
				});
				$('.prdctfltr_wc_widget:not(.prdctfltr_step_filter)').each( function() {
					ourObj[$(this).attr('data-id')] = $(this);
				});
			}
			else {
				scWrap.find('.prdctfltr_wc:not(.prdctfltr_step_filter)').each( function() {
					ourObj[$(this).attr('data-id')] = $(this);
				});
			}
		}
		else {
			$('.prdctfltr_wc:not([data-id="'+filter.attr('data-id')+'"]):not(.prdctfltr_step_filter)').each( function() {
				if ( $(this).closest('.prdctfltr_sc_products').length==0 ) {
					ourObj[$(this).attr('data-id')] = $(this);
				}
			});
			ourObj[filter.attr('data-id')] = $('.prdctfltr_wc[data-id="'+filter.attr('data-id')+'"]');
		}

		return ourObj;

	}

	function prdctfltr_count_obj_580(ourObj) {
		var pf_length = 0;
		var i;
		for (i in ourObj) {
			if (ourObj.hasOwnProperty(i)) {
				pf_length++;
			}
		}
		return pf_length;
	}

	function prdctfltr_check_parent_helper_590(termParent, pfObj) {
		if ( termParent ) {
			var found = pfObj.find('input[value="'+termParent+'"]');
			if ( found.length > 0 ) {
				pfObj.find('input[value="'+termParent+'"][type="checkbox"]').prop('checked',true).attr('checked',true).change().closest('label').addClass('prdctfltr_active');
			}
			else {
					pfObj.closest('.prdctfltr_wc').find('.prdctfltr_add_inputs').append('<input type="hidden" name="'+pfObj.attr('data-filter')+'" value="'+termParent+'" class="pf_added_input" />');

			}
		}
	}

	function prdctfltr_check_580(curr, curr_chckbx, curr_var, curr_filter) {

		var ourObj = prdctfltr_get_obj_580(curr_filter);
		var pf_length = prdctfltr_count_obj_580(ourObj);

		var field = curr.children('input[type="hidden"]:first');

		var curr_name = field.attr('name');
		var curr_val = field.val();

		if ( curr_filter.hasClass('prdctfltr_tabbed_selection') ) {
			if ( curr_val == curr_chckbx.val() ) {
				return false;
			}
		}

		if ( $('.pf_added_input[name="'+curr_name+'"]').length > 0 ) {
			$('.pf_added_input[name="'+curr_name+'"]').remove();
		}

		if ( curr.hasClass('prdctfltr_selection') ) {
			var checkLength = pf_length;
			$.each( ourObj, function(i, obj) {
				var pfObj1 = $(obj).find('.prdctfltr_filter:not(.prdctfltr_range):not([data-filter="'+curr_name+'"]) label.prdctfltr_active');
				if ( pfObj1.length>0 ) {
					$.each( pfObj1, function(i3, ob5) {
						$('.pf_added_input[name="'+$(ob5).closest('.prdctfltr_filter').attr('data-filter')+'"]').remove();
						$(ob5).removeClass('prdctfltr_active').find('input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('.prdctfltr_filter').find('input[type="hidden"]').val('');
					});
				}
				var pfObj = $(obj).find('.prdctfltr_filter.prdctfltr_range input[type="hidden"][val!=""]');
				if ( pfObj.length>0 ) {
					$.each( pfObj, function(i2, obj4) {
						$('.pf_added_input[name="'+$(obj4).attr('name')+'"]').remove();
						$(obj4).closest('.prdctfltr_filter').find('input[type="hidden"]').val('');
					});
				}

				if ( !--checkLength ) {
					$.each( ourObj, function(i4, obj47) {

						$(obj47).find('.prdctfltr_buttons input[name="sale_products"], .prdctfltr_buttons input[name="instock_products"]').each(function() {
							$(this).prop('checked', false).attr('checked', false).closest('label').removeClass('prdctfltr_active');
							de_check_buttons($(this),'active');
						});

						$(obj47).find('input.pf_search').val('');

						$(obj47).find('input[id^="prdctfltr_rng_"]').each(function(){
							var setRng = $(this).data('ionRangeSlider');
							ranges[$(this).attr('id')].update({
								from: setRng.options.min,
								to: setRng.options.max
							});
						});

						$(obj47).find('.prdctfltr_filter').each( function() {
							check_selection_boxes($(this),'init');
						});

					});
				}

			});
		}

		if ( !curr.hasClass('prdctfltr_multi') ) {

			if ( curr_var == '' || curr_chckbx.closest('label').hasClass('prdctfltr_active') ) {

				var termParent = curr_chckbx.attr('data-parent');

				$.each( ourObj, function(i, obj) {
					var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');
					pfObj.find('.prdctfltr_active input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');

					if ( termParent ) {
						prdctfltr_check_parent_helper_590(termParent, pfObj);
						pfObj.find('input[name="'+curr_name+'"]').val(termParent);
					}
					else {
						pfObj.find('input[name="'+curr_name+'"]').val('');
					}

					if ( !--pf_length ) {
						prdctfltr_submit_form(curr_filter);
					}
				});

			}
			else {

				$.each( ourObj, function(i, obj) {
					var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');
					pfObj.find('.prdctfltr_active input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
					pfObj.find('input[name="'+curr_name+'"]').val(curr_var);
					pfObj.find('input[value="'+curr_var+'"][type="checkbox"]').prop('checked',true).attr('checked',true).change().closest('label').addClass('prdctfltr_active');
					if ( !--pf_length ) {
						prdctfltr_submit_form(curr_filter);
					}
				});

			}

			if ( curr_chckbx.closest('.prdctfltr_wc').hasClass('pf_select') || curr.hasClass('prdctfltr_terms_customized_select') ) {
				if ( curr.hasClass('prdctfltr_terms_customized_select') && curr_chckbx.closest('.prdctfltr_wc').hasClass('prdctfltr_wc_widget') && curr_chckbx.closest('.prdctfltr_wc').hasClass('pf_default_select') ) {
					return false;
				}
				curr_chckbx.closest('.prdctfltr_filter').find('.prdctfltr_add_scroll').slideUp(250).removeClass('prdctfltr_down');
				curr_chckbx.closest('.prdctfltr_filter').find('.prdctfltr_regular_title i.prdctfltr-up').removeClass('prdctfltr-up').addClass('prdctfltr-down');
			}

		}
		else {

			if ( curr_chckbx.val() !== '' ) {

				if ( curr_chckbx.closest('label').hasClass('prdctfltr_active') ) {

					if ( curr.hasClass('prdctfltr_merge_terms') ) {
						var curr_settings = ( curr_val.indexOf('+') > 0 ? curr_val.replace('+' + curr_var, '').replace(curr_var + '+', '') : '' );

						$.each(prdctfltr.js_filters, function(n18,obj43){
							if ( typeof obj43.adds !== 'undefined' && obj43.adds[curr_name] !== null ) {
								var check = prdctfltr.js_filters[n18].adds[curr_name];
								prdctfltr.js_filters[n18].adds[curr_name] = ( typeof check !== 'undefined' && check.indexOf('+') > 0 ? check.replace('+' + curr_var, '').replace(curr_var + '+', '') : '' );
							}
						});
					}
					else {
						var curr_settings = ( curr_val.indexOf(',') > 0 ? curr_val.replace(',' + curr_var, '').replace(curr_var + ',', '') : '' );

						$.each(prdctfltr.js_filters, function(n18,obj43){
							if ( typeof obj43.adds !== 'undefined' && obj43.adds[curr_name] !== null ) {
								var check = prdctfltr.js_filters[n18].adds[curr_name];
								prdctfltr.js_filters[n18].adds[curr_name] = ( typeof check !== 'undefined' && check.indexOf(',') > 0 ? check.replace(',' + curr_var, '').replace(curr_var + ',', '') : '' );
							}
						});
					}

					var termParent = curr_chckbx.attr('data-parent');

					$.each( ourObj, function(i, obj) {
						var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');
						pfObj.find('input[name="'+curr_name+'"]').val(curr_settings);
						pfObj.find('input[value="'+curr_var+'"][type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');

						if ( termParent ) {
							if ( curr_settings == '' ) {
								prdctfltr_check_parent_helper_590(termParent, pfObj);
								pfObj.find('input[name="'+curr_name+'"]').val(termParent);
							}
						}

						if ( !--pf_length ) {
							prdctfltr_submit_form(curr_filter);
						}

					});

				}
				else {

					$('.prdctfltr_filter[data-filter="'+curr_name+'"] .prdctfltr_sub[data-sub="'+curr_var+'"]').find('.prdctfltr_active input[type="checkbox"]').each( function() {

						var checkVal = $(this).val();
						if ( curr.hasClass('prdctfltr_merge_terms') ) {
							if ( curr_val.indexOf('+') > 0 ) {
								curr_val = curr_val.replace('+' + checkVal, '').replace(checkVal + '+', '');
							}
							else {
								curr_val = curr_val.replace(checkVal, '');
							}
						}
						else {
							if ( curr_val.indexOf(',') > 0 ) {
								curr_val = curr_val.replace(',' + checkVal, '').replace(checkVal + ',', '');
							}
							else {
								curr_val = curr_val.replace(checkVal, '');
							}
						}
						$(this).prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
					});

					if ( curr.hasClass('prdctfltr_merge_terms') ) {

						if ( curr.closest('.prdctfltr_wc').find('.prdctfltr_filter[data-filter="'+curr_name+'"]').length>1 ) {
							curr.find('.prdctfltr_active').each(function(){
								var val12 = $(this).find('input[type="checkbox"]').val();
								if ( curr_val.indexOf('+') > 0 ) {
									curr_val = curr_val.replace('+' + val12, '').replace(val12 + '+', '');
								}
								else {
									curr_val = curr_val.replace(val12, '');
								}
								$(this).find('input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
							});
						}

						var curr_settings = ( curr_val == '' ? curr_var : curr_val + '+' + curr_var );
					}
					else {
						var curr_settings = ( curr_val == '' ? curr_var : curr_val + ',' + curr_var );
					}

					var termParent = curr_chckbx.attr('data-parent');

					$.each( ourObj, function(i, obj) {
						var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');
						pfObj.find('input[name="'+curr_name+'"]').val(curr_settings);
						pfObj.find('input[value="'+curr_var+'"][type="checkbox"]').prop('checked',true).attr('checked',true).change().closest('label').addClass('prdctfltr_active');

						if ( termParent ) {
							if ( pfObj.find('input[value="'+termParent+'"][type="checkbox"]:checked').length > 0 ) {
								pfObj.find('input[value="'+termParent+'"][type="checkbox"]:checked').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
								if ( curr_settings.indexOf(termParent) > -1 ) {
									if ( curr.hasClass('prdctfltr_merge_terms') ) {
										var makeNew = ( curr_settings.indexOf('+') > 0 ? curr_settings.replace('+' + termParent, '').replace(termParent + '+', '') : '' );
									}
									else {
										var makeNew = ( curr_settings.indexOf(',') > 0 ? curr_settings.replace(',' + termParent, '').replace(termParent + ',', '') : '' );
									}
									pfObj.find('input[name="'+curr_name+'"]').val(makeNew);
								}
							}
							else {
								var remTermParent = pfObj.find('input[value="'+termParent+'"][type="checkbox"]').attr('data-parent');
								if ( remTermParent ) {
									while ( remTermParent !== false ) {
										pfObj.find('input[value="'+remTermParent+'"][type="checkbox"]:checked').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
										if ( curr_settings.indexOf(remTermParent) > -1 ) {
											if ( curr.hasClass('prdctfltr_merge_terms') ) {
												var makeNew = ( curr_settings.indexOf('+') > 0 ? curr_settings.replace('+' + remTermParent, '').replace(remTermParent + '+', '') : '' );
											}
											else {
												var makeNew = ( curr_settings.indexOf(',') > 0 ? curr_settings.replace(',' + remTermParent, '').replace(remTermParent + ',', '') : '' );
											}
											pfObj.find('input[name="'+curr_name+'"]').val(makeNew);
										}
										remTermParent = ( pfObj.find('input[value="'+remTermParent+'"][type="checkbox"]').attr('data-parent') ? pfObj.find('input[value="'+remTermParent+'"][type="checkbox"]').attr('data-parent') : false );
									}
								}
							}
						}

						if ( !--pf_length ) {
							prdctfltr_submit_form(curr_filter);
						}
					});

				}
			}
			else {

				$.each( ourObj, function(i, obj) {
					var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');

					if ( pfObj.find('label.prdctfltr_active input[data-parent]').length>0 ) {
						if ( pfObj.find('label.prdctfltr_active input[data-parent]').length == pfObj.find('label.prdctfltr_active input[data-parent="'+pfObj.find('label.prdctfltr_active input[data-parent]:first').attr('data-parent')+'"]').length ) {
							pfObj.find('input[name="'+curr_name+'"]').val(pfObj.find('label.prdctfltr_active input[data-parent]:first').attr('data-parent'));
							pfObj.find('input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
						}
					}
					else {
						pfObj.find('input[name="'+curr_name+'"]').val('');
						pfObj.find('input[type="checkbox"]').prop('checked',false).attr('checked',false).change().closest('label').removeClass('prdctfltr_active');
					}

					if ( !--pf_length ) {
						prdctfltr_submit_form(curr_filter);
					}
				});

			}

		}

		if ( curr_filter.hasClass('prdctfltr_tabbed_selection') && curr_filter.hasClass('prdctfltr_click') ) {
			curr_filter.find('.prdctfltr_filter').each( function() {
				if ( $(this).find('input[type="hidden"]:first').length > 0 && $(this).find('input[type="hidden"]:first').val() !== '' ) {
					if ( !$(this).hasClass('prdctfltr_has_selection') ) {
						$(this).addClass('prdctfltr_has_selection');
					}
				}
				else {
					if ( $(this).hasClass('prdctfltr_has_selection') ) {
						$(this).removeClass('prdctfltr_has_selection');
					}
				}
			});
		}


		$.each( ourObj, function(i, obj) {
			var pfObj = $(obj).find('.prdctfltr_filter[data-filter="'+curr_name+'"]');
			pfObj.each( function(){
				check_selection_boxes($(this),'look');
			});
		});

	}

	function check_selection_boxes_wrapper(curr) {

		curr.find('.prdctfltr_filter').each( function() {
			check_selection_boxes($(this),'init');
		});

		curr.find('.prdctfltr_buttons:first label.prdctfltr_active').each(function() {
			check_buttons($(this),'init');
		});

	}

	function de_check_buttons(curr,mode) {

		var collectors = prdctfltr.js_filters[curr.closest('.prdctfltr_wc').attr('data-id')].collectors;
		var collectorStyle = prdctfltr.js_filters[curr.closest('.prdctfltr_wc').attr('data-id')].collector_style;

		if ( mode == 'active' ) {

			$.each( collectors, function(i,e) {
				switch(e){

					case 'collector':
						var wrap = curr.closest('.prdctfltr_woocommerce_ordering');

						var collector = wrap.find('.prdctfltr_collector');
						if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').length>0 ) {
							collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
						}

					break;

					case 'topbar':
						var wrap = curr.closest('.prdctfltr_wc');

						var collector = wrap.find('.prdctfltr_topbar');
						if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').length>0 ) {
							collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
						}

					break;

					default:

					break;
				}

			});
		}
		else {

			var input = '<span class="prdctfltr_title_selected"><span class="prdctfltr_title_added prdctfltr_title_remove" data-key="'+curr.attr('name')+'"><i class="prdctfltr-check"></i></span> <span class="prdctfltr_selected_title">'+curr.parent().text()+'</span><span class="prdctfltr_title_selected_separator"></span></span>';

			$.each( collectors, function(i,e) {
				switch(e){

					case 'collector':
						var wrap = curr.closest('.prdctfltr_woocommerce_ordering');

						if (wrap.find('.prdctfltr_collector').length==0) {
							wrap.prepend('<div class="prdctfltr_collector prdctfltr_collector_'+collectorStyle+'"></div>');
							wrap.find('.prdctfltr_collector').html(input);
						}
						else {
							var collector = wrap.find('.prdctfltr_collector');
							if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').length>0 ) {
								collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
							}
							wrap.find('.prdctfltr_collector').append(input);
						}
					break;

					case 'topbar':

						var wrap = curr.closest('.prdctfltr_wc');

						if (wrap.find('.prdctfltr_topbar').length==0) {
							wrap.find('.prdctfltr_woocommerce_filter_title').after('<div class="prdctfltr_topbar"></div>');
							wrap.find('.prdctfltr_topbar').html(input);
						}
						else {
							var collector = wrap.find('.prdctfltr_topbar');
							if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').length>0 ) {
								collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
							}
							wrap.find('.prdctfltr_topbar').append(input);
						}

					break;

					default:

					break;
				}

			});

		}

		if ( curr.closest('.prdctfltr_wc').hasClass('pf_mod_masonry') ) {
			curr.closest('.prdctfltr_filter_inner').isotope('layout');
		}

	}

	function check_buttons(curr,mode) {

		var collectors = prdctfltr.js_filters[curr.closest('.prdctfltr_wc').attr('data-id')].collectors;
		var collectorStyle = prdctfltr.js_filters[curr.closest('.prdctfltr_wc').attr('data-id')].collector_style;

		var input = '<span class="prdctfltr_title_selected">'+(mode=='init'?'<a href="#" class="prdctfltr_title_remove" data-key="'+curr.find('input:first').attr('name')+'"><i class="prdctfltr-delete"></i></a>':'<span class="prdctfltr_title_added prdctfltr_title_remove" data-key="'+curr.find('input:first').attr('name')+'"><i class="prdctfltr-check"></i></span>')+' <span class="prdctfltr_selected_title">'+curr.text()+'</span><span class="prdctfltr_title_selected_separator"></span></span>';

		$.each( collectors, function(i,e) {
			switch(e){

				case 'collector':
					var wrap = curr.closest('.prdctfltr_woocommerce_ordering');

					if (wrap.find('.prdctfltr_collector').length==0) {
						wrap.prepend('<div class="prdctfltr_collector prdctfltr_collector_'+collectorStyle+'"></div>');
						wrap.find('.prdctfltr_collector').html(input);
					}
					else {
						var collector = wrap.find('.prdctfltr_collector');
						if( collector.find('.prdctfltr_title_remove[data-key="'+curr.find('input:first').attr('name')+'"]').length>0 ) {
							collector.find('.prdctfltr_title_remove[data-key="'+curr.find('input:first').attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
						}
						wrap.find('.prdctfltr_collector').append(input);
					}
				break;

				case 'topbar':

					var wrap = curr.closest('.prdctfltr_wc');

					if (wrap.find('.prdctfltr_topbar').length==0) {
						wrap.find('.prdctfltr_woocommerce_filter_title').after('<div class="prdctfltr_topbar"></div>');
						wrap.find('.prdctfltr_topbar').html(input);
					}
					else {
						var collector = wrap.find('.prdctfltr_topbar');
						if( collector.find('.prdctfltr_title_remove[data-key="'+curr.find('input:first').attr('name')+'"]').length>0 ) {
							collector.find('.prdctfltr_title_remove[data-key="'+curr.find('input:first').attr('name')+'"]').closest('.prdctfltr_title_selected').remove();
						}
						wrap.find('.prdctfltr_topbar').append(input);
					}

				break;

				default:

				break;
			}

		});

		if ( curr.closest('.prdctfltr_wc').hasClass('pf_mod_masonry') ) {
			curr.closest('.prdctfltr_filter_inner').isotope('layout');
		}

	}

	function get_input_delete(selectedTerms, mode, curr, slug) {
		return '<span class="prdctfltr_title_selected">'+(mode=='init'?'<a href="#" class="prdctfltr_title_remove" data-key="'+curr.attr('data-filter')+'"'+slug+'><i class="prdctfltr-delete"></i></a>':'<span class="prdctfltr_title_added prdctfltr_title_remove" data-key="'+curr.attr('data-filter')+'"'+slug+'><i class="prdctfltr-check"></i></span>')+' <span class="prdctfltr_selected_title">'+selectedTerms+'</span><span class="prdctfltr_title_selected_separator"></span></span>';
	}

	function check_selection_boxes(curr,mode) {

		var selectedTerms = [];
		var selectedItms = [];
		curr.find('label.prdctfltr_active').each(function() {
			if ( $(this).find('.prdctfltr_customization_search').length>0 ) {
				selectedTerms.push($(this).find('.prdctfltr_customization_search').text());
			}
			else if ( $(this).find('.prdctfltr_customize_name').length>0 ) {
				selectedTerms.push($(this).find('.prdctfltr_customize_name').text());
			}
			else {
				selectedTerms.push($(this).find('span:first').contents().filter(function(){return 3==this.nodeType;}).text());
			}
			if ( $(this).closest('.prdctfltr_filter').hasClass('prdctfltr_attributes') || $(this).closest('.prdctfltr_filter').hasClass('prdctfltr_meta') ) {
				selectedItms.push($(this).find('input[type="checkbox"]:first').val() );
			}
		});

		if ( typeof selectedTerms[0] == 'undefined' && curr.hasClass('prdctfltr_range') ) {
			var rngData = curr.find('[id^="prdctfltr_rng_"]:first').data('ionRangeSlider');

			if ( typeof rngData !== 'undefined' ) {
				if ( ( rngData.result.from==rngData.options.min && rngData.result.to == rngData.options.max ) === false ) {
					if ( curr.attr('data-filter') == 'rng_price' ) {
						selectedTerms.push(rngData.options.prefix+rngData.result.from+rngData.options.postfix+' &longleftrightarrow; '+rngData.options.prefix+rngData.result.to+rngData.options.postfix);
					}
					else {
						selectedTerms.push(rngData.options.prefix+rngData.options.prettyValues[rngData.result.from]+rngData.options.postfix+' &longleftrightarrow; '+rngData.options.prefix+rngData.options.prettyValues[rngData.result.to]+rngData.options.postfix);
					}

				}
			}
		}

		if ( typeof selectedTerms[0] == 'undefined' && curr.hasClass('prdctfltr_meta_range') ) {
			var rngData = curr.find('[id^="prdctfltr_rng_"]:first').data('ionRangeSlider');

			if ( typeof rngData !== 'undefined' ) {
				if ( ( rngData.result.from==rngData.options.min && rngData.result.to == rngData.options.max ) === false ) {

					if ( u(rngData.options.prettify_enabled) === true ) {
						selectedTerms.push(rngData.options.prefix+rngData.options.prettyValues[rngData.result.from]+rngData.options.postfix+' &longleftrightarrow; '+rngData.options.prefix+rngData.options.prettyValues[rngData.result.to]+rngData.options.postfix);						
					}
					else {
						selectedTerms.push(rngData.options.prefix+rngData.result.from+rngData.options.postfix+' &longleftrightarrow; '+rngData.options.prefix+rngData.result.to+rngData.options.postfix);
					}

				}
			}
		}

		if ( typeof selectedTerms[0] !== 'undefined' ) {

			var col = prdctfltr.js_filters[curr.closest('.prdctfltr_wc').attr('data-id')];

			var collectors = typeof col!=='undefined'?col.collectors:[];
			var collectorStyle = typeof col!=='undefined'?col.collector_style:[];

			var slug = '';
			if ( curr.hasClass('prdctfltr_attributes') || curr.hasClass('prdctfltr_meta') ) {
				if ( 1==1 && typeof selectedTerms[1] !== 'undefined' ) {
					var input = '';
					$.each(selectedItms, function(o23,k23) {
						slug = ' data-slug="'+selectedItms[o23]+'"';
						input += get_input_delete( selectedTerms[o23], mode, curr, slug );
					});
				}
				else {
					var value = curr.find('input[type="hidden"]:first').val();
					var parent = curr.find('input[type="hidden"]:first').attr('data-parent');
					slug = ' data-slug="'+(typeof parent!=='undefined'?parent+'>':'')+value+'"';
					var input = get_input_delete( selectedTerms.join(', '), mode, curr, slug );
				}
			}
			else {
				var input = '<span class="prdctfltr_title_selected">'+(mode=='init'?'<a href="#" class="prdctfltr_title_remove" data-key="'+curr.attr('data-filter')+'"'+slug+'><i class="prdctfltr-delete"></i></a>':'<span class="prdctfltr_title_added prdctfltr_title_remove" data-key="'+curr.attr('data-filter')+'"'+slug+'><i class="prdctfltr-check"></i></span>')+' <span class="prdctfltr_selected_title">'+selectedTerms.join(', ')+'</span><span class="prdctfltr_title_selected_separator"></span></span>';
			}

			$.each( collectors, function(i,e) {
				switch(e){
					case 'intitle':
						curr.find('.prdctfltr_regular_title .prdctfltr_title_selected, .prdctfltr_widget_title  .prdctfltr_title_selected').remove();
						curr.find('.prdctfltr_regular_title, .prdctfltr_widget_title').prepend(input);
					break;

					case 'aftertitle':
						curr.find('.prdctfltr_aftertitle').remove();
						curr.find('.prdctfltr_add_scroll').before('<div class="prdctfltr_aftertitle prdctfltr_collector_'+collectorStyle+'">'+input+'</div>');
					break;

					case 'collector':
						var wrap = curr.closest('.prdctfltr_woocommerce_ordering');

						if (wrap.find('.prdctfltr_collector').length==0) {
							wrap.prepend('<div class="prdctfltr_collector prdctfltr_collector_'+collectorStyle+'"></div>');
							wrap.find('.prdctfltr_collector').html(input);
						}
						else {
							var collector = wrap.find('.prdctfltr_collector');
							if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').length>0 ) {
								collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').closest('.prdctfltr_title_selected').remove();
							}
							wrap.find('.prdctfltr_collector').append(input);
						}
					break;

					case 'topbar':

						var wrap = curr.closest('.prdctfltr_wc');

						if (wrap.find('.prdctfltr_topbar').length==0) {
							wrap.find('.prdctfltr_woocommerce_filter_title').after('<div class="prdctfltr_topbar"></div>');
							wrap.find('.prdctfltr_topbar').html(input);
						}
						else {
							var collector = wrap.find('.prdctfltr_topbar');
							if( collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').length>0 ) {
								collector.find('.prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').closest('.prdctfltr_title_selected').remove();
							}
							wrap.find('.prdctfltr_topbar').append(input);
						}

					break;

					default:

					break;
				}

			});

		}
		else if ( typeof selectedTerms[0] == 'undefined' ) {
			if ( curr.closest('.prdctfltr_wc').find('.prdctfltr_attributes[data-filter="'+curr.attr('data-filter')+'"] label.prdctfltr_active').length == 0 ) {
				curr.find('.prdctfltr_title_selected').remove();
				curr.closest('.prdctfltr_wc').find('.prdctfltr_collector .prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').closest('.prdctfltr_title_selected').remove();
				curr.closest('.prdctfltr_wc').find('.prdctfltr_topbar .prdctfltr_title_remove[data-key="'+curr.attr('data-filter')+'"]').closest('.prdctfltr_title_selected').remove();
			}
		}

		if ( curr.closest('.prdctfltr_wc').hasClass('pf_mod_masonry') ) {
			curr.closest('.prdctfltr_filter_inner').isotope('layout');
		}

	}

	function clear_filters_after(filter) {
		filter.nextAll('.prdctfltr_filter').each(function() {
			$(this).find('input[type="hidden"]').val('');
		});
	}

	function clicked_remove(obj,mode,term) {

		switch ( term ) {
			case 's':
			case 'search':
			case 'search_products':
				var srchStr = 'input[name="s"],input[name="search_products"]';
			break;

			case 'price':
				var srchStr = 'input[name="min_price"],input[name="max_price"]';
			break;
			
			default:
				var srchStr = 'input[name="'+term+'"]';
			break;
		}

		if ( srchStr == 'input[name="s"],input[name="search_products"]' ) {
			if ( mode === true ) {
				obj.closest('.prdctfltr_sc_products').find('.prdctfltr_filter, .prdctfltr_buttons').find(srchStr).val('');
	
				if ( $('.prdctfltr_wc_widget').length>0 ) {
					$('.prdctfltr_wc_widget').find('.prdctfltr_filter, .prdctfltr_buttons').find(srchStr).val('');
				}
				$('.prdctfltr_add_inputs').find(srchStr).val('');
			}
			else {
				$('.prdctfltr_filter, .prdctfltr_add_inputs, .prdctfltr_buttons').find(srchStr).val('');
			}
		}
		else {
			if ( mode === true ) {
				obj.closest('.prdctfltr_sc_products').find('.prdctfltr_filter, .prdctfltr_buttons').find(srchStr).remove();
	
				if ( $('.prdctfltr_wc_widget').length>0 ) {
					$('.prdctfltr_wc_widget').find('.prdctfltr_filter, .prdctfltr_buttons').find(srchStr).remove();
				}
				$('.prdctfltr_add_inputs').find(srchStr).remove();
			}
			else {
				$('.prdctfltr_filter, .prdctfltr_add_inputs, .prdctfltr_buttons').find(srchStr).remove();
			}
		}


	}

	$(document).on('click', 'a.prdctfltr_title_remove', function() {

		var filter = $(this).attr('data-key');

		if ( filter.substr(0,4) !== 'rng_' ) {
			var selectedRemove = $(this).attr('data-slug');
			if ( typeof selectedRemove !== 'undefined' && selectedRemove.indexOf( '>' ) > 0 ) {
				selectedRemove = selectedRemove.substr(selectedRemove.indexOf( '>' )+1);
			}

			var checkRemove = $(this).closest('.prdctfltr_wc').find('.prdctfltr_filter[data-filter="'+filter+'"] input[value="'+selectedRemove+'"]' );

			if ( checkRemove.length>0 ) {
				checkRemove.closest('label').trigger('click');
				var checkSubmit = checkRemove.closest('.prdctfltr_wc').find('.prdctfltr_woocommerce_filter_submit');
				if ( checkSubmit.length>0 ) {
					checkSubmit.trigger('click');
				}

				return false;
			}
		}

		if ( $(this).closest('.prdctfltr_filter').hasClass('prdctfltr_has_selection') ) {
			clear_filters_after($(this).closest('.prdctfltr_filter'));
		}

		var mode = $(this).closest('.prdctfltr_sc_products').length>0;

		if ( filter == 's' || filter == 'search_products' || filter == 'search' ) {
			clicked_remove($(this),mode,filter);
		}
		else if ( filter == 'price' ) {
			clicked_remove($(this),mode,filter);
		}
		else if ( filter == 'orderby' || filter == 'sale_products' || filter == 'instock_products' ) {
			clicked_remove($(this),mode,filter);
		}
		else if ( filter == 'vendor' || filter == 'instock' || filter == 'products_per_page' ) {
			clicked_remove($(this),mode,filter);
		}
		else if ( filter.substr(0,4) == 'mtar' ) {
			clicked_remove($(this),mode,filter);
		}
		else if ( filter.substr(0,4) !== 'rng_' ) {

			if ( $(this).closest('.prdctfltr_sc_products').length > 0 ) {
				var curr_els = $(this).closest('.prdctfltr_sc_products').find('input[name="'+filter+'"]');
				if ( $('.prdctfltr_wc_widget').length>0 ) {
					curr_els.push($('.prdctfltr_wc_widget').find('input[name="'+filter+'"]'));
				}
			}
			else {
				var curr_els = $('.prdctfltr_filter, .prdctfltr_add_inputs').find('input[name="'+filter+'"]');
			}

			var selectedString = $(this).attr('data-slug');
			if ( selectedString.indexOf( '>' ) > 0 ) {
				var termParent = selectedString.substr(0, selectedString.indexOf( '>' ));
				selectedString = selectedString.substr(selectedString.indexOf( '>' )+1);
			}

			var cur_vals = [];
			if ( selectedString.indexOf(',') > 0 ) {
				cur_vals = selectedString.split(',');
			}
			else if ( selectedString.indexOf('+') > 0 ) {
				cur_vals = selectedString.split('+');
			}
			else {
				cur_vals[0] = selectedString;
			}

			var cv_lenght = cur_vals.length;

			$.each(cur_vals, function(i, val23) {

				var curr_value = val23;

				curr_els.each( function() {

					var curr_chckd = $(this);
					var curr_chckdval = $(this).val();

					if ( curr_chckdval.indexOf( ',' ) > 0 ) {
						curr_chckd.val(curr_chckdval.replace(',' + curr_value, '').replace(curr_value + ',', ''));
					}
					else if ( curr_chckdval.indexOf( '+' ) > 0 ) {
						curr_chckd.val(curr_chckdval.replace('+' + curr_value, '').replace(curr_value + '+', ''));
					}
					else {
						curr_chckd.val(curr_chckdval.replace(curr_value, '').replace(curr_value, ''));
					}

				});

				if ( !--cv_lenght ) {

					curr_els.each( function() {

						var curr_chckd = $(this);

						if ( termParent ) {
							curr_chckd.val(termParent);
							if ( curr_chckd.val() == '' ) {
								curr_chckd.val(termParent);
							}
							
						}

					});

				}

			});

		}
		else {
			if ( $(this).closest('.prdctfltr_sc_products').length>0 ) {
				if ( filter == 'rng_price' ) {
					$(this).closest('.prdctfltr_sc_products').find('.prdctfltr_range.prdctfltr_rng_price input[type="hidden"]').each(function() {
						$(this).remove();
					});
					$('.prdctfltr_wc_widget').find('.prdctfltr_range.prdctfltr_rng_price input[type="hidden"]').remove()
				}
				else {
					$(this).closest('.prdctfltr_sc_products').find('.prdctfltr_range input[type="hidden"][name$="'+filter.substr(4, filter.length)+'"]').each(function() {
						$(this).remove();
					});
					$('.prdctfltr_wc_widget').find('.prdctfltr_range input[type="hidden"][name$="'+filter.substr(4, filter.length)+'"]').remove();
				}

			}
			else {
				if ( filter == 'rng_price' ) {
					$('.prdctfltr_wc').find('.prdctfltr_range.prdctfltr_rng_price input[type="hidden"]').each(function() {
						$(this).remove();
					});
				}
				else {
					$('.prdctfltr_wc').find('.prdctfltr_range input[type="hidden"][name$="'+filter.substr(4, filter.length)+'"]').each(function() {
						$(this).remove();
					});
				}
			}
		}

		prdctfltr_respond_550($(this).closest('.prdctfltr_wc').find('form.prdctfltr_woocommerce_ordering'));

		return false;

	});

	$(document).on('click', 'i.prdctfltr-plus', function() {

		$(this).closest('label').toggleClass('prdctfltr_show_subs');

		if ( $(this).closest('.prdctfltr_woocommerce').hasClass('pf_mod_masonry') ) {
			$(this) .closest('.prdctfltr_filter_inner').isotope('layout');
		}

		return false;

	});

	function prdctfltr_get_loader(curr) {

		var t = curr.closest('.prdctfltr_wc');
		if ( t.is(':visible') === false ) {
			return false;
		}

		var l = t.attr('data-loader');

		if ( l == 'none' ) {
			return false;
		}

		if ( typeof l !== 'undefined' ) {
			if ( l.substr(0, 4) == 'css-' ) {
				if ( t.find('.prdctfltr_woocommerce_filter:visible').length>0 ) {
					if ( $('.pf_ajax_loading').length == 0 ) {
						t.find('.prdctfltr_woocommerce_filter').addClass('pf_ajax_loading');
					}
				}
				else {
					t.prepend('<span class="prdctfltr_added_loader prdctfltr_woocommerce_filter pf_ajax_'+l+' pf_ajax_loading"><i class="prdctfltr-bars '+l+'"></i></span>');
				}
			}
			else {
				if ( t.find('.prdctfltr_woocommerce_filter:visible i').length > 0 && t.find('.prdctfltr_woocommerce_filter img').length == 0 ) {
					t.find('.prdctfltr_woocommerce_filter').addClass('pf_ajax_loading');
					t.find('.prdctfltr_woocommerce_filter i').replaceWith('<img src="'+prdctfltr.url+'lib/images/svg-loaders/'+l+'.svg" class="prdctfltr_reset_this prdctfltr_loader" />');
				}
				else {
					t.prepend('<div class="prdctfltr_added_loader"><img src="'+prdctfltr.url+'lib/images/svg-loaders/'+l+'.svg" class="prdctfltr_reset_this prdctfltr_loader" /></div>');
				}
			}
		}

	}

	function prdctfltr_reset_filters_550(obj) {

		checkAddInputs(obj);

		obj.find('.prdctfltr_filter input[type="hidden"]').each( function() {
			if ( prdctfltr.clearall[0] !== null) {
				if ( $.inArray( this.name, prdctfltr.clearall ) > -1 ) {
					if ( !$(this).val() ) {
						if ( $(this).attr('data-parent') ) {
							$(this).val($(this).attr('data-parent'));
						}
						else {
							$(this).remove();
						}
					}
				}
				else {
					if ( $(this).attr('data-parent') ) {
						$(this).val($(this).attr('data-parent'));
					}
					else {
						$(this).remove();
					}
				}
			}
			else {
				if ( $(this).attr('data-parent') ) {
					$(this).val($(this).attr('data-parent'));
				}
				else {
					$(this).remove();
				}
			}
		});

		obj.find('.prdctfltr_filter input.pf_search').val('').prop('disabled',true).attr('disabled','true');

		if ( obj.find('input[name="s"]').length>0 ) {
			obj.find('input[name="s"]').val('');
		}
		if ( obj.find('.prdctfltr_buttons input[name="sale_products"]').length>0 ) {
			obj.find('.prdctfltr_buttons input[name="sale_products"]').remove();
		}
		if ( obj.find('.prdctfltr_buttons input[name="instock_products"]').length>0 ) {
			obj.find('.prdctfltr_buttons input[name="instock_products"]').remove();
		}
		if ( obj.find('.prdctfltr_add_inputs input[name="orderby"]').length>0 ) {
			obj.find('.prdctfltr_add_inputs input[name="orderby"]').remove();
		}

		obj.find('input[name="reset_filter"]').remove();

	}

	function checkAddInputs(obj) {

		obj.find('.prdctfltr_attributes label.prdctfltr_active input[value]').each( function() {

			var eVal = $(this).val();
			var nVal = $(this).closest('.prdctfltr_attributes').attr('data-filter');

			$('.prdctfltr_wc .prdctfltr_add_inputs .pf_added_input[name="'+nVal+'"]').each(function(){
				if ( $(this).val().indexOf(eVal) > -1 ) {
					if ( $(this).val().indexOf(',') > -1 || $(this).val().indexOf('+') > -1 ) {
						$(this).val($(this).val().replace(',' + eVal, '').replace(eVal + ',', ''));
					}
					else {
						$(this).val('');
					}
					
				}
			});

			$.each(prdctfltr.js_filters, function(n18,obj43){
				if ( typeof obj43.adds !== 'undefined' && typeof obj43.adds[nVal] !== 'undefined' ) {
					delete prdctfltr.js_filters[n18].adds[nVal];
				}
			});

		});

	}

	function prdctfltr_remove_empty_inputs_550(obj) {

		obj.find('.prdctfltr_filter input[type="hidden"], .prdctfltr_filter input.pf_search, .prdctfltr_add_inputs input[type="hidden"]').each(function() {

			var curr_val = $(this).val();

			if ( curr_val == '' ) {
				if ( $(this).is(':visible') ) {
					$(this).prop('disabled',true).attr('disabled','true');
				}
				else {
					$(this).remove();
				}
			}

		});

	}

	function prdctfltr_remove_ranges_550(obj) {
		obj.find('.prdctfltr_filter.prdctfltr_range').each( function() {
			var curr_rng = $(this);
			if ( curr_rng.find('[name^="rng_min_"]').val() == undefined || curr_rng.find('[name^="rng_max_"]').val() == undefined ) {
				curr_rng.find('input').remove();
			}
		});
	}

	function prdctfltr_check_display_550(obj) {

		if ( $('body').hasClass('wc-prdctfltr-active') ) {

			if ( obj.attr('class').indexOf( 'pf_sidebar' ) == -1 ) {
				if ( obj.hasClass( 'pf_fullscreen' ) ) {
					obj.find('form').stop(true,true).fadeOut(200, function() {
						obj.find('.prdctfltr_close_sidebar').remove();
					});
				}
				else {
					if ( !obj.hasClass('prdctfltr_wc_widget') &&  !obj.hasClass('prdctfltr_always_visible') ) {
						obj.find('form').stop(true,true).slideUp(200);
					}
				}
			}
			else {
				obj.find('form').fadeOut(200);

				if ( obj.attr('class').indexOf( 'pf_sidebar_css' ) > 0 ) {
					if ( obj.hasClass('pf_sidebar_css_right') ) {
						$('body').css({'right':'0px','bottom':'auto','top':'auto','left':'auto'});
					}
					else {
						$('body').css({'right':'auto','bottom':'auto','top':'auto','left':'0px'});
					}
					$('.prdctfltr_overlay').remove();
				}
				obj.find('form').removeClass('prdctfltr_active');
				$('body').removeClass('wc-prdctfltr-active');

			}

		}

	}

	function prdctfltr_post_analytics(curr_fields) {
		if ( $.isEmptyObject( curr_fields ) === false ) {
			var data = {};

			$.each( curr_fields, function(i,o) {
				if ( $.isEmptyObject( o ) === false ) {
						$.each( o, function(i2,o2) {
							if ( $.inArray( i2, [ 'rng_min_price', 'rng_max_price', 'sale_products', 'instock_products', 'orderby', 'vendor', 'min_price', 'max_price', 'products_per_page' ] ) == -1 && i2.substring(0,4) !== 'rng_' && i2.substring(0,4) !== 'mta_' ) {
								if ( typeof data[i2] == 'undefined' ) {
									data[i2] = o2;
								}
							}
						} );
					}
			} );

			var analyticsData = {
				action: 'prdctfltr_analytics',
				filters: data,
				pf_nonce: $('.prdctfltr_wc[data-nonce]:first').attr('data-nonce'),
			};

			$.ajax({
				type: 'POST',
				url: prdctfltr.ajax,
				data: analyticsData,
				success: function() {},
				error: function() {},
			});
		}
	}

	function prdctfltr_get_fields_550(obj) {

		var curr_fields = {};

		if ( obj.css('display') == 'none' ) {
			return curr_fields;
		}

		var lookAt = '.prdctfltr_filter input[type="hidden"], .prdctfltr_filter input.pf_search, .prdctfltr_add_inputs input[name="orderby"], .prdctfltr_add_inputs input[name="s"], .prdctfltr_add_inputs input.pf_added_input';

		obj.find(lookAt).each( function() {
			if ( $(this).val() !== '' ) {
				curr_fields[$(this).attr('name')] = $(this).val();
			}
		});

		if ( obj.find('.prdctfltr_buttons input[name="sale_products"]:checked').length > 0 ) {
			curr_fields.sale_products = 'on';
		}
		if ( obj.find('.prdctfltr_buttons input[name="instock_products"]:checked').length > 0 ) {
			curr_fields.instock_products = obj.find('.prdctfltr_buttons:first input[name="instock_products"]:checked').val();
		}

		return curr_fields;

	}

	var infiniteWasReset = false;
	function after_ajax(curr_next) {

		function AAscrollHandler() {

			if( infiniteLoad.find('a.disabled').length == 0 && $(window).scrollTop()>=infiniteLoad.position().top-$(window).height()*0.8){
				infiniteLoad.find('a:not(.disabled)').trigger('click');
			}

		};

		$.each(curr_next, function(b,setView) {
			setView = $(setView);

			infiniteLoad = $('.prdctfltr-pagination-infinite-load');
			if ( infiniteLoad.length>0 ) {
				if ( infiniteLoad.find('.button.disabled').length>0 ) {

					scrollInterval = null;
					infiniteWasReset = true;
				}
				else {
					if ( infiniteWasReset ) {
						scrollInterval = setInterval(function() {
							if ( didScroll ) {
								didScroll = false;
								if ( ajaxActive !== false || historyActive !== false ) {
									return false;
								}
								AAscrollHandler();
							}
						}, 250);
					}
				}
			}


			if ( setView.hasClass('pf_after_ajax') ) {
				return false;
			}
			setView.addClass('pf_after_ajax');

			if ( setView.hasClass('pf_mod_masonry') ) {

				setView.find('.prdctfltr_woocommerce_ordering').show();
				setView.find('.prdctfltr_filter_inner').isotope({
					resizable: false,
					masonry: { }
				});
			}

			if ( setView.find('.prdctfltr_expand_parents').length > 0 ) {
				prdctfltr_all_cats(setView);
			}
			else {
				prdctfltr_show_opened_cats(setView);
			}
			prdctfltr_init_scroll(setView);
			prdctfltr_init_tooltips(setView);
			reorder_selected(setView);
			reorder_adoptive(setView);
			set_select_index(setView);
			init_search(setView);
			init_ranges(setView);
			do_zindexes(setView);
			reorder_limit(setView);
			prdctfltr_tabbed_selection(setView);
			if ( $('body').hasClass('wc-prdctfltr-active') ) {
				$('body').removeClass('wc-prdctfltr-active');
			}

			if ( setView.hasClass('prdctfltr_step_filter') ) {
				if ( setView.find('.prdctfltr_woocommerce_filter_submit').length>0) {
					setView.find('.prdctfltr_woocommerce_filter_submit').remove();
				}
				setView.find('.prdctfltr_buttons').prepend('<a class="button prdctfltr_woocommerce_filter_submit pf_stopajax" href="#">'+(prdctfltr.js_filters[setView.attr('data-id')].button_text==''?prdctfltr.localization.getproducts:prdctfltr.js_filters[setView.attr('data-id')].button_text)+'</a>');
				setView.closest('prdctfltr_sc').addClass('prdctfltr_sc_step_filter');
			}

			prdctfltr_filter_terms_init(setView);

			get_category_mode(setView);
			prdctfltr_added_check(setView);
			prdctfltr_make_clears(setView);

			setView.find('.prdctfltr_filter').each( function() {
				check_selection_boxes($(this),'init');
			});

			setView.find('.prdctfltr_buttons:first label.prdctfltr_active').each(function() {
				check_buttons($(this),'init');
			});

			prdctfltr_show_opened_widgets(setView);

			if ( setView.hasClass('pf_mod_masonry') ) {
				setView.find('.prdctfltr_filter_inner').isotope('layout');
				if ( !setView.hasClass('prdctfltr_always_visible') ) {
					setView.find('.prdctfltr_woocommerce_ordering').hide();
				}
			}

		});
	}

	var pf_paged = 1;
	var pf_offset = 0;
	var pf_restrict = '';

	$(document).on('click', '.prdctfltr_sc_products.prdctfltr_ajax '+prdctfltr.ajax_pagination_class+' a, body.prdctfltr-ajax.prdctfltr-shop '+prdctfltr.ajax_pagination_class+' a, .prdctfltr-pagination-default a, .prdctfltr-pagination-load-more a', function() {

		if (ajaxActive===true) {
			return false;
		}

		ajaxActive = true;

		var loadMore = ( $(this).closest('.prdctfltr-pagination-load-more').length > 0 ? true : false );
		var curr_link = $(this);

		var shortcodeAjax = false;
		var checkShortcode = curr_link.closest('.prdctfltr_sc_products');

		if ( archiveAjax===false && checkShortcode.length > 0 && checkShortcode.hasClass('prdctfltr_ajax') ) {
			shortcodeAjax = true;
			var obj = checkShortcode.find('form:first');
		}
		else {
			var obj = $('div:not(.prdctfltr_sc_products) .prdctfltr_wc:not(.prdctfltr_step_filter):first form');
		}

		if ( obj.length == 0 ) {
			obj = $('.prdctfltr_wc_widget').find('form:first');
		}

		var curr_href = curr_link.attr('href');

		if ( loadMore === true ) {
			$(this).closest('.prdctfltr-pagination-load-more').addClass('prdctfltr-ignite');
			if ( shortcodeAjax===false ) {
				pf_offset = parseInt( $(prdctfltr.ajax_class).find(prdctfltr.ajax_product_class).length, 10 );
			}
			else {
				pf_offset = parseInt( checkShortcode.find(prdctfltr.ajax_product_class).length, 10 );
			}
		}
		else {
			if ( curr_href.indexOf('paged=') >= 0 ) {
				pf_paged = parseInt( curr_href.getValueByKey('paged'), 10 );
			}
			else if ( curr_href.indexOf('product-page=') >= 0 ) {
				pf_paged = parseInt( curr_href.getValueByKey('product-page'), 10 );
			}
			else {
				var arrUrl = curr_href.split('/'+prdctfltr.page_rewrite+'/');
				if ( typeof arrUrl[1] !== 'undefined' ) {
					if ( arrUrl[1].indexOf('/')>0 ) {
						arrUrl[1] = arrUrl[1].substr( 0, arrUrl[1].indexOf('/') );
					}
					pf_paged =  parseInt( arrUrl[1], 10 );
				}
			}
		}

		pf_restrict = 'pagination';

		ajaxActive = false;
		prdctfltr_respond_550(obj);

		return false;

	});

	function get_shortcode(id) {
		var wrf = {};
		if ( typeof prdctfltr.pagefilters[id].wcsc !== 'undefined' && prdctfltr.pagefilters[id].wcsc === true ) {
			wrf = prdctfltr.pagefilters[id].atts;
		}
		$.each( prdctfltr.pagefilters, function(i,o) {
			if ( i !== id ) {
				if ( typeof prdctfltr.pagefilters[i].wcsc !== 'undefined' && prdctfltr.pagefilters[i].wcsc === true ) {
					wrf = prdctfltr.pagefilters[i].atts;
				}
			}
		} );
		return wrf;
	}

	function prdctfltr_respond_550(curr) {

		if (ajaxActive===true) {
			return false;
		}

		ajaxActive = true;

		var curr_filter = curr.closest('.prdctfltr_wc');

		var ourObj = prdctfltr_get_obj_580(curr_filter);
		var pf_length = prdctfltr_count_obj_580(ourObj);
		var or_length = pf_length;

		if ( !curr.closest('.prdctfltr_wc').hasClass('prdctfltr_step_filter') && archiveAjax === true ) {
			$(prdctfltr.ajax_class+':first').fadeTo(200,0.5).addClass('prdctfltr_faded');
		}

		if ( prodcutsWrapper !== false ) {
			prodcutsWrapper.fadeTo(200,0.5).addClass('prdctfltr_faded');
		}

		if ( stopAjax === true ) {
			shortcodeAjax = false;
			archiveAjax = false;
			stopAjax = false;
		}

		var curr_fields = {};
		var requested_filters = {};

		$.each( ourObj, function(i, obj) {

			obj=$(obj);

			if ( obj.find('input[name="reset_filter"]:checked').length > 0 ) {
				prdctfltr_reset_filters_550(obj);
			}
			else {
				prdctfltr_remove_empty_inputs_550(obj);
			}

			prdctfltr_get_loader(obj);

			var pf_id = obj.attr('data-id');

			prdctfltr_remove_ranges_550(obj);

			prdctfltr_check_display_550(obj);

			if ( !obj.hasClass('prdctfltr_mobile') ) {
				requested_filters[pf_id] = pf_id;
			}

			if ( !--pf_length ) {

				$.each( ourObj, function(i, obj1) {
					curr_fields[$(obj1).attr('data-id')] = prdctfltr_get_fields_550(obj1);
				});

				if ( prdctfltr.analytics == 'yes' ) {
					setTimeout( function() {
						prdctfltr_post_analytics(curr_fields);
					}, 250 );
				}

				if (archiveAjax===true||shortcodeAjax===true) {

					var pf_set = 'archive';
					if ( archiveAjax===true && !$('body').hasClass('prdctfltr-shop') ) {
						pf_set = 'shortcode';
					}
					else {
						pf_set = ( archiveAjax === true ? 'archive' : 'shortcode' );
					}

					var data = {
						action: 'prdctfltr_respond_550',
						pf_url: location.protocol + '//' + location.host + location.pathname,
						pf_request: prdctfltr.js_filters,
						pf_requested: requested_filters,
						pf_shortcode: prdctfltr.js_filters[pf_id].atts,
						pf_filters: curr_fields,
						pf_set: pf_set,
						pf_id: pf_id,
						pf_paged: pf_paged,
						pf_pagefilters: prdctfltr.pagefilters,
						pf_restrict: pf_restrict
					};

					if ( $('.prdctfltr_wc_widget').length > 0 ) {

						var widget = $('.prdctfltr_wc_widget:first');

						var rpl = $('<div></div>').append(widget.find('.pf-help-title:first').clone()).html().toString().replace(/\t/g, '');
						var rpl_off = $('<div></div>').append(widget.find('.pf-help-title:first').find('.prdctfltr_widget_title').clone()).html().toString().replace(/\t/g, '');

						rpl = rpl.replace(rpl_off, '%%%');

						rpl = rpl.replace('<div class="pf-help-title">', '');
						rpl = rpl.substr(0,rpl.length-6);

						data.pf_widget_title = $.trim(rpl);

					}

					if ( typeof obj.attr('data-lang') !== 'undefined' ) {
						data.lang = obj.attr('data-lang');
					}

					if ( pf_offset>0 ) {
						data.pf_offset = pf_offset;
					}

					if ( $(prdctfltr.ajax_orderby_class).length>0 ) {
						data.pf_orderby_template = 'set';
					}

					if ( $(prdctfltr.ajax_count_class).length>0 ) {
						data.pf_count_template = 'set';
					}

					if ( or_length==1 && obj.hasClass('prdctfltr_step_filter') ) {
						data.pf_step = 1;
						data.pf_set = 'shortcode';
					}

					if ( pf_set == 'shortcode' ) {
						if ( prdctfltr.active_sc !== '' ) {
							data.pf_active = prdctfltr.active_sc;
						}
					}

					curr_filter.find('.pf_added_input').each(function() {
						if ( typeof data.pf_adds == 'undefined' ) {
							data.pf_adds = {};
						}
						data.pf_adds[$(this).attr('name')] = $(this).val();
					});

					$.ajax({
						type: 'POST',
						url: prdctfltr.ajax,
						data: data,
						success: function(response) {
							if (response) {
								if ( pf_offset>0 ) {
									response.offset = pf_offset;
								}
								var getElement = shortcodeAjax === true ? prodcutsWrapper : false;
								prdctfltr_handle_response_580(response, archiveAjax, shortcodeAjax, getElement);
							}
						},
						error: function(response) {
							alert('Error!');
						}
					});

				}
				else {

					obj.find('.prdctfltr_filter input[type="hidden"]:not([name="post_type"]), .prdctfltr_filter input[name="s"], .prdctfltr_filter input[name="sale_products"], .prdctfltr_filter input[name="instock_products"]').each(function () {
						obj.find('input[name="'+this.name+'"]:gt(0)').remove();
					});

					var cf_length = $.pfcount(curr_fields);

					if ( cf_length > 1 ) {
						var notEmpty = false;
						$.each( curr_fields, function(e1,w1) {
							$.each( w1, function( k02, s02 ) {
								notEmpty = true;
								if ( k02 != 's' && obj.find('input[name="'+k02+'"]').length == 0 ) {
									obj.find('.prdctfltr_add_inputs').append('<input type="hidden" name="'+k02+'" value="'+s02+'" class="pf_added_input" />');
								}
								else if ( k02 != 's' && obj.find('input[name="'+k02+'"]').length > 0 ) {
									obj.find('input[type="hidden"][name="'+k02+'"]').val(s02);
								}
								if ( k02 == 's' && obj.find('input[name="s"]').length == 0 ) {
									obj.find('.prdctfltr_add_inputs').append('<input type="hidden" name="s" value="'+s02+'" class="pf_added_input" />');
								}
							});
						});
					}

					if ( $('.prdctfltr_wc input[name="orderby"][value="'+prdctfltr.orderby+'"]').length > 0 ) {
						$('.prdctfltr_wc input[name="orderby"][value="'+prdctfltr.orderby+'"]').remove();
					}

					obj.find('.prdctfltr_woocommerce_ordering').submit();

				}

			}

		});

	}

	function u(e) {
		return typeof e == 'undefined' ? false : e;
	}

	function prdctfltr_handle_response_580(response, archiveAjax, shortcodeAjax, getElement) {

		var ajax_length = prdctfltr_count_obj_580(response);
		var ajaxRefresh = {};
		var query = '';

		for (var n in response) {
			if (response.hasOwnProperty(n)) {
				var obj2 = response[n];

				if ( n == 'products' ) {
					console.log(n);
					console.log(response[n]);
					if ( !isStep ) {

						var obj3 = ( $(obj2).find(prdctfltr.ajax_class).length > 0 ? $(obj2).find(prdctfltr.ajax_class) : $(obj2) );

						if (archiveAjax===true) {
							var products = $(prdctfltr.ajax_class+':first');
						}
						else if ( shortcodeAjax===true ) {
							var products = getElement === false ? $(prdctfltr.ajax_class+':first') : getElement.find(prdctfltr.ajax_class);
						}
						else {
							var products = $(prdctfltr.ajax_class+':first');
						}

						if ( products.find('.pl-loops').length>0 ) {
							products = products.find('.pl-loops:first');
						}

						if ( products.is('.pl-loops') && products.data('isotope') ) {
							if ( typeof response.offset == 'undefined' ) {
								products.isotope( 'remove', products.data('isotope').element.children );
							}

							if ( obj3.find(prdctfltr.ajax_product_class).length>0 ) {
								products.isotope( 'insert', obj3.find(prdctfltr.ajax_product_class) );
							}
							else {
								products.isotope( 'insert', obj3 );
							}

							var container = products;
							container.imagesLoaded( function() {
								products.isotope('layout');
							} );
						}
						else {
							if ( obj3.length<1 ) {
								products.empty();
							}
							else {
								if ( typeof response.offset == 'undefined' ) {
									if ( obj3.find(prdctfltr.ajax_product_class).length > 0 || obj3.find(prdctfltr.ajax_category_class).length > 0 ) {
										pf_animate_products( products, obj3, 'replace' );
									}
									else {
										if ( products.data('isotope') ) {
											products.isotope( 'remove', products.data('isotope').element.children );
											products.isotope( 'insert', obj3 );
										}
										else {
											products.empty().append(obj3[0].innerHTML);
										}
									}
								}
								else {
									if ( obj3.find(prdctfltr.ajax_product_class).length > 0 || obj3.find(prdctfltr.ajax_category_class).length > 0 ) {
										pf_animate_products( products, obj3, historyActive===false?'append':'replace' );
									}
									response.products = $('<div></div>').append(products.clone().removeAttr('style').removeClass('prdctfltr_faded')).html();
								}
							}
						}

						if ( $(obj2).find(prdctfltr.ajax_count_class).length>0 ) {
							response.count = $(obj2).find(prdctfltr.ajax_count_class).outerHTML();
						}

						$('.prdctfltr_faded').fadeTo(200,1).removeClass('prdctfltr_faded');
							
						setTimeout( function() {
							pf_get_scroll(products, 0);
						}, 200 );

					}
				}
				else if ( n == 'pagination' ) {

					getElement === false ? $(prdctfltr.ajax_class+':first') : getElement.find(prdctfltr.ajax_class);

					if (archiveAjax===true&&$('body').hasClass('prdctfltr-shop')) {
						var pagination = ( prdctfltr.ajax_pagination_type=='default' ? $(prdctfltr.ajax_pagination_class) : $('.'+prdctfltr.ajax_pagination_type) );
					}
					else if ( shortcodeAjax===true ) {
						if ( getElement === false ) {
							getElement = $(prdctfltr.ajax_class+':first');
						}

						var pagination = getElement.find(prdctfltr.ajax_pagination_class);
						if ( pagination.length < 1 ) {
							pagination = getElement.find('.prdctfltr-pagination-default');
						}
						if ( pagination.length < 1 ) {
							pagination = getElement.find('.prdctfltr-pagination-load-more');
						}
						if ( pagination.length < 1 ) {
							pagination = $(prdctfltr.ajax_pagination_class);
						}
					}
					else if ( shortcodeAjax===false ) {
						var pagination = $(prdctfltr.ajax_pagination_class);
						if ( pagination.length < 1 ) {
							pagination = $('.prdctfltr-pagination-default');
						}
						if ( pagination.length < 1 ) {
							pagination = $('.prdctfltr-pagination-load-more');
						}
					}

					if ( !isStep && typeof products !== 'undefined' && products.find(prdctfltr.ajax_product_class).length>0 ) {

						obj2 = $(obj2);

						if ( obj2 !== '' ) {
							if ( pagination.length < 1 ) {
								if ( $('.pf_pagination_dummy').length == 0 )  {
									if ( shortcodeAjax===true ) {
										getElement.find(prdctfltr.ajax_class+':first').after('<div class="pf_pagination_dummy"></div>');
									}
									else {
										$(prdctfltr.ajax_class+':first').after('<div class="pf_pagination_dummy"></div>');
									}
								}

								pagination = $('.pf_pagination_dummy');
							}
						}

						if ( obj2.length<1 ) {
							pagination.empty();
						}
						else {
							$.each( pagination, function() {
								$(this).replaceWith(obj2[0].outerHTML);
							} );
						}

					}
					else {
						pagination.empty();
					}
				}
				else if ( n == 'js_filters' ) {
					obj2 = $(obj2);
					$.each( obj2[0], function(i,f) {
						prdctfltr.js_filters[i] = f;
					} );
				}
				else if ( n == 'prdctfltr' ) {
					obj2 = $(obj2);
					prdctfltr = obj2[0];
				}
				else if ( n == 'ranges' ) {
					obj2 = $(obj2);
					prdctfltr.rangefilters = obj2[0];
				}
				else if ( n == 'orderby' ) {

					obj2 = $(obj2);

					$.each( $(prdctfltr.ajax_orderby_class), function() {
						$(this).replaceWith(obj2[0].outerHTML);
					} );

				}
				else if ( n == 'count' ) {
					console.log(n);
					console.log(response[n]);
					obj2 = $(obj2);

					if ( obj2.length<1 ) {
						$(prdctfltr.ajax_count_class).html(prdctfltr.localization.noproducts);
					}
					else {
						$.each( $(prdctfltr.ajax_count_class), function() {
							$(this).replaceWith(obj2[0].outerHTML);
						} );
					}
	
				}
				else if ( n == 'query' ) {
					if ( prdctfltr.permalinks !== 'yes'  ) {
						query = ( obj2 == '' ? location.protocol + '//' + location.host + location.pathname : obj2 );
					}
					else {
						query = location.protocol + '//' + location.host + location.pathname;
					}
				}
				else if ( n.substring(0, 9) == 'prdctfltr' ){
					obj2 = $(obj2);

					if ( obj2.hasClass('prdctfltr_wc') ) {
						if ( pf_offset>0&&$(response.products).find(prdctfltr.ajax_product_class).length>0 || pf_offset==0 ) {
							if ( $('.prdctfltr_wc[data-id="'+n+'"]').length > 0 ) {
								$('.prdctfltr_wc[data-id="'+n+'"]').replaceWith(obj2);
								ajaxRefresh[n] = n;
							}
						}
						else {
							$('.prdctfltr_wc[data-id="'+n+'"]').find('.prdctfltr_woocommerce_filter').replaceWith(obj2.find('.prdctfltr_woocommerce_filter'));
						}
						if ( $('.prdctfltr_wc[data-id="'+n+'"] + .prdctfltr_mobile + .prdctfltr_mobile').length>0 ) {
							$('.prdctfltr_wc[data-id="'+n+'"] + .prdctfltr_mobile + .prdctfltr_mobile').remove();
						}
					}
					else if ( obj2.hasClass('prdctfltr-widget') ) {
						if ( $('.prdctfltr_wc[data-id="'+n+'"]').length>0 ) {
							$('.prdctfltr_wc[data-id="'+n+'"]').closest('.prdctfltr-widget').replaceWith(obj2);
							ajaxRefresh[n] = n;
						}
					}
				}
				else if ( n == 'title' && obj2 !== '' ) {
					if ( $('h1').length>0 ) {

						$.each(  $('h1'), function() {
							$(this).html(obj2[0].innerHTML);
						} );

					}
				}
				else if ( n == 'desc' ) {
					if ( pf_paged<2 && obj2 !== '' ) {
						if ( $('.term-description').length>0 ) {

							$.each( $('.term-description'), function() {
								$(this).html(obj2[0].innerHTML);
							} );

						}
						else if ( $('.page-description').length>0 ) {

							$.each( $('.page-description'), function() {
								$(this).html(obj2[0].innerHTML);
							} );

						}
					}
					else {
						if ( $('.term-description').length>0 ) {

							$.each( $('.term-description'), function() {
								$(this).html('');
							} );

						}
						if ( $('.page-description').length>0 ) {

							$.each( $('.page-description'), function() {
								$(this).html('');
							} );

						}
					}
				}

			}

			if ( !--ajax_length ) {

				if ( !$.isEmptyObject( ajaxRefresh ) ) {
					$.each(ajaxRefresh, function(m,obj4) {
						after_ajax($('.prdctfltr_wc[data-id="'+m+'"]'));
						if ( $('.prdctfltr_wc[data-id="'+m+'"]').next().is('.prdctfltr_mobile') ) {
							after_ajax($('.prdctfltr_wc[data-id="'+m+'"]').next());
						}
					});
				}

				$(document.body).trigger( 'post-load' );
				if ( prdctfltr.js !== '' ) {
					eval(prdctfltr.js);
				}

				if ( historyActive === false && ( archiveAjax || $('body').hasClass('prdctfltr-sc') ) === true /*&& pf_offset == 0*/ ) {
					if ( query.indexOf('https:') > -1 && location.protocol != 'https:' ) {
						query = query.replace('https:','http:');
					}
					else if ( query.indexOf('http:') > -1 && location.protocol != 'http:' ) {
						query = query.replace('http:','https:');
					}

					if ( pf_offset>0 ) {
						query += query.indexOf('?')>-1 ? '&offset='+pf_offset : '?offset='+pf_offset;
					}

					var historyId = guid();

					makeHistory[historyId] = response;
					makeHistory[historyId].prdctfltr = prdctfltr;
					history.pushState({filters:historyId, archiveAjax:archiveAjax, shortcodeAjax:shortcodeAjax}, document.title, query);
				}

				ajaxActive = false;
				pf_paged = 1;
				pf_offset = 0;
				pf_restrict = '';

			}

		}

	}

	var historyActive = false;

	if ( archiveAjax === true || $('body').hasClass('prdctfltr-sc') ) {

		window.addEventListener('popstate', function(e) {
			if ( ajaxActive === false && historyActive === false ) {
				historyActive = true;
				ajaxActive = true;
				var state = typeof history.state != 'undefined' ? history.state : null;
				if ( state != null ) {
					if ( typeof state.filters !== 'undefined' && typeof makeHistory[state.filters] !== 'undefined' ) {
						prdctfltr_handle_response_580(makeHistory[state.filters], state.archiveAjax, state.shortcodeAjax, false);
					}
					else if ( typeof pageFilters !== 'undefined' ) {
						prdctfltr_handle_response_580(pageFilters, ( $('body').hasClass('prdctfltr-ajax') || $('body').hasClass('prdctfltr-sc') ? true : false ), false, false);
					}
				}
				setTimeout( function() {
					historyActive = false;
				}, 500 );
			}
		});
	}

	$(window).load( function() {
		$('.pf_mod_masonry .prdctfltr_filter_inner').each( function() {
			$(this).isotope('layout');
		});
	});

	if ( $('.prdctfltr-widget').length == 0 || $('.prdctfltr-widget .prdctfltr_error').length == 1 ) {

		$(window).on('resize', function() {

			$('.prdctfltr_woocommerce').each( function() {

				var curr = $(this);
		
				if ( curr.hasClass('pf_mod_row') ) {

					if ( window.matchMedia('(max-width: 768px)').matches ) {
						curr.find('.prdctfltr_filter_inner').css('width', 'auto');
					}
					else {
						var curr_columns = curr.find('.prdctfltr_filter_wrapper:first').attr('data-columns');

						var curr_scroll_column = curr.find('.prdctfltr_woocommerce_ordering').width();
						var curr_columns_length = curr.find('.prdctfltr_filter').length;

						curr.find('.prdctfltr_filter_inner').css('width', curr_columns_length*curr_scroll_column/curr_columns);
						curr.find('.prdctfltr_filter').css('width', curr_scroll_column/curr_columns);
					}
				}
			});
		});
	}

	if ((/Trident\/7\./).test(navigator.userAgent)) {
		$(document).on('click', '.prdctfltr_checkboxes label img', function() {
			$(this).parents('label').children('input:first').change().click();
		});
	}

	if ((/Trident\/4\./).test(navigator.userAgent)) {
		$(document).on('click', '.prdctfltr_checkboxes label > span > img, .prdctfltr_checkboxes label > span', function() {
			$(this).parents('label').children('input:first').change().click();
		});
	}

	function prdctfltr_filter_results(currThis,list,searchIn,curr_filter) {

		var filter = currThis.val();
		var curr = currThis.closest('.prdctfltr_filter');

		if( filter ) {

			if ( curr.find('div.prdctfltr_sub').length > 0 ) {
				$(list).find('.prdctfltr_sub').prev().addClass('prdctfltr_show_subs');
				if ( curr.hasClass('prdctfltr_searching') === false ) {
					curr.addClass('prdctfltr_searching');
				}
			}
			$(list).find(searchIn+' > span:not(:Contains(' + filter + '))').closest('label').attr('style', 'display:none !important');
			$(list).find(searchIn+' > span:Contains(' + filter + ')').closest('label').show();
			curr.find('.pf_more').hide();

		}
		else {

			if ( curr.find('div.prdctfltr_sub').length > 0 ) {
				$(list).find('.prdctfltr_sub').prev().removeClass('prdctfltr_show_subs');
			}

			curr.removeClass('prdctfltr_searching');
			$(list).find(searchIn).show();

			var checkboxes = curr.find('.prdctfltr_checkboxes');

			checkboxes.each(function(){
				var max = parseInt(curr.attr('data-limit'), 10);
				if (max != 0 && $(list).find(searchIn).length > max+1) {
					$(list).find(searchIn+':gt('+max+')').attr('style', 'display:none !important');
					$(list).find('.pf_more').html('<span>'+prdctfltr.localization.show_more+'</span>').removeClass('pf_activated');
				}
			});
			curr.find('.pf_more').show();
		}

		if ( curr_filter.hasClass('pf_mod_masonry') ) {
			curr_filter.find('.prdctfltr_filter_inner').isotope('layout');
		}
		if ( curr.hasClass('prdctfltr_expand_parents') ) {
			prdctfltr_all_cats(curr_filter);
		}

		return false;
	}

	function prdctfltr_filter_terms_init(curr) {
		curr = ( curr == null ? $('.prdctfltr_woocommerce') : curr );

		curr.find('.prdctfltr_add_search .prdctfltr_add_scroll').each( function() {
			var list = $(this);
			prdctfltr_filter_terms(list);
		});
	}

	function prdctfltr_filter_terms(list) {

		var curr_filter = list.closest('.prdctfltr_wc');
		var form = $("<div>").attr({"class":"prdctfltr_search_terms","action":"#"});
		var input = $("<input>").attr({"class":"prdctfltr_search_terms_input prdctfltr_reset_this","type":"text","placeholder":prdctfltr.localization.filter_terms});

		if ( curr_filter.hasClass('pf_select') || curr_filter.hasClass('pf_default_select') || list.closest('.prdctfltr_filter').hasClass('prdctfltr_terms_customized_select') ) {
			$(form).append(input).prependTo(list);
		}
		else {
			$(form).append(input).insertBefore(list);
		}

		if ( list.closest('.prdctfltr_filter').hasClass('pf_adptv_default') ) {
			var searchIn = 'label:not(.pf_adoptive_hide)';
		}
		else {
			var searchIn = 'label';
		}

		var timeoutId = 0;

		$(input).change( function () {

			var filter = $(this);

			clearTimeout(timeoutId);
			timeoutId = setTimeout(function() {prdctfltr_filter_results(filter,list,searchIn,curr_filter);}, 500);

		})
		.keyup( function () {
			$(this).change();
		});

	}

	$(document).on('click', '.prdctfltr_sc_products '+prdctfltr.ajax_class+' '+prdctfltr.ajax_category_class+' a, .prdctfltr-shop.prdctfltr-ajax '+prdctfltr.ajax_class+' '+prdctfltr.ajax_category_class+' a', function() {

		var curr = $(this).closest(prdctfltr.ajax_category_class);

		var curr_sc = ( curr.closest('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter)').length > 0 ? curr.closest('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter)') : $('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter):first').length > 0 ? $('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter):first') : $('.prdctfltr_woocommerce:not(.prdctfltr_step_filter):first').length > 0 ? $('.prdctfltr_woocommerce:not(.prdctfltr_step_filter):first') : 'none' );

		if ( curr_sc == 'none' ) {
			return;
		}

		if ( curr_sc.hasClass('prdctfltr_sc_products') ) {
			var curr_filter = ( curr_sc.find('.prdctfltr_woocommerce:not(.prdctfltr_step_filter)').length > 0 ? curr_sc.find('.prdctfltr_woocommerce:not(.prdctfltr_step_filter):not(.prdctfltr_mobile)') : $('.prdctfltr-widget').find('.prdctfltr_woocommerce:not(.prdctfltr_mobile)') );
		}
		else if ( $('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter)').length == 0 ) {
			var curr_filter = curr_sc;
		}
		else {
			return;
		}

		var cat = curr.find('.prdctfltr_cat_support').data('slug');

		var hasFilter = curr_filter.find('.prdctfltr_filter[data-filter="product_cat"] input[type="checkbox"][value="'+cat+'"]:first');

		if ( hasFilter.length > 0 ) {
			ajaxActive = true;
			$.each( curr_filter.find('.prdctfltr_filter[data-filter="product_cat"] label.prdctfltr_active'), function() {
				$(this).trigger('click');
			} );
			setTimeout( function() {
				ajaxActive = false;
				hasFilter.closest('label').trigger('click');
				if ( !curr_filter.hasClass('prdctfltr_click_filter') ) {
					curr_filter.find('.prdctfltr_woocommerce_filter_submit').trigger('click');
				}
			}, 25 );
		}
		else {
			var hasField = curr_filter.find('.prdctfltr_filter[data-filter="product_cat"]');

			if ( hasField.length > 0 ) {
				hasField.find('input[name="product_cat"]').val(cat);
			}
			else {
				var append = $('<input name="product_cat" type="hidden" value="'+cat+'" />');
				curr_filter.find('.prdctfltr_add_inputs').append(append);
			}

			if ( !curr_filter.hasClass('prdctfltr_click_filter') ) {
				curr_filter.find('.prdctfltr_woocommerce_filter_submit').trigger('click');
			}
			else {
				prdctfltr_respond_550(curr_filter.find('form'));
			}
		}

		return false;

	});

	if ( $('body.prdctfltr-ajax '+prdctfltr.ajax_orderby_class).length>0 ) {

		$(document).on('submit', 'body.prdctfltr-ajax '+prdctfltr.ajax_orderby_class, function() {
			return false;
		});

		$(document).on('change', 'body.prdctfltr-ajax '+prdctfltr.ajax_orderby_class+' select', function() {

			var orderVal = $(this).val();

			$('.prdctfltr_wc form').each( function() {

				if ( $(this).closest('.prdctfltr_sc').length==0 ) {

					if ( $(this).find('.prdctfltr_orderby input[type="checkbox"][val="'+orderVal+'"]').length>0 ) {
						$(this).find('.prdctfltr_orderby input[type="checkbox"][val="'+orderVal+'"]').trigger('click');
					}
					else {
						$(this).find('.prdctfltr_add_inputs').append('<input name="orderby" value="'+orderVal+'" />');
						prdctfltr_respond_550($(this));
					}

				}

			});

		});

	}

	if ( $('.prdctfltr_sc.prdctfltr_ajax '+prdctfltr.ajax_orderby_class).length>0 ) {
		$(document).on('submit', '.prdctfltr_sc.prdctfltr_ajax '+prdctfltr.ajax_orderby_class, function() {
			return false;
		} );
	
		$(document).on('change', '.prdctfltr_sc.prdctfltr_ajax '+prdctfltr.ajax_orderby_class+' select', function() {

			var orderVal = $(this).val();
			var shortcodeForm = $(this).closest('.prdctfltr_sc').find('form');
	
			shortcodeForm.find('.prdctfltr_add_inputs').append('<input name="orderby" value="'+orderVal+'" />');
			prdctfltr_respond_550(shortcodeForm);
			
		} );
	}



	function pf_get_scroll( products, offset ) {

		var objOffset = -1;

		if ( products.length==0 ) {
			objOffset = $('.prdctfltr_wc:first').offset().top;
		}
		else {
			if ( offset>0 ) {

				var thisWrap = ( products.find(prdctfltr.ajax_product_class+':gt('+(offset-1)+')').length>0 ? products.find(prdctfltr.ajax_product_class+':gt('+(offset-1)+')') : products.find(prdctfltr.ajax_product_class+':last') );

				objOffset = thisWrap.offset().top;

			}
			else {
				if ( prdctfltr.ajax_scroll == 'products' ) {
					objOffset = ( products.find(prdctfltr.ajax_product_class+':first').length>0 ? products.find(prdctfltr.ajax_product_class+':first').offset().top : products.offset().top );
				}
				else if ( prdctfltr.ajax_scroll == 'top' ) {
					objOffset = 0;
				}
				else if ( prdctfltr.ajax_scroll == 'filter' ) {
					if ( products.closest('.prdctfltr_sc_products').find('.prdctfltr_wc').length>0 ) {
						objOffset = products.closest('.prdctfltr_sc_products').find('.prdctfltr_wc').offset().top;
					}
					else {
						objOffset = $('.prdctfltr_wc:first').offset().top;
					}
				}
			}
		}

		if ( objOffset > -1 ) {
			scrollTo(parseInt(objOffset, 10));
		}

	}

	function pf_animate_products( products, obj2, type ) {
		var newProducts = obj2.find(prdctfltr.ajax_product_class);

		if ( newProducts.length>0 ) {

			if ( products.data('isotope') ) {
				if ( type == 'replace' ) {
					products.isotope( 'remove', products.data('isotope').element.children );
				}

				products.isotope( 'insert', newProducts );

				var container = products;
				container.imagesLoaded( function() {
					products.isotope('layout');
					$('.prdctfltr_faded').fadeTo(200,1).removeClass('prdctfltr_faded');
				} );
			}
			else {

				var beforeLength = products.find(prdctfltr.ajax_product_class).length;

				if ( type == 'replace' ) {
					products.empty();

					var hasCats = obj2.find(prdctfltr.ajax_category_class);

					if ( hasCats.length>0 ) {
						products.append(hasCats);
					}
				}

				products.append(newProducts);

				var addedProducts = ( type == 'replace' || historyActive === true ? products.find(prdctfltr.ajax_product_class) : products.find(prdctfltr.ajax_product_class+':gt('+beforeLength+')') );
				if ( typeof addedProducts !== 'undefined') {

					var dr = parseInt( prdctfltr.animation.duration, 10 );
					var dl = parseInt( prdctfltr.animation.delay, 10 );

					switch ( prdctfltr.ajax_animation ) {
						case 'slide':
							addedProducts.hide();
							addedProducts.each(function(i) {
								$(this).delay((i++) * dl).slideDown({duration: dr,easing: 'linear'});
							});
						break;
						case 'random':
							addedProducts.not('.pf_faded').css('opacity', '0');
							var interval = setInterval(function () {
								var $ds = addedProducts.not('.pf_faded');
								$ds.eq(Math.floor(Math.random() * $ds.length)).fadeTo(dr, 1).addClass('pf_faded');
								if ($ds.length == 1) {
									clearInterval(interval);
								}
							}, dl );
						break;
						case 'none':
						break;
						default:
							addedProducts.css('opacity', '0');
							addedProducts.each(function(i) {
								$(this).delay((i++) * dl).fadeTo(dr, 1);
							});
						break;
					}
				}
			}
		}

	}

	function do_zindexes(curr) {
		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.each( function() {
			if ( $(this).hasClass('pf_select')) {
				var objCount = $(this).find('.prdctfltr_filter');
			}
			else {
				var objCount = $(this).find('.prdctfltr_terms_customized_select');
			}
			

			var c = objCount.length;
			objCount.css('z-index', function(i) {
				return c - i + 10;
			});

		});
	}
	do_zindexes();

	function prdctfltr_show_opened_widgets() {

		if ( $('.prdctfltr-widget').length > 0 && $('.prdctfltr-widget .prdctfltr_error').length !== 1 ) {
			$('.prdctfltr-widget .prdctfltr_filter').each( function() {

				var curr = $(this);

				if ( curr.find('input[type="checkbox"]:checked').length > 0 ) {

					curr.find('.prdctfltr_widget_title .prdctfltr-down').removeClass('prdctfltr-down').addClass('prdctfltr-up');
					curr.find('.prdctfltr_add_scroll').addClass('prdctfltr_down').css({'display':'block'});

				}
				else if ( curr.find('input[type="hidden"]:first').length == 1 && curr.find('input[type="hidden"]:first').val() !== '' ) {

					curr.find('.prdctfltr_widget_title .prdctfltr-down').removeClass('prdctfltr-down').addClass('prdctfltr-up');
					curr.find('.prdctfltr_add_scroll').addClass('prdctfltr_down').css({'display':'block'});

				}
				else if ( curr.find('input[type="text"]').length > 0 && curr.find('input[type="text"]').val() !== '' ) {

					curr.find('.prdctfltr_widget_title .prdctfltr-down').removeClass('prdctfltr-down').addClass('prdctfltr-up');
					curr.find('.prdctfltr_add_scroll').addClass('prdctfltr_down').css({'display':'block'});

				}

			});
		}

	}
	prdctfltr_show_opened_widgets();


	function prdctfltr_tabbed_selection(curr) {
		curr = ( curr == null ? $('.prdctfltr_wc') : curr );

		curr.each( function() {
			if ( $(this).hasClass('prdctfltr_tabbed_selection') ) {

				$(this).find('label.prdctfltr_ft_,label.prdctfltr_ft_none').each( function() {
					$(this).remove();
				});

				var checkLength = $(this).find('.prdctfltr_filter').length;
				var checkObj = $(this);
				$(this).find('.prdctfltr_filter').each( function() {
					if ( $(this).find('input[type="hidden"]:first').length > 0 && $(this).find('input[type="hidden"]').val() !== '' ) {
						$(this).addClass('prdctfltr_has_selection');
					}
					if ( $(this).find('input[type="text"]:first').length > 0 && $(this).find('input[type="text"]').val() !== '' ) {
						$(this).addClass('prdctfltr_has_selection');
					}
				});

			}
		});
	}
	prdctfltr_tabbed_selection();

	$.pfcount = function (array) {
		if(array.length) {
			return array.length;
		}
		else {
			var length = 0;
			for ( var p in array ){
				if(array.hasOwnProperty(p)) length++;
			}
			return length;
		}
	};

	function check_shortcode_search() {
		var wg = $('.prdctfltr_wc_widget');
		var sc = $('.prdctfltr_sc_products:not(.prdctfltr_sc_step_filter)');
		if ( wg.length>0 && sc.length>0 ) {
			wg.each( function() {
				$(this).find('input[name="s"]').each( function() {
					$(this).attr('name', 'search_products');
				});
				if ( !$(this).hasClass('prdctfltr_mobile') ) {
					var id = $(this).attr('data-id');
					if ( typeof prdctfltr.pagefilters[id] == 'undefined' ) {
						var done = false;
						$.each( prdctfltr.pagefilters, function(i,e) {
							if ( !done ) {
								if ( typeof e.wcsc !== 'undefined' ) {
									prdctfltr.pagefilters[id] = e;
									done = true;
								}
								if ( typeof e.wc !== 'undefined' && typeof e.query_vars.show_products !== 'undefined' && e.query_vars.show_products == 'yes' ) {
									prdctfltr.pagefilters[id] = e;
									done = true;
								}
							}
						} );
					}
				}
			} );
		}
	}
	check_shortcode_search();

	var infiniteLoad = $('.prdctfltr-pagination-infinite-load');

	function fixScroll() {
		didScroll = true;
	}

	function scrollHandler() {

		if( infiniteLoad.find('a.disabled').length == 0 && $(window).scrollTop()>=infiniteLoad.position().top-$(window).height()*0.8){
			infiniteLoad.find('a:not(.disabled)').trigger('click');
		}

	};

	if ( infiniteLoad.length>0 ) {

		var scrollTimeout;

		$(window).on({
			'scroll': fixScroll
		});

		var didScroll = false; 

		var scrollInterval = setInterval(function() {
			if ( didScroll ) {
				didScroll = false;
				if ( ajaxActive !== false || historyActive !== false ) {
					return false;
				}
				scrollHandler();
			}
		}, 250);

	}

	function scrollTo(to) {
		to = to>-1?to-130:0;
		var start = $(window).scrollTop(),
			duration = parseInt((Math.abs(to-start)+1000)/7.5, 10),
			change = to - start,
			currentTime = 0,
			increment = 20; 
		var animateScroll = function() {
			currentTime += increment;
			var val = Math.easeInOutQuad(currentTime, start, change, duration);
			window.scrollTo(0,val);
			
			if(currentTime < duration) {
				setTimeout(animateScroll, increment);
			}
		};
		animateScroll();
	}

	Math.easeInOutQuad = function (t, b, c, d) {
		t /= d/2;
		if (t < 1) return c/2*t*t + b;
		t--;
		return -c/2 * (t*(t-2) - 1) + b;
	};

	function prdctfltr_added_check(curr) {

		curr = ( curr == null ? $('.prdctfltr_wc:visible') : curr );

		curr.each(function(){
			var adds = {};
			var obj = $(this);

			obj.find('.prdctfltr_attributes').each( function() {

				var attribute = $(this);
				var valOf = attribute.find('input[type="hidden"]:first');
				var makeVal = valOf.val();

				if ( typeof makeVal !== 'undefined' && makeVal !== '' ) {

					var vals = [];

					if ( makeVal.indexOf(',') > 0 ) {
						vals = makeVal.split(',');
					}
					else if ( makeVal.indexOf('+') > 0 ) {
						vals = makeVal.split('+');
					}
					else {
						vals[0] = makeVal;
					}

					var filter = $(this);

					var lenght = vals.length;

					$.each(vals, function(i, val23) {

						if ( curr.find('.prdctfltr_filter[data-filter="'+valOf.attr('name')+'"] input[type="checkbox"][value="'+val23+'"]').length == 0 ) {

							var dataFilter = filter.attr('data-filter');

							if ( typeof adds[dataFilter] == 'undefined' ) {
								adds[dataFilter] = [];
							}
							if( $.inArray(val23, adds[dataFilter]) == -1 ) {
								adds[dataFilter].push(val23);
								valOf.val('');
							}
							obj.each( function() {
								var wrap = $(this);
									wrap.find('.prdctfltr_add_inputs').append('<input name="'+dataFilter+'" value="'+makeVal+'" class="pf_added_input" />');
							} );
						}

					});
				}

			});
		});
	}
	prdctfltr_added_check();

	prdctfltr.goRespond = function() {
		prdctfltr_respond_550($('.prdctfltr_wc:first form'));
	}

	jQuery.fn.outerHTML = function(s) {
		return s
			? this.before(s).remove()
			: jQuery("<p>").append(this.eq(0).clone()).html();
	};

})(jQuery);