<?php
require 'vendor/autoload.php';

use RouterOS\Client;
use RouterOS\Query;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$voucher = $input['voucher'] ?? '';
$identity = $input['mikrotik'] ?? ''; // Now using identity instead of host address

if (empty($voucher) || empty($identity)) {
    echo json_encode(['success' => false, 'message' => 'Voucher and MikroTik router are required.']);
    exit;
}

// List of MikroTik routers
$mikrotiks = [
    '849a07b5f490.sn.mynetname.net' =>  [
        'user'     => 'admin',
        'password' => 'Dell@5056208',
        'port'     => 888,
        'identity' => 'TGA-1', // Add identity for this MikroTik
    ],
    
    'e3200dff785f.sn.mynetname.net' => [
        'user'     => 'admin1',
        'password' => 'Dell@7860',
        'port'     => 888,
        'identity' => 'TGA-2', // Add identity for this MikroTik
    ],
];

// Find the host address based on the identity
$mikrotikHost = null;
foreach ($mikrotiks as $host => $details) {
    if ($details['identity'] === $identity) {
        $mikrotikHost = $host;
        break;
    }
}

if (!$mikrotikHost) {
    echo json_encode(['success' => false, 'message' => 'Invalid MikroTik router selected.']);
    exit;
}

try {
    $client = new Client([
        'host' => $mikrotikHost,
        'user' => $mikrotiks[$mikrotikHost]['user'],
        'pass' => $mikrotiks[$mikrotikHost]['password'],
        'port' => $mikrotiks[$mikrotikHost]['port'],
    ]);

    // 1️⃣ Find the User in Hotspot Users
    $query = new Query('/ip/hotspot/user/print');
    $users = $client->query($query)->read();

    $user = null;
    foreach ($users as $u) {
        if ($u['name'] === $voucher) {
            $user = $u;
            break;
        }
    }

    if (!$user) {
        echo json_encode(['success' => false, 'message' => "Voucher: $voucher not found"]);
        exit;
    }

    // 2️⃣ Reset MAC to `00:00:00:00:00:00`
    $query = new Query('/ip/hotspot/user/set');
    $query->equal('.id', $user['.id']);
    $query->equal('mac-address', '00:00:00:00:00:00');
    $client->query($query)->read();

    // 3️⃣ Remove User from Active Sessions
    $query = new Query('/ip/hotspot/active/print');
    $activeUsers = $client->query($query)->read();

    foreach ($activeUsers as $activeUser) {
        if ($activeUser['user'] === $voucher) {
            $query = new Query('/ip/hotspot/active/remove');
            $query->equal('.id', $activeUser['.id']);
            $client->query($query)->read();
            break;
        }
    }

    // 4️⃣ Remove User from Cookies
    $query = new Query('/ip/hotspot/cookie/print');
    $cookies = $client->query($query)->read();

    foreach ($cookies as $cookie) {
        if ($cookie['user'] === $voucher) {
            $query = new Query('/ip/hotspot/cookie/remove');
            $query->equal('.id', $cookie['.id']);
            $client->query($query)->read();
            break;
        }
    }

    echo json_encode(['success' => true, 'message' => "Reset Voucher: $voucher Success!"]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
