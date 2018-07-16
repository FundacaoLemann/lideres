<?php


class WCS_Bookings {

	function __construct(){

		add_action( 'admin_menu', array( $this, 'bookings_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

	}


	function load_assets(){

		$screen = get_current_screen();

		if( $screen->base !== 'class_page_wcs_bookings' )
			return;

			wp_register_style( 'themify-icons', plugins_url() . '/weekly-class/assets/libs/themify/themify-icons.css' );
			wp_register_style( 'element-ui', plugins_url() . '/weekly-class/assets/libs/element-ui/index.css', null, '1.4.8' );
			wp_register_style( 'wcs-bookings', plugins_url() . '/weekly-class/assets/admin/css/bookings.css', array( 'element-ui', 'themify-icons' ), rand() );

      if( ! wp_script_is( 'vue-js', 'registered' ) ) wp_register_script( 'vue-js', plugins_url() . '/weekly-class/assets/libs/vue/vue.js', array( 'jquery' ), null, true );
      if( ! wp_script_is( 'vue-resource', 'registered' ) ) wp_register_script( 'vue-resource', plugins_url() . '/weekly-class/assets/libs/vue/vue-resource.min.js', array( 'vue-js' ), null, true );
      if( ! wp_script_is( 'moment-js', 'registered' ) ) wp_register_script( 'moment-js', plugins_url() . '/weekly-class/assets/libs/moment/moment.js', array( 'vue-js' ), null, true );
      if( ! wp_script_is( 'element-ui', 'registered' ) ) wp_register_script( 'element-ui', plugins_url() . '/weekly-class/assets/libs/element-ui/index.js', array( 'vue-js' ), null, true );
			if( ! wp_script_is( 'lodash', 'registered' ) ) wp_register_script( 'lodash', plugins_url() . '/weekly-class/assets/libs/lodash/lodash.js', array( 'vue-js' ), null, true );

			wp_register_script( 'wcs-bookings', plugins_url() . '/weekly-class/assets/admin/js/min/bookings-min.js', array( 'jquery', 'vue-resource', 'element-ui', 'moment-js', 'lodash', 'vue-js' ), rand() );

			$content = array();
			$taxes = WeeklyClass::get_object_taxonomies( 'class', 'objects' );
			foreach( $taxes as $tax =>$tax_value ){
				$content[$tax] = array();
				$terms = get_terms( $tax, array( 'hide_empty' => true ) );
				foreach($terms as $term){
					$content[$tax][] = $term;
				}
			}


			wp_localize_script( 'wcs-bookings', 'EventsSchedule', array(
				'rest_route' => esc_url_raw( get_rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'locale_element_ui' => array( 'el' => apply_filters( 'wcs_locale_element_ui', array() ) ),
				'taxonomies' => $taxes,
				'terms' => $content,
				'urls' => array(
					'edit_post' => add_query_arg( array( 'post' => '%%ID', 'action' => 'edit' ), admin_url( 'post.php' ) ),
					'edit_term' => add_query_arg( array( 'taxonomy' => '%%TAX', 'tag_ID' => '%%ID', 'post_type' => 'class' ), admin_url( 'term.php' ) ),
					'edit_user' => add_query_arg( array( 'user_id' => '%%ID'  ), admin_url( 'user-edit.php' ) ),
				)
			) );

	}


	function bookings_page(){
		add_submenu_page( 'edit.php?post_type=class', __( 'Events Schedule Bookings', 'WeeklyClass' ), __( 'Bookings', 'WeeklyClass' ), 'manage_options', 'wcs_bookings', array( $this, 'bookings_page_hook' ) );
	}

	function bookings_page_hook(){

		wp_enqueue_style( 'wcs-bookings' );
		wp_enqueue_script( 'wcs-bookings' );

		?>

    <div class="wrap">
      <div id="wcs-bookings__app" v-cloak>
				<h1><?php esc_html_e( 'Classes Bookings', 'WeeklyClass' ) ?></h1>
        <el-row :gutter="20">
					<el-col :span="5">
						<el-input placeholder="<?php esc_html_e( 'Search by class name', 'WeeklyClass' ) ?>" v-on:input="debounceInput"></el-input>
          </el-col>
					<el-col :span="3">
						<el-date-picker
              v-model="date_range"
              type="daterange"
              placeholder="<?php esc_html_e( 'Pick a range', 'WeeklyClass' ) ?>"
              :picker-options="datepiker_options">
            </el-date-picker>
					</el-col>

          <el-col :span="16" class="header-options">
            <label>
              <el-switch
                v-model="filters.finished"
                on-color="#13ce66"
                off-color="#ff4949">
              </el-switch>
              <?php esc_html_e( 'Show Finished', 'WeeklyClass' ) ?>
            </label>
          </el-col>
      </el-row>
      <div v-loading="loading">
        <el-table border :data="tableData" class="main-table" empty-text="<?php esc_html_e( 'No bookings to show', 'WeeklyClass' ) ?>">

					<el-table-column
						prop="class"
						label="<?php esc_html_e( 'Class', 'WeeklyClass' ) ?>" sortable :sort-method="sortByTile">
						<template scope="scope">
							<a :href="getPostUrl(scope.row.id)">{{scope.row.title}}</a>
						</template>
					</el-table-column>
					<el-table-column
						prop="date"
						label="<?php esc_html_e( 'Starting', 'WeeklyClass' ) ?>" sortable :sort-method="sortByDate" width="170">
						<template scope="scope">
							{{scope.row.start | moment('YYYY-MM-DD - HH:mm') }}
						</template>
					</el-table-column>

					<el-table-column v-for="tax in taxonomies" :prop="tax.rewrite.slug" :label="tax.label" filter-multiple :filter-method="filterTerms" :filters="getFilterTerms(tax.rewrite.slug)" filter-placement="bottom">
						<template scope="scope">
							<template v-for="(term, key) in scope.row.terms[tax.rewrite.slug.replace('-','_')] "><template v-if="key !== 0">, </template><a :href="getTermUrl(tax.rewrite.slug, term.id)">{{term.name}}</a></template>
						</template>
					</el-table-column>

					<el-table-column
						prop="orders"
						label="<?php esc_html_e( 'Occupancy', 'WeeklyClass' ) ?>" sortable width="160" :sort-method="sortByOccupancy">
						<template scope="scope">
							<el-progress :stroke-width="10" :percentage="Math.round( scope.row.orders_total * 100 / scope.row.capacity )"></el-progress>
						</template>
					</el-table-column>

					<el-table-column
						prop="orders"
						label="<?php esc_html_e( 'Bookings', 'WeeklyClass' ) ?>" width="130" sortable :sort-method="sortByBookings" align="right" header-align="right">
						<template scope="scope">
							{{scope.row.orders_total }}
						</template>
					</el-table-column>

					<el-table-column
						prop="orders"
						label="<?php esc_html_e( 'Capacity', 'WeeklyClass' ) ?>" width="130" sortable  :sort-method="sortByCapacity" align="right" header-align="right">
						<template scope="scope">
							{{scope.row.capacity }}
						</template>
					</el-table-column>

					<el-table-column type="expand">
			      <template scope="props">
			        <el-table :data="props.row.orders" style="width: 100%">
								<el-table-column
									prop="id"
									label="<?php esc_html_e( 'ID', 'WeeklyClass' ) ?>" width="110">
									<template scope="scope">
										<a :href="getPostUrl(scope.row.id)">#{{scope.row.id}}</a>
									</template>
								</el-table-column>
								<el-table-column
									prop="status"
									label="<?php esc_html_e( 'Status', 'WeeklyClass' ) ?>" width="120" class-name="order-status" sortable>
									<template scope="scope">
										<el-tag :type="getOrderStatus(scope.row.status)">{{scope.row.status | orderStatus }}</el-tag>
									</template>
								</el-table-column>
								<el-table-column
									prop="date.date"
									label="<?php esc_html_e( 'Order Date', 'WeeklyClass' ) ?>" width="160" sortable>
									<template scope="scope">
										{{scope.row.date.date | moment('YYYY-MM-DD - HH:mm', false) }}
									</template>
								</el-table-column>
								<el-table-column
									prop="first_name"
									label="<?php esc_html_e( 'Full Name', 'WeeklyClass' ) ?>" sortable>
									<template scope="scope">
										{{scope.row.first_name}} {{scope.row.last_name}}
									</template>
								</el-table-column>
								<el-table-column
									prop="email"
									label="<?php esc_html_e( 'Email', 'WeeklyClass' ) ?>">
									<template scope="scope">
										<a :href="'mailto:' + scope.row.email">{{scope.row.email}}</a>
									</template>
								</el-table-column>
								<el-table-column
									prop="phone"
									label="<?php esc_html_e( 'Phone', 'WeeklyClass' ) ?>" width="180">
									<template scope="scope">
										{{scope.row.phone}}
									</template>
								</el-table-column>
								<el-table-column
									prop="qty"
									label="<?php esc_html_e( 'Quantity', 'WeeklyClass' ) ?>" width="130" align="right" header-align="right" sortable>
									<template scope="scope">
										{{scope.row.qty}}
									</template>
								</el-table-column>
							</el-table>
			      </template>
			    </el-table-column>
          </el-table>

          <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :page-sizes="[10, 25, 50, 100, 250]"
            :page-size="orders_per_page"
            layout="total, sizes, prev, pager, next, jumper"
            :total="orders.length">
          </el-pagination>
        </div>
      </div>
    </div>
		<?php

	}


}

new WCS_Bookings();


?>
