<?php
session_start();
include 'includes/connection.php';

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = 0; // Initialize count to 0
        foreach($data as $row)
        {
            if($count > 0)
            {
                // Extract data from the row
                $supplier = $row[0];
                $category = $row[1];
                $brand = $row[2];
                $type = $row[3];
                $description = $row[4];
                $unit = $row[5];
                $unit_qty = $row[6];
                $wholesaleprice = $row[7];
                $unitcost = $row[8];

                // Check if the supplier exists in the supplier table
                $checkSupplierQuery = "SELECT supplier_id FROM supplier WHERE name = '$supplier'";
                $supplierResult = mysqli_query($connection, $checkSupplierQuery);
                if(mysqli_num_rows($supplierResult) == 0) {
                    // Supplier does not exist, handle this case (skip record, insert placeholder, etc.)
                    // For demonstration, I'm skipping the record and continuing to the next iteration
                    continue;
                }

                // Check if the category exists in the category table
                $checkCategoryQuery = "SELECT category_id FROM category WHERE category_name = '$category'";
                $categoryResult = mysqli_query($connection, $checkCategoryQuery);
                if(mysqli_num_rows($categoryResult) == 0) {
                    // Category does not exist, insert it
                    $insertCategoryQuery = "INSERT INTO category (category_name) VALUES ('$category')";
                    $categoryInsertResult = mysqli_query($connection, $insertCategoryQuery);
                    if (!$categoryInsertResult) {
                        echo "Error: " . $insertCategoryQuery . "<br>" . mysqli_error($connection);
                        exit; // Exit script to prevent redirection
                    }
                    // Get the newly inserted category ID
                    $categoryId = mysqli_insert_id($connection);
                } else {
                    // Category exists, get its ID
                    $categoryRow = mysqli_fetch_assoc($categoryResult);
                    $categoryId = $categoryRow['category_id'];
                }

                // Insert data into MySQL database
                $medicineQuery = "INSERT INTO medicine_list (brand, unit, unit_qty, wholesaleprice, unitcost, description, supplier_id, category_id, type_id) 
                                  VALUES ('$brand', '$unit', '$unit_qty', '$wholesaleprice', '$unitcost', '$description', 
                                  (SELECT supplier_id FROM supplier WHERE name = '$supplier'), 
                                  '$categoryId', 
                                  (SELECT type_id FROM medicinetype WHERE type_name = '$type'))";

                // Execute the query
                $result = mysqli_query($connection, $medicineQuery);

                if ($result) {
                    $msg = true;
                } else {
                    echo "Error: " . $medicineQuery . "<br>" . mysqli_error($connection); // Echo out error message
                    exit; // Exit script to prevent redirection
                }
            }
            else
            {
                $count++; // Increment count
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            $_SESSION['message_type'] = "error";
            header('Location: item.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            $_SESSION['message_type'] = "error";
            header('Location: item.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: item.php');
        exit(0);
    }
}
