<?php
require_once __DIR__ . '/../config/database.php';

$status = $_POST['status'] ?? '';
$role = $_POST['role'] ?? '';
$date = $_POST['date'] ?? '';
$sort = $_POST['sort'] ?? '';

$sql = "SELECT * FROM users WHERE 1=1";
$params = [];

if (!empty($status)) {
    $sql .= " AND status_user = :status";
    $params['status'] = $status;
}

if (!empty($role)) {
    $sql .= " AND role_user = :role";
    $params['role'] = $role;
}

if (!empty($date)) {
    $sql .= " AND DATE(subscriptiondate_user) = :date";
    $params['date'] = $date;
}

switch ($sort) {
    case 'az':
        $sql .= " ORDER BY name_user ASC";
        break;
    case 'za':
        $sql .= " ORDER BY name_user DESC";
        break;
    case 'date_recent':
        $sql .= " ORDER BY subscriptiondate_user DESC";
        break;
    case 'date_ancienne':
        $sql .= " ORDER BY subscriptiondate_user ASC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($users) === 0) {
    echo "<tr><td colspan='6'><div class='alert alert-info m-0'>Aucun utilisateur trouvé avec ces critères.</div></td></tr>";
    exit;
}

// Génération des lignes du tableau HTML
foreach ($users as $user) {
    echo "<tr>";

    echo "<td><strong>" . htmlspecialchars($user['name_user']) . " " . htmlspecialchars($user['surname_user']) . "</strong><br>";
    echo "<span>" . htmlspecialchars($user['role_user']) . "</span></td>";

    echo "<td>" . htmlspecialchars($user['email_user']) . "</td>";
    echo "<td>" . htmlspecialchars($user['role_user']) . "</td>";
    echo "<td>" . htmlspecialchars($user['subscriptiondate_user']) . "</td>";

    $status = $user['status_user'];
    $badgeClass = match($status) {
        'actif' => 'bg-success',
        'inactif' => 'bg-danger',
        'suspendu' => 'bg-warning',
        default => 'bg-secondary'
    };
    echo "<td><span class='badge $badgeClass'>" . htmlspecialchars($status) . "</span></td>";

    // actions (édition + suppression)
    echo "<td class='d-flex justify-content-between'>";
    echo "<button 
            class='btn btn-warning btn-sm edit-btn'
            data-id='" . $user['id_user'] . "'
            data-name='" . htmlspecialchars($user['name_user']) . "'
            data-surname='" . htmlspecialchars($user['surname_user']) . "'
            data-email='" . htmlspecialchars($user['email_user']) . "'
            data-role='" . $user['role_user'] . "'
            data-status='" . $user['status_user'] . "'
            data-bs-toggle='modal'
            data-bs-target='#editModal'>
            <i class='fas fa-edit'></i>
        </button>";

    echo "<form method='POST' action='admin.php?page=utilisateurs' onsubmit=\"return confirm('Supprimer cet utilisateur ?');\">";
    echo "<input type='hidden' name='delete_user_id' value='" . $user['id_user'] . "'>";
    echo "<button type='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
    echo "</form>";

    echo "</td>";

    echo "</tr>";

}