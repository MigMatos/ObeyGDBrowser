<?php 

include("../_init_.php");
include("./utils.php");

$file = str_replace("\\", "/", __FILE__);
$scriptFilename = str_replace("\\", "/", $_SERVER['SCRIPT_FILENAME']);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $file == $scriptFilename) {
    $params = $_GET;
    echo getRoles($params, $db);
} else {
    echo json_encode(array("error" => "Invalid request method or script filename mismatch."));
}

// Obtener roles/mods
function getRoles($params, $db) {
    $bindings = [];
    $order = "priority DESC";  // Ordenar por prioridad de mayor a menor

    // SQL para obtener los roles
    $sql = "SELECT roleID, roleName, priority FROM roles";

    // Orden y paginación
    if ($order) $sql .= " ORDER BY $order";
    $sql .= " LIMIT 10 OFFSET ?";
    $bindings[] = (isset($params['page']) && intval($params['page']) > 0) ? intval($params['page']) * 10 : 0;

    // Preparar y ejecutar la consulta
    $stmt = $db->prepare($sql);

    foreach ($bindings as $key => $value) {
        $stmt->bindValue($key + 1, $value, PDO::PARAM_INT);
    }

    $stmt->execute();

    if($stmt->rowCount() == 0) return json_encode([]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Contar el total de roles
    $sql = "SELECT COUNT(*) FROM roles";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $totalResults = $stmt->fetchColumn();
    $totalPages = intval($totalResults / 10) + 1;

    // Añadir paginador al resultado
    $results[0]["paginator"] = [
        "results" => $totalResults,
        "pages" => $totalPages
    ];

    return json_encode($results);
}

?>
