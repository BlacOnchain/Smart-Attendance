<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  body { margin:0; padding:0; background:#0a2e22; font-family: Arial, Helvetica, sans-serif; }
  .wrapper { max-width: 480px; margin: 0 auto; padding: 32px 20px; }
  .card {
    background: #0f3a29;
    border: 1px solid rgba(16,185,129,0.25);
    border-radius: 24px;
    padding: 32px 28px;
    color: #ffffff;
  }
  .badge {
    display: inline-block;
    background: rgba(16,185,129,0.15);
    border: 1px solid rgba(16,185,129,0.35);
    color: #34d399;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 999px;
    margin-bottom: 20px;
  }
  h1 { font-size: 20px; margin: 0 0 12px; color: #ffffff; }
  p { font-size: 14px; line-height: 22px; color: rgba(255,255,255,0.7); margin: 0 0 20px; }
  .details {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 24px;
  }
  .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
  .label { color: rgba(255,255,255,0.5); }
  .value { color: #ffffff; font-weight: 600; text-align: right; }
  .footer { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 20px; }
</style>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <span class="badge">Security Alert</span>
      <h1>New sign-in detected</h1>
      <p>Hi {{ $user->name }}, we noticed a login to your Smart Attendance account from a device or location we haven't seen before.</p>

      <div class="details">
        <div class="row"><span class="label">Account</span><span class="value">{{ $user->email }}</span></div>
        <div class="row"><span class="label">IP Address</span><span class="value">{{ $ipAddress }}</span></div>
        <div class="row"><span class="label">Device</span><span class="value">{{ \Str::limit($userAgent, 40) }}</span></div>
        <div class="row"><span class="label">Time</span><span class="value">{{ $loginTime }}</span></div>
      </div>

      <p style="margin-bottom:0;">If this was you, no action is needed. If you don't recognize this activity, change your password immediately from your profile page.</p>
      <p class="footer">Smart Attendance Security Team</p>
    </div>
  </div>
</body>
</html>