<?php

// Normal success response (no pagination)
function jsonResponse($success, $message = "", $data = [], $status_code = null)
{
    // Dynamic status code if not provided
    $status_code = $status_code ?? ($success ? 200 : 400);
    http_response_code($status_code);

    $response = [
        "success" => $success,
        "status_code" => $status_code,
        "message" => $message,
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Success response with pagination
function jsonResponseWithPagination($message = "", $data = [], $pagination = [], $status_code = 200)
{
    http_response_code($status_code);

    $paginationObject = (object) [
        "page" => $pagination['page'] ?? 1,
        "per_page" => $pagination['per_page'] ?? 10,
        "total" => $pagination['total'] ?? 0,
        "total_pages" => $pagination['total_pages'] ?? 0
    ];

    $response = [
        "success" => true,
        "status_code" => $status_code,
        "message" => $message,
        "data" => $data,
        "pagination" => $paginationObject
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Error response (no pagination)
function jsonErrorResponse($message = "", $data = [], $status_code = 400)
{
    http_response_code($status_code);

    $response = [
        "success" => false,
        "status_code" => $status_code,
        "message" => $message,
        "data" => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
