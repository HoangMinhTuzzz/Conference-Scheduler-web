
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Schedule</title>
	<style>
		body {
			margin: 0;
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
			background: #f4f6f9;
		}

		/* Container */
		.container {
			width: 90%;
			max-width: 1200px;
			margin: 30px auto;
		}

		/* Header */
		.page-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 25px;
		}

		.page-header h1 {
			font-size: 30px;
			color: #1e293b;
			margin: 0;
		}

		/* Filter Section */
		.filter-section {
			background: white;
			padding: 20px;
			border-radius: 10px;
			margin-bottom: 25px;
			box-shadow: 0 5px 15px rgba(0,0,0,0.05);
			display: flex;
			flex-wrap: wrap;
			gap: 16px;
			align-items: flex-end;
		}

		.filter-group {
			display: flex;
			flex-direction: column;
		}

		.filter-group label {
			font-weight: 600;
			margin-bottom: 6px;
			color: #333;
			font-size: 14px;
		}

		.filter-group select {
			padding: 8px 12px;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 14px;
			cursor: pointer;
			transition: 0.2s;
		}

		.filter-group select:focus {
			border-color: #4f6ef7;
			outline: none;
			box-shadow: 0 0 5px rgba(79,110,247,0.3);
		}

		/* Table */
		.schedule-table {
			background: white;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 8px 20px rgba(0,0,0,0.08);
			border-collapse: collapse;
			width: 100%;
		}

		.schedule-table table {
			width: 100%;
			border-collapse: collapse;
		}

		.schedule-table th {
			background: linear-gradient(135deg, #667eea, #764ba2);
			color: white;
			padding: 15px;
			text-align: center;
			font-weight: 600;
		}

		.schedule-table td {
			padding: 15px;
			border: 1px solid #e5e7eb;
			vertical-align: top;
			min-height: 100px;
		}

		.schedule-table tr:hover {
			background-color: #f9fafb;
		}

		.conference-cell {
			background: linear-gradient(135deg, #667eea, #764ba2);
			color: white;
			padding: 12px;
			border-radius: 8px;
			margin-bottom: 8px;
			border-left: 4px solid #fff;
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
		}

		.conference-cell:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
		}

		.conference-cell-title {
			font-weight: bold;
			font-size: 13px;
		}

		.conference-cell-location {
			font-size: 12px;
			opacity: 0.9;
			margin-top: 4px;
		}

		.schedule-cell {
			background: linear-gradient(135deg, #f093fb, #f5576c);
			color: white;
			padding: 12px;
			border-radius: 8px;
			margin-bottom: 8px;
			border-left: 4px solid #fff;
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
		}

		.schedule-cell:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 16px rgba(245, 87, 108, 0.4);
		}

		.schedule-cell-title {
			font-weight: bold;
			font-size: 13px;
		}

		.schedule-cell-location {
			font-size: 12px;
			opacity: 0.9;
			margin-top: 4px;
		}

		.login-prompt {
			background: white;
			padding: 30px;
			border-radius: 10px;
			text-align: center;
			box-shadow: 0 5px 15px rgba(0,0,0,0.05);
		}

		.login-prompt p {
			color: #888;
			font-size: 16px;
			margin-bottom: 20px;
		}

		.btn-login {
			display: inline-block;
			padding: 12px 30px;
			background: #667eea;
			color: white;
			text-decoration: none;
			border-radius: 8px;
			font-weight: 600;
			transition: 0.3s;
		}

		.btn-login:hover {
			background: #5568d3;
		}

		/* Modal Styles */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			backdrop-filter: blur(5px);
			animation: fadeIn 0.3s ease;
		}

		.modal.active {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		@keyframes fadeIn {
			from { opacity: 0; }
			to { opacity: 1; }
		}

		@keyframes slideUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.modal-content {
			background: white;
			border-radius: 12px;
			width: 90%;
			max-width: 600px;
			max-height: 85vh;
			overflow-y: auto;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
			animation: slideUp 0.3s ease;
		}

		.modal-header {
			background: linear-gradient(135deg, #667eea, #764ba2);
			color: white;
			padding: 30px;
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
		}

		.modal-header h2 {
			margin: 0;
			font-size: 24px;
		}

		.modal-close {
			background: none;
			border: none;
			color: white;
			font-size: 28px;
			cursor: pointer;
			padding: 0;
			width: 30px;
			height: 30px;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: 0.3s;
		}

		.modal-close:hover {
			opacity: 0.8;
			transform: scale(1.1);
		}

		.modal-body {
			padding: 30px;
		}

		.detail-item {
			margin-bottom: 20px;
		}

		.detail-label {
			font-weight: 600;
			color: #667eea;
			margin-bottom: 6px;
			font-size: 13px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.detail-value {
			color: #555;
			font-size: 15px;
			line-height: 1.6;
		}

		.modal-footer {
			padding: 20px 30px;
			border-top: 1px solid #e0e0e0;
			display: flex;
			gap: 10px;
			justify-content: flex-end;
		}

		.btn {
			padding: 10px 18px;
			border-radius: 6px;
			border: none;
			cursor: pointer;
			font-weight: 600;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
		}

		.btn-view-full {
			background: #667eea;
			color: white;
		}

		.btn-view-full:hover {
			background: #5568d3;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
		}

		.btn-close {
			background: #e0e0e0;
			color: #333;
		}

		.btn-close:hover {
			background: #d0d0d0;
		}

		.view-only-badge {
			background: rgba(255, 255, 255, 0.3);
			padding: 6px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			border: 1px solid rgba(255, 255, 255, 0.5);
			display: inline-block;
			margin-top: 8px;
		}

		@media (max-width: 768px) {
			.container {
				margin: 15px auto;
			}

			.modal-content {
				width: 95%;
				max-height: 90vh;
			}

			.modal-header {
				padding: 20px;
			}

			.modal-body {
				padding: 20px;
			}

			.page-header h1 {
				font-size: 24px;
			}

			.schedule-table table {
				font-size: 12px;
			}

			.schedule-table td {
				padding: 8px;
				min-height: auto;
			}
		}
	</style>
</head>
<body>

<?php include __DIR__ . '/Layout/header.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$isLoggedIn = isset($_SESSION['user']);


// Xử lý chọn năm, tháng, tuần
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$week = isset($_GET['week']) ? intval($_GET['week']) : 1;

// Tính số tuần trong tháng
function weeksInMonth($year, $month) {
	$firstDay = new DateTime("$year-$month-01");
	$lastDay = new DateTime($firstDay->format('Y-m-t'));
	$firstWeek = (int)$firstDay->format('W');
	$lastWeek = (int)$lastDay->format('W');
	if ($lastWeek < $firstWeek) $lastWeek += 52; // handle year wrap
	return $lastWeek - $firstWeek + 1;
}
$weeksInMonth = weeksInMonth($year, $month);

// Lấy ngày đầu tuần theo tuần đã chọn
function getStartOfWeek($year, $month, $week) {
	$firstDay = new DateTime("$year-$month-01");
	$firstWeek = (int)$firstDay->format('W');
	$targetWeek = $firstWeek + $week - 1;
	$start = clone $firstDay;
	$start->modify('+' . (($targetWeek - $firstWeek) * 7) . ' days');
	$start->modify('Monday this week');
	return $start;
}
$startOfWeek = getStartOfWeek($year, $month, $week);

$weekDays = [];
for ($i = 0; $i < 7; $i++) {
	$d = clone $startOfWeek;
	$d->modify("+{$i} days");
	$label = $d->format('D (T.') . (($i+1)%7==0?8:($i+1)) . ')';
	$weekDays[] = [$label, $d->format('d/m')];
}
$slots = range(1, 7); // 7 ca/slot

function renderConferenceCell($conferences, $day, $dateStr) {
	if (!$conferences) return '';
	$output = '';
	foreach ($conferences as $conf) {
		// So sánh ngày (d/m)
		if (isset($conf['date']) && date('d/m', strtotime($conf['date'])) == $dateStr) {
			$confId = (string)($conf['_id'] ?? '');
			$output .= '<div class="conference-cell" onclick="openConferenceModal(\'' . htmlspecialchars($confId) . '\', event)" title="' . htmlspecialchars($conf['location'] ?? '') . '">';
			$output .= '<div class="conference-cell-title">' . htmlspecialchars($conf['title']) . '</div>';
			$output .= '<div class="conference-cell-location">📍 ' . htmlspecialchars($conf['location'] ?? 'N/A') . '</div>';
			$output .= '</div>';
		}
	}
	return $output;
}

function renderScheduleCell($schedules, $day, $slot, $dateStr) {
	if (!$schedules) return '';
	foreach ($schedules as $schedule) {
		// Compare date (d/m) and slot
		if (isset($schedule['date']) && date('d/m', strtotime($schedule['date'])) == $dateStr && ($schedule['slot'] ?? 0) == $slot) {
			echo '<div class="schedule-cell" title="' . htmlspecialchars($schedule['title'] ?? 'Schedule') . '">';
			echo '<div class="schedule-cell-title">' . htmlspecialchars($schedule['title'] ?? 'Schedule') . '</div>';
			if (isset($schedule['location'])) {
				echo '<div class="schedule-cell-location">📍 ' . htmlspecialchars($schedule['location']) . '</div>';
			}
			echo '</div>';
		}
	}
}

function renderConferenceCellBySlot($conferences, $slot, $dateStr) {
	if (!$conferences) return '';
	foreach ($conferences as $conf) {
		// So sánh ngày (d/m) và slot
		if (isset($conf['date']) && date('d/m', strtotime($conf['date'])) == $dateStr && ($conf['slot'] ?? 0) == $slot) {
			$confId = (string)($conf['_id'] ?? '');
			echo '<div class="conference-cell" onclick="openConferenceModal(\'' . htmlspecialchars($confId) . '\', event)" title="' . htmlspecialchars($conf['location'] ?? '') . '">';
			echo '<div class="conference-cell-title">' . htmlspecialchars($conf['title']) . '</div>';
			echo '<div class="conference-cell-location">📍 ' . htmlspecialchars($conf['location'] ?? 'N/A') . '</div>';
			echo '</div>';
		}
	}
}
?>

<div class="container">
	<div class="page-header">
		<h1>📅 Schedule</h1>
	</div>

	<?php if ($isLoggedIn) { ?>
		<!-- Today's Conferences Section -->
		<?php if (!empty($todayConferences)) { ?>
			<div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 24px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
				<h2 style="margin-top: 0; display: flex; align-items: center; gap: 10px;">
					<span style="font-size: 24px;">⏰</span> Today's Conferences
				</h2>
				<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
					<?php foreach ($todayConferences as $conf) { ?>
						<div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); cursor: pointer; transition: all 0.3s ease;" onclick="openConferenceModal('<?php echo (string)($conf['_id'] ?? ''); ?>', event)">
							<h3 style="margin: 0 0 10px 0; font-size: 18px;">
								<?php echo htmlspecialchars($conf['title'] ?? 'Untitled Conference'); ?>
							</h3>
							<p style="margin: 8px 0; font-size: 14px; opacity: 0.95;">
								📍 <strong><?php echo htmlspecialchars($conf['location'] ?? 'N/A'); ?></strong>
							</p>
							<p style="margin: 8px 0; font-size: 14px; opacity: 0.95;">
								📅 <strong><?php echo htmlspecialchars($conf['date'] ?? 'N/A'); ?></strong>
							</p>
							<?php if (!empty($conf['description'])) { ?>
								<p style="margin: 8px 0; font-size: 13px; opacity: 0.9;">
									<?php echo htmlspecialchars(substr($conf['description'], 0, 100)); ?>
									<?php echo strlen($conf['description']) > 100 ? '...' : ''; ?>
								</p>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>

		<!-- This Week's Conferences Section -->
		<?php if (!empty($weekConferences)) { ?>
			<div style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 24px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
				<h2 style="margin-top: 0; display: flex; align-items: center; gap: 10px;">
					<span style="font-size: 24px;">📆</span> This Week's Conferences
				</h2>
				<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px;">
					<?php foreach ($weekConferences as $conf) { ?>
						<div style="background: rgba(255,255,255,0.15); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); cursor: pointer; transition: all 0.3s ease;" onclick="openConferenceModal('<?php echo (string)($conf['_id'] ?? ''); ?>', event)">
							<h3 style="margin: 0 0 10px 0; font-size: 18px;">
								<?php echo htmlspecialchars($conf['title'] ?? 'Untitled Conference'); ?>
							</h3>
							<p style="margin: 8px 0; font-size: 14px; opacity: 0.95;">
								📍 <span style="display: inline-block; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 4px; font-weight: 600;">
									<?php echo htmlspecialchars($conf['location'] ?? 'N/A'); ?>
								</span>
							</p>
							<p style="margin: 8px 0; font-size: 14px; opacity: 0.95;">
								📅 <span style="display: inline-block; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 4px; font-weight: 600;">
									<?php echo htmlspecialchars($conf['date'] ?? 'N/A'); ?>
								</span>
							</p>
							<?php if (!empty($conf['description'])) { ?>
								<p style="margin: 8px 0; font-size: 13px; opacity: 0.9;">
									<?php echo htmlspecialchars(substr($conf['description'], 0, 100)); ?>
									<?php echo strlen($conf['description']) > 100 ? '...' : ''; ?>
								</p>
							<?php } ?>
							<a href="index.php?page=conference_detail&id=<?php echo (string)($conf['_id'] ?? ''); ?>" style="display: inline-block; margin-top: 10px; padding: 8px 16px; background: rgba(255,255,255,0.25); color: white; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 600; transition: 0.2s; border: 1px solid rgba(255,255,255,0.3);">
								View Details →
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>

	<div class="filter-section">
		<form method="get" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end; width: 100%;">
			<input type="hidden" name="page" value="schedule">
			
			<div class="filter-group">
				<label for="year">Year</label>
				<select id="year" name="year" onchange="this.form.submit()">
					<?php for($y = $year-2; $y <= $year+2; $y++) { ?>
						<option value="<?= $y ?>" <?= $y==$year?'selected':'' ?>><?= $y ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="filter-group">
				<label for="month">Month</label>
				<select id="month" name="month" onchange="this.form.submit()">
					<?php for($m=1;$m<=12;$m++) { ?>
						<option value="<?= $m ?>" <?= $m==$month?'selected':'' ?>><?= DateTime::createFromFormat('!m', $m)->format('M') ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="filter-group">
				<label for="week">Week</label>
				<select id="week" name="week" onchange="this.form.submit()">
					<?php for($w=1;$w<=$weeksInMonth;$w++) { ?>
						<option value="<?= $w ?>" <?= $w==$week?'selected':'' ?>><?= $w ?></option>
					<?php } ?>
				</select>
			</div>
		</form>
	</div>

	<?php if ($isLoggedIn) { ?>
		<div class="schedule-table">
			<table>
				<tr>
					<th>Date Slot</th>
					<?php foreach ($weekDays as $d) { echo '<th>' . $d[0] . '<br>' . $d[1] . '</th>'; } ?>
				</tr>
				<?php 
				// Check if there are any conferences with slot 0 (no slot assigned)
				$allDayConfs = array_filter($allDayConferences, function($conf) { return ($conf['slot'] ?? 0) == 0; });
				if (!empty($allDayConfs)) { 
				?>
					<tr style="background-color: #f0f4ff;">
						<td style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-weight: bold; text-align: center;">📆 All Day</td>
						<?php for ($i=0; $i<7; $i++) { ?>
							<td>
								<?php echo renderConferenceCell($allDayConfs, $i+1, $weekDays[$i][1]); ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
				<?php foreach ($slots as $slot) { ?>
					<tr>
						<td><?php echo $slot; ?></td>
						<?php for ($i=0; $i<7; $i++) { ?>
							<td>
								<?php renderScheduleCell($schedules, $i+1, $slot, $weekDays[$i][1]); ?>
								<?php renderConferenceCellBySlot($allDayConferences, $slot, $weekDays[$i][1]); ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
		</div>
	<?php } else { ?>
		<div class="login-prompt">
			<p>Please log in to view your personal schedule.</p>
			<a href="index.php?page=login" class="btn-login">Login</a>
		</div>
	<?php } ?>
</div>

<!-- Conference Detail Modal -->
<div id="conferenceModal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<h2 id="modalTitle">Conference Details</h2>
			<button class="modal-close" onclick="closeConferenceModal()">&times;</button>
		</div>
		<div class="modal-body" id="modalBody">
			<p style="text-align: center; color: #999;">Loading...</p>
		</div>
		<div class="modal-footer">
			<button class="btn btn-view-full" onclick="goToFullDetails()">View Full Details</button>
			<button class="btn btn-close" onclick="closeConferenceModal()">Close</button>
		</div>
	</div>
</div>

<script>
	let currentConferenceId = null;

	function openConferenceModal(confId, event) {
		if (event) event.stopPropagation();
		currentConferenceId = confId;
		const modal = document.getElementById('conferenceModal');
		modal.classList.add('active');
		
		// Fetch conference details
		fetch(`index.php?page=api_conference_detail&id=${confId}`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					renderConferenceModal(data.conference);
				} else {
					document.getElementById('modalBody').innerHTML = '<p style="color: #e53e3e;">Failed to load conference details.</p>';
				}
			})
			.catch(error => {
				console.error('Error:', error);
				document.getElementById('modalBody').innerHTML = '<p style="color: #e53e3e;">Error loading conference details.</p>';
			});
	}

	function renderConferenceModal(conf) {
		const slotMap = {
			1: 'Slot 1: 9:00 AM - 10:00 AM',
			2: 'Slot 2: 10:00 AM - 11:00 AM',
			3: 'Slot 3: 11:00 AM - 12:00 PM',
			4: 'Slot 4: 12:00 PM - 1:00 PM',
			5: 'Slot 5: 1:00 PM - 2:00 PM',
			6: 'Slot 6: 2:00 PM - 3:00 PM',
			7: 'Slot 7: 3:00 PM - 4:00 PM',
		};

		document.getElementById('modalTitle').textContent = conf.title || 'Conference';
		
		const modalBody = document.getElementById('modalBody');
		modalBody.innerHTML = `
			<div class="detail-item">
				<div class="detail-label">📅 Date</div>
				<div class="detail-value">${escapeHtml(conf.date || 'N/A')}</div>
			</div>

			<div class="detail-item">
				<div class="detail-label">📍 Location</div>
				<div class="detail-value">${escapeHtml(conf.location || 'N/A')}</div>
			</div>

			<div class="detail-item">
				<div class="detail-label">⏰ Time Slot</div>
				<div class="detail-value">${slotMap[conf.slot] || 'Not assigned'}</div>
			</div>

			<div class="detail-item">
				<div class="detail-label">📝 Description</div>
				<div class="detail-value">${escapeHtml(conf.description || 'No description provided')}</div>
			</div>

			<div class="detail-item">
				<div class="detail-label">👤 Created By</div>
				<div class="detail-value">${escapeHtml(conf.created_by || 'N/A')}</div>
			</div>

			<div class="view-only-badge">👁️ View Only - This is a read-only preview</div>
		`;
	}

	function closeConferenceModal() {
		const modal = document.getElementById('conferenceModal');
		modal.classList.remove('active');
		currentConferenceId = null;
	}

	function goToFullDetails() {
		if (currentConferenceId) {
			window.location.href = `index.php?page=conference_detail&id=${currentConferenceId}`;
		}
	}

	function escapeHtml(text) {
		const map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		};
		return text.replace(/[&<>"']/g, m => map[m]);
	}

	// Close modal when clicking outside
	document.getElementById('conferenceModal').addEventListener('click', function(event) {
		if (event.target === this) {
			closeConferenceModal();
		}
	});

	// Close modal with Escape key
	document.addEventListener('keydown', function(event) {
		if (event.key === 'Escape') {
			closeConferenceModal();
		}
	});
</script>

</body>
</html>
