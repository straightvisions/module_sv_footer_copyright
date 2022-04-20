<?php
	namespace sv100;

	class sv_footer_copyright extends init {
		public function init() {
			$this->set_module_title( __( 'SV Footer Copyright', 'sv100' ) )
				->set_module_desc( __( 'Manages the footer copyright bar.', 'sv100' ) )
				->set_css_cache_active()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_template_path()
				->set_section_order(4100)
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 15.781c-2.084 0-3.781-1.696-3.781-3.781s1.696-3.781 3.781-3.781c1.172 0 2.306.523 3.136 1.669l1.857-1.218c-1.281-1.826-3.133-2.67-4.993-2.67-3.308 0-6 2.692-6 6s2.691 6 6 6c1.881 0 3.724-.859 4.994-2.67l-1.857-1.218c-.828 1.14-1.959 1.669-3.137 1.669z"/></svg>')
				->get_root()
				->add_section( $this );

			add_action('init', function(){
				$this->load_settings()->add_metaboxes();
			});
		}
		protected function load_settings(): sv_footer_copyright {
			// General
			$this->get_setting( 'max_width' )
				->set_title( __( 'Max Width', 'sv100' ) )
				->set_description( __( 'Set the max width of the Header', 'sv100' ) )
				->set_options( $this->get_module('sv_common') ? $this->get_module('sv_common')->get_max_width_options() : array('' => __('Please activate module SV Common for this Feature.', 'sv100')) )
				->set_default_value( '1300px' )
				->set_is_responsive( true )
				->load_type( 'select' );

			$this->get_setting( 'bg_color' )
				->set_title( __( 'Background Color', 'sv100' ) )
				->set_default_value( '41,43,45,1' )
				->set_is_responsive( true )
				->load_type( 'color' );

			$this->get_setting( 'sidebar' )
				->set_title( __( 'Sidebar', 'sv100' ) )
				->set_description( __( 'Select Sidebar for this position.', 'sv100' ) )
				->set_options( $this->get_module('sv_sidebar') ? $this->get_module('sv_sidebar')->get_sidebars_for_settings_options() : array('' => __('Please activate module SV Sidebar for this Feature.', 'sv100')) )
				->load_type( 'select' );

			return $this;
		}

		public function has_sidebar_content(): bool {
			if ( !$this->get_module( 'sv_sidebar' ) ) {
				return false;
			}

			if( $this->get_module( 'sv_sidebar' )->load( $this->get_metabox_data('sidebar') ) ) {
				return true;
			}

			return false;
		}

		public function load( $settings = array() ): string {
			$output		= '';
			if(!is_admin()){
				$this->load_settings();

				if ( $this->has_sidebar_content() ) {
					$this->register_scripts();

					ob_start();
					require ( $this->get_path('lib/tpl/frontend/default.php' ) );
					$output							= ob_get_clean();

					foreach($this->get_scripts() as $script){
						$script->set_is_enqueued();
					}
				}else{
					$this->get_script( 'credits' )->set_is_enqueued();
				}
			}
			return $output;
		}
		private function add_metaboxes(): sv_footer_copyright{
			$this->metaboxes			= $this->get_root()->get_module('sv_metabox');

			$states						= $this->get_module('sv_sidebar') ? $this->get_module('sv_sidebar')->get_sidebars_for_metabox_options() : array('' => __('Please activate module SV Sidebar for this Feature.', 'sv100'));

			$this->metaboxes->get_setting( $this->get_prefix('sidebar') )
				->set_title( __('Sidebar Footer Copyright', 'sv100') )
				->set_description( __('Override Default Settings', 'sv100') )
				->load_type( 'select' )
				->set_options($states);

			return $this;
		}
		public function show_sidebar(): string{
			return $this->has_sidebar_content() ? $this->get_metabox_data('sidebar') : '';
		}
	}