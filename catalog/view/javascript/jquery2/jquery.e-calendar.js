(function ($) {
    var eCalendar = function (options, object) {
        // Initializing global variables
        var adDay = new Date().getDate();
        var adMonth = new Date().getMonth();
        var adYear = new Date().getFullYear();
        var dDay = adDay;
        var dMonth = adMonth;
        var dYear = adYear;
        var instance = object;

        var settings = $.extend({}, $.fn.eCalendar.defaults, options);

        function lpad(value, length, pad) {
            if (typeof pad == 'undefined') {
                pad = '0';
            }
            var p;
            for (var i = 0; i < length; i++) {
                p += pad;
            }
            return (p + value).slice(-length);
        }

        var mouseOver = function () {
            $(this).addClass('c-nav-btn-over');
        };
        var mouseLeave = function () {
            $(this).removeClass('c-nav-btn-over');
        };
        var mouseOverEvent = function () {
            $(this).addClass('c-event-over');
            var d = $(this).attr('data-event-day');
            $('div.c-event-item[data-event-day="' + d + '"]').addClass('c-event-over');
        };
        var mouseLeaveEvent = function () {
            $(this).removeClass('c-event-over')
            var d = $(this).attr('data-event-day');
            $('div.c-event-item[data-event-day="' + d + '"]').removeClass('c-event-over');
        };
        var umouseOverEvent = function () {
            $(this).addClass('c-uevent-over');
            var d = $(this).attr('data-event-day');
        };
        var umouseLeaveEvent = function () {
            $(this).removeClass('c-uevent-over');
            var d = $(this).attr('data-event-day');
        };
        var mouseOverItem = function () {
            $(this).addClass('c-event-over');
            var d = $(this).attr('data-event-day');
            $('div.c-event[data-event-day="' + d + '"]').addClass('c-event-over');
        };
        var mouseLeaveItem = function () {
            $(this).removeClass('c-event-over')
            var d = $(this).attr('data-event-day');
            $('div.c-event[data-event-day="' + d + '"]').removeClass('c-event-over');
        };
        var nextMonth = function () {
            if (dMonth < 11) {
                dMonth++;
            } else {
                dMonth = 0;
                dYear++;
            }
            print();
        };
        var previousMonth = function () {
            if (dMonth > 0) {
                dMonth--;
            } else {
                dMonth = 11;
                dYear--;
            }
            print();
        };

        function loadEvents() {
            if (typeof settings.url != 'undefined' && settings.url != '') {
                $.ajax({url: settings.url,
                    async: false,
                    type:'GET',
                    dataType:'json',
                    data:{uname_id:settings.uname_id,uname:settings.uname},
                    success: function (data) {
                        if(data!=2){
                        $.each(data,function(index,d){
                            //alert(d.addtime);
                            arr=d.addtime.split('-');
                            d.addtime = new Date(arr[0], arr[1], arr[2]);
                        });
                        settings.events = data;
                        }
                    },
                    error:function(){
                        alert('服务器繁忙');
                    }
                });
            }
        }

        function print() {
            loadEvents();
            var dWeekDayOfMonthStart = new Date(dYear, dMonth, 1).getDay();
            var dLastDayOfMonth = new Date(dYear, dMonth + 1, 0).getDate();
            var dLastDayOfPreviousMonth = new Date(dYear, dMonth + 1, 0).getDate() - dWeekDayOfMonthStart + 1;

            var cBody = $('<div/>').addClass('c-grid');
            var cEvents = $('<div/>').addClass('c-event-grid');
            var cEventsBody = $('<div/>').addClass('c-event-body');
            //cEvents.append($('<div/>').addClass('c-event-title c-pad-top').html(settings.eventTitle));
            //cEvents.append(cEventsBody);
            var cNext = $('<div/>').addClass('c-next c-grid-title c-pad-top');
            var cMonth = $('<div/>').addClass('c-month c-grid-title c-pad-top');
            var cPrevious = $('<div/>').addClass('c-previous c-grid-title c-pad-top');
            cPrevious.html(settings.textArrows.previous);
            cMonth.html(dYear + '年' + settings.months[dMonth]);
            cNext.html(settings.textArrows.next);

            cPrevious.on('mouseover', mouseOver).on('mouseleave', mouseLeave).on('click', previousMonth);
            if( adYear > dYear || ( adYear == dYear && adMonth > dMonth )){
            	cNext.on('mouseover', mouseOver).on('mouseleave', mouseLeave).on('click', nextMonth);
            }

            cBody.append(cPrevious);
            cBody.append(cMonth);
            cBody.append(cNext);
            for (var i = 0; i < settings.weekDays.length; i++) {
                var cWeekDay = $('<div/>').addClass('c-week-day c-pad-top');
                cWeekDay.html(settings.weekDays[i]);
                cBody.append(cWeekDay);
            }
            var day = 1;
            var dayOfNextMonth = 1;
            for (var i = 0; i < 42; i++) {
                var cDay = $('<div/>');
                if (i < dWeekDayOfMonthStart) {
                    cDay.addClass('c-day-previous-month c-pad-top');
                    cDay.html('&nbsp;');
                    //cDay.html(dLastDayOfPreviousMonth++);
                } else if (day <= dLastDayOfMonth) {
                    cDay.addClass('c-day c-pad-top');
                    if (day == dDay && adMonth == dMonth && adYear == dYear) {
                        cDay.addClass('c-today');
                    }
                    for (var j = 0; j < settings.events.length; j++) {
                        var d = settings.events[j].addtime;
                        if (d.getDate() == day && (d.getMonth() - 1) == dMonth && d.getFullYear() == dYear) {
                            cDay.addClass('c-event').attr('data-event-day', d.getDate());
                            cDay.on('mouseover', mouseOverEvent).on('mouseleave', mouseLeaveEvent);
                        }
                    }
                    cDay.html(day++);
                    if(dDay > cDay.text()){
                        cDay.on('mouseover', umouseOverEvent).on('mouseleave', umouseLeaveEvent);
                    }
                    if(adMonth != dMonth){
                    	cDay.on('mouseover', umouseLeaveEvent);
                    }
                } else {
                    cDay.addClass('c-day-next-month c-pad-top');
                    cDay.html('&nbsp;');
                    //cDay.html(dayOfNextMonth++);
                }
                cBody.append(cDay);
            }
            //var eventList = $('<div/>').addClass('c-event-list');
            //for (var i = 0; i < settings.events.length; i++) {
                //var d = settings.events[i].addtime;
                //if ((d.getMonth() - 1) == dMonth && d.getFullYear() == dYear) {
                    var date = lpad(d.getDate(), 2) + '/' + lpad(d.getMonth(), 2) + ' ' + lpad(d.getHours(), 2) + ':' + lpad(d.getMinutes(), 2);
                    //var item = $('<div/>').addClass('c-event-item');
                    //var title = $('<div/>').addClass('title').html(date + '  ' + settings.events[i].title + '<br/>');
                    //var description = $('<div/>').addClass('description').html(settings.events[i].description + '<br/>');
                    //item.attr('data-event-day', d.getDate());
                    //item.on('mouseover', mouseOverItem).on('mouseleave', mouseLeaveItem);
                    //item.append(title).append(description);
                    //eventList.append(item);
                //}
            //}
            $(instance).addClass('calendar');
            //cEventsBody.append(eventList);
            $(instance).html(cBody);
        }
        return print();
    }

    $.fn.eCalendar = function (oInit) {
        //alert(oInit.uname);
        return this.each(function () {
            return eCalendar(oInit, $(this));
        });
    };

    // plugin defaults
    $.fn.eCalendar.defaults = {
        weekDays: ['日','一', '二', '三', '四', '五', '六'],
        months: ['01月', '02月', '03月', '04月', '05月', '06月', '07月', '08月', '09月', '10月', '11月', '12月'],
        textArrows: {previous: '<', next: '>'},
        eventTitle: '事件',
        url: 'index.php?route=order/order/qiandao',
        events:[
                 {addtime:new Date(new Date().getFullYear(),new Date().getMonth()+1,new Date().getDate())}
]
    };
}(jQuery));