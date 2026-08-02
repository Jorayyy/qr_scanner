<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVSU Visitor - ID Verification Gateway</title>
    <!-- Tailwind CSS CDN for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center p-4" style="background-image: linear-gradient(rgba(17, 24, 39, 0.85), rgba(17, 24, 39, 0.85)), url('https://unsplash.com'); background-size: cover; background-position: center;">

    <div class="w-full max-w-lg bg-[#1e293b]/90 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700/50 p-8 text-white">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-700 rounded-full mx-auto flex items-center justify-center mb-3 shadow-lg">
                <span class="text-2xl font-bold text-white">E</span>
            </div>
            <h2 class="text-xl font-bold tracking-wide">Eastern Visayas State University</h2>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">Identity Verification Gateway</p>
        </div>

        <!-- Alert Notification Messages -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/50 border border-red-500 rounded-lg text-xs text-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Submission Core -->
        <form action="{{ route('visitor.verify.process') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Form Fields Wrapper -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required 
                           class="w-full bg-[#0f172a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 transition-colors" placeholder="John">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required 
                           class="w-full bg-[#0f172a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 transition-colors" placeholder="Doe">
                </div>
            </div>

            <!-- ID Type Dropdown Select System -->
            <div>
                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">Select ID Type</label>
                <select name="id_type" required 
                        class="w-full bg-[#0f172a] border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 transition-colors">
                    <option value="" disabled selected>-- Choose ID Type --</option>
                    <option value="national_id">Philippine National ID (PhilID)</option>
                    <option value="drivers_license">LTO Driver's License</option>
                    <option value="umpid">UMID / SSS Card</option>
                    <option value="passport">Philippine Passport</option>
                    <option value="evsu_id">EVSU School ID / University ID</option>
                </select>
            </div>

            <!-- Drag & Drop / File Input Node Container -->
            <div>
                <label class="block text-[10px] font-bold text-gray-400 mb-1 uppercase tracking-wider">Upload Valid ID Document Image</label>
                <div class="relative border-2 border-dashed border-gray-700 hover:border-red-500 rounded-xl bg-[#0f172a]/50 p-4 transition-colors text-center group cursor-pointer">
                    <input type="file" name="id_image" id="id_image" required accept="image/png, image/jpeg" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                           onchange="updatePreview(this)">
                    
                    <div id="upload-prompt" class="space-y-1">
                        <svg class="w-8 h-8 text-gray-500 group-hover:text-red-400 mx-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-gray-300 font-medium">Click or Drag ID image photo files here</p>
                        <p class="text-[10px] text-gray-500">Supports JPEG, PNG up to 5MB maximum file payload</p>
                    </div>

                    <!-- Dynamic Visual Feedback Image Preview -->
                    <img id="image-preview" src="#" alt="Uploaded Document Preview" class="hidden max-h-40 mx-auto rounded-lg shadow border border-gray-700 mt-1">
                </div>
            </div>

            <!-- Submit Button Trigger -->
            <button type="submit" class="w-full bg-white hover:bg-gray-100 text-gray-900 font-semibold text-xs tracking-wider uppercase py-3 rounded-lg shadow-md transition-all active:scale-[0.99] flex items-center justify-center space-x-2">
                <span>Scan & Verify Identity</span>
            </button>
        </form>

        <!-- Footer Redirection Links -->
        <div class="text-center mt-6 pt-4 border-t border-gray-800/60">
            <a href="/login" class="text-xs text-gray-400 hover:text-white transition-colors">← Existing User? Login Here</a>
        </div>
    </div>

    <!-- Frontend Interactive Preview Script -->
    <script>
        function updatePreview(input) {
            const preview = document.getElementById('image-preview');
            const prompt = document.getElementById('upload-prompt');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    prompt.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
