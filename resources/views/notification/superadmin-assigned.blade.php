<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
        }
        .content {
            padding: 15px;
        }
        p {
            font-size: 12px; 
            line-height: 1.5;
            color: #292828; 
        }
        .footer {
            text-align: center;
            padding: 5px 0;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Superadmin Role Set</h1>
            <img src="{{ $message->embed(public_path('assets/img/Logo_1.png')) }}" alt="MediKeep Logo" style="width: 50px; height: auto;">
        </div>
        <div class="content">
            <p>Hello {{ $user->name }} you have been set with Superadmin role.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} MediKeep. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
