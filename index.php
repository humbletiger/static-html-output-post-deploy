<?php
   
/**
 * Plugin Name: Static HTML Output Post Deploy Rewrite
 * Plugin URI:  https://github.com/EricP/static-html-output-post-deploy
 * Description: For use with Static HTML Output plugin. No settings required.
 * Version:     1.0.0
 * Author:      Eric Pecoraro
 * Author URI:  https://github.com/EricP
 * Text Domain: static-html-output-post-deploy-rewrite
 * License:     Unlicense
 * 
 */

function statichtmloutput_post_deploy_rewrite($archive) {

    $log = true;
	
	$settings = $archive->settings;
	$post=$GLOBALS['_POST'];
	$log_path = $settings['wp_uploads_path'].'/post-deploy-rewrite.txt';

    $rewrite_rules = explode("\n",str_replace( "\r", '', $post['rewrite_rules']));
    foreach ( $rewrite_rules as $rewrite_rule_line ) {
        list($from, $to) = explode( ',', $rewrite_rule_line);
        $rewrite_from[] = $from;
        $rewrite_to[] = $to;
    }
	
	$files_dir = rtrim($archive->path,'/');
	$files = glob("$files_dir/{,*/,*/*/,*/*/*/,*/*/*/*/,*/*/*/*/*/,*/*/*/*/*/*/,*/*/*/*/*/*/*/}*{.html,.txt,.xml}", GLOB_BRACE);
	
	// Iterate through static output and do replacements
	foreach ( $files as $file ) {
	    $contents = file_get_contents($file);
	    $cnt=0;
	    foreach ( $rewrite_from as $i ) {
			$from = $rewrite_from[$cnt];
	        $to = $rewrite_to[$cnt];
	        $contents = str_replace($from,$to,$contents);
	        $cnt++;
			$fm_arr[]=$from;
			$to_arr[]=$to;
	    }
	    file_put_contents($file,$contents);
	    if ( strstr($file,'static-html-output/index.html') ) {
	       $log_content_index = $contents; 
	    }
	}
	
	file_put_contents($log_path,""); // clear log, regardless
	if ( $log ) {
	    $log_content = 'REWRITE FROM: '.print_r($rewrite_from,true)."\n";
	    $log_content.= 'REWRITE TO: '.print_r($rewrite_to,true)."\n";
	    $log_content.= 'POST: '.print_r($GLOBALS['_POST'],true)."\n";
	    $log_content = preg_replace('/\[s3Secret\](.*) (.*)/i', '[s3Secret] => ***REDACTED***',$log_content);
	    $log_content.= 'FILES PROCESSED: '.print_r($files,true)."\n";
	    $log_content.= 'STATIC HTML OUTPUT $active object: '.print_r($archive,true)."\n";
	    $log_content.= "INDEX.HTML CONTENT: \n\n".$log_content_index."\n";
	    file_put_contents($log_path,$log_content);
	}

}

add_filter( 'statichtmloutput_post_deploy_trigger', 'statichtmloutput_post_deploy_rewrite' );

