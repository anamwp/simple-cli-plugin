<?php
/**
 * Plugin Name:     Sampleplugin
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     sampleplugin
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Sampleplugin
 */
class ANAM_CLI{
    public function hello_world(){
        WP_CLI::line('Hello World');
    }
    public function generate_posts_progress_bar( $args, $assoc_args ) {

        $desired_posts_to_generate = (int) $args[0];
      
        $progress = \WP_CLI\Utils\make_progress_bar( 'Generating Posts', $desired_posts_to_generate );
      
        for ( $i = 0; $i < $desired_posts_to_generate; $i++ ) {
          // Code used to generate a post.
          $progress->tick();
        }
      
        $progress->finish();
      
    }
    public function generate_posts( $args, $assoc_args ) {

        // Get Post Details.
        $desired_posts_to_generate = (int) $args[0]; // First argument is how many posts should be generated.
        $title_prepend = $args[1]; // Second argument should be the title of posts generated. This will be used with index in loop to generate a title.
        $author_id = (int) $args[2]; // Id of author who to assign generated post to.
      
        $progress = \WP_CLI\Utils\make_progress_bar( 'Generating Posts', $desired_posts_to_generate );
      
        for ( $i = 0; $i < $desired_posts_to_generate; $i++ ) {
      
          // Code used to generate a post.
          $my_post = array(
            'post_title'  => $title_prepend . ' ' . ($i + 1),
            'post_status' => 'publish',
            'post_author' => $author_id,
            'post_type'   => 'post',
            'tags_input'  => [ 'generated' ],
            'meta_input'  => $assoc_args, // Simply passes all key value pairs to posts generated that can be used in testing.
          );
      
          // Insert the post into the database.
          wp_insert_post( $my_post );
      
          $progress->tick();
        }
      
        $progress->finish();
        WP_CLI::success( $desired_posts_to_generate. ' posts generated!' ); // Prepends Success to message
    }
    public function anam_cli_delete_single_post( $args, $assoc_args ){
        
    }
}
function anam_cli_register_command(){
    WP_CLI::add_command('anam', 'ANAM_CLI');
}
add_action('cli_init', 'anam_cli_register_command');