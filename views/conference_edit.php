<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Conference</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input, textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #4f6ef7;
            outline: none;
            box-shadow: 0 0 5px rgba(79,110,247,0.3);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit {
            background: #4f6ef7;
        }

        .btn-submit:hover {
            background: #3b55d1;
        }

        .btn-cancel {
            background: #999;
        }

        .btn-cancel:hover {
            background: #777;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #555;
        }

        .back-link:hover {
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Conference</h2>

    <form method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($conference['title'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" id="dateInput" value="<?php echo htmlspecialchars($conference['date'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($conference['location'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Time Slot</label>
            <select name="slot" id="slotSelect" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                <option value="">-- Select Time Slot --</option>
                <option value="1" <?php echo (($conference['slot'] ?? null) == 1) ? 'selected' : ''; ?>>Slot 1: 9:00 AM - 10:00 AM</option>
                <option value="2" <?php echo (($conference['slot'] ?? null) == 2) ? 'selected' : ''; ?>>Slot 2: 10:00 AM - 11:00 AM</option>
                <option value="3" <?php echo (($conference['slot'] ?? null) == 3) ? 'selected' : ''; ?>>Slot 3: 11:00 AM - 12:00 PM</option>
                <option value="4" <?php echo (($conference['slot'] ?? null) == 4) ? 'selected' : ''; ?>>Slot 4: 12:00 PM - 1:00 PM</option>
                <option value="5" <?php echo (($conference['slot'] ?? null) == 5) ? 'selected' : ''; ?>>Slot 5: 1:00 PM - 2:00 PM</option>
                <option value="6" <?php echo (($conference['slot'] ?? null) == 6) ? 'selected' : ''; ?>>Slot 6: 2:00 PM - 3:00 PM</option>
                <option value="7" <?php echo (($conference['slot'] ?? null) == 7) ? 'selected' : ''; ?>>Slot 7: 8:00 PM - 9:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($conference['description'] ?? ''); ?></textarea>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-submit">Update Conference</button>
            <a href="index.php?page=conference" class="btn btn-cancel" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">Cancel</a>
        </div>
    </form>

    <a href="index.php?page=conference" class="back-link">← Back to Conferences</a>
</div>

<script>
    // Set minimum date to today (we allow today because slot 7 is available after 5 PM)
    document.getElementById('dateInput').min = new Date().toISOString().split('T')[0];

    const currentSlot = <?php echo $conference['slot'] ?? 'null'; ?>;
    const currentDate = document.getElementById('dateInput').value;

    // Function to load and update available slots
    function updateSlotAvailability(date) {
        const slotSelect = document.getElementById('slotSelect');
        
        if (!date) {
            return;
        }

        // Fetch available slots for the selected date
        fetch(`index.php?page=api_available_slots&date=${date}`)
            .then(response => response.json())
            .then(data => {
    if (data.success) {
        const bookedSlots = data.bookedSlots || [];
        const unavailableSlots = data.unavailableSlots || [];

        const slotSelect = document.getElementById('slotSelect');
        const options = slotSelect.querySelectorAll('option[value!=""]');

        const selectedDate = new Date(date);
        const now = new Date();

        const isToday = selectedDate.toDateString() === now.toDateString();
        const isAfter5PM = now.getHours() >= 17;

        // Reset options
        options.forEach(option => {
            option.disabled = false;
            option.style.display = 'block';
            option.textContent = option.textContent
                .replace(' (Booked)', '')
                .replace(' (Before 5 PM)', '')
                .replace(' (Past)', '');
        });

        // 👉 Nếu là hôm nay và sau 5PM -> chỉ cho Slot 7
        if (isToday && isAfter5PM) {
            options.forEach(option => {
                if (option.value !== "7") {
                    option.style.display = 'none'; // ẨN luôn
                }
            });
        }

        // Disable booked slots
        bookedSlots.forEach(slot => {
            const option = slotSelect.querySelector(`option[value="${slot}"]`);
            if (option) {
                option.disabled = true;
                option.textContent += ' (Booked)';
            }
        });

        // Disable unavailable slots
        unavailableSlots.forEach(slot => {
            const option = slotSelect.querySelector(`option[value="${slot}"]`);
            if (option && !bookedSlots.includes(slot)) {
                option.disabled = true;
                option.textContent += ' (Before 5 PM)';
            }
        });
    }
})
            .catch(error => console.error('Error fetching slots:', error));
    }
    
    // Load slot availability on page load
    updateSlotAvailability(currentDate);

    // Update available slots when date changes
    document.getElementById('dateInput').addEventListener('change', function() {
        updateSlotAvailability(this.value);
    });

    // Validate form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const dateInput = document.getElementById('dateInput');
        const slotSelect = document.getElementById('slotSelect');
        const todayDate = new Date();
        todayDate.setHours(0, 0, 0, 0);
        
        if (!dateInput.value) {
            e.preventDefault();
            alert('Please select a date');
            return;
        }
        
        if (!slotSelect.value) {
            e.preventDefault();
            alert('Please select a time slot');
            return;
        }
        
        if (slotSelect.options[slotSelect.selectedIndex].disabled) {
            e.preventDefault();
            alert('Selected slot is not available for this date');
            return;
        }
        
        // Validate that selected date is not in the past
        const selectedDate = new Date(dateInput.value);
        if (selectedDate < todayDate) {
            e.preventDefault();
            alert('Cannot edit conferences to past dates');
            return;
        }
    });
</script>

</body>
</html>
