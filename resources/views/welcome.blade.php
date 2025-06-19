<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Products API - Welcome</title>
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <style>
            body {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: #f9fafb;
                color: #1b1b18;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            }
            .container {
                background: #fff;
                border-radius: 1rem;
                box-shadow: 0 4px 24px rgba(0,0,0,0.07);
                padding: 2.5rem 2rem;
                max-width: 420px;
                text-align: center;
            }
            h1 {
                font-size: 2.2rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }
            p {
                font-size: 1.1rem;
                color: #555;
                margin-bottom: 2rem;
            }
            .api-info {
                background: #f3f4f6;
                border-radius: 0.5rem;
                padding: 1rem;
                font-size: 0.98rem;
                color: #333;
            }
            @media (max-width: 600px) {
                .container { padding: 1.5rem 0.5rem; }
            }
        </style>
    </head>
    <body>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="w-full bg-white rounded-lg shadow-[0_4px_24px_rgba(0,0,0,0.07)] p-8 text-center">
                    <h1 class="text-3xl font-semibold mb-4">Welcome to the Products API</h1>
                    <p class="text-base text-[#555] mb-6">
                        This application provides a modern RESTful API for managing products and their prices.<br>
                        Use this API to create, update, list, and manage products and currencies efficiently.
                    </p>
                    <div class="bg-[#f3f4f6] rounded-md p-4 text-sm text-[#333]">
                        <strong>How to use:</strong><br>
                        Access the API endpoints via <code>/api</code> routes.<br>
                        Authentication is required for most actions.<br>
                        See the documentation or contact the developer for more details.
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
