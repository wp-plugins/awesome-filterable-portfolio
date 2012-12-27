<?php

/*
Plugin Name: Awesome Filterable Portfolio
Plugin URI: http://brinidesigner.com/wordpress-plugins/awesome-filterable-portfolio/?utm_source=AFP&utm_medium=AFP&utm_campaign=AFP
Description: Awesome Filterable Portfolio allows you to create a portfolio that you can filter its elements using smooth animations.
Version: 1.5
Author: BriniA
Author URI: http://brinidesigner.com/?utm_source=AFP&utm_medium=AFP&utm_campaign=AFP

Copyright 2012  BriniA  (email : contact@brinidesigner.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Registering Scripts & Styles for the Admin
function afp_enqeue_scripts(){
	if (get_current_screen()->id == 'portfolio-items_page_afp_add_new_portfolio_item'){
		wp_register_style('datepicker-style', '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/jquery-ui-datepicker.css');
		wp_enqueue_style('datepicker-style');
		wp_register_script('afp-admin-functions', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/afp-admin-functions.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('afp-admin-functions');
	}
}
add_action('admin_enqueue_scripts', 'afp_enqeue_scripts');

//Creating the menu
function afp_portfolio_items_page(){
	afp_get_potfolio_items_page();
}

function afp_portfolio_items_page_menu(){
	add_menu_page( 'Awesome Filterable Portfolio', 'Portfolio Items', 'manage_options', 'afp', 'afp_portfolio_items_page', path_join(WP_PLUGIN_URL, basename(dirname(__FILE__)).'/af-portfolio-icon.png'), 100 );
}
add_action( 'admin_menu', 'afp_portfolio_items_page_menu' );

function afp_add_new_page(){
	afp_get_new_portfolio_item_page();
}

function afp_add_new_page_menu(){
	add_submenu_page( 'afp', 'Add New', 'Add New Item', 'manage_options', 'afp_add_new_portfolio_item', 'afp_add_new_page' );
}
add_action( 'admin_menu', 'afp_add_new_page_menu' );

function afp_categories_page(){
	afp_get_categories_page();
}

function afp_categories_page_menu(){
	add_submenu_page( 'afp', 'Categories List', 'Categories List', 'manage_options', 'afp_categories', 'afp_categories_page' );

}
add_action( 'admin_menu', 'afp_categories_page_menu' );


function afp_add_new_category_page(){
	afp_get_new_category_page();
}

function afp_add_new_category_page_menu(){
	add_submenu_page( 'afp', 'Add New Category', 'Add New Category', 'manage_options', 'afp_add_new_category', 'afp_add_new_category_page' );

}
add_action( 'admin_menu', 'afp_add_new_category_page_menu' );

//ADMIN USER INTERFACE

//END ADMIN USER INTERFACE
function afp_help_meta_box(){
	?>
		<div class="inner-sidebar">
			<div class="postbox">
				<h3><span>Need help?</span></h3>
				<div class="inside">
                	<p>Watch this <a href="http://brinidesigner.com/wordpress-plugins/awesome-filterable-portfolio/video/?utm_source=AFP&utm_medium=AFP&utm_campaign=AFP">Video Tutorial</a></p>
					<p>Read the plugin's <a href="http://brinidesigner.com/wordpress-plugins/awesome-filterable-portfolio/docs/?utm_source=AFP&utm_medium=AFP&utm_campaign=AFP">Documentation</a></p>
                    <hr />
					<p>For more cool stuff <a href="http://brinidesigner.com/?utm_source=AFP&utm_medium=AFP&utm_campaign=AFP">visit the author's website</a></p>
				</div>
			</div>
		</div> <!-- .inner-sidebar -->
	<?php
}

function afp_get_new_portfolio_item_page(){
	global $wpdb;
	?>
<div class="wrap">
	<?php if(!isset($_GET['item_id'])) { ?>
	<h2><?php _e('Add New Portfolio Item'); ?></h2>
	<div class="metabox-holder has-right-sidebar">
		<?php afp_help_meta_box(); ?>	
		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox">
					<h3><span><?php _e('Add New Portfolio Item'); ?></span></h3>
					<div class="inside">
					<form action="#" method="post" enctype="multipart/form-data">
						  <p>
							<label for="title"><b><?php _e('Project Name :'); ?></b></label><br>
							<input type="text" name="title" id="title" class="regular-text"><br>
						  </p>
						  <p>
							<label for="client"><b><?php _e('Client :'); ?></b></label><br>
							<input type="text" name="client" id="client" class="regular-text">
						  </p>
						  <p>
							<label for="date"><b><?php _e('Date :'); ?></b></label><br>
							<input type="text" name="date" id="date"><br />
                            <span class="description"><?php _e('The date when the project was created. If left empty no date will be displayed'); ?></span>
						  </p>
						  <p>
							<label for="link"><b><?php _e('Project Link :'); ?></b></label><br>
							<input type="text" name="link" id="link" class="regular-text"><br>
							<span class="description"><?php _e('Add a URL to your project. If left empty no date will be displayed'); ?></span>
						  </p>
						  <p>
							<label for="category"><b><?php _e('Category :'); ?></b></label><br>
							<select name="category" id="category" >
							  <?php $cats = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_categories');
							  foreach ($cats as $cat){
							  ?>
							  <option value="<?php echo($cat->cat_name); ?>"><?php echo($cat->cat_name); ?></option>
							  <?php
							  }
							  ?>
							</select>
						  </p>
						  <p>
							<label for="thumbnail"><b><?php _e('Thumbnail'); ?></b></label><br />
							<input type="text" name="thumbnail_adr" id="thumbnail_adr" class="regular-text" /><input type="button" name="thumbnail" id="thumbnail" class="button-secondary" value="<?php _e('Upload Thumbnail'); ?>" /><br />
							<span class="description"><?php _e('This is thumbnail image. You should use small thumbnails for preview purposes'); ?></span>
						  </p>
						  <p>
							<label for="image"><b><?php _e('Image'); ?></b></label><br />
							<input type="text" name="image_adr" id="image_adr" class="regular-text" /><input type="button" name="image" id="image" class="button-secondary" value="<?php _e('Upload Image'); ?>" /><br />
							<span class="description"><?php _e('This is the image that will be displayed when you show the project details.'); ?></span>
						  </p>
						  <p>
							<label for="description"><b><?php _e('Description :'); ?></b></label><br>
							<textarea name="description" id="description" cols="100" rows="10"></textarea>
						  </p>
						  <input type="hidden" name="which" id="which" value="new_portfolio_item"/>
						  <input type="submit" value="<?php _e('Save New Portfolio Item'); ?>" class="button-primary">
						</form>
					</div> <!-- .inside -->
				</div>
			</div> <!-- #post-body-content -->
		</div> <!-- #post-body -->

	</div> <!-- .metabox-holder -->
	<?php } else { 
	$item_id = $_GET['item_id'];
	$msg = $_GET['msg'];
	global $wpdb;
	$item = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'afp_items WHERE item_id=' . $item_id);
	?>
	<h2><?php _e('Edit Portfolio Item'); ?></h2>
	<?php if(isset($msg)){ ?><div style="padding: 5px" class="updated"><b><?php if ($msg=='added') { _e('Portfolio Item added successfully'); } else { _e('Portfolio Item edited successfully'); } ?></b></div><?php } ?>
	<div class="metabox-holder has-right-sidebar">
		<?php afp_help_meta_box(); ?>

		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox">
					<h3><span><?php _e('Edit Portfolio Item'); ?></span></h3>
					<div class="inside">
					<form action="#" method="post" enctype="multipart/form-data">
						  <p>
							<label for="title"><b><?php _e('Project Name :'); ?></b></label><br>
							<input type="text" name="title" id="title" class="regular-text" value="<?php echo($item->item_title); ?>"><br>
						  </p>
						  <p>
							<label for="client"><b><?php _e('Client :'); ?></b></label><br>
							<input type="text" name="client" id="client" class="regular-text" value="<?php echo($item->item_client); ?>">
						  </p>
						  <p>
							<label for="date"><b><?php _e('Date :'); ?></b></label><br>
							<input type="text" name="date" id="date" value="<?php if($item->item_date =='0000-00-00') { echo(''); } else { echo(date("m/d/Y", strtotime($item->item_date))); } ?>"><br />
                            <span class="description"><?php _e('The date when the project was created. If left empty no date will be displayed'); ?></span>
						  </p>
						  <p>
							<label for="link"><b><?php _e('Project Link :'); ?></b></label><br>
							<input type="text" name="link" id="link" class="regular-text" value="<?php echo($item->item_link); ?>"><br>
							<span class="description"><?php _e('Add a URL to your project. If left empty no date will be displayed'); ?></span>
						  </p>
						  <p>
							<label for="category"><b><?php _e('Category :'); ?></b></label><br>
							<select name="category" id="category" >
							  <?php $cats = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_categories');
							  foreach ($cats as $cat){
							  ?>
							  <option value="<?php echo($cat->cat_name); ?>"><?php echo($cat->cat_name); ?></option>
							  <?php
							  }
							  ?>
							</select>						  </p>
						  <p>
							<label for="thumbnail"><b><?php _e('Thumbnail'); ?></b></label><br />
							<input type="text" name="thumbnail_adr" id="thumbnail_adr" class="regular-text" value="<?php echo($item->item_thumbnail); ?>" /><input type="button" name="thumbnail" id="thumbnail" class="button-secondary" value="<?php _e('Upload Thumbnail'); ?>" /><br />
							<span class="description"><?php _e('This is thumbnail image. You should use small thumbnails for preview purposes'); ?></span>
						  </p>
						  <p>
							<label for="image"><b><?php _e('Image'); ?></b></label><br />
							<input type="text" name="image_adr" id="image_adr" class="regular-text" value="<?php echo($item->item_image); ?>"/><input type="button" name="image" id="image" class="button-secondary" value="<?php _e('Upload Image'); ?>" /><br />
							<span class="description"><?php _e('This is the image that will be displayed when you show the project details.'); ?></span>
						  </p>
						  <p>
							<label for="description"><b><?php _e('Description :'); ?></b></label><br>
							<textarea name="description" id="description" cols="100" rows="10"><?php echo($item->item_description); ?></textarea>
						  </p>
						  <input type="hidden" name="item_id" id="item_id" value="<?php echo($item_id); ?>"/>
						  <input type="hidden" name="which" id="which" value="update_portfolio_item"/>
						  <input type="submit" value="<?php _e('Save Portfolio Item'); ?>" class="button-primary">
						</form>
					</div> <!-- .inside -->
				</div>
			</div> <!-- #post-body-content -->
		</div> <!-- #post-body -->

	</div> <!-- .metabox-holder -->
	?>
</div> <!-- .wrap -->
<?php
}
}

function afp_get_potfolio_items_page(){
	global $wpdb;
	?>
<div class="wrap">
	<?php 
	$item_id = $_GET['item_id'];
	$action=$_GET['action'];
	if( $action=='' || $action=='delete' ){ 
	if ($action=='delete') { $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'afp_items WHERE item_id=' . $item_id); }
	?>
	<h2><?php _e('Portfolio Items '); ?><a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=afp_add_new_portfolio_item" title="" class="add-new-h2">Add New</a></h2>
	<?php $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_items');
	if ( $items == null ) { 
	?>
	You don't have any portfolio item. Please <a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=afp_add_new_portfolio_item" title="">Add a New Item</a>
	<?php
	} else {
	?>
	<table class="widefat">
		<thead>
			<tr>
            	<th width="120px">Thumbnail</th>
				<th class="row-title">Title</th>
				<th>Client</th>
				<th>Date</th>
				<th>Link</th>
				<th>Category</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $items as $item ) {
			echo('<tr>
					<td><div style="background: url('.$item->item_thumbnail.') center; background-size: cover; width: 100px; height: 100px;"></div></td>
					<td class="title column-title">
						<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_portfolio_item&item_id=' . $item->item_id . '"><b>' . $item->item_title . '</b></a>
						<div class="row-actions">
							<span class="edit"><a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_portfolio_item&item_id=' . $item->item_id . '">Edit</a></span> |
							<span class="submitdelete"><a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp&action=confirm&item_id=' . $item->item_id . '">Delete</a></span>
						</div>
					</td>
					<td>' . $item->item_client . '</td>
					<td>' . date("m/d/Y", strtotime($item->item_date)) . '</td>
					<td>' . $item->item_link . '</td>
					<td>' . $item->item_category . '</td>
				</tr>');
		}
		?>
		</tbody>
		<tfoot>
			<tr>
            	<th width="120px">Thumbnail</th>
				<th class="row-title">Title</th>
				<th>Client</th>
				<th>Date</th>
				<th>Link</th>
				<th>Category</th>
			</tr>
		</tfoot>
	</table>
	<?php
	}
	} elseif( $action == 'confirm' ){
		?>
		<h2>Delete Confirmation</h2>
		<h3>Are you sure you want to delete this portfolio item?</h3>
		<a class="button-primary" href="<?php echo( get_bloginfo('url') . '/wp-admin/admin.php?page=afp&action=delete&item_id=' . $item_id ); ?>"><?php _e( 'Delete' ); ?></a> 
		<a class="button-secondary" href="<?php echo( get_bloginfo('url') . '/wp-admin/admin.php?page=afp'); ?>"><?php _e( 'Cancel' ); ?></a> 
		<?php
	}
}

function afp_get_new_category_page(){
	if (!isset($_GET['cat_id'])){
	?>
<div class="wrap">

	<h2><?php _e('Add New Category'); ?></h2>

	<div class="metabox-holder has-right-sidebar">
		<?php afp_help_meta_box(); ?>	
		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox">
					<h3><span><?php _e('Add New Category'); ?></span></h3>
					<div class="inside">
					<form action="#" method="post" enctype="multipart/form-data">
						  <p>
							<label for="title"><b><?php _e('Category name :'); ?></b></label><br>
							<input type="text" name="title" id="title" class="regular-text"><br>
						  </p>
						  <p>
							<label for="description"><b><?php _e('Description :'); ?></b></label><br>
							<textarea name="description" id="description" cols="100" rows="10"></textarea>
						  </p>
						  <input type="hidden" name="which" id="which" value="new_category"/>
						  <input type="submit" value="<?php _e('Save New Category'); ?>" class="button-primary">
						</form>
					</div> <!-- .inside -->
				</div>
			</div> <!-- #post-body-content -->
		</div> <!-- #post-body -->

	</div> <!-- .metabox-holder -->
</div> <!-- .wrap -->
<?php
}else{
	$cat_id = $_GET['cat_id'];
	$msg = $_GET['msg'];
	global $wpdb;
	$cat = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'afp_categories WHERE cat_id=' . $cat_id);
	?>
<div class="wrap">

	<h2><?php _e('Edit Category'); ?></h2>
	<?php if(isset($msg)){ ?><div style="padding: 5px" class="updated"><b><?php if ($msg=='added') { _e('Category added successfully'); } else { _e('Category edited successfully'); } ?></b></div><?php } ?>
	<div class="metabox-holder has-right-sidebar">
	<?php afp_help_meta_box(); ?>
		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox">
					<h3><span><?php _e('Edit Category'); ?></span></h3>
					<div class="inside">
					<form action="#" method="post" enctype="multipart/form-data">
						  <p>
							<label for="title"><b><?php _e('Category name :'); ?></b></label><br>
							<input type="text" name="title" id="title" class="regular-text" value="<?php echo($cat->cat_name); ?>"><br>
						  </p>
						  <p>
							<label for="description"><b><?php _e('Description :'); ?></b></label><br>
							<textarea name="description" id="description" cols="100" rows="10"><?php echo($cat->cat_description); ?></textarea>
						  </p>
						  <input type="hidden" name="cat_id" id="cat_id" value="<?php echo($cat_id); ?>"/>
						  <input type="hidden" name="which" id="which" value="update_category"/>
						  <input type="submit" value="<?php _e('Save Category'); ?>" class="button-primary">
						</form>
					</div> <!-- .inside -->
				</div>
			</div> <!-- #post-body-content -->
		</div> <!-- #post-body -->

	</div> <!-- .metabox-holder -->
</div> <!-- .wrap -->

<?php
}
}



function afp_get_categories_page(){
	global $wpdb;
	?>
<div class="wrap">
	<?php 
	$cat_id = $_GET['cat_id'];
	$action=$_GET['action'];
	if( $action=='' || $action=='delete' ){ 
	if ($action=='delete') { $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'afp_categories WHERE cat_id=' . $cat_id); }
	?>
	<h2><?php _e('Categories '); ?><a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=afp_add_new_category" title="" class="add-new-h2">Add New</a></h2>
	<?php 
	$cats = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_categories');
	if ($cats == null) {
		?>
		You don't have any categories. Please <a href="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=afp_add_new_category" title="">Add a New Category</a>
		<?php
		} else {
	?>
	<table class="widefat">
		<thead>
			<tr>
				<th class="row-title">Name</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $cats as $cat ) {
			echo('<tr>
					<td class="title column-title">
						<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_category&cat_id=' . $cat->cat_id . '"><b>' . $cat->cat_name . '</b></a>
						<div class="row-actions">
							<span class="edit"><a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_category&cat_id=' . $cat->cat_id . '">Edit</a></span> |
							<span class="submitdelete"><a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_categories&action=confirm&cat_id=' . $cat->cat_id . '">Delete</a></span>
						</div>
					</td>
					<td>' . $cat->cat_description . '</td>
				</tr>');
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<th class="row-title">Name</th>
				<th>Description</th>
			</tr>
		</tfoot>
	</table>
	<?php
	}
	} elseif( $action == 'confirm' ){
		?>
		<h2>Delete Confirmation</h2>
		<h3>Are you sure you want to delete this category?</h3>
		<a class="button-primary" href="<?php echo( get_bloginfo('url') . '/wp-admin/admin.php?page=afp_categories&action=delete&cat_id=' . $cat_id ); ?>"><?php _e( 'Delete' ); ?></a> 
		<a class="button-secondary" href="<?php echo( get_bloginfo('url') . '/wp-admin/admin.php?page=afp_categories'); ?>"><?php _e( 'Cancel' ); ?></a> 
		<?php
	}
}


//ADD, UPDATE PORTFOLIO ITEM/CATEGORY

global $wpdb;

/*** PORTFOLIO ITEM ***/
if($_POST['which']=='new_portfolio_item'){
	$item_title = $_POST['title'];
	$item_link = $_POST['link'];
	$item_category = $_POST['category'];
	$item_client = $_POST['client'];
	$item_date = $_POST['date'];
	$item_thumbnail = $_POST['thumbnail_adr'];
	$item_image = $_POST['image_adr'];
	$item_description = $_POST['description'];
	if ($item_date != NULL) {
		$item_date = date("Y-m-d", strtotime($item_date));
	} else {
		$item_date = '0000-00-00';
	}
	$wpdb->query($wpdb->prepare('
	INSERT INTO ' . $wpdb->prefix . 'afp_items(item_title, item_link, item_description, item_client, item_date, item_thumbnail, item_image, item_category)
	VALUES( %s, %s, %s, %s, %s, %s, %s, %s)' , $item_title, $item_link, $item_description, $item_client, $item_date, $item_thumbnail, $item_image, $item_category ));
	header ('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_portfolio_item&msg=added&item_id=' . $wpdb->insert_id);
}
if($_POST['which']=='update_portfolio_item'){
	$item_id = $_POST['item_id'];
	$item_title = $_POST['title'];
	$item_link = $_POST['link'];
	$item_category = $_POST['category'];
	$item_client = $_POST['client'];
	$item_date = $_POST['date'];
	$item_thumbnail = $_POST['thumbnail_adr'];
	$item_image = $_POST['image_adr'];
	$item_description = $_POST['description'];
	if ($item_date != '') {
		$item_date = date("Y-m-d", strtotime($item_date));
	} else {
		$item_date = '0000-00-00';
	}
	$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->prefix . 'afp_items SET item_title = \'' . $item_title . '\', item_link =\''. $item_link . '\', item_description =\''. $item_description . '\', item_client =\''. $item_client . '\', item_date =\''. $item_date . '\', item_thumbnail =\''. $item_thumbnail . '\', item_image =\''. $item_image . '\', item_category =\''. $item_category . '\' WHERE item_id=' . $item_id));
	header ('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_portfolio_item&msg=edited&item_id=' . $item_id);
}

