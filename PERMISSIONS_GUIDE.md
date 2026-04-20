# Conference Permission System Documentation

## Overview

This document describes the permission system implemented for the Conference Scheduler application. The system ensures that:

- **Regular Users**: Can only VIEW conferences created by the admin. They cannot create, edit, or delete conferences.
- **Admin Users**: Have full CRUD access (Create, Read, Update, Delete) to all conferences.

---

## Implementation Details

### 1. Database Changes

#### Conference Document Structure
Each conference now includes a `created_by` field:

```json
{
  "_id": ObjectId("..."),
  "title": "Conference Title",
  "date": "2024-04-20",
  "location": "City, Country",
  "description": "...",
  "created_by": "admin@gmail.com"  // New field tracking the creator
}
```

#### Migration
To add `created_by` field to existing conferences:
```bash
php migrate_conference_creator.php
```

This script updates all existing conferences without a `created_by` field to mark them as created by `admin@gmail.com`.

---

### 2. Backend Authorization

#### ConferenceModel.php - New Methods

**`getAllConferences($userRole, $userEmail)`**
- **Admin**: Returns all conferences
- **Regular User**: Returns only conferences where `created_by = 'admin@gmail.com'`

**`isCreatedByUser($conferenceId, $userEmail)`**
- Checks if a specific user created the conference

**`canModify($conferenceId, $userRole, $userEmail)`**
- **Admin**: Always returns `true` (can modify any conference)
- **Regular User**: Can only modify if they created it (checks `created_by` field)

#### ConferenceController.php - Authorization Checks

**create()**
- ✅ Admin: Can create conferences (stored with `created_by = 'admin@gmail.com'`)
- ❌ Users: Get "Unauthorized" message

**edit()**
- ✅ Admin: Can edit any conference
- ✅ Creator: Can edit their own conference (if applicable)
- ❌ Others: Get "Unauthorized" message

**delete()**
- ✅ Admin: Can delete any conference
- ✅ Creator: Can delete their own conference (if applicable)
- ❌ Others: Get "Unauthorized" message

---

### 3. Frontend Display

#### conference_list.php Changes

**Create Button** (Header)
- ✅ Visible: Only to admin users
- ❌ Hidden: From regular users

**Edit & Delete Buttons** (Per Conference Card)
- ✅ Visible: Only to admin users
- ❌ Hidden: From regular users

**View Button** (Per Conference Card)
- ✅ Visible: To all authenticated users

**Empty State Message**
- **Admin**: "Create your first one 🚀" with create button
- **User**: "No conferences available to view." without create button

---

## User Roles

### Regular User (`role: 'user'`)
**Capabilities:**
- ✅ View all conferences created by admin
- ✅ View conference details
- ❌ Create new conferences
- ❌ Edit conferences
- ❌ Delete conferences

**UI Experience:**
- Sees a read-only list of conferences
- Only "View" button available per conference
- No "Create" button in header

### Admin (`role: 'admin'`)
**Capabilities:**
- ✅ View all conferences
- ✅ Create new conferences
- ✅ Edit all conferences
- ✅ Delete all conferences

**UI Experience:**
- Sees "Create" button in header
- "Edit" and "Delete" buttons available on each conference
- Can manage conference lifecycle

---

## Session Data

User role and email are stored in `$_SESSION['user']`:

```php
$_SESSION['user'] = [
    'email' => 'user@example.com',
    '_id' => '507f1f77bcf86cd799439011',
    'role' => 'admin' // or 'user'
];
```

---

## Security Layer

### Backend Security (Most Important)
Even if a user somehow hacks the frontend to make requests, the backend validates:

```php
// In ConferenceController::create()
if ($userRole !== 'admin') {
    echo "Unauthorized: Only admins can create conferences";
    return;
}

// In ConferenceController::edit() and delete()
if (!$this->model->canModify($id, $userRole, $userEmail)) {
    echo "Unauthorized: Only the creator or admin can modify this conference";
    return;
}
```

### Frontend Security (UX & Clarity)
Buttons are conditionally hidden to provide a clean user experience and prevent confusion.

---

## Testing Checklist

### As Regular User:
- [ ] Can view conference list
- [ ] Can click "View" on each conference
- [ ] Cannot see "Create" button in header
- [ ] Cannot see "Edit" button on conferences
- [ ] Cannot see "Delete" button on conferences
- [ ] Cannot access `index.php?page=conference_create` directly
- [ ] Cannot access `index.php?page=conference_edit&id=X` directly
- [ ] Cannot access `index.php?page=conference_delete&id=X` directly

### As Admin:
- [ ] Can view all conferences
- [ ] Can see "Create" button in header
- [ ] Can see "Edit" button on each conference
- [ ] Can see "Delete" button on each conference
- [ ] Can create, edit, and delete conferences normally

---

## Future Enhancements

1. **Granular Roles**: Add roles like 'organizer', 'reviewer', 'sponsor'
2. **Conference Ownership**: Allow multiple users to co-create conferences
3. **Approval Workflow**: Require admin approval for user-created conferences
4. **Audit Logging**: Track who created/modified each conference and when
5. **Access Control Lists**: Allow admin to assign view/edit permissions to specific users

---

## Files Modified

1. `models/ConferenceModel.php` - Added authorization methods
2. `controllers/ConferenceController.php` - Added role-based checks
3. `views/conference_list.php` - Conditional button visibility

## Files Created

1. `migrate_conference_creator.php` - Migration script for existing data

---

## Quick Reference

| Action | Admin | User |
|--------|-------|------|
| View Conferences | ✅ | ✅ (only admin-created) |
| Create Conference | ✅ | ❌ |
| Edit Conference | ✅ | ❌ |
| Delete Conference | ✅ | ❌ |

