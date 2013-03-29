<?php

  class datasanitizer {
    function sanitize($string) {
      $string  = trim($string);
      $string  = strip_tags($string);
      $string  = preg_replace( '/\s+/', '', $string );
      return $string;
    }
    function sanitizecomment($string) {
      $string  = trim($string);
      $string  = strip_tags($string);
      return $string;
    }
  }
?>
