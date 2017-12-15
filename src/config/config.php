<?php

return [
    'themes' => [
        /**
         * Absolute paths as to where stylist can discover themes.
         */
        'paths' => [

        ],

        /**
         * Specify the name of the theme that you wish to activate. This should be the same
         * as the theme name that is defined within that theme's json file.
         */
        'activate' => null,
	    
    ],
	
	'cache-break' => [
		
		/**
		 * Possible values:
		 * auto     add hashes only to css and js assets
		 * all      add hashes to all assets
		 * manual   add hash only to specified assets: /path/to/scripts.js?cache-break
		 * off      disable cache break
		 */
		'activate' => 'auto',
		
		/**
		 * Default method for cache breaking
		 * It can be overridden manually per asset: /path/to/scripts.js?cache-break=manifest
		 *
		 * Supported methods:
		 * manifest     will look for manifest file in theme's root and add hashes to resource urls
		 * timestamp    hash file's last_modified timestamp
		 */
		'method' => 'manifest',
		
		/**
		 * Manifest filename (relevant only if method is 'manifest')
		 */
		'manifest' => 'manifest.json'
	
	],
];
