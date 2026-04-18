
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Schedule</title>
	<style>
		body {
			margin: 0;
			font-family: 'Segoe UI', sans-serif;
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

function renderScheduleCell($schedules, $day, $slot, $dateStr) {
	if (!$schedules) return '';
	foreach ($schedules as $sch) {
		// So sánh ngày (d/m) và slot
		if (isset($sch['date']) && date('d/m', strtotime($sch['date'])) == $dateStr && $sch['slot'] == $slot) {
			echo '<div style="font-weight:bold">' . htmlspecialchars($sch['subject']) . '</div>';
			echo '<div>' . htmlspecialchars($sch['room']) . '</div>';
			echo '<div>' . htmlspecialchars($sch['teacher']) . '</div>';
			if (!empty($sch['online_link'])) {
				echo '<div><a href="' . htmlspecialchars($sch['online_link']) . '" target="_blank">';
				echo '<span style="color:#3366cc">&#128187; Online meet</span></a></div>';
			}
			if (!empty($sch['attended'])) {
				echo '<div style="color:green">&#x2611; Attended</div>';
			}
			echo '<div><b>Time: ' . htmlspecialchars($sch['time']) . '</b></div>';
		}
	}
}
?>

<div class="container">
	<div class="page-header">
		<h1>📅 Schedule</h1>
	</div>

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
				<?php foreach ($slots as $slot) { ?>
					<tr>
						<td><?php echo $slot; ?></td>
						<?php for ($i=0; $i<7; $i++) { ?>
							<td>
								<?php renderScheduleCell($schedules, $i+1, $slot, $weekDays[$i][1]); ?>
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

</body>
</html>
