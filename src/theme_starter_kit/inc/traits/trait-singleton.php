<?php
trait WithSingleton {
  private static $instance;
	public static function getInstance():static {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}