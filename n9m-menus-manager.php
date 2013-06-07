<?php
/*
Plugin Name: New Nine Menus Manager
Description: Adds a new section in Appearance->Menus to quickly create and delete menus. Menus Manager is MU compatible for single sites and networks.
Version: 1.0
Author: New Nine Media & Advertising
Author URI: http://www.newnine.com
License: GPLv2
Copyright: 2013, New Nine Media LP, 7134 W Grand Avenue, Chicago, IL 60707. Tel: (800) 288-9699. GPLv2: http://www.gnu.org/licenses
*/
defined( 'ABSPATH' ) OR exit;
class NewNineMenuManager{
    function nav_menu_meta_create(){
        add_meta_box( 'n9m_menu_creator', 'Menus Manager', array( $this, 'nav_menu_meta_cb' ), 'nav-menus', 'side', 'high' );
    }
    function nav_menu_meta_cb(){
        $menus = get_option( 'n9m-menus' ) ? get_option( 'n9m-menus' ) : array();
        if( $_GET['action'] ) {
            if( 'n9m-create' == $_GET['action'] ){
                if( !$_GET['menuid'] ){
                    print '<div class="error"><p>The menu location you tried to register is invalid. Please limit your menu location names to letters, numbers, and spaces.</div>';
                } else {
                    $_GET['error'] == 0 ? print '<div class="updated"><p>The menu location <strong>'.$menus[ $_GET['menuid'] ].'</strong> has been registered.</p></div>' : print '<div class="error"><p>That menu location is already in use. Please choose a different name.</p></div>';
                }
            }
            if( 'n9m-delete' == $_GET['action'] ){
                $count = intval( $_GET['count'] );
                switch( $count ){
                    case 0:
                    case '':
                        $result = '<div class="error"><p>You didn&#8217;t select any menus to delete.</p></div>';
                        break;
                    case 1:
                        $result = '<div class="updated"><p>You successfully deleted a menu.</p></div>';
                        break;
                    default:
                        $result = '<div class="updated"><p>You successfully deleted '.number_format( $count, 0 ).' menus.</p></div>';
                }
                print $result;
            }
        }
        print ' <h4>Create a New Menu</h4>
                <p class="howto">Register a new menu / theme location for your website.</p>';
        print ' <form action="" method="post">
                    <p>
                        <label class="howto" for="n9m-menu">
                            <span>Name</span>
                            <input type="text" name="n9m-menu" id="n9m-menu" class="code menu-item-textbox" />
                            <div style="clear: both; height: 1px; font-size: 1px;">&nbsp;</div>
                        </label>
                    </p>
                    <p class="button-controls"><span class="add-to-menu">'.wp_nonce_field( 'menus_nonce_create_action', 'menus_nonce_create' ).'<input type="submit" name="n9m-create" value="Create" class="button-primary" /></span></p>
                </form>';
        $menus_all = get_registered_nav_menus();
        if( $menus_all ){
            print ' <h4>View Menus &amp; Menu IDs</h4>
                    <p class="howto">View all of your menus and (<code>their ids</code>).</p>
                    <ul>';
                foreach( $menus_all as $menus_all_id => $menus_all_name ){
                    print ' <li>'.$menus_all_name.' (<code>'.$menus_all_id.'</code>)</li>';
                }
            print ' </ul>';
            if( $other_menus ){
                print '<p class="howto"><strong>*</strong> Menu not created by the Menu Manager, but by your theme or a plugin.</p>';
            }
        }
        if( $menus ){
            print ' <h4>Delete Menus</h4>
                    <p class="howto">Menus not listed below were created by your theme or a plugin and need to be deleted there.</p>
                    <form action="" method="post">
                        <ul>';
            foreach( $menus as $menu_id => $menu_name ){
                print '<li><label for="'.$menu_id.'"><input type="checkbox" name="menudelete['.$menu_id.']" id="'.$menu_id.'" /> '.$menu_name.'</label></li>';
            }
                print ' </ul>
                        <p class="button-controls"><span class="add-to-menu">'.wp_nonce_field( 'menus_nonce_delete_action', 'menus_nonce_delete' ).'<input type="submit" name="n9m-delete" value="Delete Checked" class="button-secondary" /></span></p>
                    </form>';
        }
    }
    function nav_menu_register(){
        $n9m_menus = get_option( 'n9m-menus' ) ? get_option( 'n9m-menus' ) : array();
        register_nav_menus( $n9m_menus );
        if( $_POST && wp_verify_nonce( $_POST['menus_nonce_create'], 'menus_nonce_create_action' ) ){
            $menu_name = trim( preg_replace( '/[^a-zA-Z0-9\s]/', '', $_POST['n9m-menu'] ) );
            $menu_id = sanitize_title( $menu_name );
            if( empty( $menu_name ) || empty( $menu_id ) ){
                wp_redirect( admin_url( '/nav-menus.php?action=n9m-create&error=1' ) );
            } elseif( !array_key_exists( $menu_id, $n9m_menus ) ){
                $n9m_menus[ $menu_id ] = $menu_name;
                ksort( $n9m_menus );
                update_option( 'n9m-menus', $n9m_menus );
                wp_redirect( admin_url( '/nav-menus.php?action=n9m-create&menuid='.$menu_id.'&error=0' ) );
            } else {
                wp_redirect( admin_url( '/nav-menus.php?action=n9m-create&menuid='.$menu_id.'&error=1' ) );
            }
            exit();
        }
        if( $_POST && wp_verify_nonce( $_POST['menus_nonce_delete'], 'menus_nonce_delete_action' ) ){
            foreach( $_POST['menudelete'] as $menu_id => $status ){
                if( 'on' == $status ){
                    unset( $n9m_menus[ $menu_id ] );
                }
            }
            ksort( $n9m_menus );
            update_option( 'n9m-menus', $n9m_menus );
            wp_redirect( admin_url( '/nav-menus.php?action=n9m-delete&count='.count( $_POST['menudelete'] ) ) );
            exit();
        }
    }
    function __construct(){
        add_action( 'admin_init', array( $this, 'nav_menu_meta_create' ) );
        add_action( 'init', array( $this, 'nav_menu_register' ) );
    }
}
new NewNineMenuManager();
?>