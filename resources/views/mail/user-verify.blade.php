<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dynamic HTML Email Template</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .header img {
            max-width: 200px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .content p {
            margin-bottom: 15px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <x-application-logo />
        </div>

        <div class="content">
            <h1>Exciting News!</h1>
            <p>We're thrilled to announce...</p>

            <div class="image-container">
                <img src="https://via.placeholder.com/400x300" alt="Product Image">
            </div>

            <p>...</p>

            <p><a class="button" href="#">Learn More</a></p>
        </div>

        <div class="footer">
            &copy; 2023 Your Company. All rights reserved.
        </div>

    </div>

</body>

</html>
