<?php
require_once __DIR__ . '/../config/database.php';

try {
    $status = $_POST['status'] ?? '';
    $date = $_POST['date'] ?? '';
    $sort = $_POST['sort'] ?? '';

    $conditions = [];
    $params = [];

    if (!empty($status)) {
        $conditions[] = "status_contact = :status";
        $params[':status'] = $status;
    }

    if (!empty($date)) {
        $conditions[] = "DATE(creationdate_contact) = :date";
        $params[':date'] = $date;
    }

    $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

    switch ($sort) {
        case 'az':
            $orderBy = 'ORDER BY name ASC';
            break;
        case 'za':
            $orderBy = 'ORDER BY name DESC';
            break;
        case 'date_ancienne':
            $orderBy = 'ORDER BY creationdate_contact ASC';
            break;
        default:
            $orderBy = 'ORDER BY creationdate_contact DESC';
    }

    $sql = "SELECT *, CONCAT(name, ' ', surname_contact) AS full_name
            FROM contacts
            $whereClause
            $orderBy";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $results]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}