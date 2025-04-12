<!DOCTYPE html>
<html>
<head>
    <title>Repair Proposal Completed</title>
</head>
<body>
    <h1>Repair Proposal Completed</h1>
    
    <p>Hello {{ $data['customer_name'] }},</p>
    
    <p>Your repair proposal #{{ $data['proposal_id'] }} has been completed.</p>
    
    <p>Details:</p>
    <ul>
        <li>Completion Date: {{ $data['completion_date'] }}</li>
        <li>Total Cost: ${{ number_format($data['total_cost'], 2) }}</li>
    </ul>
    
    <p>Thank you for your business!</p>
    
    <p>Best regards,<br>
    {{ config('app.name') }}</p>
</body>
</html>