<?php 
use \Elementor\Controls_Manager;

class Oak_Image extends \Elementor\Widget_Image {
    private $widget_options;

    public function get_name() {
        return 'oak_image';
    }

    public function get_title() {
        return __( 'Oak Images', Oak::$text_domain );
    }

	public function get_icon() {
		return 'eicon-image';
    }

    public function get_categories() {
		return [ 'oak_images' ];
    }

    public function _register_controls() {
        parent::_register_controls();

        $this->start_controls_section(
			'section_oak_image',
			[
				'label' => __( 'Oak Image', 'elementor' ),
			]
        );
        
        $post_images_to_show = get_option('oak_post_images_to_show');
        $options = [ array( '0' => __( 'Aucune image sélectionnée', Oak::$text_domain ) ) ];
        foreach( $post_images_to_show as $image_to_show ) :
            if ( $image_to_show['url'] != '' ) :
                $options = array_merge( $options, array( $image_to_show['url'] => $image_to_show['label'] ) );
			endif;
        endforeach;

        $this->add_control (
			'oak_images',
			[
				'label' => __( 'Oak Images', Oak::$text_domain ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => $options
			]
		);
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $post_images_to_show = get_option('oak_post_images_to_show');
        $options = [];
        foreach( $post_images_to_show as $image_to_show ) :
            if ( $image_to_show['url'] != '' ) :
                $options = array_merge( $options, array( $image_to_show['url'] => $image_to_show['label'] ) );
			endif;
        endforeach;
	}


    protected function _content_template() {
		?>
		<#
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

            var actual_image_url = settings.oak_images;
			var image_url = 'http://localhost:8888/test/wp-content/uploads/2019/05/Gilles-Pelisson-TF1.jpg';

			if ( ! image_url ) {
				return;
			}

			var hasCaption = function() {
				if( ! settings.caption_source || 'none' === settings.caption_source ) {
					return false;
				}
				return true;
			}

			var ensureAttachmentData = function( id ) {
				if ( 'undefined' === typeof wp.media.attachment( id ).get( 'caption' ) ) {
					wp.media.attachment( id ).fetch().then( function( data ) {
						view.render();
					} );
				}
			}

			var getAttachmentCaption = function( id ) {
				if ( ! id ) {
					return '';
				}
				ensureAttachmentData( id );
				return wp.media.attachment( id ).get( 'caption' );
			}

			var getCaption = function() {
				if ( ! hasCaption() ) {
					return '';
				}
				return 'custom' === settings.caption_source ? settings.caption : getAttachmentCaption( settings.image.id );
			}

			var link_url;

			if ( 'custom' === settings.link_to ) {
				link_url = settings.link.url;
			}

			if ( 'file' === settings.link_to ) {
				link_url = settings.image.url;
			}

			#><div class="elementor-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }}"><#
			var imgClass = '';

			if ( '' !== settings.hover_animation ) {
				imgClass = 'elementor-animation-' + settings.hover_animation;
			}

			if ( hasCaption() ) {
				#><figure class="wp-caption"><#
			}

			if ( link_url ) {
					#><a class="elementor-clickable" data-elementor-open-lightbox="{{ settings.open_lightbox }}" href="{{ link_url }}"><#
			}
						#><img src="{{ actual_image_url }}" class="{{ imgClass }}" /><#

			if ( link_url ) {
					#></a><#
			}

			if ( hasCaption() ) {
					#><figcaption class="widget-image-caption wp-caption-text">{{{ getCaption() }}}</figcaption><#
			}

			if ( hasCaption() ) {
				#></figure><#
			}

			#></div><#
        #>
		<?php
	}
}
