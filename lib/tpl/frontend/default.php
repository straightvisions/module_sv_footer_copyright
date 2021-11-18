<div class="<?php echo $this->get_prefix('wrapper'); ?>">
	<div class="<?php echo $this->get_prefix('inner'); ?>">
		<?php if($this->get_module( 'sv_sidebar' )->load( $this->get_setting('sidebar_1')->get_data() )){ ?>
		<div class="sv100_sv_sidebar_sv_copyright_footer_1"><?php echo $this->get_module( 'sv_sidebar' )->load( $this->get_setting('sidebar_1')->get_data() ); ?></div>
		<?php } ?>
		<?php if($this->get_module( 'sv_sidebar' )->load( $this->get_setting('sidebar_2')->get_data() )){ ?>
		<div class="sv100_sv_sidebar_sv_copyright_footer_2"><?php echo $this->get_module( 'sv_sidebar' )->load( $this->get_setting('sidebar_2')->get_data() ); ?></div>
		<?php } ?>
	</div>
</div>