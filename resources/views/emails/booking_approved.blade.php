<!DOCTYPE html>
<html>
<head>
    <title>Booking Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #2c3e50;">Booking Approved Successfully!</h2>
        <p>Hello {{ $studentName }},</p>
        <p>Good news! Your booking request has been approved by the admin.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #4CAF50; margin: 20px 0;">
            <p style="margin: 0;"><strong>Equipment:</strong> {{ $booking->equipment->name }} (x{{ $booking->quantity }})</p>
            <p style="margin: 5px 0 0 0;"><strong>Pickup Date:</strong> {{ $booking->booking_date }} at {{ $booking->pickup_time }}</p>
            <p style="margin: 5px 0 0 0;"><strong>Return Date:</strong> {{ $booking->return_date }}</p>
        </div>

        <p>Please make sure to bring your student ID when collecting the equipment.</p>
        <p>Best regards,<br>Sports Rental Team</p>
    </div>
</body>
</html>
