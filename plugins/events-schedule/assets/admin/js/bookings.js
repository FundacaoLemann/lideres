if (typeof(document.getElementById("wcs-bookings__app")) != 'undefined' && document.getElementById("wcs-bookings__app") != null){

  ELEMENT.locale(window.EventsSchedule.locale_element_ui);

  Vue.filter('moment', function (date, format, convert) {
  	return convert !== false ? moment(date).utc().format(format) : moment(date).format(format);
  });

  var WcsBookings = new Vue({
    el: '#wcs-bookings__app',
    data: function(){

      var terms = window.EventsSchedule.terms;
      var filters = {
        finished: true,
        canceled: true,
        search: ''
      };
      _.each( terms, function(o,k){
        filters[k] = [];
      });

      return {
        terms: terms,
        filters: filters,
        orders: [],
        orders_count: 0,
        orders_page: 1,
        orders_per_page: 10,
        query: {
          posts_per_page: 100,
          paged: 1,
					date_start: moment().format(),
					date_end: moment().add(2, 'weeks').format()
        },
				loading: false,
				buffer: {
					cancel_order: ''
				},
				date_range: [ moment(), moment().add(2, 'weeks') ],
				datepiker_options: {
          shortcuts: [{
            text: 'Next week',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              end.setTime(start.getTime() + 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          },{
            text: 'Next 2 weeks',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              end.setTime(start.getTime() + 3600 * 1000 * 24 * 14);
              picker.$emit('pick', [start, end]);
            }
          },{
            text: 'Next 30 days',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              end.setTime(start.getTime() + 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          },{
            text: 'Last week',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          },{
            text: 'Last 2 week',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 14);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: 'Last 30 days',
            onClick: function(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          }]
        }
      }
    },
    mounted: function(){
      var vm = this;
      this.getOrders();
    },
    watch: {
			date_range: function( newVal ){
				var vm = this;
				vm.query.date_start = typeof newVal !== 'undefined' && newVal[0] !== null ? moment( newVal[0] ).format() : moment().format();
				vm.query.date_end = typeof newVal !== 'undefined' && newVal[1] !== null ? moment( newVal[1] ).format() : moment().add(2, 'weeks').format();
				this.getOrders();
			},
      orders_page: function(newVal){
        this.query.paged = newVal;
        //this.query.posts_per_page = 10;
        if( this.filtered_orders.length < this.orders_count && this.filtered_orders.length % this.orders_per_page * this.orders_page === 0 ){
          this.getOrders();
        }
      },
      orders_per_page: function(newVal){
        this.orders_page = 1;
        this.query.posts_per_page = newVal;
        if( this.filtered_orders.length < this.orders_count && this.filtered_orders.length < this.orders_per_page ){
          this.getOrders();
        }
      }
    },
    updated: function(){

    },
		computed: {
      taxonomies: function(){
        return window.EventsSchedule.taxonomies;
      },
			tableData: function(){
				var vm = this;
				var orders = [];
				var start = vm.orders_per_page * ( vm.orders_page - 1);
				var end = vm.orders_per_page * vm.orders_page;
				vm.filtered_orders.forEach(function(val, index, array){
					if( index >= start && index < end ){
						orders.push(val);
					}
				});
				return orders;
			},
			filtered_orders: function(){
				var vm = this;
				var orders = [];
				vm.orders.forEach(function(val, index, array){
					var allow = true;
          if( ! vm.filters.finished && val.finished ){
						allow = false;
					}
          if( vm.filters.search.length > 0 ){
            if( val.title.toLowerCase().search(vm.filters.search.toLowerCase()) ){
              allow = false;
            }
          }
					if( allow ) orders.push( val );
				});
				return orders;
			}
		},
    methods: {
      debounceInput: _.debounce(function (e) {
        this.filters.search = e;
      }, 200),
      filterTerms: function(value, row){
        var vm = this;
        var term_ids = [];
        _.each( row.terms, function(terms){
          _.each( terms, function(t){
            term_ids.push( t.id );
          })
        });
        return term_ids.indexOf( value ) >= 0;
      },
      getOrderStatus: function(status){
        switch ( true ) {
          case status === 'on-hold' : return 'warning'; break;
          case status === 'pending' : return 'warning'; break;
          case status === 'processing' : return 'primary'; break;
          case status === 'completed' : return 'success'; break;
          case status === 'cancelled' : return 'danger'; break;
          case status === 'refunded' : return 'danger'; break;
          case status === 'failed' : return 'danger'; break;
          default : return 'gray';
        }
      },
      getFilterTerms: function(t){
        var vm = this;
        var out = [];
        _.each( vm.terms[t], function(o){
          out.push({
            text: o.name,
            value: o.term_id
          });
        });
        return out;
      },
			filter_var: function( test ){
				return [1,'1', 'yes', true, 'true', 'on'].indexOf( test ) >= 0;
			},
			handleSizeChange: function(val){
				this.orders_per_page = val;
			},
			handleCurrentChange: function(val){
				this.orders_page = val;
			},
			getOrderType: function(order){
				switch ( true ) {
					case order.status === 'canceled' :
						return 'canceled';
						break;
					case order.event.time * 1000 <= moment().utc().valueOf() :
						return 'finished';
						break;
					default: return 'accepted';
				}
			},
			getOrderTagType: function( type ){
				if( type === 'canceled' ) return 'danger';
				if( type === 'accepted' ) return 'success';
				return 'gray';
			},
			getOrderClasses: function(order){
				var vm = this;
				var out = [ 'order' ];
				out.push( 'order--' + vm.getOrderType(order) );
				return out.join( ' ' );
			},
      cancelEvent: function( order, event){
        var vm = this;
        if( confirm('Are you sure you want to cancel this order?') ){
					vm.loading = true;
					vm.buffer.cancel_order = order.id;
        	vm.$http.post( ajaxurl, { order: order }, { emulateJSON: true, params: { action: 'wcs_cancel_order' } } ).then( vm.responseSuccessOrder, vm.responseErrorOrder );
        }
      },
      getAge: function( dob ){
        return Math.round( moment().utc().diff( moment( dob ).utc(), 'years', true ) );
      },
      getOrders: function(){
        var vm = this;
				vm.loading = true;
        vm.$http.get(
          window.EventsSchedule.rest_route + 'weekly-class/v1/bookings/',
          {
            //emulateHTTP: true
            headers: {
              'X-WP-Nonce': window.EventsSchedule.nonce
            },
            params:{
              'start' : vm.query.date_start,
              'end' : vm.query.date_end
            }
          }
        ).then(vm.responseSuccess, vm.responseError);
        //vm.$http.get( ajaxurl, { params: { action: 'wcs_get_trial_bookings', query: vm.query } } ).then( vm.responseSuccess, vm. );
      },
      responseSuccessOrder: function(response){
        var vm = this;

        if( typeof response.body.success !== 'undefined' ){
					vm.orders.forEach(function(val, index, array){
						if( val.id === parseInt( vm.buffer.cancel_order ) ){
							vm.$set( vm.orders[index], 'status', 'canceled' );
							vm.$notify({
			          title: 'Success',
			          message: 'Order has been canceled succesfully.',
			          type: 'success',
			          offset: 40,
			          duration: 2000
			        });
						}
					});
        }
        vm.loading = false;
				vm.buffer.cancel_order = '';
      },
      responseErrorOrder: function(response){
				var vm = this;
        vm.loading = false;
				vm.$notify({
					title: 'Error',
					message: 'Order could not be canceled.',
					type: 'error',
					offset: 40,
					duration: 2000
				});
      },
      responseSuccess: function(response){
        var vm = this;
        if( response.status === 200 ){
          vm.orders = response.body;
          vm.orders_count = response.body.length;
        }
				vm.loading = false;
      },
      responseError: function(response){
				var vm = this;
        vm.loading = false;
      },
      sortByTile: function(a, b){
        if(a.title >= b.title) return true;
        return false;
      },
      sortByDate: function(a, b){
        if( moment( a.date ).isAfter( b.date ) ) return true;
        return false;
      },
      sortByOccupancy: function(a, b){
        if( a.orders_total * 100 / a.capacity >= b.orders_total * 100 / b.capacity ) return true;
        return false;
      },
      sortByBookings: function(a, b){
        if( a.orders_total  >= b.orders_total ) return true;
        return false;
      },
      sortByCapacity: function(a, b){
        if( a.capacity  >= b.capacity ) return true;
        return false;
      },
      getPostUrl: function(id){
        return window.EventsSchedule.urls.edit_post.replace( '%%ID', id );
      },
      getTermUrl: function(slug, id){
        return window.EventsSchedule.urls.edit_term.replace( '%%ID', id ).replace( '%%TAX', slug );
      }
    },
		filters: {
      orderStatus: function(s){
        return s.replace('-', ' ');
      },
			capitalize : function(str){
				return (str + '')
		    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function ($1) {
		      return $1.toUpperCase()
		    });
			}
		}
	});
};
