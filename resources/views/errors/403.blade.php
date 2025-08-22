<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Denied</title>
    <style>
        body {
            background-color: #1e1e1e; /* Dark grey background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
            background: #2c2c2c; /* Slightly lighter grey box */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            max-width: 500px;
            width: 90%;
        }

        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #ff4d4f; /* Red tone for the error code */
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 1.25rem;
            color: #f0f0f0;
            margin-bottom: 25px;
        }

        .home-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .home-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <div class="error-message">You do not have permission to access this page.</div>
        <a href="{{ url('/') }}" class="home-link">Back to Home</a>
    </div>
</body>
</html>
