<?php
require_once('../model/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); 

    if (isset($data['employee_id'])) {
        $employee_id = intval($data['employee_id']); 

        $conn = getConnection();

        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $employee_id);

        $response = [];
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Employee deleted successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete employee';
        }

        $stmt->close();
        $conn->close();

        echo json_encode($response);
        exit;
    }
}

// Invalid request
http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit;
?>
