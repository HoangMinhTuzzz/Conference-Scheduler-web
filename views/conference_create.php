<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Conference</title>

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

        .btn {
            width: 100%;
            padding: 12px;
            background: #4f6ef7;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #3b55d1;
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
    <h2>Create Conference</h2>

    <form method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" required>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" required>
        </div>

        <div class="form-group">
            <label>Time Slot</label>
            <select name="slot" required style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                <option value="">-- Select Time Slot --</option>
                <option value="1">Slot 1: 9:00 AM - 10:00 AM</option>
                <option value="2">Slot 2: 10:00 AM - 11:00 AM</option>
                <option value="3">Slot 3: 11:00 AM - 12:00 PM</option>
                <option value="4">Slot 4: 12:00 PM - 1:00 PM</option>
                <option value="5">Slot 5: 1:00 PM - 2:00 PM</option>
                <option value="6">Slot 6: 2:00 PM - 3:00 PM</option>
                <option value="7">Slot 7: 3:00 PM - 4:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>

        <button type="submit" class="btn">Create Conference</button>
    </form>

    <a href="index.php?page=conference" class="back-link">← Back to Conferences</a>
</div>

</body>
</html>