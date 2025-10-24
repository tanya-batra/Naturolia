<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; padding: 20px;">
        <h2 style="color: #97351E; border-bottom: 2px solid #97351E; padding-bottom: 10px;">New Contact Form Submission</h2>

        <p><strong style="color: #97351E;">Name:</strong> {{ $data['name'] }}</p>
        <p><strong style="color: #97351E;">Email:</strong> {{ $data['email'] }}</p>
        <p><strong style="color: #97351E;">Subject:</strong> {{ $data['subject'] }}</p>
        
        <p><strong style="color: #97351E;">Message:</strong></p>
        <div style="background-color: #f4f4f4; padding: 15px; border-left: 4px solid #97351E; border-radius: 4px;">
            {{ $data['message'] }}
        </div>
    </div>
</body>
</html>
