<!DOCTYPE html>
<html>
<div class="h-auto w-full my-10">
    <div class="w-full text-center text-4xl font-extrabold text-gray-800 tracking-wide mb-6">
        DISCOVER
    </div>
    <div class="w-full h-auto p-5">
        <div class="w-full h-auto p-6 rounded-lg bg-white shadow-lg">
            <div class="w-full mb-4 flex flex-col md:flex-row justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">POPULAR DESTINATION</h2>
                <button class="hidden md:block py-3 px-6 rounded-lg bg-[#D6AD60] text-white text-sm shadow-md hover:bg-[#8E7340] transition-transform duration-300 ease-in-out hover:scale-105">
                    More Popular Destinations
                </button>
            </div>
            <div id="scrollableDiv" class="w-full py-4 px-3 bg-white overflow-x-auto flex gap-4 border rounded-xl shadow-md scroll-smooth focus:scroll-auto custom-scrollbar scrollableDiv">
                <!-- Destination Cards -->
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-blue-400 to-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">1</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-green-400 to-green-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">2</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-red-400 to-red-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">3</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-yellow-400 to-yellow-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
            </div>
            <button class="py-3 my-5 w-full rounded-lg bg-[#D6AD60] text-white text-sm shadow-md md:hidden hover:bg-[#8E7340]">
                More Popular Destinations
            </button>
        </div>

        <div class="w-full h-full p-6 rounded-lg bg-white my-10 shadow-lg">
            <div class="w-full mb-4 flex flex-col md:flex-row justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">POPULAR COUNTRY</h2>
                <button class="hidden md:block py-3 px-6 rounded-lg bg-[#D6AD60] text-white text-sm shadow-md hover:bg-[#8E7340] transition-transform duration-300 ease-in-out hover:scale-105">
                    More Popular Countries
                </button>
            </div>
            <div id="scrollableDiv" class="w-full py-4 px-3 bg-white overflow-x-auto flex gap-4 border rounded-xl shadow-md scroll-smooth focus:scroll-auto custom-scrollbar scrollableDiv">
                <!-- Country Cards -->
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-purple-400 to-purple-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">1</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-pink-400 to-pink-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">2</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-teal-400 to-teal-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">3</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
                <div class="h-72 w-72 flex-shrink-0 rounded-xl bg-gradient-to-r from-orange-400 to-orange-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">4</div>
            </div>
            <button class="py-3 my-5 w-full rounded-lg bg-[#D6AD60] text-white text-sm shadow-md md:hidden hover:bg-[#8E7340]">
                More Popular Countries
            </button>
        </div>
    </div>
    <script>
        const scrollableDivs = document.querySelectorAll('.scrollableDiv');
        scrollableDivs.forEach(div => {
            div.addEventListener('wheel', (event) => {
                event.preventDefault();
                div.scrollLeft += event.deltaY;
            });
        });
    </script>
</div>

</html>