/*** CATEGORY ***/

if($_POST['which']=='new_category'){
	$cat_name = $_POST['title'];
	$cat_description = $_POST['description'];
	$wpdb->query($wpdb->prepare('
	INSERT INTO ' . $wpdb->prefix . 'afp_categories(cat_name, cat_description)
	VALUES( %s, %s)' , $cat_name, $cat_description ));
	header ('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_category&msg=added&cat_id=' . $wpdb->insert_id);
}
if($_POST['which']=='update_category'){
	$cat_id = $_POST['cat_id'];
	$cat_name = $_POST['title'];
	$cat_description = $_POST['description'];
	$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->prefix . 'afp_categories SET cat_name = \'' . $cat_name . '\', cat_description =\''. $cat_description .'\' WHERE cat_id=' . $cat_id));
	header ('Location: ' . get_bloginfo('url') . '/wp-admin/admin.php?page=afp_add_new_category&msg=edited&cat_id=' . $cat_id);
}


//Activation Code
function afp_activation(){
	global $wpdb;
	$req = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "afp_items(
			item_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			item_title VARCHAR (100),
			item_link VARCHAR (500),
			item_description TEXT,
			item_client VARCHAR (100),
			item_date DATE,
			item_thumbnail VARCHAR (200),
			item_image VARCHAR (200),
			item_category VARCHAR (150)
			); ";
	$wpdb->query($req);
	$req = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "afp_categories(
			cat_id INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			cat_name VARCHAR (100),
			cat_description TEXT
			);";
	$wpdb->query($req);
}
register_activation_hook(__FILE__, 'afp_activation');

