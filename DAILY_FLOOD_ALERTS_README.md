# Daily Flood Prediction Alert System

## Overview
This system sends automated daily flood prediction alerts to users via SMS and/or Email based on their stored probability thresholds (25%, 50%, or 70%). Alerts are sent once per day at 7 PM Manila time when tomorrow's flood probability meets or exceeds the user's threshold.

## Files Created/Modified

### New Files
1. **app/Controllers/Alerts.php** - Main alert controller with test and send methods
2. **app/Database/Migrations/2025-01-20-000001_AddFloodAlertFieldsToUsers.php** - Migration for new user fields
3. **SQL_ALTER_USERS_TABLE.sql** - Manual SQL for adding fields to users table

### Modified Files
1. **app/Models/UserModel.php** - Added `last_flood_alert_date` and `last_flood_alert_probability` to allowedFields
2. **app/Controllers/Email_cont.php** - Added `sendFloodPredictionAlert()` method
3. **app/Controllers/SmsController.php** - Added `sendFloodPredictionAlertSMS()` method
4. **app/Config/Routes.php** - Added routes for alert endpoints

## Database Changes

### New Fields in `users` Table
```sql
ALTER TABLE `users` 
ADD COLUMN `last_flood_alert_date` DATE NULL AFTER `last_water_alert_level`,
ADD COLUMN `last_flood_alert_probability` DECIMAL(10,4) NULL AFTER `last_flood_alert_date`;
```

**OR** run the migration:
```bash
php spark migrate
```

## How It Works

### 1. Data Source
- Uses the same prediction endpoint as the Daily page: `/flood/predict-ajax`
- Fetches 5-day outlook from Open-Meteo API
- Runs Python ML model to predict flood probability
- Extracts tomorrow's data (days[1]) for alert comparison

### 2. Alert Logic
- Runs at 7 PM Manila time daily (via cron)
- Converts probability to percentage: `percent = probability * 1000`
- Queries users where:
  - `alert_email_enabled = 1` OR `alert_sms_enabled = 1`
  - `percent >= alert_min_probability`
  - `last_flood_alert_date != today` (prevents duplicate alerts)

### 3. Notification Delivery
- **Email**: Sends via CodeIgniter Email service with formatted HTML message
- **SMS**: Sends via TextBee API with concise text message
- Updates `last_flood_alert_date` and `last_flood_alert_probability` after sending

## Routes

### Test Route (Dry Run)
```
GET /alerts/test-daily
```
- Shows which users would receive alerts
- Displays user details, thresholds, and alert status
- Does NOT send actual alerts
- Useful for testing and debugging

### Send Route (Production)
```
GET /alerts/send-daily
```
- Actually sends alerts to qualifying users
- Should be called by cron job at 7 PM Manila time
- Logs all activity to CodeIgniter logs

### CLI Command
```bash
php spark alerts:send-daily
```
- Same as send route but via CLI
- Recommended for cron jobs

## Setup Instructions

### 1. Database Setup
Run the SQL manually or use migration:
```bash
cd /path/to/FloodGuard
php spark migrate
```

### 2. Test the System
Visit the test route to verify logic:
```
http://localhost/FloodGuard/public/index.php/alerts/test-daily
```

This will show:
- Tomorrow's predicted probability
- List of all users with alerts enabled
- Who would receive alerts and why
- Who would be skipped and why

### 3. Manual Test Send
To manually trigger alerts (for testing):
```
http://localhost/FloodGuard/public/index.php/alerts/send-daily
```

### 4. Schedule Cron Job

#### Option A: Add to existing autopost cron
Edit `docker/cron/autopost`:
```bash
# Existing autopost at 8 AM
0 8 * * * cd /var/www/html && php spark autopost >> /var/log/cron.log 2>&1

# Add daily flood alerts at 7 PM Manila time
0 19 * * * cd /var/www/html && php spark alerts:send-daily >> /var/log/cron.log 2>&1
```

#### Option B: Windows Task Scheduler (for local dev)
1. Open Task Scheduler
2. Create Basic Task
3. Set trigger: Daily at 7:00 PM
4. Action: Start a program
5. Program: `php`
6. Arguments: `spark alerts:send-daily`
7. Start in: `D:\xampp\htdocs\FloodGuard`

#### Option C: Linux crontab
```bash
crontab -e
```
Add:
```
0 19 * * * cd /path/to/FloodGuard && php spark alerts:send-daily >> /var/log/flood-alerts.log 2>&1
```

