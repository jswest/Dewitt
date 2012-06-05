<?php
class Resize {
  
  /*
   * PROPERTIES
   */
  private $file_name; // The initial file name.
  private $image; // The initial image, created from a .jpg file
  private $width; // The width of that image
  private $height; // The height of that image
  private $shortest_side; // The shortest side of that image
  private $crop_size; // The size to which the image will be cropped
  private $resized_image; // The resized image
  public  $final_path;    // God, I'm lazy.
  
  
  /*
   * THE CONSTRUCTOR METHOD
   * This method creates a new image from the .jpg file.
   * It also gets that image's width, height, and determines
   * which side is the shortest.
   */
  public function __construct( $file_name ) {
    
    // Define the file name; we'll need it when we name the altered image.
    $this->file_name = $file_name;
    
    // Open a new image from the file.
    $this->open_image( $this->file_name );
    
    // If everything went okay, get the height, width, and shortest side.
    if( $this->image ) {
      
      // Get the height and width.
      $this->width = imagesx( $this->image );
      $this->height = imagesy( $this->image );
      
      // Get the shortest side.
      if( $this->width < $this->height ) {
        $this->shortest_side = $this->width;
      } else {
        $this->shortest_side = $this->height;
      }
    }
  }
  
  
  /*
   * THE OPEN IMAGE METHOD
   * This method does the real work of creating an image from
   * the .jpg file. It also has a little bit of error handling if
   * there isn't a .jpg file. It is called from the CONSTRUCTOR method.
   */
  private function open_image( $file ) {
    
    // Get the file extension.
    $extension = strtolower( strrchr( $file, '.' ) );
        
    // If it's a .jpg file, create the image.
    if( $extension == '.jpg' || '.jpeg' ) {
      $img = imagecreatefromjpeg( $file );
    
    // If it's not a .jpg file, give an error.
    } else {
      $img = false;
      echo "ERROR: you must upload a file with the extension .jpg or .jpeg";
    }
    
    // Create the new image
    if( $img ) {
      $this->image = $img;
    }
  }
  
  
  /*
   * THE CREATE THUMB METHOD
   * This method takes the size of a thumbnail.
   * It then calls the crop_image function.
   * It's public, so this is the one--or one like it--you call from external scripts.
   */
  public function create_thumb( $nsize ) {
    
    // Call the CROP IMAGE method, which does the work of cropping.
    $this->crop_image( $nsize );
    
    // Create the path for the SAVE IMAGE method.
    $extension = strrchr( $this->file_name, '.' );
    $path = substr_replace( $this->file_name, '_thumb' . $nsize, strrpos( $this->file_name, '.' ) ) . $extension;
    
    // Call the SAVE IMAGE method, which saves the image, as you might guess.
    $this->save_image( $path );
  }
  
  
  /*
   * THE CREATE PIECE METHOD
   * This sets the optimal height and width of an large image.
   * It then calls the RESIZE IMAGE method, which does the work
   * of correctly resizing the image.
   */
  public function create_piece() {
    
    // The optimal width and height.
    $owidth = 1440;
    $oheight = 990;
   
    // Call the RESIZE IMAGE method, which does the work of resizing.
    $this->resize_image( $owidth, $oheight );
    
    // Create the path for the SAVE IMAGE method.
    $extension = strrchr( $this->file_name, '.' );
    $path = substr_replace( $this->file_name, '_piece', strrpos( $this->file_name, '.' ) ) . $extension;
    
    // Call the SAVE IMAGE method, which saves the image, as you might guess.
    $this->save_image( $path );    
  }
  
  
  /*
   * THE RESIZE IMAGE METHOD
   * This method correctly resizes the image.
   */
  private function resize_image( $owidth, $oheight ) {
    
    // If it's landscape...
    if( $this->height < $this->width ) {
      $nwidth = $owdith;
      $nheight = $nwidth * ( $this->height / $this->width );
    
    // Else if it's portrait...
    } elseif( $this->height > $this->width ) {
      $nheight = $oheight;
      $nwidth = $nheight * ( $this->width / $this->height );
    
    // Otherwise, if it's square...
    } else {
      $nwidth = $oheight;
      $nheight = $oheight;
    }
    
    // Create the new, blank image.
    $this->resized_image = imagecreatetruecolor( round($nwidth), round($nheight) );
    
    // Resize the damn thing.
    imagecopyresampled(
      $this->resized_image, // The destination image
      $this->image,         // The source image
      0,                    // The starting x point on the destination image
      0,                    // The starting y point on the destination image
      0,                    // The starting x point on the source image
      0,                    // The starting y point on the source image
      round($nwidth),       // The width of the destination image
      round($nheight),      // The height of the destination image
      $this->width,         // The width of the source image crop area
      $this->height         // The height of the source image crop area
    );
  }

  
  /*
   * THE CROP IMAGE METHOD
   * First, this determines what size on the source image to crop,
   * cropping to the size of the smallest side and centering in the wider side.
   * Then it resizes that part of the image down to the requested new size.
   * NB: It's always a square.
   */
  private function crop_image( $nsize ) {
    
    // Get the crop size.
    $this->crop_size = $this->shortest_side;
    
    // Get the starting x point.
    if( $this->shortest_side == $this->width || $this->width == $this->height ) {
      $sx = 0;
    } else {
      $sx = ( $this->width - $this->shortest_side ) / 2;
    }
    
    // Get the starting y point.
    if( $shortest_side == $this->height || $this->height == $this->width ) {
      $sy = 0;
    } else {
      $sy = ( $this->height - $this->shortest_side ) / 2;
    }
    
    // Create the new, blank image.
    $this->resized_image = imagecreatetruecolor( $nsize, $nsize );
    
    // Actually crop the image
    imagecopyresampled(
      $this->resized_image, // The destination image
      $this->image,         // The source image
      0,                    // The starting x point on the destination image
      0,                    // The starting y point on the destination image
      $sx,                  // The starting x point on the source image
      $sy,                  // The starting y point on the source image
      $nsize,               // The width of the destination image
      $nsize,               // The height of the destination image
      $this->crop_size,     // The width of the source image crop area
      $this->crop_size      // The height of the source image crop area
    );
  }
  
  
  /*
   * THE SAVE IMAGE METHOD
   * This method saves the resized image ($this->resized_image) as
   * a .jpg file with the appropriate revised name. It takes that new name as
   * it's only argument. It also does a little cleanup.
   */
  private function save_image( $path ) {
    
    // Actually make the new .jpg.
    imagejpeg(
      $this->resized_image, // The resized image
      $path,                // The path to save the new .jpg
      100                   // The quality of the new .jpg (0-100)
    );
    
    $this->final_path = $path;
    
    // Destroy the old image resources.
    imagedestroy( $this->image );
    imagedestroy( $this->resized_image );
  
  }
}

?>