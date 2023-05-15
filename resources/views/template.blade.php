<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-900 text-white">
        <!-- Menú -->
        <nav class="bg-gray-800 text-white p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 lg:flex-row">
                    <span class="text-2xl font-semibold text-left"
                        >BrowserTravel</span
                    >
                    <div
                        id="menu-items"
                        class="hidden lg:flex lg:items-center lg:space-x-4"
                    >
                        <a href="#" class="flex items-center space-x-2">
                            <svg
                                class="w-6 h-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64"
                                />
                            </svg>
                            <span class="font-semibold">Mapa</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2">
                            <svg
                                class="w-6 h-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"
                                />
                            </svg>
                            <span class="font-semibold">Historial</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <button
                        class="lg:hidden focus:outline-none"
                        onclick="toggleMenu()"
                        aria-label="Toggle menu"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Área de trabajo -->
        <div class="container mx-auto px-4 py-8 lg:px-8 lg:py-12">
            <h1 class="text-2xl font-semibold mb-4">Área de trabajo</h1>
        </div>

        <script>
            function toggleMenu() {
                var menuItems = document.getElementById("menu-items");
                menuItems.classList.toggle("hidden");
            }
        </script>
    </body>
</html>