<?php

require('fpdf/fpdf.php');
include 'includes/connection.php';

if ($connection) {
    // Ensure that the tracking number is properly fetched and sanitized
    $trackingNumber = isset($_REQUEST['tracking_number']) ? mysqli_real_escape_string($connection, $_REQUEST['tracking_number']) : '';

    if (!empty($trackingNumber)) {
        // Fetch all items related to the tracking number
        $query = "SELECT 
                    cart_table.brand,
                    cart_table.quantity,
                    cart_table.unit,
                    cart_table.order_date,
                    cart_table.total AS item_total,
                    cart_table.category,
                    cart_table.wholesaleprice,
                    order_table.supplier_id,
                    order_table.grand_total
                  FROM 
                    cart_table
                  INNER JOIN 
                    order_table ON cart_table.order_id = order_table.id
                  WHERE 
                    cart_table.tracking_number = '$trackingNumber'";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            printf("Error: %s\n", mysqli_error($connection));
            exit();
        }

        if (mysqli_num_rows($result) > 0) {
            // Fetch supplier information based on the supplier ID
            $supplierInfoQuery = "SELECT * FROM supplier WHERE supplier_id = (SELECT supplier_id FROM order_table WHERE id = (SELECT order_id FROM cart_table WHERE tracking_number = '$trackingNumber' LIMIT 1))";
            $supplierInfoResult = mysqli_query($connection, $supplierInfoQuery);
            $supplierInfo = mysqli_fetch_assoc($supplierInfoResult);

            // Fetch the order date
            $orderDateQuery = "SELECT order_date FROM cart_table WHERE tracking_number = '$trackingNumber' LIMIT 1";
            $orderDateResult = mysqli_query($connection, $orderDateQuery);
            $orderDateRow = mysqli_fetch_assoc($orderDateResult);
            $orderDate = $orderDateRow['order_date'];

            // Fetch the grand total from the order_table
            $grandTotalQuery = "SELECT grand_total FROM order_table WHERE id = (SELECT order_id FROM cart_table WHERE tracking_number = '$trackingNumber' LIMIT 1)";
            $grandTotalResult = mysqli_query($connection, $grandTotalQuery);
            $grandTotalRow = mysqli_fetch_assoc($grandTotalResult);
            $grandTotal = $grandTotalRow['grand_total'];

            // Ensure that no output is sent before generating the PDF
            ob_clean();

            // Generate PDF
            $pdf = new FPDF('L', 'mm', 'A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Official Receipt', 0, 1, 'C');
            $pdf->Ln();

            // Output supplier information
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(0, 10, 'Supplier: ' . $supplierInfo['name'], 0, 1, 'L'); // Align left
            $pdf->Cell(0, 10, 'Address: ' . $supplierInfo['address'], 0, 1, 'L'); // Align left
            $pdf->Cell(0, 10, 'Contact Person: ' . $supplierInfo['contact_person'], 0, 1, 'L'); // Align left
            $pdf->Cell(0, 10, 'Contact: ' . $supplierInfo['contact'], 0, 1, 'L'); // Align left
            $pdf->Cell(0, 10, 'Email: ' . $supplierInfo['email'], 0, 1, 'L'); // Align left
            $pdf->Cell(0, 10, 'Tracking Number: ' . $trackingNumber, 0, 1, 'L'); 
            $pdf->Cell(0, 10, 'Order Date: ' . $orderDate, 0, 1, 'L');  
            $pdf->Cell(0, 10, 'Shipping Fee: ' . $supplierInfo['shippingfee'], 0, 1, 'L'); 
            $pdf->Cell(0, 10, 'Mode of Payment: ' . $supplierInfo['modeofpayment'], 0, 1, 'L'); 
            $pdf->Ln();

            // Iterate through items and output them in the PDF
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(20, 10, 'Item', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Brand', 1, 0, 'C');
            $pdf->Cell(60, 10, 'Category', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Unit', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Price', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Total', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 12);
            $itemNo = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                $pdf->Cell(20, 10, $itemNo++, 1, 0, 'C');
                $pdf->Cell(60, 10, $row['brand'], 1, 0, 'L');
                $pdf->Cell(60, 10, $row['category'], 1, 0, 'C');
                $pdf->Cell(30, 10, $row['quantity'], 1, 0, 'C');
                $pdf->Cell(30, 10, $row['unit'], 1, 0, 'C');
                $pdf->Cell(30, 10, $row['wholesaleprice'] . 'php', 1, 0, 'C');
                $pdf->Cell(40, 10, $row['item_total'] . 'php', 1, 1, 'C');
            }

            // Output grand total
            $pdf->Cell(200, 10, 'Grand Total:', 1, 0, 'R');
            $pdf->Cell(70, 10, $grandTotal . 'php', 1, 1, 'C');

            // Send PDF to browser
            $pdf->Output();
            exit();
        } else {
            echo "Error: No data found for the provided tracking number";
        }
    } else {
        echo "Error: Tracking number is required";
    }
    mysqli_close($connection);
} else {
    echo "Error: Unable to connect to the database";
}
?>