//Deactivation Code
function afp_deactivation(){
	global $wpdb;
	$req = "DROP TABLE IF EXISTS " . $wpdb->prefix . "afp_items;";
	$wpdb->query($req);
	$req = "DROP TABLE IF EXISTS " . $wpdb->prefix . "afp_categories;";
	$wpdb->query($req);
}

register_deactivation_hook(__FILE__, 'afp_deactivation');

/*** FRONT END ***/

function afp_shortcode(){
	global $wpdb;
	
	//Registering Scripts & Styles for the FrontEnd
	wp_register_script('afp-easing', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/jquery-easing.js');
	wp_register_script('afp-quicksand', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/quicksand.js');
	wp_register_script('afp-fancybox', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/fancybox/fancybox.js');
	wp_register_script('afp-functions', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/afp-functions.js');

	wp_register_style('fancybox-style', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/fancybox/fancybox.css');
	wp_register_style('afp-style', get_bloginfo('url') . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/afp-style.css');

	wp_enqueue_script('jquery');
	wp_enqueue_script('afp-easing');
	wp_enqueue_script('afp-quicksand');
	wp_enqueue_style('afp-style');
	wp_enqueue_script('afp-fancybox');
	wp_enqueue_style('fancybox-style');
	wp_enqueue_script('afp-functions');	
	

	//
	$items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_items');
	$cats = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'afp_categories');
	?>
    <div id="afp-container">
    
        <ul id="afp-filter">
        	<li class="afp-active-cat"><a href="#" class="All">All</a></li>
            <?php
            foreach ( $cats as $cat ){ ?>
            <li><a href="#" class="<?php echo( ereg_replace("[^A-Za-z0-9]", "", $cat->cat_name) ); ?>"><?php echo($cat->cat_name); ?></a></li>
            <?php } ?>
        </ul>
        
        <ul class="afp-items">
            <?php
            $k = 1;
            foreach ($items as $item ){ ?>
            <li class="afp-single-item" data-id="id-<?php echo($k); ?>" data-type="<?php echo( ereg_replace("[^A-Za-z0-9]", "", $item->item_category) ); ?>">
                <a class="fancybox" title="<?php echo( $item->item_description ); ?>" href="<?php echo ( $item->item_image ); ?>"><img alt="" class="img-link-initial" src="<?php echo($item->item_thumbnail); ?>"></a><br />
                <ul class="afp-item-details">
                    <?php if($item->item_title != null) { ?><li><strong><?php echo($item->item_title); ?></strong></li><?php } ?>
                    <?php if($item->item_client != null) { ?><li><?php echo($item->item_client); ?></li><?php } ?>
                    <?php if($item->item_date != '0000-00-00') { ?><li><?php echo(date("m/d/Y", strtotime($item->item_date))); ?></li><?php } ?>
                    <?php if($item->item_link != null) { ?><li><a target="_blank" href="<?php echo($item->item_link); ?>">Project Link</a></li><?php } ?>
                </ul>
            </li>
            <?php
            $k++;
            }
            ?>
        </ul>
        
    </div>
	<?php
}
add_shortcode('af-portfolio', 'afp_shortcode');

?>