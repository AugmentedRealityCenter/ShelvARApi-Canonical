<?php
/**
 * @file
 * @author Bo Brinkman
 * @date 2013-03-29
 *
 * A function set used to convert a human-readable LC call number to
 * a base-64 string, used in a ShelvAR tag.
 *
 */
$root = $_SERVER['DOCUMENT_ROOT']."/";
include_once $root."api/lc2bin/lc_numbers_lib.php";

if (!isset($_GET['call_number'])) {
    exit(json_encode(array('result'=>'ERROR',
       'message'=>'Please specify call_number')));
}

$call_number_in = urldecode($_GET["call_number"]);

$result = "";
$book_tag = lc_to_tag($call_number_in);

if(strlen($book_tag) == 0){
  echo json_encode(array('result'=>"ERROR", 'message'=>"Call number too long"));
} else {
  $call_number_out = tag_to_lc($book_tag);
  if(strcmp(trim($call_number_in),$call_number_out) != 0) {
    echo json_encode(array('result'=>"ERROR", 'message'=>"Call number in doesn't match call number out. This is a bug, report to the developers "));
  } else {
	echo json_encode(array('result'=>"SUCCESS", "book_tag" => $book_tag, 
		       "call_number" => $call_number_out));
  }
}
 ?>
