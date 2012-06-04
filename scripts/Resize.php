<?php
Class Resize {
  
  private $image;
  private $width;
  private $height;
  private $resized_image;
  
  public function __construct( $file_name ) {
    $this->image = $this->open_image($file_name);
    if( $this->image ) {
      $this->width = imagesx( $this->image );
      $this->height = imagesy( $this->image ); 
    }
  }
  
  private function open_image( $file ) {
    $extension = strtolower( strrchr( $file, '.' ) );
    if( $extension == '.jpg' || '.jpeg' ) {
      $img = imagecreatefromjpeg( $file );
    } else {
      $img = false;
    }
    return $img;
  }
  
  public function create_project_thumb() {
    $nwidth = 200;
    $nheight = 200;
    $crop = true;
    $this->resize_image( $nwidth, $nheight, $crop );
  }
  
  public function create_thumb() {
    $nwidth = 100;
    $nheight = 100;
    $crop = true;
    $this->resize_image( $nwidth, $nheight, $crop );
  }
  
  public function create_piece() {
    $nwidth = 1440;
    $nheight = 990;
    $crop = false;
    $this->resize_image( $nwidth, $nheight, $crop );
  }
  
  private function resize_image( $nwidth, $nheight, $crop ) {
    $oarray = $this->get_dimensions( $nwidth, $nheight );
    $owidth = $oarray['owidth'];
    $oheight = $oarray['oheight'];
    $this->resized_image = imagecreatetruecolor( $owidth, $oheight );
    imagecopyresampled( $this->resized_image, $this->image, 0, 0, 0, 0, $owidth, $oheight, $this->width, $this->height );
    if( $crop ) {
      $this->crop($owidth, $oheight, $nwidth, $nheight);
    }
  }
  
  private function get_width_from_fixed_height( $nheight ) {  
    $ratio = $this->width / $this->height;  
    $nwidth = $nheight * $ratio;  
    return $nwidth;  
  }  

  private function get_height_from_fixed_width( $nwidth ) {  
    $ratio = $this->height / $this->width;  
    $nheight = $nwidth * $ratio;  
    return $nheight;  
  }
    
  private function get_dimensions( $nwidth, $nheight ) {
    if( $this->height < $this->width ) {
      $owidth = $nwidth;
      $oheight = $this->get_height_from_fixed_width( $nwidth );
    } elseif( $this->height > $this->width) {
      $owidth = $this->get_width_from_fixed_height( $nheight );
      $oheight = $nheight;
    } else {
      if( $nheight < $nwidth ) {
        $owidth = $nwidth;
        $oheight = $this->get_height_from_fixed_width( $nwidth );
      } elseif( $nheight > $nwidth ) {
        $owidth = $this->get_width_from_fixed_height( $nheight );
        $oheight = $nheight;
      } else {
        $owidth = $nwidth;
        $oheight = $nheight;
      }
    }
    return array( 'owidth' => $owidth, 'oheight' => $oheight );
  }
    
  private function get_optimal_crop( $nwidth, $nheight ) {
    $hratio = $this->height / $nheight;
    $wratio = $this->width / $nwidth;
    if( $hratio < $wratio ) {
      $oratio = $hratio;
    } else {
      $oratio = $wratio;
    }
    $oheight = $this->height / $oratio;
    $owidth = $this->width / $oratio;
    return array( 'owidth' => $owidth, 'oheight' => $oheight );
  }
  
  private function crop( $owidth, $oheight, $nwidth, $nheight ) {
    $crop_startx = ( $owidth / 2) - ( $nwidth / 2 );  
    $crop_starty = ( $oheight / 2) - ( $nheight / 2 );  
  
    $crop = $this->resized_image;  
  
    // *** Now crop from center to exact requested size  
    $this->resized_image = imagecreatetruecolor( $nwidth , $nheight );  
    imagecopyresampled( $this->resized_image, $crop , 0, 0, $crop_startx, $crop_starty, $nwidth, $nheight , $nwidth, $nheight );  
  }
  
  public function save_image( $save_path ) {
    $extension = strrchr( $save_path, '.' );
    $extension = strtolower( $extension );
    if( $extension == '.jpg' || '.jpeg' ) {
      imagejpeg( $this->resized_image, $save_path, 100 );
    } else {
      echo "error";
    }
    imagedestroy( $this->resized_image );
  }
  
}
?>