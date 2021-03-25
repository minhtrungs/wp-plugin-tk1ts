<?php
class TLP_Frontend
{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'main_styles' ), 1 );
        add_action( 'wp_enqueue_scripts', array( $this, 'main_scripts' ), 2 );
    }
    public static function render(){
        add_action( 'wp_enqueue_scripts', array( self::class, 'custom_styles' ), 3 );
        add_action( 'wp_enqueue_scripts', array( self::class, 'custom_scripts' ), 4 );
    }

    public function main_styles(){
        wp_enqueue_style( 'tk1ts-bootstrap', TLP_STYLES . '/bootstrap.min.css', array(), TLP_VERSION );
    }

    public function main_scripts(){
        wp_enqueue_script( 'tk1ts-jquery', TLP_SCRIPTS . '/jquery.min.js', array(), TLP_VERSION, true );
    }

    public function custom_styles(){
        wp_enqueue_style( 'tk1ts-main', TLP_STYLES . '/main.css', array(), TLP_VERSION );
        wp_enqueue_style( 'tk1ts-bootstrap', TLP_STYLES . '/bootstrap.min.css', array(), TLP_VERSION );
        wp_enqueue_style( 'tk1ts-font', TLP_STYLES . '/font-awesome.min.css', array(), TLP_VERSION );

        wp_enqueue_style( 'tk1ts-datepicker', TLP_STYLES . '/datepicker.min.css', array(), TLP_VERSION );
        
        wp_enqueue_style( 'tk1ts-auth', TLP_STYLES . '/auth.css', array(), TLP_VERSION );
    }

    public function custom_scripts(){
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'tk1ts-libscripts', TLP_SCRIPTS . '/libscripts.bundle.js', array(), TLP_VERSION, true );
        wp_enqueue_script( 'tk1ts-vendor', TLP_SCRIPTS . '/vendorscripts.bundle.js', array(), TLP_VERSION, true );
        wp_enqueue_script( 'tk1ts-mainscripts', TLP_SCRIPTS . '/mainscripts.bundle.js', array(), TLP_VERSION, true );
                
        wp_enqueue_script( 'tk1ts-datepicker', TLP_SCRIPTS . '/datepicker.js', array(), TLP_VERSION, true );
        wp_enqueue_script( 'tk1ts-moment', TLP_SCRIPTS . '/moment.js', array(), TLP_VERSION, true );
        wp_enqueue_script( 'tk1ts-main', TLP_SCRIPTS . '/main.js', array(), TLP_VERSION, true );
        wp_enqueue_script( 'tk1ts-handle', TLP_SCRIPTS . '/handle.js', array(), TLP_VERSION, true );
    }
}