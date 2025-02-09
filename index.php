<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.json">
    <title>Voucher Reset</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
        }

        .container {
            max-width: 500px;
            width: 100%;
            margin: 20px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            width: 100px; /* Adjust the size of the logo */
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        p {
            font-size: 14px;
            color: #ddd;
            margin-bottom: 25px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            text-align: left;
            margin-bottom: 8px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        }

        .form-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            pointer-events: none;
        }

        .form-group svg.icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            fill: #00bfff; /* Change this to your desired icon color */
            pointer-events: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        button:hover {
            background: linear-gradient(135deg, #0056b3, #0099cc);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Response Message Styles */
        #response {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            font-size: 14px;
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .success {
            background-color: rgba(212, 237, 218, 0.2);
            color: #d4edda;
            border: 1px solid rgba(195, 230, 203, 0.3);
        }

        .error {
            background-color: rgba(248, 215, 218, 0.2);
            color: #f8d7da;
            border: 1px solid rgba(245, 198, 203, 0.3);
        }

        /* Copyright Styles */
        .copyright {
            margin-top: 25px;
            font-size: 12px;
            color: #bbb;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 12px;
            }

            input, select, button {
                padding: 10px 35px 10px 10px;
                font-size: 14px;
            }

            .form-group i {
                right: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
      .then((registration) => {
        console.log('Service Worker registered with scope:', registration.scope);
      })
      .catch((error) => {
        console.error('Service Worker registration failed:', error);
      });
  }
</script>
    <div class="container">
        <!-- Add the logo here -->
        <img src="logo.png" alt="LOGO" class="logo">
        <h1>Voucher Reset Terminal</h1>
        <p>1. Enter Voucher <br/> 2. Select Camp <br/> 3. Press Button</p>
        <form id="resetMacForm">
            <div class="form-group">
                <label for="voucher">Voucher Number:</label>
                <!-- SVG Icon for Voucher -->
                <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM10 4h4v2h-4V4zm10 16H4V8h16v12z"/>
                    <path d="M11 10h2v2h-2zM15 10h2v2h-2zM7 10h2v2H7zM11 14h2v2h-2zM15 14h2v2h-2zM7 14h2v2H7z"/>
                </svg>
                <input type="text" id="voucher" name="voucher" placeholder="Enter voucher number" required>
            </div>
            <div class="form-group">
                <label for="mikrotik">Select Camp:</label>
                <i class="fas fa-campground"></i>
                <select id="mikrotik" name="mikrotik" required>
                    <option value="TGA-1">TGA-1</option>
                    <option value="TGA-2">TGA-2</option>
                    <!-- Add more MikroTik identities here -->
                </select>
            </div>
            <button type="submit">Reset Voucher</button>
        </form>

        <div id="response"></div>

        <!-- Copyright Notice -->
        <div class="copyright">
            &copy; 2023 Your FUTURENETWORKS. All rights reserved.
        </div>
    </div>

    <script>
        document.getElementById('resetMacForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form submission

            const voucher = document.getElementById('voucher').value;
            const mikrotik = document.getElementById('mikrotik').value;

            // Send data to the PHP backend using AJAX
            fetch('reset_mac.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ voucher, mikrotik }),
            })
            .then(response => response.json())
            .then(data => {
                const responseDiv = document.getElementById('response');
                responseDiv.style.display = 'block';

                if (data.success) {
                    responseDiv.className = 'success';
                    responseDiv.innerHTML = `✅ ${data.message}`;
                } else {
                    responseDiv.className = 'error';
                    responseDiv.innerHTML = `❌ ${data.message}`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const responseDiv = document.getElementById('response');
                responseDiv.style.display = 'block';
                responseDiv.className = 'error';
                responseDiv.innerHTML = '❌ An error occurred. Please try again.';
            });
        });
    </script>
</body>
</html>
