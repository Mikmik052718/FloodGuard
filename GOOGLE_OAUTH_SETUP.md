# Google OAuth Setup Guide

## Prerequisites
1. Google Cloud Console account
2. CodeIgniter 4 application

## Step 1: Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" and enable it
4. Create OAuth 2.0 credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Add authorized redirect URIs:
     - `http://localhost/FloodGuard/public/index.php/auth/google/callback`
     - `https://yourdomain.com/auth/google/callback` (for production)
   - Copy the Client ID and Client Secret

## Step 2: Configure Your Application

### Update Google Configuration
Edit `app/Config/Google.php`:

```php
public string $clientId = 'YOUR_CLIENT_ID_HERE';
public string $clientSecret = 'YOUR_CLIENT_SECRET_HERE';
public string $redirectUri = 'http://localhost/FloodGuard/public/index.php/auth/google/callback';
```

### Environment Variables (Recommended)
Add to your `.env` file:
```
google.clientId=YOUR_CLIENT_ID_HERE
google.clientSecret=YOUR_CLIENT_SECRET_HERE
google.redirectUri=http://localhost/FloodGuard/public/index.php/auth/google/callback
```

## Step 3: Database Migration

Run the migration to add Google OAuth fields to the users table:

```bash
php spark migrate
```

## Step 4: Test the Implementation

1. Visit `/auth/uslogin`
2. Click "Sign in with Google"
3. Complete the OAuth flow
4. Verify user creation/login

## Troubleshooting

### Common Issues:

1. **"Invalid OAuth state" error**
   - Clear your browser cookies and try again
   - Check that sessions are working properly

2. **"Google login failed" error**
   - Verify your Client ID and Secret are correct
   - Ensure the redirect URI matches exactly in Google Console
   - Check that the Google+ API is enabled

3. **"Failed to get access token" error**
   - Verify your credentials are correct
   - Check network connectivity

### Debug Mode
Enable error logging in `app/Config/Logger.php` to see detailed error messages.

## Security Notes

- Always use HTTPS in production
- Validate the redirect URI in your OAuth configuration
- Store client secrets securely (never in version control)
- Implement proper session management
- Consider implementing account linking for existing users

## Production Deployment

1. Update the redirect URI in Google Cloud Console to your production domain
2. Update the `redirectUri` in your configuration
3. Ensure proper SSL/HTTPS setup
4. Test thoroughly before going live
