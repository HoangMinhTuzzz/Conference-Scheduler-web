<?php
/**
 * Time Slot Helper
 * Manages conference time slots (1-7) corresponding to 9 AM to 9 PM
 */

class TimeSlotHelper {
    // Define time slots: slot number => [start_time, end_time]
    private static $timeSlots = [
        1 => ['09:00', '10:00', '9:00 AM - 10:00 AM'],
        2 => ['10:00', '11:00', '10:00 AM - 11:00 AM'],
        3 => ['11:00', '12:00', '11:00 AM - 12:00 PM'],
        4 => ['12:00', '13:00', '12:00 PM - 1:00 PM'],
        5 => ['13:00', '14:00', '1:00 PM - 2:00 PM'],
        6 => ['14:00', '15:00', '2:00 PM - 3:00 PM'],
        7 => ['15:00', '16:00', '3:00 PM - 4:00 PM'],
    ];

    /**
     * Get all time slots
     * @return array
     */
    public static function getTimeSlots() {
        return self::$timeSlots;
    }

    /**
     * Get time range for a specific slot
     * @param int $slot
     * @return array|null [start_time, end_time, display_text]
     */
    public static function getSlotTime($slot) {
        return self::$timeSlots[$slot] ?? null;
    }

    /**
     * Get display text for a slot
     * @param int $slot
     * @return string
     */
    public static function getSlotDisplay($slot) {
        $slotData = self::$timeSlots[$slot] ?? null;
        return $slotData ? $slotData[2] : "Slot $slot";
    }

    /**
     * Get all slots as options for select dropdown
     * @return array
     */
    public static function getSlotOptions() {
        $options = [];
        foreach (self::$timeSlots as $slot => $data) {
            $options[$slot] = $data[2];
        }
        return $options;
    }

    /**
     * Check if slot is valid
     * @param int $slot
     * @return bool
     */
    public static function isValidSlot($slot) {
        return isset(self::$timeSlots[$slot]);
    }
}
?>
