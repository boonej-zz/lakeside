<?php
$lot_phone = geodir_get_post_meta( $post_ID, 'geodir_contact', true );
$lot_mobile1 = geodir_get_post_meta( $post_ID, 'geodir_mobile1', true );
$lot_mobile2 = geodir_get_post_meta( $post_ID, 'geodir_mobile2', true );
$lot_email1 = geodir_get_post_meta( $post_ID, 'geodir_email_1', true );
$lot_email2 = geodir_get_post_meta( $post_ID, 'geodir_email_2', true );
$lot_children = geodir_get_post_meta( $post_ID, 'geodir_children', true );
?>
<?php if( !empty( $lot_phone ) ) {?>
  <strong>Phone: </strong><?php echo $lot_phone; ?><br />
<?php }?>

<?php if( !empty( $lot_mobile1 ) ){?>
  <strong>Mobile 1: </strong><?php echo $lot_mobile1; ?><br />
<?php }?>

<?php if( !empty( $lot_mobile2 ) ){?>
  <strong>Mobile 2: </strong><?php echo $lot_mobile2; ?><br />
<?php }?>

<?php if( !empty( $lot_email1 ) ){?>
  <strong>Email: </strong><?php echo $lot_email1; ?><br />
<?php }?>

<?php if( !empty( $lot_email2 ) ){?>
  <strong>Email 2: </strong><?php echo $lot_email2; ?><br />
<?php }?>

<?php if( !empty( $lot_children ) ){?> 
<strong>Children: </strong><br /><?php echo $lot_children; ?>
<?php }?>