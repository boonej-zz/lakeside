<form class="searchform tranz" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<input type="text" name="s" class="s tranz" size="30" value="<?php esc_attr_e('Search...','association'); ?>" onfocus="if (this.value = '') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_attr_e('Search...','association'); ?>';}" />
<button class='searchSubmit' ><i class="fa fa-search"></i></button>
</form>