<?php
$title = 'Admin Dashboard - User Management';
ob_start();
?>
<style>
.admin-dashboard {
    padding: 30px 20px;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    min-height: calc(100vh - 100px);
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #0284c7;
}

.dashboard-header h2 {
    margin: 0;
    font-size: 2rem;
    color: #0c4a6e;
    font-weight: 700;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(6, 78, 130, 0.1);
    border-left: 4px solid #0284c7;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(6, 78, 130, 0.15);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #0c4a6e;
    margin: 10px 0;
}

.stat-label {
    font-size: 0.85rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(6, 78, 130, 0.1);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #0c4a6e 0%, #0284c7 100%);
    padding: 20px;
}

.table-header h3 {
    margin: 0;
    color: white;
    font-size: 1.3rem;
}

.user-table {
    border-collapse: collapse;
    width: 100%;
}

.user-table th {
    background: linear-gradient(135deg, #0c4a6e 0%, #0284c7 100%);
    color: #fff;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.user-table td {
    padding: 14px 15px;
    border-bottom: 1px solid #e0e7ff;
    color: #334155;
}

.user-table tr:hover {
    background-color: #f0f9ff;
    transition: background-color 0.2s ease;
}

.user-table tr:last-child td {
    border-bottom: none;
}

.email-cell {
    font-weight: 500;
    color: #0c4a6e;
}

.role-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.role-admin {
    background-color: rgba(239, 68, 68, 0.2);
    color: #7f1d1d;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.role-user {
    background-color: rgba(59, 130, 246, 0.2);
    color: #1e40af;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.status-active {
    background-color: rgba(34, 197, 94, 0.2);
    color: #15803d;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.status-pending {
    background-color: rgba(245, 158, 11, 0.2);
    color: #b45309;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.approve-btn {
    display: inline-block;
    padding: 8px 14px;
    background-color: #22c55e;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.approve-btn:hover {
    background-color: #16a34a;
    box-shadow: 0 4px 8px rgba(34, 197, 94, 0.3);
    transform: translateY(-2px);
}

.no-action {
    color: #cbd5e1;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #64748b;
}

.empty-state-icon {
    font-size: 3rem;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .user-table th,
    .user-table td {
        padding: 10px;
        font-size: 0.85rem;
    }
    
    .role-badge,
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
}
</style>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h2>⚙️ Admin Dashboard</h2>
        <div style="font-size: 0.9rem; color: #64748b;">
            Last updated: <?= date('M d, Y H:i') ?>
        </div>
    </div>

    <?php
    // Convert MongoDB Cursor to array
    $users = iterator_to_array($users);
    
    // Calculate statistics
    $totalUsers = count($users);
    $adminUsers = count(array_filter($users, fn($u) => ($u['role'] ?? 'user') === 'admin'));
    $regularUsers = $totalUsers - $adminUsers;
    $pendingUsers = count(array_filter($users, fn($u) => ($u['status'] ?? 'active') === 'pending'));
    ?>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-label">👥 Total Users</div>
            <div class="stat-number"><?= $totalUsers ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">⭐ Administrators</div>
            <div class="stat-number"><?= $adminUsers ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">👤 Regular Users</div>
            <div class="stat-number"><?= $regularUsers ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">⏳ Pending Approval</div>
            <div class="stat-number" style="color: <?= $pendingUsers > 0 ? '#f59e0b' : '#22c55e' ?>;">
                <?= $pendingUsers ?>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>📋 User Management</h3>
        </div>
        
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">👤</div>
                <p>No users found in the system.</p>
            </div>
        <?php else: ?>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="email-cell"><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="role-badge role-<?= ($user['role'] ?? 'user') === 'admin' ? 'admin' : 'user' ?>">
                                    <?= htmlspecialchars($user['role'] ?? 'user') ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars($user['status'] ?? 'active') ?>">
                                    <?= htmlspecialchars($user['status'] ?? 'active') ?>
                                </span>
                            </td>
                            <td>
                                <?php if (($user['status'] ?? 'active') === 'pending'): ?>
                                    <a class="approve-btn" href="index.php?page=users&approve=<?= $user['_id'] ?>">
                                        ✓ Approve
                                    </a>
                                <?php else: ?>
                                    <span class="no-action">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/Layout/layout.php';
