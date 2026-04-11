<div class="min-h-screen bg-[#4455DD] flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-sm">
        <h1 class="text-2xl font-bold text-[#4455DD] mb-6 text-center">Login Admin</h1>
        <?php if (isset($_GET['error'])) { ?>
            <div class="bg-[#EE6666] text-white px-4 py-2 rounded-lg mb-4 text-sm">
                Username atau password salah.
            </div>
        <?php } ?>
        <form action="<?= BASE_PATH ?>/admin/authenticate" method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4455DD]">
            </div>
            <button type="submit"
                    class="w-full bg-[#4455DD] text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Login
            </button>
        </form>
    </div>
</div>