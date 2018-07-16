"undefined"!=typeof wcs_moment_locale&&moment.updateLocale("en",wcs_moment_locale);var wcs_apps=[],timetables=document.querySelectorAll("div.wcs-vue");Array.prototype.forEach.call(timetables,function(t,s){var e=t.getAttribute("id"),i=e.replace("wcs-app-",""),n=window["EventsSchedule_"+i],o=void 0!==n.options?n.options:{},l=void 0!==n.filters?n.filters:{},a="undefined"!==n.feed?n.feed:[],c=[wcs_timetable_mixins];if(void 0!==n.css&&void 0!==document.getElementById("wcs_styles")&&null!=document.getElementById("wcs_styles")&&(document.getElementById("wcs_styles").innerHTML+=n.css),!1!==o.mixins){o.mixins.split(" ").forEach(function(t){c.push(window[t])})}o.is_single?wcs_apps[s]=new Vue({el:"#"+e,mounted:function(){var t=["wcs-vue--mounted"];this.$el.className+=" "+t.join(" ")},template:"#wcs_templates_timetable--"+e,data:function(){return{css_classes:[],options:o,single:a,now:moment().utc()}},mixins:c}):wcs_apps[s]=new Vue({el:"#"+e,template:"#wcs_templates_timetable--"+e,created:function(){var t=this;void 0!==this.options.days&&this.options.days||(this.options.days=356),0===a.length?this.getEvents():a.forEach(function(s,e,i){-1===t.events_hases.indexOf(s.hash)&&(t.events_hases.push(s.hash),t.filterEvent(s))})},computed:{schedule_events:function(){var t=this,s=t.getLimit(),e=[],i=!1;return t.events.forEach(function(s,n){i=!1,t.filter_var(t.options.show_past_events)||!t.filter_var(s.future)&&t.filter_var(s.finished)&&(i=!0),i||e.push(s)}),s>0&&(e=t.events.slice(0,s)),e}},mounted:function(){if(this.css_classes.push(this.hasFilters()?"wcs-timetable--with-filters":"wcs-timetable--without-filters"),this.hasFilters()){switch(!0){case 0===parseInt(this.options.filters_position):this.css_classes.push("wcs-timetable--filters-left");break;case 1===parseInt(this.options.filters_position):this.css_classes.push("wcs-timetable--filters-center");break;case 2===parseInt(this.options.filters_position):this.css_classes.push("wcs-timetable--filters-right");break}this.css_classes.push(this.filter_var(this.options.show_filters_opened)?"wcs-timetable--filters-expanded":"wcs-timetable--filters-closed"),this.css_classes.push(void 0!==this.options.label_toggle.length&&this.options.label_toggle.length>0?"wcs-timetable--filters-with-toggle":"wcs-timetable--filters-without-toggle")}},methods:{extendObject:function t(s,e){return Object.keys(e).forEach(function(t){s[t]=e[t]}),s},apply_filters:function(){var t=Array.prototype.slice.call(arguments,0)},get_utc_offset:function(){var t=this,s=window.wcs_locale.gmtOffset,e=0===s.toString().indexOf("-")?"-":"+";return"-"===e&&(s=s.substring(1)),hours=parseInt(s/3600),hours=hours<10?"0"+hours:hours,minutes=s%3600,minutes=minutes<10?"0"+minutes:minutes,e+hours+":"+minutes}},data:function(){return{el_id:e,css_classes:["wcs-timetable--style-"+o.view],options:o,events:a,events_hases:[],events_filtered:[],filters:l,filters_active:this.getActiveFilters(l),loading:!1,loading_process:!1,loading_history:[],selected_day:!1,iso:!1,iso_expanded_items:[],start:void 0!==o.ts_start?o.ts_start:moment().utcOffset(this.get_utc_offset()).format("YYYY-MM-DD"),stop:void 0!==o.ts_start?o.ts_stop:moment().utcOffset(this.get_utc_offset()).add(parseInt(o.days)-1,"days").format("YYYY-MM-DD"),today:moment().utcOffset(this.get_utc_offset()).format("YYYY-MM-DD"),calendar:{},calendarDay:null,selectedDay:null,dateRange:{start:null,stop:null},dateRangeHistory:[],status:{toggler:!0}}},mixins:c})});