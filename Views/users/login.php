<div class="flex items-center justify-center min-h-screen bg-white">
    <form action="" method="POST" class="p-10 border-[1px] -mt-10 border-slate-200 rounded-md flex flex-col items-center space-y-3">
        <div class="py-8">
            <h2 class="my-3 text-3xl">Annonces</h2>
        </div>
        <div class="mb-3">

            <input class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="E-Mail or Phone number" />
        </div>
        <div class="flex flex-col space-y-1">
            <input class="p-3 border-[1px] border-slate-500 rounded-sm w-80" placeholder="Password" />
            <a href="#" class="font-bold text-[#0070ba] text-sm">Forgot password?</a>
        </div>
        <div class="flex flex-col w-full space-y-5">
            <button class="w-full bg-[#0070ba] rounded-3xl p-3 text-white font-bold transition duration-200 hover:bg-[#003087]">Log
                in</button>
            <div class="flex items-center justify-center border-t-[1px] border-t-slate-300 w-full relative">
                <div class="absolute px-5 -mt-1 bg-white font-bod">Or</div>
            </div>
            <a href="/users/register" class="w-full border-blue-900 hover:border-[#003087] hover:border-[2px] border-[1px] rounded-3xl p-3 text-[#0070ba] font-bold transition duration-200">Register</a>
        </div>
    </form>
</div>