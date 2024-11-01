<?php

     /**
      * Functions used by plugins
      */
     if (!class_exists('wcpz_Dependencies'))
	 require_once 'class-wcpz-dependencies.php';

     /**
      * WC Detection
      */
     if (!function_exists('is_woocommerce_active')) {

	 function is_woocommerce_active() {
	     return wcpz_Dependencies::woocommerce_active_check();
	 }

     }