## Alert Message Templates

### Email Template
```
Subject: Flood Alert: [PREDICTION] Predicted for Tomorrow

Hello [Username],

Flood Prediction Alert

Based on the latest weather data and flood prediction model, tomorrow has a significant flood probability:

Date: [Tomorrow's Date]
Flood Probability: [XX.XX]%
Prediction: [FLOOD/NO FLOOD]
Your Alert Threshold: [User's Threshold]%

[If FLOOD predicted:]
⚠️ HIGH RISK: Flooding is predicted. Please take necessary precautions and prepare for possible evacuation.

[If NO FLOOD but elevated:]
While flooding is not definitively predicted, the probability is elevated. Please stay alert and monitor updates.

For more details, visit: [Link to Daily Page]

Stay safe,
AlertoMarikeno Team
```

### SMS Template
```
Hello [Username],

FLOOD PREDICTION ALERT

Tomorrow ([Date]) has elevated flood risk:
Probability: [XX.XX]%
Prediction: [FLOOD/NO FLOOD]
Your threshold: [Threshold]%

[If FLOOD:]
HIGH RISK: Flooding predicted. Take precautions and prepare for possible evacuation.

[If elevated:]
Probability is elevated. Stay alert and monitor updates.

View details: [Link]

Stay safe,
AlertoMarikeno Team
```

## User Threshold Settings

Users set their `alert_min_probability` in two ways:

### 1. During Registration
- Choose alert method (Email/SMS/Both)
- Select minimum probability: 25%, 50%, or 70%

### 2. Via Hazard Map Location Save
- When user saves location on hazard map
- System automatically sets threshold based on zone:
  - **Green Zone** → 25%
  - **Yellow Zone** → 50%
  - **Red Zone** → 70%

## Monitoring and Logs

### Check Logs
```bash
tail -f writable/logs/log-[date].php
```

Look for entries like:
```
INFO - Starting daily flood prediction alerts at 2025-01-20 19:00:00
INFO - Tomorrow's prediction: 2025-01-21 - 45.23% - NO FLOOD
INFO - Email alert sent to user@example.com
INFO - SMS alert sent to +639123456789
INFO - Daily flood alerts completed: 5 emails, 3 SMS sent, 2 skipped
```

### Common Issues

**No alerts sent:**
- Check if any users have `alert_min_probability` <= tomorrow's probability
- Verify users have `alert_email_enabled` or `alert_sms_enabled` = 1
- Check if alerts were already sent today (last_flood_alert_date)

**Python prediction fails:**
- Check Python path in `getPythonExe()` method
- Verify `python/predict.py` exists and is executable
- Check Open-Meteo API is accessible

**Email not sending:**
- Verify email configuration in `app/Config/Email.php`
- Check SMTP credentials
- Review email logs

**SMS not sending:**
- Verify TextBee API key and device ID in SmsController
- Check phone numbers are in +63 format
- Review TextBee API logs

## Testing Checklist

- [ ] Database migration successful
- [ ] Test route shows correct user list
- [ ] Test route shows correct probability calculation
- [ ] Manual send route works
- [ ] Email alerts received
- [ ] SMS alerts received
- [ ] Duplicate prevention works (no second alert same day)
- [ ] Cron job scheduled correctly
- [ ] Logs show successful execution

## Future Enhancements

1. **User Location-Based Alerts**
   - Currently uses fixed lat/lon (14.657293, 121.11524)
   - Could fetch predictions for each user's saved location
   - Requires per-user prediction computation

2. **Multi-Day Outlook**
   - Alert if ANY of next 5 days exceeds threshold
   - Include which days in alert message

3. **Alert History Table**
   - Track all sent alerts
   - Enable alert analytics
   - Better duplicate prevention

4. **Admin Dashboard**
   - View alert statistics
   - Manual trigger interface
   - User threshold management

5. **Customizable Alert Time**
   - Let users choose preferred alert time
   - Multiple alerts per day option

## Support

For issues or questions:
1. Check logs in `writable/logs/`
2. Test with dry-run route first
3. Verify database fields exist
4. Confirm cron job is running

## Version History

- **v1.0** (2025-01-20): Initial implementation
  - Daily alerts at 7 PM Manila time
  - Email and SMS support
  - Threshold-based filtering (25/50/70%)
  - Once-per-day delivery
  - Test/dry-run route
