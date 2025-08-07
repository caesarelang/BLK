<div class="flex flex-col h-screen bg-gray-100">
    <!-- Top App Bar -->
    <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4">
        <h1 class="text-lg font-semibold text-gray-800">Learning Dashboard</h1>
        <!-- You can add more elements here, like a user dropdown or notifications -->
    </header>

    <!-- Main Content Area -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white overflow-y-auto">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">Navigation</h2>
                <!-- Add your navigation links here -->
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Dashboard</a> --}}
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Courses</a> --}}
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Progress</a> --}}
            </div>
        </aside>

        <!-- Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <!-- Existing content goes here -->
            <h1 class="text-2xl font-bold mb-4">Learning Dashboard</h1>
            <p class="text-gray-700">This is a simple learning dashboard.</p>
        </main>
    </div>
</div>