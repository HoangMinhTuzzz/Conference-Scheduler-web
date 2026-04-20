# Schedule Display Feature Documentation

## Overview

This feature displays conferences scheduled for today and this week on the schedule page, giving users and administrators a quick overview of upcoming meetings.

---

## Implementation Details

### 1. ConferenceModel.php - New Methods

#### `getTodayConferences($userRole = 'user')`
Retrieves all conferences scheduled for today.

**Parameters:**
- `$userRole` - User's role ('admin' or 'user')

**Returns:**
- Array of conference documents with `date = TODAY`

**Permissions:**
- Admin: Sees all conferences scheduled for today
- Users: See only admin-created conferences scheduled for today

**Example Query:**
```php
$conferences = $model->getTodayConferences('user');
// Returns: conferences where date = '2026-04-20' and created_by = 'admin@gmail.com'
```

---

#### `getThisWeekConferences($userRole = 'user')`
Retrieves all conferences scheduled for the current week (Monday to Sunday).

**Parameters:**
- `$userRole` - User's role ('admin' or 'user')

**Returns:**
- Array of conference documents with dates between Monday and Sunday of current week

**Permissions:**
- Admin: Sees all conferences scheduled this week
- Users: See only admin-created conferences scheduled this week

**Example Query:**
```php
$conferences = $model->getThisWeekConferences('user');
// Returns: conferences where date between 2026-04-20 and 2026-04-26
```

---

#### `getConferencesByDateRange($startDate, $endDate, $userRole = 'user')`
Retrieves conferences scheduled within a custom date range.

**Parameters:**
- `$startDate` - Start date (format: 'YYYY-MM-DD')
- `$endDate` - End date (format: 'YYYY-MM-DD')
- `$userRole` - User's role ('admin' or 'user')

**Returns:**
- Array of conference documents within the specified range

**Example Query:**
```php
$conferences = $model->getConferencesByDateRange('2026-04-20', '2026-04-30', 'user');
```

---

### 2. ScheduleController.php - Updates

The controller now fetches today's and this week's conferences:

```php
// Get conferences scheduled for today and this week
$todayConferences = $confModel->getTodayConferences($userRole);
$weekConferences = $confModel->getThisWeekConferences($userRole);
```

These variables are passed to the view for display.

---

### 3. schedule.php - Visual Display

#### Today's Conferences Section
- **Visibility:** Only shown if there are conferences scheduled for today
- **Background:** Purple gradient (`linear-gradient(135deg, #667eea, #764ba2)`)
- **Icon:** ⏰
- **Layout:** Responsive grid (auto-fill, min 300px per card)
- **Card Content:**
  - Conference title
  - Location (📍)
  - Date (📅)
  - Description preview (first 100 characters)
  - "View Details" button

#### This Week's Conferences Section
- **Visibility:** Only shown if there are conferences scheduled this week
- **Background:** Pink/Red gradient (`linear-gradient(135deg, #f093fb, #f5576c)`)
- **Icon:** 📆
- **Layout:** Responsive grid (auto-fill, min 300px per card)
- **Card Content:**
  - Conference title
  - Location (📍 with background highlight)
  - Date (📅 with background highlight)
  - Description preview (first 100 characters)
  - "View Details" button

#### Display Logic
```php
<?php if (!empty($todayConferences)) { ?>
    <!-- Display today's conferences -->
<?php } ?>

<?php if (!empty($weekConferences)) { ?>
    <!-- Display this week's conferences -->
<?php } ?>
```

---

## User Experience

### Regular User
1. Logs in and visits Schedule page
2. Sees:
   - ⏰ Today's Conferences (if any scheduled)
   - 📆 This Week's Conferences (if any scheduled)
   - Calendar view below with personal schedule

### Admin
1. Logs in and visits Schedule page
2. Sees:
   - ⏰ Today's Conferences (all conferences created by admin)
   - 📆 This Week's Conferences (all conferences created by admin)
   - Calendar view below with personal schedule

---

## Database Query Filters

### Today's Query
```
{
  "date": "2026-04-20",
  "created_by": "admin@gmail.com"  // for regular users only
}
```

### This Week's Query
```
{
  "date": {
    "$gte": "2026-04-20",  // Monday
    "$lte": "2026-04-26"   // Sunday
  },
  "created_by": "admin@gmail.com"  // for regular users only
}
```

---

## Styling Features

- **Glass morphism effect:** Semi-transparent cards with backdrop blur
- **Responsive grid:** Automatically adjusts number of columns based on screen size
- **Gradient backgrounds:** Distinct colors for different time periods
- **Hover effects:** Links have smooth transitions
- **Badge-style elements:** Location and date badges with light backgrounds

---

## Integration with Permission System

This feature respects the existing permission system:
- **Regular users** see only conferences created by admin
- **Admins** see all conferences
- Consistent with the conference list view permissions

---

## File Changes Summary

| File | Changes |
|------|---------|
| `models/ConferenceModel.php` | Added 3 new methods for fetching conferences by date |
| `controllers/ScheduleController.php` | Fetch today's and this week's conferences |
| `views/schedule.php` | Display two new sections for today/this week |

---

## Testing Steps

1. **Create admin account** (if not already done):
   ```bash
   php seed_admin.php
   ```

2. **Create test conferences:**
   - As admin, create conference for today
   - Create conference for tomorrow
   - Create conference for later this week

3. **Test as user:**
   - Create regular user account
   - Login as user
   - Go to Schedule page
   - Verify you see today's and this week's conferences

4. **Test as admin:**
   - Login as admin
   - Go to Schedule page
   - Verify you see all today's and this week's conferences

---

## Future Enhancements

1. **Upcoming Conferences:** Add "Next 7 Days" or "Next 30 Days" sections
2. **Conference Reminders:** Show alert badge if conference is in 24 hours
3. **User Registration:** Show which conferences you're registered for with badge
4. **Calendar Integration:** Sync with external calendar systems
5. **Search & Filter:** Add search across upcoming conferences
6. **Export:** Export conferences to calendar file (ICS format)

