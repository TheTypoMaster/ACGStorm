var cnstorm = {
    baseUrl: "",
    config: {
        root: "/"
    },
    formatData: function (data) {
        return window.eval('(' + data + ')');
    },
    isEmpty: function () {
        if (arguments.length <= 0)
            return true;
        return (arguments[0].replace(/(^\s*)|(\s*$)/g, "") == "") ? true : false;
    },
    toInt: function () {
        if (arguments.length <= 0)
            return -1;
        if (isNaN(parseInt(arguments[0])))
            return -1;
        else
            return parseInt(arguments[0]);
    },
    showBox: function (classname, width, height, html) {
        var _width = $("." + classname).width();
        var _height = $("." + classname).height();
        var _left = (parseInt(_width) - width) / 2;
        var _top = (parseInt(_height) - height) / 2;
        $("body").append("<div class=\"background-layer\" style=\"display:none;background-color:#666;width:100%;height:9999px;left:0;top:0;filter:alpha(opacity=50);opacity:0.5;z-index:80000;position:absolute;background-position: initial initial;background-repeat: initial initial;\" ></div><div class=\"box-layer\" style=\"display:none;position:absolute;z-index:80001;background:##f9f9f9;\"></div>");
        $(".background-layer").css({"width": _width, "height": _height}).fadeIn(500);
        $(".box-layer").css({"left": _left + "px", "top": _top + "px", "width": width, "height": height}).fadeIn(500);
        $(".box-layer").html(html);

        $(window).on('resize', function () {
            $(".background-layer").css("height", $(this).height());
        });
    },
    cancelBox: function () {
        $(".box-layer").remove();
        $(".background-layer").remove();
    },
    getQueryString: function (name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return "";
    },
    getBrowser: function () {
        var ClientParams = {};
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
                (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
                (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
                (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
                (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
        if (Sys.ie) {
            ClientParams.Browser = "IE" + Sys.ie;
        }
        else if (Sys.firefox) {
            ClientParams.Browser = "Firefox" + Sys.firefox;
        }
        else if (Sys.chrome) {
            ClientParams.Browser = "Chrome" + Sys.chrome;
        }
        else if (Sys.opera) {
            ClientParams.Browser = "Opera" + Sys.opera;
        }
        else if (Sys.safari) {
            ClientParams.Browser = "Safari" + Sys.safari;
        }
        else {
            ClientParams.Browser = "";
        }
        return ClientParams.Browser;
    }


};