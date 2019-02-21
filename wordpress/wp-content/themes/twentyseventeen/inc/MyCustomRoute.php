<?php
add_action('rest_api_init', function () {
    $latest_posts_controller = new MyCustomRoute();
    $latest_posts_controller->register_routes();
});


class MyCustomRoute extends WP_REST_Controller {

    public function register_routes() {
        $version = '1';
        $namespace = 'my-route/v' . $version;

        register_rest_route( $namespace, '/' . 'search',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_items' ),
                'args'                => array(
                    'id'
                ),
            )
        );
        register_rest_route($namespace,'/' . 'update',
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'update_item'),
            )
         );
        register_rest_route( $namespace, '/' . 'create',
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'create_item' ),
                'args'                => array(
                    'id'
                ),
            )
        );
        register_rest_route($namespace,'/' . 'delete' . '/(?P<id>[\d]+)',
            array(
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => array( $this, 'delete_item'),
            )
        );
    }

    public function get_items( $request ) {
        $query = new WP_Query( array( 'p' => 'any' ) );
        return new WP_REST_Response( $query->posts,200);
    }

    public function update_item( $request ) {
        global $wpdb;
        if(empty($request)){
            return new WP_REST_Response('empty',200);
        }
        $wpdb->update( 'wp_posts',
            array( 'post_content' => $request['post_content'], 'post_title' => $request['post_title'] ),
            array ( 'id' => $request['id'] ),
            array( '%s', '%s' ),
            array( '%d' ));

        return new WP_REST_Response(true,200);
    }

    public function create_item( $request ) {
        global $wpdb;
        if(empty($request)){
            return new WP_REST_Response('empty',200);
        }

        $wpdb->insert( 'wp_posts',
            array( 'post_content' => $request['content'],
                'post_title' => $request['title'],
                'post_date' => date("Y-m-d H:i:s")
            ),
            array( '%s', '%s' ));
        return new WP_REST_Response(true,201);
    }

    public function delete_item( $request ) {
        global $wpdb;
        if(empty($request)){
            return new WP_REST_Response('empty',200);
        }

        $wpdb->delete( 'wp_posts',
              array ( 'id' => $request['id'] ));
        return new WP_REST_Response(true,200);
    }
}