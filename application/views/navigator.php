<!DOCTYPE html>
<html>
<div class="bg-[#004d4d] text-white border-b-2 rounded-b-lg fixed top-0 left-0 w-full z-50 shadow-md">
    <div class="md:container mx-auto">
        <nav class="max-md:h-16 h-28 font-semi-bold text-lg">
            <div class="h-full w-full grid grid-cols-12 max-md:grid-cols-2">
                <div class="col-span-2 max-md:col-span-1">
                    <div class="h-full w-full flex ">
                        <a href="<?php echo base_url(); ?>" class="my-auto lg:mx-auto flex  lg:items-center space-x-2">
                            <img src="<?php echo base_url('assets/img/LOGOpng.png'); ?>" alt="LiveAboardTrips Logo" class="h-30 lg:w-30 w-24 object-contain" />
                        </a>
                    </div>
                </div>
                <div class="col-span-10 max-md:col-span-1 flex flex-col justify-center h-full">
                    <div class="max-md:hidden md:flex space-x-6 p-2 justify-end">
                        <a href="<?php echo base_url(); ?>" class="hover:text-gray-300">Home</a>
                        <a href="<?php echo base_url('aboutus'); ?>" class="hover:text-gray-300">About</a>
                        <a href="<?php echo base_url('services'); ?>" class="hover:text-gray-300">Services</a>
                        <a href="<?php echo base_url('contactus'); ?>" class="hover:text-gray-300">Contact</a>
                        <a href="<?php echo base_url('admin/adminlogin'); ?>" class="text-white hover:text-gray-300">Admin Login</a>
                    </div>
                    <div class="md:hidden w-full">
                        <button id="menu-btn" class="focus:outline-none absolute top-0 right-0 p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>
                    <div id="mobile-menu" class="fixed top-0 right-0 w-64 h-full bg-blue-600 transform translate-x-full transition-transform duration-500 ease-in-out md:hidden flex flex-col space-y-4 p-4 backdrop-blur-sm z-10">
                        <a href="<?php echo base_url(); ?>" class="text-white hover:text-gray-300">Home</a>
                        <a href="<?php echo base_url('aboutus'); ?>" class="text-white hover:text-gray-300">About</a>
                        <a href="<?php echo base_url('services'); ?>" class="text-white hover:text-gray-300">Services</a>
                        <a href="<?php echo base_url('contactus'); ?>" class="text-white hover:text-gray-300">Contact</a>
                        <a href="<?php echo base_url('admin/adminlogin'); ?>" class="text-white hover:text-gray-300">Admin Login</a>
                    </div>
                </div>
            </div>
        </nav>
        <script>
            const menuBtn = document.getElementById('menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            // Toggle mobile menu visibility
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('translate-x-full');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', (event) => {
                const isClickInside = mobileMenu.contains(event.target) || menuBtn.contains(event.target);
                if (!isClickInside && !mobileMenu.classList.contains('translate-x-full')) {
                    mobileMenu.classList.add('translate-x-full');
                }
            });
        </script>
    </div>
</div>

<div class="max-md:h-16 h-28">
</div>

</html>