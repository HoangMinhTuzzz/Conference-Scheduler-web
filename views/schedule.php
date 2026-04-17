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
<div style="margin:20px">
	<form method="get" style="margin-bottom:10px;display:flex;gap:20px;align-items:center">
		<label>Year
			<select name="year" onchange="this.form.submit()">
				<?php for($y = $year-2; $y <= $year+2; $y++) { ?>
					<option value="<?= $y ?>" <?= $y==$year?'selected':'' ?>><?= $y ?></option>
				<?php } ?>
			</select>
		</label>
		<label>Month
			<select name="month" onchange="this.form.submit()">
				<?php for($m=1;$m<=12;$m++) { ?>
					<option value="<?= $m ?>" <?= $m==$month?'selected':'' ?>><?= DateTime::createFromFormat('!m', $m)->format('M') ?></option>
				<?php } ?>
			</select>
		</label>
		<label>Week
			<select name="week" onchange="this.form.submit()">
				<?php for($w=1;$w<=$weeksInMonth;$w++) { ?>
					<option value="<?= $w ?>" <?= $w==$week?'selected':'' ?>><?= $w ?></option>
				<?php } ?>
			</select>
		</label>
	</form>
	<table border="1" cellpadding="8" cellspacing="0" style="width:100%;text-align:center;border-collapse:collapse">
		<tr style="background:#232e7a;color:#fff">
			<th>Date Slot</th>
			<?php foreach ($weekDays as $d) { echo '<th>' . $d[0] . '<br>' . $d[1] . '</th>'; } ?>
		</tr>
		<?php foreach ($slots as $slot) { ?>
			<tr>
				<td><?php echo $slot; ?></td>
				<?php for ($i=0; $i<7; $i++) { ?>
					<td style="min-width:120px;vertical-align:top">
						<?php if ($isLoggedIn) renderScheduleCell($schedules, $i+1, $slot, $weekDays[$i][1]); ?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</table>
	<?php if (!$isLoggedIn) { ?>
		<div style="margin-top:20px;color:#888">Vui lòng đăng nhập để xem lịch cá nhân.</div>
	<?php } ?>
</div>
