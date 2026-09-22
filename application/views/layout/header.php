<?php
$app_name = 'Smart Parking'; // Fallback
// Try to get dynamic name from DB if CI instance is available
$CI =& get_instance();

// Ensure database is loaded
if (!isset($CI->db)) {
    $CI->load->database();
}

if (isset($CI->db)) {
    $db_debug = $CI->db->db_debug;
    $CI->db->db_debug = FALSE;
    
    $query = $CI->db->get_where('app_headers', ['is_active' => 1]);
    if ($query && $query->num_rows() > 0) {
        $app_name = $query->row()->header_name;
    } else {
        $query_any = $CI->db->get('app_headers');
        if ($query_any && $query_any->num_rows() > 0) {
            $app_name = $query_any->row()->header_name;
        }
    }
    
    $CI->db->db_debug = $db_debug; // Restore
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= htmlspecialchars($app_name) ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 20px;}
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
        .container { max-width: 480px; /* Mobile width container */ margin-top: 20px; }
        .navbar .container { margin-top: 0; }
        .btn-green { background-color: #00b894; color: white; border: none; }
        .btn-green:hover { background-color: #00a884; color: white; }
        .btn-blue { background-color: #0984e3; color: white; border: none; }
        .btn-blue:hover { background-color: #0873c4; color: white; }
        .card { border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
        <i class="bi bi-car-front-fill me-2 text-warning"></i><?= htmlspecialchars($app_name) ?>
    </a>
    
    <?php if($this->session->userdata('logged_in')): ?>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="bi bi-house-door"></i> Home</a>
                </li>
                <?php if($this->session->userdata('role') === 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear-fill"></i> Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('admin') ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/tarif') ?>"><i class="bi bi-cash-coin me-2"></i> Master Tarif</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/vehicles') ?>"><i class="bi bi-car-front me-2"></i> List Kendaraan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('admin/headers') ?>"><i class="bi bi-type me-2"></i> Master Header</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="nav-item mt-2">
                    <a class="nav-link text-danger" href="<?= base_url('auth/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
    </div>
    <?php endif; ?>
  </div>
</nav>
