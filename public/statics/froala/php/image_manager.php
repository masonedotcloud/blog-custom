<?php
function getList($folderPath, $thumbPath = null) {

    if (empty($thumbPath)) {
      $thumbPath = $folderPath;
    }

    // Array of image objects to return.
    $response = array();

    //$absoluteFolderPath = $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' . $folderPath;
    $absoluteFolderPath =  $_SERVER['DOCUMENT_ROOT'] . '/alessandromasone.altervista.org' .  $folderPath;
    // Image types.
    //$image_types = Image::$defaultUploadOptions['validation']['allowedMimeTypes'];

    // Filenames in the uploads folder.
    $fnames = scandir($absoluteFolderPath);

    // Check if folder exists.
    if ($fnames) {
      // Go through all the filenames in the folder.
      foreach ($fnames as $name) {
        // Filename must not be a folder.
        if (!is_dir($name)) {
          // Check if file is an image.

          //if (in_array(mime_content_type($absoluteFolderPath . $name), $image_types)) {
            // Build the image.
            $img = new \StdClass;
            $img->url = $folderPath .'/'. $name;
            $img->thumb = $thumbPath.'/'. $name;
            $img->name = $name;

            // Add to the array of image.
            array_push($response, $img);
          //}
        }
      }
    }

    // Folder does not exist, respond with a JSON to throw error.
    else {
      throw new Exception('Images folder does not exist!');
    }

    return $response;
  }





try {
    $response = getList('/public/assets/posts/content/images');
    echo stripslashes(json_encode($response));
  }
  catch (Exception $e) {
    http_response_code(404);
  }