/*! jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license */
!function(e,t){"use strict";"object"==typeof module&&"object"==typeof module.exports?module.exports=e.document?t(e,!0):function(e){if(!e.document)throw new Error("jQuery requires a window with a document");return t(e)}:t(e)}("undefined"!=typeof window?window:this,function(C,e){"use strict";var t=[],r=Object.getPrototypeOf,s=t.slice,g=t.flat?function(e){return t.flat.call(e)}:function(e){return t.concat.apply([],e)},u=t.push,i=t.indexOf,n={},o=n.toString,v=n.hasOwnProperty,a=v.toString,l=a.call(Object),y={},m=function(e){return"function"==typeof e&&"number"!=typeof e.nodeType&&"function"!=typeof e.item},x=function(e){return null!=e&&e===e.window},E=C.document,c={type:!0,src:!0,nonce:!0,noModule:!0};function b(e,t,n){var r,i,o=(n=n||E).createElement("script");if(o.text=e,t)for(r in c)(i=t[r]||t.getAttribute&&t.getAttribute(r))&&o.setAttribute(r,i);n.head.appendChild(o).parentNode.removeChild(o)}function w(e){return null==e?e+"":"object"==typeof e||"function"==typeof e?n[o.call(e)]||"object":typeof e}var f="3.6.0",S=function(e,t){return new S.fn.init(e,t)};function p(e){var t=!!e&&"length"in e&&e.length,n=w(e);return!m(e)&&!x(e)&&("array"===n||0===t||"number"==typeof t&&0<t&&t-1 in e)}S.fn=S.prototype={jquery:f,constructor:S,length:0,toArray:function(){return s.call(this)},get:function(e){return null==e?s.call(this):e<0?this[e+this.length]:this[e]},pushStack:function(e){var t=S.merge(this.constructor(),e);return t.prevObject=this,t},each:function(e){return S.each(this,e)},map:function(n){return this.pushStack(S.map(this,function(e,t){return n.call(e,t,e)}))},slice:function(){return this.pushStack(s.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},even:function(){return this.pushStack(S.grep(this,function(e,t){return(t+1)%2}))},odd:function(){return this.pushStack(S.grep(this,function(e,t){return t%2}))},eq:function(e){var t=this.length,n=+e+(e<0?t:0);return this.pushStack(0<=n&&n<t?[this[n]]:[])},end:function(){return this.prevObject||this.constructor()},push:u,sort:t.sort,splice:t.splice},S.extend=S.fn.extend=function(){var e,t,n,r,i,o,a=arguments[0]||{},s=1,u=arguments.length,l=!1;for("boolean"==typeof a&&(l=a,a=arguments[s]||{},s++),"object"==typeof a||m(a)||(a={}),s===u&&(a=this,s--);s<u;s++)if(null!=(e=arguments[s]))for(t in e)r=e[t],"__proto__"!==t&&a!==r&&(l&&r&&(S.isPlainObject(r)||(i=Array.isArray(r)))?(n=a[t],o=i&&!Array.isArray(n)?[]:i||S.isPlainObject(n)?n:{},i=!1,a[t]=S.extend(l,o,r)):void 0!==r&&(a[t]=r));return a},S.extend({expando:"jQuery"+(f+Math.random()).replace(/\D/g,""),isReady:!0,error:function(e){throw new Error(e)},noop:function(){},isPlainObject:function(e){var t,n;return!(!e||"[object Object]"!==o.call(e))&&(!(t=r(e))||"function"==typeof(n=v.call(t,"constructor")&&t.constructor)&&a.call(n)===l)},isEmptyObject:function(e){var t;for(t in e)return!1;return!0},globalEval:function(e,t,n){b(e,{nonce:t&&t.nonce},n)},each:function(e,t){var n,r=0;if(p(e)){for(n=e.length;r<n;r++)if(!1===t.call(e[r],r,e[r]))break}else for(r in e)if(!1===t.call(e[r],r,e[r]))break;return e},makeArray:function(e,t){var n=t||[];return null!=e&&(p(Object(e))?S.merge(n,"string"==typeof e?[e]:e):u.call(n,e)),n},inArray:function(e,t,n){return null==t?-1:i.call(t,e,n)},merge:function(e,t){for(var n=+t.length,r=0,i=e.length;r<n;r++)e[i++]=t[r];return e.length=i,e},grep:function(e,t,n){for(var r=[],i=0,o=e.length,a=!n;i<o;i++)!t(e[i],i)!==a&&r.push(e[i]);return r},map:function(e,t,n){var r,i,o=0,a=[];if(p(e))for(r=e.length;o<r;o++)null!=(i=t(e[o],o,n))&&a.push(i);else for(o in e)null!=(i=t(e[o],o,n))&&a.push(i);return g(a)},guid:1,support:y}),"function"==typeof Symbol&&(S.fn[Symbol.iterator]=t[Symbol.iterator]),S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),function(e,t){n["[object "+t+"]"]=t.toLowerCase()});var d=function(n){var e,d,b,o,i,h,f,g,w,u,l,T,C,a,E,v,s,c,y,S="sizzle"+1*new Date,p=n.document,k=0,r=0,m=ue(),x=ue(),A=ue(),N=ue(),j=function(e,t){return e===t&&(l=!0),0},D={}.hasOwnProperty,t=[],q=t.pop,L=t.push,H=t.push,O=t.slice,P=function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1},R="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",M="[\\x20\\t\\r\\n\\f]",I="(?:\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",W="\\["+M+"*("+I+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+I+"))|)"+M+"*\\]",F=":("+I+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+W+")*)|.*)\\)|)",B=new RegExp(M+"+","g"),$=new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$","g"),_=new RegExp("^"+M+"*,"+M+"*"),z=new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"),U=new RegExp(M+"|>"),X=new RegExp(F),V=new RegExp("^"+I+"$"),G={ID:new RegExp("^#("+I+")"),CLASS:new RegExp("^\\.("+I+")"),TAG:new RegExp("^("+I+"|[*])"),ATTR:new RegExp("^"+W),PSEUDO:new RegExp("^"+F),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)","i"),bool:new RegExp("^(?:"+R+")$","i"),needsContext:new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)","i")},Y=/HTML$/i,Q=/^(?:input|select|textarea|button)$/i,J=/^h\d$/i,K=/^[^{]+\{\s*\[native \w/,Z=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,ee=/[+~]/,te=new RegExp("\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\([^\\r\\n\\f])","g"),ne=function(e,t){var n="0x"+e.slice(1)-65536;return t||(n<0?String.fromCharCode(n+65536):String.fromCharCode(n>>10|55296,1023&n|56320))},re=/([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,ie=function(e,t){return t?"\0"===e?"\ufffd":e.slice(0,-1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" ":"\\"+e},oe=function(){T()},ae=be(function(e){return!0===e.disabled&&"fieldset"===e.nodeName.toLowerCase()},{dir:"parentNode",next:"legend"});try{H.apply(t=O.call(p.childNodes),p.childNodes),t[p.childNodes.length].nodeType}catch(e){H={apply:t.length?function(e,t){L.apply(e,O.call(t))}:function(e,t){var n=e.length,r=0;while(e[n++]=t[r++]);e.length=n-1}}}function se(t,e,n,r){var i,o,a,s,u,l,c,f=e&&e.ownerDocument,p=e?e.nodeType:9;if(n=n||[],"string"!=typeof t||!t||1!==p&&9!==p&&11!==p)return n;if(!r&&(T(e),e=e||C,E)){if(11!==p&&(u=Z.exec(t)))if(i=u[1]){if(9===p){if(!(a=e.getElementById(i)))return n;if(a.id===i)return n.push(a),n}else if(f&&(a=f.getElementById(i))&&y(e,a)&&a.id===i)return n.push(a),n}else{if(u[2])return H.apply(n,e.getElementsByTagName(t)),n;if((i=u[3])&&d.getElementsByClassName&&e.getElementsByClassName)return H.apply(n,e.getElementsByClassName(i)),n}if(d.qsa&&!N[t+" "]&&(!v||!v.test(t))&&(1!==p||"object"!==e.nodeName.toLowerCase())){if(c=t,f=e,1===p&&(U.test(t)||z.test(t))){(f=ee.test(t)&&ye(e.parentNode)||e)===e&&d.scope||((s=e.getAttribute("id"))?s=s.replace(re,ie):e.setAttribute("id",s=S)),o=(l=h(t)).length;while(o--)l[o]=(s?"#"+s:":scope")+" "+xe(l[o]);c=l.join(",")}try{return H.apply(n,f.querySelectorAll(c)),n}catch(e){N(t,!0)}finally{s===S&&e.removeAttribute("id")}}}return g(t.replace($,"$1"),e,n,r)}function ue(){var r=[];return function e(t,n){return r.push(t+" ")>b.cacheLength&&delete e[r.shift()],e[t+" "]=n}}function le(e){return e[S]=!0,e}function ce(e){var t=C.createElement("fieldset");try{return!!e(t)}catch(e){return!1}finally{t.parentNode&&t.parentNode.removeChild(t),t=null}}function fe(e,t){var n=e.split("|"),r=n.length;while(r--)b.attrHandle[n[r]]=t}function pe(e,t){var n=t&&e,r=n&&1===e.nodeType&&1===t.nodeType&&e.sourceIndex-t.sourceIndex;if(r)return r;if(n)while(n=n.nextSibling)if(n===t)return-1;return e?1:-1}function de(t){return function(e){return"input"===e.nodeName.toLowerCase()&&e.type===t}}function he(n){return function(e){var t=e.nodeName.toLowerCase();return("input"===t||"button"===t)&&e.type===n}}function ge(t){return function(e){return"form"in e?e.parentNode&&!1===e.disabled?"label"in e?"label"in e.parentNode?e.parentNode.disabled===t:e.disabled===t:e.isDisabled===t||e.isDisabled!==!t&&ae(e)===t:e.disabled===t:"label"in e&&e.disabled===t}}function ve(a){return le(function(o){return o=+o,le(function(e,t){var n,r=a([],e.length,o),i=r.length;while(i--)e[n=r[i]]&&(e[n]=!(t[n]=e[n]))})})}function ye(e){return e&&"undefined"!=typeof e.getElementsByTagName&&e}for(e in d=se.support={},i=se.isXML=function(e){var t=e&&e.namespaceURI,n=e&&(e.ownerDocument||e).documentElement;return!Y.test(t||n&&n.nodeName||"HTML")},T=se.setDocument=function(e){var t,n,r=e?e.ownerDocument||e:p;return r!=C&&9===r.nodeType&&r.documentElement&&(a=(C=r).documentElement,E=!i(C),p!=C&&(n=C.defaultView)&&n.top!==n&&(n.addEventListener?n.addEventListener("unload",oe,!1):n.attachEvent&&n.attachEvent("onunload",oe)),d.scope=ce(function(e){return a.appendChild(e).appendChild(C.createElement("div")),"undefined"!=typeof e.querySelectorAll&&!e.querySelectorAll(":scope fieldset div").length}),d.attributes=ce(function(e){return e.className="i",!e.getAttribute("className")}),d.getElementsByTagName=ce(function(e){return e.appendChild(C.createComment("")),!e.getElementsByTagName("*").length}),d.getElementsByClassName=K.test(C.getElementsByClassName),d.getById=ce(function(e){return a.appendChild(e).id=S,!C.getElementsByName||!C.getElementsByName(S).length}),d.getById?(b.filter.ID=function(e){var t=e.replace(te,ne);return function(e){return e.getAttribute("id")===t}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n=t.getElementById(e);return n?[n]:[]}}):(b.filter.ID=function(e){var n=e.replace(te,ne);return function(e){var t="undefined"!=typeof e.getAttributeNode&&e.getAttributeNode("id");return t&&t.value===n}},b.find.ID=function(e,t){if("undefined"!=typeof t.getElementById&&E){var n,r,i,o=t.getElementById(e);if(o){if((n=o.getAttributeNode("id"))&&n.value===e)return[o];i=t.getElementsByName(e),r=0;while(o=i[r++])if((n=o.getAttributeNode("id"))&&n.value===e)return[o]}return[]}}),b.find.TAG=d.getElementsByTagName?function(e,t){return"undefined"!=typeof t.getElementsByTagName?t.getElementsByTagName(e):d.qsa?t.querySelectorAll(e):void 0}:function(e,t){var n,r=[],i=0,o=t.getElementsByTagName(e);if("*"===e){while(n=o[i++])1===n.nodeType&&r.push(n);return r}return o},b.find.CLASS=d.getElementsByClassName&&function(e,t){if("undefined"!=typeof t.getElementsByClassName&&E)return t.getElementsByClassName(e)},s=[],v=[],(d.qsa=K.test(C.querySelectorAll))&&(ce(function(e){var t;a.appendChild(e).innerHTML="<a id='"+S+"'></a><select id='"+S+"-\r\\' msallowcapture=''><option selected=''></option></select>",e.querySelectorAll("[msallowcapture^='']").length&&v.push("[*^$]="+M+"*(?:''|\"\")"),e.querySelectorAll("[selected]").length||v.push("\\["+M+"*(?:value|"+R+")"),e.querySelectorAll("[id~="+S+"-]").length||v.push("~="),(t=C.createElement("input")).setAttribute("name",""),e.appendChild(t),e.querySelectorAll("[name='']").length||v.push("\\["+M+"*name"+M+"*="+M+"*(?:''|\"\")"),e.querySelectorAll(":checked").length||v.push(":checked"),e.querySelectorAll("a#"+S+"+*").length||v.push(".#.+[+~]"),e.querySelectorAll("\\\f"),v.push("[\\r\\n\\f]")}),ce(function(e){e.innerHTML="<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";var t=C.createElement("input");t.setAttribute("type","hidden"),e.appendChild(t).setAttribute("name","D"),e.querySelectorAll("[name=d]").length&&v.push("name"+M+"*[*^$|!~]?="),2!==e.querySelectorAll(":enabled").length&&v.push(":enabled",":disabled"),a.appendChild(e).disabled=!0,2!==e.querySelectorAll(":disabled").length&&v.push(":enabled",":disabled"),e.querySelectorAll("*,:x"),v.push(",.*:")})),(d.matchesSelector=K.test(c=a.matches||a.webkitMatchesSelector||a.mozMatchesSelector||a.oMatchesSelector||a.msMatchesSelector))&&ce(function(e){d.disconnectedMatch=c.call(e,"*"),c.call(e,"[s!='']:x"),s.push("!=",F)}),v=v.length&&new RegExp(v.join("|")),s=s.length&&new RegExp(s.join("|")),t=K.test(a.compareDocumentPosition),y=t||K.test(a.contains)?function(e,t){var n=9===e.nodeType?e.documentElement:e,r=t&&t.parentNode;return e===r||!(!r||1!==r.nodeType||!(n.contains?n.contains(r):e.compareDocumentPosition&&16&e.compareDocumentPosition(r)))}:function(e,t){if(t)while(t=t.parentNode)if(t===e)return!0;return!1},j=t?function(e,t){if(e===t)return l=!0,0;var n=!e.compareDocumentPosition-!t.compareDocumentPosition;return n||(1&(n=(e.ownerDocument||e)==(t.ownerDocument||t)?e.compareDocumentPosition(t):1)||!d.sortDetached&&t.compareDocumentPosition(e)===n?e==C||e.ownerDocument==p&&y(p,e)?-1:t==C||t.ownerDocument==p&&y(p,t)?1:u?P(u,e)-P(u,t):0:4&n?-1:1)}:function(e,t){if(e===t)return l=!0,0;var n,r=0,i=e.parentNode,o=t.parentNode,a=[e],s=[t];if(!i||!o)return e==C?-1:t==C?1:i?-1:o?1:u?P(u,e)-P(u,t):0;if(i===o)return pe(e,t);n=e;while(n=n.parentNode)a.unshift(n);n=t;while(n=n.parentNode)s.unshift(n);while(a[r]===s[r])r++;return r?pe(a[r],s[r]):a[r]==p?-1:s[r]==p?1:0}),C},se.matches=function(e,t){return se(e,null,null,t)},se.matchesSelector=function(e,t){if(T(e),d.matchesSelector&&E&&!N[t+" "]&&(!s||!s.test(t))&&(!v||!v.test(t)))try{var n=c.call(e,t);if(n||d.disconnectedMatch||e.document&&11!==e.document.nodeType)return n}catch(e){N(t,!0)}return 0<se(t,C,null,[e]).length},se.contains=function(e,t){return(e.ownerDocument||e)!=C&&T(e),y(e,t)},se.attr=function(e,t){(e.ownerDocument||e)!=C&&T(e);var n=b.attrHandle[t.toLowerCase()],r=n&&D.call(b.attrHandle,t.toLowerCase())?n(e,t,!E):void 0;return void 0!==r?r:d.attributes||!E?e.getAttribute(t):(r=e.getAttributeNode(t))&&r.specified?r.value:null},se.escape=function(e){return(e+"").replace(re,ie)},se.error=function(e){throw new Error("Syntax error, unrecognized expression: "+e)},se.uniqueSort=function(e){var t,n=[],r=0,i=0;if(l=!d.detectDuplicates,u=!d.sortStable&&e.slice(0),e.sort(j),l){while(t=e[i++])t===e[i]&&(r=n.push(i));while(r--)e.splice(n[r],1)}return u=null,e},o=se.getText=function(e){var t,n="",r=0,i=e.nodeType;if(i){if(1===i||9===i||11===i){if("string"==typeof e.textContent)return e.textContent;for(e=e.firstChild;e;e=e.nextSibling)n+=o(e)}else if(3===i||4===i)return e.nodeValue}else while(t=e[r++])n+=o(t);return n},(b=se.selectors={cacheLength:50,createPseudo:le,match:G,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(e){return e[1]=e[1].replace(te,ne),e[3]=(e[3]||e[4]||e[5]||"").replace(te,ne),"~="===e[2]&&(e[3]=" "+e[3]+" "),e.slice(0,4)},CHILD:function(e){return e[1]=e[1].toLowerCase(),"nth"===e[1].slice(0,3)?(e[3]||se.error(e[0]),e[4]=+(e[4]?e[5]+(e[6]||1):2*("even"===e[3]||"odd"===e[3])),e[5]=+(e[7]+e[8]||"odd"===e[3])):e[3]&&se.error(e[0]),e},PSEUDO:function(e){var t,n=!e[6]&&e[2];return G.CHILD.test(e[0])?null:(e[3]?e[2]=e[4]||e[5]||"":n&&X.test(n)&&(t=h(n,!0))&&(t=n.indexOf(")",n.length-t)-n.length)&&(e[0]=e[0].slice(0,t),e[2]=n.slice(0,t)),e.slice(0,3))}},filter:{TAG:function(e){var t=e.replace(te,ne).toLowerCase();return"*"===e?function(){return!0}:function(e){return e.nodeName&&e.nodeName.toLowerCase()===t}},CLASS:function(e){var t=m[e+" "];return t||(t=new RegExp("(^|"+M+")"+e+"("+M+"|$)"))&&m(e,function(e){return t.test("string"==typeof e.className&&e.className||"undefined"!=typeof e.getAttribute&&e.getAttribute("class")||"")})},ATTR:function(n,r,i){return function(e){var t=se.attr(e,n);return null==t?"!="===r:!r||(t+="","="===r?t===i:"!="===r?t!==i:"^="===r?i&&0===t.indexOf(i):"*="===r?i&&-1<t.indexOf(i):"$="===r?i&&t.slice(-i.length)===i:"~="===r?-1<(" "+t.replace(B," ")+" ").indexOf(i):"|="===r&&(t===i||t.slice(0,i.length+1)===i+"-"))}},CHILD:function(h,e,t,g,v){var y="nth"!==h.slice(0,3),m="last"!==h.slice(-4),x="of-type"===e;return 1===g&&0===v?function(e){return!!e.parentNode}:function(e,t,n){var r,i,o,a,s,u,l=y!==m?"nextSibling":"previousSibling",c=e.parentNode,f=x&&e.nodeName.toLowerCase(),p=!n&&!x,d=!1;if(c){if(y){while(l){a=e;while(a=a[l])if(x?a.nodeName.toLowerCase()===f:1===a.nodeType)return!1;u=l="only"===h&&!u&&"nextSibling"}return!0}if(u=[m?c.firstChild:c.lastChild],m&&p){d=(s=(r=(i=(o=(a=c)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1])&&r[2],a=s&&c.childNodes[s];while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if(1===a.nodeType&&++d&&a===e){i[h]=[k,s,d];break}}else if(p&&(d=s=(r=(i=(o=(a=e)[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]||[])[0]===k&&r[1]),!1===d)while(a=++s&&a&&a[l]||(d=s=0)||u.pop())if((x?a.nodeName.toLowerCase()===f:1===a.nodeType)&&++d&&(p&&((i=(o=a[S]||(a[S]={}))[a.uniqueID]||(o[a.uniqueID]={}))[h]=[k,d]),a===e))break;return(d-=v)===g||d%g==0&&0<=d/g}}},PSEUDO:function(e,o){var t,a=b.pseudos[e]||b.setFilters[e.toLowerCase()]||se.error("unsupported pseudo: "+e);return a[S]?a(o):1<a.length?(t=[e,e,"",o],b.setFilters.hasOwnProperty(e.toLowerCase())?le(function(e,t){var n,r=a(e,o),i=r.length;while(i--)e[n=P(e,r[i])]=!(t[n]=r[i])}):function(e){return a(e,0,t)}):a}},pseudos:{not:le(function(e){var r=[],i=[],s=f(e.replace($,"$1"));return s[S]?le(function(e,t,n,r){var i,o=s(e,null,r,[]),a=e.length;while(a--)(i=o[a])&&(e[a]=!(t[a]=i))}):function(e,t,n){return r[0]=e,s(r,null,n,i),r[0]=null,!i.pop()}}),has:le(function(t){return function(e){return 0<se(t,e).length}}),contains:le(function(t){return t=t.replace(te,ne),function(e){return-1<(e.textContent||o(e)).indexOf(t)}}),lang:le(function(n){return V.test(n||"")||se.error("unsupported lang: "+n),n=n.replace(te,ne).toLowerCase(),function(e){var t;do{if(t=E?e.lang:e.getAttribute("xml:lang")||e.getAttribute("lang"))return(t=t.toLowerCase())===n||0===t.indexOf(n+"-")}while((e=e.parentNode)&&1===e.nodeType);return!1}}),target:function(e){var t=n.location&&n.location.hash;return t&&t.slice(1)===e.id},root:function(e){return e===a},focus:function(e){return e===C.activeElement&&(!C.hasFocus||C.hasFocus())&&!!(e.type||e.href||~e.tabIndex)},enabled:ge(!1),disabled:ge(!0),checked:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&!!e.checked||"option"===t&&!!e.selected},selected:function(e){return e.parentNode&&e.parentNode.selectedIndex,!0===e.selected},empty:function(e){for(e=e.firstChild;e;e=e.nextSibling)if(e.nodeType<6)return!1;return!0},parent:function(e){return!b.pseudos.empty(e)},header:function(e){return J.test(e.nodeName)},input:function(e){return Q.test(e.nodeName)},button:function(e){var t=e.nodeName.toLowerCase();return"input"===t&&"button"===e.type||"button"===t},text:function(e){var t;return"input"===e.nodeName.toLowerCase()&&"text"===e.type&&(null==(t=e.getAttribute("type"))||"text"===t.toLowerCase())},first:ve(function(){return[0]}),last:ve(function(e,t){return[t-1]}),eq:ve(function(e,t,n){return[n<0?n+t:n]}),even:ve(function(e,t){for(var n=0;n<t;n+=2)e.push(n);return e}),odd:ve(function(e,t){for(var n=1;n<t;n+=2)e.push(n);return e}),lt:ve(function(e,t,n){for(var r=n<0?n+t:t<n?t:n;0<=--r;)e.push(r);return e}),gt:ve(function(e,t,n){for(var r=n<0?n+t:n;++r<t;)e.push(r);return e})}}).pseudos.nth=b.pseudos.eq,{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})b.pseudos[e]=de(e);for(e in{submit:!0,reset:!0})b.pseudos[e]=he(e);function me(){}function xe(e){for(var t=0,n=e.length,r="";t<n;t++)r+=e[t].value;return r}function be(s,e,t){var u=e.dir,l=e.next,c=l||u,f=t&&"parentNode"===c,p=r++;return e.first?function(e,t,n){while(e=e[u])if(1===e.nodeType||f)return s(e,t,n);return!1}:function(e,t,n){var r,i,o,a=[k,p];if(n){while(e=e[u])if((1===e.nodeType||f)&&s(e,t,n))return!0}else while(e=e[u])if(1===e.nodeType||f)if(i=(o=e[S]||(e[S]={}))[e.uniqueID]||(o[e.uniqueID]={}),l&&l===e.nodeName.toLowerCase())e=e[u]||e;else{if((r=i[c])&&r[0]===k&&r[1]===p)return a[2]=r[2];if((i[c]=a)[2]=s(e,t,n))return!0}return!1}}function we(i){return 1<i.length?function(e,t,n){var r=i.length;while(r--)if(!i[r](e,t,n))return!1;return!0}:i[0]}function Te(e,t,n,r,i){for(var o,a=[],s=0,u=e.length,l=null!=t;s<u;s++)(o=e[s])&&(n&&!n(o,r,i)||(a.push(o),l&&t.push(s)));return a}function Ce(d,h,g,v,y,e){return v&&!v[S]&&(v=Ce(v)),y&&!y[S]&&(y=Ce(y,e)),le(function(e,t,n,r){var i,o,a,s=[],u=[],l=t.length,c=e||function(e,t,n){for(var r=0,i=t.length;r<i;r++)se(e,t[r],n);return n}(h||"*",n.nodeType?[n]:n,[]),f=!d||!e&&h?c:Te(c,s,d,n,r),p=g?y||(e?d:l||v)?[]:t:f;if(g&&g(f,p,n,r),v){i=Te(p,u),v(i,[],n,r),o=i.length;while(o--)(a=i[o])&&(p[u[o]]=!(f[u[o]]=a))}if(e){if(y||d){if(y){i=[],o=p.length;while(o--)(a=p[o])&&i.push(f[o]=a);y(null,p=[],i,r)}o=p.length;while(o--)(a=p[o])&&-1<(i=y?P(e,a):s[o])&&(e[i]=!(t[i]=a))}}else p=Te(p===t?p.splice(l,p.length):p),y?y(null,t,p,r):H.apply(t,p)})}function Ee(e){for(var i,t,n,r=e.length,o=b.relative[e[0].type],a=o||b.relative[" "],s=o?1:0,u=be(function(e){return e===i},a,!0),l=be(function(e){return-1<P(i,e)},a,!0),c=[function(e,t,n){var r=!o&&(n||t!==w)||((i=t).nodeType?u(e,t,n):l(e,t,n));return i=null,r}];s<r;s++)if(t=b.relative[e[s].type])c=[be(we(c),t)];else{if((t=b.filter[e[s].type].apply(null,e[s].matches))[S]){for(n=++s;n<r;n++)if(b.relative[e[n].type])break;return Ce(1<s&&we(c),1<s&&xe(e.slice(0,s-1).concat({value:" "===e[s-2].type?"*":""})).replace($,"$1"),t,s<n&&Ee(e.slice(s,n)),n<r&&Ee(e=e.slice(n)),n<r&&xe(e))}c.push(t)}return we(c)}return me.prototype=b.filters=b.pseudos,b.setFilters=new me,h=se.tokenize=function(e,t){var n,r,i,o,a,s,u,l=x[e+" "];if(l)return t?0:l.slice(0);a=e,s=[],u=b.preFilter;while(a){for(o in n&&!(r=_.exec(a))||(r&&(a=a.slice(r[0].length)||a),s.push(i=[])),n=!1,(r=z.exec(a))&&(n=r.shift(),i.push({value:n,type:r[0].replace($," ")}),a=a.slice(n.length)),b.filter)!(r=G[o].exec(a))||u[o]&&!(r=u[o](r))||(n=r.shift(),i.push({value:n,type:o,matches:r}),a=a.slice(n.length));if(!n)break}return t?a.length:a?se.error(e):x(e,s).slice(0)},f=se.compile=function(e,t){var n,v,y,m,x,r,i=[],o=[],a=A[e+" "];if(!a){t||(t=h(e)),n=t.length;while(n--)(a=Ee(t[n]))[S]?i.push(a):o.push(a);(a=A(e,(v=o,m=0<(y=i).length,x=0<v.length,r=function(e,t,n,r,i){var o,a,s,u=0,l="0",c=e&&[],f=[],p=w,d=e||x&&b.find.TAG("*",i),h=k+=null==p?1:Math.random()||.1,g=d.length;for(i&&(w=t==C||t||i);l!==g&&null!=(o=d[l]);l++){if(x&&o){a=0,t||o.ownerDocument==C||(T(o),n=!E);while(s=v[a++])if(s(o,t||C,n)){r.push(o);break}i&&(k=h)}m&&((o=!s&&o)&&u--,e&&c.push(o))}if(u+=l,m&&l!==u){a=0;while(s=y[a++])s(c,f,t,n);if(e){if(0<u)while(l--)c[l]||f[l]||(f[l]=q.call(r));f=Te(f)}H.apply(r,f),i&&!e&&0<f.length&&1<u+y.length&&se.uniqueSort(r)}return i&&(k=h,w=p),c},m?le(r):r))).selector=e}return a},g=se.select=function(e,t,n,r){var i,o,a,s,u,l="function"==typeof e&&e,c=!r&&h(e=l.selector||e);if(n=n||[],1===c.length){if(2<(o=c[0]=c[0].slice(0)).length&&"ID"===(a=o[0]).type&&9===t.nodeType&&E&&b.relative[o[1].type]){if(!(t=(b.find.ID(a.matches[0].replace(te,ne),t)||[])[0]))return n;l&&(t=t.parentNode),e=e.slice(o.shift().value.length)}i=G.needsContext.test(e)?0:o.length;while(i--){if(a=o[i],b.relative[s=a.type])break;if((u=b.find[s])&&(r=u(a.matches[0].replace(te,ne),ee.test(o[0].type)&&ye(t.parentNode)||t))){if(o.splice(i,1),!(e=r.length&&xe(o)))return H.apply(n,r),n;break}}}return(l||f(e,c))(r,t,!E,n,!t||ee.test(e)&&ye(t.parentNode)||t),n},d.sortStable=S.split("").sort(j).join("")===S,d.detectDuplicates=!!l,T(),d.sortDetached=ce(function(e){return 1&e.compareDocumentPosition(C.createElement("fieldset"))}),ce(function(e){return e.innerHTML="<a href='#'></a>","#"===e.firstChild.getAttribute("href")})||fe("type|href|height|width",function(e,t,n){if(!n)return e.getAttribute(t,"type"===t.toLowerCase()?1:2)}),d.attributes&&ce(function(e){return e.innerHTML="<input/>",e.firstChild.setAttribute("value",""),""===e.firstChild.getAttribute("value")})||fe("value",function(e,t,n){if(!n&&"input"===e.nodeName.toLowerCase())return e.defaultValue}),ce(function(e){return null==e.getAttribute("disabled")})||fe(R,function(e,t,n){var r;if(!n)return!0===e[t]?t.toLowerCase():(r=e.getAttributeNode(t))&&r.specified?r.value:null}),se}(C);S.find=d,S.expr=d.selectors,S.expr[":"]=S.expr.pseudos,S.uniqueSort=S.unique=d.uniqueSort,S.text=d.getText,S.isXMLDoc=d.isXML,S.contains=d.contains,S.escapeSelector=d.escape;var h=function(e,t,n){var r=[],i=void 0!==n;while((e=e[t])&&9!==e.nodeType)if(1===e.nodeType){if(i&&S(e).is(n))break;r.push(e)}return r},T=function(e,t){for(var n=[];e;e=e.nextSibling)1===e.nodeType&&e!==t&&n.push(e);return n},k=S.expr.match.needsContext;function A(e,t){return e.nodeName&&e.nodeName.toLowerCase()===t.toLowerCase()}var N=/^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;function j(e,n,r){return m(n)?S.grep(e,function(e,t){return!!n.call(e,t,e)!==r}):n.nodeType?S.grep(e,function(e){return e===n!==r}):"string"!=typeof n?S.grep(e,function(e){return-1<i.call(n,e)!==r}):S.filter(n,e,r)}S.filter=function(e,t,n){var r=t[0];return n&&(e=":not("+e+")"),1===t.length&&1===r.nodeType?S.find.matchesSelector(r,e)?[r]:[]:S.find.matches(e,S.grep(t,function(e){return 1===e.nodeType}))},S.fn.extend({find:function(e){var t,n,r=this.length,i=this;if("string"!=typeof e)return this.pushStack(S(e).filter(function(){for(t=0;t<r;t++)if(S.contains(i[t],this))return!0}));for(n=this.pushStack([]),t=0;t<r;t++)S.find(e,i[t],n);return 1<r?S.uniqueSort(n):n},filter:function(e){return this.pushStack(j(this,e||[],!1))},not:function(e){return this.pushStack(j(this,e||[],!0))},is:function(e){return!!j(this,"string"==typeof e&&k.test(e)?S(e):e||[],!1).length}});var D,q=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;(S.fn.init=function(e,t,n){var r,i;if(!e)return this;if(n=n||D,"string"==typeof e){if(!(r="<"===e[0]&&">"===e[e.length-1]&&3<=e.length?[null,e,null]:q.exec(e))||!r[1]&&t)return!t||t.jquery?(t||n).find(e):this.constructor(t).find(e);if(r[1]){if(t=t instanceof S?t[0]:t,S.merge(this,S.parseHTML(r[1],t&&t.nodeType?t.ownerDocument||t:E,!0)),N.test(r[1])&&S.isPlainObject(t))for(r in t)m(this[r])?this[r](t[r]):this.attr(r,t[r]);return this}return(i=E.getElementById(r[2]))&&(this[0]=i,this.length=1),this}return e.nodeType?(this[0]=e,this.length=1,this):m(e)?void 0!==n.ready?n.ready(e):e(S):S.makeArray(e,this)}).prototype=S.fn,D=S(E);var L=/^(?:parents|prev(?:Until|All))/,H={children:!0,contents:!0,next:!0,prev:!0};function O(e,t){while((e=e[t])&&1!==e.nodeType);return e}S.fn.extend({has:function(e){var t=S(e,this),n=t.length;return this.filter(function(){for(var e=0;e<n;e++)if(S.contains(this,t[e]))return!0})},closest:function(e,t){var n,r=0,i=this.length,o=[],a="string"!=typeof e&&S(e);if(!k.test(e))for(;r<i;r++)for(n=this[r];n&&n!==t;n=n.parentNode)if(n.nodeType<11&&(a?-1<a.index(n):1===n.nodeType&&S.find.matchesSelector(n,e))){o.push(n);break}return this.pushStack(1<o.length?S.uniqueSort(o):o)},index:function(e){return e?"string"==typeof e?i.call(S(e),this[0]):i.call(this,e.jquery?e[0]:e):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(e,t){return this.pushStack(S.uniqueSort(S.merge(this.get(),S(e,t))))},addBack:function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}}),S.each({parent:function(e){var t=e.parentNode;return t&&11!==t.nodeType?t:null},parents:function(e){return h(e,"parentNode")},parentsUntil:function(e,t,n){return h(e,"parentNode",n)},next:function(e){return O(e,"nextSibling")},prev:function(e){return O(e,"previousSibling")},nextAll:function(e){return h(e,"nextSibling")},prevAll:function(e){return h(e,"previousSibling")},nextUntil:function(e,t,n){return h(e,"nextSibling",n)},prevUntil:function(e,t,n){return h(e,"previousSibling",n)},siblings:function(e){return T((e.parentNode||{}).firstChild,e)},children:function(e){return T(e.firstChild)},contents:function(e){return null!=e.contentDocument&&r(e.contentDocument)?e.contentDocument:(A(e,"template")&&(e=e.content||e),S.merge([],e.childNodes))}},function(r,i){S.fn[r]=function(e,t){var n=S.map(this,i,e);return"Until"!==r.slice(-5)&&(t=e),t&&"string"==typeof t&&(n=S.filter(t,n)),1<this.length&&(H[r]||S.uniqueSort(n),L.test(r)&&n.reverse()),this.pushStack(n)}});var P=/[^\x20\t\r\n\f]+/g;function R(e){return e}function M(e){throw e}function I(e,t,n,r){var i;try{e&&m(i=e.promise)?i.call(e).done(t).fail(n):e&&m(i=e.then)?i.call(e,t,n):t.apply(void 0,[e].slice(r))}catch(e){n.apply(void 0,[e])}}S.Callbacks=function(r){var e,n;r="string"==typeof r?(e=r,n={},S.each(e.match(P)||[],function(e,t){n[t]=!0}),n):S.extend({},r);var i,t,o,a,s=[],u=[],l=-1,c=function(){for(a=a||r.once,o=i=!0;u.length;l=-1){t=u.shift();while(++l<s.length)!1===s[l].apply(t[0],t[1])&&r.stopOnFalse&&(l=s.length,t=!1)}r.memory||(t=!1),i=!1,a&&(s=t?[]:"")},f={add:function(){return s&&(t&&!i&&(l=s.length-1,u.push(t)),function n(e){S.each(e,function(e,t){m(t)?r.unique&&f.has(t)||s.push(t):t&&t.length&&"string"!==w(t)&&n(t)})}(arguments),t&&!i&&c()),this},remove:function(){return S.each(arguments,function(e,t){var n;while(-1<(n=S.inArray(t,s,n)))s.splice(n,1),n<=l&&l--}),this},has:function(e){return e?-1<S.inArray(e,s):0<s.length},empty:function(){return s&&(s=[]),this},disable:function(){return a=u=[],s=t="",this},disabled:function(){return!s},lock:function(){return a=u=[],t||i||(s=t=""),this},locked:function(){return!!a},fireWith:function(e,t){return a||(t=[e,(t=t||[]).slice?t.slice():t],u.push(t),i||c()),this},fire:function(){return f.fireWith(this,arguments),this},fired:function(){return!!o}};return f},S.extend({Deferred:function(e){var o=[["notify","progress",S.Callbacks("memory"),S.Callbacks("memory"),2],["resolve","done",S.Callbacks("once memory"),S.Callbacks("once memory"),0,"resolved"],["reject","fail",S.Callbacks("once memory"),S.Callbacks("once memory"),1,"rejected"]],i="pending",a={state:function(){return i},always:function(){return s.done(arguments).fail(arguments),this},"catch":function(e){return a.then(null,e)},pipe:function(){var i=arguments;return S.Deferred(function(r){S.each(o,function(e,t){var n=m(i[t[4]])&&i[t[4]];s[t[1]](function(){var e=n&&n.apply(this,arguments);e&&m(e.promise)?e.promise().progress(r.notify).done(r.resolve).fail(r.reject):r[t[0]+"With"](this,n?[e]:arguments)})}),i=null}).promise()},then:function(t,n,r){var u=0;function l(i,o,a,s){return function(){var n=this,r=arguments,e=function(){var e,t;if(!(i<u)){if((e=a.apply(n,r))===o.promise())throw new TypeError("Thenable self-resolution");t=e&&("object"==typeof e||"function"==typeof e)&&e.then,m(t)?s?t.call(e,l(u,o,R,s),l(u,o,M,s)):(u++,t.call(e,l(u,o,R,s),l(u,o,M,s),l(u,o,R,o.notifyWith))):(a!==R&&(n=void 0,r=[e]),(s||o.resolveWith)(n,r))}},t=s?e:function(){try{e()}catch(e){S.Deferred.exceptionHook&&S.Deferred.exceptionHook(e,t.stackTrace),u<=i+1&&(a!==M&&(n=void 0,r=[e]),o.rejectWith(n,r))}};i?t():(S.Deferred.getStackHook&&(t.stackTrace=S.Deferred.getStackHook()),C.setTimeout(t))}}return S.Deferred(function(e){o[0][3].add(l(0,e,m(r)?r:R,e.notifyWith)),o[1][3].add(l(0,e,m(t)?t:R)),o[2][3].add(l(0,e,m(n)?n:M))}).promise()},promise:function(e){return null!=e?S.extend(e,a):a}},s={};return S.each(o,function(e,t){var n=t[2],r=t[5];a[t[1]]=n.add,r&&n.add(function(){i=r},o[3-e][2].disable,o[3-e][3].disable,o[0][2].lock,o[0][3].lock),n.add(t[3].fire),s[t[0]]=function(){return s[t[0]+"With"](this===s?void 0:this,arguments),this},s[t[0]+"With"]=n.fireWith}),a.promise(s),e&&e.call(s,s),s},when:function(e){var n=arguments.length,t=n,r=Array(t),i=s.call(arguments),o=S.Deferred(),a=function(t){return function(e){r[t]=this,i[t]=1<arguments.length?s.call(arguments):e,--n||o.resolveWith(r,i)}};if(n<=1&&(I(e,o.done(a(t)).resolve,o.reject,!n),"pending"===o.state()||m(i[t]&&i[t].then)))return o.then();while(t--)I(i[t],a(t),o.reject);return o.promise()}});var W=/^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;S.Deferred.exceptionHook=function(e,t){C.console&&C.console.warn&&e&&W.test(e.name)&&C.console.warn("jQuery.Deferred exception: "+e.message,e.stack,t)},S.readyException=function(e){C.setTimeout(function(){throw e})};var F=S.Deferred();function B(){E.removeEventListener("DOMContentLoaded",B),C.removeEventListener("load",B),S.ready()}S.fn.ready=function(e){return F.then(e)["catch"](function(e){S.readyException(e)}),this},S.extend({isReady:!1,readyWait:1,ready:function(e){(!0===e?--S.readyWait:S.isReady)||(S.isReady=!0)!==e&&0<--S.readyWait||F.resolveWith(E,[S])}}),S.ready.then=F.then,"complete"===E.readyState||"loading"!==E.readyState&&!E.documentElement.doScroll?C.setTimeout(S.ready):(E.addEventListener("DOMContentLoaded",B),C.addEventListener("load",B));var $=function(e,t,n,r,i,o,a){var s=0,u=e.length,l=null==n;if("object"===w(n))for(s in i=!0,n)$(e,t,s,n[s],!0,o,a);else if(void 0!==r&&(i=!0,m(r)||(a=!0),l&&(a?(t.call(e,r),t=null):(l=t,t=function(e,t,n){return l.call(S(e),n)})),t))for(;s<u;s++)t(e[s],n,a?r:r.call(e[s],s,t(e[s],n)));return i?e:l?t.call(e):u?t(e[0],n):o},_=/^-ms-/,z=/-([a-z])/g;function U(e,t){return t.toUpperCase()}function X(e){return e.replace(_,"ms-").replace(z,U)}var V=function(e){return 1===e.nodeType||9===e.nodeType||!+e.nodeType};function G(){this.expando=S.expando+G.uid++}G.uid=1,G.prototype={cache:function(e){var t=e[this.expando];return t||(t={},V(e)&&(e.nodeType?e[this.expando]=t:Object.defineProperty(e,this.expando,{value:t,configurable:!0}))),t},set:function(e,t,n){var r,i=this.cache(e);if("string"==typeof t)i[X(t)]=n;else for(r in t)i[X(r)]=t[r];return i},get:function(e,t){return void 0===t?this.cache(e):e[this.expando]&&e[this.expando][X(t)]},access:function(e,t,n){return void 0===t||t&&"string"==typeof t&&void 0===n?this.get(e,t):(this.set(e,t,n),void 0!==n?n:t)},remove:function(e,t){var n,r=e[this.expando];if(void 0!==r){if(void 0!==t){n=(t=Array.isArray(t)?t.map(X):(t=X(t))in r?[t]:t.match(P)||[]).length;while(n--)delete r[t[n]]}(void 0===t||S.isEmptyObject(r))&&(e.nodeType?e[this.expando]=void 0:delete e[this.expando])}},hasData:function(e){var t=e[this.expando];return void 0!==t&&!S.isEmptyObject(t)}};var Y=new G,Q=new G,J=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,K=/[A-Z]/g;function Z(e,t,n){var r,i;if(void 0===n&&1===e.nodeType)if(r="data-"+t.replace(K,"-$&").toLowerCase(),"string"==typeof(n=e.getAttribute(r))){try{n="true"===(i=n)||"false"!==i&&("null"===i?null:i===+i+""?+i:J.test(i)?JSON.parse(i):i)}catch(e){}Q.set(e,t,n)}else n=void 0;return n}S.extend({hasData:function(e){return Q.hasData(e)||Y.hasData(e)},data:function(e,t,n){return Q.access(e,t,n)},removeData:function(e,t){Q.remove(e,t)},_data:function(e,t,n){return Y.access(e,t,n)},_removeData:function(e,t){Y.remove(e,t)}}),S.fn.extend({data:function(n,e){var t,r,i,o=this[0],a=o&&o.attributes;if(void 0===n){if(this.length&&(i=Q.get(o),1===o.nodeType&&!Y.get(o,"hasDataAttrs"))){t=a.length;while(t--)a[t]&&0===(r=a[t].name).indexOf("data-")&&(r=X(r.slice(5)),Z(o,r,i[r]));Y.set(o,"hasDataAttrs",!0)}return i}return"object"==typeof n?this.each(function(){Q.set(this,n)}):$(this,function(e){var t;if(o&&void 0===e)return void 0!==(t=Q.get(o,n))?t:void 0!==(t=Z(o,n))?t:void 0;this.each(function(){Q.set(this,n,e)})},null,e,1<arguments.length,null,!0)},removeData:function(e){return this.each(function(){Q.remove(this,e)})}}),S.extend({queue:function(e,t,n){var r;if(e)return t=(t||"fx")+"queue",r=Y.get(e,t),n&&(!r||Array.isArray(n)?r=Y.access(e,t,S.makeArray(n)):r.push(n)),r||[]},dequeue:function(e,t){t=t||"fx";var n=S.queue(e,t),r=n.length,i=n.shift(),o=S._queueHooks(e,t);"inprogress"===i&&(i=n.shift(),r--),i&&("fx"===t&&n.unshift("inprogress"),delete o.stop,i.call(e,function(){S.dequeue(e,t)},o)),!r&&o&&o.empty.fire()},_queueHooks:function(e,t){var n=t+"queueHooks";return Y.get(e,n)||Y.access(e,n,{empty:S.Callbacks("once memory").add(function(){Y.remove(e,[t+"queue",n])})})}}),S.fn.extend({queue:function(t,n){var e=2;return"string"!=typeof t&&(n=t,t="fx",e--),arguments.length<e?S.queue(this[0],t):void 0===n?this:this.each(function(){var e=S.queue(this,t,n);S._queueHooks(this,t),"fx"===t&&"inprogress"!==e[0]&&S.dequeue(this,t)})},dequeue:function(e){return this.each(function(){S.dequeue(this,e)})},clearQueue:function(e){return this.queue(e||"fx",[])},promise:function(e,t){var n,r=1,i=S.Deferred(),o=this,a=this.length,s=function(){--r||i.resolveWith(o,[o])};"string"!=typeof e&&(t=e,e=void 0),e=e||"fx";while(a--)(n=Y.get(o[a],e+"queueHooks"))&&n.empty&&(r++,n.empty.add(s));return s(),i.promise(t)}});var ee=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,te=new RegExp("^(?:([+-])=|)("+ee+")([a-z%]*)$","i"),ne=["Top","Right","Bottom","Left"],re=E.documentElement,ie=function(e){return S.contains(e.ownerDocument,e)},oe={composed:!0};re.getRootNode&&(ie=function(e){return S.contains(e.ownerDocument,e)||e.getRootNode(oe)===e.ownerDocument});var ae=function(e,t){return"none"===(e=t||e).style.display||""===e.style.display&&ie(e)&&"none"===S.css(e,"display")};function se(e,t,n,r){var i,o,a=20,s=r?function(){return r.cur()}:function(){return S.css(e,t,"")},u=s(),l=n&&n[3]||(S.cssNumber[t]?"":"px"),c=e.nodeType&&(S.cssNumber[t]||"px"!==l&&+u)&&te.exec(S.css(e,t));if(c&&c[3]!==l){u/=2,l=l||c[3],c=+u||1;while(a--)S.style(e,t,c+l),(1-o)*(1-(o=s()/u||.5))<=0&&(a=0),c/=o;c*=2,S.style(e,t,c+l),n=n||[]}return n&&(c=+c||+u||0,i=n[1]?c+(n[1]+1)*n[2]:+n[2],r&&(r.unit=l,r.start=c,r.end=i)),i}var ue={};function le(e,t){for(var n,r,i,o,a,s,u,l=[],c=0,f=e.length;c<f;c++)(r=e[c]).style&&(n=r.style.display,t?("none"===n&&(l[c]=Y.get(r,"display")||null,l[c]||(r.style.display="")),""===r.style.display&&ae(r)&&(l[c]=(u=a=o=void 0,a=(i=r).ownerDocument,s=i.nodeName,(u=ue[s])||(o=a.body.appendChild(a.createElement(s)),u=S.css(o,"display"),o.parentNode.removeChild(o),"none"===u&&(u="block"),ue[s]=u)))):"none"!==n&&(l[c]="none",Y.set(r,"display",n)));for(c=0;c<f;c++)null!=l[c]&&(e[c].style.display=l[c]);return e}S.fn.extend({show:function(){return le(this,!0)},hide:function(){return le(this)},toggle:function(e){return"boolean"==typeof e?e?this.show():this.hide():this.each(function(){ae(this)?S(this).show():S(this).hide()})}});var ce,fe,pe=/^(?:checkbox|radio)$/i,de=/<([a-z][^\/\0>\x20\t\r\n\f]*)/i,he=/^$|^module$|\/(?:java|ecma)script/i;ce=E.createDocumentFragment().appendChild(E.createElement("div")),(fe=E.createElement("input")).setAttribute("type","radio"),fe.setAttribute("checked","checked"),fe.setAttribute("name","t"),ce.appendChild(fe),y.checkClone=ce.cloneNode(!0).cloneNode(!0).lastChild.checked,ce.innerHTML="<textarea>x</textarea>",y.noCloneChecked=!!ce.cloneNode(!0).lastChild.defaultValue,ce.innerHTML="<option></option>",y.option=!!ce.lastChild;var ge={thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};function ve(e,t){var n;return n="undefined"!=typeof e.getElementsByTagName?e.getElementsByTagName(t||"*"):"undefined"!=typeof e.querySelectorAll?e.querySelectorAll(t||"*"):[],void 0===t||t&&A(e,t)?S.merge([e],n):n}function ye(e,t){for(var n=0,r=e.length;n<r;n++)Y.set(e[n],"globalEval",!t||Y.get(t[n],"globalEval"))}ge.tbody=ge.tfoot=ge.colgroup=ge.caption=ge.thead,ge.th=ge.td,y.option||(ge.optgroup=ge.option=[1,"<select multiple='multiple'>","</select>"]);var me=/<|&#?\w+;/;function xe(e,t,n,r,i){for(var o,a,s,u,l,c,f=t.createDocumentFragment(),p=[],d=0,h=e.length;d<h;d++)if((o=e[d])||0===o)if("object"===w(o))S.merge(p,o.nodeType?[o]:o);else if(me.test(o)){a=a||f.appendChild(t.createElement("div")),s=(de.exec(o)||["",""])[1].toLowerCase(),u=ge[s]||ge._default,a.innerHTML=u[1]+S.htmlPrefilter(o)+u[2],c=u[0];while(c--)a=a.lastChild;S.merge(p,a.childNodes),(a=f.firstChild).textContent=""}else p.push(t.createTextNode(o));f.textContent="",d=0;while(o=p[d++])if(r&&-1<S.inArray(o,r))i&&i.push(o);else if(l=ie(o),a=ve(f.appendChild(o),"script"),l&&ye(a),n){c=0;while(o=a[c++])he.test(o.type||"")&&n.push(o)}return f}var be=/^([^.]*)(?:\.(.+)|)/;function we(){return!0}function Te(){return!1}function Ce(e,t){return e===function(){try{return E.activeElement}catch(e){}}()==("focus"===t)}function Ee(e,t,n,r,i,o){var a,s;if("object"==typeof t){for(s in"string"!=typeof n&&(r=r||n,n=void 0),t)Ee(e,s,n,r,t[s],o);return e}if(null==r&&null==i?(i=n,r=n=void 0):null==i&&("string"==typeof n?(i=r,r=void 0):(i=r,r=n,n=void 0)),!1===i)i=Te;else if(!i)return e;return 1===o&&(a=i,(i=function(e){return S().off(e),a.apply(this,arguments)}).guid=a.guid||(a.guid=S.guid++)),e.each(function(){S.event.add(this,t,i,r,n)})}function Se(e,i,o){o?(Y.set(e,i,!1),S.event.add(e,i,{namespace:!1,handler:function(e){var t,n,r=Y.get(this,i);if(1&e.isTrigger&&this[i]){if(r.length)(S.event.special[i]||{}).delegateType&&e.stopPropagation();else if(r=s.call(arguments),Y.set(this,i,r),t=o(this,i),this[i](),r!==(n=Y.get(this,i))||t?Y.set(this,i,!1):n={},r!==n)return e.stopImmediatePropagation(),e.preventDefault(),n&&n.value}else r.length&&(Y.set(this,i,{value:S.event.trigger(S.extend(r[0],S.Event.prototype),r.slice(1),this)}),e.stopImmediatePropagation())}})):void 0===Y.get(e,i)&&S.event.add(e,i,we)}S.event={global:{},add:function(t,e,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.get(t);if(V(t)){n.handler&&(n=(o=n).handler,i=o.selector),i&&S.find.matchesSelector(re,i),n.guid||(n.guid=S.guid++),(u=v.events)||(u=v.events=Object.create(null)),(a=v.handle)||(a=v.handle=function(e){return"undefined"!=typeof S&&S.event.triggered!==e.type?S.event.dispatch.apply(t,arguments):void 0}),l=(e=(e||"").match(P)||[""]).length;while(l--)d=g=(s=be.exec(e[l])||[])[1],h=(s[2]||"").split(".").sort(),d&&(f=S.event.special[d]||{},d=(i?f.delegateType:f.bindType)||d,f=S.event.special[d]||{},c=S.extend({type:d,origType:g,data:r,handler:n,guid:n.guid,selector:i,needsContext:i&&S.expr.match.needsContext.test(i),namespace:h.join(".")},o),(p=u[d])||((p=u[d]=[]).delegateCount=0,f.setup&&!1!==f.setup.call(t,r,h,a)||t.addEventListener&&t.addEventListener(d,a)),f.add&&(f.add.call(t,c),c.handler.guid||(c.handler.guid=n.guid)),i?p.splice(p.delegateCount++,0,c):p.push(c),S.event.global[d]=!0)}},remove:function(e,t,n,r,i){var o,a,s,u,l,c,f,p,d,h,g,v=Y.hasData(e)&&Y.get(e);if(v&&(u=v.events)){l=(t=(t||"").match(P)||[""]).length;while(l--)if(d=g=(s=be.exec(t[l])||[])[1],h=(s[2]||"").split(".").sort(),d){f=S.event.special[d]||{},p=u[d=(r?f.delegateType:f.bindType)||d]||[],s=s[2]&&new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"),a=o=p.length;while(o--)c=p[o],!i&&g!==c.origType||n&&n.guid!==c.guid||s&&!s.test(c.namespace)||r&&r!==c.selector&&("**"!==r||!c.selector)||(p.splice(o,1),c.selector&&p.delegateCount--,f.remove&&f.remove.call(e,c));a&&!p.length&&(f.teardown&&!1!==f.teardown.call(e,h,v.handle)||S.removeEvent(e,d,v.handle),delete u[d])}else for(d in u)S.event.remove(e,d+t[l],n,r,!0);S.isEmptyObject(u)&&Y.remove(e,"handle events")}},dispatch:function(e){var t,n,r,i,o,a,s=new Array(arguments.length),u=S.event.fix(e),l=(Y.get(this,"events")||Object.create(null))[u.type]||[],c=S.event.special[u.type]||{};for(s[0]=u,t=1;t<arguments.length;t++)s[t]=arguments[t];if(u.delegateTarget=this,!c.preDispatch||!1!==c.preDispatch.call(this,u)){a=S.event.handlers.call(this,u,l),t=0;while((i=a[t++])&&!u.isPropagationStopped()){u.currentTarget=i.elem,n=0;while((o=i.handlers[n++])&&!u.isImmediatePropagationStopped())u.rnamespace&&!1!==o.namespace&&!u.rnamespace.test(o.namespace)||(u.handleObj=o,u.data=o.data,void 0!==(r=((S.event.special[o.origType]||{}).handle||o.handler).apply(i.elem,s))&&!1===(u.result=r)&&(u.preventDefault(),u.stopPropagation()))}return c.postDispatch&&c.postDispatch.call(this,u),u.result}},handlers:function(e,t){var n,r,i,o,a,s=[],u=t.delegateCount,l=e.target;if(u&&l.nodeType&&!("click"===e.type&&1<=e.button))for(;l!==this;l=l.parentNode||this)if(1===l.nodeType&&("click"!==e.type||!0!==l.disabled)){for(o=[],a={},n=0;n<u;n++)void 0===a[i=(r=t[n]).selector+" "]&&(a[i]=r.needsContext?-1<S(i,this).index(l):S.find(i,this,null,[l]).length),a[i]&&o.push(r);o.length&&s.push({elem:l,handlers:o})}return l=this,u<t.length&&s.push({elem:l,handlers:t.slice(u)}),s},addProp:function(t,e){Object.defineProperty(S.Event.prototype,t,{enumerable:!0,configurable:!0,get:m(e)?function(){if(this.originalEvent)return e(this.originalEvent)}:function(){if(this.originalEvent)return this.originalEvent[t]},set:function(e){Object.defineProperty(this,t,{enumerable:!0,configurable:!0,writable:!0,value:e})}})},fix:function(e){return e[S.expando]?e:new S.Event(e)},special:{load:{noBubble:!0},click:{setup:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click",we),!1},trigger:function(e){var t=this||e;return pe.test(t.type)&&t.click&&A(t,"input")&&Se(t,"click"),!0},_default:function(e){var t=e.target;return pe.test(t.type)&&t.click&&A(t,"input")&&Y.get(t,"click")||A(t,"a")}},beforeunload:{postDispatch:function(e){void 0!==e.result&&e.originalEvent&&(e.originalEvent.returnValue=e.result)}}}},S.removeEvent=function(e,t,n){e.removeEventListener&&e.removeEventListener(t,n)},S.Event=function(e,t){if(!(this instanceof S.Event))return new S.Event(e,t);e&&e.type?(this.originalEvent=e,this.type=e.type,this.isDefaultPrevented=e.defaultPrevented||void 0===e.defaultPrevented&&!1===e.returnValue?we:Te,this.target=e.target&&3===e.target.nodeType?e.target.parentNode:e.target,this.currentTarget=e.currentTarget,this.relatedTarget=e.relatedTarget):this.type=e,t&&S.extend(this,t),this.timeStamp=e&&e.timeStamp||Date.now(),this[S.expando]=!0},S.Event.prototype={constructor:S.Event,isDefaultPrevented:Te,isPropagationStopped:Te,isImmediatePropagationStopped:Te,isSimulated:!1,preventDefault:function(){var e=this.originalEvent;this.isDefaultPrevented=we,e&&!this.isSimulated&&e.preventDefault()},stopPropagation:function(){var e=this.originalEvent;this.isPropagationStopped=we,e&&!this.isSimulated&&e.stopPropagation()},stopImmediatePropagation:function(){var e=this.originalEvent;this.isImmediatePropagationStopped=we,e&&!this.isSimulated&&e.stopImmediatePropagation(),this.stopPropagation()}},S.each({altKey:!0,bubbles:!0,cancelable:!0,changedTouches:!0,ctrlKey:!0,detail:!0,eventPhase:!0,metaKey:!0,pageX:!0,pageY:!0,shiftKey:!0,view:!0,"char":!0,code:!0,charCode:!0,key:!0,keyCode:!0,button:!0,buttons:!0,clientX:!0,clientY:!0,offsetX:!0,offsetY:!0,pointerId:!0,pointerType:!0,screenX:!0,screenY:!0,targetTouches:!0,toElement:!0,touches:!0,which:!0},S.event.addProp),S.each({focus:"focusin",blur:"focusout"},function(e,t){S.event.special[e]={setup:function(){return Se(this,e,Ce),!1},trigger:function(){return Se(this,e),!0},_default:function(){return!0},delegateType:t}}),S.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(e,i){S.event.special[e]={delegateType:i,bindType:i,handle:function(e){var t,n=e.relatedTarget,r=e.handleObj;return n&&(n===this||S.contains(this,n))||(e.type=r.origType,t=r.handler.apply(this,arguments),e.type=i),t}}}),S.fn.extend({on:function(e,t,n,r){return Ee(this,e,t,n,r)},one:function(e,t,n,r){return Ee(this,e,t,n,r,1)},off:function(e,t,n){var r,i;if(e&&e.preventDefault&&e.handleObj)return r=e.handleObj,S(e.delegateTarget).off(r.namespace?r.origType+"."+r.namespace:r.origType,r.selector,r.handler),this;if("object"==typeof e){for(i in e)this.off(i,t,e[i]);return this}return!1!==t&&"function"!=typeof t||(n=t,t=void 0),!1===n&&(n=Te),this.each(function(){S.event.remove(this,e,n,t)})}});var ke=/<script|<style|<link/i,Ae=/checked\s*(?:[^=]|=\s*.checked.)/i,Ne=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;function je(e,t){return A(e,"table")&&A(11!==t.nodeType?t:t.firstChild,"tr")&&S(e).children("tbody")[0]||e}function De(e){return e.type=(null!==e.getAttribute("type"))+"/"+e.type,e}function qe(e){return"true/"===(e.type||"").slice(0,5)?e.type=e.type.slice(5):e.removeAttribute("type"),e}function Le(e,t){var n,r,i,o,a,s;if(1===t.nodeType){if(Y.hasData(e)&&(s=Y.get(e).events))for(i in Y.remove(t,"handle events"),s)for(n=0,r=s[i].length;n<r;n++)S.event.add(t,i,s[i][n]);Q.hasData(e)&&(o=Q.access(e),a=S.extend({},o),Q.set(t,a))}}function He(n,r,i,o){r=g(r);var e,t,a,s,u,l,c=0,f=n.length,p=f-1,d=r[0],h=m(d);if(h||1<f&&"string"==typeof d&&!y.checkClone&&Ae.test(d))return n.each(function(e){var t=n.eq(e);h&&(r[0]=d.call(this,e,t.html())),He(t,r,i,o)});if(f&&(t=(e=xe(r,n[0].ownerDocument,!1,n,o)).firstChild,1===e.childNodes.length&&(e=t),t||o)){for(s=(a=S.map(ve(e,"script"),De)).length;c<f;c++)u=e,c!==p&&(u=S.clone(u,!0,!0),s&&S.merge(a,ve(u,"script"))),i.call(n[c],u,c);if(s)for(l=a[a.length-1].ownerDocument,S.map(a,qe),c=0;c<s;c++)u=a[c],he.test(u.type||"")&&!Y.access(u,"globalEval")&&S.contains(l,u)&&(u.src&&"module"!==(u.type||"").toLowerCase()?S._evalUrl&&!u.noModule&&S._evalUrl(u.src,{nonce:u.nonce||u.getAttribute("nonce")},l):b(u.textContent.replace(Ne,""),u,l))}return n}function Oe(e,t,n){for(var r,i=t?S.filter(t,e):e,o=0;null!=(r=i[o]);o++)n||1!==r.nodeType||S.cleanData(ve(r)),r.parentNode&&(n&&ie(r)&&ye(ve(r,"script")),r.parentNode.removeChild(r));return e}S.extend({htmlPrefilter:function(e){return e},clone:function(e,t,n){var r,i,o,a,s,u,l,c=e.cloneNode(!0),f=ie(e);if(!(y.noCloneChecked||1!==e.nodeType&&11!==e.nodeType||S.isXMLDoc(e)))for(a=ve(c),r=0,i=(o=ve(e)).length;r<i;r++)s=o[r],u=a[r],void 0,"input"===(l=u.nodeName.toLowerCase())&&pe.test(s.type)?u.checked=s.checked:"input"!==l&&"textarea"!==l||(u.defaultValue=s.defaultValue);if(t)if(n)for(o=o||ve(e),a=a||ve(c),r=0,i=o.length;r<i;r++)Le(o[r],a[r]);else Le(e,c);return 0<(a=ve(c,"script")).length&&ye(a,!f&&ve(e,"script")),c},cleanData:function(e){for(var t,n,r,i=S.event.special,o=0;void 0!==(n=e[o]);o++)if(V(n)){if(t=n[Y.expando]){if(t.events)for(r in t.events)i[r]?S.event.remove(n,r):S.removeEvent(n,r,t.handle);n[Y.expando]=void 0}n[Q.expando]&&(n[Q.expando]=void 0)}}}),S.fn.extend({detach:function(e){return Oe(this,e,!0)},remove:function(e){return Oe(this,e)},text:function(e){return $(this,function(e){return void 0===e?S.text(this):this.empty().each(function(){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||(this.textContent=e)})},null,e,arguments.length)},append:function(){return He(this,arguments,function(e){1!==this.nodeType&&11!==this.nodeType&&9!==this.nodeType||je(this,e).appendChild(e)})},prepend:function(){return He(this,arguments,function(e){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var t=je(this,e);t.insertBefore(e,t.firstChild)}})},before:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this)})},after:function(){return He(this,arguments,function(e){this.parentNode&&this.parentNode.insertBefore(e,this.nextSibling)})},empty:function(){for(var e,t=0;null!=(e=this[t]);t++)1===e.nodeType&&(S.cleanData(ve(e,!1)),e.textContent="");return this},clone:function(e,t){return e=null!=e&&e,t=null==t?e:t,this.map(function(){return S.clone(this,e,t)})},html:function(e){return $(this,function(e){var t=this[0]||{},n=0,r=this.length;if(void 0===e&&1===t.nodeType)return t.innerHTML;if("string"==typeof e&&!ke.test(e)&&!ge[(de.exec(e)||["",""])[1].toLowerCase()]){e=S.htmlPrefilter(e);try{for(;n<r;n++)1===(t=this[n]||{}).nodeType&&(S.cleanData(ve(t,!1)),t.innerHTML=e);t=0}catch(e){}}t&&this.empty().append(e)},null,e,arguments.length)},replaceWith:function(){var n=[];return He(this,arguments,function(e){var t=this.parentNode;S.inArray(this,n)<0&&(S.cleanData(ve(this)),t&&t.replaceChild(e,this))},n)}}),S.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(e,a){S.fn[e]=function(e){for(var t,n=[],r=S(e),i=r.length-1,o=0;o<=i;o++)t=o===i?this:this.clone(!0),S(r[o])[a](t),u.apply(n,t.get());return this.pushStack(n)}});var Pe=new RegExp("^("+ee+")(?!px)[a-z%]+$","i"),Re=function(e){var t=e.ownerDocument.defaultView;return t&&t.opener||(t=C),t.getComputedStyle(e)},Me=function(e,t,n){var r,i,o={};for(i in t)o[i]=e.style[i],e.style[i]=t[i];for(i in r=n.call(e),t)e.style[i]=o[i];return r},Ie=new RegExp(ne.join("|"),"i");function We(e,t,n){var r,i,o,a,s=e.style;return(n=n||Re(e))&&(""!==(a=n.getPropertyValue(t)||n[t])||ie(e)||(a=S.style(e,t)),!y.pixelBoxStyles()&&Pe.test(a)&&Ie.test(t)&&(r=s.width,i=s.minWidth,o=s.maxWidth,s.minWidth=s.maxWidth=s.width=a,a=n.width,s.width=r,s.minWidth=i,s.maxWidth=o)),void 0!==a?a+"":a}function Fe(e,t){return{get:function(){if(!e())return(this.get=t).apply(this,arguments);delete this.get}}}!function(){function e(){if(l){u.style.cssText="position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0",l.style.cssText="position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%",re.appendChild(u).appendChild(l);var e=C.getComputedStyle(l);n="1%"!==e.top,s=12===t(e.marginLeft),l.style.right="60%",o=36===t(e.right),r=36===t(e.width),l.style.position="absolute",i=12===t(l.offsetWidth/3),re.removeChild(u),l=null}}function t(e){return Math.round(parseFloat(e))}var n,r,i,o,a,s,u=E.createElement("div"),l=E.createElement("div");l.style&&(l.style.backgroundClip="content-box",l.cloneNode(!0).style.backgroundClip="",y.clearCloneStyle="content-box"===l.style.backgroundClip,S.extend(y,{boxSizingReliable:function(){return e(),r},pixelBoxStyles:function(){return e(),o},pixelPosition:function(){return e(),n},reliableMarginLeft:function(){return e(),s},scrollboxSize:function(){return e(),i},reliableTrDimensions:function(){var e,t,n,r;return null==a&&(e=E.createElement("table"),t=E.createElement("tr"),n=E.createElement("div"),e.style.cssText="position:absolute;left:-11111px;border-collapse:separate",t.style.cssText="border:1px solid",t.style.height="1px",n.style.height="9px",n.style.display="block",re.appendChild(e).appendChild(t).appendChild(n),r=C.getComputedStyle(t),a=parseInt(r.height,10)+parseInt(r.borderTopWidth,10)+parseInt(r.borderBottomWidth,10)===t.offsetHeight,re.removeChild(e)),a}}))}();var Be=["Webkit","Moz","ms"],$e=E.createElement("div").style,_e={};function ze(e){var t=S.cssProps[e]||_e[e];return t||(e in $e?e:_e[e]=function(e){var t=e[0].toUpperCase()+e.slice(1),n=Be.length;while(n--)if((e=Be[n]+t)in $e)return e}(e)||e)}var Ue=/^(none|table(?!-c[ea]).+)/,Xe=/^--/,Ve={position:"absolute",visibility:"hidden",display:"block"},Ge={letterSpacing:"0",fontWeight:"400"};function Ye(e,t,n){var r=te.exec(t);return r?Math.max(0,r[2]-(n||0))+(r[3]||"px"):t}function Qe(e,t,n,r,i,o){var a="width"===t?1:0,s=0,u=0;if(n===(r?"border":"content"))return 0;for(;a<4;a+=2)"margin"===n&&(u+=S.css(e,n+ne[a],!0,i)),r?("content"===n&&(u-=S.css(e,"padding"+ne[a],!0,i)),"margin"!==n&&(u-=S.css(e,"border"+ne[a]+"Width",!0,i))):(u+=S.css(e,"padding"+ne[a],!0,i),"padding"!==n?u+=S.css(e,"border"+ne[a]+"Width",!0,i):s+=S.css(e,"border"+ne[a]+"Width",!0,i));return!r&&0<=o&&(u+=Math.max(0,Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5))||0),u}function Je(e,t,n){var r=Re(e),i=(!y.boxSizingReliable()||n)&&"border-box"===S.css(e,"boxSizing",!1,r),o=i,a=We(e,t,r),s="offset"+t[0].toUpperCase()+t.slice(1);if(Pe.test(a)){if(!n)return a;a="auto"}return(!y.boxSizingReliable()&&i||!y.reliableTrDimensions()&&A(e,"tr")||"auto"===a||!parseFloat(a)&&"inline"===S.css(e,"display",!1,r))&&e.getClientRects().length&&(i="border-box"===S.css(e,"boxSizing",!1,r),(o=s in e)&&(a=e[s])),(a=parseFloat(a)||0)+Qe(e,t,n||(i?"border":"content"),o,r,a)+"px"}function Ke(e,t,n,r,i){return new Ke.prototype.init(e,t,n,r,i)}S.extend({cssHooks:{opacity:{get:function(e,t){if(t){var n=We(e,"opacity");return""===n?"1":n}}}},cssNumber:{animationIterationCount:!0,columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,gridArea:!0,gridColumn:!0,gridColumnEnd:!0,gridColumnStart:!0,gridRow:!0,gridRowEnd:!0,gridRowStart:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{},style:function(e,t,n,r){if(e&&3!==e.nodeType&&8!==e.nodeType&&e.style){var i,o,a,s=X(t),u=Xe.test(t),l=e.style;if(u||(t=ze(s)),a=S.cssHooks[t]||S.cssHooks[s],void 0===n)return a&&"get"in a&&void 0!==(i=a.get(e,!1,r))?i:l[t];"string"===(o=typeof n)&&(i=te.exec(n))&&i[1]&&(n=se(e,t,i),o="number"),null!=n&&n==n&&("number"!==o||u||(n+=i&&i[3]||(S.cssNumber[s]?"":"px")),y.clearCloneStyle||""!==n||0!==t.indexOf("background")||(l[t]="inherit"),a&&"set"in a&&void 0===(n=a.set(e,n,r))||(u?l.setProperty(t,n):l[t]=n))}},css:function(e,t,n,r){var i,o,a,s=X(t);return Xe.test(t)||(t=ze(s)),(a=S.cssHooks[t]||S.cssHooks[s])&&"get"in a&&(i=a.get(e,!0,n)),void 0===i&&(i=We(e,t,r)),"normal"===i&&t in Ge&&(i=Ge[t]),""===n||n?(o=parseFloat(i),!0===n||isFinite(o)?o||0:i):i}}),S.each(["height","width"],function(e,u){S.cssHooks[u]={get:function(e,t,n){if(t)return!Ue.test(S.css(e,"display"))||e.getClientRects().length&&e.getBoundingClientRect().width?Je(e,u,n):Me(e,Ve,function(){return Je(e,u,n)})},set:function(e,t,n){var r,i=Re(e),o=!y.scrollboxSize()&&"absolute"===i.position,a=(o||n)&&"border-box"===S.css(e,"boxSizing",!1,i),s=n?Qe(e,u,n,a,i):0;return a&&o&&(s-=Math.ceil(e["offset"+u[0].toUpperCase()+u.slice(1)]-parseFloat(i[u])-Qe(e,u,"border",!1,i)-.5)),s&&(r=te.exec(t))&&"px"!==(r[3]||"px")&&(e.style[u]=t,t=S.css(e,u)),Ye(0,t,s)}}}),S.cssHooks.marginLeft=Fe(y.reliableMarginLeft,function(e,t){if(t)return(parseFloat(We(e,"marginLeft"))||e.getBoundingClientRect().left-Me(e,{marginLeft:0},function(){return e.getBoundingClientRect().left}))+"px"}),S.each({margin:"",padding:"",border:"Width"},function(i,o){S.cssHooks[i+o]={expand:function(e){for(var t=0,n={},r="string"==typeof e?e.split(" "):[e];t<4;t++)n[i+ne[t]+o]=r[t]||r[t-2]||r[0];return n}},"margin"!==i&&(S.cssHooks[i+o].set=Ye)}),S.fn.extend({css:function(e,t){return $(this,function(e,t,n){var r,i,o={},a=0;if(Array.isArray(t)){for(r=Re(e),i=t.length;a<i;a++)o[t[a]]=S.css(e,t[a],!1,r);return o}return void 0!==n?S.style(e,t,n):S.css(e,t)},e,t,1<arguments.length)}}),((S.Tween=Ke).prototype={constructor:Ke,init:function(e,t,n,r,i,o){this.elem=e,this.prop=n,this.easing=i||S.easing._default,this.options=t,this.start=this.now=this.cur(),this.end=r,this.unit=o||(S.cssNumber[n]?"":"px")},cur:function(){var e=Ke.propHooks[this.prop];return e&&e.get?e.get(this):Ke.propHooks._default.get(this)},run:function(e){var t,n=Ke.propHooks[this.prop];return this.options.duration?this.pos=t=S.easing[this.easing](e,this.options.duration*e,0,1,this.options.duration):this.pos=t=e,this.now=(this.end-this.start)*t+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),n&&n.set?n.set(this):Ke.propHooks._default.set(this),this}}).init.prototype=Ke.prototype,(Ke.propHooks={_default:{get:function(e){var t;return 1!==e.elem.nodeType||null!=e.elem[e.prop]&&null==e.elem.style[e.prop]?e.elem[e.prop]:(t=S.css(e.elem,e.prop,""))&&"auto"!==t?t:0},set:function(e){S.fx.step[e.prop]?S.fx.step[e.prop](e):1!==e.elem.nodeType||!S.cssHooks[e.prop]&&null==e.elem.style[ze(e.prop)]?e.elem[e.prop]=e.now:S.style(e.elem,e.prop,e.now+e.unit)}}}).scrollTop=Ke.propHooks.scrollLeft={set:function(e){e.elem.nodeType&&e.elem.parentNode&&(e.elem[e.prop]=e.now)}},S.easing={linear:function(e){return e},swing:function(e){return.5-Math.cos(e*Math.PI)/2},_default:"swing"},S.fx=Ke.prototype.init,S.fx.step={};var Ze,et,tt,nt,rt=/^(?:toggle|show|hide)$/,it=/queueHooks$/;function ot(){et&&(!1===E.hidden&&C.requestAnimationFrame?C.requestAnimationFrame(ot):C.setTimeout(ot,S.fx.interval),S.fx.tick())}function at(){return C.setTimeout(function(){Ze=void 0}),Ze=Date.now()}function st(e,t){var n,r=0,i={height:e};for(t=t?1:0;r<4;r+=2-t)i["margin"+(n=ne[r])]=i["padding"+n]=e;return t&&(i.opacity=i.width=e),i}function ut(e,t,n){for(var r,i=(lt.tweeners[t]||[]).concat(lt.tweeners["*"]),o=0,a=i.length;o<a;o++)if(r=i[o].call(n,t,e))return r}function lt(o,e,t){var n,a,r=0,i=lt.prefilters.length,s=S.Deferred().always(function(){delete u.elem}),u=function(){if(a)return!1;for(var e=Ze||at(),t=Math.max(0,l.startTime+l.duration-e),n=1-(t/l.duration||0),r=0,i=l.tweens.length;r<i;r++)l.tweens[r].run(n);return s.notifyWith(o,[l,n,t]),n<1&&i?t:(i||s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l]),!1)},l=s.promise({elem:o,props:S.extend({},e),opts:S.extend(!0,{specialEasing:{},easing:S.easing._default},t),originalProperties:e,originalOptions:t,startTime:Ze||at(),duration:t.duration,tweens:[],createTween:function(e,t){var n=S.Tween(o,l.opts,e,t,l.opts.specialEasing[e]||l.opts.easing);return l.tweens.push(n),n},stop:function(e){var t=0,n=e?l.tweens.length:0;if(a)return this;for(a=!0;t<n;t++)l.tweens[t].run(1);return e?(s.notifyWith(o,[l,1,0]),s.resolveWith(o,[l,e])):s.rejectWith(o,[l,e]),this}}),c=l.props;for(!function(e,t){var n,r,i,o,a;for(n in e)if(i=t[r=X(n)],o=e[n],Array.isArray(o)&&(i=o[1],o=e[n]=o[0]),n!==r&&(e[r]=o,delete e[n]),(a=S.cssHooks[r])&&"expand"in a)for(n in o=a.expand(o),delete e[r],o)n in e||(e[n]=o[n],t[n]=i);else t[r]=i}(c,l.opts.specialEasing);r<i;r++)if(n=lt.prefilters[r].call(l,o,c,l.opts))return m(n.stop)&&(S._queueHooks(l.elem,l.opts.queue).stop=n.stop.bind(n)),n;return S.map(c,ut,l),m(l.opts.start)&&l.opts.start.call(o,l),l.progress(l.opts.progress).done(l.opts.done,l.opts.complete).fail(l.opts.fail).always(l.opts.always),S.fx.timer(S.extend(u,{elem:o,anim:l,queue:l.opts.queue})),l}S.Animation=S.extend(lt,{tweeners:{"*":[function(e,t){var n=this.createTween(e,t);return se(n.elem,e,te.exec(t),n),n}]},tweener:function(e,t){m(e)?(t=e,e=["*"]):e=e.match(P);for(var n,r=0,i=e.length;r<i;r++)n=e[r],lt.tweeners[n]=lt.tweeners[n]||[],lt.tweeners[n].unshift(t)},prefilters:[function(e,t,n){var r,i,o,a,s,u,l,c,f="width"in t||"height"in t,p=this,d={},h=e.style,g=e.nodeType&&ae(e),v=Y.get(e,"fxshow");for(r in n.queue||(null==(a=S._queueHooks(e,"fx")).unqueued&&(a.unqueued=0,s=a.empty.fire,a.empty.fire=function(){a.unqueued||s()}),a.unqueued++,p.always(function(){p.always(function(){a.unqueued--,S.queue(e,"fx").length||a.empty.fire()})})),t)if(i=t[r],rt.test(i)){if(delete t[r],o=o||"toggle"===i,i===(g?"hide":"show")){if("show"!==i||!v||void 0===v[r])continue;g=!0}d[r]=v&&v[r]||S.style(e,r)}if((u=!S.isEmptyObject(t))||!S.isEmptyObject(d))for(r in f&&1===e.nodeType&&(n.overflow=[h.overflow,h.overflowX,h.overflowY],null==(l=v&&v.display)&&(l=Y.get(e,"display")),"none"===(c=S.css(e,"display"))&&(l?c=l:(le([e],!0),l=e.style.display||l,c=S.css(e,"display"),le([e]))),("inline"===c||"inline-block"===c&&null!=l)&&"none"===S.css(e,"float")&&(u||(p.done(function(){h.display=l}),null==l&&(c=h.display,l="none"===c?"":c)),h.display="inline-block")),n.overflow&&(h.overflow="hidden",p.always(function(){h.overflow=n.overflow[0],h.overflowX=n.overflow[1],h.overflowY=n.overflow[2]})),u=!1,d)u||(v?"hidden"in v&&(g=v.hidden):v=Y.access(e,"fxshow",{display:l}),o&&(v.hidden=!g),g&&le([e],!0),p.done(function(){for(r in g||le([e]),Y.remove(e,"fxshow"),d)S.style(e,r,d[r])})),u=ut(g?v[r]:0,r,p),r in v||(v[r]=u.start,g&&(u.end=u.start,u.start=0))}],prefilter:function(e,t){t?lt.prefilters.unshift(e):lt.prefilters.push(e)}}),S.speed=function(e,t,n){var r=e&&"object"==typeof e?S.extend({},e):{complete:n||!n&&t||m(e)&&e,duration:e,easing:n&&t||t&&!m(t)&&t};return S.fx.off?r.duration=0:"number"!=typeof r.duration&&(r.duration in S.fx.speeds?r.duration=S.fx.speeds[r.duration]:r.duration=S.fx.speeds._default),null!=r.queue&&!0!==r.queue||(r.queue="fx"),r.old=r.complete,r.complete=function(){m(r.old)&&r.old.call(this),r.queue&&S.dequeue(this,r.queue)},r},S.fn.extend({fadeTo:function(e,t,n,r){return this.filter(ae).css("opacity",0).show().end().animate({opacity:t},e,n,r)},animate:function(t,e,n,r){var i=S.isEmptyObject(t),o=S.speed(e,n,r),a=function(){var e=lt(this,S.extend({},t),o);(i||Y.get(this,"finish"))&&e.stop(!0)};return a.finish=a,i||!1===o.queue?this.each(a):this.queue(o.queue,a)},stop:function(i,e,o){var a=function(e){var t=e.stop;delete e.stop,t(o)};return"string"!=typeof i&&(o=e,e=i,i=void 0),e&&this.queue(i||"fx",[]),this.each(function(){var e=!0,t=null!=i&&i+"queueHooks",n=S.timers,r=Y.get(this);if(t)r[t]&&r[t].stop&&a(r[t]);else for(t in r)r[t]&&r[t].stop&&it.test(t)&&a(r[t]);for(t=n.length;t--;)n[t].elem!==this||null!=i&&n[t].queue!==i||(n[t].anim.stop(o),e=!1,n.splice(t,1));!e&&o||S.dequeue(this,i)})},finish:function(a){return!1!==a&&(a=a||"fx"),this.each(function(){var e,t=Y.get(this),n=t[a+"queue"],r=t[a+"queueHooks"],i=S.timers,o=n?n.length:0;for(t.finish=!0,S.queue(this,a,[]),r&&r.stop&&r.stop.call(this,!0),e=i.length;e--;)i[e].elem===this&&i[e].queue===a&&(i[e].anim.stop(!0),i.splice(e,1));for(e=0;e<o;e++)n[e]&&n[e].finish&&n[e].finish.call(this);delete t.finish})}}),S.each(["toggle","show","hide"],function(e,r){var i=S.fn[r];S.fn[r]=function(e,t,n){return null==e||"boolean"==typeof e?i.apply(this,arguments):this.animate(st(r,!0),e,t,n)}}),S.each({slideDown:st("show"),slideUp:st("hide"),slideToggle:st("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(e,r){S.fn[e]=function(e,t,n){return this.animate(r,e,t,n)}}),S.timers=[],S.fx.tick=function(){var e,t=0,n=S.timers;for(Ze=Date.now();t<n.length;t++)(e=n[t])()||n[t]!==e||n.splice(t--,1);n.length||S.fx.stop(),Ze=void 0},S.fx.timer=function(e){S.timers.push(e),S.fx.start()},S.fx.interval=13,S.fx.start=function(){et||(et=!0,ot())},S.fx.stop=function(){et=null},S.fx.speeds={slow:600,fast:200,_default:400},S.fn.delay=function(r,e){return r=S.fx&&S.fx.speeds[r]||r,e=e||"fx",this.queue(e,function(e,t){var n=C.setTimeout(e,r);t.stop=function(){C.clearTimeout(n)}})},tt=E.createElement("input"),nt=E.createElement("select").appendChild(E.createElement("option")),tt.type="checkbox",y.checkOn=""!==tt.value,y.optSelected=nt.selected,(tt=E.createElement("input")).value="t",tt.type="radio",y.radioValue="t"===tt.value;var ct,ft=S.expr.attrHandle;S.fn.extend({attr:function(e,t){return $(this,S.attr,e,t,1<arguments.length)},removeAttr:function(e){return this.each(function(){S.removeAttr(this,e)})}}),S.extend({attr:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return"undefined"==typeof e.getAttribute?S.prop(e,t,n):(1===o&&S.isXMLDoc(e)||(i=S.attrHooks[t.toLowerCase()]||(S.expr.match.bool.test(t)?ct:void 0)),void 0!==n?null===n?void S.removeAttr(e,t):i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:(e.setAttribute(t,n+""),n):i&&"get"in i&&null!==(r=i.get(e,t))?r:null==(r=S.find.attr(e,t))?void 0:r)},attrHooks:{type:{set:function(e,t){if(!y.radioValue&&"radio"===t&&A(e,"input")){var n=e.value;return e.setAttribute("type",t),n&&(e.value=n),t}}}},removeAttr:function(e,t){var n,r=0,i=t&&t.match(P);if(i&&1===e.nodeType)while(n=i[r++])e.removeAttribute(n)}}),ct={set:function(e,t,n){return!1===t?S.removeAttr(e,n):e.setAttribute(n,n),n}},S.each(S.expr.match.bool.source.match(/\w+/g),function(e,t){var a=ft[t]||S.find.attr;ft[t]=function(e,t,n){var r,i,o=t.toLowerCase();return n||(i=ft[o],ft[o]=r,r=null!=a(e,t,n)?o:null,ft[o]=i),r}});var pt=/^(?:input|select|textarea|button)$/i,dt=/^(?:a|area)$/i;function ht(e){return(e.match(P)||[]).join(" ")}function gt(e){return e.getAttribute&&e.getAttribute("class")||""}function vt(e){return Array.isArray(e)?e:"string"==typeof e&&e.match(P)||[]}S.fn.extend({prop:function(e,t){return $(this,S.prop,e,t,1<arguments.length)},removeProp:function(e){return this.each(function(){delete this[S.propFix[e]||e]})}}),S.extend({prop:function(e,t,n){var r,i,o=e.nodeType;if(3!==o&&8!==o&&2!==o)return 1===o&&S.isXMLDoc(e)||(t=S.propFix[t]||t,i=S.propHooks[t]),void 0!==n?i&&"set"in i&&void 0!==(r=i.set(e,n,t))?r:e[t]=n:i&&"get"in i&&null!==(r=i.get(e,t))?r:e[t]},propHooks:{tabIndex:{get:function(e){var t=S.find.attr(e,"tabindex");return t?parseInt(t,10):pt.test(e.nodeName)||dt.test(e.nodeName)&&e.href?0:-1}}},propFix:{"for":"htmlFor","class":"className"}}),y.optSelected||(S.propHooks.selected={get:function(e){var t=e.parentNode;return t&&t.parentNode&&t.parentNode.selectedIndex,null},set:function(e){var t=e.parentNode;t&&(t.selectedIndex,t.parentNode&&t.parentNode.selectedIndex)}}),S.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){S.propFix[this.toLowerCase()]=this}),S.fn.extend({addClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).addClass(t.call(this,e,gt(this)))});if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])r.indexOf(" "+o+" ")<0&&(r+=o+" ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},removeClass:function(t){var e,n,r,i,o,a,s,u=0;if(m(t))return this.each(function(e){S(this).removeClass(t.call(this,e,gt(this)))});if(!arguments.length)return this.attr("class","");if((e=vt(t)).length)while(n=this[u++])if(i=gt(n),r=1===n.nodeType&&" "+ht(i)+" "){a=0;while(o=e[a++])while(-1<r.indexOf(" "+o+" "))r=r.replace(" "+o+" "," ");i!==(s=ht(r))&&n.setAttribute("class",s)}return this},toggleClass:function(i,t){var o=typeof i,a="string"===o||Array.isArray(i);return"boolean"==typeof t&&a?t?this.addClass(i):this.removeClass(i):m(i)?this.each(function(e){S(this).toggleClass(i.call(this,e,gt(this),t),t)}):this.each(function(){var e,t,n,r;if(a){t=0,n=S(this),r=vt(i);while(e=r[t++])n.hasClass(e)?n.removeClass(e):n.addClass(e)}else void 0!==i&&"boolean"!==o||((e=gt(this))&&Y.set(this,"__className__",e),this.setAttribute&&this.setAttribute("class",e||!1===i?"":Y.get(this,"__className__")||""))})},hasClass:function(e){var t,n,r=0;t=" "+e+" ";while(n=this[r++])if(1===n.nodeType&&-1<(" "+ht(gt(n))+" ").indexOf(t))return!0;return!1}});var yt=/\r/g;S.fn.extend({val:function(n){var r,e,i,t=this[0];return arguments.length?(i=m(n),this.each(function(e){var t;1===this.nodeType&&(null==(t=i?n.call(this,e,S(this).val()):n)?t="":"number"==typeof t?t+="":Array.isArray(t)&&(t=S.map(t,function(e){return null==e?"":e+""})),(r=S.valHooks[this.type]||S.valHooks[this.nodeName.toLowerCase()])&&"set"in r&&void 0!==r.set(this,t,"value")||(this.value=t))})):t?(r=S.valHooks[t.type]||S.valHooks[t.nodeName.toLowerCase()])&&"get"in r&&void 0!==(e=r.get(t,"value"))?e:"string"==typeof(e=t.value)?e.replace(yt,""):null==e?"":e:void 0}}),S.extend({valHooks:{option:{get:function(e){var t=S.find.attr(e,"value");return null!=t?t:ht(S.text(e))}},select:{get:function(e){var t,n,r,i=e.options,o=e.selectedIndex,a="select-one"===e.type,s=a?null:[],u=a?o+1:i.length;for(r=o<0?u:a?o:0;r<u;r++)if(((n=i[r]).selected||r===o)&&!n.disabled&&(!n.parentNode.disabled||!A(n.parentNode,"optgroup"))){if(t=S(n).val(),a)return t;s.push(t)}return s},set:function(e,t){var n,r,i=e.options,o=S.makeArray(t),a=i.length;while(a--)((r=i[a]).selected=-1<S.inArray(S.valHooks.option.get(r),o))&&(n=!0);return n||(e.selectedIndex=-1),o}}}}),S.each(["radio","checkbox"],function(){S.valHooks[this]={set:function(e,t){if(Array.isArray(t))return e.checked=-1<S.inArray(S(e).val(),t)}},y.checkOn||(S.valHooks[this].get=function(e){return null===e.getAttribute("value")?"on":e.value})}),y.focusin="onfocusin"in C;var mt=/^(?:focusinfocus|focusoutblur)$/,xt=function(e){e.stopPropagation()};S.extend(S.event,{trigger:function(e,t,n,r){var i,o,a,s,u,l,c,f,p=[n||E],d=v.call(e,"type")?e.type:e,h=v.call(e,"namespace")?e.namespace.split("."):[];if(o=f=a=n=n||E,3!==n.nodeType&&8!==n.nodeType&&!mt.test(d+S.event.triggered)&&(-1<d.indexOf(".")&&(d=(h=d.split(".")).shift(),h.sort()),u=d.indexOf(":")<0&&"on"+d,(e=e[S.expando]?e:new S.Event(d,"object"==typeof e&&e)).isTrigger=r?2:3,e.namespace=h.join("."),e.rnamespace=e.namespace?new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,e.result=void 0,e.target||(e.target=n),t=null==t?[e]:S.makeArray(t,[e]),c=S.event.special[d]||{},r||!c.trigger||!1!==c.trigger.apply(n,t))){if(!r&&!c.noBubble&&!x(n)){for(s=c.delegateType||d,mt.test(s+d)||(o=o.parentNode);o;o=o.parentNode)p.push(o),a=o;a===(n.ownerDocument||E)&&p.push(a.defaultView||a.parentWindow||C)}i=0;while((o=p[i++])&&!e.isPropagationStopped())f=o,e.type=1<i?s:c.bindType||d,(l=(Y.get(o,"events")||Object.create(null))[e.type]&&Y.get(o,"handle"))&&l.apply(o,t),(l=u&&o[u])&&l.apply&&V(o)&&(e.result=l.apply(o,t),!1===e.result&&e.preventDefault());return e.type=d,r||e.isDefaultPrevented()||c._default&&!1!==c._default.apply(p.pop(),t)||!V(n)||u&&m(n[d])&&!x(n)&&((a=n[u])&&(n[u]=null),S.event.triggered=d,e.isPropagationStopped()&&f.addEventListener(d,xt),n[d](),e.isPropagationStopped()&&f.removeEventListener(d,xt),S.event.triggered=void 0,a&&(n[u]=a)),e.result}},simulate:function(e,t,n){var r=S.extend(new S.Event,n,{type:e,isSimulated:!0});S.event.trigger(r,null,t)}}),S.fn.extend({trigger:function(e,t){return this.each(function(){S.event.trigger(e,t,this)})},triggerHandler:function(e,t){var n=this[0];if(n)return S.event.trigger(e,t,n,!0)}}),y.focusin||S.each({focus:"focusin",blur:"focusout"},function(n,r){var i=function(e){S.event.simulate(r,e.target,S.event.fix(e))};S.event.special[r]={setup:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r);t||e.addEventListener(n,i,!0),Y.access(e,r,(t||0)+1)},teardown:function(){var e=this.ownerDocument||this.document||this,t=Y.access(e,r)-1;t?Y.access(e,r,t):(e.removeEventListener(n,i,!0),Y.remove(e,r))}}});var bt=C.location,wt={guid:Date.now()},Tt=/\?/;S.parseXML=function(e){var t,n;if(!e||"string"!=typeof e)return null;try{t=(new C.DOMParser).parseFromString(e,"text/xml")}catch(e){}return n=t&&t.getElementsByTagName("parsererror")[0],t&&!n||S.error("Invalid XML: "+(n?S.map(n.childNodes,function(e){return e.textContent}).join("\n"):e)),t};var Ct=/\[\]$/,Et=/\r?\n/g,St=/^(?:submit|button|image|reset|file)$/i,kt=/^(?:input|select|textarea|keygen)/i;function At(n,e,r,i){var t;if(Array.isArray(e))S.each(e,function(e,t){r||Ct.test(n)?i(n,t):At(n+"["+("object"==typeof t&&null!=t?e:"")+"]",t,r,i)});else if(r||"object"!==w(e))i(n,e);else for(t in e)At(n+"["+t+"]",e[t],r,i)}S.param=function(e,t){var n,r=[],i=function(e,t){var n=m(t)?t():t;r[r.length]=encodeURIComponent(e)+"="+encodeURIComponent(null==n?"":n)};if(null==e)return"";if(Array.isArray(e)||e.jquery&&!S.isPlainObject(e))S.each(e,function(){i(this.name,this.value)});else for(n in e)At(n,e[n],t,i);return r.join("&")},S.fn.extend({serialize:function(){return S.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var e=S.prop(this,"elements");return e?S.makeArray(e):this}).filter(function(){var e=this.type;return this.name&&!S(this).is(":disabled")&&kt.test(this.nodeName)&&!St.test(e)&&(this.checked||!pe.test(e))}).map(function(e,t){var n=S(this).val();return null==n?null:Array.isArray(n)?S.map(n,function(e){return{name:t.name,value:e.replace(Et,"\r\n")}}):{name:t.name,value:n.replace(Et,"\r\n")}}).get()}});var Nt=/%20/g,jt=/#.*$/,Dt=/([?&])_=[^&]*/,qt=/^(.*?):[ \t]*([^\r\n]*)$/gm,Lt=/^(?:GET|HEAD)$/,Ht=/^\/\//,Ot={},Pt={},Rt="*/".concat("*"),Mt=E.createElement("a");function It(o){return function(e,t){"string"!=typeof e&&(t=e,e="*");var n,r=0,i=e.toLowerCase().match(P)||[];if(m(t))while(n=i[r++])"+"===n[0]?(n=n.slice(1)||"*",(o[n]=o[n]||[]).unshift(t)):(o[n]=o[n]||[]).push(t)}}function Wt(t,i,o,a){var s={},u=t===Pt;function l(e){var r;return s[e]=!0,S.each(t[e]||[],function(e,t){var n=t(i,o,a);return"string"!=typeof n||u||s[n]?u?!(r=n):void 0:(i.dataTypes.unshift(n),l(n),!1)}),r}return l(i.dataTypes[0])||!s["*"]&&l("*")}function Ft(e,t){var n,r,i=S.ajaxSettings.flatOptions||{};for(n in t)void 0!==t[n]&&((i[n]?e:r||(r={}))[n]=t[n]);return r&&S.extend(!0,e,r),e}Mt.href=bt.href,S.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:bt.href,type:"GET",isLocal:/^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":Rt,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/\bxml\b/,html:/\bhtml/,json:/\bjson\b/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":JSON.parse,"text xml":S.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(e,t){return t?Ft(Ft(e,S.ajaxSettings),t):Ft(S.ajaxSettings,e)},ajaxPrefilter:It(Ot),ajaxTransport:It(Pt),ajax:function(e,t){"object"==typeof e&&(t=e,e=void 0),t=t||{};var c,f,p,n,d,r,h,g,i,o,v=S.ajaxSetup({},t),y=v.context||v,m=v.context&&(y.nodeType||y.jquery)?S(y):S.event,x=S.Deferred(),b=S.Callbacks("once memory"),w=v.statusCode||{},a={},s={},u="canceled",T={readyState:0,getResponseHeader:function(e){var t;if(h){if(!n){n={};while(t=qt.exec(p))n[t[1].toLowerCase()+" "]=(n[t[1].toLowerCase()+" "]||[]).concat(t[2])}t=n[e.toLowerCase()+" "]}return null==t?null:t.join(", ")},getAllResponseHeaders:function(){return h?p:null},setRequestHeader:function(e,t){return null==h&&(e=s[e.toLowerCase()]=s[e.toLowerCase()]||e,a[e]=t),this},overrideMimeType:function(e){return null==h&&(v.mimeType=e),this},statusCode:function(e){var t;if(e)if(h)T.always(e[T.status]);else for(t in e)w[t]=[w[t],e[t]];return this},abort:function(e){var t=e||u;return c&&c.abort(t),l(0,t),this}};if(x.promise(T),v.url=((e||v.url||bt.href)+"").replace(Ht,bt.protocol+"//"),v.type=t.method||t.type||v.method||v.type,v.dataTypes=(v.dataType||"*").toLowerCase().match(P)||[""],null==v.crossDomain){r=E.createElement("a");try{r.href=v.url,r.href=r.href,v.crossDomain=Mt.protocol+"//"+Mt.host!=r.protocol+"//"+r.host}catch(e){v.crossDomain=!0}}if(v.data&&v.processData&&"string"!=typeof v.data&&(v.data=S.param(v.data,v.traditional)),Wt(Ot,v,t,T),h)return T;for(i in(g=S.event&&v.global)&&0==S.active++&&S.event.trigger("ajaxStart"),v.type=v.type.toUpperCase(),v.hasContent=!Lt.test(v.type),f=v.url.replace(jt,""),v.hasContent?v.data&&v.processData&&0===(v.contentType||"").indexOf("application/x-www-form-urlencoded")&&(v.data=v.data.replace(Nt,"+")):(o=v.url.slice(f.length),v.data&&(v.processData||"string"==typeof v.data)&&(f+=(Tt.test(f)?"&":"?")+v.data,delete v.data),!1===v.cache&&(f=f.replace(Dt,"$1"),o=(Tt.test(f)?"&":"?")+"_="+wt.guid+++o),v.url=f+o),v.ifModified&&(S.lastModified[f]&&T.setRequestHeader("If-Modified-Since",S.lastModified[f]),S.etag[f]&&T.setRequestHeader("If-None-Match",S.etag[f])),(v.data&&v.hasContent&&!1!==v.contentType||t.contentType)&&T.setRequestHeader("Content-Type",v.contentType),T.setRequestHeader("Accept",v.dataTypes[0]&&v.accepts[v.dataTypes[0]]?v.accepts[v.dataTypes[0]]+("*"!==v.dataTypes[0]?", "+Rt+"; q=0.01":""):v.accepts["*"]),v.headers)T.setRequestHeader(i,v.headers[i]);if(v.beforeSend&&(!1===v.beforeSend.call(y,T,v)||h))return T.abort();if(u="abort",b.add(v.complete),T.done(v.success),T.fail(v.error),c=Wt(Pt,v,t,T)){if(T.readyState=1,g&&m.trigger("ajaxSend",[T,v]),h)return T;v.async&&0<v.timeout&&(d=C.setTimeout(function(){T.abort("timeout")},v.timeout));try{h=!1,c.send(a,l)}catch(e){if(h)throw e;l(-1,e)}}else l(-1,"No Transport");function l(e,t,n,r){var i,o,a,s,u,l=t;h||(h=!0,d&&C.clearTimeout(d),c=void 0,p=r||"",T.readyState=0<e?4:0,i=200<=e&&e<300||304===e,n&&(s=function(e,t,n){var r,i,o,a,s=e.contents,u=e.dataTypes;while("*"===u[0])u.shift(),void 0===r&&(r=e.mimeType||t.getResponseHeader("Content-Type"));if(r)for(i in s)if(s[i]&&s[i].test(r)){u.unshift(i);break}if(u[0]in n)o=u[0];else{for(i in n){if(!u[0]||e.converters[i+" "+u[0]]){o=i;break}a||(a=i)}o=o||a}if(o)return o!==u[0]&&u.unshift(o),n[o]}(v,T,n)),!i&&-1<S.inArray("script",v.dataTypes)&&S.inArray("json",v.dataTypes)<0&&(v.converters["text script"]=function(){}),s=function(e,t,n,r){var i,o,a,s,u,l={},c=e.dataTypes.slice();if(c[1])for(a in e.converters)l[a.toLowerCase()]=e.converters[a];o=c.shift();while(o)if(e.responseFields[o]&&(n[e.responseFields[o]]=t),!u&&r&&e.dataFilter&&(t=e.dataFilter(t,e.dataType)),u=o,o=c.shift())if("*"===o)o=u;else if("*"!==u&&u!==o){if(!(a=l[u+" "+o]||l["* "+o]))for(i in l)if((s=i.split(" "))[1]===o&&(a=l[u+" "+s[0]]||l["* "+s[0]])){!0===a?a=l[i]:!0!==l[i]&&(o=s[0],c.unshift(s[1]));break}if(!0!==a)if(a&&e["throws"])t=a(t);else try{t=a(t)}catch(e){return{state:"parsererror",error:a?e:"No conversion from "+u+" to "+o}}}return{state:"success",data:t}}(v,s,T,i),i?(v.ifModified&&((u=T.getResponseHeader("Last-Modified"))&&(S.lastModified[f]=u),(u=T.getResponseHeader("etag"))&&(S.etag[f]=u)),204===e||"HEAD"===v.type?l="nocontent":304===e?l="notmodified":(l=s.state,o=s.data,i=!(a=s.error))):(a=l,!e&&l||(l="error",e<0&&(e=0))),T.status=e,T.statusText=(t||l)+"",i?x.resolveWith(y,[o,l,T]):x.rejectWith(y,[T,l,a]),T.statusCode(w),w=void 0,g&&m.trigger(i?"ajaxSuccess":"ajaxError",[T,v,i?o:a]),b.fireWith(y,[T,l]),g&&(m.trigger("ajaxComplete",[T,v]),--S.active||S.event.trigger("ajaxStop")))}return T},getJSON:function(e,t,n){return S.get(e,t,n,"json")},getScript:function(e,t){return S.get(e,void 0,t,"script")}}),S.each(["get","post"],function(e,i){S[i]=function(e,t,n,r){return m(t)&&(r=r||n,n=t,t=void 0),S.ajax(S.extend({url:e,type:i,dataType:r,data:t,success:n},S.isPlainObject(e)&&e))}}),S.ajaxPrefilter(function(e){var t;for(t in e.headers)"content-type"===t.toLowerCase()&&(e.contentType=e.headers[t]||"")}),S._evalUrl=function(e,t,n){return S.ajax({url:e,type:"GET",dataType:"script",cache:!0,async:!1,global:!1,converters:{"text script":function(){}},dataFilter:function(e){S.globalEval(e,t,n)}})},S.fn.extend({wrapAll:function(e){var t;return this[0]&&(m(e)&&(e=e.call(this[0])),t=S(e,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&t.insertBefore(this[0]),t.map(function(){var e=this;while(e.firstElementChild)e=e.firstElementChild;return e}).append(this)),this},wrapInner:function(n){return m(n)?this.each(function(e){S(this).wrapInner(n.call(this,e))}):this.each(function(){var e=S(this),t=e.contents();t.length?t.wrapAll(n):e.append(n)})},wrap:function(t){var n=m(t);return this.each(function(e){S(this).wrapAll(n?t.call(this,e):t)})},unwrap:function(e){return this.parent(e).not("body").each(function(){S(this).replaceWith(this.childNodes)}),this}}),S.expr.pseudos.hidden=function(e){return!S.expr.pseudos.visible(e)},S.expr.pseudos.visible=function(e){return!!(e.offsetWidth||e.offsetHeight||e.getClientRects().length)},S.ajaxSettings.xhr=function(){try{return new C.XMLHttpRequest}catch(e){}};var Bt={0:200,1223:204},$t=S.ajaxSettings.xhr();y.cors=!!$t&&"withCredentials"in $t,y.ajax=$t=!!$t,S.ajaxTransport(function(i){var o,a;if(y.cors||$t&&!i.crossDomain)return{send:function(e,t){var n,r=i.xhr();if(r.open(i.type,i.url,i.async,i.username,i.password),i.xhrFields)for(n in i.xhrFields)r[n]=i.xhrFields[n];for(n in i.mimeType&&r.overrideMimeType&&r.overrideMimeType(i.mimeType),i.crossDomain||e["X-Requested-With"]||(e["X-Requested-With"]="XMLHttpRequest"),e)r.setRequestHeader(n,e[n]);o=function(e){return function(){o&&(o=a=r.onload=r.onerror=r.onabort=r.ontimeout=r.onreadystatechange=null,"abort"===e?r.abort():"error"===e?"number"!=typeof r.status?t(0,"error"):t(r.status,r.statusText):t(Bt[r.status]||r.status,r.statusText,"text"!==(r.responseType||"text")||"string"!=typeof r.responseText?{binary:r.response}:{text:r.responseText},r.getAllResponseHeaders()))}},r.onload=o(),a=r.onerror=r.ontimeout=o("error"),void 0!==r.onabort?r.onabort=a:r.onreadystatechange=function(){4===r.readyState&&C.setTimeout(function(){o&&a()})},o=o("abort");try{r.send(i.hasContent&&i.data||null)}catch(e){if(o)throw e}},abort:function(){o&&o()}}}),S.ajaxPrefilter(function(e){e.crossDomain&&(e.contents.script=!1)}),S.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/\b(?:java|ecma)script\b/},converters:{"text script":function(e){return S.globalEval(e),e}}}),S.ajaxPrefilter("script",function(e){void 0===e.cache&&(e.cache=!1),e.crossDomain&&(e.type="GET")}),S.ajaxTransport("script",function(n){var r,i;if(n.crossDomain||n.scriptAttrs)return{send:function(e,t){r=S("<script>").attr(n.scriptAttrs||{}).prop({charset:n.scriptCharset,src:n.url}).on("load error",i=function(e){r.remove(),i=null,e&&t("error"===e.type?404:200,e.type)}),E.head.appendChild(r[0])},abort:function(){i&&i()}}});var _t,zt=[],Ut=/(=)\?(?=&|$)|\?\?/;S.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var e=zt.pop()||S.expando+"_"+wt.guid++;return this[e]=!0,e}}),S.ajaxPrefilter("json jsonp",function(e,t,n){var r,i,o,a=!1!==e.jsonp&&(Ut.test(e.url)?"url":"string"==typeof e.data&&0===(e.contentType||"").indexOf("application/x-www-form-urlencoded")&&Ut.test(e.data)&&"data");if(a||"jsonp"===e.dataTypes[0])return r=e.jsonpCallback=m(e.jsonpCallback)?e.jsonpCallback():e.jsonpCallback,a?e[a]=e[a].replace(Ut,"$1"+r):!1!==e.jsonp&&(e.url+=(Tt.test(e.url)?"&":"?")+e.jsonp+"="+r),e.converters["script json"]=function(){return o||S.error(r+" was not called"),o[0]},e.dataTypes[0]="json",i=C[r],C[r]=function(){o=arguments},n.always(function(){void 0===i?S(C).removeProp(r):C[r]=i,e[r]&&(e.jsonpCallback=t.jsonpCallback,zt.push(r)),o&&m(i)&&i(o[0]),o=i=void 0}),"script"}),y.createHTMLDocument=((_t=E.implementation.createHTMLDocument("").body).innerHTML="<form></form><form></form>",2===_t.childNodes.length),S.parseHTML=function(e,t,n){return"string"!=typeof e?[]:("boolean"==typeof t&&(n=t,t=!1),t||(y.createHTMLDocument?((r=(t=E.implementation.createHTMLDocument("")).createElement("base")).href=E.location.href,t.head.appendChild(r)):t=E),o=!n&&[],(i=N.exec(e))?[t.createElement(i[1])]:(i=xe([e],t,o),o&&o.length&&S(o).remove(),S.merge([],i.childNodes)));var r,i,o},S.fn.load=function(e,t,n){var r,i,o,a=this,s=e.indexOf(" ");return-1<s&&(r=ht(e.slice(s)),e=e.slice(0,s)),m(t)?(n=t,t=void 0):t&&"object"==typeof t&&(i="POST"),0<a.length&&S.ajax({url:e,type:i||"GET",dataType:"html",data:t}).done(function(e){o=arguments,a.html(r?S("<div>").append(S.parseHTML(e)).find(r):e)}).always(n&&function(e,t){a.each(function(){n.apply(this,o||[e.responseText,t,e])})}),this},S.expr.pseudos.animated=function(t){return S.grep(S.timers,function(e){return t===e.elem}).length},S.offset={setOffset:function(e,t,n){var r,i,o,a,s,u,l=S.css(e,"position"),c=S(e),f={};"static"===l&&(e.style.position="relative"),s=c.offset(),o=S.css(e,"top"),u=S.css(e,"left"),("absolute"===l||"fixed"===l)&&-1<(o+u).indexOf("auto")?(a=(r=c.position()).top,i=r.left):(a=parseFloat(o)||0,i=parseFloat(u)||0),m(t)&&(t=t.call(e,n,S.extend({},s))),null!=t.top&&(f.top=t.top-s.top+a),null!=t.left&&(f.left=t.left-s.left+i),"using"in t?t.using.call(e,f):c.css(f)}},S.fn.extend({offset:function(t){if(arguments.length)return void 0===t?this:this.each(function(e){S.offset.setOffset(this,t,e)});var e,n,r=this[0];return r?r.getClientRects().length?(e=r.getBoundingClientRect(),n=r.ownerDocument.defaultView,{top:e.top+n.pageYOffset,left:e.left+n.pageXOffset}):{top:0,left:0}:void 0},position:function(){if(this[0]){var e,t,n,r=this[0],i={top:0,left:0};if("fixed"===S.css(r,"position"))t=r.getBoundingClientRect();else{t=this.offset(),n=r.ownerDocument,e=r.offsetParent||n.documentElement;while(e&&(e===n.body||e===n.documentElement)&&"static"===S.css(e,"position"))e=e.parentNode;e&&e!==r&&1===e.nodeType&&((i=S(e).offset()).top+=S.css(e,"borderTopWidth",!0),i.left+=S.css(e,"borderLeftWidth",!0))}return{top:t.top-i.top-S.css(r,"marginTop",!0),left:t.left-i.left-S.css(r,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var e=this.offsetParent;while(e&&"static"===S.css(e,"position"))e=e.offsetParent;return e||re})}}),S.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(t,i){var o="pageYOffset"===i;S.fn[t]=function(e){return $(this,function(e,t,n){var r;if(x(e)?r=e:9===e.nodeType&&(r=e.defaultView),void 0===n)return r?r[i]:e[t];r?r.scrollTo(o?r.pageXOffset:n,o?n:r.pageYOffset):e[t]=n},t,e,arguments.length)}}),S.each(["top","left"],function(e,n){S.cssHooks[n]=Fe(y.pixelPosition,function(e,t){if(t)return t=We(e,n),Pe.test(t)?S(e).position()[n]+"px":t})}),S.each({Height:"height",Width:"width"},function(a,s){S.each({padding:"inner"+a,content:s,"":"outer"+a},function(r,o){S.fn[o]=function(e,t){var n=arguments.length&&(r||"boolean"!=typeof e),i=r||(!0===e||!0===t?"margin":"border");return $(this,function(e,t,n){var r;return x(e)?0===o.indexOf("outer")?e["inner"+a]:e.document.documentElement["client"+a]:9===e.nodeType?(r=e.documentElement,Math.max(e.body["scroll"+a],r["scroll"+a],e.body["offset"+a],r["offset"+a],r["client"+a])):void 0===n?S.css(e,t,i):S.style(e,t,n,i)},s,n?e:void 0,n)}})}),S.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(e,t){S.fn[t]=function(e){return this.on(t,e)}}),S.fn.extend({bind:function(e,t,n){return this.on(e,null,t,n)},unbind:function(e,t){return this.off(e,null,t)},delegate:function(e,t,n,r){return this.on(t,e,n,r)},undelegate:function(e,t,n){return 1===arguments.length?this.off(e,"**"):this.off(t,e||"**",n)},hover:function(e,t){return this.mouseenter(e).mouseleave(t||e)}}),S.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),function(e,n){S.fn[n]=function(e,t){return 0<arguments.length?this.on(n,null,e,t):this.trigger(n)}});var Xt=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;S.proxy=function(e,t){var n,r,i;if("string"==typeof t&&(n=e[t],t=e,e=n),m(e))return r=s.call(arguments,2),(i=function(){return e.apply(t||this,r.concat(s.call(arguments)))}).guid=e.guid=e.guid||S.guid++,i},S.holdReady=function(e){e?S.readyWait++:S.ready(!0)},S.isArray=Array.isArray,S.parseJSON=JSON.parse,S.nodeName=A,S.isFunction=m,S.isWindow=x,S.camelCase=X,S.type=w,S.now=Date.now,S.isNumeric=function(e){var t=S.type(e);return("number"===t||"string"===t)&&!isNaN(e-parseFloat(e))},S.trim=function(e){return null==e?"":(e+"").replace(Xt,"")},"function"==typeof define&&define.amd&&define("jquery",[],function(){return S});var Vt=C.jQuery,Gt=C.$;return S.noConflict=function(e){return C.$===S&&(C.$=Gt),e&&C.jQuery===S&&(C.jQuery=Vt),S},"undefined"==typeof e&&(C.jQuery=C.$=S),S});

/**
 * @popperjs/core v2.11.2 - MIT License
 */

!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports):"function"==typeof define&&define.amd?define(["exports"],t):t((e="undefined"!=typeof globalThis?globalThis:e||self).Popper={})}(this,(function(e){"use strict";function t(e){if(null==e)return window;if("[object Window]"!==e.toString()){var t=e.ownerDocument;return t&&t.defaultView||window}return e}function n(e){return e instanceof t(e).Element||e instanceof Element}function r(e){return e instanceof t(e).HTMLElement||e instanceof HTMLElement}function o(e){return"undefined"!=typeof ShadowRoot&&(e instanceof t(e).ShadowRoot||e instanceof ShadowRoot)}var i=Math.max,a=Math.min,s=Math.round;function f(e,t){void 0===t&&(t=!1);var n=e.getBoundingClientRect(),o=1,i=1;if(r(e)&&t){var a=e.offsetHeight,f=e.offsetWidth;f>0&&(o=s(n.width)/f||1),a>0&&(i=s(n.height)/a||1)}return{width:n.width/o,height:n.height/i,top:n.top/i,right:n.right/o,bottom:n.bottom/i,left:n.left/o,x:n.left/o,y:n.top/i}}function c(e){var n=t(e);return{scrollLeft:n.pageXOffset,scrollTop:n.pageYOffset}}function p(e){return e?(e.nodeName||"").toLowerCase():null}function u(e){return((n(e)?e.ownerDocument:e.document)||window.document).documentElement}function l(e){return f(u(e)).left+c(e).scrollLeft}function d(e){return t(e).getComputedStyle(e)}function h(e){var t=d(e),n=t.overflow,r=t.overflowX,o=t.overflowY;return/auto|scroll|overlay|hidden/.test(n+o+r)}function m(e,n,o){void 0===o&&(o=!1);var i,a,d=r(n),m=r(n)&&function(e){var t=e.getBoundingClientRect(),n=s(t.width)/e.offsetWidth||1,r=s(t.height)/e.offsetHeight||1;return 1!==n||1!==r}(n),v=u(n),g=f(e,m),y={scrollLeft:0,scrollTop:0},b={x:0,y:0};return(d||!d&&!o)&&(("body"!==p(n)||h(v))&&(y=(i=n)!==t(i)&&r(i)?{scrollLeft:(a=i).scrollLeft,scrollTop:a.scrollTop}:c(i)),r(n)?((b=f(n,!0)).x+=n.clientLeft,b.y+=n.clientTop):v&&(b.x=l(v))),{x:g.left+y.scrollLeft-b.x,y:g.top+y.scrollTop-b.y,width:g.width,height:g.height}}function v(e){var t=f(e),n=e.offsetWidth,r=e.offsetHeight;return Math.abs(t.width-n)<=1&&(n=t.width),Math.abs(t.height-r)<=1&&(r=t.height),{x:e.offsetLeft,y:e.offsetTop,width:n,height:r}}function g(e){return"html"===p(e)?e:e.assignedSlot||e.parentNode||(o(e)?e.host:null)||u(e)}function y(e){return["html","body","#document"].indexOf(p(e))>=0?e.ownerDocument.body:r(e)&&h(e)?e:y(g(e))}function b(e,n){var r;void 0===n&&(n=[]);var o=y(e),i=o===(null==(r=e.ownerDocument)?void 0:r.body),a=t(o),s=i?[a].concat(a.visualViewport||[],h(o)?o:[]):o,f=n.concat(s);return i?f:f.concat(b(g(s)))}function x(e){return["table","td","th"].indexOf(p(e))>=0}function w(e){return r(e)&&"fixed"!==d(e).position?e.offsetParent:null}function O(e){for(var n=t(e),o=w(e);o&&x(o)&&"static"===d(o).position;)o=w(o);return o&&("html"===p(o)||"body"===p(o)&&"static"===d(o).position)?n:o||function(e){var t=-1!==navigator.userAgent.toLowerCase().indexOf("firefox");if(-1!==navigator.userAgent.indexOf("Trident")&&r(e)&&"fixed"===d(e).position)return null;for(var n=g(e);r(n)&&["html","body"].indexOf(p(n))<0;){var o=d(n);if("none"!==o.transform||"none"!==o.perspective||"paint"===o.contain||-1!==["transform","perspective"].indexOf(o.willChange)||t&&"filter"===o.willChange||t&&o.filter&&"none"!==o.filter)return n;n=n.parentNode}return null}(e)||n}var j="top",E="bottom",D="right",A="left",L="auto",P=[j,E,D,A],M="start",k="end",W="viewport",B="popper",H=P.reduce((function(e,t){return e.concat([t+"-"+M,t+"-"+k])}),[]),T=[].concat(P,[L]).reduce((function(e,t){return e.concat([t,t+"-"+M,t+"-"+k])}),[]),R=["beforeRead","read","afterRead","beforeMain","main","afterMain","beforeWrite","write","afterWrite"];function S(e){var t=new Map,n=new Set,r=[];function o(e){n.add(e.name),[].concat(e.requires||[],e.requiresIfExists||[]).forEach((function(e){if(!n.has(e)){var r=t.get(e);r&&o(r)}})),r.push(e)}return e.forEach((function(e){t.set(e.name,e)})),e.forEach((function(e){n.has(e.name)||o(e)})),r}function C(e){return e.split("-")[0]}function q(e,t){var n=t.getRootNode&&t.getRootNode();if(e.contains(t))return!0;if(n&&o(n)){var r=t;do{if(r&&e.isSameNode(r))return!0;r=r.parentNode||r.host}while(r)}return!1}function V(e){return Object.assign({},e,{left:e.x,top:e.y,right:e.x+e.width,bottom:e.y+e.height})}function N(e,r){return r===W?V(function(e){var n=t(e),r=u(e),o=n.visualViewport,i=r.clientWidth,a=r.clientHeight,s=0,f=0;return o&&(i=o.width,a=o.height,/^((?!chrome|android).)*safari/i.test(navigator.userAgent)||(s=o.offsetLeft,f=o.offsetTop)),{width:i,height:a,x:s+l(e),y:f}}(e)):n(r)?function(e){var t=f(e);return t.top=t.top+e.clientTop,t.left=t.left+e.clientLeft,t.bottom=t.top+e.clientHeight,t.right=t.left+e.clientWidth,t.width=e.clientWidth,t.height=e.clientHeight,t.x=t.left,t.y=t.top,t}(r):V(function(e){var t,n=u(e),r=c(e),o=null==(t=e.ownerDocument)?void 0:t.body,a=i(n.scrollWidth,n.clientWidth,o?o.scrollWidth:0,o?o.clientWidth:0),s=i(n.scrollHeight,n.clientHeight,o?o.scrollHeight:0,o?o.clientHeight:0),f=-r.scrollLeft+l(e),p=-r.scrollTop;return"rtl"===d(o||n).direction&&(f+=i(n.clientWidth,o?o.clientWidth:0)-a),{width:a,height:s,x:f,y:p}}(u(e)))}function I(e,t,o){var s="clippingParents"===t?function(e){var t=b(g(e)),o=["absolute","fixed"].indexOf(d(e).position)>=0&&r(e)?O(e):e;return n(o)?t.filter((function(e){return n(e)&&q(e,o)&&"body"!==p(e)})):[]}(e):[].concat(t),f=[].concat(s,[o]),c=f[0],u=f.reduce((function(t,n){var r=N(e,n);return t.top=i(r.top,t.top),t.right=a(r.right,t.right),t.bottom=a(r.bottom,t.bottom),t.left=i(r.left,t.left),t}),N(e,c));return u.width=u.right-u.left,u.height=u.bottom-u.top,u.x=u.left,u.y=u.top,u}function _(e){return e.split("-")[1]}function F(e){return["top","bottom"].indexOf(e)>=0?"x":"y"}function U(e){var t,n=e.reference,r=e.element,o=e.placement,i=o?C(o):null,a=o?_(o):null,s=n.x+n.width/2-r.width/2,f=n.y+n.height/2-r.height/2;switch(i){case j:t={x:s,y:n.y-r.height};break;case E:t={x:s,y:n.y+n.height};break;case D:t={x:n.x+n.width,y:f};break;case A:t={x:n.x-r.width,y:f};break;default:t={x:n.x,y:n.y}}var c=i?F(i):null;if(null!=c){var p="y"===c?"height":"width";switch(a){case M:t[c]=t[c]-(n[p]/2-r[p]/2);break;case k:t[c]=t[c]+(n[p]/2-r[p]/2)}}return t}function z(e){return Object.assign({},{top:0,right:0,bottom:0,left:0},e)}function X(e,t){return t.reduce((function(t,n){return t[n]=e,t}),{})}function Y(e,t){void 0===t&&(t={});var r=t,o=r.placement,i=void 0===o?e.placement:o,a=r.boundary,s=void 0===a?"clippingParents":a,c=r.rootBoundary,p=void 0===c?W:c,l=r.elementContext,d=void 0===l?B:l,h=r.altBoundary,m=void 0!==h&&h,v=r.padding,g=void 0===v?0:v,y=z("number"!=typeof g?g:X(g,P)),b=d===B?"reference":B,x=e.rects.popper,w=e.elements[m?b:d],O=I(n(w)?w:w.contextElement||u(e.elements.popper),s,p),A=f(e.elements.reference),L=U({reference:A,element:x,strategy:"absolute",placement:i}),M=V(Object.assign({},x,L)),k=d===B?M:A,H={top:O.top-k.top+y.top,bottom:k.bottom-O.bottom+y.bottom,left:O.left-k.left+y.left,right:k.right-O.right+y.right},T=e.modifiersData.offset;if(d===B&&T){var R=T[i];Object.keys(H).forEach((function(e){var t=[D,E].indexOf(e)>=0?1:-1,n=[j,E].indexOf(e)>=0?"y":"x";H[e]+=R[n]*t}))}return H}var G={placement:"bottom",modifiers:[],strategy:"absolute"};function J(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return!t.some((function(e){return!(e&&"function"==typeof e.getBoundingClientRect)}))}function K(e){void 0===e&&(e={});var t=e,r=t.defaultModifiers,o=void 0===r?[]:r,i=t.defaultOptions,a=void 0===i?G:i;return function(e,t,r){void 0===r&&(r=a);var i,s,f={placement:"bottom",orderedModifiers:[],options:Object.assign({},G,a),modifiersData:{},elements:{reference:e,popper:t},attributes:{},styles:{}},c=[],p=!1,u={state:f,setOptions:function(r){var i="function"==typeof r?r(f.options):r;l(),f.options=Object.assign({},a,f.options,i),f.scrollParents={reference:n(e)?b(e):e.contextElement?b(e.contextElement):[],popper:b(t)};var s,p,d=function(e){var t=S(e);return R.reduce((function(e,n){return e.concat(t.filter((function(e){return e.phase===n})))}),[])}((s=[].concat(o,f.options.modifiers),p=s.reduce((function(e,t){var n=e[t.name];return e[t.name]=n?Object.assign({},n,t,{options:Object.assign({},n.options,t.options),data:Object.assign({},n.data,t.data)}):t,e}),{}),Object.keys(p).map((function(e){return p[e]}))));return f.orderedModifiers=d.filter((function(e){return e.enabled})),f.orderedModifiers.forEach((function(e){var t=e.name,n=e.options,r=void 0===n?{}:n,o=e.effect;if("function"==typeof o){var i=o({state:f,name:t,instance:u,options:r}),a=function(){};c.push(i||a)}})),u.update()},forceUpdate:function(){if(!p){var e=f.elements,t=e.reference,n=e.popper;if(J(t,n)){f.rects={reference:m(t,O(n),"fixed"===f.options.strategy),popper:v(n)},f.reset=!1,f.placement=f.options.placement,f.orderedModifiers.forEach((function(e){return f.modifiersData[e.name]=Object.assign({},e.data)}));for(var r=0;r<f.orderedModifiers.length;r++)if(!0!==f.reset){var o=f.orderedModifiers[r],i=o.fn,a=o.options,s=void 0===a?{}:a,c=o.name;"function"==typeof i&&(f=i({state:f,options:s,name:c,instance:u})||f)}else f.reset=!1,r=-1}}},update:(i=function(){return new Promise((function(e){u.forceUpdate(),e(f)}))},function(){return s||(s=new Promise((function(e){Promise.resolve().then((function(){s=void 0,e(i())}))}))),s}),destroy:function(){l(),p=!0}};if(!J(e,t))return u;function l(){c.forEach((function(e){return e()})),c=[]}return u.setOptions(r).then((function(e){!p&&r.onFirstUpdate&&r.onFirstUpdate(e)})),u}}var Q={passive:!0};var Z={name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:function(e){var n=e.state,r=e.instance,o=e.options,i=o.scroll,a=void 0===i||i,s=o.resize,f=void 0===s||s,c=t(n.elements.popper),p=[].concat(n.scrollParents.reference,n.scrollParents.popper);return a&&p.forEach((function(e){e.addEventListener("scroll",r.update,Q)})),f&&c.addEventListener("resize",r.update,Q),function(){a&&p.forEach((function(e){e.removeEventListener("scroll",r.update,Q)})),f&&c.removeEventListener("resize",r.update,Q)}},data:{}};var $={name:"popperOffsets",enabled:!0,phase:"read",fn:function(e){var t=e.state,n=e.name;t.modifiersData[n]=U({reference:t.rects.reference,element:t.rects.popper,strategy:"absolute",placement:t.placement})},data:{}},ee={top:"auto",right:"auto",bottom:"auto",left:"auto"};function te(e){var n,r=e.popper,o=e.popperRect,i=e.placement,a=e.variation,f=e.offsets,c=e.position,p=e.gpuAcceleration,l=e.adaptive,h=e.roundOffsets,m=e.isFixed,v=f.x,g=void 0===v?0:v,y=f.y,b=void 0===y?0:y,x="function"==typeof h?h({x:g,y:b}):{x:g,y:b};g=x.x,b=x.y;var w=f.hasOwnProperty("x"),L=f.hasOwnProperty("y"),P=A,M=j,W=window;if(l){var B=O(r),H="clientHeight",T="clientWidth";if(B===t(r)&&"static"!==d(B=u(r)).position&&"absolute"===c&&(H="scrollHeight",T="scrollWidth"),B=B,i===j||(i===A||i===D)&&a===k)M=E,b-=(m&&W.visualViewport?W.visualViewport.height:B[H])-o.height,b*=p?1:-1;if(i===A||(i===j||i===E)&&a===k)P=D,g-=(m&&W.visualViewport?W.visualViewport.width:B[T])-o.width,g*=p?1:-1}var R,S=Object.assign({position:c},l&&ee),C=!0===h?function(e){var t=e.x,n=e.y,r=window.devicePixelRatio||1;return{x:s(t*r)/r||0,y:s(n*r)/r||0}}({x:g,y:b}):{x:g,y:b};return g=C.x,b=C.y,p?Object.assign({},S,((R={})[M]=L?"0":"",R[P]=w?"0":"",R.transform=(W.devicePixelRatio||1)<=1?"translate("+g+"px, "+b+"px)":"translate3d("+g+"px, "+b+"px, 0)",R)):Object.assign({},S,((n={})[M]=L?b+"px":"",n[P]=w?g+"px":"",n.transform="",n))}var ne={name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:function(e){var t=e.state,n=e.options,r=n.gpuAcceleration,o=void 0===r||r,i=n.adaptive,a=void 0===i||i,s=n.roundOffsets,f=void 0===s||s,c={placement:C(t.placement),variation:_(t.placement),popper:t.elements.popper,popperRect:t.rects.popper,gpuAcceleration:o,isFixed:"fixed"===t.options.strategy};null!=t.modifiersData.popperOffsets&&(t.styles.popper=Object.assign({},t.styles.popper,te(Object.assign({},c,{offsets:t.modifiersData.popperOffsets,position:t.options.strategy,adaptive:a,roundOffsets:f})))),null!=t.modifiersData.arrow&&(t.styles.arrow=Object.assign({},t.styles.arrow,te(Object.assign({},c,{offsets:t.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:f})))),t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-placement":t.placement})},data:{}};var re={name:"applyStyles",enabled:!0,phase:"write",fn:function(e){var t=e.state;Object.keys(t.elements).forEach((function(e){var n=t.styles[e]||{},o=t.attributes[e]||{},i=t.elements[e];r(i)&&p(i)&&(Object.assign(i.style,n),Object.keys(o).forEach((function(e){var t=o[e];!1===t?i.removeAttribute(e):i.setAttribute(e,!0===t?"":t)})))}))},effect:function(e){var t=e.state,n={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(t.elements.popper.style,n.popper),t.styles=n,t.elements.arrow&&Object.assign(t.elements.arrow.style,n.arrow),function(){Object.keys(t.elements).forEach((function(e){var o=t.elements[e],i=t.attributes[e]||{},a=Object.keys(t.styles.hasOwnProperty(e)?t.styles[e]:n[e]).reduce((function(e,t){return e[t]="",e}),{});r(o)&&p(o)&&(Object.assign(o.style,a),Object.keys(i).forEach((function(e){o.removeAttribute(e)})))}))}},requires:["computeStyles"]};var oe={name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:function(e){var t=e.state,n=e.options,r=e.name,o=n.offset,i=void 0===o?[0,0]:o,a=T.reduce((function(e,n){return e[n]=function(e,t,n){var r=C(e),o=[A,j].indexOf(r)>=0?-1:1,i="function"==typeof n?n(Object.assign({},t,{placement:e})):n,a=i[0],s=i[1];return a=a||0,s=(s||0)*o,[A,D].indexOf(r)>=0?{x:s,y:a}:{x:a,y:s}}(n,t.rects,i),e}),{}),s=a[t.placement],f=s.x,c=s.y;null!=t.modifiersData.popperOffsets&&(t.modifiersData.popperOffsets.x+=f,t.modifiersData.popperOffsets.y+=c),t.modifiersData[r]=a}},ie={left:"right",right:"left",bottom:"top",top:"bottom"};function ae(e){return e.replace(/left|right|bottom|top/g,(function(e){return ie[e]}))}var se={start:"end",end:"start"};function fe(e){return e.replace(/start|end/g,(function(e){return se[e]}))}function ce(e,t){void 0===t&&(t={});var n=t,r=n.placement,o=n.boundary,i=n.rootBoundary,a=n.padding,s=n.flipVariations,f=n.allowedAutoPlacements,c=void 0===f?T:f,p=_(r),u=p?s?H:H.filter((function(e){return _(e)===p})):P,l=u.filter((function(e){return c.indexOf(e)>=0}));0===l.length&&(l=u);var d=l.reduce((function(t,n){return t[n]=Y(e,{placement:n,boundary:o,rootBoundary:i,padding:a})[C(n)],t}),{});return Object.keys(d).sort((function(e,t){return d[e]-d[t]}))}var pe={name:"flip",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,r=e.name;if(!t.modifiersData[r]._skip){for(var o=n.mainAxis,i=void 0===o||o,a=n.altAxis,s=void 0===a||a,f=n.fallbackPlacements,c=n.padding,p=n.boundary,u=n.rootBoundary,l=n.altBoundary,d=n.flipVariations,h=void 0===d||d,m=n.allowedAutoPlacements,v=t.options.placement,g=C(v),y=f||(g===v||!h?[ae(v)]:function(e){if(C(e)===L)return[];var t=ae(e);return[fe(e),t,fe(t)]}(v)),b=[v].concat(y).reduce((function(e,n){return e.concat(C(n)===L?ce(t,{placement:n,boundary:p,rootBoundary:u,padding:c,flipVariations:h,allowedAutoPlacements:m}):n)}),[]),x=t.rects.reference,w=t.rects.popper,O=new Map,P=!0,k=b[0],W=0;W<b.length;W++){var B=b[W],H=C(B),T=_(B)===M,R=[j,E].indexOf(H)>=0,S=R?"width":"height",q=Y(t,{placement:B,boundary:p,rootBoundary:u,altBoundary:l,padding:c}),V=R?T?D:A:T?E:j;x[S]>w[S]&&(V=ae(V));var N=ae(V),I=[];if(i&&I.push(q[H]<=0),s&&I.push(q[V]<=0,q[N]<=0),I.every((function(e){return e}))){k=B,P=!1;break}O.set(B,I)}if(P)for(var F=function(e){var t=b.find((function(t){var n=O.get(t);if(n)return n.slice(0,e).every((function(e){return e}))}));if(t)return k=t,"break"},U=h?3:1;U>0;U--){if("break"===F(U))break}t.placement!==k&&(t.modifiersData[r]._skip=!0,t.placement=k,t.reset=!0)}},requiresIfExists:["offset"],data:{_skip:!1}};function ue(e,t,n){return i(e,a(t,n))}var le={name:"preventOverflow",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,r=e.name,o=n.mainAxis,s=void 0===o||o,f=n.altAxis,c=void 0!==f&&f,p=n.boundary,u=n.rootBoundary,l=n.altBoundary,d=n.padding,h=n.tether,m=void 0===h||h,g=n.tetherOffset,y=void 0===g?0:g,b=Y(t,{boundary:p,rootBoundary:u,padding:d,altBoundary:l}),x=C(t.placement),w=_(t.placement),L=!w,P=F(x),k="x"===P?"y":"x",W=t.modifiersData.popperOffsets,B=t.rects.reference,H=t.rects.popper,T="function"==typeof y?y(Object.assign({},t.rects,{placement:t.placement})):y,R="number"==typeof T?{mainAxis:T,altAxis:T}:Object.assign({mainAxis:0,altAxis:0},T),S=t.modifiersData.offset?t.modifiersData.offset[t.placement]:null,q={x:0,y:0};if(W){if(s){var V,N="y"===P?j:A,I="y"===P?E:D,U="y"===P?"height":"width",z=W[P],X=z+b[N],G=z-b[I],J=m?-H[U]/2:0,K=w===M?B[U]:H[U],Q=w===M?-H[U]:-B[U],Z=t.elements.arrow,$=m&&Z?v(Z):{width:0,height:0},ee=t.modifiersData["arrow#persistent"]?t.modifiersData["arrow#persistent"].padding:{top:0,right:0,bottom:0,left:0},te=ee[N],ne=ee[I],re=ue(0,B[U],$[U]),oe=L?B[U]/2-J-re-te-R.mainAxis:K-re-te-R.mainAxis,ie=L?-B[U]/2+J+re+ne+R.mainAxis:Q+re+ne+R.mainAxis,ae=t.elements.arrow&&O(t.elements.arrow),se=ae?"y"===P?ae.clientTop||0:ae.clientLeft||0:0,fe=null!=(V=null==S?void 0:S[P])?V:0,ce=z+ie-fe,pe=ue(m?a(X,z+oe-fe-se):X,z,m?i(G,ce):G);W[P]=pe,q[P]=pe-z}if(c){var le,de="x"===P?j:A,he="x"===P?E:D,me=W[k],ve="y"===k?"height":"width",ge=me+b[de],ye=me-b[he],be=-1!==[j,A].indexOf(x),xe=null!=(le=null==S?void 0:S[k])?le:0,we=be?ge:me-B[ve]-H[ve]-xe+R.altAxis,Oe=be?me+B[ve]+H[ve]-xe-R.altAxis:ye,je=m&&be?function(e,t,n){var r=ue(e,t,n);return r>n?n:r}(we,me,Oe):ue(m?we:ge,me,m?Oe:ye);W[k]=je,q[k]=je-me}t.modifiersData[r]=q}},requiresIfExists:["offset"]};var de={name:"arrow",enabled:!0,phase:"main",fn:function(e){var t,n=e.state,r=e.name,o=e.options,i=n.elements.arrow,a=n.modifiersData.popperOffsets,s=C(n.placement),f=F(s),c=[A,D].indexOf(s)>=0?"height":"width";if(i&&a){var p=function(e,t){return z("number"!=typeof(e="function"==typeof e?e(Object.assign({},t.rects,{placement:t.placement})):e)?e:X(e,P))}(o.padding,n),u=v(i),l="y"===f?j:A,d="y"===f?E:D,h=n.rects.reference[c]+n.rects.reference[f]-a[f]-n.rects.popper[c],m=a[f]-n.rects.reference[f],g=O(i),y=g?"y"===f?g.clientHeight||0:g.clientWidth||0:0,b=h/2-m/2,x=p[l],w=y-u[c]-p[d],L=y/2-u[c]/2+b,M=ue(x,L,w),k=f;n.modifiersData[r]=((t={})[k]=M,t.centerOffset=M-L,t)}},effect:function(e){var t=e.state,n=e.options.element,r=void 0===n?"[data-popper-arrow]":n;null!=r&&("string"!=typeof r||(r=t.elements.popper.querySelector(r)))&&q(t.elements.popper,r)&&(t.elements.arrow=r)},requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};function he(e,t,n){return void 0===n&&(n={x:0,y:0}),{top:e.top-t.height-n.y,right:e.right-t.width+n.x,bottom:e.bottom-t.height+n.y,left:e.left-t.width-n.x}}function me(e){return[j,D,E,A].some((function(t){return e[t]>=0}))}var ve={name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:function(e){var t=e.state,n=e.name,r=t.rects.reference,o=t.rects.popper,i=t.modifiersData.preventOverflow,a=Y(t,{elementContext:"reference"}),s=Y(t,{altBoundary:!0}),f=he(a,r),c=he(s,o,i),p=me(f),u=me(c);t.modifiersData[n]={referenceClippingOffsets:f,popperEscapeOffsets:c,isReferenceHidden:p,hasPopperEscaped:u},t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-reference-hidden":p,"data-popper-escaped":u})}},ge=K({defaultModifiers:[Z,$,ne,re]}),ye=[Z,$,ne,re,oe,pe,le,de,ve],be=K({defaultModifiers:ye});e.applyStyles=re,e.arrow=de,e.computeStyles=ne,e.createPopper=be,e.createPopperLite=ge,e.defaultModifiers=ye,e.detectOverflow=Y,e.eventListeners=Z,e.flip=pe,e.hide=ve,e.offset=oe,e.popperGenerator=K,e.popperOffsets=$,e.preventOverflow=le,Object.defineProperty(e,"__esModule",{value:!0})}));
//# sourceMappingURL=popper.min.js.map

/*!
  * Bootstrap v4.6.1 (https://getbootstrap.com/)
  * Copyright 2011-2021 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('jquery')) :
  typeof define === 'function' && define.amd ? define(['exports', 'jquery'], factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.bootstrap = {}, global.jQuery));
})(this, (function (exports, $) { 'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var $__default = /*#__PURE__*/_interopDefaultLegacy($);

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  function _extends$1() {
    _extends$1 = Object.assign || function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i];

        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }

      return target;
    };

    return _extends$1.apply(this, arguments);
  }

  function _inheritsLoose(subClass, superClass) {
    subClass.prototype = Object.create(superClass.prototype);
    subClass.prototype.constructor = subClass;

    _setPrototypeOf(subClass, superClass);
  }

  function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
      o.__proto__ = p;
      return o;
    };

    return _setPrototypeOf(o, p);
  }

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.6.1): util.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */
  /**
   * Private TransitionEnd Helpers
   */

  var TRANSITION_END = 'transitionend';
  var MAX_UID = 1000000;
  var MILLISECONDS_MULTIPLIER = 1000; // Shoutout AngusCroll (https://goo.gl/pxwQGp)

  function toType(obj) {
    if (obj === null || typeof obj === 'undefined') {
      return "" + obj;
    }

    return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase();
  }

  function getSpecialTransitionEndEvent() {
    return {
      bindType: TRANSITION_END,
      delegateType: TRANSITION_END,
      handle: function handle(event) {
        if ($__default["default"](event.target).is(this)) {
          return event.handleObj.handler.apply(this, arguments); // eslint-disable-line prefer-rest-params
        }

        return undefined;
      }
    };
  }

  function transitionEndEmulator(duration) {
    var _this = this;

    var called = false;
    $__default["default"](this).one(Util.TRANSITION_END, function () {
      called = true;
    });
    setTimeout(function () {
      if (!called) {
        Util.triggerTransitionEnd(_this);
      }
    }, duration);
    return this;
  }

  function setTransitionEndSupport() {
    $__default["default"].fn.emulateTransitionEnd = transitionEndEmulator;
    $__default["default"].event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent();
  }
  /**
   * Public Util API
   */


  var Util = {
    TRANSITION_END: 'bsTransitionEnd',
    getUID: function getUID(prefix) {
      do {
        // eslint-disable-next-line no-bitwise
        prefix += ~~(Math.random() * MAX_UID); // "~~" acts like a faster Math.floor() here
      } while (document.getElementById(prefix));

      return prefix;
    },
    getSelectorFromElement: function getSelectorFromElement(element) {
      var selector = element.getAttribute('data-target');

      if (!selector || selector === '#') {
        var hrefAttr = element.getAttribute('href');
        selector = hrefAttr && hrefAttr !== '#' ? hrefAttr.trim() : '';
      }

      try {
        return document.querySelector(selector) ? selector : null;
      } catch (_) {
        return null;
      }
    },
    getTransitionDurationFromElement: function getTransitionDurationFromElement(element) {
      if (!element) {
        return 0;
      } // Get transition-duration of the element


      var transitionDuration = $__default["default"](element).css('transition-duration');
      var transitionDelay = $__default["default"](element).css('transition-delay');
      var floatTransitionDuration = parseFloat(transitionDuration);
      var floatTransitionDelay = parseFloat(transitionDelay); // Return 0 if element or transition duration is not found

      if (!floatTransitionDuration && !floatTransitionDelay) {
        return 0;
      } // If multiple durations are defined, take the first


      transitionDuration = transitionDuration.split(',')[0];
      transitionDelay = transitionDelay.split(',')[0];
      return (parseFloat(transitionDuration) + parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER;
    },
    reflow: function reflow(element) {
      return element.offsetHeight;
    },
    triggerTransitionEnd: function triggerTransitionEnd(element) {
      $__default["default"](element).trigger(TRANSITION_END);
    },
    supportsTransitionEnd: function supportsTransitionEnd() {
      return Boolean(TRANSITION_END);
    },
    isElement: function isElement(obj) {
      return (obj[0] || obj).nodeType;
    },
    typeCheckConfig: function typeCheckConfig(componentName, config, configTypes) {
      for (var property in configTypes) {
        if (Object.prototype.hasOwnProperty.call(configTypes, property)) {
          var expectedTypes = configTypes[property];
          var value = config[property];
          var valueType = value && Util.isElement(value) ? 'element' : toType(value);

          if (!new RegExp(expectedTypes).test(valueType)) {
            throw new Error(componentName.toUpperCase() + ": " + ("Option \"" + property + "\" provided type \"" + valueType + "\" ") + ("but expected type \"" + expectedTypes + "\"."));
          }
        }
      }
    },
    findShadowRoot: function findShadowRoot(element) {
      if (!document.documentElement.attachShadow) {
        return null;
      } // Can find the shadow root otherwise it'll return the document


      if (typeof element.getRootNode === 'function') {
        var root = element.getRootNode();
        return root instanceof ShadowRoot ? root : null;
      }

      if (element instanceof ShadowRoot) {
        return element;
      } // when we don't find a shadow root


      if (!element.parentNode) {
        return null;
      }

      return Util.findShadowRoot(element.parentNode);
    },
    jQueryDetection: function jQueryDetection() {
      if (typeof $__default["default"] === 'undefined') {
        throw new TypeError('Bootstrap\'s JavaScript requires jQuery. jQuery must be included before Bootstrap\'s JavaScript.');
      }

      var version = $__default["default"].fn.jquery.split(' ')[0].split('.');
      var minMajor = 1;
      var ltMajor = 2;
      var minMinor = 9;
      var minPatch = 1;
      var maxMajor = 4;

      if (version[0] < ltMajor && version[1] < minMinor || version[0] === minMajor && version[1] === minMinor && version[2] < minPatch || version[0] >= maxMajor) {
        throw new Error('Bootstrap\'s JavaScript requires at least jQuery v1.9.1 but less than v4.0.0');
      }
    }
  };
  Util.jQueryDetection();
  setTransitionEndSupport();

  /**
   * Constants
   */

  var NAME$a = 'alert';
  var VERSION$a = '4.6.1';
  var DATA_KEY$a = 'bs.alert';
  var EVENT_KEY$a = "." + DATA_KEY$a;
  var DATA_API_KEY$7 = '.data-api';
  var JQUERY_NO_CONFLICT$a = $__default["default"].fn[NAME$a];
  var CLASS_NAME_ALERT = 'alert';
  var CLASS_NAME_FADE$5 = 'fade';
  var CLASS_NAME_SHOW$7 = 'show';
  var EVENT_CLOSE = "close" + EVENT_KEY$a;
  var EVENT_CLOSED = "closed" + EVENT_KEY$a;
  var EVENT_CLICK_DATA_API$6 = "click" + EVENT_KEY$a + DATA_API_KEY$7;
  var SELECTOR_DISMISS = '[data-dismiss="alert"]';
  /**
   * Class definition
   */

  var Alert = /*#__PURE__*/function () {
    function Alert(element) {
      this._element = element;
    } // Getters


    var _proto = Alert.prototype;

    // Public
    _proto.close = function close(element) {
      var rootElement = this._element;

      if (element) {
        rootElement = this._getRootElement(element);
      }

      var customEvent = this._triggerCloseEvent(rootElement);

      if (customEvent.isDefaultPrevented()) {
        return;
      }

      this._removeElement(rootElement);
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$a);
      this._element = null;
    } // Private
    ;

    _proto._getRootElement = function _getRootElement(element) {
      var selector = Util.getSelectorFromElement(element);
      var parent = false;

      if (selector) {
        parent = document.querySelector(selector);
      }

      if (!parent) {
        parent = $__default["default"](element).closest("." + CLASS_NAME_ALERT)[0];
      }

      return parent;
    };

    _proto._triggerCloseEvent = function _triggerCloseEvent(element) {
      var closeEvent = $__default["default"].Event(EVENT_CLOSE);
      $__default["default"](element).trigger(closeEvent);
      return closeEvent;
    };

    _proto._removeElement = function _removeElement(element) {
      var _this = this;

      $__default["default"](element).removeClass(CLASS_NAME_SHOW$7);

      if (!$__default["default"](element).hasClass(CLASS_NAME_FADE$5)) {
        this._destroyElement(element);

        return;
      }

      var transitionDuration = Util.getTransitionDurationFromElement(element);
      $__default["default"](element).one(Util.TRANSITION_END, function (event) {
        return _this._destroyElement(element, event);
      }).emulateTransitionEnd(transitionDuration);
    };

    _proto._destroyElement = function _destroyElement(element) {
      $__default["default"](element).detach().trigger(EVENT_CLOSED).remove();
    } // Static
    ;

    Alert._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var $element = $__default["default"](this);
        var data = $element.data(DATA_KEY$a);

        if (!data) {
          data = new Alert(this);
          $element.data(DATA_KEY$a, data);
        }

        if (config === 'close') {
          data[config](this);
        }
      });
    };

    Alert._handleDismiss = function _handleDismiss(alertInstance) {
      return function (event) {
        if (event) {
          event.preventDefault();
        }

        alertInstance.close(this);
      };
    };

    _createClass(Alert, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$a;
      }
    }]);

    return Alert;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API$6, SELECTOR_DISMISS, Alert._handleDismiss(new Alert()));
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$a] = Alert._jQueryInterface;
  $__default["default"].fn[NAME$a].Constructor = Alert;

  $__default["default"].fn[NAME$a].noConflict = function () {
    $__default["default"].fn[NAME$a] = JQUERY_NO_CONFLICT$a;
    return Alert._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$9 = 'button';
  var VERSION$9 = '4.6.1';
  var DATA_KEY$9 = 'bs.button';
  var EVENT_KEY$9 = "." + DATA_KEY$9;
  var DATA_API_KEY$6 = '.data-api';
  var JQUERY_NO_CONFLICT$9 = $__default["default"].fn[NAME$9];
  var CLASS_NAME_ACTIVE$3 = 'active';
  var CLASS_NAME_BUTTON = 'btn';
  var CLASS_NAME_FOCUS = 'focus';
  var EVENT_CLICK_DATA_API$5 = "click" + EVENT_KEY$9 + DATA_API_KEY$6;
  var EVENT_FOCUS_BLUR_DATA_API = "focus" + EVENT_KEY$9 + DATA_API_KEY$6 + " " + ("blur" + EVENT_KEY$9 + DATA_API_KEY$6);
  var EVENT_LOAD_DATA_API$2 = "load" + EVENT_KEY$9 + DATA_API_KEY$6;
  var SELECTOR_DATA_TOGGLE_CARROT = '[data-toggle^="button"]';
  var SELECTOR_DATA_TOGGLES = '[data-toggle="buttons"]';
  var SELECTOR_DATA_TOGGLE$4 = '[data-toggle="button"]';
  var SELECTOR_DATA_TOGGLES_BUTTONS = '[data-toggle="buttons"] .btn';
  var SELECTOR_INPUT = 'input:not([type="hidden"])';
  var SELECTOR_ACTIVE$2 = '.active';
  var SELECTOR_BUTTON = '.btn';
  /**
   * Class definition
   */

  var Button = /*#__PURE__*/function () {
    function Button(element) {
      this._element = element;
      this.shouldAvoidTriggerChange = false;
    } // Getters


    var _proto = Button.prototype;

    // Public
    _proto.toggle = function toggle() {
      var triggerChangeEvent = true;
      var addAriaPressed = true;
      var rootElement = $__default["default"](this._element).closest(SELECTOR_DATA_TOGGLES)[0];

      if (rootElement) {
        var input = this._element.querySelector(SELECTOR_INPUT);

        if (input) {
          if (input.type === 'radio') {
            if (input.checked && this._element.classList.contains(CLASS_NAME_ACTIVE$3)) {
              triggerChangeEvent = false;
            } else {
              var activeElement = rootElement.querySelector(SELECTOR_ACTIVE$2);

              if (activeElement) {
                $__default["default"](activeElement).removeClass(CLASS_NAME_ACTIVE$3);
              }
            }
          }

          if (triggerChangeEvent) {
            // if it's not a radio button or checkbox don't add a pointless/invalid checked property to the input
            if (input.type === 'checkbox' || input.type === 'radio') {
              input.checked = !this._element.classList.contains(CLASS_NAME_ACTIVE$3);
            }

            if (!this.shouldAvoidTriggerChange) {
              $__default["default"](input).trigger('change');
            }
          }

          input.focus();
          addAriaPressed = false;
        }
      }

      if (!(this._element.hasAttribute('disabled') || this._element.classList.contains('disabled'))) {
        if (addAriaPressed) {
          this._element.setAttribute('aria-pressed', !this._element.classList.contains(CLASS_NAME_ACTIVE$3));
        }

        if (triggerChangeEvent) {
          $__default["default"](this._element).toggleClass(CLASS_NAME_ACTIVE$3);
        }
      }
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$9);
      this._element = null;
    } // Static
    ;

    Button._jQueryInterface = function _jQueryInterface(config, avoidTriggerChange) {
      return this.each(function () {
        var $element = $__default["default"](this);
        var data = $element.data(DATA_KEY$9);

        if (!data) {
          data = new Button(this);
          $element.data(DATA_KEY$9, data);
        }

        data.shouldAvoidTriggerChange = avoidTriggerChange;

        if (config === 'toggle') {
          data[config]();
        }
      });
    };

    _createClass(Button, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$9;
      }
    }]);

    return Button;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API$5, SELECTOR_DATA_TOGGLE_CARROT, function (event) {
    var button = event.target;
    var initialButton = button;

    if (!$__default["default"](button).hasClass(CLASS_NAME_BUTTON)) {
      button = $__default["default"](button).closest(SELECTOR_BUTTON)[0];
    }

    if (!button || button.hasAttribute('disabled') || button.classList.contains('disabled')) {
      event.preventDefault(); // work around Firefox bug #1540995
    } else {
      var inputBtn = button.querySelector(SELECTOR_INPUT);

      if (inputBtn && (inputBtn.hasAttribute('disabled') || inputBtn.classList.contains('disabled'))) {
        event.preventDefault(); // work around Firefox bug #1540995

        return;
      }

      if (initialButton.tagName === 'INPUT' || button.tagName !== 'LABEL') {
        Button._jQueryInterface.call($__default["default"](button), 'toggle', initialButton.tagName === 'INPUT');
      }
    }
  }).on(EVENT_FOCUS_BLUR_DATA_API, SELECTOR_DATA_TOGGLE_CARROT, function (event) {
    var button = $__default["default"](event.target).closest(SELECTOR_BUTTON)[0];
    $__default["default"](button).toggleClass(CLASS_NAME_FOCUS, /^focus(in)?$/.test(event.type));
  });
  $__default["default"](window).on(EVENT_LOAD_DATA_API$2, function () {
    // ensure correct active class is set to match the controls' actual values/states
    // find all checkboxes/readio buttons inside data-toggle groups
    var buttons = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLES_BUTTONS));

    for (var i = 0, len = buttons.length; i < len; i++) {
      var button = buttons[i];
      var input = button.querySelector(SELECTOR_INPUT);

      if (input.checked || input.hasAttribute('checked')) {
        button.classList.add(CLASS_NAME_ACTIVE$3);
      } else {
        button.classList.remove(CLASS_NAME_ACTIVE$3);
      }
    } // find all button toggles


    buttons = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLE$4));

    for (var _i = 0, _len = buttons.length; _i < _len; _i++) {
      var _button = buttons[_i];

      if (_button.getAttribute('aria-pressed') === 'true') {
        _button.classList.add(CLASS_NAME_ACTIVE$3);
      } else {
        _button.classList.remove(CLASS_NAME_ACTIVE$3);
      }
    }
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$9] = Button._jQueryInterface;
  $__default["default"].fn[NAME$9].Constructor = Button;

  $__default["default"].fn[NAME$9].noConflict = function () {
    $__default["default"].fn[NAME$9] = JQUERY_NO_CONFLICT$9;
    return Button._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$8 = 'carousel';
  var VERSION$8 = '4.6.1';
  var DATA_KEY$8 = 'bs.carousel';
  var EVENT_KEY$8 = "." + DATA_KEY$8;
  var DATA_API_KEY$5 = '.data-api';
  var JQUERY_NO_CONFLICT$8 = $__default["default"].fn[NAME$8];
  var ARROW_LEFT_KEYCODE = 37; // KeyboardEvent.which value for left arrow key

  var ARROW_RIGHT_KEYCODE = 39; // KeyboardEvent.which value for right arrow key

  var TOUCHEVENT_COMPAT_WAIT = 500; // Time for mouse compat events to fire after touch

  var SWIPE_THRESHOLD = 40;
  var CLASS_NAME_CAROUSEL = 'carousel';
  var CLASS_NAME_ACTIVE$2 = 'active';
  var CLASS_NAME_SLIDE = 'slide';
  var CLASS_NAME_RIGHT = 'carousel-item-right';
  var CLASS_NAME_LEFT = 'carousel-item-left';
  var CLASS_NAME_NEXT = 'carousel-item-next';
  var CLASS_NAME_PREV = 'carousel-item-prev';
  var CLASS_NAME_POINTER_EVENT = 'pointer-event';
  var DIRECTION_NEXT = 'next';
  var DIRECTION_PREV = 'prev';
  var DIRECTION_LEFT = 'left';
  var DIRECTION_RIGHT = 'right';
  var EVENT_SLIDE = "slide" + EVENT_KEY$8;
  var EVENT_SLID = "slid" + EVENT_KEY$8;
  var EVENT_KEYDOWN = "keydown" + EVENT_KEY$8;
  var EVENT_MOUSEENTER = "mouseenter" + EVENT_KEY$8;
  var EVENT_MOUSELEAVE = "mouseleave" + EVENT_KEY$8;
  var EVENT_TOUCHSTART = "touchstart" + EVENT_KEY$8;
  var EVENT_TOUCHMOVE = "touchmove" + EVENT_KEY$8;
  var EVENT_TOUCHEND = "touchend" + EVENT_KEY$8;
  var EVENT_POINTERDOWN = "pointerdown" + EVENT_KEY$8;
  var EVENT_POINTERUP = "pointerup" + EVENT_KEY$8;
  var EVENT_DRAG_START = "dragstart" + EVENT_KEY$8;
  var EVENT_LOAD_DATA_API$1 = "load" + EVENT_KEY$8 + DATA_API_KEY$5;
  var EVENT_CLICK_DATA_API$4 = "click" + EVENT_KEY$8 + DATA_API_KEY$5;
  var SELECTOR_ACTIVE$1 = '.active';
  var SELECTOR_ACTIVE_ITEM = '.active.carousel-item';
  var SELECTOR_ITEM = '.carousel-item';
  var SELECTOR_ITEM_IMG = '.carousel-item img';
  var SELECTOR_NEXT_PREV = '.carousel-item-next, .carousel-item-prev';
  var SELECTOR_INDICATORS = '.carousel-indicators';
  var SELECTOR_DATA_SLIDE = '[data-slide], [data-slide-to]';
  var SELECTOR_DATA_RIDE = '[data-ride="carousel"]';
  var Default$7 = {
    interval: 5000,
    keyboard: true,
    slide: false,
    pause: 'hover',
    wrap: true,
    touch: true
  };
  var DefaultType$7 = {
    interval: '(number|boolean)',
    keyboard: 'boolean',
    slide: '(boolean|string)',
    pause: '(string|boolean)',
    wrap: 'boolean',
    touch: 'boolean'
  };
  var PointerType = {
    TOUCH: 'touch',
    PEN: 'pen'
  };
  /**
   * Class definition
   */

  var Carousel = /*#__PURE__*/function () {
    function Carousel(element, config) {
      this._items = null;
      this._interval = null;
      this._activeElement = null;
      this._isPaused = false;
      this._isSliding = false;
      this.touchTimeout = null;
      this.touchStartX = 0;
      this.touchDeltaX = 0;
      this._config = this._getConfig(config);
      this._element = element;
      this._indicatorsElement = this._element.querySelector(SELECTOR_INDICATORS);
      this._touchSupported = 'ontouchstart' in document.documentElement || navigator.maxTouchPoints > 0;
      this._pointerEvent = Boolean(window.PointerEvent || window.MSPointerEvent);

      this._addEventListeners();
    } // Getters


    var _proto = Carousel.prototype;

    // Public
    _proto.next = function next() {
      if (!this._isSliding) {
        this._slide(DIRECTION_NEXT);
      }
    };

    _proto.nextWhenVisible = function nextWhenVisible() {
      var $element = $__default["default"](this._element); // Don't call next when the page isn't visible
      // or the carousel or its parent isn't visible

      if (!document.hidden && $element.is(':visible') && $element.css('visibility') !== 'hidden') {
        this.next();
      }
    };

    _proto.prev = function prev() {
      if (!this._isSliding) {
        this._slide(DIRECTION_PREV);
      }
    };

    _proto.pause = function pause(event) {
      if (!event) {
        this._isPaused = true;
      }

      if (this._element.querySelector(SELECTOR_NEXT_PREV)) {
        Util.triggerTransitionEnd(this._element);
        this.cycle(true);
      }

      clearInterval(this._interval);
      this._interval = null;
    };

    _proto.cycle = function cycle(event) {
      if (!event) {
        this._isPaused = false;
      }

      if (this._interval) {
        clearInterval(this._interval);
        this._interval = null;
      }

      if (this._config.interval && !this._isPaused) {
        this._updateInterval();

        this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval);
      }
    };

    _proto.to = function to(index) {
      var _this = this;

      this._activeElement = this._element.querySelector(SELECTOR_ACTIVE_ITEM);

      var activeIndex = this._getItemIndex(this._activeElement);

      if (index > this._items.length - 1 || index < 0) {
        return;
      }

      if (this._isSliding) {
        $__default["default"](this._element).one(EVENT_SLID, function () {
          return _this.to(index);
        });
        return;
      }

      if (activeIndex === index) {
        this.pause();
        this.cycle();
        return;
      }

      var direction = index > activeIndex ? DIRECTION_NEXT : DIRECTION_PREV;

      this._slide(direction, this._items[index]);
    };

    _proto.dispose = function dispose() {
      $__default["default"](this._element).off(EVENT_KEY$8);
      $__default["default"].removeData(this._element, DATA_KEY$8);
      this._items = null;
      this._config = null;
      this._element = null;
      this._interval = null;
      this._isPaused = null;
      this._isSliding = null;
      this._activeElement = null;
      this._indicatorsElement = null;
    } // Private
    ;

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, Default$7, config);
      Util.typeCheckConfig(NAME$8, config, DefaultType$7);
      return config;
    };

    _proto._handleSwipe = function _handleSwipe() {
      var absDeltax = Math.abs(this.touchDeltaX);

      if (absDeltax <= SWIPE_THRESHOLD) {
        return;
      }

      var direction = absDeltax / this.touchDeltaX;
      this.touchDeltaX = 0; // swipe left

      if (direction > 0) {
        this.prev();
      } // swipe right


      if (direction < 0) {
        this.next();
      }
    };

    _proto._addEventListeners = function _addEventListeners() {
      var _this2 = this;

      if (this._config.keyboard) {
        $__default["default"](this._element).on(EVENT_KEYDOWN, function (event) {
          return _this2._keydown(event);
        });
      }

      if (this._config.pause === 'hover') {
        $__default["default"](this._element).on(EVENT_MOUSEENTER, function (event) {
          return _this2.pause(event);
        }).on(EVENT_MOUSELEAVE, function (event) {
          return _this2.cycle(event);
        });
      }

      if (this._config.touch) {
        this._addTouchEventListeners();
      }
    };

    _proto._addTouchEventListeners = function _addTouchEventListeners() {
      var _this3 = this;

      if (!this._touchSupported) {
        return;
      }

      var start = function start(event) {
        if (_this3._pointerEvent && PointerType[event.originalEvent.pointerType.toUpperCase()]) {
          _this3.touchStartX = event.originalEvent.clientX;
        } else if (!_this3._pointerEvent) {
          _this3.touchStartX = event.originalEvent.touches[0].clientX;
        }
      };

      var move = function move(event) {
        // ensure swiping with one touch and not pinching
        _this3.touchDeltaX = event.originalEvent.touches && event.originalEvent.touches.length > 1 ? 0 : event.originalEvent.touches[0].clientX - _this3.touchStartX;
      };

      var end = function end(event) {
        if (_this3._pointerEvent && PointerType[event.originalEvent.pointerType.toUpperCase()]) {
          _this3.touchDeltaX = event.originalEvent.clientX - _this3.touchStartX;
        }

        _this3._handleSwipe();

        if (_this3._config.pause === 'hover') {
          // If it's a touch-enabled device, mouseenter/leave are fired as
          // part of the mouse compatibility events on first tap - the carousel
          // would stop cycling until user tapped out of it;
          // here, we listen for touchend, explicitly pause the carousel
          // (as if it's the second time we tap on it, mouseenter compat event
          // is NOT fired) and after a timeout (to allow for mouse compatibility
          // events to fire) we explicitly restart cycling
          _this3.pause();

          if (_this3.touchTimeout) {
            clearTimeout(_this3.touchTimeout);
          }

          _this3.touchTimeout = setTimeout(function (event) {
            return _this3.cycle(event);
          }, TOUCHEVENT_COMPAT_WAIT + _this3._config.interval);
        }
      };

      $__default["default"](this._element.querySelectorAll(SELECTOR_ITEM_IMG)).on(EVENT_DRAG_START, function (e) {
        return e.preventDefault();
      });

      if (this._pointerEvent) {
        $__default["default"](this._element).on(EVENT_POINTERDOWN, function (event) {
          return start(event);
        });
        $__default["default"](this._element).on(EVENT_POINTERUP, function (event) {
          return end(event);
        });

        this._element.classList.add(CLASS_NAME_POINTER_EVENT);
      } else {
        $__default["default"](this._element).on(EVENT_TOUCHSTART, function (event) {
          return start(event);
        });
        $__default["default"](this._element).on(EVENT_TOUCHMOVE, function (event) {
          return move(event);
        });
        $__default["default"](this._element).on(EVENT_TOUCHEND, function (event) {
          return end(event);
        });
      }
    };

    _proto._keydown = function _keydown(event) {
      if (/input|textarea/i.test(event.target.tagName)) {
        return;
      }

      switch (event.which) {
        case ARROW_LEFT_KEYCODE:
          event.preventDefault();
          this.prev();
          break;

        case ARROW_RIGHT_KEYCODE:
          event.preventDefault();
          this.next();
          break;
      }
    };

    _proto._getItemIndex = function _getItemIndex(element) {
      this._items = element && element.parentNode ? [].slice.call(element.parentNode.querySelectorAll(SELECTOR_ITEM)) : [];
      return this._items.indexOf(element);
    };

    _proto._getItemByDirection = function _getItemByDirection(direction, activeElement) {
      var isNextDirection = direction === DIRECTION_NEXT;
      var isPrevDirection = direction === DIRECTION_PREV;

      var activeIndex = this._getItemIndex(activeElement);

      var lastItemIndex = this._items.length - 1;
      var isGoingToWrap = isPrevDirection && activeIndex === 0 || isNextDirection && activeIndex === lastItemIndex;

      if (isGoingToWrap && !this._config.wrap) {
        return activeElement;
      }

      var delta = direction === DIRECTION_PREV ? -1 : 1;
      var itemIndex = (activeIndex + delta) % this._items.length;
      return itemIndex === -1 ? this._items[this._items.length - 1] : this._items[itemIndex];
    };

    _proto._triggerSlideEvent = function _triggerSlideEvent(relatedTarget, eventDirectionName) {
      var targetIndex = this._getItemIndex(relatedTarget);

      var fromIndex = this._getItemIndex(this._element.querySelector(SELECTOR_ACTIVE_ITEM));

      var slideEvent = $__default["default"].Event(EVENT_SLIDE, {
        relatedTarget: relatedTarget,
        direction: eventDirectionName,
        from: fromIndex,
        to: targetIndex
      });
      $__default["default"](this._element).trigger(slideEvent);
      return slideEvent;
    };

    _proto._setActiveIndicatorElement = function _setActiveIndicatorElement(element) {
      if (this._indicatorsElement) {
        var indicators = [].slice.call(this._indicatorsElement.querySelectorAll(SELECTOR_ACTIVE$1));
        $__default["default"](indicators).removeClass(CLASS_NAME_ACTIVE$2);

        var nextIndicator = this._indicatorsElement.children[this._getItemIndex(element)];

        if (nextIndicator) {
          $__default["default"](nextIndicator).addClass(CLASS_NAME_ACTIVE$2);
        }
      }
    };

    _proto._updateInterval = function _updateInterval() {
      var element = this._activeElement || this._element.querySelector(SELECTOR_ACTIVE_ITEM);

      if (!element) {
        return;
      }

      var elementInterval = parseInt(element.getAttribute('data-interval'), 10);

      if (elementInterval) {
        this._config.defaultInterval = this._config.defaultInterval || this._config.interval;
        this._config.interval = elementInterval;
      } else {
        this._config.interval = this._config.defaultInterval || this._config.interval;
      }
    };

    _proto._slide = function _slide(direction, element) {
      var _this4 = this;

      var activeElement = this._element.querySelector(SELECTOR_ACTIVE_ITEM);

      var activeElementIndex = this._getItemIndex(activeElement);

      var nextElement = element || activeElement && this._getItemByDirection(direction, activeElement);

      var nextElementIndex = this._getItemIndex(nextElement);

      var isCycling = Boolean(this._interval);
      var directionalClassName;
      var orderClassName;
      var eventDirectionName;

      if (direction === DIRECTION_NEXT) {
        directionalClassName = CLASS_NAME_LEFT;
        orderClassName = CLASS_NAME_NEXT;
        eventDirectionName = DIRECTION_LEFT;
      } else {
        directionalClassName = CLASS_NAME_RIGHT;
        orderClassName = CLASS_NAME_PREV;
        eventDirectionName = DIRECTION_RIGHT;
      }

      if (nextElement && $__default["default"](nextElement).hasClass(CLASS_NAME_ACTIVE$2)) {
        this._isSliding = false;
        return;
      }

      var slideEvent = this._triggerSlideEvent(nextElement, eventDirectionName);

      if (slideEvent.isDefaultPrevented()) {
        return;
      }

      if (!activeElement || !nextElement) {
        // Some weirdness is happening, so we bail
        return;
      }

      this._isSliding = true;

      if (isCycling) {
        this.pause();
      }

      this._setActiveIndicatorElement(nextElement);

      this._activeElement = nextElement;
      var slidEvent = $__default["default"].Event(EVENT_SLID, {
        relatedTarget: nextElement,
        direction: eventDirectionName,
        from: activeElementIndex,
        to: nextElementIndex
      });

      if ($__default["default"](this._element).hasClass(CLASS_NAME_SLIDE)) {
        $__default["default"](nextElement).addClass(orderClassName);
        Util.reflow(nextElement);
        $__default["default"](activeElement).addClass(directionalClassName);
        $__default["default"](nextElement).addClass(directionalClassName);
        var transitionDuration = Util.getTransitionDurationFromElement(activeElement);
        $__default["default"](activeElement).one(Util.TRANSITION_END, function () {
          $__default["default"](nextElement).removeClass(directionalClassName + " " + orderClassName).addClass(CLASS_NAME_ACTIVE$2);
          $__default["default"](activeElement).removeClass(CLASS_NAME_ACTIVE$2 + " " + orderClassName + " " + directionalClassName);
          _this4._isSliding = false;
          setTimeout(function () {
            return $__default["default"](_this4._element).trigger(slidEvent);
          }, 0);
        }).emulateTransitionEnd(transitionDuration);
      } else {
        $__default["default"](activeElement).removeClass(CLASS_NAME_ACTIVE$2);
        $__default["default"](nextElement).addClass(CLASS_NAME_ACTIVE$2);
        this._isSliding = false;
        $__default["default"](this._element).trigger(slidEvent);
      }

      if (isCycling) {
        this.cycle();
      }
    } // Static
    ;

    Carousel._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var data = $__default["default"](this).data(DATA_KEY$8);

        var _config = _extends$1({}, Default$7, $__default["default"](this).data());

        if (typeof config === 'object') {
          _config = _extends$1({}, _config, config);
        }

        var action = typeof config === 'string' ? config : _config.slide;

        if (!data) {
          data = new Carousel(this, _config);
          $__default["default"](this).data(DATA_KEY$8, data);
        }

        if (typeof config === 'number') {
          data.to(config);
        } else if (typeof action === 'string') {
          if (typeof data[action] === 'undefined') {
            throw new TypeError("No method named \"" + action + "\"");
          }

          data[action]();
        } else if (_config.interval && _config.ride) {
          data.pause();
          data.cycle();
        }
      });
    };

    Carousel._dataApiClickHandler = function _dataApiClickHandler(event) {
      var selector = Util.getSelectorFromElement(this);

      if (!selector) {
        return;
      }

      var target = $__default["default"](selector)[0];

      if (!target || !$__default["default"](target).hasClass(CLASS_NAME_CAROUSEL)) {
        return;
      }

      var config = _extends$1({}, $__default["default"](target).data(), $__default["default"](this).data());

      var slideIndex = this.getAttribute('data-slide-to');

      if (slideIndex) {
        config.interval = false;
      }

      Carousel._jQueryInterface.call($__default["default"](target), config);

      if (slideIndex) {
        $__default["default"](target).data(DATA_KEY$8).to(slideIndex);
      }

      event.preventDefault();
    };

    _createClass(Carousel, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$8;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$7;
      }
    }]);

    return Carousel;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API$4, SELECTOR_DATA_SLIDE, Carousel._dataApiClickHandler);
  $__default["default"](window).on(EVENT_LOAD_DATA_API$1, function () {
    var carousels = [].slice.call(document.querySelectorAll(SELECTOR_DATA_RIDE));

    for (var i = 0, len = carousels.length; i < len; i++) {
      var $carousel = $__default["default"](carousels[i]);

      Carousel._jQueryInterface.call($carousel, $carousel.data());
    }
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$8] = Carousel._jQueryInterface;
  $__default["default"].fn[NAME$8].Constructor = Carousel;

  $__default["default"].fn[NAME$8].noConflict = function () {
    $__default["default"].fn[NAME$8] = JQUERY_NO_CONFLICT$8;
    return Carousel._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$7 = 'collapse';
  var VERSION$7 = '4.6.1';
  var DATA_KEY$7 = 'bs.collapse';
  var EVENT_KEY$7 = "." + DATA_KEY$7;
  var DATA_API_KEY$4 = '.data-api';
  var JQUERY_NO_CONFLICT$7 = $__default["default"].fn[NAME$7];
  var CLASS_NAME_SHOW$6 = 'show';
  var CLASS_NAME_COLLAPSE = 'collapse';
  var CLASS_NAME_COLLAPSING = 'collapsing';
  var CLASS_NAME_COLLAPSED = 'collapsed';
  var DIMENSION_WIDTH = 'width';
  var DIMENSION_HEIGHT = 'height';
  var EVENT_SHOW$4 = "show" + EVENT_KEY$7;
  var EVENT_SHOWN$4 = "shown" + EVENT_KEY$7;
  var EVENT_HIDE$4 = "hide" + EVENT_KEY$7;
  var EVENT_HIDDEN$4 = "hidden" + EVENT_KEY$7;
  var EVENT_CLICK_DATA_API$3 = "click" + EVENT_KEY$7 + DATA_API_KEY$4;
  var SELECTOR_ACTIVES = '.show, .collapsing';
  var SELECTOR_DATA_TOGGLE$3 = '[data-toggle="collapse"]';
  var Default$6 = {
    toggle: true,
    parent: ''
  };
  var DefaultType$6 = {
    toggle: 'boolean',
    parent: '(string|element)'
  };
  /**
   * Class definition
   */

  var Collapse = /*#__PURE__*/function () {
    function Collapse(element, config) {
      this._isTransitioning = false;
      this._element = element;
      this._config = this._getConfig(config);
      this._triggerArray = [].slice.call(document.querySelectorAll("[data-toggle=\"collapse\"][href=\"#" + element.id + "\"]," + ("[data-toggle=\"collapse\"][data-target=\"#" + element.id + "\"]")));
      var toggleList = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLE$3));

      for (var i = 0, len = toggleList.length; i < len; i++) {
        var elem = toggleList[i];
        var selector = Util.getSelectorFromElement(elem);
        var filterElement = [].slice.call(document.querySelectorAll(selector)).filter(function (foundElem) {
          return foundElem === element;
        });

        if (selector !== null && filterElement.length > 0) {
          this._selector = selector;

          this._triggerArray.push(elem);
        }
      }

      this._parent = this._config.parent ? this._getParent() : null;

      if (!this._config.parent) {
        this._addAriaAndCollapsedClass(this._element, this._triggerArray);
      }

      if (this._config.toggle) {
        this.toggle();
      }
    } // Getters


    var _proto = Collapse.prototype;

    // Public
    _proto.toggle = function toggle() {
      if ($__default["default"](this._element).hasClass(CLASS_NAME_SHOW$6)) {
        this.hide();
      } else {
        this.show();
      }
    };

    _proto.show = function show() {
      var _this = this;

      if (this._isTransitioning || $__default["default"](this._element).hasClass(CLASS_NAME_SHOW$6)) {
        return;
      }

      var actives;
      var activesData;

      if (this._parent) {
        actives = [].slice.call(this._parent.querySelectorAll(SELECTOR_ACTIVES)).filter(function (elem) {
          if (typeof _this._config.parent === 'string') {
            return elem.getAttribute('data-parent') === _this._config.parent;
          }

          return elem.classList.contains(CLASS_NAME_COLLAPSE);
        });

        if (actives.length === 0) {
          actives = null;
        }
      }

      if (actives) {
        activesData = $__default["default"](actives).not(this._selector).data(DATA_KEY$7);

        if (activesData && activesData._isTransitioning) {
          return;
        }
      }

      var startEvent = $__default["default"].Event(EVENT_SHOW$4);
      $__default["default"](this._element).trigger(startEvent);

      if (startEvent.isDefaultPrevented()) {
        return;
      }

      if (actives) {
        Collapse._jQueryInterface.call($__default["default"](actives).not(this._selector), 'hide');

        if (!activesData) {
          $__default["default"](actives).data(DATA_KEY$7, null);
        }
      }

      var dimension = this._getDimension();

      $__default["default"](this._element).removeClass(CLASS_NAME_COLLAPSE).addClass(CLASS_NAME_COLLAPSING);
      this._element.style[dimension] = 0;

      if (this._triggerArray.length) {
        $__default["default"](this._triggerArray).removeClass(CLASS_NAME_COLLAPSED).attr('aria-expanded', true);
      }

      this.setTransitioning(true);

      var complete = function complete() {
        $__default["default"](_this._element).removeClass(CLASS_NAME_COLLAPSING).addClass(CLASS_NAME_COLLAPSE + " " + CLASS_NAME_SHOW$6);
        _this._element.style[dimension] = '';

        _this.setTransitioning(false);

        $__default["default"](_this._element).trigger(EVENT_SHOWN$4);
      };

      var capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
      var scrollSize = "scroll" + capitalizedDimension;
      var transitionDuration = Util.getTransitionDurationFromElement(this._element);
      $__default["default"](this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
      this._element.style[dimension] = this._element[scrollSize] + "px";
    };

    _proto.hide = function hide() {
      var _this2 = this;

      if (this._isTransitioning || !$__default["default"](this._element).hasClass(CLASS_NAME_SHOW$6)) {
        return;
      }

      var startEvent = $__default["default"].Event(EVENT_HIDE$4);
      $__default["default"](this._element).trigger(startEvent);

      if (startEvent.isDefaultPrevented()) {
        return;
      }

      var dimension = this._getDimension();

      this._element.style[dimension] = this._element.getBoundingClientRect()[dimension] + "px";
      Util.reflow(this._element);
      $__default["default"](this._element).addClass(CLASS_NAME_COLLAPSING).removeClass(CLASS_NAME_COLLAPSE + " " + CLASS_NAME_SHOW$6);
      var triggerArrayLength = this._triggerArray.length;

      if (triggerArrayLength > 0) {
        for (var i = 0; i < triggerArrayLength; i++) {
          var trigger = this._triggerArray[i];
          var selector = Util.getSelectorFromElement(trigger);

          if (selector !== null) {
            var $elem = $__default["default"]([].slice.call(document.querySelectorAll(selector)));

            if (!$elem.hasClass(CLASS_NAME_SHOW$6)) {
              $__default["default"](trigger).addClass(CLASS_NAME_COLLAPSED).attr('aria-expanded', false);
            }
          }
        }
      }

      this.setTransitioning(true);

      var complete = function complete() {
        _this2.setTransitioning(false);

        $__default["default"](_this2._element).removeClass(CLASS_NAME_COLLAPSING).addClass(CLASS_NAME_COLLAPSE).trigger(EVENT_HIDDEN$4);
      };

      this._element.style[dimension] = '';
      var transitionDuration = Util.getTransitionDurationFromElement(this._element);
      $__default["default"](this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
    };

    _proto.setTransitioning = function setTransitioning(isTransitioning) {
      this._isTransitioning = isTransitioning;
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$7);
      this._config = null;
      this._parent = null;
      this._element = null;
      this._triggerArray = null;
      this._isTransitioning = null;
    } // Private
    ;

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, Default$6, config);
      config.toggle = Boolean(config.toggle); // Coerce string values

      Util.typeCheckConfig(NAME$7, config, DefaultType$6);
      return config;
    };

    _proto._getDimension = function _getDimension() {
      var hasWidth = $__default["default"](this._element).hasClass(DIMENSION_WIDTH);
      return hasWidth ? DIMENSION_WIDTH : DIMENSION_HEIGHT;
    };

    _proto._getParent = function _getParent() {
      var _this3 = this;

      var parent;

      if (Util.isElement(this._config.parent)) {
        parent = this._config.parent; // It's a jQuery object

        if (typeof this._config.parent.jquery !== 'undefined') {
          parent = this._config.parent[0];
        }
      } else {
        parent = document.querySelector(this._config.parent);
      }

      var selector = "[data-toggle=\"collapse\"][data-parent=\"" + this._config.parent + "\"]";
      var children = [].slice.call(parent.querySelectorAll(selector));
      $__default["default"](children).each(function (i, element) {
        _this3._addAriaAndCollapsedClass(Collapse._getTargetFromElement(element), [element]);
      });
      return parent;
    };

    _proto._addAriaAndCollapsedClass = function _addAriaAndCollapsedClass(element, triggerArray) {
      var isOpen = $__default["default"](element).hasClass(CLASS_NAME_SHOW$6);

      if (triggerArray.length) {
        $__default["default"](triggerArray).toggleClass(CLASS_NAME_COLLAPSED, !isOpen).attr('aria-expanded', isOpen);
      }
    } // Static
    ;

    Collapse._getTargetFromElement = function _getTargetFromElement(element) {
      var selector = Util.getSelectorFromElement(element);
      return selector ? document.querySelector(selector) : null;
    };

    Collapse._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var $element = $__default["default"](this);
        var data = $element.data(DATA_KEY$7);

        var _config = _extends$1({}, Default$6, $element.data(), typeof config === 'object' && config ? config : {});

        if (!data && _config.toggle && typeof config === 'string' && /show|hide/.test(config)) {
          _config.toggle = false;
        }

        if (!data) {
          data = new Collapse(this, _config);
          $element.data(DATA_KEY$7, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    _createClass(Collapse, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$7;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$6;
      }
    }]);

    return Collapse;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API$3, SELECTOR_DATA_TOGGLE$3, function (event) {
    // preventDefault only for <a> elements (which change the URL) not inside the collapsible element
    if (event.currentTarget.tagName === 'A') {
      event.preventDefault();
    }

    var $trigger = $__default["default"](this);
    var selector = Util.getSelectorFromElement(this);
    var selectors = [].slice.call(document.querySelectorAll(selector));
    $__default["default"](selectors).each(function () {
      var $target = $__default["default"](this);
      var data = $target.data(DATA_KEY$7);
      var config = data ? 'toggle' : $trigger.data();

      Collapse._jQueryInterface.call($target, config);
    });
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$7] = Collapse._jQueryInterface;
  $__default["default"].fn[NAME$7].Constructor = Collapse;

  $__default["default"].fn[NAME$7].noConflict = function () {
    $__default["default"].fn[NAME$7] = JQUERY_NO_CONFLICT$7;
    return Collapse._jQueryInterface;
  };

  /**!
   * @fileOverview Kickass library to create and place poppers near their reference elements.
   * @version 1.16.1
   * @license
   * Copyright (c) 2016 Federico Zivolo and contributors
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy
   * of this software and associated documentation files (the "Software"), to deal
   * in the Software without restriction, including without limitation the rights
   * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
   * copies of the Software, and to permit persons to whom the Software is
   * furnished to do so, subject to the following conditions:
   *
   * The above copyright notice and this permission notice shall be included in all
   * copies or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
   * SOFTWARE.
   */
  var isBrowser = typeof window !== 'undefined' && typeof document !== 'undefined' && typeof navigator !== 'undefined';

  var timeoutDuration = function () {
    var longerTimeoutBrowsers = ['Edge', 'Trident', 'Firefox'];
    for (var i = 0; i < longerTimeoutBrowsers.length; i += 1) {
      if (isBrowser && navigator.userAgent.indexOf(longerTimeoutBrowsers[i]) >= 0) {
        return 1;
      }
    }
    return 0;
  }();

  function microtaskDebounce(fn) {
    var called = false;
    return function () {
      if (called) {
        return;
      }
      called = true;
      window.Promise.resolve().then(function () {
        called = false;
        fn();
      });
    };
  }

  function taskDebounce(fn) {
    var scheduled = false;
    return function () {
      if (!scheduled) {
        scheduled = true;
        setTimeout(function () {
          scheduled = false;
          fn();
        }, timeoutDuration);
      }
    };
  }

  var supportsMicroTasks = isBrowser && window.Promise;

  /**
  * Create a debounced version of a method, that's asynchronously deferred
  * but called in the minimum time possible.
  *
  * @method
  * @memberof Popper.Utils
  * @argument {Function} fn
  * @returns {Function}
  */
  var debounce = supportsMicroTasks ? microtaskDebounce : taskDebounce;

  /**
   * Check if the given variable is a function
   * @method
   * @memberof Popper.Utils
   * @argument {Any} functionToCheck - variable to check
   * @returns {Boolean} answer to: is a function?
   */
  function isFunction(functionToCheck) {
    var getType = {};
    return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
  }

  /**
   * Get CSS computed property of the given element
   * @method
   * @memberof Popper.Utils
   * @argument {Eement} element
   * @argument {String} property
   */
  function getStyleComputedProperty(element, property) {
    if (element.nodeType !== 1) {
      return [];
    }
    // NOTE: 1 DOM access here
    var window = element.ownerDocument.defaultView;
    var css = window.getComputedStyle(element, null);
    return property ? css[property] : css;
  }

  /**
   * Returns the parentNode or the host of the element
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @returns {Element} parent
   */
  function getParentNode(element) {
    if (element.nodeName === 'HTML') {
      return element;
    }
    return element.parentNode || element.host;
  }

  /**
   * Returns the scrolling parent of the given element
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @returns {Element} scroll parent
   */
  function getScrollParent(element) {
    // Return body, `getScroll` will take care to get the correct `scrollTop` from it
    if (!element) {
      return document.body;
    }

    switch (element.nodeName) {
      case 'HTML':
      case 'BODY':
        return element.ownerDocument.body;
      case '#document':
        return element.body;
    }

    // Firefox want us to check `-x` and `-y` variations as well

    var _getStyleComputedProp = getStyleComputedProperty(element),
        overflow = _getStyleComputedProp.overflow,
        overflowX = _getStyleComputedProp.overflowX,
        overflowY = _getStyleComputedProp.overflowY;

    if (/(auto|scroll|overlay)/.test(overflow + overflowY + overflowX)) {
      return element;
    }

    return getScrollParent(getParentNode(element));
  }

  /**
   * Returns the reference node of the reference object, or the reference object itself.
   * @method
   * @memberof Popper.Utils
   * @param {Element|Object} reference - the reference element (the popper will be relative to this)
   * @returns {Element} parent
   */
  function getReferenceNode(reference) {
    return reference && reference.referenceNode ? reference.referenceNode : reference;
  }

  var isIE11 = isBrowser && !!(window.MSInputMethodContext && document.documentMode);
  var isIE10 = isBrowser && /MSIE 10/.test(navigator.userAgent);

  /**
   * Determines if the browser is Internet Explorer
   * @method
   * @memberof Popper.Utils
   * @param {Number} version to check
   * @returns {Boolean} isIE
   */
  function isIE(version) {
    if (version === 11) {
      return isIE11;
    }
    if (version === 10) {
      return isIE10;
    }
    return isIE11 || isIE10;
  }

  /**
   * Returns the offset parent of the given element
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @returns {Element} offset parent
   */
  function getOffsetParent(element) {
    if (!element) {
      return document.documentElement;
    }

    var noOffsetParent = isIE(10) ? document.body : null;

    // NOTE: 1 DOM access here
    var offsetParent = element.offsetParent || null;
    // Skip hidden elements which don't have an offsetParent
    while (offsetParent === noOffsetParent && element.nextElementSibling) {
      offsetParent = (element = element.nextElementSibling).offsetParent;
    }

    var nodeName = offsetParent && offsetParent.nodeName;

    if (!nodeName || nodeName === 'BODY' || nodeName === 'HTML') {
      return element ? element.ownerDocument.documentElement : document.documentElement;
    }

    // .offsetParent will return the closest TH, TD or TABLE in case
    // no offsetParent is present, I hate this job...
    if (['TH', 'TD', 'TABLE'].indexOf(offsetParent.nodeName) !== -1 && getStyleComputedProperty(offsetParent, 'position') === 'static') {
      return getOffsetParent(offsetParent);
    }

    return offsetParent;
  }

  function isOffsetContainer(element) {
    var nodeName = element.nodeName;

    if (nodeName === 'BODY') {
      return false;
    }
    return nodeName === 'HTML' || getOffsetParent(element.firstElementChild) === element;
  }

  /**
   * Finds the root node (document, shadowDOM root) of the given element
   * @method
   * @memberof Popper.Utils
   * @argument {Element} node
   * @returns {Element} root node
   */
  function getRoot(node) {
    if (node.parentNode !== null) {
      return getRoot(node.parentNode);
    }

    return node;
  }

  /**
   * Finds the offset parent common to the two provided nodes
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element1
   * @argument {Element} element2
   * @returns {Element} common offset parent
   */
  function findCommonOffsetParent(element1, element2) {
    // This check is needed to avoid errors in case one of the elements isn't defined for any reason
    if (!element1 || !element1.nodeType || !element2 || !element2.nodeType) {
      return document.documentElement;
    }

    // Here we make sure to give as "start" the element that comes first in the DOM
    var order = element1.compareDocumentPosition(element2) & Node.DOCUMENT_POSITION_FOLLOWING;
    var start = order ? element1 : element2;
    var end = order ? element2 : element1;

    // Get common ancestor container
    var range = document.createRange();
    range.setStart(start, 0);
    range.setEnd(end, 0);
    var commonAncestorContainer = range.commonAncestorContainer;

    // Both nodes are inside #document

    if (element1 !== commonAncestorContainer && element2 !== commonAncestorContainer || start.contains(end)) {
      if (isOffsetContainer(commonAncestorContainer)) {
        return commonAncestorContainer;
      }

      return getOffsetParent(commonAncestorContainer);
    }

    // one of the nodes is inside shadowDOM, find which one
    var element1root = getRoot(element1);
    if (element1root.host) {
      return findCommonOffsetParent(element1root.host, element2);
    } else {
      return findCommonOffsetParent(element1, getRoot(element2).host);
    }
  }

  /**
   * Gets the scroll value of the given element in the given side (top and left)
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @argument {String} side `top` or `left`
   * @returns {number} amount of scrolled pixels
   */
  function getScroll(element) {
    var side = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'top';

    var upperSide = side === 'top' ? 'scrollTop' : 'scrollLeft';
    var nodeName = element.nodeName;

    if (nodeName === 'BODY' || nodeName === 'HTML') {
      var html = element.ownerDocument.documentElement;
      var scrollingElement = element.ownerDocument.scrollingElement || html;
      return scrollingElement[upperSide];
    }

    return element[upperSide];
  }

  /*
   * Sum or subtract the element scroll values (left and top) from a given rect object
   * @method
   * @memberof Popper.Utils
   * @param {Object} rect - Rect object you want to change
   * @param {HTMLElement} element - The element from the function reads the scroll values
   * @param {Boolean} subtract - set to true if you want to subtract the scroll values
   * @return {Object} rect - The modifier rect object
   */
  function includeScroll(rect, element) {
    var subtract = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    var scrollTop = getScroll(element, 'top');
    var scrollLeft = getScroll(element, 'left');
    var modifier = subtract ? -1 : 1;
    rect.top += scrollTop * modifier;
    rect.bottom += scrollTop * modifier;
    rect.left += scrollLeft * modifier;
    rect.right += scrollLeft * modifier;
    return rect;
  }

  /*
   * Helper to detect borders of a given element
   * @method
   * @memberof Popper.Utils
   * @param {CSSStyleDeclaration} styles
   * Result of `getStyleComputedProperty` on the given element
   * @param {String} axis - `x` or `y`
   * @return {number} borders - The borders size of the given axis
   */

  function getBordersSize(styles, axis) {
    var sideA = axis === 'x' ? 'Left' : 'Top';
    var sideB = sideA === 'Left' ? 'Right' : 'Bottom';

    return parseFloat(styles['border' + sideA + 'Width']) + parseFloat(styles['border' + sideB + 'Width']);
  }

  function getSize(axis, body, html, computedStyle) {
    return Math.max(body['offset' + axis], body['scroll' + axis], html['client' + axis], html['offset' + axis], html['scroll' + axis], isIE(10) ? parseInt(html['offset' + axis]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Top' : 'Left')]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Bottom' : 'Right')]) : 0);
  }

  function getWindowSizes(document) {
    var body = document.body;
    var html = document.documentElement;
    var computedStyle = isIE(10) && getComputedStyle(html);

    return {
      height: getSize('Height', body, html, computedStyle),
      width: getSize('Width', body, html, computedStyle)
    };
  }

  var classCallCheck = function (instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  };

  var createClass = function () {
    function defineProperties(target, props) {
      for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || false;
        descriptor.configurable = true;
        if ("value" in descriptor) descriptor.writable = true;
        Object.defineProperty(target, descriptor.key, descriptor);
      }
    }

    return function (Constructor, protoProps, staticProps) {
      if (protoProps) defineProperties(Constructor.prototype, protoProps);
      if (staticProps) defineProperties(Constructor, staticProps);
      return Constructor;
    };
  }();





  var defineProperty = function (obj, key, value) {
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
  };

  var _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  /**
   * Given element offsets, generate an output similar to getBoundingClientRect
   * @method
   * @memberof Popper.Utils
   * @argument {Object} offsets
   * @returns {Object} ClientRect like output
   */
  function getClientRect(offsets) {
    return _extends({}, offsets, {
      right: offsets.left + offsets.width,
      bottom: offsets.top + offsets.height
    });
  }

  /**
   * Get bounding client rect of given element
   * @method
   * @memberof Popper.Utils
   * @param {HTMLElement} element
   * @return {Object} client rect
   */
  function getBoundingClientRect(element) {
    var rect = {};

    // IE10 10 FIX: Please, don't ask, the element isn't
    // considered in DOM in some circumstances...
    // This isn't reproducible in IE10 compatibility mode of IE11
    try {
      if (isIE(10)) {
        rect = element.getBoundingClientRect();
        var scrollTop = getScroll(element, 'top');
        var scrollLeft = getScroll(element, 'left');
        rect.top += scrollTop;
        rect.left += scrollLeft;
        rect.bottom += scrollTop;
        rect.right += scrollLeft;
      } else {
        rect = element.getBoundingClientRect();
      }
    } catch (e) {}

    var result = {
      left: rect.left,
      top: rect.top,
      width: rect.right - rect.left,
      height: rect.bottom - rect.top
    };

    // subtract scrollbar size from sizes
    var sizes = element.nodeName === 'HTML' ? getWindowSizes(element.ownerDocument) : {};
    var width = sizes.width || element.clientWidth || result.width;
    var height = sizes.height || element.clientHeight || result.height;

    var horizScrollbar = element.offsetWidth - width;
    var vertScrollbar = element.offsetHeight - height;

    // if an hypothetical scrollbar is detected, we must be sure it's not a `border`
    // we make this check conditional for performance reasons
    if (horizScrollbar || vertScrollbar) {
      var styles = getStyleComputedProperty(element);
      horizScrollbar -= getBordersSize(styles, 'x');
      vertScrollbar -= getBordersSize(styles, 'y');

      result.width -= horizScrollbar;
      result.height -= vertScrollbar;
    }

    return getClientRect(result);
  }

  function getOffsetRectRelativeToArbitraryNode(children, parent) {
    var fixedPosition = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    var isIE10 = isIE(10);
    var isHTML = parent.nodeName === 'HTML';
    var childrenRect = getBoundingClientRect(children);
    var parentRect = getBoundingClientRect(parent);
    var scrollParent = getScrollParent(children);

    var styles = getStyleComputedProperty(parent);
    var borderTopWidth = parseFloat(styles.borderTopWidth);
    var borderLeftWidth = parseFloat(styles.borderLeftWidth);

    // In cases where the parent is fixed, we must ignore negative scroll in offset calc
    if (fixedPosition && isHTML) {
      parentRect.top = Math.max(parentRect.top, 0);
      parentRect.left = Math.max(parentRect.left, 0);
    }
    var offsets = getClientRect({
      top: childrenRect.top - parentRect.top - borderTopWidth,
      left: childrenRect.left - parentRect.left - borderLeftWidth,
      width: childrenRect.width,
      height: childrenRect.height
    });
    offsets.marginTop = 0;
    offsets.marginLeft = 0;

    // Subtract margins of documentElement in case it's being used as parent
    // we do this only on HTML because it's the only element that behaves
    // differently when margins are applied to it. The margins are included in
    // the box of the documentElement, in the other cases not.
    if (!isIE10 && isHTML) {
      var marginTop = parseFloat(styles.marginTop);
      var marginLeft = parseFloat(styles.marginLeft);

      offsets.top -= borderTopWidth - marginTop;
      offsets.bottom -= borderTopWidth - marginTop;
      offsets.left -= borderLeftWidth - marginLeft;
      offsets.right -= borderLeftWidth - marginLeft;

      // Attach marginTop and marginLeft because in some circumstances we may need them
      offsets.marginTop = marginTop;
      offsets.marginLeft = marginLeft;
    }

    if (isIE10 && !fixedPosition ? parent.contains(scrollParent) : parent === scrollParent && scrollParent.nodeName !== 'BODY') {
      offsets = includeScroll(offsets, parent);
    }

    return offsets;
  }

  function getViewportOffsetRectRelativeToArtbitraryNode(element) {
    var excludeScroll = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

    var html = element.ownerDocument.documentElement;
    var relativeOffset = getOffsetRectRelativeToArbitraryNode(element, html);
    var width = Math.max(html.clientWidth, window.innerWidth || 0);
    var height = Math.max(html.clientHeight, window.innerHeight || 0);

    var scrollTop = !excludeScroll ? getScroll(html) : 0;
    var scrollLeft = !excludeScroll ? getScroll(html, 'left') : 0;

    var offset = {
      top: scrollTop - relativeOffset.top + relativeOffset.marginTop,
      left: scrollLeft - relativeOffset.left + relativeOffset.marginLeft,
      width: width,
      height: height
    };

    return getClientRect(offset);
  }

  /**
   * Check if the given element is fixed or is inside a fixed parent
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @argument {Element} customContainer
   * @returns {Boolean} answer to "isFixed?"
   */
  function isFixed(element) {
    var nodeName = element.nodeName;
    if (nodeName === 'BODY' || nodeName === 'HTML') {
      return false;
    }
    if (getStyleComputedProperty(element, 'position') === 'fixed') {
      return true;
    }
    var parentNode = getParentNode(element);
    if (!parentNode) {
      return false;
    }
    return isFixed(parentNode);
  }

  /**
   * Finds the first parent of an element that has a transformed property defined
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @returns {Element} first transformed parent or documentElement
   */

  function getFixedPositionOffsetParent(element) {
    // This check is needed to avoid errors in case one of the elements isn't defined for any reason
    if (!element || !element.parentElement || isIE()) {
      return document.documentElement;
    }
    var el = element.parentElement;
    while (el && getStyleComputedProperty(el, 'transform') === 'none') {
      el = el.parentElement;
    }
    return el || document.documentElement;
  }

  /**
   * Computed the boundaries limits and return them
   * @method
   * @memberof Popper.Utils
   * @param {HTMLElement} popper
   * @param {HTMLElement} reference
   * @param {number} padding
   * @param {HTMLElement} boundariesElement - Element used to define the boundaries
   * @param {Boolean} fixedPosition - Is in fixed position mode
   * @returns {Object} Coordinates of the boundaries
   */
  function getBoundaries(popper, reference, padding, boundariesElement) {
    var fixedPosition = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;

    // NOTE: 1 DOM access here

    var boundaries = { top: 0, left: 0 };
    var offsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, getReferenceNode(reference));

    // Handle viewport case
    if (boundariesElement === 'viewport') {
      boundaries = getViewportOffsetRectRelativeToArtbitraryNode(offsetParent, fixedPosition);
    } else {
      // Handle other cases based on DOM element used as boundaries
      var boundariesNode = void 0;
      if (boundariesElement === 'scrollParent') {
        boundariesNode = getScrollParent(getParentNode(reference));
        if (boundariesNode.nodeName === 'BODY') {
          boundariesNode = popper.ownerDocument.documentElement;
        }
      } else if (boundariesElement === 'window') {
        boundariesNode = popper.ownerDocument.documentElement;
      } else {
        boundariesNode = boundariesElement;
      }

      var offsets = getOffsetRectRelativeToArbitraryNode(boundariesNode, offsetParent, fixedPosition);

      // In case of HTML, we need a different computation
      if (boundariesNode.nodeName === 'HTML' && !isFixed(offsetParent)) {
        var _getWindowSizes = getWindowSizes(popper.ownerDocument),
            height = _getWindowSizes.height,
            width = _getWindowSizes.width;

        boundaries.top += offsets.top - offsets.marginTop;
        boundaries.bottom = height + offsets.top;
        boundaries.left += offsets.left - offsets.marginLeft;
        boundaries.right = width + offsets.left;
      } else {
        // for all the other DOM elements, this one is good
        boundaries = offsets;
      }
    }

    // Add paddings
    padding = padding || 0;
    var isPaddingNumber = typeof padding === 'number';
    boundaries.left += isPaddingNumber ? padding : padding.left || 0;
    boundaries.top += isPaddingNumber ? padding : padding.top || 0;
    boundaries.right -= isPaddingNumber ? padding : padding.right || 0;
    boundaries.bottom -= isPaddingNumber ? padding : padding.bottom || 0;

    return boundaries;
  }

  function getArea(_ref) {
    var width = _ref.width,
        height = _ref.height;

    return width * height;
  }

  /**
   * Utility used to transform the `auto` placement to the placement with more
   * available space.
   * @method
   * @memberof Popper.Utils
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function computeAutoPlacement(placement, refRect, popper, reference, boundariesElement) {
    var padding = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 0;

    if (placement.indexOf('auto') === -1) {
      return placement;
    }

    var boundaries = getBoundaries(popper, reference, padding, boundariesElement);

    var rects = {
      top: {
        width: boundaries.width,
        height: refRect.top - boundaries.top
      },
      right: {
        width: boundaries.right - refRect.right,
        height: boundaries.height
      },
      bottom: {
        width: boundaries.width,
        height: boundaries.bottom - refRect.bottom
      },
      left: {
        width: refRect.left - boundaries.left,
        height: boundaries.height
      }
    };

    var sortedAreas = Object.keys(rects).map(function (key) {
      return _extends({
        key: key
      }, rects[key], {
        area: getArea(rects[key])
      });
    }).sort(function (a, b) {
      return b.area - a.area;
    });

    var filteredAreas = sortedAreas.filter(function (_ref2) {
      var width = _ref2.width,
          height = _ref2.height;
      return width >= popper.clientWidth && height >= popper.clientHeight;
    });

    var computedPlacement = filteredAreas.length > 0 ? filteredAreas[0].key : sortedAreas[0].key;

    var variation = placement.split('-')[1];

    return computedPlacement + (variation ? '-' + variation : '');
  }

  /**
   * Get offsets to the reference element
   * @method
   * @memberof Popper.Utils
   * @param {Object} state
   * @param {Element} popper - the popper element
   * @param {Element} reference - the reference element (the popper will be relative to this)
   * @param {Element} fixedPosition - is in fixed position mode
   * @returns {Object} An object containing the offsets which will be applied to the popper
   */
  function getReferenceOffsets(state, popper, reference) {
    var fixedPosition = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

    var commonOffsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, getReferenceNode(reference));
    return getOffsetRectRelativeToArbitraryNode(reference, commonOffsetParent, fixedPosition);
  }

  /**
   * Get the outer sizes of the given element (offset size + margins)
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element
   * @returns {Object} object containing width and height properties
   */
  function getOuterSizes(element) {
    var window = element.ownerDocument.defaultView;
    var styles = window.getComputedStyle(element);
    var x = parseFloat(styles.marginTop || 0) + parseFloat(styles.marginBottom || 0);
    var y = parseFloat(styles.marginLeft || 0) + parseFloat(styles.marginRight || 0);
    var result = {
      width: element.offsetWidth + y,
      height: element.offsetHeight + x
    };
    return result;
  }

  /**
   * Get the opposite placement of the given one
   * @method
   * @memberof Popper.Utils
   * @argument {String} placement
   * @returns {String} flipped placement
   */
  function getOppositePlacement(placement) {
    var hash = { left: 'right', right: 'left', bottom: 'top', top: 'bottom' };
    return placement.replace(/left|right|bottom|top/g, function (matched) {
      return hash[matched];
    });
  }

  /**
   * Get offsets to the popper
   * @method
   * @memberof Popper.Utils
   * @param {Object} position - CSS position the Popper will get applied
   * @param {HTMLElement} popper - the popper element
   * @param {Object} referenceOffsets - the reference offsets (the popper will be relative to this)
   * @param {String} placement - one of the valid placement options
   * @returns {Object} popperOffsets - An object containing the offsets which will be applied to the popper
   */
  function getPopperOffsets(popper, referenceOffsets, placement) {
    placement = placement.split('-')[0];

    // Get popper node sizes
    var popperRect = getOuterSizes(popper);

    // Add position, width and height to our offsets object
    var popperOffsets = {
      width: popperRect.width,
      height: popperRect.height
    };

    // depending by the popper placement we have to compute its offsets slightly differently
    var isHoriz = ['right', 'left'].indexOf(placement) !== -1;
    var mainSide = isHoriz ? 'top' : 'left';
    var secondarySide = isHoriz ? 'left' : 'top';
    var measurement = isHoriz ? 'height' : 'width';
    var secondaryMeasurement = !isHoriz ? 'height' : 'width';

    popperOffsets[mainSide] = referenceOffsets[mainSide] + referenceOffsets[measurement] / 2 - popperRect[measurement] / 2;
    if (placement === secondarySide) {
      popperOffsets[secondarySide] = referenceOffsets[secondarySide] - popperRect[secondaryMeasurement];
    } else {
      popperOffsets[secondarySide] = referenceOffsets[getOppositePlacement(secondarySide)];
    }

    return popperOffsets;
  }

  /**
   * Mimics the `find` method of Array
   * @method
   * @memberof Popper.Utils
   * @argument {Array} arr
   * @argument prop
   * @argument value
   * @returns index or -1
   */
  function find(arr, check) {
    // use native find if supported
    if (Array.prototype.find) {
      return arr.find(check);
    }

    // use `filter` to obtain the same behavior of `find`
    return arr.filter(check)[0];
  }

  /**
   * Return the index of the matching object
   * @method
   * @memberof Popper.Utils
   * @argument {Array} arr
   * @argument prop
   * @argument value
   * @returns index or -1
   */
  function findIndex(arr, prop, value) {
    // use native findIndex if supported
    if (Array.prototype.findIndex) {
      return arr.findIndex(function (cur) {
        return cur[prop] === value;
      });
    }

    // use `find` + `indexOf` if `findIndex` isn't supported
    var match = find(arr, function (obj) {
      return obj[prop] === value;
    });
    return arr.indexOf(match);
  }

  /**
   * Loop trough the list of modifiers and run them in order,
   * each of them will then edit the data object.
   * @method
   * @memberof Popper.Utils
   * @param {dataObject} data
   * @param {Array} modifiers
   * @param {String} ends - Optional modifier name used as stopper
   * @returns {dataObject}
   */
  function runModifiers(modifiers, data, ends) {
    var modifiersToRun = ends === undefined ? modifiers : modifiers.slice(0, findIndex(modifiers, 'name', ends));

    modifiersToRun.forEach(function (modifier) {
      if (modifier['function']) {
        // eslint-disable-line dot-notation
        console.warn('`modifier.function` is deprecated, use `modifier.fn`!');
      }
      var fn = modifier['function'] || modifier.fn; // eslint-disable-line dot-notation
      if (modifier.enabled && isFunction(fn)) {
        // Add properties to offsets to make them a complete clientRect object
        // we do this before each modifier to make sure the previous one doesn't
        // mess with these values
        data.offsets.popper = getClientRect(data.offsets.popper);
        data.offsets.reference = getClientRect(data.offsets.reference);

        data = fn(data, modifier);
      }
    });

    return data;
  }

  /**
   * Updates the position of the popper, computing the new offsets and applying
   * the new style.<br />
   * Prefer `scheduleUpdate` over `update` because of performance reasons.
   * @method
   * @memberof Popper
   */
  function update() {
    // if popper is destroyed, don't perform any further update
    if (this.state.isDestroyed) {
      return;
    }

    var data = {
      instance: this,
      styles: {},
      arrowStyles: {},
      attributes: {},
      flipped: false,
      offsets: {}
    };

    // compute reference element offsets
    data.offsets.reference = getReferenceOffsets(this.state, this.popper, this.reference, this.options.positionFixed);

    // compute auto placement, store placement inside the data object,
    // modifiers will be able to edit `placement` if needed
    // and refer to originalPlacement to know the original value
    data.placement = computeAutoPlacement(this.options.placement, data.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding);

    // store the computed placement inside `originalPlacement`
    data.originalPlacement = data.placement;

    data.positionFixed = this.options.positionFixed;

    // compute the popper offsets
    data.offsets.popper = getPopperOffsets(this.popper, data.offsets.reference, data.placement);

    data.offsets.popper.position = this.options.positionFixed ? 'fixed' : 'absolute';

    // run the modifiers
    data = runModifiers(this.modifiers, data);

    // the first `update` will call `onCreate` callback
    // the other ones will call `onUpdate` callback
    if (!this.state.isCreated) {
      this.state.isCreated = true;
      this.options.onCreate(data);
    } else {
      this.options.onUpdate(data);
    }
  }

  /**
   * Helper used to know if the given modifier is enabled.
   * @method
   * @memberof Popper.Utils
   * @returns {Boolean}
   */
  function isModifierEnabled(modifiers, modifierName) {
    return modifiers.some(function (_ref) {
      var name = _ref.name,
          enabled = _ref.enabled;
      return enabled && name === modifierName;
    });
  }

  /**
   * Get the prefixed supported property name
   * @method
   * @memberof Popper.Utils
   * @argument {String} property (camelCase)
   * @returns {String} prefixed property (camelCase or PascalCase, depending on the vendor prefix)
   */
  function getSupportedPropertyName(property) {
    var prefixes = [false, 'ms', 'Webkit', 'Moz', 'O'];
    var upperProp = property.charAt(0).toUpperCase() + property.slice(1);

    for (var i = 0; i < prefixes.length; i++) {
      var prefix = prefixes[i];
      var toCheck = prefix ? '' + prefix + upperProp : property;
      if (typeof document.body.style[toCheck] !== 'undefined') {
        return toCheck;
      }
    }
    return null;
  }

  /**
   * Destroys the popper.
   * @method
   * @memberof Popper
   */
  function destroy() {
    this.state.isDestroyed = true;

    // touch DOM only if `applyStyle` modifier is enabled
    if (isModifierEnabled(this.modifiers, 'applyStyle')) {
      this.popper.removeAttribute('x-placement');
      this.popper.style.position = '';
      this.popper.style.top = '';
      this.popper.style.left = '';
      this.popper.style.right = '';
      this.popper.style.bottom = '';
      this.popper.style.willChange = '';
      this.popper.style[getSupportedPropertyName('transform')] = '';
    }

    this.disableEventListeners();

    // remove the popper if user explicitly asked for the deletion on destroy
    // do not use `remove` because IE11 doesn't support it
    if (this.options.removeOnDestroy) {
      this.popper.parentNode.removeChild(this.popper);
    }
    return this;
  }

  /**
   * Get the window associated with the element
   * @argument {Element} element
   * @returns {Window}
   */
  function getWindow(element) {
    var ownerDocument = element.ownerDocument;
    return ownerDocument ? ownerDocument.defaultView : window;
  }

  function attachToScrollParents(scrollParent, event, callback, scrollParents) {
    var isBody = scrollParent.nodeName === 'BODY';
    var target = isBody ? scrollParent.ownerDocument.defaultView : scrollParent;
    target.addEventListener(event, callback, { passive: true });

    if (!isBody) {
      attachToScrollParents(getScrollParent(target.parentNode), event, callback, scrollParents);
    }
    scrollParents.push(target);
  }

  /**
   * Setup needed event listeners used to update the popper position
   * @method
   * @memberof Popper.Utils
   * @private
   */
  function setupEventListeners(reference, options, state, updateBound) {
    // Resize event listener on window
    state.updateBound = updateBound;
    getWindow(reference).addEventListener('resize', state.updateBound, { passive: true });

    // Scroll event listener on scroll parents
    var scrollElement = getScrollParent(reference);
    attachToScrollParents(scrollElement, 'scroll', state.updateBound, state.scrollParents);
    state.scrollElement = scrollElement;
    state.eventsEnabled = true;

    return state;
  }

  /**
   * It will add resize/scroll events and start recalculating
   * position of the popper element when they are triggered.
   * @method
   * @memberof Popper
   */
  function enableEventListeners() {
    if (!this.state.eventsEnabled) {
      this.state = setupEventListeners(this.reference, this.options, this.state, this.scheduleUpdate);
    }
  }

  /**
   * Remove event listeners used to update the popper position
   * @method
   * @memberof Popper.Utils
   * @private
   */
  function removeEventListeners(reference, state) {
    // Remove resize event listener on window
    getWindow(reference).removeEventListener('resize', state.updateBound);

    // Remove scroll event listener on scroll parents
    state.scrollParents.forEach(function (target) {
      target.removeEventListener('scroll', state.updateBound);
    });

    // Reset state
    state.updateBound = null;
    state.scrollParents = [];
    state.scrollElement = null;
    state.eventsEnabled = false;
    return state;
  }

  /**
   * It will remove resize/scroll events and won't recalculate popper position
   * when they are triggered. It also won't trigger `onUpdate` callback anymore,
   * unless you call `update` method manually.
   * @method
   * @memberof Popper
   */
  function disableEventListeners() {
    if (this.state.eventsEnabled) {
      cancelAnimationFrame(this.scheduleUpdate);
      this.state = removeEventListeners(this.reference, this.state);
    }
  }

  /**
   * Tells if a given input is a number
   * @method
   * @memberof Popper.Utils
   * @param {*} input to check
   * @return {Boolean}
   */
  function isNumeric(n) {
    return n !== '' && !isNaN(parseFloat(n)) && isFinite(n);
  }

  /**
   * Set the style to the given popper
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element - Element to apply the style to
   * @argument {Object} styles
   * Object with a list of properties and values which will be applied to the element
   */
  function setStyles(element, styles) {
    Object.keys(styles).forEach(function (prop) {
      var unit = '';
      // add unit if the value is numeric and is one of the following
      if (['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(prop) !== -1 && isNumeric(styles[prop])) {
        unit = 'px';
      }
      element.style[prop] = styles[prop] + unit;
    });
  }

  /**
   * Set the attributes to the given popper
   * @method
   * @memberof Popper.Utils
   * @argument {Element} element - Element to apply the attributes to
   * @argument {Object} styles
   * Object with a list of properties and values which will be applied to the element
   */
  function setAttributes(element, attributes) {
    Object.keys(attributes).forEach(function (prop) {
      var value = attributes[prop];
      if (value !== false) {
        element.setAttribute(prop, attributes[prop]);
      } else {
        element.removeAttribute(prop);
      }
    });
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Object} data.styles - List of style properties - values to apply to popper element
   * @argument {Object} data.attributes - List of attribute properties - values to apply to popper element
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The same data object
   */
  function applyStyle(data) {
    // any property present in `data.styles` will be applied to the popper,
    // in this way we can make the 3rd party modifiers add custom styles to it
    // Be aware, modifiers could override the properties defined in the previous
    // lines of this modifier!
    setStyles(data.instance.popper, data.styles);

    // any property present in `data.attributes` will be applied to the popper,
    // they will be set as HTML attributes of the element
    setAttributes(data.instance.popper, data.attributes);

    // if arrowElement is defined and arrowStyles has some properties
    if (data.arrowElement && Object.keys(data.arrowStyles).length) {
      setStyles(data.arrowElement, data.arrowStyles);
    }

    return data;
  }

  /**
   * Set the x-placement attribute before everything else because it could be used
   * to add margins to the popper margins needs to be calculated to get the
   * correct popper offsets.
   * @method
   * @memberof Popper.modifiers
   * @param {HTMLElement} reference - The reference element used to position the popper
   * @param {HTMLElement} popper - The HTML element used as popper
   * @param {Object} options - Popper.js options
   */
  function applyStyleOnLoad(reference, popper, options, modifierOptions, state) {
    // compute reference element offsets
    var referenceOffsets = getReferenceOffsets(state, popper, reference, options.positionFixed);

    // compute auto placement, store placement inside the data object,
    // modifiers will be able to edit `placement` if needed
    // and refer to originalPlacement to know the original value
    var placement = computeAutoPlacement(options.placement, referenceOffsets, popper, reference, options.modifiers.flip.boundariesElement, options.modifiers.flip.padding);

    popper.setAttribute('x-placement', placement);

    // Apply `position` to popper before anything else because
    // without the position applied we can't guarantee correct computations
    setStyles(popper, { position: options.positionFixed ? 'fixed' : 'absolute' });

    return options;
  }

  /**
   * @function
   * @memberof Popper.Utils
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Boolean} shouldRound - If the offsets should be rounded at all
   * @returns {Object} The popper's position offsets rounded
   *
   * The tale of pixel-perfect positioning. It's still not 100% perfect, but as
   * good as it can be within reason.
   * Discussion here: https://github.com/FezVrasta/popper.js/pull/715
   *
   * Low DPI screens cause a popper to be blurry if not using full pixels (Safari
   * as well on High DPI screens).
   *
   * Firefox prefers no rounding for positioning and does not have blurriness on
   * high DPI screens.
   *
   * Only horizontal placement and left/right values need to be considered.
   */
  function getRoundedOffsets(data, shouldRound) {
    var _data$offsets = data.offsets,
        popper = _data$offsets.popper,
        reference = _data$offsets.reference;
    var round = Math.round,
        floor = Math.floor;

    var noRound = function noRound(v) {
      return v;
    };

    var referenceWidth = round(reference.width);
    var popperWidth = round(popper.width);

    var isVertical = ['left', 'right'].indexOf(data.placement) !== -1;
    var isVariation = data.placement.indexOf('-') !== -1;
    var sameWidthParity = referenceWidth % 2 === popperWidth % 2;
    var bothOddWidth = referenceWidth % 2 === 1 && popperWidth % 2 === 1;

    var horizontalToInteger = !shouldRound ? noRound : isVertical || isVariation || sameWidthParity ? round : floor;
    var verticalToInteger = !shouldRound ? noRound : round;

    return {
      left: horizontalToInteger(bothOddWidth && !isVariation && shouldRound ? popper.left - 1 : popper.left),
      top: verticalToInteger(popper.top),
      bottom: verticalToInteger(popper.bottom),
      right: horizontalToInteger(popper.right)
    };
  }

  var isFirefox = isBrowser && /Firefox/i.test(navigator.userAgent);

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function computeStyle(data, options) {
    var x = options.x,
        y = options.y;
    var popper = data.offsets.popper;

    // Remove this legacy support in Popper.js v2

    var legacyGpuAccelerationOption = find(data.instance.modifiers, function (modifier) {
      return modifier.name === 'applyStyle';
    }).gpuAcceleration;
    if (legacyGpuAccelerationOption !== undefined) {
      console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');
    }
    var gpuAcceleration = legacyGpuAccelerationOption !== undefined ? legacyGpuAccelerationOption : options.gpuAcceleration;

    var offsetParent = getOffsetParent(data.instance.popper);
    var offsetParentRect = getBoundingClientRect(offsetParent);

    // Styles
    var styles = {
      position: popper.position
    };

    var offsets = getRoundedOffsets(data, window.devicePixelRatio < 2 || !isFirefox);

    var sideA = x === 'bottom' ? 'top' : 'bottom';
    var sideB = y === 'right' ? 'left' : 'right';

    // if gpuAcceleration is set to `true` and transform is supported,
    //  we use `translate3d` to apply the position to the popper we
    // automatically use the supported prefixed version if needed
    var prefixedProperty = getSupportedPropertyName('transform');

    // now, let's make a step back and look at this code closely (wtf?)
    // If the content of the popper grows once it's been positioned, it
    // may happen that the popper gets misplaced because of the new content
    // overflowing its reference element
    // To avoid this problem, we provide two options (x and y), which allow
    // the consumer to define the offset origin.
    // If we position a popper on top of a reference element, we can set
    // `x` to `top` to make the popper grow towards its top instead of
    // its bottom.
    var left = void 0,
        top = void 0;
    if (sideA === 'bottom') {
      // when offsetParent is <html> the positioning is relative to the bottom of the screen (excluding the scrollbar)
      // and not the bottom of the html element
      if (offsetParent.nodeName === 'HTML') {
        top = -offsetParent.clientHeight + offsets.bottom;
      } else {
        top = -offsetParentRect.height + offsets.bottom;
      }
    } else {
      top = offsets.top;
    }
    if (sideB === 'right') {
      if (offsetParent.nodeName === 'HTML') {
        left = -offsetParent.clientWidth + offsets.right;
      } else {
        left = -offsetParentRect.width + offsets.right;
      }
    } else {
      left = offsets.left;
    }
    if (gpuAcceleration && prefixedProperty) {
      styles[prefixedProperty] = 'translate3d(' + left + 'px, ' + top + 'px, 0)';
      styles[sideA] = 0;
      styles[sideB] = 0;
      styles.willChange = 'transform';
    } else {
      // othwerise, we use the standard `top`, `left`, `bottom` and `right` properties
      var invertTop = sideA === 'bottom' ? -1 : 1;
      var invertLeft = sideB === 'right' ? -1 : 1;
      styles[sideA] = top * invertTop;
      styles[sideB] = left * invertLeft;
      styles.willChange = sideA + ', ' + sideB;
    }

    // Attributes
    var attributes = {
      'x-placement': data.placement
    };

    // Update `data` attributes, styles and arrowStyles
    data.attributes = _extends({}, attributes, data.attributes);
    data.styles = _extends({}, styles, data.styles);
    data.arrowStyles = _extends({}, data.offsets.arrow, data.arrowStyles);

    return data;
  }

  /**
   * Helper used to know if the given modifier depends from another one.<br />
   * It checks if the needed modifier is listed and enabled.
   * @method
   * @memberof Popper.Utils
   * @param {Array} modifiers - list of modifiers
   * @param {String} requestingName - name of requesting modifier
   * @param {String} requestedName - name of requested modifier
   * @returns {Boolean}
   */
  function isModifierRequired(modifiers, requestingName, requestedName) {
    var requesting = find(modifiers, function (_ref) {
      var name = _ref.name;
      return name === requestingName;
    });

    var isRequired = !!requesting && modifiers.some(function (modifier) {
      return modifier.name === requestedName && modifier.enabled && modifier.order < requesting.order;
    });

    if (!isRequired) {
      var _requesting = '`' + requestingName + '`';
      var requested = '`' + requestedName + '`';
      console.warn(requested + ' modifier is required by ' + _requesting + ' modifier in order to work, be sure to include it before ' + _requesting + '!');
    }
    return isRequired;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function arrow(data, options) {
    var _data$offsets$arrow;

    // arrow depends on keepTogether in order to work
    if (!isModifierRequired(data.instance.modifiers, 'arrow', 'keepTogether')) {
      return data;
    }

    var arrowElement = options.element;

    // if arrowElement is a string, suppose it's a CSS selector
    if (typeof arrowElement === 'string') {
      arrowElement = data.instance.popper.querySelector(arrowElement);

      // if arrowElement is not found, don't run the modifier
      if (!arrowElement) {
        return data;
      }
    } else {
      // if the arrowElement isn't a query selector we must check that the
      // provided DOM node is child of its popper node
      if (!data.instance.popper.contains(arrowElement)) {
        console.warn('WARNING: `arrow.element` must be child of its popper element!');
        return data;
      }
    }

    var placement = data.placement.split('-')[0];
    var _data$offsets = data.offsets,
        popper = _data$offsets.popper,
        reference = _data$offsets.reference;

    var isVertical = ['left', 'right'].indexOf(placement) !== -1;

    var len = isVertical ? 'height' : 'width';
    var sideCapitalized = isVertical ? 'Top' : 'Left';
    var side = sideCapitalized.toLowerCase();
    var altSide = isVertical ? 'left' : 'top';
    var opSide = isVertical ? 'bottom' : 'right';
    var arrowElementSize = getOuterSizes(arrowElement)[len];

    //
    // extends keepTogether behavior making sure the popper and its
    // reference have enough pixels in conjunction
    //

    // top/left side
    if (reference[opSide] - arrowElementSize < popper[side]) {
      data.offsets.popper[side] -= popper[side] - (reference[opSide] - arrowElementSize);
    }
    // bottom/right side
    if (reference[side] + arrowElementSize > popper[opSide]) {
      data.offsets.popper[side] += reference[side] + arrowElementSize - popper[opSide];
    }
    data.offsets.popper = getClientRect(data.offsets.popper);

    // compute center of the popper
    var center = reference[side] + reference[len] / 2 - arrowElementSize / 2;

    // Compute the sideValue using the updated popper offsets
    // take popper margin in account because we don't have this info available
    var css = getStyleComputedProperty(data.instance.popper);
    var popperMarginSide = parseFloat(css['margin' + sideCapitalized]);
    var popperBorderSide = parseFloat(css['border' + sideCapitalized + 'Width']);
    var sideValue = center - data.offsets.popper[side] - popperMarginSide - popperBorderSide;

    // prevent arrowElement from being placed not contiguously to its popper
    sideValue = Math.max(Math.min(popper[len] - arrowElementSize, sideValue), 0);

    data.arrowElement = arrowElement;
    data.offsets.arrow = (_data$offsets$arrow = {}, defineProperty(_data$offsets$arrow, side, Math.round(sideValue)), defineProperty(_data$offsets$arrow, altSide, ''), _data$offsets$arrow);

    return data;
  }

  /**
   * Get the opposite placement variation of the given one
   * @method
   * @memberof Popper.Utils
   * @argument {String} placement variation
   * @returns {String} flipped placement variation
   */
  function getOppositeVariation(variation) {
    if (variation === 'end') {
      return 'start';
    } else if (variation === 'start') {
      return 'end';
    }
    return variation;
  }

  /**
   * List of accepted placements to use as values of the `placement` option.<br />
   * Valid placements are:
   * - `auto`
   * - `top`
   * - `right`
   * - `bottom`
   * - `left`
   *
   * Each placement can have a variation from this list:
   * - `-start`
   * - `-end`
   *
   * Variations are interpreted easily if you think of them as the left to right
   * written languages. Horizontally (`top` and `bottom`), `start` is left and `end`
   * is right.<br />
   * Vertically (`left` and `right`), `start` is top and `end` is bottom.
   *
   * Some valid examples are:
   * - `top-end` (on top of reference, right aligned)
   * - `right-start` (on right of reference, top aligned)
   * - `bottom` (on bottom, centered)
   * - `auto-end` (on the side with more space available, alignment depends by placement)
   *
   * @static
   * @type {Array}
   * @enum {String}
   * @readonly
   * @method placements
   * @memberof Popper
   */
  var placements = ['auto-start', 'auto', 'auto-end', 'top-start', 'top', 'top-end', 'right-start', 'right', 'right-end', 'bottom-end', 'bottom', 'bottom-start', 'left-end', 'left', 'left-start'];

  // Get rid of `auto` `auto-start` and `auto-end`
  var validPlacements = placements.slice(3);

  /**
   * Given an initial placement, returns all the subsequent placements
   * clockwise (or counter-clockwise).
   *
   * @method
   * @memberof Popper.Utils
   * @argument {String} placement - A valid placement (it accepts variations)
   * @argument {Boolean} counter - Set to true to walk the placements counterclockwise
   * @returns {Array} placements including their variations
   */
  function clockwise(placement) {
    var counter = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

    var index = validPlacements.indexOf(placement);
    var arr = validPlacements.slice(index + 1).concat(validPlacements.slice(0, index));
    return counter ? arr.reverse() : arr;
  }

  var BEHAVIORS = {
    FLIP: 'flip',
    CLOCKWISE: 'clockwise',
    COUNTERCLOCKWISE: 'counterclockwise'
  };

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function flip(data, options) {
    // if `inner` modifier is enabled, we can't use the `flip` modifier
    if (isModifierEnabled(data.instance.modifiers, 'inner')) {
      return data;
    }

    if (data.flipped && data.placement === data.originalPlacement) {
      // seems like flip is trying to loop, probably there's not enough space on any of the flippable sides
      return data;
    }

    var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, options.boundariesElement, data.positionFixed);

    var placement = data.placement.split('-')[0];
    var placementOpposite = getOppositePlacement(placement);
    var variation = data.placement.split('-')[1] || '';

    var flipOrder = [];

    switch (options.behavior) {
      case BEHAVIORS.FLIP:
        flipOrder = [placement, placementOpposite];
        break;
      case BEHAVIORS.CLOCKWISE:
        flipOrder = clockwise(placement);
        break;
      case BEHAVIORS.COUNTERCLOCKWISE:
        flipOrder = clockwise(placement, true);
        break;
      default:
        flipOrder = options.behavior;
    }

    flipOrder.forEach(function (step, index) {
      if (placement !== step || flipOrder.length === index + 1) {
        return data;
      }

      placement = data.placement.split('-')[0];
      placementOpposite = getOppositePlacement(placement);

      var popperOffsets = data.offsets.popper;
      var refOffsets = data.offsets.reference;

      // using floor because the reference offsets may contain decimals we are not going to consider here
      var floor = Math.floor;
      var overlapsRef = placement === 'left' && floor(popperOffsets.right) > floor(refOffsets.left) || placement === 'right' && floor(popperOffsets.left) < floor(refOffsets.right) || placement === 'top' && floor(popperOffsets.bottom) > floor(refOffsets.top) || placement === 'bottom' && floor(popperOffsets.top) < floor(refOffsets.bottom);

      var overflowsLeft = floor(popperOffsets.left) < floor(boundaries.left);
      var overflowsRight = floor(popperOffsets.right) > floor(boundaries.right);
      var overflowsTop = floor(popperOffsets.top) < floor(boundaries.top);
      var overflowsBottom = floor(popperOffsets.bottom) > floor(boundaries.bottom);

      var overflowsBoundaries = placement === 'left' && overflowsLeft || placement === 'right' && overflowsRight || placement === 'top' && overflowsTop || placement === 'bottom' && overflowsBottom;

      // flip the variation if required
      var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;

      // flips variation if reference element overflows boundaries
      var flippedVariationByRef = !!options.flipVariations && (isVertical && variation === 'start' && overflowsLeft || isVertical && variation === 'end' && overflowsRight || !isVertical && variation === 'start' && overflowsTop || !isVertical && variation === 'end' && overflowsBottom);

      // flips variation if popper content overflows boundaries
      var flippedVariationByContent = !!options.flipVariationsByContent && (isVertical && variation === 'start' && overflowsRight || isVertical && variation === 'end' && overflowsLeft || !isVertical && variation === 'start' && overflowsBottom || !isVertical && variation === 'end' && overflowsTop);

      var flippedVariation = flippedVariationByRef || flippedVariationByContent;

      if (overlapsRef || overflowsBoundaries || flippedVariation) {
        // this boolean to detect any flip loop
        data.flipped = true;

        if (overlapsRef || overflowsBoundaries) {
          placement = flipOrder[index + 1];
        }

        if (flippedVariation) {
          variation = getOppositeVariation(variation);
        }

        data.placement = placement + (variation ? '-' + variation : '');

        // this object contains `position`, we want to preserve it along with
        // any additional property we may add in the future
        data.offsets.popper = _extends({}, data.offsets.popper, getPopperOffsets(data.instance.popper, data.offsets.reference, data.placement));

        data = runModifiers(data.instance.modifiers, data, 'flip');
      }
    });
    return data;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function keepTogether(data) {
    var _data$offsets = data.offsets,
        popper = _data$offsets.popper,
        reference = _data$offsets.reference;

    var placement = data.placement.split('-')[0];
    var floor = Math.floor;
    var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;
    var side = isVertical ? 'right' : 'bottom';
    var opSide = isVertical ? 'left' : 'top';
    var measurement = isVertical ? 'width' : 'height';

    if (popper[side] < floor(reference[opSide])) {
      data.offsets.popper[opSide] = floor(reference[opSide]) - popper[measurement];
    }
    if (popper[opSide] > floor(reference[side])) {
      data.offsets.popper[opSide] = floor(reference[side]);
    }

    return data;
  }

  /**
   * Converts a string containing value + unit into a px value number
   * @function
   * @memberof {modifiers~offset}
   * @private
   * @argument {String} str - Value + unit string
   * @argument {String} measurement - `height` or `width`
   * @argument {Object} popperOffsets
   * @argument {Object} referenceOffsets
   * @returns {Number|String}
   * Value in pixels, or original string if no values were extracted
   */
  function toValue(str, measurement, popperOffsets, referenceOffsets) {
    // separate value from unit
    var split = str.match(/((?:\-|\+)?\d*\.?\d*)(.*)/);
    var value = +split[1];
    var unit = split[2];

    // If it's not a number it's an operator, I guess
    if (!value) {
      return str;
    }

    if (unit.indexOf('%') === 0) {
      var element = void 0;
      switch (unit) {
        case '%p':
          element = popperOffsets;
          break;
        case '%':
        case '%r':
        default:
          element = referenceOffsets;
      }

      var rect = getClientRect(element);
      return rect[measurement] / 100 * value;
    } else if (unit === 'vh' || unit === 'vw') {
      // if is a vh or vw, we calculate the size based on the viewport
      var size = void 0;
      if (unit === 'vh') {
        size = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
      } else {
        size = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
      }
      return size / 100 * value;
    } else {
      // if is an explicit pixel unit, we get rid of the unit and keep the value
      // if is an implicit unit, it's px, and we return just the value
      return value;
    }
  }

  /**
   * Parse an `offset` string to extrapolate `x` and `y` numeric offsets.
   * @function
   * @memberof {modifiers~offset}
   * @private
   * @argument {String} offset
   * @argument {Object} popperOffsets
   * @argument {Object} referenceOffsets
   * @argument {String} basePlacement
   * @returns {Array} a two cells array with x and y offsets in numbers
   */
  function parseOffset(offset, popperOffsets, referenceOffsets, basePlacement) {
    var offsets = [0, 0];

    // Use height if placement is left or right and index is 0 otherwise use width
    // in this way the first offset will use an axis and the second one
    // will use the other one
    var useHeight = ['right', 'left'].indexOf(basePlacement) !== -1;

    // Split the offset string to obtain a list of values and operands
    // The regex addresses values with the plus or minus sign in front (+10, -20, etc)
    var fragments = offset.split(/(\+|\-)/).map(function (frag) {
      return frag.trim();
    });

    // Detect if the offset string contains a pair of values or a single one
    // they could be separated by comma or space
    var divider = fragments.indexOf(find(fragments, function (frag) {
      return frag.search(/,|\s/) !== -1;
    }));

    if (fragments[divider] && fragments[divider].indexOf(',') === -1) {
      console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');
    }

    // If divider is found, we divide the list of values and operands to divide
    // them by ofset X and Y.
    var splitRegex = /\s*,\s*|\s+/;
    var ops = divider !== -1 ? [fragments.slice(0, divider).concat([fragments[divider].split(splitRegex)[0]]), [fragments[divider].split(splitRegex)[1]].concat(fragments.slice(divider + 1))] : [fragments];

    // Convert the values with units to absolute pixels to allow our computations
    ops = ops.map(function (op, index) {
      // Most of the units rely on the orientation of the popper
      var measurement = (index === 1 ? !useHeight : useHeight) ? 'height' : 'width';
      var mergeWithPrevious = false;
      return op
      // This aggregates any `+` or `-` sign that aren't considered operators
      // e.g.: 10 + +5 => [10, +, +5]
      .reduce(function (a, b) {
        if (a[a.length - 1] === '' && ['+', '-'].indexOf(b) !== -1) {
          a[a.length - 1] = b;
          mergeWithPrevious = true;
          return a;
        } else if (mergeWithPrevious) {
          a[a.length - 1] += b;
          mergeWithPrevious = false;
          return a;
        } else {
          return a.concat(b);
        }
      }, [])
      // Here we convert the string values into number values (in px)
      .map(function (str) {
        return toValue(str, measurement, popperOffsets, referenceOffsets);
      });
    });

    // Loop trough the offsets arrays and execute the operations
    ops.forEach(function (op, index) {
      op.forEach(function (frag, index2) {
        if (isNumeric(frag)) {
          offsets[index] += frag * (op[index2 - 1] === '-' ? -1 : 1);
        }
      });
    });
    return offsets;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @argument {Number|String} options.offset=0
   * The offset value as described in the modifier description
   * @returns {Object} The data object, properly modified
   */
  function offset(data, _ref) {
    var offset = _ref.offset;
    var placement = data.placement,
        _data$offsets = data.offsets,
        popper = _data$offsets.popper,
        reference = _data$offsets.reference;

    var basePlacement = placement.split('-')[0];

    var offsets = void 0;
    if (isNumeric(+offset)) {
      offsets = [+offset, 0];
    } else {
      offsets = parseOffset(offset, popper, reference, basePlacement);
    }

    if (basePlacement === 'left') {
      popper.top += offsets[0];
      popper.left -= offsets[1];
    } else if (basePlacement === 'right') {
      popper.top += offsets[0];
      popper.left += offsets[1];
    } else if (basePlacement === 'top') {
      popper.left += offsets[0];
      popper.top -= offsets[1];
    } else if (basePlacement === 'bottom') {
      popper.left += offsets[0];
      popper.top += offsets[1];
    }

    data.popper = popper;
    return data;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function preventOverflow(data, options) {
    var boundariesElement = options.boundariesElement || getOffsetParent(data.instance.popper);

    // If offsetParent is the reference element, we really want to
    // go one step up and use the next offsetParent as reference to
    // avoid to make this modifier completely useless and look like broken
    if (data.instance.reference === boundariesElement) {
      boundariesElement = getOffsetParent(boundariesElement);
    }

    // NOTE: DOM access here
    // resets the popper's position so that the document size can be calculated excluding
    // the size of the popper element itself
    var transformProp = getSupportedPropertyName('transform');
    var popperStyles = data.instance.popper.style; // assignment to help minification
    var top = popperStyles.top,
        left = popperStyles.left,
        transform = popperStyles[transformProp];

    popperStyles.top = '';
    popperStyles.left = '';
    popperStyles[transformProp] = '';

    var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, boundariesElement, data.positionFixed);

    // NOTE: DOM access here
    // restores the original style properties after the offsets have been computed
    popperStyles.top = top;
    popperStyles.left = left;
    popperStyles[transformProp] = transform;

    options.boundaries = boundaries;

    var order = options.priority;
    var popper = data.offsets.popper;

    var check = {
      primary: function primary(placement) {
        var value = popper[placement];
        if (popper[placement] < boundaries[placement] && !options.escapeWithReference) {
          value = Math.max(popper[placement], boundaries[placement]);
        }
        return defineProperty({}, placement, value);
      },
      secondary: function secondary(placement) {
        var mainSide = placement === 'right' ? 'left' : 'top';
        var value = popper[mainSide];
        if (popper[placement] > boundaries[placement] && !options.escapeWithReference) {
          value = Math.min(popper[mainSide], boundaries[placement] - (placement === 'right' ? popper.width : popper.height));
        }
        return defineProperty({}, mainSide, value);
      }
    };

    order.forEach(function (placement) {
      var side = ['left', 'top'].indexOf(placement) !== -1 ? 'primary' : 'secondary';
      popper = _extends({}, popper, check[side](placement));
    });

    data.offsets.popper = popper;

    return data;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function shift(data) {
    var placement = data.placement;
    var basePlacement = placement.split('-')[0];
    var shiftvariation = placement.split('-')[1];

    // if shift shiftvariation is specified, run the modifier
    if (shiftvariation) {
      var _data$offsets = data.offsets,
          reference = _data$offsets.reference,
          popper = _data$offsets.popper;

      var isVertical = ['bottom', 'top'].indexOf(basePlacement) !== -1;
      var side = isVertical ? 'left' : 'top';
      var measurement = isVertical ? 'width' : 'height';

      var shiftOffsets = {
        start: defineProperty({}, side, reference[side]),
        end: defineProperty({}, side, reference[side] + reference[measurement] - popper[measurement])
      };

      data.offsets.popper = _extends({}, popper, shiftOffsets[shiftvariation]);
    }

    return data;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by update method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function hide(data) {
    if (!isModifierRequired(data.instance.modifiers, 'hide', 'preventOverflow')) {
      return data;
    }

    var refRect = data.offsets.reference;
    var bound = find(data.instance.modifiers, function (modifier) {
      return modifier.name === 'preventOverflow';
    }).boundaries;

    if (refRect.bottom < bound.top || refRect.left > bound.right || refRect.top > bound.bottom || refRect.right < bound.left) {
      // Avoid unnecessary DOM access if visibility hasn't changed
      if (data.hide === true) {
        return data;
      }

      data.hide = true;
      data.attributes['x-out-of-boundaries'] = '';
    } else {
      // Avoid unnecessary DOM access if visibility hasn't changed
      if (data.hide === false) {
        return data;
      }

      data.hide = false;
      data.attributes['x-out-of-boundaries'] = false;
    }

    return data;
  }

  /**
   * @function
   * @memberof Modifiers
   * @argument {Object} data - The data object generated by `update` method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {Object} The data object, properly modified
   */
  function inner(data) {
    var placement = data.placement;
    var basePlacement = placement.split('-')[0];
    var _data$offsets = data.offsets,
        popper = _data$offsets.popper,
        reference = _data$offsets.reference;

    var isHoriz = ['left', 'right'].indexOf(basePlacement) !== -1;

    var subtractLength = ['top', 'left'].indexOf(basePlacement) === -1;

    popper[isHoriz ? 'left' : 'top'] = reference[basePlacement] - (subtractLength ? popper[isHoriz ? 'width' : 'height'] : 0);

    data.placement = getOppositePlacement(placement);
    data.offsets.popper = getClientRect(popper);

    return data;
  }

  /**
   * Modifier function, each modifier can have a function of this type assigned
   * to its `fn` property.<br />
   * These functions will be called on each update, this means that you must
   * make sure they are performant enough to avoid performance bottlenecks.
   *
   * @function ModifierFn
   * @argument {dataObject} data - The data object generated by `update` method
   * @argument {Object} options - Modifiers configuration and options
   * @returns {dataObject} The data object, properly modified
   */

  /**
   * Modifiers are plugins used to alter the behavior of your poppers.<br />
   * Popper.js uses a set of 9 modifiers to provide all the basic functionalities
   * needed by the library.
   *
   * Usually you don't want to override the `order`, `fn` and `onLoad` props.
   * All the other properties are configurations that could be tweaked.
   * @namespace modifiers
   */
  var modifiers = {
    /**
     * Modifier used to shift the popper on the start or end of its reference
     * element.<br />
     * It will read the variation of the `placement` property.<br />
     * It can be one either `-end` or `-start`.
     * @memberof modifiers
     * @inner
     */
    shift: {
      /** @prop {number} order=100 - Index used to define the order of execution */
      order: 100,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: shift
    },

    /**
     * The `offset` modifier can shift your popper on both its axis.
     *
     * It accepts the following units:
     * - `px` or unit-less, interpreted as pixels
     * - `%` or `%r`, percentage relative to the length of the reference element
     * - `%p`, percentage relative to the length of the popper element
     * - `vw`, CSS viewport width unit
     * - `vh`, CSS viewport height unit
     *
     * For length is intended the main axis relative to the placement of the popper.<br />
     * This means that if the placement is `top` or `bottom`, the length will be the
     * `width`. In case of `left` or `right`, it will be the `height`.
     *
     * You can provide a single value (as `Number` or `String`), or a pair of values
     * as `String` divided by a comma or one (or more) white spaces.<br />
     * The latter is a deprecated method because it leads to confusion and will be
     * removed in v2.<br />
     * Additionally, it accepts additions and subtractions between different units.
     * Note that multiplications and divisions aren't supported.
     *
     * Valid examples are:
     * ```
     * 10
     * '10%'
     * '10, 10'
     * '10%, 10'
     * '10 + 10%'
     * '10 - 5vh + 3%'
     * '-10px + 5vh, 5px - 6%'
     * ```
     * > **NB**: If you desire to apply offsets to your poppers in a way that may make them overlap
     * > with their reference element, unfortunately, you will have to disable the `flip` modifier.
     * > You can read more on this at this [issue](https://github.com/FezVrasta/popper.js/issues/373).
     *
     * @memberof modifiers
     * @inner
     */
    offset: {
      /** @prop {number} order=200 - Index used to define the order of execution */
      order: 200,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: offset,
      /** @prop {Number|String} offset=0
       * The offset value as described in the modifier description
       */
      offset: 0
    },

    /**
     * Modifier used to prevent the popper from being positioned outside the boundary.
     *
     * A scenario exists where the reference itself is not within the boundaries.<br />
     * We can say it has "escaped the boundaries" — or just "escaped".<br />
     * In this case we need to decide whether the popper should either:
     *
     * - detach from the reference and remain "trapped" in the boundaries, or
     * - if it should ignore the boundary and "escape with its reference"
     *
     * When `escapeWithReference` is set to`true` and reference is completely
     * outside its boundaries, the popper will overflow (or completely leave)
     * the boundaries in order to remain attached to the edge of the reference.
     *
     * @memberof modifiers
     * @inner
     */
    preventOverflow: {
      /** @prop {number} order=300 - Index used to define the order of execution */
      order: 300,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: preventOverflow,
      /**
       * @prop {Array} [priority=['left','right','top','bottom']]
       * Popper will try to prevent overflow following these priorities by default,
       * then, it could overflow on the left and on top of the `boundariesElement`
       */
      priority: ['left', 'right', 'top', 'bottom'],
      /**
       * @prop {number} padding=5
       * Amount of pixel used to define a minimum distance between the boundaries
       * and the popper. This makes sure the popper always has a little padding
       * between the edges of its container
       */
      padding: 5,
      /**
       * @prop {String|HTMLElement} boundariesElement='scrollParent'
       * Boundaries used by the modifier. Can be `scrollParent`, `window`,
       * `viewport` or any DOM element.
       */
      boundariesElement: 'scrollParent'
    },

    /**
     * Modifier used to make sure the reference and its popper stay near each other
     * without leaving any gap between the two. Especially useful when the arrow is
     * enabled and you want to ensure that it points to its reference element.
     * It cares only about the first axis. You can still have poppers with margin
     * between the popper and its reference element.
     * @memberof modifiers
     * @inner
     */
    keepTogether: {
      /** @prop {number} order=400 - Index used to define the order of execution */
      order: 400,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: keepTogether
    },

    /**
     * This modifier is used to move the `arrowElement` of the popper to make
     * sure it is positioned between the reference element and its popper element.
     * It will read the outer size of the `arrowElement` node to detect how many
     * pixels of conjunction are needed.
     *
     * It has no effect if no `arrowElement` is provided.
     * @memberof modifiers
     * @inner
     */
    arrow: {
      /** @prop {number} order=500 - Index used to define the order of execution */
      order: 500,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: arrow,
      /** @prop {String|HTMLElement} element='[x-arrow]' - Selector or node used as arrow */
      element: '[x-arrow]'
    },

    /**
     * Modifier used to flip the popper's placement when it starts to overlap its
     * reference element.
     *
     * Requires the `preventOverflow` modifier before it in order to work.
     *
     * **NOTE:** this modifier will interrupt the current update cycle and will
     * restart it if it detects the need to flip the placement.
     * @memberof modifiers
     * @inner
     */
    flip: {
      /** @prop {number} order=600 - Index used to define the order of execution */
      order: 600,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: flip,
      /**
       * @prop {String|Array} behavior='flip'
       * The behavior used to change the popper's placement. It can be one of
       * `flip`, `clockwise`, `counterclockwise` or an array with a list of valid
       * placements (with optional variations)
       */
      behavior: 'flip',
      /**
       * @prop {number} padding=5
       * The popper will flip if it hits the edges of the `boundariesElement`
       */
      padding: 5,
      /**
       * @prop {String|HTMLElement} boundariesElement='viewport'
       * The element which will define the boundaries of the popper position.
       * The popper will never be placed outside of the defined boundaries
       * (except if `keepTogether` is enabled)
       */
      boundariesElement: 'viewport',
      /**
       * @prop {Boolean} flipVariations=false
       * The popper will switch placement variation between `-start` and `-end` when
       * the reference element overlaps its boundaries.
       *
       * The original placement should have a set variation.
       */
      flipVariations: false,
      /**
       * @prop {Boolean} flipVariationsByContent=false
       * The popper will switch placement variation between `-start` and `-end` when
       * the popper element overlaps its reference boundaries.
       *
       * The original placement should have a set variation.
       */
      flipVariationsByContent: false
    },

    /**
     * Modifier used to make the popper flow toward the inner of the reference element.
     * By default, when this modifier is disabled, the popper will be placed outside
     * the reference element.
     * @memberof modifiers
     * @inner
     */
    inner: {
      /** @prop {number} order=700 - Index used to define the order of execution */
      order: 700,
      /** @prop {Boolean} enabled=false - Whether the modifier is enabled or not */
      enabled: false,
      /** @prop {ModifierFn} */
      fn: inner
    },

    /**
     * Modifier used to hide the popper when its reference element is outside of the
     * popper boundaries. It will set a `x-out-of-boundaries` attribute which can
     * be used to hide with a CSS selector the popper when its reference is
     * out of boundaries.
     *
     * Requires the `preventOverflow` modifier before it in order to work.
     * @memberof modifiers
     * @inner
     */
    hide: {
      /** @prop {number} order=800 - Index used to define the order of execution */
      order: 800,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: hide
    },

    /**
     * Computes the style that will be applied to the popper element to gets
     * properly positioned.
     *
     * Note that this modifier will not touch the DOM, it just prepares the styles
     * so that `applyStyle` modifier can apply it. This separation is useful
     * in case you need to replace `applyStyle` with a custom implementation.
     *
     * This modifier has `850` as `order` value to maintain backward compatibility
     * with previous versions of Popper.js. Expect the modifiers ordering method
     * to change in future major versions of the library.
     *
     * @memberof modifiers
     * @inner
     */
    computeStyle: {
      /** @prop {number} order=850 - Index used to define the order of execution */
      order: 850,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: computeStyle,
      /**
       * @prop {Boolean} gpuAcceleration=true
       * If true, it uses the CSS 3D transformation to position the popper.
       * Otherwise, it will use the `top` and `left` properties
       */
      gpuAcceleration: true,
      /**
       * @prop {string} [x='bottom']
       * Where to anchor the X axis (`bottom` or `top`). AKA X offset origin.
       * Change this if your popper should grow in a direction different from `bottom`
       */
      x: 'bottom',
      /**
       * @prop {string} [x='left']
       * Where to anchor the Y axis (`left` or `right`). AKA Y offset origin.
       * Change this if your popper should grow in a direction different from `right`
       */
      y: 'right'
    },

    /**
     * Applies the computed styles to the popper element.
     *
     * All the DOM manipulations are limited to this modifier. This is useful in case
     * you want to integrate Popper.js inside a framework or view library and you
     * want to delegate all the DOM manipulations to it.
     *
     * Note that if you disable this modifier, you must make sure the popper element
     * has its position set to `absolute` before Popper.js can do its work!
     *
     * Just disable this modifier and define your own to achieve the desired effect.
     *
     * @memberof modifiers
     * @inner
     */
    applyStyle: {
      /** @prop {number} order=900 - Index used to define the order of execution */
      order: 900,
      /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
      enabled: true,
      /** @prop {ModifierFn} */
      fn: applyStyle,
      /** @prop {Function} */
      onLoad: applyStyleOnLoad,
      /**
       * @deprecated since version 1.10.0, the property moved to `computeStyle` modifier
       * @prop {Boolean} gpuAcceleration=true
       * If true, it uses the CSS 3D transformation to position the popper.
       * Otherwise, it will use the `top` and `left` properties
       */
      gpuAcceleration: undefined
    }
  };

  /**
   * The `dataObject` is an object containing all the information used by Popper.js.
   * This object is passed to modifiers and to the `onCreate` and `onUpdate` callbacks.
   * @name dataObject
   * @property {Object} data.instance The Popper.js instance
   * @property {String} data.placement Placement applied to popper
   * @property {String} data.originalPlacement Placement originally defined on init
   * @property {Boolean} data.flipped True if popper has been flipped by flip modifier
   * @property {Boolean} data.hide True if the reference element is out of boundaries, useful to know when to hide the popper
   * @property {HTMLElement} data.arrowElement Node used as arrow by arrow modifier
   * @property {Object} data.styles Any CSS property defined here will be applied to the popper. It expects the JavaScript nomenclature (eg. `marginBottom`)
   * @property {Object} data.arrowStyles Any CSS property defined here will be applied to the popper arrow. It expects the JavaScript nomenclature (eg. `marginBottom`)
   * @property {Object} data.boundaries Offsets of the popper boundaries
   * @property {Object} data.offsets The measurements of popper, reference and arrow elements
   * @property {Object} data.offsets.popper `top`, `left`, `width`, `height` values
   * @property {Object} data.offsets.reference `top`, `left`, `width`, `height` values
   * @property {Object} data.offsets.arrow] `top` and `left` offsets, only one of them will be different from 0
   */

  /**
   * Default options provided to Popper.js constructor.<br />
   * These can be overridden using the `options` argument of Popper.js.<br />
   * To override an option, simply pass an object with the same
   * structure of the `options` object, as the 3rd argument. For example:
   * ```
   * new Popper(ref, pop, {
   *   modifiers: {
   *     preventOverflow: { enabled: false }
   *   }
   * })
   * ```
   * @type {Object}
   * @static
   * @memberof Popper
   */
  var Defaults = {
    /**
     * Popper's placement.
     * @prop {Popper.placements} placement='bottom'
     */
    placement: 'bottom',

    /**
     * Set this to true if you want popper to position it self in 'fixed' mode
     * @prop {Boolean} positionFixed=false
     */
    positionFixed: false,

    /**
     * Whether events (resize, scroll) are initially enabled.
     * @prop {Boolean} eventsEnabled=true
     */
    eventsEnabled: true,

    /**
     * Set to true if you want to automatically remove the popper when
     * you call the `destroy` method.
     * @prop {Boolean} removeOnDestroy=false
     */
    removeOnDestroy: false,

    /**
     * Callback called when the popper is created.<br />
     * By default, it is set to no-op.<br />
     * Access Popper.js instance with `data.instance`.
     * @prop {onCreate}
     */
    onCreate: function onCreate() {},

    /**
     * Callback called when the popper is updated. This callback is not called
     * on the initialization/creation of the popper, but only on subsequent
     * updates.<br />
     * By default, it is set to no-op.<br />
     * Access Popper.js instance with `data.instance`.
     * @prop {onUpdate}
     */
    onUpdate: function onUpdate() {},

    /**
     * List of modifiers used to modify the offsets before they are applied to the popper.
     * They provide most of the functionalities of Popper.js.
     * @prop {modifiers}
     */
    modifiers: modifiers
  };

  /**
   * @callback onCreate
   * @param {dataObject} data
   */

  /**
   * @callback onUpdate
   * @param {dataObject} data
   */

  // Utils
  // Methods
  var Popper = function () {
    /**
     * Creates a new Popper.js instance.
     * @class Popper
     * @param {Element|referenceObject} reference - The reference element used to position the popper
     * @param {Element} popper - The HTML / XML element used as the popper
     * @param {Object} options - Your custom options to override the ones defined in [Defaults](#defaults)
     * @return {Object} instance - The generated Popper.js instance
     */
    function Popper(reference, popper) {
      var _this = this;

      var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
      classCallCheck(this, Popper);

      this.scheduleUpdate = function () {
        return requestAnimationFrame(_this.update);
      };

      // make update() debounced, so that it only runs at most once-per-tick
      this.update = debounce(this.update.bind(this));

      // with {} we create a new object with the options inside it
      this.options = _extends({}, Popper.Defaults, options);

      // init state
      this.state = {
        isDestroyed: false,
        isCreated: false,
        scrollParents: []
      };

      // get reference and popper elements (allow jQuery wrappers)
      this.reference = reference && reference.jquery ? reference[0] : reference;
      this.popper = popper && popper.jquery ? popper[0] : popper;

      // Deep merge modifiers options
      this.options.modifiers = {};
      Object.keys(_extends({}, Popper.Defaults.modifiers, options.modifiers)).forEach(function (name) {
        _this.options.modifiers[name] = _extends({}, Popper.Defaults.modifiers[name] || {}, options.modifiers ? options.modifiers[name] : {});
      });

      // Refactoring modifiers' list (Object => Array)
      this.modifiers = Object.keys(this.options.modifiers).map(function (name) {
        return _extends({
          name: name
        }, _this.options.modifiers[name]);
      })
      // sort the modifiers by order
      .sort(function (a, b) {
        return a.order - b.order;
      });

      // modifiers have the ability to execute arbitrary code when Popper.js get inited
      // such code is executed in the same order of its modifier
      // they could add new properties to their options configuration
      // BE AWARE: don't add options to `options.modifiers.name` but to `modifierOptions`!
      this.modifiers.forEach(function (modifierOptions) {
        if (modifierOptions.enabled && isFunction(modifierOptions.onLoad)) {
          modifierOptions.onLoad(_this.reference, _this.popper, _this.options, modifierOptions, _this.state);
        }
      });

      // fire the first update to position the popper in the right place
      this.update();

      var eventsEnabled = this.options.eventsEnabled;
      if (eventsEnabled) {
        // setup event listeners, they will take care of update the position in specific situations
        this.enableEventListeners();
      }

      this.state.eventsEnabled = eventsEnabled;
    }

    // We can't use class properties because they don't get listed in the
    // class prototype and break stuff like Sinon stubs


    createClass(Popper, [{
      key: 'update',
      value: function update$$1() {
        return update.call(this);
      }
    }, {
      key: 'destroy',
      value: function destroy$$1() {
        return destroy.call(this);
      }
    }, {
      key: 'enableEventListeners',
      value: function enableEventListeners$$1() {
        return enableEventListeners.call(this);
      }
    }, {
      key: 'disableEventListeners',
      value: function disableEventListeners$$1() {
        return disableEventListeners.call(this);
      }

      /**
       * Schedules an update. It will run on the next UI update available.
       * @method scheduleUpdate
       * @memberof Popper
       */


      /**
       * Collection of utilities useful when writing custom modifiers.
       * Starting from version 1.7, this method is available only if you
       * include `popper-utils.js` before `popper.js`.
       *
       * **DEPRECATION**: This way to access PopperUtils is deprecated
       * and will be removed in v2! Use the PopperUtils module directly instead.
       * Due to the high instability of the methods contained in Utils, we can't
       * guarantee them to follow semver. Use them at your own risk!
       * @static
       * @private
       * @type {Object}
       * @deprecated since version 1.8
       * @member Utils
       * @memberof Popper
       */

    }]);
    return Popper;
  }();

  /**
   * The `referenceObject` is an object that provides an interface compatible with Popper.js
   * and lets you use it as replacement of a real DOM node.<br />
   * You can use this method to position a popper relatively to a set of coordinates
   * in case you don't have a DOM node to use as reference.
   *
   * ```
   * new Popper(referenceObject, popperNode);
   * ```
   *
   * NB: This feature isn't supported in Internet Explorer 10.
   * @name referenceObject
   * @property {Function} data.getBoundingClientRect
   * A function that returns a set of coordinates compatible with the native `getBoundingClientRect` method.
   * @property {number} data.clientWidth
   * An ES6 getter that will return the width of the virtual reference element.
   * @property {number} data.clientHeight
   * An ES6 getter that will return the height of the virtual reference element.
   */


  Popper.Utils = (typeof window !== 'undefined' ? window : global).PopperUtils;
  Popper.placements = placements;
  Popper.Defaults = Defaults;

  var Popper$1 = Popper;

  /**
   * Constants
   */

  var NAME$6 = 'dropdown';
  var VERSION$6 = '4.6.1';
  var DATA_KEY$6 = 'bs.dropdown';
  var EVENT_KEY$6 = "." + DATA_KEY$6;
  var DATA_API_KEY$3 = '.data-api';
  var JQUERY_NO_CONFLICT$6 = $__default["default"].fn[NAME$6];
  var ESCAPE_KEYCODE$1 = 27; // KeyboardEvent.which value for Escape (Esc) key

  var SPACE_KEYCODE = 32; // KeyboardEvent.which value for space key

  var TAB_KEYCODE = 9; // KeyboardEvent.which value for tab key

  var ARROW_UP_KEYCODE = 38; // KeyboardEvent.which value for up arrow key

  var ARROW_DOWN_KEYCODE = 40; // KeyboardEvent.which value for down arrow key

  var RIGHT_MOUSE_BUTTON_WHICH = 3; // MouseEvent.which value for the right button (assuming a right-handed mouse)

  var REGEXP_KEYDOWN = new RegExp(ARROW_UP_KEYCODE + "|" + ARROW_DOWN_KEYCODE + "|" + ESCAPE_KEYCODE$1);
  var CLASS_NAME_DISABLED$1 = 'disabled';
  var CLASS_NAME_SHOW$5 = 'show';
  var CLASS_NAME_DROPUP = 'dropup';
  var CLASS_NAME_DROPRIGHT = 'dropright';
  var CLASS_NAME_DROPLEFT = 'dropleft';
  var CLASS_NAME_MENURIGHT = 'dropdown-menu-right';
  var CLASS_NAME_POSITION_STATIC = 'position-static';
  var EVENT_HIDE$3 = "hide" + EVENT_KEY$6;
  var EVENT_HIDDEN$3 = "hidden" + EVENT_KEY$6;
  var EVENT_SHOW$3 = "show" + EVENT_KEY$6;
  var EVENT_SHOWN$3 = "shown" + EVENT_KEY$6;
  var EVENT_CLICK = "click" + EVENT_KEY$6;
  var EVENT_CLICK_DATA_API$2 = "click" + EVENT_KEY$6 + DATA_API_KEY$3;
  var EVENT_KEYDOWN_DATA_API = "keydown" + EVENT_KEY$6 + DATA_API_KEY$3;
  var EVENT_KEYUP_DATA_API = "keyup" + EVENT_KEY$6 + DATA_API_KEY$3;
  var SELECTOR_DATA_TOGGLE$2 = '[data-toggle="dropdown"]';
  var SELECTOR_FORM_CHILD = '.dropdown form';
  var SELECTOR_MENU = '.dropdown-menu';
  var SELECTOR_NAVBAR_NAV = '.navbar-nav';
  var SELECTOR_VISIBLE_ITEMS = '.dropdown-menu .dropdown-item:not(.disabled):not(:disabled)';
  var PLACEMENT_TOP = 'top-start';
  var PLACEMENT_TOPEND = 'top-end';
  var PLACEMENT_BOTTOM = 'bottom-start';
  var PLACEMENT_BOTTOMEND = 'bottom-end';
  var PLACEMENT_RIGHT = 'right-start';
  var PLACEMENT_LEFT = 'left-start';
  var Default$5 = {
    offset: 0,
    flip: true,
    boundary: 'scrollParent',
    reference: 'toggle',
    display: 'dynamic',
    popperConfig: null
  };
  var DefaultType$5 = {
    offset: '(number|string|function)',
    flip: 'boolean',
    boundary: '(string|element)',
    reference: '(string|element)',
    display: 'string',
    popperConfig: '(null|object)'
  };
  /**
   * Class definition
   */

  var Dropdown = /*#__PURE__*/function () {
    function Dropdown(element, config) {
      this._element = element;
      this._popper = null;
      this._config = this._getConfig(config);
      this._menu = this._getMenuElement();
      this._inNavbar = this._detectNavbar();

      this._addEventListeners();
    } // Getters


    var _proto = Dropdown.prototype;

    // Public
    _proto.toggle = function toggle() {
      if (this._element.disabled || $__default["default"](this._element).hasClass(CLASS_NAME_DISABLED$1)) {
        return;
      }

      var isActive = $__default["default"](this._menu).hasClass(CLASS_NAME_SHOW$5);

      Dropdown._clearMenus();

      if (isActive) {
        return;
      }

      this.show(true);
    };

    _proto.show = function show(usePopper) {
      if (usePopper === void 0) {
        usePopper = false;
      }

      if (this._element.disabled || $__default["default"](this._element).hasClass(CLASS_NAME_DISABLED$1) || $__default["default"](this._menu).hasClass(CLASS_NAME_SHOW$5)) {
        return;
      }

      var relatedTarget = {
        relatedTarget: this._element
      };
      var showEvent = $__default["default"].Event(EVENT_SHOW$3, relatedTarget);

      var parent = Dropdown._getParentFromElement(this._element);

      $__default["default"](parent).trigger(showEvent);

      if (showEvent.isDefaultPrevented()) {
        return;
      } // Totally disable Popper for Dropdowns in Navbar


      if (!this._inNavbar && usePopper) {
        // Check for Popper dependency
        if (typeof Popper$1 === 'undefined') {
          throw new TypeError('Bootstrap\'s dropdowns require Popper (https://popper.js.org)');
        }

        var referenceElement = this._element;

        if (this._config.reference === 'parent') {
          referenceElement = parent;
        } else if (Util.isElement(this._config.reference)) {
          referenceElement = this._config.reference; // Check if it's jQuery element

          if (typeof this._config.reference.jquery !== 'undefined') {
            referenceElement = this._config.reference[0];
          }
        } // If boundary is not `scrollParent`, then set position to `static`
        // to allow the menu to "escape" the scroll parent's boundaries
        // https://github.com/twbs/bootstrap/issues/24251


        if (this._config.boundary !== 'scrollParent') {
          $__default["default"](parent).addClass(CLASS_NAME_POSITION_STATIC);
        }

        this._popper = new Popper$1(referenceElement, this._menu, this._getPopperConfig());
      } // If this is a touch-enabled device we add extra
      // empty mouseover listeners to the body's immediate children;
      // only needed because of broken event delegation on iOS
      // https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html


      if ('ontouchstart' in document.documentElement && $__default["default"](parent).closest(SELECTOR_NAVBAR_NAV).length === 0) {
        $__default["default"](document.body).children().on('mouseover', null, $__default["default"].noop);
      }

      this._element.focus();

      this._element.setAttribute('aria-expanded', true);

      $__default["default"](this._menu).toggleClass(CLASS_NAME_SHOW$5);
      $__default["default"](parent).toggleClass(CLASS_NAME_SHOW$5).trigger($__default["default"].Event(EVENT_SHOWN$3, relatedTarget));
    };

    _proto.hide = function hide() {
      if (this._element.disabled || $__default["default"](this._element).hasClass(CLASS_NAME_DISABLED$1) || !$__default["default"](this._menu).hasClass(CLASS_NAME_SHOW$5)) {
        return;
      }

      var relatedTarget = {
        relatedTarget: this._element
      };
      var hideEvent = $__default["default"].Event(EVENT_HIDE$3, relatedTarget);

      var parent = Dropdown._getParentFromElement(this._element);

      $__default["default"](parent).trigger(hideEvent);

      if (hideEvent.isDefaultPrevented()) {
        return;
      }

      if (this._popper) {
        this._popper.destroy();
      }

      $__default["default"](this._menu).toggleClass(CLASS_NAME_SHOW$5);
      $__default["default"](parent).toggleClass(CLASS_NAME_SHOW$5).trigger($__default["default"].Event(EVENT_HIDDEN$3, relatedTarget));
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$6);
      $__default["default"](this._element).off(EVENT_KEY$6);
      this._element = null;
      this._menu = null;

      if (this._popper !== null) {
        this._popper.destroy();

        this._popper = null;
      }
    };

    _proto.update = function update() {
      this._inNavbar = this._detectNavbar();

      if (this._popper !== null) {
        this._popper.scheduleUpdate();
      }
    } // Private
    ;

    _proto._addEventListeners = function _addEventListeners() {
      var _this = this;

      $__default["default"](this._element).on(EVENT_CLICK, function (event) {
        event.preventDefault();
        event.stopPropagation();

        _this.toggle();
      });
    };

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, this.constructor.Default, $__default["default"](this._element).data(), config);
      Util.typeCheckConfig(NAME$6, config, this.constructor.DefaultType);
      return config;
    };

    _proto._getMenuElement = function _getMenuElement() {
      if (!this._menu) {
        var parent = Dropdown._getParentFromElement(this._element);

        if (parent) {
          this._menu = parent.querySelector(SELECTOR_MENU);
        }
      }

      return this._menu;
    };

    _proto._getPlacement = function _getPlacement() {
      var $parentDropdown = $__default["default"](this._element.parentNode);
      var placement = PLACEMENT_BOTTOM; // Handle dropup

      if ($parentDropdown.hasClass(CLASS_NAME_DROPUP)) {
        placement = $__default["default"](this._menu).hasClass(CLASS_NAME_MENURIGHT) ? PLACEMENT_TOPEND : PLACEMENT_TOP;
      } else if ($parentDropdown.hasClass(CLASS_NAME_DROPRIGHT)) {
        placement = PLACEMENT_RIGHT;
      } else if ($parentDropdown.hasClass(CLASS_NAME_DROPLEFT)) {
        placement = PLACEMENT_LEFT;
      } else if ($__default["default"](this._menu).hasClass(CLASS_NAME_MENURIGHT)) {
        placement = PLACEMENT_BOTTOMEND;
      }

      return placement;
    };

    _proto._detectNavbar = function _detectNavbar() {
      return $__default["default"](this._element).closest('.navbar').length > 0;
    };

    _proto._getOffset = function _getOffset() {
      var _this2 = this;

      var offset = {};

      if (typeof this._config.offset === 'function') {
        offset.fn = function (data) {
          data.offsets = _extends$1({}, data.offsets, _this2._config.offset(data.offsets, _this2._element));
          return data;
        };
      } else {
        offset.offset = this._config.offset;
      }

      return offset;
    };

    _proto._getPopperConfig = function _getPopperConfig() {
      var popperConfig = {
        placement: this._getPlacement(),
        modifiers: {
          offset: this._getOffset(),
          flip: {
            enabled: this._config.flip
          },
          preventOverflow: {
            boundariesElement: this._config.boundary
          }
        }
      }; // Disable Popper if we have a static display

      if (this._config.display === 'static') {
        popperConfig.modifiers.applyStyle = {
          enabled: false
        };
      }

      return _extends$1({}, popperConfig, this._config.popperConfig);
    } // Static
    ;

    Dropdown._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var data = $__default["default"](this).data(DATA_KEY$6);

        var _config = typeof config === 'object' ? config : null;

        if (!data) {
          data = new Dropdown(this, _config);
          $__default["default"](this).data(DATA_KEY$6, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    Dropdown._clearMenus = function _clearMenus(event) {
      if (event && (event.which === RIGHT_MOUSE_BUTTON_WHICH || event.type === 'keyup' && event.which !== TAB_KEYCODE)) {
        return;
      }

      var toggles = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLE$2));

      for (var i = 0, len = toggles.length; i < len; i++) {
        var parent = Dropdown._getParentFromElement(toggles[i]);

        var context = $__default["default"](toggles[i]).data(DATA_KEY$6);
        var relatedTarget = {
          relatedTarget: toggles[i]
        };

        if (event && event.type === 'click') {
          relatedTarget.clickEvent = event;
        }

        if (!context) {
          continue;
        }

        var dropdownMenu = context._menu;

        if (!$__default["default"](parent).hasClass(CLASS_NAME_SHOW$5)) {
          continue;
        }

        if (event && (event.type === 'click' && /input|textarea/i.test(event.target.tagName) || event.type === 'keyup' && event.which === TAB_KEYCODE) && $__default["default"].contains(parent, event.target)) {
          continue;
        }

        var hideEvent = $__default["default"].Event(EVENT_HIDE$3, relatedTarget);
        $__default["default"](parent).trigger(hideEvent);

        if (hideEvent.isDefaultPrevented()) {
          continue;
        } // If this is a touch-enabled device we remove the extra
        // empty mouseover listeners we added for iOS support


        if ('ontouchstart' in document.documentElement) {
          $__default["default"](document.body).children().off('mouseover', null, $__default["default"].noop);
        }

        toggles[i].setAttribute('aria-expanded', 'false');

        if (context._popper) {
          context._popper.destroy();
        }

        $__default["default"](dropdownMenu).removeClass(CLASS_NAME_SHOW$5);
        $__default["default"](parent).removeClass(CLASS_NAME_SHOW$5).trigger($__default["default"].Event(EVENT_HIDDEN$3, relatedTarget));
      }
    };

    Dropdown._getParentFromElement = function _getParentFromElement(element) {
      var parent;
      var selector = Util.getSelectorFromElement(element);

      if (selector) {
        parent = document.querySelector(selector);
      }

      return parent || element.parentNode;
    } // eslint-disable-next-line complexity
    ;

    Dropdown._dataApiKeydownHandler = function _dataApiKeydownHandler(event) {
      // If not input/textarea:
      //  - And not a key in REGEXP_KEYDOWN => not a dropdown command
      // If input/textarea:
      //  - If space key => not a dropdown command
      //  - If key is other than escape
      //    - If key is not up or down => not a dropdown command
      //    - If trigger inside the menu => not a dropdown command
      if (/input|textarea/i.test(event.target.tagName) ? event.which === SPACE_KEYCODE || event.which !== ESCAPE_KEYCODE$1 && (event.which !== ARROW_DOWN_KEYCODE && event.which !== ARROW_UP_KEYCODE || $__default["default"](event.target).closest(SELECTOR_MENU).length) : !REGEXP_KEYDOWN.test(event.which)) {
        return;
      }

      if (this.disabled || $__default["default"](this).hasClass(CLASS_NAME_DISABLED$1)) {
        return;
      }

      var parent = Dropdown._getParentFromElement(this);

      var isActive = $__default["default"](parent).hasClass(CLASS_NAME_SHOW$5);

      if (!isActive && event.which === ESCAPE_KEYCODE$1) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();

      if (!isActive || event.which === ESCAPE_KEYCODE$1 || event.which === SPACE_KEYCODE) {
        if (event.which === ESCAPE_KEYCODE$1) {
          $__default["default"](parent.querySelector(SELECTOR_DATA_TOGGLE$2)).trigger('focus');
        }

        $__default["default"](this).trigger('click');
        return;
      }

      var items = [].slice.call(parent.querySelectorAll(SELECTOR_VISIBLE_ITEMS)).filter(function (item) {
        return $__default["default"](item).is(':visible');
      });

      if (items.length === 0) {
        return;
      }

      var index = items.indexOf(event.target);

      if (event.which === ARROW_UP_KEYCODE && index > 0) {
        // Up
        index--;
      }

      if (event.which === ARROW_DOWN_KEYCODE && index < items.length - 1) {
        // Down
        index++;
      }

      if (index < 0) {
        index = 0;
      }

      items[index].focus();
    };

    _createClass(Dropdown, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$6;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$5;
      }
    }, {
      key: "DefaultType",
      get: function get() {
        return DefaultType$5;
      }
    }]);

    return Dropdown;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_KEYDOWN_DATA_API, SELECTOR_DATA_TOGGLE$2, Dropdown._dataApiKeydownHandler).on(EVENT_KEYDOWN_DATA_API, SELECTOR_MENU, Dropdown._dataApiKeydownHandler).on(EVENT_CLICK_DATA_API$2 + " " + EVENT_KEYUP_DATA_API, Dropdown._clearMenus).on(EVENT_CLICK_DATA_API$2, SELECTOR_DATA_TOGGLE$2, function (event) {
    event.preventDefault();
    event.stopPropagation();

    Dropdown._jQueryInterface.call($__default["default"](this), 'toggle');
  }).on(EVENT_CLICK_DATA_API$2, SELECTOR_FORM_CHILD, function (e) {
    e.stopPropagation();
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$6] = Dropdown._jQueryInterface;
  $__default["default"].fn[NAME$6].Constructor = Dropdown;

  $__default["default"].fn[NAME$6].noConflict = function () {
    $__default["default"].fn[NAME$6] = JQUERY_NO_CONFLICT$6;
    return Dropdown._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$5 = 'modal';
  var VERSION$5 = '4.6.1';
  var DATA_KEY$5 = 'bs.modal';
  var EVENT_KEY$5 = "." + DATA_KEY$5;
  var DATA_API_KEY$2 = '.data-api';
  var JQUERY_NO_CONFLICT$5 = $__default["default"].fn[NAME$5];
  var ESCAPE_KEYCODE = 27; // KeyboardEvent.which value for Escape (Esc) key

  var CLASS_NAME_SCROLLABLE = 'modal-dialog-scrollable';
  var CLASS_NAME_SCROLLBAR_MEASURER = 'modal-scrollbar-measure';
  var CLASS_NAME_BACKDROP = 'modal-backdrop';
  var CLASS_NAME_OPEN = 'modal-open';
  var CLASS_NAME_FADE$4 = 'fade';
  var CLASS_NAME_SHOW$4 = 'show';
  var CLASS_NAME_STATIC = 'modal-static';
  var EVENT_HIDE$2 = "hide" + EVENT_KEY$5;
  var EVENT_HIDE_PREVENTED = "hidePrevented" + EVENT_KEY$5;
  var EVENT_HIDDEN$2 = "hidden" + EVENT_KEY$5;
  var EVENT_SHOW$2 = "show" + EVENT_KEY$5;
  var EVENT_SHOWN$2 = "shown" + EVENT_KEY$5;
  var EVENT_FOCUSIN = "focusin" + EVENT_KEY$5;
  var EVENT_RESIZE = "resize" + EVENT_KEY$5;
  var EVENT_CLICK_DISMISS$1 = "click.dismiss" + EVENT_KEY$5;
  var EVENT_KEYDOWN_DISMISS = "keydown.dismiss" + EVENT_KEY$5;
  var EVENT_MOUSEUP_DISMISS = "mouseup.dismiss" + EVENT_KEY$5;
  var EVENT_MOUSEDOWN_DISMISS = "mousedown.dismiss" + EVENT_KEY$5;
  var EVENT_CLICK_DATA_API$1 = "click" + EVENT_KEY$5 + DATA_API_KEY$2;
  var SELECTOR_DIALOG = '.modal-dialog';
  var SELECTOR_MODAL_BODY = '.modal-body';
  var SELECTOR_DATA_TOGGLE$1 = '[data-toggle="modal"]';
  var SELECTOR_DATA_DISMISS$1 = '[data-dismiss="modal"]';
  var SELECTOR_FIXED_CONTENT = '.fixed-top, .fixed-bottom, .is-fixed, .sticky-top';
  var SELECTOR_STICKY_CONTENT = '.sticky-top';
  var Default$4 = {
    backdrop: true,
    keyboard: true,
    focus: true,
    show: true
  };
  var DefaultType$4 = {
    backdrop: '(boolean|string)',
    keyboard: 'boolean',
    focus: 'boolean',
    show: 'boolean'
  };
  /**
   * Class definition
   */

  var Modal = /*#__PURE__*/function () {
    function Modal(element, config) {
      this._config = this._getConfig(config);
      this._element = element;
      this._dialog = element.querySelector(SELECTOR_DIALOG);
      this._backdrop = null;
      this._isShown = false;
      this._isBodyOverflowing = false;
      this._ignoreBackdropClick = false;
      this._isTransitioning = false;
      this._scrollbarWidth = 0;
    } // Getters


    var _proto = Modal.prototype;

    // Public
    _proto.toggle = function toggle(relatedTarget) {
      return this._isShown ? this.hide() : this.show(relatedTarget);
    };

    _proto.show = function show(relatedTarget) {
      var _this = this;

      if (this._isShown || this._isTransitioning) {
        return;
      }

      var showEvent = $__default["default"].Event(EVENT_SHOW$2, {
        relatedTarget: relatedTarget
      });
      $__default["default"](this._element).trigger(showEvent);

      if (showEvent.isDefaultPrevented()) {
        return;
      }

      this._isShown = true;

      if ($__default["default"](this._element).hasClass(CLASS_NAME_FADE$4)) {
        this._isTransitioning = true;
      }

      this._checkScrollbar();

      this._setScrollbar();

      this._adjustDialog();

      this._setEscapeEvent();

      this._setResizeEvent();

      $__default["default"](this._element).on(EVENT_CLICK_DISMISS$1, SELECTOR_DATA_DISMISS$1, function (event) {
        return _this.hide(event);
      });
      $__default["default"](this._dialog).on(EVENT_MOUSEDOWN_DISMISS, function () {
        $__default["default"](_this._element).one(EVENT_MOUSEUP_DISMISS, function (event) {
          if ($__default["default"](event.target).is(_this._element)) {
            _this._ignoreBackdropClick = true;
          }
        });
      });

      this._showBackdrop(function () {
        return _this._showElement(relatedTarget);
      });
    };

    _proto.hide = function hide(event) {
      var _this2 = this;

      if (event) {
        event.preventDefault();
      }

      if (!this._isShown || this._isTransitioning) {
        return;
      }

      var hideEvent = $__default["default"].Event(EVENT_HIDE$2);
      $__default["default"](this._element).trigger(hideEvent);

      if (!this._isShown || hideEvent.isDefaultPrevented()) {
        return;
      }

      this._isShown = false;
      var transition = $__default["default"](this._element).hasClass(CLASS_NAME_FADE$4);

      if (transition) {
        this._isTransitioning = true;
      }

      this._setEscapeEvent();

      this._setResizeEvent();

      $__default["default"](document).off(EVENT_FOCUSIN);
      $__default["default"](this._element).removeClass(CLASS_NAME_SHOW$4);
      $__default["default"](this._element).off(EVENT_CLICK_DISMISS$1);
      $__default["default"](this._dialog).off(EVENT_MOUSEDOWN_DISMISS);

      if (transition) {
        var transitionDuration = Util.getTransitionDurationFromElement(this._element);
        $__default["default"](this._element).one(Util.TRANSITION_END, function (event) {
          return _this2._hideModal(event);
        }).emulateTransitionEnd(transitionDuration);
      } else {
        this._hideModal();
      }
    };

    _proto.dispose = function dispose() {
      [window, this._element, this._dialog].forEach(function (htmlElement) {
        return $__default["default"](htmlElement).off(EVENT_KEY$5);
      });
      /**
       * `document` has 2 events `EVENT_FOCUSIN` and `EVENT_CLICK_DATA_API`
       * Do not move `document` in `htmlElements` array
       * It will remove `EVENT_CLICK_DATA_API` event that should remain
       */

      $__default["default"](document).off(EVENT_FOCUSIN);
      $__default["default"].removeData(this._element, DATA_KEY$5);
      this._config = null;
      this._element = null;
      this._dialog = null;
      this._backdrop = null;
      this._isShown = null;
      this._isBodyOverflowing = null;
      this._ignoreBackdropClick = null;
      this._isTransitioning = null;
      this._scrollbarWidth = null;
    };

    _proto.handleUpdate = function handleUpdate() {
      this._adjustDialog();
    } // Private
    ;

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, Default$4, config);
      Util.typeCheckConfig(NAME$5, config, DefaultType$4);
      return config;
    };

    _proto._triggerBackdropTransition = function _triggerBackdropTransition() {
      var _this3 = this;

      var hideEventPrevented = $__default["default"].Event(EVENT_HIDE_PREVENTED);
      $__default["default"](this._element).trigger(hideEventPrevented);

      if (hideEventPrevented.isDefaultPrevented()) {
        return;
      }

      var isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;

      if (!isModalOverflowing) {
        this._element.style.overflowY = 'hidden';
      }

      this._element.classList.add(CLASS_NAME_STATIC);

      var modalTransitionDuration = Util.getTransitionDurationFromElement(this._dialog);
      $__default["default"](this._element).off(Util.TRANSITION_END);
      $__default["default"](this._element).one(Util.TRANSITION_END, function () {
        _this3._element.classList.remove(CLASS_NAME_STATIC);

        if (!isModalOverflowing) {
          $__default["default"](_this3._element).one(Util.TRANSITION_END, function () {
            _this3._element.style.overflowY = '';
          }).emulateTransitionEnd(_this3._element, modalTransitionDuration);
        }
      }).emulateTransitionEnd(modalTransitionDuration);

      this._element.focus();
    };

    _proto._showElement = function _showElement(relatedTarget) {
      var _this4 = this;

      var transition = $__default["default"](this._element).hasClass(CLASS_NAME_FADE$4);
      var modalBody = this._dialog ? this._dialog.querySelector(SELECTOR_MODAL_BODY) : null;

      if (!this._element.parentNode || this._element.parentNode.nodeType !== Node.ELEMENT_NODE) {
        // Don't move modal's DOM position
        document.body.appendChild(this._element);
      }

      this._element.style.display = 'block';

      this._element.removeAttribute('aria-hidden');

      this._element.setAttribute('aria-modal', true);

      this._element.setAttribute('role', 'dialog');

      if ($__default["default"](this._dialog).hasClass(CLASS_NAME_SCROLLABLE) && modalBody) {
        modalBody.scrollTop = 0;
      } else {
        this._element.scrollTop = 0;
      }

      if (transition) {
        Util.reflow(this._element);
      }

      $__default["default"](this._element).addClass(CLASS_NAME_SHOW$4);

      if (this._config.focus) {
        this._enforceFocus();
      }

      var shownEvent = $__default["default"].Event(EVENT_SHOWN$2, {
        relatedTarget: relatedTarget
      });

      var transitionComplete = function transitionComplete() {
        if (_this4._config.focus) {
          _this4._element.focus();
        }

        _this4._isTransitioning = false;
        $__default["default"](_this4._element).trigger(shownEvent);
      };

      if (transition) {
        var transitionDuration = Util.getTransitionDurationFromElement(this._dialog);
        $__default["default"](this._dialog).one(Util.TRANSITION_END, transitionComplete).emulateTransitionEnd(transitionDuration);
      } else {
        transitionComplete();
      }
    };

    _proto._enforceFocus = function _enforceFocus() {
      var _this5 = this;

      $__default["default"](document).off(EVENT_FOCUSIN) // Guard against infinite focus loop
      .on(EVENT_FOCUSIN, function (event) {
        if (document !== event.target && _this5._element !== event.target && $__default["default"](_this5._element).has(event.target).length === 0) {
          _this5._element.focus();
        }
      });
    };

    _proto._setEscapeEvent = function _setEscapeEvent() {
      var _this6 = this;

      if (this._isShown) {
        $__default["default"](this._element).on(EVENT_KEYDOWN_DISMISS, function (event) {
          if (_this6._config.keyboard && event.which === ESCAPE_KEYCODE) {
            event.preventDefault();

            _this6.hide();
          } else if (!_this6._config.keyboard && event.which === ESCAPE_KEYCODE) {
            _this6._triggerBackdropTransition();
          }
        });
      } else if (!this._isShown) {
        $__default["default"](this._element).off(EVENT_KEYDOWN_DISMISS);
      }
    };

    _proto._setResizeEvent = function _setResizeEvent() {
      var _this7 = this;

      if (this._isShown) {
        $__default["default"](window).on(EVENT_RESIZE, function (event) {
          return _this7.handleUpdate(event);
        });
      } else {
        $__default["default"](window).off(EVENT_RESIZE);
      }
    };

    _proto._hideModal = function _hideModal() {
      var _this8 = this;

      this._element.style.display = 'none';

      this._element.setAttribute('aria-hidden', true);

      this._element.removeAttribute('aria-modal');

      this._element.removeAttribute('role');

      this._isTransitioning = false;

      this._showBackdrop(function () {
        $__default["default"](document.body).removeClass(CLASS_NAME_OPEN);

        _this8._resetAdjustments();

        _this8._resetScrollbar();

        $__default["default"](_this8._element).trigger(EVENT_HIDDEN$2);
      });
    };

    _proto._removeBackdrop = function _removeBackdrop() {
      if (this._backdrop) {
        $__default["default"](this._backdrop).remove();
        this._backdrop = null;
      }
    };

    _proto._showBackdrop = function _showBackdrop(callback) {
      var _this9 = this;

      var animate = $__default["default"](this._element).hasClass(CLASS_NAME_FADE$4) ? CLASS_NAME_FADE$4 : '';

      if (this._isShown && this._config.backdrop) {
        this._backdrop = document.createElement('div');
        this._backdrop.className = CLASS_NAME_BACKDROP;

        if (animate) {
          this._backdrop.classList.add(animate);
        }

        $__default["default"](this._backdrop).appendTo(document.body);
        $__default["default"](this._element).on(EVENT_CLICK_DISMISS$1, function (event) {
          if (_this9._ignoreBackdropClick) {
            _this9._ignoreBackdropClick = false;
            return;
          }

          if (event.target !== event.currentTarget) {
            return;
          }

          if (_this9._config.backdrop === 'static') {
            _this9._triggerBackdropTransition();
          } else {
            _this9.hide();
          }
        });

        if (animate) {
          Util.reflow(this._backdrop);
        }

        $__default["default"](this._backdrop).addClass(CLASS_NAME_SHOW$4);

        if (!callback) {
          return;
        }

        if (!animate) {
          callback();
          return;
        }

        var backdropTransitionDuration = Util.getTransitionDurationFromElement(this._backdrop);
        $__default["default"](this._backdrop).one(Util.TRANSITION_END, callback).emulateTransitionEnd(backdropTransitionDuration);
      } else if (!this._isShown && this._backdrop) {
        $__default["default"](this._backdrop).removeClass(CLASS_NAME_SHOW$4);

        var callbackRemove = function callbackRemove() {
          _this9._removeBackdrop();

          if (callback) {
            callback();
          }
        };

        if ($__default["default"](this._element).hasClass(CLASS_NAME_FADE$4)) {
          var _backdropTransitionDuration = Util.getTransitionDurationFromElement(this._backdrop);

          $__default["default"](this._backdrop).one(Util.TRANSITION_END, callbackRemove).emulateTransitionEnd(_backdropTransitionDuration);
        } else {
          callbackRemove();
        }
      } else if (callback) {
        callback();
      }
    } // ----------------------------------------------------------------------
    // the following methods are used to handle overflowing modals
    // todo (fat): these should probably be refactored out of modal.js
    // ----------------------------------------------------------------------
    ;

    _proto._adjustDialog = function _adjustDialog() {
      var isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;

      if (!this._isBodyOverflowing && isModalOverflowing) {
        this._element.style.paddingLeft = this._scrollbarWidth + "px";
      }

      if (this._isBodyOverflowing && !isModalOverflowing) {
        this._element.style.paddingRight = this._scrollbarWidth + "px";
      }
    };

    _proto._resetAdjustments = function _resetAdjustments() {
      this._element.style.paddingLeft = '';
      this._element.style.paddingRight = '';
    };

    _proto._checkScrollbar = function _checkScrollbar() {
      var rect = document.body.getBoundingClientRect();
      this._isBodyOverflowing = Math.round(rect.left + rect.right) < window.innerWidth;
      this._scrollbarWidth = this._getScrollbarWidth();
    };

    _proto._setScrollbar = function _setScrollbar() {
      var _this10 = this;

      if (this._isBodyOverflowing) {
        // Note: DOMNode.style.paddingRight returns the actual value or '' if not set
        //   while $(DOMNode).css('padding-right') returns the calculated value or 0 if not set
        var fixedContent = [].slice.call(document.querySelectorAll(SELECTOR_FIXED_CONTENT));
        var stickyContent = [].slice.call(document.querySelectorAll(SELECTOR_STICKY_CONTENT)); // Adjust fixed content padding

        $__default["default"](fixedContent).each(function (index, element) {
          var actualPadding = element.style.paddingRight;
          var calculatedPadding = $__default["default"](element).css('padding-right');
          $__default["default"](element).data('padding-right', actualPadding).css('padding-right', parseFloat(calculatedPadding) + _this10._scrollbarWidth + "px");
        }); // Adjust sticky content margin

        $__default["default"](stickyContent).each(function (index, element) {
          var actualMargin = element.style.marginRight;
          var calculatedMargin = $__default["default"](element).css('margin-right');
          $__default["default"](element).data('margin-right', actualMargin).css('margin-right', parseFloat(calculatedMargin) - _this10._scrollbarWidth + "px");
        }); // Adjust body padding

        var actualPadding = document.body.style.paddingRight;
        var calculatedPadding = $__default["default"](document.body).css('padding-right');
        $__default["default"](document.body).data('padding-right', actualPadding).css('padding-right', parseFloat(calculatedPadding) + this._scrollbarWidth + "px");
      }

      $__default["default"](document.body).addClass(CLASS_NAME_OPEN);
    };

    _proto._resetScrollbar = function _resetScrollbar() {
      // Restore fixed content padding
      var fixedContent = [].slice.call(document.querySelectorAll(SELECTOR_FIXED_CONTENT));
      $__default["default"](fixedContent).each(function (index, element) {
        var padding = $__default["default"](element).data('padding-right');
        $__default["default"](element).removeData('padding-right');
        element.style.paddingRight = padding ? padding : '';
      }); // Restore sticky content

      var elements = [].slice.call(document.querySelectorAll("" + SELECTOR_STICKY_CONTENT));
      $__default["default"](elements).each(function (index, element) {
        var margin = $__default["default"](element).data('margin-right');

        if (typeof margin !== 'undefined') {
          $__default["default"](element).css('margin-right', margin).removeData('margin-right');
        }
      }); // Restore body padding

      var padding = $__default["default"](document.body).data('padding-right');
      $__default["default"](document.body).removeData('padding-right');
      document.body.style.paddingRight = padding ? padding : '';
    };

    _proto._getScrollbarWidth = function _getScrollbarWidth() {
      // thx d.walsh
      var scrollDiv = document.createElement('div');
      scrollDiv.className = CLASS_NAME_SCROLLBAR_MEASURER;
      document.body.appendChild(scrollDiv);
      var scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;
      document.body.removeChild(scrollDiv);
      return scrollbarWidth;
    } // Static
    ;

    Modal._jQueryInterface = function _jQueryInterface(config, relatedTarget) {
      return this.each(function () {
        var data = $__default["default"](this).data(DATA_KEY$5);

        var _config = _extends$1({}, Default$4, $__default["default"](this).data(), typeof config === 'object' && config ? config : {});

        if (!data) {
          data = new Modal(this, _config);
          $__default["default"](this).data(DATA_KEY$5, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config](relatedTarget);
        } else if (_config.show) {
          data.show(relatedTarget);
        }
      });
    };

    _createClass(Modal, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$5;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$4;
      }
    }]);

    return Modal;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API$1, SELECTOR_DATA_TOGGLE$1, function (event) {
    var _this11 = this;

    var target;
    var selector = Util.getSelectorFromElement(this);

    if (selector) {
      target = document.querySelector(selector);
    }

    var config = $__default["default"](target).data(DATA_KEY$5) ? 'toggle' : _extends$1({}, $__default["default"](target).data(), $__default["default"](this).data());

    if (this.tagName === 'A' || this.tagName === 'AREA') {
      event.preventDefault();
    }

    var $target = $__default["default"](target).one(EVENT_SHOW$2, function (showEvent) {
      if (showEvent.isDefaultPrevented()) {
        // Only register focus restorer if modal will actually get shown
        return;
      }

      $target.one(EVENT_HIDDEN$2, function () {
        if ($__default["default"](_this11).is(':visible')) {
          _this11.focus();
        }
      });
    });

    Modal._jQueryInterface.call($__default["default"](target), config, this);
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$5] = Modal._jQueryInterface;
  $__default["default"].fn[NAME$5].Constructor = Modal;

  $__default["default"].fn[NAME$5].noConflict = function () {
    $__default["default"].fn[NAME$5] = JQUERY_NO_CONFLICT$5;
    return Modal._jQueryInterface;
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.6.1): tools/sanitizer.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */
  var uriAttrs = ['background', 'cite', 'href', 'itemtype', 'longdesc', 'poster', 'src', 'xlink:href'];
  var ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i;
  var DefaultWhitelist = {
    // Global attributes allowed on any supplied element below.
    '*': ['class', 'dir', 'id', 'lang', 'role', ARIA_ATTRIBUTE_PATTERN],
    a: ['target', 'href', 'title', 'rel'],
    area: [],
    b: [],
    br: [],
    col: [],
    code: [],
    div: [],
    em: [],
    hr: [],
    h1: [],
    h2: [],
    h3: [],
    h4: [],
    h5: [],
    h6: [],
    i: [],
    img: ['src', 'srcset', 'alt', 'title', 'width', 'height'],
    li: [],
    ol: [],
    p: [],
    pre: [],
    s: [],
    small: [],
    span: [],
    sub: [],
    sup: [],
    strong: [],
    u: [],
    ul: []
  };
  /**
   * A pattern that recognizes a commonly useful subset of URLs that are safe.
   *
   * Shoutout to Angular https://github.com/angular/angular/blob/12.2.x/packages/core/src/sanitization/url_sanitizer.ts
   */

  var SAFE_URL_PATTERN = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i;
  /**
   * A pattern that matches safe data URLs. Only matches image, video and audio types.
   *
   * Shoutout to Angular https://github.com/angular/angular/blob/12.2.x/packages/core/src/sanitization/url_sanitizer.ts
   */

  var DATA_URL_PATTERN = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;

  function allowedAttribute(attr, allowedAttributeList) {
    var attrName = attr.nodeName.toLowerCase();

    if (allowedAttributeList.indexOf(attrName) !== -1) {
      if (uriAttrs.indexOf(attrName) !== -1) {
        return Boolean(SAFE_URL_PATTERN.test(attr.nodeValue) || DATA_URL_PATTERN.test(attr.nodeValue));
      }

      return true;
    }

    var regExp = allowedAttributeList.filter(function (attrRegex) {
      return attrRegex instanceof RegExp;
    }); // Check if a regular expression validates the attribute.

    for (var i = 0, len = regExp.length; i < len; i++) {
      if (regExp[i].test(attrName)) {
        return true;
      }
    }

    return false;
  }

  function sanitizeHtml(unsafeHtml, whiteList, sanitizeFn) {
    if (unsafeHtml.length === 0) {
      return unsafeHtml;
    }

    if (sanitizeFn && typeof sanitizeFn === 'function') {
      return sanitizeFn(unsafeHtml);
    }

    var domParser = new window.DOMParser();
    var createdDocument = domParser.parseFromString(unsafeHtml, 'text/html');
    var whitelistKeys = Object.keys(whiteList);
    var elements = [].slice.call(createdDocument.body.querySelectorAll('*'));

    var _loop = function _loop(i, len) {
      var el = elements[i];
      var elName = el.nodeName.toLowerCase();

      if (whitelistKeys.indexOf(el.nodeName.toLowerCase()) === -1) {
        el.parentNode.removeChild(el);
        return "continue";
      }

      var attributeList = [].slice.call(el.attributes); // eslint-disable-next-line unicorn/prefer-spread

      var whitelistedAttributes = [].concat(whiteList['*'] || [], whiteList[elName] || []);
      attributeList.forEach(function (attr) {
        if (!allowedAttribute(attr, whitelistedAttributes)) {
          el.removeAttribute(attr.nodeName);
        }
      });
    };

    for (var i = 0, len = elements.length; i < len; i++) {
      var _ret = _loop(i);

      if (_ret === "continue") continue;
    }

    return createdDocument.body.innerHTML;
  }

  /**
   * Constants
   */

  var NAME$4 = 'tooltip';
  var VERSION$4 = '4.6.1';
  var DATA_KEY$4 = 'bs.tooltip';
  var EVENT_KEY$4 = "." + DATA_KEY$4;
  var JQUERY_NO_CONFLICT$4 = $__default["default"].fn[NAME$4];
  var CLASS_PREFIX$1 = 'bs-tooltip';
  var BSCLS_PREFIX_REGEX$1 = new RegExp("(^|\\s)" + CLASS_PREFIX$1 + "\\S+", 'g');
  var DISALLOWED_ATTRIBUTES = ['sanitize', 'whiteList', 'sanitizeFn'];
  var CLASS_NAME_FADE$3 = 'fade';
  var CLASS_NAME_SHOW$3 = 'show';
  var HOVER_STATE_SHOW = 'show';
  var HOVER_STATE_OUT = 'out';
  var SELECTOR_TOOLTIP_INNER = '.tooltip-inner';
  var SELECTOR_ARROW = '.arrow';
  var TRIGGER_HOVER = 'hover';
  var TRIGGER_FOCUS = 'focus';
  var TRIGGER_CLICK = 'click';
  var TRIGGER_MANUAL = 'manual';
  var AttachmentMap = {
    AUTO: 'auto',
    TOP: 'top',
    RIGHT: 'right',
    BOTTOM: 'bottom',
    LEFT: 'left'
  };
  var Default$3 = {
    animation: true,
    template: '<div class="tooltip" role="tooltip">' + '<div class="arrow"></div>' + '<div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    selector: false,
    placement: 'top',
    offset: 0,
    container: false,
    fallbackPlacement: 'flip',
    boundary: 'scrollParent',
    customClass: '',
    sanitize: true,
    sanitizeFn: null,
    whiteList: DefaultWhitelist,
    popperConfig: null
  };
  var DefaultType$3 = {
    animation: 'boolean',
    template: 'string',
    title: '(string|element|function)',
    trigger: 'string',
    delay: '(number|object)',
    html: 'boolean',
    selector: '(string|boolean)',
    placement: '(string|function)',
    offset: '(number|string|function)',
    container: '(string|element|boolean)',
    fallbackPlacement: '(string|array)',
    boundary: '(string|element)',
    customClass: '(string|function)',
    sanitize: 'boolean',
    sanitizeFn: '(null|function)',
    whiteList: 'object',
    popperConfig: '(null|object)'
  };
  var Event$1 = {
    HIDE: "hide" + EVENT_KEY$4,
    HIDDEN: "hidden" + EVENT_KEY$4,
    SHOW: "show" + EVENT_KEY$4,
    SHOWN: "shown" + EVENT_KEY$4,
    INSERTED: "inserted" + EVENT_KEY$4,
    CLICK: "click" + EVENT_KEY$4,
    FOCUSIN: "focusin" + EVENT_KEY$4,
    FOCUSOUT: "focusout" + EVENT_KEY$4,
    MOUSEENTER: "mouseenter" + EVENT_KEY$4,
    MOUSELEAVE: "mouseleave" + EVENT_KEY$4
  };
  /**
   * Class definition
   */

  var Tooltip = /*#__PURE__*/function () {
    function Tooltip(element, config) {
      if (typeof Popper$1 === 'undefined') {
        throw new TypeError('Bootstrap\'s tooltips require Popper (https://popper.js.org)');
      } // Private


      this._isEnabled = true;
      this._timeout = 0;
      this._hoverState = '';
      this._activeTrigger = {};
      this._popper = null; // Protected

      this.element = element;
      this.config = this._getConfig(config);
      this.tip = null;

      this._setListeners();
    } // Getters


    var _proto = Tooltip.prototype;

    // Public
    _proto.enable = function enable() {
      this._isEnabled = true;
    };

    _proto.disable = function disable() {
      this._isEnabled = false;
    };

    _proto.toggleEnabled = function toggleEnabled() {
      this._isEnabled = !this._isEnabled;
    };

    _proto.toggle = function toggle(event) {
      if (!this._isEnabled) {
        return;
      }

      if (event) {
        var dataKey = this.constructor.DATA_KEY;
        var context = $__default["default"](event.currentTarget).data(dataKey);

        if (!context) {
          context = new this.constructor(event.currentTarget, this._getDelegateConfig());
          $__default["default"](event.currentTarget).data(dataKey, context);
        }

        context._activeTrigger.click = !context._activeTrigger.click;

        if (context._isWithActiveTrigger()) {
          context._enter(null, context);
        } else {
          context._leave(null, context);
        }
      } else {
        if ($__default["default"](this.getTipElement()).hasClass(CLASS_NAME_SHOW$3)) {
          this._leave(null, this);

          return;
        }

        this._enter(null, this);
      }
    };

    _proto.dispose = function dispose() {
      clearTimeout(this._timeout);
      $__default["default"].removeData(this.element, this.constructor.DATA_KEY);
      $__default["default"](this.element).off(this.constructor.EVENT_KEY);
      $__default["default"](this.element).closest('.modal').off('hide.bs.modal', this._hideModalHandler);

      if (this.tip) {
        $__default["default"](this.tip).remove();
      }

      this._isEnabled = null;
      this._timeout = null;
      this._hoverState = null;
      this._activeTrigger = null;

      if (this._popper) {
        this._popper.destroy();
      }

      this._popper = null;
      this.element = null;
      this.config = null;
      this.tip = null;
    };

    _proto.show = function show() {
      var _this = this;

      if ($__default["default"](this.element).css('display') === 'none') {
        throw new Error('Please use show on visible elements');
      }

      var showEvent = $__default["default"].Event(this.constructor.Event.SHOW);

      if (this.isWithContent() && this._isEnabled) {
        $__default["default"](this.element).trigger(showEvent);
        var shadowRoot = Util.findShadowRoot(this.element);
        var isInTheDom = $__default["default"].contains(shadowRoot !== null ? shadowRoot : this.element.ownerDocument.documentElement, this.element);

        if (showEvent.isDefaultPrevented() || !isInTheDom) {
          return;
        }

        var tip = this.getTipElement();
        var tipId = Util.getUID(this.constructor.NAME);
        tip.setAttribute('id', tipId);
        this.element.setAttribute('aria-describedby', tipId);
        this.setContent();

        if (this.config.animation) {
          $__default["default"](tip).addClass(CLASS_NAME_FADE$3);
        }

        var placement = typeof this.config.placement === 'function' ? this.config.placement.call(this, tip, this.element) : this.config.placement;

        var attachment = this._getAttachment(placement);

        this.addAttachmentClass(attachment);

        var container = this._getContainer();

        $__default["default"](tip).data(this.constructor.DATA_KEY, this);

        if (!$__default["default"].contains(this.element.ownerDocument.documentElement, this.tip)) {
          $__default["default"](tip).appendTo(container);
        }

        $__default["default"](this.element).trigger(this.constructor.Event.INSERTED);
        this._popper = new Popper$1(this.element, tip, this._getPopperConfig(attachment));
        $__default["default"](tip).addClass(CLASS_NAME_SHOW$3);
        $__default["default"](tip).addClass(this.config.customClass); // If this is a touch-enabled device we add extra
        // empty mouseover listeners to the body's immediate children;
        // only needed because of broken event delegation on iOS
        // https://www.quirksmode.org/blog/archives/2014/02/mouse_event_bub.html

        if ('ontouchstart' in document.documentElement) {
          $__default["default"](document.body).children().on('mouseover', null, $__default["default"].noop);
        }

        var complete = function complete() {
          if (_this.config.animation) {
            _this._fixTransition();
          }

          var prevHoverState = _this._hoverState;
          _this._hoverState = null;
          $__default["default"](_this.element).trigger(_this.constructor.Event.SHOWN);

          if (prevHoverState === HOVER_STATE_OUT) {
            _this._leave(null, _this);
          }
        };

        if ($__default["default"](this.tip).hasClass(CLASS_NAME_FADE$3)) {
          var transitionDuration = Util.getTransitionDurationFromElement(this.tip);
          $__default["default"](this.tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
        } else {
          complete();
        }
      }
    };

    _proto.hide = function hide(callback) {
      var _this2 = this;

      var tip = this.getTipElement();
      var hideEvent = $__default["default"].Event(this.constructor.Event.HIDE);

      var complete = function complete() {
        if (_this2._hoverState !== HOVER_STATE_SHOW && tip.parentNode) {
          tip.parentNode.removeChild(tip);
        }

        _this2._cleanTipClass();

        _this2.element.removeAttribute('aria-describedby');

        $__default["default"](_this2.element).trigger(_this2.constructor.Event.HIDDEN);

        if (_this2._popper !== null) {
          _this2._popper.destroy();
        }

        if (callback) {
          callback();
        }
      };

      $__default["default"](this.element).trigger(hideEvent);

      if (hideEvent.isDefaultPrevented()) {
        return;
      }

      $__default["default"](tip).removeClass(CLASS_NAME_SHOW$3); // If this is a touch-enabled device we remove the extra
      // empty mouseover listeners we added for iOS support

      if ('ontouchstart' in document.documentElement) {
        $__default["default"](document.body).children().off('mouseover', null, $__default["default"].noop);
      }

      this._activeTrigger[TRIGGER_CLICK] = false;
      this._activeTrigger[TRIGGER_FOCUS] = false;
      this._activeTrigger[TRIGGER_HOVER] = false;

      if ($__default["default"](this.tip).hasClass(CLASS_NAME_FADE$3)) {
        var transitionDuration = Util.getTransitionDurationFromElement(tip);
        $__default["default"](tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
      } else {
        complete();
      }

      this._hoverState = '';
    };

    _proto.update = function update() {
      if (this._popper !== null) {
        this._popper.scheduleUpdate();
      }
    } // Protected
    ;

    _proto.isWithContent = function isWithContent() {
      return Boolean(this.getTitle());
    };

    _proto.addAttachmentClass = function addAttachmentClass(attachment) {
      $__default["default"](this.getTipElement()).addClass(CLASS_PREFIX$1 + "-" + attachment);
    };

    _proto.getTipElement = function getTipElement() {
      this.tip = this.tip || $__default["default"](this.config.template)[0];
      return this.tip;
    };

    _proto.setContent = function setContent() {
      var tip = this.getTipElement();
      this.setElementContent($__default["default"](tip.querySelectorAll(SELECTOR_TOOLTIP_INNER)), this.getTitle());
      $__default["default"](tip).removeClass(CLASS_NAME_FADE$3 + " " + CLASS_NAME_SHOW$3);
    };

    _proto.setElementContent = function setElementContent($element, content) {
      if (typeof content === 'object' && (content.nodeType || content.jquery)) {
        // Content is a DOM node or a jQuery
        if (this.config.html) {
          if (!$__default["default"](content).parent().is($element)) {
            $element.empty().append(content);
          }
        } else {
          $element.text($__default["default"](content).text());
        }

        return;
      }

      if (this.config.html) {
        if (this.config.sanitize) {
          content = sanitizeHtml(content, this.config.whiteList, this.config.sanitizeFn);
        }

        $element.html(content);
      } else {
        $element.text(content);
      }
    };

    _proto.getTitle = function getTitle() {
      var title = this.element.getAttribute('data-original-title');

      if (!title) {
        title = typeof this.config.title === 'function' ? this.config.title.call(this.element) : this.config.title;
      }

      return title;
    } // Private
    ;

    _proto._getPopperConfig = function _getPopperConfig(attachment) {
      var _this3 = this;

      var defaultBsConfig = {
        placement: attachment,
        modifiers: {
          offset: this._getOffset(),
          flip: {
            behavior: this.config.fallbackPlacement
          },
          arrow: {
            element: SELECTOR_ARROW
          },
          preventOverflow: {
            boundariesElement: this.config.boundary
          }
        },
        onCreate: function onCreate(data) {
          if (data.originalPlacement !== data.placement) {
            _this3._handlePopperPlacementChange(data);
          }
        },
        onUpdate: function onUpdate(data) {
          return _this3._handlePopperPlacementChange(data);
        }
      };
      return _extends$1({}, defaultBsConfig, this.config.popperConfig);
    };

    _proto._getOffset = function _getOffset() {
      var _this4 = this;

      var offset = {};

      if (typeof this.config.offset === 'function') {
        offset.fn = function (data) {
          data.offsets = _extends$1({}, data.offsets, _this4.config.offset(data.offsets, _this4.element));
          return data;
        };
      } else {
        offset.offset = this.config.offset;
      }

      return offset;
    };

    _proto._getContainer = function _getContainer() {
      if (this.config.container === false) {
        return document.body;
      }

      if (Util.isElement(this.config.container)) {
        return $__default["default"](this.config.container);
      }

      return $__default["default"](document).find(this.config.container);
    };

    _proto._getAttachment = function _getAttachment(placement) {
      return AttachmentMap[placement.toUpperCase()];
    };

    _proto._setListeners = function _setListeners() {
      var _this5 = this;

      var triggers = this.config.trigger.split(' ');
      triggers.forEach(function (trigger) {
        if (trigger === 'click') {
          $__default["default"](_this5.element).on(_this5.constructor.Event.CLICK, _this5.config.selector, function (event) {
            return _this5.toggle(event);
          });
        } else if (trigger !== TRIGGER_MANUAL) {
          var eventIn = trigger === TRIGGER_HOVER ? _this5.constructor.Event.MOUSEENTER : _this5.constructor.Event.FOCUSIN;
          var eventOut = trigger === TRIGGER_HOVER ? _this5.constructor.Event.MOUSELEAVE : _this5.constructor.Event.FOCUSOUT;
          $__default["default"](_this5.element).on(eventIn, _this5.config.selector, function (event) {
            return _this5._enter(event);
          }).on(eventOut, _this5.config.selector, function (event) {
            return _this5._leave(event);
          });
        }
      });

      this._hideModalHandler = function () {
        if (_this5.element) {
          _this5.hide();
        }
      };

      $__default["default"](this.element).closest('.modal').on('hide.bs.modal', this._hideModalHandler);

      if (this.config.selector) {
        this.config = _extends$1({}, this.config, {
          trigger: 'manual',
          selector: ''
        });
      } else {
        this._fixTitle();
      }
    };

    _proto._fixTitle = function _fixTitle() {
      var titleType = typeof this.element.getAttribute('data-original-title');

      if (this.element.getAttribute('title') || titleType !== 'string') {
        this.element.setAttribute('data-original-title', this.element.getAttribute('title') || '');
        this.element.setAttribute('title', '');
      }
    };

    _proto._enter = function _enter(event, context) {
      var dataKey = this.constructor.DATA_KEY;
      context = context || $__default["default"](event.currentTarget).data(dataKey);

      if (!context) {
        context = new this.constructor(event.currentTarget, this._getDelegateConfig());
        $__default["default"](event.currentTarget).data(dataKey, context);
      }

      if (event) {
        context._activeTrigger[event.type === 'focusin' ? TRIGGER_FOCUS : TRIGGER_HOVER] = true;
      }

      if ($__default["default"](context.getTipElement()).hasClass(CLASS_NAME_SHOW$3) || context._hoverState === HOVER_STATE_SHOW) {
        context._hoverState = HOVER_STATE_SHOW;
        return;
      }

      clearTimeout(context._timeout);
      context._hoverState = HOVER_STATE_SHOW;

      if (!context.config.delay || !context.config.delay.show) {
        context.show();
        return;
      }

      context._timeout = setTimeout(function () {
        if (context._hoverState === HOVER_STATE_SHOW) {
          context.show();
        }
      }, context.config.delay.show);
    };

    _proto._leave = function _leave(event, context) {
      var dataKey = this.constructor.DATA_KEY;
      context = context || $__default["default"](event.currentTarget).data(dataKey);

      if (!context) {
        context = new this.constructor(event.currentTarget, this._getDelegateConfig());
        $__default["default"](event.currentTarget).data(dataKey, context);
      }

      if (event) {
        context._activeTrigger[event.type === 'focusout' ? TRIGGER_FOCUS : TRIGGER_HOVER] = false;
      }

      if (context._isWithActiveTrigger()) {
        return;
      }

      clearTimeout(context._timeout);
      context._hoverState = HOVER_STATE_OUT;

      if (!context.config.delay || !context.config.delay.hide) {
        context.hide();
        return;
      }

      context._timeout = setTimeout(function () {
        if (context._hoverState === HOVER_STATE_OUT) {
          context.hide();
        }
      }, context.config.delay.hide);
    };

    _proto._isWithActiveTrigger = function _isWithActiveTrigger() {
      for (var trigger in this._activeTrigger) {
        if (this._activeTrigger[trigger]) {
          return true;
        }
      }

      return false;
    };

    _proto._getConfig = function _getConfig(config) {
      var dataAttributes = $__default["default"](this.element).data();
      Object.keys(dataAttributes).forEach(function (dataAttr) {
        if (DISALLOWED_ATTRIBUTES.indexOf(dataAttr) !== -1) {
          delete dataAttributes[dataAttr];
        }
      });
      config = _extends$1({}, this.constructor.Default, dataAttributes, typeof config === 'object' && config ? config : {});

      if (typeof config.delay === 'number') {
        config.delay = {
          show: config.delay,
          hide: config.delay
        };
      }

      if (typeof config.title === 'number') {
        config.title = config.title.toString();
      }

      if (typeof config.content === 'number') {
        config.content = config.content.toString();
      }

      Util.typeCheckConfig(NAME$4, config, this.constructor.DefaultType);

      if (config.sanitize) {
        config.template = sanitizeHtml(config.template, config.whiteList, config.sanitizeFn);
      }

      return config;
    };

    _proto._getDelegateConfig = function _getDelegateConfig() {
      var config = {};

      if (this.config) {
        for (var key in this.config) {
          if (this.constructor.Default[key] !== this.config[key]) {
            config[key] = this.config[key];
          }
        }
      }

      return config;
    };

    _proto._cleanTipClass = function _cleanTipClass() {
      var $tip = $__default["default"](this.getTipElement());
      var tabClass = $tip.attr('class').match(BSCLS_PREFIX_REGEX$1);

      if (tabClass !== null && tabClass.length) {
        $tip.removeClass(tabClass.join(''));
      }
    };

    _proto._handlePopperPlacementChange = function _handlePopperPlacementChange(popperData) {
      this.tip = popperData.instance.popper;

      this._cleanTipClass();

      this.addAttachmentClass(this._getAttachment(popperData.placement));
    };

    _proto._fixTransition = function _fixTransition() {
      var tip = this.getTipElement();
      var initConfigAnimation = this.config.animation;

      if (tip.getAttribute('x-placement') !== null) {
        return;
      }

      $__default["default"](tip).removeClass(CLASS_NAME_FADE$3);
      this.config.animation = false;
      this.hide();
      this.show();
      this.config.animation = initConfigAnimation;
    } // Static
    ;

    Tooltip._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var $element = $__default["default"](this);
        var data = $element.data(DATA_KEY$4);

        var _config = typeof config === 'object' && config;

        if (!data && /dispose|hide/.test(config)) {
          return;
        }

        if (!data) {
          data = new Tooltip(this, _config);
          $element.data(DATA_KEY$4, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    _createClass(Tooltip, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$4;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$3;
      }
    }, {
      key: "NAME",
      get: function get() {
        return NAME$4;
      }
    }, {
      key: "DATA_KEY",
      get: function get() {
        return DATA_KEY$4;
      }
    }, {
      key: "Event",
      get: function get() {
        return Event$1;
      }
    }, {
      key: "EVENT_KEY",
      get: function get() {
        return EVENT_KEY$4;
      }
    }, {
      key: "DefaultType",
      get: function get() {
        return DefaultType$3;
      }
    }]);

    return Tooltip;
  }();
  /**
   * jQuery
   */


  $__default["default"].fn[NAME$4] = Tooltip._jQueryInterface;
  $__default["default"].fn[NAME$4].Constructor = Tooltip;

  $__default["default"].fn[NAME$4].noConflict = function () {
    $__default["default"].fn[NAME$4] = JQUERY_NO_CONFLICT$4;
    return Tooltip._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$3 = 'popover';
  var VERSION$3 = '4.6.1';
  var DATA_KEY$3 = 'bs.popover';
  var EVENT_KEY$3 = "." + DATA_KEY$3;
  var JQUERY_NO_CONFLICT$3 = $__default["default"].fn[NAME$3];
  var CLASS_PREFIX = 'bs-popover';
  var BSCLS_PREFIX_REGEX = new RegExp("(^|\\s)" + CLASS_PREFIX + "\\S+", 'g');
  var CLASS_NAME_FADE$2 = 'fade';
  var CLASS_NAME_SHOW$2 = 'show';
  var SELECTOR_TITLE = '.popover-header';
  var SELECTOR_CONTENT = '.popover-body';

  var Default$2 = _extends$1({}, Tooltip.Default, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover" role="tooltip">' + '<div class="arrow"></div>' + '<h3 class="popover-header"></h3>' + '<div class="popover-body"></div></div>'
  });

  var DefaultType$2 = _extends$1({}, Tooltip.DefaultType, {
    content: '(string|element|function)'
  });

  var Event = {
    HIDE: "hide" + EVENT_KEY$3,
    HIDDEN: "hidden" + EVENT_KEY$3,
    SHOW: "show" + EVENT_KEY$3,
    SHOWN: "shown" + EVENT_KEY$3,
    INSERTED: "inserted" + EVENT_KEY$3,
    CLICK: "click" + EVENT_KEY$3,
    FOCUSIN: "focusin" + EVENT_KEY$3,
    FOCUSOUT: "focusout" + EVENT_KEY$3,
    MOUSEENTER: "mouseenter" + EVENT_KEY$3,
    MOUSELEAVE: "mouseleave" + EVENT_KEY$3
  };
  /**
   * Class definition
   */

  var Popover = /*#__PURE__*/function (_Tooltip) {
    _inheritsLoose(Popover, _Tooltip);

    function Popover() {
      return _Tooltip.apply(this, arguments) || this;
    }

    var _proto = Popover.prototype;

    // Overrides
    _proto.isWithContent = function isWithContent() {
      return this.getTitle() || this._getContent();
    };

    _proto.addAttachmentClass = function addAttachmentClass(attachment) {
      $__default["default"](this.getTipElement()).addClass(CLASS_PREFIX + "-" + attachment);
    };

    _proto.getTipElement = function getTipElement() {
      this.tip = this.tip || $__default["default"](this.config.template)[0];
      return this.tip;
    };

    _proto.setContent = function setContent() {
      var $tip = $__default["default"](this.getTipElement()); // We use append for html objects to maintain js events

      this.setElementContent($tip.find(SELECTOR_TITLE), this.getTitle());

      var content = this._getContent();

      if (typeof content === 'function') {
        content = content.call(this.element);
      }

      this.setElementContent($tip.find(SELECTOR_CONTENT), content);
      $tip.removeClass(CLASS_NAME_FADE$2 + " " + CLASS_NAME_SHOW$2);
    } // Private
    ;

    _proto._getContent = function _getContent() {
      return this.element.getAttribute('data-content') || this.config.content;
    };

    _proto._cleanTipClass = function _cleanTipClass() {
      var $tip = $__default["default"](this.getTipElement());
      var tabClass = $tip.attr('class').match(BSCLS_PREFIX_REGEX);

      if (tabClass !== null && tabClass.length > 0) {
        $tip.removeClass(tabClass.join(''));
      }
    } // Static
    ;

    Popover._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var data = $__default["default"](this).data(DATA_KEY$3);

        var _config = typeof config === 'object' ? config : null;

        if (!data && /dispose|hide/.test(config)) {
          return;
        }

        if (!data) {
          data = new Popover(this, _config);
          $__default["default"](this).data(DATA_KEY$3, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    _createClass(Popover, null, [{
      key: "VERSION",
      get: // Getters
      function get() {
        return VERSION$3;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$2;
      }
    }, {
      key: "NAME",
      get: function get() {
        return NAME$3;
      }
    }, {
      key: "DATA_KEY",
      get: function get() {
        return DATA_KEY$3;
      }
    }, {
      key: "Event",
      get: function get() {
        return Event;
      }
    }, {
      key: "EVENT_KEY",
      get: function get() {
        return EVENT_KEY$3;
      }
    }, {
      key: "DefaultType",
      get: function get() {
        return DefaultType$2;
      }
    }]);

    return Popover;
  }(Tooltip);
  /**
   * jQuery
   */


  $__default["default"].fn[NAME$3] = Popover._jQueryInterface;
  $__default["default"].fn[NAME$3].Constructor = Popover;

  $__default["default"].fn[NAME$3].noConflict = function () {
    $__default["default"].fn[NAME$3] = JQUERY_NO_CONFLICT$3;
    return Popover._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$2 = 'scrollspy';
  var VERSION$2 = '4.6.1';
  var DATA_KEY$2 = 'bs.scrollspy';
  var EVENT_KEY$2 = "." + DATA_KEY$2;
  var DATA_API_KEY$1 = '.data-api';
  var JQUERY_NO_CONFLICT$2 = $__default["default"].fn[NAME$2];
  var CLASS_NAME_DROPDOWN_ITEM = 'dropdown-item';
  var CLASS_NAME_ACTIVE$1 = 'active';
  var EVENT_ACTIVATE = "activate" + EVENT_KEY$2;
  var EVENT_SCROLL = "scroll" + EVENT_KEY$2;
  var EVENT_LOAD_DATA_API = "load" + EVENT_KEY$2 + DATA_API_KEY$1;
  var METHOD_OFFSET = 'offset';
  var METHOD_POSITION = 'position';
  var SELECTOR_DATA_SPY = '[data-spy="scroll"]';
  var SELECTOR_NAV_LIST_GROUP$1 = '.nav, .list-group';
  var SELECTOR_NAV_LINKS = '.nav-link';
  var SELECTOR_NAV_ITEMS = '.nav-item';
  var SELECTOR_LIST_ITEMS = '.list-group-item';
  var SELECTOR_DROPDOWN$1 = '.dropdown';
  var SELECTOR_DROPDOWN_ITEMS = '.dropdown-item';
  var SELECTOR_DROPDOWN_TOGGLE$1 = '.dropdown-toggle';
  var Default$1 = {
    offset: 10,
    method: 'auto',
    target: ''
  };
  var DefaultType$1 = {
    offset: 'number',
    method: 'string',
    target: '(string|element)'
  };
  /**
   * Class definition
   */

  var ScrollSpy = /*#__PURE__*/function () {
    function ScrollSpy(element, config) {
      var _this = this;

      this._element = element;
      this._scrollElement = element.tagName === 'BODY' ? window : element;
      this._config = this._getConfig(config);
      this._selector = this._config.target + " " + SELECTOR_NAV_LINKS + "," + (this._config.target + " " + SELECTOR_LIST_ITEMS + ",") + (this._config.target + " " + SELECTOR_DROPDOWN_ITEMS);
      this._offsets = [];
      this._targets = [];
      this._activeTarget = null;
      this._scrollHeight = 0;
      $__default["default"](this._scrollElement).on(EVENT_SCROLL, function (event) {
        return _this._process(event);
      });
      this.refresh();

      this._process();
    } // Getters


    var _proto = ScrollSpy.prototype;

    // Public
    _proto.refresh = function refresh() {
      var _this2 = this;

      var autoMethod = this._scrollElement === this._scrollElement.window ? METHOD_OFFSET : METHOD_POSITION;
      var offsetMethod = this._config.method === 'auto' ? autoMethod : this._config.method;
      var offsetBase = offsetMethod === METHOD_POSITION ? this._getScrollTop() : 0;
      this._offsets = [];
      this._targets = [];
      this._scrollHeight = this._getScrollHeight();
      var targets = [].slice.call(document.querySelectorAll(this._selector));
      targets.map(function (element) {
        var target;
        var targetSelector = Util.getSelectorFromElement(element);

        if (targetSelector) {
          target = document.querySelector(targetSelector);
        }

        if (target) {
          var targetBCR = target.getBoundingClientRect();

          if (targetBCR.width || targetBCR.height) {
            // TODO (fat): remove sketch reliance on jQuery position/offset
            return [$__default["default"](target)[offsetMethod]().top + offsetBase, targetSelector];
          }
        }

        return null;
      }).filter(function (item) {
        return item;
      }).sort(function (a, b) {
        return a[0] - b[0];
      }).forEach(function (item) {
        _this2._offsets.push(item[0]);

        _this2._targets.push(item[1]);
      });
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$2);
      $__default["default"](this._scrollElement).off(EVENT_KEY$2);
      this._element = null;
      this._scrollElement = null;
      this._config = null;
      this._selector = null;
      this._offsets = null;
      this._targets = null;
      this._activeTarget = null;
      this._scrollHeight = null;
    } // Private
    ;

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, Default$1, typeof config === 'object' && config ? config : {});

      if (typeof config.target !== 'string' && Util.isElement(config.target)) {
        var id = $__default["default"](config.target).attr('id');

        if (!id) {
          id = Util.getUID(NAME$2);
          $__default["default"](config.target).attr('id', id);
        }

        config.target = "#" + id;
      }

      Util.typeCheckConfig(NAME$2, config, DefaultType$1);
      return config;
    };

    _proto._getScrollTop = function _getScrollTop() {
      return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
    };

    _proto._getScrollHeight = function _getScrollHeight() {
      return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    };

    _proto._getOffsetHeight = function _getOffsetHeight() {
      return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
    };

    _proto._process = function _process() {
      var scrollTop = this._getScrollTop() + this._config.offset;

      var scrollHeight = this._getScrollHeight();

      var maxScroll = this._config.offset + scrollHeight - this._getOffsetHeight();

      if (this._scrollHeight !== scrollHeight) {
        this.refresh();
      }

      if (scrollTop >= maxScroll) {
        var target = this._targets[this._targets.length - 1];

        if (this._activeTarget !== target) {
          this._activate(target);
        }

        return;
      }

      if (this._activeTarget && scrollTop < this._offsets[0] && this._offsets[0] > 0) {
        this._activeTarget = null;

        this._clear();

        return;
      }

      for (var i = this._offsets.length; i--;) {
        var isActiveTarget = this._activeTarget !== this._targets[i] && scrollTop >= this._offsets[i] && (typeof this._offsets[i + 1] === 'undefined' || scrollTop < this._offsets[i + 1]);

        if (isActiveTarget) {
          this._activate(this._targets[i]);
        }
      }
    };

    _proto._activate = function _activate(target) {
      this._activeTarget = target;

      this._clear();

      var queries = this._selector.split(',').map(function (selector) {
        return selector + "[data-target=\"" + target + "\"]," + selector + "[href=\"" + target + "\"]";
      });

      var $link = $__default["default"]([].slice.call(document.querySelectorAll(queries.join(','))));

      if ($link.hasClass(CLASS_NAME_DROPDOWN_ITEM)) {
        $link.closest(SELECTOR_DROPDOWN$1).find(SELECTOR_DROPDOWN_TOGGLE$1).addClass(CLASS_NAME_ACTIVE$1);
        $link.addClass(CLASS_NAME_ACTIVE$1);
      } else {
        // Set triggered link as active
        $link.addClass(CLASS_NAME_ACTIVE$1); // Set triggered links parents as active
        // With both <ul> and <nav> markup a parent is the previous sibling of any nav ancestor

        $link.parents(SELECTOR_NAV_LIST_GROUP$1).prev(SELECTOR_NAV_LINKS + ", " + SELECTOR_LIST_ITEMS).addClass(CLASS_NAME_ACTIVE$1); // Handle special case when .nav-link is inside .nav-item

        $link.parents(SELECTOR_NAV_LIST_GROUP$1).prev(SELECTOR_NAV_ITEMS).children(SELECTOR_NAV_LINKS).addClass(CLASS_NAME_ACTIVE$1);
      }

      $__default["default"](this._scrollElement).trigger(EVENT_ACTIVATE, {
        relatedTarget: target
      });
    };

    _proto._clear = function _clear() {
      [].slice.call(document.querySelectorAll(this._selector)).filter(function (node) {
        return node.classList.contains(CLASS_NAME_ACTIVE$1);
      }).forEach(function (node) {
        return node.classList.remove(CLASS_NAME_ACTIVE$1);
      });
    } // Static
    ;

    ScrollSpy._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var data = $__default["default"](this).data(DATA_KEY$2);

        var _config = typeof config === 'object' && config;

        if (!data) {
          data = new ScrollSpy(this, _config);
          $__default["default"](this).data(DATA_KEY$2, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    _createClass(ScrollSpy, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$2;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default$1;
      }
    }]);

    return ScrollSpy;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](window).on(EVENT_LOAD_DATA_API, function () {
    var scrollSpys = [].slice.call(document.querySelectorAll(SELECTOR_DATA_SPY));
    var scrollSpysLength = scrollSpys.length;

    for (var i = scrollSpysLength; i--;) {
      var $spy = $__default["default"](scrollSpys[i]);

      ScrollSpy._jQueryInterface.call($spy, $spy.data());
    }
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$2] = ScrollSpy._jQueryInterface;
  $__default["default"].fn[NAME$2].Constructor = ScrollSpy;

  $__default["default"].fn[NAME$2].noConflict = function () {
    $__default["default"].fn[NAME$2] = JQUERY_NO_CONFLICT$2;
    return ScrollSpy._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME$1 = 'tab';
  var VERSION$1 = '4.6.1';
  var DATA_KEY$1 = 'bs.tab';
  var EVENT_KEY$1 = "." + DATA_KEY$1;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT$1 = $__default["default"].fn[NAME$1];
  var CLASS_NAME_DROPDOWN_MENU = 'dropdown-menu';
  var CLASS_NAME_ACTIVE = 'active';
  var CLASS_NAME_DISABLED = 'disabled';
  var CLASS_NAME_FADE$1 = 'fade';
  var CLASS_NAME_SHOW$1 = 'show';
  var EVENT_HIDE$1 = "hide" + EVENT_KEY$1;
  var EVENT_HIDDEN$1 = "hidden" + EVENT_KEY$1;
  var EVENT_SHOW$1 = "show" + EVENT_KEY$1;
  var EVENT_SHOWN$1 = "shown" + EVENT_KEY$1;
  var EVENT_CLICK_DATA_API = "click" + EVENT_KEY$1 + DATA_API_KEY;
  var SELECTOR_DROPDOWN = '.dropdown';
  var SELECTOR_NAV_LIST_GROUP = '.nav, .list-group';
  var SELECTOR_ACTIVE = '.active';
  var SELECTOR_ACTIVE_UL = '> li > .active';
  var SELECTOR_DATA_TOGGLE = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]';
  var SELECTOR_DROPDOWN_TOGGLE = '.dropdown-toggle';
  var SELECTOR_DROPDOWN_ACTIVE_CHILD = '> .dropdown-menu .active';
  /**
   * Class definition
   */

  var Tab = /*#__PURE__*/function () {
    function Tab(element) {
      this._element = element;
    } // Getters


    var _proto = Tab.prototype;

    // Public
    _proto.show = function show() {
      var _this = this;

      if (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && $__default["default"](this._element).hasClass(CLASS_NAME_ACTIVE) || $__default["default"](this._element).hasClass(CLASS_NAME_DISABLED)) {
        return;
      }

      var target;
      var previous;
      var listElement = $__default["default"](this._element).closest(SELECTOR_NAV_LIST_GROUP)[0];
      var selector = Util.getSelectorFromElement(this._element);

      if (listElement) {
        var itemSelector = listElement.nodeName === 'UL' || listElement.nodeName === 'OL' ? SELECTOR_ACTIVE_UL : SELECTOR_ACTIVE;
        previous = $__default["default"].makeArray($__default["default"](listElement).find(itemSelector));
        previous = previous[previous.length - 1];
      }

      var hideEvent = $__default["default"].Event(EVENT_HIDE$1, {
        relatedTarget: this._element
      });
      var showEvent = $__default["default"].Event(EVENT_SHOW$1, {
        relatedTarget: previous
      });

      if (previous) {
        $__default["default"](previous).trigger(hideEvent);
      }

      $__default["default"](this._element).trigger(showEvent);

      if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) {
        return;
      }

      if (selector) {
        target = document.querySelector(selector);
      }

      this._activate(this._element, listElement);

      var complete = function complete() {
        var hiddenEvent = $__default["default"].Event(EVENT_HIDDEN$1, {
          relatedTarget: _this._element
        });
        var shownEvent = $__default["default"].Event(EVENT_SHOWN$1, {
          relatedTarget: previous
        });
        $__default["default"](previous).trigger(hiddenEvent);
        $__default["default"](_this._element).trigger(shownEvent);
      };

      if (target) {
        this._activate(target, target.parentNode, complete);
      } else {
        complete();
      }
    };

    _proto.dispose = function dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$1);
      this._element = null;
    } // Private
    ;

    _proto._activate = function _activate(element, container, callback) {
      var _this2 = this;

      var activeElements = container && (container.nodeName === 'UL' || container.nodeName === 'OL') ? $__default["default"](container).find(SELECTOR_ACTIVE_UL) : $__default["default"](container).children(SELECTOR_ACTIVE);
      var active = activeElements[0];
      var isTransitioning = callback && active && $__default["default"](active).hasClass(CLASS_NAME_FADE$1);

      var complete = function complete() {
        return _this2._transitionComplete(element, active, callback);
      };

      if (active && isTransitioning) {
        var transitionDuration = Util.getTransitionDurationFromElement(active);
        $__default["default"](active).removeClass(CLASS_NAME_SHOW$1).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
      } else {
        complete();
      }
    };

    _proto._transitionComplete = function _transitionComplete(element, active, callback) {
      if (active) {
        $__default["default"](active).removeClass(CLASS_NAME_ACTIVE);
        var dropdownChild = $__default["default"](active.parentNode).find(SELECTOR_DROPDOWN_ACTIVE_CHILD)[0];

        if (dropdownChild) {
          $__default["default"](dropdownChild).removeClass(CLASS_NAME_ACTIVE);
        }

        if (active.getAttribute('role') === 'tab') {
          active.setAttribute('aria-selected', false);
        }
      }

      $__default["default"](element).addClass(CLASS_NAME_ACTIVE);

      if (element.getAttribute('role') === 'tab') {
        element.setAttribute('aria-selected', true);
      }

      Util.reflow(element);

      if (element.classList.contains(CLASS_NAME_FADE$1)) {
        element.classList.add(CLASS_NAME_SHOW$1);
      }

      var parent = element.parentNode;

      if (parent && parent.nodeName === 'LI') {
        parent = parent.parentNode;
      }

      if (parent && $__default["default"](parent).hasClass(CLASS_NAME_DROPDOWN_MENU)) {
        var dropdownElement = $__default["default"](element).closest(SELECTOR_DROPDOWN)[0];

        if (dropdownElement) {
          var dropdownToggleList = [].slice.call(dropdownElement.querySelectorAll(SELECTOR_DROPDOWN_TOGGLE));
          $__default["default"](dropdownToggleList).addClass(CLASS_NAME_ACTIVE);
        }

        element.setAttribute('aria-expanded', true);
      }

      if (callback) {
        callback();
      }
    } // Static
    ;

    Tab._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var $this = $__default["default"](this);
        var data = $this.data(DATA_KEY$1);

        if (!data) {
          data = new Tab(this);
          $this.data(DATA_KEY$1, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config]();
        }
      });
    };

    _createClass(Tab, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION$1;
      }
    }]);

    return Tab;
  }();
  /**
   * Data API implementation
   */


  $__default["default"](document).on(EVENT_CLICK_DATA_API, SELECTOR_DATA_TOGGLE, function (event) {
    event.preventDefault();

    Tab._jQueryInterface.call($__default["default"](this), 'show');
  });
  /**
   * jQuery
   */

  $__default["default"].fn[NAME$1] = Tab._jQueryInterface;
  $__default["default"].fn[NAME$1].Constructor = Tab;

  $__default["default"].fn[NAME$1].noConflict = function () {
    $__default["default"].fn[NAME$1] = JQUERY_NO_CONFLICT$1;
    return Tab._jQueryInterface;
  };

  /**
   * Constants
   */

  var NAME = 'toast';
  var VERSION = '4.6.1';
  var DATA_KEY = 'bs.toast';
  var EVENT_KEY = "." + DATA_KEY;
  var JQUERY_NO_CONFLICT = $__default["default"].fn[NAME];
  var CLASS_NAME_FADE = 'fade';
  var CLASS_NAME_HIDE = 'hide';
  var CLASS_NAME_SHOW = 'show';
  var CLASS_NAME_SHOWING = 'showing';
  var EVENT_CLICK_DISMISS = "click.dismiss" + EVENT_KEY;
  var EVENT_HIDE = "hide" + EVENT_KEY;
  var EVENT_HIDDEN = "hidden" + EVENT_KEY;
  var EVENT_SHOW = "show" + EVENT_KEY;
  var EVENT_SHOWN = "shown" + EVENT_KEY;
  var SELECTOR_DATA_DISMISS = '[data-dismiss="toast"]';
  var Default = {
    animation: true,
    autohide: true,
    delay: 500
  };
  var DefaultType = {
    animation: 'boolean',
    autohide: 'boolean',
    delay: 'number'
  };
  /**
   * Class definition
   */

  var Toast = /*#__PURE__*/function () {
    function Toast(element, config) {
      this._element = element;
      this._config = this._getConfig(config);
      this._timeout = null;

      this._setListeners();
    } // Getters


    var _proto = Toast.prototype;

    // Public
    _proto.show = function show() {
      var _this = this;

      var showEvent = $__default["default"].Event(EVENT_SHOW);
      $__default["default"](this._element).trigger(showEvent);

      if (showEvent.isDefaultPrevented()) {
        return;
      }

      this._clearTimeout();

      if (this._config.animation) {
        this._element.classList.add(CLASS_NAME_FADE);
      }

      var complete = function complete() {
        _this._element.classList.remove(CLASS_NAME_SHOWING);

        _this._element.classList.add(CLASS_NAME_SHOW);

        $__default["default"](_this._element).trigger(EVENT_SHOWN);

        if (_this._config.autohide) {
          _this._timeout = setTimeout(function () {
            _this.hide();
          }, _this._config.delay);
        }
      };

      this._element.classList.remove(CLASS_NAME_HIDE);

      Util.reflow(this._element);

      this._element.classList.add(CLASS_NAME_SHOWING);

      if (this._config.animation) {
        var transitionDuration = Util.getTransitionDurationFromElement(this._element);
        $__default["default"](this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
      } else {
        complete();
      }
    };

    _proto.hide = function hide() {
      if (!this._element.classList.contains(CLASS_NAME_SHOW)) {
        return;
      }

      var hideEvent = $__default["default"].Event(EVENT_HIDE);
      $__default["default"](this._element).trigger(hideEvent);

      if (hideEvent.isDefaultPrevented()) {
        return;
      }

      this._close();
    };

    _proto.dispose = function dispose() {
      this._clearTimeout();

      if (this._element.classList.contains(CLASS_NAME_SHOW)) {
        this._element.classList.remove(CLASS_NAME_SHOW);
      }

      $__default["default"](this._element).off(EVENT_CLICK_DISMISS);
      $__default["default"].removeData(this._element, DATA_KEY);
      this._element = null;
      this._config = null;
    } // Private
    ;

    _proto._getConfig = function _getConfig(config) {
      config = _extends$1({}, Default, $__default["default"](this._element).data(), typeof config === 'object' && config ? config : {});
      Util.typeCheckConfig(NAME, config, this.constructor.DefaultType);
      return config;
    };

    _proto._setListeners = function _setListeners() {
      var _this2 = this;

      $__default["default"](this._element).on(EVENT_CLICK_DISMISS, SELECTOR_DATA_DISMISS, function () {
        return _this2.hide();
      });
    };

    _proto._close = function _close() {
      var _this3 = this;

      var complete = function complete() {
        _this3._element.classList.add(CLASS_NAME_HIDE);

        $__default["default"](_this3._element).trigger(EVENT_HIDDEN);
      };

      this._element.classList.remove(CLASS_NAME_SHOW);

      if (this._config.animation) {
        var transitionDuration = Util.getTransitionDurationFromElement(this._element);
        $__default["default"](this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
      } else {
        complete();
      }
    };

    _proto._clearTimeout = function _clearTimeout() {
      clearTimeout(this._timeout);
      this._timeout = null;
    } // Static
    ;

    Toast._jQueryInterface = function _jQueryInterface(config) {
      return this.each(function () {
        var $element = $__default["default"](this);
        var data = $element.data(DATA_KEY);

        var _config = typeof config === 'object' && config;

        if (!data) {
          data = new Toast(this, _config);
          $element.data(DATA_KEY, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError("No method named \"" + config + "\"");
          }

          data[config](this);
        }
      });
    };

    _createClass(Toast, null, [{
      key: "VERSION",
      get: function get() {
        return VERSION;
      }
    }, {
      key: "DefaultType",
      get: function get() {
        return DefaultType;
      }
    }, {
      key: "Default",
      get: function get() {
        return Default;
      }
    }]);

    return Toast;
  }();
  /**
   * jQuery
   */


  $__default["default"].fn[NAME] = Toast._jQueryInterface;
  $__default["default"].fn[NAME].Constructor = Toast;

  $__default["default"].fn[NAME].noConflict = function () {
    $__default["default"].fn[NAME] = JQUERY_NO_CONFLICT;
    return Toast._jQueryInterface;
  };

  exports.Alert = Alert;
  exports.Button = Button;
  exports.Carousel = Carousel;
  exports.Collapse = Collapse;
  exports.Dropdown = Dropdown;
  exports.Modal = Modal;
  exports.Popover = Popover;
  exports.Scrollspy = ScrollSpy;
  exports.Tab = Tab;
  exports.Toast = Toast;
  exports.Tooltip = Tooltip;
  exports.Util = Util;

  Object.defineProperty(exports, '__esModule', { value: true });

}));
//# sourceMappingURL=bootstrap.bundle.js.map

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
/*!
 * typeahead.js 1.3.1
 * https://github.com/corejavascript/typeahead.js
 * Copyright 2013-2020 Twitter, Inc. and other contributors; Licensed MIT
 */


(function(root, factory) {
    if (typeof define === "function" && define.amd) {
        define([ "jquery" ], function(a0) {
            return root["Bloodhound"] = factory(a0);
        });
    } else if (typeof module === "object" && module.exports) {
        module.exports = factory(require("jquery"));
    } else {
        root["Bloodhound"] = factory(root["jQuery"]);
    }
})(this, function($) {
    var _ = function() {
        "use strict";
        return {
            isMsie: function() {
                return /(msie|trident)/i.test(navigator.userAgent) ? navigator.userAgent.match(/(msie |rv:)(\d+(.\d+)?)/i)[2] : false;
            },
            isBlankString: function(str) {
                return !str || /^\s*$/.test(str);
            },
            escapeRegExChars: function(str) {
                return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            },
            isString: function(obj) {
                return typeof obj === "string";
            },
            isNumber: function(obj) {
                return typeof obj === "number";
            },
            isArray: $.isArray,
            isFunction: $.isFunction,
            isObject: $.isPlainObject,
            isUndefined: function(obj) {
                return typeof obj === "undefined";
            },
            isElement: function(obj) {
                return !!(obj && obj.nodeType === 1);
            },
            isJQuery: function(obj) {
                return obj instanceof $;
            },
            toStr: function toStr(s) {
                return _.isUndefined(s) || s === null ? "" : s + "";
            },
            bind: $.proxy,
            each: function(collection, cb) {
                $.each(collection, reverseArgs);
                function reverseArgs(index, value) {
                    return cb(value, index);
                }
            },
            map: $.map,
            filter: $.grep,
            every: function(obj, test) {
                var result = true;
                if (!obj) {
                    return result;
                }
                $.each(obj, function(key, val) {
                    if (!(result = test.call(null, val, key, obj))) {
                        return false;
                    }
                });
                return !!result;
            },
            some: function(obj, test) {
                var result = false;
                if (!obj) {
                    return result;
                }
                $.each(obj, function(key, val) {
                    if (result = test.call(null, val, key, obj)) {
                        return false;
                    }
                });
                return !!result;
            },
            mixin: $.extend,
            identity: function(x) {
                return x;
            },
            clone: function(obj) {
                return $.extend(true, {}, obj);
            },
            getIdGenerator: function() {
                var counter = 0;
                return function() {
                    return counter++;
                };
            },
            templatify: function templatify(obj) {
                return $.isFunction(obj) ? obj : template;
                function template() {
                    return String(obj);
                }
            },
            defer: function(fn) {
                setTimeout(fn, 0);
            },
            debounce: function(func, wait, immediate) {
                var timeout, result;
                return function() {
                    var context = this, args = arguments, later, callNow;
                    later = function() {
                        timeout = null;
                        if (!immediate) {
                            result = func.apply(context, args);
                        }
                    };
                    callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) {
                        result = func.apply(context, args);
                    }
                    return result;
                };
            },
            throttle: function(func, wait) {
                var context, args, timeout, result, previous, later;
                previous = 0;
                later = function() {
                    previous = new Date();
                    timeout = null;
                    result = func.apply(context, args);
                };
                return function() {
                    var now = new Date(), remaining = wait - (now - previous);
                    context = this;
                    args = arguments;
                    if (remaining <= 0) {
                        clearTimeout(timeout);
                        timeout = null;
                        previous = now;
                        result = func.apply(context, args);
                    } else if (!timeout) {
                        timeout = setTimeout(later, remaining);
                    }
                    return result;
                };
            },
            stringify: function(val) {
                return _.isString(val) ? val : JSON.stringify(val);
            },
            guid: function() {
                function _p8(s) {
                    var p = (Math.random().toString(16) + "000000000").substr(2, 8);
                    return s ? "-" + p.substr(0, 4) + "-" + p.substr(4, 4) : p;
                }
                return "tt-" + _p8() + _p8(true) + _p8(true) + _p8();
            },
            noop: function() {}
        };
    }();
    var VERSION = "1.3.1";
    var tokenizers = function() {
        "use strict";
        return {
            nonword: nonword,
            whitespace: whitespace,
            ngram: ngram,
            obj: {
                nonword: getObjTokenizer(nonword),
                whitespace: getObjTokenizer(whitespace),
                ngram: getObjTokenizer(ngram)
            }
        };
        function whitespace(str) {
            str = _.toStr(str);
            return str ? str.split(/\s+/) : [];
        }
        function nonword(str) {
            str = _.toStr(str);
            return str ? str.split(/\W+/) : [];
        }
        function ngram(str) {
            str = _.toStr(str);
            var tokens = [], word = "";
            _.each(str.split(""), function(char) {
                if (char.match(/\s+/)) {
                    word = "";
                } else {
                    tokens.push(word + char);
                    word += char;
                }
            });
            return tokens;
        }
        function getObjTokenizer(tokenizer) {
            return function setKey(keys) {
                keys = _.isArray(keys) ? keys : [].slice.call(arguments, 0);
                return function tokenize(o) {
                    var tokens = [];
                    _.each(keys, function(k) {
                        tokens = tokens.concat(tokenizer(_.toStr(o[k])));
                    });
                    return tokens;
                };
            };
        }
    }();
    var LruCache = function() {
        "use strict";
        function LruCache(maxSize) {
            this.maxSize = _.isNumber(maxSize) ? maxSize : 100;
            this.reset();
            if (this.maxSize <= 0) {
                this.set = this.get = $.noop;
            }
        }
        _.mixin(LruCache.prototype, {
            set: function set(key, val) {
                var tailItem = this.list.tail, node;
                if (this.size >= this.maxSize) {
                    this.list.remove(tailItem);
                    delete this.hash[tailItem.key];
                    this.size--;
                }
                if (node = this.hash[key]) {
                    node.val = val;
                    this.list.moveToFront(node);
                } else {
                    node = new Node(key, val);
                    this.list.add(node);
                    this.hash[key] = node;
                    this.size++;
                }
            },
            get: function get(key) {
                var node = this.hash[key];
                if (node) {
                    this.list.moveToFront(node);
                    return node.val;
                }
            },
            reset: function reset() {
                this.size = 0;
                this.hash = {};
                this.list = new List();
            }
        });
        function List() {
            this.head = this.tail = null;
        }
        _.mixin(List.prototype, {
            add: function add(node) {
                if (this.head) {
                    node.next = this.head;
                    this.head.prev = node;
                }
                this.head = node;
                this.tail = this.tail || node;
            },
            remove: function remove(node) {
                node.prev ? node.prev.next = node.next : this.head = node.next;
                node.next ? node.next.prev = node.prev : this.tail = node.prev;
            },
            moveToFront: function(node) {
                this.remove(node);
                this.add(node);
            }
        });
        function Node(key, val) {
            this.key = key;
            this.val = val;
            this.prev = this.next = null;
        }
        return LruCache;
    }();
    var PersistentStorage = function() {
        "use strict";
        var LOCAL_STORAGE;
        try {
            LOCAL_STORAGE = window.localStorage;
            LOCAL_STORAGE.setItem("~~~", "!");
            LOCAL_STORAGE.removeItem("~~~");
        } catch (err) {
            LOCAL_STORAGE = null;
        }
        function PersistentStorage(namespace, override) {
            this.prefix = [ "__", namespace, "__" ].join("");
            this.ttlKey = "__ttl__";
            this.keyMatcher = new RegExp("^" + _.escapeRegExChars(this.prefix));
            this.ls = override || LOCAL_STORAGE;
            !this.ls && this._noop();
        }
        _.mixin(PersistentStorage.prototype, {
            _prefix: function(key) {
                return this.prefix + key;
            },
            _ttlKey: function(key) {
                return this._prefix(key) + this.ttlKey;
            },
            _noop: function() {
                this.get = this.set = this.remove = this.clear = this.isExpired = _.noop;
            },
            _safeSet: function(key, val) {
                try {
                    this.ls.setItem(key, val);
                } catch (err) {
                    if (err.name === "QuotaExceededError") {
                        this.clear();
                        this._noop();
                    }
                }
            },
            get: function(key) {
                if (this.isExpired(key)) {
                    this.remove(key);
                }
                return decode(this.ls.getItem(this._prefix(key)));
            },
            set: function(key, val, ttl) {
                if (_.isNumber(ttl)) {
                    this._safeSet(this._ttlKey(key), encode(now() + ttl));
                } else {
                    this.ls.removeItem(this._ttlKey(key));
                }
                return this._safeSet(this._prefix(key), encode(val));
            },
            remove: function(key) {
                this.ls.removeItem(this._ttlKey(key));
                this.ls.removeItem(this._prefix(key));
                return this;
            },
            clear: function() {
                var i, keys = gatherMatchingKeys(this.keyMatcher);
                for (i = keys.length; i--; ) {
                    this.remove(keys[i]);
                }
                return this;
            },
            isExpired: function(key) {
                var ttl = decode(this.ls.getItem(this._ttlKey(key)));
                return _.isNumber(ttl) && now() > ttl ? true : false;
            }
        });
        return PersistentStorage;
        function now() {
            return new Date().getTime();
        }
        function encode(val) {
            return JSON.stringify(_.isUndefined(val) ? null : val);
        }
        function decode(val) {
            return $.parseJSON(val);
        }
        function gatherMatchingKeys(keyMatcher) {
            var i, key, keys = [], len = LOCAL_STORAGE.length;
            for (i = 0; i < len; i++) {
                if ((key = LOCAL_STORAGE.key(i)).match(keyMatcher)) {
                    keys.push(key.replace(keyMatcher, ""));
                }
            }
            return keys;
        }
    }();
    var Transport = function() {
        "use strict";
        var pendingRequestsCount = 0, pendingRequests = {}, sharedCache = new LruCache(10);
        function Transport(o) {
            o = o || {};
            this.maxPendingRequests = o.maxPendingRequests || 6;
            this.cancelled = false;
            this.lastReq = null;
            this._send = o.transport;
            this._get = o.limiter ? o.limiter(this._get) : this._get;
            this._cache = o.cache === false ? new LruCache(0) : sharedCache;
        }
        Transport.setMaxPendingRequests = function setMaxPendingRequests(num) {
            this.maxPendingRequests = num;
        };
        Transport.resetCache = function resetCache() {
            sharedCache.reset();
        };
        _.mixin(Transport.prototype, {
            _fingerprint: function fingerprint(o) {
                o = o || {};
                return o.url + o.type + $.param(o.data || {});
            },
            _get: function(o, cb) {
                var that = this, fingerprint, jqXhr;
                fingerprint = this._fingerprint(o);
                if (this.cancelled || fingerprint !== this.lastReq) {
                    return;
                }
                if (jqXhr = pendingRequests[fingerprint]) {
                    jqXhr.done(done).fail(fail);
                } else if (pendingRequestsCount < this.maxPendingRequests) {
                    pendingRequestsCount++;
                    pendingRequests[fingerprint] = this._send(o).done(done).fail(fail).always(always);
                } else {
                    this.onDeckRequestArgs = [].slice.call(arguments, 0);
                }
                function done(resp) {
                    cb(null, resp);
                    that._cache.set(fingerprint, resp);
                }
                function fail() {
                    cb(true);
                }
                function always() {
                    pendingRequestsCount--;
                    delete pendingRequests[fingerprint];
                    if (that.onDeckRequestArgs) {
                        that._get.apply(that, that.onDeckRequestArgs);
                        that.onDeckRequestArgs = null;
                    }
                }
            },
            get: function(o, cb) {
                var resp, fingerprint;
                cb = cb || $.noop;
                o = _.isString(o) ? {
                    url: o
                } : o || {};
                fingerprint = this._fingerprint(o);
                this.cancelled = false;
                this.lastReq = fingerprint;
                if (resp = this._cache.get(fingerprint)) {
                    cb(null, resp);
                } else {
                    this._get(o, cb);
                }
            },
            cancel: function() {
                this.cancelled = true;
            }
        });
        return Transport;
    }();
    var SearchIndex = window.SearchIndex = function() {
        "use strict";
        var CHILDREN = "c", IDS = "i";
        function SearchIndex(o) {
            o = o || {};
            if (!o.datumTokenizer || !o.queryTokenizer) {
                $.error("datumTokenizer and queryTokenizer are both required");
            }
            this.identify = o.identify || _.stringify;
            this.datumTokenizer = o.datumTokenizer;
            this.queryTokenizer = o.queryTokenizer;
            this.matchAnyQueryToken = o.matchAnyQueryToken;
            this.reset();
        }
        _.mixin(SearchIndex.prototype, {
            bootstrap: function bootstrap(o) {
                this.datums = o.datums;
                this.trie = o.trie;
            },
            add: function(data) {
                var that = this;
                data = _.isArray(data) ? data : [ data ];
                _.each(data, function(datum) {
                    var id, tokens;
                    that.datums[id = that.identify(datum)] = datum;
                    tokens = normalizeTokens(that.datumTokenizer(datum));
                    _.each(tokens, function(token) {
                        var node, chars, ch;
                        node = that.trie;
                        chars = token.split("");
                        while (ch = chars.shift()) {
                            node = node[CHILDREN][ch] || (node[CHILDREN][ch] = newNode());
                            node[IDS].push(id);
                        }
                    });
                });
            },
            get: function get(ids) {
                var that = this;
                return _.map(ids, function(id) {
                    return that.datums[id];
                });
            },
            search: function search(query) {
                var that = this, tokens, matches;
                tokens = normalizeTokens(this.queryTokenizer(query));
                _.each(tokens, function(token) {
                    var node, chars, ch, ids;
                    if (matches && matches.length === 0 && !that.matchAnyQueryToken) {
                        return false;
                    }
                    node = that.trie;
                    chars = token.split("");
                    while (node && (ch = chars.shift())) {
                        node = node[CHILDREN][ch];
                    }
                    if (node && chars.length === 0) {
                        ids = node[IDS].slice(0);
                        matches = matches ? getIntersection(matches, ids) : ids;
                    } else {
                        if (!that.matchAnyQueryToken) {
                            matches = [];
                            return false;
                        }
                    }
                });
                return matches ? _.map(unique(matches), function(id) {
                    return that.datums[id];
                }) : [];
            },
            all: function all() {
                var values = [];
                for (var key in this.datums) {
                    values.push(this.datums[key]);
                }
                return values;
            },
            reset: function reset() {
                this.datums = {};
                this.trie = newNode();
            },
            serialize: function serialize() {
                return {
                    datums: this.datums,
                    trie: this.trie
                };
            }
        });
        return SearchIndex;
        function normalizeTokens(tokens) {
            tokens = _.filter(tokens, function(token) {
                return !!token;
            });
            tokens = _.map(tokens, function(token) {
                return token.toLowerCase();
            });
            return tokens;
        }
        function newNode() {
            var node = {};
            node[IDS] = [];
            node[CHILDREN] = {};
            return node;
        }
        function unique(array) {
            var seen = {}, uniques = [];
            for (var i = 0, len = array.length; i < len; i++) {
                if (!seen[array[i]]) {
                    seen[array[i]] = true;
                    uniques.push(array[i]);
                }
            }
            return uniques;
        }
        function getIntersection(arrayA, arrayB) {
            var ai = 0, bi = 0, intersection = [];
            arrayA = arrayA.sort();
            arrayB = arrayB.sort();
            var lenArrayA = arrayA.length, lenArrayB = arrayB.length;
            while (ai < lenArrayA && bi < lenArrayB) {
                if (arrayA[ai] < arrayB[bi]) {
                    ai++;
                } else if (arrayA[ai] > arrayB[bi]) {
                    bi++;
                } else {
                    intersection.push(arrayA[ai]);
                    ai++;
                    bi++;
                }
            }
            return intersection;
        }
    }();
    var Prefetch = function() {
        "use strict";
        var keys;
        keys = {
            data: "data",
            protocol: "protocol",
            thumbprint: "thumbprint"
        };
        function Prefetch(o) {
            this.url = o.url;
            this.ttl = o.ttl;
            this.cache = o.cache;
            this.prepare = o.prepare;
            this.transform = o.transform;
            this.transport = o.transport;
            this.thumbprint = o.thumbprint;
            this.storage = new PersistentStorage(o.cacheKey);
        }
        _.mixin(Prefetch.prototype, {
            _settings: function settings() {
                return {
                    url: this.url,
                    type: "GET",
                    dataType: "json"
                };
            },
            store: function store(data) {
                if (!this.cache) {
                    return;
                }
                this.storage.set(keys.data, data, this.ttl);
                this.storage.set(keys.protocol, location.protocol, this.ttl);
                this.storage.set(keys.thumbprint, this.thumbprint, this.ttl);
            },
            fromCache: function fromCache() {
                var stored = {}, isExpired;
                if (!this.cache) {
                    return null;
                }
                stored.data = this.storage.get(keys.data);
                stored.protocol = this.storage.get(keys.protocol);
                stored.thumbprint = this.storage.get(keys.thumbprint);
                isExpired = stored.thumbprint !== this.thumbprint || stored.protocol !== location.protocol;
                return stored.data && !isExpired ? stored.data : null;
            },
            fromNetwork: function(cb) {
                var that = this, settings;
                if (!cb) {
                    return;
                }
                settings = this.prepare(this._settings());
                this.transport(settings).fail(onError).done(onResponse);
                function onError() {
                    cb(true);
                }
                function onResponse(resp) {
                    cb(null, that.transform(resp));
                }
            },
            clear: function clear() {
                this.storage.clear();
                return this;
            }
        });
        return Prefetch;
    }();
    var Remote = function() {
        "use strict";
        function Remote(o) {
            this.url = o.url;
            this.prepare = o.prepare;
            this.transform = o.transform;
            this.indexResponse = o.indexResponse;
            this.transport = new Transport({
                cache: o.cache,
                limiter: o.limiter,
                transport: o.transport,
                maxPendingRequests: o.maxPendingRequests
            });
        }
        _.mixin(Remote.prototype, {
            _settings: function settings() {
                return {
                    url: this.url,
                    type: "GET",
                    dataType: "json"
                };
            },
            get: function get(query, cb) {
                var that = this, settings;
                if (!cb) {
                    return;
                }
                query = query || "";
                settings = this.prepare(query, this._settings());
                return this.transport.get(settings, onResponse);
                function onResponse(err, resp) {
                    err ? cb([]) : cb(that.transform(resp));
                }
            },
            cancelLastRequest: function cancelLastRequest() {
                this.transport.cancel();
            }
        });
        return Remote;
    }();
    var oParser = function() {
        "use strict";
        return function parse(o) {
            var defaults, sorter;
            defaults = {
                initialize: true,
                identify: _.stringify,
                datumTokenizer: null,
                queryTokenizer: null,
                matchAnyQueryToken: false,
                sufficient: 5,
                indexRemote: false,
                sorter: null,
                local: [],
                prefetch: null,
                remote: null
            };
            o = _.mixin(defaults, o || {});
            !o.datumTokenizer && $.error("datumTokenizer is required");
            !o.queryTokenizer && $.error("queryTokenizer is required");
            sorter = o.sorter;
            o.sorter = sorter ? function(x) {
                return x.sort(sorter);
            } : _.identity;
            o.local = _.isFunction(o.local) ? o.local() : o.local;
            o.prefetch = parsePrefetch(o.prefetch);
            o.remote = parseRemote(o.remote);
            return o;
        };
        function parsePrefetch(o) {
            var defaults;
            if (!o) {
                return null;
            }
            defaults = {
                url: null,
                ttl: 24 * 60 * 60 * 1e3,
                cache: true,
                cacheKey: null,
                thumbprint: "",
                prepare: _.identity,
                transform: _.identity,
                transport: null
            };
            o = _.isString(o) ? {
                url: o
            } : o;
            o = _.mixin(defaults, o);
            !o.url && $.error("prefetch requires url to be set");
            o.transform = o.filter || o.transform;
            o.cacheKey = o.cacheKey || o.url;
            o.thumbprint = VERSION + o.thumbprint;
            o.transport = o.transport ? callbackToDeferred(o.transport) : $.ajax;
            return o;
        }
        function parseRemote(o) {
            var defaults;
            if (!o) {
                return;
            }
            defaults = {
                url: null,
                cache: true,
                prepare: null,
                replace: null,
                wildcard: null,
                limiter: null,
                rateLimitBy: "debounce",
                rateLimitWait: 300,
                transform: _.identity,
                transport: null
            };
            o = _.isString(o) ? {
                url: o
            } : o;
            o = _.mixin(defaults, o);
            !o.url && $.error("remote requires url to be set");
            o.transform = o.filter || o.transform;
            o.prepare = toRemotePrepare(o);
            o.limiter = toLimiter(o);
            o.transport = o.transport ? callbackToDeferred(o.transport) : $.ajax;
            delete o.replace;
            delete o.wildcard;
            delete o.rateLimitBy;
            delete o.rateLimitWait;
            return o;
        }
        function toRemotePrepare(o) {
            var prepare, replace, wildcard;
            prepare = o.prepare;
            replace = o.replace;
            wildcard = o.wildcard;
            if (prepare) {
                return prepare;
            }
            if (replace) {
                prepare = prepareByReplace;
            } else if (o.wildcard) {
                prepare = prepareByWildcard;
            } else {
                prepare = identityPrepare;
            }
            return prepare;
            function prepareByReplace(query, settings) {
                settings.url = replace(settings.url, query);
                return settings;
            }
            function prepareByWildcard(query, settings) {
                settings.url = settings.url.replace(wildcard, encodeURIComponent(query));
                return settings;
            }
            function identityPrepare(query, settings) {
                return settings;
            }
        }
        function toLimiter(o) {
            var limiter, method, wait;
            limiter = o.limiter;
            method = o.rateLimitBy;
            wait = o.rateLimitWait;
            if (!limiter) {
                limiter = /^throttle$/i.test(method) ? throttle(wait) : debounce(wait);
            }
            return limiter;
            function debounce(wait) {
                return function debounce(fn) {
                    return _.debounce(fn, wait);
                };
            }
            function throttle(wait) {
                return function throttle(fn) {
                    return _.throttle(fn, wait);
                };
            }
        }
        function callbackToDeferred(fn) {
            return function wrapper(o) {
                var deferred = $.Deferred();
                fn(o, onSuccess, onError);
                return deferred;
                function onSuccess(resp) {
                    _.defer(function() {
                        deferred.resolve(resp);
                    });
                }
                function onError(err) {
                    _.defer(function() {
                        deferred.reject(err);
                    });
                }
            };
        }
    }();
    var Bloodhound = function() {
        "use strict";
        var old;
        old = window && window.Bloodhound;
        function Bloodhound(o) {
            o = oParser(o);
            this.sorter = o.sorter;
            this.identify = o.identify;
            this.sufficient = o.sufficient;
            this.indexRemote = o.indexRemote;
            this.local = o.local;
            this.remote = o.remote ? new Remote(o.remote) : null;
            this.prefetch = o.prefetch ? new Prefetch(o.prefetch) : null;
            this.index = new SearchIndex({
                identify: this.identify,
                datumTokenizer: o.datumTokenizer,
                queryTokenizer: o.queryTokenizer
            });
            o.initialize !== false && this.initialize();
        }
        Bloodhound.noConflict = function noConflict() {
            window && (window.Bloodhound = old);
            return Bloodhound;
        };
        Bloodhound.tokenizers = tokenizers;
        _.mixin(Bloodhound.prototype, {
            __ttAdapter: function ttAdapter() {
                var that = this;
                return this.remote ? withAsync : withoutAsync;
                function withAsync(query, sync, async) {
                    return that.search(query, sync, async);
                }
                function withoutAsync(query, sync) {
                    return that.search(query, sync);
                }
            },
            _loadPrefetch: function loadPrefetch() {
                var that = this, deferred, serialized;
                deferred = $.Deferred();
                if (!this.prefetch) {
                    deferred.resolve();
                } else if (serialized = this.prefetch.fromCache()) {
                    this.index.bootstrap(serialized);
                    deferred.resolve();
                } else {
                    this.prefetch.fromNetwork(done);
                }
                return deferred.promise();
                function done(err, data) {
                    if (err) {
                        return deferred.reject();
                    }
                    that.add(data);
                    that.prefetch.store(that.index.serialize());
                    deferred.resolve();
                }
            },
            _initialize: function initialize() {
                var that = this, deferred;
                this.clear();
                (this.initPromise = this._loadPrefetch()).done(addLocalToIndex);
                return this.initPromise;
                function addLocalToIndex() {
                    that.add(that.local);
                }
            },
            initialize: function initialize(force) {
                return !this.initPromise || force ? this._initialize() : this.initPromise;
            },
            add: function add(data) {
                this.index.add(data);
                return this;
            },
            get: function get(ids) {
                ids = _.isArray(ids) ? ids : [].slice.call(arguments);
                return this.index.get(ids);
            },
            search: function search(query, sync, async) {
                var that = this, local;
                sync = sync || _.noop;
                async = async || _.noop;
                local = this.sorter(this.index.search(query));
                sync(this.remote ? local.slice() : local);
                if (this.remote && local.length < this.sufficient) {
                    this.remote.get(query, processRemote);
                } else if (this.remote) {
                    this.remote.cancelLastRequest();
                }
                return this;
                function processRemote(remote) {
                    var nonDuplicates = [];
                    _.each(remote, function(r) {
                        !_.some(local, function(l) {
                            return that.identify(r) === that.identify(l);
                        }) && nonDuplicates.push(r);
                    });
                    that.indexRemote && that.add(nonDuplicates);
                    async(nonDuplicates);
                }
            },
            all: function all() {
                return this.index.all();
            },
            clear: function clear() {
                this.index.reset();
                return this;
            },
            clearPrefetchCache: function clearPrefetchCache() {
                this.prefetch && this.prefetch.clear();
                return this;
            },
            clearRemoteCache: function clearRemoteCache() {
                Transport.resetCache();
                return this;
            },
            ttAdapter: function ttAdapter() {
                return this.__ttAdapter();
            }
        });
        return Bloodhound;
    }();
    return Bloodhound;
});

(function(root, factory) {
    if (typeof define === "function" && define.amd) {
        define([ "jquery" ], function(a0) {
            return factory(a0);
        });
    } else if (typeof module === "object" && module.exports) {
        module.exports = factory(require("jquery"));
    } else {
        factory(root["jQuery"]);
    }
})(this, function($) {
    var _ = function() {
        "use strict";
        return {
            isMsie: function() {
                return /(msie|trident)/i.test(navigator.userAgent) ? navigator.userAgent.match(/(msie |rv:)(\d+(.\d+)?)/i)[2] : false;
            },
            isBlankString: function(str) {
                return !str || /^\s*$/.test(str);
            },
            escapeRegExChars: function(str) {
                return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            },
            isString: function(obj) {
                return typeof obj === "string";
            },
            isNumber: function(obj) {
                return typeof obj === "number";
            },
            isArray: $.isArray,
            isFunction: $.isFunction,
            isObject: $.isPlainObject,
            isUndefined: function(obj) {
                return typeof obj === "undefined";
            },
            isElement: function(obj) {
                return !!(obj && obj.nodeType === 1);
            },
            isJQuery: function(obj) {
                return obj instanceof $;
            },
            toStr: function toStr(s) {
                return _.isUndefined(s) || s === null ? "" : s + "";
            },
            bind: $.proxy,
            each: function(collection, cb) {
                $.each(collection, reverseArgs);
                function reverseArgs(index, value) {
                    return cb(value, index);
                }
            },
            map: $.map,
            filter: $.grep,
            every: function(obj, test) {
                var result = true;
                if (!obj) {
                    return result;
                }
                $.each(obj, function(key, val) {
                    if (!(result = test.call(null, val, key, obj))) {
                        return false;
                    }
                });
                return !!result;
            },
            some: function(obj, test) {
                var result = false;
                if (!obj) {
                    return result;
                }
                $.each(obj, function(key, val) {
                    if (result = test.call(null, val, key, obj)) {
                        return false;
                    }
                });
                return !!result;
            },
            mixin: $.extend,
            identity: function(x) {
                return x;
            },
            clone: function(obj) {
                return $.extend(true, {}, obj);
            },
            getIdGenerator: function() {
                var counter = 0;
                return function() {
                    return counter++;
                };
            },
            templatify: function templatify(obj) {
                return $.isFunction(obj) ? obj : template;
                function template() {
                    return String(obj);
                }
            },
            defer: function(fn) {
                setTimeout(fn, 0);
            },
            debounce: function(func, wait, immediate) {
                var timeout, result;
                return function() {
                    var context = this, args = arguments, later, callNow;
                    later = function() {
                        timeout = null;
                        if (!immediate) {
                            result = func.apply(context, args);
                        }
                    };
                    callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) {
                        result = func.apply(context, args);
                    }
                    return result;
                };
            },
            throttle: function(func, wait) {
                var context, args, timeout, result, previous, later;
                previous = 0;
                later = function() {
                    previous = new Date();
                    timeout = null;
                    result = func.apply(context, args);
                };
                return function() {
                    var now = new Date(), remaining = wait - (now - previous);
                    context = this;
                    args = arguments;
                    if (remaining <= 0) {
                        clearTimeout(timeout);
                        timeout = null;
                        previous = now;
                        result = func.apply(context, args);
                    } else if (!timeout) {
                        timeout = setTimeout(later, remaining);
                    }
                    return result;
                };
            },
            stringify: function(val) {
                return _.isString(val) ? val : JSON.stringify(val);
            },
            guid: function() {
                function _p8(s) {
                    var p = (Math.random().toString(16) + "000000000").substr(2, 8);
                    return s ? "-" + p.substr(0, 4) + "-" + p.substr(4, 4) : p;
                }
                return "tt-" + _p8() + _p8(true) + _p8(true) + _p8();
            },
            noop: function() {}
        };
    }();
    var WWW = function() {
        "use strict";
        var defaultClassNames = {
            wrapper: "twitter-typeahead",
            input: "tt-input",
            hint: "tt-hint",
            menu: "tt-menu",
            dataset: "tt-dataset",
            suggestion: "tt-suggestion",
            selectable: "tt-selectable",
            empty: "tt-empty",
            open: "tt-open",
            cursor: "tt-cursor",
            highlight: "tt-highlight"
        };
        return build;
        function build(o) {
            var www, classes;
            classes = _.mixin({}, defaultClassNames, o);
            www = {
                css: buildCss(),
                classes: classes,
                html: buildHtml(classes),
                selectors: buildSelectors(classes)
            };
            return {
                css: www.css,
                html: www.html,
                classes: www.classes,
                selectors: www.selectors,
                mixin: function(o) {
                    _.mixin(o, www);
                }
            };
        }
        function buildHtml(c) {
            return {
                wrapper: '<span class="' + c.wrapper + '"></span>',
                menu: '<div role="listbox" class="' + c.menu + '"></div>'
            };
        }
        function buildSelectors(classes) {
            var selectors = {};
            _.each(classes, function(v, k) {
                selectors[k] = "." + v;
            });
            return selectors;
        }
        function buildCss() {
            var css = {
                wrapper: {
                    position: "relative",
                    display: "inline-block"
                },
                hint: {
                    position: "absolute",
                    top: "0",
                    left: "0",
                    borderColor: "transparent",
                    boxShadow: "none",
                    opacity: "1"
                },
                input: {
                    position: "relative",
                    verticalAlign: "top",
                    backgroundColor: "transparent"
                },
                inputWithNoHint: {
                    position: "relative",
                    verticalAlign: "top"
                },
                menu: {
                    position: "absolute",
                    top: "100%",
                    left: "0",
                    zIndex: "100",
                    display: "none"
                },
                ltr: {
                    left: "0",
                    right: "auto"
                },
                rtl: {
                    left: "auto",
                    right: " 0"
                }
            };
            if (_.isMsie()) {
                _.mixin(css.input, {
                    backgroundImage: "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)"
                });
            }
            return css;
        }
    }();
    var EventBus = function() {
        "use strict";
        var namespace, deprecationMap;
        namespace = "typeahead:";
        deprecationMap = {
            render: "rendered",
            cursorchange: "cursorchanged",
            select: "selected",
            autocomplete: "autocompleted"
        };
        function EventBus(o) {
            if (!o || !o.el) {
                $.error("EventBus initialized without el");
            }
            this.$el = $(o.el);
        }
        _.mixin(EventBus.prototype, {
            _trigger: function(type, args) {
                var $e = $.Event(namespace + type);
                this.$el.trigger.call(this.$el, $e, args || []);
                return $e;
            },
            before: function(type) {
                var args, $e;
                args = [].slice.call(arguments, 1);
                $e = this._trigger("before" + type, args);
                return $e.isDefaultPrevented();
            },
            trigger: function(type) {
                var deprecatedType;
                this._trigger(type, [].slice.call(arguments, 1));
                if (deprecatedType = deprecationMap[type]) {
                    this._trigger(deprecatedType, [].slice.call(arguments, 1));
                }
            }
        });
        return EventBus;
    }();
    var EventEmitter = function() {
        "use strict";
        var splitter = /\s+/, nextTick = getNextTick();
        return {
            onSync: onSync,
            onAsync: onAsync,
            off: off,
            trigger: trigger
        };
        function on(method, types, cb, context) {
            var type;
            if (!cb) {
                return this;
            }
            types = types.split(splitter);
            cb = context ? bindContext(cb, context) : cb;
            this._callbacks = this._callbacks || {};
            while (type = types.shift()) {
                this._callbacks[type] = this._callbacks[type] || {
                    sync: [],
                    async: []
                };
                this._callbacks[type][method].push(cb);
            }
            return this;
        }
        function onAsync(types, cb, context) {
            return on.call(this, "async", types, cb, context);
        }
        function onSync(types, cb, context) {
            return on.call(this, "sync", types, cb, context);
        }
        function off(types) {
            var type;
            if (!this._callbacks) {
                return this;
            }
            types = types.split(splitter);
            while (type = types.shift()) {
                delete this._callbacks[type];
            }
            return this;
        }
        function trigger(types) {
            var type, callbacks, args, syncFlush, asyncFlush;
            if (!this._callbacks) {
                return this;
            }
            types = types.split(splitter);
            args = [].slice.call(arguments, 1);
            while ((type = types.shift()) && (callbacks = this._callbacks[type])) {
                syncFlush = getFlush(callbacks.sync, this, [ type ].concat(args));
                asyncFlush = getFlush(callbacks.async, this, [ type ].concat(args));
                syncFlush() && nextTick(asyncFlush);
            }
            return this;
        }
        function getFlush(callbacks, context, args) {
            return flush;
            function flush() {
                var cancelled;
                for (var i = 0, len = callbacks.length; !cancelled && i < len; i += 1) {
                    cancelled = callbacks[i].apply(context, args) === false;
                }
                return !cancelled;
            }
        }
        function getNextTick() {
            var nextTickFn;
            if (window.setImmediate) {
                nextTickFn = function nextTickSetImmediate(fn) {
                    setImmediate(function() {
                        fn();
                    });
                };
            } else {
                nextTickFn = function nextTickSetTimeout(fn) {
                    setTimeout(function() {
                        fn();
                    }, 0);
                };
            }
            return nextTickFn;
        }
        function bindContext(fn, context) {
            return fn.bind ? fn.bind(context) : function() {
                fn.apply(context, [].slice.call(arguments, 0));
            };
        }
    }();
    var highlight = function(doc) {
        "use strict";
        var defaults = {
            node: null,
            pattern: null,
            tagName: "strong",
            className: null,
            wordsOnly: false,
            caseSensitive: false,
            diacriticInsensitive: false
        };
        var accented = {
            A: "[AaªÀ-Åà-åĀ-ąǍǎȀ-ȃȦȧᴬᵃḀḁẚẠ-ảₐ℀℁℻⒜Ⓐⓐ㍱-㍴㎀-㎄㎈㎉㎩-㎯㏂㏊㏟㏿Ａａ]",
            B: "[BbᴮᵇḂ-ḇℬ⒝Ⓑⓑ㍴㎅-㎇㏃㏈㏔㏝Ｂｂ]",
            C: "[CcÇçĆ-čᶜ℀ℂ℃℅℆ℭⅭⅽ⒞Ⓒⓒ㍶㎈㎉㎝㎠㎤㏄-㏇Ｃｃ]",
            D: "[DdĎďǄ-ǆǱ-ǳᴰᵈḊ-ḓⅅⅆⅮⅾ⒟Ⓓⓓ㋏㍲㍷-㍹㎗㎭-㎯㏅㏈Ｄｄ]",
            E: "[EeÈ-Ëè-ëĒ-ěȄ-ȇȨȩᴱᵉḘ-ḛẸ-ẽₑ℡ℯℰⅇ⒠Ⓔⓔ㉐㋍㋎Ｅｅ]",
            F: "[FfᶠḞḟ℉ℱ℻⒡Ⓕⓕ㎊-㎌㎙ﬀ-ﬄＦｆ]",
            G: "[GgĜ-ģǦǧǴǵᴳᵍḠḡℊ⒢Ⓖⓖ㋌㋍㎇㎍-㎏㎓㎬㏆㏉㏒㏿Ｇｇ]",
            H: "[HhĤĥȞȟʰᴴḢ-ḫẖℋ-ℎ⒣Ⓗⓗ㋌㍱㎐-㎔㏊㏋㏗Ｈｈ]",
            I: "[IiÌ-Ïì-ïĨ-İĲĳǏǐȈ-ȋᴵᵢḬḭỈ-ịⁱℐℑℹⅈⅠ-ⅣⅥ-ⅨⅪⅫⅰ-ⅳⅵ-ⅸⅺⅻ⒤Ⓘⓘ㍺㏌㏕ﬁﬃＩｉ]",
            J: "[JjĲ-ĵǇ-ǌǰʲᴶⅉ⒥ⒿⓙⱼＪｊ]",
            K: "[KkĶķǨǩᴷᵏḰ-ḵK⒦Ⓚⓚ㎄㎅㎉㎏㎑㎘㎞㎢㎦㎪㎸㎾㏀㏆㏍-㏏Ｋｋ]",
            L: "[LlĹ-ŀǇ-ǉˡᴸḶḷḺ-ḽℒℓ℡Ⅼⅼ⒧Ⓛⓛ㋏㎈㎉㏐-㏓㏕㏖㏿ﬂﬄＬｌ]",
            M: "[MmᴹᵐḾ-ṃ℠™ℳⅯⅿ⒨Ⓜⓜ㍷-㍹㎃㎆㎎㎒㎖㎙-㎨㎫㎳㎷㎹㎽㎿㏁㏂㏎㏐㏔-㏖㏘㏙㏞㏟Ｍｍ]",
            N: "[NnÑñŃ-ŉǊ-ǌǸǹᴺṄ-ṋⁿℕ№⒩Ⓝⓝ㎁㎋㎚㎱㎵㎻㏌㏑Ｎｎ]",
            O: "[OoºÒ-Öò-öŌ-őƠơǑǒǪǫȌ-ȏȮȯᴼᵒỌ-ỏₒ℅№ℴ⒪Ⓞⓞ㍵㏇㏒㏖Ｏｏ]",
            P: "[PpᴾᵖṔ-ṗℙ⒫Ⓟⓟ㉐㍱㍶㎀㎊㎩-㎬㎰㎴㎺㏋㏗-㏚Ｐｐ]",
            Q: "[Qqℚ⒬Ⓠⓠ㏃Ｑｑ]",
            R: "[RrŔ-řȐ-ȓʳᴿᵣṘ-ṛṞṟ₨ℛ-ℝ⒭Ⓡⓡ㋍㍴㎭-㎯㏚㏛Ｒｒ]",
            S: "[SsŚ-šſȘșˢṠ-ṣ₨℁℠⒮Ⓢⓢ㎧㎨㎮-㎳㏛㏜ﬆＳｓ]",
            T: "[TtŢ-ťȚțᵀᵗṪ-ṱẗ℡™⒯Ⓣⓣ㉐㋏㎔㏏ﬅﬆＴｔ]",
            U: "[UuÙ-Üù-üŨ-ųƯưǓǔȔ-ȗᵁᵘᵤṲ-ṷỤ-ủ℆⒰Ⓤⓤ㍳㍺Ｕｕ]",
            V: "[VvᵛᵥṼ-ṿⅣ-Ⅷⅳ-ⅷ⒱Ⓥⓥⱽ㋎㍵㎴-㎹㏜㏞Ｖｖ]",
            W: "[WwŴŵʷᵂẀ-ẉẘ⒲Ⓦⓦ㎺-㎿㏝Ｗｗ]",
            X: "[XxˣẊ-ẍₓ℻Ⅸ-Ⅻⅸ-ⅻ⒳Ⓧⓧ㏓Ｘｘ]",
            Y: "[YyÝýÿŶ-ŸȲȳʸẎẏẙỲ-ỹ⒴Ⓨⓨ㏉Ｙｙ]",
            Z: "[ZzŹ-žǱ-ǳᶻẐ-ẕℤℨ⒵Ⓩⓩ㎐-㎔Ｚｚ]"
        };
        return function hightlight(o) {
            var regex;
            o = _.mixin({}, defaults, o);
            if (!o.node || !o.pattern) {
                return;
            }
            o.pattern = _.isArray(o.pattern) ? o.pattern : [ o.pattern ];
            regex = getRegex(o.pattern, o.caseSensitive, o.wordsOnly, o.diacriticInsensitive);
            traverse(o.node, hightlightTextNode);
            function hightlightTextNode(textNode) {
                var match, patternNode, wrapperNode;
                if (match = regex.exec(textNode.data)) {
                    wrapperNode = doc.createElement(o.tagName);
                    o.className && (wrapperNode.className = o.className);
                    patternNode = textNode.splitText(match.index);
                    patternNode.splitText(match[0].length);
                    wrapperNode.appendChild(patternNode.cloneNode(true));
                    textNode.parentNode.replaceChild(wrapperNode, patternNode);
                }
                return !!match;
            }
            function traverse(el, hightlightTextNode) {
                var childNode, TEXT_NODE_TYPE = 3;
                for (var i = 0; i < el.childNodes.length; i++) {
                    childNode = el.childNodes[i];
                    if (childNode.nodeType === TEXT_NODE_TYPE) {
                        i += hightlightTextNode(childNode) ? 1 : 0;
                    } else {
                        traverse(childNode, hightlightTextNode);
                    }
                }
            }
        };
        function accent_replacer(chr) {
            return accented[chr.toUpperCase()] || chr;
        }
        function getRegex(patterns, caseSensitive, wordsOnly, diacriticInsensitive) {
            var escapedPatterns = [], regexStr;
            for (var i = 0, len = patterns.length; i < len; i++) {
                var escapedWord = _.escapeRegExChars(patterns[i]);
                if (diacriticInsensitive) {
                    escapedWord = escapedWord.replace(/\S/g, accent_replacer);
                }
                escapedPatterns.push(escapedWord);
            }
            regexStr = wordsOnly ? "\\b(" + escapedPatterns.join("|") + ")\\b" : "(" + escapedPatterns.join("|") + ")";
            return caseSensitive ? new RegExp(regexStr) : new RegExp(regexStr, "i");
        }
    }(window.document);
    var Input = function() {
        "use strict";
        var specialKeyCodeMap;
        specialKeyCodeMap = {
            9: "tab",
            27: "esc",
            37: "left",
            39: "right",
            13: "enter",
            38: "up",
            40: "down"
        };
        function Input(o, www) {
            var id;
            o = o || {};
            if (!o.input) {
                $.error("input is missing");
            }
            www.mixin(this);
            this.$hint = $(o.hint);
            this.$input = $(o.input);
            this.$menu = $(o.menu);
            id = this.$input.attr("id") || _.guid();
            this.$menu.attr("id", id + "_listbox");
            this.$hint.attr({
                "aria-hidden": true
            });
            this.$input.attr({
                "aria-owns": id + "_listbox",
                role: "combobox",
                "aria-autocomplete": "list",
                "aria-expanded": false
            });
            this.query = this.$input.val();
            this.queryWhenFocused = this.hasFocus() ? this.query : null;
            this.$overflowHelper = buildOverflowHelper(this.$input);
            this._checkLanguageDirection();
            if (this.$hint.length === 0) {
                this.setHint = this.getHint = this.clearHint = this.clearHintIfInvalid = _.noop;
            }
            this.onSync("cursorchange", this._updateDescendent);
        }
        Input.normalizeQuery = function(str) {
            return _.toStr(str).replace(/^\s*/g, "").replace(/\s{2,}/g, " ");
        };
        _.mixin(Input.prototype, EventEmitter, {
            _onBlur: function onBlur() {
                this.resetInputValue();
                this.trigger("blurred");
            },
            _onFocus: function onFocus() {
                this.queryWhenFocused = this.query;
                this.trigger("focused");
            },
            _onKeydown: function onKeydown($e) {
                var keyName = specialKeyCodeMap[$e.which || $e.keyCode];
                this._managePreventDefault(keyName, $e);
                if (keyName && this._shouldTrigger(keyName, $e)) {
                    this.trigger(keyName + "Keyed", $e);
                }
            },
            _onInput: function onInput() {
                this._setQuery(this.getInputValue());
                this.clearHintIfInvalid();
                this._checkLanguageDirection();
            },
            _managePreventDefault: function managePreventDefault(keyName, $e) {
                var preventDefault;
                switch (keyName) {
                  case "up":
                  case "down":
                    preventDefault = !withModifier($e);
                    break;

                  default:
                    preventDefault = false;
                }
                preventDefault && $e.preventDefault();
            },
            _shouldTrigger: function shouldTrigger(keyName, $e) {
                var trigger;
                switch (keyName) {
                  case "tab":
                    trigger = !withModifier($e);
                    break;

                  default:
                    trigger = true;
                }
                return trigger;
            },
            _checkLanguageDirection: function checkLanguageDirection() {
                var dir = (this.$input.css("direction") || "ltr").toLowerCase();
                if (this.dir !== dir) {
                    this.dir = dir;
                    this.$hint.attr("dir", dir);
                    this.trigger("langDirChanged", dir);
                }
            },
            _setQuery: function setQuery(val, silent) {
                var areEquivalent, hasDifferentWhitespace;
                areEquivalent = areQueriesEquivalent(val, this.query);
                hasDifferentWhitespace = areEquivalent ? this.query.length !== val.length : false;
                this.query = val;
                if (!silent && !areEquivalent) {
                    this.trigger("queryChanged", this.query);
                } else if (!silent && hasDifferentWhitespace) {
                    this.trigger("whitespaceChanged", this.query);
                }
            },
            _updateDescendent: function updateDescendent(event, id) {
                this.$input.attr("aria-activedescendant", id);
            },
            bind: function() {
                var that = this, onBlur, onFocus, onKeydown, onInput;
                onBlur = _.bind(this._onBlur, this);
                onFocus = _.bind(this._onFocus, this);
                onKeydown = _.bind(this._onKeydown, this);
                onInput = _.bind(this._onInput, this);
                this.$input.on("blur.tt", onBlur).on("focus.tt", onFocus).on("keydown.tt", onKeydown);
                if (!_.isMsie() || _.isMsie() > 9) {
                    this.$input.on("input.tt", onInput);
                } else {
                    this.$input.on("keydown.tt keypress.tt cut.tt paste.tt", function($e) {
                        if (specialKeyCodeMap[$e.which || $e.keyCode]) {
                            return;
                        }
                        _.defer(_.bind(that._onInput, that, $e));
                    });
                }
                return this;
            },
            focus: function focus() {
                this.$input.focus();
            },
            blur: function blur() {
                this.$input.blur();
            },
            getLangDir: function getLangDir() {
                return this.dir;
            },
            getQuery: function getQuery() {
                return this.query || "";
            },
            setQuery: function setQuery(val, silent) {
                this.setInputValue(val);
                this._setQuery(val, silent);
            },
            hasQueryChangedSinceLastFocus: function hasQueryChangedSinceLastFocus() {
                return this.query !== this.queryWhenFocused;
            },
            getInputValue: function getInputValue() {
                return this.$input.val();
            },
            setInputValue: function setInputValue(value) {
                this.$input.val(value);
                this.clearHintIfInvalid();
                this._checkLanguageDirection();
            },
            resetInputValue: function resetInputValue() {
                this.setInputValue(this.query);
            },
            getHint: function getHint() {
                return this.$hint.val();
            },
            setHint: function setHint(value) {
                this.$hint.val(value);
            },
            clearHint: function clearHint() {
                this.setHint("");
            },
            clearHintIfInvalid: function clearHintIfInvalid() {
                var val, hint, valIsPrefixOfHint, isValid;
                val = this.getInputValue();
                hint = this.getHint();
                valIsPrefixOfHint = val !== hint && hint.indexOf(val) === 0;
                isValid = val !== "" && valIsPrefixOfHint && !this.hasOverflow();
                !isValid && this.clearHint();
            },
            hasFocus: function hasFocus() {
                return this.$input.is(":focus");
            },
            hasOverflow: function hasOverflow() {
                var constraint = this.$input.width() - 2;
                this.$overflowHelper.text(this.getInputValue());
                return this.$overflowHelper.width() >= constraint;
            },
            isCursorAtEnd: function() {
                var valueLength, selectionStart, range;
                valueLength = this.$input.val().length;
                selectionStart = this.$input[0].selectionStart;
                if (_.isNumber(selectionStart)) {
                    return selectionStart === valueLength;
                } else if (document.selection) {
                    range = document.selection.createRange();
                    range.moveStart("character", -valueLength);
                    return valueLength === range.text.length;
                }
                return true;
            },
            destroy: function destroy() {
                this.$hint.off(".tt");
                this.$input.off(".tt");
                this.$overflowHelper.remove();
                this.$hint = this.$input = this.$overflowHelper = $("<div>");
            },
            setAriaExpanded: function setAriaExpanded(value) {
                this.$input.attr("aria-expanded", value);
            }
        });
        return Input;
        function buildOverflowHelper($input) {
            return $('<pre aria-hidden="true"></pre>').css({
                position: "absolute",
                visibility: "hidden",
                whiteSpace: "pre",
                fontFamily: $input.css("font-family"),
                fontSize: $input.css("font-size"),
                fontStyle: $input.css("font-style"),
                fontVariant: $input.css("font-variant"),
                fontWeight: $input.css("font-weight"),
                wordSpacing: $input.css("word-spacing"),
                letterSpacing: $input.css("letter-spacing"),
                textIndent: $input.css("text-indent"),
                textRendering: $input.css("text-rendering"),
                textTransform: $input.css("text-transform")
            }).insertAfter($input);
        }
        function areQueriesEquivalent(a, b) {
            return Input.normalizeQuery(a) === Input.normalizeQuery(b);
        }
        function withModifier($e) {
            return $e.altKey || $e.ctrlKey || $e.metaKey || $e.shiftKey;
        }
    }();
    var Dataset = function() {
        "use strict";
        var keys, nameGenerator;
        keys = {
            dataset: "tt-selectable-dataset",
            val: "tt-selectable-display",
            obj: "tt-selectable-object"
        };
        nameGenerator = _.getIdGenerator();
        function Dataset(o, www) {
            o = o || {};
            o.templates = o.templates || {};
            o.templates.notFound = o.templates.notFound || o.templates.empty;
            if (!o.source) {
                $.error("missing source");
            }
            if (!o.node) {
                $.error("missing node");
            }
            if (o.name && !isValidName(o.name)) {
                $.error("invalid dataset name: " + o.name);
            }
            www.mixin(this);
            this.highlight = !!o.highlight;
            this.name = _.toStr(o.name || nameGenerator());
            this.limit = o.limit || 5;
            this.displayFn = getDisplayFn(o.display || o.displayKey);
            this.templates = getTemplates(o.templates, this.displayFn);
            this.source = o.source.__ttAdapter ? o.source.__ttAdapter() : o.source;
            this.async = _.isUndefined(o.async) ? this.source.length > 2 : !!o.async;
            this._resetLastSuggestion();
            this.$el = $(o.node).attr("role", "presentation").addClass(this.classes.dataset).addClass(this.classes.dataset + "-" + this.name);
        }
        Dataset.extractData = function extractData(el) {
            var $el = $(el);
            if ($el.data(keys.obj)) {
                return {
                    dataset: $el.data(keys.dataset) || "",
                    val: $el.data(keys.val) || "",
                    obj: $el.data(keys.obj) || null
                };
            }
            return null;
        };
        _.mixin(Dataset.prototype, EventEmitter, {
            _overwrite: function overwrite(query, suggestions) {
                suggestions = suggestions || [];
                if (suggestions.length) {
                    this._renderSuggestions(query, suggestions);
                } else if (this.async && this.templates.pending) {
                    this._renderPending(query);
                } else if (!this.async && this.templates.notFound) {
                    this._renderNotFound(query);
                } else {
                    this._empty();
                }
                this.trigger("rendered", suggestions, false, this.name);
            },
            _append: function append(query, suggestions) {
                suggestions = suggestions || [];
                if (suggestions.length && this.$lastSuggestion.length) {
                    this._appendSuggestions(query, suggestions);
                } else if (suggestions.length) {
                    this._renderSuggestions(query, suggestions);
                } else if (!this.$lastSuggestion.length && this.templates.notFound) {
                    this._renderNotFound(query);
                }
                this.trigger("rendered", suggestions, true, this.name);
            },
            _renderSuggestions: function renderSuggestions(query, suggestions) {
                var $fragment;
                $fragment = this._getSuggestionsFragment(query, suggestions);
                this.$lastSuggestion = $fragment.children().last();
                this.$el.html($fragment).prepend(this._getHeader(query, suggestions)).append(this._getFooter(query, suggestions));
            },
            _appendSuggestions: function appendSuggestions(query, suggestions) {
                var $fragment, $lastSuggestion;
                $fragment = this._getSuggestionsFragment(query, suggestions);
                $lastSuggestion = $fragment.children().last();
                this.$lastSuggestion.after($fragment);
                this.$lastSuggestion = $lastSuggestion;
            },
            _renderPending: function renderPending(query) {
                var template = this.templates.pending;
                this._resetLastSuggestion();
                template && this.$el.html(template({
                    query: query,
                    dataset: this.name
                }));
            },
            _renderNotFound: function renderNotFound(query) {
                var template = this.templates.notFound;
                this._resetLastSuggestion();
                template && this.$el.html(template({
                    query: query,
                    dataset: this.name
                }));
            },
            _empty: function empty() {
                this.$el.empty();
                this._resetLastSuggestion();
            },
            _getSuggestionsFragment: function getSuggestionsFragment(query, suggestions) {
                var that = this, fragment;
                fragment = document.createDocumentFragment();
                _.each(suggestions, function getSuggestionNode(suggestion) {
                    var $el, context;
                    context = that._injectQuery(query, suggestion);
                    $el = $(that.templates.suggestion(context)).data(keys.dataset, that.name).data(keys.obj, suggestion).data(keys.val, that.displayFn(suggestion)).addClass(that.classes.suggestion + " " + that.classes.selectable);
                    fragment.appendChild($el[0]);
                });
                this.highlight && highlight({
                    className: this.classes.highlight,
                    node: fragment,
                    pattern: query
                });
                return $(fragment);
            },
            _getFooter: function getFooter(query, suggestions) {
                return this.templates.footer ? this.templates.footer({
                    query: query,
                    suggestions: suggestions,
                    dataset: this.name
                }) : null;
            },
            _getHeader: function getHeader(query, suggestions) {
                return this.templates.header ? this.templates.header({
                    query: query,
                    suggestions: suggestions,
                    dataset: this.name
                }) : null;
            },
            _resetLastSuggestion: function resetLastSuggestion() {
                this.$lastSuggestion = $();
            },
            _injectQuery: function injectQuery(query, obj) {
                return _.isObject(obj) ? _.mixin({
                    _query: query
                }, obj) : obj;
            },
            update: function update(query) {
                var that = this, canceled = false, syncCalled = false, rendered = 0;
                this.cancel();
                this.cancel = function cancel() {
                    canceled = true;
                    that.cancel = $.noop;
                    that.async && that.trigger("asyncCanceled", query, that.name);
                };
                this.source(query, sync, async);
                !syncCalled && sync([]);
                function sync(suggestions) {
                    if (syncCalled) {
                        return;
                    }
                    syncCalled = true;
                    suggestions = (suggestions || []).slice(0, that.limit);
                    rendered = suggestions.length;
                    that._overwrite(query, suggestions);
                    if (rendered < that.limit && that.async) {
                        that.trigger("asyncRequested", query, that.name);
                    }
                }
                function async(suggestions) {
                    suggestions = suggestions || [];
                    if (!canceled && rendered < that.limit) {
                        that.cancel = $.noop;
                        var idx = Math.abs(rendered - that.limit);
                        rendered += idx;
                        that._append(query, suggestions.slice(0, idx));
                        that.async && that.trigger("asyncReceived", query, that.name);
                    }
                }
            },
            cancel: $.noop,
            clear: function clear() {
                this._empty();
                this.cancel();
                this.trigger("cleared");
            },
            isEmpty: function isEmpty() {
                return this.$el.is(":empty");
            },
            destroy: function destroy() {
                this.$el = $("<div>");
            }
        });
        return Dataset;
        function getDisplayFn(display) {
            display = display || _.stringify;
            return _.isFunction(display) ? display : displayFn;
            function displayFn(obj) {
                return obj[display];
            }
        }
        function getTemplates(templates, displayFn) {
            return {
                notFound: templates.notFound && _.templatify(templates.notFound),
                pending: templates.pending && _.templatify(templates.pending),
                header: templates.header && _.templatify(templates.header),
                footer: templates.footer && _.templatify(templates.footer),
                suggestion: templates.suggestion ? userSuggestionTemplate : suggestionTemplate
            };
            function userSuggestionTemplate(context) {
                var template = templates.suggestion;
                return $(template(context)).attr("id", _.guid());
            }
            function suggestionTemplate(context) {
                return $('<div role="option">').attr("id", _.guid()).text(displayFn(context));
            }
        }
        function isValidName(str) {
            return /^[_a-zA-Z0-9-]+$/.test(str);
        }
    }();
    var Menu = function() {
        "use strict";
        function Menu(o, www) {
            var that = this;
            o = o || {};
            if (!o.node) {
                $.error("node is required");
            }
            www.mixin(this);
            this.$node = $(o.node);
            this.query = null;
            this.datasets = _.map(o.datasets, initializeDataset);
            function initializeDataset(oDataset) {
                var node = that.$node.find(oDataset.node).first();
                oDataset.node = node.length ? node : $("<div>").appendTo(that.$node);
                return new Dataset(oDataset, www);
            }
        }
        _.mixin(Menu.prototype, EventEmitter, {
            _onSelectableClick: function onSelectableClick($e) {
                this.trigger("selectableClicked", $($e.currentTarget));
            },
            _onRendered: function onRendered(type, dataset, suggestions, async) {
                this.$node.toggleClass(this.classes.empty, this._allDatasetsEmpty());
                this.trigger("datasetRendered", dataset, suggestions, async);
            },
            _onCleared: function onCleared() {
                this.$node.toggleClass(this.classes.empty, this._allDatasetsEmpty());
                this.trigger("datasetCleared");
            },
            _propagate: function propagate() {
                this.trigger.apply(this, arguments);
            },
            _allDatasetsEmpty: function allDatasetsEmpty() {
                return _.every(this.datasets, _.bind(function isDatasetEmpty(dataset) {
                    var isEmpty = dataset.isEmpty();
                    this.$node.attr("aria-expanded", !isEmpty);
                    return isEmpty;
                }, this));
            },
            _getSelectables: function getSelectables() {
                return this.$node.find(this.selectors.selectable);
            },
            _removeCursor: function _removeCursor() {
                var $selectable = this.getActiveSelectable();
                $selectable && $selectable.removeClass(this.classes.cursor);
            },
            _ensureVisible: function ensureVisible($el) {
                var elTop, elBottom, nodeScrollTop, nodeHeight;
                elTop = $el.position().top;
                elBottom = elTop + $el.outerHeight(true);
                nodeScrollTop = this.$node.scrollTop();
                nodeHeight = this.$node.height() + parseInt(this.$node.css("paddingTop"), 10) + parseInt(this.$node.css("paddingBottom"), 10);
                if (elTop < 0) {
                    this.$node.scrollTop(nodeScrollTop + elTop);
                } else if (nodeHeight < elBottom) {
                    this.$node.scrollTop(nodeScrollTop + (elBottom - nodeHeight));
                }
            },
            bind: function() {
                var that = this, onSelectableClick;
                onSelectableClick = _.bind(this._onSelectableClick, this);
                this.$node.on("click.tt", this.selectors.selectable, onSelectableClick);
                this.$node.on("mouseover", this.selectors.selectable, function() {
                    that.setCursor($(this));
                });
                this.$node.on("mouseleave", function() {
                    that._removeCursor();
                });
                _.each(this.datasets, function(dataset) {
                    dataset.onSync("asyncRequested", that._propagate, that).onSync("asyncCanceled", that._propagate, that).onSync("asyncReceived", that._propagate, that).onSync("rendered", that._onRendered, that).onSync("cleared", that._onCleared, that);
                });
                return this;
            },
            isOpen: function isOpen() {
                return this.$node.hasClass(this.classes.open);
            },
            open: function open() {
                this.$node.scrollTop(0);
                this.$node.addClass(this.classes.open);
            },
            close: function close() {
                this.$node.attr("aria-expanded", false);
                this.$node.removeClass(this.classes.open);
                this._removeCursor();
            },
            setLanguageDirection: function setLanguageDirection(dir) {
                this.$node.attr("dir", dir);
            },
            selectableRelativeToCursor: function selectableRelativeToCursor(delta) {
                var $selectables, $oldCursor, oldIndex, newIndex;
                $oldCursor = this.getActiveSelectable();
                $selectables = this._getSelectables();
                oldIndex = $oldCursor ? $selectables.index($oldCursor) : -1;
                newIndex = oldIndex + delta;
                newIndex = (newIndex + 1) % ($selectables.length + 1) - 1;
                newIndex = newIndex < -1 ? $selectables.length - 1 : newIndex;
                return newIndex === -1 ? null : $selectables.eq(newIndex);
            },
            setCursor: function setCursor($selectable) {
                this._removeCursor();
                if ($selectable = $selectable && $selectable.first()) {
                    $selectable.addClass(this.classes.cursor);
                    this._ensureVisible($selectable);
                }
            },
            getSelectableData: function getSelectableData($el) {
                return $el && $el.length ? Dataset.extractData($el) : null;
            },
            getActiveSelectable: function getActiveSelectable() {
                var $selectable = this._getSelectables().filter(this.selectors.cursor).first();
                return $selectable.length ? $selectable : null;
            },
            getTopSelectable: function getTopSelectable() {
                var $selectable = this._getSelectables().first();
                return $selectable.length ? $selectable : null;
            },
            update: function update(query) {
                var isValidUpdate = query !== this.query;
                if (isValidUpdate) {
                    this.query = query;
                    _.each(this.datasets, updateDataset);
                }
                return isValidUpdate;
                function updateDataset(dataset) {
                    dataset.update(query);
                }
            },
            empty: function empty() {
                _.each(this.datasets, clearDataset);
                this.query = null;
                this.$node.addClass(this.classes.empty);
                function clearDataset(dataset) {
                    dataset.clear();
                }
            },
            destroy: function destroy() {
                this.$node.off(".tt");
                this.$node = $("<div>");
                _.each(this.datasets, destroyDataset);
                function destroyDataset(dataset) {
                    dataset.destroy();
                }
            }
        });
        return Menu;
    }();
    var Status = function() {
        "use strict";
        function Status(options) {
            this.$el = $("<span></span>", {
                role: "status",
                "aria-live": "polite"
            }).css({
                position: "absolute",
                padding: "0",
                border: "0",
                height: "1px",
                width: "1px",
                "margin-bottom": "-1px",
                "margin-right": "-1px",
                overflow: "hidden",
                clip: "rect(0 0 0 0)",
                "white-space": "nowrap"
            });
            options.$input.after(this.$el);
            _.each(options.menu.datasets, _.bind(function(dataset) {
                if (dataset.onSync) {
                    dataset.onSync("rendered", _.bind(this.update, this));
                    dataset.onSync("cleared", _.bind(this.cleared, this));
                }
            }, this));
        }
        _.mixin(Status.prototype, {
            update: function update(event, suggestions) {
                var length = suggestions.length;
                var words;
                if (length === 1) {
                    words = {
                        result: "result",
                        is: "is"
                    };
                } else {
                    words = {
                        result: "results",
                        is: "are"
                    };
                }
                this.$el.text(length + " " + words.result + " " + words.is + " available, use up and down arrow keys to navigate.");
            },
            cleared: function() {
                this.$el.text("");
            }
        });
        return Status;
    }();
    var DefaultMenu = function() {
        "use strict";
        var s = Menu.prototype;
        function DefaultMenu() {
            Menu.apply(this, [].slice.call(arguments, 0));
        }
        _.mixin(DefaultMenu.prototype, Menu.prototype, {
            open: function open() {
                !this._allDatasetsEmpty() && this._show();
                return s.open.apply(this, [].slice.call(arguments, 0));
            },
            close: function close() {
                this._hide();
                return s.close.apply(this, [].slice.call(arguments, 0));
            },
            _onRendered: function onRendered() {
                if (this._allDatasetsEmpty()) {
                    this._hide();
                } else {
                    this.isOpen() && this._show();
                }
                return s._onRendered.apply(this, [].slice.call(arguments, 0));
            },
            _onCleared: function onCleared() {
                if (this._allDatasetsEmpty()) {
                    this._hide();
                } else {
                    this.isOpen() && this._show();
                }
                return s._onCleared.apply(this, [].slice.call(arguments, 0));
            },
            setLanguageDirection: function setLanguageDirection(dir) {
                this.$node.css(dir === "ltr" ? this.css.ltr : this.css.rtl);
                return s.setLanguageDirection.apply(this, [].slice.call(arguments, 0));
            },
            _hide: function hide() {
                this.$node.hide();
            },
            _show: function show() {
                this.$node.css("display", "block");
            }
        });
        return DefaultMenu;
    }();
    var Typeahead = function() {
        "use strict";
        function Typeahead(o, www) {
            var onFocused, onBlurred, onEnterKeyed, onTabKeyed, onEscKeyed, onUpKeyed, onDownKeyed, onLeftKeyed, onRightKeyed, onQueryChanged, onWhitespaceChanged;
            o = o || {};
            if (!o.input) {
                $.error("missing input");
            }
            if (!o.menu) {
                $.error("missing menu");
            }
            if (!o.eventBus) {
                $.error("missing event bus");
            }
            www.mixin(this);
            this.eventBus = o.eventBus;
            this.minLength = _.isNumber(o.minLength) ? o.minLength : 1;
            this.input = o.input;
            this.menu = o.menu;
            this.enabled = true;
            this.autoselect = !!o.autoselect;
            this.active = false;
            this.input.hasFocus() && this.activate();
            this.dir = this.input.getLangDir();
            this._hacks();
            this.menu.bind().onSync("selectableClicked", this._onSelectableClicked, this).onSync("asyncRequested", this._onAsyncRequested, this).onSync("asyncCanceled", this._onAsyncCanceled, this).onSync("asyncReceived", this._onAsyncReceived, this).onSync("datasetRendered", this._onDatasetRendered, this).onSync("datasetCleared", this._onDatasetCleared, this);
            onFocused = c(this, "activate", "open", "_onFocused");
            onBlurred = c(this, "deactivate", "_onBlurred");
            onEnterKeyed = c(this, "isActive", "isOpen", "_onEnterKeyed");
            onTabKeyed = c(this, "isActive", "isOpen", "_onTabKeyed");
            onEscKeyed = c(this, "isActive", "_onEscKeyed");
            onUpKeyed = c(this, "isActive", "open", "_onUpKeyed");
            onDownKeyed = c(this, "isActive", "open", "_onDownKeyed");
            onLeftKeyed = c(this, "isActive", "isOpen", "_onLeftKeyed");
            onRightKeyed = c(this, "isActive", "isOpen", "_onRightKeyed");
            onQueryChanged = c(this, "_openIfActive", "_onQueryChanged");
            onWhitespaceChanged = c(this, "_openIfActive", "_onWhitespaceChanged");
            this.input.bind().onSync("focused", onFocused, this).onSync("blurred", onBlurred, this).onSync("enterKeyed", onEnterKeyed, this).onSync("tabKeyed", onTabKeyed, this).onSync("escKeyed", onEscKeyed, this).onSync("upKeyed", onUpKeyed, this).onSync("downKeyed", onDownKeyed, this).onSync("leftKeyed", onLeftKeyed, this).onSync("rightKeyed", onRightKeyed, this).onSync("queryChanged", onQueryChanged, this).onSync("whitespaceChanged", onWhitespaceChanged, this).onSync("langDirChanged", this._onLangDirChanged, this);
        }
        _.mixin(Typeahead.prototype, {
            _hacks: function hacks() {
                var $input, $menu;
                $input = this.input.$input || $("<div>");
                $menu = this.menu.$node || $("<div>");
                $input.on("blur.tt", function($e) {
                    var active, isActive, hasActive;
                    active = document.activeElement;
                    isActive = $menu.is(active);
                    hasActive = $menu.has(active).length > 0;
                    if (_.isMsie() && (isActive || hasActive)) {
                        $e.preventDefault();
                        $e.stopImmediatePropagation();
                        _.defer(function() {
                            $input.focus();
                        });
                    }
                });
                $menu.on("mousedown.tt", function($e) {
                    $e.preventDefault();
                });
            },
            _onSelectableClicked: function onSelectableClicked(type, $el) {
                this.select($el);
            },
            _onDatasetCleared: function onDatasetCleared() {
                this._updateHint();
            },
            _onDatasetRendered: function onDatasetRendered(type, suggestions, async, dataset) {
                this._updateHint();
                if (this.autoselect) {
                    var cursorClass = this.selectors.cursor.substr(1);
                    this.menu.$node.find(this.selectors.suggestion).first().addClass(cursorClass);
                }
                this.eventBus.trigger("render", suggestions, async, dataset);
            },
            _onAsyncRequested: function onAsyncRequested(type, dataset, query) {
                this.eventBus.trigger("asyncrequest", query, dataset);
            },
            _onAsyncCanceled: function onAsyncCanceled(type, dataset, query) {
                this.eventBus.trigger("asynccancel", query, dataset);
            },
            _onAsyncReceived: function onAsyncReceived(type, dataset, query) {
                this.eventBus.trigger("asyncreceive", query, dataset);
            },
            _onFocused: function onFocused() {
                this._minLengthMet() && this.menu.update(this.input.getQuery());
            },
            _onBlurred: function onBlurred() {
                if (this.input.hasQueryChangedSinceLastFocus()) {
                    this.eventBus.trigger("change", this.input.getQuery());
                }
            },
            _onEnterKeyed: function onEnterKeyed(type, $e) {
                var $selectable;
                if ($selectable = this.menu.getActiveSelectable()) {
                    if (this.select($selectable)) {
                        $e.preventDefault();
                        $e.stopPropagation();
                    }
                } else if (this.autoselect) {
                    if (this.select(this.menu.getTopSelectable())) {
                        $e.preventDefault();
                        $e.stopPropagation();
                    }
                }
            },
            _onTabKeyed: function onTabKeyed(type, $e) {
                var $selectable;
                if ($selectable = this.menu.getActiveSelectable()) {
                    this.select($selectable) && $e.preventDefault();
                } else if (this.autoselect) {
                    if ($selectable = this.menu.getTopSelectable()) {
                        this.autocomplete($selectable) && $e.preventDefault();
                    }
                }
            },
            _onEscKeyed: function onEscKeyed() {
                this.close();
            },
            _onUpKeyed: function onUpKeyed() {
                this.moveCursor(-1);
            },
            _onDownKeyed: function onDownKeyed() {
                this.moveCursor(+1);
            },
            _onLeftKeyed: function onLeftKeyed() {
                if (this.dir === "rtl" && this.input.isCursorAtEnd()) {
                    this.autocomplete(this.menu.getActiveSelectable() || this.menu.getTopSelectable());
                }
            },
            _onRightKeyed: function onRightKeyed() {
                if (this.dir === "ltr" && this.input.isCursorAtEnd()) {
                    this.autocomplete(this.menu.getActiveSelectable() || this.menu.getTopSelectable());
                }
            },
            _onQueryChanged: function onQueryChanged(e, query) {
                this._minLengthMet(query) ? this.menu.update(query) : this.menu.empty();
            },
            _onWhitespaceChanged: function onWhitespaceChanged() {
                this._updateHint();
            },
            _onLangDirChanged: function onLangDirChanged(e, dir) {
                if (this.dir !== dir) {
                    this.dir = dir;
                    this.menu.setLanguageDirection(dir);
                }
            },
            _openIfActive: function openIfActive() {
                this.isActive() && this.open();
            },
            _minLengthMet: function minLengthMet(query) {
                query = _.isString(query) ? query : this.input.getQuery() || "";
                return query.length >= this.minLength;
            },
            _updateHint: function updateHint() {
                var $selectable, data, val, query, escapedQuery, frontMatchRegEx, match;
                $selectable = this.menu.getTopSelectable();
                data = this.menu.getSelectableData($selectable);
                val = this.input.getInputValue();
                if (data && !_.isBlankString(val) && !this.input.hasOverflow()) {
                    query = Input.normalizeQuery(val);
                    escapedQuery = _.escapeRegExChars(query);
                    frontMatchRegEx = new RegExp("^(?:" + escapedQuery + ")(.+$)", "i");
                    match = frontMatchRegEx.exec(data.val);
                    match && this.input.setHint(val + match[1]);
                } else {
                    this.input.clearHint();
                }
            },
            isEnabled: function isEnabled() {
                return this.enabled;
            },
            enable: function enable() {
                this.enabled = true;
            },
            disable: function disable() {
                this.enabled = false;
            },
            isActive: function isActive() {
                return this.active;
            },
            activate: function activate() {
                if (this.isActive()) {
                    return true;
                } else if (!this.isEnabled() || this.eventBus.before("active")) {
                    return false;
                } else {
                    this.active = true;
                    this.eventBus.trigger("active");
                    return true;
                }
            },
            deactivate: function deactivate() {
                if (!this.isActive()) {
                    return true;
                } else if (this.eventBus.before("idle")) {
                    return false;
                } else {
                    this.active = false;
                    this.close();
                    this.eventBus.trigger("idle");
                    return true;
                }
            },
            isOpen: function isOpen() {
                return this.menu.isOpen();
            },
            open: function open() {
                if (!this.isOpen() && !this.eventBus.before("open")) {
                    this.input.setAriaExpanded(true);
                    this.menu.open();
                    this._updateHint();
                    this.eventBus.trigger("open");
                }
                return this.isOpen();
            },
            close: function close() {
                if (this.isOpen() && !this.eventBus.before("close")) {
                    this.input.setAriaExpanded(false);
                    this.menu.close();
                    this.input.clearHint();
                    this.input.resetInputValue();
                    this.eventBus.trigger("close");
                }
                return !this.isOpen();
            },
            setVal: function setVal(val) {
                this.input.setQuery(_.toStr(val));
            },
            getVal: function getVal() {
                return this.input.getQuery();
            },
            select: function select($selectable) {
                var data = this.menu.getSelectableData($selectable);
                if (data && !this.eventBus.before("select", data.obj, data.dataset)) {
                    this.input.setQuery(data.val, true);
                    this.eventBus.trigger("select", data.obj, data.dataset);
                    this.close();
                    return true;
                }
                return false;
            },
            autocomplete: function autocomplete($selectable) {
                var query, data, isValid;
                query = this.input.getQuery();
                data = this.menu.getSelectableData($selectable);
                isValid = data && query !== data.val;
                if (isValid && !this.eventBus.before("autocomplete", data.obj, data.dataset)) {
                    this.input.setQuery(data.val);
                    this.eventBus.trigger("autocomplete", data.obj, data.dataset);
                    return true;
                }
                return false;
            },
            moveCursor: function moveCursor(delta) {
                var query, $candidate, data, suggestion, datasetName, cancelMove, id;
                query = this.input.getQuery();
                $candidate = this.menu.selectableRelativeToCursor(delta);
                data = this.menu.getSelectableData($candidate);
                suggestion = data ? data.obj : null;
                datasetName = data ? data.dataset : null;
                id = $candidate ? $candidate.attr("id") : null;
                this.input.trigger("cursorchange", id);
                cancelMove = this._minLengthMet() && this.menu.update(query);
                if (!cancelMove && !this.eventBus.before("cursorchange", suggestion, datasetName)) {
                    this.menu.setCursor($candidate);
                    if (data) {
                        if (typeof data.val === "string") {
                            this.input.setInputValue(data.val);
                        }
                    } else {
                        this.input.resetInputValue();
                        this._updateHint();
                    }
                    this.eventBus.trigger("cursorchange", suggestion, datasetName);
                    return true;
                }
                return false;
            },
            destroy: function destroy() {
                this.input.destroy();
                this.menu.destroy();
            }
        });
        return Typeahead;
        function c(ctx) {
            var methods = [].slice.call(arguments, 1);
            return function() {
                var args = [].slice.call(arguments);
                _.each(methods, function(method) {
                    return ctx[method].apply(ctx, args);
                });
            };
        }
    }();
    (function() {
        "use strict";
        var old, keys, methods;
        old = $.fn.typeahead;
        keys = {
            www: "tt-www",
            attrs: "tt-attrs",
            typeahead: "tt-typeahead"
        };
        methods = {
            initialize: function initialize(o, datasets) {
                var www;
                datasets = _.isArray(datasets) ? datasets : [].slice.call(arguments, 1);
                o = o || {};
                www = WWW(o.classNames);
                return this.each(attach);
                function attach() {
                    var $input, $wrapper, $hint, $menu, defaultHint, defaultMenu, eventBus, input, menu, status, typeahead, MenuConstructor;
                    _.each(datasets, function(d) {
                        d.highlight = !!o.highlight;
                    });
                    $input = $(this);
                    $wrapper = $(www.html.wrapper);
                    $hint = $elOrNull(o.hint);
                    $menu = $elOrNull(o.menu);
                    defaultHint = o.hint !== false && !$hint;
                    defaultMenu = o.menu !== false && !$menu;
                    defaultHint && ($hint = buildHintFromInput($input, www));
                    defaultMenu && ($menu = $(www.html.menu).css(www.css.menu));
                    $hint && $hint.val("");
                    $input = prepInput($input, www);
                    if (defaultHint || defaultMenu) {
                        $wrapper.css(www.css.wrapper);
                        $input.css(defaultHint ? www.css.input : www.css.inputWithNoHint);
                        $input.wrap($wrapper).parent().prepend(defaultHint ? $hint : null).append(defaultMenu ? $menu : null);
                    }
                    MenuConstructor = defaultMenu ? DefaultMenu : Menu;
                    eventBus = new EventBus({
                        el: $input
                    });
                    input = new Input({
                        hint: $hint,
                        input: $input,
                        menu: $menu
                    }, www);
                    menu = new MenuConstructor({
                        node: $menu,
                        datasets: datasets
                    }, www);
                    status = new Status({
                        $input: $input,
                        menu: menu
                    });
                    typeahead = new Typeahead({
                        input: input,
                        menu: menu,
                        eventBus: eventBus,
                        minLength: o.minLength,
                        autoselect: o.autoselect
                    }, www);
                    $input.data(keys.www, www);
                    $input.data(keys.typeahead, typeahead);
                }
            },
            isEnabled: function isEnabled() {
                var enabled;
                ttEach(this.first(), function(t) {
                    enabled = t.isEnabled();
                });
                return enabled;
            },
            enable: function enable() {
                ttEach(this, function(t) {
                    t.enable();
                });
                return this;
            },
            disable: function disable() {
                ttEach(this, function(t) {
                    t.disable();
                });
                return this;
            },
            isActive: function isActive() {
                var active;
                ttEach(this.first(), function(t) {
                    active = t.isActive();
                });
                return active;
            },
            activate: function activate() {
                ttEach(this, function(t) {
                    t.activate();
                });
                return this;
            },
            deactivate: function deactivate() {
                ttEach(this, function(t) {
                    t.deactivate();
                });
                return this;
            },
            isOpen: function isOpen() {
                var open;
                ttEach(this.first(), function(t) {
                    open = t.isOpen();
                });
                return open;
            },
            open: function open() {
                ttEach(this, function(t) {
                    t.open();
                });
                return this;
            },
            close: function close() {
                ttEach(this, function(t) {
                    t.close();
                });
                return this;
            },
            select: function select(el) {
                var success = false, $el = $(el);
                ttEach(this.first(), function(t) {
                    success = t.select($el);
                });
                return success;
            },
            autocomplete: function autocomplete(el) {
                var success = false, $el = $(el);
                ttEach(this.first(), function(t) {
                    success = t.autocomplete($el);
                });
                return success;
            },
            moveCursor: function moveCursoe(delta) {
                var success = false;
                ttEach(this.first(), function(t) {
                    success = t.moveCursor(delta);
                });
                return success;
            },
            val: function val(newVal) {
                var query;
                if (!arguments.length) {
                    ttEach(this.first(), function(t) {
                        query = t.getVal();
                    });
                    return query;
                } else {
                    ttEach(this, function(t) {
                        t.setVal(_.toStr(newVal));
                    });
                    return this;
                }
            },
            destroy: function destroy() {
                ttEach(this, function(typeahead, $input) {
                    revert($input);
                    typeahead.destroy();
                });
                return this;
            }
        };
        $.fn.typeahead = function(method) {
            if (methods[method]) {
                return methods[method].apply(this, [].slice.call(arguments, 1));
            } else {
                return methods.initialize.apply(this, arguments);
            }
        };
        $.fn.typeahead.noConflict = function noConflict() {
            $.fn.typeahead = old;
            return this;
        };
        function ttEach($els, fn) {
            $els.each(function() {
                var $input = $(this), typeahead;
                (typeahead = $input.data(keys.typeahead)) && fn(typeahead, $input);
            });
        }
        function buildHintFromInput($input, www) {
            return $input.clone().addClass(www.classes.hint).removeData().css(www.css.hint).css(getBackgroundStyles($input)).prop({
                readonly: true,
                required: false
            }).removeAttr("id name placeholder").removeClass("required").attr({
                spellcheck: "false",
                tabindex: -1
            });
        }
        function prepInput($input, www) {
            $input.data(keys.attrs, {
                dir: $input.attr("dir"),
                autocomplete: $input.attr("autocomplete"),
                spellcheck: $input.attr("spellcheck"),
                style: $input.attr("style")
            });
            $input.addClass(www.classes.input).attr({
                spellcheck: false
            });
            try {
                !$input.attr("dir") && $input.attr("dir", "auto");
            } catch (e) {}
            return $input;
        }
        function getBackgroundStyles($el) {
            return {
                backgroundAttachment: $el.css("background-attachment"),
                backgroundClip: $el.css("background-clip"),
                backgroundColor: $el.css("background-color"),
                backgroundImage: $el.css("background-image"),
                backgroundOrigin: $el.css("background-origin"),
                backgroundPosition: $el.css("background-position"),
                backgroundRepeat: $el.css("background-repeat"),
                backgroundSize: $el.css("background-size")
            };
        }
        function revert($input) {
            var www, $wrapper;
            www = $input.data(keys.www);
            $wrapper = $input.parent().filter(www.selectors.wrapper);
            _.each($input.data(keys.attrs), function(val, key) {
                _.isUndefined(val) ? $input.removeAttr(key) : $input.attr(key, val);
            });
            $input.removeData(keys.typeahead).removeData(keys.www).removeData(keys.attr).removeClass(www.classes.input);
            if ($wrapper.length) {
                $input.detach().insertAfter($wrapper);
                $wrapper.remove();
            }
        }
        function $elOrNull(obj) {
            var isValid, $el;
            isValid = _.isJQuery(obj) || _.isElement(obj);
            $el = isValid ? $(obj).first() : [];
            return $el.length ? $el : null;
        }
    })();
});
/*!
 * Bootstrap-select v1.13.18 (https://developer.snapappointments.com/bootstrap-select)
 *
 * Copyright 2012-2020 SnapAppointments, LLC
 * Licensed under MIT (https://github.com/snapappointments/bootstrap-select/blob/master/LICENSE)
 */

!function(e,t){void 0===e&&void 0!==window&&(e=window),"function"==typeof define&&define.amd?define(["jquery"],function(e){return t(e)}):"object"==typeof module&&module.exports?module.exports=t(require("jquery")):t(e.jQuery)}(this,function(e){!function(P){"use strict";var d=["sanitize","whiteList","sanitizeFn"],r=["background","cite","href","itemtype","longdesc","poster","src","xlink:href"],e={"*":["class","dir","id","lang","role","tabindex","style",/^aria-[\w-]*$/i],a:["target","href","title","rel"],area:[],b:[],br:[],col:[],code:[],div:[],em:[],hr:[],h1:[],h2:[],h3:[],h4:[],h5:[],h6:[],i:[],img:["src","alt","title","width","height"],li:[],ol:[],p:[],pre:[],s:[],small:[],span:[],sub:[],sup:[],strong:[],u:[],ul:[]},l=/^(?:(?:https?|mailto|ftp|tel|file):|[^&:/?#]*(?:[/?#]|$))/gi,a=/^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+/]+=*$/i;function v(e,t){var i=e.nodeName.toLowerCase();if(-1!==P.inArray(i,t))return-1===P.inArray(i,r)||Boolean(e.nodeValue.match(l)||e.nodeValue.match(a));for(var s=P(t).filter(function(e,t){return t instanceof RegExp}),n=0,o=s.length;n<o;n++)if(i.match(s[n]))return!0;return!1}function W(e,t,i){if(i&&"function"==typeof i)return i(e);for(var s=Object.keys(t),n=0,o=e.length;n<o;n++)for(var r=e[n].querySelectorAll("*"),l=0,a=r.length;l<a;l++){var c=r[l],d=c.nodeName.toLowerCase();if(-1!==s.indexOf(d))for(var h=[].slice.call(c.attributes),p=[].concat(t["*"]||[],t[d]||[]),u=0,f=h.length;u<f;u++){var m=h[u];v(m,p)||c.removeAttribute(m.nodeName)}else c.parentNode.removeChild(c)}}"classList"in document.createElement("_")||function(e){if("Element"in e){var t="classList",i="prototype",s=e.Element[i],n=Object,o=function(){var i=P(this);return{add:function(e){return e=Array.prototype.slice.call(arguments).join(" "),i.addClass(e)},remove:function(e){return e=Array.prototype.slice.call(arguments).join(" "),i.removeClass(e)},toggle:function(e,t){return i.toggleClass(e,t)},contains:function(e){return i.hasClass(e)}}};if(n.defineProperty){var r={get:o,enumerable:!0,configurable:!0};try{n.defineProperty(s,t,r)}catch(e){void 0!==e.number&&-2146823252!==e.number||(r.enumerable=!1,n.defineProperty(s,t,r))}}else n[i].__defineGetter__&&s.__defineGetter__(t,o)}}(window);var t,c,i=document.createElement("_");if(i.classList.add("c1","c2"),!i.classList.contains("c2")){var s=DOMTokenList.prototype.add,n=DOMTokenList.prototype.remove;DOMTokenList.prototype.add=function(){Array.prototype.forEach.call(arguments,s.bind(this))},DOMTokenList.prototype.remove=function(){Array.prototype.forEach.call(arguments,n.bind(this))}}if(i.classList.toggle("c3",!1),i.classList.contains("c3")){var o=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(e,t){return 1 in arguments&&!this.contains(e)==!t?t:o.call(this,e)}}function h(e){if(null==this)throw new TypeError;var t=String(this);if(e&&"[object RegExp]"==c.call(e))throw new TypeError;var i=t.length,s=String(e),n=s.length,o=1<arguments.length?arguments[1]:void 0,r=o?Number(o):0;r!=r&&(r=0);var l=Math.min(Math.max(r,0),i);if(i<n+l)return!1;for(var a=-1;++a<n;)if(t.charCodeAt(l+a)!=s.charCodeAt(a))return!1;return!0}function O(e,t){var i,s=e.selectedOptions,n=[];if(t){for(var o=0,r=s.length;o<r;o++)(i=s[o]).disabled||"OPTGROUP"===i.parentNode.tagName&&i.parentNode.disabled||n.push(i);return n}return s}function z(e,t){for(var i,s=[],n=t||e.selectedOptions,o=0,r=n.length;o<r;o++)(i=n[o]).disabled||"OPTGROUP"===i.parentNode.tagName&&i.parentNode.disabled||s.push(i.value);return e.multiple?s:s.length?s[0]:null}i=null,String.prototype.startsWith||(t=function(){try{var e={},t=Object.defineProperty,i=t(e,e,e)&&t}catch(e){}return i}(),c={}.toString,t?t(String.prototype,"startsWith",{value:h,configurable:!0,writable:!0}):String.prototype.startsWith=h),Object.keys||(Object.keys=function(e,t,i){for(t in i=[],e)i.hasOwnProperty.call(e,t)&&i.push(t);return i}),HTMLSelectElement&&!HTMLSelectElement.prototype.hasOwnProperty("selectedOptions")&&Object.defineProperty(HTMLSelectElement.prototype,"selectedOptions",{get:function(){return this.querySelectorAll(":checked")}});var p={useDefault:!1,_set:P.valHooks.select.set};P.valHooks.select.set=function(e,t){return t&&!p.useDefault&&P(e).data("selected",!0),p._set.apply(this,arguments)};var T=null,u=function(){try{return new Event("change"),!0}catch(e){return!1}}();function k(e,t,i,s){for(var n=["display","subtext","tokens"],o=!1,r=0;r<n.length;r++){var l=n[r],a=e[l];if(a&&(a=a.toString(),"display"===l&&(a=a.replace(/<[^>]+>/g,"")),s&&(a=w(a)),a=a.toUpperCase(),o="contains"===i?0<=a.indexOf(t):a.startsWith(t)))break}return o}function N(e){return parseInt(e,10)||0}P.fn.triggerNative=function(e){var t,i=this[0];i.dispatchEvent?(u?t=new Event(e,{bubbles:!0}):(t=document.createEvent("Event")).initEvent(e,!0,!1),i.dispatchEvent(t)):i.fireEvent?((t=document.createEventObject()).eventType=e,i.fireEvent("on"+e,t)):this.trigger(e)};var f={"\xc0":"A","\xc1":"A","\xc2":"A","\xc3":"A","\xc4":"A","\xc5":"A","\xe0":"a","\xe1":"a","\xe2":"a","\xe3":"a","\xe4":"a","\xe5":"a","\xc7":"C","\xe7":"c","\xd0":"D","\xf0":"d","\xc8":"E","\xc9":"E","\xca":"E","\xcb":"E","\xe8":"e","\xe9":"e","\xea":"e","\xeb":"e","\xcc":"I","\xcd":"I","\xce":"I","\xcf":"I","\xec":"i","\xed":"i","\xee":"i","\xef":"i","\xd1":"N","\xf1":"n","\xd2":"O","\xd3":"O","\xd4":"O","\xd5":"O","\xd6":"O","\xd8":"O","\xf2":"o","\xf3":"o","\xf4":"o","\xf5":"o","\xf6":"o","\xf8":"o","\xd9":"U","\xda":"U","\xdb":"U","\xdc":"U","\xf9":"u","\xfa":"u","\xfb":"u","\xfc":"u","\xdd":"Y","\xfd":"y","\xff":"y","\xc6":"Ae","\xe6":"ae","\xde":"Th","\xfe":"th","\xdf":"ss","\u0100":"A","\u0102":"A","\u0104":"A","\u0101":"a","\u0103":"a","\u0105":"a","\u0106":"C","\u0108":"C","\u010a":"C","\u010c":"C","\u0107":"c","\u0109":"c","\u010b":"c","\u010d":"c","\u010e":"D","\u0110":"D","\u010f":"d","\u0111":"d","\u0112":"E","\u0114":"E","\u0116":"E","\u0118":"E","\u011a":"E","\u0113":"e","\u0115":"e","\u0117":"e","\u0119":"e","\u011b":"e","\u011c":"G","\u011e":"G","\u0120":"G","\u0122":"G","\u011d":"g","\u011f":"g","\u0121":"g","\u0123":"g","\u0124":"H","\u0126":"H","\u0125":"h","\u0127":"h","\u0128":"I","\u012a":"I","\u012c":"I","\u012e":"I","\u0130":"I","\u0129":"i","\u012b":"i","\u012d":"i","\u012f":"i","\u0131":"i","\u0134":"J","\u0135":"j","\u0136":"K","\u0137":"k","\u0138":"k","\u0139":"L","\u013b":"L","\u013d":"L","\u013f":"L","\u0141":"L","\u013a":"l","\u013c":"l","\u013e":"l","\u0140":"l","\u0142":"l","\u0143":"N","\u0145":"N","\u0147":"N","\u014a":"N","\u0144":"n","\u0146":"n","\u0148":"n","\u014b":"n","\u014c":"O","\u014e":"O","\u0150":"O","\u014d":"o","\u014f":"o","\u0151":"o","\u0154":"R","\u0156":"R","\u0158":"R","\u0155":"r","\u0157":"r","\u0159":"r","\u015a":"S","\u015c":"S","\u015e":"S","\u0160":"S","\u015b":"s","\u015d":"s","\u015f":"s","\u0161":"s","\u0162":"T","\u0164":"T","\u0166":"T","\u0163":"t","\u0165":"t","\u0167":"t","\u0168":"U","\u016a":"U","\u016c":"U","\u016e":"U","\u0170":"U","\u0172":"U","\u0169":"u","\u016b":"u","\u016d":"u","\u016f":"u","\u0171":"u","\u0173":"u","\u0174":"W","\u0175":"w","\u0176":"Y","\u0177":"y","\u0178":"Y","\u0179":"Z","\u017b":"Z","\u017d":"Z","\u017a":"z","\u017c":"z","\u017e":"z","\u0132":"IJ","\u0133":"ij","\u0152":"Oe","\u0153":"oe","\u0149":"'n","\u017f":"s"},m=/[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g,g=RegExp("[\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff\\u1ab0-\\u1aff\\u1dc0-\\u1dff]","g");function b(e){return f[e]}function w(e){return(e=e.toString())&&e.replace(m,b).replace(g,"")}var I,x,y,$,S=(I={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;","`":"&#x60;"},x="(?:"+Object.keys(I).join("|")+")",y=RegExp(x),$=RegExp(x,"g"),function(e){return e=null==e?"":""+e,y.test(e)?e.replace($,E):e});function E(e){return I[e]}var C={32:" ",48:"0",49:"1",50:"2",51:"3",52:"4",53:"5",54:"6",55:"7",56:"8",57:"9",59:";",65:"A",66:"B",67:"C",68:"D",69:"E",70:"F",71:"G",72:"H",73:"I",74:"J",75:"K",76:"L",77:"M",78:"N",79:"O",80:"P",81:"Q",82:"R",83:"S",84:"T",85:"U",86:"V",87:"W",88:"X",89:"Y",90:"Z",96:"0",97:"1",98:"2",99:"3",100:"4",101:"5",102:"6",103:"7",104:"8",105:"9"},A=27,L=13,D=32,H=9,B=38,R=40,M={success:!1,major:"3"};try{M.full=(P.fn.dropdown.Constructor.VERSION||"").split(" ")[0].split("."),M.major=M.full[0],M.success=!0}catch(e){}var U=0,j=".bs.select",V={DISABLED:"disabled",DIVIDER:"divider",SHOW:"open",DROPUP:"dropup",MENU:"dropdown-menu",MENURIGHT:"dropdown-menu-right",MENULEFT:"dropdown-menu-left",BUTTONCLASS:"btn-default",POPOVERHEADER:"popover-title",ICONBASE:"glyphicon",TICKICON:"glyphicon-ok"},F={MENU:"."+V.MENU},_={div:document.createElement("div"),span:document.createElement("span"),i:document.createElement("i"),subtext:document.createElement("small"),a:document.createElement("a"),li:document.createElement("li"),whitespace:document.createTextNode("\xa0"),fragment:document.createDocumentFragment()};_.noResults=_.li.cloneNode(!1),_.noResults.className="no-results",_.a.setAttribute("role","option"),_.a.className="dropdown-item",_.subtext.className="text-muted",_.text=_.span.cloneNode(!1),_.text.className="text",_.checkMark=_.span.cloneNode(!1);var G=new RegExp(B+"|"+R),q=new RegExp("^"+H+"$|"+A),K={li:function(e,t,i){var s=_.li.cloneNode(!1);return e&&(1===e.nodeType||11===e.nodeType?s.appendChild(e):s.innerHTML=e),void 0!==t&&""!==t&&(s.className=t),null!=i&&s.classList.add("optgroup-"+i),s},a:function(e,t,i){var s=_.a.cloneNode(!0);return e&&(11===e.nodeType?s.appendChild(e):s.insertAdjacentHTML("beforeend",e)),void 0!==t&&""!==t&&s.classList.add.apply(s.classList,t.split(/\s+/)),i&&s.setAttribute("style",i),s},text:function(e,t){var i,s,n=_.text.cloneNode(!1);if(e.content)n.innerHTML=e.content;else{if(n.textContent=e.text,e.icon){var o=_.whitespace.cloneNode(!1);(s=(!0===t?_.i:_.span).cloneNode(!1)).className=this.options.iconBase+" "+e.icon,_.fragment.appendChild(s),_.fragment.appendChild(o)}e.subtext&&((i=_.subtext.cloneNode(!1)).textContent=e.subtext,n.appendChild(i))}if(!0===t)for(;0<n.childNodes.length;)_.fragment.appendChild(n.childNodes[0]);else _.fragment.appendChild(n);return _.fragment},label:function(e){var t,i,s=_.text.cloneNode(!1);if(s.innerHTML=e.display,e.icon){var n=_.whitespace.cloneNode(!1);(i=_.span.cloneNode(!1)).className=this.options.iconBase+" "+e.icon,_.fragment.appendChild(i),_.fragment.appendChild(n)}return e.subtext&&((t=_.subtext.cloneNode(!1)).textContent=e.subtext,s.appendChild(t)),_.fragment.appendChild(s),_.fragment}};var Y=function(e,t){var i=this;p.useDefault||(P.valHooks.select.set=p._set,p.useDefault=!0),this.$element=P(e),this.$newElement=null,this.$button=null,this.$menu=null,this.options=t,this.selectpicker={main:{},search:{},current:{},view:{},isSearching:!1,keydown:{keyHistory:"",resetKeyHistory:{start:function(){return setTimeout(function(){i.selectpicker.keydown.keyHistory=""},800)}}}},this.sizeInfo={},null===this.options.title&&(this.options.title=this.$element.attr("title"));var s=this.options.windowPadding;"number"==typeof s&&(this.options.windowPadding=[s,s,s,s]),this.val=Y.prototype.val,this.render=Y.prototype.render,this.refresh=Y.prototype.refresh,this.setStyle=Y.prototype.setStyle,this.selectAll=Y.prototype.selectAll,this.deselectAll=Y.prototype.deselectAll,this.destroy=Y.prototype.destroy,this.remove=Y.prototype.remove,this.show=Y.prototype.show,this.hide=Y.prototype.hide,this.init()};function Z(e){var l,a=arguments,c=e;if([].shift.apply(a),!M.success){try{M.full=(P.fn.dropdown.Constructor.VERSION||"").split(" ")[0].split(".")}catch(e){Y.BootstrapVersion?M.full=Y.BootstrapVersion.split(" ")[0].split("."):(M.full=[M.major,"0","0"],console.warn("There was an issue retrieving Bootstrap's version. Ensure Bootstrap is being loaded before bootstrap-select and there is no namespace collision. If loading Bootstrap asynchronously, the version may need to be manually specified via $.fn.selectpicker.Constructor.BootstrapVersion.",e))}M.major=M.full[0],M.success=!0}if("4"===M.major){var t=[];Y.DEFAULTS.style===V.BUTTONCLASS&&t.push({name:"style",className:"BUTTONCLASS"}),Y.DEFAULTS.iconBase===V.ICONBASE&&t.push({name:"iconBase",className:"ICONBASE"}),Y.DEFAULTS.tickIcon===V.TICKICON&&t.push({name:"tickIcon",className:"TICKICON"}),V.DIVIDER="dropdown-divider",V.SHOW="show",V.BUTTONCLASS="btn-light",V.POPOVERHEADER="popover-header",V.ICONBASE="",V.TICKICON="bs-ok-default";for(var i=0;i<t.length;i++){e=t[i];Y.DEFAULTS[e.name]=V[e.className]}}var s=this.each(function(){var e=P(this);if(e.is("select")){var t=e.data("selectpicker"),i="object"==typeof c&&c;if(t){if(i)for(var s in i)Object.prototype.hasOwnProperty.call(i,s)&&(t.options[s]=i[s])}else{var n=e.data();for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&-1!==P.inArray(o,d)&&delete n[o];var r=P.extend({},Y.DEFAULTS,P.fn.selectpicker.defaults||{},n,i);r.template=P.extend({},Y.DEFAULTS.template,P.fn.selectpicker.defaults?P.fn.selectpicker.defaults.template:{},n.template,i.template),e.data("selectpicker",t=new Y(this,r))}"string"==typeof c&&(l=t[c]instanceof Function?t[c].apply(t,a):t.options[c])}});return void 0!==l?l:s}Y.VERSION="1.13.18",Y.DEFAULTS={noneSelectedText:"Nothing selected",noneResultsText:"No results matched {0}",countSelectedText:function(e,t){return 1==e?"{0} item selected":"{0} items selected"},maxOptionsText:function(e,t){return[1==e?"Limit reached ({n} item max)":"Limit reached ({n} items max)",1==t?"Group limit reached ({n} item max)":"Group limit reached ({n} items max)"]},selectAllText:"Select All",deselectAllText:"Deselect All",doneButton:!1,doneButtonText:"Close",multipleSeparator:", ",styleBase:"btn",style:V.BUTTONCLASS,size:"auto",title:null,selectedTextFormat:"values",width:!1,container:!1,hideDisabled:!1,showSubtext:!1,showIcon:!0,showContent:!0,dropupAuto:!0,header:!1,liveSearch:!1,liveSearchPlaceholder:null,liveSearchNormalize:!1,liveSearchStyle:"contains",actionsBox:!1,iconBase:V.ICONBASE,tickIcon:V.TICKICON,showTick:!1,template:{caret:'<span class="caret"></span>'},maxOptions:!1,mobile:!1,selectOnTab:!1,dropdownAlignRight:!1,windowPadding:0,virtualScroll:600,display:!1,sanitize:!0,sanitizeFn:null,whiteList:e},Y.prototype={constructor:Y,init:function(){var i=this,e=this.$element.attr("id"),t=this.$element[0],s=t.form;U++,this.selectId="bs-select-"+U,t.classList.add("bs-select-hidden"),this.multiple=this.$element.prop("multiple"),this.autofocus=this.$element.prop("autofocus"),t.classList.contains("show-tick")&&(this.options.showTick=!0),this.$newElement=this.createDropdown(),this.buildData(),this.$element.after(this.$newElement).prependTo(this.$newElement),s&&null===t.form&&(s.id||(s.id="form-"+this.selectId),t.setAttribute("form",s.id)),this.$button=this.$newElement.children("button"),this.$menu=this.$newElement.children(F.MENU),this.$menuInner=this.$menu.children(".inner"),this.$searchbox=this.$menu.find("input"),t.classList.remove("bs-select-hidden"),!0===this.options.dropdownAlignRight&&this.$menu[0].classList.add(V.MENURIGHT),void 0!==e&&this.$button.attr("data-id",e),this.checkDisabled(),this.clickListener(),this.options.liveSearch?(this.liveSearchListener(),this.focusedParent=this.$searchbox[0]):this.focusedParent=this.$menuInner[0],this.setStyle(),this.render(),this.setWidth(),this.options.container?this.selectPosition():this.$element.on("hide"+j,function(){if(i.isVirtual()){var e=i.$menuInner[0],t=e.firstChild.cloneNode(!1);e.replaceChild(t,e.firstChild),e.scrollTop=0}}),this.$menu.data("this",this),this.$newElement.data("this",this),this.options.mobile&&this.mobile(),this.$newElement.on({"hide.bs.dropdown":function(e){i.$element.trigger("hide"+j,e)},"hidden.bs.dropdown":function(e){i.$element.trigger("hidden"+j,e)},"show.bs.dropdown":function(e){i.$element.trigger("show"+j,e)},"shown.bs.dropdown":function(e){i.$element.trigger("shown"+j,e)}}),t.hasAttribute("required")&&this.$element.on("invalid"+j,function(){i.$button[0].classList.add("bs-invalid"),i.$element.on("shown"+j+".invalid",function(){i.$element.val(i.$element.val()).off("shown"+j+".invalid")}).on("rendered"+j,function(){this.validity.valid&&i.$button[0].classList.remove("bs-invalid"),i.$element.off("rendered"+j)}),i.$button.on("blur"+j,function(){i.$element.trigger("focus").trigger("blur"),i.$button.off("blur"+j)})}),setTimeout(function(){i.buildList(),i.$element.trigger("loaded"+j)})},createDropdown:function(){var e=this.multiple||this.options.showTick?" show-tick":"",t=this.multiple?' aria-multiselectable="true"':"",i="",s=this.autofocus?" autofocus":"";M.major<4&&this.$element.parent().hasClass("input-group")&&(i=" input-group-btn");var n,o="",r="",l="",a="";return this.options.header&&(o='<div class="'+V.POPOVERHEADER+'"><button type="button" class="close" aria-hidden="true">&times;</button>'+this.options.header+"</div>"),this.options.liveSearch&&(r='<div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off"'+(null===this.options.liveSearchPlaceholder?"":' placeholder="'+S(this.options.liveSearchPlaceholder)+'"')+' role="combobox" aria-label="Search" aria-controls="'+this.selectId+'" aria-autocomplete="list"></div>'),this.multiple&&this.options.actionsBox&&(l='<div class="bs-actionsbox"><div class="btn-group btn-group-sm btn-block"><button type="button" class="actions-btn bs-select-all btn '+V.BUTTONCLASS+'">'+this.options.selectAllText+'</button><button type="button" class="actions-btn bs-deselect-all btn '+V.BUTTONCLASS+'">'+this.options.deselectAllText+"</button></div></div>"),this.multiple&&this.options.doneButton&&(a='<div class="bs-donebutton"><div class="btn-group btn-block"><button type="button" class="btn btn-sm '+V.BUTTONCLASS+'">'+this.options.doneButtonText+"</button></div></div>"),n='<div class="dropdown bootstrap-select'+e+i+'"><button type="button" tabindex="-1" class="'+this.options.styleBase+' dropdown-toggle" '+("static"===this.options.display?'data-display="static"':"")+'data-toggle="dropdown"'+s+' role="combobox" aria-owns="'+this.selectId+'" aria-haspopup="listbox" aria-expanded="false"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner"></div></div> </div>'+("4"===M.major?"":'<span class="bs-caret">'+this.options.template.caret+"</span>")+'</button><div class="'+V.MENU+" "+("4"===M.major?"":V.SHOW)+'">'+o+r+l+'<div class="inner '+V.SHOW+'" role="listbox" id="'+this.selectId+'" tabindex="-1" '+t+'><ul class="'+V.MENU+" inner "+("4"===M.major?V.SHOW:"")+'" role="presentation"></ul></div>'+a+"</div></div>",P(n)},setPositionData:function(){this.selectpicker.view.canHighlight=[],this.selectpicker.view.size=0,this.selectpicker.view.firstHighlightIndex=!1;for(var e=0;e<this.selectpicker.current.data.length;e++){var t=this.selectpicker.current.data[e],i=!0;"divider"===t.type?(i=!1,t.height=this.sizeInfo.dividerHeight):"optgroup-label"===t.type?(i=!1,t.height=this.sizeInfo.dropdownHeaderHeight):t.height=this.sizeInfo.liHeight,t.disabled&&(i=!1),this.selectpicker.view.canHighlight.push(i),i&&(this.selectpicker.view.size++,t.posinset=this.selectpicker.view.size,!1===this.selectpicker.view.firstHighlightIndex&&(this.selectpicker.view.firstHighlightIndex=e)),t.position=(0===e?0:this.selectpicker.current.data[e-1].position)+t.height}},isVirtual:function(){return!1!==this.options.virtualScroll&&this.selectpicker.main.elements.length>=this.options.virtualScroll||!0===this.options.virtualScroll},createView:function(N,e,t){var A,L,D=this,i=0,H=[];if(this.selectpicker.isSearching=N,this.selectpicker.current=N?this.selectpicker.search:this.selectpicker.main,this.setPositionData(),e)if(t)i=this.$menuInner[0].scrollTop;else if(!D.multiple){var s=D.$element[0],n=(s.options[s.selectedIndex]||{}).liIndex;if("number"==typeof n&&!1!==D.options.size){var o=D.selectpicker.main.data[n],r=o&&o.position;r&&(i=r-(D.sizeInfo.menuInnerHeight+D.sizeInfo.liHeight)/2)}}function l(e,t){var i,s,n,o,r,l,a,c,d=D.selectpicker.current.elements.length,h=[],p=!0,u=D.isVirtual();D.selectpicker.view.scrollTop=e,i=Math.ceil(D.sizeInfo.menuInnerHeight/D.sizeInfo.liHeight*1.5),s=Math.round(d/i)||1;for(var f=0;f<s;f++){var m=(f+1)*i;if(f===s-1&&(m=d),h[f]=[f*i+(f?1:0),m],!d)break;void 0===r&&e-1<=D.selectpicker.current.data[m-1].position-D.sizeInfo.menuInnerHeight&&(r=f)}if(void 0===r&&(r=0),l=[D.selectpicker.view.position0,D.selectpicker.view.position1],n=Math.max(0,r-1),o=Math.min(s-1,r+1),D.selectpicker.view.position0=!1===u?0:Math.max(0,h[n][0])||0,D.selectpicker.view.position1=!1===u?d:Math.min(d,h[o][1])||0,a=l[0]!==D.selectpicker.view.position0||l[1]!==D.selectpicker.view.position1,void 0!==D.activeIndex&&(L=D.selectpicker.main.elements[D.prevActiveIndex],H=D.selectpicker.main.elements[D.activeIndex],A=D.selectpicker.main.elements[D.selectedIndex],t&&(D.activeIndex!==D.selectedIndex&&D.defocusItem(H),D.activeIndex=void 0),D.activeIndex&&D.activeIndex!==D.selectedIndex&&D.defocusItem(A)),void 0!==D.prevActiveIndex&&D.prevActiveIndex!==D.activeIndex&&D.prevActiveIndex!==D.selectedIndex&&D.defocusItem(L),(t||a)&&(c=D.selectpicker.view.visibleElements?D.selectpicker.view.visibleElements.slice():[],D.selectpicker.view.visibleElements=!1===u?D.selectpicker.current.elements:D.selectpicker.current.elements.slice(D.selectpicker.view.position0,D.selectpicker.view.position1),D.setOptionStatus(),(N||!1===u&&t)&&(p=!function(e,i){return e.length===i.length&&e.every(function(e,t){return e===i[t]})}(c,D.selectpicker.view.visibleElements)),(t||!0===u)&&p)){var v,g,b=D.$menuInner[0],w=document.createDocumentFragment(),I=b.firstChild.cloneNode(!1),x=D.selectpicker.view.visibleElements,k=[];b.replaceChild(I,b.firstChild);f=0;for(var y=x.length;f<y;f++){var $,S,E=x[f];D.options.sanitize&&($=E.lastChild)&&(S=D.selectpicker.current.data[f+D.selectpicker.view.position0])&&S.content&&!S.sanitized&&(k.push($),S.sanitized=!0),w.appendChild(E)}if(D.options.sanitize&&k.length&&W(k,D.options.whiteList,D.options.sanitizeFn),!0===u?(v=0===D.selectpicker.view.position0?0:D.selectpicker.current.data[D.selectpicker.view.position0-1].position,g=D.selectpicker.view.position1>d-1?0:D.selectpicker.current.data[d-1].position-D.selectpicker.current.data[D.selectpicker.view.position1-1].position,b.firstChild.style.marginTop=v+"px",b.firstChild.style.marginBottom=g+"px"):(b.firstChild.style.marginTop=0,b.firstChild.style.marginBottom=0),b.firstChild.appendChild(w),!0===u&&D.sizeInfo.hasScrollBar){var C=b.firstChild.offsetWidth;if(t&&C<D.sizeInfo.menuInnerInnerWidth&&D.sizeInfo.totalMenuWidth>D.sizeInfo.selectWidth)b.firstChild.style.minWidth=D.sizeInfo.menuInnerInnerWidth+"px";else if(C>D.sizeInfo.menuInnerInnerWidth){D.$menu[0].style.minWidth=0;var O=b.firstChild.offsetWidth;O>D.sizeInfo.menuInnerInnerWidth&&(D.sizeInfo.menuInnerInnerWidth=O,b.firstChild.style.minWidth=D.sizeInfo.menuInnerInnerWidth+"px"),D.$menu[0].style.minWidth=""}}}if(D.prevActiveIndex=D.activeIndex,D.options.liveSearch){if(N&&t){var z,T=0;D.selectpicker.view.canHighlight[T]||(T=1+D.selectpicker.view.canHighlight.slice(1).indexOf(!0)),z=D.selectpicker.view.visibleElements[T],D.defocusItem(D.selectpicker.view.currentActive),D.activeIndex=(D.selectpicker.current.data[T]||{}).index,D.focusItem(z)}}else D.$menuInner.trigger("focus")}l(i,!0),this.$menuInner.off("scroll.createView").on("scroll.createView",function(e,t){D.noScroll||l(this.scrollTop,t),D.noScroll=!1}),P(window).off("resize"+j+"."+this.selectId+".createView").on("resize"+j+"."+this.selectId+".createView",function(){D.$newElement.hasClass(V.SHOW)&&l(D.$menuInner[0].scrollTop)})},focusItem:function(e,t,i){if(e){t=t||this.selectpicker.main.data[this.activeIndex];var s=e.firstChild;s&&(s.setAttribute("aria-setsize",this.selectpicker.view.size),s.setAttribute("aria-posinset",t.posinset),!0!==i&&(this.focusedParent.setAttribute("aria-activedescendant",s.id),e.classList.add("active"),s.classList.add("active")))}},defocusItem:function(e){e&&(e.classList.remove("active"),e.firstChild&&e.firstChild.classList.remove("active"))},setPlaceholder:function(){var e=this,t=!1;if(this.options.title&&!this.multiple){this.selectpicker.view.titleOption||(this.selectpicker.view.titleOption=document.createElement("option")),t=!0;var i=this.$element[0],s=!1,n=!this.selectpicker.view.titleOption.parentNode,o=i.selectedIndex,r=i.options[o],l=window.performance&&window.performance.getEntriesByType("navigation"),a=l&&l.length?"back_forward"!==l[0].type:2!==window.performance.navigation.type;n&&(this.selectpicker.view.titleOption.className="bs-title-option",this.selectpicker.view.titleOption.value="",s=!r||0===o&&!1===r.defaultSelected&&void 0===this.$element.data("selected")),!n&&0===this.selectpicker.view.titleOption.index||i.insertBefore(this.selectpicker.view.titleOption,i.firstChild),s&&a?i.selectedIndex=0:"complete"!==document.readyState&&window.addEventListener("pageshow",function(){e.selectpicker.view.displayedValue!==i.value&&e.render()})}return t},buildData:function(){var p=':not([hidden]):not([data-hidden="true"])',u=[],f=0,m=this.setPlaceholder()?1:0;this.options.hideDisabled&&(p+=":not(:disabled)");var e=this.$element[0].querySelectorAll("select > *"+p);function v(e){var t=u[u.length-1];t&&"divider"===t.type&&(t.optID||e.optID)||((e=e||{}).type="divider",u.push(e))}function g(e,t){if((t=t||{}).divider="true"===e.getAttribute("data-divider"),t.divider)v({optID:t.optID});else{var i=u.length,s=e.style.cssText,n=s?S(s):"",o=(e.className||"")+(t.optgroupClass||"");t.optID&&(o="opt "+o),t.optionClass=o.trim(),t.inlineStyle=n,t.text=e.textContent,t.content=e.getAttribute("data-content"),t.tokens=e.getAttribute("data-tokens"),t.subtext=e.getAttribute("data-subtext"),t.icon=e.getAttribute("data-icon"),e.liIndex=i,t.display=t.content||t.text,t.type="option",t.index=i,t.option=e,t.selected=!!e.selected,t.disabled=t.disabled||!!e.disabled,u.push(t)}}function t(e,t){var i=t[e],s=!(e-1<m)&&t[e-1],n=t[e+1],o=i.querySelectorAll("option"+p);if(o.length){var r,l,a={display:S(i.label),subtext:i.getAttribute("data-subtext"),icon:i.getAttribute("data-icon"),type:"optgroup-label",optgroupClass:" "+(i.className||"")};f++,s&&v({optID:f}),a.optID=f,u.push(a);for(var c=0,d=o.length;c<d;c++){var h=o[c];0===c&&(l=(r=u.length-1)+d),g(h,{headerIndex:r,lastIndex:l,optID:a.optID,optgroupClass:a.optgroupClass,disabled:i.disabled})}n&&v({optID:f})}}for(var i=e.length,s=m;s<i;s++){var n=e[s];"OPTGROUP"!==n.tagName?g(n,{}):t(s,e)}this.selectpicker.main.data=this.selectpicker.current.data=u},buildList:function(){var s=this,e=this.selectpicker.main.data,n=[],o=0;function t(e){var t,i=0;switch(e.type){case"divider":t=K.li(!1,V.DIVIDER,e.optID?e.optID+"div":void 0);break;case"option":(t=K.li(K.a(K.text.call(s,e),e.optionClass,e.inlineStyle),"",e.optID)).firstChild&&(t.firstChild.id=s.selectId+"-"+e.index);break;case"optgroup-label":t=K.li(K.label.call(s,e),"dropdown-header"+e.optgroupClass,e.optID)}e.element=t,n.push(t),e.display&&(i+=e.display.length),e.subtext&&(i+=e.subtext.length),e.icon&&(i+=1),o<i&&(o=i,s.selectpicker.view.widestOption=n[n.length-1])}!s.options.showTick&&!s.multiple||_.checkMark.parentNode||(_.checkMark.className=this.options.iconBase+" "+s.options.tickIcon+" check-mark",_.a.appendChild(_.checkMark));for(var i=e.length,r=0;r<i;r++){t(e[r])}this.selectpicker.main.elements=this.selectpicker.current.elements=n},findLis:function(){return this.$menuInner.find(".inner > li")},render:function(){var e,t=this,i=this.$element[0],s=this.setPlaceholder()&&0===i.selectedIndex,n=O(i,this.options.hideDisabled),o=n.length,r=this.$button[0],l=r.querySelector(".filter-option-inner-inner"),a=document.createTextNode(this.options.multipleSeparator),c=_.fragment.cloneNode(!1),d=!1;if(r.classList.toggle("bs-placeholder",t.multiple?!o:!z(i,n)),t.multiple||1!==n.length||(t.selectpicker.view.displayedValue=z(i,n)),"static"===this.options.selectedTextFormat)c=K.text.call(this,{text:this.options.title},!0);else if(!1===(this.multiple&&-1!==this.options.selectedTextFormat.indexOf("count")&&1<o&&(1<(e=this.options.selectedTextFormat.split(">")).length&&o>e[1]||1===e.length&&2<=o))){if(!s){for(var h=0;h<o&&h<50;h++){var p=n[h],u=this.selectpicker.main.data[p.liIndex],f={};this.multiple&&0<h&&c.appendChild(a.cloneNode(!1)),p.title?f.text=p.title:u&&(u.content&&t.options.showContent?(f.content=u.content.toString(),d=!0):(t.options.showIcon&&(f.icon=u.icon),t.options.showSubtext&&!t.multiple&&u.subtext&&(f.subtext=" "+u.subtext),f.text=p.textContent.trim())),c.appendChild(K.text.call(this,f,!0))}49<o&&c.appendChild(document.createTextNode("..."))}}else{var m=':not([hidden]):not([data-hidden="true"]):not([data-divider="true"])';this.options.hideDisabled&&(m+=":not(:disabled)");var v=this.$element[0].querySelectorAll("select > option"+m+", optgroup"+m+" option"+m).length,g="function"==typeof this.options.countSelectedText?this.options.countSelectedText(o,v):this.options.countSelectedText;c=K.text.call(this,{text:g.replace("{0}",o.toString()).replace("{1}",v.toString())},!0)}if(null==this.options.title&&(this.options.title=this.$element.attr("title")),c.childNodes.length||(c=K.text.call(this,{text:void 0!==this.options.title?this.options.title:this.options.noneSelectedText},!0)),r.title=c.textContent.replace(/<[^>]*>?/g,"").trim(),this.options.sanitize&&d&&W([c],t.options.whiteList,t.options.sanitizeFn),l.innerHTML="",l.appendChild(c),M.major<4&&this.$newElement[0].classList.contains("bs3-has-addon")){var b=r.querySelector(".filter-expand"),w=l.cloneNode(!0);w.className="filter-expand",b?r.replaceChild(w,b):r.appendChild(w)}this.$element.trigger("rendered"+j)},setStyle:function(e,t){var i,s=this.$button[0],n=this.$newElement[0],o=this.options.style.trim();this.$element.attr("class")&&this.$newElement.addClass(this.$element.attr("class").replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi,"")),M.major<4&&(n.classList.add("bs3"),n.parentNode.classList&&n.parentNode.classList.contains("input-group")&&(n.previousElementSibling||n.nextElementSibling)&&(n.previousElementSibling||n.nextElementSibling).classList.contains("input-group-addon")&&n.classList.add("bs3-has-addon")),i=e?e.trim():o,"add"==t?i&&s.classList.add.apply(s.classList,i.split(" ")):"remove"==t?i&&s.classList.remove.apply(s.classList,i.split(" ")):(o&&s.classList.remove.apply(s.classList,o.split(" ")),i&&s.classList.add.apply(s.classList,i.split(" ")))},liHeight:function(e){if(e||!1!==this.options.size&&!Object.keys(this.sizeInfo).length){var t,i=_.div.cloneNode(!1),s=_.div.cloneNode(!1),n=_.div.cloneNode(!1),o=document.createElement("ul"),r=_.li.cloneNode(!1),l=_.li.cloneNode(!1),a=_.a.cloneNode(!1),c=_.span.cloneNode(!1),d=this.options.header&&0<this.$menu.find("."+V.POPOVERHEADER).length?this.$menu.find("."+V.POPOVERHEADER)[0].cloneNode(!0):null,h=this.options.liveSearch?_.div.cloneNode(!1):null,p=this.options.actionsBox&&this.multiple&&0<this.$menu.find(".bs-actionsbox").length?this.$menu.find(".bs-actionsbox")[0].cloneNode(!0):null,u=this.options.doneButton&&this.multiple&&0<this.$menu.find(".bs-donebutton").length?this.$menu.find(".bs-donebutton")[0].cloneNode(!0):null,f=this.$element.find("option")[0];if(this.sizeInfo.selectWidth=this.$newElement[0].offsetWidth,c.className="text",a.className="dropdown-item "+(f?f.className:""),i.className=this.$menu[0].parentNode.className+" "+V.SHOW,i.style.width=0,"auto"===this.options.width&&(s.style.minWidth=0),s.className=V.MENU+" "+V.SHOW,n.className="inner "+V.SHOW,o.className=V.MENU+" inner "+("4"===M.major?V.SHOW:""),r.className=V.DIVIDER,l.className="dropdown-header",c.appendChild(document.createTextNode("\u200b")),this.selectpicker.current.data.length)for(var m=0;m<this.selectpicker.current.data.length;m++){var v=this.selectpicker.current.data[m];if("option"===v.type){t=v.element;break}}else t=_.li.cloneNode(!1),a.appendChild(c),t.appendChild(a);if(l.appendChild(c.cloneNode(!0)),this.selectpicker.view.widestOption&&o.appendChild(this.selectpicker.view.widestOption.cloneNode(!0)),o.appendChild(t),o.appendChild(r),o.appendChild(l),d&&s.appendChild(d),h){var g=document.createElement("input");h.className="bs-searchbox",g.className="form-control",h.appendChild(g),s.appendChild(h)}p&&s.appendChild(p),n.appendChild(o),s.appendChild(n),u&&s.appendChild(u),i.appendChild(s),document.body.appendChild(i);var b,w=t.offsetHeight,I=l?l.offsetHeight:0,x=d?d.offsetHeight:0,k=h?h.offsetHeight:0,y=p?p.offsetHeight:0,$=u?u.offsetHeight:0,S=P(r).outerHeight(!0),E=!!window.getComputedStyle&&window.getComputedStyle(s),C=s.offsetWidth,O=E?null:P(s),z={vert:N(E?E.paddingTop:O.css("paddingTop"))+N(E?E.paddingBottom:O.css("paddingBottom"))+N(E?E.borderTopWidth:O.css("borderTopWidth"))+N(E?E.borderBottomWidth:O.css("borderBottomWidth")),horiz:N(E?E.paddingLeft:O.css("paddingLeft"))+N(E?E.paddingRight:O.css("paddingRight"))+N(E?E.borderLeftWidth:O.css("borderLeftWidth"))+N(E?E.borderRightWidth:O.css("borderRightWidth"))},T={vert:z.vert+N(E?E.marginTop:O.css("marginTop"))+N(E?E.marginBottom:O.css("marginBottom"))+2,horiz:z.horiz+N(E?E.marginLeft:O.css("marginLeft"))+N(E?E.marginRight:O.css("marginRight"))+2};n.style.overflowY="scroll",b=s.offsetWidth-C,document.body.removeChild(i),this.sizeInfo.liHeight=w,this.sizeInfo.dropdownHeaderHeight=I,this.sizeInfo.headerHeight=x,this.sizeInfo.searchHeight=k,this.sizeInfo.actionsHeight=y,this.sizeInfo.doneButtonHeight=$,this.sizeInfo.dividerHeight=S,this.sizeInfo.menuPadding=z,this.sizeInfo.menuExtras=T,this.sizeInfo.menuWidth=C,this.sizeInfo.menuInnerInnerWidth=C-z.horiz,this.sizeInfo.totalMenuWidth=this.sizeInfo.menuWidth,this.sizeInfo.scrollBarWidth=b,this.sizeInfo.selectHeight=this.$newElement[0].offsetHeight,this.setPositionData()}},getSelectPosition:function(){var e,t=P(window),i=this.$newElement.offset(),s=P(this.options.container);this.options.container&&s.length&&!s.is("body")?((e=s.offset()).top+=parseInt(s.css("borderTopWidth")),e.left+=parseInt(s.css("borderLeftWidth"))):e={top:0,left:0};var n=this.options.windowPadding;this.sizeInfo.selectOffsetTop=i.top-e.top-t.scrollTop(),this.sizeInfo.selectOffsetBot=t.height()-this.sizeInfo.selectOffsetTop-this.sizeInfo.selectHeight-e.top-n[2],this.sizeInfo.selectOffsetLeft=i.left-e.left-t.scrollLeft(),this.sizeInfo.selectOffsetRight=t.width()-this.sizeInfo.selectOffsetLeft-this.sizeInfo.selectWidth-e.left-n[1],this.sizeInfo.selectOffsetTop-=n[0],this.sizeInfo.selectOffsetLeft-=n[3]},setMenuSize:function(e){this.getSelectPosition();var t,i,s,n,o,r,l,a,c=this.sizeInfo.selectWidth,d=this.sizeInfo.liHeight,h=this.sizeInfo.headerHeight,p=this.sizeInfo.searchHeight,u=this.sizeInfo.actionsHeight,f=this.sizeInfo.doneButtonHeight,m=this.sizeInfo.dividerHeight,v=this.sizeInfo.menuPadding,g=0;if(this.options.dropupAuto&&(l=d*this.selectpicker.current.elements.length+v.vert,a=this.sizeInfo.selectOffsetTop-this.sizeInfo.selectOffsetBot>this.sizeInfo.menuExtras.vert&&l+this.sizeInfo.menuExtras.vert+50>this.sizeInfo.selectOffsetBot,!0===this.selectpicker.isSearching&&(a=this.selectpicker.dropup),this.$newElement.toggleClass(V.DROPUP,a),this.selectpicker.dropup=a),"auto"===this.options.size)n=3<this.selectpicker.current.elements.length?3*this.sizeInfo.liHeight+this.sizeInfo.menuExtras.vert-2:0,i=this.sizeInfo.selectOffsetBot-this.sizeInfo.menuExtras.vert,s=n+h+p+u+f,r=Math.max(n-v.vert,0),this.$newElement.hasClass(V.DROPUP)&&(i=this.sizeInfo.selectOffsetTop-this.sizeInfo.menuExtras.vert),t=(o=i)-h-p-u-f-v.vert;else if(this.options.size&&"auto"!=this.options.size&&this.selectpicker.current.elements.length>this.options.size){for(var b=0;b<this.options.size;b++)"divider"===this.selectpicker.current.data[b].type&&g++;t=(i=d*this.options.size+g*m+v.vert)-v.vert,o=i+h+p+u+f,s=r=""}this.$menu.css({"max-height":o+"px",overflow:"hidden","min-height":s+"px"}),this.$menuInner.css({"max-height":t+"px","overflow-y":"auto","min-height":r+"px"}),this.sizeInfo.menuInnerHeight=Math.max(t,1),this.selectpicker.current.data.length&&this.selectpicker.current.data[this.selectpicker.current.data.length-1].position>this.sizeInfo.menuInnerHeight&&(this.sizeInfo.hasScrollBar=!0,this.sizeInfo.totalMenuWidth=this.sizeInfo.menuWidth+this.sizeInfo.scrollBarWidth),"auto"===this.options.dropdownAlignRight&&this.$menu.toggleClass(V.MENURIGHT,this.sizeInfo.selectOffsetLeft>this.sizeInfo.selectOffsetRight&&this.sizeInfo.selectOffsetRight<this.sizeInfo.totalMenuWidth-c),this.dropdown&&this.dropdown._popper&&this.dropdown._popper.update()},setSize:function(e){if(this.liHeight(e),this.options.header&&this.$menu.css("padding-top",0),!1!==this.options.size){var t=this,i=P(window);this.setMenuSize(),this.options.liveSearch&&this.$searchbox.off("input.setMenuSize propertychange.setMenuSize").on("input.setMenuSize propertychange.setMenuSize",function(){return t.setMenuSize()}),"auto"===this.options.size?i.off("resize"+j+"."+this.selectId+".setMenuSize scroll"+j+"."+this.selectId+".setMenuSize").on("resize"+j+"."+this.selectId+".setMenuSize scroll"+j+"."+this.selectId+".setMenuSize",function(){return t.setMenuSize()}):this.options.size&&"auto"!=this.options.size&&this.selectpicker.current.elements.length>this.options.size&&i.off("resize"+j+"."+this.selectId+".setMenuSize scroll"+j+"."+this.selectId+".setMenuSize")}this.createView(!1,!0,e)},setWidth:function(){var i=this;"auto"===this.options.width?requestAnimationFrame(function(){i.$menu.css("min-width","0"),i.$element.on("loaded"+j,function(){i.liHeight(),i.setMenuSize();var e=i.$newElement.clone().appendTo("body"),t=e.css("width","auto").children("button").outerWidth();e.remove(),i.sizeInfo.selectWidth=Math.max(i.sizeInfo.totalMenuWidth,t),i.$newElement.css("width",i.sizeInfo.selectWidth+"px")})}):"fit"===this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width","").addClass("fit-width")):this.options.width?(this.$menu.css("min-width",""),this.$newElement.css("width",this.options.width)):(this.$menu.css("min-width",""),this.$newElement.css("width","")),this.$newElement.hasClass("fit-width")&&"fit"!==this.options.width&&this.$newElement[0].classList.remove("fit-width")},selectPosition:function(){this.$bsContainer=P('<div class="bs-container" />');function e(e){var t={},i=r.options.display||!!P.fn.dropdown.Constructor.Default&&P.fn.dropdown.Constructor.Default.display;r.$bsContainer.addClass(e.attr("class").replace(/form-control|fit-width/gi,"")).toggleClass(V.DROPUP,e.hasClass(V.DROPUP)),s=e.offset(),l.is("body")?n={top:0,left:0}:((n=l.offset()).top+=parseInt(l.css("borderTopWidth"))-l.scrollTop(),n.left+=parseInt(l.css("borderLeftWidth"))-l.scrollLeft()),o=e.hasClass(V.DROPUP)?0:e[0].offsetHeight,(M.major<4||"static"===i)&&(t.top=s.top-n.top+o,t.left=s.left-n.left),t.width=e[0].offsetWidth,r.$bsContainer.css(t)}var s,n,o,r=this,l=P(this.options.container);this.$button.on("click.bs.dropdown.data-api",function(){r.isDisabled()||(e(r.$newElement),r.$bsContainer.appendTo(r.options.container).toggleClass(V.SHOW,!r.$button.hasClass(V.SHOW)).append(r.$menu))}),P(window).off("resize"+j+"."+this.selectId+" scroll"+j+"."+this.selectId).on("resize"+j+"."+this.selectId+" scroll"+j+"."+this.selectId,function(){r.$newElement.hasClass(V.SHOW)&&e(r.$newElement)}),this.$element.on("hide"+j,function(){r.$menu.data("height",r.$menu.height()),r.$bsContainer.detach()})},setOptionStatus:function(e){var t=this;if(t.noScroll=!1,t.selectpicker.view.visibleElements&&t.selectpicker.view.visibleElements.length)for(var i=0;i<t.selectpicker.view.visibleElements.length;i++){var s=t.selectpicker.current.data[i+t.selectpicker.view.position0],n=s.option;n&&(!0!==e&&t.setDisabled(s.index,s.disabled),t.setSelected(s.index,n.selected))}},setSelected:function(e,t){var i,s,n=this.selectpicker.main.elements[e],o=this.selectpicker.main.data[e],r=void 0!==this.activeIndex,l=this.activeIndex===e||t&&!this.multiple&&!r;o.selected=t,s=n.firstChild,t&&(this.selectedIndex=e),n.classList.toggle("selected",t),l?(this.focusItem(n,o),this.selectpicker.view.currentActive=n,this.activeIndex=e):this.defocusItem(n),s&&(s.classList.toggle("selected",t),t?s.setAttribute("aria-selected",!0):this.multiple?s.setAttribute("aria-selected",!1):s.removeAttribute("aria-selected")),l||r||!t||void 0===this.prevActiveIndex||(i=this.selectpicker.main.elements[this.prevActiveIndex],this.defocusItem(i))},setDisabled:function(e,t){var i,s=this.selectpicker.main.elements[e];this.selectpicker.main.data[e].disabled=t,i=s.firstChild,s.classList.toggle(V.DISABLED,t),i&&("4"===M.major&&i.classList.toggle(V.DISABLED,t),t?(i.setAttribute("aria-disabled",t),i.setAttribute("tabindex",-1)):(i.removeAttribute("aria-disabled"),i.setAttribute("tabindex",0)))},isDisabled:function(){return this.$element[0].disabled},checkDisabled:function(){this.isDisabled()?(this.$newElement[0].classList.add(V.DISABLED),this.$button.addClass(V.DISABLED).attr("aria-disabled",!0)):this.$button[0].classList.contains(V.DISABLED)&&(this.$newElement[0].classList.remove(V.DISABLED),this.$button.removeClass(V.DISABLED).attr("aria-disabled",!1))},clickListener:function(){var C=this,t=P(document);function e(){C.options.liveSearch?C.$searchbox.trigger("focus"):C.$menuInner.trigger("focus")}function i(){C.dropdown&&C.dropdown._popper&&C.dropdown._popper.state.isCreated?e():requestAnimationFrame(i)}t.data("spaceSelect",!1),this.$button.on("keyup",function(e){/(32)/.test(e.keyCode.toString(10))&&t.data("spaceSelect")&&(e.preventDefault(),t.data("spaceSelect",!1))}),this.$newElement.on("show.bs.dropdown",function(){3<M.major&&!C.dropdown&&(C.dropdown=C.$button.data("bs.dropdown"),C.dropdown._menu=C.$menu[0])}),this.$button.on("click.bs.dropdown.data-api",function(){C.$newElement.hasClass(V.SHOW)||C.setSize()}),this.$element.on("shown"+j,function(){C.$menuInner[0].scrollTop!==C.selectpicker.view.scrollTop&&(C.$menuInner[0].scrollTop=C.selectpicker.view.scrollTop),3<M.major?requestAnimationFrame(i):e()}),this.$menuInner.on("mouseenter","li a",function(e){var t=this.parentElement,i=C.isVirtual()?C.selectpicker.view.position0:0,s=Array.prototype.indexOf.call(t.parentElement.children,t),n=C.selectpicker.current.data[s+i];C.focusItem(t,n,!0)}),this.$menuInner.on("click","li a",function(e,t){var i=P(this),s=C.$element[0],n=C.isVirtual()?C.selectpicker.view.position0:0,o=C.selectpicker.current.data[i.parent().index()+n],r=o.index,l=z(s),a=s.selectedIndex,c=s.options[a],d=!0;if(C.multiple&&1!==C.options.maxOptions&&e.stopPropagation(),e.preventDefault(),!C.isDisabled()&&!i.parent().hasClass(V.DISABLED)){var h=o.option,p=P(h),u=h.selected,f=p.parent("optgroup"),m=f.find("option"),v=C.options.maxOptions,g=f.data("maxOptions")||!1;if(r===C.activeIndex&&(t=!0),t||(C.prevActiveIndex=C.activeIndex,C.activeIndex=void 0),C.multiple){if(h.selected=!u,C.setSelected(r,!u),C.focusedParent.focus(),!1!==v||!1!==g){var b=v<O(s).length,w=g<f.find("option:selected").length;if(v&&b||g&&w)if(v&&1==v)s.selectedIndex=-1,h.selected=!0,C.setOptionStatus(!0);else if(g&&1==g){for(var I=0;I<m.length;I++){var x=m[I];x.selected=!1,C.setSelected(x.liIndex,!1)}h.selected=!0,C.setSelected(r,!0)}else{var k="string"==typeof C.options.maxOptionsText?[C.options.maxOptionsText,C.options.maxOptionsText]:C.options.maxOptionsText,y="function"==typeof k?k(v,g):k,$=y[0].replace("{n}",v),S=y[1].replace("{n}",g),E=P('<div class="notify"></div>');y[2]&&($=$.replace("{var}",y[2][1<v?0:1]),S=S.replace("{var}",y[2][1<g?0:1])),h.selected=!1,C.$menu.append(E),v&&b&&(E.append(P("<div>"+$+"</div>")),d=!1,C.$element.trigger("maxReached"+j)),g&&w&&(E.append(P("<div>"+S+"</div>")),d=!1,C.$element.trigger("maxReachedGrp"+j)),setTimeout(function(){C.setSelected(r,!1)},10),E[0].classList.add("fadeOut"),setTimeout(function(){E.remove()},1050)}}}else c&&(c.selected=!1),h.selected=!0,C.setSelected(r,!0);!C.multiple||C.multiple&&1===C.options.maxOptions?C.$button.trigger("focus"):C.options.liveSearch&&C.$searchbox.trigger("focus"),d&&(!C.multiple&&a===s.selectedIndex||(T=[h.index,p.prop("selected"),l],C.$element.triggerNative("change")))}}),this.$menu.on("click","li."+V.DISABLED+" a, ."+V.POPOVERHEADER+", ."+V.POPOVERHEADER+" :not(.close)",function(e){e.currentTarget==this&&(e.preventDefault(),e.stopPropagation(),C.options.liveSearch&&!P(e.target).hasClass("close")?C.$searchbox.trigger("focus"):C.$button.trigger("focus"))}),this.$menuInner.on("click",".divider, .dropdown-header",function(e){e.preventDefault(),e.stopPropagation(),C.options.liveSearch?C.$searchbox.trigger("focus"):C.$button.trigger("focus")}),this.$menu.on("click","."+V.POPOVERHEADER+" .close",function(){C.$button.trigger("click")}),this.$searchbox.on("click",function(e){e.stopPropagation()}),this.$menu.on("click",".actions-btn",function(e){C.options.liveSearch?C.$searchbox.trigger("focus"):C.$button.trigger("focus"),e.preventDefault(),e.stopPropagation(),P(this).hasClass("bs-select-all")?C.selectAll():C.deselectAll()}),this.$button.on("focus"+j,function(e){var t=C.$element[0].getAttribute("tabindex");void 0!==t&&e.originalEvent&&e.originalEvent.isTrusted&&(this.setAttribute("tabindex",t),C.$element[0].setAttribute("tabindex",-1),C.selectpicker.view.tabindex=t)}).on("blur"+j,function(e){void 0!==C.selectpicker.view.tabindex&&e.originalEvent&&e.originalEvent.isTrusted&&(C.$element[0].setAttribute("tabindex",C.selectpicker.view.tabindex),this.setAttribute("tabindex",-1),C.selectpicker.view.tabindex=void 0)}),this.$element.on("change"+j,function(){C.render(),C.$element.trigger("changed"+j,T),T=null}).on("focus"+j,function(){C.options.mobile||C.$button[0].focus()})},liveSearchListener:function(){var u=this;this.$button.on("click.bs.dropdown.data-api",function(){u.$searchbox.val()&&(u.$searchbox.val(""),u.selectpicker.search.previousValue=void 0)}),this.$searchbox.on("click.bs.dropdown.data-api focus.bs.dropdown.data-api touchend.bs.dropdown.data-api",function(e){e.stopPropagation()}),this.$searchbox.on("input propertychange",function(){var e=u.$searchbox[0].value;if(u.selectpicker.search.elements=[],u.selectpicker.search.data=[],e){var t=[],i=e.toUpperCase(),s={},n=[],o=u._searchStyle(),r=u.options.liveSearchNormalize;r&&(i=w(i));for(var l=0;l<u.selectpicker.main.data.length;l++){var a=u.selectpicker.main.data[l];s[l]||(s[l]=k(a,i,o,r)),s[l]&&void 0!==a.headerIndex&&-1===n.indexOf(a.headerIndex)&&(0<a.headerIndex&&(s[a.headerIndex-1]=!0,n.push(a.headerIndex-1)),s[a.headerIndex]=!0,n.push(a.headerIndex),s[a.lastIndex+1]=!0),s[l]&&"optgroup-label"!==a.type&&n.push(l)}l=0;for(var c=n.length;l<c;l++){var d=n[l],h=n[l-1],p=(a=u.selectpicker.main.data[d],u.selectpicker.main.data[h]);("divider"!==a.type||"divider"===a.type&&p&&"divider"!==p.type&&c-1!==l)&&(u.selectpicker.search.data.push(a),t.push(u.selectpicker.main.elements[d]))}u.activeIndex=void 0,u.noScroll=!0,u.$menuInner.scrollTop(0),u.selectpicker.search.elements=t,u.createView(!0),function(e,t){e.length||(_.noResults.innerHTML=this.options.noneResultsText.replace("{0}",'"'+S(t)+'"'),this.$menuInner[0].firstChild.appendChild(_.noResults))}.call(u,t,e)}else u.selectpicker.search.previousValue&&(u.$menuInner.scrollTop(0),u.createView(!1));u.selectpicker.search.previousValue=e})},_searchStyle:function(){return this.options.liveSearchStyle||"contains"},val:function(e){var t=this.$element[0];if(void 0===e)return this.$element.val();var i=z(t);if(T=[null,null,i],this.$element.val(e).trigger("changed"+j,T),this.$newElement.hasClass(V.SHOW))if(this.multiple)this.setOptionStatus(!0);else{var s=(t.options[t.selectedIndex]||{}).liIndex;"number"==typeof s&&(this.setSelected(this.selectedIndex,!1),this.setSelected(s,!0))}return this.render(),T=null,this.$element},changeAll:function(e){if(this.multiple){void 0===e&&(e=!0);var t=this.$element[0],i=0,s=0,n=z(t);t.classList.add("bs-select-hidden");for(var o=0,r=this.selectpicker.current.data,l=r.length;o<l;o++){var a=r[o],c=a.option;c&&!a.disabled&&"divider"!==a.type&&(a.selected&&i++,!0===(c.selected=e)&&s++)}t.classList.remove("bs-select-hidden"),i!==s&&(this.setOptionStatus(),T=[null,null,n],this.$element.triggerNative("change"))}},selectAll:function(){return this.changeAll(!0)},deselectAll:function(){return this.changeAll(!1)},toggle:function(e){(e=e||window.event)&&e.stopPropagation(),this.$button.trigger("click.bs.dropdown.data-api")},keydown:function(e){var t,i,s,n,o,r=P(this),l=r.hasClass("dropdown-toggle"),a=(l?r.closest(".dropdown"):r.closest(F.MENU)).data("this"),c=a.findLis(),d=!1,h=e.which===H&&!l&&!a.options.selectOnTab,p=G.test(e.which)||h,u=a.$menuInner[0].scrollTop,f=!0===a.isVirtual()?a.selectpicker.view.position0:0;if(!(112<=e.which&&e.which<=123))if(!(i=a.$newElement.hasClass(V.SHOW))&&(p||48<=e.which&&e.which<=57||96<=e.which&&e.which<=105||65<=e.which&&e.which<=90)&&(a.$button.trigger("click.bs.dropdown.data-api"),a.options.liveSearch))a.$searchbox.trigger("focus");else{if(e.which===A&&i&&(e.preventDefault(),a.$button.trigger("click.bs.dropdown.data-api").trigger("focus")),p){if(!c.length)return;-1!==(t=(s=a.selectpicker.main.elements[a.activeIndex])?Array.prototype.indexOf.call(s.parentElement.children,s):-1)&&a.defocusItem(s),e.which===B?(-1!==t&&t--,t+f<0&&(t+=c.length),a.selectpicker.view.canHighlight[t+f]||-1===(t=a.selectpicker.view.canHighlight.slice(0,t+f).lastIndexOf(!0)-f)&&(t=c.length-1)):e.which!==R&&!h||(++t+f>=a.selectpicker.view.canHighlight.length&&(t=a.selectpicker.view.firstHighlightIndex),a.selectpicker.view.canHighlight[t+f]||(t=t+1+a.selectpicker.view.canHighlight.slice(t+f+1).indexOf(!0))),e.preventDefault();var m=f+t;e.which===B?0===f&&t===c.length-1?(a.$menuInner[0].scrollTop=a.$menuInner[0].scrollHeight,m=a.selectpicker.current.elements.length-1):d=(o=(n=a.selectpicker.current.data[m]).position-n.height)<u:e.which!==R&&!h||(t===a.selectpicker.view.firstHighlightIndex?(a.$menuInner[0].scrollTop=0,m=a.selectpicker.view.firstHighlightIndex):d=u<(o=(n=a.selectpicker.current.data[m]).position-a.sizeInfo.menuInnerHeight)),s=a.selectpicker.current.elements[m],a.activeIndex=a.selectpicker.current.data[m].index,a.focusItem(s),a.selectpicker.view.currentActive=s,d&&(a.$menuInner[0].scrollTop=o),a.options.liveSearch?a.$searchbox.trigger("focus"):r.trigger("focus")}else if(!r.is("input")&&!q.test(e.which)||e.which===D&&a.selectpicker.keydown.keyHistory){var v,g,b=[];e.preventDefault(),a.selectpicker.keydown.keyHistory+=C[e.which],a.selectpicker.keydown.resetKeyHistory.cancel&&clearTimeout(a.selectpicker.keydown.resetKeyHistory.cancel),a.selectpicker.keydown.resetKeyHistory.cancel=a.selectpicker.keydown.resetKeyHistory.start(),g=a.selectpicker.keydown.keyHistory,/^(.)\1+$/.test(g)&&(g=g.charAt(0));for(var w=0;w<a.selectpicker.current.data.length;w++){var I=a.selectpicker.current.data[w];k(I,g,"startsWith",!0)&&a.selectpicker.view.canHighlight[w]&&b.push(I.index)}if(b.length){var x=0;c.removeClass("active").find("a").removeClass("active"),1===g.length&&(-1===(x=b.indexOf(a.activeIndex))||x===b.length-1?x=0:x++),v=b[x],d=0<u-(n=a.selectpicker.main.data[v]).position?(o=n.position-n.height,!0):(o=n.position-a.sizeInfo.menuInnerHeight,n.position>u+a.sizeInfo.menuInnerHeight),s=a.selectpicker.main.elements[v],a.activeIndex=b[x],a.focusItem(s),s&&s.firstChild.focus(),d&&(a.$menuInner[0].scrollTop=o),r.trigger("focus")}}i&&(e.which===D&&!a.selectpicker.keydown.keyHistory||e.which===L||e.which===H&&a.options.selectOnTab)&&(e.which!==D&&e.preventDefault(),a.options.liveSearch&&e.which===D||(a.$menuInner.find(".active a").trigger("click",!0),r.trigger("focus"),a.options.liveSearch||(e.preventDefault(),P(document).data("spaceSelect",!0))))}},mobile:function(){this.options.mobile=!0,this.$element[0].classList.add("mobile-device")},refresh:function(){var e=P.extend({},this.options,this.$element.data());this.options=e,this.checkDisabled(),this.buildData(),this.setStyle(),this.render(),this.buildList(),this.setWidth(),this.setSize(!0),this.$element.trigger("refreshed"+j)},hide:function(){this.$newElement.hide()},show:function(){this.$newElement.show()},remove:function(){this.$newElement.remove(),this.$element.remove()},destroy:function(){this.$newElement.before(this.$element).remove(),this.$bsContainer?this.$bsContainer.remove():this.$menu.remove(),this.selectpicker.view.titleOption&&this.selectpicker.view.titleOption.parentNode&&this.selectpicker.view.titleOption.parentNode.removeChild(this.selectpicker.view.titleOption),this.$element.off(j).removeData("selectpicker").removeClass("bs-select-hidden selectpicker"),P(window).off(j+"."+this.selectId)}};var J=P.fn.selectpicker;function Q(){if(P.fn.dropdown)return(P.fn.dropdown.Constructor._dataApiKeydownHandler||P.fn.dropdown.Constructor.prototype.keydown).apply(this,arguments)}P.fn.selectpicker=Z,P.fn.selectpicker.Constructor=Y,P.fn.selectpicker.noConflict=function(){return P.fn.selectpicker=J,this},P(document).off("keydown.bs.dropdown.data-api").on("keydown.bs.dropdown.data-api",':not(.bootstrap-select) > [data-toggle="dropdown"]',Q).on("keydown.bs.dropdown.data-api",":not(.bootstrap-select) > .dropdown-menu",Q).on("keydown"+j,'.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input',Y.prototype.keydown).on("focusin.modal",'.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bootstrap-select .bs-searchbox input',function(e){e.stopPropagation()}),P(window).on("load"+j+".data-api",function(){P(".selectpicker").each(function(){var e=P(this);Z.call(e,e.data())})})}(e)});
//# sourceMappingURL=bootstrap-select.min.js.map
/*!
 * Datepicker for Bootstrap v1.9.0 (https://github.com/uxsolutions/bootstrap-datepicker)
 *
 * Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
 */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a,b){function c(){return new Date(Date.UTC.apply(Date,arguments))}function d(){var a=new Date;return c(a.getFullYear(),a.getMonth(),a.getDate())}function e(a,b){return a.getUTCFullYear()===b.getUTCFullYear()&&a.getUTCMonth()===b.getUTCMonth()&&a.getUTCDate()===b.getUTCDate()}function f(c,d){return function(){return d!==b&&a.fn.datepicker.deprecated(d),this[c].apply(this,arguments)}}function g(a){return a&&!isNaN(a.getTime())}function h(b,c){function d(a,b){return b.toLowerCase()}var e,f=a(b).data(),g={},h=new RegExp("^"+c.toLowerCase()+"([A-Z])");c=new RegExp("^"+c.toLowerCase());for(var i in f)c.test(i)&&(e=i.replace(h,d),g[e]=f[i]);return g}function i(b){var c={};if(q[b]||(b=b.split("-")[0],q[b])){var d=q[b];return a.each(p,function(a,b){b in d&&(c[b]=d[b])}),c}}var j=function(){var b={get:function(a){return this.slice(a)[0]},contains:function(a){for(var b=a&&a.valueOf(),c=0,d=this.length;c<d;c++)if(0<=this[c].valueOf()-b&&this[c].valueOf()-b<864e5)return c;return-1},remove:function(a){this.splice(a,1)},replace:function(b){b&&(a.isArray(b)||(b=[b]),this.clear(),this.push.apply(this,b))},clear:function(){this.length=0},copy:function(){var a=new j;return a.replace(this),a}};return function(){var c=[];return c.push.apply(c,arguments),a.extend(c,b),c}}(),k=function(b,c){a.data(b,"datepicker",this),this._events=[],this._secondaryEvents=[],this._process_options(c),this.dates=new j,this.viewDate=this.o.defaultViewDate,this.focusDate=null,this.element=a(b),this.isInput=this.element.is("input"),this.inputField=this.isInput?this.element:this.element.find("input"),this.component=!!this.element.hasClass("date")&&this.element.find(".add-on, .input-group-addon, .input-group-append, .input-group-prepend, .btn"),this.component&&0===this.component.length&&(this.component=!1),this.isInline=!this.component&&this.element.is("div"),this.picker=a(r.template),this._check_template(this.o.templates.leftArrow)&&this.picker.find(".prev").html(this.o.templates.leftArrow),this._check_template(this.o.templates.rightArrow)&&this.picker.find(".next").html(this.o.templates.rightArrow),this._buildEvents(),this._attachEvents(),this.isInline?this.picker.addClass("datepicker-inline").appendTo(this.element):this.picker.addClass("datepicker-dropdown dropdown-menu"),this.o.rtl&&this.picker.addClass("datepicker-rtl"),this.o.calendarWeeks&&this.picker.find(".datepicker-days .datepicker-switch, thead .datepicker-title, tfoot .today, tfoot .clear").attr("colspan",function(a,b){return Number(b)+1}),this._process_options({startDate:this._o.startDate,endDate:this._o.endDate,daysOfWeekDisabled:this.o.daysOfWeekDisabled,daysOfWeekHighlighted:this.o.daysOfWeekHighlighted,datesDisabled:this.o.datesDisabled}),this._allow_update=!1,this.setViewMode(this.o.startView),this._allow_update=!0,this.fillDow(),this.fillMonths(),this.update(),this.isInline&&this.show()};k.prototype={constructor:k,_resolveViewName:function(b){return a.each(r.viewModes,function(c,d){if(b===c||-1!==a.inArray(b,d.names))return b=c,!1}),b},_resolveDaysOfWeek:function(b){return a.isArray(b)||(b=b.split(/[,\s]*/)),a.map(b,Number)},_check_template:function(c){try{if(c===b||""===c)return!1;if((c.match(/[<>]/g)||[]).length<=0)return!0;return a(c).length>0}catch(a){return!1}},_process_options:function(b){this._o=a.extend({},this._o,b);var e=this.o=a.extend({},this._o),f=e.language;q[f]||(f=f.split("-")[0],q[f]||(f=o.language)),e.language=f,e.startView=this._resolveViewName(e.startView),e.minViewMode=this._resolveViewName(e.minViewMode),e.maxViewMode=this._resolveViewName(e.maxViewMode),e.startView=Math.max(this.o.minViewMode,Math.min(this.o.maxViewMode,e.startView)),!0!==e.multidate&&(e.multidate=Number(e.multidate)||!1,!1!==e.multidate&&(e.multidate=Math.max(0,e.multidate))),e.multidateSeparator=String(e.multidateSeparator),e.weekStart%=7,e.weekEnd=(e.weekStart+6)%7;var g=r.parseFormat(e.format);e.startDate!==-1/0&&(e.startDate?e.startDate instanceof Date?e.startDate=this._local_to_utc(this._zero_time(e.startDate)):e.startDate=r.parseDate(e.startDate,g,e.language,e.assumeNearbyYear):e.startDate=-1/0),e.endDate!==1/0&&(e.endDate?e.endDate instanceof Date?e.endDate=this._local_to_utc(this._zero_time(e.endDate)):e.endDate=r.parseDate(e.endDate,g,e.language,e.assumeNearbyYear):e.endDate=1/0),e.daysOfWeekDisabled=this._resolveDaysOfWeek(e.daysOfWeekDisabled||[]),e.daysOfWeekHighlighted=this._resolveDaysOfWeek(e.daysOfWeekHighlighted||[]),e.datesDisabled=e.datesDisabled||[],a.isArray(e.datesDisabled)||(e.datesDisabled=e.datesDisabled.split(",")),e.datesDisabled=a.map(e.datesDisabled,function(a){return r.parseDate(a,g,e.language,e.assumeNearbyYear)});var h=String(e.orientation).toLowerCase().split(/\s+/g),i=e.orientation.toLowerCase();if(h=a.grep(h,function(a){return/^auto|left|right|top|bottom$/.test(a)}),e.orientation={x:"auto",y:"auto"},i&&"auto"!==i)if(1===h.length)switch(h[0]){case"top":case"bottom":e.orientation.y=h[0];break;case"left":case"right":e.orientation.x=h[0]}else i=a.grep(h,function(a){return/^left|right$/.test(a)}),e.orientation.x=i[0]||"auto",i=a.grep(h,function(a){return/^top|bottom$/.test(a)}),e.orientation.y=i[0]||"auto";else;if(e.defaultViewDate instanceof Date||"string"==typeof e.defaultViewDate)e.defaultViewDate=r.parseDate(e.defaultViewDate,g,e.language,e.assumeNearbyYear);else if(e.defaultViewDate){var j=e.defaultViewDate.year||(new Date).getFullYear(),k=e.defaultViewDate.month||0,l=e.defaultViewDate.day||1;e.defaultViewDate=c(j,k,l)}else e.defaultViewDate=d()},_applyEvents:function(a){for(var c,d,e,f=0;f<a.length;f++)c=a[f][0],2===a[f].length?(d=b,e=a[f][1]):3===a[f].length&&(d=a[f][1],e=a[f][2]),c.on(e,d)},_unapplyEvents:function(a){for(var c,d,e,f=0;f<a.length;f++)c=a[f][0],2===a[f].length?(e=b,d=a[f][1]):3===a[f].length&&(e=a[f][1],d=a[f][2]),c.off(d,e)},_buildEvents:function(){var b={keyup:a.proxy(function(b){-1===a.inArray(b.keyCode,[27,37,39,38,40,32,13,9])&&this.update()},this),keydown:a.proxy(this.keydown,this),paste:a.proxy(this.paste,this)};!0===this.o.showOnFocus&&(b.focus=a.proxy(this.show,this)),this.isInput?this._events=[[this.element,b]]:this.component&&this.inputField.length?this._events=[[this.inputField,b],[this.component,{click:a.proxy(this.show,this)}]]:this._events=[[this.element,{click:a.proxy(this.show,this),keydown:a.proxy(this.keydown,this)}]],this._events.push([this.element,"*",{blur:a.proxy(function(a){this._focused_from=a.target},this)}],[this.element,{blur:a.proxy(function(a){this._focused_from=a.target},this)}]),this.o.immediateUpdates&&this._events.push([this.element,{"changeYear changeMonth":a.proxy(function(a){this.update(a.date)},this)}]),this._secondaryEvents=[[this.picker,{click:a.proxy(this.click,this)}],[this.picker,".prev, .next",{click:a.proxy(this.navArrowsClick,this)}],[this.picker,".day:not(.disabled)",{click:a.proxy(this.dayCellClick,this)}],[a(window),{resize:a.proxy(this.place,this)}],[a(document),{"mousedown touchstart":a.proxy(function(a){this.element.is(a.target)||this.element.find(a.target).length||this.picker.is(a.target)||this.picker.find(a.target).length||this.isInline||this.hide()},this)}]]},_attachEvents:function(){this._detachEvents(),this._applyEvents(this._events)},_detachEvents:function(){this._unapplyEvents(this._events)},_attachSecondaryEvents:function(){this._detachSecondaryEvents(),this._applyEvents(this._secondaryEvents)},_detachSecondaryEvents:function(){this._unapplyEvents(this._secondaryEvents)},_trigger:function(b,c){var d=c||this.dates.get(-1),e=this._utc_to_local(d);this.element.trigger({type:b,date:e,viewMode:this.viewMode,dates:a.map(this.dates,this._utc_to_local),format:a.proxy(function(a,b){0===arguments.length?(a=this.dates.length-1,b=this.o.format):"string"==typeof a&&(b=a,a=this.dates.length-1),b=b||this.o.format;var c=this.dates.get(a);return r.formatDate(c,b,this.o.language)},this)})},show:function(){if(!(this.inputField.is(":disabled")||this.inputField.prop("readonly")&&!1===this.o.enableOnReadonly))return this.isInline||this.picker.appendTo(this.o.container),this.place(),this.picker.show(),this._attachSecondaryEvents(),this._trigger("show"),(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&this.o.disableTouchKeyboard&&a(this.element).blur(),this},hide:function(){return this.isInline||!this.picker.is(":visible")?this:(this.focusDate=null,this.picker.hide().detach(),this._detachSecondaryEvents(),this.setViewMode(this.o.startView),this.o.forceParse&&this.inputField.val()&&this.setValue(),this._trigger("hide"),this)},destroy:function(){return this.hide(),this._detachEvents(),this._detachSecondaryEvents(),this.picker.remove(),delete this.element.data().datepicker,this.isInput||delete this.element.data().date,this},paste:function(b){var c;if(b.originalEvent.clipboardData&&b.originalEvent.clipboardData.types&&-1!==a.inArray("text/plain",b.originalEvent.clipboardData.types))c=b.originalEvent.clipboardData.getData("text/plain");else{if(!window.clipboardData)return;c=window.clipboardData.getData("Text")}this.setDate(c),this.update(),b.preventDefault()},_utc_to_local:function(a){if(!a)return a;var b=new Date(a.getTime()+6e4*a.getTimezoneOffset());return b.getTimezoneOffset()!==a.getTimezoneOffset()&&(b=new Date(a.getTime()+6e4*b.getTimezoneOffset())),b},_local_to_utc:function(a){return a&&new Date(a.getTime()-6e4*a.getTimezoneOffset())},_zero_time:function(a){return a&&new Date(a.getFullYear(),a.getMonth(),a.getDate())},_zero_utc_time:function(a){return a&&c(a.getUTCFullYear(),a.getUTCMonth(),a.getUTCDate())},getDates:function(){return a.map(this.dates,this._utc_to_local)},getUTCDates:function(){return a.map(this.dates,function(a){return new Date(a)})},getDate:function(){return this._utc_to_local(this.getUTCDate())},getUTCDate:function(){var a=this.dates.get(-1);return a!==b?new Date(a):null},clearDates:function(){this.inputField.val(""),this.update(),this._trigger("changeDate"),this.o.autoclose&&this.hide()},setDates:function(){var b=a.isArray(arguments[0])?arguments[0]:arguments;return this.update.apply(this,b),this._trigger("changeDate"),this.setValue(),this},setUTCDates:function(){var b=a.isArray(arguments[0])?arguments[0]:arguments;return this.setDates.apply(this,a.map(b,this._utc_to_local)),this},setDate:f("setDates"),setUTCDate:f("setUTCDates"),remove:f("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead"),setValue:function(){var a=this.getFormattedDate();return this.inputField.val(a),this},getFormattedDate:function(c){c===b&&(c=this.o.format);var d=this.o.language;return a.map(this.dates,function(a){return r.formatDate(a,c,d)}).join(this.o.multidateSeparator)},getStartDate:function(){return this.o.startDate},setStartDate:function(a){return this._process_options({startDate:a}),this.update(),this.updateNavArrows(),this},getEndDate:function(){return this.o.endDate},setEndDate:function(a){return this._process_options({endDate:a}),this.update(),this.updateNavArrows(),this},setDaysOfWeekDisabled:function(a){return this._process_options({daysOfWeekDisabled:a}),this.update(),this},setDaysOfWeekHighlighted:function(a){return this._process_options({daysOfWeekHighlighted:a}),this.update(),this},setDatesDisabled:function(a){return this._process_options({datesDisabled:a}),this.update(),this},place:function(){if(this.isInline)return this;var b=this.picker.outerWidth(),c=this.picker.outerHeight(),d=a(this.o.container),e=d.width(),f="body"===this.o.container?a(document).scrollTop():d.scrollTop(),g=d.offset(),h=[0];this.element.parents().each(function(){var b=a(this).css("z-index");"auto"!==b&&0!==Number(b)&&h.push(Number(b))});var i=Math.max.apply(Math,h)+this.o.zIndexOffset,j=this.component?this.component.parent().offset():this.element.offset(),k=this.component?this.component.outerHeight(!0):this.element.outerHeight(!1),l=this.component?this.component.outerWidth(!0):this.element.outerWidth(!1),m=j.left-g.left,n=j.top-g.top;"body"!==this.o.container&&(n+=f),this.picker.removeClass("datepicker-orient-top datepicker-orient-bottom datepicker-orient-right datepicker-orient-left"),"auto"!==this.o.orientation.x?(this.picker.addClass("datepicker-orient-"+this.o.orientation.x),"right"===this.o.orientation.x&&(m-=b-l)):j.left<0?(this.picker.addClass("datepicker-orient-left"),m-=j.left-10):m+b>e?(this.picker.addClass("datepicker-orient-right"),m+=l-b):this.o.rtl?this.picker.addClass("datepicker-orient-right"):this.picker.addClass("datepicker-orient-left");var o,p=this.o.orientation.y;if("auto"===p&&(o=-f+n-c,p=o<0?"bottom":"top"),this.picker.addClass("datepicker-orient-"+p),"top"===p?n-=c+parseInt(this.picker.css("padding-top")):n+=k,this.o.rtl){var q=e-(m+l);this.picker.css({top:n,right:q,zIndex:i})}else this.picker.css({top:n,left:m,zIndex:i});return this},_allow_update:!0,update:function(){if(!this._allow_update)return this;var b=this.dates.copy(),c=[],d=!1;return arguments.length?(a.each(arguments,a.proxy(function(a,b){b instanceof Date&&(b=this._local_to_utc(b)),c.push(b)},this)),d=!0):(c=this.isInput?this.element.val():this.element.data("date")||this.inputField.val(),c=c&&this.o.multidate?c.split(this.o.multidateSeparator):[c],delete this.element.data().date),c=a.map(c,a.proxy(function(a){return r.parseDate(a,this.o.format,this.o.language,this.o.assumeNearbyYear)},this)),c=a.grep(c,a.proxy(function(a){return!this.dateWithinRange(a)||!a},this),!0),this.dates.replace(c),this.o.updateViewDate&&(this.dates.length?this.viewDate=new Date(this.dates.get(-1)):this.viewDate<this.o.startDate?this.viewDate=new Date(this.o.startDate):this.viewDate>this.o.endDate?this.viewDate=new Date(this.o.endDate):this.viewDate=this.o.defaultViewDate),d?(this.setValue(),this.element.change()):this.dates.length&&String(b)!==String(this.dates)&&d&&(this._trigger("changeDate"),this.element.change()),!this.dates.length&&b.length&&(this._trigger("clearDate"),this.element.change()),this.fill(),this},fillDow:function(){if(this.o.showWeekDays){var b=this.o.weekStart,c="<tr>";for(this.o.calendarWeeks&&(c+='<th class="cw">&#160;</th>');b<this.o.weekStart+7;)c+='<th class="dow',-1!==a.inArray(b,this.o.daysOfWeekDisabled)&&(c+=" disabled"),c+='">'+q[this.o.language].daysMin[b++%7]+"</th>";c+="</tr>",this.picker.find(".datepicker-days thead").append(c)}},fillMonths:function(){for(var a,b=this._utc_to_local(this.viewDate),c="",d=0;d<12;d++)a=b&&b.getMonth()===d?" focused":"",c+='<span class="month'+a+'">'+q[this.o.language].monthsShort[d]+"</span>";this.picker.find(".datepicker-months td").html(c)},setRange:function(b){b&&b.length?this.range=a.map(b,function(a){return a.valueOf()}):delete this.range,this.fill()},getClassNames:function(b){var c=[],f=this.viewDate.getUTCFullYear(),g=this.viewDate.getUTCMonth(),h=d();return b.getUTCFullYear()<f||b.getUTCFullYear()===f&&b.getUTCMonth()<g?c.push("old"):(b.getUTCFullYear()>f||b.getUTCFullYear()===f&&b.getUTCMonth()>g)&&c.push("new"),this.focusDate&&b.valueOf()===this.focusDate.valueOf()&&c.push("focused"),this.o.todayHighlight&&e(b,h)&&c.push("today"),-1!==this.dates.contains(b)&&c.push("active"),this.dateWithinRange(b)||c.push("disabled"),this.dateIsDisabled(b)&&c.push("disabled","disabled-date"),-1!==a.inArray(b.getUTCDay(),this.o.daysOfWeekHighlighted)&&c.push("highlighted"),this.range&&(b>this.range[0]&&b<this.range[this.range.length-1]&&c.push("range"),-1!==a.inArray(b.valueOf(),this.range)&&c.push("selected"),b.valueOf()===this.range[0]&&c.push("range-start"),b.valueOf()===this.range[this.range.length-1]&&c.push("range-end")),c},_fill_yearsView:function(c,d,e,f,g,h,i){for(var j,k,l,m="",n=e/10,o=this.picker.find(c),p=Math.floor(f/e)*e,q=p+9*n,r=Math.floor(this.viewDate.getFullYear()/n)*n,s=a.map(this.dates,function(a){return Math.floor(a.getUTCFullYear()/n)*n}),t=p-n;t<=q+n;t+=n)j=[d],k=null,t===p-n?j.push("old"):t===q+n&&j.push("new"),-1!==a.inArray(t,s)&&j.push("active"),(t<g||t>h)&&j.push("disabled"),t===r&&j.push("focused"),i!==a.noop&&(l=i(new Date(t,0,1)),l===b?l={}:"boolean"==typeof l?l={enabled:l}:"string"==typeof l&&(l={classes:l}),!1===l.enabled&&j.push("disabled"),l.classes&&(j=j.concat(l.classes.split(/\s+/))),l.tooltip&&(k=l.tooltip)),m+='<span class="'+j.join(" ")+'"'+(k?' title="'+k+'"':"")+">"+t+"</span>";o.find(".datepicker-switch").text(p+"-"+q),o.find("td").html(m)},fill:function(){var e,f,g=new Date(this.viewDate),h=g.getUTCFullYear(),i=g.getUTCMonth(),j=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,k=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,l=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,m=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,n=q[this.o.language].today||q.en.today||"",o=q[this.o.language].clear||q.en.clear||"",p=q[this.o.language].titleFormat||q.en.titleFormat,s=d(),t=(!0===this.o.todayBtn||"linked"===this.o.todayBtn)&&s>=this.o.startDate&&s<=this.o.endDate&&!this.weekOfDateIsDisabled(s);if(!isNaN(h)&&!isNaN(i)){this.picker.find(".datepicker-days .datepicker-switch").text(r.formatDate(g,p,this.o.language)),this.picker.find("tfoot .today").text(n).css("display",t?"table-cell":"none"),this.picker.find("tfoot .clear").text(o).css("display",!0===this.o.clearBtn?"table-cell":"none"),this.picker.find("thead .datepicker-title").text(this.o.title).css("display","string"==typeof this.o.title&&""!==this.o.title?"table-cell":"none"),this.updateNavArrows(),this.fillMonths();var u=c(h,i,0),v=u.getUTCDate();u.setUTCDate(v-(u.getUTCDay()-this.o.weekStart+7)%7);var w=new Date(u);u.getUTCFullYear()<100&&w.setUTCFullYear(u.getUTCFullYear()),w.setUTCDate(w.getUTCDate()+42),w=w.valueOf();for(var x,y,z=[];u.valueOf()<w;){if((x=u.getUTCDay())===this.o.weekStart&&(z.push("<tr>"),this.o.calendarWeeks)){var A=new Date(+u+(this.o.weekStart-x-7)%7*864e5),B=new Date(Number(A)+(11-A.getUTCDay())%7*864e5),C=new Date(Number(C=c(B.getUTCFullYear(),0,1))+(11-C.getUTCDay())%7*864e5),D=(B-C)/864e5/7+1;z.push('<td class="cw">'+D+"</td>")}y=this.getClassNames(u),y.push("day");var E=u.getUTCDate();this.o.beforeShowDay!==a.noop&&(f=this.o.beforeShowDay(this._utc_to_local(u)),f===b?f={}:"boolean"==typeof f?f={enabled:f}:"string"==typeof f&&(f={classes:f}),!1===f.enabled&&y.push("disabled"),f.classes&&(y=y.concat(f.classes.split(/\s+/))),f.tooltip&&(e=f.tooltip),f.content&&(E=f.content)),y=a.isFunction(a.uniqueSort)?a.uniqueSort(y):a.unique(y),z.push('<td class="'+y.join(" ")+'"'+(e?' title="'+e+'"':"")+' data-date="'+u.getTime().toString()+'">'+E+"</td>"),e=null,x===this.o.weekEnd&&z.push("</tr>"),u.setUTCDate(u.getUTCDate()+1)}this.picker.find(".datepicker-days tbody").html(z.join(""));var F=q[this.o.language].monthsTitle||q.en.monthsTitle||"Months",G=this.picker.find(".datepicker-months").find(".datepicker-switch").text(this.o.maxViewMode<2?F:h).end().find("tbody span").removeClass("active");if(a.each(this.dates,function(a,b){b.getUTCFullYear()===h&&G.eq(b.getUTCMonth()).addClass("active")}),(h<j||h>l)&&G.addClass("disabled"),h===j&&G.slice(0,k).addClass("disabled"),h===l&&G.slice(m+1).addClass("disabled"),this.o.beforeShowMonth!==a.noop){var H=this;a.each(G,function(c,d){var e=new Date(h,c,1),f=H.o.beforeShowMonth(e);f===b?f={}:"boolean"==typeof f?f={enabled:f}:"string"==typeof f&&(f={classes:f}),!1!==f.enabled||a(d).hasClass("disabled")||a(d).addClass("disabled"),f.classes&&a(d).addClass(f.classes),f.tooltip&&a(d).prop("title",f.tooltip)})}this._fill_yearsView(".datepicker-years","year",10,h,j,l,this.o.beforeShowYear),this._fill_yearsView(".datepicker-decades","decade",100,h,j,l,this.o.beforeShowDecade),this._fill_yearsView(".datepicker-centuries","century",1e3,h,j,l,this.o.beforeShowCentury)}},updateNavArrows:function(){if(this._allow_update){var a,b,c=new Date(this.viewDate),d=c.getUTCFullYear(),e=c.getUTCMonth(),f=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,g=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,h=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,i=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,j=1;switch(this.viewMode){case 4:j*=10;case 3:j*=10;case 2:j*=10;case 1:a=Math.floor(d/j)*j<=f,b=Math.floor(d/j)*j+j>h;break;case 0:a=d<=f&&e<=g,b=d>=h&&e>=i}this.picker.find(".prev").toggleClass("disabled",a),this.picker.find(".next").toggleClass("disabled",b)}},click:function(b){b.preventDefault(),b.stopPropagation();var e,f,g,h;e=a(b.target),e.hasClass("datepicker-switch")&&this.viewMode!==this.o.maxViewMode&&this.setViewMode(this.viewMode+1),e.hasClass("today")&&!e.hasClass("day")&&(this.setViewMode(0),this._setDate(d(),"linked"===this.o.todayBtn?null:"view")),e.hasClass("clear")&&this.clearDates(),e.hasClass("disabled")||(e.hasClass("month")||e.hasClass("year")||e.hasClass("decade")||e.hasClass("century"))&&(this.viewDate.setUTCDate(1),f=1,1===this.viewMode?(h=e.parent().find("span").index(e),g=this.viewDate.getUTCFullYear(),this.viewDate.setUTCMonth(h)):(h=0,g=Number(e.text()),this.viewDate.setUTCFullYear(g)),this._trigger(r.viewModes[this.viewMode-1].e,this.viewDate),this.viewMode===this.o.minViewMode?this._setDate(c(g,h,f)):(this.setViewMode(this.viewMode-1),this.fill())),this.picker.is(":visible")&&this._focused_from&&this._focused_from.focus(),delete this._focused_from},dayCellClick:function(b){var c=a(b.currentTarget),d=c.data("date"),e=new Date(d);this.o.updateViewDate&&(e.getUTCFullYear()!==this.viewDate.getUTCFullYear()&&this._trigger("changeYear",this.viewDate),e.getUTCMonth()!==this.viewDate.getUTCMonth()&&this._trigger("changeMonth",this.viewDate)),this._setDate(e)},navArrowsClick:function(b){var c=a(b.currentTarget),d=c.hasClass("prev")?-1:1;0!==this.viewMode&&(d*=12*r.viewModes[this.viewMode].navStep),this.viewDate=this.moveMonth(this.viewDate,d),this._trigger(r.viewModes[this.viewMode].e,this.viewDate),this.fill()},_toggle_multidate:function(a){var b=this.dates.contains(a);if(a||this.dates.clear(),-1!==b?(!0===this.o.multidate||this.o.multidate>1||this.o.toggleActive)&&this.dates.remove(b):!1===this.o.multidate?(this.dates.clear(),this.dates.push(a)):this.dates.push(a),"number"==typeof this.o.multidate)for(;this.dates.length>this.o.multidate;)this.dates.remove(0)},_setDate:function(a,b){b&&"date"!==b||this._toggle_multidate(a&&new Date(a)),(!b&&this.o.updateViewDate||"view"===b)&&(this.viewDate=a&&new Date(a)),this.fill(),this.setValue(),b&&"view"===b||this._trigger("changeDate"),this.inputField.trigger("change"),!this.o.autoclose||b&&"date"!==b||this.hide()},moveDay:function(a,b){var c=new Date(a);return c.setUTCDate(a.getUTCDate()+b),c},moveWeek:function(a,b){return this.moveDay(a,7*b)},moveMonth:function(a,b){if(!g(a))return this.o.defaultViewDate;if(!b)return a;var c,d,e=new Date(a.valueOf()),f=e.getUTCDate(),h=e.getUTCMonth(),i=Math.abs(b);if(b=b>0?1:-1,1===i)d=-1===b?function(){return e.getUTCMonth()===h}:function(){return e.getUTCMonth()!==c},c=h+b,e.setUTCMonth(c),c=(c+12)%12;else{for(var j=0;j<i;j++)e=this.moveMonth(e,b);c=e.getUTCMonth(),e.setUTCDate(f),d=function(){return c!==e.getUTCMonth()}}for(;d();)e.setUTCDate(--f),e.setUTCMonth(c);return e},moveYear:function(a,b){return this.moveMonth(a,12*b)},moveAvailableDate:function(a,b,c){do{if(a=this[c](a,b),!this.dateWithinRange(a))return!1;c="moveDay"}while(this.dateIsDisabled(a));return a},weekOfDateIsDisabled:function(b){return-1!==a.inArray(b.getUTCDay(),this.o.daysOfWeekDisabled)},dateIsDisabled:function(b){return this.weekOfDateIsDisabled(b)||a.grep(this.o.datesDisabled,function(a){return e(b,a)}).length>0},dateWithinRange:function(a){return a>=this.o.startDate&&a<=this.o.endDate},keydown:function(a){if(!this.picker.is(":visible"))return void(40!==a.keyCode&&27!==a.keyCode||(this.show(),a.stopPropagation()));var b,c,d=!1,e=this.focusDate||this.viewDate;switch(a.keyCode){case 27:this.focusDate?(this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill()):this.hide(),a.preventDefault(),a.stopPropagation();break;case 37:case 38:case 39:case 40:if(!this.o.keyboardNavigation||7===this.o.daysOfWeekDisabled.length)break;b=37===a.keyCode||38===a.keyCode?-1:1,0===this.viewMode?a.ctrlKey?(c=this.moveAvailableDate(e,b,"moveYear"))&&this._trigger("changeYear",this.viewDate):a.shiftKey?(c=this.moveAvailableDate(e,b,"moveMonth"))&&this._trigger("changeMonth",this.viewDate):37===a.keyCode||39===a.keyCode?c=this.moveAvailableDate(e,b,"moveDay"):this.weekOfDateIsDisabled(e)||(c=this.moveAvailableDate(e,b,"moveWeek")):1===this.viewMode?(38!==a.keyCode&&40!==a.keyCode||(b*=4),c=this.moveAvailableDate(e,b,"moveMonth")):2===this.viewMode&&(38!==a.keyCode&&40!==a.keyCode||(b*=4),c=this.moveAvailableDate(e,b,"moveYear")),c&&(this.focusDate=this.viewDate=c,this.setValue(),this.fill(),a.preventDefault());break;case 13:if(!this.o.forceParse)break;e=this.focusDate||this.dates.get(-1)||this.viewDate,this.o.keyboardNavigation&&(this._toggle_multidate(e),d=!0),this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.setValue(),this.fill(),this.picker.is(":visible")&&(a.preventDefault(),a.stopPropagation(),this.o.autoclose&&this.hide());break;case 9:this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill(),this.hide()}d&&(this.dates.length?this._trigger("changeDate"):this._trigger("clearDate"),this.inputField.trigger("change"))},setViewMode:function(a){this.viewMode=a,this.picker.children("div").hide().filter(".datepicker-"+r.viewModes[this.viewMode].clsName).show(),this.updateNavArrows(),this._trigger("changeViewMode",new Date(this.viewDate))}};var l=function(b,c){a.data(b,"datepicker",this),this.element=a(b),this.inputs=a.map(c.inputs,function(a){return a.jquery?a[0]:a}),delete c.inputs,this.keepEmptyValues=c.keepEmptyValues,delete c.keepEmptyValues,n.call(a(this.inputs),c).on("changeDate",a.proxy(this.dateUpdated,this)),this.pickers=a.map(this.inputs,function(b){return a.data(b,"datepicker")}),this.updateDates()};l.prototype={updateDates:function(){this.dates=a.map(this.pickers,function(a){return a.getUTCDate()}),this.updateRanges()},updateRanges:function(){var b=a.map(this.dates,function(a){return a.valueOf()});a.each(this.pickers,function(a,c){c.setRange(b)})},clearDates:function(){a.each(this.pickers,function(a,b){b.clearDates()})},dateUpdated:function(c){if(!this.updating){this.updating=!0;var d=a.data(c.target,"datepicker");if(d!==b){var e=d.getUTCDate(),f=this.keepEmptyValues,g=a.inArray(c.target,this.inputs),h=g-1,i=g+1,j=this.inputs.length;if(-1!==g){if(a.each(this.pickers,function(a,b){b.getUTCDate()||b!==d&&f||b.setUTCDate(e)}),e<this.dates[h])for(;h>=0&&e<this.dates[h];)this.pickers[h--].setUTCDate(e);else if(e>this.dates[i])for(;i<j&&e>this.dates[i];)this.pickers[i++].setUTCDate(e);this.updateDates(),delete this.updating}}}},destroy:function(){a.map(this.pickers,function(a){a.destroy()}),a(this.inputs).off("changeDate",this.dateUpdated),delete this.element.data().datepicker},remove:f("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead")};var m=a.fn.datepicker,n=function(c){var d=Array.apply(null,arguments);d.shift();var e;if(this.each(function(){var b=a(this),f=b.data("datepicker"),g="object"==typeof c&&c;if(!f){var j=h(this,"date"),m=a.extend({},o,j,g),n=i(m.language),p=a.extend({},o,n,j,g);b.hasClass("input-daterange")||p.inputs?(a.extend(p,{inputs:p.inputs||b.find("input").toArray()}),f=new l(this,p)):f=new k(this,p),b.data("datepicker",f)}"string"==typeof c&&"function"==typeof f[c]&&(e=f[c].apply(f,d))}),e===b||e instanceof k||e instanceof l)return this;if(this.length>1)throw new Error("Using only allowed for the collection of a single element ("+c+" function)");return e};a.fn.datepicker=n;var o=a.fn.datepicker.defaults={assumeNearbyYear:!1,autoclose:!1,beforeShowDay:a.noop,beforeShowMonth:a.noop,beforeShowYear:a.noop,beforeShowDecade:a.noop,beforeShowCentury:a.noop,calendarWeeks:!1,clearBtn:!1,toggleActive:!1,daysOfWeekDisabled:[],daysOfWeekHighlighted:[],datesDisabled:[],endDate:1/0,forceParse:!0,format:"mm/dd/yyyy",keepEmptyValues:!1,keyboardNavigation:!0,language:"en",minViewMode:0,maxViewMode:4,multidate:!1,multidateSeparator:",",orientation:"auto",rtl:!1,startDate:-1/0,startView:0,todayBtn:!1,todayHighlight:!1,updateViewDate:!0,weekStart:0,disableTouchKeyboard:!1,enableOnReadonly:!0,showOnFocus:!0,zIndexOffset:10,container:"body",immediateUpdates:!1,title:"",templates:{leftArrow:"&#x00AB;",rightArrow:"&#x00BB;"},showWeekDays:!0},p=a.fn.datepicker.locale_opts=["format","rtl","weekStart"];a.fn.datepicker.Constructor=k;var q=a.fn.datepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],today:"Today",clear:"Clear",titleFormat:"MM yyyy"}},r={viewModes:[{names:["days","month"],clsName:"days",e:"changeMonth"},{names:["months","year"],clsName:"months",e:"changeYear",navStep:1},{names:["years","decade"],clsName:"years",e:"changeDecade",navStep:10},{names:["decades","century"],clsName:"decades",e:"changeCentury",navStep:100},{names:["centuries","millennium"],clsName:"centuries",e:"changeMillennium",navStep:1e3}],validParts:/dd?|DD?|mm?|MM?|yy(?:yy)?/g,nonpunctuation:/[^ -\/:-@\u5e74\u6708\u65e5\[-`{-~\t\n\r]+/g,parseFormat:function(a){if("function"==typeof a.toValue&&"function"==typeof a.toDisplay)return a;var b=a.replace(this.validParts,"\0").split("\0"),c=a.match(this.validParts);if(!b||!b.length||!c||0===c.length)throw new Error("Invalid date format.");return{separators:b,parts:c}},parseDate:function(c,e,f,g){function h(a,b){return!0===b&&(b=10),a<100&&(a+=2e3)>(new Date).getFullYear()+b&&(a-=100),a}function i(){var a=this.slice(0,j[n].length),b=j[n].slice(0,a.length);return a.toLowerCase()===b.toLowerCase()}if(!c)return b;if(c instanceof Date)return c;if("string"==typeof e&&(e=r.parseFormat(e)),e.toValue)return e.toValue(c,e,f);var j,l,m,n,o,p={d:"moveDay",m:"moveMonth",w:"moveWeek",y:"moveYear"},s={yesterday:"-1d",today:"+0d",tomorrow:"+1d"};if(c in s&&(c=s[c]),/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/i.test(c)){for(j=c.match(/([\-+]\d+)([dmwy])/gi),c=new Date,n=0;n<j.length;n++)l=j[n].match(/([\-+]\d+)([dmwy])/i),m=Number(l[1]),o=p[l[2].toLowerCase()],c=k.prototype[o](c,m);return k.prototype._zero_utc_time(c)}j=c&&c.match(this.nonpunctuation)||[];var t,u,v={},w=["yyyy","yy","M","MM","m","mm","d","dd"],x={yyyy:function(a,b){return a.setUTCFullYear(g?h(b,g):b)},m:function(a,b){if(isNaN(a))return a;for(b-=1;b<0;)b+=12;for(b%=12,a.setUTCMonth(b);a.getUTCMonth()!==b;)a.setUTCDate(a.getUTCDate()-1);return a},d:function(a,b){return a.setUTCDate(b)}};x.yy=x.yyyy,x.M=x.MM=x.mm=x.m,x.dd=x.d,c=d();var y=e.parts.slice();if(j.length!==y.length&&(y=a(y).filter(function(b,c){return-1!==a.inArray(c,w)}).toArray()),j.length===y.length){var z;for(n=0,z=y.length;n<z;n++){if(t=parseInt(j[n],10),l=y[n],isNaN(t))switch(l){case"MM":u=a(q[f].months).filter(i),t=a.inArray(u[0],q[f].months)+1;break;case"M":u=a(q[f].monthsShort).filter(i),t=a.inArray(u[0],q[f].monthsShort)+1}v[l]=t}var A,B;for(n=0;n<w.length;n++)(B=w[n])in v&&!isNaN(v[B])&&(A=new Date(c),x[B](A,v[B]),isNaN(A)||(c=A))}return c},formatDate:function(b,c,d){if(!b)return"";if("string"==typeof c&&(c=r.parseFormat(c)),c.toDisplay)return c.toDisplay(b,c,d);var e={d:b.getUTCDate(),D:q[d].daysShort[b.getUTCDay()],DD:q[d].days[b.getUTCDay()],m:b.getUTCMonth()+1,M:q[d].monthsShort[b.getUTCMonth()],MM:q[d].months[b.getUTCMonth()],yy:b.getUTCFullYear().toString().substring(2),yyyy:b.getUTCFullYear()};e.dd=(e.d<10?"0":"")+e.d,e.mm=(e.m<10?"0":"")+e.m,b=[];for(var f=a.extend([],c.separators),g=0,h=c.parts.length;g<=h;g++)f.length&&b.push(f.shift()),b.push(e[c.parts[g]]);return b.join("")},
headTemplate:'<thead><tr><th colspan="7" class="datepicker-title"></th></tr><tr><th class="prev">'+o.templates.leftArrow+'</th><th colspan="5" class="datepicker-switch"></th><th class="next">'+o.templates.rightArrow+"</th></tr></thead>",contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};r.template='<div class="datepicker"><div class="datepicker-days"><table class="table-condensed">'+r.headTemplate+"<tbody></tbody>"+r.footTemplate+'</table></div><div class="datepicker-months"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-years"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-decades"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+'</table></div><div class="datepicker-centuries"><table class="table-condensed">'+r.headTemplate+r.contTemplate+r.footTemplate+"</table></div></div>",a.fn.datepicker.DPGlobal=r,a.fn.datepicker.noConflict=function(){return a.fn.datepicker=m,this},a.fn.datepicker.version="1.9.0",a.fn.datepicker.deprecated=function(a){var b=window.console;b&&b.warn&&b.warn("DEPRECATED: "+a)},a(document).on("focus.datepicker.data-api click.datepicker.data-api",'[data-provide="datepicker"]',function(b){var c=a(this);c.data("datepicker")||(b.preventDefault(),n.call(c,"show"))}),a(function(){n.call(a('[data-provide="datepicker-inline"]'))})});
//Wait spinner
var __assign = (this && this.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
var defaults = {
    lines: 12,
    length: 7,
    width: 5,
    radius: 10,
    scale: 1.0,
    corners: 1,
    color: '#000',
    fadeColor: 'transparent',
    animation: 'spinner-line-fade-default',
    rotate: 0,
    direction: 1,
    speed: 1,
    zIndex: 2e9,
    className: 'spinner',
    top: '50%',
    left: '50%',
    shadow: '0 0 1px transparent',
    position: 'absolute',
};
var Spinner = /** @class */ (function () {
    function Spinner(opts) {
        if (opts === void 0) { opts = {}; }
        this.opts = __assign(__assign({}, defaults), opts);
    }
    /**
     * Adds the spinner to the given target element. If this instance is already
     * spinning, it is automatically removed from its previous target by calling
     * stop() internally.
     */
    Spinner.prototype.spin = function (target) {
        this.stop();
        this.el = document.createElement('div');
        this.el.className = this.opts.className;
        this.el.setAttribute('role', 'progressbar');
        css(this.el, {
            position: this.opts.position,
            width: 0,
            zIndex: this.opts.zIndex,
            left: this.opts.left,
            top: this.opts.top,
            transform: "scale(" + this.opts.scale + ")",
        });
        if (target) {
            target.insertBefore(this.el, target.firstChild || null);
        }
        drawLines(this.el, this.opts);
        return this;
    };
    /**
     * Stops and removes the Spinner.
     * Stopped spinners may be reused by calling spin() again.
     */
    Spinner.prototype.stop = function () {
        if (this.el) {
            if (typeof requestAnimationFrame !== 'undefined') {
                cancelAnimationFrame(this.animateId);
            }
            else {
                clearTimeout(this.animateId);
            }
            if (this.el.parentNode) {
                this.el.parentNode.removeChild(this.el);
            }
            this.el = undefined;
        }
        return this;
    };
    return Spinner;
}());

/**
 * Sets multiple style properties at once.
 */
function css(el, props) {
    for (var prop in props) {
        el.style[prop] = props[prop];
    }
    return el;
}
/**
 * Returns the line color from the given string or array.
 */
function getColor(color, idx) {
    return typeof color == 'string' ? color : color[idx % color.length];
}
/**
 * Internal method that draws the individual lines.
 */
function drawLines(el, opts) {
    var borderRadius = (Math.round(opts.corners * opts.width * 500) / 1000) + 'px';
    var shadow = 'none';
    if (opts.shadow === true) {
        shadow = '0 2px 4px #000'; // default shadow
    }
    else if (typeof opts.shadow === 'string') {
        shadow = opts.shadow;
    }
    var shadows = parseBoxShadow(shadow);
    for (var i = 0; i < opts.lines; i++) {
        var degrees = ~~(360 / opts.lines * i + opts.rotate);
        var backgroundLine = css(document.createElement('div'), {
            position: 'absolute',
            top: -opts.width / 2 + "px",
            width: (opts.length + opts.width) + 'px',
            height: opts.width + 'px',
            background: getColor(opts.fadeColor, i),
            borderRadius: borderRadius,
            transformOrigin: 'left',
            transform: "rotate(" + degrees + "deg) translateX(" + opts.radius + "px)",
        });
        var delay = i * opts.direction / opts.lines / opts.speed;
        delay -= 1 / opts.speed; // so initial animation state will include trail
        var line = css(document.createElement('div'), {
            width: '100%',
            height: '100%',
            background: getColor(opts.color, i),
            borderRadius: borderRadius,
            boxShadow: normalizeShadow(shadows, degrees),
            animation: 1 / opts.speed + "s linear " + delay + "s infinite " + opts.animation,
        });
        backgroundLine.appendChild(line);
        el.appendChild(backgroundLine);
    }
}
function parseBoxShadow(boxShadow) {
    var regex = /^\s*([a-zA-Z]+\s+)?(-?\d+(\.\d+)?)([a-zA-Z]*)\s+(-?\d+(\.\d+)?)([a-zA-Z]*)(.*)$/;
    var shadows = [];
    for (var _i = 0, _a = boxShadow.split(','); _i < _a.length; _i++) {
        var shadow = _a[_i];
        var matches = shadow.match(regex);
        if (matches === null) {
            continue; // invalid syntax
        }
        var x = +matches[2];
        var y = +matches[5];
        var xUnits = matches[4];
        var yUnits = matches[7];
        if (x === 0 && !xUnits) {
            xUnits = yUnits;
        }
        if (y === 0 && !yUnits) {
            yUnits = xUnits;
        }
        if (xUnits !== yUnits) {
            continue; // units must match to use as coordinates
        }
        shadows.push({
            prefix: matches[1] || '',
            x: x,
            y: y,
            xUnits: xUnits,
            yUnits: yUnits,
            end: matches[8],
        });
    }
    return shadows;
}
/**
 * Modify box-shadow x/y offsets to counteract rotation
 */
function normalizeShadow(shadows, degrees) {
    var normalized = [];
    for (var _i = 0, shadows_1 = shadows; _i < shadows_1.length; _i++) {
        var shadow = shadows_1[_i];
        var xy = convertOffset(shadow.x, shadow.y, degrees);
        normalized.push(shadow.prefix + xy[0] + shadow.xUnits + ' ' + xy[1] + shadow.yUnits + shadow.end);
    }
    return normalized.join(', ');
}
function convertOffset(x, y, degrees) {
    var radians = degrees * Math.PI / 180;
    var sin = Math.sin(radians);
    var cos = Math.cos(radians);
    return [
        Math.round((x * cos + y * sin) * 1000) / 1000,
        Math.round((-x * sin + y * cos) * 1000) / 1000,
    ];
}

