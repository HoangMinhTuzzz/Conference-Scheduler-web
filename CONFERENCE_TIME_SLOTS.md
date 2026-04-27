# Conference Time Slots Feature

## Overview

Conferences now support time slot scheduling. Each conference can be assigned to one of 7 time slots that correspond to the schedule page's daily time divisions. This allows conferences to appear in the correct time slot on the schedule calendar view.

---

## Time Slot Mapping

The 7 time slots divide the day from 9 AM to 9 PM:

| Slot | Time Range | Display |
|------|-----------|---------|
| 1 | 9:00 AM - 10:00 AM | Slot 1: 9:00 AM - 10:00 AM |
| 2 | 10:00 AM - 11:00 AM | Slot 2: 10:00 AM - 11:00 AM |
| 3 | 11:00 AM - 12:00 PM | Slot 3: 11:00 AM - 12:00 PM |
| 4 | 12:00 PM - 1:00 PM | Slot 4: 12:00 PM - 1:00 PM |
| 5 | 1:00 PM - 2:00 PM | Slot 5: 1:00 PM - 2:00 PM |
| 6 | 2:00 PM - 3:00 PM | Slot 6: 2:00 PM - 3:00 PM |
| 7 | 3:00 PM - 4:00 PM | Slot 7: 3:00 PM - 4:00 PM |

---

## Features

### 1. Create Conference with Time Slot
When creating a new conference (admin only), a dropdown menu allows selecting a time slot (required field).

**Path:** `index.php?page=conference_create`

**Form Field:**
```
Time Slot: [Dropdown 1-7]
```

### 2. Edit Conference Time Slot
Existing conferences can have their time slot updated.

**Path:** `index.php?page=conference_edit&id=<conference_id>`

**Form Field:**
```
Time Slot: [Dropdown with current slot pre-selected]
```

### 3. View Conference Details
The conference detail page displays the assigned time slot.

**Path:** `index.php?page=conference_detail&id=<conference_id>`

**Display:**
```
⏰ Time Slot: Slot 1: 9:00 AM - 10:00 AM
```

### 4. Conference List Display
Conference cards in the list view show the time slot.

**Display:**
```
⏰ Slot 1: 9:00-10:00
```

### 5. Schedule Calendar Integration
Conferences appear in the schedule table at their assigned time slot row.

**Example:**
```
If conference has slot=3, it appears in row "Slot 3" 
in the corresponding date column
```

---

## Database Schema

Each conference document now includes:

```javascript
{
  "_id": ObjectId("..."),
  "title": "Conference Title",
  "date": "2026-04-20",
  "location": "City, Country",
  "description": "Description",
  "slot": 1,  // Time slot 1-7
  "created_by": "admin@gmail.com",
  ...
}
```

---

## Implementation Details

### Database

**Field:** `slot`
**Type:** Integer
**Values:** 1-7 (or 0 for unassigned in legacy documents)
**Required:** Yes (for new conferences)

### Backend

**TimeSlotHelper.php** (new file)
```php
class TimeSlotHelper {
    public static function getTimeSlots()           // Get all slots
    public static function getSlotTime($slot)       // Get time range
    public static function getSlotDisplay($slot)    // Get display text
    public static function getSlotOptions()         // Get dropdown options
    public static function isValidSlot($slot)       // Validate slot
}
```

### Controller Updates

**ConferenceController.php**
- `create()`: Converts slot to integer before saving
- `edit()`: Converts slot to integer before saving

### View Updates

**conference_create.php**
- Added time slot dropdown (required)

**conference_edit.php**
- Added time slot dropdown with current value pre-selected

**conference_detail.php**
- Display time slot with ⏰ icon

**conference_list.php**
- Show time slot on each conference card

**schedule.php**
- Conferences display in their assigned slot row
- New function `renderConferenceCellBySlot()` displays conferences by slot
- Updated table to show conferences alongside schedule items

---

## Migration

For existing conferences without a slot assigned, run:

```bash
php migrate_conference_slot.php
```

This will:
- Add `slot: 1` to all conferences missing the slot field
- Default: Slot 1 (9:00 AM - 10:00 AM)

---

## Usage Examples

### Create Conference with Slot 3

1. Go to `index.php?page=conference_create` (admin only)
2. Fill in Title, Date, Location, Description
3. Select **Slot 3: 11:00 AM - 12:00 PM** from dropdown
4. Click "Create Conference"

Result: Conference appears in schedule table at Slot 3 row

### Edit Conference to Different Slot

1. Go to conference detail page
2. Click "Edit"
3. Change Time Slot dropdown
4. Click "Update Conference"

Result: Conference moves to new time slot in schedule

### View in Schedule

1. Go to `index.php?page=schedule`
2. Select appropriate year/month/week
3. Conferences appear in their assigned slot rows:
   - Regular schedule items in same row
   - Multiple items stack visually

---

## UI/UX

### Conference Card Time Display
```
⏰ Slot 1: 9:00-10:00
```

### Detail Page Time Display
```
⏰ Time Slot: Slot 1: 9:00 AM - 10:00 AM
```

### Schedule Table
```
Conferences appear in their slot rows with:
- Purple gradient background
- Conference title
- Location with 📍 icon
- Border styling to distinguish from schedule items
```

---

## Validation

**Form Validation:**
- Slot field is required
- Slot must be between 1-7
- Controller converts to integer type

**Backend Validation:**
- TimeSlotHelper::isValidSlot() checks if slot is valid (1-7)

---

## Permissions

- **Regular Users:** Can view conferences and see them in schedule
- **Admins:** Can create/edit/delete conferences and assign time slots

---

## Technical Notes

1. **Slot Type:** Integer (1-7), not string
2. **Default:** Existing conferences default to slot 1
3. **Display:** Time slots are formatted consistently across all views
4. **Storage:** Stored in MongoDB as integer field
5. **Integration:** Works seamlessly with existing permission system

---

## Future Enhancements

1. **Recurring Conferences:** Assign same slot across multiple dates
2. **Slot Availability:** Show which slots are occupied
3. **Conflicts:** Warn if two conferences scheduled same date/slot
4. **Time Customization:** Allow admins to customize time slot ranges
5. **Calendar Export:** Include time slot in exported calendar files

