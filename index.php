<?php
  // Downloading file from URL
  $groceryStore = simplexml_load_file("http://cdn.flashtalking.com/temp/charlie/feedstest/waitrose.xml");
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
    // Product rendered in JSON
    $productJSON = json_encode($product);
    // Product rendered in XML
    $productXML = $product->asXML();
    // separate categories by array
    $sub_categories = explode(" > ", $category);
    // For every sub-category
    for ($i=1;$i<count($sub_categories);$i++) {
      // Assign sub-category index
      $subCategoryIndex = $sub_categories[$i];
      // Assign $jsonFolder
      $jsonFolder = str_replace(" ", "", "assets/json/items/" . str_replace(" > ", "/", $sub_categories[1]) . "/");
      // Assign $jsonFile with '_' replace whitespace.
      $jsonFile = $jsonFolder . str_replace(" ", "",$sub_categories[1]) . ".json";
      // Assign $xmlFolder
      $xmlFolder = str_replace(" ", "", "assets/xml/items/" . str_replace(" > ", "/", $sub_categories[1]) . "/");
      // Assign $xmlFile
      $xmlFile = $xmlFolder . str_replace(" ", "",$sub_categories[1]) . ".xml";
      // If no sub-category folder
      if (!file_exists($jsonFolder)) {
        // Create sub-category JSON using createCategoryFolderJSON().
        createCategoryFolderJSON($jsonFolder);
      };
      // Insert Product into CategoryFolderJSON
      insertProductJSON($productJSON, $jsonFile);
      // If no sub-category folder
      if (!file_exists($xmlFolder)) {
        // Create sub-category XML using createCategoryFolderXML()
        createCategoryFolderXML($xmlFolder);
      };
      insertProductXML($productXML, $xmlFile);
    }
  };

echo "All Objects imported into JSON and XML sub-categories. \r\n";

  // createCategoryFolderJSON
  function createCategoryFolderJSON($jsonFolder) {
    if (!file_exists($jsonFolder)) {
      echo "Creating json folder: " . $jsonFolder . "\r\n";
      mkdir($jsonFolder, 0777, true);
    }
  };

  // Insert Product into *.json using insertProductJSON()
  function insertProductJSON($productJSON, $jsonFile) {
    echo "------JSON Version----- \r\n";
    echo "\r\n";
    // open file stream for $jsonFile to input product information.
    $fp = fopen($jsonFile, "a");
    // New JSON product
    echo "Entering in Product ID#:" . json_decode($productJSON)->productId . " into " . $jsonFile . "\r\n";
    fwrite($fp, $productJSON);
    // Closing file stream
    fclose($fp);
  };

  // createCategoryFolderXML
  function createCategoryFolderXML($xmlFolder) {
    if (!file_exists($xmlFolder)) {
      echo "Creating XML folder: " . $xmlFolder . "\r\n";
      mkdir($xmlFolder, 0777, true);
    }
  };
  // Insert Product into *.xml using insertProductXML()
  function insertProductXML($productXML, $xmlFile) {
    echo "------XML Version----- \r\n";
    echo "\r\n";
    $item = simplexml_load_string($productXML);
    // open file stream for $jsonFile to input product information.
    $fp = fopen($xmlFile, "a");
    // New JSON product
    echo "Entering in Product ID#:" . $item->productId . " into " . $xmlFile . "\r\n";
    fwrite($fp, $item->asXml());
    // Closing file stream
    fclose($fp);
  };
?>
