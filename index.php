<?php
  // Downloading file from URL
  $groceryStore = simplexml_load_file("waitrose.xml");
  // Loop Through all products in the grocery store
  foreach ($groceryStore->product as $product) {
    // Product attributes
    $id = $product->productId;
    $name = $product->productName;
    $image = $product->productImage;
    $url = $product->productUrl;
    $price = $product->price;
    $offer = $product->offer;
    $category = $product->category;
    // Product rendered as an array
    $array = array('id'=>$id,'name'=>$name,'image'=>$image,'url'=>$url,'price'=>$price,'offer'=>$offer,'category'=>$category);
    // Product rendered in JSON
    $productJSON = json_encode($product);
    // Product rendered in XML
    $productXML = $product->asXml();
    // separate categories by array
    $sub_categories = explode(" > ", $category);
    // For every sub-category
    for ($i=1;$i<count($sub_categories);$i++) {
      // Assign sub-category index
      $subCategoryIndex = $sub_categories[$i];
      // Assign $jsonFile with '_' replace whitespace.
      $jsonFile = "assets/json/" . str_replace(" ", "_",$subCategoryIndex) . ".json";
      // Assign $xmlFile
      $xmlFile = "assets/xml/" . str_replace(" ", "_",$subCategoryIndex) . ".xml";
      echo "------JSON Version----- \r\n";
      echo "\r\n";
      // If a sub-category JSON does not exists
      if (!file_exists($jsonFile)) {
        // Create sub-category JSON using createCategoryJSON in array() format.
        createCategoryJSON($jsonFile);
      }
      insertProductJSON($productJSON, $jsonFile);
    }
  };

  // createCategoryJSON
  function createCategoryJSON($jsonFile) {
    // Open file stream for $jsonFile (assets/json/{{$categoryIndex}}.json)
    $fp = fopen($jsonFile, 'w');
    echo "Creating json file for " . $jsonFile . "\r\n";
    // New JSON for sub-category
    fwrite($fp, " ");
    // Closing file stream
    fclose($fp);
  };
  // Insert Product into JSON using insertProductJSON()
  function insertProductJSON($productJSON, $jsonFile) {
    // open file stream for $jsonFile to input product information.
    $fp = fopen($jsonFile, "w");
    // New JSON product
    echo "Entering in Product ID#:" . JSON_decode($productJSON)->productId . "into " . JSON_decode($productJSON)->category . "\r\n";
    fwrite($fp, $productJSON);
    // Closing file stream
    fclose($fp);
  };
  echo "STOP 1 time \r\n"; die;
?>



// function createCategoryFolderXML($array, $categoryIndex) {
//   echo "Creating xml file for " . $categoryIndex . "\r\n";
//   $header = header("Content-type: text/xml");
//   if (!isset($header)) {
//
//   }
  //   echo $header;
//   $product->asXml("assets/xml/" . $sub_category[$i] . '.xml');
//   }


// // function insertProductXML($array, $categoryIndex) {
//
// };

// echo "------XML Version----- \r\n";
// echo $xml . "\r\n";
// echo "\r\n";
// if (!isset($categoryIndex)) {
//   createCategoryXML($categoryIndex, $array);
// };
// insertProductXML($array, $category);
